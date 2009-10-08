<?php
$open = (!isset($options['open'])) ? 'close' : $options['open'];
?>
<div class="segments widget">
	<div class="widget_header">
		<h3>
			<a href="<?php Router::url(); ?>#" class="toggle <?php echo $open; ?>" id="toggle_segments">
				<?php echo __('Segments', true); ?>
				<small>(<?php echo count($segments); ?>)</small>
			</a>
		</h3>
	</div>
	<div class="widget_content">
		<ul class="wrapper_toggle_segments">
			<?php foreach ($segments as $segment) : ?>
				<li>
					<?php
					echo $html->link($segment['Segment']['name'], array(
						'controller' => 'segments', 'action' => 'view', $segment['Segment']['id'],
						'plugin' => 'segments'
					));
					?>
					-
					<?php
					echo $html->link(__('Delete', true), array(
						'controller' => 'segments', 'action' => 'delete', $segment['Segment']['id'],
						'plugin' => 'segments'
					), null, __('Are you sure? There is no going back ..', true));
					?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
