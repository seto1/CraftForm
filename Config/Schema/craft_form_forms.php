<?php
class CraftFormFormsSchema extends CakeSchema {

	public $file = 'craft_form_forms.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $craft_form_forms = [
		'id' => [
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'unsigned' => false,
			'key' => 'primary',
			'comment' => 'ID'
		],
		'url' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'title' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'blueprint_input' => [
			'type' => 'text',
			'null' => true,
			'default' => null,
			'comment' => '入力画面の構造データ'
		],
		'blueprint_admin_mail' => [
			'type' => 'text',
			'null' => true,
			'default' => null,
			'comment' => '管理者あてに送信されるメール本文の構造データ'
		],
		'mail_title' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'mail_to' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'mail_cc' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'mail_bcc' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'mail_from' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'mail_from_name' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'form_rule' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'message_success' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'message_failed' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'message_validation_error' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'message_disabled' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'status' => [
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'length' => 1,
			'unsigned' => false
		],
		'created' => [
			'type' => 'datetime',
			'null' => true,
			'default' => null
		],
		'modified' => [
			'type' => 'datetime',
			'null' => true,
			'default' => null
		],
		'indexes' => [
			'PRIMARY' => ['column' => 'id', 'unique' => 1]
		],
		'tableParameters' => [
			'charset' => 'utf8',
			'collate' => 'utf8_general_ci',
			'engine' => 'InnoDB'
		]
	];
}
