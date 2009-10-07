<div class="content" id="segments_index">
	<h1><?php echo $this->pageTitle = 'Adding a Segment'; ?></h1>

	<?php
	echo $form->create('Segment', array('action' => 'add/1'));
	echo $form->input('referer', array('type' => 'hidden', 'value' => $referer));
	echo $form->input('model', array('type' => 'hidden'));
	echo $form->input('items', array('type' => 'hidden'));
	echo $form->input('name', array('label' => 'Name For Your Segment:'));
	echo $form->end('Save');
	?>
</div>