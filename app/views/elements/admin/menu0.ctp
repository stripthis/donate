<?php
$Session = Common::getComponent('Session');
$Session->read('Office.id');
?>
    <ul class="menu" id="menu_top">
      <li><a href="<?php echo Router::Url("/admin/home",true) ?>"  <?php if($this->name=="Statistics") echo 'class="selected"'?>><?php echo __("Home"); ?></li>
      <li><a href="<?php echo Router::Url("/admin/appeals/index",true) ?>" <?php if($this->name=="Appeals") echo 'class="selected"';?>><?php echo __("Appeals");?></a></li>
      <li><a href="<?php echo Router::Url("/admin/gifts/index",true) ?>" <?php if($this->name=="Gifts") echo 'class="selected"';?>><?php echo __("Gifts");?></a></li>
      <li><a href="<?php echo Router::Url("/admin/transactions/index",true) ?>" <?php if($this->name=="Transactions") echo 'class="selected"';?>><?php echo __("Transactions");?></a></li>
      <li><a href="<?php echo Router::Url("/admin/supporters/index",true) ?>" <?php if($this->name=="Supporters") echo 'class="selected"';?>><?php echo __("Supporters");?></a></li>
<?php if (User::isRoot()) : ?>
      <li><a href="<?php echo Router::Url("/admin/offices") ?>" <?php if($this->name=="Offices") echo 'class="selected"';?>><?php echo __("Offices");?></a></li>
      <li><a href="<?php echo Router::Url("/admin/users") ?>" <?php if($this->name=="Users") echo 'class="selected"';?>><?php echo __("Users");?></a></li>
      <li><a href="<?php echo Router::Url("/admin/bugs") ?>" <?php if($this->name=="Bugs") echo 'class="selected"';?>><?php echo __("Bugs");?></a></li>
<?php elseif (User::isSuperAdmin()) : ?>
      <li><a href="<?php echo Router::Url("/admin/offices/edit/" . $Session->read('Office.id'),true) ?>" <?php if($this->name=="Offices") echo 'class="selected"';?>><?php echo __("Office Config");?></a></li>
<?php endif; ?>
    </ul>
<?php /*<!-- menu -->
      <ul class="menu" id="top">
        <li class="selected">
          <div class="tab" id="single">
            <a href="http://doris-services.com/home">Home</a>
          </div>
        </li>
        <li>
          <div class="tab">
            <a href="http://doris-services.com/real_estate">Real Estate</a><a href="#" class="sub"><img style="border-style: solid;" src="http://doris-services.com/img/layout/tab_arrow_down.png"></a>
          </div>
          <ul style="visibility: hidden;" class="submenu">
            <li><a href="http://doris-services.com/real_estate/apartments">Apartments</a></li>
            <li><a href="http://doris-services.com/real_estate/independant_houses">Independant Houses</a></li>
            <li><a href="http://doris-services.com/real_estate/farm_houses">Farm Houses</a></li>
            <li><a href="http://doris-services.com/real_estate/commercial">Commercial</a></li>
            <li><a href="http://doris-services.com/real_estate/offices">Offices</a></li>
          </ul>
        </li>
        <li>
          <div class="tab">
            <a href="http://doris-services.com/facilities">Facilites</a><a href="#" class="sub"><img src="http://doris-services.com/img/layout/tab_arrow_down.png"></a>
          </div>
          <ul class="submenu">
            <li><a href="http://doris-services.com/facilities/furnitures">Furnitures</a></li>

            <li><a href="http://doris-services.com/facilities/air_conditioners">Air Conditioners</a></li>
            <li><a href="http://doris-services.com/facilities/generators">Generators</a></li>
            <li><a href="http://doris-services.com/facilities/cars_and_drivers">Cars &amp; Drivers</a></li>
            <li><a href="http://doris-services.com/facilities/home_staff">Home staff</a></li>
            <li><a href="http://doris-services.com/facilities/interpreters">Interpreters</a></li>

          </ul>
        </li>
        <li>
          <div class="tab">
            <a href="http://doris-services.com/services">Services</a><a href="#" class="sub"><img src="http://doris-services.com/img/layout/tab_arrow_down.png"></a>
          </div>
          <ul class="submenu">
            <li><a href="http://doris-services.com/services/renovation">Renovation</a></li>

            <li><a href="http://doris-services.com/services/maintenance">Maintenance</a></li>
            <li><a href="http://doris-services.com/services/travel_services">Travel Services</a></li>
            <!--<li><a href="#">Around the world</a></li>-->
          </ul>
        </li>
        <li>
          <div class="tab">
            <a href="http://doris-services.com/packages">Packages</a><a href="#" class="sub"><img src="http://doris-services.com/img/layout/tab_arrow_down.png"></a>

          </div>
          <ul class="submenu">
            <li><a href="http://doris-services.com/packages/residential">Residential</a></li>
            <li><a href="http://doris-services.com/packages/corporate">Corporate</a></li>
            <li><a href="http://doris-services.com/packages/relocation">Relocation</a></li>
          </ul>
        </li>

        <li>
          <div class="tab">
            <a href="http://doris-services.com/about">About</a><a href="#" class="sub"><img src="http://doris-services.com/img/layout/tab_arrow_down.png"></a>
          </div>
          <ul class="submenu">
            <li><a href="http://doris-services.com/about/news">News</a></li><li>
            </li><li><a href="http://doris-services.com/about/careers">Careers</a></li>

            <li><a href="http://doris-services.com/about/contact_us">Contact Us</a></li>
            <li><a href="http://doris-services.com/about/sitemap">Sitemap</a></li>
            <li><a href="http://doris-services.com/about/help">Help</a></li>
          </ul>
        </li>
      </ul>
  </div>
*/?>
