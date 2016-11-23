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

ALTER TABLE {$this->getTable('customer_entity')}
	    	ADD `zoho_id` varchar(20) default '',
	    	ADD `zoho_markup` tinyint(1) default 0,
                ADD `zoho_type` varchar(10) default 'None',
                ADD `zoho_accountname` varchar(100) default '';

ALTER TABLE {$this->getTable('customer_address_entity')}
	    	ADD `zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('catalog_product_entity')}
	    	ADD `zoho_id` varchar(20) default '';

");

$installer->addAttribute('customer', 'zoho_id', array('type' => 'static', 'input' => 'text', 'visible' => false, 'required' => false));
$installer->addAttribute('customer', 'zoho_type', array('type' => 'static', 'input' => 'text', 'visible' => false, 'required' => false));
$installer->addAttribute('customer_address', 'zoho_id', array('type' => 'static', 'input' => 'text', 'visible' => false, 'required' => false));

$entityType = Mage::getModel('catalog/product')->getResource()->getEntityType();
$data = array(
    'entity_type_id' => $entityType->getId(),
    'attribute_code' => 'zoho_id',
    'backend_type' => 'static',
    'frontend_input' => 'text',
    'frontend_label' => 'Zoho Id'
);
$zohoIdAttribute = Mage::getModel('eav/entity_attribute')
        ->getCollection()
        ->addFieldToFilter('entity_type_id', $entityType->getId())
        ->addFieldToFilter('attribute_code', $data['attribute_code'])
        ->getFirstItem();

if (!intval($zohoIdAttribute->getId())) {
    $zohoIdAttribute->setData($data)
            ->save();
} else {
    $zohoIdAttribute->setBackendType($data['backend_type'])
            ->setFrontendInput($data['frontend_input'])
            ->setFrontendLabel($data['frontend_label'])
            ->save();
}

if ($catalog_eav_attribute_existed) {
    $installer->run("UPDATE {$this->getTable('catalog_eav_attribute')} SET is_global = 1, is_visible_in_advanced_search = 0 WHERE attribute_id = " . $zohoIdAttribute->getId());
} else {
    $installer->run("UPDATE {$this->getTable('eav_attribute')} SET is_global = 1, is_visible_in_advanced_search = 0 WHERE attribute_id = " . $zohoIdAttribute->getId());
}

if (file_exists(Mage::getBaseDir() . DS . 'app' . DS . 'code' . DS . 'core' . DS . 'Mage' . DS . 'Index' . DS . 'Model' . DS . 'Indexer.php')) {
    $process = Mage::getSingleton('index/indexer')->getProcessById(4);
    if ($process) {
        $process->reindexEverything();
    }
}

$installer->run("
    
DROP TABLE IF EXISTS {$this->getTable('crm4ecommerce_zohosynchronization_log')};
CREATE TABLE {$this->getTable('crm4ecommerce_zohosynchronization_log')} (
  `log_id` int(11) unsigned NOT NULL auto_increment,
  `type_data` smallint(5) NOT NULL default '0',
  `mode` tinyint(4) NOT NULL default '0',
  `action` varchar(20) NOT NULL default 'save',
  `from_id` int(10) unsigned default NULL,
  `to_id` int(10) unsigned default NULL,
  `number_success` int(10) unsigned NOT NULL default '1',
  `success_ids` text NOT NULL default '',
  `number_failure` int(10) unsigned NOT NULL default '1',
  `failure_ids` text NOT NULL default '',
  `website_id` smallint(5) NOT NULL default '0',
  `store_id` smallint(5) NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '0',
  `log` text NOT NULL default '',
  `start_time` datetime NULL,
  `log_time` datetime NULL,
  `log_in_time` double NOT NULL default '0',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('crm4ecommerce_zohosynchronization_mapping_fields')};
CREATE TABLE {$this->getTable('crm4ecommerce_zohosynchronization_mapping_fields')} (
  `mapping_id` int(10) unsigned NOT NULL auto_increment,
  `mapping_type` smallint(6) NOT NULL,
  `mapping_order` int(10) unsigned NOT NULL,
  `object_type` varchar(20) NOT NULL,
  `attribute_name` varchar(50) default NULL,
  `attribute_code` varchar(50) default NULL,
  `zoho_field` varchar(50) default NULL,
  `zoho_dv` varchar(50) default NULL,
  `zoho_data_type` varchar(25) default NULL,
  `zoho_default_value` varchar(100) default NULL,
  `zoho_using_default` tinyint(4) default '1',
  `status` tinyint(4) default '1',
  PRIMARY KEY  (`mapping_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

");

$installer->run("
        
INSERT INTO {$this->getTable('crm4ecommerce_zohosynchronization_mapping_fields')}
    (`mapping_type`,`mapping_order`,`object_type`,`attribute_name`,`attribute_code`,`zoho_field`, `zoho_dv`, `zoho_data_type`, `zoho_default_value`) VALUES 
(1,1,'customer_info','Status','status','Lead Status','Lead Status', 'Pick List', ''),
(1,2,'customer_info','Prefix','prefix','Salutation','Salutation', 'Text', ''),
(1,3,'customer_info','First Name','firstname','First Name','First Name', 'Text', ''),
(1,4,'customer_info','Last Name','lastname','Last Name','Last Name', 'Text', ''),
(1,5,'customer_info','Email','email','Email','Email', 'Email', ''),
(1,6,'customer_billing','Telephone','telephone','Phone','Phone', 'Phone', ''),
(1,7,'customer_billing','Fax','fax','Fax','Fax', 'Text', ''),
(1,8,'customer_billing','Street Address','street','Street','Street', 'Text', ''),
(1,9,'customer_billing','City','city','City','City', 'Text', ''),
(1,10,'customer_billing','State/Province','region','State','State', 'Text', ''),
(1,11,'customer_billing','Zip/Postal Code','postcode','Zip Code','Zip Code', 'Text', ''),
(1,12,'customer_billing','Country','country_id','Country','Country', 'Text', ''),
(1,13,'--none--',null,null,'Lead Source','Lead Source', 'Pick List', 'OnlineStore'),
(1,14,'--none--',null,null,'Industry','Industry', 'Pick List', 'Small/Medium Enterprise'),
(1,15,'--none--',null,null,'Email Opt Out','Email Opt Out', 'Boolean', 'true'),
(1,16,'--none--',null,null,'Rating','Rating', 'Pick List', 'Active'),

(2,1, 'customer_billing', 'Telephone', 'telephone', 'Phone', 'Phone', 'Phone', ''),
(2,2, 'customer_billing', 'Fax', 'fax', 'Fax', 'Fax', 'Text', ''),
(2,3, 'customer_info', 'Customer Group', 'group_id', 'Account Type', 'Account Type', 'Pick List', ''),
(2,4, 'customer_billing', 'Street Address', 'street', 'Billing Street', 'Billing Street', 'Text', ''),
(2,5, 'customer_billing', 'City', 'city', 'Billing City', 'Billing City', 'Text', ''),
(2,6, 'customer_billing', 'State/Province', 'region', 'Billing State', 'Billing State', 'Text', ''),
(2,7, 'customer_billing', 'Zip/Postal Code', 'postcode', 'Billing Code', 'Billing Code', 'Text', ''),
(2,8, 'customer_billing', 'Country', 'country_id', 'Billing Country', 'Billing Country', 'Text', ''),
(2,9, 'customer_shipping', 'Street Address', 'street', 'Shipping Street', 'Shipping Street', 'Text', ''),
(2,10, 'customer_shipping', 'City', 'city', 'Shipping City', 'Shipping City', 'Text', ''),
(2,11, 'customer_shipping', 'State/Province', 'region', 'Shipping State', 'Shipping State', 'Text', ''),
(2,12, 'customer_shipping', 'Zip/Postal Code', 'postcode', 'Shipping Code', 'Shipping Code', 'Text', ''),
(2,13, 'customer_shipping', 'Country', 'country_id', 'Shipping Country', 'Shipping Country', 'Text', ''),
(2,14,'--none--',null,null,'Industry','Industry', 'Pick List', 'Small/Medium Enterprise'),
(2,15,'--none--',null,null,'Ownership','Ownership', 'Pick List', 'Private'),

(3,1, 'address_info', 'Prefix', 'prefix', 'Salutation', 'Salutation', 'Text', ''),
(3,2, 'address_info', 'First Name', 'firstname', 'First Name', 'First Name', 'Text', ''),
(3,3, 'address_info', 'Last Name', 'lastname', 'Last Name', 'Last Name', 'Text', ''),
(3,4, 'address_info', 'Telephone', 'telephone', 'Phone', 'Phone', 'Phone', ''),
(3,5, 'address_info', 'Fax', 'fax', 'Fax', 'Fax', 'Text', ''),
(3,6, 'address_info', 'Street Address', 'street', 'Mailing Street', 'Mailing Street', 'Text', ''),
(3,7, 'address_info', 'City', 'city', 'Mailing City', 'Mailing City', 'Text', ''),
(3,8, 'address_info', 'State/Province', 'region', 'Mailing State', 'Mailing State', 'Text', ''),
(3,9, 'address_info', 'Zip/Postal Code', 'postcode', 'Mailing Zip', 'Mailing Zip', 'Text', ''),
(3,10, 'address_info', 'Country', 'country_id', 'Mailing Country', 'Mailing Country', 'Text', ''),
(3,11,'--none--',null,null,'Email Opt Out','Email Opt Out', 'Boolean', 'true'),

(4,1,'product_info', 'Name', 'name', 'Product Name', 'Product Name', 'Text', ''),
(4,2,'product_info', 'SKU', 'sku', 'Product Code', 'Product Code', 'Text', ''),
(4,3,'product_info', 'Status', 'status', 'Product Active', 'Product Active', 'Boolean', ''),
(4,4,'product_info', 'Manufacturer', 'manufacturer', 'Manufacturer', 'Manufacturer', 'Pick List', ''),
(4,5,'product_other', 'Product Category', 'category', 'Product Category', 'Product Category', 'Pick List', ''),
(4,6,'product_info', 'Set Product as New from Date', 'news_from_date', 'Sales Start Date', 'Sales Start Date', 'Date', ''),
(4,7,'product_info', 'Price', 'price', 'Unit Price', 'Unit Price', 'Currency', ''),
(4,8,'product_info', 'Tax Class', 'tax_class_id', 'Tax', 'Tax', 'Multiselect Pick List', ''),
(4,9,'product_stock', 'Quantity', 'qty', 'Qty in Stock', 'Qty in Stock', 'Double', ''),
(4,10,'product_info', 'Description', 'description', 'Description', 'Description', 'TextArea', ''),
(4,11,'--none--',null,null,'Usage Unit','Usage Unit', 'Pick List', 'Each'),
(4,12,'product_stock', 'Qty in Demand', 'qty_in_demand', 'Qty in Demand', 'Qty in Demand', 'Double', '');

"
);

$installer->run("

ALTER TABLE {$this->getTable('sales_flat_quote')}
    ADD `zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('sales_flat_quote_item')}
    ADD `zoho_list_price` decimal(12,4) default 0.0000;

");

$installer->run("
        
INSERT INTO {$this->getTable('crm4ecommerce_zohosynchronization_mapping_fields')}
    (`mapping_type`,`mapping_order`,`object_type`,`attribute_name`,`attribute_code`,`zoho_field`, `zoho_dv`, `zoho_data_type`, `zoho_default_value`) VALUES 
(5,1,'quote_info','Status','status','Quote Stage','Quote Stage', 'Pick List', ''),
(5,2,'quote_bill','Street','street','Billing Street','Billing Street', 'Text', ''),
(5,3,'quote_bill','City','city','Billing City','Billing City', 'Text', ''),
(5,4,'quote_bill','State/Province','region','Billing State','Billing State', 'Text', ''),
(5,5,'quote_bill','Zip/Postal Code','postcode','Billing Code','Billing Code', 'Text', ''),
(5,6,'quote_bill','Country','country_id','Billing Country','Billing Country', 'Text', ''),
(5,7,'quote_ship','Street','street','Shipping Street','Shipping Street', 'Text', ''),
(5,8,'quote_ship','City','city','Shipping City','Shipping City', 'Text', ''),
(5,9,'quote_ship','State/Province','region','Shipping State','Shipping State', 'Text', ''),
(5,10,'quote_ship','Zip/Postal Code','postcode','Shipping Code','Shipping Code', 'Text', ''),
(5,11,'quote_ship','Country','country_id','Shipping Country','Shipping Country', 'Text', '')

"
);

if ($sales_flat_order_existed) {
    $installer->run("

ALTER TABLE {$this->getTable('sales_flat_order')}
    ADD `zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('sales_flat_order_grid')}
    ADD `zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('sales_flat_invoice')}
    ADD `zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('sales_flat_invoice_grid')}
    ADD `zoho_id` varchar(20) default '';

");
} else {
    $installer->run("

ALTER TABLE {$this->getTable('sales_order')}
    ADD `zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('sales_order_entity')}
    ADD `zoho_id` varchar(20) default '';

");
}

$installer->addAttribute('order', 'zoho_id', array('type' => 'static', 'input' => 'text'));
$installer->addAttribute('invoice', 'zoho_id', array('type' => 'static', 'input' => 'text'));

$installer->run("
        
INSERT INTO {$this->getTable('crm4ecommerce_zohosynchronization_mapping_fields')}
    (`mapping_type`,`mapping_order`,`object_type`,`attribute_name`,`attribute_code`,`zoho_field`, `zoho_dv`, `zoho_data_type`, `zoho_default_value`) VALUES 
(6,1,'order_info','Order Status','status','Status','Status', 'Pick List', ''),
(6,2,'order_bill','Street','street','Billing Street','Billing Street', 'Text', ''),
(6,3,'order_bill','City','city','Billing City','Billing City', 'Text', ''),
(6,4,'order_bill','State/Province','region','Billing State','Billing State', 'Text', ''),
(6,5,'order_bill','Zip/Postal Code','postcode','Billing Code','Billing Code', 'Text', ''),
(6,6,'order_bill','Country','country_id','Billing Country','Billing Country', 'Text', ''),
(6,7,'order_ship','Street','street','Shipping Street','Shipping Street', 'Text', ''),
(6,8,'order_ship','City','city','Shipping City','Shipping City', 'Text', ''),
(6,9,'order_ship','State/Province','region_id','Shipping State','Shipping State', 'Text', ''),
(6,10,'order_ship','Zip/Postal Code','postcode','Shipping Code','Shipping Code', 'Text', ''),
(6,11,'order_ship','Country','country_id','Shipping Country','Shipping Country', 'Text', ''),

(7,1,'invoice_info','Invoice Status','state','Status','Status', 'Pick List', ''),
(7,2,'invoice_bill','Street','street','Billing Street','Billing Street', 'Text', ''),
(7,3,'invoice_bill','City','city','Billing City','Billing City', 'Text', ''),
(7,4,'invoice_bill','State/Province','region','Billing State','Billing State', 'Text', ''),
(7,5,'invoice_bill','Zip/Postal Code','postcode','Billing Code','Billing Code', 'Text', ''),
(7,6,'invoice_bill','Country','country_id','Billing Country','Billing Country', 'Text', ''),
(7,7,'invoice_ship','Street','street','Shipping Street','Shipping Street', 'Text', ''),
(7,8,'invoice_ship','City','city','Shipping City','Shipping City', 'Text', ''),
(7,9,'invoice_ship','State/Province','region_id','Shipping State','Shipping State', 'Text', ''),
(7,10,'invoice_ship','Zip/Postal Code','postcode','Shipping Code','Shipping Code', 'Text', ''),
(7,11,'invoice_ship','Country','country_id','Shipping Country','Shipping Country', 'Text', ''),

(8,1,'potential_info','Stage','stage','Stage','Stage', 'Pick List', ''),
(8,2,'potential_info','Type','type','Type','Type', 'Pick List', ''),
(8,3,'potential_info','Probability','probability','Probability','Probability (%)', 'Integer', ''),
(8,4,'potential_info','Next Step','next_step','Next Step','Next Step', 'Text', ''),
(8,5,'potential_info','Amount','amount','Amount','Amount', 'Currency', ''),
(8,6,'potential_info','Closing Date','closing_date','Closing Date','Closing Date', 'Date', ''),
(8,7,'potential_info','Quote / Order Details','quote_order_details','Description','Description', 'TextArea', ''),
(8,8,'--none--',null,null,'Lead Source','Lead Source', 'Pick List', 'OnlineStore');

"
);

$installer->endSetup();