<div class="content" id="transactions_view">
	<h2><?php  __('Transaction');?></h2>
	<?php echo $this->element('../transactions/elements/actions'); ?>
	<fieldset>
		<dl>
			<dt><?php __('Friends Id'); ?></dt>
			<dd>
				<?php echo $transaction['Transaction']['order_id']; ?>
				&nbsp;
			</dd>
			<?php if (!empty($transaction['ParentTransaction']['id'])) : ?>
				<dt><?php __('Parent Trans.'); ?></dt>
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
			<dt><?php __('Status'); ?></dt>
			<dd>
				<?php echo $transaction['Transaction']['status']; ?>
				&nbsp;
			</dd>
			<dt><?php __('Gateway'); ?></dt>
			<dd>
				<?php echo $transaction['Gateway']['name']; ?>
				&nbsp;
			</dd>
		</dl>
	</fieldset>
	<fieldset>
		<dl>
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
		<dt><?php __('Amount'); ?></dt>
		<dd>
			<?php echo $transaction['Transaction']['amount']; ?>
			&nbsp;
		</dd>
	</dl>
	</fieldset>
	<fieldset>
		<dl>
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
	</fieldset>
</div>