<?php 
echo $javascript->link('/tellfriends/js/ajaxRefer.js');
echo $javascript->link('/tellfriends/js/jquery.pagination.js');
echo $javascript->link('/tellfriends/js/paginate.js');
echo $html->css('/tellfriends/css/pagination.css');
?>
			<fieldset>
			<legend><?php __('Contact List'); ?></legend>
            <input type='text' id="openinviter_contact_list">
            <input type='hidden' id="your_login_email" value="<? echo $sender; ?>">
            <div id= "contactList">
            <table id="main">
            <tr>
                 <td></td>
                 <td></td>
                 <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <table id="Searchresult" style="overflow: hidden;text-overflow: ellipsis;"
>
                        <tr>
                        <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td colspan="3">
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
					$newKey       = 0;
					$numPages	  = ceil($totalContacts/33);
					for($p = 0; $p < $numPages; $p++) { ?>
                    <table class="index_wrapper" style="display:none;">
					<? for($r = 0; $r < 11; $r++) {
						?><tr><?
						for($c = 0; $c < $tableColumns; $c++) {
							if($newKey<$totalContacts) {
									?><td  valign="top"><input type="checkbox" id="hiddencheckbox_<? echo $newKey; ?>" name="hiddencheckbox" value="<? echo $newContacts[$newKey]; ?>" ></td><td valgin="bottom"><span id="hiddenspan_<? echo $newKey; ?>" class = "spantxt"><? echo $newContacts[$newKey]; ?></span></td><?
									$newKey++;
							} else {
									?><td  valign="top">&nbsp;</td><td valgin="bottom">&nbsp;</td><?
							}
						}
						?></tr><? }?>
                       </table> <? }?>
                       </td></tr>
                    <tr>
                     <td valgin="bottom"><div style="width:130px;"><input type="button" id="confirm" value="Confirm"></div></td>
                     <td valign="top" colspan ="2">&nbsp;</td>
                   </tr>
				    <tr>
                   <td colspan="3"> <div id="Pagination" class="pagination">
       			   </div></td>
                   </tr>
				   <?
				 } }
				if($errors){
					foreach ($errors as $key=>$val) {?>
					<tr>
						<td colspan="3"><? echo $val; ?></td>
					</tr>
					<?	} ?>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td><a href="tellfriends/tellfriends/openinviter"><strong>Back To Login</strong></a></td>
					<td colspan="2">&nbsp;</td>
				</tr>
				</table>
            <? } ?>
            </div>
			</fieldset>
            
