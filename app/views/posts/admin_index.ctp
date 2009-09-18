<div class="posts index">
	<h2><?php __('Posts Index');?></h2>
	<div class="actions">
		<h3>Actions</h3>
		<ul>
			<li>
				<?php
				echo $html->link(__('New Post', true),
					array('action' => 'add'), array('class' => 'add')
				);
				?>
			</li>
		</ul>
	</div>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $paginator->sort('id');?></th>
			<th><?php echo $paginator->sort('title');?></th>
			<th><?php echo $paginator->sort('body');?></th>
			<th class="date created"><?php echo $paginator->sort('created');?></th>
			<th class="date modified"><?php echo $paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		<?php
		$i = 0;
		foreach ($posts as $post) :
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $post['Post']['id']; ?></td>
			<td><?php echo $post['Post']['title']; ?></td>
			<td><?php echo $post['Post']['body']; ?></td>
			<td><?php echo $post['Post']['created']; ?></td>
			<td><?php echo $post['Post']['modified']; ?></td>
			<td class="actions">
				<?php
				echo $html->link(__('View', true),
					array('action' => 'view', $post['Post']['id']),
					array('class'=>'view')
				)."\n";
				echo $html->link(__('Edit', true),
					array('action'=>'edit', $post['Post']['id']),
					array('class'=>'edit')
				)."\n";
				echo $html->link(__('Delete', true),
					array('action' => 'delete', $post['Post']['id']),
					array('class'=>'delete'),
					__('Are you sure?', true)
				)."\n";
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
<?php echo $this->element('paging', array('model' => 'Post'))?>