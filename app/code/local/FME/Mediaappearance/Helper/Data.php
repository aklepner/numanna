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
 * Class FME_Mediaappearance_Helper_Data
 *
 * @category FME
 * @package  Mediaappearance
 * @author   Altaf Ahmed <support@fmeextension.com>
 * @license  http://opensource.org/licenses/osl-3.0.php  
 * Open Software License (OSL 3.0)
 * @link     https://www.fmeextensions.com
 */

class FME_Mediaappearance_Helper_Data extends Mage_Core_Helper_Abstract
{
    
    const XML_PATH_MEDIAGALLER_ENABLE            =    'mediaappearance/general/enablemedia';
    const XML_PATH_LIST_PAGE_TITLE                =    'mediaappearance/list/page_title';
    const XML_PATH_LIST_IDENTIFIER                =    'mediaappearance/list/identifier';
    const XML_PATH_LIST_ITEMS_PER_PAGE            =    'mediaappearance/list/items_per_page'; 
    const XML_PATH_LIST_CATS_PER_PAGE            =    'mediaappearance/list/cat_per_page'; 
    const XML_PATH_LIST_PRODS_PER_PAGE            =    'mediaappearance/list/prod_per_page'; 
    
    const XML_PATH_LIST_LIMIT_DESCRIPTION        =    'mediaappearance/list/limit_description';
    const XML_PATH_LIST_META_DESCRIPTION        =    'mediaappearance/list/meta_description';
    const XML_PATH_LIST_META_KEYWORDS            =    'mediaappearance/list/meta_keywords';
    const XML_PATH_SEO_URL_SUFFIX                =    'mediaappearance/seo/url_suffix'; 
    const XML_PATH_FEATUREDBLOCK_LEFT            =     'mediaappearance/featuredblock/left';
    const XML_PATH_FEATUREDBLOCK_RIGHT            =     'mediaappearance/featuredblock/right';
    const XML_PATH_FEATUREDBLOCK_TITLE            =     'mediaappearance/featuredblock/title'; 
    const XML_PATH_VIDEOSBLOCK_LEFT                =     'mediaappearance/videosblock/left';
    const XML_PATH_VIDEOSBLOCK_RIGHT            =     'mediaappearance/videosblock/right';
    const XML_PATH_VIDEOSBLOCK_TITLE            =     'mediaappearance/videosblock/title';
    const XML_PATH_VIDEOPLAY_OPTIONS            =    'mediaappearance/general/videooptions';
    
    public function getMediaEnable()
    {
        return Mage::getStoreConfig(self::XML_PATH_MEDIAGALLER_ENABLE);
    }
    public function getListPageTitle()
    {
        return Mage::getStoreConfig(self::XML_PATH_LIST_PAGE_TITLE);
    }
    
    public function getFeaturedVideosBlockTitle()
    {
        return Mage::getStoreConfig(self::XML_PATH_FEATUREDBLOCK_TITLE);
    }
    
    public function getVideosBlockTitle()
    {
        return Mage::getStoreConfig(self::XML_PATH_VIDEOSBLOCK_TITLE);
    }

    public function getVideoPlayOptions()
    {
        return Mage::getStoreConfig(self::XML_PATH_VIDEOPLAY_OPTIONS);
    }
    
    public function getListIdentifier()
    {
        $identifier = Mage::getStoreConfig(self::XML_PATH_LIST_IDENTIFIER);
        if (!$identifier ) {
            $identifier = 'mediaappearance';
        }
        return $identifier;
    }
    
    public function geturlIdentifier()
    {
        $identifier = $this->getListIdentifier() . Mage::getStoreConfig(self::XML_PATH_SEO_URL_SUFFIX);
        return Mage::getUrl($identifier);
    }
    
    public function getListItemsPerPage()
    {
        return (int)Mage::getStoreConfig(self::XML_PATH_LIST_ITEMS_PER_PAGE);
    }
    
    public function getListCatsPerPage()
    {
        return (int)Mage::getStoreConfig(self::XML_PATH_LIST_CATS_PER_PAGE);
    }
    
    public function getListProdsPerPage()
    {
        return (int)Mage::getStoreConfig(self::XML_PATH_LIST_PRODS_PER_PAGE);
    }
    
    public function getListLimitDescription()
    {
        return (int)Mage::getStoreConfig(self::XML_PATH_LIST_LIMIT_DESCRIPTION);
    }
    
    public function getListMetaDescription()
    {
        return Mage::getStoreConfig(self::XML_PATH_LIST_META_DESCRIPTION);
    }
    
    public function getListMetaKeywords()
    {
        return Mage::getStoreConfig(self::XML_PATH_LIST_META_KEYWORDS);
    }
    
    public function getUrl($identifier = null)
    {
        
        if (is_null($identifier) ) {
            $url = Mage::getUrl('') . self::getListIdentifier() . self::getSeoUrlSuffix();
        } else {
            $url = Mage::getUrl('') . $identifier . self::getSeoUrlSuffix();
        }

        return $url;
        
    }
    
    public function getSeoUrlSuffix()
    {
        return Mage::getStoreConfig(self::XML_PATH_SEO_URL_SUFFIX);
    }
    
    public function video_thumbnail($url) 
    {
        $youtube = array();
        if (!strpos($url, "#!v=") === false ) {  //Em caso de ser um link de quando clica nos related
            $url = str_replace('#!v=', '?v=', $url);
        }
        parse_str(parse_url($url, PHP_URL_QUERY));
        if (isset($v) ) {
            $youtubeID = $v;
        } else { //Se não achou, é por que é o link de um video de canal ex: http://www.youtube.com/user/laryssap#p/a/u/1/SAXVMaLL94g
            //If not found, is because is a link from a user channel ex: http://www.youtube.com/user/laryssap#p/a/u/1/SAXVMaLL94g
            $youtubeID = substr($url, strrpos($url, '/') + 1, 11);
        }
        
        $youtube[0] = $youtubeID;
        $youtube[1] ="http://img.youtube.com/vi/".$youtubeID."/0.jpg";
        $youtube[2] ="http://www.youtube.com/v/".$youtubeID;
        
        return $youtube;
    }
    
    public function resizeImage($imgUrl, $x=null, $y=null, $imagePath=null)
    {
        $x = Mage::getStoreConfig('mediaappearance/images/width');
        $y = Mage::getStoreConfig('mediaappearance/images/height');
        if ($x == null && $y == null) { 
            $x = 200;
            $y = 200;
        }
        
        $imgPath=$this->splitImageValue($imgUrl, "path");
        $imgName=$this->splitImageValue($imgUrl, "name");

        /**
         * Path with Directory Seperator
         */
        $imgPath=str_replace("/", DS, $imgPath);

        /**
         * Absolute full path of Image
         */
        
        $imgPathFull=Mage::getBaseDir("media").DS.$imgPath.DS.$imgName;
         

        /**
         * If Y is not set set it to as X
         */
        $width=$x;
        $y?$height=$y:$height=$x;

        /**
         * Resize folder is widthXheight
         */
        $resizeFolder=$width."X".$height;

        /**
         * Image resized path will then be
         */
         
        $imageResizedPath = Mage::getBaseDir("media").DS.$imgPath.DS.$resizeFolder.DS.$imgName;
        
        /**
         * First check in cache i.e image resized path
         * If not in cache then create image of the width=X and height = Y
         */
         
        $colorArray = array();

        $colorArray = explode(",", $color);
        //print_r($colorArray); exit();
        if (!file_exists($imageResizedPath) && file_exists($imgPathFull)) :
            
            $imageObj = new Varien_Image($imgPathFull);
            $imageObj->constrainOnly(true);
            $imageObj->keepAspectRatio(false);
            $imageObj->resize($width, $height);
            $imageObj->save($imageResizedPath);
        endif;

        /**
         * Else image is in cache replace the Image Path with / for http path.
         */
        $imgUrl=str_replace(DS, "/", $imgPath);

        /**
         * Return full http path of the image
         */
        return Mage::getBaseUrl("media").$imgUrl."/".$resizeFolder."/".$imgName;
    }
    
    public function recursiveReplace($search, $replace, $subject)
    {
        if (!is_array($subject)) {
            return $subject;
        }

        foreach ($subject as $key => $value) {
            if (is_string($value))
                $subject[$key] = str_replace($search, $replace, $value);
            elseif (is_array($value))
                $subject[$key] = self::recursiveReplace($search, $replace, $value);
        }

        return $subject;
    }
    
    public function getImageUrl($image_file)
    {
        $url = false;
        $url = Mage::getBaseUrl('media'). $image_file;
        return $url;
    }
    
    public function getFileExists($image_file)
    {
        $file_exists = false;
        $file_exists = file_exists(Mage::getBaseUrl('media'). $image_file);
        return $file_exists;
    }
    
    public function isMageVerAtLeast($version_str) 
    {
         $version_str_sections = explode('.', $version_str);
         $mage_version_sections = explode('.', Mage::getVersion());
        foreach ( $version_str_sections as $key => $value) { 
            if (!isset($mage_version_sections[$key])) break;
               
            if ($mage_version_sections[$key] > $value ) {
                return true;
            }
            if ($mage_version_sections[$key] < $value ) {
                return false;
            }
        }
         return true;    
    }

    public function video_info($url) 
    {
    
        // Handle Youtube
        if (strpos($url, "youtube.com")) {

            $data = $this->getYouTubeInfo($url);

            
        } // End Youtube
        
        // Handle Vimeo
        else if (strpos($url, "vimeo.com")) {
            $data = $this->getVimeoInfo($url);
        } // End Vimeo
        
        // Set false if invalid URL
        else { $data = false; 
        }
        
        return $data;
    
    }

    public function getYouTubeInfo($url)
    {
        $url = parse_url($url);
        $vid = parse_str($url['query'], $output);
        $video_id = $output['v'];
        $data['video_type'] = 'youtube';
        $data['video_id'] = $video_id;
        $xml = simplexml_load_file("http://gdata.youtube.com/feeds/api/videos?q=$video_id");
        
        foreach ($xml->entry as $entry) {
            // get nodes in media: namespace
            $media = $entry->children('http://search.yahoo.com/mrss/');
                
            // get video player URL
            $attrs = $media->group->player->attributes();
            $watch = $attrs['url']; 
                
            // get video thumbnail
            $data['thumb_1'] = $media->group->thumbnail[0]->attributes(); // Thumbnail 1
            $data['thumb_2'] = $media->group->thumbnail[1]->attributes(); // Thumbnail 2
            $data['thumb_3'] = $media->group->thumbnail[2]->attributes(); // Thumbnail 3
            $data['thumb_large'] = $media->group->thumbnail[3]->attributes(); // Large thumbnail
            $data['tags'] = $media->group->keywords; // Video Tags
            $data['cat'] = $media->group->category; // Video category
            $attrs = $media->group->thumbnail[0]->attributes();
            $thumbnail = $attrs['url']; 
                
            // get <yt:duration> node for video length
            $yt = $media->children('http://gdata.youtube.com/schemas/2007');
            $attrs = $yt->duration->attributes();
            $data['duration'] = $attrs['seconds'];
                
            // get <yt:stats> node for viewer statistics
            $yt = $entry->children('http://gdata.youtube.com/schemas/2007');
            $attrs = $yt->statistics->attributes();
            //$data['views'] = $viewCount = $attrs['viewCount']; 
            $data['title']=$entry->title;
            //$data['info']=$entry->content;
                
            // get <gd:rating> node for video ratings
            $gd = $entry->children('http://schemas.google.com/g/2005'); 
            if ($gd->rating) {
                $attrs = $gd->rating->attributes();
                $data['rating'] = $attrs['average']; 
            } else { $data['rating'] = 0;
            }
        } // End foreach
        return $data;
    }

    public function getVimeoInfo($url)
    {
        $video_id=explode('vimeo.com/', $url);
        $video_id=$video_id[1];
        $data['video_type'] = 'vimeo';
        $data['video_id'] = $video_id;
            
        /*$xml = simplexml_load_file("http://vimeo.com/api/v2/video/$video_id.xml");
				
        foreach ($xml->video as $video) {
        //$data['id']=$video->id;
        //$data['title']=$video->title;
        //$data['info']=$video->description;
        $data['url']=$video->url;
        //$data['upload_date']=$video->upload_date;
        $data['mobile_url']=$video->mobile_url;
        //$data['thumb_small']=$video->thumbnail_small;
        //$data['thumb_medium']=$video->thumbnail_medium;
        $data['thumb_large']=$video->thumbnail_large;
        //$data['user_name']=$video->user_name;
        //$data['urer_url']=$video->urer_url;
        //$data['user_thumb_small']=$video->user_portrait_small;
        //$data['user_thumb_medium']=$video->user_portrait_medium;
        //$data['user_thumb_large']=$video->user_portrait_large;
        //$data['user_thumb_huge']=$video->user_portrait_huge;
        //$data['likes']=$video->stats_number_of_likes;
        //$data['views']=$video->stats_number_of_plays;
        //$data['comments']=$video->stats_number_of_comments;
        //$data['duration']=$video->duration;
        //$data['width']=$video->width;
        //$data['height']=$video->height;
        //$data['tags']=$video->tags;
        } // End foreach*/
        return $data;
    }

    public function getResizedUrl($imgUrl,$x=100,$y=null,$color)
    {


        $imgPath=$this->splitImageValue($imgUrl, "path");
        $imgName=$this->splitImageValue($imgUrl, "name");

        /**
         * Path with Directory Seperator
         */
        $imgPath=str_replace("/", DS, $imgPath);

        /**
         * Absolute full path of Image
         */
        
        $imgPathFull=Mage::getBaseDir("media").DS.$imgPath.DS.$imgName;
         

        /**
         * If Y is not set set it to as X
         */
        $width=$x;
        $y?$height=$y:$height=$x;

        /**
         * Resize folder is widthXheight
         */
        $resizeFolder=$width."X".$height;

        /**
         * Image resized path will then be
         */
         
        $imageResizedPath = Mage::getBaseDir("media").DS.$imgPath.DS.$resizeFolder.DS.$imgName;
        
        /**
         * First check in cache i.e image resized path
         * If not in cache then create image of the width=X and height = Y
         */
         
        $colorArray = array();

        $colorArray = explode(",", $color);
        //print_r($colorArray); exit();
        if (!file_exists($imageResizedPath) && file_exists($imgPathFull)) :
            
            $imageObj = new Varien_Image($imgPathFull);
            $imageObj->constrainOnly(true);
            $imageObj->keepAspectRatio(true);
            $imageObj->keepFrame(true);
            $imageObj->keeptransparency(true);
            $imageObj->backgroundColor(array(intval($colorArray[0]),intval($colorArray[1]),intval($colorArray[2])));
            $imageObj->resize($width, $height);
            $imageObj->save($imageResizedPath);
        endif;

        /**
         * Else image is in cache replace the Image Path with / for http path.
         */
        $imgUrl=str_replace(DS, "/", $imgPath);

        /**
         * Return full http path of the image
         */
        return Mage::getBaseUrl("media").$imgUrl."/".$resizeFolder."/".$imgName;
    }

    // Function To Split the Image Path
    public function splitImageValue($imageValue,$attr="name")
    {
        $imArray=explode("/", $imageValue);

        $name=$imArray[count($imArray)-1];
        $path=implode("/", array_diff($imArray, array($name)));
        if ($attr=="path") {
            return $path;
        }
        else
        return $name;

    }

    //Function To Return Class For Image Or Local video
    public function is_image($path)
    {
        $a = getimagesize($path);
        $image_type = $a[2];

         
        if (in_array($image_type, array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP,13))) {
            return "fancybox";
        }
        else
        {
            return "jwVideo";
        }
        
    } 

    /*
     * Converts title to URL key according to URL standard
     * @param string @name title
     * @return string URL key
     */
    public function nameToUrlKey($name)
    {
        $_URL_ENCODED_CHARS = array(
            ' ', '+', '(', ')', ';', ':', '@', '&', '`', '\'',
            '=', '!', '$', ',', '/', '?', '#', '[', ']', '%',
        );

        $name = strtolower(trim($name));
        $name = str_replace($_URL_ENCODED_CHARS, '-', $name);
        do {
            $name = $newStr = str_replace('--', '-', $name, $count);
        } while($count);

        return $name;
    }


    public function getMediaGalleryProducts($productId)
    {
        $mediagallery_productsTable = Mage::getSingleton('core/resource')->getTableName('mediaappearance_products');
        $collection = Mage::getModel('mediaappearance/mediaappearance')->getCollection();

        $collection->getSelect()
            ->join(
                array('related' => $mediagallery_productsTable),
                'main_table.mediaappearance_id = related.mediaappearance_id'
            )
            ->order('main_table.mediaappearance_id');

        $collection->addFieldToFilter('related.product_id', $productId);

        
        return $collection->getData();
    }

    public function getProductVideos($pid)
    {
        $collection = Mage::getModel('mediaappearance/mediaappearance')->getCollection();

        $collection->addFieldToFilter('product_ids',array('finset'=>$pid));
        return $collection->getData();
    }

    public function getMediaBlock($blockidentifier)
    {
       return Mage::getModel('mediaappearance/videoblocks')->load($blockidentifier);
    }

    public function getMediaBlockCollection($blockid)
    {
    $blocksTable = Mage::getSingleton('core/resource')->getTableName('media_block_videos');
      $collection =  Mage::getModel('mediaappearance/mediaappearance')->getCollection();
      $collection->getSelect()
      ->join(array('related' => $blocksTable),
            'main_table.mediaappearance_id = related.mediaappearance_id AND related.media_block_id = '.$blockid.''
    );
      return $collection;

    }


    
}
