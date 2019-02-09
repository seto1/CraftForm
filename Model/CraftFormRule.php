<?php

class CraftFormRule extends AppModel {

	public $name = 'CraftFormRule';

	public $ruleSettings = [
		'validateRequired' => [],
		'validateLength' => ['minLength', 'maxLength'],
		'validateCharacterType' => ['characterType'],
		'validateRange' => ['min', 'max'],
		'validateEqualTo' => ['equalTo'],
		'validateDate' => ['since', 'until'],
		'validateRegex' => ['regex'],
		'validateNgRegex' => ['ngRegex'],
		'convertKana' => ['convertKanaOption'],
		'convertDate' => ['convertDateOption'],
		'convertUpper' => [],
		'convertLower' => [],
		'convertRegex' => ['convertRegexPattern', 'convertRegexReplacement'],
		'sendLimitTimes' => ['sendLimitTime', 'sendLimitTimes'],
		'sendLimitIP' => ['sendLimitIP'],
	];

	public $craftFormValidateErrors;

	public $validate = [
		'title' => [
			[
				'rule' => ['notBlank'],
				'message' => '入力必須です。',
				'required' => true,
			],
		],
		'name' => [
			[
				'rule' => ['notBlank'],
				'message' => '入力必須です。',
				'required' => true,
			],
			[
				'rule' => ['alphaNumeric'],
				'message' => '半角英数で入力してください。',
			],
			[
				'rule' => ['isUnique'],
				'message' => 'そのルール名はすでに使われています。',
			],
		],
		'type' => [
			[
				'rule' => ['notBlank'],
				'message' => '選択必須です。',
				'required' => true,
			],
		],
		'minLength' => [
			[
				'rule' => ['naturalNumber'],
				'message' => '数値を入力してください。',
				'allowEmpty' => true,
			],
		],
		'maxLength' => [
			[
				'rule' => ['naturalNumber'],
				'message' => '数値を入力してください。',
				'allowEmpty' => true,
			],
		],
		'min' => [
			[
				'rule' => ['numeric'],
				'message' => '数値を入力してください。',
				'allowEmpty' => true,
			],
		],
		'max' => [
			[
				'rule' => ['numeric'],
				'message' => '数値を入力してください。',
				'allowEmpty' => true,
			],
		],
		'since' => [
			[
				'rule' => ['date'],
				'message' => '日付を入力してください。',
				'allowEmpty' => true,
			],
		],
		'until' => [
			[
				'rule' => ['date'],
				'message' => '日付を入力してください。',
				'allowEmpty' => true,
			],
		],
	];

	public function validatesData($data) {
		$this->set($data);

		// オプション以外のバリデーション
		if (! $this->validates(['fieldList' => ['title', 'name', 'type', 'options', 'message']])
			|| ! $this->validateMessage($data)) {

			return false;
		}

		// オプションのバリデーション
		$ruleOptions = $this->convertRuleOptions($data);
		if (! $this->validateOptions($data['CraftFormRule']['type'], $ruleOptions)) {
			return false;
		}

		return true;
	}

	// ルールのオプションを配列に変換
	public function convertRuleOptions($data) {
		$ruleType = $data['CraftFormRule']['type'];

		if (! $ruleType) {
			throw new Exception('ルールが選択されていません。');
		}
		if (! array_key_exists($ruleType, $this->ruleSettings)) {
			throw new Exception('ruleTypeが存在しません。');
		}

		$options = [];
		foreach ($this->ruleSettings[$ruleType] as $settingName) {
			$options[$settingName] = $data['CraftFormRule'][$settingName];
		}

		return $options;
	}

	// ルールのオプションに対するバリデーション
	public function validateOptions($ruleType, $optionValues) {
		$checkFields = [];
		foreach ($optionValues as $optionName => $option) {
			$checkFields[] = $optionName;
		}

		if ($checkFields && ! $this->validates(['fieldList' => $checkFields])) {
			return false;
		}

		return true;
	}

	public function convertRuleRequestData($data, $options) {
		$optionsJson = NULL;
		if ($options) {
			$optionsJson = json_encode($options, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		}

		return $data['CraftFormRules'] = [
			'name' => $data['CraftFormRule']['name'],
			'type' => $data['CraftFormRule']['type'],
			'options' => $optionsJson,
			'message' => $data['CraftFormRule']['message'],
			'status' => 1,
		];
	}

	// validate・sendLimitの場合はエラーメッセージ必須
	private function validateMessage($data) {
		if (preg_match('/\A(?:validate|sendLimit)/', $data['CraftFormRule']['type'])
			&& empty($data['CraftFormRule']['message'])
		) {
			$this->invalidate('message', 'エラーメッセージが入力されていません。');
			return false;
		}
		return true;
	}

	// 送信制限ルールを適用
	public function applyFormRules($ruleText) {
		$formRules = explode(',', $ruleText);
		$formRules = array_map('trim', $formRules);
		$rules = $this->find('all');

		foreach ($rules as $rule) {
			$ruleType = $rule['CraftFormRule']['type'];
			$ruleOptions = json_decode($rule['CraftFormRule']['options'], true);

			foreach ($formRules as $formRule) {
				if ($rule['CraftFormRule']['name'] === $formRule) {
					if (strpos($ruleType, 'sendLimit') === 0) {
						if (! $this->$ruleType($ruleOptions)) {
							$this->craftFormValidateErrors['__form'][] = $rule['CraftFormRule']['message'];
							break 2;
						}
					}
				}
			}
		}
	}

	// リクエストデータに対してルールを適用
	public function applyFieldRules($requestData, $fields) {
		$this->set($requestData);

		$this->craftFormValidateErrors = [];
		$rules = $this->find('all');

		foreach ($fields as $fieldName => $field) {
			if (empty($field['rules'])) {
				continue;
			}

			if (isset($requestData[$fieldName])) {
				$fieldValue = $requestData[$fieldName];
			} else {
				$fieldValue = null;
			}

			$requestData[$fieldName] = $this->applyFieldRule($fieldName, $fieldValue, $field, $rules);
		}

		return $requestData;
	}

	// リクエストデータに対してルールを適用
	private function applyFieldRule($fieldName, $fieldValue, $field, $rules) {
		foreach ($field['rules'] as $ruleName) {
			foreach ($rules as $rule) {
				$ruleType = $rule['CraftFormRule']['type'];
				if (! array_key_exists($ruleType, $this->ruleSettings)) {
					continue;
				}

				$ruleOptions = json_decode($rule['CraftFormRule']['options'], true);

				if ($ruleName === $rule['CraftFormRule']['name']) {
					if (strpos($ruleType, 'validate') === 0) {
						if ($ruleType !== 'validateRequired' && ! $fieldValue) {
							continue;
						}
						if (! $this->$ruleType($fieldValue, $ruleOptions)) {
							$this->craftFormValidateErrors[$fieldName][] = $rule['CraftFormRule']['message'];
							break 2;
						}
					} elseif (strpos($ruleType, 'convert') === 0) {
						$fieldValue = $this->$ruleType($fieldValue, $ruleOptions);
					}
					break;
				}
			}
		}

		return $fieldValue;
	}

	// 送信制限: 送信回数
	private function sendLimitTimes($options) {
		$request = Router::getRequest();
		$clientIp = $request->clientIp();

		$startDate = date('Y-m-d H:i:s', strtotime("- {$options['sendLimitTime']} minutes"));

		$CraftFormModel = ClassRegistry::init('CraftFormMail');
		$sendCount = $CraftFormModel->find('count', [
			'conditions' => [
				'ip' => $clientIp,
				'created >=' => $startDate
			]
		]);

		return ($sendCount < $options['sendLimitTimes']);
	}

	// 送信制限: IP
	private function sendLimitIP($options) {
		$request = Router::getRequest();
		$clientIp = $request->clientIp();

		$ips = explode("\n", $options['sendLimitIP']);
		$ips = array_map('trim', $ips);

		return ! in_array($clientIp, $ips);
	}

	// バリデーション: 必須
	private function validateRequired($value, $options) {
		return ! empty($value);
	}

	// バリデーション: 他フィールド一致
	private function validateEqualTo($value, $options) {
		if (empty($this->data['CraftFormRule'][$options['equalTo']])) {
			return false;
		}

		if ($this->data['CraftFormRule'][$options['equalTo']] !== $value) {
			return false;
		}

		return true;
	}

	// バリデーション: 文字数
	private function validateLength($value, $options) {
		$length = mb_strlen($value);
		if ($length < $options['minLength'] || $length > $options['maxLength']) {
			return false;
		}

		return true;
	}

	// バリデーション: 文字種
	private function validateCharacterType($value, $options) {
		$replacePattern = [
			'hiragana' => '[ぁ-んー]',
			'katakana' => '[ァ-ヶー]',
			'halfKatakana' => '[ァ-ヶー]',
			'numeric' => '[0-9]',
			'emNumeric' => '[０-９]',
			'space' => ' ',
			'emSpace' => '　',
			'lowerCase' => '[a-z]',
			'upperCase' => '[A-Z]',
		];

		foreach ($options['characterType'] as $characterType) {
			if (empty($replacePattern[$characterType])) {
				continue;
			}

			$value = preg_replace("/{$replacePattern[$characterType]}+/u", '', $value);
		}

		return empty($value);
	}

	// バリデーション: 数値
	private function validateRange($value, $options) {
		if ($value < $options['min'] || $value > $options['max']) {
			return false;
		}

		return true;
	}

	// バリデーション: 日付
	private function validateDate($value, $options) {
		$valueTime = strtotime($value);
		$sinceTime = strtotime($options['since']);
		$untilTime = strtotime($options['until']);

		if ($valueTime < $sinceTime || $valueTime > $untilTime) {
			return false;
		}

		return true;
	}

	// バリデーション: 正規表現
	private function validateRegex($value, $options) {
		$pattern = str_replace("\0", '', $options['regex']);

		return preg_match("/{$pattern}/us", $value);
	}

	// バリデーション: 正規表現 NGワード
	private function validateNgRegex($value, $options) {
		$pattern = str_replace("\0", '', $options['ngRegex']);

		return ! preg_match("/{$pattern}/us", $value);
	}

	// 変換: カナ
	private function convertKana($value, $options) {
		return mb_convert_kana($value, $options['convertKanaOption']);
	}

	// 変換:
	private function convertUpper($value, $options) {
		return strtoupper($value);
	}

	// 変換:
	private function convertLower($value, $options) {
		return strtolower($value);
	}

	// 変換:
	private function convertRegex($value, $options) {
		$pattern = str_replace("\0", '', $options['convertRegexPattern']);
		$replacement = str_replace("\0", '', $options['convertRegexReplacement']);

		return preg_replace("/{$pattern}/us", $replacement, $value);
	}

	// 変換:
	private function convertDate($value, $options) {
		return date($options['convertDateOption'], strtotime($value));
	}
}
