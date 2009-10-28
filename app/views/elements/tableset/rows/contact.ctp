<?php
//format address //@todo multiple address
$address['Address'] = isset($contact['Contact']['Address'][0]) ? 
	$contact['Contact']['Address'][0] : array();
//format status 
if(!isset($contact['Contact']['status'])) {
	$contact['Contact']['status'] = Contact::getCompleteness($contact);
}
// recurring options for collumns elements
$options = array(
	'model' => 'Contact', 
	'id' => $contact['Contact']['id'],
	'status'=> $contact['Contact']['status'],
	'allowEmpty' => (isset($allowEmpty) ? $allowEmpty : true),
	'leaf' => (isset($leaf) ? $leaf : true),
	'parent_id' => (isset($parent_id) ? $parent_id : false)
);
?>
<tr class="<?php echo $common->getFoldClass($options); ?>">
	<?php echo $this->element('tableset/collumns/selection', $options); ?>
	<?php echo $this->element('tableset/collumns/fold', $options); ?>
	<?php echo $this->element('tableset/collumns/favorites',$options); ?>
	<?php echo $this->element('tableset/collumns/status', $options); ?>
	<td class="title">
			<?php 
				$label = '';
				if (isset($contact['Contact']['fname'])) {
					$label .= ucfirst($contact['Contact']['fname']).' ';
				} else {
					$label .= $common->emptyNotice(__('no first name',true)).' ';
				}
				if (isset($contact['Contact']['lname'])) {
					$label .= ucfirst($contact['Contact']['lname']);
				} else {
					$label .= $common->emptyNotice(__('no last name',true)).' ';
				}
				if (isset($contact['Contact']['email'])) {
					$label .= ' (' . low($contact['Contact']['email']) . ')';
				} else {
					$label .= ' (' .$common->emptyNotice(__('no email',true)) . ')';
				}
				if (isset($contact['Contact']['id'])) {
					echo $html->link($label, 
						array('controller' => 'supporters', 'action' => 'view', $contact['Contact']['id']),
						array('class'=> 'iconic profile')
					);
				} else {
					echo '<p class=\'iconic profile\'>'.$label.'</p>';
				}
			?>
		</a>
	</td>
	<td class="description">
			<?php 
				$label = '';
				if (isset($address['Address']['zip'])) {
					$label .= $address['Address']['zip'].' '; 
				} else {
					$label .= $common->emptyNotice(__('no zipcode',true)).' ';
				}
				if (isset($address['Address']['City']['name'])) {
					$label .= $address['Address']['City']['name'].' '; 
				} else {
					$label .= $common->emptyNotice(__('no city',true)).' ';
				}
				if (isset($address['Address']['Country']['name'])) {
					$label .= $address['Address']['Country']['name'].' '; 
				} else {
					$label .= $common->emptyNotice(__('no country',true)).' ';
				}
				echo $label;
			?>
	</td>
	<?php echo $this->element('tableset/collumns/attachments',$options); ?>
	<?php echo $this->element('tableset/collumns/comments',$options); ?>
	<?php echo $this->element('tableset/collumns/date',am($options,array('date'=> $contact['Contact']['modified']))); ?>
	<?php echo $this->element('tableset/collumns/grab'); ?>
</tr>
