CREATE TABLE `Notes` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(150),
	`description` TEXT,
	`created` DATETIME,
	PRIMARY KEY (`id`)
);