<?php
  require('ArticuloModel.php');

  echo '<h1>CRUD con MVC de la tabla * Articulos * </h1>';

  $articulo = new ArticuloModel();

  // para mostrar lo que retorna la consulta en el arreglo que se asigno.
  // $articulo->read();
  // Ahora se manda un parámetro.
  $datosArticulo = $articulo->read();
  //var_dump($datosArticulo);

// Obteniendo el número total de registros del arreglo.
$num_articulos = count($datosArticulo);

echo '<h2>Número total de elementos del arreglo <mark>'.$num_articulos.'</mark></h2>';
echo "<h2>Número total de elementos del arreglo <mark> $num_articulos </mark></h2>";

echo '<h2>Tabla de Articulos </h2>';
echo '<table> 
        <tr>
          <th>Articulo_id</th>
          <th>Descripcion</th>                        
          <th>Marca</th>
          <th>Modelo</th>
          <th>Num. Serie</th>
          <th>Num_Parte</th>
          <th>Existencia</th>              
        </tr>';
// Se desplegara el contenido del arrelgo.
        for ($n=0; $n<$num_articulos; $n++)
        {
          echo '<tr>
                  <td>'.$datosArticulo[$n]['articulo_id'].'</td>
                  <td>'.$datosArticulo[$n]['descripcion'].'</td>                        
                  <td>'.$datosArticulo[$n]['marca'].'</td>                                          
                  <td>'.$datosArticulo[$n]['modelo'].'</td>
                  <td>'.$datosArticulo[$n]['num_serial'].'</td> 
                  <td>'.$datosArticulo[$n]['num_parte'].'</td>                                                                <td>'.$datosArticulo[$n]['existencia'].'</td>                               
                </tr>';
        };
echo  '</table>';

?>
