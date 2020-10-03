CREATE TABLE analytics
(
	title VARCHAR(255),
	value INT(11)
)
CREATE TABLE category
(
	id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255)
)
CREATE TABLE products
(
	id INT PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(255),
	description TEXT,
	price INT(11),
	category VARCHAR(255),
	weight VARCHAR(255),
	taxe FLOAT,
	TVA INT(11),
	finalprice INT(11),
	stock INT(11)
)
CREATE TABLE staff
(
	username VARCHAR(255),
	password TEXT
)
INSERT INTO staff VALUES ('admin', '$2y$10$HrGBY04.JPBLcEewF0iGtu0tc.59OVd1tf.xgUB12qd8yT8gTrkwC')
CREATE TABLE transactions
(
	id INT PRIMARY KEY AUTO_INCREMENT,
	user_id INT(11),
	name VARCHAR(255),
	street VARCHAR(255),
	state VARCHAR(255),
	city VARCHAR(255),
	postalcode VARCHAR(255),
	countrycode VARCHAR(255),
	date VARCHAR(255),
	products TEXT,
	transaction_id VARCHAR(255),
	amount FLOAT,
	currency_code VARCHAR(255),
	user_email VARCHAR(255),
	totalTVA FLOAT
)
CREATE TABLE users
(
	id INT PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(255),
	email VARCHAR(255),
	password TEXT
)
CREATE TABLE weights
(
	id INT PRIMARY KEY AUTO_INCREMENT,
	weight VARCHAR(255),
	taxe FLOAT
)