<?php
	//@todo missing field
	$contact['Contact']['status'] = 'tick';
?>
          <tr>
<?php echo $this->element('tableset/collumns/favorites', array('model'=>'Contact', 'id'=> $contact['Contact']['id'])); ?>
<?php echo $this->element('tableset/collumns/status', array('model'=>'Gift', 'status'=> $contact['Contact']['status'])); ?>
            <td class="name">
              <a href="/admin/supporters/view/<?php echo $contact['Contact']['id']; ?>" class="iconic profile">
                <?php echo $contact['Contact']['fname']; ?>
                <?php echo $contact['Contact']['lname']; ?>   
              </a>
            </td>
<?php	if(isset($contact['Contact']['Address'][0])) : //@todo multiple address ?>
            <td class="postcode"><?php $contact['Contact']['Address'][0]['zip']; ?></td>
            <td class="city"><?php $contact['Contact']['Address'][0]['City']['name']; ?></td>
            <td class="country"><?php $contact['Contact']['Address'][0]['Country']['name']; ?></td>
 <?php endif; ?>
            <td class="favorites">
            <?php //echo $html->image('/img/icons/S/bullet_green.png'); ?>
            </td>
<?php echo $this->element('tableset/collumns/notifications',array('model'=>'Contact', 'id'=> $contact['Contact']['id'], 'allowEmpty'=>true)); ?>
<?php echo $this->element('tableset/collumns/date',array('model'=>'Contact', 'date'=> $contact['Contact']['modified'])); ?>
<?php echo $this->element('tableset/collumns/grab'); ?>
          </tr>
