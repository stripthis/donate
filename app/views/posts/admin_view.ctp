<div class="posts view">
<h2><?php  __('Post');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions');?></h3>
    <ul>
      <li><?php echo $html->link(__('Edit Post', true), array('action'=>'edit', $post['Post']['id']), array('class'=>'edit')); ?> </li>
    <li><?php echo $html->link(__('Delete Post', true), array('action'=>'delete', $post['Post']['id']), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $post['Post']['id'])); ?> </li>
    <li><?php echo $html->link(__('List Posts', true), array('action'=>'index'),array('class'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Post', true), array('action'=>'add'),array('class'=>'add')); ?> </li>
    </ul>
  </div>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $post['Post']['id']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $post['Post']['title']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Body'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $post['Post']['body']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $post['Post']['created']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $post['Post']['modified']; ?>
      &nbsp;
    </dd>
	</dl>
</div>

