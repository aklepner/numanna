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
 * Class FME_Mediaappearance_Block_Adminhtml_Videoblocks_Edit_Tab_Form
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Block_Adminhtml_Videoblocks_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{ 
  	protected function _prepareForm()
  	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('videoblocks_form', array('legend'=>Mage::helper('mediaappearance')->__('Media Block information')));
		
		$fieldset->addField('block_title', 'text', array(
		  'label'     => Mage::helper('mediaappearance')->__('Title'),
		  'class'     => 'required-entry',
		  'required'  => true,
		  'name'      => 'block_title',
		));
		
		$fieldset->addField('block_identifier', 'text', array(
			'name'      => 'block_identifier',
			'label'     => Mage::helper('mediaappearance')->__('Identifier'),
			'title'     => Mage::helper('mediaappearance')->__('Identifier'),
			'class'     => 'validate-identifier',
			//'after_element_html' => '<p class="nm"><small>' . Mage::helper('faqs')->__('(eg: domain.com/faqs/identifier)') . '</small></p>',
		));
		
		$fieldset->addField('block_status', 'select', array(
		  'label'     => Mage::helper('mediaappearance')->__('Status'),
		  'name'      => 'block_status',
		  'values'    => array(
			  array(
				  'value'     => 1,
				  'label'     => Mage::helper('mediaappearance')->__('Enabled'),
			  ),
		
			  array(
				  'value'     => 2,
				  'label'     => Mage::helper('mediaappearance')->__('Disabled'),
			  ),
		  ),
		));
	
		$fieldset->addField('block_area', 'select', array(
		  'label'     => Mage::helper('mediaappearance')->__('Block Display Area'),
		  'name'      => 'block_area',
		  'values'    => array(
			  array(
				  'value'     => 'side',
				  'label'     => Mage::helper('mediaappearance')->__('Left / Right'),
			  ),
		
			  array(
				  'value'     => 'main',
				  'label'     => Mage::helper('mediaappearance')->__('Main'),
			  ),
		  ),
		));

	  	$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
             array('tab_id' => 'form_section')
        );
        $wysiwygConfig["files_browser_window_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index');
        $wysiwygConfig["directives_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive');
        $wysiwygConfig["directives_url_quoted"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive');
        $wysiwygConfig["widget_window_url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/widget/index');
		$wysiwygConfig["files_browser_window_width"] = (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_width');
		$wysiwygConfig["files_browser_window_height"] = (int) Mage::getConfig()->getNode('adminhtml/cms/browser/window_height');
        $plugins = $wysiwygConfig->getData("plugins");
        $plugins[0]["options"]["url"] = Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/system_variable/wysiwygPlugin');
        $plugins[0]["options"]["onclick"]["subject"] = "MagentovariablePlugin.loadChooser('".Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/system_variable/wysiwygPlugin')."', '{{html_id}}');";
        $plugins = $wysiwygConfig->setData("plugins",$plugins);
	 
        $contentField = $fieldset->addField('block_content', 'editor', array(
          	'name'      => 'block_content',
          	'label'     => Mage::helper('mediaappearance')->__('Content'),
          	'title'     => Mage::helper('mediaappearance')->__('Content'),
          	'style'     => 'height:20em; width:50em;',
	  		'required'  => true,
          	'config'    => $wysiwygConfig
     	));
      
	    // Setting custom renderer for content field to remove label column
	    $renderer = $this->getLayout()->createBlock('adminhtml/widget_form_renderer_fieldset_element')
	                    ->setTemplate('cms/page/edit/form/renderer/content.phtml');
	    $contentField->setRenderer($renderer);
	      
	    if ( Mage::getSingleton('adminhtml/session')->getVideoblocksData() ) {
	          $form->setValues(Mage::getSingleton('adminhtml/session')->getVideoblocksData());
	          Mage::getSingleton('adminhtml/session')->setVideoblocksData(null);
	    } elseif ( Mage::registry('media_block_data') ) {
	          $form->setValues(Mage::registry('media_block_data')->getData());
	    }

	    return parent::_prepareForm();
  	}
}