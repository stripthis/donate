 <?php
/**
 * Donation form credit card payment fieldset element 
 * Allows selection based on predefined cards type
 * 
 * @author			white rabbit team rocket!
 * @copyright	 GREENPEACE INTERNATIONAL (c) 2009
 * @link				http://www.greenpeace.org/international/supportus
 */
	$cardOptions = Card::getTypes();
	$cardSelected = $giftForm->value('Card', 'type', 'visa', $form->data);
?>
		<fieldset id="card">
				<legend><?php __('Payment Information') ?>:</legend>
				<div class="input_wrapper radio">
					<label for="amount" class="option_title"><?php __('Card type'); ?>: <?php echo $giftForm->required(); ?></label>
<?php if ($form->isFieldError('Card.type')):?>
					<div class="error"><?php echo $form->error("Card.type"); ?></div>
<?php endif; ?>

		<?php foreach ($cardOptions as $cardId => $cardName): ?>
					<label class="option" id="<?php echo $cardId; ?>">
						<input name="data[Card][type]" value="<?php echo low($cardName) ?>" class="radio" type="radio" 
						<?php echo $cardSelected == low($cardName) ? $giftForm->checked() : ''; ?>>
						<span><?php echo $cardName; ?></span>
					</label>
		<?php endforeach; ?>
				</div>
				<div class="input_wrapper half">
					<?php
						echo $form->input('Card.cardholder_name', array(
							'label' => 'Cardholder name'. ': ' . $giftForm->required(), 
						))."\n";
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
							)))."\n";
						?>
					</div>
				</div>
				<div class="spacer"></div>
				<div class="input_wrapper half">
					<?php
						echo $form->input('Card.number', array(
							'label' => 'Card number'. ': ' . $giftForm->required(), 
						))."\n";
					?>
				</div>
				<div class="input_wrapper half" id="cvc">
					<?php
						echo $form->input('Card.verification_code', array(
							'label' => 'Verification code'. ': ' . $giftForm->required() . 
							$giftForm->hint('The verification code is generally a 3 digit number located on the back of your card.'), 
						))."\n";
					?>
				</div>
			</fieldset>
