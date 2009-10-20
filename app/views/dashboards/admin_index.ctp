<div class="content users index">
	<h2><?php echo __('Root Configuration', true);?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'admin_root_admin_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<p class="message information">
		<?php __('In this section you can administer users, payment gateway, i.e. your office(s) configuration'); ?>
	</p>
	<div class="quicklinks">
		<ul>
			<li>
			<?php
			$officeImg = $html->image('icons/XL/office_config.png', array('alt' => 'offices'));
			echo $html->link($officeImg . " " . __('Manage offices', true), 
					array('admin' => true, 'controller' => 'offices'),
					array('escape' => false)
				);
			?>
			</li>
			<li>
				<?php
				$usersImg = $html->image('icons/XL/users.png', array('alt' => 'users'));
				echo $html->link($usersImg . " " . __('Manage users', true),
					array('admin' => true, 'controller' => 'users'),
					array('escape' => false)
				);
				?>
			</li>
			<li>
				<?php
				$rootImg = $html->image('icons/XL/root.png', array('alt' => 'users'));
				echo $html->link($rootImg . " " . __('Manage roles', true),
					array('admin' => true, 'controller' => 'roles'),
					array('escape' => false)
				);
				?>
			</li>
		</ul>
  </div>
</div>