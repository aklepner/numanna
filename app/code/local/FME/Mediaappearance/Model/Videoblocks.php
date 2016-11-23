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
 * Class FME_Mediaappearance_Model_Videoblocks
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Model_Videoblocks extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mediaappearance/videoblocks');
    }
    
    /**
     * Retrieve related articles
     *
     * @return array
     */
    public function getRelatedMedia($blockId)
    {
        $mediavideoblockTable = Mage::getSingleton('core/resource')->getTableName('media_block_videos');
        $mediaTable = Mage::getSingleton('core/resource')->getTableName('mediaappearance');
            
        $collection = Mage::getModel('mediaappearance/videoblocks')->getCollection()
        ->addBlockIdFilter($blockId);
                      
        $collection->getSelect()
            ->joinLeft(
                array('related' => $mediavideoblockTable),
                'main_table.media_block_id = related.media_block_id'
            )
            ->joinLeft(
                array('media' => $mediaTable),
                'related.mediaappearance_id = media.mediaappearance_id'
            )
            ->order('media.mediaappearance_id');
            
        return $collection->getData();

    }
    
    public function checkIdentifier($identifier, $storeId)
    {
        return $this->_getResource()->checkIdentifier($identifier, $storeId);
    }
}
