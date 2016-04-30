USE `clear`;

CREATE TABLE IF NOT EXISTS `user` (
	`id`       int(11)      NOT NULL AUTO_INCREMENT,
	`created`  datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`active`   tinyint(1)   NOT NULL DEFAULT 1,
	`email`    varchar(128) NOT NULL,
	`username` varchar(128) NOT NULL,
	`password` varchar(128) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
