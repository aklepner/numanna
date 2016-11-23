<?php

class Transform_Slideshow_Adminhtml_SlidesController extends Mage_Adminhtml_Controller_Action {

    public function indexAction() {
//        $this->_title($this->__('Sales'))->_title($this->__('Terms and Conditions'));
        $this->_initAction()
                ->_addContent($this->getLayout()->createBlock('slideshow/adminhtml_slides'))
                ->renderLayout();
        return $this;
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction() {
//        $this->_title($this->__('Sales'))->_title($this->__('Terms and Conditions'));

        $id = $this->getRequest()->getParam('id');
        $slideModel = Mage::getModel('slideshow/slide');
        $hlp = Mage::helper('slideshow');
        if ($id) {
            $slideModel->load($id);
            if (!$slideModel->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($hlp->__('This slide no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

//        $this->_title($agreementModel->getId() ? $agreementModel->getName() : $this->__('New Condition'));

        $data = Mage::getSingleton('adminhtml/session')->getSlideshowData(true);
        if (!empty($data)) {
            $slideModel->setData($data);
        }

        Mage::register('transform_slides', $slideModel);

        $this->_initAction()
                ->_addBreadcrumb($id ? $hlp->__('Edit Slide') : $hlp->__('New Slide'), $id ? $hlp->__('Edit Slide') : $hlp->__('New Slide'))
                ->_addContent($this->getLayout()->createBlock('slideshow/adminhtml_slides_edit')->setData('action', $this->getUrl('*/*/save')))
                ->renderLayout();
    }

    public function saveAction() {
        $fields_images = $this->getImageFields();
        if ($postData = $this->getRequest()->getPost()) {
            $model = Mage::getSingleton('slideshow/slide');
            $model->setData($postData);
/*
            foreach(array('show_homepage', 'show_home', 'show_retail', 'show_business') as $v){
              if(empty($postData[$v])) $model->setData($v,'0');
            }
*/
//Upload images
            foreach ($fields_images as $f) {
                if(isset($postData[$f]['delete']) && $postData[$f]['delete'] == 1){
                    $this->deleteslide($postData['currphoto'.$f]);
                }
                if (isset($_FILES[$f]['name']) && (file_exists($_FILES[$f]['tmp_name']))) {
                    try {
                        $this->deleteslide($postData['currphoto'.$f]);
                        $uploader = new Varien_File_Uploader($f);
                        $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                        $uploader->setAllowRenameFiles(false);
                        // setAllowRenameFiles(true) -> move your file in a folder the magento way
                        // setAllowRenameFiles(true) -> move your file directly in the $path folder
                        $uploader->setFilesDispersion(false);
                        $path = Mage::getBaseDir('media') . DS; //. 'fpslides' . DS;
                        $uploader->save($path, $_FILES[$f]['name']);
                        $model->setData($f, $_FILES[$f]['name']);
                    } catch (Exception $e) {
                        
                    }
                } else {
                    if (isset($postData[$f]['delete']) && $postData[$f]['delete'] == 1)
                        $model->setData($f, '');
                    else
                        $model->setData($f, null);
                }
            }
//End Upload image
            try {
                $model->save();

//                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('checkout')->__('The condition has been saved.'));
                $this->_redirect('*/*/');

                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('slideshow')->__('An error occurred while saving this slide.'));
            }

            Mage::getSingleton('adminhtml/session')->setSlideshowData($postData);
            $this->_redirectReferer();
        }
    }

    public function deleteAction() {
        $id = (int) $this->getRequest()->getParam('id');
        $model = Mage::getSingleton('slideshow/slide')
                ->load($id);
        if (!$model->getId()) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('checkout')->__('This slide no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }

        try {
            $fields_images = $this->getImageFields();
            foreach ($fields_images as $f){
                $this->deleteslide($model->getData($f));
            }
            $model->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('checkout')->__('The slide has been deleted'));
            $this->_redirect('*/*/');

            return;
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('checkout')->__('An error occurred while deleting this slide.'));
        }

        $this->_redirectReferer();
    }

    public function deleteslide($slide){
      if(file_exists(Mage::getBaseDir('media') . DS . $slide) && is_file(Mage::getBaseDir('media') . DS . $slide))
        unlink(Mage::getBaseDir('media') . DS . $slide);
    }

    protected function _initAction() {
        $this->loadLayout()
//            ->_setActiveMenu('sales/checkoutagreement')
//            ->_addBreadcrumb(Mage::helper('checkout')->__('Sales'), Mage::helper('checkout')->__('Sales'))
//            ->_addBreadcrumb(Mage::helper('checkout')->__('Checkout Conditions'), Mage::helper('checkout')->__('Checkout Terms and Conditions'))
        ;
        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        return $this;
    }

    public function getImageFields(){
        return array('photo','photo1','photo2');
    }
}
