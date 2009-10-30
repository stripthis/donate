<?php
$typeOptions = array(
	'name' => 'Appeal Name',
	'campaign_code' => 'Campaign Code',
	'author_email' => 'Author Email'
);
?>
<div class="filter">
	<?php echo $form->create('Appeals', array('url' => '/admin/appeals/index', 'type' => 'get')); ?>
	<?php echo $this->element('admin/filters/paging_limit'); ?>
	<?php echo $this->element('admin/filters/time_range'); ?>
	<?php echo $this->element('admin/filters/keyword', compact('typeOptions')); ?>
	<?php echo $form->end('Filter');  ?>
</div>
<div class="clear"></div>