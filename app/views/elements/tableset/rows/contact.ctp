<?php
	//@todo missing field
	$contact['Contact']['status'] = 'tick';
?>
          <tr class="contact">
          	<td class="select"></td>
          	<td class="folded"></td>
<?php echo $this->element('tableset/collumns/favorites', array('model'=>'Contact', 'id'=> $contact['Contact']['id'])); ?>
<?php echo $this->element('tableset/collumns/status', array('model'=>'Gift', 'status'=> $contact['Contact']['status'])); ?>
            <td class="title">
              <a href="/admin/supporters/view/<?php echo $contact['Contact']['id']; ?>" class="iconic profile">
                <?php echo $contact['Contact']['fname']; ?>
                <?php echo $contact['Contact']['lname']; ?>   
              </a>
            </td>
            <td class="descriptions>
<?php	if(isset($contact['Contact']['Address'][0])) : //@todo multiple address ?>
            <?php $contact['Contact']['Address'][0]['zip']; ?>
            <?php $contact['Contact']['Address'][0]['City']['name']; ?>
            <?php $contact['Contact']['Address'][0]['Country']['name']; ?>
 <?php endif; ?>
 						</td>
<?php echo $this->element('tableset/collumns/attachment',array('model'=>'Contact', 'id'=> $contact['Contact']['id'], 'allowEmpty'=>true)); ?>
<?php echo $this->element('tableset/collumns/comments',array('model'=>'Contact', 'id'=> $contact['Contact']['id'], 'allowEmpty'=>true)); ?>
<?php echo $this->element('tableset/collumns/date',array('model'=>'Contact', 'date'=> $contact['Contact']['modified'])); ?>
<?php echo $this->element('tableset/collumns/grab'); ?>
          </tr>
