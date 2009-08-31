<?php
  $typeOptions = array(
    'all' => 'All',
    'gift' => 'Gift Id',
    'person' => 'Person Name',
    'appeal' => 'Appeal Name',
    'office' => 'Office Name'
  );
?>
    <div class="filter">
      <?php echo $form->create('Gift', array('url' => '/admin/gifts/index/' . $type, 'type' => 'get')); ?>
      <?php echo $form->input('keyword', array('label' => 'Keyword:', 'value' => $keyword)); ?>  
      <?php echo $form->input('search_type', array('label' => 'Type:', 'selected' => $searchType, 'options' => $typeOptions, 'class'=>'full'));  ?>
      <?php echo $form->end('Filter');  ?>
    </div>
    <div class="clear"></div>
