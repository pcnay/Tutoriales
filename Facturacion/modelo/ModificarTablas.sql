USE facturacion;
/* Agregar una columna("estatus") a la Tabla de Usuarios */
/* ALTER TABLE usuario add estatus tinyint(1) DEFAULT NULL; */
/* Cuando se agrega la palabra por DEFAULT <Valor>, cada vez que se crea un nuevo se grega lo que contenga <Valor>*/
 
ALTER TABLE usuario add estatus tinyint(1) DEFAULT 1; 

/*
Para agregar varias columnas
ALTER TABLE tabla1 add (
colNueva varchar(2) NOT NULL,
colMásNueva tinyint(1) default 0
)

*/