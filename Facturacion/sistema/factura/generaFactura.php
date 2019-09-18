<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	session_start();
	// Solo tienen acceso las personas que tengan una sesion activa. Para evitar que cualquiera accese, solo los que estan con sesion en el sistema.
	if(empty($_SESSION['active']))
	{
		header('location: ../');
	}

	// se regresan dos niveles para llegar a "conexion.php"
	include "../../conexion.php";
	require_once '../pdf/vendor/autoload.php';
	// "autoload.php" = Cargará todos los archivos que se requiera para la generacion del PDF.
	use Dompdf\Dompdf;

	// estos parámetros se envian por medio de la funcion : generaPDF de "functions.js"
	// $url = 'factura/generaFactura.php?cl='+cliente+'&f='+factura;
	// Para mostrar la ventana :  window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
	// $_REQUEST[], lee "POST" y "GET"
	if(empty($_REQUEST['cl']) || empty($_REQUEST['f']))
	{
		echo "No es posible generar la factura.";
	}
	else
	{
		$codCliente = $_REQUEST['cl'];
		$noFactura = $_REQUEST['f'];
		$anulada = '';

		$query_config   = mysqli_query($conexion,"SELECT * FROM configuracion");
		$result_config  = mysqli_num_rows($query_config);
		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
		}

		// En la tabla de "Factura" tiene almacenado como Fecha y Hora, por lo que se extrae por separado, y demás datos de la factura.
		
		$query = mysqli_query($conexion,"SELECT f.nofactura, DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(f.fecha,'%H:%i:%s') as  hora, f.codcliente, f.estatus,
												 v.nombre as vendedor,
												 cl.nit, cl.nombre, cl.telefono,cl.direccion
											FROM factura f
											INNER JOIN usuario v
											ON f.usuario = v.idusuario
											INNER JOIN cliente cl
											ON f.codcliente = cl.idcliente
											WHERE f.nofactura = $noFactura AND f.codcliente = $codCliente  AND f.estatus != 10 ");
// estatus = 10, es factura eliminada

		$result = mysqli_num_rows($query);
		if($result > 0){

			$factura = mysqli_fetch_assoc($query);
			$no_factura = $factura['nofactura'];

			if($factura['estatus'] == 2){
				// Se asigna una etiqueta a una variable, este es un archivo que tiene la leyenda en diagonal en toda la hoja "ANULADA" de color rojo.
				$anulada = '<img class="anulada" src="img/anulado.png" alt="Anulada">';
			}
			// Obtiene el detalle de la Venta.
			$query_productos = mysqli_query($conexion,"SELECT p.descripcion,dt.cantidad,dt.precio_venta,(dt.cantidad * dt.precio_venta) as precio_total
														FROM factura f
														INNER JOIN detallefactura dt
														ON f.nofactura = dt.nofactura
														INNER JOIN producto p
														ON dt.codproducto = p.codproducto
														WHERE f.nofactura = $no_factura ");
			$result_detalle = mysqli_num_rows($query_productos);
 
			ob_start(); // Prepara y se carga en memoria el siguiente archivo "factura.php"
				include(dirname('__FILE__').'/factura.php'); // Accede a la ruta completa donde se encuentra el archivo "factura.php" -> /var/www/html/facturacion/sistema/factura/.
				//Como estan en memoria el archivo "factura.php" ya se puede accesar a las variables, arreglos que contenga, ya que es como si esta continuando en esta parte "include"
				$html = ob_get_clean(); // Carga el todo el archivo "factura.php" en su formato HTML.
				

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF,
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('factura_'.$noFactura.'.pdf',array('Attachment'=>0));
			exit;
		}
	}

?>