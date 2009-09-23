<div class="posts form">
	<h2><?php sprintf(__('Add a new post', true));?></h2>
	<div class="actions">
		<h3><?php sprintf(__('Actions', true));?></h3>
		<ul>
			<li><?php echo $html->link(__('List Posts', true), array('action' => 'index'), array('class' => 'index'));?></li>
		</ul>
	</div>
	<?php echo $form->create('Post');?>
	<fieldset>
		<legend><?php sprintf(__('Add Post', true));?></legend>
		<?php
		echo $form->input('title');
		echo $form->input('body');
		?>
	</fieldset>
	<?php echo $form->end('Submit');?>
</div>