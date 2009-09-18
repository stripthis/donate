<?php
$typeOptions = array(
	'all' => 'All',
	'order_id' => 'Order ID (not yet implemented)',
	'name' => 'Name (first name, last name, or both)',
	'country' => 'Country',
	'city' => 'City'
);
?>
<div class="filter">
	<?php echo $form->create('Gift', array('url' => '/admin/supporters/index/' . $type, 'type' => 'get')); ?>
	<?php echo $this->element('admin/filters/paging_limit'); ?>
	<?php echo $this->element('admin/filters/time_range'); ?>
	<?php echo $this->element('admin/filters/keyword', array('typeOptions'=>$typeOptions)); ?>
	<?php echo $form->end('Filter');  ?>
</div>
<div class="clear"></div>