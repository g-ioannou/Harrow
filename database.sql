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
	upload_isp VARCHAR(255),
	upload_location VARCHAR(255),
	full_file LONGTEXT,
	upload_date DATETIME DEFAULT CURRENT_TIMESTAMP(),
	PRIMARY KEY (file_id),
	-- FOREIGN KEY (user_id) REFERENCES users(user_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE entries(
	file_id BIGINT,
	entry_id BIGINT AUTO_INCREMENT,
	serverIpAddress VARCHAR(20),
	startedDateTime DATETIME DEFAULT NULL,
	wait INT,
	PRIMARY KEY (entry_id),
	-- CONSTRAINT entry_file FOREIGN KEY (entry_id) REFERENCES files(file_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE requests(
	entry_id BIGINT,
	request_id BIGINT AUTO_INCREMENT,
	url VARCHAR(255),
	method VARCHAR(5),
	PRIMARY KEY (request_id),
	-- FOREIGN KEY (entry_id) REFERENCES entries(entry_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE responses(
	entry_id BIGINT,
	response_id BIGINT AUTO_INCREMENT,
	statusText TEXT,
	status INT(3),
	PRIMARY KEY (response_id),
	-- FOREIGN KEY (entry_id) REFERENCES entries(entry_id)
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
	expires BIGINT DEFAULT NULL,
	age BIGINT DEFAULT NULL,
	last_modified VARCHAR(255) DEFAULT NULL,
	PRIMARY KEY (header_id),
	-- FOREIGN KEY (request_id) REFERENCES requests(request_id)
	-- ON DELETE CASCADE ON UPDATE CASCADE,
	-- FOREIGN KEY (response_id) REFERENCES responses(response_id)
	-- ON DELETE CASCADE ON UPDATE CASCADE
);

