<?php
class CraftFormMailsSchema extends CakeSchema {

	public $file = 'craft_form_mails.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $craft_form_mails = [
		'id' => [
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'unsigned' => false,
			'key' => 'primary',
			'comment' => 'ID'
		],
		'form_id' => [
			'type' => 'integer',
			'null' => false,
			'default' => null,
			'unsigned' => false
		],
		'form_url' => [
			'type' => 'string',
			'null' => false,
			'default' => null
		],
		'ip' => [
			'type' => 'string',
			'null' => false,
			'default' => null,
			'comment' => '送信者のIPアドレス'
		],
		'user_agent' => [
			'type' => 'text',
			'null' => false,
			'default' => null,
			'comment' => '送信者のユーザーエージェント'
		],
		'created' => [
			'type' => 'datetime',
			'null' => false,
			'default' => null
		],
		'modified' => [
			'type' => 'datetime',
			'null' => false,
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
