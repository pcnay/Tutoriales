<?php
  require('EstatusModel.php');

  echo '<h1>CRUD con MVC de la tabla * Estatus * </h1>';

  $estatus = new EstatusModel();

  // para mostrar lo que retorna la consulta en el arreglo que se asigno.
  // $estatus->read();
  // Ahora se manda un parámetro.
  $datosEstatus = $estatus->read(3);
  var_dump($datosEstatus);
?>