/* Como no se espefica el "id_modelo" se incrementa automaticamente */

/*
INSERT INTO t_Modelo 
	SET descripcion = 'CS820';

INSERT INTO t_Clientes
	SET nombre = 'Grupo Modelo Cerveceria ';

INSERT INTO t_Clientes
	SET nombre = 'NOMBRE CLIENTE XXXXX';


UPDATE t_Marca 
	SET descripcion = 'Huawei' WHERE id_marca = 2;

DELETE FROM t_Clientes WHERE id_clientes = 7;
*/

USE ordenservicios;

/* Consultas varias */ 
SELECT * FROM t_Clientes;

SELECT notas,fecha FROM t_Historico_epo;
/* Que despliege los registros que en el número de serie contengan al inicio "7410" independiente de los demás números*/ 
SELECT id_marca,id_modelo,num_serie FROM t_Equipo WHERE num_serie LIKE '7410%';
SELECT id_marca,id_modelo,num_serie FROM t_Equipo WHERE num_serie LIKE '%80%' ORDER BY num_inv; 

/* Consultas Multiples */
/* Por cada registro de la tabla "t_Equipo" lo Multiplica por cada registro de la tabla "t_Modelo", por lo que no es correcta la consulta, se tiene que agregar la condicional  */
SELECT * FROM t_Equipo AS equipo INNER JOIN t_Modelo AS Modelo;

/* Despliega solo unos campos pero mostrando información de la otra tabla */
SELECT t_Equipo.num_serie,t_Equipo.num_inv,t_Modelo.descripcion FROM t_Equipo AS t_Equipo INNER JOIN t_Modelo AS t_Modelo
	ON t_Equipo.id_modelo = t_Modelo.id_modelo;

SELECT t_Equipo.num_serie,t_Equipo.num_inv,t_Modelo.descripcion FROM t_Equipo AS t_Equipo INNER JOIN t_Modelo AS t_Modelo
	ON t_Equipo.id_modelo = t_Modelo.id_modelo ORDER BY t_Modelo.descripcion DESC; 

SELECT t_Equipo.num_serie,t_Equipo.num_inv,t_Marca.descripcion,t_Modelo.descripcion,t_tipo_epo.descripcion FROM t_Equipo AS t_Equipo 
	INNER JOIN t_Modelo AS t_Modelo 
	ON t_Equipo.id_modelo = t_Modelo.id_modelo	
	INNER JOIN t_Marca AS t_Marca
	ON t_Equipo.id_marca = t_Marca.id_marca
	INNER JOIN t_Tipo_epo AS t_tipo_epo
	ON t_Equipo.id_tipo_epo = t_tipo_epo.id_tipo_epo
	WHERE  t_Equipo.id_modelo  = 1
	ORDER BY t_Modelo.descripcion DESC;

UPDATE t_Marca 
	SET descripcion = 'Lexmark Modif'
	WHERE id_marca = 3;

/* Salvar un registro. 
	REPLACE no forma parte del estadard de SQL, es una instrucción propia de MariaDB
	Inserta un nuevo registro en el caso de que la clave(clave única) no exista.
	Actualiza si existe la clave única.
	Este actualiza todos los campos, se debe colocar todos los valores de la tabla, ya que si no se coloca le asigna un valor nulo.
	Para agregar un registro.
		REPLACE INTO t_Clientes (id_clientes,nombre) VALUES (0,'Famsa');
		REPLACE t_Clientes SET id_clientes = 0, nombre='Famsa';
 	
	 Para Actualizar registro 
		REPLACE t_Clientes SET id_clientes = 8, nombre='Grupo Famsa';

*/ 


