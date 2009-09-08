<?php
$typeOptions = array(
	'name' => __('Name', true),
	'email' => __('Email', true)
);
$paginateOptions = array(10, 20, 40, 50, 75);
$paginateOptions = array_combine($paginateOptions, $paginateOptions);
?>
<div class="filter">
	<?php echo $form->create('User', array('url' => '/admin/users/index/' . $type, 'type' => 'get')); ?>
	<?php echo $form->input('keyword', array('label' => 'Keyword:', 'value' => $params['keyword'])); ?>  
	<?php echo $form->input('search_type', array('label' => 'Type:', 'selected' => $params['search_type'], 'options' => $typeOptions, 'class'=>'full')); ?>
  <?php echo $form->input('my_limit', array(
'label' => 'Results per Page:',
'selected' => $params['my_limit'],
'options' => $paginateOptions,
)); ?>
  <?php echo $form->input('custom_limit', array(
'label' => 'or custom:',
'value' => $params['custom_limit']
)); ?>
	<?php echo $form->end('Filter');  ?>
</div>
<div class="clear"></div>
