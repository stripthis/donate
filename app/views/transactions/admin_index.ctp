  <div class="transactions index">
  <h2><?php __('Transactions');?></h2>
  <table cellpadding="0" cellspacing="0">
  <tr>
    	<th><?php echo $paginator->sort('parent_id');?></th>
    	<th><?php echo $paginator->sort('gateway_id');?></th>
    	<th><?php echo $paginator->sort('external_id');?></th>
    	<th><?php echo $paginator->sort('gift_id');?></th>
    	<th><?php echo $paginator->sort('status');?></th>
    	<th><?php echo $paginator->sort('amount');?></th>
    	<th><?php echo $paginator->sort('created');?></th>
    	<th class="actions"><?php __('Actions');?></th>
  </tr>
<?php foreach ($transactions as $transaction) : ?>
	<tr>
		<td>
			<?php
			if (!empty($transaction['ParentTransaction']['id'])) {
				echo $html->link($transaction['ParentTransaction']['id'], array(
					'controller' => 'transactions', 'action' => 'view', $transaction['ParentTransaction']['id']
				));
			} else {
				echo '--';
			}
			?>
		</td>
    <td>
      <?php echo $transaction['Gateway']['name']; ?>
    </td>
    <td>
      <?php echo $transaction['Transaction']['external_id']; ?>
    </td>
    <td>
      <?php echo $html->link('Check', array('controller'=> 'gifts', 'action'=>'view', $transaction['Gift']['id'])); ?>
    </td>
    <td>
      <?php echo $transaction['Transaction']['status']; ?>
    </td>
    <td>
      <?php echo $transaction['Transaction']['amount']; ?>
    </td>
    <td>
      <?php echo $transaction['Transaction']['created']; ?>
    </td>
    <td class="actions">
      <?php echo $html->link(__('View', true), array('action'=>'view', $transaction['Transaction']['id']),array('class'=>'view')); ?>
      <?php echo $html->link(__('Delete', true), array('action'=>'delete', $transaction['Transaction']['id']), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $transaction['Transaction']['id'])); ?>
    </td>
  </tr>
	<?php if (!empty($transaction['ChildTransaction'])) : ?>
		<?php foreach ($transaction['ChildTransaction'] as $t) : ?>
		  <tr>
		    <td>
		      <?php
				echo $html->link($transaction['Transaction']['id'], array(
					'controller' => 'transactions', 'action' => 'view', $transaction['Transaction']['id']
				));
				?>
		    </td>
		    <td>
		      <?php echo $transaction['Gateway']['name']; ?>
		    </td>
		    <td>
		      <?php echo $transaction['Transaction']['external_id']; ?>
		    </td>
		    <td>
		      <?php echo $html->link('Check', array('controller'=> 'gifts', 'action'=>'view', $transaction['Gift']['id'])); ?>
		    </td>
		    <td>
		      <?php echo $transaction['Transaction']['status']; ?>
		    </td>
		    <td>
		      <?php echo $transaction['Transaction']['amount']; ?>
		    </td>
		    <td>
		      <?php echo $transaction['Transaction']['created']; ?>
		    </td>
		    <td class="actions">
		      <?php echo $html->link(__('View', true), array('action'=>'view', $transaction['Transaction']['id']),array('class'=>'view')); ?>
		      <?php echo $html->link(__('Delete', true), array('action'=>'delete', $transaction['Transaction']['id']), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $transaction['Transaction']['id'])); ?>
		    </td>
		  </tr>
		<?php endforeach; ?>
	<?php endif; ?>
<?php endforeach; ?>
  </table>
  </div>
  <div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
   |   <?php echo $paginator->numbers();?>
    <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
  </div>
  <p>
  <?php
  echo $paginator->counter(array(
  'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
  ));
  ?>  </p>
