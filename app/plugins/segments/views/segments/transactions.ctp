<?php
$doFavorites = class_exists('Favorite') && Favorite::doForModel('Transaction');
$favConfig = Configure::read('Favorites');
$foundOne = false;

if (!empty($transactions)) {
	$content = '<table>';
	$th = array();
	if ($doFavorites) {
		$th[] = $favorites->favall();
	}
	$th = am($th, array(
		__('Status',true),
		__('Id',true),
		__('Import Id',true),
		__('Amount',true),
		__('Gateway',true),
		__('Created',true),
		__('Modified',true),
		'Actions'
	));

	$content .= $html->tableHeaders($th);
	foreach ($transactions as $t) {
		if (empty($t['Transaction'])) {
			continue;
		}
		$foundOne = true;
		$actions = array(
			$html->link(__('View', true),
				array('controller'=> 'gifts', 'action'=>'view', $t['Transaction']['gift_id']),
				array('class' => 'view')
			)
		);

		$tr = array();
		if ($doFavorites) {
			$tr[] = $favorites->link('Transaction', $t['Transaction']['id']);
		}
		$tr = am($tr,array(            
			$t['Transaction']['status'],
			$t['Transaction']['serial'],
			!empty($t['Import']['serial']) ? $t['Import']['serial'] : '--',
			$t['Transaction']['amount'] . ' EUR', //@todo currency
			$t['Transaction']['Gateway']['name'],
			$t['Transaction']['created'],
			$t['Transaction']['modified'],
			implode(' - ', $actions)
		));
		$content .= $html->tableCells($tr)."\n";
	}
	$content .= '</table>';

	if ($foundOne) {
		echo $content;
	}
}
?>

<?php if (!$foundOne) : ?>
    <p class="nothing"><?php echo __('Sorry but there is nothing to display here...', true); ?></p>
<?php endif; ?>