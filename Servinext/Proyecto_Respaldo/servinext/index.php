<?php
/* Para cambiar el directorio por defecto en el Servidor Web se tiene que modificar el archivo : 
	Nano /etc/apache2/sites-enabled/000-default.conf 

	La carpeta donde se guardaran los archivos de “.html”, “.php” es : /home/soporte/proyectos/tutoriales/servinext
*/

require('./Clientes/ClientesModel.php');
echo '<h1>CRUD con MVC de la Tabla Clientes.</h1>';
$cliente = new ClientesModel();
//echo 'Otro mensajes';
//$clientes_datos = $cliente->read(); Muestra toda la tabla
//$clientes_datos = $cliente->read(2);
var_dump($clientes_datos);

?>
