<?php

class Transform_Slideshow_Block_Adminhtml_Slides_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

    /**
     * Init class
     *
     */
    public function __construct() {
        parent::__construct();

        $this->setId('slideshowSlideForm');
//        $this->setTitle(Mage::helper('checkout')->__('Terms and Conditions Information'));
    }

    /**
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm() {
        $model = Mage::registry('transform_slides');
        $model->setCurrphoto($model->getPhoto());
        $form = new Varien_Data_Form(array(
                    'id' => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('slideshow')->__('Slides'),
            'class' => 'fieldset-wide',
                ));

        if ($model->getId()) {
            $fieldset->addField('slide_id', 'hidden', array(
                'name' => 'slide_id',
            ));
            $fieldset->addField('currphoto', 'hidden', array(
                'name' => 'currphoto',
            ));
        }
        $fieldset->addField('name', 'text', array(
            'name' => 'name',
            'label' => Mage::helper('slideshow')->__('Slide Name'),
            'title' => Mage::helper('slideshow')->__('Slide Name'),
            'required' => true,
        ));
        
            $fieldset->addField('position', 'text', array(
                'name'      => 'position',
                'label'     => Mage::helper('slideshow')->__('Position'),
                'title'     => Mage::helper('slideshow')->__('Position'),
                'required'  => false,
            ));
            
/*
            $fieldset->addField('store_id', 'select', array(
                'name'      => 'store_id',
                'label'     => Mage::helper('cms')->__('Store View'),
                'title'     => Mage::helper('cms')->__('Store View'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
//            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
//            $field->setRenderer($renderer);
*/

        $fieldset->addField('is_active', 'select', array(
            'name' => 'is_active',
            'label' => Mage::helper('slideshow')->__('Status'),
            'title' => Mage::helper('slideshow')->__('Status'),
            'required' => true,
            'options' => array(
                '1' => Mage::helper('slideshow')->__('Enabled'),
                '0' => Mage::helper('slideshow')->__('Disabled'),
            ),
        ));

        $fieldset->addField('slide_type', 'select', array(
            'name' => 'slide_type',
            'label' => Mage::helper('slideshow')->__('Slide Type'),
            'title' => Mage::helper('slideshow')->__('Slide Type'),
            'required' => true,
            'options' => array(
                '0' => Mage::helper('slideshow')->__('Leftward'),
                '1' => Mage::helper('slideshow')->__('Centered'),
                '2' => Mage::helper('slideshow')->__('Centered with Image'),
                '3' => Mage::helper('slideshow')->__('Centered with Video'),
            ),
        ));

        $fieldset->addField('content', 'editor', array(
            'name' => 'content',
            'label' => Mage::helper('slideshow')->__('Content'),
            'title' => Mage::helper('slideshow')->__('Content'),
            'style' => 'height:12em;',
            'wysiwyg' => true,
            'required' => true,
        ));
        
  /*      $fieldset->addField('content', 'editor', array(
            'name' => 'content',
            'label' => Mage::helper('slideshow')->__('Content'),
            'title' => Mage::helper('slideshow')->__('Content'),
            'style' => 'height:12em;',
            'wysiwyg' => true,
            'required' => true,
        ));
*/
        $fieldset->addField('photo', 'image', array(
            'label' => Mage::helper('slideshow')->__('Background image'),
            'required' => false,
            'name' => 'photo',
        ));
        
        $fieldset->addField('photo1', 'image', array(
            'label' => Mage::helper('slideshow')->__('Center image'),
            'required' => false,
            'name' => 'photo1',
        ));
        
        $fieldset->addField('photo2', 'image', array(
            'label' => Mage::helper('slideshow')->__('Seal image'),
            'required' => false,
            'name' => 'photo2',
        ));
        
        $fieldset->addField('video_link', 'text', array(
            'name' => 'video_link',
            'label' => Mage::helper('slideshow')->__('Video Link'),
            'title' => Mage::helper('slideshow')->__('Video Link'),
            'required' => false,
        ));
        
        $fieldset->addField('link', 'text', array(
            'name' => 'link',
            'label' => Mage::helper('slideshow')->__('First Button Link'),
            'title' => Mage::helper('slideshow')->__('First Button Link'),
            'required' => false,
        ));

        $fieldset->addField('link_title', 'text', array(
            'name' => 'link_title',
            'label' => Mage::helper('slideshow')->__('First Button Title'),
            'title' => Mage::helper('slideshow')->__('First Button Title'),
            'required' => false,
        ));

$fieldset->addField('link1', 'text', array(
            'name' => 'link1',
            'label' => Mage::helper('slideshow')->__('Second Button Link'),
            'title' => Mage::helper('slideshow')->__('Second Button Link'),
            'required' => false,
        ));

        $fieldset->addField('link1_title', 'text', array(
            'name' => 'link1_title',
            'label' => Mage::helper('slideshow')->__('Second Button Title'),
            'title' => Mage::helper('slideshow')->__('Second Button Title'),
            'required' => false,
        ));
 
        
        /*
        $fieldset->addField('show_homepage', 'checkbox', array(
            'label' => Mage::helper('slideshow')->__('Show on home page'),
            'name' => 'show_homepage',
            'onclick' => 'this.value = this.checked ? 1 : 0;'
        ))
        ->setIsChecked($model->getShowHomepage());

        $fieldset->addField('show_business', 'checkbox', array(
            'label' => Mage::helper('slideshow')->__('Show on Walla Business page'),
            'name' => 'show_business',
            'onclick' => 'this.value = this.checked ? 1 : 0;'
        ))
        ->setIsChecked($model->getShowBusiness());
        
        $fieldset->addField('show_retail', 'checkbox', array(
            'label' => Mage::helper('slideshow')->__('Show on Walla Retail page'),
            'name' => 'show_retail',
            'onclick' => 'this.value = this.checked ? 1 : 0;'
        ))
        ->setIsChecked($model->getShowRetail());
        
        $fieldset->addField('show_home', 'checkbox', array(
            'label' => Mage::helper('slideshow')->__('Show on Walla Home page'),
            'name' => 'show_home',
            'onclick' => 'this.value = this.checked ? 1 : 0;'
        ))
        ->setIsChecked($model->getShowHome());
  */      
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
