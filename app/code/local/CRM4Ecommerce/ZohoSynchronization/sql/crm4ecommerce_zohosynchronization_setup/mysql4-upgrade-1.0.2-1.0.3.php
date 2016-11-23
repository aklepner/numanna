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
        
ALTER TABLE {$this->getTable('crm4ecommerce_zohosynchronization_zoho_account')}
    ADD `authtoken` varchar(60) default '';

");

$installer->endSetup();