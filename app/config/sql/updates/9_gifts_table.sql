CREATE TABLE `gifts` (
`id` CHAR( 36 ) NOT NULL ,
`type` ENUM( 'donation' ) NOT NULL ,
`amount` FLOAT NOT NULL ,
`recurring` TINYINT( 1 ) NOT NULL DEFAULT '0',
`description` TEXT NOT NULL ,
`start` DATETIME NOT NULL ,
`end` DATETIME NOT NULL ,
`frequency` VARCHAR( 255 ) NOT NULL ,
`appeal_id` CHAR( 36 ) NOT NULL ,
`user_id` CHAR( 36 ) NOT NULL ,
`created` DATETIME NOT NULL ,
`modified` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;