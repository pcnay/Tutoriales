


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
SELECT * FROM movieseries AS ms INNER JOIN estatus AS s;

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

