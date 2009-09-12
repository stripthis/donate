<div class="content" id="offices_view">
<h2><?php  __('Office');?></h2>
  <div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
      <li><?php echo $html->link(__('Edit Office', true), array('action'=>'edit', $office['Office']['id']), array('class'=>'edit')); ?> </li>
    </ul>
  </div>
	<dl>
    <dt><?php __('Name'); ?></dt>
    <dd>
      <?php echo $office['Office']['name']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Parent Office'); ?></dt>
    <dd>
      <?php echo !empty($office['ParentOffice']) ? $office['ParentOffice']['name'] : '--'; ?>
      &nbsp;
    </dd>
    <dt><?php __('Created'); ?></dt>
    <dd>
      <?php echo $office['Office']['created']; ?>
      &nbsp;
    </dd>
    <dt><?php __('Modified'); ?></dt>
    <dd>
      <?php echo $office['Office']['modified']; ?>
      &nbsp;
    </dd>
	</dl>
	<h3><?php __('Supported Gateways');?></h3>
	<?php if (!empty($office['Gateway'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
    <th><?php __('Name'); ?></th>
    <th><?php __('Uses Price'); ?></th>
    <th><?php __('Uses Rate'); ?></th>
    <th><?php __('Created'); ?></th>
    <th><?php __('Modified'); ?></th>
  	<?php foreach ($office['Gateway'] as $gateway) : ?>
	    <tr>
	      <td><?php echo $gateway['name'];?></td>
	      <td><?php echo $gateway['uses_price'];?></td>
	      <td><?php echo $gateway['uses_rate'];?></td>
	      <td><?php echo $gateway['created'];?></td>
	      <td><?php echo $gateway['modified'];?></td>
	    </tr>
  	<?php endforeach; ?>
	</table>
<?php else : ?>
	<p>Nothing to show here.</p>
<?php endif; ?>
</div>

</div>