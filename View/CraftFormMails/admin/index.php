<?php echo $this->BcBaser->css('CraftForm.admin/style') ?>

<table cellpadding="0" cellspacing="0" class="list-table craft-form-list-table" id="ListTable">
	<thead>
		<tr>
			<th class="list-tool"><div></div></th>
			<th>受信内容</th>
			<th>IP</th>
			<th>受信日時</th>
		</tr>
	</thead>
	<tbody>
	<?php if (! empty($mails)): ?>
		<?php foreach ($mails as $mail): ?>
			<tr>
				<td>
					<?php $this->BcBaser->link(
						$this->BcBaser->getImg(
							'admin/icn_tool_view.png', [
								'alt' => __d('baser', '編集'), 'class' => 'btn'
							]
						),
						['action' => 'edit', $mail['CraftFormMail']['id']],
						['title' => __d('baser', '編集')]
					) ?>
				</td>
				<td>
					<?php echo h(CakeText::truncate($mail['CraftFormMail']['message'], 100)); ?>
				</td>
				<td>
					<?php echo h($mail['CraftFormMail']['ip']); ?>
				</td>
				<td>
					<?php echo h($mail['CraftFormMail']['created']); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="3">
				<p class="no-data">
					<?php echo __d('baser', 'データが見つかりませんでした。')?>
				</p>
			</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>
