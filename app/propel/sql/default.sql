
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- visual_form
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_form`;

CREATE TABLE `visual_form`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER NOT NULL,
	`group_id` INTEGER NOT NULL,
	`name` VARCHAR(255),
	`is_active` TINYINT(1) DEFAULT 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`,`user_id`,`group_id`),
	INDEX `FI_form_1` (`user_id`),
	INDEX `FI_form_2` (`group_id`),
	CONSTRAINT `fk_form_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `visual_user` (`id`),
	CONSTRAINT `fk_form_2`
		FOREIGN KEY (`group_id`)
		REFERENCES `visual_group` (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_form_question
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_form_question`;

CREATE TABLE `visual_form_question`
(
	`form_id` INTEGER NOT NULL,
	`question_id` INTEGER NOT NULL,
	`export_name` VARCHAR(128),
	`label` VARCHAR(255),
	`is_required` TINYINT(1) DEFAULT 0,
	`is_export` TINYINT(1) DEFAULT 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`sortable_rank` INTEGER,
	PRIMARY KEY (`form_id`,`question_id`),
	INDEX `FI_form_question_2` (`question_id`),
	CONSTRAINT `fk_form_question_1`
		FOREIGN KEY (`form_id`)
		REFERENCES `visual_form` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	CONSTRAINT `fk_form_question_2`
		FOREIGN KEY (`question_id`)
		REFERENCES `visual_question` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_menu
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_menu`;

CREATE TABLE `visual_menu`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`is_active` TINYINT(1) DEFAULT 0,
	`url` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`sortable_rank` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `is_active_index` (`is_active`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_menu_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_menu_i18n`;

CREATE TABLE `visual_menu_i18n`
(
	`id` INTEGER NOT NULL,
	`locale` VARCHAR(5) NOT NULL,
	`name` VARCHAR(45),
	`slug` VARCHAR(45),
	`content` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`,`locale`),
	CONSTRAINT `fk_menu_id`
		FOREIGN KEY (`id`)
		REFERENCES `visual_menu` (`id`)
		ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_question
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_question`;

CREATE TABLE `visual_question`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER NOT NULL,
	`group_id` INTEGER NOT NULL,
	`name` VARCHAR(255),
	`label` VARCHAR(255),
	`type` TINYINT,
	`answers` TEXT,
	`limit` INTEGER(4),
	`validation_rule_predefined` VARCHAR(80),
	`validation_rule_optional` VARCHAR(255),
	`is_predefined` TINYINT(1) DEFAULT 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`sortable_rank` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `visual_question_I_1` (`type`, `is_predefined`),
	INDEX `FI_question_1` (`user_id`),
	INDEX `FI_question_2` (`group_id`),
	CONSTRAINT `fk_question_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `visual_user` (`id`),
	CONSTRAINT `fk_question_2`
		FOREIGN KEY (`group_id`)
		REFERENCES `visual_group` (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_recruitment
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_recruitment`;

CREATE TABLE `visual_recruitment`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`form_id` INTEGER NOT NULL,
	`user_id` INTEGER NOT NULL,
	`group_id` INTEGER NOT NULL,
	`name` VARCHAR(100) NOT NULL,
	`alias_name` VARCHAR(30) NOT NULL,
	`place` VARCHAR(255),
	`is_active` TINYINT(1) DEFAULT 0,
	`description` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `visual_recruitment_I_1` (`alias_name`),
	INDEX `FI_rf_1` (`form_id`),
	INDEX `FI_ru_2` (`user_id`),
	INDEX `FI_rg_3` (`group_id`),
	CONSTRAINT `fk_rf_1`
		FOREIGN KEY (`form_id`)
		REFERENCES `visual_form` (`id`),
	CONSTRAINT `fk_ru_2`
		FOREIGN KEY (`user_id`)
		REFERENCES `visual_user` (`id`),
	CONSTRAINT `fk_rg_3`
		FOREIGN KEY (`group_id`)
		REFERENCES `visual_group` (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_recruitment_date
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_recruitment_date`;

CREATE TABLE `visual_recruitment_date`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`recruitment_id` INTEGER NOT NULL,
	`event_date_from` DATETIME NOT NULL,
	`event_date_to` DATETIME NOT NULL,
	`no_active_text` VARCHAR(255),
	`used_limit` SMALLINT DEFAULT 0,
	`set_limit` SMALLINT DEFAULT 0,
	`is_visible_limit` TINYINT(1) DEFAULT 0,
	`is_not_set_event_date` TINYINT(1) DEFAULT 0,
	`is_active` TINYINT(1) DEFAULT 0,
	`is_automatic_qualify` TINYINT(1) DEFAULT 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `FI_rdr_1` (`recruitment_id`),
	CONSTRAINT `fk_rdr_1`
		FOREIGN KEY (`recruitment_id`)
		REFERENCES `visual_recruitment` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_recruitment_user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_recruitment_user`;

CREATE TABLE `visual_recruitment_user`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`recruitment_id` INTEGER NOT NULL,
	`recruitment_date_id` INTEGER NOT NULL,
	`name` VARCHAR(40) NOT NULL,
	`surname` VARCHAR(60) NOT NULL,
	`email` VARCHAR(255) NOT NULL,
	`is_qualify` TINYINT(1) DEFAULT 0,
	`is_active` TINYINT(1) DEFAULT 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `i_ru` (`is_active`, `is_qualify`),
	INDEX `FI_rru_1` (`recruitment_id`),
	INDEX `FI_rdru_2` (`recruitment_date_id`),
	CONSTRAINT `fk_rru_1`
		FOREIGN KEY (`recruitment_id`)
		REFERENCES `visual_recruitment` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	CONSTRAINT `fk_rdru_2`
		FOREIGN KEY (`recruitment_date_id`)
		REFERENCES `visual_recruitment_date` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_recruitment_user_data
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_recruitment_user_data`;

CREATE TABLE `visual_recruitment_user_data`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`user_recruitment_id` INTEGER NOT NULL,
	`question_id` INTEGER NOT NULL,
	`value` TEXT,
	PRIMARY KEY (`id`),
	INDEX `FI_rudru_1` (`user_recruitment_id`),
	INDEX `FI_rudq_2` (`question_id`),
	CONSTRAINT `fk_rudru_1`
		FOREIGN KEY (`user_recruitment_id`)
		REFERENCES `visual_recruitment_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	CONSTRAINT `fk_rudq_2`
		FOREIGN KEY (`question_id`)
		REFERENCES `visual_question` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_user`;

CREATE TABLE `visual_user`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(100) NOT NULL,
	`password` VARCHAR(100) NOT NULL,
	`salt` VARCHAR(100) NOT NULL,
	`email` VARCHAR(255),
	`name` VARCHAR(100),
	`surname` VARCHAR(100),
	`barcode` BIGINT,
	`type` TINYINT NOT NULL,
	`street` VARCHAR(45),
	`flat` SMALLINT(2),
	`city` VARCHAR(45),
	`postcode` VARCHAR(45),
	`is_superadmin` TINYINT(1) DEFAULT 0,
	`is_active` TINYINT(1) NOT NULL,
	`is_agree_processing` TINYINT(1) DEFAULT 0 NOT NULL,
	`is_agree_regulations` TINYINT(1) DEFAULT 0 NOT NULL,
	`is_first_time` TINYINT(1) DEFAULT 1 NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `user_barcode` (`barcode`),
	INDEX `visual_user_I_1` (`is_active`, `username`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_group`;

CREATE TABLE `visual_group`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(128),
	`slug` VARCHAR(135),
	`street` VARCHAR(45),
	`flat` SMALLINT(2),
	`city` VARCHAR(45),
	`postcode` VARCHAR(45),
	`nip` CHAR(14),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_user_group
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_user_group`;

CREATE TABLE `visual_user_group`
(
	`user_id` INTEGER NOT NULL,
	`group_id` INTEGER NOT NULL,
	`is_group_admin` TINYINT(1) DEFAULT 0,
	PRIMARY KEY (`user_id`,`group_id`),
	INDEX `FI_ug_2` (`group_id`),
	CONSTRAINT `fk_ug_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `visual_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	CONSTRAINT `fk_ug_2`
		FOREIGN KEY (`group_id`)
		REFERENCES `visual_group` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_role`;

CREATE TABLE `visual_role`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL,
	`description` VARCHAR(255) NOT NULL,
	`type` TINYINT NOT NULL,
	`is_active` TINYINT(1) DEFAULT 0,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_user_role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_user_role`;

CREATE TABLE `visual_user_role`
(
	`user_id` INTEGER NOT NULL,
	`role_id` INTEGER NOT NULL,
	PRIMARY KEY (`user_id`,`role_id`),
	INDEX `FI_ur_2` (`role_id`),
	CONSTRAINT `fk_ur_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `visual_user` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	CONSTRAINT `fk_ur_2`
		FOREIGN KEY (`role_id`)
		REFERENCES `visual_role` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_group_role
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_group_role`;

CREATE TABLE `visual_group_role`
(
	`group_id` INTEGER NOT NULL,
	`role_id` INTEGER NOT NULL,
	PRIMARY KEY (`group_id`,`role_id`),
	INDEX `FI_gr_2` (`role_id`),
	CONSTRAINT `fk_gr_1`
		FOREIGN KEY (`group_id`)
		REFERENCES `visual_group` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	CONSTRAINT `fk_gr_2`
		FOREIGN KEY (`role_id`)
		REFERENCES `visual_role` (`id`)
		ON UPDATE CASCADE
		ON DELETE CASCADE
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_log`;

CREATE TABLE `visual_log`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER NOT NULL,
	`type` SMALLINT(2) NOT NULL,
	`message` VARCHAR(255) NOT NULL,
	`ip` VARCHAR(15),
	`content` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
) ENGINE=Archive CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_session
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_session`;

CREATE TABLE `visual_session`
(
	`session` VARCHAR(255) NOT NULL,
	`data` TEXT NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`session`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_files_library
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_files_library`;

CREATE TABLE `visual_files_library`
(
	`key` VARCHAR(41) NOT NULL,
	`extension` VARCHAR(5) NOT NULL,
	`mime_type` VARCHAR(50),
	`name` VARCHAR(255) NOT NULL,
	`is_public` TINYINT(1) DEFAULT 1 NOT NULL,
	`location` VARCHAR(500) NOT NULL,
	`class_key` INTEGER,
	`object` TEXT NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`key`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_barcode
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_barcode`;

CREATE TABLE `visual_barcode`
(
	`code` BIGINT NOT NULL,
	`class_key` INTEGER,
	PRIMARY KEY (`code`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- visual_number
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `visual_number`;

CREATE TABLE `visual_number`
(
	`key` VARCHAR(10) NOT NULL,
	`counter` INTEGER DEFAULT 1 NOT NULL,
	PRIMARY KEY (`key`)
) ENGINE=InnoDB CHARACTER SET='utf8';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
