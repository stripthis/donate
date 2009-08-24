  <div class="gifts index">
  <h2><?php __('Gifts');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('New Gift', true), array('action'=>'add'),array('class'=>'add')); ?></li>
      <li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Appeals', true), array('controller'=> 'appeals', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Appeal', true), array('controller'=> 'appeals', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Countries', true), array('controller'=> 'countries', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Country', true), array('controller'=> 'countries', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Offices', true), array('controller'=> 'offices', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Office', true), array('controller'=> 'offices', 'action'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Transactions', true), array('controller'=> 'transactions', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Transaction', true), array('controller'=> 'transactions', 'action'=>'add')); ?> </li>
    </ul>
  </div>
  <table cellpadding="0" cellspacing="0">
  <tr>
    	<th><?php echo $paginator->sort('id');?></th>
    	<th><?php echo $paginator->sort('office_id');?></th>
    	<th><?php echo $paginator->sort('type');?></th>
    	<th><?php echo $paginator->sort('amount');?></th>
    	<th><?php echo $paginator->sort('description');?></th>
    	<th><?php echo $paginator->sort('frequency');?></th>
    	<th><?php echo $paginator->sort('appeal_id');?></th>
    	<th><?php echo $paginator->sort('user_id');?></th>
    	<th><?php echo $paginator->sort('fname');?></th>
    	<th><?php echo $paginator->sort('lname');?></th>
    	<th><?php echo $paginator->sort('salutation');?></th>
    	<th><?php echo $paginator->sort('title');?></th>
    	<th><?php echo $paginator->sort('address');?></th>
    	<th><?php echo $paginator->sort('zip');?></th>
    	<th><?php echo $paginator->sort('country_id');?></th>
    	<th><?php echo $paginator->sort('email');?></th>
    	<th><?php echo $paginator->sort('created');?></th>
    	<th><?php echo $paginator->sort('modified');?></th>
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
      <?php echo $gift['Gift']['id']; ?>
    </td>
    <td>
      <?php echo $html->link($gift['Office']['name'], array('controller'=> 'offices', 'action'=>'view', $gift['Office']['id'])); ?>
    </td>
    <td>
      <?php echo $gift['Gift']['type']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['amount']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['description']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['frequency']; ?>
    </td>
    <td>
      <?php echo $html->link($gift['Appeal']['name'], array('controller'=> 'appeals', 'action'=>'view', $gift['Appeal']['id'])); ?>
    </td>
    <td>
      <?php echo $html->link($gift['User']['login'], array('controller'=> 'users', 'action'=>'view', $gift['User']['id'])); ?>
    </td>
    <td>
      <?php echo $gift['Gift']['fname']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['lname']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['salutation']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['title']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['address']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['zip']; ?>
    </td>
    <td>
      <?php echo $html->link($gift['Country']['name'], array('controller'=> 'countries', 'action'=>'view', $gift['Country']['id'])); ?>
    </td>
    <td>
      <?php echo $gift['Gift']['email']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['created']; ?>
    </td>
    <td>
      <?php echo $gift['Gift']['modified']; ?>
    </td>
    <td class="actions">
      <?php echo $html->link(__('View', true), array('action'=>'view', $gift['Gift']['id']),array('class'=>'view')); ?>
      <?php echo $html->link(__('Edit', true), array('action'=>'edit', $gift['Gift']['id']),array('class'=>'edit')); ?>
      <?php echo $html->link(__('Delete', true), array('action'=>'delete', $gift['Gift']['id']), array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $gift['Gift']['id'])); ?>
    </td>
  </tr>
<?php endforeach; ?>
  </table>
	<?php echo $this->element('paging', array('model' => 'Gift'))?>
	  </div>
	