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
 * Class FME_Mediaappearance_Block_Adminhtml_Mediaappearance_Grid
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Block_Adminhtml_Mediaappearance_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('mediaappearanceGrid');
        $this->setDefaultSort('mediaappearance_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('mediaappearance/mediaappearance')->getCollection();
        $this->setCollection($collection);
        $html  = '';
        $html .= '<script type="text/javascript">';
        $html .= '
			Shadowbox.init({
				overlayOpacity: 0.8,
				flashVars: {
					skin: "'.Mage::getBaseUrl('js')."mediaappearance/skin01.zip".'"
				}
			});';
        $html .= '</script>';
        echo $html;
      
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
            
        $this->addColumn(
            'mediaappearance_id', array(
            'header'    => Mage::helper('mediaappearance')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'mediaappearance_id',
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
            'featured', array(
            'header'    => Mage::helper('mediaappearance')->__('Featured'),
            'align'     => 'left',
            'width'     => '120px',
            'index'     => 'featured_video',
            'type'      => 'options',
            'options'   => array(
            1 => 'Yes',
            0 => 'No',
            ),
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
            0 => 'Disabled',
            ),
            )
        );
      
        $this->addColumn(
            'action',
            array(
                'header'    =>  Mage::helper('mediaappearance')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('mediaappearance')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
            )
        );
        
        $this->addExportType('*/*/exportCsv', Mage::helper('mediaappearance')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('mediaappearance')->__('XML'));
      
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('mediaappearance_id');
        $this->getMassactionBlock()->setFormFieldName('mediaappearance');

        $this->getMassactionBlock()->addItem(
            'delete', array(
             'label'    => Mage::helper('mediaappearance')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('mediaappearance')->__('Are you sure?')
            )
        );

        $statuses = Mage::getSingleton('mediaappearance/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem(
            'status', array(
             'label'=> Mage::helper('mediaappearance')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('mediaappearance')->__('Status'),
                         'values' => $statuses
                     )
             )
            )
        );
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
  
  

}
