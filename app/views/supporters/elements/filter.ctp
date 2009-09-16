<?php
$typeOptions = array(
  'all' => 'All',
  'gift' => 'Gift ID',
  'person' => 'Person Name (or firstname)',
  'appeal' => 'Appeal Name'
);
?>
<div class="filter">
	<?php echo $form->create('Supporter', array('url' => '/admin/gifts/index/' . $type, 'type' => 'get')); ?>
	<?php echo $this->element('admin/filters/paging_limit'); ?>
	<?php echo $this->element('admin/filters/time_range'); ?>
	<?php echo $this->element('admin/filters/keyword', array('typeOptions'=>$typeOptions)); ?>
	<?php echo $form->end('Filter');  ?>
</div>
<div class="clear"></div>