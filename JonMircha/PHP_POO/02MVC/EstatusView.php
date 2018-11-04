<?php
  require('EstatusModel.php');

  echo '<h1>CRUD con MVC de la tabla * Estatus * </h1>';

  $estatus = new EstatusModel();

  // para mostrar lo que retorna la consulta en el arreglo que se asigno.
  // $estatus->read();
  // Ahora se manda un parámetro.
  $datosEstatus = $estatus->read(3); // Enlace de Modelo con la Vista, no es la forma adecuada mas adelante de adaptara correctamente.
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

?>