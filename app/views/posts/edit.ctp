<div class="posts form">
  <h2><?php __('Edit Post');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions');?></h3>
    <ul>
      <li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Post.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Post.id'))); ?></li>
      <li><?php echo $html->link(__('List Posts', true), array('action'=>'index'));?></li>
    </ul>
  </div>
<?php echo $form->create('Post');?>
	<fieldset>
 		<legend><?php __('Edit Post');?></legend>
  <?php
    echo $form->input('id');
    echo $form->input('title');
    echo $form->input('body');
  ?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

