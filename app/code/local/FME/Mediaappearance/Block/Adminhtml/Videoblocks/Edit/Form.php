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
 * Class FME_Mediaappearance_Block_Adminhtml_Videoblocks_Edit_Form
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Block_Adminhtml_Videoblocks_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
            'id' => 'videoblocks_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
                                      'enctype' => 'multipart/form-data'
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
