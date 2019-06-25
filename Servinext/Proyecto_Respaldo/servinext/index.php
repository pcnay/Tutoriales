<?php
	require_once('./Controllers/Autoload.php');
	$autoload = new AutoLoad();
	//echo '<h1>Bienvenido al Sistema Control de SGI</h1>';
	$route= (isset($_GET['r']))?$_GET['r']:'home';
	
	$scs = new Router($route);
	$a = new ClientesModel();
	

/* Para cambiar el directorio por defecto en el Servidor Web se tiene que modificar el archivo : 
	Nano /etc/apache2/sites-enabled/000-default.conf 

	La carpeta donde se guardaran los archivos de “.html”, “.php” es : /home/soporte/proyectos/tutoriales/servinext


require('./Clientes/ClientesController.php');
echo '<h1>CRUD con MVC de la Tabla Clientes.</h1>';
$cliente = new ClientesController();
//echo 'Otro mensajes';
$clientes_datos = $cliente->read(); // Muestra toda la tabla
//$clientes_datos = $cliente->read(2);
var_dump($clientes_datos);

$num_clientes = count($clientes_datos);
//echo '<h2>Numero de clientes <mark>'.$num_clientes.'</mark>';
echo "<h2>Numero de clientes <mark>$num_clientes</mark>";

echo '<h2>Tabla de clientes</h2>';
echo 
'<table>
	<tr>
		<th>Id Cliente</th>
		<th>Nombre</th>
	</tr>';
	for ($n=0;$n<$num_clientes;$n++)
	{
		echo
			'<tr>
				<td>'.$clientes_datos[$n]['id_clientes'] .'</td>
				<td>'.$clientes_datos[$n]['nombre'] .'</td>
			</tr>';
	}
echo '</table>';

echo '<h2>Insertando clientes</h2>';
$nuevo_cliente = array(
	'id_clientes' =>0, // Para que agrege automaticamente el id_cliente.
	'nombre' => 'Televisa'
);
//$cliente->create($nuevo_cliente);

echo '<h2>Actualizando clientes</h2>';
$actualiza_cliente = array(
	'id_clientes' =>7, // Para que agrege automaticamente el id_cliente.
	'nombre' => 'Compartamos Banco'
);
$cliente->update($actualiza_cliente);

echo '<h2>Borrando clientes</h2>';
$cliente->delete(5);
*/

?>
