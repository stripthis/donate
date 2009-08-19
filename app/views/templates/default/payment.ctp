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
  $cardSelected = $giftForm->value('Card', 'type', 'visa', $form->data);
?>
    <fieldset id="card">
        <legend>Payment Information:</legend>
        <div class="input_wrapper radio">
          <label for="amount" class="option_title">Card type: <?php echo $giftForm->required(); ?></label>
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
          <label class="option">Expiration date <?php echo $giftForm->required(); ?></label>
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
      <div class="verisign">
      	<a href="/" class="">This form is secured with a SSL certificate.</a>
      </div>