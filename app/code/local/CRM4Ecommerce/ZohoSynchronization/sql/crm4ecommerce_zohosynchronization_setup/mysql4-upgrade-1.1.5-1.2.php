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
    
ALTER TABLE {$this->getTable('sales_flat_quote_item')}
    ADD `zoho_pricebook_discount` decimal(12,4) default 0.0000;
                
ALTER TABLE {$this->getTable('sales_flat_order_item')}
    ADD `zoho_pricebook_discount` decimal(12,4) default 0.0000;
    
ALTER TABLE {$this->getTable('sales_flat_invoice_item')}
    ADD `zoho_pricebook_discount` decimal(12,4) default 0.0000;

"
);

$installer->endSetup();