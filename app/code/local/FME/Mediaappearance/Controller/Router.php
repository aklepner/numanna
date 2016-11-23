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
 * Class FME_Mediaappearance_Controller_Router
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */
class FME_Mediaappearance_Controller_Router extends Mage_Core_Controller_Varien_Router_Abstract
{
    public function initControllerRouters($observer)
    {            
        $front = $observer->getEvent()->getFront();
        $router = new FME_Mediaappearance_Controller_Router();
        $front->addRouter('mediaappearance', $router);
        
    }

    public function match(Zend_Controller_Request_Http $request)
    {
        
        if (!Mage::isInstalled()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect(Mage::getUrl('install'))
                ->sendResponse();
            exit;
        }
        
        
        $route = Mage::helper('mediaappearance')->getListIdentifier();        
           $identifier = trim($request->getPathInfo(), '/');        
        $identifier = str_replace(Mage::helper('mediaappearance')->getSeoUrlSuffix(), '', $identifier);
                    
        if ($identifier == $route ) {
            $request->setModuleName('mediaappearance')
                ->setControllerName('index')
                ->setActionName('index');
                    
            return true;
                    
        }  
       
        return false;

    }
}
