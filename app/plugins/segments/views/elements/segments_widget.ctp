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
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
