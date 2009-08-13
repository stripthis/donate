  <div class="offices index">
  <h2><?php __('Offices');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('New Office', true), array('action'=>'add'),array('class'=>'add')); ?></li>
      <li><?php echo $html->link(__('List Gateways', true), array('controller'=> 'gateways', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Gateway', true), array('controller'=> 'gateways', 'action'=>'add')); ?> </li>
    </ul>
  </div>
  <table cellpadding="0" cellspacing="0">
  <tr>
    	<th><?php echo $paginator->sort('name');?></th>
    	<th><?php echo $paginator->sort('parent_id');?></th>
    	<th><?php echo $paginator->sort('created');?></th>
    	<th><?php echo $paginator->sort('modified');?></th>
    	<th class="actions"><?php __('Actions');?></th>
  </tr>
<?php
$i = 0;
foreach ($offices as $office):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
  <tr<?php echo $class;?>>
    <td>
      <?php echo $office['Office']['name']; ?>
    </td>
    <td>
      <?php echo $office['ParentOffice']['name']; ?>
    </td>
    <td>
      <?php echo $office['Office']['created']; ?>
    </td>
    <td>
      <?php echo $office['Office']['modified']; ?>
    </td>
    <td class="actions">
      <?php echo $html->link(__('View', true), array('action'=>'view', $office['Office']['id']),array('class'=>'view')); ?>
      <?php echo $html->link(__('Edit', true), array('action'=>'edit', $office['Office']['id']),array('class'=>'edit')); ?>
      <?php echo $html->link(__('Delete', true), array('action'=>'delete', $office['Office']['id']), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $office['Office']['id'])); ?>
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
