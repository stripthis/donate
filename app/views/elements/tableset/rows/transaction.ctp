<?php
	//pr($transaction);
	//pr($gift);
	$options = array(
		'model'=>'Transaction', 
		'id'=> $transaction['id'], 
    'allowEmpty' => (isset($allowEmpty) ? $allowEmpty : true),
    'leaf' => (isset($leaf) ? $leaf : true),
  	'parent_id' => (isset($parent_id) ? $parent_id : false)
	);
?>
            <tr class="<?php echo $common->getFoldClass($options); ?>">
<?php echo $this->element('tableset/collumns/selection', $options); ?>
<?php echo $this->element('tableset/collumns/fold', $options); ?>
<?php echo $this->element('tableset/collumns/favorites',$options); ?>
<?php echo $this->element('tableset/collumns/status', array('model'=>'Gift', 'status'=> $transaction['status'])); ?>
              <td class="title">
                <a href="/admin/transactions/view/" class="iconic transaction up">
                   Test Mode (status: <?php echo $transaction['status']; ?>)
                </a>
              </td>
              <td class="description">
<?php if(isset($transaction['Gateway'])): ?>
                <?php echo $transaction['Gateway']['name']; ?>
<?php else: ?>
                <strong class="error-message"><?php __('The payment gateway is missing') ?></strong>
<?php endif; ?>
              </td>
<?php echo $this->element('tableset/collumns/attachments', $options); ?>
<?php echo $this->element('tableset/collumns/comments', $options); ?>
<?php echo $this->element('tableset/collumns/date', am($options,array('date'=> $transaction['modified']))); ?>
<?php echo $this->element('tableset/collumns/grab'); ?>
          </tr>
