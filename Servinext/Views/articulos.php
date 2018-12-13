<?php
  print('<h2 class="p1">GESTION DE ARTICULOS</h2>');
  $articulo_controller = new ArticuloController(); // Para accesar al CRUD de la tabla "Articulos".
  $articulo = $articulo_controller->get(); // Obtiene todos los valores de la tabla "Articulos", en arreglo asociativo.
  if (empty($articulo))
  {
    print('
      <div class = "container">
        <p class = "item error" >NO hay Artíuclos </p>
      </div>');
  }


?>
