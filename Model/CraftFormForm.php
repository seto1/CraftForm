<?php

class CraftFormForm extends AppModel {

	public $name = 'CraftFormForm';

	public $validate = [
		'title' => [
			[
				'rule' => ['notBlank'],
				'message' => '入力必須です。',
				'required' => true,
			],
		],
		'blueprint_input' => [
			[
				'rule' => ['notBlank'],
				'message' => '入力必須です。',
				'required' => true,
			],
		],
		'mail_title' => [
			[
				'rule' => ['notBlank'],
				'message' => '入力必須です。',
				'required' => true,
			],
		],
		'mail_to' => [
			[
				'rule' => ['emails'],
				'message' => 'メールアドレスの形式が不正です。',
				'allowEmpty' => true,
			],
		],
		'mail_cc' => [
			[
				'rule' => ['emails'],
				'message' => 'メールアドレスの形式が不正です。',
				'allowEmpty' => true,
			],
		],
		'mail_bcc' => [
			[
				'rule' => ['emails'],
				'message' => 'メールアドレスの形式が不正です。',
				'allowEmpty' => true,
			],
		],
		'mail_from' => [
			[
				'rule' => ['email'],
				'message' => 'メールアドレスの形式が不正です。',
				'allowEmpty' => true,
			],
		],
	];

}
