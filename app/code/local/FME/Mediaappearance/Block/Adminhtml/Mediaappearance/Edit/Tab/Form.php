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
 * Class FME_Mediaappearance_Block_Adminhtml_Mediaappearance_Edit_Tab_Form
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Block_Adminhtml_Mediaappearance_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
      
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('mediaappearance_form', array('legend'=>Mage::helper('mediaappearance')->__('Media information')));
        
        $object = Mage::getModel('mediaappearance/mediaappearance')->load($this->getRequest()->getParam('id'));
        $videoURL   = false;
      
        $fieldset->addField(
            'title', 'text', array(
            'label'     => Mage::helper('mediaappearance')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
            )
        );
      
        $field =     $fieldset->addField(
            'video', 'hidden', array(
            'label'     => Mage::helper('mediaappearance')->__(''),
            'name'      => 'video',
            'id'      => 'video',
          
            )
        );
      
        $field->setRenderer($this->getLayout()->createBlock('mediaappearance/adminhtml_mediaappearance_edit_renderer_video'));
      
        $fieldset->addField(
            'my_file', 'hidden', array(
            'name'        => 'my_file',
            )
        );
        $fieldset->addField(
            'my_thumb', 'hidden', array(
            'name'        => 'my_thumb',
            )
        );

      
        $fieldset->addField(
            'product_ids', 'hidden', array(
            'label'     => Mage::helper('mediaappearance')->__(''),
            'name'      => 'product_ids',
            'id'      => 'product_ids',
          
            )
        );
      
        $fieldset->addField(
            'featured_video', 'select', array(
            'label'     => Mage::helper('mediaappearance')->__('Featured video ?'),
            'name'      => 'featured_video',
            'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('mediaappearance')->__('Yes'),
              ),

              array(
                  'value'     => 0,
                  'label'     => Mage::helper('mediaappearance')->__('No'),
              ),
            ),
            )
        );
      
      
        
        $fieldset->addField(
            'stores', 'multiselect', array(
            'name'      => 'stores[]',
            'label'     => Mage::helper('mediaappearance')->__('Store View'),
            'title'     => Mage::helper('mediaappearance')->__('Store View'),
            'required'  => true,
            'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true)
            )
        );

        $fieldset->addField(
            'desp', 'textarea', array(
            'label'     => Mage::helper('mediaappearance')->__('Description'),
            'class'     => 'required-entry validate-length minimum-length-10 maximum-length-160',
            'required'  => true,
            'name'      => 'desp',
            'after_element_html' => '<small id="price"><br>Min Charcters : 10, Max Charcters: 160</small>',
      
            )
        );
        
        $fieldset->addField(
            'status', 'select', array(
            'label'     => Mage::helper('mediaappearance')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                  'value'     => 0,
                  'label'     => Mage::helper('mediaappearance')->__('Disabled'),
              ),
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('mediaappearance')->__('Enabled'),
              ),

              
            ),
            )
        );
     
      
     
        if (Mage::getSingleton('adminhtml/session')->getMediaappearanceData() ) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getMediaappearanceData());
            Mage::getSingleton('adminhtml/session')->setMediaappearanceData(null);
        } elseif (Mage::registry('mediaappearance_data') ) {
            $form->setValues(Mage::registry('mediaappearance_data')->getData());
        }
        return parent::_prepareForm();
    }
}
