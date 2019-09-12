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
/*
DELIMITER $$
  CREATE PROCEDURE add_detalle_temp(codigo int, cantidad int, token_user varchar(50))
  BEGIN
    DECLARE precio_actual decimal(10,2);
    
    SELECT precio INTO precio_actual FROM producto WHERE codproducto = codigo;

    INSERT INTO detalle_temp(token_user,codproducto,cantidad,precio_venta) VALUES (token_user,codigo,cantidad,precio_actual);

    SELECT tmp.correlativo,tmp.codproducto,p.descripcion,tmp.cantidad,tmp.precio_venta FROM detalle_temp tmp
    INNER JOIN producto p
    ON tmp.codproducto = p.codproducto
    WHERE tmp.token_user = token_user;
    /* Con este "Where" solo seleccionara los usuarios del sistema(Administrador, Supervisor, Vendedor) que realizaron esta Venta.
    
  END;$$
DELIMITER ;
*/

/* Procedimiento Almacenado para borrar registro de la tabla "detalle_temp" 
  Una vez que borra el registro, realiza una consulta para refrescar los registros del detalle de la venta ("detalle_temp")

DELIMITER $$
  CREATE PROCEDURE del_detalle_temp(id_detalle int, token varchar(50))
  BEGIN
    DELETE FROM detalle_temp WHERE correlativo = id_detalle;
    
    SELECT tmp.correlativo,tmp.codproducto,p.descripcion,tmp.cantidad,tmp.precio_venta FROM detalle_temp tmp
    INNER JOIN producto p
    ON tmp.codproducto = p.codproducto
    WHERE tmp.token_user = token;
    /* Con este "Where" solo seleccionara los usuarios del sistema(Administrador, Supervisor, Vendedor) que realizaron esta Venta.
    
  END;$$
DELIMITER ;
*/

/* Procesar la Venta */ 
DELIMITER $$
  CREATE PROCEDURE procesar_venta(cod_usuario int, cod_cliente int, token varchar(50))
  BEGIN
    DECLARE factura INT;
    DECLARE registros INT;
    DECLARE total DECIMAL(10,2);
    DECLARE nueva_existencia INT;
    DECLARE existencia_actual INT;
    DECLARE tmp_cod_producto INT;
    DECLARE tmp_cant_producto INT;
    DECLARE a INT;
    SET a = 1;

    CREATE TEMPORARY TABLE tbl_tmp_tokenuser
    (
      id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      cod_prod BIGINT,
      cant_prod INT);

    SET registros = (SELECT COUNT(*) FROM detalle_temp WHERE token_user = token);
    
    IF registros > 0 THEN
      /* Se inserta registros en la tabla temporal, los dos campos se obtienen de ejecutar el "SELECT" de dos campos que son los que se utilizan para insertalos */
      INSERT INTO tbl_tmp_tokenuser(cod_prod,cant_prod) SELECT codproducto,cantidad FROM detalle_temp WHERE token_user=token;
      /* Generando la factura, estos dos datos son los parametros de "procesar_venta" */
      INSERT INTO factura(usuario,codcliente) VALUES (cod_usuario,cod_cliente);
    
      SET factura = LAST_INSERT_ID(); /* El "id" que le corresponde */

      INSERT INTO detallefactura(nofactura,codproducto,cantidad,precio_venta) SELECT (factura) AS nofactura,codproducto,cantidad,precio_venta FROM detalle_temp WHERE token_user = token;

      WHILE a <= registros DO 
      /* el valor de "cod_prod" se asigna a "tmp_cod_producto", "cant_prod" se asigna a "tmp_cant_producto */
        SELECT cod_prod,cant_prod INTO tmp_cod_producto,tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id = a; 
        /* Obtiene la existencia actual del producto */ 
        SELECT existencia INTO existencia_actual FROM producto WHERE codproducto = tmp_cod_producto;
        /* Esta obteniendo la existencia actual */
        SET nueva_existencia = existencia_actual - tmp_cant_producto;

        /*Actualizando la existencia*/
        UPDATE producto SET existencia = nueva_existencia WHERE codproducto = tmp_cod_producto;
        SET a=a+1;

      END WHILE;
      /* Obtiene el total de la factura que se actualizo anteriormente */
      SET total = (SELECT SUM(cantidad*precio_venta) FROM detalle_temp WHERE token_user = token);
      
      UPDATE factura SET totalfactura=total WHERE nofactura = factura;

      DELETE FROM detalle_temp WHERE token_user = token;

      /* Limpiando todos los registros
      TRUNCATE TABLE tbl_tmp_tokenuser; */
      DROP TABLE tbl_tmp_tokenuser;

      /* Esta es la información que retorna del Procedimiento Almacenado */
      SELECT * FROM factura WHERE nofactura = factura;

    ELSE
      
      SELECT 0;

    END IF;

  END;$$
DELIMITER ;


COMMIT;