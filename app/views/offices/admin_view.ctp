<div class="content" id="office_config_view">
	<h2><?php  echo __('Office Configuration', true);?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'admin_config_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<?php echo $this->element('../offices/elements/actions'); ?>
	<dl>
		<dt><?php echo __('Name', true); ?></dt>
		<dd>
			<?php echo $office['Office']['name']; ?>
			&nbsp;
		</dd>
		<?php if (!empty($office['ParentOffice']['name'])) : ?>
			<dt><?php echo __('Parent Office', true); ?></dt>
			<dd><?php echo $office['ParentOffice']['name'] ?></dd>
		<?php endif; ?>
		<dt><?php echo __('Created', true); ?></dt>
		<dd>
			<?php echo date('F d Y', strtotime($office['Office']['created'])); ?>
			&nbsp;
		</dd>
	</dl>
	<h3><?php echo __('Supported Gateways', true);?></h3>
	<?php if (!empty($office['Gateway'])):?>
		<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('Name', true); ?></th>
				<th><?php echo __('Uses Price', true); ?></th>
				<th><?php echo __('Uses Rate',true); ?></th>
				<th><?php echo __('Created', true); ?></th>
				<th><?php echo __('Modified', true); ?></th>
			</tr>
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
		<p><?php echo __('Nothing to show here.', true); ?></p>
	<?php endif; ?>
</div>