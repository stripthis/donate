<div class="posts form">
  <h2><?php __('Add Post');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions');?></h3>
    <ul>
      <li><?php echo $html->link(__('List Posts', true), array('action'=>'index'));?></li>
    </ul>
  </div>
<?php echo $form->create('Post');?>
	<fieldset>
 		<legend><?php __('Add Post');?></legend>
  <?php
    echo $form->input('title');
    echo $form->input('body');
  ?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

