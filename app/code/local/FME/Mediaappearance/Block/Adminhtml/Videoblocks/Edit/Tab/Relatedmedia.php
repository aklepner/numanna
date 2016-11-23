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
 * Class FME_Mediaappearance_Block_Adminhtml_Videoblocks_Edit_Tab_Relatedmedia
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Block_Adminhtml_Videoblocks_Edit_Tab_Relatedmedia extends Mage_Adminhtml_Block_Widget_Grid
{
    
    /**
    * Set grid params 
    */
    public function __construct()
    { 
        parent::__construct();
        $this->setId('related_media_grid');
        $this->setDefaultSort('mediaappearance_id');
        $this->setUseAjax(true);
        
    }
    
    /**
    * Retirve currently edited product model
    *
    * @return Mage_Catalog_Model_Product
    */
    protected function _getMedia()
    {
        return Mage::registry('current_block');
    }
    
    /**
    * Add filter
    *
    * @param  object $column
    * @return Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Related
    */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in product flag
        if ($column->getId() == 'in_media') {
            $mediaIds = $this->getSelectedRelatedMedia();

            if (empty($mediaIds)) {
                $mediaIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('mediaappearance_id', array('in'=>$mediaIds));
            } else {
                if ($mediaIds) {
                    $this->getCollection()->addFieldToFilter('mediaappearance_id', array('nin'=>$mediaIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
    
        return $this;
    }
    
        
    protected function _prepareCollection()
    {
                
        $collection = Mage::getModel('mediaappearance/mediaappearance')->getCollection() 
                          ->addOrder('mediaappearance_id', 'asc');
        $this->setCollection($collection);        
        return parent::_prepareCollection();
    }


    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_media', array(
            'header_css_class'  => 'a-center',
            'type'              => 'checkbox',
            'name'              => 'in_media',
            'align'             => 'center',
            'values'            => $this->getSelectedRelatedMedia(),
            'index'             => 'mediaappearance_id'
            )
        );

        $this->addColumn(
            'mediaappearance_id', array(
            'header'    => Mage::helper('mediaappearance')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'mediaappearance_id',
            )
        );

        $this->addColumn(
            'filethumb', array(
            'header'    => Mage::helper('mediaappearance')->__('Thumbnail'),
            'align'     =>'center',
            'index'     => 'filethumb',
            'type'      => 'image',
            'escape'    => true,
            'sortable'  => false,
            'filter'    => false,
            'renderer'  => new FME_Mediaappearance_Block_Adminhtml_Mediaappearance_Renderer_Image,
            )
        );
        
        $this->addColumn(
            'title', array(
            'header'    => Mage::helper('mediaappearance')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
            )
        );
        
        $this->addColumn(
            'status', array(
            'header'    => Mage::helper('mediaappearance')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
            1 => 'Enabled',
            2 => 'Disabled',
            ),
            )
        );

        return parent::_prepareColumns();
    }
    
    /**
     * Retrieve related products
     *
     * @return array
     */
    public function getSelectedRelatedMedia()
    {
        $id = $this->getRequest()->getParam('id');
           $mediaArr = array();
        foreach (Mage::getModel('mediaappearance/videoblocks')->getRelatedMedia($id) as $media) {
            $mediaArr[$media["mediaappearance_id"]] = array('position' => '0');
        }
        $media = array_keys($mediaArr);
        return $media;
    }
    
    /**
     * Rerieve grid URL
     *
     * @return string
     */


}
