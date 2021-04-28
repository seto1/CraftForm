<?php

class CraftFormMailsController extends AppController {

	public $components = ['BcAuth', 'BcAuthConfigure'];

	public $uses = ['CraftForm.CraftFormMail'];

	public $subMenuElements = ['CraftForm.index'];

	public $crumbs = [
		['name' => 'CraftForm'],
	];

	public function admin_index() {
		$mails = $this->CraftFormMail->find('all', [
			'order' => ['CraftFormMail.created DESC'],
		]);

		$mails = $this->generateMailMessages($mails);

		$this->set('mails', $mails);
	}

	public function admin_add() {
		if (!$this->request->is('post') || !$this->request->data('CraftFormMail')) {
			$this->render('form');
			return;
		}

		if (!$this->CraftFormMail->save($this->request->data('CraftFormMail'))) {
			$this->render('form');
			return;
		}

		$this->redirect(
			[
				'action' => 'edit',
				$this->CraftFormMail->getLastInsertId()
			]
		);
	}

	public function admin_edit($id) {
		if ($this->request->is('post') && !empty($this->request->data('CraftFormMail'))) {
			if (isset($this->request->data['delete'])) {
				$this->delete($this->request->data('CraftFormMail.id'));
			}
			$this->render('form');
			return;
		}

		$mail = $this->CraftFormMail->read(null, $id);
		if (!$mail) {
			$this->setMessage(__d('baser', '無効な処理です。'), true);
			$this->redirect(['action' => 'index']);
			return;
		}
		$this->set('mail', $mail);
		$this->render('form');
	}

	private function delete($id) {
		if (!$this->CraftFormMail->delete($id)) {
			$this->setMessage('フォームの削除に失敗しました。', true);
		} else {
			clearViewCache();
			$this->setMessage('フォームを削除しました。');
		}
		$this->redirect('index');
	}

	private function generateMailMessages($mails) {
		foreach ($mails as &$mail) {
			$values = [];
			foreach ($mail['CraftFormMailField'] as &$mailField) {
				$values[] = $mailField['value'];
			}
			$mail['CraftFormMail']['message'] = implode(',', $values);
		}
		return $mails;
	}
}
