    <h2><?= __("What do you feel like doing?"); ?></h2>
    <div class="quicklinks">
      <ul>
        <li><?php echo $html->link( $html->image("icons/XL/help.png", array("alt"=>"help"))."Help me get started...", 
                  array("admin"=>true,"controller"=>"help"), array('escape' => false)); ?> 
        </li>
        <li><?php echo $html->link( $html->image("icons/XL/appeals.png", array("alt"=>"appeals"))." Manage appeals", 
                  array("admin"=>true,"controller"=>"appeals", 'all'), array('escape' => false)); ?> 
        </li>
        <li><?php echo $html->link( $html->image("icons/XL/users.png", array("alt"=>"users"))." Manage Supporters", 
                  array("admin"=>true,"controller"=>"users", 'all'), array('escape' => false)); ?> 
        </li>
        <li><?php echo $html->link( $html->image("icons/XL/kexi.png", array("alt"=>"help"))."Browse Gifts", 
                  array("admin"=>true,"controller"=>"gifts", 'all'), array('escape' => false)); ?> 
        </li>
        <li><?php echo $html->link( $html->image("icons/XL/vcard.png", array("alt"=>"help"))."Browse Transactions", 
                  array("admin"=>true,"controller"=>"transactions", 'all'), array('escape' => false)); ?> 
        </li>
        <div class="clear"></div>
        <li><?php echo $html->link( $html->image("icons/XL/statistics.png", array("alt"=>"help"))."Browse Statistics", 
                  array("admin"=>true,"controller"=>"statistics"), array('escape' => false)); ?> 
        </li>
        <li><?php echo $html->link( $html->image("icons/XL/bug.png", array("alt"=>"bug"))."Report a Bug", 
                  array("admin"=>true,"controller"=>"bugs", 'action' => 'add', 'plugin' => 'bugs'), array('escape' => false)); ?> 
        </li>
        <li><?php echo $html->link( $html->image("icons/XL/office_config.png", array("alt"=>"office config"))."Office Config", 
                  array("admin"=>true,"controller"=>"offices", 'all'), array('escape' => false)); ?> 
        </li>
      </ul>
    </div>