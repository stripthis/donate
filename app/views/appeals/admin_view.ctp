<div class="content" id="appeals view">
	<h2><?php  sprintf(__('Appeal', true));?></h2>
	<div class="actions">
		<h3><?php sprintf(__('Actions', true)); ?></h3>
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
		<dt><?php sprintf(__('Id', true)); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['id']; ?>
			&nbsp;
		</dd>
		<dt><?php sprintf(__('Parent', true)); ?></dt>
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
		<dt><?php sprintf(__('Name', true)); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['name']; ?>
			&nbsp;
		</dd>
		<dt><?php sprintf(__('Campaign Code', true)); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['campaign_code']; ?>
			&nbsp;
		</dd>
		<dt><?php sprintf(__('Is Default', true)); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['default'] ? __('Yes', true) : __('No', true); ?>
			&nbsp;
		</dd>
		<dt><?php sprintf(__('Cost', true)); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['cost']; ?>
			&nbsp;
		</dd>
		<dt><?php sprintf(__('Reviewed', true)); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['reviewed']; ?>
			&nbsp;
		</dd>
		<dt><?php sprintf(__('Status', true)); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['status']; ?>
			&nbsp;
		</dd>
		<dt><?php sprintf(__('Created By', true)); ?></dt>
		<dd>
			<?php
			echo $html->link($appeal['User']['login'], array(
				'controller'=> 'users', 'action'=>'view', $appeal['User']['id']
			));
			?>
			&nbsp;
		</dd>
		<dt><?php sprintf(__('Created On', true)); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['created']; ?>
			&nbsp;
		</dd>
		<dt><?php sprintf(__('Last Modified', true)); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>