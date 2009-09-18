<?php
$typeOptions = array(
	'name' => __('Name', true),
	'email' => __('Email', true)
);
?>
<div class="filter">
	<?php echo $form->create('Users', array('url' => '/admin/users/index/' . $type, 'type' => 'get')); ?>
	<?php echo $this->element('admin/filters/paging_limit'); ?>
	<?php echo $this->element('admin/filters/time_range'); ?>
	<?php echo $this->element('admin/filters/keyword', compact('typeOptions')); ?>
	<?php echo $form->end('Filter');  ?>
</div>
<div class="clear"></div>