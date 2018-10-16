/*
Mexflix : Base De Datos de peliculas y series
Cualquier parecido con Netflix es mera  coincidencia.

Explicación de los tipos de datos en MySQL.
  http://mysql.conclase.net/curso/index.php?cap=005#

*/

CREATE DATABASE IF NOT EXISTS mexflix;
USE mexflix;
CREATE TABLE movieseries
(
  /* Se ocupa los 9 espacios, no se desperdicia espacio.*/
  imdb_char CHAR(9) PRIMARY KEY,
  /* CHAR(X) = cuando se define de algun tamaño pero no se utiliza, se despedicia espacio, por ejemplo
  CHAR(30), pero el valor de "title" es de 20, se desperdicio 60 espacios.
  VARCHAR(80) se adapta al tamaño del titulo.
  */
  title VARCHAR(80) NOT NULL,
  plott TEXT NULL,



);

/* TIEMPO  25:55 Min */

