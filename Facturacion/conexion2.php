<?php
  $host = 'localhost';
  $user = 'root';
  $password = 'nay-2@@3';
  $db = 'facturacion';
  $conexion = @mysqli_connect($host,$user,$password,$db);
  if (!$conexion)
  {
		//echo "Error En La Conexion";    
		die ('Error de conexion'.mysqli_connect_error());
    
  }
  else
   {
     echo "Conectado Correctamente";	
   }

?>
