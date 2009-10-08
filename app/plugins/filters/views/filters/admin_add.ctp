<div class="content" id="filters_index">
	<h1><?php echo $this->pageTitle = 'Adding a Filter'; ?></h1>

	<p><?php echo __('Filters will show up in the sidebar as a widget.', true) ?></p>
	<?php
	echo $form->create('Filter', array('action' => 'add/1'));
	echo $form->input('referer', array('type' => 'hidden', 'value' => $referer));
	echo $form->input('url', array('type' => 'hidden'));
	echo $form->input('name', array('label' => __('Label your filter:', true)));
	echo $form->end('Save');
	?>
</div>