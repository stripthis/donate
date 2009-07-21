  <div class="gifts index">
  <h2><?php __('Gifts');?></h2>
  <table cellpadding="0" cellspacing="0">
  <tr>
    	<th><?php echo $paginator->sort('office_id');?></th>
    	<th><?php echo $paginator->sort('type');?></th>
    	<th><?php echo $paginator->sort('amount');?></th>
    	<th><?php echo $paginator->sort('frequency');?></th>
    	<th><?php echo $paginator->sort('appeal_id');?></th>
    	<th><?php echo $paginator->sort('fname');?></th>
    	<th><?php echo $paginator->sort('lname');?></th>
    	<th><?php echo $paginator->sort('zip');?></th>
    	<th><?php echo $paginator->sort('country_id');?></th>
    	<th><?php echo $paginator->sort('email');?></th>
    	<th><?php echo $paginator->sort('created');?></th>
    	<th class="actions"><?php __('Actions');?></th>
  </tr>
<?php
$i = 0;
foreach ($gifts as $gift):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
  <tr<?php echo $class;?>>
    <td>
      <?php echo $html->link($gift['Office']['name'], array('controller'=> 'offices', 'action' => 'view', $gift['Office']['id'])); ?>
    </td>
    <td>
      <?php echo $gift['Gift']['type']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['amount']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['frequency']; ?>
    </td>
    <td>
      <?php echo $html->link($gift['Appeal']['name'], array('controller'=> 'appeals', 'action'=>'view', $gift['Appeal']['id'])); ?>
    </td>
    <td>
      <?php echo $gift['Gift']['fname']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['lname']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['zip']; ?>
    </td>
    <td>
      <?php echo $gift['Country']['name']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['email']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['created']; ?>
    </td>
    <td class="actions">
      <?php echo $html->link(__('View', true), array('action'=>'view', $gift['Gift']['id']),array('class'=>'view')); ?>
      <?php echo $html->link(__('Edit', true), array('action'=>'edit', $gift['Gift']['id']),array('class'=>'edit')); ?>
      <?php echo $html->link(__('Delete', true), array('action'=>'delete', $gift['Gift']['id']), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $gift['Gift']['id'])); ?>
    </td>
  </tr>
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
