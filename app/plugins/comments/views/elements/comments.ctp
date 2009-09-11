<?php
$headline = isset($headline) ? $headline : 'Comments';
$showForm = isset($showForm) ? $showForm : true;
$items = !isset($items) ? $item['Comment'] : $items;
if (empty($modelName)) {
	$modelName = Inflector::classify($this->params['controller']);
}
$modelId = false;
if (isset($item[$modelName])) {
	$modelId = $item[$modelName]['id'];
} else {
	$modelId = $item['id'];
}
?>
<?php if ($headline !== false) : ?>
	<h2 style="border: 0px;"><?php echo $headline ?></h2>
<?php endif;?>

<?php
if (empty($items)) {
 	$emptyMsg = !empty($emptyMsg) ? $emptyMsg : 'There are currently no comments posted.';
	echo $this->element('warning', array('txt' => $emptyMsg));
} else {
	foreach ($items as $comment) {
		echo $this->element('commentlet', array(
			'comment' => $comment, 'plugin' => 'comments',
			'depth' => 1, 'commentMethod' => $commentMethod,
			'modelId' => $modelId
		));
	}
}
if (isset($preview)) {
	return;
}
?>
<div class="comment_login">
	<?php
	if ($showForm) {
		echo $this->element('comment_form', array('id' => $modelId, 'plugin' => 'comments'));
	}
	?>
</div>