<?php
$class = "gift";
$id = '';
$gift['Gift']['status'] = $common->giftStatus($gift);

// recurring options for collumns elements
$options = array(
	'model' => 'Gift', 
	'id' => $gift['Gift']['id'],
	'status' => $gift['Gift']['status'],
	'allowEmpty' => (isset($allowEmpty) ? $allowEmpty : true),
	'leaf' => isset($leaf) ? $leaf : false,
	'parent_id' => isset($parent_id) ? $parent_id : false,
	'do_selection' => isset($do_selection) ? $do_selection : 1,
	'do_fold' => isset($fold) ? $do_fold : 1,
	'do_favorites' => isset($do_favorites) ? $do_favorites : 1,
	'do_status' => isset($do_status) ? $do_status : 1,
	'colsToAppend' => isset($colsToAppend) ? $colsToAppend : false
);
?>

<tr class="<?php echo $common->getFoldClass($options); ?>">
	<?php
	$contactData = isset($gift['Contact'])
					? $gift['Contact']
					: $gift['Gift']['Contact'];

	if ($options['do_selection']) {
		echo $this->element('tableset/collumns/selection', $options);
	}
	if ($options['do_fold']) {
		echo $this->element('tableset/collumns/fold', $options);
	}
	if ($options['do_favorites']) {
		echo $this->element('tableset/collumns/favorites', $options);
	}
	if ($options['do_status']) {
		echo $this->element('tableset/collumns/status', $options);
	}
	?>
	<td class="title gift details" >
		<span class="iconic gift creditcard">
			<?php echo $gift['Gift']['amount'] . ' EUR ' . $gift['Gift']['frequency']; ?>
		</span>
		<?php if (!$options['leaf']) : ?>
			#<?php echo $gift['Gift']['serial']?>
			<?php if (isset($type) && $type != 'onetime' || !isset($type)) : ?>
				(<?php echo __('due',true) ?>: <?php echo $gift['Gift']['due'] ? __('yes',true) : __('no',true)?>)
			<?php endif; ?>
		<?php endif; ?>
	</td>

	<?php if (!$options['leaf']) : ?>
		<td class="description contact details">
			<?php
			$validData = isset($contactData['fname']) && isset($contactData['lname']) && $contactData['email'];
			if ($validData) {
				$label = ucfirst($contactData['fname']) . ' ' . ucfirst($contactData['lname']);
				$label .= ' (' . low($contactData['email']) . ')';
				echo $html->link($label, array(
					'controller' => 'gifts', 'action' => 'view', $gift['Gift']['id']
				));
			} else {
				echo '--';
			}
			?>
		</td>
	<?php else : ?>
		<td class="description">Some more information</td>
	<?php endif; ?>

	<?php
	echo $this->element('tableset/collumns/attachments', $options);
	echo $this->element('tableset/collumns/comments',$options);
	echo $this->element('tableset/collumns/date', array('date'=>$gift['Gift']['modified']));
	echo $this->element('tableset/collumns/grab');
	if (!empty($options['colsToAppend'])) {
		echo $options['colsToAppend'];
	}
	?>
</tr>