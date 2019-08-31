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

/* ALTER TABLE usuario add estatus tinyint(1) DEFAULT 1;  

ALTER TABLE `usuario`
 ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `cliente` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE;

 COMMIT;

*/

/*
--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`codproveedor`, `proveedor`, `contacto`, `telefono`, `direccion`,`usuario_id`) VALUES
(1, 'BIC', 'Claudia Rosales', 789877889, 'Avenida las Americas',1),
(2, 'CASIO', 'Jorge Herrera', 565656565656, 'Calzada Las Flores',1),
(3, 'Omega', 'Julio Estrada', 982877489, 'Avenida Elena Zona 4, Guatemala',1),
(4, 'Dell Compani', 'Roberto Estrada', 2147483647, 'Guatemala, Guatemala',1),
(5, 'Olimpia S.A', 'Elena Franco Morales', 564535676, '5ta. Avenida Zona 4 Ciudad',1),
(6, 'Oster', 'Fernando Guerra', 78987678, 'Calzada La Paz, Guatemala',1),
(7, 'ACELTECSA S.A', 'Ruben PÃ©rez', 789879889, 'Colonia las Victorias',1),
(8, 'Sony', 'Julieta Contreras', 89476787, 'Antigua Guatemala',1),
(9, 'VAIO', 'Felix Arnoldo Rojas', 476378276, 'Avenida las Americas Zona 13',1),
(10, 'SUMAR', 'Oscar Maldonado', 788376787, 'Colonia San Jose, Zona 5 Guatemala',1),
(11, 'HP', 'Angel Cardona', 2147483647, '5ta. calle zona 4 Guatemala',1);

INSERT INTO `usuario` (`idusuario`, `nombre`, `correo`, `usuario`, `clave`,`rol`) VALUES
(2, 'Juan Solis', 'supervisor1@correo.com', 'supervisor', MD5('123'),1),
(3, 'Monserrat Sanchez', 'vendedor1@correo.com', 'vendedor1', MD5('123'),1),
(4, 'Alfredo Lopez', 'vendedor2@correo.com', 'vendedor2', MD5('123'),1);
*/
/* 
Este "TRIGGER" se utilizara para insertar un regsitros en la tabla de "Entradas", es despues de insertar un registros en la tabla de "Producto".

entrada_A_I = Es el nombre del Trigger, para este caso es: Tabla "Entrada", A= "After", I = "Insert"
new = Hace referencia a los datos insertados en la tabla "Producto", es donde tomara los valores para pasarlos a la tabla de "entradas"

SHOW TRIGGERS FROM NombreBaseDatos;  = Muestra todos los triggers creados en la base de datos actual.
DROP TRIGGERS "Nombre Triggers"; = Borra el triggers.
SHOW TRIGGERS LIKE 'nombreTabla' = Para mostrar todos los triggers de "nombreTabla"
SHOW TRIGGERS WHERE EVENT LIKE 'insert' \G; = Muestra todos los "triggers" con el evento "Insert", de forma ordenada (\G)



DELIMITER |
CREATE TRIGGER entrada_A_I AFTER INSERT ON producto FOR EACH ROW
BEGIN
  INSERT INTO entradas (codproducto,cantidad,precio,usuario_id)
  VALUE (new.codproducto,new.existencia,new.precio,new.usuario_id);
END
|
DELIMITER ;


DELIMITER $$
  CREATE PROCEDURE actualizar_precio_producto(n_cantidad int, n_precio decimal(10,2), codigo int)
  BEGIN
    DECLARE nueva_existencia int;
    DECLARE nuevo_total decimal(10,2);
    DECLARE nuevo_precio decimal(10,2);

    DECLARE cant_actual int;
    DECLARE pre_actual decimal(10,2);

    DECLARE actual_existencia int;
    DECLARE actual_precio decimal(10,2);

    SELECT precio,existencia INTO actual_precio,actual_existencia FROM producto WHERE codproducto = codigo;
    SET nueva_existencia = actual_existencia+n_cantidad;
    SET nuevo_total = (actual_existencia*actual_precio)+(n_cantidad*n_precio);
    SET nuevo_precio = nuevo_total/nueva_existencia;

    UPDATE producto SET existencia = nueva_existencia, precio = nuevo_precio WHERE codproducto = codigo;

    SELECT nueva_existencia,nuevo_precio;
  END;$$
DELIMITER ;
*/


COMMIT;