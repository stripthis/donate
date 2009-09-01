<?php
	//@todo missing field in db
	$contact['Contact']['status'] = 'tick';
	$options = array(
		'model'=>'Contact', 
		'id'=> $contact['Contact']['id'],
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
              <a href="/admin/supporters/view/<?php echo $contact['Contact']['id']; ?>" class="iconic profile">
                <?php echo ucfirst($contact['Contact']['fname']); ?>
                <?php echo ucfirst($contact['Contact']['lname']); ?>  
                (<?php echo $contact['Contact']['email']; ?>)
              </a>
            </td>
            <td class="description">
<?php	if(isset($contact['Contact']['Address'][0])) : //@todo multiple address ?>
            <?php echo $contact['Contact']['Address'][0]['zip']; ?>
            <?php echo $contact['Contact']['Address'][0]['City']['name']; ?> - 
            <?php echo $contact['Contact']['Address'][0]['Country']['name']; ?>
<?php else: ?>
							&nbsp;
<?php endif; ?>
 						</td>
<?php echo $this->element('tableset/collumns/attachments',$options); ?>
<?php echo $this->element('tableset/collumns/comments',$options); ?>
<?php echo $this->element('tableset/collumns/date',am($options,array('date'=> $contact['Contact']['modified']))); ?>
<?php echo $this->element('tableset/collumns/grab'); ?>
          </tr>
