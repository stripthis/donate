<h1><?php sprintf(__('Pending Transactions', true)); </h1>

<?php foreach ($results as $result) : ?>
	<?php pr($result)?>
<?php endforeach; ?>

<?php sprintf(__('Have fun with this report!
Your Greenpeace Staff', true)); ?>