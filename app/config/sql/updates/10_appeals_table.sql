CREATE TABLE `appeals` (
`id` CHAR( 36 ) NOT NULL ,
`parent_id` CHAR( 36 ) NOT NULL ,
`name` VARCHAR( 255 ) NOT NULL ,
`campaign_code` VARCHAR( 10 ) NOT NULL ,
`default` TINYINT( 1 ) NOT NULL ,
`starred` TINYINT( 1 ) NOT NULL ,
`cost` FLOAT NOT NULL ,
`reviewed` TINYINT NOT NULL ,
`status` ENUM( 'draft' ) NOT NULL ,
`country_id` CHAR( 36 ) NOT NULL ,
`user_id` CHAR( 36 ) NOT NULL ,
`created` DATETIME NOT NULL ,
`modified` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;