<div class="content" id="appeals view">
	<h2><?php  __('Appeal');?></h2>
	<div class="actions">
		<h3><?php echo __('Actions'); ?></h3>
		<ul>
			<li>
				<?php
				echo $html->link(__('Edit Appeal', true),
					array('action'=>'edit', $appeal['Appeal']['id']),
					array('class'=>'edit')
				);
				?>
			</li>
			<li>
				<?php
				echo $html->link(__('Delete Appeal', true),
					array('action'=>'delete', $appeal['Appeal']['id']),
					array('class'=>'delete'),
					__('Are you sure?', true)
				);
				?>
			</li>
		</ul>
	</div>
	<dl>
		<dt><?php __('Id'); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['id']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Parent'); ?></dt>
		<dd>
			<?php
			if (!empty($appeal['Parent']['name'])) {
				echo $html->link($appeal['Parent']['name'], array(
					'controller'=> 'appeals', 'action'=>'view', $appeal['Parent']['id']
				));
			} else {
				echo '--';
			}
			?>
			&nbsp;
		</dd>
		<dt><?php __('Name'); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['name']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Campaign Code'); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['campaign_code']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Is Default'); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['default'] ? __('Yes', true) : __('No', true); ?>
			&nbsp;
		</dd>
		<dt><?php __('Cost'); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['cost']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Reviewed'); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['reviewed']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Status'); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['status']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Created By'); ?></dt>
		<dd>
			<?php
			echo $html->link($appeal['User']['login'], array(
				'controller'=> 'users', 'action'=>'view', $appeal['User']['id']
			));
			?>
			&nbsp;
		</dd>
		<dt><?php __('Created On'); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['created']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Last Modified'); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>