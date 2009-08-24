<?php
$referer = isset($referer) ? $referer : $this->here;
?>
<?php echo $form->create('Comment', array('action' => 'edit')); ?>
<?php echo $form->input('id', array('type' => 'hidden'))?>
<?php echo $form->input('referer', array('type' => 'hidden', 'value' => $referer)); ?>
<?php echo $form->input('body', array('div' => 'comment', 'label' => false, 'class' => 'mce')); ?>
<?php echo $form->submit('Save', array('class' => 'comment-btn', 'div' => 'submit commentlong')); ?>
<?php echo $form->end(); ?>