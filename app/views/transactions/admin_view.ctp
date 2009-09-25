<div class="content" id="transactions_view">
	<h2><?php  sprintf(__('Transaction', true));?></h2>
	<?php echo $this->element('../transactions/elements/actions'); ?>
	<fieldset>
		<dl>
			<dt><?php sprintf(__('Friends Id', true)); ?></dt>
			<dd>
				<?php echo $transaction['Transaction']['order_id']; ?>
				&nbsp;
			</dd>
			<?php if (!empty($transaction['ParentTransaction']['id'])) : ?>
				<dt><?php sprintf(__('Parent Trans.', true)); ?></dt>
				<dd>
					<?php
				$url = array(
					'controller'=> 'transactions', 'action'=>'view',
					$transaction['ParentTransaction']['id']
					);
				echo $html->link($transaction['ParentTransaction']['id'], $url);
				?>
			</dd>
			<?php endif; ?>
			<dt><?php sprintf(__('Status', true)); ?></dt>
			<dd>
				<?php echo $transaction['Transaction']['status']; ?>
				&nbsp;
			</dd>
			<dt><?php sprintf(__('Gateway', true)); ?></dt>
			<dd>
				<?php echo $transaction['Gateway']['name']; ?>
				&nbsp;
			</dd>
		</dl>
	</fieldset>
	<fieldset>
		<dl>
			<dt><?php sprintf(__('Gift', true)); ?></dt>
			<dd>
				<?php
			$amount = $transaction['Gift']['amount'];
			$frequency = $transaction['Gift']['frequency'];
			$type = $transaction['Gift']['type'];
			echo sprintf('%s %s, %s EUR', ucfirst($frequency), ucfirst($type), $amount);
			?>
			&nbsp;
		</dd>
		<dt><?php sprintf(__('Amount', true)); ?></dt>
		<dd>
			<?php echo $transaction['Transaction']['amount']; ?>
			&nbsp;
		</dd>
	</dl>
	</fieldset>
	<fieldset>
		<dl>
			<dt><?php sprintf(__('Created', true)); ?></dt>
			<dd>
				<?php echo $transaction['Transaction']['created']; ?>
				&nbsp;
			</dd>
			<dt><?php sprintf(__('Modified', true)); ?></dt>
			<dd>
				<?php echo $transaction['Transaction']['modified']; ?>
				&nbsp;
			</dd>
		</dl>
	</fieldset>
</div>