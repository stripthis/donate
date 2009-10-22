<?php 
if (!isset($widgets)) {
	$widgets = array('search', 'favorites', 'chat', 'shortcuts','news');
	if (pluginLoaded('Segments')) {
		$widgets[] = 'segments.segments_widget';
	}
	if (pluginLoaded('Filters')) {
		$widgets[] = 'filters.filters_widget';
	}
}
?>
<!-- SIDEBAR -->
<div class="sidebar_wrapper">
	<div class="sidebar" id="right_sidebar">
		<?php 
		foreach ($widgets as $widget) {
			$path = 'admin/sidebar/';
			$plugin = '';
			if (strpos($widget, '.') !== false) {
				$data = explode('.', $widget);
				$path = '';
				$widget = $data[1];
				$plugin = $data[0];
			}

			$name = r('_widget', '', $widget);
			$open = isset($widgetState[$name]) && $widgetState[$name]
					? 'open' : 'closed';
			
		  //pr($path . $widget);
			echo $this->element($path . $widget, compact('plugin', 'open'));
		}
		?>
		<?php
		echo $html->link(__('Save Widget Config', true), '#', array('class' => 'save-widgets'));?>
	</div>
</div>