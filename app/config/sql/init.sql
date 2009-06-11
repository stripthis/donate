CREATE TABLE `session_instances` (
  `id` char(36) collate utf8_unicode_ci NOT NULL,
  `key` varchar(32) collate utf8_unicode_ci NOT NULL,
  `user_id` char(36) collate utf8_unicode_ci default NULL,
  `data` varchar(8192) collate utf8_unicode_ci default NULL,
  `expires` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `key` (`key`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `countries` (
  `id` char(36) collate utf8_unicode_ci NOT NULL,
  `iso_code` char(2) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique code` (`iso_code`),
  UNIQUE KEY `unique name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `states` (
  `id` char(36) collate utf8_unicode_ci NOT NULL,
  `country_id` char(36) collate utf8_unicode_ci NOT NULL,
  `iso_code` char(2) collate utf8_unicode_ci NOT NULL,
  `fips_code` char(2) collate utf8_unicode_ci NOT NULL,
  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `country_id` (`country_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `auth_keys` (
  `id` char(36) collate utf8_unicode_ci NOT NULL,
  `user_id` char(36) collate utf8_unicode_ci NOT NULL,
  `auth_key_type_id` char(36) collate utf8_unicode_ci NOT NULL,
  `key` varchar(64) collate utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `expires` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `unique_key` (`key`),
  UNIQUE KEY `one_key_per_type` (`user_id`,`auth_key_type_id`),
  KEY `auth_key_type_id` (`auth_key_type_id`),
  KEY `user_id` (`user_id`),
  KEY `auth_key_type_id_2` (`auth_key_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `auth_key_types` (
  `id` char(36) collate utf8_unicode_ci NOT NULL,
  `name` varchar(64) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `users` CHANGE `id` `id` CHAR( 36 ) NOT NULL;
ALTER TABLE `supporters` CHANGE `id` `id` CHAR( 36 ) NOT NULL;
ALTER TABLE `posts` CHANGE `id` `id` CHAR( 36 ) NOT NULL;
ALTER TABLE `challenges` CHANGE `id` `id` CHAR( 36 ) NOT NULL;
ALTER TABLE `leaders` CHANGE `id` `id` CHAR( 36 ) NOT NULL;
ALTER TABLE `leaders_challenges` CHANGE `id` `id` CHAR( 36 ) NOT NULL;
ALTER TABLE `posts` CHANGE `id` `id` CHAR( 36 ) NOT NULL;
ALTER TABLE `criteria` CHANGE `id` `id` CHAR( 36 ) NOT NULL;

ALTER TABLE `users` ADD `country_id` CHAR( 36 ) NOT NULL AFTER `role` ,
ADD `state_id` CHAR( 36 ) NOT NULL AFTER `country_id` ;



INSERT INTO `greenpeace_voting`.`users` (
`id` ,
`login` ,
`password` ,
`active` ,
`role` ,
`country_id` ,
`state_id` ,
`created` ,
`modified`
)
VALUES (
'49f319c8-0a54-4e9f-9761-db0923c1de0a', 'guest@greenpeace.org', '', '1', 'user', '', '', '2009-04-25 16:11:02', '2009-04-25 16:11:07'
);
ALTER TABLE `users` CHANGE `role` `level` ENUM( 'user', 'admin', 'guest' ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL;
UPDATE `greenpeace_voting`.`users` SET `level` = 'guest' WHERE CONVERT( `users`.`id` USING utf8 ) = '49f319c8-0a54-4e9f-9761-db0923c1de0a' LIMIT 1 ;
ALTER TABLE `users` ADD `city` VARCHAR( 100 ) NOT NULL AFTER `level` ;

ALTER TABLE `users` CHANGE `active` `active` TINYINT( 1 ) NOT NULL DEFAULT '0';