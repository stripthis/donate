CREATE TABLE `attachments` (
`id` CHAR( 36 ) NOT NULL ,
`user_id` CHAR( 36 ) NOT NULL ,
`foreign_id` CHAR( 36 ) NOT NULL ,
`name` VARCHAR( 200 ) NOT NULL ,
`url` VARCHAR( 500 ) NOT NULL ,
`mimetype` VARCHAR( 50 ) NOT NULL ,
`size` INT NOT NULL ,
`created` DATETIME NOT NULL ,
`modified` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;