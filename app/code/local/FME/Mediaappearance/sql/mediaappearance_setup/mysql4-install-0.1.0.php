<?php

$installer = $this;

$installer->startSetup();

$installer->run(
    "

-- DROP TABLE IF EXISTS {$this->getTable('mediaappearance')};
CREATE TABLE IF NOT EXISTS  `{$this->getTable('mediaappearance')}` (                                  
   `mediaappearance_id` int(11) unsigned NOT NULL auto_increment,  
   `title` varchar(255) NOT NULL default '',                       
   `mediatype` smallint(6) default '0',                            
   `filename` varchar(255) NOT NULL default '',                    
   `filethumb` varchar(255) default '',                            
   `filethumbgrid` text,                                           
   `videourl` varchar(255) default '',                                                                   
   `product_ids` varchar(255) default NULL,                         
   `status` smallint(6) NOT NULL default '0', 
   `featured_video` smallint(6) default '0',                       
   `created_time` datetime default NULL,   
   `category_ids` text,
   `desp` text,
   `update_time` datetime default NULL,                            
   PRIMARY KEY  (`mediaappearance_id`)                             
 ) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('media_store')};
CREATE TABLE IF NOT EXISTS `{$this->getTable('media_store')}` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `mediaappearance_id` int(11) NOT NULL,                               
 `store_id` smallint(5) unsigned NOT NULL,                    
 PRIMARY KEY  (`id`),                      
 KEY `FK_MEDIAAPPEARANCE_STORE_STORE` (`store_id`)                    
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='FME Media Stores';

DROP TABLE IF EXISTS {$this->getTable('media_category_video')};
CREATE TABLE IF NOT EXISTS {$this->getTable('media_category_video')} (                                
  `mediaappearance_id` int(11) NOT NULL,                                   
  `category_id` smallint(5) unsigned NOT NULL,                     
  PRIMARY KEY  (`mediaappearance_id`,`category_id`),                       
  KEY `FK_CATEGORYBANNERS_CATEGORIES` (`category_id`)                      
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Video Categories';

DROP TABLE IF EXISTS {$this->getTable('media_blocks')};
CREATE TABLE IF NOT EXISTS  {$this->getTable('media_blocks')} ( 
	`media_block_id` int(11) NOT NULL auto_increment,      
	`block_title` varchar(255) default '',                 
	`block_identifier` varchar(255) default NULL,          
	`block_status` smallint(6) default '0',                
	`block_area` varchar(20) default 'main',               
	`block_content` text,                                  
	`related_media` text,                                  
	PRIMARY KEY  (`media_block_id`)                        
  ) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS {$this->getTable('media_block_videos')};
CREATE TABLE IF NOT EXISTS  {$this->getTable('media_block_videos')} (                       
  `media_block_id` int(11) NOT NULL,                         
  `mediaappearance_id` int(11) NOT NULL,                     
  PRIMARY KEY  (`media_block_id`,`mediaappearance_id`),      
  KEY `FK_CATEGORYBANNERS_CATEGORIES` (`media_block_id`)     
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS {$this->getTable('mediaappearance_products')};
CREATE TABLE IF NOT EXISTS  {$this->getTable('mediaappearance_products')} (
  `mediaappearance_id` int(11) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`mediaappearance_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


"
);

$installer->setConfigData('mediaappearance/general/enablemedia', '1');
$installer->setConfigData('mediaappearance/general/videooptions', '1');
$installer->setConfigData('mediaappearance/general/useyoutubethumb', '1');


$installer->setConfigData('mediaappearance/featuredblock/title', 'Featured Videos');


$installer->setConfigData('mediaappearance/videosblock/title', 'Videos');
$installer->setConfigData('mediaappearance/videosblock/right', '1');
$installer->setConfigData('mediaappearance/videosblock/left', '0');

$installer->setConfigData('mediaappearance/list/page_title', 'Media Appearance');
$installer->setConfigData('mediaappearance/list/identifier', 'all-media');
$installer->setConfigData('mediaappearance/list/items_per_page', '12');

$installer->setConfigData('mediaappearance/list/meta_keywords', 'Media Gallery');
$installer->setConfigData('mediaappearance/list/meta_description', 'Media Gallery');



$installer->setConfigData('mediaappearance/images/showurl', '0');
$installer->setConfigData('mediaappearance/images/showbydefault', '1');
$installer->setConfigData('mediaappearance/images/width', '200');
$installer->setConfigData('mediaappearance/images/height', '200');

$installer->setConfigData('mediaappearance/seo/url_suffix', '.html');


$installer->setConfigData('mediaappearance/popupsettings/width', '500');
$installer->setConfigData('mediaappearance/popupsettings/height', '600');
$installer->setConfigData('mediaappearance/popupsettings/autoplay', '1');



$installer->endSetup(); 
