<?php
$favorites = $session->read('verbose_favorites');
$favoritesCount = count($session->read('favorites'));
?>
<div class="favorites widget <?php echo $open ?>">
	<div class="widget_header">
		<h3>
			<a href="<?php Router::url(); ?>#" class="toggle <?php echo $open; ?>" id="toggle_favorites">
				<?php echo __('Favorites', true); ?>
				<small>(<?php echo $favoritesCount; ?>)</small>
			</a>
		</h3>
	</div>
	<div class="widget_content">
		<ul class="wrapper_toggle_favorites with_bullets">
			<li>
				<?php
				$label = sprintf(__('Gifts', true) . ' (%s)', $favorites['Gift']);
				echo $html->link($label, array(
					'controller' => 'gifts', 'action' => 'index', 'favorites',
					'plugin' => ''
				));
				?>
			</li>
			<li>
				<?php
				$label = sprintf(__('Supporters', true) . ' (%s)', $favorites['User']);
				echo $html->link($label, array(
					'controller' => 'supporters', 'action' => 'index', 'favorites',
					'plugin' => ''
				));
				?>
			</li>
			<li>
				<?php
				$label = sprintf(__('Transactions', true) . ' (%s)', $favorites['Transaction']);
				echo $html->link($label, array(
					'controller' => 'transactions', 'action' => 'index', 'favorites',
					'plugin' => ''
				));
				?>
			</li>
		</ul>
	</div>
</div>
