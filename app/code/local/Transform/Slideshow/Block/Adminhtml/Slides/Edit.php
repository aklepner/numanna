<?php

class Transform_Slideshow_Block_Adminhtml_Slides_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     *
     */
    public function __construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_slides';
        $this->_blockGroup = 'slideshow';

        parent::__construct();

//        $this->_updateButton('save', 'label', Mage::helper('checkout')->__('Save Condition'));
//        $this->_updateButton('delete', 'label', Mage::helper('checkout')->__('Delete Condition'));
    }

    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {
//        if (Mage::registry('checkout_agreement')->getId()) {
//            return Mage::helper('checkout')->__('Edit Terms and Conditions');
//        }
//       else {
//            return Mage::helper('checkout')->__('New Condition');
//        }
    }
}
