<?php
$title = User::is('root')
			? __('User Management', true)
			: __('Team &amp; Permissions', true);
?>
<div class="content users index">
	<h2><?php echo $title;?></h2>
	<?php
	if (User::is('root')) {
		echo $this->element('nav', array(
			'type' => 'admin_root_admin_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
		));
	} else {
		echo $this->element('nav', array(
			'type' => 'admin_config_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
		));
	}

	if ($type != 'unactivated') {
		echo $this->element('../users/elements/actions');
	}
	?>
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
				<th class="text"><?php echo $paginator->sort(__('Level', true), 'Role.name', array('url' => $params));?></th>
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
				<td class="date"><?php echo $common->date($user['User']['created']); ?></td>
				<td class="text"><?php echo Inflector::humanize($user['Role']['name']); ?></td>
				<td class="">
					<?php
					$actions = array();
					if ($type != 'unactivated') {
						$actions[] = $html->link(__('Edit', true), array(
							'action' => 'edit', $user['User']['id']),
							array('class' => 'edit'), false, false
						);
					} else {
						$actions[] = $html->link(__('Resend Activation Email', true), array(
							'action' => 'resend_activation_email', $user['User']['id']),
							array('class'=>'view'), false, false
						);
					}
					$actions[] = $html->link(__('Delete', true), array(
						'action' => 'delete', $user['User']['id']),
						array('class'=>'delete'),
						sprintf(__('Are you sure you want to delete %s?', true), $user['User']['name'])
					);
					echo implode(' - ', $actions);
					?>
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
		<p><?php echo __('Sorry, nothing to show here.', true); ?></p>
	<?php endif; ?>
	<?php
	if ($type != 'unactivated') {
		echo $this->element('../users/elements/filter', compact('params', 'type'));
	}
	?>
</div>