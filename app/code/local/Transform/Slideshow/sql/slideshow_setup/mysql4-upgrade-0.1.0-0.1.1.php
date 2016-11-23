<?php
$installer = $this;
$installer->startSetup();

$installer->run("ALTER TABLE `{$installer->getTable('transform_slideshow')}` ADD `show_homepage` TINYINT UNSIGNED NOT NULL DEFAULT 0");
$installer->run("ALTER TABLE `{$installer->getTable('transform_slideshow')}` ADD `show_home` TINYINT UNSIGNED NOT NULL DEFAULT 0");
$installer->run("ALTER TABLE `{$installer->getTable('transform_slideshow')}` ADD `show_retail` TINYINT UNSIGNED NOT NULL DEFAULT 0");
$installer->run("ALTER TABLE `{$installer->getTable('transform_slideshow')}` ADD `show_business` TINYINT UNSIGNED NOT NULL DEFAULT 0");

$installer->endSetup();