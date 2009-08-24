<?php
$referer = isset($referer) ? $referer : $this->here;
?>
<?php echo $form->create('Comment', array('url' => $this->here)); ?>
<?php echo $form->input('id', array('type' => 'hidden'))?>
<?php
if (!empty($parentId)) {
	echo $form->input('parent_id', array('type' => 'hidden', 'value' => $parentId));
}
if (!empty($foreignId)) {
	echo $form->input('foreign_id', array('type' => 'hidden', 'value' => $foreignId));
}
?>
<?php echo $form->input('referer', array('type' => 'hidden', 'value' => $referer)); ?>
<?php echo $form->input('body', array('div' => 'comment', 'label' => false, 'class' => 'mce')); ?>
<?php echo $form->submit('Save', array('class' => 'comment-btn', 'div' => 'submit commentlong')); ?>
<?php echo $form->end(); ?>