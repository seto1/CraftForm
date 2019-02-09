<?php 
class CraftFormFormsSchema extends CakeSchema {

	public $file = 'craft_form_forms.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $craft_form_forms = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
		'url' => array('type' => 'string', 'null' => true, 'default' => null),
		'title' => array('type' => 'string', 'null' => true, 'default' => null),
		'blueprint_input' => array('type' => 'text', 'null' => true, 'default' => null, 'comment' => '入力画面の構造データ'),
		'blueprint_admin_mail' => array('type' => 'text', 'null' => true, 'default' => null, 'comment' => '管理者あてに送信されるメール本文の構造データ'),
		'mail_title' => array('type' => 'string', 'null' => true, 'default' => null),
		'mail_to' => array('type' => 'string', 'null' => true, 'default' => null),
		'mail_cc' => array('type' => 'string', 'null' => true, 'default' => null),
		'mail_bcc' => array('type' => 'string', 'null' => true, 'default' => null),
		'mail_from' => array('type' => 'string', 'null' => true, 'default' => null),
		'mail_from_name' => array('type' => 'string', 'null' => true, 'default' => null),
		'form_rule' => array('type' => 'string', 'null' => true, 'default' => null),
		'message_success' => array('type' => 'string', 'null' => true, 'default' => null),
		'message_failed' => array('type' => 'string', 'null' => true, 'default' => null),
		'message_validation_error' => array('type' => 'string', 'null' => true, 'default' => null),
		'message_disabled' => array('type' => 'string', 'null' => true, 'default' => null),
		'status' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 1, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

}
