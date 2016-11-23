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
    
DROP TABLE IF EXISTS {$this->getTable('crm4ecommerce_zohosynchronization_zoho_account')};
CREATE TABLE {$this->getTable('crm4ecommerce_zohosynchronization_zoho_account')} (
  `account_id` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `sort_order` int(10) unsigned NOT NULL,
  `is_current` tinyint(4) NOT NULL default '0',
  `status` tinyint(4) NOT NULL default '0',
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE {$this->getTable('customer_entity')} DROP COLUMN `zoho_markup`;

");

Mage::getSingleton('core/config')->saveConfig(
        'crm4ecommerce_zohosynchronization/mapping_fields/logs/Accounts', 'Account Information@Account Owner,Account Owner,Lookup;Rating,Rating,Pick List;Account Name,Account Name,Text;Phone,Phone,Phone;Account Site,Account Site,Text;Fax,Fax,Text;Parent Account,Parent Account,Lookup;Website,Website,Website;Account Number,Account Number,Integer;Ticker Symbol,Ticker Symbol,Text;Account Type,Account Type,Pick List;Ownership,Ownership,Pick List;Industry,Industry,Pick List;Employees,Employees,Integer;Annual Revenue,Annual Revenue,Currency;SIC Code,SIC Code,Integer;Created By,Created By,OwnerLookup;Modified By,Modified By,OwnerLookup@@Address Information@Billing Street,Billing Street,Text;Shipping Street,Shipping Street,Text;Billing City,Billing City,Text;Shipping City,Shipping City,Text;Billing State,Billing State,Text;Shipping State,Shipping State,Text;Billing Code,Billing Code,Text;Shipping Code,Shipping Code,Text;Billing Country,Billing Country,Text;Shipping Country,Shipping Country,Text@@Description Information@Description,Description,TextArea'
);

Mage::getSingleton('core/config')->saveConfig(
        'crm4ecommerce_zohosynchronization/mapping_fields/logs/Contacts', 'Contact Information@Contact Owner,Contact Owner,Lookup;Lead Source,Lead Source,Pick List;First Name,First Name,Text;Last Name,Last Name,Text;Account Name,Account Name,Lookup;Vendor Name,Vendor Name,Lookup;Email,Email,Email;Title,Title,Text;Department,Department,Text;Phone,Phone,Phone;Home Phone,Home Phone,Phone;Other Phone,Other Phone,Phone;Fax,Fax,Text;Mobile,Mobile,Phone;Date of Birth,Date of Birth,Date;Assistant,Assistant,Text;Asst Phone,Asst Phone,Phone;Reports To,Reports To,Text;Email Opt Out,Email Opt Out,Boolean;Created By,Created By,OwnerLookup;Skype ID,Skype ID,Text;Modified By,Modified By,OwnerLookup;Add to QuickBooks,Add to QuickBooks,Boolean;Secondary Email,Secondary Email,Email@@Address Information@Mailing Street,Mailing Street,Text;Other Street,Other Street,Text;Mailing City,Mailing City,Text;Other City,Other City,Text;Mailing State,Mailing State,Text;Other State,Other State,Text;Mailing Zip,Mailing Zip,Text;Other Zip,Other Zip,Text;Mailing Country,Mailing Country,Text;Other Country,Other Country,Text@@Description Information@Description,Description,TextArea'
);

Mage::getSingleton('core/config')->saveConfig(
        'crm4ecommerce_zohosynchronization/mapping_fields/logs/Leads', 'Lead Information@Lead Owner,Lead Owner,Lookup;Company,Company,Text;First Name,First Name,Text;Last Name,Last Name,Text;Designation,Title,Text;Email,Email,Email;Phone,Phone,Phone;Fax,Fax,Text;Mobile,Mobile,Phone;Website,Website,Website;Lead Source,Lead Source,Pick List;Lead Status,Lead Status,Pick List;Industry,Industry,Pick List;No of Employees,No of Employees,Integer;Annual Revenue,Annual Revenue,Currency;Rating,Rating,Pick List;Created By,Created By,OwnerLookup;Email Opt Out,Email Opt Out,Boolean;Skype ID,Skype ID,Text;Modified By,Modified By,OwnerLookup;Secondary Email,Secondary Email,Email@@Address Information@Street,Street,Text;City,City,Text;State,State,Text;Zip Code,Zip Code,Text;Country,Country,Text@@Description Information@Description,Description,TextArea'
);

Mage::getSingleton('core/config')->saveConfig(
        'crm4ecommerce_zohosynchronization/mapping_fields/logs/Potentials', 'Potential Information@Potential Owner,Potential Owner,Lookup;Amount,Amount,Currency;Potential Name,Potential Name,Text;Closing Date,Closing Date,Date;Account Name,Account Name,Lookup;Stage,Stage,Pick List;Type,Type,Pick List;Probability,Probability (%),Integer;Next Step,Next Step,Text;Expected Revenue,Expected Revenue,Currency;Lead Source,Lead Source,Pick List;Campaign Source,Campaign Source,Lookup;Contact Name,Contact Name,Lookup;Created By,Created By,OwnerLookup;Modified By,Modified By,OwnerLookup@@Description Information@Description,Description,TextArea'
);

Mage::getSingleton('core/config')->saveConfig(
        'crm4ecommerce_zohosynchronization/mapping_fields/logs/Products', 'Product Information@Product Owner,Product Owner,Lookup;Product Name,Product Name,Text;Product Code,Product Code,Text;Vendor Name,Vendor Name,Lookup;Product Active,Product Active,Boolean;Manufacturer,Manufacturer,Pick List;Product Category,Product Category,Pick List;Sales Start Date,Sales Start Date,Date;Sales End Date,Sales End Date,Date;Support Start Date,Support Start Date,Date;Support Expiry Date,Support Expiry Date,Date;Created By,Created By,OwnerLookup;Modified By,Modified By,OwnerLookup@@Price Information@Unit Price,Unit Price,Currency;Commission Rate,Commission Rate,Currency;Tax,Tax,Multiselect Pick List;Taxable,Taxable,Boolean@@Stock Information@Usage Unit,Usage Unit,Pick List;Qty Ordered,Qty Ordered,Double;Qty in Stock,Qty in Stock,Double;Reorder Level,Reorder Level,Double;Handler,Handler,Lookup;Qty in Demand,Qty in Demand,Double@@Description Information@Description,Description,TextArea'
);

Mage::getSingleton('core/config')->saveConfig(
        'crm4ecommerce_zohosynchronization/mapping_fields/logs/Quotes', 'Quote Information@Quote Owner,Quote Owner,Lookup;Subject,Subject,Text;Potential Name,Potential Name,Lookup;Quote Stage,Quote Stage,Pick List;Valid Till,Valid Till,Date;Team,Team,Text;Contact Name,Contact Name,Lookup;Carrier,Carrier,Pick List;Account Name,Account Name,Lookup;Created By,Created By,OwnerLookup;Modified By,Modified By,OwnerLookup@@Address Information@Billing Street,Billing Street,Text;Shipping Street,Shipping Street,Text;Billing City,Billing City,Text;Shipping City,Shipping City,Text;Billing State,Billing State,Text;Shipping State,Shipping State,Text;Billing Code,Billing Code,Text;Shipping Code,Shipping Code,Text;Billing Country,Billing Country,Text;Shipping Country,Shipping Country,Text@@Product Details@Product Details,Product Details,Text@@Terms and Conditions@Terms and Conditions,Terms and Conditions,TextArea@@Description Information@Description,Description,TextArea'
);

Mage::getSingleton('core/config')->saveConfig(
        'crm4ecommerce_zohosynchronization/mapping_fields/logs/SalesOrders', 'Sales Order Information@Sales Order Owner,Sales Order Owner,Lookup;Subject,Subject,Text;Potential Name,Potential Name,Lookup;Customer No,Customer No,Text;Purchase Order,Purchase Order,Text;Quote Name,Quote Name,Lookup;Due Date,Due Date,Date;Pending,Pending,Text;Contact Name,Contact Name,Lookup;Carrier,Carrier,Pick List;Excise Duty,Excise Duty,Currency;Sales Commission,Sales Commission,Currency;Status,Status,Pick List;Account Name,Account Name,Lookup;Created By,Created By,OwnerLookup;Modified By,Modified By,OwnerLookup@@Address Information@Billing Street,Billing Street,Text;Shipping Street,Shipping Street,Text;Billing City,Billing City,Text;Shipping City,Shipping City,Text;Billing State,Billing State,Text;Shipping State,Shipping State,Text;Billing Code,Billing Code,Text;Shipping Code,Shipping Code,Text;Billing Country,Billing Country,Text;Shipping Country,Shipping Country,Text@@Product Details@Product Details,Product Details,Text@@Terms and Conditions@Terms and Conditions,Terms and Conditions,TextArea@@Description Information@Description,Description,TextArea'
);

Mage::getSingleton('core/config')->saveConfig(
        'crm4ecommerce_zohosynchronization/mapping_fields/logs/Invoices', 'Invoice Information@Invoice Owner,Invoice Owner,Lookup;Subject,Subject,Text;Sales Order,Sales Order,Lookup;Invoice Date,Invoice Date,Date;Purchase Order,Purchase Order,Text;Due Date,Due Date,Date;Excise Duty,Excise Duty,Currency;Sales Commission,Sales Commission,Currency;Status,Status,Pick List;Account Name,Account Name,Lookup;Created By,Created By,OwnerLookup;Contact Name,Contact Name,Lookup;Modified By,Modified By,OwnerLookup@@Address Information@Billing Street,Billing Street,Text;Shipping Street,Shipping Street,Text;Billing City,Billing City,Text;Shipping City,Shipping City,Text;Billing State,Billing State,Text;Shipping State,Shipping State,Text;Billing Code,Billing Code,Text;Shipping Code,Shipping Code,Text;Billing Country,Billing Country,Text;Shipping Country,Shipping Country,Text@@Product Details@Product Details,Product Details,Text@@Terms and Conditions@Terms and Conditions,Terms and Conditions,TextArea@@Description Information@Description,Description,TextArea'
);

$product_default_attribute_set = '';
$product_attribute_sets = Mage::getModel('zohosynchronization/array_getListAttributeSets')->toOptionArray();
foreach ($product_attribute_sets as $attribute_set) {
    if ($product_default_attribute_set == '') {
        $product_default_attribute_set = $attribute_set['value'];
    }
    if ($attribute_set['label'] == Mage::helper('zohosynchronization')->__('Default')) {
        $product_default_attribute_set = $attribute_set['value'];
        break;
    }
}
Mage::getSingleton('core/config')->saveConfig(
        'crm4ecommerce_zohosynchronization/params/default_attribute_set', $product_default_attribute_set
);

Mage::getSingleton('core/config')->saveConfig(
        'crm4ecommerce_zohosynchronization/params/service_default_attribute_set', $product_default_attribute_set
);

$installer->run("
        
ALTER TABLE {$this->getTable('customer_entity')}
    ADD `zoho_logintime` datetime default NULL,
    ADD `zoho_logouttime` datetime default NULL,
    ADD `zoho_numberlogin` int(10) unsigned default 0,
    ADD `zoho_ip` varchar(30) default '';

");

$installer->addAttribute('customer', 'zoho_logintime', array('type' => 'static', 'input' => 'datetime', 'visible' => false, 'required' => false));
$installer->addAttribute('customer', 'zoho_logouttime', array('type' => 'static', 'input' => 'datetime', 'visible' => false, 'required' => false));
$installer->addAttribute('customer', 'zoho_numberlogin', array('type' => 'static', 'input' => 'number', 'visible' => false, 'required' => false));
$installer->addAttribute('customer', 'zoho_ip', array('type' => 'static', 'input' => 'text', 'visible' => false, 'required' => false));

$zohoIdAttribute = Mage::getModel('eav/entity_attribute')
        ->getCollection()
        ->addFieldToFilter('attribute_code', 'zoho_logintime')
        ->getFirstItem();
$zohoIdAttribute->setFrontendLabel('Last login time')
            ->save();

$zohoIdAttribute = Mage::getModel('eav/entity_attribute')
        ->getCollection()
        ->addFieldToFilter('attribute_code', 'zoho_logouttime')
        ->getFirstItem();
$zohoIdAttribute->setFrontendLabel('Last logout time')
            ->save();

$zohoIdAttribute = Mage::getModel('eav/entity_attribute')
        ->getCollection()
        ->addFieldToFilter('attribute_code', 'zoho_numberlogin')
        ->getFirstItem();
$zohoIdAttribute->setFrontendLabel('Number login')
            ->save();

$zohoIdAttribute = Mage::getModel('eav/entity_attribute')
        ->getCollection()
        ->addFieldToFilter('attribute_code', 'zoho_ip')
        ->getFirstItem();
$zohoIdAttribute->setFrontendLabel('Customer Ip')
            ->save();

$installer->endSetup();