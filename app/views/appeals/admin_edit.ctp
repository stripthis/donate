<div class="appeals form">
  <h2><?php __('Edit Appeal');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions');?></h3>
    <ul>
      <li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Appeal.id')), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Appeal.id'))); ?></li>
    </ul>
  </div>
<?php echo $form->create('Appeal');?>
	<fieldset>
 		<legend><?php __('Edit Appeal');?></legend>
  <?php
    echo $form->input('id');
    echo $form->input('name');
    echo $form->input('campaign_code');
    echo $form->input('default');
    echo $form->input('starred');
    echo $form->input('cost');
    echo $form->input('reviewed');
    echo $form->input('status');
    echo $form->input('country_id', array('options' => $countryOptions));
  ?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

