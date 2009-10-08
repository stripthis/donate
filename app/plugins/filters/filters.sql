CREATE TABLE `filters` (
`id` CHAR( 36 ) NOT NULL ,
`user_id` CHAR( 36 ) NOT NULL ,
`name` VARCHAR( 100 ) NOT NULL ,
`url` TEXT NOT NULL ,
`created` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = innodb CHARACTER SET utf8 COLLATE utf8_unicode_ci;