<div class="gifts form">
  <h2><?php __('Add Gift');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions');?></h3>
    <ul>
      <li><?php echo $html->link(__('List Gifts', true), array('action'=>'index'), array('class'=>'index'));?></li>
    <li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Appeals', true), array('controller'=> 'appeals', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Appeal', true), array('controller'=> 'appeals', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Countries', true), array('controller'=> 'countries', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Country', true), array('controller'=> 'countries', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Offices', true), array('controller'=> 'offices', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Office', true), array('controller'=> 'offices', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Transactions', true), array('controller'=> 'transactions', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Transaction', true), array('controller'=> 'transactions', 'action'=>'add')); ?> </li>
    </ul>
  </div>
<?php echo $form->create('Gift');?>
	<fieldset>
 		<legend><?php __('Add Gift');?></legend>
  <?php
    echo $form->input('office_id');
    echo $form->input('type');
    echo $form->input('amount');
    echo $form->input('description');
    echo $form->input('frequency');
    echo $form->input('appeal_id');
    echo $form->input('user_id');
    echo $form->input('fname');
    echo $form->input('lname');
    echo $form->input('salutation');
    echo $form->input('title');
    echo $form->input('address');
    echo $form->input('zip');
    echo $form->input('country_id');
    echo $form->input('email');
  ?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

