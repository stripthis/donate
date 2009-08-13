 <?php
/**
 * Donation form credit card payment fieldset element 
 * Allows selection based on predefined cards type
 * 
 * @author      white rabbit team rocket!
 * @copyright   GREENPEACE INTERNATIONAL (c) 2009
 * @link        http://www.greenpeace.org/international/supportus
 */
  $cardOptions = Card::getTypes();
  $monthOptions = Card::getMonthOptions();
  $yearOptions = Card::getYearOptions();
  $cardSelected =  $giftForm->value('Card', 'type', 'visa', $form->data);
?>
    <fieldset>
        <legend>Payment Information:</legend>
        <div class="input_wrapper radio" id="card">
          <label for="amount" class="option_title">Card type: <?php echo $required; ?></label>
<?php foreach ($cardOptions as $cardId => $cardName): ?>
          <label class="option" id="<?php echo $cardId; ?>">
          	<input name="data[Card][type]" value="mastercard" class="radio" type="radio" 
          	<?php echo $cardSelected == '$cardName' ? $checked : ''; ?>>
          	<span><?php echo $cardName; ?></span>
          </label>
<?php endforeach; ?>
<?php if ($form->isFieldError('Card.type')):?>
					<div class="error"><?php echo $form->error("Card.type"); ?></div>
<?php endif; ?>
        </div>
        <div class="input_wrapper half">
          <?php
            echo $form->input('Card.number', array(
              'label' => 'Card number'. ': ' . $required, 
            ))."\n";
          ?>
        </div><div class="input_wrapper half" id="cvc">
          <?php
            echo $form->input('Card.verification_code', array(
              'label' => 'Verification code'. ': ' . $required . 
            	$giftForm->hint('The verification code is generally a 3 digit number located on the back of your card, or a 4 digit number located in front of american express card'), 
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper" id="expire">
          <label class="option">Expiracy date <?php echo $required; ?></label>
          <div>
            <?php 
              echo $form->input('Card.expire_month', array(
                'label' => 'month', 
                'options' => $monthOptions,
              ))."\n";
            ?>
            <?php 
              echo $form->input('Card.expire_year', array(
                'label' => 'year', 
                'options' => $yearOptions,
              ))."\n";
            ?>
        	</div>
        </div>
        
      </fieldset>
