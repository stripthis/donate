<div class="content" id="appeals view">
	<h2><?php echo __('Appeal', true);?></h2>
	<div class="actions">
		<h3><?php echo __('Actions', true); ?></h3>
		<ul>
			<li>
				<?php
				echo $html->link(__('Edit Appeal', true),
					array('action' => 'edit', $appeal['Appeal']['id']),
					array('class' => 'edit')
				);
				?>
			</li>
			<li>
				<?php
				echo $html->link(__('Clone Appeal', true),
					array('action' => 'add', 'clone_id' => $appeal['Appeal']['id']),
					array('class' => 'add')
				);
				?>
			</li>
			<li>
				<?php
				echo $html->link(__('Delete Appeal', true),
					array('action' => 'delete', $appeal['Appeal']['id']),
					array('class' => 'delete'), __('Are you sure?', true)
				);
				?>
			</li>
		</ul>
	</div>
	<dl>
		<dt><?php echo __('Name', true); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['name']; ?>
		</dd>
		<dt><?php echo __('Status', true); ?></dt>
		<dd>
			<?php echo ucfirst($appeal['Appeal']['status']); ?>
		</dd>
		<dt><?php echo __('Campaign Code', true); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['campaign_code']; ?>
		</dd>
		<dt><?php echo __('Is Default', true); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['default'] ? __('Yes', true) : __('No', true); ?>
		</dd>
		<dt><?php echo __('Cost', true); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['cost']; ?>
		</dd>
		<dt><?php echo __('Targeted Income', true); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['targeted_income']; ?>
		</dd>
		<dt><?php echo __('Targeted Signups', true); ?></dt>
		<dd>
			<?php echo $appeal['Appeal']['targeted_signups']; ?>
		</dd>
		<dt><?php echo __('Created By', true); ?></dt>
		<dd>
			<?php
			echo $html->link($appeal['User']['login'], array(
				'controller' => 'users', 'action' => 'view', $appeal['User']['id']
			));
			?>
		</dd>
		<dt><?php echo __('Created On', true); ?></dt>
		<dd>
			<?php echo $common->date($appeal['Appeal']['created']); ?>
		</dd>
		<dt><?php echo __('Last Modified', true); ?></dt>
		<dd>
			<?php echo $common->date($appeal['Appeal']['modified']); ?>
		</dd>
	</dl>
</div>