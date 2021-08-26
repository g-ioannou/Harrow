DROP DATABASE IF EXISTS harrow;
CREATE DATABASE harrow;
USE harrow;
-- ----------------------------------------------------------
-- 						CREATE TABLES                     
-- ----------------------------------------------------------
CREATE TABLE users(
	user_id BIGINT AUTO_INCREMENT,
	email VARCHAR(255),
	username VARCHAR(255),
	password VARCHAR(255),
	firstname VARCHAR(255),
	lastname VARCHAR(255),
	token VARCHAR(255),
	reg_date DATETIME DEFAULT CURRENT_TIMESTAMP(),
	is_admin TINYINT DEFAULT 0,
	PRIMARY KEY(user_id, email)
);

CREATE TABLE files(
	user_id BIGINT,
	file_id BIGINT AUTO_INCREMENT,
	name VARCHAR(255),
	size BIGINT,
	upload_ip VARCHAR(255),
	upload_isp VARCHAR(255),
	upload_location VARCHAR(255),
	full_file LONGTEXT,
	upload_date DATETIME DEFAULT CURRENT_TIMESTAMP(),
	PRIMARY KEY (file_id),
	CONSTRAINT file_user_fk FOREIGN KEY (user_id) REFERENCES users(user_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE entries(
	file_id BIGINT,
	entry_id BIGINT AUTO_INCREMENT,
	serverIpAddress VARCHAR(255),
	startedDateTime DATETIME DEFAULT NULL,
	wait FLOAT(5,5),
	PRIMARY KEY (entry_id),
	CONSTRAINT entry_file_fk FOREIGN KEY (file_id) REFERENCES files(file_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE requests(
	entry_id BIGINT,
	request_id BIGINT AUTO_INCREMENT,
	url VARCHAR(255),
	method VARCHAR(255),
	PRIMARY KEY (request_id),
	CONSTRAINT request_entry_fk FOREIGN KEY (entry_id) REFERENCES entries(entry_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE responses(
	entry_id BIGINT,
	response_id BIGINT AUTO_INCREMENT,
	statusText TEXT,
	status INT(3),
	PRIMARY KEY (response_id),
	CONSTRAINT entry_response_fk FOREIGN KEY (entry_id) REFERENCES entries(entry_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE headers(
	header_id BIGINT AUTO_INCREMENT,
	request_id BIGINT DEFAULT NULL,
	response_id BIGINT DEFAULT NULL,
	host VARCHAR(255) DEFAULT NULL,
	content_type VARCHAR(255) DEFAULT NULL,
	cache_control VARCHAR(255) DEFAULT NULL,
	pragma VARCHAR(255) DEFAULT NULL,
	expires VARCHAR(255) DEFAULT NULL,
	age BIGINT DEFAULT NULL,
	last_modified VARCHAR(255) DEFAULT NULL,
	PRIMARY KEY (header_id),
	CONSTRAINT header_request_fk FOREIGN KEY (request_id) REFERENCES requests(request_id)
	ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT header_response_fk FOREIGN KEY (response_id) REFERENCES responses(response_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);




-- ----------------------------------------------------------
--  					CREATE PROCEDURES                    
-- ----------------------------------------------------------
DROP PROCEDURE IF EXISTS add_user;
DELIMITER $ 
CREATE PROCEDURE `add_user` (
	IN `inp_email` VARCHAR(255),
	IN `inp_username` VARCHAR(255),
	IN `inp_password` VARCHAR(255),
	IN `inp_name` VARCHAR(255),
	IN `inp_lastname` VARCHAR(255)
) 
BEGIN
	INSERT INTO users (email, username, password, firstname, lastname)
	VALUES (inp_email,inp_username,inp_password,inp_name,inp_lastname);
END $ 
DELIMITER ;

DROP PROCEDURE IF EXISTS get_user;
DELIMITER $ 
CREATE PROCEDURE `get_user` (IN `inp_email` VARCHAR(255)) 
BEGIN
	SELECT *
	FROM `users`
	WHERE `email` = inp_email;
END $
DELIMITER ;


DROP PROCEDURE IF EXISTS validate_login;
DELIMITER $ 
CREATE PROCEDURE `validate_login` (
	IN `inp_email` VARCHAR(255),
	IN `inp_password` VARCHAR(255)
) 
BEGIN
	SELECT * FROM `users` WHERE `email` = inp_email AND `password` = inp_password;
END $ 
DELIMITER ;

DROP PROCEDURE IF EXISTS add_file;
DELIMITER $
CREATE PROCEDURE `add_file`(
	IN `inp_user_id` BIGINT,
	IN `inp_name` VARCHAR(255),
	IN `inp_size` BIGINT,
	IN `inp_upload_isp` VARCHAR(255),
	IN `inp_upload_location` VARCHAR(255),
	IN `inp_full_file` LONGTEXT,
	IN `inp_upload_ip` VARCHAR(255)
)
BEGIN 
	INSERT INTO files(user_id,name,size,upload_isp,upload_location,full_file,upload_ip) VALUES (inp_user_id,inp_name,inp_size,inp_upload_isp,inp_upload_location,inp_full_file,inp_upload_ip);

	SELECT MAX(file_id) AS file_id FROM files WHERE name = `inp_name` AND user_id=`inp_user_id`;
END$
DELIMITER ;

DROP PROCEDURE IF EXISTS add_entry;
DELIMITER $
CREATE PROCEDURE `add_entry`(
	IN `inp_file_id` BIGINT,
	IN `inp_startedDateTime` VARCHAR(255),
	IN `inp_serverIpAddress` VARCHAR(255),
	IN `inp_wait` FLOAT(5,5)
)

BEGIN 
	INSERT INTO entries(file_id,startedDateTime,serverIpAddress,wait) VALUES (inp_file_id,inp_startedDateTime,inp_serverIpAddress,inp_wait);

	SELECT MAX(entry_id) AS entry_id FROM entries WHERE file_id = `inp_file_id` ;
END$
DELIMITER ;

DROP PROCEDURE IF EXISTS add_request;
DELIMITER $
CREATE PROCEDURE `add_request`(
	IN `inp_entry_id` BIGINT,
	IN `inp_method` VARCHAR(255),
	IN `inp_url` VARCHAR(255)
)
BEGIN
	INSERT INTO requests(entry_id,url,method) VALUES (inp_entry_id,inp_url,inp_method);

	SELECT MAX(request_id) AS request_id FROM requests WHERE entry_id = `inp_entry_id` ;
END$
DELIMITER ;

DROP PROCEDURE IF EXISTS add_response;
DELIMITER $
CREATE PROCEDURE `add_response`(
	IN `inp_entry_id` BIGINT,
	IN `inp_status` INT(3),
	IN `inp_statusText` TEXT
)
BEGIN 
	INSERT INTO responses(entry_id,status,statusText) VALUES
	(inp_entry_id,inp_status,inp_statusText);

	SELECT MAX(response_id) AS response_id FROM responses WHERE entry_id = `inp_entry_id`;
END$
DELIMITER ;

DROP PROCEDURE IF EXISTS get_files;
DELIMITER $
CREATE PROCEDURE `get_files`(
	IN `inp_user_id` BIGINT
)
BEGIN 
	SELECT * FROM files WHERE user_id=`inp_user_id`;
END$
DELIMITER ;

DROP PROCEDURE IF EXISTS delete_file;
DELIMITER $
CREATE PROCEDURE `delete_file`(
	IN `inp_user_id` BIGINT,
	IN `inp_file_id` BIGINT
)
BEGIN 
	DELETE FROM files WHERE user_id = `inp_user_id` AND file_id = `inp_file_id`;
END $
DELIMITER $
