<?php 
echo $javascript->link('/tellfriends/js/ajaxRefer.js');
?>
			<fieldset>
			<legend><?php __('Contact List'); ?></legend>
            <input type='hidden' id="openinviter_contact_list">
            <input type='hidden' id="your_login_email" value="<? echo $sender; ?>">
            <div id= "contactList">
            <table>
            <tr>
            <td colspan="6"></td>
            </tr>
            <?	
 			if($contacts){
				$totalContacts = count($contacts);
				if($totalContacts >0){
					$tempKey = 0;
					$newContacts = array();
					foreach ($contacts as $key=>$val) {
						$val = $key;
						$key = $tempKey;
						$newContacts[$key] = $val;
						$tempKey++;
					}
					$tableColumns = 3;
					$tableRows    = $totalContacts/3;
					$newKey       = 0;
					for($r = 0; $r < $tableRows; $r++) {
						?><tr><?
						for($c = 0; $c < $tableColumns; $c++) {
							if($newKey<$totalContacts) {
									?><td  valign="top"><input type="checkbox" id="contactcheckbox_<? echo $newKey; ?>" name="contactcheckbox" value="<? echo $newContacts[$newKey]; ?>" ></td><td valgin="bottom"><span id="contactspan_<? echo $newKey; ?>"><? echo $newContacts[$newKey]; ?></span></td><?
									$newKey++;
							} else {
									?><td  valign="top">&nbsp;</td><td valgin="bottom">&nbsp;</td><?
							}
						}
						?></tr><?
					}
				    ?><td valgin="bottom" colspan ="2"><input type="button" id="confirm" value="Confirm">&nbsp;</td><td valign="top" colspan ="4">&nbsp;</td><?
				 } }
				if($errors){
				foreach ($errors as $key=>$val) {?>
				<tr>
            <td colspan="6"><? echo $val; ?></td>
            </tr>
			<?	} ?>
            <tr>
            <td colspan="6">&nbsp;</td>
            </tr>
			<tr>
            <td><a href="tellfriends/tellfriends/openinviter"><strong>Back To Login</strong></a></td>
            <td colspan="5">&nbsp;</td>
            </tr>
			</table>
            <?	
			}
            ?>
            </div>
			</fieldset>
            
