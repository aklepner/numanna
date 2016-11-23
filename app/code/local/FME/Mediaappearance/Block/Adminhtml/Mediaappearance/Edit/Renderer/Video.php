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
 * Class 
 * FME_Mediaappearance_Block_Adminhtml_Mediaappearance_Edit_Renderer_Video
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Block_Adminhtml_Mediaappearance_Edit_Renderer_Video extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
         
        $_val = Mage::registry('mediaappearance_data');
        $_Typevalfile = '';
        $_Typevalurl  = ''; 
        
        if ($_val["mediatype"] == '1') {
            $_Typevalfile = 'checked="checked"';
            $_Typevalurl  = '';
        } elseif ($_val["mediatype"] == '2') {
            $_Typevalurl = 'checked="checked"';
            $_Typevalfile = '';
        } else {
            $_Typevalfile = 'checked="checked"';
            $_Typevalurl = '';
        }
        
        //Get the Current File
        try {
            $object = Mage::getModel('mediaappearance/mediaappearance')->load($this->getRequest()->getParam('id'));
            $note = false;
            //Config For Popup Window
            $popupWidth  = Mage::getStoreConfig('mediaappearance/popupsettings/width');
            $popupHeight = Mage::getStoreConfig('mediaappearance/popupsettings/height');
            $autoPlay      = Mage::getStoreConfig('mediaappearance/popupsettings/autoplay');
            $playAgain      = Mage::getStoreConfig('mediaappearance/popupsettings/playagain');
                        
            if ($object["mediatype"] == "1") {
                
                if ($object["filethumb"] != "") {
                    $imgURL =  Mage::helper('mediaappearance')->getResizedUrl($object["filethumb"], 100);
                } else {
                    $imgURL =  Mage::helper('mediaappearance')->getResizedUrl("mediaappearance/video_icon_full.jpg", 100);
                }
                $videoURL = Mage::getBaseUrl('media').$object["filename"];
                $videoRel = 'shadowbox;height='.$popupHeight.';width='.$popupWidth.';options={flashVars:{skin: '.Mage::getBaseUrl('js').'mediaappearance/skin01.zip,autostart: '.$autoPlay.'}}; handleOversize: "resize",';
                if ($object["filename"]!='') {
                    $html .='<input type="hidden" value="1" name="filenotemty">';
                } else {
                    $html .='<input type="hidden" value="0" name="filenotemty">';
                }
            } elseif ($object["mediatype"] == "2") {
                
                //For Thumb
                $videoURL = $object["videourl"];
                $videoData = Mage::helper('mediaappearance')->video_info($object["videourl"]);
                if ($videoData!==false) {
                    if (Mage::getStoreConfig('mediaappearance/general/useyoutubethumb')) {
                        $imgURL =  Mage::helper('mediaappearance')->getResizedUrl($object["filethumb"], 500);
                    } else {
                        if ($object["filethumb"] != "") {
                            $imgURL =  Mage::helper('mediaappearance')->getResizedUrl($object["filethumb"], 500);
                        } else { 
                            $imgURL =  Mage::helper('mediaappearance')->getResizedUrl("mediaappearance/video_icon_full.jpg", 500);
                        }
                    }
                } else {
                    if ($object["filethumb"] != "") {
                        $imgURL =  Mage::helper('mediaappearance')->getResizedUrl($object["filethumb"], 500);
                    } else {
                        $imgURL =  Mage::helper('mediaappearance')->getResizedUrl("mediaappearance/video_icon_full.jpg", 500);
                    }
                }
                
                //For Video URL
                if ($videoData!==false) {
                    $video_type  = $videoData['video_type'];
                    $video_id    = $videoData['video_id'];
                    if ($video_type == "vimeo") {
                        $videoRel = "shadowbox;height=".$popupHeight.";width=".$popupWidth.";";
                        $videoURL = 'http://vimeo.com/moogaloop.swf?clip_id='.$video_id.'&autoplay='.$autoPlay.'';
                    } elseif ($video_type == "youtube") {
                        $videoRel = 'shadowbox;height='.$popupHeight.';width='.$popupWidth.';options={flashVars:{autostart: '.$autoPlay .'}}';
                        $videoURL = "http://www.youtube.com/v/".$video_id;
                    } 
                } else {
                    $videoURL = "".$object["videourl"];
                    $videoRel = 'shadowbox;height='.$popupHeight.';width='.$popupWidth.';options={flashVars:{skin: '.Mage::getBaseUrl('js').'mediaappearance/skin01.zip,autostart: '.$autoPlay.'}}';
                }
                if ($object["videourl"]!='') {
                    $html .='<input type="hidden" value="1" name="videonotempty">';
                } else {
                    $html .='<input type="hidden" value="0" name="videonotempty">';
                }
            } 
            
            if ($object->getId()) {
                $titlevid = $object["title"];
                $videoLink = '&nbsp;&nbsp;<a href="'.$videoURL.'"  rel="'.$videoRel.'" onclick="closeadmin()">View current file</a>';
                
                
                $imgSrc = '&nbsp;&nbsp;<a href="'.$imgURL.'" rel="'.$videoRel.'">View current file</a>';
            } else {
                $videoLink = "";
                $imgSrc = "";
            }
            
            
            
        } catch (Exception $e) {
            $videoLink = "";
        }
        $html .= '<script type="text/javascript">';
        $html .='	
					Shadowbox.init({
						overlayOpacity: 0.8,
						displayNav:true,
    					flashVars: {
   						skin: "'.Mage::getBaseUrl('js').'mediaappearance/skin01.zip'.'"
  						},
					});
					Shadowbox.open({
						handleOversize: "resize",
        				player:     "inline",
    				});
				';
        $html .=     '</script>';
        $html .=     "";
        $html .=    '<tr>';
        $html .=    '<td class="label"><label for="mediatype">Choose Video Type</label></td>';
        $html .=    '<td class="value">';
        $html .=    '<input type="radio" '.$_Typevalfile.' onclick="checkRadios();" id="video_typefile" value="1" name="mediatype"><label for="video_typefile" class="inline">&nbsp;Media File</label>&nbsp;';
        $html .=    '<input type="radio" id="video_typeurl" '.$_Typevalurl.' onclick="checkRadios();" value="2" name="mediatype"><label for="video_typeurl" class="inline">&nbsp;URL</label>&nbsp;';
        $html .=    '<p class="nm"><small>(If you want to upload file select (<b>Media File</b>) if you want to put yourtube video or link of video select second option)</small></p>            </td>';
        $html .=    '</tr>';
        
        $html .=    '<tr id="video_file_block">';
        $html .=    '<td class="label"><label for="my_file_uploader">Video File</label></td>';
        $html .=    '<td class="value">';
        $html .=    '<input type="file" value="" name="my_file_uploader" id="my_file_uploader">'.$videoLink;
        $html .=     "<div class='window_content video' id='rbird_video' style='display: none;''></div>";
        $html .=    '<p class="nm"><small>(Supported Format FLV, MPEG, MP4, MP3)</small></p></td>';
        $html .=    '</tr>';
        
        $html .=     '<tr id="video_url_block" style="display:none">';
        $html .=     '<td class="label"><label for="videourl">Video URL</label></td>';
        $html .=     '<td class="value">';
        $html .=      '<input type="text" class=" input-text" value="'.$_val["videourl"].'" name="videourl" id="videourl">'.$videoLink;
        $html .=     '<p class="nm"><small>(In URL field out youtube or Vimeo URL OR complete path of video e.g http://www.domain.com/media/abc.flv)</small></p></td>';
        $html .=     '</tr>';
        
        $html .=     '<tr>';
        $html .=     '<td class="label"><label for="my_thumb_uploader">Media Thumb</label></td>';
        $html .=     '<td class="value">';
        $html .=      '<input type="file"  value="" name="my_thumb_uploader" id="my_thumb_uploader">'.$imgSrc;
        $html .=    '<p class="nm"><small>(Supported Format JPEG, PNG, GIF)</small></p>';
        $html .=     '</td>';
        $html .=     '</tr>';
        
        $html .= '<script type="text/javascript">';
        $html .= "var checkRadios = function(){
					if ($('video_typefile').checked){
						
						$('video_file_block').show();
						$('video_url_block').hide();
			
					} else if ($('video_typeurl').checked) {
			
						$('video_url_block').show();
						$('video_file_block').hide();
					}
				}
				window.onload = function() {
					checkRadios();
				}";
                
        $html .= ";function closeadmin()
					{
						Shadowbox.close();
						document.getElementById('sb-title-inner').innerHTML= '';
    					document.getElementById('sb-counter').innerHTML = '';
    					document.getElementById('sb-container').style.display= 'none';
					}";
        
        $html .= '</script>';
        $html .='
					<div style="height:10px;">&nbsp;</div>
					<div id="sb-container" style="display: none; height: 100%; width: 100%; visibility: visible;">
						<div id="sb-overlay" style="background-color: rgb(0, 0, 0); opacity: 0.8;">
						</div>
						<div id="sb-wrapper" style="top: 20px; left: 501px; width: 410px; visibility: visible;">
							<div id="sb-title">
								<div id="sb-title-inner" style="margin-top: 0px;">
								</div>
							</div>
							<div id="sb-wrapper-inner" style="height: 303px;">
								<div id="sb-body">
									<div id="sb-body-inner">
									</div>
								<div id="sb-loading" style="display: none;">
									<div id="sb-loading-inner">
										<span>loading</span>
									</div>
								</div>
							</div>
						</div>
					<div id="sb-info">
						<div id="sb-info-inner" style="margin-top: 0px;">
							<div id="sb-counter">
							</div>
							<div id="sb-nav">
								<a href="javascript:closeadmin();" title="Close" id="sb-nav-close">X</a>
							</div>
						</div>
						</div>
						</div>
					</div>';
        return $html;
    }

}
