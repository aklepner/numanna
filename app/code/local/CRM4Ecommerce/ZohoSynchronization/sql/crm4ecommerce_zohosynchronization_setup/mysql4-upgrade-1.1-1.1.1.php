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

ALTER TABLE {$this->getTable('sales_flat_quote')}
    ADD `potential_name` varchar(100) default '',
    ADD `guest_zoho_id` varchar(20) default '',
    ADD `guest_billing_zoho_id` varchar(20) default '',
    ADD `zoho_product_ids` text default '';

ALTER TABLE {$this->getTable('sales_flat_order_status_history')}
    ADD `activity_zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('sales_flat_invoice')}
    ADD `activity_zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('sales_flat_invoice_grid')}
    ADD `activity_zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('sales_flat_invoice_comment')}
    ADD `activity_zoho_id` varchar(20) default '';
    
ALTER TABLE {$this->getTable('sales_flat_shipment')}
    ADD `activity_zoho_id` varchar(20) default '';
    
ALTER TABLE {$this->getTable('sales_flat_shipment_grid')}
    ADD `activity_zoho_id` varchar(20) default '';
    
ALTER TABLE {$this->getTable('sales_flat_shipment_comment')}
    ADD `activity_zoho_id` varchar(20) default '';
    
ALTER TABLE {$this->getTable('sales_flat_shipment_track')}
    ADD `activity_zoho_id` varchar(20) default '';
    
ALTER TABLE {$this->getTable('sales_flat_creditmemo')}
    ADD `activity_zoho_id` varchar(20) default '';
    
ALTER TABLE {$this->getTable('sales_flat_creditmemo_grid')}
    ADD `activity_zoho_id` varchar(20) default '';
    
ALTER TABLE {$this->getTable('sales_flat_creditmemo_comment')}
    ADD `activity_zoho_id` varchar(20) default '';

");

function getEntityTypeId($type_code) {
    $resource = Mage::getSingleton('core/resource');
    $read = $resource->getConnection('core_read');
    $select = $read->select('entity_type_id')->from($resource->getTableName('eav_entity_type'))->where('entity_type_code = ?', $type_code);
    $rs = $read->fetchAll($select);
    foreach ($rs as $row) {
        return $row['entity_type_id'];
    }
    return 0;
}

$quote_entity_type_id = getEntityTypeId('quote');
$quote_address_entity_type_id = getEntityTypeId('quote_address');
$order_entity_type_id = getEntityTypeId('order');
$order_status_history_entity_type_id = getEntityTypeId('order_status_history');
$invoice_entity_type_id = getEntityTypeId('invoice');
$invoice_comment_entity_type_id = getEntityTypeId('invoice_comment');
$shipment_entity_type_id = getEntityTypeId('shipment');
$shipment_comment_entity_type_id = getEntityTypeId('shipment_comment');
$creditmemo_entity_type_id = getEntityTypeId('creditmemo');
$creditmemo_comment_entity_type_id = getEntityTypeId('creditmemo_comment');

$installer->run("

UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Store View') . "' WHERE `attribute_code` = 'store_id' AND `entity_type_id` = {$quote_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Customer Ip') . "' WHERE `attribute_code` = 'remote_ip' AND `entity_type_id` = {$quote_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Coupon Code') . "' WHERE `attribute_code` = 'coupon_code' AND `entity_type_id` = {$quote_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Currency Code') . "' WHERE `attribute_code` = 'quote_currency_code' AND `entity_type_id` = {$quote_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Currency Rate (From Base Currency)') . "' WHERE `attribute_code` = 'base_to_quote_rate' AND `entity_type_id` = {$quote_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Checkout Method') . "' WHERE `attribute_code` = 'checkout_method' AND `entity_type_id` = {$quote_entity_type_id};
    
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Email') . "' WHERE `attribute_code` = 'email' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Prefix') . "' WHERE `attribute_code` = 'prefix' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('First Name') . "' WHERE `attribute_code` = 'firstname' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Middle Name') . "' WHERE `attribute_code` = 'middlename' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Last Name') . "' WHERE `attribute_code` = 'lastname' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Suffix') . "' WHERE `attribute_code` = 'suffix' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Company') . "' WHERE `attribute_code` = 'company' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Street') . "' WHERE `attribute_code` = 'street' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('City') . "' WHERE `attribute_code` = 'city' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('State/Province') . "' WHERE `attribute_code` = 'region' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Zip/Postal Code') . "' WHERE `attribute_code` = 'postcode' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Country') . "' WHERE `attribute_code` = 'country_id' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Telephone') . "' WHERE `attribute_code` = 'telephone' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Fax') . "' WHERE `attribute_code` = 'fax' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Shipping & Handling Method') . "' WHERE `attribute_code` = 'shipping_description' AND `entity_type_id` = {$quote_address_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Weight Amount') . "' WHERE `attribute_code` = 'weight' AND `entity_type_id` = {$quote_address_entity_type_id};

UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Order Status') . "' WHERE `attribute_code` = 'status' AND `entity_type_id` = {$order_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Store View') . "' WHERE `attribute_code` = 'store_id' AND `entity_type_id` = {$order_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Customer Ip') . "' WHERE `attribute_code` = 'remote_ip' AND `entity_type_id` = {$order_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Customer Group') . "' WHERE `attribute_code` = 'customer_group_id' AND `entity_type_id` = {$order_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Coupon Code') . "' WHERE `attribute_code` = 'coupon_code' AND `entity_type_id` = {$order_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Currency Code') . "' WHERE `attribute_code` = 'order_currency_code' AND `entity_type_id` = {$order_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Currency Rate (From Base Currency)') . "' WHERE `attribute_code` = 'base_to_order_rate' AND `entity_type_id` = {$order_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Total Paid') . "' WHERE `attribute_code` = 'base_total_paid' AND `entity_type_id` = {$order_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Total Refunded') . "' WHERE `attribute_code` = 'base_total_refunded' AND `entity_type_id` = {$order_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Total Due') . "' WHERE `attribute_code` = 'base_total_due' AND `entity_type_id` = {$order_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Shipping & Handling Method') . "' WHERE `attribute_code` = 'shipping_description' AND `entity_type_id` = {$order_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Shipping & Handling Fee') . "' WHERE `attribute_code` = 'base_shipping_amount' AND `entity_type_id` = {$order_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Total Refunded') . "' WHERE `attribute_code` = 'base_total_refunded' AND `entity_type_id` = {$order_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Weight Amount') . "' WHERE `attribute_code` = 'weight' AND `entity_type_id` = {$order_entity_type_id};

UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Invoice Status') . "' WHERE `attribute_code` = 'state' AND `entity_type_id` = {$invoice_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Store View') . "' WHERE `attribute_code` = 'store_id' AND `entity_type_id` = {$invoice_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Currency Code') . "' WHERE `attribute_code` = 'order_currency_code' AND `entity_type_id` = {$invoice_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Currency Rate (From Base Currency)') . "' WHERE `attribute_code` = 'base_to_order_rate' AND `entity_type_id` = {$invoice_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Shipping & Handling Fee') . "' WHERE `attribute_code` = 'base_shipping_amount' AND `entity_type_id` = {$invoice_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Email Sent') . "' WHERE `attribute_code` = 'email_sent' AND `entity_type_id` = {$invoice_entity_type_id};
    
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Comment') . "' WHERE `attribute_code` = 'comment' AND `entity_type_id` = {$order_status_history_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Is Customer Notified') . "' WHERE `attribute_code` = 'is_customer_notified' AND `entity_type_id` = {$order_status_history_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Order Status') . "' WHERE `attribute_code` = 'status' AND `entity_type_id` = {$order_status_history_entity_type_id};

UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Comment') . "' WHERE `attribute_code` = 'comment' AND `entity_type_id` = {$invoice_comment_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Is Customer Notified') . "' WHERE `attribute_code` = 'is_customer_notified' AND `entity_type_id` = {$invoice_comment_entity_type_id};
    
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Email Sent') . "' WHERE `attribute_code` = 'email_sent' AND `entity_type_id` = {$shipment_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Comment') . "' WHERE `attribute_code` = 'comment' AND `entity_type_id` = {$shipment_comment_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Is Customer Notified') . "' WHERE `attribute_code` = 'is_customer_notified' AND `entity_type_id` = {$shipment_comment_entity_type_id};
    
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Email Sent') . "' WHERE `attribute_code` = 'email_sent' AND `entity_type_id` = {$creditmemo_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Comment') . "' WHERE `attribute_code` = 'comment' AND `entity_type_id` = {$creditmemo_comment_entity_type_id};
UPDATE {$this->getTable('eav_attribute')} SET `frontend_label` = '" . Mage::helper('zohosynchronization')->__('Is Customer Notified') . "' WHERE `attribute_code` = 'is_customer_notified' AND `entity_type_id` = {$creditmemo_comment_entity_type_id};

");

Mage::getSingleton('core/config')->saveConfig(
        'crm4ecommerce_zohosynchronization/mapping_fields/logs/Events', 'Event Information@Event Owner,Event Owner,Lookup;Subject,Subject,Text;Start DateTime,Start DateTime,DateTime;End DateTime,End DateTime,DateTime;Venue,Venue,Text;Who Id,Contact Name,Lookup;What Id,Related To,Lookup;Send Notification Email,Send Notification Email,Boolean;Created By,Created By,OwnerLookup;Recurring Activity,Recurring Activity,Text;Modified By,Modified By,OwnerLookup@@Description Information@Description,Description,TextArea'
);

Mage::getSingleton('core/config')->saveConfig(
        'crm4ecommerce_zohosynchronization/mapping_fields/logs/Tasks', 'Task Information@Task Owner,Task Owner,Lookup;Subject,Subject,Text;Due Date,Due Date,Date;Who Id,Contact Name,Lookup;What Id,Related To,Lookup;Status,Status,Pick List;Priority,Priority,Pick List;Created By,Created By,OwnerLookup;Send Notification Email,Send Notification Email,Boolean;Modified By,Modified By,OwnerLookup;Recurring Activity,Recurring Activity,Text@@Description Information@Description,Description,TextArea'
);

$installer->run("
        
INSERT INTO {$this->getTable('crm4ecommerce_zohosynchronization_mapping_fields')}
    (`mapping_type`,`mapping_order`,`object_type`,`attribute_name`,`attribute_code`,`zoho_field`, `zoho_dv`, `zoho_data_type`, `zoho_default_value`) VALUES 
(9,1,'statuseshistory_info','Created At','created_at','Start DateTime','Start DateTime', 'DateTime', ''),
(9,2,'statuseshistory_info','Is Customer Notified','is_customer_notified','Send Notification Email','Send Notification Email', 'Boolean', ''),

(10,1,'statuseshistory_info','Created At','created_at','Start DateTime','Start DateTime', 'DateTime', ''),
(10,2,'statuseshistory_info','Email Sent','email_sent','Send Notification Email','Send Notification Email', 'Boolean', ''),

(11,1,'statuseshistory_info','Created At','created_at','Start DateTime','Start DateTime', 'DateTime', ''),
(11,2,'statuseshistory_info','Email Sent','email_sent','Send Notification Email','Send Notification Email', 'Boolean', ''),

(12,1,'statuseshistory_info','Created At','created_at','Start DateTime','Start DateTime', 'DateTime', ''),
(12,2,'statuseshistory_info','Email Sent','email_sent','Send Notification Email','Send Notification Email', 'Boolean', '');

"
);

$installer->run("
        
INSERT INTO {$this->getTable('crm4ecommerce_zohosynchronization_mapping_fields')}
    (`mapping_type`,`mapping_order`,`object_type`,`attribute_name`,`attribute_code`,`zoho_field`, `zoho_dv`, `zoho_data_type`, `zoho_default_value`) VALUES 
(13,1,'comment_info','Is Customer Notified','is_customer_notified','Send Notification Email','Send Notification Email', 'Boolean', ''),
(13,2,'comment_info','Comment','comment','Description','Description', 'TextArea', ''),

(14,1,'comment_info','Is Customer Notified','is_customer_notified','Send Notification Email','Send Notification Email', 'Boolean', ''),
(14,2,'comment_info','Comment','comment','Description','Description', 'TextArea', ''),

(15,1,'comment_info','Is Customer Notified','is_customer_notified','Send Notification Email','Send Notification Email', 'Boolean', ''),
(15,2,'comment_info','Comment','comment','Description','Description', 'TextArea', ''),
(15,2,'--none--',null,null,'Status','Status', 'Pick List', 'In Progress'),

(16,1,'comment_info','Is Customer Notified','is_customer_notified','Send Notification Email','Send Notification Email', 'Boolean', ''),
(16,2,'comment_info','Comment','comment','Description','Description', 'TextArea', ''),

(8,8,'potential_info','Quote / Order Details','quote_order_details','Description','Description', 'TextArea', '');

"
);

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

if ($sales_flat_order_existed) {
    $installer->run("

ALTER TABLE {$this->getTable('sales_flat_order')}
    ADD `billing_zoho_id` varchar(20) default '',
    ADD `shipping_zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('sales_flat_order_grid')}
    ADD `billing_zoho_id` varchar(20) default '',
    ADD `shipping_zoho_id` varchar(20) default '';

");
} else {
    $installer->run("

ALTER TABLE {$this->getTable('sales_order')}
    ADD `billing_zoho_id` varchar(20) default '',
    ADD `shipping_zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('sales_order_entity')}
    ADD `billing_zoho_id` varchar(20) default '',
    ADD `shipping_zoho_id` varchar(20) default '';

");
}

$installer->run("

ALTER TABLE {$this->getTable('catalogrule')}
	    	ADD `zoho_id` varchar(20) default '';

ALTER TABLE {$this->getTable('salesrule')}
	    	ADD `zoho_id` varchar(20) default '';

");

Mage::getSingleton('core/config')->saveConfig(
        'crm4ecommerce_zohosynchronization/mapping_fields/logs/Campaigns', 'Campaign Information@Campaign Owner,Campaign Owner,Lookup;Type,Type,Pick List;Campaign Name,Campaign Name,Text;Status,Status,Pick List;Start Date,Start Date,Date;End Date,End Date,Date;Expected Revenue,Expected Revenue,Currency;Budgeted Cost,Budgeted Cost,Currency;Actual Cost,Actual Cost,Currency;Expected Response,Expected Response,Integer;Num sent,Num sent,Integer;Created By,Created By,OwnerLookup;Modified By,Modified By,OwnerLookup@@Description Information@Description,Description,TextArea'
);

$installer->run("
        
INSERT INTO {$this->getTable('crm4ecommerce_zohosynchronization_mapping_fields')}
    (`mapping_type`,`mapping_order`,`object_type`,`attribute_name`,`attribute_code`,`zoho_field`, `zoho_dv`, `zoho_data_type`, `zoho_default_value`) VALUES 
(17,1,'rule_info','Description','description','Description','Description', 'TextArea', ''),
(17,2,'rule_info','Status','is_active','Status','Status', 'Pick List', ''),
(17,3,'rule_info','From Date','from_date','Start Date','Start Date', 'Date', ''),
(17,4,'rule_info','To Date','to_date','End Date','End Date', 'Date', ''),
(17,5,'--none--',null,null,'Type','Type', 'Pick List', 'Catalog Price Rule'),

(18,1,'rule_info','Description','description','Description','Description', 'TextArea', ''),
(18,2,'rule_info','Status','is_active','Status','Status', 'Pick List', ''),
(18,3,'rule_info','From Date','from_date','Start Date','Start Date', 'Date', ''),
(18,4,'rule_info','To Date','to_date','End Date','End Date', 'Date', ''),
(18,5,'--none--',null,null,'Type','Type', 'Pick List', 'Shopping Cart Price Rule');

"
);

$installer->endSetup();