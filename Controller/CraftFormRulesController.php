<?php

class CraftFormRulesController extends AppController {

	public $components = ['BcAuth', 'BcAuthConfigure'];

	public $uses = ['CraftForm.CraftFormRule'];

	public $subMenuElements = ['CraftForm.index'];

	public $crumbs = [
		['name' => 'CraftForm'],
	];

	public function admin_index() {
		$forms = $this->CraftFormRule->find('all', [
			'order' => 'title asc',
		]);
		$this->set('forms', $forms);
	}

	public function admin_add() {
		if (!$this->request->data('CraftFormRule')) {
			$this->render('form');
			return;
		}
		try {
			if (!$this->CraftFormRule->validatesData($this->request->data)) {
				throw new Exception('バリデーションエラー');
			}
			$data = $this->CraftFormRule->convertRuleRequestData(
				$this->request->data,
				$this->CraftFormRule->convertRuleOptions($this->request->data)
			);
			if ($this->CraftFormRule->save($data)) {
				clearViewCache();
				$this->setMessage('ルールを追加しました。');
				$this->redirect([
					'action' => 'edit',
					$this->CraftFormRule->getLastInsertId()
				]);
			}
		} catch (Exception $e) {
			$this->setMessage('エラーが発生しました。内容を確認してください。', true);
		}
		$this->render('form');
	}

	public function admin_edit($id) {
		if ($this->request->is('put') && ! empty($this->request->data['CraftFormRule'])) {
			if (!isset($this->request->data['delete'])) {
				$this->edit($this->request->data);
			} else {
				$this->delete(
					$this->request->data['CraftFormRule']['id']
				);
			}
			$this->render('form');
			return;
		}
		$this->request->data = $this->CraftFormRule->findById($id);
		if (! $this->request->data) {
			$this->setMessage(__d('baser', '無効な処理です。'), true);
			$this->redirect(['action' => 'index']);
		}

		$options = json_decode($this->request->data['CraftFormRule']['options'], true);
		if (is_array($options)) {
			$this->request->data['CraftFormRule'] = array_merge(
				$this->request->data['CraftFormRule'],
				$options
			);
		}
		$this->render('form');
	}

	private function edit($data) {
		try {
			if (! $this->CraftFormRule->validatesData($this->request->data)) {
				throw new Exception('バリデーションエラー');
			}

			$data = $this->CraftFormRule->convertRuleRequestData(
				$this->request->data,
				$this->CraftFormRule->convertRuleOptions(
					$this->request->data
				)
			);

			if ($this->CraftFormRule->save($data, false)) {
				clearViewCache();
				$this->setMessage('ルールを更新しました。');
				$this->redirect(['action' => 'edit', $this->request->data['CraftFormRule']['id']]);
			}
		} catch (Exception $e) {
			$this->setMessage('エラーが発生しました。内容を確認してください。', true);
		}
	}

	private function delete($id) {
		if (!$this->CraftFormRule->delete($id)) {
			$this->setMessage('ルールの削除に失敗しました。', true);
			$this->redirect('index');
			return;
		}
		clearViewCache();
		$this->setMessage('ルールを削除しました。');
		$this->redirect('index');
	}
}
