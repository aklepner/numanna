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

$resource = Mage::getSingleton('core/resource');
$read = $resource->getConnection('core_read');
$rs = $read->fetchAll('SHOW TABLES');
$catalog_eav_attribute_existed = false;
$sales_flat_order_existed = false;
foreach ($rs as $row) {
    foreach ($row as $k => $v) {
        if ($v == $this->getTable('catalog_eav_attribute')) {
            $catalog_eav_attribute_existed = true;
        }
        if ($v == $this->getTable('sales_flat_order')) {
            $sales_flat_order_existed = true;
        }
    }
}

$installer->run("
        
DROP TABLE IF EXISTS {$this->getTable('crm4ecommerce_zohosynchronization_queue')};
CREATE TABLE {$this->getTable('crm4ecommerce_zohosynchronization_queue')} (
  `queue_id` int(11) unsigned NOT NULL auto_increment,
  `type_data` smallint(5) NOT NULL default '0',
  `event` varchar(100) default NULL,
  `from_id` int(10) unsigned default NULL,
  `to_id` int(10) unsigned default NULL,
  `size` int(10) unsigned NOT NULL default '1',
  `current_id` int(10) unsigned default NULL,
  `created_time` datetime NULL,
  `start_time` datetime NULL,
  `end_time` datetime NULL,
  `status` tinyint(4) NOT NULL default '0',
  `log` text NOT NULL default '',
  PRIMARY KEY (`queue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE {$this->getTable('crm4ecommerce_zohosynchronization_log')}
    ADD `queue_id` int(11) unsigned default NULL;
    
ALTER TABLE {$this->getTable('sales_flat_quote')}
    ADD `potential_zoho_id` varchar(20) default '';

");

if ($sales_flat_order_existed) {
    $installer->run("

ALTER TABLE {$this->getTable('sales_flat_order')}
    ADD `potential_zoho_id` varchar(20) default '',
    ADD `guest_zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('sales_flat_order_grid')}
    ADD `potential_zoho_id` varchar(20) default '',
    ADD `guest_zoho_id` varchar(20) default '';

");
} else {
    $installer->run("

ALTER TABLE {$this->getTable('sales_order')}
    ADD `potential_zoho_id` varchar(20) default '',
    ADD `guest_zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('sales_order_entity')}
    ADD `potential_zoho_id` varchar(20) default '',
    ADD `guest_zoho_id` varchar(20) default '';

");
}

$installer->run("
    
DROP TABLE IF EXISTS {$this->getTable('crm4ecommerce_zohosynchronization_payment_attribute')};
CREATE TABLE {$this->getTable('crm4ecommerce_zohosynchronization_payment_attribute')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `payment_method` varchar(50) NOT NULL default '',
  `attribute_code` varchar(80) NOT NULL default '',
  `attribute_name` varchar(100) NOT NULL default '',
  `is_additional` tinyint(4) NOT NULL default 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->run("
        
INSERT INTO {$this->getTable('crm4ecommerce_zohosynchronization_payment_attribute')}
    (`payment_method`,`attribute_code`,`attribute_name`, `is_additional`) VALUES 
('purchaseorder', 'po_number', 'Purchase Order Number', 0),
('ccsave', 'cc_owner', 'Name on the Card', 0),
('ccsave', 'cc_type', 'Credit Card Type', 0),
('ccsave', 'cc_number', 'Credit Card Number', 0),
('ccsave', 'cc_expiration', 'Expiration Date', 0),
('paypal_standard', 'paypal_payer_id', 'Payer ID', 1),
('paypal_standard', 'paypal_payer_email', 'Payer Email', 1),
('paypal_standard', 'paypal_payer_status', 'Payer Status', 1),
('paypal_standard', 'paypal_protection_eligibility', 'Merchant Protection Eligibility', 1),
('paypal_standard', 'paypal_payment_status', 'Payment Status', 1),
('paypal_standard', 'last_trans_id', 'Last Transaction ID', 0);

"
);

$installer->endSetup();