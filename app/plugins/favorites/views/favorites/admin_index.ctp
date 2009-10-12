<?php
$config = Configure::read('Favorites');
$headline = 'My ' . Inflector::humanize(Inflector::pluralize($config['subject']));
$isSingle = count($model) == 1;
if ($isSingle) {
	$headline = 'My ' . $config['adjective'] . ' ' . Inflector::pluralize($model[0]);
}
?>
<h1><?php echo $this->pageTitle = $headline; ?></h1>
<?php foreach ($model as $m) : ?>
	<?php
	if (!$isSingle) {
		echo '<h2>' . Inflector::pluralize($m) . '</h2>';
	}
	?>
	<table>
	<?php
	$found = false;
	foreach ($favorites as $favorite) {
		if (empty($favorite[$m]['id'])) {
			continue;
		}
		if (!$found) {
			$th = array('Created', $m, 'actions');
			echo $html->tableHeaders($th);
		}
		$found = true;
		$actions = array(
			$html->link('Delete', array(
				'plugin' => 'favorites', 'action' => 'delete', $favorite['Favorite']['id'], $m),
				null, 'Are you sure?'
			)
		);

		$field = $config['models'][$m];
		$item = $html->link($favorite[$m][$field], array(
			'plugin' => '', 'controller' => Inflector::pluralize(low($m)),
			'action' => 'view', $favorite[$m]['id']
		));
		$tr = array(
			method_exists($common, 'date') 
				? $common->date($favorite['Favorite']['created'])
				: $favorite['Favorite']['created'],
			$item,
			implode(' - ', $actions)
		);
		echo $html->tableCells($tr);
	}
	if (!($found)) {
		echo '<p>' . __('Sorry, there are no ' . Inflector::pluralize(low($m)) . ' in your ' . Inflector::pluralize($config['subject']), true) . '.</p>';
	}
	?>
	</table>
<?php endforeach; ?>