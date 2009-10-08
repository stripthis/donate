<?php 
echo $javascript->link('/tellfriends/js/jquery.base64.js');
echo $javascript->link('/tellfriends/js/ajaxRefer.js');
echo $javascript->link('/tellfriends/js/datepicker.js');
?>
<style type="text/css">
@import "js/datepicker/jquery.datepick.css";
</style>
		<fieldset>
				<legend><?php echo __('Date Picker Demo', true); ?></legend>
				<div id= "contactList"></div>
                              
<select id="a_month">
<option value="">Month</option>
<option value="1">Jan</option>
<option value="2">Feb</option>
<option value="3">Mar</option>
<option value="4">Apr</option>
<option value="5">May</option>
<option value="6">Jun</option>
<option value="7">Jul</option>
<option value="8">Aug</option>
<option value="9">Sep</option>
<option value="10">Oct</option>
<option value="11">Nov</option>
<option value="12">Dec</option>
</select>
<select id="a_day">
<option value="">Day</option>
<?php for($i=1; $i<=31; $i++) {?>
<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
<?php } ?>

</select>
<select id="a_year">
<option value="">Year</option>
<option value="2005">2005</option>
<option value="2006">2006</option>
<option value="2007">2007</option>
<option value="2008">2008</option>
<option value="2009">2009</option>
<option value="2010">2010</option>
</select><input id="a"  type="text" style="position: absolute; z-index: -1;" />
                <input type="text" id="popupDatepicker" >
  
			</fieldset>
