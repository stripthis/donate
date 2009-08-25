<?php
  $typeOptions = array(
    'gift' => 'Gift Id',
    'person' => 'Person Name',
    'appeal' => 'Appeal Name',
    'office' => 'Office Name'
  );
?>
    <div class="filter">
      <?php echo $form->create('Gift', array('url' => '/admin/gifts/index', 'type' => 'get')); ?>
      <?php echo $form->input('keyword', array('label' => 'Keyword:', 'value' => $keyword)); ?>  
      <?php echo $form->input('type', array('label' => 'Type:', 'selected' => $type, 'options' => $typeOptions, 'class'=>'full'));  ?>
      <?php echo $form->end('Filter');  ?>
    </div>
    <div class="clear"></div>
