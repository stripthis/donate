<cake:nocache>
	<ul class="nav">
		<li><?php echo $html->link(__('Home', true), "/"); ?></li>
			<?php if (User::isAdmin()) : ?>
	    		<li>
					<?php echo $html->link('Admin Dashboard', array(
						'controller' => 'gifts', 'action' => 'index', 'admin' => true
					)); ?>
				</li>
				<li>
					<?php echo $html->link('Appeals', array(
						'controller' => 'appeals', 'action' => 'index', 'admin' => true
					)); ?>
				</li>
				<li>
					<?php echo $html->link('Offices', array(
						'controller' => 'offices', 'action' => 'index', 'admin' => true
					)); ?>
				</li>
				<li>
					<?php echo $html->link('Transactions', array(
						'controller' => 'transactions', 'action' => 'index', 'admin' => true
					)); ?>
				</li>
				<li>
					<?php echo $html->link('Settings', array(
						'controller' => 'settings', 'action' => 'edit', 'admin' => true
					)); ?>
				</li>
				<li>
					<?php echo $html->link('Statistics', array(
						'controller' => 'statistics', 'action' => 'index', 'admin' => true
					)); ?>
				</li>
				<li><?php echo $html->link('Users', array('controller' => 'users', 'action' => 'index', 'admin' => true))?></li>
				<li><?php echo $html->link('Posts', array('controller' => 'posts', 'action' => 'index', 'admin' => true))?></li>
			<?php endif; ?>
			<?php if (!User::isGuest()) : ?>
				<li>
				<?php echo $html->link(__('Dashboard', true), array(
					'controller' => 'users', 'action' => 'dashboard', 'admin' => false));
				?>
				</li>
			<?php endif; ?>
			<li><a href="http://www.greenpeace.org/international/campaigns/climate-change/cool-it-challenge/about"><?php echo __('About', true); ?></a></li>
		</ul>
<cake:nocache>
