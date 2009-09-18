<div id="leaders_form">
	<h2><?php echo __("Settings");?></h2>
	<?php echo $form->create('Setting', array('action' => 'edit'));?>
	<?php echo $form->input('id');?>
	<?php echo $form->input('vote_cutoff', array('type' => 'datetime', 'empty' => '--'));?>
	<?php echo $form->end('Save');?>
</div>