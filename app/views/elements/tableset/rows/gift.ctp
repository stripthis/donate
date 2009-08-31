<?php
	//@todo somewhere else?
	if(!isset($leaf)) {
		$leaf=false;
	}
	$gift['Gift']['status'] = 'tick';
	if(!isset($gift['Contact']) && !isset($gift['Transaction'])) {
		$gift['Gift']['status'] = 'error';
	}else{
		foreach($gift['Transaction'] as $transaction){
			if($transaction['status'] == 'new' && !$leaf && $gift['Gift']['status']!='warning') {
				 $gift['Gift']['status'] = 'new';
			}elseif($transaction['status'] == 'warning'){
				$gift['Gift']['status'] = 'warning';
			}elseif($transaction['status'] == 'error'){
				$gift['Gift']['status'] = 'error';
				break;
			}
		}
	}
	$class='gift';
	$id = '';
	if($leaf) {
		$class .=  ' toggle_wrapper leaf';
		$id = 'wrapper_trigger_'. $gift['Gift']['id'];
	}
?>
          <tr class="<?php echo $class; ?>"  id="<?php echo $id; ?>">
<?php if(!$leaf): ?>
            <td class="selection"><?php echo $form->checkbox($gift['Gift']['id'], array('class'=>'checkbox','name'=>'gift'));?></td>
            <td class="fold"><a href="<?php echo Router::url(); ?>#" class="toggle close" id="trigger_<?php echo $gift['Gift']['id'];?>">&nbsp;</a></td>
<?php else: ?>
            <td class="selection">&nbsp;</td>
            <td class="fold">&nbsp;</td>
<?php endif; ?>
<?php echo $this->element('tableset/collumns/favorites', array('model'=>'Gift', 'id'=> $gift['Gift']['id'])); ?>
<?php echo $this->element('tableset/collumns/status', array('model'=>'Gift', 'status'=> $gift['Gift']['status'])); ?>
            <td class="title" >
              <a href="<?php echo Router::url('/admin/gifts/view/') . $gift['Gift']['id']; ?>" class="iconic gift creditcard">
            		<?php echo $gift['Gift']['serial']?>
            		<?php echo $gift['Gift']['amount'];?>
              	EUR <?php //@todo currencies?>
            		<?php echo $gift['Gift']['frequency'];?>
								<?php if ($type != 'onetime') : ?>
            			<?php echo $gift['Gift']['due'] ? 'Yes' : 'No'?>
								<?php endif; ?>
              </a>
            </td>
<?php if(!isset($leaf) || $leaf==false): ?>
            <td class="description">
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
<?php echo $this->element('tableset/collumns/attachments',array('model'=>'Gift', 'id'=> $gift['Gift']['id'], 'allowEmpty'=>true)); ?>
<?php echo $this->element('tableset/collumns/comments',array('model'=>'Gift', 'id'=> $gift['Gift']['id'], 'allowEmpty'=>true)); ?>
<?php echo $this->element('tableset/collumns/date', array('date'=>$gift['Gift']['modified'])); ?>
<?php echo $this->element('tableset/collumns/grab'); ?>
          </tr>