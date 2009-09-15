<?php if (!User::is('guest')) : ?>
	<?php echo $form->create('Comment', array('url' => '/comments/add')); ?>
	<?php echo $form->input('referer', array('type' => 'hidden', 'value' => $this->here)); ?>
	<?php echo $form->input('foreign_id', array('value' => $id, 'type' => 'hidden')); ?>
	<?php echo $form->input('body', array('label' => false, 'style'=>'width: 380px;')); ?>
	<div class="clear"></div>
	<?php echo $form->submit('Add Comment', array('class' => 'comment-btn', 'div' => 'submit comment')); ?>
	<?php echo $form->end(); ?>
<?php endif; ?>