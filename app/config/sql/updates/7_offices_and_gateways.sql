CREATE TABLE `offices` (
`id` CHAR( 36 ) NOT NULL ,
`parent_id` CHAR( 36 ) NOT NULL ,
`country_id` CHAR( 36 ) NOT NULL ,
`state_id` CHAR( 36 ) NOT NULL ,
`city_id` CHAR( 36 ) NOT NULL ,
`created` DATETIME NOT NULL ,
`modified` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `gateways` (
`id` CHAR( 36 ) NOT NULL ,
`name` VARCHAR( 100 ) NOT NULL ,
`uses_price` TINYINT( 1 ) NOT NULL DEFAULT '0',
`uses_rate` TINYINT( 1 ) NOT NULL DEFAULT '0',
`created` DATETIME NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `gateways` ADD PRIMARY KEY ( `id` );
ALTER TABLE `gateways` ADD `modified` DATETIME NOT NULL AFTER `created` ;
CREATE TABLE `gateways_offices` (
`id` CHAR( 36 ) NOT NULL ,
`gateway_id` CHAR( 36 ) NOT NULL ,
`office_id` CHAR( 36 ) NOT NULL ,
`created` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;
