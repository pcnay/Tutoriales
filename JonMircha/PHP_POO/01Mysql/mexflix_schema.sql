/*
Mexflix : Base De Datos de peliculas y series
Cualquier parecido con Netflix es mera  coincidencia.

Explicación de los tipos de datos en MySQL.
  http://mysql.conclase.net/curso/index.php?cap=005#

*/
DROP DATABASE IF EXISTS mexflix;

CREATE DATABASE IF NOT EXISTS mexflix;
USE mexflix;


/* Tabla de Datos */
/* Se ocupa los 9 espacios, no se desperdicia espacio.*/
  /* CHAR(X) = cuando se define de algun tamaño pero no se utiliza, se despedicia espacio, por ejemplo
  CHAR(30), pero el valor de "title" es de 20, se desperdicio 60 espacios.
  VARCHAR(80) se adapta al tamaño del titulo.
  En la base de datos se puede guardar, videos, documentos en formato binario, pero creceria mucho.
  Se sube el video, documento, solo se graba la URL en el campo de la base de datos.
  */

/* Es una tabla catalogo */ 
CREATE TABLE estatus
(
  estatus_id INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  estatus VARCHAR(20) NOT NULL
);

CREATE TABLE movieseries
(  
  imdb_char CHAR(9) PRIMARY KEY,  
  title VARCHAR(80) NOT NULL,
  plott TEXT NULL,
  author VARCHAR(100) DEFAULT 'Pending',
  actors VARCHAR(100) DEFAULT 'Pending',
  country VARCHAR(100) DEFAULT 'Unknown',
  premiere YEAR(4) NOT NULL,
  poster VARCHAR(150) DEFAULT 'no-poster.jpg',
  trailer VARCHAR(150) DEFAULT 'no-trailer.jpg',
  rating DECIMAL(2,1),
  genres VARCHAR(50) NOT NULL,
  estatus INTEGER UNSIGNED NOT NULL,
  category ENUM('Movie','Serie') NOT NULL,
  /* Se debe crear primero la tabla de "estatus" */
  FOREIGN KEY (estatus) REFERENCES estatus(estatus_id) ON DELETE RESTRICT ON UPDATE CASCADE
  /* Revisar esta pagina :  https://blog.openalfa.com/como-trabajar-con-restricciones-de-clave-externa-en-mysql 
  ON DELETE RESTRICT = No se puede borrar en la tabla "estatus" un registro que este contenido en la tabla "movieseries"
  ON UPDATE CASCADE = Se actualiza en automaticamente, cuando se modifique un registro en "estatus" se refrejara en la tabla "movieseries".
  */
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




/* 'coming Soon','Release','In Issue','Finished','Canceled' */

/* TIEMPO  25:55 Min */

