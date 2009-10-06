			<fieldset>
				<legend><?php echo __('Tell A Friend', true); ?></legend>
				<div id= "contactList"></div>
                Date Picker Demo<input type="text" id="popupDatepicker" >
				<div class="input_wrapper half">
					<?php 
					echo $form->input('Tellfriend.receiver', array('type' => 'text',
						'label' => __('Friends\' Email (comma separated emails)',true).' *','class'=>'input text required','div'=>false)
					);
					?>
					<a href="#" class="iconic address_book"><?php __('Import contacts from web...'); ?></a>
				</div>
				<div class="spacer"></div>
				<div class="input_wrapper half">
					<?php 
					echo $form->input('Tellfriend.sender', array('type' => 'text',
						'label' => __('Your Email',true).' (Optional)','class'=>'input text required','div'=>false)
					);
					?>
				</div>
				<div class="spacer"></div>
				<div class="input_wrapper full">
					<?php 
					echo $form->input('Tellfriend.content', array('type' => 'textarea',
						'label' => __('Your Message',true),'class'=>'input text required','div'=>false, 
						'value' => __('Hi, Your friend wants you to check out this website: www.greenpeace.org ', true))
					);
					?>
				</div>
			</fieldset>
