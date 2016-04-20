USE `clear`;

CREATE TABLE IF NOT EXISTS `todo` (
	`id`    int(11)      NOT NULL AUTO_INCREMENT,
	`done`  tinyint(1)   NOT NULL DEFAULT 0,
	`date`  datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`name`  varchar(128) NOT NULL,
	`notes` text         NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
