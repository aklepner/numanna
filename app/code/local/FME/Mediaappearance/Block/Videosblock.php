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
 * Class FME_Mediaappearance_Block_Videosblock
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */
class FME_Mediaappearance_Block_Videosblock extends Mage_Core_Block_Template
{

    public function getBlockVideos($limit = 5)      
    { 
        $limit = Mage::getStoreConfig('mediaappearance/general/maxrightblockvideos');
        $collection = Mage::getModel('mediaappearance/mediaappearance')->getCollection()
        ->addStoreFilter(Mage::app()->getStore(true)->getId())
        ->addFieldToFilter('main_table.status', 1)
        ->addFieldToFilter('main_table.show_in_right_column', 1)
        ->addOrder('main_table.created_time', 'desc')
        ->setPageSize($limit)
        ->getData();
        
        return $collection;
        
    }
    
    public function _toHtml()
    {
    
        $isLeft = ($this->getParentBlock() === $this->getLayout()->getBlock('left'));
        $isRight = ($this->getParentBlock() === $this->getLayout()->getBlock('right'));
        
        $isMediaPage = Mage::app()->getFrontController()->getAction()->getRequest()->getModuleName() == 'mediaappearance';
        
        $leftAllowed = ($isMediaPage && Mage::getStoreConfig('mediaappearance/videosblock/left') == 2) || (Mage::getStoreConfig('mediaappearance/videosblock/left') == 1);
        $rightAllowed = ($isMediaPage && Mage::getStoreConfig('mediaappearance/videosblock/right') == 2) || (Mage::getStoreConfig('mediaappearance/videosblock/right') == 1);
        
        if (!$leftAllowed && $isLeft) {
            return '';
        }
        if (!$rightAllowed && $isRight) {
            return '';
        }        
        return parent::_toHtml();
    }
    
}
