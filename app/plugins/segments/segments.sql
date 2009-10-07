CREATE TABLE `segments` (
`id` CHAR( 36 ) NOT NULL ,
`user_id` CHAR( 36 ) NOT NULL ,
`name` VARCHAR( 200 ) NOT NULL ,
`created` DATETIME NOT NULL ,
`modified` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = innodb CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `segment_items` (
`id` CHAR( 36 ) NOT NULL ,
`segment_id` CHAR( 36 ) NOT NULL ,
`foreign_id` CHAR( 36 ) NOT NULL ,
`created` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = innodb CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE `segment_items` ADD `model` VARCHAR( 100 ) NOT NULL AFTER `foreign_id` ;
ALTER TABLE `segments` ADD `segment_item_count` INT NOT NULL DEFAULT '0' AFTER `user_id` ;