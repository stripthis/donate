<div class="users index">
	<h2><?php __('Users');?></h2>
	<div class="actions">
		<h3><?php echo __('Actions'); ?></h3>
		<ul>
			<li><?php echo $html->link(__('New User', true), array('action'=>'add'),array('class'=>'add')); ?></li>
      </ul>
	</div>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th class="text"><?php echo $paginator->sort('login');?></th>
			<th class="date"><?php echo $paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		<?php
		$i = 0;
		foreach ($users as $user):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $user['User']['id']; ?></td>
			<td class="text"><?php echo $user['User']['login']; ?></td>
			<td class="date"><?php echo $user['User']['created']; ?></td>
			<td class="date"><?php echo $user['User']['modified']; ?></td>
			<td class="actions">
				<?php echo $html->link(__('Details', true), array('action'=>'view', $user['User']['id']),array('class'=>'view')); ?>
				<?php echo $html->link(__('Delete', true), array('action'=>'delete', $user['User']['id']), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
<?php echo $this->element('paging', array('model' => 'User'))?>