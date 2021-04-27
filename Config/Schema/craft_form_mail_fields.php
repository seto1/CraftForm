<?php
class CraftFormMailFieldsSchema extends CakeSchema {

	public $file = 'craft_form_mail_fields.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $craft_form_mail_fields = [
		'id' => [
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'unsigned' => false,
			'key' => 'primary'
		],
		'mail_id' => [
			'type' => 'integer',
			'null' => true,
			'default' => null,
			'unsigned' => false
		],
		'name' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'title' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'value' => [
			'type' => 'text',
			'null' => true,
			'default' => null
		],
		'order' => [
			'type' => 'integer',
			'null' => true,
			'default' => null,
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
