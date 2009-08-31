<?php 
	$context = ($this->here != '/admin/appeal/add') ?  __('Add Appeal',true) : __('Edit Appeal',true);
?>
<div class="content" id="appeal_form">
  <h1><?php echo $context; ?></h1>
<?php echo $form->create('Appeal');?>
	<fieldset>
 		<legend><?php echo $context;?></legend>
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
