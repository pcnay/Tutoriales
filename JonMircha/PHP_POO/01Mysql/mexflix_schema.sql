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
  /* Define el campo para buscar en la tabla, sea por titulo,autor,actores, generonombre; los campos tipo TEXT no aplican en FullText */
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

DELETE FROM movieseries WHERE imdb_id = 'tt0947645';

SELECT * FROM movieseries;

SELECT COUNT(*) FROM movieseries; 

SELECT * FROM movieseries WHERE category = 'Serie';

SELECT category,category,country,estatus FROM movieseries WHERE category = 'Serie';

SELECT category,category,country,estatus,premiere FROM movieseries WHERE category = 'Serie' ORDER BY premiere;
SELECT category,category,country,estatus,premiere FROM movieseries WHERE category = 'Serie' AND country = 'USA' ORDER BY premiere;

/* NO importa como inicia el texto "%" */
SELECT category,category,country,estatus,premiere FROM movieseries WHERE category = 'Serie' AND country LIKE '%USA' ORDER BY premiere;

/* NO importa como termina el texto "%" */
SELECT category,category,country,estatus,premiere FROM movieseries WHERE category = 'Serie' AND country LIKE 'USA%' ORDER BY premiere;

/* NO importa como inicie y termina el texto "%" , que solo contenga la palabra "USA"*/
SELECT category,category,country,estatus,premiere FROM movieseries WHERE category = 'Serie' AND country LIKE '%USA%' ORDER BY premiere;

SELECT category,category,country,estatus,premiere FROM movieseries WHERE category = 'Serie' OR estatus = 1  ORDER BY premiere;

/* Consultas Múltiplex */

/* En Wikipedia se encuentra el tema de Join con mas detalles */
/* Realiza una multiplicación de matrices, por cada registro de la tabla "MovieSeries" agrega todos los registros de la tabla  "Estatus", por lo que no es correcta la consulta multiple, se obtiene esta por no agregar una condicional  */
SELECT * FROM movieseries AS ms INNER JOIN estatus AS s

/* Consulta multiple correcta, por cada registro de la tabla "MovieSeries" se agre un registro de la tabla "Estatus" pero que existen el "id estatus" en ambas tablas que es como debe funcionar */
SELECT * FROM movieseries AS ms INNER JOIN estatus AS s
  ON ms.estatus = s.estatus_id;

SELECT ms.title,ms.category,ms.premiere,s.estatus 
  FROM movieseries AS ms INNER JOIN estatus AS s
  ON ms.estatus = s.estatus_id
  ORDER BY ms.premiere;

SELECT ms.title,ms.category,ms.premiere,s.estatus 
  FROM movieseries AS ms INNER JOIN estatus AS s
  ON ms.estatus = s.estatus_id
  WHERE s.estatus = 'Release'
  ORDER BY ms.premiere;

SELECT ms.title,ms.category,ms.premiere,s.estatus 
  FROM movieseries AS ms INNER JOIN estatus AS s
  ON ms.estatus = s.estatus_id
  WHERE (s.estatus = 'Release' OR s.estatus = 'coming Soon') AND ms.category = 'Serie'
  ORDER BY ms.premiere;

/* Consulta FullText */
/* La palabra "Vince" se buscara en los campos : "title, author, actors, genres" */
SELECT * FROM movieseries
  WHERE MATCH(title, author, actors, genres)  
  AGAINST('Vince' IN BOOLEAN MODE);

SELECT ms.title,ms.category,ms.country,ms.genres,ms.premiere,s.estatus
  FROM movieseries AS ms
  INNER JOIN estatus AS s
  ON ms.estatus = s.estatus_id
  WHERE MATCH(ms.title, ms.author, ms.actors, ms.genres)  
  AGAINST('Drama' IN BOOLEAN MODE)
  ORDER BY ms.premiere;

/* Integridad referencial */
/* Con este valor de "0" se incrementa automaticamente */
INSERT INTO estatus  
  SET estatus_id = 0,
      estatus = 'Otro Estatus';

/* Actualizando en Cascada */
UPDATE estatus 
  SET estatus_id = 7,
      estatus = 'Estrenada'
  WHERE estatus_id = 2;

/*
MySQL tiene una instrucción para relizar el proceso de INSERT Y UPDATE en una sola instrucción. "REPLACE"
NO forma parte del estandar SQL, solo lo tiene MySQL
En caso de no existir el campo llave este lo agrega automanticamente. Por lo que antes de grabarlo realiza una Busqueda.
En el caso de que encuentre el registro realiza la actualización.
Se tiene que tener cuidado ya que "REPLACE" actualiza todos los campos, por lo que se tiene que escribir el valor, de lo contrario lo guarda con el valor nulo.
Se debe utilizar el campo llave para que puede funcionar correctamente este comando
*/
/* Inserta un registro */
REPLACE INTO estatus (estatus_id,estatus) VALUES (0,"estatus 6Nov-1");

/* Actualiza un registro */
REPLACE INTO estatus (estatus_id,estatus) VALUES (10,"estatus 6Nov-1");

/* REPLACE estatus SET estatus_id = 0, estatus = "Estatus 6Nov-2"); */


/* Utilizando la tabla de "Users" 

*/
REPLACE INTO users SET
  user = '@usuario',
  email = 'usuario@midominio.com',
  names = 'Soy un usuario',
  birthday = '1970-09-23',
  pass = MD5('un-passwod'),
  roles = 'Admin';

/* Actualizando el password del usuario.*/ 

/* Usando la clausula UPDATE 
UPDATE users SET
  pass = MD5('un_nuevo_password');
  WHERE user = '@usuario' AND email = 'usuario@midominio.com';
*/
/* Se debe teclear todos los campos para que no los asigne a null.*/
REPLACE INTO users SET
  user = '@usuario',
  email = 'usuario@midominio.com',
  names = 'Soy un usuario',
  birthday = '1970-09-23',
  pass = MD5('un-nuevo-password'),
  roles = 'Admin';

