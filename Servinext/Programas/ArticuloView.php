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
                  <td>'.$datosArticulo[$n]['num_parte'].'</td>
                  <td>'.$datosArticulo[$n]['existencia'].'</td>                               
                </tr>';
        };
echo  '</table>';

echo 'Insertando registros';
  // En el modelo se define que se pasara como parametro un arreglo ques será asociativo
  $articulo_dato = array(
    'articulo_id' => 0, // Automaticamente se le asigna el siguiente número.
    'descripcion' => 'Impresora',
    'marca' => 'Okidata',
    'modelo' => 'Oki-4590',
    'num_serial' => 'MX34293842',
    'num_parte' => '4034590T',
    'existencia' => 9
  );

  
    //Invocando el método para insertar registros del modelo.php
    //var_dump($articulo_dato);
    $articulo->create($articulo_dato);

  echo '<h2>ACTUALIZANDO UN REGISTRO </h2>';

  $actualizar_articulo = array(
    'articulo_id' => 3, 
    'descripcion' => 'Cambiado Reg. 3',
    'marca' => 'HP',
    'modelo' => 'c3456',
    'num_serial' => 'MKJFJDE930',
    'num_parte' => 'r6743aHP',
    'existencia' => 20
  );
  
  $articulo->update($actualizar_articulo);

  echo '<h2>Eliminando un Registro</h2>';
  $articulo->delete(9);

?>
