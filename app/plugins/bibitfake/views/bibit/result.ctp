<h1><?php echo $this->pageTitle = 'Welcome to RBS World Pay!'; ?></h1>
<p>
	Please pay the following amount: <?php echo $transaction['Transaction']['amount']?> 
	<?php echo $transaction['Currency']['iso_code']?>
</p>

<?php
echo $form->create('Card', array('url' => $this->here));
echo $form->input('transaction_id', array('type' => 'hidden', 'value' => $transaction['Transaction']['id']));
?>
<fieldset id="card">
	<legend><?php __('Payment Information') ?>:</legend>
	<div class="input_wrapper radio">
		<label for="amount" class="option_title"><?php __('Card type'); ?>: <?php echo $giftForm->required(); ?></label>
		<?php
		echo $form->input('Card.type', array(
			'options' => $cardOptions, 'label' => false
		))
		?>
	</div>
	<div class="input_wrapper half">
		<?php
			echo $form->input('Card.cardholder_name', array(
				'label' => 'Cardholder name'. ': ' . $giftForm->required(), 
			));
		?>
	</div>
	<div class="input_wrapper half" id="expire">
		<label class="option"><?php __('Expiration date'); ?> <?php echo $giftForm->required(); ?></label>
		<div>
			<?php 
				echo r('>-<', '><', $form->input('Card.expire_date', array(
					'label' => false,
					'type' => 'date',
					'dateFormat' => 'MY',
					'minYear' => date('Y'),
					'maxYear' => date('Y') + 10,
					'separator' => '&nbsp;'
				)));
			echo $form->input('expire_date_hidden', array(
			'type' => 'hidden',
			'div' => false
		));
			?>
		</div>
	</div>
	<div class="spacer"></div>
	<div class="input_wrapper half">
		<?php
			echo $form->input('Card.number', array(
				'label' => 'Card number'. ': ' . $giftForm->required(), 
			));
		?>
	</div>
	<div class="input_wrapper half" id="cvc">
		<?php
			echo $form->input('Card.verification_code', array(
				'label' => 'Verification code'. ': ' . $giftForm->required() . 
				$giftForm->hint('The verification code is generally a 3 digit number located on the back of your card.'), 
			));
		?>
	</div>
</fieldset>
<?php
echo $form->end('Save');
?>