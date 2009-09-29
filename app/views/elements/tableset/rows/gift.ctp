<?php
$class = "gift";
$id = '';
if (!isset($leaf)) {
	$leaf = false;
}

$gift['Gift']['status'] = $common->giftStatus($gift);

// recurring options for collumns elements
$options = array(
	'model'=>'Gift', 
	'id'=> $gift['Gift']['id'],
	'status' => $gift['Gift']['status'],
	'allowEmpty' => (isset($allowEmpty) ? $allowEmpty : true),
	'leaf' => $leaf,
	'parent_id' => isset($parent_id) ? $parent_id : false
);
?>

<tr class="<?php echo $common->getFoldClass($options); ?>">
	<?php echo $this->element('tableset/collumns/selection', $options); ?>
	<?php echo $this->element('tableset/collumns/fold', $options); ?>
	<?php echo $this->element('tableset/collumns/favorites',$options); ?>
	<?php echo $this->element('tableset/collumns/status', $options); ?>
	<td class="title gift details" >
		<span class="iconic gift creditcard">
			<?php echo $gift['Gift']['amount'] . ' EUR ' . $gift['Gift']['frequency']; ?>
		</span>
		<?php if (!$leaf) : ?>
			#<?php echo $gift['Gift']['serial']?>
			<?php if ($type != 'onetime') : ?>
				(<?php echo __('due',true) ?>: <?php echo $gift['Gift']['due'] ? __('yes',true) : __('no',true)?>)
			<?php endif; ?>
		<?php endif; ?>
	</td>

	<?php if (!$leaf) : ?>
		<td class="description contact details">
			<?php
			$label = ucfirst($gift['Contact']['fname']) . ' ' . ucfirst($gift['Contact']['lname']);
			$label .= ' (' . low($gift['Contact']['email']) . ')';
			echo $html->link($label, array(
				'controller' => 'gifts', 'action' => 'view', $gift['Gift']['id']
			));
			?>
		</td>
	<?php else : ?>
		<td class="description">Some more information</td>
	<?php endif; ?>
	<?php echo $this->element('tableset/collumns/attachments',$options); ?>
	<?php echo $this->element('tableset/collumns/comments',$options); ?>
	<?php echo $this->element('tableset/collumns/date', array('date'=>$gift['Gift']['modified'])); ?>
	<?php echo $this->element('tableset/collumns/grab'); ?>
</tr>