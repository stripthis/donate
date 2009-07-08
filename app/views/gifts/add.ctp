<h1>Create A Gift</h1>

<?php echo $form->create('Gift', array('url' => $this->here))?>
<?php echo $form->input('type', array('label' => 'Type:', 'options' => Configure::read('App.gift_types')))?>
<?php echo $form->input('amount', array('label' => 'Amount:'))?>
<?php echo $form->input('recurring', array('label' => 'Recurring?'))?>
<div class="recurring-opts">
	<?php echo $form->input('start', array('label' => 'Start:'))?>
	<?php echo $form->input('end', array('label' => 'End:'))?>
	<?php echo $form->input('frequency', array('label' => 'Frequency:'))?>
</div>
<?php echo $form->input('description', array('label' => 'Comments:'))?>
<?php echo $form->input('appeal_id', array('label' => 'Appeal:', 'options' => $appealOptions, 'empty' => '--'))?>
<?php echo $form->end('Save')?>