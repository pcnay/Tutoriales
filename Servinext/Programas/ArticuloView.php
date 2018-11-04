<?php
  require('ArticuloModel.php');

  echo '<h1>CRUD con MVC de la tabla * Articulos * </h1>';

  $articulo = new ArticuloModel();

  // para mostrar lo que retorna la consulta en el arreglo que se asigno.
  // $articulo->read();
  // Ahora se manda un parámetro.
  $datosArticulo = $articulo->read();
  var_dump($datosArticulo);
?>