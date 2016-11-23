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
 * Class FME_Mediaappearance_Model_Mysql4_Mediaappearance_Collection
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Model_Mysql4_Mediaappearance_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mediaappearance/mediaappearance');
    }
    
    public function addStoreFilter($store)
    {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        $this->getSelect()->join(
            array('store_table' => $this->getTable('media_store')),
            'main_table.mediaappearance_id = store_table.mediaappearance_id',
            array()
        )
            ->where('store_table.store_id in (?)', array(0, $store));

        return $this;
    }

    public function addMediagalleryFilter($mediagalleryId)
    {
        if (is_array($mediagalleryId)) {
            $condition = $this->getConnection()->quoteInto('main_table.mediaappearance_id IN(?)', $mediagalleryId);
        } else {
            $condition = $this->getConnection()->quoteInto('main_table.mediaappearance_id=?', $mediagalleryId);
        }
        return $this->addFilter('mediaappearance_id', $condition, 'string');
    }
}
