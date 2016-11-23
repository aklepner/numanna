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
 * Class FME_Mediaappearance_Block_Mediaappearance
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Block_Mediaappearance extends Mage_Core_Block_Template
{

    
    public function _prepareLayout()
    {
        
        if (Mage::getStoreConfig('web/default/show_cms_breadcrumbs') && ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) ) {
            $breadcrumbs->addCrumb('home', array('label'=>Mage::helper('cms')->__('Home'), 'title'=>Mage::helper('cms')->__('Go to Home Page'), 'link'=>Mage::getBaseUrl()));
            $breadcrumbs->addCrumb('mediaappearance_home', array('label' => Mage::helper('mediaappearance')->getListPageTitle(), 'title' => Mage::helper('mediaappearance')->getListPageTitle()));
        }
        
        if ($head = $this->getLayout()->getBlock('head')) {
            $head->setTitle(Mage::helper('mediaappearance')->getListPageTitle());
            $head->setDescription(Mage::helper('mediaappearance')->getListMetaDescription());
            $head->setKeywords(Mage::helper('mediaappearance')->getListMetaKeywords());
        }
        
        return parent::_prepareLayout();
    }
    
    public function getLimitDescription()
    {
        
        if (!$this->hasData('limit_description') ) {
            $this->setData('limit_description', Mage::registry('limit_description'));
        }
        return $this->getData('limit_description');
        
    }
    
    public function getMediaappearance()     
    { 
        $collection = Mage::getModel('mediaappearance/mediaappearance')->getCollection()
        ->addStoreFilter(Mage::app()->getStore(true)->getId())
        ->addFieldToFilter('main_table.status', 1)
        ->addOrder('main_table.created_time', 'desc')
        ->getData();
     
        if (!$this->hasData('mediaappearance')) {
            $this->setData('mediaappearance', $collection);
        }
        return $this->getData('mediaappearance');
        
    }
}
