<?php

/**
 * 
 * @category   CRM4Ecommerce
 * @package    CRM4Ecommerce_ZohoSynchronization
 * @author     Philip Nguyen <philip@crm4ecommerce.com>
 * @link       http://crm4ecommerce.com
 */

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('crm4ecommerce_zohosynchronization_mapping_currencies')};
CREATE TABLE {$this->getTable('crm4ecommerce_zohosynchronization_mapping_currencies')} (
  `mapping_id` int(10) unsigned NOT NULL auto_increment,
  `currency_code` varchar(5) NOT NULL,
  `zoho_currency_name` varchar(50) default NULL,
  `zoho_currency_code` varchar(5) NOT NULL,
  `status` tinyint(4) default '1',
  PRIMARY KEY  (`mapping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup();