<h2><?php __('Supporters');?></h2>
<?php if (empty($gifts)) : ?>
	<p><?php echo __('Sorry there are no gifts yet.')?></p>
<?php else : ?>
	<dl>
		<?php foreach ($gifts as $gift) : ?>
			<h2>Gift</h2>
		    <dt>Type</dt><dd><?php echo $gift['Gift']['type']; ?></dd>
			<dt>Amount</dt><dd><?php echo $gift['Gift']['amount']; ?></dd>
			<dt>Frequency</dt><dd><?php echo $gift['Gift']['frequency']; ?></dd>
			<dt>Appeal</dt><dd><?php echo $html->link($gift['Appeal']['name'], array('controller'=> 'appeals', 'action'=>'view', $gift['Appeal']['id'])); ?></dd>
			<dt>When</dt><dd><?php echo $gift['Gift']['created']; ?></dd>
			<h2>Contact Data</h2>
			<dt>
			<dt>Name</dt><dd> <?php echo $common->contactName($gift) ?></dd>
			<dt>Email</dt><dd><?php echo $gift['Contact']['email']?></dd>
			<dt>Actions</dt>
			<dd>
				<?php echo $html->link('See all Transactions', array(
					'controller' => 'transactions', 'action' => 'index', $gift['Contact']['id']
				))?>
			</dd>
			<hr/>
		<?php endforeach; ?>
	</dl>
	<?php echo $this->element('paging', array('model' => 'Gift'))?>
<?php endif;?>