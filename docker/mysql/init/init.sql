CREATE DATABASE shop;

GRANT ALL PRIVILEGES ON shop.* TO 'shop'@'%' IDENTIFIED BY 'shop';
GRANT ALL PRIVILEGES ON shop.* TO 'shop'@'localhost' IDENTIFIED BY 'shop';