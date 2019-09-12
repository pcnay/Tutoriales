-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-01-2019 a las 19:00:47
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ejemplo`
--

-- --------------------------------------------------------

/*
Explicación de los tipos de datos en MySQL.
  http://mysql.conclase.net/curso/index.php?cap=005#

Trabajando localmente y/o en otros proveedores de hosting, podrás verás que en el valor “host” siempre utilizas “localhost”. Esto es debido a que el servidor de base de datos (mysql) y el servidor web (apache) se encuentran en el mismo servidor. Aquí radica la diferencia, ya que cuenta con una infraestructura en nodos en donde tenemos separados el servidor de base de datos del servidor web.

*/
-- Ejecutarlo desde una terminal de Mysql 
-- Se debe accesar al directorio donde se encuentra el "script.sql" y ejecutar el comenado "mysql" desde una terminal
-- $ mysql -u nom-usr -p NombreBaseDatos < script.sql
-- Otra Forma :
--    mysql -u usuario -p NombreBaseDatos
--    source script.sql ó \. script.sql

/* =============================================================================*/
/* Este Trigger corresponde a la tabla de "Producto" cuando se inserta se actualiza la tabla de "entradas"

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

INSERT INTO `producto` (`codproducto`, `descripcion`, `proveedor`, `precio`, `existencia`,`usuario_id`,`foto`) VALUES
(1, 'Descripcion Producto 1',1,150,10,1,'foto-1.jpg'),
(2, 'Descripcion Producto 2',3,100,4,1,'foto-2.jpg'),
(3, 'Descripcion Producto 3',2,90,6,3,'foto-3.jpg');

=================================================================================
PROCEDIMIENTOS ALMACENADOS
Por defecto estos son asociados a la base de datos actual. 
En una terminal de MySQL se ejecuta "proc_name (parametro1, parametro2, ...)
CALL proc_name;
DROP PROCEDURE IF EXISTS names;
SHOW CREATE PROCEDURE proc_name;
SHOW PROCEDURE STATUS LIKE 'actualizar_precio_producto' \G;
*************************** 1. row ***************************
                  Db: facturacion
                Name: actualizar_precio_producto
                Type: PROCEDURE
             Definer: root@localhost
            Modified: 2019-08-29 19:23:40
             Created: 2019-08-29 19:23:40
       Security_type: DEFINER
             Comment:
character_set_client: utf8
collation_connection: utf8_general_ci
  Database Collation: latin1_swedish_ci
1 row in set (0.003 sec)

ALTER PROCEDURE proc_name;

==================================================================================
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




DROP DATABASE IF EXISTS facturacion;

CREATE DATABASE IF NOT EXISTS facturacion;
USE facturacion;

-- Los datos de la empresa 
CREATE TABLE `configuracion` (
  `id` bigint(11) NOT NULL,
  `nit` varchar(20) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `razon_social` varchar(100) DEFAULT NULL,
  `telefono` bigint(11) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `iva` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nit` int(11) DEFAULT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
   `dateadd` datetime NOT NULL  DEFAULT CURRENT_TIMESTAMP, /* Por defecto grabara la fecha sin necesidad de agregalo manualmente */
  `usuario_id` int(11) NOT NULL,
  `estatus` tinyint DEFAULT 1      
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `correlativo` bigint(11) NOT NULL,
  `nofactura` bigint(11) DEFAULT NULL,
  `codproducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_venta` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

CREATE TABLE `detalle_temp` (
  `correlativo` int(11) NOT NULL,
  `token_user` varchar(50) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `correlativo` int(11) NOT NULL,
  `codproducto` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `nofactura` bigint(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` int(11) DEFAULT NULL,
  `codcliente` int(11) DEFAULT NULL,
  `totalfactura` decimal(10,2) DEFAULT NULL,
  `estatus` tinyint DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codproducto` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `proveedor` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `existencia` int(11) DEFAULT NULL,
  `dateadd` datetime NOT NULL  DEFAULT CURRENT_TIMESTAMP, /* Por defecto grabara la fecha sin necesidad de agregalo manualmente */
  `usuario_id` int(11) NOT NULL,
  `estatus` tinyint DEFAULT 1,
  `foto` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `codproveedor` int(11) NOT NULL,
  `proveedor` varchar(100) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` bigint(11) DEFAULT NULL,
  `direccion` text,
  `usuario_id` int(11) NOT NULL,
  `date_add` datetime NOT NULL  DEFAULT CURRENT_TIMESTAMP, /* Por defecto grabara la fecha sin necesidad de agregalo manualmente */
  `estatus` tinyint DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `usuario` varchar(15) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL,
  `estatus` tinyint DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Índices para tablas volcadas
--

ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `usuario_id` (`usuario_id`); /* Para poder enlazar la tabla "Usuario" con "Cliente"*/
--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `codproducto` (`codproducto`),
  ADD KEY `nofactura` (`nofactura`);

--
-- Indices de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD PRIMARY KEY (`correlativo`),
  -- ADD KEY `nofactura` (`nofactura`),
  ADD KEY `codproducto` (`codproducto`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `codproducto` (`codproducto`),
  ADD KEY `usuario_id` (`usuario_id`); /* Para poder enlazar la tabla "Usuario" con "Entrada"*/
--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`nofactura`),
  ADD KEY `usuario` (`usuario`),
  ADD KEY `codcliente` (`codcliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codproducto`),
  ADD KEY `proveedor` (`proveedor`),
  ADD KEY `usuario_id` (`usuario_id`); /* Para poder enlazar la tabla "Usuario" con "Cliente"*/

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`codproveedor`),
  ADD KEY `usuario_id` (`usuario_id`); /* Para poder enlazar la tabla "Usuario" con "Cliente"*/

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `rol` (`rol`);
  

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT;
  
--
-- AUTO_INCREMENT de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `correlativo` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `nofactura` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `codproducto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `codproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `detallefactura_ibfk_1` FOREIGN KEY (`nofactura`) REFERENCES `factura` (`nofactura`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD CONSTRAINT `detalle_temp_ibfk_1` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

/* Durante el proyecto se elimina la relacion de "Factura" con "Detalle_temp"
  --ADD CONSTRAINT `detalle_temp_ibfk_1` FOREIGN KEY (`nofactura`) REFERENCES `factura` (`nofactura`) ON DELETE CASCADE ON UPDATE CASCADE,
*/
--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`codproducto`) REFERENCES `producto` (`codproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`codcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;
  
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `proveedor`
  ADD CONSTRAINT `proveedor_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`proveedor`) REFERENCES `proveedor` (`codproveedor`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

/*
  Otra forma de crearlo:
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
  comentarios TEXT NULL,
  /* Longuitud de TEXT = 4 GB */
  /* FULLTEXT KEY search(num_serie,num_inv),
  FOREIGN KEY(id_tipo_componente) REFERENCES t_Tipo_Componente(id_tipo_componente)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(id_marca) REFERENCES t_Marca(id_marca)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(id_modelo) REFERENCES t_Modelo(id_modelo)
    ON DELETE RESTRICT ON UPDATE CASCADE
*/

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `rol` (`idrol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Supervisor'),
(3, 'Vendedor');

INSERT INTO `usuario` (`idusuario`, `nombre`,`correo`,`usuario`,`clave`,`rol`) VALUES
(1, 'Abel','info@abelosh.com','admin',MD5('123'),1),
(2, 'Juan','juan@correo.com','supervisor',MD5('123'),2),
(3, 'Rosalia','rosalia@correo.com','vendedor',MD5('123'),3);

INSERT INTO `cliente` (`idcliente`, `nit`, `nombre`, `telefono`, `direccion`,`usuario_id`) VALUES
(1, 12345, 'Nombre Cliente 1', 0293982, 'Direccion Cliente 1',1),
(2, 123456, 'Nombre Cliente 2', 021232, 'Direccion Cliente 2',2),
(3, 1234567, 'Nombre Cliente 3', 2123982, 'Direccion Cliente 3',1),
(4, 123, 'Nombre Cliente 4', 444444, 'Direccion Cliente 4',1),
(5, 12340, 'Nombre Cliente 5', 55555, 'Direccion Cliente 5',1),
(6, 1212, 'Nombre Cliente 6', 66666, 'Direccion Cliente 6',1);

INSERT INTO `proveedor` (`codproveedor`, `proveedor`, `contacto`, `telefono`, `direccion`,`usuario_id`) VALUES
(1, 'BIC', 'Claudia Rosales', 789877889, 'Avenida las Americas',1),
(2, 'CASIO', 'Jorge Herrera', 565656565656, 'Calzada Las Flores',2),
(3, 'Omega', 'Julio Estrada', 982877489, 'Avenida Elena Zona 4, Guatemala',3),
(4, 'Dell Compani', 'Roberto Estrada', 2147483647, 'Guatemala, Guatemala',2),
(5, 'Olimpia S.A', 'Elena Franco Morales', 564535676, '5ta. Avenida Zona 4 Ciudad',1),
(6, 'Oster', 'Fernando Guerra', 78987678, 'Calzada La Paz, Guatemala',3),
(7, 'ACELTECSA S.A', 'Ruben PÃ©rez', 789879889, 'Colonia las Victorias',2),
(8, 'Sony', 'Julieta Contreras', 89476787, 'Antigua Guatemala',1),
(9, 'VAIO', 'Felix Arnoldo Rojas', 476378276, 'Avenida las Americas Zona 13',3),
(10, 'SUMAR', 'Oscar Maldonado', 788376787, 'Colonia San Jose, Zona 5 Guatemala',2),
(11, 'HP', 'Angel Cardona', 2147483647, '5ta. calle zona 4 Guatemala',1);

-- Insertando datos en la tabla de "Configuracion"
INSERT INTO `configuracion` (`id`, `nit`, `nombre`, `razon_social`, `telefono`,`email`,`direccion`,`iva`) VALUES
(1, '12345GFRE','LA GRAN EMPRESA DEL NORTE, S.A. DE C.V.', 'SEPSA',999873234,'email@empresa.com.mx','Ave. Los Laureles No. 120 Esq. Con Amado Nervo',12);

DELIMITER |
CREATE TRIGGER entrada_A_I AFTER INSERT ON producto FOR EACH ROW
BEGIN
  INSERT INTO entradas (codproducto,cantidad,precio,usuario_id)
  VALUE (new.codproducto,new.existencia,new.precio,new.usuario_id);
END
|
DELIMITER ;

INSERT INTO `producto` (`codproducto`, `descripcion`, `proveedor`, `precio`, `existencia`,`usuario_id`,`foto`) VALUES
(1, 'Descripcion Producto 1',1,150,10,1,'foto-1.jpg'),
(2, 'Descripcion Producto 2',3,100,4,1,'foto-2.jpg'),
(3, 'Descripcion Producto 3',2,90,6,3,'foto-3.jpg');

/* 

=================================================================================
PROCEDIMIENTOS ALMACENADOS
Por defecto estos son asociados a la base de datos actual. 
En una terminal de MySQL se ejecuta "proc_name (parametro1, parametro2, ...)"
CALL proc_name (Parametro1, Parametro2, ....);
DROP PROCEDURE IF EXISTS names;
SHOW CREATE PROCEDURE proc_name;
SHOW PROCEDURE STATUS LIKE 'actualizar_precio_producto' \G;
*************************** 1. row ***************************
                  Db: facturacion
                Name: actualizar_precio_producto
                Type: PROCEDURE
             Definer: root@localhost
            Modified: 2019-08-29 19:23:40
             Created: 2019-08-29 19:23:40
       Security_type: DEFINER
             Comment:
character_set_client: utf8
collation_connection: utf8_general_ci
  Database Collation: latin1_swedish_ci
1 row in set (0.003 sec)

ALTER PROCEDURE proc_name;
*/

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

/* Procedimiento Almacenado para grabar información a la tabla "detalle_temp" e extraer información de la misma con relación de otra tabla"*/
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
    /* Con este "Where" solo seleccionara los usuarios del sistema(Administrador, Supervisor, Vendedor) que realizaron esta Venta.*/
    
  END;$$
DELIMITER ;

/* Procedimiento Almacenado para borrar registro de la tabla "detalle_temp" 
  Una vez que borra el registro, realiza una consulta para refrescar los registros del detalle de la venta ("detalle_temp")
*/
DELIMITER $$
  CREATE PROCEDURE del_detalle_temp(id_detalle int, token varchar(50))
  BEGIN
    DELETE FROM detalle_temp WHERE correlativo = id_detalle;
    
    SELECT tmp.correlativo,tmp.codproducto,p.descripcion,tmp.cantidad,tmp.precio_venta FROM detalle_temp tmp
    INNER JOIN producto p
    ON tmp.codproducto = p.codproducto
    WHERE tmp.token_user = token;
    /* Con este "Where" solo seleccionara los usuarios del sistema(Administrador, Supervisor, Vendedor) que realizaron esta Venta.*/
    
  END;$$
DELIMITER ;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
