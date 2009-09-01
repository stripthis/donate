== <?php echo Configure::read('App.name') ?> - Lost Password == 

Dear <?php echo $name; ?>, 

in order to reset your password please follow the link below:

<?php echo Router::url('/auth_keys/view/' . $authKey . '/user_id:' . $id . '/auth_key_type_id:' . $authKeyTypeId, true); ?>

If you did not request this password recovery, please disregard this message.

-- Your <?php echo Configure::read('App.name') ?> Team