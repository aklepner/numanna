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
 * Class FME_Mediaappearance_Block_Adminhtml_Mediaappearance_Edit
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Block_Adminhtml_Mediaappearance_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'mediaappearance';
        $this->_controller = 'adminhtml_mediaappearance';
        
        $this->_updateButton('save', 'label', Mage::helper('mediaappearance')->__('Save Media'));
        $this->_updateButton('delete', 'label', Mage::helper('mediaappearance')->__('Delete Media'));
        
        $this->_addButton(
            'saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
            ), -100
        );

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('mediaappearance_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'mediaappearance_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'mediaappearance_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('mediaappearance_data') && Mage::registry('mediaappearance_data')->getId() ) {
            return Mage::helper('mediaappearance')->__("Edit Media '%s'", $this->htmlEscape(Mage::registry('mediaappearance_data')->getTitle()));
        } else {
            return Mage::helper('mediaappearance')->__('Add Media');
        }
    }
}
