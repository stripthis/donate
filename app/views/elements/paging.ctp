<?php
$modulus = isset($modulus) ? $modulus : 6;
if (!isset($paginator->params['paging'])) {
	return;
}
if (!isset($model) || $paginator->params['paging'][$model]['pageCount'] < 2) {
	//return;
}
if (!isset($options)) {
	$options = array();
}
$options['model'] = $model;
$options['url']['model'] = $model;
$paginator->__defaultModel = $model;

$widget = isset($widget) ? $widget : false;
$numbers = isset($numbers) ? $numbers : false;
$class = isset($class) ? ' '.$class : '';

$numberOptions = $options;
if (isset($url)) {
	if (is_string($url) || !isset($url['merge'])) {
		$options['url'][] = $url;
		$numberOptions['url'][] = $url;
	} else {
		unset($url['merge']);
		$options['url'] = am($options['url'], $url);
		$numberOptions['url'] = am($numberOptions['url'], $url);
	}
}
?>
<div class="paging <?php echo $class ?>">
	<div class="counter">
	<?php
	echo $paginator->counter(array(
	        'format' => 'Page %page% of %pages% / showing %current% of %count% '
	));?>
	</div>
	<div class="pages">
	<?php
	echo $paginator->prev('&laquo;Prev', array_merge(array('escape' => false, 'class' => 'prev'), $options), null, array('class' => 'prev disabled', 'escape' => false));
	echo $myPaginator->numbers(am($numberOptions, array('before' => false, 'after' => false, 'separator' => false, 'modulus' => $modulus, 'fold' => 2, 'class'=>'number')));
	echo $paginator->next('Next&raquo;', array_merge(array('escape' => false, 'class' => 'next'), $options), null, array('class' => 'next disabled', 'escape' => false));
	?>
	</div>
</div>