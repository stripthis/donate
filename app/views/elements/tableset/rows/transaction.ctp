<?php
	//pr($transaction);
	//pr($gift);
?>
            <tr>
          		<td class="select"></td>
          		<td class="folded"></td>
<?php echo $this->element('tableset/collumns/favorites', array('model'=>'Transaction', 'id'=> $transaction['id'])); ?>
<?php echo $this->element('tableset/collumns/status', array('model'=>'Gift', 'status'=> $transaction['status'])); ?>
              <td class="transaction"><?php //@todo dynamic ?>
                <a href="/admin/transactions/view/" class="iconic transaction up">
                   Test Mode (status: <?php echo $transaction['status']; ?>)
                </a>
              </td>
              <td class="bank">
                <?php echo $transaction['Gateway']['name']; ?>
              </td>
<?php echo $this->element('tableset/collumns/attachments',array('model'=>'Transaction', 'id'=> $transaction['id'], 'allowEmpty'=>true)); ?>
<?php echo $this->element('tableset/collumns/comments',array('model'=>'Transaction', 'id'=> $transaction['id'], 'allowEmpty'=>true)); ?>
                <?php echo $this->element('tableset/collumns/date', array('date'=> $transaction['modified'])); ?>
<?php echo $this->element('tableset/collumns/grab'); ?>
            </tr>
