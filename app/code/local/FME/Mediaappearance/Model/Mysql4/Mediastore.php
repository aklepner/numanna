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
 * Class FME_Mediaappearance_Model_Mysql4_Mediastore
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Model_Mysql4_Mediastore
 extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the mediaappearance_id refers to the key field in your database table.
        $this->_init('mediaappearance/media_store', 'mediaappearance_id');
    }
    
    /* protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
    	
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('media_store'))
            ->where('mediaappearance_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }

        return parent::_afterLoad($object);
        
    }*/

    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('media_store'))
            ->where('mediaappearance_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $storesArray = array();
            foreach ($data as $row) {
                $storesArray[] = $row['store_id'];
            }
            $object->setData('store_id', $storesArray);
        }

        $mediagalleryProductsTable = Mage::getSingleton('core/resource')->getTableName('mediaappearance_products');
    
        //Get Category Ids
        $select = $this->_getReadAdapter()->select()
            ->from($mediagalleryProductsTable)
            ->where('mediaappearance_id = ?', $object->getId());

        if ($data = $this->_getReadAdapter()->fetchAll($select)) {
            $productsArray = array();
            foreach ($data as $row) {
                $productsArray[] = $row['product_id'];
            }
            $object->setData('product_id', $productsArray);
        }

        return parent::_afterLoad($object);
        
    }

    /**
     * Process page data before saving
     *
     * @param Mage_Core_Model_Abstract $object
     */
    /*  protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
            
        $condition = $this->_getWriteAdapter()->quoteInto('mediaappearance_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('media_store'), $condition);
        $this->_getWriteAdapter()->delete($this->getTable('media_category_video'), $condition);
    
    
        //Get All Selected Categories
        $string = $_POST['category_ids'];
        $string = trim($string, ',');
                        
        $catIds = explode(",", $string);    
        $result = array_unique($catIds);
        
         foreach ($result as $category) {
            $categoryArray = array();
            $categoryArray['mediaappearance_id'] = $object->getId();
            $categoryArray['category_id'] = $category;
            $this->_getWriteAdapter()->insert($this->getTable('media_category_video'), $categoryArray);
        }
    
        foreach ((array)$object->getData('stores') as $store) {
            $storeArray = array();
            $storeArray['mediaappearance_id'] = $object->getId();
            $storeArray['store_id'] = $store;
            $this->_getWriteAdapter()->insert($this->getTable('media_store'), $storeArray);
        }
    
        return parent::_afterSave($object);
        
    }*/
    
    /**
     * Process page data before saving
     *
     * @param Mage_Core_Model_Abstract $object
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {

        /* echo '<pre>';
        print_r($_POST['productIds']);
        exit;*/

        $mediagalleryProductsTable = Mage::getSingleton('core/resource')->getTableName('mediaappearance_products');
        
        $condition = $this->_getWriteAdapter()->quoteInto('mediaappearance_id = ?', $object->getId());
        //Get All Selected Categories
        if (isset($_POST['productIds'])) {
            $this->_getWriteAdapter()->delete($mediagalleryProductsTable, $condition);    
            
            $productIdsString = $_POST['productIds'];
            $productIdsString = trim($productIdsString, ',');   
            
            if (isset($_POST['productIds'])) {
                if ($productIdsString != '') {
                    
                    $db = $this->_getWriteAdapter();
                    try {
                            $db->beginTransaction();
                            $db->exec("DELETE FROM ".$mediagalleryProductsTable." WHERE product_id in ($productIdsString)");
                            $db->commit();
                            
                    } catch(Exception $e) {
                        $db->rollBack();
                        throw new Exception($e);
                    }
                }
            }

            $productIds = explode(",", $productIdsString);  
            $Result = array_unique($productIds);
                    
            foreach ($Result as $_productId) {  
             
                $productsArray = array();
                $productsArray['mediaappearance_id'] = $object->getId();
                $productsArray['product_id'] = $_productId;
                $this->_getWriteAdapter()->insert($mediagalleryProductsTable, $productsArray);
            }
        }
        
        if (isset($_POST['stores'])) {
             $this->_getWriteAdapter()->delete($this->getTable('media_store'), $condition);
            foreach ((array)$_POST['stores'] as $store) {
                $storeArray = array();
                $storeArray['mediaappearance_id'] = $object->getId();
                $storeArray['store_id'] = $store;
                $this->_getWriteAdapter()->insert($this->getTable('media_store'), $storeArray);
            }
        }
    
    
        $this->_getWriteAdapter()->delete($this->getTable('media_store'), $condition);
    
        foreach ((array)$object->getData('stores') as $store) {
            $storeArray = array();
            $storeArray['mediaappearance_id'] = $object->getId();
            $storeArray['store_id'] = $store;
            $this->_getWriteAdapter()->insert($this->getTable('media_store'), $storeArray);
        }
    
        return parent::_afterSave($object);
        
    }
    
}
