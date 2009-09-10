<div class="content" id="gifts_index">
  <h2><?php __('Transaction Export');?></h2>

	<?php
	echo $form->create('Transaction', array('url' => $this->here));
	echo $form->input('process', array('type' => 'hidden', 'value' => '1'));
	$fields = array(
		'Transaction.serial' => 'Id',
		'Transaction.amount' => 'Amount',
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