<div class="content" id="bud_report">
	<h1>Submit a Bug</h1>
	<?php
	echo $form->create('Bug');
	echo $form->input('url', array(
		'label' => __('What url did you experience the bug on? (optional)', true),
		'class'=>'txt'
	));
	echo $form->input('browser', array(
		'label' => __('Which browser were you using? (optional)', true)
	));
	echo $form->input('last_thing', array(
		'type' => 'textarea',
		'label' => __('What was the last thing you did?', true),
		'rows' => 5,
		'cols' => 90
	));
	echo $form->input('bug_descr', array(
		'type' => 'textarea',
		'label' => __('What exactly was shown to you as a bug?', true),
		'rows'=> 15,
		'cols' => 90
	));
	echo $form->submit(__('Help improve this application!', true), array('class' => 'submit'));
	echo $form->end()
	?>
</div>