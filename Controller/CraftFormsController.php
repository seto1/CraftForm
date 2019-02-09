<?php

class CraftFormsController extends AppController {

	public $components = ['BcAuth', 'BcAuthConfigure'];

	public $uses = ['CraftForm.CraftFormForm', 'CraftForm.CraftFormRule', 'CraftForm.CraftFormMail'];

	public $subMenuElements = ['CraftForm.index'];

	public $crumbs = [
		['name' => 'CraftForm'],
	];

	public function beforeFilter() {
		$this->BcAuth->allow(['submit']);

		parent::beforeFilter();
	}

	public function submit() {
		$this->viewClass = 'Json';

		$requestData = $this->getCraftFormRequestData();
		if (empty($requestData)) {
			return false;
		}

		$formId = $requestData['formId'];
		$formUrl = $requestData['formUrl'];

		unset($requestData['formId']);
		unset($requestData['formUrl']);

		$form = $this->CraftFormForm->find('first', [
			'conditions' => [
				'CraftFormForm.id' => $formId,
				'CraftFormForm.status' => 1,
			],
		]);
		if (! $form) {
			return $this->displayErrorResult('disabled');
		}

		if (empty($form['CraftFormForm']['mail_to'])) {
			$form['CraftFormForm']['mail_to'] = $this->siteConfigs['email'];
		}

		$this->CraftFormRule->applyFormRules($form['CraftFormForm']['form_rule']);
		if ($this->CraftFormRule->craftFormValidateErrors) {
			return $this->displayErrorResult('send_limit');
		}

		$fields = CraftFormUtil::converToArray($form);
		$requestData = $this->CraftFormRule->applyFieldRules($requestData, $fields);
		if (empty($requestData)) {
			return false;
		}
		if ($this->CraftFormRule->craftFormValidateErrors) {
			return $this->displayErrorResult('validation');
		}

		// event beforeSend
		list($requestData, $sendOptions) = $this->dispatchBeforeSendEvent($requestData);

		// DB保存
		$requestOptions['ip'] = $this->request->clientIP();
		$requestOptions['userAgent'] = $this->request->header('User-Agent');
		$requestOptions['formId'] = $formId;
		$requestOptions['formUrl'] = $formUrl;
		$this->saveMail($requestData, $fields, $requestOptions);

		$sendOptions = array_merge(
			[
				'template' => false,
				'to' => $form['CraftFormForm']['mail_to'],
				'cc' => $form['CraftFormForm']['mail_cc'],
				'bcc' => $form['CraftFormForm']['mail_bcc'],
				'from' => $form['CraftFormForm']['mail_from'],
				'fromName' => $form['CraftFormForm']['mail_from_name'],
				'title' => $form['CraftFormForm']['mail_title'],
				'message' => $this->convertToMailMessage($requestData, $requestOptions),
			],
			$sendOptions
		);

		// send
		$sendResult = $this->send($sendOptions);

		if (! $sendResult) {
			return $this->displayErrorResult('send');
		}

		$response = [
			'status' => 'success',
		];
		$this->set([
			'response' => [
				'status' => 'success',
			],
			'_serialize' => ['response'],
		]);

		// event afterSend
		$this->dispatchAfterSendEvent($requestData, $sendOptions);

		return;
	}

	// フォームから送信されたリクエストを取得
	private function getCraftFormRequestData() {
		foreach ($this->request->data as $requestKey => $requestData) {
			if (preg_match('/\ACraftForm\d\z/', $requestKey)) {
				return $requestData;
			}
		}

		$response = [
			'status' => 'failed',
			'error' => 'empty',
		];
		$this->set([
			'response' => $response,
			'_serialize' => ['response'],
		]);

		return false;
	}

	// エラーをJSONで出力
	private function displayErrorResult($errorType) {
		$response = [
			'status' => 'failed',
			'error' => $errorType,
		];

		if ($errorType === 'validation') {
			$response['validation_errors'] = $this->CraftFormRule->craftFormValidateErrors;
		}
		if ($errorType === 'send_limit') {
			$response['send_limit_errors'] = $this->CraftFormRule->craftFormValidateErrors['__form'];
		}

		$this->set([
			'response' => $response,
			'_serialize' => ['response'],
		]);

		return false;
	}

	// メールを送信
	private function send($options) {
		return $this->sendMail($options['to'], $options['title'], $options['message'], $options);
	}

	// メールの本文を作成
	private function convertToMailMessage($requestData, $options) {
		$message = '';
		foreach ($requestData as $key => $var) {
			$message .= "□{$key}\n";
			$message .= "{$var}\n\n";
		}

		$message .= "----------\n\n";

		$message .= "□送信元\n{$options['formUrl']}\n\n";
		$message .= "□IP\n{$options['ip']}\n\n";
		$message .= "□UA\n{$options['userAgent']}";

		$message = trim($message);

		return $message;
	}

	// メールをDBに保存
	private function saveMail($requestData, $fields, $options) {
		$saveData['CraftFormMail'] = [
			'form_id' => $options['formId'],
			'form_url' => $options['formUrl'],
			'ip' => $options['ip'],
			'user_agent' => $options['userAgent'],
		];

		$saveData['CraftFormMailField'] = [];

		$order = 0;
		foreach ($fields as $fieldName => $field) {
			$order++;

			if (! isset($requestData[$fieldName])) {
				continue;
			}

			$fieldData = [];

			$fieldData['name'] = $fieldName;

			if (! empty($field['title'])) {
				$fieldData['title'] = $field['title'];
			}

			$fieldData['value'] = $requestData[$fieldName];

			$fieldData['order'] = $order;

			$saveData['CraftFormMailField'][] = $fieldData;
		}

		// モデルに書いたバインドが読み込まれていない場合があるので再度バインド
		$this->CraftFormMail->bindModel(
			[
				'hasMany' => [
					'CraftFormMailField' => [
						'className' => 'CraftForm.CraftFormMailField',
						'foreignKey' => 'mail_id',
						'dependent' => true,
					],
				],
			]
		);

		$this->CraftFormMail->saveAssociated($saveData);
	}

	// beforeSendイベント発火
	private function dispatchBeforeSendEvent($requestData) {
		$event = $this->dispatchEvent('beforeSend', [
			'data' => $requestData
		]);
		$sendOptions = [];
		if ($event !== false) {
			if ($event->result === true) {
				$requestData = $event->data['data'];
			} else {
				$requestData = $event->result;
			}
			if (! empty($event->data['sendOptions'])) {
				$sendOptions = $event->data['sendOptions'];
			}
		}

		return [$requestData, $sendOptions];
	}

	// afterSendイベント発火
	private function dispatchAfterSendEvent($requestData, $sendOptions) {
		$this->dispatchEvent('afterSend', [
			'data' => $requestData,
			'sendOptions' => $sendOptions
		]);
	}

	public function admin_index() {
		$forms = $this->CraftFormForm->find('all');

		$this->set('forms', $forms);
	}

	public function admin_add() {
		if ($this->request->is('post') && ! empty($this->request->data['CraftFormForm'])) {
			if ($this->CraftFormForm->save($this->request->data['CraftFormForm'])) {
				$id = $this->CraftFormForm->getLastInsertId();
				$this->redirect(['action' => 'edit', $id]);
			}
		}
		$this->render('form');
	}

	public function admin_edit($id) {
		if ($this->request->is('put') && ! empty($this->request->data['CraftFormForm'])) {
			if (isset($this->request->data['delete'])) {
				$this->delete($this->request->data['CraftFormForm']['id']);
			} else {
				$this->edit($this->request->data);
			}
		} else {
			$this->request->data = $this->CraftFormForm->findById($id);
			if (! $this->request->data) {
				$this->setMessage(__d('baser', '無効な処理です。'), true);
				$this->redirect(['action' => 'index']);
			}
		}
		$this->render('form');
	}

	private function edit($data) {
		if ($this->CraftFormForm->save($data)) {
			clearViewCache();
			$this->setMessage('フォームを更新しました。');
			$this->redirect(['action' => 'edit', $data['CraftFormForm']['id']]);
		} else {
			$this->setMessage('エラーが発生しました。内容を確認してください。', true);
		}
	}

	private function delete($id) {
		if ($this->CraftFormForm->delete($id)) {
			clearViewCache();
			$this->setMessage('フォームを削除しました。');
		} else {
			$this->setMessage('フォームの削除に失敗しました。', true);
		}

		$this->redirect('index');
	}

}
