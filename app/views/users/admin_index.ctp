<div class="content users index">
	<h2><?php __('Users');?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'admin_config_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
<?php echo $this->element('../users/elements/actions'); ?>
	<?php if (!empty($users)) : ?>
		<?php
		unset($params['sort']);
		unset($params['direction']);
		?>
		<table cellpadding="0" cellspacing="0">
		  <thead>
			<tr>
				<th class="text"><?php echo $paginator->sort(__('Login', true), 'login', array('url' => $params));?></th>
				<th class="date"><?php echo $paginator->sort(__('Created', true), 'created', array('url' => $params));?></th>
				<th class=""><?php __('Actions');?></th>
			</tr>
			<?php
			$i = 0;
			foreach ($users as $user):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			</thead>
			<tbody>
			<tr<?php echo $class;?>>
				<td class="text"><?php echo $user['User']['login']; ?></td>
				<td class="date"><?php echo date('F d Y', strtotime($user['User']['created'])); ?></td>
				<td class="">
					<?php echo $html->link(__('Details', true), array('action'=>'view', $user['User']['id']),array('class'=>'view')); ?>
					- <?php echo $html->link(__('Delete', true), array('action'=>'delete', $user['User']['id']), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?>
				</td>
			</tr>
			</tbody>
			<?php endforeach; ?>
		</table>
		<?php
		$urlParams = $params;
		$urlParams[] = $type;
		$urlParams['merge'] = true;
		unset($urlParams['ext']);
		unset($urlParams['page']);
		echo $this->element('paging', array('model' => 'User', 'url' => $urlParams));
		?>
	<?php else : ?>
		<p>Sorry, nothing to show here.</p>
	<?php endif; ?>
	<?php echo $this->element('../users/elements/filter', compact('params', 'type')); ?>
</div>