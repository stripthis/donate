<?php 
	//@todo widgets: help, chat, twitter, etc. 
	if (!isset($widgets)) {
		$widgets = array('search','favorites','shortcuts','news');
	}
	if (!isset($widgets_options)) {
		//@todo dynamic user based widget preferences
		$widgets_options = array(
			'search' => array('open' => true)
		);
	}
?>
		<!-- SIDEBAR -->
		<div class="sidebar_wrapper">
			<div class="sidebar" id="right_sidebar">
<?php 
	foreach($widgets as $widget) {
		$options = (isset($widgets_options[$widget])) ? $widgets_options[$widget] : array();
		echo $this->element('admin/sidebar/'.$widget, array('options' => $options)); 
	}
?>
    	</div>
    </div>
