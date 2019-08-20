<?php
/*
Trabajando localmente y/o en otros proveedores de hosting, podrás verás que en el valor “host” siempre utilizas “localhost”. Esto es debido a que el servidor de base de datos (mysql) y el servidor web (apache) se encuentran en el mismo servidor. Aquí radica la diferencia, ya que cuenta con una infraestructura en nodos en donde tenemos separados el servidor de base de datos del servidor web.

*/
  $host = 'localhost';
  $user = 'root';
  $password = 'pcnay2003';
  $db = 'facturacion';
  $conexion = @mysqli_connect($host,$user,$password,$db);
  if (!$conexion)
  {
    //echo "Error En La Conexion";    
    die ('Error de conexion'.mysqli_connect_error());
  }
  else
  {
   
  }
?>