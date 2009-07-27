<div class="offices form">
  <h2><?php __('Edit Office');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions');?></h3>
    <ul>
      <li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Office.id')), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Office.id'))); ?></li>
      <li><?php echo $html->link(__('List Offices', true), array('action'=>'index'), array('class'=>'index'));?></li>
    <li><?php echo $html->link(__('List Gateways', true), array('controller'=> 'gateways', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Gateway', true), array('controller'=> 'gateways', 'action'=>'add')); ?> </li>
    </ul>
  </div>
<?php echo $form->create('Office');?>
	<fieldset>
 		<legend><?php __('Edit Office');?></legend>
  <?php
    echo $form->input('id');
    echo $form->input('name');
    echo $form->input('parent_id');
    echo $form->input('country_id');
    echo $form->input('state_id');
    echo $form->input('city_id');
    echo $form->input('Gateway');
  ?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

