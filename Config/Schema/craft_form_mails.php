<?php 
class CraftFormMailsSchema extends CakeSchema {

	public $file = 'craft_form_mails.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $craft_form_mails = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'ID'),
		'form_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'form_url' => array('type' => 'string', 'null' => false, 'default' => null),
		'ip' => array('type' => 'string', 'null' => false, 'default' => null, 'comment' => '送信者のIPアドレス'),
		'user_agent' => array('type' => 'text', 'null' => false, 'default' => null, 'comment' => '送信者のユーザーエージェント'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

}
