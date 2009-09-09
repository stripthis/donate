<?php
$typeOptions = array(
	'name' => 'Appeal Name',
	'campaign_code' => 'Campaign Code',
	'author_email' => 'Author Email'
);
$paginateOptions = array(10, 20, 40, 50, 75);
$paginateOptions = array_combine($paginateOptions, $paginateOptions);
?>
<div class="filter">
	<?php echo $form->create('Appeal', array('url' => '/admin/appeals/index/' . $type, 'type' => 'get')); ?>
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