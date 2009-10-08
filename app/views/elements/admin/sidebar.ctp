<?php 
if (!isset($widgets)) {
	$widgets = array('search', 'favorites', 'chat', 'shortcuts','news');
	if (pluginLoaded('Segments')) {
		$widgets[] = 'Segments.segments_widget';
	}
	if (pluginLoaded('Filters')) {
		$widgets[] = 'Filters.filters_widget';
	}
}
if (!isset($widgets_options)) {
	$widgets_options = array(
		'search' => array('open' => true)
	);
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

			if (!isset($widgets_options[$widget])) {
				$widgets_options[$widget] = array();
			}

			echo $this->element($path . $widget, array(
				'options' => $widgets_options[$widget], 'plugin' => $plugin
			));
		}
		?>
	</div>
</div>
