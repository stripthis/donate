    <h2><?= __("What do you feel like doing?"); ?></h2>
    <div class="quicklinks">
      <ul>
        <li><?php echo $html->link( $html->image("icons/XL/challenges.png", array("alt"=>"challenges"))." Manage challenges", 
                  array("admin"=>true,"controller"=>"challenges"), array('escape' => false)); ?> 
        </li>
        <li><?php echo $html->link( $html->image("icons/XL/rules.png", array("alt"=>"rules"))." Manage rules", 
                  array("admin"=>true,"controller"=>"criteria"), array('escape' => false)); ?> 
        </li>
        <li><?php echo $html->link( $html->image("icons/XL/leaders.png", array("alt"=>"leaders"))." Manage Leaders", 
                  array("admin"=>true,"controller"=>"leaders"), array('escape' => false)); ?> 
        </li>
        <li><?php echo $html->link( $html->image("icons/XL/users.png", array("alt"=>"users"))." Manage Users", 
                  array("admin"=>true,"controller"=>"users"), array('escape' => false)); ?> 
        </li>
      </ul>
    </div>