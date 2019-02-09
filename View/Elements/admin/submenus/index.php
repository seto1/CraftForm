<tr>
	<th>CraftForm</th>
	<td>
		<ul class="cleafix">
			<li><?php $this->BcBaser->link('フォーム一覧', ['controller' => 'craft_forms', 'action' => 'index']) ?></li>
			<li><?php $this->BcBaser->link('フォーム追加', ['controller' => 'craft_forms', 'action' => 'add']) ?></li>
			<li><?php $this->BcBaser->link('ルール一覧', ['controller' => 'craft_form_rules', 'action' => 'index']) ?></li>
			<li><?php $this->BcBaser->link('ルール追加', ['controller' => 'craft_form_rules', 'action' => 'add']) ?></li>
			<li><?php $this->BcBaser->link('受信メール一覧', ['controller' => 'craft_form_mails', 'action' => 'index']) ?></li>
			<li><?php $this->BcBaser->link('使用ガイド', ['controller' => 'craft_form_guide', 'action' => 'index']) ?></li>
		</ul>
	</td>
</tr>
