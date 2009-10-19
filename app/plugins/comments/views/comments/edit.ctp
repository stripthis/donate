<?php
$referer = isset($referer) ? $referer : $this->here;
echo $form->create('Comment', array('url' => $this->here));
echo $form->input('id', array('type' => 'hidden'));

if (!empty($parentId)) {
	echo $form->input('parent_id', array('type' => 'hidden', 'value' => $parentId));
}
if (!empty($foreignId)) {
	echo $form->input('foreign_id', array('type' => 'hidden', 'value' => $foreignId));
}

echo $form->input('referer', array('type' => 'hidden', 'value' => $referer));
echo $form->input('body', array('div' => 'comment', 'label' => false, 'class' => 'mce'));
echo $form->submit('Save', array('class' => 'comment-btn', 'div' => 'submit commentlong'));
echo $form->end();
?>