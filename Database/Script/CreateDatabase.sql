SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `user` DEFAULT CHARACTER SET utf8 ;
USE `user` ;

CREATE TABLE IF NOT EXISTS `users_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

INSERT INTO users_status (id, name) VALUES (1, 'Active');
INSERT INTO users_status (id, name) VALUES (2, 'Inactive');

CREATE TABLE IF NOT EXISTS `users` (
  `id` BINARY(16) NOT NULL DEFAULT UUID(),
  `name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE,
  INDEX `fk_users_users_status1_idx` (`status` ASC) VISIBLE,
  CONSTRAINT `fk_users_users_status1`
    FOREIGN KEY (`status`)
    REFERENCES `users_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- PASSWORD BCRYPT (fulladmin)
INSERT INTO users (id, name, email, password, status) VALUES (UNHEX(REPLACE('cbe386e3-3d70-4068-886a-1839ef342ebb', '-', '')), 'Full Administrator', 'fulladmin@mail.com', '$2a$12$T9PdxQLUMxVnsiQfnWzQSOeksAtysA7hPMp4ja5xzzfsZHGcKeXRK', 1); 

CREATE TABLE IF NOT EXISTS `users_projects_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
ENGINE = InnoDB;

INSERT INTO users_projects_status (id, name) VALUES (1, 'Active');
INSERT INTO users_projects_status (id, name) VALUES (2, 'Inactive');

CREATE TABLE IF NOT EXISTS `projects_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;

INSERT INTO projects_status (id, name) VALUES (1, 'Active');
INSERT INTO projects_status (id, name) VALUES (2, 'Inactive');

CREATE TABLE IF NOT EXISTS `projects` (
  `id` BINARY(16) NOT NULL DEFAULT UUID(),
  `name` VARCHAR(255) NOT NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_projects_projects_status1_idx` (`status` ASC) VISIBLE,
  CONSTRAINT `fk_projects_projects_status1`
    FOREIGN KEY (`status`)
    REFERENCES `projects_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO projects (id, name, status) VALUES (UNHEX(REPLACE('5a5c6a5d-4e14-4b45-b52b-c319f509c9d4', '-', '')), 'Cloud', 1);
INSERT INTO projects (id, name, status) VALUES (UNHEX(REPLACE('6cf5a6a7-6d85-4c18-9c39-6fb01b9c4f4a', '-', '')), 'Gmail', 1);

CREATE TABLE IF NOT EXISTS `clients_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE)
ENGINE = InnoDB;

INSERT INTO clients_status (id, name) VALUES (1, 'Active');
INSERT INTO clients_status (id, name) VALUES (2, 'Inactive');

CREATE TABLE IF NOT EXISTS `clients` (
  `id` BINARY(16) NOT NULL DEFAULT UUID(),
  `name` VARCHAR(255) NOT NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_clients_clients_status1_idx` (`status` ASC) VISIBLE,
  CONSTRAINT `fk_clients_clients_status1`
    FOREIGN KEY (`status`)
    REFERENCES `clients_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO clients (id, name, status) VALUES (UNHEX(REPLACE('2a196187-c63a-4f5f-9f3c-738a348ea4d5', '-', '')), 'Amazon', 1);
INSERT INTO clients (id, name, status) VALUES (UNHEX(REPLACE('ee0f7c48-e397-11ed-b5ea-0242ac120002', '-', '')), 'Google', 1);

CREATE TABLE IF NOT EXISTS `projects_clients_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;

INSERT INTO projects_clients_status (id, name) VALUES (1, 'Active');
INSERT INTO projects_clients_status (id, name) VALUES (2, 'Inactive');

CREATE TABLE IF NOT EXISTS `projects_clients` (
  `id` INT NULL,
  `project` BINARY(16) NOT NULL,
  `client` BINARY(16) NOT NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_clients_projects_projects1_idx` (`project` ASC) VISIBLE,
  INDEX `fk_clients_projects_clients1_idx` (`client` ASC) VISIBLE,
  INDEX `fk_projects_clients_projects_clients_status1_idx` (`status` ASC) VISIBLE,
  CONSTRAINT `fk_clients_projects_projects1`
    FOREIGN KEY (`project`)
    REFERENCES `projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_clients_projects_clients1`
    FOREIGN KEY (`client`)
    REFERENCES `clients` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projects_clients_projects_clients_status1`
    FOREIGN KEY (`status`)
    REFERENCES `projects_clients_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO projects_clients (id, project, client, status) VALUES (1, UNHEX(REPLACE('5a5c6a5d-4e14-4b45-b52b-c319f509c9d4', '-', '')), UNHEX(REPLACE('2a196187-c63a-4f5f-9f3c-738a348ea4d5', '-', '')), 1);
INSERT INTO projects_clients (id, project, client, status) VALUES (2, UNHEX(REPLACE('5a5c6a5d-4e14-4b45-b52b-c319f509c9d4', '-', '')), UNHEX(REPLACE('ee0f7c48-e397-11ed-b5ea-0242ac120002', '-', '')), 1);
INSERT INTO projects_clients (id, project, client, status) VALUES (2, UNHEX(REPLACE('6cf5a6a7-6d85-4c18-9c39-6fb01b9c4f4a', '-', '')), UNHEX(REPLACE('ee0f7c48-e397-11ed-b5ea-0242ac120002', '-', '')), 1);

CREATE TABLE IF NOT EXISTS `projects_roles_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;

INSERT INTO projects_roles_status (id, name) VALUES (1, 'Active');
INSERT INTO projects_roles_status (id, name) VALUES (2, 'Inactive');

CREATE TABLE IF NOT EXISTS `projects_roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `label` VARCHAR(255) NOT NULL,
  `project` BINARY(16) NOT NULL,
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_projects_roles_projects1_idx` (`project` ASC) VISIBLE,
  INDEX `fk_projects_roles_projects_roles_status1_idx` (`status` ASC) VISIBLE,
  CONSTRAINT `fk_projects_roles_projects1`
    FOREIGN KEY (`project`)
    REFERENCES `projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projects_roles_projects_roles_status1`
    FOREIGN KEY (`status`)
    REFERENCES `projects_roles_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO projects_roles (id, name, label, project, status) VALUES (1, 'Administrator', 'ADM', UNHEX(REPLACE('5a5c6a5d-4e14-4b45-b52b-c319f509c9d4', 1);
INSERT INTO projects_roles (id, name, label, project, status) VALUES (2, 'Developer', 'DEV', UNHEX(REPLACE('5a5c6a5d-4e14-4b45-b52b-c319f509c9d4', 1);
INSERT INTO projects_roles (id, name, label, project, status) VALUES (3, 'Administrator', 'ADM', UNHEX(REPLACE('6cf5a6a7-6d85-4c18-9c39-6fb01b9c4f4a', 1);
INSERT INTO projects_roles (id, name, label, project, status) VALUES (4, 'common user', 'CU', UNHEX(REPLACE('6cf5a6a7-6d85-4c18-9c39-6fb01b9c4f4a', 1);

CREATE TABLE IF NOT EXISTS `users_projects` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user` BINARY(16) NOT NULL,
  `status` INT NOT NULL,
  `project` INT NOT NULL,
  `role` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_users_systems_users1_idx` (`user` ASC) VISIBLE,
  INDEX `fk_users_projects_users_status1_idx` (`status` ASC) VISIBLE,
  INDEX `fk_users_projects_projects_clients1_idx` (`project` ASC) VISIBLE,
  INDEX `fk_users_projects_projects_roles1_idx` (`role` ASC) VISIBLE,
  CONSTRAINT `fk_users_systems_users1`
    FOREIGN KEY (`user`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_projects_users_status1`
    FOREIGN KEY (`status`)
    REFERENCES `users_projects_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_projects_projects_clients1`
    FOREIGN KEY (`project`)
    REFERENCES `projects_clients` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_projects_projects_roles1`
    FOREIGN KEY (`role`)
    REFERENCES `projects_roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO users_projects (id, user, status, project, role) VALUES (1, UNHEX(REPLACE('cbe386e3-3d70-4068-886a-1839ef342ebb', 1, UNHEX(REPLACE('5a5c6a5d-4e14-4b45-b52b-c319f509c9d4', 1);
INSERT INTO users_projects (id, user, status, project, role) VALUES (2, UNHEX(REPLACE('cbe386e3-3d70-4068-886a-1839ef342ebb', 1, UNHEX(REPLACE('6cf5a6a7-6d85-4c18-9c39-6fb01b9c4f4a', 3);

CREATE TABLE IF NOT EXISTS `tokens_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;

INSERT INTO tokens_status (id, name) VALUES (1, 'Active');
INSERT INTO tokens_status (id, name) VALUES (2, 'Inactive');

CREATE TABLE IF NOT EXISTS `users_tokens` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user` BINARY(16) NOT NULL,
  `token` VARCHAR(24) NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_tokens_users1_idx` (`user` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_users_tokens_tokens_status1_idx` (`status` ASC) VISIBLE,
  CONSTRAINT `fk_users_tokens_users1`
    FOREIGN KEY (`user`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_tokens_tokens_status1`
    FOREIGN KEY (`status`)
    REFERENCES `tokens_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `users_logs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user` BINARY(16) NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` VARCHAR(25) NOT NULL,
  `value` TEXT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_users_logs_users1_idx` (`user` ASC) VISIBLE,
  CONSTRAINT `fk_users_logs_users1`
    FOREIGN KEY (`user`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `users_sessions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user` BINARY(16) NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` VARCHAR(45) NOT NULL,
  `browser` VARCHAR(100) NOT NULL,
  `token` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  INDEX `fk_users_sessions_users1_idx` (`user` ASC) VISIBLE,
  CONSTRAINT `fk_users_sessions_users1`
    FOREIGN KEY (`user`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
