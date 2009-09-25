<div class="content view" id="gifts_view">
	<h2><?php echo  __('Gift', true);?></h2>
	<div class="actions">
		<h3><?php echo __('Actions', true); ?></h3>
		<ul>
			<li>
			<?php
			echo $html->link(__('Delete Gift', true),
				array('action'=>'delete', $gift['Gift']['id']),
				array('class'=>'delete'), __('Are you sure?', true)
			);
			?>
			</li>
		</ul>
	</div>
	<dl>
		<dt><?php echo __('Id', true); ?></dt>
		<dd>
			<?php echo $gift['Gift']['id']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Office', true); ?></dt>
		<dd>
			<?php
			echo $html->link($gift['Office']['name'], array(
				'controller' => 'offices', 'action' =>'view', $gift['Office']['id']
			));
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type', true); ?></dt>
		<dd>
			<?php echo $gift['Gift']['type']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Amount', true); ?></dt>
		<dd>
			<?php echo $gift['Gift']['amount']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description', true); ?></dt>
		<dd>
			<?php echo $gift['Gift']['description']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Frequency', true); ?></dt>
		<dd>
			<?php echo $gift['Gift']['frequency']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Appeal', true); ?></dt>
		<dd>
			<?php
			echo $html->link($gift['Appeal']['name'], array(
				'controller'=> 'appeals', 'action'=>'view', $gift['Appeal']['id']
			)); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fname', true); ?></dt>
		<dd>
			<?php echo $gift['Contact']['fname']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lname', true); ?></dt>
		<dd>
			<?php echo $gift['Contact']['lname']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Salutation', true); ?></dt>
		<dd>
			<?php echo $gift['Contact']['salutation']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title', true); ?></dt>
		<dd>
			<?php echo $gift['Contact']['title']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address', true); ?></dt>
		<dd>
			<?php echo $gift['Contact']['Address'][0]['line_1']; ?><br />
			<?php echo $gift['Contact']['Address'][0]['line_2']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zip', true); ?></dt>
		<dd>
			<?php echo $gift['Contact']['Address'][0]['zip']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Country', true); ?></dt>
		<dd>
			<?php echo $gift['Contact']['Address'][0]['Country']['name']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email', true); ?></dt>
		<dd>
			<?php echo $gift['Contact']['email']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created', true); ?></dt>
		<dd>
			<?php echo $gift['Gift']['created']; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified', true); ?></dt>
		<dd>
			<?php echo $gift['Gift']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
	
	<h2><?php echo __('Transactions', true) ?></h2>
	<?php if (!empty($transactions)) : ?>
		<table>
		<?php
		$th = array(
			__('Status', true),
			__('Id', true),
			__('Order ID', true),
			__('Amount', true),
			__('Gateway', true),
			__('Created', true),
			'Actions'
		);

		echo $html->tableHeaders($th);
		foreach ($transactions as $t) {
			$actions = array(
				$html->link(__('View', true), array(
					'action' => 'view', $t['Transaction']['id']),array('class'=>'view'
				)),
				$html->link(__('Delete', true), array('action' => 'delete', $t['Transaction']['id']),
					array('class'=>'delete'), __('Are you sure?', true))
			);

			$parent = '';
			if (!empty($t['ParentTransaction']['id'])) {
				$parent = $html->link($t['ParentTransaction']['id'], array(
					'controller' => 'transactions', 'action' => 'view', $t['ParentTransaction']['id']
				));
			}

			$tr = array(
				$t['Transaction']['status'],
				$t['Transaction']['serial'],
				$t['Transaction']['order_id'],
				$t['Transaction']['amount'].' EUR', //@todo currency
				$t['Gateway']['name'],
				$t['Transaction']['created'],
				implode(' - ', $actions)
			);
			echo $html->tableCells($tr);

			if (!empty($t['ChildTransaction'])) {
				foreach ($t['ChildTransaction'] as $t) {
					$actions = array(
						$html->link(__('View', true), array(
							'action' => 'view', $t['Transaction']['id']), array('class' => 'view'
						)),
						$html->link(__('Delete', true), array(
							'action' => 'delete', $t['Transaction']['id']), array('class' => 'delete'),
							__('Are you sure?', true))

					);
					$id = $html->link($t['Transaction']['id'], array(
						'controller' => 'transactions', 'action' => 'view', $t['Transaction']['id']
					));
					$tr = array(
						$t['Transaction']['status'],
						$id,
						$t['Gateway']['name'],
						$t['Transaction']['amount'],
						$t['Transaction']['external_id'],
						$t['Transaction']['created'],
						$actions
					);
				}
			}
		}
		?>
		</table>
	<?php else : ?>
	    <p class="nothing"><?php echo __('Sorry but there is nothing to display here...', true); ?></p>
	<?php endif; ?>
	<?php echo $this->element('comments', array('item' => $gift, 'items' => $comments, 'plugin' => 'comments'))?>
</div>