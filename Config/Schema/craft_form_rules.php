<?php
class CraftFormRulesSchema extends CakeSchema {

	public $file = 'craft_form_rules.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $craft_form_rules = [
		'id' => [
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'unsigned' => false,
			'key' => 'primary'
		],
		'title' => [
			'type' => 'string',
			'null' => false,
			'default' => null
		],
		'name' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'type' => [
			'type' => 'string',
			'null' => true,
			'default' => null
		],
		'options' => [
			'type' => 'text',
			'null' => true,
			'default' => null
		],
		'message' => [
			'type' => 'text',
			'null' => true,
			'default' => null
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
