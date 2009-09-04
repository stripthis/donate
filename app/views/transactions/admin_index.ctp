<?php
$doFavorites = class_exists('Favorite') && Favorite::doForModel('Transaction');
$favConfig = Configure::read('Favorites');
?>
<div class="content" id="transactions_index">
<h2>
	<?php
	$headline = __('Transactions', true);
	if (!empty($contact)) {
		$name = $common->contactName($contact);
		$headline = sprintf(__('%s\'s Transactions', true), $name);
	}
	echo $headline;
	?>
</h2>
<?php echo $this->element('../transactions/elements/menu'); ?>
<?php echo $this->element('../transactions/elements/actions'); ?>
<?php if (!empty($transactions)) : ?>
	<table>
	<?php
	unset($params['sort']);
	unset($params['direction']);
	$th = array(
		'<input name="Transaction" class="select_all checkbox" type="checkbox">',
		$myPaginator->sort(__('Status',true),'Transaction.status', array('url' => $params)),
		$myPaginator->sort(__('Id',true),'Transaction.serial', array('url' => $params)),
		$myPaginator->sort(__('Parent',true),'Transaction.parent_id', array('url' => $params)),
		$myPaginator->sort(__('Amount',true),'Transaction.amount', array('url' => $params)),
		$myPaginator->sort(__('Gateway',true),'Gateway.parent_id', array('url' => $params)),
		$myPaginator->sort(__('External ID',true),'Transaction.external_id', array('url' => $params)),
		$myPaginator->sort(__('Gift',true),'Transaction.gift_id', array('url' => $params)),
		$myPaginator->sort(__('Created',true),'Transaction.created', array('url' => $params)),
		$myPaginator->sort(__('Modified',true),'Transaction.modified', array('url' => $params)),
		'Actions'
	);
	if ($doFavorites) {
		array_unshift($th, $html->image('icons/S/rate.png'));
	}
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

		$gift = $html->link('Check', array('controller'=> 'gifts', 'action'=>'view', $t['Gift']['id']));
		$tr = array(
		  $form->checkbox($t['Transaction']['external_id'], array('class'=>'checkbox','name'=> 'Transaction')),
			$t['Transaction']['status'],
			$t['Transaction']['serial'],
			$parent,
			$t['Transaction']['amount'].' EUR', //@todo currency
			$t['Gateway']['name'],
			$t['Transaction']['external_id'],
			$gift,
			$t['Transaction']['created'],
			$t['Transaction']['modified'],
			implode(' - ', $actions)
		);
		if ($doFavorites) {
			array_unshift($tr, $favorites->link("Transaction", $t['Transaction']['id']));
		}
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
					$gift,
					$t['Transaction']['created'],
			    $t['Transaction']['modified'],
					$actions
				);
			}
		}
	}
	?>
	</table>
	<?php
	$urlParams = $params;
	unset($urlParams['ext']);
	unset($urlParams['page']);
	$urlParams['merge'] = true;
	echo $this->element('paging', array('model' => 'Transaction', 'url' => $urlParams));
	?>
<?php else : ?>
	<p>Sorry, nothing to show here.</p>
<?php endif; ?>
<?php echo $this->element('../transactions/elements/filter', compact('params')); ?>
</div>