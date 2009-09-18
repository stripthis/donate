<?php
$typeOptions = array(
  'all' => 'All',
  'gift' => 'Gift Id',
  'person' => 'Person Name',
  'appeal' => 'Appeal Name'
);
?>
<div class="filter">
	<?php echo $form->create('Gift', array('url' => '/admin/gifts/index/' . $type, 'type' => 'get')); ?>
	<?php echo $this->element('admin/filters/paging_limit'); ?>
	<?php echo $this->element('admin/filters/time_range'); ?>
	<?php echo $this->element('admin/filters/keyword', compact('typeOptions')); ?>
	<?php echo $form->end('Filter');  ?>
</div>
<div class="clear"></div>