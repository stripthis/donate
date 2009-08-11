<h1>Confirmation</h1>

<p>Thanks for considering to do this donation. Here is is your data presented again for confirmation.</p>

<?php
$types = Configure::read('App.gift_types');
$data = $this->data['Gift'];
?>

<?php echo $form->create('Gift', array('url' => $this->here))?>
	<dl>
		<dt>Type:</dt>
		<dd><?php echo $types[$data['type']] ?></dd>
		<dt>Amount</dt>
		<dd><?php echo $data['amount']?></dd>
		<dt>Description</dt>
		<dd><?php echo $data['description']?></dd>
	</dl>
<?php echo $form->end('Process!')?>