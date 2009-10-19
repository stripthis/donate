<div class="segments widget <?php echo $open ?>">
	<div class="widget_header">
		<h3>
			<a href="<?php Router::url(); ?>#" class="toggle <?php echo $open; ?>" id="toggle_segments">
				<?php echo __('Segments', true); ?>
				<small>(<?php echo count($segments); ?>)</small>
			</a>
		</h3>
	</div>
	<div class="widget_content">
		<div class="wrapper_toggle_segments">
			<?php if (!empty($segments)) : ?>
				<ul>
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
			<?php else : ?>
				<?php __('There is nothing to display.')?>
			<?php endif; ?>
		</div>
	</div>
</div>
