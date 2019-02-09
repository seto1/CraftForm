<?php 
class CraftFormMailFieldsSchema extends CakeSchema {

	public $file = 'craft_form_mail_fields.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $craft_form_mail_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'mail_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'name' => array('type' => 'string', 'null' => true, 'default' => null),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'value' => array('type' => 'text', 'null' => true, 'default' => null),
		'order' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

}
