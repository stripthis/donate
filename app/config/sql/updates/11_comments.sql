CREATE TABLE `comments` (
`id` CHAR( 36 ) NOT NULL ,
`foreign_id` CHAR( 36 ) NOT NULL ,
`body` TEXT NOT NULL ,
`created` DATETIME NOT NULL ,
`modified` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;