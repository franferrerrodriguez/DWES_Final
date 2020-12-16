DROP DATABASE IF EXISTS frandiab_dwes;
CREATE DATABASE IF NOT EXISTS frandiab_dwes DEFAULT CHARACTER SET latin1 COLLATE latin1_spanish_ci;
USE frandiab_dwes;

DROP TABLE IF EXISTS USERS;
CREATE TABLE IF NOT EXISTS USERS(
    id INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    first_lastname VARCHAR(50) NOT NULL,
    second_lastname VARCHAR(50) NOT NULL,
    document VARCHAR(9) NOT NULL,
    phone1 VARCHAR(9) NOT NULL,
    phone2 VARCHAR(9) NOT NULL,
    address VARCHAR(50) NOT NULL,
    location VARCHAR(30) NOT NULL,
    province VARCHAR(30) NOT NULL,
    country VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE KEY,
    password VARCHAR(255) NOT NULL,
    rol INT NOT NULL DEFAULT 0, /*0->user, 1->employment, 5->root*/
    is_active INT NOT NULL DEFAULT 1
)ENGINE=INNODB CHARACTER SET latin1 COLLATE latin1_spanish_ci;

DROP TABLE IF EXISTS CATEGORIES;
CREATE TABLE IF NOT EXISTS CATEGORIES(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(50) NOT NULL,
    is_active INT NOT NULL DEFAULT 1,
    category_id INT NULL DEFAULT NULL,
    CONSTRAINT CATEGORIES_category_id FOREIGN KEY(category_id) REFERENCES CATEGORIES(id) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB CHARACTER SET latin1 COLLATE latin1_spanish_ci;

DROP TABLE IF EXISTS ARTICLES;
CREATE TABLE IF NOT EXISTS ARTICLES(
    id INT PRIMARY KEY AUTO_INCREMENT,
    serial_number VARCHAR(50) NOT NULL UNIQUE KEY,
    brand VARCHAR(50) NOT NULL,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(255) NOT NULL,
    especification VARCHAR(255) NOT NULL,
    img_route VARCHAR(255) NOT NULL,
    price FLOAT NOT NULL,
    price_discount FLOAT NOT NULL DEFAULT 0,
    percentage_discount FLOAT NOT NULL DEFAULT 0,
    is_outlet INT NOT NULL DEFAULT 0,
    free_shipping INT NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    warranty INT NOT NULL,
    return_days INT NOT NULL,
    visitor_counter INT NOT NULL DEFAULT 1,
    release_date DATE,
    is_active INT NOT NULL DEFAULT 1
)ENGINE=INNODB CHARACTER SET latin1 COLLATE latin1_spanish_ci;

DROP TABLE IF EXISTS CATEGORIES_ARTICLES;
CREATE TABLE IF NOT EXISTS CATEGORIES_ARTICLES(
    category_id INT NOT NULL,
    article_id INT NOT NULL,
    CONSTRAINT CATEGORIES_ARTICLES_category_id FOREIGN KEY(category_id) REFERENCES CATEGORIES(id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT CATEGORIES_ARTICLES_article_id FOREIGN KEY(article_id) REFERENCES ARTICLES(id) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB CHARACTER SET latin1 COLLATE latin1_spanish_ci;

/*------------------------------------------------------------------------------------*/

INSERT INTO USERS(firstname, first_lastname, second_lastname, document, phone1, phone2, address, location, province, country, email, password, rol) VALUES
('','Fran','', '', '', '', '', '', '', '', 'fran@fran.com', '$2y$10$OS1kdCs1.FnALnm95vmDoO4Pb88PAHh0qmrec21vBega0aGbLb646', 0),
('','Empleado','', '', '', '', '', '', '', '', 'emp@emp.com', '$2y$10$OS1kdCs1.FnALnm95vmDoO4Pb88PAHh0qmrec21vBega0aGbLb646', 1),
('','root','', '', '', '', '', '', '', '', 'root@root.com', '$2y$10$OS1kdCs1.FnALnm95vmDoO4Pb88PAHh0qmrec21vBega0aGbLb646', 5);

INSERT INTO CATEGORIES(name, description, is_active, category_id) VALUES
('Componentes', 'Componentes', 1, NULL),
('Ordenadores', 'Ordenadores', 1, NULL),
('Smartphones, Tablets, TV...', 'Smartphones y Telefonía', 1, NULL),
('Periféricos', 'Periféricos', 1, NULL),
('Consolas y Gaming', 'Consolas y Gaming', 1, NULL),
('Placas Base','Placas base', 1, 1),
('Procesadores','Procesadores', 1, 1),
('Discos Duros','Discos duros', 1, 1),
('Tarjetas Gráficas','Tarjetas gráficas', 1, 1),
('Memoria RAM','Memorias RAM', 1, 1),
('Fuentes Alimentación','Fuentes de alimentación', 1, 1),
('Torres/Carcasas','Torres/Carcasas', 1, 1),
('Sobremesa','Sobremesa', 1, 2),
('Portátiles','Portátiles', 1, 2),
('Smartphones','Smartphones', 1, 3),
('Tablets','Tablets', 1, 3),
('Televisores','Televisores', 1, 3),
('Monitores','Monitores', 1, 4),
('Teclados','Teclados', 1, 4),
('Ratones','Ratones', 1, 4),
('Audio','Audio', 1, 4),
('Consolas','Componentes', 1, 5),
('Juegos PC','Componentes', 1, 5),
('Juegos consola','Componentes', 1, 5),
('Intel','Intel', 1, 7),
('AMD','Intel', 1, 7),
('Nvidia','Intel', 1, 9),
('AMD','Intel', 1, 9);

INSERT INTO ARTICLES(serial_number, brand, name, description, especification, img_route, 
price, price_discount, percentage_discount, is_outlet, free_shipping, stock, warranty, 
return_days, visitor_counter, release_date, is_active) VALUES
('Componentes');




/*
REVIEWS
id
title
description
stars
advantages
unadvantages
user_id
article_id

SHOPPINGCART
id
json_shoppingcart
customer_id

ORDER
id
customer_id
created_at
modified_at
status

ORDERLINES
id
article_id
quantity
order_id
*/