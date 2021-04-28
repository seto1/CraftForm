<?php
class CraftFormUtil {
	static public function convertToForm($form) {
		$formId = $form['CraftFormForm']['id'];

		App::uses('BcFormHelper', 'View/Helper');
		$BcForm = new BcFormHelper(new View());

		$formData = $BcForm->create('CraftForm' . $formId, [
			'id' => 'CraftForm_' . $formId,
			'url' => [
				'plugin' => 'craft_form',
				'controller' => 'craft_forms',
				'action' => 'submit'
			],
		]);

		$formData .= preg_replace_callback(
			'/\[[\w-]+.*]/',
			function ($match) use ($BcForm) {
				preg_match('/\A\[([\w-]+)/i', $match[0], $matchFieldType);
				if (! $matchFieldType) {
					return false;
				}

				preg_match_all('/ ([\w-]+)="([^"]+)"/i', $match[0], $matchFieldAttributes, PREG_SET_ORDER);
				$attributes = [];
				foreach ($matchFieldAttributes as $matchFieldAttribute) {
					$attributes[$matchFieldAttribute[1]] = $matchFieldAttribute[2];
				}

				$attributes['type'] = $matchFieldType[1];

				$fieldName = null;
				if (! empty($attributes['name'])) {
					$fieldName = $attributes['name'];
				} elseif ($attributes['type'] !== 'submit') {
					return $match[0];
				}
				unset($attributes['name'], $attributes['rule']);
				if (empty($attributes['div'])) {
					$attributes['div'] = false;
				}

				if (empty($attributes['class'])) {
					$attributes['class'] = '';
				} else {
					$attributes['class'] .= ' ';
				}
				$attributes['class'] .= 'craft_form_' . $attributes['type'];
				if ($fieldName) {
					$attributes['class'] .= ' craft_form_' . $fieldName;
				}

				switch ($attributes['type']) {
					case 'select':
						$choices = explode(',', $attributes['choice']);
						$options = [];
						foreach ($choices as $choice) {
							$options[$choice] = $choice;
						}
						return $BcForm->select($fieldName, $options, $attributes);
					case 'submit':
						$attributes['disabled'] = 'true';
						if (empty($attributes['value'])) {
							$attributes['value'] = '送信';
						}
						$result = $BcForm->button($attributes['value'], $attributes);
						$result .= '<div class="craft_form_output"></div>';
						return $result;
					default:
						return $BcForm->input($fieldName, $attributes);
				}
			},
			$form['CraftFormForm']['blueprint_input']
		);

		$formData .= $BcForm->hidden('formId', ['value' => $formId]);
		$currentUrl = sprintf(
			"%s%s%s",
			empty($_SERVER['HTTPS']) ? 'http://' : 'https://',
			$_SERVER['HTTP_HOST'],
			$_SERVER['REQUEST_URI']
		);
		$formData .= $BcForm->hidden('formUrl', ['value' => $currentUrl]);

		$formData .= $BcForm->end();

		return $formData;
	}

	static public function converToArray($form) {
		preg_match_all('/\[[\w-]+.*]/', $form['CraftFormForm']['blueprint_input'], $matches);
		$fields = [];
		foreach ($matches[0] as $match) {
			preg_match('/\A\[([\w-]+)/i', $match, $matchFieldType);
			if (! $matchFieldType) {
				return false;
			}

			preg_match_all('/ ([\w-]+)="([^"]+)"/i', $match, $matchFieldAttributes, PREG_SET_ORDER);
			$attributes = [];
			foreach ($matchFieldAttributes as $matchFieldAttribute) {
				$attributes[$matchFieldAttribute[1]] = $matchFieldAttribute[2];
			}

			$attributes['type'] = $matchFieldType[1];

			if (empty($attributes['name'])) {
				continue;
			}

			if (!empty($attributes['rule'])) {
				$attributes['rules'] = explode(',', $attributes['rule']);
			}

			$fields[$attributes['name']] = $attributes;
			unset($fields[$attributes['name']]['name']);
		}
		return $fields;
	}
}
