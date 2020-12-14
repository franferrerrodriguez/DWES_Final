DROP DATABASE IF EXISTS clientes_DB;
CREATE DATABASE IF NOT EXISTS clientes_DB DEFAULT CHARACTER SET latin1 COLLATE latin1_spanish_ci;
USE clientes_DB;

DROP TABLE IF EXISTS clientes;
CREATE TABLE IF NOT EXISTS clientes(
    dni VARCHAR(9) PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    direccion VARCHAR(50),
    localidad VARCHAR(30),
    provincia VARCHAR(30),
    telefono VARCHAR(9),
    email VARCHAR(30) NOT NULL
)ENGINE=INNODB CHARACTER SET latin1 COLLATE latin1_spanish_ci;

INSERT INTO clientes(dni, nombre, direccion, localidad, provincia, telefono, email) VALUES
('28374625A','Alberto Grau López','Calle Naranha', 'Madrid', 'Madrid', '600600600', 'alberto@gmail.com');






CATEGORIES
id
name
description

SUBCATEGORIES
id
name
description
category_id

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
freeShipping
stock
warranty
returns
category_id
is_active
created_at
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

USERS
id
firstname
first_lastname
second_lastname
document
phone1
phone2
address
location
province
country
email
rol

SHOPPINGCART
id
json_shoppingcart
customer_id

PEDIDOS
