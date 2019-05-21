/*
Mexflix : Base De Datos de peliculas y series
Cualquier parecido con Netflix es mera  coincidencia.

Explicación de los tipos de datos en MySQL.
  http://mysql.conclase.net/curso/index.php?cap=005#

*/
-- Ejecutarlo desde una terminal de Mysql 
-- Se debe accesar al directorio donde se encuentra el "script.sql" y ejecutar el comenado "mysql" desde una terminal
-- $ mysql -u nom-usr -p NombreBaseDatos < script.sql
-- Otra Forma :
--    mysql -u usuario -p NombreBaseDatos
--    source script.sql ó \. script.sql
 
DROP DATABASE IF EXISTS ordenservicios;

CREATE DATABASE IF NOT EXISTS ordenservicios;
USE ordenservicios;


/* Tabla de Datos */
/* Se ocupa los 9 espacios, no se desperdicia espacio.*/
  /* CHAR(X) = cuando se define de algun tamaño pero no se utiliza, se despedicia espacio, por ejemplo
  CHAR(30), pero el valor de "title" es de 20, se desperdicio 60 espacios.
  VARCHAR(80) se adapta al tamaño del titulo.
  En la base de datos se puede guardar, videos, documentos en formato binario, pero creceria mucho.
  Se sube el video, documento, solo se graba la URL en el campo de la base de datos.
  */

/* Es una tabla catalogo */ 

CREATE TABLE t_Marca
(
  id_marca INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(80) NOT NULL
);

CREATE TABLE t_Modelo
(
  id_modelo INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(80) NOT NULL
);

CREATE TABLE t_Clientes
(
  id_clientes INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(80) NOT NULL
);

CREATE TABLE t_Sucursales
(
  id_sucursal INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(80) NOT NULL,
  num_suc VARCHAR(45) NOT NULL,
  domicilio VARCHAR(90) NOT NULL,
  referencias TEXT NULL,
  tel_fijo VARCHAR(15) NULL,
  tel_movil VARCHAR(45) NULL,
  contacto VARCHAR(80) NULL
);

CREATE TABLE t_Tipo_epo
(
  id_tipo_epo INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(45) NOT NULL
);

CREATE TABLE t_Equipo
(
  id_epo INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  num_serie VARCHAR(45) NOT NULL,
  num_inv VARCHAR(45) NULL,
  id_tipo_epo INT UNSIGNED NOT NULL,
  id_marca INTEGER UNSIGNED NOT NULL,
  id_modelo INTEGER UNSIGNED NOT NULL,
  /* FULLTEXT KEY search(num_serie,num_inv),*/
  FOREIGN KEY(id_tipo_epo) REFERENCES t_Tipo_epo(id_tipo_epo)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(id_marca) REFERENCES t_Marca(id_marca)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(id_modelo) REFERENCES t_Modelo(id_modelo)
    ON DELETE RESTRICT ON UPDATE CASCADE
  /* Revisar esta pagina :  https://blog.openalfa.com/como-trabajar-con-restricciones-de-clave-externa-en-mysql 
    ON DELETE RESTRICT = No se puede borrar en la tabla "estatus" un registro que este contenido en la tabla "movieseries"
    ON UPDATE CASCADE = Se actualiza en automaticamente, cuando se modifique un registro en "estatus" se refrejara en la tabla "movieseries".
  */    
);


CREATE TABLE usuarios
(
  usuario VARCHAR(15) PRIMARY KEY,
  email VARCHAR(80) UNIQUE NOT NULL, /* Evalua que sea único en esta tabla. */
  nombre  VARCHAR(100) NOT NULL,
  cumpleanos DATE NOT NULL,
  clave CHAR(32) NOT NULL, /* Encriptar en MySQL con MD5, requiere 32 posiciones */
  perfil ENUM ('Admin','User') NOT NULL
);

CREATE TABLE t_Historico_epo
(
  id_Historico_epo INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  id_marca INTEGER UNSIGNED NOT NULL,
  id_modelo INTEGER UNSIGNED NOT NULL,
  id_clientes INTEGER UNSIGNED NOT NULL,
  id_sucursal INTEGER UNSIGNED NOT NULL,
  id_epo INTEGER UNSIGNED NOT NULL,
  fecha DATE NOT NULL,
  notas TEXT NULL,
  FOREIGN KEY(id_marca) REFERENCES t_Marca(id_marca)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(id_modelo) REFERENCES t_Modelo(id_modelo)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(id_clientes) REFERENCES t_Clientes(id_clientes)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(id_sucursal) REFERENCES t_Sucursales(id_sucursal)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(id_epo) REFERENCES t_Equipo(id_epo)
    ON DELETE RESTRICT ON UPDATE CASCADE    
    
);

CREATE TABLE estatus
(
  estatus_id INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  estatus VARCHAR(80) NOT NULL
);


CREATE TABLE movieseries
(  
  imdb_id CHAR(9) PRIMARY KEY,  
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
  /* Define el campo para buscar en la tabla, sea por titulo,autor,actores, generonombre; los campos tipo TEXT no aplcan en FullText */
  FULLTEXT KEY search (title, author, actors, genres), 
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

/* Precargando los datos */
INSERT INTO estatus (estatus_id,estatus) VALUES
  (1,'coming Soon'),
  (2,'Release'),
  (3,'In Issue'),
  (4,'Finish'),
  (5,'Canceled');

INSERT INTO users (user,email,names,birthday,pass,roles) VALUES
  ('@jonmircha','jonmircha@bextlan.com','Jonathan Mircha','1984-05-23',MD5('chafo'),'Admin'),
  ('@user','usuario@bextlan.com','Usuario Mortal','2000-12-19',MD5('chimichangas'),'User');

/* Con las comillas no afecta la colocación de apostrofes. Con apostrofes se tiene que colocar el caracter \ 
\'The line \'  para que grabe en la base de datos 'The Line'
Cuando se tenga tenga una oración que inicia con "", pero en medio de la misma tenga comillas se tiene que escribir \"Mr. Robot \"

*/

INSERT INTO movieseries(imdb_id,title,plott,genres,author,actors,country,premiere,trailer,poster,rating,estatus,category) VALUES 
('tt0903747','Breaking Bad',"man dnmadnm adnm adnm anmd asnd as dnmsa dmsad ad anmds nmas dnma sdnm anmd 's anmd adnm asnmd mann dmnas dmna dnd amdn",'Crime, Drama,Trailer','Vince Gallent', 'Bryan Cranston','USA','2008','https://ia.media-imdb.com','posters //////////',9.5,4,'Serie'),
('tt0943547','Breaking Bad','man dnmadnm adnm adnm anmd asnd as dnmsa dmsad ad anmds nmas dnma sdnm anmd anmd adnm \'The line \' asnmd mann dmnas dmna dnd amdn','Crime, Drama,Trailer','Vince Gallent', 'Bryan Cranston','USA','2008','https://ia.media-imdb.com','posrtes ///////////',8.5,2,'Serie'),
('tt0949087','Breaking Bad','man dnmadnm adnm adnm anmd asnd as dnmsa dmsad ad anmds nmas dnma sdnm anmd anmd adnm asnmd mann dmnas dmna dnd amdn','Crime, Drama,Trailer','Vince Gallent', 'Bryan Cranston','USA','2010','https://ia.media-imdb.com','posrtes ///////////',7.5,1,'Movie'),
('tt0947645','Breaking Bad',"man dnmadnm adnm adnm anmd asnd as dnmsa dmsad ad anmds nmas dnma sdnm anmd anmd \"Mr. Robot \" adnm asnmd mann dmnas dmna dnd amdn",'Crime, Drama,Trailer','Vince Gallent', 'Bryan Cranston','USA','2015','https://ia.media-imdb.com','posrtes ///////////',8.5,4,'Movie');

/* Para rellenar la tabla de "MovieSeries, se puede utilizar esta página Web. > 
http://www.omdbapi.com/ 
http://www.imdb.com

*/

INSERT INTO movieseries SET 
  imdb_id = 'tt3749900', 
  title = 'Titulo película', 
  plott = 'Plott ///////', 
  genres = 'Genres ////////',
  author = 'Autores ###################',
  actors = 'Actorres ##################',
  country = "Pais $###################",
  premiere = 2015,
  trailer = 'Trailer ))))))))))))))))))))))))))))))))))',
  poster = 'Poster )))))))))))))))))))))))))))))))))))))',
  rating = 8.2,
  estatus = 2,
  category = 'Movie';

UPDATE movieseries SET 
  author = 'autores ===============================',
  actors = 'actores &&&&&&&&&&&&&&&&&&&&&',
  country = 'México',
  poster = 'poster )))))))))))))))))))))))))))))',
  trailer = 'trailer ==============================',
  rating = 9.2,
  plott = 'plott ////////////////////////////',
  category = 'Serie',
  estatus = 1
  WHERE imdb_id = 'tt0903747';
