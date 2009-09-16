<h1>Thanks!</h1>
<p>Thank you for your gift! It is appreciated!</p>

<h2>Your Receipts</h2>
<p>Here is a list of receipts of all the gifts you made in this browser session so far.</p>

<ul>
<?php echo $this->element('tax_receipt'); ?>
<h2>Way To Go</h2>
<ul>
	<li>
		<?php echo $html->link('Add Another Gift', array('controller' => 'gifts', 'action' => 'add'))?>
	</li>
	<li>
		<?php echo $html->link('Tell Your Friends!', array('controller' => 'tell_friends', 'action' => 'add'))?>
	</li>
</ul>
	