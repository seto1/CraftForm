<?php echo $this->BcBaser->css('CraftForm.admin/style') ?>

<script type="text/javascript">
$(document).ready(function(){
	$('#BtnDelete').click(function() {
		if (! confirm('削除してもよろしいですか？')) {
			return false;
		}
	});
});
</script>

<div id="craftform-blueprint-form">

<?php echo $this->BcForm->create('CraftForm.CraftFormForm') ?>

	<?php if ($this->action === 'admin_edit'): ?>
		<table class="form-table">
			<tr>
				<th>ショートコード</th>
				<td>
					<label>
						<input
							type="text"
							class="craft-form-short-code"
							value="[CraftForm.getForm <?php echo $this->request->data['CraftFormForm']['id'] ?>]"
							readonly
						>
					</label><br>
					<small>固定ページやブログに貼り付けるとフォームが表示されます。</small>
				</td>
			</tr>
		</table>
	<?php endif ?>

	□フォーム設定
	<table class="form-table">
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('CraftFormForm.title', 'タイトル') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('CraftFormForm.title', ['type' => 'text']) ?>
				<?php echo $this->BcForm->error('CraftFormForm.title') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('CraftFormForm.blueprint_input', '入力画面') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('CraftFormForm.blueprint_input', ['type' => 'textarea']) ?>
				<?php echo $this->BcForm->error('CraftFormForm.blueprint_input') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('CraftFormForm.mail_title', 'メールタイトル') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('CraftFormForm.mail_title', ['type' => 'text']) ?>
				<?php echo $this->BcForm->error('CraftFormForm.mail_title') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('CraftFormForm.mail_to', '送信先 to') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('CraftFormForm.mail_to', ['type' => 'text']) ?>
				<?php echo $this->BcForm->error('CraftFormForm.mail_to') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('CraftFormForm.mail_cc', '送信先 cc') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('CraftFormForm.mail_cc', ['type' => 'text']) ?>
				<?php echo $this->BcForm->error('CraftFormForm.mail_cc') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('CraftFormForm.mail_bcc', '送信先 bcc') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('CraftFormForm.mail_bcc', ['type' => 'text']) ?>
				<?php echo $this->BcForm->error('CraftFormForm.mail_bcc') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('CraftFormForm.mail_from', '差出人 メールアドレス') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('CraftFormForm.mail_from', ['type' => 'text']) ?>
				<?php echo $this->BcForm->error('CraftFormForm.mail_from') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('CraftFormForm.mail_from_name', '差出人 名前') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('CraftFormForm.mail_from_name', ['type' => 'text']) ?>
				<?php echo $this->BcForm->error('CraftFormForm.mail_from_name') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('CraftFormForm.form_rule', 'フォームルール') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('CraftFormForm.form_rule', ['type' => 'text']) ?>
				<?php echo $this->BcForm->error('CraftFormForm.form_rule') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('CraftFormForm.status', '公開状態') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->input(
					'CraftFormForm.status',
					[
						'type' => 'radio',
						'options' => [0 => '非公開', 1 => '公開'],
						'default' => 1
					]
				) ?>
				<?php echo $this->BcForm->error('CraftFormForm.status') ?>
			</td>
		</tr>
	</table>

	<div>□メッセージ</div>
	<table class="form-table">
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('CraftFormForm.message_success', '送信完了時') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('CraftFormForm.message_success', ['type' => 'text']) ?>
				<?php echo $this->BcForm->error('CraftFormForm.message_success') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('CraftFormForm.message_failed', '送信失敗時') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('CraftFormForm.message_failed', ['type' => 'text']) ?>
				<?php echo $this->BcForm->error('CraftFormForm.message_failed') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				<?php echo $this->BcForm->label('CraftFormForm.message_validation_error', '入力内容に問題があった場合') ?>
			</th>
			<td class="col-input">
				<?php echo $this->BcForm->input('CraftFormForm.message_validation_error', ['type' => 'text']) ?>
				<?php echo $this->BcForm->error('CraftFormForm.message_validation_error') ?>
			</td>
		</tr>
	</table>

	<?php echo $this->BcForm->input('CraftFormForm.id', ['type' => 'hidden']) ?>

	<div class="submit">
		<?php $this->BcBaser->link('一覧に戻る', ['action' => 'index'], ['class' => 'button']) ?>
		<?php echo $this->BcForm->submit(
			'保存',
			['div' => false, 'class' => 'button', 'id' => 'BtnSave', 'name' => 'save']
		) ?>
		<?php if ($this->action === 'admin_edit'): ?>
			<?php echo $this->BcForm->submit(
				'削除',
				['div' => false, 'class' => 'button', 'id' => 'BtnDelete', 'name' => 'delete']
			) ?>
		<?php endif ?>
	</div>

	<?php echo $this->BcForm->end() ?>
</div>
