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
 * Class FME_Mediaappearance_Model_Mysql4_Videoblocks_Collection
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Model_Mysql4_Videoblocks_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mediaappearance/videoblocks');
    }
    
    public function addAttributeToFilter($attribute, $condition=null, $joinType='inner')
    {
        switch( $attribute ) {
        case 'status':
            $conditionSql = $this->_getConditionSql($attribute, $condition);
            $this->getSelect()->where($conditionSql);
            return $this;
                break;
        default:
            parent::addAttributeToFilter($attribute, $condition, $joinType);
        }
        return $this;
    }
    
    public function addBlockIdFilter($id = 0)
    {
        $this->getSelect()
            ->where('related.media_block_id=?', (int)$id);

        return $this;
    }
    
    public function addBlockIdentiferFilter($identifier = '')
    {
        $this->getSelect()
            ->where('main_table.block_identifier=?', $identifier);

        return $this;
    }
    
    
}
