<?php
$open = (!isset($options['open'])) ? 'close' : $options['open'];
?>
<div class="filters widget">
	<div class="widget_header">
		<h3>
			<a href="<?php Router::url(); ?>#" class="toggle <?php echo $open; ?>" id="toggle_filters">
				<?php echo __('Filters', true); ?>
				<small>(<?php echo count($filters); ?>)</small>
			</a>
		</h3>
	</div>
	<div class="widget_content">
		<ul class="wrapper_toggle_filters">
			<?php foreach ($filters as $filter) : ?>
				<li>
					<?php
					echo $html->link($filter['Filter']['name'], $filter['Filter']['url']);
					?>
					-
					<?php
					echo $html->link(__('Delete', true), array(
						'controller' => 'filters', 'action' => 'delete', $filter['Filter']['id'],
						'plugin' => 'filters'
					), null, __('Are you sure? There is no going back ..', true));
					?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
