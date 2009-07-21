<div class="offices view">
<h2><?php  __('Office');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('Edit Office', true), array('action'=>'edit', $office['Office']['id']), array('class'=>'edit')); ?> </li>
      <li><?php echo $html->link(__('Delete Office', true), array('action'=>'delete', $office['Office']['id']),  array('class'=>'delete'), sprintf(__('Are you sure you want to delete # %s?', true), $office['Office']['id'])); ?> </li>
      <li><?php echo $html->link(__('List Offices', true), array('action'=>'index'),array('class'=>'index')); ?> </li>
      <li><?php echo $html->link(__('New Office', true), array('action'=>'add'),array('class'=>'add')); ?> </li>
    <li><?php echo $html->link(__('List Gateways', true), array('controller'=> 'gateways', 'action'=>'index')); ?> </li>
    <li><?php echo $html->link(__('New Gateway', true), array('controller'=> 'gateways', 'action'=>'add')); ?> </li>
    </ul>
  </div>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $office['Office']['id']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $office['Office']['name']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent Id'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $office['Office']['parent_id']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Country Id'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $office['Office']['country_id']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('State Id'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $office['Office']['state_id']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('City Id'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $office['Office']['city_id']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $office['Office']['created']; ?>
      &nbsp;
    </dd>
    <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
    <dd<?php if ($i++ % 2 == 0) echo $class;?>>
      <?php echo $office['Office']['modified']; ?>
      &nbsp;
    </dd>
	</dl>
</div>

<div class="related">
	<h3><?php __('Related Gateways');?></h3>
	<?php if (!empty($office['Gateway'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
    <th><?php __('Id'); ?></th>
    <th><?php __('Name'); ?></th>
    <th><?php __('Uses Price'); ?></th>
    <th><?php __('Uses Rate'); ?></th>
    <th><?php __('Created'); ?></th>
    <th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
  <?php
		$i = 0;
		foreach ($office['Gateway'] as $gateway):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
    <tr<?php echo $class;?>>
      <td><?php echo $gateway['id'];?></td>
      <td><?php echo $gateway['name'];?></td>
      <td><?php echo $gateway['uses_price'];?></td>
      <td><?php echo $gateway['uses_rate'];?></td>
      <td><?php echo $gateway['created'];?></td>
      <td><?php echo $gateway['modified'];?></td>
      <td class="actions">
        <?php echo $html->link(__('View', true), array('controller'=> 'gateways', 'action'=>'view', $gateway['id'])); ?>
        <?php echo $html->link(__('Edit', true), array('controller'=> 'gateways', 'action'=>'edit', $gateway['id'])); ?>
        <?php echo $html->link(__('Delete', true), array('controller'=> 'gateways', 'action'=>'delete', $gateway['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $gateway['id'])); ?>
      </td>
    </tr>
  <?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Gateway', true), array('controller'=> 'gateways', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
