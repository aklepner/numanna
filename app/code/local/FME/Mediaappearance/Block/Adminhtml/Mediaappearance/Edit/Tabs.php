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
 * Class FME_Mediaappearance_Block_Adminhtml_Mediaappearance_Edit_Tabs
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Block_Adminhtml_Mediaappearance_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('mediaappearance_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('mediaappearance')->__('Media Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_section', array(
            'label'     => Mage::helper('mediaappearance')->__('Media Information'),
            'title'     => Mage::helper('mediaappearance')->__('Media Information'),
            'content'   => $this->getLayout()->createBlock('mediaappearance/adminhtml_mediaappearance_edit_tab_form')->toHtml(),
            'active'    => true
            )
        );
      
        /*$this->addTab('products_section', array(
        'label'     => Mage::helper('mediaappearance')->__('Apply to Products'),
        'title'     => Mage::helper('mediaappearance')->__('Apply to Products'),
        'content'   => $this->getLayout()->createBlock('mediaappearance/adminhtml_mediaappearance_edit_tab_product')->toHtml(),
		
        )); */

        $this->addTab(
            'products_section', array(
            'label'     => Mage::helper('mediaappearance')->__('Apply to  Products'),
            'url'       => $this->getUrl('*/*/products', array('_current' => true)),
            'class'     => 'ajax',
            )
        );
      
        $this->addTab(
            'categories_section', array(
            'label'     => Mage::helper('mediaappearance')->__('Apply to Categories'),
            'title'     => Mage::helper('mediaappearance')->__('Apply to Categories'),
            'content'   => $this->getLayout()->createBlock('mediaappearance/adminhtml_mediaappearance_edit_tab_categories')->toHtml(),
            )
        );
     
        return parent::_beforeToHtml();
    }
}
