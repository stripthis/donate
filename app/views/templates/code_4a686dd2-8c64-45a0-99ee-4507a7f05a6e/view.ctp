<div class="gifts view">
<h2><?php  __('Gift');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('Edit Gift', true), array('action'=>'edit', $gift['Gift']['id']), array('class'=>'edit')); ?> </li>
      <li><?php echo $html->link(__('Delete Gift', true), array('action'=>'delete', $gift['Gift']['id']),  array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $gift['Gift']['id'])); ?> </li>
      <li><?php echo $html->link(__('List Gifts', true), array('action'=>'index'),array('class'=>'index')); ?> </li>
      <li><?php echo $html->link(__('New Gift', true), array('action'=>'add'),array('class'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Appeals', true), array('controller'=> 'appeals', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Appeal', true), array('controller'=> 'appeals', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Countries', true), array('controller'=> 'countries', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Country', true), array('controller'=> 'countries', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Offices', true), array('controller'=> 'offices', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Office', true), array('controller'=> 'offices', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Transactions', true), array('controller'=> 'transactions', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Transaction', true), array('controller'=> 'transactions', 'action'=>'add')); ?> </li>
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
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $html->link($gift['User']['login'], array('controller'=> 'users', 'action'=>'view', $gift['User']['id'])); ?>
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
      <?php echo $html->link($gift['Country']['name'], array('controller'=> 'countries', 'action'=>'view', $gift['Country']['id'])); ?>
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

<div class="related">
	<h3><?php __('Related Transactions');?></h3>
	<?php if (!empty($gift['Transaction'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
    <th><?php __('Id'); ?></th>
    <th><?php __('Parent Id'); ?></th>
    <th><?php __('Gateway Id'); ?></th>
    <th><?php __('Order Id'); ?></th>
    <th><?php __('Gift Id'); ?></th>
    <th><?php __('Status'); ?></th>
    <th><?php __('Amount'); ?></th>
    <th><?php __('Created'); ?></th>
    <th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
  <?php
		$i = 0;
		foreach ($gift['Transaction'] as $transaction):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
    <tr<?php echo $class;?>>
      <td><?php echo $transaction['id'];?></td>
      <td><?php echo $transaction['parent_id'];?></td>
      <td><?php echo $transaction['gateway_id'];?></td>
      <td><?php echo $transaction['order_id'];?></td>
      <td><?php echo $transaction['gift_id'];?></td>
      <td><?php echo $transaction['status'];?></td>
      <td><?php echo $transaction['amount'];?></td>
      <td><?php echo $transaction['created'];?></td>
      <td><?php echo $transaction['modified'];?></td>
      <td class="actions">
        <?php echo $html->link(__('View', true), array('controller'=> 'transactions', 'action'=>'view', $transaction['id'])); ?>
        <?php echo $html->link(__('Edit', true), array('controller'=> 'transactions', 'action'=>'edit', $transaction['id'])); ?>
        <?php echo $html->link(__('Delete', true), array('controller'=> 'transactions', 'action'=>'delete', $transaction['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $transaction['id'])); ?>
      </td>
    </tr>
  <?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Transaction', true), array('controller'=> 'transactions', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
