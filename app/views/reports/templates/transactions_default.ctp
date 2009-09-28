<h1><?php echo __('Pending Transactions', true); ?></h1>

<?php foreach ($results as $result) : ?>
	<?php pr($result)?>
<?php endforeach; ?>

<?php echo __('Have fun with this report!
Your Greenpeace Staff', true); ?>