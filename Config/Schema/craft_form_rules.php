<?php 
class CraftFormRulesSchema extends CakeSchema {

	public $file = 'craft_form_rules.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $craft_form_rules = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'type' => array('type' => 'string', 'null' => true, 'default' => null),
		'options' => array('type' => 'text', 'null' => true, 'default' => null),
		'message' => array('type' => 'text', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

}
