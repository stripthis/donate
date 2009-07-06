CREATE TABLE `transactions` (
`id` CHAR( 36 ) NOT NULL ,
`parent_id` CHAR( 36 ) NOT NULL ,
`gateway_id` CHAR( 36 ) NOT NULL ,
`external_id` CHAR( 36 ) NOT NULL ,
`gift_id` CHAR( 36 ) NOT NULL ,
`status` VARCHAR( 100 ) NOT NULL ,
`created` DATETIME NOT NULL ,
`modified` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;