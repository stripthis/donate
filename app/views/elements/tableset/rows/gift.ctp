<?php
$contact['Contact'] = isset($gift['Contact']) ? $gift['Contact']	: $gift['Gift']['Contact'];

// format status
if (isset($gift['Gift']['status'])) {
	$status = $gift['Gift']['status'];
}else {
	$status = false;
}
if ($status && isset($leaf) && !$leaf) {
	// generate 'aggregate' status //@todo in model?
	if(!Contact::isComplete($contact)) {
		$status = false;
	}
	//@todo same with transaction status
}

// recurring options for collumns elements
$options = array(
	'model' => 'Gift', 
	'id' => $gift['Gift']['id'],
	'status' => $status,
	'allowEmpty' => isset($allowEmpty) ? $allowEmpty : true,
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
			<?php
			if (isset($gift['Frequency']['humanized'])) {
				$frequency = low($gift['Frequency']['humanized']);
			} elseif (isset($gift['Gift']['Frequency']['humanized'])) {
				$frequency = low($gift['Gift']['Frequency']['humanized']);
			} else {
				$frequency = $common->emptyNotice(__('Undefined', true));
			}

			if (isset($gift['Gift']['amount'])) {
				$amount = $gift['Gift']['amount'];
			} else {
				$amount = $common->emptyNotice(__('Undefined', true));
			}

			if (isset($gift['Currency']['iso_code'])) {
				$currency = up($gift['Currency']['iso_code']);
			} else {
				$currency = $common->emptyNotice(__('???',true));
			}

			$giftType = false;
			if (isset($gift['GiftType'])) {
				$giftType = $gift['GiftType'];
			}
			if (isset($gift['Gift']['GiftType'])) {
				$giftType = $gift['Gift']['GiftType'];
			}

			if (!empty($giftType)) {
				$type = low($giftType['humanized']);
			} else {
				$type = $common->emptyNotice(__('???',true));
			}
			echo $amount . ' ' . $currency . ' ' . $frequency . ' ' . $type;
			?>
		</span>
		<?php 
		if (isset($frequency) && $frequency != 'onetime' || !isset($frequency)) {
			echo '(' . __('due', true) . ': ';
			echo $gift['Gift']['due'] ? __('yes', true) : __('no', true) . ')';
		}
		?>
	</td>
	<?php if (!$options['leaf']) : ?>
		<td class="description contact details">
			<?php 
				$label = '';
				if (isset($contact['Contact']['fname'])) {
					$label .= ucfirst($contact['Contact']['fname']).' ';
				} else {
					$label .= $common->emptyNotice(__('no first name', true)).' ';
				}
				if (isset($contact['Contact']['lname'])) {
					$label .= ucfirst($contact['Contact']['lname']);
				} else {
					$label .= $common->emptyNotice(__('no last name', true)).' ';
				}
				if (isset($contact['Contact']['email'])) {
					$label .= ' (' . low($contact['Contact']['email']) . ')';
				} else {
					$label .= ' (' . $common->emptyNotice(__('no email', true)) . ')';
				}
				if (isset($contact['Contact']['id'])) {
					echo $html->link($label, 
						array('controller' => 'supporters', 'action' => 'view', $contact['Contact']['id'])
					);
				} else {
					echo $label;
				}
			?>
		</td>
	<?php else : ?>
		<td class="description">
			<?php
				$label = '#'.$gift['Gift']['serial'];
				echo $html->link($label, array(
					'controller' => 'gifts', 'action' => 'view', $gift['Gift']['id']
				));
			?>
		</td>
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