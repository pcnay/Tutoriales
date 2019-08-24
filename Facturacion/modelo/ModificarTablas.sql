USE facturacion;
/* Agregar una columna("estatus") a la Tabla de Usuarios */
/* ALTER TABLE usuario add estatus tinyint(1) DEFAULT NULL; */
/* Cuando se agrega la palabra por DEFAULT <Valor>, cada vez que se crea un nuevo se grega lo que contenga <Valor>*/

/*
Para agregar varias columnas
ALTER TABLE tabla1 add (
colNueva varchar(2) NOT NULL,
colMásNueva tinyint(1) default 0
)

*/

/* ALTER TABLE usuario add estatus tinyint(1) DEFAULT 1;  */

ALTER TABLE `usuario`
 ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `cliente` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

 COMMIT;
