				<fieldset>
					<legend class="legal"><?php echo __('Small print',true); ?></legend>
					<div class="">
						<label>
							<?php echo $form->input('User.eula', array('label' => false, 'type' => 'checkbox', 'class' => 'required checkbox', 'div' => false))?>
							<span class="terms"><a href='http://www.greenpeace.org/international/footer/privacy' target="_blank"><?php echo __('I\'ve read and accept the fascinating privacy policy'); ?></a>.</span>
						</label>
						<div class="clear"></div>
						<p><?php __('Note: Greenpeace won\'t be selling or giving your information away.')?><br/><?php __('We only collect what is needed to contact you.'); ?></p>
					</div>
				</fieldset>
