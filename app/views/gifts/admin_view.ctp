<div class="gifts view">
<h2><?php  __('Gift');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('Edit Gift', true), array('action'=>'edit', $gift['Gift']['id']), array('class'=>'edit')); ?> </li>
      <li><?php echo $html->link(__('Delete Gift', true), array('action'=>'delete', $gift['Gift']['id']),  array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $gift['Gift']['id'])); ?> </li>
    </ul>
  </div>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['id']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Office'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $html->link($gift['Office']['name'], array('controller'=> 'offices', 'action'=>'view', $gift['Office']['id'])); ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Type'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['type']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['amount']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['description']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Frequency'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['frequency']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Appeal'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $html->link($gift['Appeal']['name'], array('controller'=> 'appeals', 'action'=>'view', $gift['Appeal']['id'])); ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Fname'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['fname']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Lname'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['lname']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Salutation'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['salutation']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['title']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Address'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['address']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Zip'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['zip']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Country'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Country']['name']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['email']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['created']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $gift['Gift']['modified']; ?>
      &nbsp;
    </dd>
	</dl>
</div>

<?php echo $this->element('comments', array('item' => $gift))?>