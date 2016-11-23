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
 * Class FME_Mediaappearance_Adminhtml_Fme_VideoblocksController
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Adminhtml_Fme_VideoblocksController extends Mage_Adminhtml_Controller_action
{
  
    protected function _initAction() 
    {
        $this->loadLayout()
            ->_setActiveMenu('mediaappearance/videoblocks')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Manage Media Blocks'), Mage::helper('adminhtml')->__('Manage Media Blocks'));
        
        return $this;
    }   
 
    public function indexAction() 
    {
        $this->_initAction();        
        $this->renderLayout();
    }
    
    protected function _initMediaBlock() 
    {
        
        $blockId  = (int) $this->getRequest()->getParam('id');
        if (!$blockId) {
            return false;
        }
        
        $block = Mage::getModel('mediaappearance/videoblocks');
        if ($blockId) {
            $block->load($blockId);
        }

        Mage::register('current_block', $block);
        
        return $block;
    }
    
    /**
     * Create serializer block for a grid
     *
     * @param  string                           $inputName
     * @param  Mage_Adminhtml_Block_Widget_Grid $gridBlock
     * @param  array                            $productsArray
     * @return Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Ajax_Serializer
     */
    protected function _createSerializerBlock($inputName, Mage_Adminhtml_Block_Widget_Grid $gridBlock, $productsArray)
    {
        return $this->getLayout()->createBlock('adminhtml/videoblocks_edit_tab_ajax_serializer')
            ->setGridBlock($gridBlock)
            ->setProducts($productsArray)
            ->setInputElementName($inputName);
    }
 
    
    public function editAction() 
    {
        $this->loadLayout();
        $this->_setActiveMenu('mediaappearance/videoblocks');
        $this->_addBreadcrumb(Mage::helper('mediaappearance')->__('Manage Media Blocks'), Mage::helper('mediaappearance')->__('Manage Media Blocks'));
        
        $id = $this->getRequest()->getParam('id');
        if ($id > 0) {
            
            $model  = Mage::getModel('mediaappearance/videoblocks')->load($id);
            Mage::register('media_block_data', $model);
        }
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->_addContent($this->getLayout()->createBlock('mediaappearance/adminhtml_videoblocks_edit'))
            ->_addLeft($this->getLayout()->createBlock('mediaappearance/adminhtml_videoblocks_edit_tabs'));
        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        $this->renderLayout();
    }
 
    public function newAction() 
    {
        $this->_forward('edit');
    }
 
    public function saveAction() 
    {
        
        $id=$this->getRequest()->getParam('id');
        $data = $this->getRequest()->getPost();

        if ($data['block_identifier']) {
            $data['block_identifier'] = Mage::helper('mediaappearance')->nameToUrlKey($data['block_identifier']);
        } else {
            $data['block_identifier'] = Mage::helper('mediaappearance')->nameToUrlKey($data['block_title']);
        }
        
        //Save Related Media
        if (isset($_POST['links'])) {
            $links         = $_POST['links'];
            $mediaIds     = Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['relatedmedia']);
            //Explode Array into Comma Seprated 
            $relatedmedia = implode(",", $mediaIds);
            $data['related_media'] = $relatedmedia; 
        }
    
        try {
            $model = Mage::getModel('mediaappearance/videoblocks');        
            $model->setData($data)
                ->setId($this->getRequest()->getParam('id'));

            if ($model->getCreatedTime == null || $model->getUpdateTime() == null) {
                $model->setCreatedTime(now())
                    ->setUpdateTime(now());
            } else {
                $model->setUpdateTime(now());
            }    
            
            $model->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('mediaappearance')->__('Media Block was successfully saved'));
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
            $this->_redirect('*/*/', array('id' => $id));
        }
    }
    
    /**
     * Get related products grid and serializer block
     */
    public function relatedmediaAction()
    {
        $this->_initMediaBlock();
        $this->loadLayout();
        $this->getLayout()->getBlock('videoblocks.edit.tab.relatedmedia')
            ->setMediaRelated($this->getRequest()->getPost('related_media', null));
        $this->renderLayout();
    }

    
    public function deleteAction() 
    {
        if ($this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('mediaappearance/videoblocks');
                 
                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();
                     
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Media Block was successfully deleted'));
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
        $mediablockid = $this->getRequest()->getParam('mediaappearance');
        if (!is_array($mediablockid)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Media Block(s)'));
        } else {
            try {
                foreach ($mediablockid as $blockid) {
                    $media = Mage::getModel('mediaappearance/videoblocks')->load($blockid);
                    $media->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($mediablockid)
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
        $mediablockid = $this->getRequest()->getParam('mediaappearance');
        if (!is_array($mediablockid)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Media Block(s)'));
        } else {
            try {
                foreach ($mediablockid as $blockid) {
                    $media = Mage::getSingleton('mediaappearance/videoblocks')
                        ->load($blockid)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($mediablockid))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    
    public function exportCsvAction()
    {
        $fileName   = 'videoblocks.csv';
        $content    = $this->getLayout()->createBlock('mediaappearance/adminhtml_videoblocks_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'videoblocks.xml';
        $content    = $this->getLayout()->createBlock('mediaappearance/adminhtml_videoblocks_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
    
    public function productAction() 
    {
        
        $this->_initProduct();
        $this->loadLayout();
        $data=$this->getRequest()->getPost();
        $this->renderLayout();
    }
    
    public function productGridAction() 
    {
        
        echo 'Function ===> productgridaction';
        $this->_initProduct();
        $this->loadLayout();
        $data=$this->getRequest()->getPost();
        $this->renderLayout();
    }
    
    public function gridAction() 
    {
     
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('mediaappearance/adminhtml_videoblocks_edit_tab_product')->toHtml()
        );
    
    }
    
    public function gridOnlyAction()
    {
        echo 'Function ===> GridOnlyAction';
        $this->_initProduct();
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('adminhtml/videoblocks_edit_tab_product')
                ->toHtml()
        );
    }

    protected function _isAllowed()
    {
        return true;
    }
}
