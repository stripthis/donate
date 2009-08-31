<div class="content" id="bud_report">
<h1>Submit a Bug</h1>
<?php echo $form->create('Bug') ?>
<?php echo $form->input('url', array('label'=>'What url did you experience the bug on (optional) ?', 'class'=>'txt')) ?>
<?php echo $form->input('browser', array('label'=>'Which browser were you using (optional) ?')) ?>
<?php echo $form->input('last_thing', array('type' => 'textarea', 'label'=>'What was the last thing you did?', 'rows'=>5, 'cols' => 90)) ?>
<?php echo $form->input('bug_descr', array('type' => 'textarea', 'label'=>'What exactly was shown to you as a bug ?', 'rows'=>15, 'cols' => 90)) ?>
<?php echo $form->submit('Help improve this application!', array('class' => 'submit')) ?>
<?php echo $form->end() ?>
</div>