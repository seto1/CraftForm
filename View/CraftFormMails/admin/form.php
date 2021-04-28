<?php echo $this->BcBaser->css('CraftForm.admin/style') ?>
<script type="text/javascript">
$(function(){
	$('#BtnDelete').click(function() {
		if (! confirm('削除してもよろしいですか？')) {
			return false;
		}
	});
});
</script>
<div>
	<table cellpadding="0" cellspacing="0" class="form-table">
	<?php foreach ($mail['CraftFormMailField'] as $mailField): ?>
		<tr>
			<th class="col-head">
				<?php echo h($mailField['name']) ?>
			</th>
			<td class="col-input">
				<?php echo nl2br(h($mailField['value'])) ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<table cellpadding="0" cellspacing="0" class="form-table">
		<tr>
			<th class="col-head">
				IP
			</th>
			<td class="col-input">
				<?php echo h($mail['CraftFormMail']['ip']) ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				ユーザーエージェント
			</th>
			<td class="col-input">
				<?php echo h($mail['CraftFormMail']['user_agent']) ?>
			</td>
		</tr>
		<tr>
			<th class="col-head">
				受信日時
			</th>
			<td class="col-input">
				<?php echo h($mail['CraftFormMail']['created']) ?>
			</td>
		</tr>
	</table>
	<?php echo $this->BcForm->create('CraftForm.CraftFormMailField') ?>
		<?php echo $this->BcForm->input(
			'CraftFormMail.id', [
				'type' => 'hidden',
				'value' => $mail['CraftFormMail']['id']
			]
		) ?>

		<div class="submit">
			<?php $this->BcBaser->link(
				'一覧に戻る', [
					'action' => 'index'
				], [
					'class' => 'button'
				]
			) ?>
			<?php echo $this->BcForm->submit(
				'削除', [
					'div' => false, 'class' => 'button', 'id' => 'BtnDelete', 'name' => 'delete'
				]
			) ?>
		</div>
	<?php echo $this->BcForm->end() ?>
</div>
