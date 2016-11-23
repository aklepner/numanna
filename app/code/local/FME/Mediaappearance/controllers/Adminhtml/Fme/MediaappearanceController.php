<?php
/**
 * Media Gallery & Product Videos extension
 *
 * NOTICE OF LICENSE
 *
 * PHP version 5
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category  FME
 * @package   Mediaappearance
 * @author    Altaf Ahmed <support@fmeextension.com>
 * @copyright 2016 FME Extensions (https://www.fmeextensions.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link      https://www.fmeextensions.com
 */

/**
 * Class FME_Mediaappearance_Adminhtml_Fme_MediaappearanceController
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Adminhtml_Fme_MediaappearanceController extends Mage_Adminhtml_Controller_action
{

    protected function _initAction() 
    {
        $this->loadLayout()
            ->_setActiveMenu('mediaappearance/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Media Manager'), Mage::helper('adminhtml')->__('Media Manager'));
        
        return $this;
    }   
 
    public function indexAction() 
    {
        $this->_initAction()
            ->renderLayout();
    }
    
    public function categoriesAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('mediaappearance/adminhtml_mediaappearance_edit_tab_categories')->toHtml()
        );   
    }
    
    public function categoriesJsonAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('mediaappearance/adminhtml_mediaappearance_edit_tab_categories')
                ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }

    public function editAction() 
    {
                
        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('mediaappearance/mediaappearance')->load($id);
        $Storemodel = Mage::getModel('mediaappearance/mediastore')->getCollection();
        $Storemodel->addFieldToFilter('mediaappearance_id',$id);
        $stores = $Storemodel->getData();
        foreach ($stores as $value) {
            $store[] = $value['store_id'];
        }
        
        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            
            $model['stores'] = $store; 
            Mage::register('mediaappearance_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('mediaappearance/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Media Manager'), Mage::helper('adminhtml')->__('Media Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Media News'), Mage::helper('adminhtml')->__('Media News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('mediaappearance/adminhtml_mediaappearance_edit'))
                ->_addLeft($this->getLayout()->createBlock('mediaappearance/adminhtml_mediaappearance_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mediaappearance')->__('Media does not exist'));
            $this->_redirect('*/*/');
        }
    }
 
    public function newAction() 
    {
        $this->_forward('edit');
    }
 
    public function saveAction() 
    {
        
        if ($data = $this->getRequest()->getPost()) {

            if ($data['mediatype']==1) {
                if (array_key_exists('filenotemty', $data)) {
                    //echo "Key"; exit();
                    if ($data['filenotemty']!=1) {
                        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mediaappearance')->__('Upload A Video File'));
                        Mage::getSingleton('adminhtml/session')->setFormData($data);
                        $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                        return;
                    }
                } 
                else
                {
                    if (empty($_FILES['my_file_uploader']['name'])) {
                        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mediaappearance')->__('Upload A Video File'));
                        Mage::getSingleton('adminhtml/session')->setFormData($data);
                        $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                        return;
                    }
                }  
            }
            elseif ($data['mediatype']==2) {
                if (empty($data['videourl'])) {
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mediaappearance')->__('Add A Video Url'));
                    Mage::getSingleton('adminhtml/session')->setFormData($data);
                    $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                    return;
                } 
            }
            
            
            //Upload Video and Thumbnail  
            $files = $this->uploadFiles($_FILES); 
            if ($files && is_array($files) ) {
                for( $f=0; $f<count($files); $f++ ){
                    if ($files[$f] ) {
                        $fieldname = str_replace('_uploader', '', $files[$f]['fieldname']);
                        if (array_key_exists($fieldname, $data) ) {
                            if ($fieldname == "my_file") {
                                $data['filename'] = $files[$f]['url'];
                            }
                            if ($fieldname == "my_thumb") {
                                $data['filethumb'] = $files[$f]['url'];
                            }
                        }     
                    }     
                }   
            } 

            //Save Products ID"s that is realted to this video!
           
            //Set Related Products
            $links = $this->getRequest()->getPost('links');
            if (isset($links['related'])) {
                $productIds = Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['related']);
                $productString = "";
                foreach ($productIds as $_product) {
                    $productString .= $_product.",";
                }
                $_POST['productIds'] = $productString;
                $data['product_ids'] = $productString; 
            }
          
            //Save related category id's Separated By Commas
            $categoryidsString  = trim($_POST['category_ids'], ',');
            $catIds = explode(",", $categoryidsString);     
            $result = array_unique($catIds);
            $comma_separated = implode(",", $result);
            
            $data['category_ids'] = $comma_separated;
                        
            $model = Mage::getModel('mediaappearance/mediaappearance');   

             
            $model->setData($data)
                ->setId($this->getRequest()->getParam('id'));
            
            try {
                if ($model->getCreatedTime == null || $model->getUpdateTime() == null) {
                    $model->setCreatedTime(now())
                        ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }   
                
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('mediaappearance')->__('Media was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mediaappearance')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }
 
    public function deleteAction() 
    {
        if ($this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('mediaappearance/mediaappearance');
                 
                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();
                     
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction() 
    {
        $mediaappearanceIds = $this->getRequest()->getParam('mediaappearance');
        if (!is_array($mediaappearanceIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($mediaappearanceIds as $mediaappearanceId) {
                    $mediaappearance = Mage::getModel('mediaappearance/mediaappearance')->load($mediaappearanceId);
                    $mediaappearance->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($mediaappearanceIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    public function massStatusAction()
    {
        $mediaappearanceIds = $this->getRequest()->getParam('mediaappearance');
        if (!is_array($mediaappearanceIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Media(s)'));
        } else {
            try {
                foreach ($mediaappearanceIds as $mediaappearanceId) {
                    $mediaappearance = Mage::getSingleton('mediaappearance/mediaappearance')
                        ->load($mediaappearanceId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($mediaappearanceIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'mediaappearance.csv';
        $content    = $this->getLayout()->createBlock('mediaappearance/adminhtml_mediaappearance_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'mediaappearance.xml';
        $content    = $this->getLayout()->createBlock('mediaappearance/adminhtml_mediaappearance_grid')
            ->getXml();

        $this->_prepareDownloadResponse($fileName, $content);
    }

   
    
    public function toOptionArray($isMultiselect) 
    {
        if (!$this->_options) {
            $this->_options = Mage::getResourceModel('core/language_collection')->loadData()->toOptionArray();
        }
        $options = $this->_options;
        if (!$isMultiselect) {
            array_unshift($options, array('value'=>'', 'label'=>''));
        }
        return $options;
    }

    public function productsAction()
    {
        $this->_initMediagalleryProducts();
        $this->loadLayout();
        $this->getLayout()->getBlock('mediaappearance.edit.tab.products')
            ->setMediagalleryProductsRelated($this->getRequest()->getPost('products_related', null));
        $this->renderLayout();
    }

    protected function _initMediagalleryProducts() 
    {
        $mediagallery = Mage::getModel('mediaappearance/mediaappearance');
        $mediagalleryId  = (int) $this->getRequest()->getParam('id');
        if ($mediagalleryId) {
            $mediagallery->load($mediagalleryId);
        }
        Mage::register('current_mediagallery_products', $mediagallery);
        return $mediagallery;
        
    }

    
    public function productAction() 
    {
        $this->_initProduct();
        $this->loadLayout();
        $data=$this->getRequest()->getPost();
        $this->renderLayout();
    }

     /**
     * Get related products grid
     */
    public function productsGridAction()
    {
        $this->_initMediagalleryProducts();
        //Push Existing Values in Array
        $productsarray = array();
        $mediagalleryId  = (int) $this->getRequest()->getParam('id');
        foreach (Mage::registry('current_mediagallery_products')->getMediagalleryRelatedProducts($mediagalleryId) as $products) {
            $productsarray = $products["product_id"];
        }
        array_push($_POST["products_related"], $productsarray);
        Mage::registry('current_mediagallery_products')->setMediagalleryProductsRelated($productsarray);
        
        $this->loadLayout();
        $this->getLayout()->getBlock('mediaappearance.edit.tab.products')
            ->setMediagalleryProductsRelated($this->getRequest()->getPost('products_related', null));
        $this->renderLayout();
    }

    
    public function gridAction() 
    {
     
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('mediaappearance/adminhtml_mediaappearance_edit_tab_product')->toHtml()
        );
    
    }
    
    public function gridOnlyAction()
    {
        $this->_initProduct();
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('adminhtml/mediaappearance_edit_tab_product')
                ->toHtml()
        );
    }
    
    protected function uploadFiles( $files )
    {
        if (!empty($files) && is_array($files) ) {
            $result = array();
            foreach ( $files as $file=>$info ) {
                $result[] = $this->uploadFile($file);
            }
            return $result;
        }
    }
    
    protected function uploadFile( $file_name )
    {

        if (!empty($_FILES[$file_name]['name']) ) {
            $result = array();
            $dynamicScmsURL = 'mediaappearance' . DS . 'files';
            $baseScmsMediaURL = Mage::getBaseUrl('media') . DS . 'mediaappearance' . DS . 'files';
            $baseScmsMediaPath = Mage::getBaseDir('media') . DS .  'mediaappearance' . DS . 'files';
            
            $uploader = new Varien_File_Uploader($file_name);
            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png','flv','mp4','mp3','avi','MP4','m4v','swf'));
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $result = $uploader->save($baseScmsMediaPath);
       
            $file = str_replace(DS, '/', $result['file']);
            if (substr($baseScmsMediaURL, strlen($baseScmsMediaURL)-1)=='/' && substr($file, 0, 1)=='/' ) {
                $file = substr($file, 1);
            }    
                        
            $ScmsMediaUrl = $dynamicScmsURL.$file;
            
            $result['fieldname'] = $file_name;
            $result['url'] = $ScmsMediaUrl;
            $result['file'] = $result['file'];
            return $result;
        } else {
            return false;
        }
    } 

    protected function _isAllowed()
    {
        return true;
    }
}
