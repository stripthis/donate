    <div id="home" class="landing_page"><?php $tabindex = 1; ?>
	<?php echo $html->link('Eng', array('language' => 'eng'))?>
	<?php echo $html->link('Fre', array('language' => 'fre'))?>
      <h2>
        <?php echo __("White Rabbit - Easy Donating to Greenpeace")."\n"; ?>
		<?php echo __('Give us some money and we will make the world a better place!')?>
        <?php echo $html->link(__("Get Involved!",true)." »","/register",array('class'=>'major'))."\n"; ?>
      </h2>
      <div class="movie">
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="581" height="300"> 
          <param name="movie" value="http://www.updesign.info/itchallenge/Intro5.swf"> 
          <param name="quality" value="high"><param name="BGCOLOR" value="#FFFFFF"> 
          <embed src="http://www.greenpeace.org/international/assets/flashes/cool-it-challenge-intro-animat.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" bgcolor="#FFFFFF" width="581" height="300"> 
        </object>
      </div>
      <div class="signup">
        <?php echo __("Join thousands of techies, geeks and activists on an urgent mission to fight climate change. Let's have some fun!")."\n";?>
        <form id="userAddForm" method="get" action="/users/register/">
          <div class="input text">
            <label for="userLogin" class="hidden"><?php echo __("Email"); ?></label>
            <input name="email" type="text" tabindex="1" title="<?php echo __("your email");?>" value="<?php echo __("your email");?>" id="userLogin" class="hint" />
          </div>
          <div class="submit"><input type="submit" value="<?php echo __("register"); ?> »" tabindex="2" /></div>
        </form>
      </div>
    </div>
