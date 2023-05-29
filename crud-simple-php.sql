DROP DATABASE IF EXISTS crud_php_img;

CREATE DATABASE crud_php_img;

USE crud_php_img;

DROP TABLE IF EXISTS coches;

CREATE TABLE coches (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    marca varchar(255) NOT NULL,
    modelo varchar(255) NOT NULL,
    imagen varchar(255) NOT NULL
    
)ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Tabla de Imagenes';;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO coches (id, marca, modelo, imagen) VALUES
(1, 'Peugeot', '3008', '770585.jpg'),
(2, 'Nissan', 'Qasqai', '798786.jpg'),
(3, 'Audi', 'Q5', '736043.jpeg');