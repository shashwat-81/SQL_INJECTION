# SQL_INJECTION

#Make sure you have downloaded the XAMPP

run this in browser
http://localhost/bank_portal/login.php

Run this below in your browser to create the database.
http://localhost/phpmyadmin

ADD thid below SQL code to 

CREATE DATABASE bank_portal;
USE bank_portal;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL
);

INSERT INTO users (username, password) VALUES
('admin', 'admin123'),
('customer', 'customer123');
