<?php echo $this->BcBaser->css('CraftForm.admin/style') ?>

<table class="list-table craft-form-list-table" id="ListTable">
	<thead>
		<tr>
			<th class="list-tool">
				<div>
					<?php $this->BcBaser->link('＋新規追加', ['action' => 'add']) ?>
				</div>
			</th>
			<th>
				URL
			</th>
			<th>
				タイトル
			</th>
		</tr>
	</thead>
	<tbody>
		<?php if (! empty($forms)): ?>
			<?php foreach ($forms as $form): ?>
				<tr>
					<td>
						<?php
						$this->BcBaser->link(
							$this->BcBaser->getImg(
								'admin/icn_tool_edit.png',
								['alt' => __d('baser', '編集'), 'class' => 'btn']
							),
							['action' => 'edit', $form['CraftFormForm']['id']],
							['title' => __d('baser', '編集')]
						) ?>
					</td>
					<td>
						<?php echo h($form['CraftFormForm']['url']); ?>
					</td>
					<td>
						<?php echo h($form['CraftFormForm']['title']); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="3"><p class="no-data"><?php echo __d('baser', 'データが見つかりませんでした。')?></p></td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>
