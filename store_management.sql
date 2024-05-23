-- Create the database
CREATE DATABASE IF NOT EXISTS store_management;

-- Use the created database
USE store_management;

-- Create the inventory table
CREATE TABLE inventory (
    Product_id INT AUTO_INCREMENT PRIMARY KEY,
    Product_cat INT NOT NULL,
    Product_brand INT NOT NULL,
    Product_title VARCHAR(255) NOT NULL,
    Product_price INT NOT NULL,
    Product_desc TEXT,
    Product_image TEXT,
    Product_keywords TEXT
);

-- Create the category table
CREATE TABLE category (
    cat_id INT AUTO_INCREMENT PRIMARY KEY,
    cat_title VARCHAR(100) NOT NULL
);

-- Create the brands table
CREATE TABLE brands (
    brand_id INT AUTO_INCREMENT PRIMARY KEY,
    brand_title VARCHAR(255) NOT NULL
);

-- Create the user table
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);