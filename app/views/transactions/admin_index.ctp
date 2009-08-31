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

<?php if (!empty($transactions)) : ?>
	<table>
	<?php
	$th = array(
		$paginator->sort('parent_id'),
		$paginator->sort('gateway_id'),
		$paginator->sort('external_id'),
		$paginator->sort('gift_id'),
		$paginator->sort('status'),
		$paginator->sort('amount'),
		'Serial',
		$paginator->sort('created'),
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
		if ($doFavorites) {
			$actions[] = $html->link(__(ucfirst($favConfig['verb']), true), array(
				'controller' => 'favorites', 'action' => 'add', $t['Transaction']['id'], 'Transaction'
			));
		}

		$parent = '';
		if (!empty($t['ParentTransaction']['id'])) {
			$parent = $html->link($t['ParentTransaction']['id'], array(
				'controller' => 'transactions', 'action' => 'view', $t['ParentTransaction']['id']
			));
		}

		$gift = $html->link('Check', array('controller'=> 'gifts', 'action'=>'view', $t['Gift']['id']));
		$tr = array(
			$parent,
			$t['Gateway']['name'],
			$t['Transaction']['external_id'],
			$gift,
			$t['Transaction']['status'],
			$t['Transaction']['amount'],
			$t['Transaction']['serial'],
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
					$id,
					$t['Gateway']['name'],
					$t['Transaction']['external_id'],
					$gift,
					$t['Transaction']['status'],
					$t['Transaction']['amount'],
					$t['Transaction']['serial'],
					$t['Transaction']['created'],
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