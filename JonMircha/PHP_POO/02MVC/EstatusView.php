<?php
  require('EstatusModel.php');

  echo '<h1>CRUD con MVC de la tabla * Estatus * </h1>';

  $estatus = new EstatusModel();

  // para mostrar lo que retorna la consulta en el arreglo que se asigno.
  // $estatus->read();
  // Ahora se manda un parámetro.
  $datosEstatus = $estatus->read(); // Enlace de Modelo con la Vista, no es la forma adecuada mas adelante de adaptara correctamente.
  // var_dump($datosEstatus);
  // Obteniendo el número total de registros del arreglo.
  $num_estatus = count($datosEstatus);

  echo '<h2>Número total de elementos del arreglo <mark>'.$num_estatus.'</mark></h2>';
  echo "<h2>Número total de elementos del arreglo <mark> $num_estatus </mark></h2>";

  echo '<h2>Tabla de Estatus </h2>';
  echo '<table> 
          <tr>
            <th>estatus_id</th>
            <th>estatus</th>                        
          </tr>';
  // Se desplegara el contenido del arrelgo.
          for ($n=0; $n<$num_estatus; $n++)
          {
            echo '<tr>
                    <td>'.$datosEstatus[$n]['estatus_id'].'</td>
                    <td>'.$datosEstatus[$n]['estatus'].'</td>                        
                  </tr>';
          };
  echo  '</table>';

  //echo 'Insertando registros';
  // En el modelo se define que se pasara como parametro un arreglo ques será asociativo
  $new_estatus = array(
    'estatus_id' => 0, // Automaticamente se le asigna el siguiente número.
    'estatus' => 'Otro Estatus'
  );

  // Invocando el método para insertar registros del modelo.php
  // $estatus->create($new_estatus);

  echo '<h2>ACTUALIZANDO UN REGISTRO </h2>';

  $actualizar_estatus = array(
    'estatus_id' => 3, // Automaticamente se le asigna el siguiente número.
    'estatus' => ' Otro Estatus cambiado a 3'
  );
  
  $estatus->update($actualizar_estatus);

  echo '<h2>Eliminando un Registro</h2>';
  $estatus->delete(6);
  
?>