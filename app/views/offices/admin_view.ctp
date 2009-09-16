<div class="content" id="office_config_view">
	<h2><?php  __('Office Configuration');?></h2>
	  <?php
	    echo $this->element('nav', array(
			  'type' => 'admin_config_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
		  ));
		?>
		<?php echo $this->element('../offices/elements/actions'); ?>
		<dl>
		    <dt><?php __('Name'); ?></dt>
		    <dd>
		      <?php echo $office['Office']['name']; ?>
		      &nbsp;
		    </dd>
			<?php if (!empty($office['ParentOffice']['name'])) : ?>
		   		<dt><?php __('Parent Office'); ?></dt>
		   		<dd><?php echo $office['ParentOffice']['name'] ?></dd>
			<?php endif; ?>
		    <dt><?php __('Created'); ?></dt>
		    <dd>
		      <?php echo date('F d Y', strtotime($office['Office']['created'])); ?>
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