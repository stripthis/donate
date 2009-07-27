  <div class="appeals index">
  <h2><?php __('Appeals');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('New Appeal', true), array('action'=>'add'),array('class'=>'add')); ?></li>
    </ul>
  </div>
  <table cellpadding="0" cellspacing="0">
  <tr>
    	<th><?php echo $paginator->sort('id');?></th>
    	<th><?php echo $paginator->sort('parent_id');?></th>
    	<th><?php echo $paginator->sort('name');?></th>
    	<th><?php echo $paginator->sort('campaign_code');?></th>
    	<th><?php echo $paginator->sort('default');?></th>
    	<th><?php echo $paginator->sort('starred');?></th>
    	<th><?php echo $paginator->sort('cost');?></th>
    	<th><?php echo $paginator->sort('reviewed');?></th>
    	<th><?php echo $paginator->sort('status');?></th>
    	<th><?php echo $paginator->sort('country_id');?></th>
    	<th><?php echo $paginator->sort('Created By', 'user_id');?></th>
    	<th><?php echo $paginator->sort('created');?></th>
    	<th><?php echo $paginator->sort('modified');?></th>
    	<th class="actions"><?php __('Actions');?></th>
  </tr>
<?php
$i = 0;
foreach ($appeals as $appeal):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
  <tr<?php echo $class;?>>
    <td>
      <?php echo $appeal['Appeal']['id']; ?>
    </td>
    <td>
      <?php echo $html->link($appeal['Parent']['name'], array('controller'=> 'appeals', 'action'=>'view', $appeal['Parent']['id'])); ?>
    </td>
    <td>
      <?php echo $appeal['Appeal']['name']; ?>
    </td>
    <td>
      <?php echo $appeal['Appeal']['campaign_code']; ?>
    </td>
    <td>
      <?php echo $appeal['Appeal']['default']; ?>
    </td>
    <td>
      <?php echo $appeal['Appeal']['starred']; ?>
    </td>
    <td>
      <?php echo $appeal['Appeal']['cost']; ?>
    </td>
    <td>
      <?php echo $appeal['Appeal']['reviewed']; ?>
    </td>
    <td>
      <?php echo $appeal['Appeal']['status']; ?>
    </td>
    <td>
      <?php echo $appeal['Country']['name']; ?>
    </td>
    <td>
      <?php echo $html->link($appeal['User']['login'], array('controller'=> 'users', 'action'=>'view', $appeal['User']['id'])); ?>
    </td>
    <td>
      <?php echo $appeal['Appeal']['created']; ?>
    </td>
    <td>
      <?php echo $appeal['Appeal']['modified']; ?>
    </td>
    <td class="actions">
      <?php echo $html->link(__('View', true), array('action'=>'view', $appeal['Appeal']['id']),array('class'=>'view')); ?>
      <?php echo $html->link(__('Edit', true), array('action'=>'edit', $appeal['Appeal']['id']),array('class'=>'edit')); ?>
      <?php echo $html->link(__('Delete', true), array('action'=>'delete', $appeal['Appeal']['id']), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $appeal['Appeal']['id'])); ?>
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
