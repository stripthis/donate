<?php
/**
 * Donation form gift selection fieldset element 
 * Allows selection based on predefined amounts, frequencies, currencies
 * Note: requires the help of /js/views/gifts/add.js
 * 
 * @author			white rabbit team rocket!
 * @copyright	 GREENPEACE INTERNATIONAL (c) 2009
 * @link				http://www.greenpeace.org/international/supportus
 */
	$currencyOptions = Gift::find('currencies');
	$frequencyOptions = Gift::find('frequencies');
	$typeOptions = Gift::find('gift_types');
	$amountOptions = explode(',', Gift::find('amounts'));
	$amountSelected = $giftForm->value('Gift', 'amount', '10', $form->data);
?>
			<fieldset class="left" id="gift_type">
				<legend><?php echo __("Gift Information"); ?></legend>
				<?php echo $form->input('Gift.id', array('type' => 'hidden'))."\n"; ?>
				<?php
				if (!isset($appealOptions)) {
					echo $form->input('Gift.appeal_id', array('type' => 'hidden'))."\n";
				} else {
					echo $form->input('Gift.appeal_id', array('options' => $appealOptions))."\n";
				}
				?>
				<?php //echo $form->input('Gift.type', array('options' => $typeOptions))."\n"; ?>
				<input name="data[Gift][type]" value="donation" id="GiftType" type="hidden">
				<div class="input_wrapper radio">
					<label for="amount" class="option_title">Amount: <strong class="required">*</strong></label>
		<?php foreach ($amountOptions as $amountOption): ?>
					<label class="option">
						<input name="data[Gift][amount]" value="<?php echo $amountOption; ?>" class="radio amount" type="radio" 
							<?php echo $amountSelected == $amountOption ? $giftForm->checked() : ''?>> <?php echo $amountOption; ?>€
					</label>
		<?php endforeach; ?>
				</div>
				<div class="input_wrapper radio" id="other_amount">
					<label class="option">
						<input name="data[Gift][amount]" value="other" class="form-radio otheramount" type="radio"> Other
					</label>
					<input name="data[Gift][amount_other]" type="text" class="text" id="txtOtherAmount" 
						value="<?php echo !in_array($amountSelected, $amountOptions) ? $amountSelected : ''?>"
						<?php echo !in_array($amountSelected, $amountOptions) ? $giftForm->checked() : ''?> 
					/> 
					<?php
						echo $form->input('currency', array(
							'label' => '', 'options' => $currencyOptions,
							'selected' => $giftForm->value('Gift', 'currency', 'EUR', $form->data)
						))."\n";
					?>
					<?php 
						if ($form->isFieldError('amount')) {
							echo '<div class="error">' . $form->error("Gift.amount") . '</div>';
						}
						if ($form->isFieldError('currency')) {
							echo '<div class="error">' . $form->error("Gift.currency"). '</div>';
						}
					?>
				</div>
				<?php
					$options = array(
						'label' => 'Frequency' . ': ' . $giftForm->required(),
						'options' => $frequencyOptions,
						'selected' => $giftForm->value('Gift', 'frequency', 'monthly', $form->data)
						);
					echo $form->input('frequency', $options);
				?>
			</fieldset>
