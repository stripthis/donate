<div class="transactions view">
<h2><?php  __('Transaction');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('Delete Transaction', true), array('action'=>'delete', $transaction['Transaction']['id']),  array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $transaction['Transaction']['id'])); ?> </li>
    </ul>
  </div>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $transaction['Transaction']['id']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent Transaction'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $html->link($transaction['ParentTransaction']['id'], array('controller'=> 'transactions', 'action'=>'view', $transaction['ParentTransaction']['id'])); ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Gateway'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $html->link($transaction['Gateway']['name'], array('controller'=> 'gateways', 'action'=>'view', $transaction['Gateway']['id'])); ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('External Id'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $transaction['Transaction']['external_id']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Gift'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $html->link($transaction['Gift']['title'], array('controller'=> 'gifts', 'action'=>'view', $transaction['Gift']['id'])); ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $transaction['Transaction']['status']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Amount'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $transaction['Transaction']['amount']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $transaction['Transaction']['created']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $transaction['Transaction']['modified']; ?>
      &nbsp;
    </dd>
	</dl>
</div>

