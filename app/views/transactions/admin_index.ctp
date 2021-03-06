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
<?php
echo $this->element('nav', array(
	'type' => 'transaction_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
));

echo $form->create('Transaction', array('url' => '/admin/exports/transactions', 'type' => 'post'));
echo $this->element('../transactions/elements/actions', array('export' => true));
?>
<?php if (!empty($transactions)) : ?>
	<table>
	<?php
	unset($params['sort']);
	unset($params['direction']);
	$th = array();
	$th[] = '<input name="Transaction" class="select_all checkbox" type="checkbox">';
	if ($doFavorites) {
		$th[] = $favorites->favall();
	}
	$th = am($th,array(
		$myPaginator->sort(__('Status',true), 'Transaction.status', array('url' => $params)),
		$myPaginator->sort(__('Id',true), 'Transaction.serial', array('url' => $params)),
		$myPaginator->sort(__('Import Id',true), 'Import.serial', array('url' => $params)),
		$myPaginator->sort(__('Amount',true), 'Transaction.amount', array('url' => $params)),
		$myPaginator->sort(__('Gateway',true), 'Gateway.parent_id', array('url' => $params)),
		$myPaginator->sort(__('Created',true), 'Transaction.created', array('url' => $params)),
		$myPaginator->sort(__('Modified',true), 'Transaction.modified', array('url' => $params)),
		'Actions'
	));

	echo $html->tableHeaders($th);
	foreach ($transactions as $t) {
		$actions = array(
			$html->link(__('View', true), array('controller'=> 'gifts', 'action'=>'view', $t['Gift']['id']),
				array('class'=>'view')
			),
			$html->link(__('Delete', true), array('action' => 'delete', $t['Transaction']['id']),
				array('class'=>'delete'), __('Are you sure?', true))
		);

		$tr = array();
		$tr[] = $form->checkbox($t['Transaction']['id'], array('class'=>'checkbox'));
		if ($doFavorites) {
			$tr[] = $favorites->link("Transaction", $t['Transaction']['id']);
		}

		$tr = am($tr, array(
			$t['Transaction']['status'],
			$t['Transaction']['serial'],
			!empty($t['Import']['serial']) ? $t['Import']['serial'] : '--',
			$t['Transaction']['amount'] . ' ' . $t['Currency']['iso_code'],
			$t['Gateway']['name'],
			$common->date($t['Transaction']['created']),
			$common->date($t['Transaction']['modified']),
			implode(' - ', $actions)
		));
		echo $html->tableCells($tr)."\n";

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
					$t['Transaction']['order_id'],
			    	$html->link(__('Check', true), array(
						'controller'=> 'gifts', 'action'=>'view', $t['Gift']['id']
					)),
					$common->date($t['Transaction']['created']),
					$common->date($t['Transaction']['modified']),
					$actions
				);
			}
		}
	}
	?>
	</table>
	<?php
	$urlParams = $params;
	$urlParams[] = $type;
	unset($urlParams['ext']);
	unset($urlParams['page']);
	$urlParams['merge'] = true;
	echo $this->element('paging', array('model' => 'Transaction', 'url' => $urlParams));
	?>
<?php else : ?>
    <p class="nothing"><?php echo __('Sorry but there is nothing to display here...', true); ?></p>
<?php endif; ?>
<?php echo $form->end(); ?>
<?php echo $this->element('../transactions/elements/filter', compact('params', 'type')); ?>
</div>