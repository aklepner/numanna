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
 * Class FME_Mediaappearance_Block_Pagination
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Block_Pagination extends Mage_Core_Block_Template
{
    
    public function getPaginator()     
    { 
        
        $tabID = $this->getRequest()->getParam('tab');
        if (isset($tabID)) {
            
            if ($tabID == 1) {
                if (!$this->hasData('items') ) {
                    $this->setData('items', Mage::registry('items'));
                    return $this->getData('items')->getPages('Sliding');
                }  
            }elseif ($tabID == 2) {
                if (!$this->hasData('proditems') ) {
                    $this->setData('proditems', Mage::registry('proditems'));
                    return $this->getData('proditems')->getPages('Sliding');
                }  
            }elseif ($tabID == 3) {
                if (!$this->hasData('catitems') ) {
                    $this->setData('catitems', Mage::registry('catitems'));
                    return $this->getData('catitems')->getPages('Sliding');
                }    
            } 
            
        } else {
                
            if (!$this->hasData('items') ) {
                $this->setData('items', Mage::registry('items'));
                return $this->getData('items')->getPages('Sliding');
            }   
                
        }


    }

    
}
