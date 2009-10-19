<?php
if (!User::is('guest')) {
	echo $form->create('Comment', array('url' => '/comments/add'));
	echo $form->input('referer', array('type' => 'hidden', 'value' => $this->here));
	echo $form->input('foreign_id', array('value' => $id, 'type' => 'hidden'));
	echo $form->input('body', array('label' => false));
	echo '<div class="clear"></div>';
	echo $form->submit(__('Add Comment', true), array(
		'class' => 'comment-btn',
		'div' => 'submit comment'
	));
	echo $form->end();
}
?>