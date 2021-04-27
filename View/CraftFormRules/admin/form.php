<?= $this->BcBaser->css('CraftForm.admin/style') ?>
<?= $this->BcBaser->js('CraftForm.admin/field_rule') ?>
<script type="text/javascript">
$(function(){
	$('#BtnDelete').click(function() {
		if (! confirm('削除してもよろしいですか？')) {
			return false;
		}
	});
});
</script>
<div id="craftform-validation-form">
<?= $this->BcForm->create('CraftForm.CraftFormRule') ?>
	<table cellpadding="0" cellspacing="0" class="form-table">
		<tr>
			<th class="col-head">
				ルールタイトル <span class="required">*</span>
			</th>
			<td class="col-input">
				<?= $this->BcForm->input('title', ['size' => 50]) ?>
				<?= $this->BcForm->error('title') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				ルール名 <span class="required">*</span>
			</th>
			<td class="col-input">
				<?= $this->BcForm->input('name', ['size' => 25]) ?>
				<small>※半角英数で入力してください</small>
				<?= $this->BcForm->error('name') ?>
			</td>
		</tr>
	</table>

	<?= $this->BcForm->error('type') ?>
	<ul class="craft-form-rule-select-list">
		<li class="craft-form-rule-select-label">入力値チェック</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="validateRequired">必須確認</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="validateEqualTo">一致確認</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="validateLength">文字数</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="validateCharacterType">文字種</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="validateRange">数値</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="validateDate">日付</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="validateRegex">正規表現</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="validateNgRegex">正規表現（NGワード）</li>
	</ul>
	<ul class="craft-form-rule-select-list">
		<li class="craft-form-rule-select-label">変換処理</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="convertKana">半角 ⇔ 全角</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="convertUpper">大文字</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="convertLower">小文字</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="convertRegex">正規表現</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="convertDate">日付</li>
	</ul>
	<ul class="craft-form-rule-select-list">
		<li class="craft-form-rule-select-label">送信制限</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="sendLimitTimes">連続送信制限</li>
		<li class="craft-form-rule-select" data-craftFormSelectRule="sendLimitIP">IP制限</li>
	</ul>

	<table class="form-table craft-form-rule-table">
		<tr class="mailfield-rules-validateRequired">
			<th>入力必須</th>
			<td>
				ON<br>
				<small>値の存在をチェックします。</small>
			</td>
		</tr>
		<tr class="mailfield-rules-validateEqualTo">
			<th>一致確認</th>
			<td>
				<?= $this->BcForm->input('equalTo', ['size' => 20]) ?>
				<?= $this->BcForm->error('equalTo') ?><br>
				<small>指定したフィールドと値が一致するかチェックします。</small>
			</td>
		</tr>
		<tr class="mailfield-rules-validateLength">
			<th>文字数</th>
			<td>
				<?= $this->BcForm->input('minLength', ['size' => 1]) ?>
				文字
				<?= $this->BcForm->error('minLength') ?>
				～
				<?= $this->BcForm->input('maxLength', ['size' => 1]) ?>
				文字<?= $this->BcForm->error('maxLength') ?><br>
			</td>
		</tr>
		<tr class="mailfield-rules-validateCharacterType">
			<th>文字種</th>
			<td>
				<?= $this->BcForm->input(
					'characterType', [
					'type' => 'select',
					'multiple' => 'checkbox',
					'options' => [
						'hiragana' => 'ひらがな',
						'katakana' => 'カタカナ',
						'halfKatakana' => '半角カタカナ',
						'numeric' => '半角数値',
						'emNumeric' => '全角数値',
						'space' => '半角空白',
						'emSpace' => '全角空白',
						'loserCase' => '英字小文字',
						'upperCase' => '英字大文字',
					]
				]) ?>
				<?= $this->BcForm->error('characterType') ?>
			</td>
		</tr>
		<tr class="mailfield-rules-validateRange">
			<th>数値</th>
			<td>
				<?= $this->BcForm->input('min', ['size' => 1]) ?>
				<?= $this->BcForm->error('min') ?>
				～
				<?= $this->BcForm->input('max', ['size' => 1]) ?>
				<?= $this->BcForm->error('max') ?><br>
				<small>指定した範囲の数値であることをチェックします。</small>
			</td>
		</tr>
		<tr class="mailfield-rules-validateDate">
			<th>日付</th>
			<td>
				<?= $this->BcForm->input('since', ['size' => 7]) ?>
				<?= $this->BcForm->error('since') ?>
				～
				<?= $this->BcForm->input('until', ['size' => 7]) ?>
				<?= $this->BcForm->error('until') ?><br>
				<small>指定した期間内の日付であることをチェックします。</small>
			</td>
		</tr>
		<tr class="mailfield-rules-validateRegex">
			<th>正規表現</th>
			<td>
				/
				<?= $this->BcForm->input('regex', ['size' => 50]) ?>
				/us
				<?= $this->BcForm->error('regex') ?><br>
			</td>
		</tr>
		<tr class="mailfield-rules-validateNgRegex">
			<th>正規表現（NGワード）</th>
			<td>
				/
				<?= $this->BcForm->input('ngRegex', ['size' => 50]) ?>
				/us
				<?= $this->BcForm->error('noRegex') ?><br>
				<small>一致する場合にエラーが表示されます。</small>
			</td>
		</tr>
		<tr class="mailfield-rules-convertKana">
			<th>半角 ⇔ 全角</th>
			<td>
				<?= $this->BcForm->input('convertKanaOption', ['size' => 10]) ?><br>
				<small><a
						href="http://php.net/manual/ja/function.mb-convert-kana.php"
						target=_blank
					>mb_convert_kana関数</a>の変換オプションを指定してください。</small>
			</td>
		</tr>
		<tr class="mailfield-rules-convertUpper">
			<th>大文字</th>
			<td>
				ON<br>
				<small>アルファベットを大文字に変換します。</small>
			</td>
		</tr>
		<tr class="mailfield-rules-convertLower">
			<th>小文字</th>
			<td>
				ON<br>
				<small>アルファベットを小文字に変換します。</small>
			</td>
		</tr>
		<tr class="mailfield-rules-convertRegex">
			<th>正規表現</th>
			<td>
				from /
				<?= $this->BcForm->input('convertRegexPattern', ['size' => 50]) ?>
				/us
				<?= $this->BcForm->error('convertRegexPattern') ?><br>
				to
				<?= $this->BcForm->input('convertRegexReplacement', ['size' => 50]) ?>
				<?= $this->BcForm->error('convertRegexReplacement') ?><br>
			</td>
		</tr>
		<tr class="mailfield-rules-convertDate">
			<th>日付</th>
			<td>
				<?= $this->BcForm->input('convertDateOption', ['size' => 10]) ?>
				<?= $this->BcForm->error('convertDateOption') ?><br>
				<small><a
						href="http://php.net/manual/ja/function.date.php"
						target=_blank
					>date関数</a>関数のフォーマットを指定してください。</small>
			</td>
		</tr>
		<tr class="mailfield-rules-sendLimitTimes">
			<th>連続送信制限</th>
			<td>
				<?= $this->BcForm->input('sendLimitTime', ['size' => 5]) ?>
				<?= $this->BcForm->error('sendLimitTime') ?>
				分に
				<?= $this->BcForm->input('sendLimitTimes', ['size' => 5]) ?>
				<?= $this->BcForm->error('sendLimitTimes') ?>
				回まで送信を許可する
			</td>
		</tr>
		<tr class="mailfield-rules-sendLimitIP">
			<th>IP制限</th>
			<td>
				<?= $this->BcForm->input('sendLimitIP', ['type' => 'textarea']) ?>
				<?= $this->BcForm->error('sendLimitIP') ?><br>
				<small>一行にひとつずつIPを入力してください。</small>
			</td>
		</tr>
	</table>

	<table class="form-table  craft-form-rule-table-error-message">
		<tr>
			<th>エラーメッセージ</th>
			<td>
				<?= $this->BcForm->input('message', ['type' => 'text', 'size' => 50]) ?>
				<?= $this->BcForm->error('message') ?><br>
				<small>メッセージ中の「%l」は、エラー表示時にメールフィールドの項目名に変換されます。</small>
			</td>
		</tr>
	</table>
	<?= $this->BcForm->input('CraftFormRule.id', ['type' => 'hidden']) ?>
	<?= $this->BcForm->input('CraftFormRule.type', ['type' => 'hidden']) ?>

	<div class="submit">
		<?php $this->BcBaser->link('一覧に戻る', ['action' => 'index'], ['class' => 'button']) ?>
		<?= $this->BcForm->submit(
			'保存',
			['div' => false, 'class' => 'button', 'id' => 'BtnSave', 'name' => 'save']
		) ?>
		<?php if ($this->action === 'admin_edit'): ?>
			<?= $this->BcForm->submit(
				'削除',
				['div' => false, 'class' => 'button', 'id' => 'BtnDelete', 'name' => 'delete']
			) ?>
		<?php endif ?>
	</div>
	<?= $this->BcForm->end() ?>
</div>

