			<fieldset>
				<legend><?php echo __('Tell A Friend', true); ?></legend>
				<div class="input_wrapper half">
					<?php 
					echo $form->input('Tellfriend.receiver', array('type' => 'text',
						'label' => __('Friends\' Email (comma separated emails)',true).' *','class'=>'input text required','div'=>false)
					);
					?>
					<a href="tellfriends/tellfriends/openinviter?keepThis=true&TB_iframe=true&height=360&width= 430" class="thickbox iconic address_book"  id="onpeniviterLink"><?php __('Import contacts from web...'); ?></a>
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
