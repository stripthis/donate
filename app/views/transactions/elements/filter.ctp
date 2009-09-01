<?php
$typeOptions = array(
	'transaction' => 'Transaction Id'
);
$paginateOptions = array(10, 20, 40, 50, 75);
$paginateOptions = array_combine($paginateOptions, $paginateOptions);
?>
    <div class="filter">
      <?php echo $form->create('Transaction', array('url' => '/admin/transactions', 'type' => 'get')); ?>
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
      <?php echo $form->input('start_date', array(
        'label' => 'Start Date:',
        'type' => 'date',
        'selected' => $params['start_date'],
        'dateFormat' => 'MY',
        'maxYear' => date('Y'),
		'empty' => '--'
      ));
      ?>
      <?php echo $form->input('end_date', array(
        'label' => 'End Date:',
        'type' => 'date',
        'selected' => $params['end_date'],
        'dateFormat' => 'MY',
        'maxYear' => date('Y'),
		'empty' => '--'
      ));
      ?>
      <?php echo $form->end('Filter');  ?>
    </div>
    <div class="clear"></div>