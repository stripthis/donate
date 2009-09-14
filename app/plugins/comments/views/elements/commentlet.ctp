<a name="comment-<?php echo $comment['Comment']['id']; ?>"></a>
<div class="comments discussion" id="comment-<?php echo $comment['Comment']['id']; ?>">
	<div class="comment_name">
		<strong><?php echo $comment['User']['login']?></strong><br/>
		<span id="comment_created"><?php echo $time->timeAgoInWords($comment['Comment']['created']); ?></span>
	</div>

	<div class="comm"><?php echo $text->autoLink($comment['Comment']['body'], array('rel' => 'nofollow')); ?>
		<div>
			<small>
				<?php
				if ($commentMethod == 'threaded') {
					$actions = array(
						$html->link('Reply', array('controller' => 'comments',
							'action' => 'add', 'admin' => false,
							'parent_id' => $comment['Comment']['id'],
							'foreign_id' => $modelId
						))
					);
				}
				if (User::get('id') == $comment['User']['id']) {
					$actions[] = $html->link('Edit', array(
						'controller' => 'comments', 'action' => 'edit', $comment['Comment']['id'], 'admin' => false)
					);
					$actions[] = $html->link('Delete', array('controller' => 'comments',
						'action' => 'delete', $comment['Comment']['id'], 'admin' => false),
						null, 'Are you sure?'
					);
				}
				echo implode(' | ', $actions);
				?>
			</small>
		</div>
	</div>
	<?php
	if (isset($comment['children'])) {
		foreach ($comment['children'] as $comment) {
			echo $this->element('commentlet', array(
				'comment' => $comment, 'plugin' => 'comments',
				'depth' => 1, 'commentMethod' => $commentMethod,
				'modelId' => $modelId
			));
		}
	}
	?>
</div>
<div class="clear"></div>