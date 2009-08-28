<div class="content edit" id="users_edit">
<?php echo $this->element('messages')?>
<?php if(!isset($tabindex)) $tabindex = 1; ?>
<?php echo $form->create('User', array('action' => 'edit', 'autocomplete' => 'off'))?>
  <fieldset>
    <legend class="profile"><?php echo __("Your profile"); ?></legend>
    <?php echo $form->input('User.name', array('label' => __('Your Name (or nickname)',true).' *','class'=>'text required',"tabindex" => $tabindex++))?>
    <?php echo $form->input('User.country_id', array('label' => __('Country',true).' *', 'selected' => $this->data['User']['country_id'],"tabindex" => $tabindex++))?>
    <div class="state_id"><?php echo $this->data['User']['state_id']?></div>
    <?php echo $form->input('User.state_id', array('label' => __('State',true), 'type' => 'select',"tabindex" => $tabindex++))?>
    <?php echo $form->input('User.city', array('label' => __('City',true),"tabindex" => $tabindex++))?>
  </fieldset>
<?php echo $form->submit(__('Save',true)." »",array("tabindex"=>$tabindex++));?>
<?php echo $form->end()?>
</div>