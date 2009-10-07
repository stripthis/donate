<div class="content" id="smileys_index">
	<h1><?php echo $this->pageTitle = 'Smiley Import'; ?></h1>

	<?php
	echo $form->create('Smiley', array('action' => 'import', 'type' => 'file'));
	echo $form->input('file', array('type' => 'file'));
	echo $form->end('Save');
	?>
</div>