ALTER TABLE `users` CHANGE `city` `city_id` CHAR( 36 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `users` DROP `bet_points`;
ALTER TABLE `users`
  DROP `score`,
  DROP `rank`;
ALTER TABLE `users` ADD `office_id` CHAR( 36 ) NOT NULL AFTER `state_id` ;
ALTER TABLE `users` ADD `locale` VARCHAR( 50 ) NOT NULL AFTER `referral_key` ;
ALTER TABLE `users` ADD `first_name` VARCHAR( 50 ) NOT NULL AFTER `referral_key` ,
ADD `last_name` VARCHAR( 100 ) NOT NULL AFTER `first_name` ,
ADD `gender` ENUM( 'female', 'male' ) NOT NULL DEFAULT 'male' AFTER `last_name` ;
ALTER TABLE `users` ADD `has_donated` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `locale` ;