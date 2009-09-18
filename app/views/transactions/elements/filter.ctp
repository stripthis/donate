<?php
$typeOptions = array(
	'transaction' => 'Transaction Id'
);
?>
<div class="filter">
	<?php
	echo $form->create('Transaction', array('url' => '/admin/transactions/index/' . $type, 'type' => 'get'));
	echo $this->element('admin/filters/paging_limit');
	echo $this->element('admin/filters/time_range', compact('typeOptions'));
	echo $this->element('admin/filters/keyword', compact('typeOptions'));
	echo $form->end('Filter');
	?>
</div>
<div class="clear"></div>