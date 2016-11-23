<?php

$installer = $this;
$installer->startSetup();

//$installer->run("DROP TABLE `{$installer->getTable('transform_slideshow')}`");
$installer->run("
CREATE TABLE `{$installer->getTable('transform_slideshow')}` (
   `slide_id` int(10) unsigned NOT NULL auto_increment,
   `store_id` int(10) unsigned NOT NULL,
   `position` int(10) unsigned NOT NULL,
   `name` varchar(255) NOT NULL default '',
   `subtitle` varchar(255) NOT NULL default '',
   `content` text NOT NULL,
   `is_active` tinyint(4) NOT NULL default '0',
   `photo` varchar(255) NOT NULL default '',
   `link` varchar(255) NOT NULL default '',
   `link_title` varchar(255) NOT NULL default '',
    PRIMARY KEY  (`slide_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();
