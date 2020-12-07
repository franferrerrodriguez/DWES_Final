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