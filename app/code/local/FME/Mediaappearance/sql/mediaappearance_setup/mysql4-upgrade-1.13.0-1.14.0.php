<?php

$installer = $this;

$installer->startSetup();

$installer->run(
    "ALTER TABLE `{$this->getTable('mediaappearance')}` MODIFY COLUMN `product_ids` TEXT;
"
);




$installer->endSetup(); 
