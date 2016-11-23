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
 * Class FME_Mediaappearance_Block_Adminhtml_Mediaappearance_Renderer_Image
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */
 
class FME_Mediaappearance_Block_Adminhtml_Mediaappearance_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected static $showImagesUrl = null;
    protected static $showByDefault = null;
    protected static $width = null;
    protected static $height = null;
    
    public function __construct() 
    {
        if (self::$showImagesUrl == null)
            self::$showImagesUrl = (int)Mage::getStoreConfig('mediaappearance/images/showurl') === 1;
        if (self::$showByDefault == null)
            self::$showByDefault = (int)Mage::getStoreConfig('mediaappearance/images/showbydefault') === 1;
        if (self::$width == null)
            self::$width = Mage::getStoreConfig('mediaappearance/images/width');
        if (self::$height == null)
            self::$height = Mage::getStoreConfig('mediaappearance/images/height'); 
    }

    /** 
     * Renders grid column
     *
     * @param  Varien_Object $row
     * @return string
     */
    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    }
    
    protected function _getValue(Varien_Object $row)
    {
        $dored = false;
        if ($getter = $this->getColumn()->getGetter()) {
            $val = $row->$getter();
        }
        
        $mediaID  = $row->getData("mediaappearance_id");

        $val = $val2 = $row->getData($this->getColumn()->getIndex());
        $val = str_replace("no_selection", "", $val);
        $val2 = str_replace("no_selection", "", $val2);

        if ($row->getData("mediatype") == "1") {
            
            if ($row->getData("filethumb") != "") {
                $url = Mage::helper('mediaappearance')->getImageUrl($val);
            } else {
                $url = Mage::getBaseUrl('media')."mediaappearance/video_icon.jpg";
            }
            
        } elseif ($row->getData("mediatype") == "2") {

            $videoData = Mage::helper('mediaappearance')->video_info($row->getData("videourl"));
                
            if ($videoData!==false) {

                if (Mage::getStoreConfig('mediaappearance/general/useyoutubethumb')) {
                    //$url = $videoData['thumb_large'];	

                    if ($videoData['thumb_large'] != "") {
                        $url = Mage::helper('mediaappearance')->getResizedUrl($row->getData("filethumb"), 100);
                    } elseif ($row->getData("filethumb") != "") {
                        $url = Mage::helper('mediaappearance')->getResizedUrl($row->getData("filethumb"), 100);
                    } else {
                        $url = Mage::helper('mediaappearance')->getResizedUrl("mediaappearance/video_icon.jpg", 100);
                    }

                } else {
                    if ($row->getData("filethumb") != "") {
                        $url = Mage::helper('mediaappearance')->getResizedUrl($row->getData("filethumb"), 100);
                    } else {
                        $url = Mage::helper('mediaappearance')->getResizedUrl("mediaappearance/video_icon.jpg", 100);
                    }
                }
            } else {
                    
                if ($row->getData("filethumb") != "") {
                    $url = Mage::helper('mediaappearance')->getResizedUrl($row->getData("filethumb"), 100);
                } else {
                    $url = Mage::helper('mediaappearance')->getResizedUrl("mediaappearance/video_icon.jpg", 100);
                }
            }
        }
   
        if (strpos($val, "placeholder/")) {
            $dored = true;
        }
        
        $filename = substr($val2, strrpos($val2, "/")+1, strlen($val2)-strrpos($val2, "/")-1);
        if (!self::$showImagesUrl) $filename = '';
        if ($dored) {
            $val = "<span style=\"color:red\" id=\"img\">$filename</span>";
        } else {
            $val = "<span>". $filename ."</span>";
        }
        
        if (empty($val2) ) {
            $out = "";
        } else {
            $out = $val. '<center>';
        }
        
        if (self::$showByDefault) {
            $out = '<img style="width:150px" ';
            $out .= 'id="' . $this->getColumn()->getId() . '" ';
            $out .= 'src="' . $url . '"';
            $out .= 'class="grid-image ' . $this->getColumn()->getInlineCss() . '"/>';
        }
        $out .= '</center>';
        return $out;
    }


}
