<div class="content" id="gifts_index">
	<h2><?php echo __('Gift Statistics', true);?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'gift_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>

	<?php echo $this->element('../gifts/elements/filter', compact('params', 'type'));
	?>
</div>