<?php
$headline = isset($headline) ? $headline : 'Comments';
$showForm = isset($showForm) ? $showForm : true;
?>
<?php if ($headline !== false) : ?>
	<h2 style="border: 0px;"><?php echo $headline ?></h2>
<?php endif;?>

<?php if (empty($item['Comment'])): ?>
	<?php
 	$emptyMsg = !empty($emptyMsg) ? $emptyMsg : 'There are currently no comments posted.';
	echo $this->element('warning', array('txt' => $emptyMsg));
	?>
<?php else: ?>
	<?php foreach ($item['Comment'] as $comment) : ?>
		<a name="comment-<?php echo $comment['id']; ?>"></a>
		<div class="comments discussion" id="comment-<?php echo $comment['id']; ?>">
			<div class="comment_name">
				<strong><?php echo $comment['User']['login']?></strong><br/>
				<span id="comment_created"><?php echo $time->timeAgoInWords($comment['created']); ?></span>
			</div>

			<div class="comm"><?php echo $text->autoLink($comment['body'], array('rel' => 'nofollow')); ?>
				<div>
					<small>
						<?php if (User::get('id') == $comment['User']['id']) : ?>
							 <?php
								echo $html->link('Edit',
									array('controller' => 'comments', 'action' => 'edit', $comment['id'], 'admin' => false),
									array('rel' => 'facebox')
								);
							?>
							| <?php echo $html->link('Delete', array(
								'controller' => 'comments', 'action' => 'delete', $comment['id'], 'admin' => false),
								null, 'Are you sure you want to delete this comment?'
							)?>
						<?php endif; ?>
					</small>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	<?php endforeach; ?>
<?php endif; ?>

<?php if (isset($preview)) return; ?>

<div class="comment_login">
	<?php
	if ($showForm) {
		if (empty($modelName)) {
			$modelName = Inflector::classify($this->params['controller']);
		}
		$modelId = false;
		if (isset($item[$modelName])) {
			$modelId = $item[$modelName]['id'];
		} else {
			$modelId = $item['id'];
		}
		echo $this->element('comment_form', array('id' => $modelId, 'plugin' => 'Comments'));
	}
	?>
</div>