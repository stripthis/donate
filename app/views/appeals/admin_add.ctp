<div class="appeals form">
	<h2><?php __('Add Appeal');?></h2>
	<div class="actions">
		<h3><?php echo __('Actions');?></h3>
		<ul>
			<li><?php echo $html->link(__('List Appeals', true), array('action'=>'index'), array('class'=>'index'));?></li>
			<li><?php echo $html->link(__('List Appeals', true), array('controller'=> 'appeals', 'action'=>'index')); ?> </li>
			<li><?php echo $html->link(__('New Parent', true), array('controller'=> 'appeals', 'action'=>'add')); ?> </li>
			<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
			<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
			<li><?php echo $html->link(__('List Countries', true), array('controller'=> 'countries', 'action'=>'index')); ?> </li>
			<li><?php echo $html->link(__('New Country', true), array('controller'=> 'countries', 'action'=>'add')); ?> </li>
		</ul>
	</div>
	<?php echo $form->create('Appeal');?>
	<fieldset>
		<legend><?php __('Add Appeal');?></legend>
		<?php
		echo $form->input('parent_id');
		echo $form->input('name');
		echo $form->input('campaign_code');
		echo $form->input('default');
		echo $form->input('cost');
		echo $form->input('reviewed');
		echo $form->input('status');
		echo $form->input('country_id');
		echo $form->input('user_id');
		?>
	</fieldset>
	<?php echo $form->end('Submit');?>
</div>