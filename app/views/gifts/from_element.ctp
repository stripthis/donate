<div class="index_wrapper">
	<table>
		<thead>
			<tr>
				<th class="favorites">&nbsp;</th>
				<th class="status">&nbsp;</th>
				<th class="title">
					<?php echo __('Amount',true); ?>
					<?php echo __('Frequency', true); ?>
					<?php echo __('Due', true); ?>
				</th>
				<th class="description">
					<?php echo __('First Name', true); ?> 
					<?php echo __('Last Name', true); ?>
					<?php echo __('Email', true); ?>
				</th>
				<th class="date"><?php echo __('Date', true); ?></th>
				<th class="grab"></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($gifts as $gift) {
				$options = array(
					'parent_id' => $gift['Gift']['id'],
					'gift' => $gift,
					'leaf' => 0,
					'do_selection' => 0,
					'do_fold' => 0
				);

				echo $this->element('tableset/rows/gift', $options);
				if (isset($gift['Contact'])) {
					// echo $this->element('tableset/rows/contact', am($options, array('contact' => $gift)));
				}
			}
			?>
		</tbody>
	</table>
</div>