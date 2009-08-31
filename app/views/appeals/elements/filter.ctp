<?php
$typeOptions = array(
	'name' => 'Appeal Name',
	'campaign_code' => 'Campaign Code',
	'country' => 'Country',
	'author_email' => 'Author Email'
);
$paginateOptions = array(10, 20, 40, 50, 75);
$paginateOptions = array_combine($paginateOptions, $paginateOptions);
?>
<div class="filter">
	<?php echo $form->create('Appeal', array('url' => '/admin/appeals', 'type' => 'get')); ?>
	<?php echo $form->input('keyword', array('label' => 'Keyword:', 'value' => $keyword)); ?>  
	<?php echo $form->input('search_type', array('label' => 'Type:', 'selected' => $searchType, 'options' => $typeOptions, 'class'=>'full')); ?>
  <?php echo $form->input('my_limit', array(
'label' => 'Results per Page:',
'selected' => $limit,
'options' => $paginateOptions,
)); ?>
  <?php echo $form->input('custom_limit', array(
'label' => 'or custom:',
'value' => $customLimit
)); ?>
	<?php echo $form->end('Filter');  ?>
</div>
<div class="clear"></div>
