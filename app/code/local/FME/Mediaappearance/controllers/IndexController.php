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
 * Class FME_Mediaappearance_IndexController
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */
 
class FME_Mediaappearance_IndexController extends Mage_Core_Controller_Front_Action
{
    public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::helper('mediaappearance')->getMediaEnable()) {
            Mage::getSingleton('core/session')->addError(Mage::helper('mediaappearance')->__('Sorry This Feature is disabled temporarily'));
            $this->norouteAction();
    
        }
    }
    public function indexAction()
    {    
        $tabID = $this->getRequest()->getParam('tab');
        if (isset($tabID)) {
            if ($tabID == 1) {
                $collection = Mage::getModel('mediaappearance/mediaappearance')->getCollection()
                 ->addFieldToFilter('main_table.status', 1)
                 ->addOrder('main_table.created_time', 'desc')
                 ->getData();
                $itemsPerPage = Mage::helper('mediaappearance')->getListItemsPerPage();
            
                // Use paginator
                if ($itemsPerPage != 0 ) {        
                    $paginator = Zend_Paginator::factory((array)$collection);
                    $paginator->setCurrentPageNumber((int)$this->_request->getParam('page', 1))
                        ->setItemCountPerPage($itemsPerPage);
                    Mage::register('items', $paginator);
                } else {
                    Mage::register('items', $collection);
                }
            }  elseif ($tabID == 2) {
            
                $mediaTable = Mage::getSingleton('core/resource')->getTableName('mediaappearance');
                $collection = Mage::getResourceModel('catalog/product_collection');
                $attributes = Mage::getSingleton('catalog/config')
                ->getProductAttributes();
                $collection->addAttributeToSelect($attributes)
                    ->addMinimalPrice()
                    ->addFinalPrice()
                    ->addTaxPercents()
                    ->addStoreFilter();
                Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
                Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
                $collection->getSelect()
                    ->join(
                        array('media' => $mediaTable),
                        'FIND_IN_SET(e.entity_id, media.product_ids)'
                    );
                $collection->getSelect()->group(array('media.mediaappearance_id'));    
                //->group('e.entity_id');

                $prodcollection = $collection->getData();    

                /*echo "<pre>";
                print_r($prodcollection); exit();*/

                $itemsPerPage = Mage::helper('mediaappearance')->getListItemsPerPage();
            
                // Use paginator
                if ($itemsPerPage != 0 ) {        
                    $paginator = Zend_Paginator::factory((array)$prodcollection);
                    $paginator->setCurrentPageNumber((int)$this->_request->getParam('page', 1))
                        ->setItemCountPerPage($itemsPerPage);
                     /*echo "<pre>";
                     print_r($paginator); exit();*/
                    Mage::register('proditems', $paginator);
                } else {
                    Mage::register('proditems', $prodcollection);
                }

            
            } elseif ($tabID == 3) {
            
                $mediaTable = Mage::getSingleton('core/resource')->getTableName('mediaappearance');
                $categoriesCollection = Mage::getModel('catalog/category')
                ->getCollection()
                ->addFieldToFilter('is_active', array('eq' => 1))
                ->load();

                $categoriesCollection->getSelect()
                    ->join(array('mc' => $mediaTable), "FIND_IN_SET(e.entity_id, mc.category_ids)", array('mc.*'));

                $categoriesCollection->getSelect()->group(array('mc.mediaappearance_id'));                
                $categoriesCollection = $categoriesCollection->getData();

                
                $itemsPerPage = Mage::helper('mediaappearance')->getListItemsPerPage();
            
                // Use paginator
                if ($itemsPerPage != 0 ) {        
                    $cpaginator = Zend_Paginator::factory((array)$categoriesCollection);
                    $cpaginator->setCurrentPageNumber((int)$this->_request->getParam('page', 1))
                        ->setItemCountPerPage($itemsPerPage);
                    Mage::register('catitems', $cpaginator);
                } else {
                    Mage::register('catitems', $categoriesCollection);
                }

            
            }
            
        } else {
            
            $collection = Mage::getModel('mediaappearance/mediaappearance')->getCollection()
               ->addFieldToFilter('main_table.status', 1)
               ->addOrder('main_table.created_time', 'desc')
               ->getData();
            $itemsPerPage = Mage::helper('mediaappearance')->getListItemsPerPage();
            
            // Use paginator
            if ($itemsPerPage != 0 ) {        
                $paginator = Zend_Paginator::factory((array)$collection);
                $paginator->setCurrentPageNumber((int)$this->_request->getParam('page', 1))
                    ->setItemCountPerPage($itemsPerPage);
                Mage::register('items', $paginator);
            } else {
                Mage::register('items', $collection);
            }
            
        }
        $this->loadLayout(); 
        $this->getLayout()->createBlock(
            'mediaappearance/block', 'jsfunc',
            array('template' => 'mediaappearance/js_functions.phtml')
        );
        
        $this->getLayout()->getBlock('root')->setTemplate('page/1column.phtml');
        $this->renderLayout();


    }
}
