<?php
$typeOptions = array(
	'transaction' => 'Transaction Id'
);
$paginateOptions = array(10, 20, 40, 50, 75);
$paginateOptions = array_combine($paginateOptions, $paginateOptions);
?>
    <div class="filter">
      <?php echo $form->create('Gift', array('url' => '/admin/transactions', 'type' => 'get')); ?>
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
      <?php echo $form->input('startDate', array(
        'label' => 'Start Date:',
        'type' => 'date',
        'selected' => $startDate,
        'dateFormat' => 'MY',
        'maxYear' => date('Y')
      ));
      ?>
      <?php echo $form->input('endDate', array(
        'label' => 'End Date:',
        'type' => 'date',
        'selected' => $endDate,
        'dateFormat' => 'MY',
        'maxYear' => date('Y')
      ));
      ?>
      <?php echo $form->end('Filter');  ?>
    </div>
    <div class="clear"></div>
