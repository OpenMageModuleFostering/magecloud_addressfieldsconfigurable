<?php
$installer = $this;
$installer->startSetup();

$installer->run("
UPDATE {$this->getTable('eav_attribute')} SET is_required = 0 WHERE attribute_code = 'telephone';
UPDATE {$this->getTable('eav_attribute')} SET is_required = 0 WHERE attribute_code = 'region';
");
	
	
	
$installer->endSetup();