    <div class="shortcuts widget">
    	<div class="widget_header">
 			  <h3><a href="<?php Router::url(); ?>#" class="toggle close" id="trigger_shortcuts"><?php echo __('Shortcuts'); ?></a></h3>
      </div>
      <div class="widget_content">
        <ul class="toggle_wrapper" id="wrapper_trigger_shortcuts">
          <li><a href="javascript:addFavorite()" class="tooltip iconic bookmark"><?php echo __('Bookmark this page'); ?></a></li>
          <li><a href="javascript:printThis()" class="tooltip iconic print"><?php echo __('Print this page'); ?></a></li>
        </ul>
      </div>
    </div>
