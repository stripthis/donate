<div class="content" id="transactions_index">
<h2>
	<?php
	$headline = __('Transactions Statistics', true);
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
?>
<?php echo $this->element('../transactions/elements/filter', compact('params', 'type')); ?>
</div>