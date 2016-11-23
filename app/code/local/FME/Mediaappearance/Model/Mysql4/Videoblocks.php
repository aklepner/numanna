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
 * Class FME_Mediaappearance_Model_Mysql4_Videoblocks
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Model_Mysql4_Videoblocks extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('mediaappearance/videoblocks', 'media_block_id');
    }
    
    /**
     * Check if page identifier exist for specific store
     * return page id if page exists
     *
     * @param  string $identifier
     * @param  int    $storeId
     * @return int
     */
    public function checkIdentifier($identifier, $storeId)
    {
        $select = $this->_getReadAdapter()->select()->from(array('main_table'=>$this->getMainTable()), 'media_block_id')
            ->where('main_table.identifier = ?', $identifier)
            ->where('main_table.status = 1');
            
        return $this->_getReadAdapter()->fetchOne($select);
    }
    
    public function load(Mage_Core_Model_Abstract $object, $value, $field=null)
    {

        if (!intval($value) && is_string($value)) {
            $field = 'block_identifier';
        }
        return parent::load($object, $value, $field);
    }
    
    /**
     * Process page data before saving
     *
     * @param Mage_Core_Model_Abstract $object
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
            
        $condition = $this->_getWriteAdapter()->quoteInto('media_block_id = ?', $object->getId());
        //Get Related Media
        if (isset($_POST['links'])) {
            $links = $_POST['links'];
            $mediaIds = Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['relatedmedia']);
            $this->_getWriteAdapter()->delete($this->getTable('media_block_videos'), $condition);
        
        
            //Save Related Articles
            foreach ($mediaIds as $_media) {
                $mediaArray = array();
                $mediaArray['media_block_id'] = $object->getId();
                $mediaArray['mediaappearance_id'] = $_media;
                $this->_getWriteAdapter()->insert($this->getTable('media_block_videos'), $mediaArray);
            }
        } 
        
        return parent::_afterSave($object);
        
    }
    
    /**
     * Check for unique of identifier of block.
     *
     * @param  Mage_Core_Model_Abstract $object
     * @return bool
     */
    public function getIsUniqueBlockToStores(Mage_Core_Model_Abstract $object)
    {
        $select = $this->_getWriteAdapter()->select()
            ->from($this->getMainTable())
            ->join(array('cbs' => $this->getTable('cms/block_store')), $this->getMainTable().'.block_id = `cbs`.block_id')
            ->where($this->getMainTable().'.identifier = ?', $object->getData('identifier'));
        if ($object->getId()) {
            $select->where($this->getMainTable().'.block_id <> ?', $object->getId());
        }
        $select->where('`cbs`.store_id IN (?)', (array)$object->getData('stores'));

        if ($this->_getWriteAdapter()->fetchRow($select)) {
            return false;
        }

        return true;
    }
    
}
