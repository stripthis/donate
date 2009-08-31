<?php
	//@todo somewhere else?
	$gift['Gift']['status'] = 'tick';
	if(!isset($gift['Contact']) && !isset($gift['Transaction'])) {
		$gift['Gift']['status'] = 'error';
	}else{
		foreach($gift['Transaction'] as $transaction){
			if($transaction['status'] == 'new' && !isset($leaf) && $gift['Gift']['status']!='warning') {
				 $gift['Gift']['status'] = 'new';
			}elseif($transaction['status'] == 'warning'){
				$gift['Gift']['status'] = 'warning';
			}elseif($transaction['status'] == 'error'){
				$gift['Gift']['status'] = 'error';
				break;
			}
		}
	}
?>
          <tr class="gift" id='<?php echo $gift['Gift']['id'];?>'>
<?php if(!isset($leaf) || $leaf==false): ?>
            <td class="selection"><?php echo $form->checkbox($gift['Gift']['id'], array("class"=>"checkbox"));?></td>
            <td class="fold"><a href="<?php echo Router::url(); ?>#" class="toggle close" id="trigger_<?php echo $gift['Gift']['id'];?>">&nbsp;</a></td>
<?php endif; ?>
			<td><?php echo $gift['Gift']['serial']?></td>
			<?php if ($type != 'onetime') : ?>
				<td><?php echo $gift['Gift']['due'] ? 'Yes' : 'No'?></td>
			<?php endif; ?>
<?php echo $this->element('tableset/collumns/favorites', array('model'=>'Gift', 'id'=> $gift['Gift']['id'])); ?>
<?php echo $this->element('tableset/collumns/status', array('model'=>'Gift', 'status'=> $gift['Gift']['status'])); ?>
            <td class="details" >
              <a href="<?php echo Router::url('/admin/gifts/view/') . $gift['Gift']['id']; ?>" class="iconic gift creditcard">
            		<?php echo $gift['Gift']['amount'];?>
              	EUR <?php //@todo currencies?>
            		<?php echo $gift['Gift']['frequency'];?>
              </a>
            </td>
<?php if(!isset($leaf) || $leaf==false): ?>
            <td class="name">
              <a href="<?php echo Router::url('/admin/gifts/view/') . $gift['Gift']['id'] ; ?>">
                <?php echo ucfirst($gift['Contact']['fname']);?>
                <?php echo ucfirst($gift['Contact']['lname']);?> 
                (<?php echo low($gift['Contact']['email']);?>)
              </a>
            </td>
<?php else: ?>
           	<td class="description">
           		<?php //@dynamic ?>
           		Some more information
           	</td>
<?php endif; ?>
<?php echo $this->element('tableset/collumns/notifications',array('model'=>'Gift', 'id'=> $gift['Gift']['id'], 'allowEmpty'=>true)); ?>
<?php echo $this->element('tableset/collumns/date', array('date'=>$gift['Gift']['modified'])); ?>
<?php echo $this->element('tableset/collumns/grab'); ?>
          </tr>
