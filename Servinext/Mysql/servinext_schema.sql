/*
Servinext : Base De Datos para el control de inventarios y Ordenes de servicios

Explicación de los tipos de datos en MySQL.
  http://mysql.conclase.net/curso/index.php?cap=005#

*/
DROP DATABASE IF EXISTS ctrlfolios;

CREATE DATABASE IF NOT EXISTS ctrlfolios;
USE ctrlfolios;


/* Tabla de Datos */
/* Se ocupa los 9 espacios, no se desperdicia espacio.*/
  /* CHAR(X) = cuando se define de algun tamaño pero no se utiliza, se despedicia espacio, por ejemplo
  CHAR(80), pero el valor de "title" es de 20, se desperdicio 60 espacios.
  VARCHAR(80) se adapta al tamaño del titulo.
  En la base de datos se puede guardar, videos, documentos en formato binario, pero creceria mucho.
  Se sube el video, documento, solo se graba la URL en el campo de la base de datos.
  */

/* Es una tabla catalogo */ 
CREATE TABLE contactos
(
  contacto_id INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,  
  nombre VARCHAR(50) NOT NULL,
  sucursal VARCHAR(10) NOT NULL,
  direccion VARCHAR(100) NOT NULL,  
  referencia TEXT NULL,
  telefono VARCHAR(20) NULL,
  email VARCHAR(80) UNIQUE NULL /* Evalua que sea único en esta tabla. */
);

CREATE TABLE articulos
(
  articulo_id INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(50) NOT NULL,
  marca VARCHAR(20) NOT NULL,
  modelo VARCHAR(20) NOT NULL,
  num_serial VARCHAR(40) NOT NULL,  
  num_parte VARCHAR(20) NOT NULL,
  existencia INTEGER UNSIGNED,
  FULLTEXT KEY search (descripcion, modelo, num_serial, num_parte)
);


CREATE TABLE inventarios
(  
  entrada_salida char(1) NOT NULL,
  fecha_alta DATE NOT NULL,
  articulo_id INTEGER UNSIGNED,
  contacto_id INTEGER UNSIGNED,
  cantidad INTEGER UNSIGNED,
  /* Se debe crear primero la tabla de "ubicacion" */
  /* key (tabla) Reference (tabla - id)*/
  FOREIGN KEY (contacto_id) REFERENCES contactos(contacto_id) ON DELETE RESTRICT ON UPDATE CASCADE,
  /* Revisar esta pagina :  https://blog.openalfa.com/como-trabajar-con-restricciones-de-clave-externa-en-mysql 
  ON DELETE RESTRICT = No se puede borrar en la tabla "estatus" un registro que este contenido en la tabla "movieseries"
  ON UPDATE CASCADE = Se actualiza en automaticamente, cuando se modifique un registro en "estatus" se refrejara en la tabla "movieseries".
  */
  
  FOREIGN KEY (articulo_id) REFERENCES articulos(articulo_id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE users
(
  user VARCHAR(15) PRIMARY KEY,
  email VARCHAR(80) UNIQUE NOT NULL, /* Evalua que sea único en esta tabla. */
  names  VARCHAR(100) NOT NULL,
  birthday DATE NOT NULL,
  pass CHAR(32) NOT NULL, /* Encriptar en MySQL con MD5, requiere 32 posiciones */
  roles ENUM ('Admin','User') NOT NULL
);

/* Precargando Datos */

INSERT INTO articulos(articulo_id,descripcion,marca,modelo,num_serial,num_parte,existencia) VALUES
  (1,'Impresora','Lexmark','MX511','701531HH03YZG','N/A',0),
  (2,'Impresora','Lexmark','MX711','79039484DSSDS','N/A',0),
  (3,'Impresora','Lexmark','MX611','78492323JHDHG','N/A',0);
  
INSERT INTO users (user,email,names,birthday,pass,roles) VALUES
  ('@administrador','administrador@correo.com','Administrador','1984-05-23',MD5('clave'),'Admin'),
  ('@user','usuario@correo.com','Usuario Mortal','2000-12-19',MD5('usuario'),'User');

INSERT INTO contactos(contacto_id,nombre,sucursal,direccion,referencia,telefono,email) VALUES
  (1,'Banamex','0003','Calle Reyrson No. 1079, Ensenada B.C.N.','Subir por la calle 9na desde la central','616-384-40-30','suc_reysorn@banamex.com'),
  (2,'Banamex','0002','Calle Constitucion No. 10843, Col. Centro, Tijuana B.C.N.','Se encuentra entre las calles 4ta y 5ta ','664-994-20-50','suc_cuarta@banamex.com'),  
  (3,'Banamex','4357','Calzada Tecnólogico No. 2050 Col. Otay Universidad Tijuana, B.C.','Se encuentra enfrente de la UABC','664-970-40-90','suc_otay@banamex.com');

