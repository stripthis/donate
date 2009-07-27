<div class="transactions view">
<h2><?php  __('Transaction');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('Edit Transaction', true), array('action'=>'edit', $transaction['Transaction']['id']), array('class'=>'edit')); ?> </li>
      <li><?php echo $html->link(__('Delete Transaction', true), array('action'=>'delete', $transaction['Transaction']['id']),  array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $transaction['Transaction']['id'])); ?> </li>
      <li><?php echo $html->link(__('List Transactions', true), array('action'=>'index'),array('class'=>'index')); ?> </li>
      <li><?php echo $html->link(__('New Transaction', true), array('action'=>'add'),array('class'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Transactions', true), array('controller'=> 'transactions', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Parent Transaction', true), array('controller'=> 'transactions', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Gateways', true), array('controller'=> 'gateways', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Gateway', true), array('controller'=> 'gateways', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Gifts', true), array('controller'=> 'gifts', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Gift', true), array('controller'=> 'gifts', 'action'=>'add')); ?> </li>
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

