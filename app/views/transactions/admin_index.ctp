  <div class="transactions index">
  <h2><?php __('Transactions');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('New Transaction', true), array('action'=>'add'),array('class'=>'add')); ?></li>
      <li><?php echo $html->link(__('List Transactions', true), array('controller'=> 'transactions', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Parent Transaction', true), array('controller'=> 'transactions', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Gateways', true), array('controller'=> 'gateways', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Gateway', true), array('controller'=> 'gateways', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Gifts', true), array('controller'=> 'gifts', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Gift', true), array('controller'=> 'gifts', 'action'=>'add')); ?> </li>
    </ul>
  </div>
  <table cellpadding="0" cellspacing="0">
  <tr>
    	<th><?php echo $paginator->sort('id');?></th>
    	<th><?php echo $paginator->sort('parent_id');?></th>
    	<th><?php echo $paginator->sort('gateway_id');?></th>
    	<th><?php echo $paginator->sort('external_id');?></th>
    	<th><?php echo $paginator->sort('gift_id');?></th>
    	<th><?php echo $paginator->sort('status');?></th>
    	<th><?php echo $paginator->sort('amount');?></th>
    	<th><?php echo $paginator->sort('created');?></th>
    	<th><?php echo $paginator->sort('modified');?></th>
    	<th class="actions"><?php __('Actions');?></th>
  </tr>
<?php
$i = 0;
foreach ($transactions as $transaction):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
  <tr<?php echo $class;?>>
    <td>
      <?php echo $transaction['Transaction']['id']; ?>
    </td>
    <td>
      <?php echo $html->link($transaction['ParentTransaction']['id'], array('controller'=> 'transactions', 'action'=>'view', $transaction['ParentTransaction']['id'])); ?>
    </td>
    <td>
      <?php echo $html->link($transaction['Gateway']['name'], array('controller'=> 'gateways', 'action'=>'view', $transaction['Gateway']['id'])); ?>
    </td>
    <td>
      <?php echo $transaction['Transaction']['external_id']; ?>
    </td>
    <td>
      <?php echo $html->link($transaction['Gift']['title'], array('controller'=> 'gifts', 'action'=>'view', $transaction['Gift']['id'])); ?>
    </td>
    <td>
      <?php echo $transaction['Transaction']['status']; ?>
    </td>
    <td>
      <?php echo $transaction['Transaction']['amount']; ?>
    </td>
    <td>
      <?php echo $transaction['Transaction']['created']; ?>
    </td>
    <td>
      <?php echo $transaction['Transaction']['modified']; ?>
    </td>
    <td class="actions">
      <?php echo $html->link(__('View', true), array('action'=>'view', $transaction['Transaction']['id']),array('class'=>'view')); ?>
      <?php echo $html->link(__('Edit', true), array('action'=>'edit', $transaction['Transaction']['id']),array('class'=>'edit')); ?>
      <?php echo $html->link(__('Delete', true), array('action'=>'delete', $transaction['Transaction']['id']), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $transaction['Transaction']['id'])); ?>
    </td>
  </tr>
<?php endforeach; ?>
  </table>
  </div>
  <div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
   |   <?php echo $paginator->numbers();?>
    <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
  </div>
  <p>
  <?php
  echo $paginator->counter(array(
  'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
  ));
  ?>  </p>
