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
    free_shipping INT NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    warranty INT NOT NULL,
    return_days INT NOT NULL,
    is_visible INT NOT NULL DEFAULT 1,
    visitor_counter INT NOT NULL DEFAULT 1,
    release_date DATE,
    subcategory_id INT NOT NULL,
    CONSTRAINT ARTICLES_subcategory_id FOREIGN KEY(subcategory_id) REFERENCES SUBCATEGORIES(id) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB CHARACTER SET latin1 COLLATE latin1_spanish_ci;

/*------------------------------------------------------------------------------------*/

INSERT INTO USERS(firstname, first_lastname, second_lastname, document, phone1, phone2, address, location, province, country, email, password, rol) VALUES
('','root','', '', '', '', '', '', '', '', 'root@root.com', '1234', 5);

INSERT INTO CATEGORIES(name, description, is_visible) VALUES
('Componentes', 'Componentes', 1),
('Ordenadores', 'Ordenadores', 1),
('Smartphones, Tablets, TV...', 'Smartphones y Telefonía', 1),
('Periféricos', 'Periféricos', 1),
('Consolas y Gaming', 'Consolas y Gaming', 1);

INSERT INTO SUBCATEGORIES(name, description, is_visible, category_id) VALUES
('Placas base','Placas base', 1, 1),
('Procesadores','Procesadores', 1, 1),
('Discos duros','Discos duros', 1, 1),
('Tarjetas gráficas','Tarjetas gráficas', 1, 1),
('Memorias RAM','Memorias RAM', 1, 1),
('Fuentes de alimentación','Fuentes de alimentación', 1, 1),
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
('Juegos consola','Componentes', 1, 5);