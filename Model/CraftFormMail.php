<?php

class CraftFormMail extends AppModel {

	public $hasMany = [
		'CraftFormMailField' => [
			'className' => 'CraftForm.CraftFormMailField',
			'foreignKey' => 'mail_id',
			'dependent' => true,
		],
	];

}
