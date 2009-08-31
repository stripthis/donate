<div class="content" id="transactions_view">
<h2><?php  __('Transaction');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('Delete Transaction', true), array('action'=>'delete', $transaction['Transaction']['id']),  array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $transaction['Transaction']['id'])); ?> </li>
    </ul>
  </div>
	<dl>
    <dt><?php __('Id'); ?></dt>
    <dd>
      <?php echo $transaction['Transaction']['id']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Parent Trans.'); ?></dt>
    <dd>
      <?php
		if (!empty($transaction['ParentTransaction']['id'])) {
			$url = array(
				'controller'=> 'transactions', 'action'=>'view',
				$transaction['ParentTransaction']['id']
			);
			echo $html->link($transaction['ParentTransaction']['id'], $url);
		} else {
			echo '--';
		}
		?>
      &nbsp;
    </dd>
    <dt><?php __('Gateway'); ?></dt>
    <dd>
      <?php echo $html->link($transaction['Gateway']['name'], array('controller'=> 'gateways', 'action'=>'view', $transaction['Gateway']['id'])); ?>
      &nbsp;
    </dd>
    <dt><?php __('External Id'); ?></dt>
    <dd>
      <?php echo $transaction['Transaction']['external_id']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Gift'); ?></dt>
    <dd>
      <?php
      $amount = $transaction['Gift']['amount'];
      $frequency = $transaction['Gift']['frequency'];
      $type = $transaction['Gift']['type'];
		echo sprintf('%s %s, %s EUR', ucfirst($frequency), ucfirst($type), $amount);
      ?>
      &nbsp;
    </dd>
    <dt><?php __('Status'); ?></dt>
    <dd>
      <?php echo $transaction['Transaction']['status']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Amount'); ?></dt>
    <dd>
      <?php echo $transaction['Transaction']['amount']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Created'); ?></dt>
    <dd>
      <?php echo $transaction['Transaction']['created']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Modified'); ?></dt>
    <dd>
      <?php echo $transaction['Transaction']['modified']; ?>
      &nbsp;
    </dd>
	</dl>
</div>

