<?php
$options = array(
	'doFavorites' => class_exists('Favorite') && Favorite::doForModel('Gift'),
	'model' => 'gift'
);
$urlParams = $params;
$urlParams[] = $type;
$urlParams['merge'] = true;

unset($urlParams['ext']);
unset($urlParams['page']);
?>
<div class="content" id="gifts_index">
	<h2><?php echo __('Online Donations', true);?></h2>
	<?php
	echo $this->element('nav', array(
		'type' => 'gift_sub', 'class' => 'menu with_tabs', 'div' => 'menu_wrapper'
	));
	?>
	<?php
	echo $form->create('Gift', array('url' => '/admin/exports/gifts', 'type' => 'post'));
	echo $this->element('../gifts/elements/actions', array('export' => true));
	?>
<?php if (isset($gifts) && !empty($gifts)) : ?>
		<div class="index_wrapper">
			<table>
				<thead>
					<tr>
						<th class="selection"><input name="Gift" class="select_all checkbox" type="checkbox"></th>
						<th class="fold">&nbsp;</th>
						<th class="favorites">&nbsp;</th>
						<th class="status">&nbsp;</th>
						<th class="title">
							<?php echo $myPaginator->sort(__('Amount',true),'Gift.amount'); ?>
							<?php echo $myPaginator->sort(__('Frequency',true),'Gift.frequency'); ?>
							<?php if ($type != 'onetime') : ?>
								<?php echo $myPaginator->sort(__('Due',true),'Gift.due'); ?>
						<?php endif; ?>
					</th>
					<th class="description">
						<?php echo $myPaginator->sort(__('First Name',true),'Contact.fname'); ?> 
						<?php echo $myPaginator->sort(__('Last Name',true),'Contact.lname'); ?>
						<?php echo $myPaginator->sort(__('Email',true),'Contact.email'); ?>
					</th>
					<th class="attachments">&nbsp;</th>
					<th class="comments">&nbsp;</th>
					<th class="date"><?php echo $myPaginator->sort(__('Date',true),'Gift.modified'); ?></th>
					<th class="grab"></th>
				</tr>
				</thead>
				<tbody>
					<?php
					foreach ($gifts as $gift) {
						$options['parent_id'] = $gift['Gift']['id'];
						$options['gift'] = $gift;
						$options['leaf'] = 0;
						echo $this->element('tableset/rows/gift',$options);
						if(isset($gift)) {
							$options['leaf'] = 1;
							echo $this->element('tableset/rows/gift', $options);
							if(isset($gift['Contact'])) {
								echo $this->element('tableset/rows/contact',am($options,array('contact'=>$gift))); 
							}
							if (isset($gift['Transaction'])) {
								foreach ($gift['Transaction'] as $transaction) {
									echo $this->element('tableset/rows/transaction', am(
										$options, compact('transaction')
									));
								}
							}
						}
					}
					?>
				</tbody>
			</table>
		</div>
		<?php echo $this->element('paging', array('model' => 'Gift', 'url' => $urlParams)); ?>
	<?php else : ?>
		<p class="nothing"><?php echo __('Sorry but there is nothing to display here...', true); ?></p>
	<?php endif; ?>
	<?php
	echo $form->end();
	echo $this->element('../gifts/elements/filter', compact('params', 'type'));
	?>
</div>