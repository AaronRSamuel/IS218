USE `week8`;-- put your databse name inside the single quote.
-- if you want to upload this sql to remote njit databse server, you need put your UCID inside the single quotes.

DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;

-- create the tables

CREATE TABLE categories (
  categoryID        INT            NOT NULL,
  categoryName      VARCHAR(60)    DEFAULT NULL,
  PRIMARY KEY (categoryID)
);

CREATE TABLE products (
  productID         INT            NOT NULL   AUTO_INCREMENT,
  categoryID        INT            NOT NULL,
  productCode       VARCHAR(60)    NOT NULL,
  productName       VARCHAR(60)    DEFAULT NULL,
  listPrice         VARCHAR(40)    NOT NULL,
  PRIMARY KEY (productID),
  FOREIGN KEY (categoryID) REFERENCES categories(categoryID)
);



-- insert data into the database
INSERT INTO categories (categoryID, categoryName) VALUES
(1, 'Guitars'),
(2, 'Basses'),
(3, 'Drums');


INSERT INTO products (categoryID, productCode, productName,listPrice) VALUES
(1, 'strat', 'Fender Stratocaster', 699.00),
(1, 'les_paul', 'Gibson Les Paul', 1199.00),
(1, 'sg', 'Gibson SG', 2517.00),
(1, 'fg700s', 'Yamaha FG700s', 489.99),
(1, 'washburn', 'Washburn D10S', 299.00),
(1, 'rodriguez', 'Rodriguez Caballero 11', 415),
(2, 'precision', 'Fender Precision',799.99),
(2, 'hofner','Hofner Icon', 499.99),
(3,'ludwig','Ludwig 5-piece Drum Set with Cymbals',699.99),
(3, 'tama','Tama 5-piece Drum Set with Cymbals',799.99);

DROP TABLE IF EXISTS `Question1`;
DROP TABLE IF EXISTS `Question2`;
CREATE TABLE `Question1`(
	productName       VARCHAR(60)    DEFAULT NULL,
  	listPrice         VARCHAR(40)    NOT NULL,
  	PRIMARY KEY (productName)
);
CREATE TABLE `Question2` (
  categoryID        INT            NOT NULL,
  productName       VARCHAR(60)    DEFAULT NULL,
  PRIMARY KEY (categoryID)
);
-- Question 1
SELECT productName, listPrice FROM products WHERE listPrice>700 ORDER BY listPrice ASC;

-- Question 2
SELECT categoryID, productName FROM products WHERE categoryID = 2;

-- Question 4
UPDATE products SET productName = 'Okay Gibson SG' WHERE productName='Gibson SG';

-- Question 5
DELETE FROM products WHERE listprice>1000;
