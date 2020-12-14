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
    rol INT NOT NULL DEFAULT 0 /*0->user, 1->employment, 5->root*/
)ENGINE=INNODB CHARACTER SET latin1 COLLATE latin1_spanish_ci;

DROP TABLE IF EXISTS CATEGORIES;
CREATE TABLE IF NOT EXISTS CATEGORIES(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(50) NOT NULL,
    is_visible INT NOT NULL DEFAULT 1
)ENGINE=INNODB CHARACTER SET latin1 COLLATE latin1_spanish_ci;

DROP TABLE IF EXISTS SUBCATEGORIES;
CREATE TABLE IF NOT EXISTS SUBCATEGORIES(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(50) NOT NULL,
    is_visible INT NOT NULL DEFAULT 1,
    category_id INT NOT NULL,
    CONSTRAINT SUBCATEGORIES_category_id FOREIGN KEY(category_id) REFERENCES CATEGORIES(id) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB CHARACTER SET latin1 COLLATE latin1_spanish_ci;

/*------------------------------------------------------------------------------------*/

INSERT INTO USERS(firstname, first_lastname, second_lastname, document, phone1, phone2, address, location, province, country, email, password, rol) VALUES
('','root','', '', '', '', '', '', '', '', 'root@root.com', '1234', 5);

INSERT INTO CATEGORIES(name, description) VALUES
('Componentes', 'Componentes'),
('Ordenadores', 'Ordenadores'),
('Smartphones, Tablets, TV...', 'Smartphones y Telefonía'),
('Periféricos', 'Periféricos'),
('Consolas y Gaming', 'Consolas y Gaming');

INSERT INTO SUBCATEGORIES(name, description, category_id) VALUES
('Placas base','Placas base', 1),
('Procesadores','Procesadores', 1),
('Discos duros','Discos duros', 1),
('Tarjetas gráficas','Tarjetas gráficas', 1),
('Memorias RAM','Memorias RAM', 1),
('Fuentes de alimentación','Fuentes de alimentación', 1),
('Torres/Carcasas','Torres/Carcasas', 1),
('Sobremesa','Sobremesa', 2),
('Portátiles','Portátiles', 2),
('Smartphones','Smartphones', 3),
('Tablets','Tablets', 3),
('Televisores','Televisores', 3),
('Monitores','Monitores', 4),
('Teclados','Teclados', 4),
('Ratones','Ratones', 4),
('Audio','Audio', 4),
('Consolas','Componentes', 5),
('Juegos PC','Componentes', 5),
('Juegos consola','Componentes', 5);














/*
ARTICLES
id
codarticulo
serial_number
brand
name
description
especification
price
discount
free_shipping
stock
warranty
returns
category_id
is_active
visitor_counter
release_date

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