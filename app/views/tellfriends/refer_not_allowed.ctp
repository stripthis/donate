<div id="referDiv">
	<?php echo $form->create('tellafriend', array('url' =>array('controller'=>'tellfriends', 'action'=>'refer')   )); ?>
	<fieldset>
	  <legend><?php echo __('Tell A Friend'); ?></legend>
	  <br />
	  <ul>
		<li><?php echo Configure::read('App.tellafriendError'); ?></li>
	  </ul>
	</fieldset>
</div>