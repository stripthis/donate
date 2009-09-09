<?php
$typeOptions = array(
	'transaction' => 'Transaction Id'
);
?>
    <div class="filter">
      <?php echo $form->create('Transaction', array('url' => '/admin/transactions/index/' . $type, 'type' => 'get')); ?>
<?php echo $this->element('admin/filters/paging_limit'); ?>
<?php echo $this->element('admin/filters/time_range', array('typeOptions'=>$typeOptions)); ?>
<?php echo $this->element('admin/filters/keyword', array('typeOptions'=>$typeOptions)); ?>
      <?php echo $form->end('Filter');  ?>
    </div>
    <div class="clear"></div>
