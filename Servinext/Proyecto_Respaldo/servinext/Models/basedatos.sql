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

CREATE TABLE t_Tipo_Componente
(
  id_tipo_componente INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(45) NOT NULL
);

CREATE TABLE t_Equipo
(
  id_epo INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  num_serie VARCHAR(45) NOT NULL,
  num_inv VARCHAR(45) NULL,
  num_parte VARCHAR(45) NULL,
  existencia INTEGER UNSIGNED NOT NULL,
  id_tipo_componente INT UNSIGNED NOT NULL,
  id_marca INTEGER UNSIGNED NOT NULL,
  id_modelo INTEGER UNSIGNED NOT NULL,
  /* FULLTEXT KEY search(num_serie,num_inv),*/
  FOREIGN KEY(id_tipo_componente) REFERENCES t_Tipo_Componente(id_tipo_componente)
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


CREATE TABLE t_Usuarios
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

/* Precargando los datos */
INSERT INTO t_Marca (id_marca,descripcion) VALUES
  (1,'HewllwtPackard'),
  (2,'Dell'),
  (3,'Lexmark');

INSERT INTO t_Modelo (id_modelo,descripcion) VALUES
  (1,'MX711'),
  (2,'MX611'),
  (3,'Optiplex 970');

INSERT INTO t_Clientes (id_clientes,nombre) VALUES
  (1,'Banamex'),
  (2,'Nacional Monte De Piedad'),
  (3,'BBVA Bancomer');

INSERT INTO t_Tipo_Componente (id_tipo_componente,descripcion) VALUES
  (1,'Escritorio'),
	(2,'Escritorio Moderno'),
  (3,'Portatil'),
  (4,'Teclado'),
  (5,'NoteBook');

INSERT INTO t_Sucursales (id_sucursal,nombre,num_suc,domicilio,referencias,tel_fijo,tel_movil,contacto) VALUES
  (1,'Banamex Matamoros','4333','Ruta Independencia No. 15150','Dentro Plaza Mariano Matamoros','664-999-99-99','664-99-99','Julio Salazar'),
  (2,'Compartamos Banco','Los Pinos','Blvd. Diaz Ordaz No. 10430','Aun lado de la CFE','664-999-99-99','664-99-99','Juana Sanchez'),
  (3,'Banamex La Mesa','0390','Blvd. Agua Caliente No. 140','Enfrente de Telcel 5y10 ','664-999-99-99','664-99-99','Margarita Solis');

INSERT INTO t_Equipo (id_epo,num_serie,num_inv,id_tipo_componente,num_parte,existencia,id_marca,id_modelo) VALUES
  (1,'7410HH348984','Numero De Inventario 1',1,'40X4598',1,1,1),
	(2,'7410HH348993','Numero De Inventario 2',2,'NUMPARTE10',2,1,1),
	(3,'9410HH348081','Numero De Inventario 3',1,'NUMPARTE20',4,1,1);

INSERT INTO t_Historico_epo (id_Historico_epo,notas,id_modelo,id_marca,id_clientes,id_sucursal,id_epo,fecha) VALUES
  (1,'Campo De Notas 1',1,1,1,1,1,'2018-05-19'),
	(2,'Campo De Notas 2',1,1,1,1,1,'2018-06-20'),
	(3,'Campo De Notas 3',1,1,1,1,1,'2018-07-19');

INSERT INTO t_Usuarios (usuario,email,nombre,cumpleanos,clave,perfil) VALUES
  ('@admin','admin@gmail.com','Administrador','1980-10-10',MD5('1234'),'Admin'),
  ('@usuario','usuario@gmail.com','Usuario','1990-11-11',MD5('4321'),'User');
