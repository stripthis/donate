<div class="transactions form">
  <h2><?php __('Add Transaction');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions');?></h3>
    <ul>
      <li><?php echo $html->link(__('List Transactions', true), array('action'=>'index'), array('class'=>'index'));?></li>
    <li><?php echo $html->link(__('List Transactions', true), array('controller'=> 'transactions', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Parent Transaction', true), array('controller'=> 'transactions', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Gateways', true), array('controller'=> 'gateways', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Gateway', true), array('controller'=> 'gateways', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Gifts', true), array('controller'=> 'gifts', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Gift', true), array('controller'=> 'gifts', 'action'=>'add')); ?> </li>
    </ul>
  </div>
<?php echo $form->create('Transaction');?>
	<fieldset>
 		<legend><?php __('Add Transaction');?></legend>
  <?php
    echo $form->input('parent_id');
    echo $form->input('gateway_id');
    echo $form->input('external_id');
    echo $form->input('gift_id');
    echo $form->input('status');
    echo $form->input('amount');
  ?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

