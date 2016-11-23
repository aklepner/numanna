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
    
ALTER TABLE {$this->getTable('newsletter_subscriber')}
	    	ADD `zoho_id` varchar(20) default '';

INSERT INTO {$this->getTable('crm4ecommerce_zohosynchronization_mapping_fields')}
    (`mapping_type`,`mapping_order`,`object_type`,`attribute_name`,`attribute_code`,`zoho_field`, `zoho_dv`, `zoho_data_type`, `zoho_default_value`) VALUES 
    
(19,1,'subscriber_info','Subscriber Email','subscriber_email','Email','Email', 'Email', ''),
(19,2,'--none--',null,null,'Lead Source','Lead Source', 'Pick List', 'Web Research'),
(19,3,'--none--',null,null,'Company','Company', 'Text', '{{mail_name}}'),
(19,4,'--none--',null,null,'Last Name','Last Name', 'Text', '{{mail_name}}');

"
);

$installer->endSetup();