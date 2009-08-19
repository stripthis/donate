<?php
  $saluteOptions = Contact::getSalutations();
?>
			<fieldset id="contact">
        <legend><?php echo __("Contact Information"); ?></legend>
        <div class="input_wrapper">
          <?php
            echo $form->input('Contact.salutation', array(
              'label' => 'Salutation:', 'options' => $saluteOptions,
              'selected' => $giftForm->value('Contact', 'salutation', '', $form->data)
            ))."\n";
          ?>
        </div>
        <div class="spacer"></div>
        <div class="input_wrapper half">
          <?php
            echo $form->input('Contact.fname', array(
              'label' => 'First Name'. ': ' ,
              'value' => $giftForm->value('Contact', 'fname', '', $form->data)
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper half">
          <?php
            echo $form->input('Contact.lname', array(
              'label' => 'Last Name'. ': ' . $giftForm->required(),
              'value' => $giftForm->value('Contact', 'lname', '', $form->data)
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper full">
          <?php         
            echo $form->input('Address.line_1', array(
              'label' => 'Address'. ': ' . $giftForm->required(),
              'value' => $giftForm->value('Address', 'line_1', '', $form->data)
            ))."\n";
          ?>
          <?php
            echo $form->input('Address.line_2', array(
              'label' => "",
              'value' => $giftForm->value('Address', 'line_2', '', $form->data)
            ))."\n";
          ?>
        </div>
        <div  class="input_wrapper half">
          <?php
          echo $form->input('Address.zip', array(
            'label' => 'Zip Code'. ': ' . $giftForm->required(),
            'value' => $giftForm->value('Address', 'zip', '', $form->data)
          ))."\n";
          ?>
        </div>
        <div class="input_wrapper half">
          <?php
            echo $form->input('Address.city_id', array(
              'label' => 'City'. ': ' . $giftForm->required(),
              'value' => $giftForm->value('Address', 'city_id', '', $form->data)
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper">
          <?php 
            echo $form->input('Address.country_id', array(
              'label' => 'Country'. ': ' . $giftForm->required(), 'options' => $countryOptions,
              'selected' => $giftForm->value('Address', 'country_id', '', $form->data)
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper half">
          <?php
            echo $form->input('Contact.email', array(
              'label' => 'Email'. ': ' . $giftForm->required() . 
                $giftForm->hint('<strong>Q: Why do you need my email address?</strong><br/>A: We need your email address to send you a receipt or get in touch if something goes wrong.'),
              'value' => $giftForm->value('Contact', 'email', '', $form->data)
            ))."\n";
          ?>
          <?php
            $value = $giftForm->value('Contact', 'newsletter', '', $form->data);
            echo $form->input('Contact.newsletter', array(
              'label' => 'Yes, send me updates by email', 'type' => 'checkbox', 
              'class' => 'checkbox', 'div' => false,
              'checked' => $value ? 'checked' : ''
            ))."\n";
          ?>
        </div>
        <div class="input_wrapper half">
          <?php 
            echo $form->input('Phone.phone', array(
              'label' => 'Phone'. ': ',
               'value' => $giftForm->value('Phone', 'phone', '', $form->data)
            ))."\n";
          ?>
          <?php
            $value = $giftForm->value('Phone', 'contactable', '', $form->data);
            echo $form->input('Phone.contactable', array(
              'label' => 'Yes, it\'s ok to call me at this number', 'type' => 'checkbox',
              'class' => 'checkbox', 'div' => false,
              'checked' => $value ? 'checked' : ''
            ))."\n";
          ?>
        </div>
      </fieldset>
