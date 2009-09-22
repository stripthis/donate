<div class="content" id="transactions_index">
	<h2><?php echo __('Import Transactions', true); ?></h2>
	<?php
	echo $form->create('Import', array('url' => $this->here, 'type' => 'file'));
	echo $form->input('file', array('label' => 'File', 'type' => 'file'));
	$options = array('friends' => 'Friends Recurring');
	echo $form->input('template', array('label' => 'Template', 'options' => $options));
	echo $form->input('description', array('label' => 'Description', 'type' => 'textbox'));
	echo $form->end('Import');
	?>
</div>