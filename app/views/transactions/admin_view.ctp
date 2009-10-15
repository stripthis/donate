<div class="content" id="transactions_view">
	<h2><?php  echo __('Transaction', true);?></h2>
	<?php echo $this->element('../transactions/elements/actions'); ?>
	<fieldset>
		<dl>
			<dt><?php echo __('Friends Id', true); ?></dt>
			<dd><?php echo $transaction['Transaction']['order_id']; ?></dd>
			<?php if (!empty($transaction['ParentTransaction']['id'])) : ?>
				<dt><?php echo __('Parent Trans.', true); ?></dt>
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
			<dt><?php echo __('Status', true); ?></dt>
			<dd><?php echo $transaction['Transaction']['status']; ?></dd>
			<dt><?php echo __('Gateway', true); ?></dt>
			<dd><?php echo $transaction['Gateway']['name']; ?></dd>
		</dl>
	</fieldset>
	<fieldset>
		<dl>
			<dt><?php echo __('Gift', true); ?></dt>
			<dd>
				<?php
				$amount = $transaction['Gift']['amount'];
				$frequency = $transaction['Gift']['Frequency']['humanized'];
				$type = $transaction['Gift']['type'];
				echo sprintf('%s %s, %s EUR', $frequency, ucfirst($type), $amount);
				?>
		</dd>
		<dt><?php echo __('Amount', true); ?></dt>
		<dd>
			<?php echo $transaction['Transaction']['amount']; ?>
		</dd>
	</dl>
	</fieldset>
	<fieldset>
		<dl>
			<dt><?php echo __('Created', true); ?></dt>
			<dd>
				<?php echo $common->date($transaction['Transaction']['created']); ?>
			</dd>
			<dt><?php echo __('Modified', true); ?></dt>
			<dd>
				<?php echo $common->date($transaction['Transaction']['modified']); ?>
			</dd>
		</dl>
	</fieldset>
</div>