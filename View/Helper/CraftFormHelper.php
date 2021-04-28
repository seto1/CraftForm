<?php

class CraftFormHelper extends AppHelper {
	public $helpers = ['BcBaser'];
	public function getForm($id) {
		$obj = ClassRegistry::init('CraftForm.CraftFormForm');
		$form = $obj->find('first', [
			'conditions' => [
				'CraftFormForm.id' => $id,
				'CraftFormForm.status' => 1,
			],
		]);

		if (!$form) {
			return '';
		}

		$this->BcBaser->js(
			[
				'CraftForm.jquery.craftForm',
				'CraftForm.craft_form',
			],
			false
		);

//			$result = CraftFormUtil::converToArray($form);
		//exit;

		$result = CraftFormUtil::convertToForm($form);

		$result .= <<< EOF
<script>
$.craftForm.init({
	baseUrl: '{$this->request->base}',
	messageSuccess: "{$form['CraftFormForm']['message_success']}",
	messageFailed: "{$form['CraftFormForm']['message_failed']}",
	messageValidationError: "{$form['CraftFormForm']['message_validation_error']}",
	messageDisabled: "{$form['CraftFormForm']['message_disabled']}"
});
</script>
EOF;
		return $result;
	}

}
