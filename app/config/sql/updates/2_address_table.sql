CREATE TABLE `addresses` (
`id` CHAR( 36 ) NOT NULL ,
`user_id` CHAR( 36 ) NOT NULL ,
`line_1` VARCHAR( 150 ) NOT NULL ,
`line_2` VARCHAR( 200 ) NOT NULL ,
`country_id` CHAR( 36 ) NOT NULL ,
`state_id` CHAR( 36 ) NOT NULL ,
`city_id` CHAR( 36 ) NOT NULL ,
`primary` TINYINT( 1 ) NOT NULL DEFAULT '0',
`created` DATETIME NOT NULL ,
`modified` DATETIME NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `addresses` ADD PRIMARY KEY ( `id` );