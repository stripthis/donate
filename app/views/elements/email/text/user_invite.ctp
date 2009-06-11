== <?php echo Configure::read('App.name') ?> - Invitation == 

Hey there,

your friend "<?php echo $name ?>" would like to invite you the Greenpeace CoolIt Challenge. This is what he had to say:

"<?php echo $message ?>"

In order to signup please go to <?php echo Router::url('/refer/' . $referralKey, true); ?>.

-- Your <?php echo Configure::read('App.name') ?> Team