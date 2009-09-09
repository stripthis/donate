<div class="content" id="gifts_index">
  <h2><?php __('Gift Export');?></h2>

	<?php
	echo $form->create('Gift', array('url' => $this->here));
	echo $form->input('process', array('type' => 'hidden', 'value' => '1'));
	$fields = array(
		'Gift.id' => 'Id',
		'Contact.fname' => 'First Name',
		'Contact.lname' => 'Last Name',
		'Contact.email' => 'Email',
	);
	echo $form->input('fields', array(
		'label' => 'Fields to Include:', 'options' => $fields,
		'multiple' => 'checkbox'
	));

	echo $form->input('softdelete', array(
		'label' => 'Archive Selected Rows?', 'type' => 'checkbox'
	));

	echo $form->input('download', array(
		'label' => 'Download the File?', 'type' => 'checkbox'
	));

	$formats = array('csv' => 'CSV');
	echo $form->input('format', array(
		'label' => 'Format:', 'options' => $formats
	));
	echo $form->end('Export');
	?>
</div>