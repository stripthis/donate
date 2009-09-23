<div class="content" id="offices_form">
	<h2><?php sprintf(__('Add Office', true));?></h2>
	<div class="actions">
		<h3><?php sprintf(__('Actions', true));?></h3>
		<ul>
			<li><?php echo $html->link(__('List Offices', true), array('action'=>'index'), array('class'=>'index'));?></li>
			<li><?php echo $html->link(__('List Gateways', true), array('controller'=> 'gateways', 'action'=>'index')); ?> </li>
			<li><?php echo $html->link(__('New Gateway', true), array('controller'=> 'gateways', 'action'=>'add')); ?> </li>
		</ul>
	</div>
	<?php echo $form->create('Office');?>
	<fieldset>
		<legend><?php sprintf(__('Add Office', true));?></legend>
		<?php
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