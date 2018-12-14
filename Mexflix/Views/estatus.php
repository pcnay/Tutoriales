<?php
  print('<h2 class="p1">GESTION DE ESTATUS</h2>');
  $estatus_controller = new EstatusController(); // Para accesar al CRUD de la tabla "Estatus".
  $estatus = $estatus_controller->get(); // Obtiene todos los valores de la tabla "Estatus", en arreglo asociativo.
  if (empty($estatus))
  {
    print('
      <div class = "container">
        <p class = "item error" >NO hay Estatus </p>
      </div>');
  }
  else
  {
    $template_estatus = ' 
      <div class = "item">
        <table>
          <tr>
            <th>ID</th>
            <th>ESTATUS</th>
            <th colspan="2"> <!-- Para que abarque dos celdas, por los botones de "Editar" y "Borrar" -->
              <form method ="POST"> 
                <!-- Se agrega un boton "hidden" para pasarlo cuando se oprime el boton de "Agregar" -->
                <input type ="hidden" name = "r" value ="estatus-add">
                 <input class ="button add" type = "submit" value ="Agregar">                             
              </form>
            </th>
          </tr>';
          // Se obtiene los datos de la tabla de "Estatus" de forma dinámica, para ser desplegados
      // Por cada renglon que se despliegue se muestra un boton de "Editar" y "Borrar".
      for ($n=0;$n < count($estatus); $n++)
      {
        $template_estatus .= ' 
          <tr>
            <td>'.$estatus[$n]['estatus_id'].'</td> 
            <td>'.$estatus[$n]['estatus'].'</td> 
            <td>
              <form method ="POST"> 
                <!-- Se agrega un boton "hidden" para pasarlo cuando se oprime el boton de "Editar". NO se ve para el usuario pero los programadores lo utilizan para mandar información de las rutas (directorios que se accesan) -->
                <input type ="hidden" name = "r" value ="estatus-edit">
                <input type ="hidden" name = "estatus_id" value ="'.$estatus[$n]['estatus_id'].'">
                <input class ="button edit" type = "submit" value ="Editar">                             
              </form>        
            </td>         
            <td>
              <form method ="POST"> 
                <!-- Se agrega un boton "hidden" para pasarlo cuando se oprime el boton de "Borrar". NO se ve para el usuario pero los programadores lo utilizan para mandar información de las rutas (directorios que se accesan) -->
                <input type ="hidden" name = "r" value ="estatus-delete">
                <input type ="hidden" name = "estatus_id" value ="'.$estatus[$n]['estatus_id'].'">
                <input class ="button delete" type = "submit" value ="Eliminar">                             
              </form>        
            </td>

          </tr>
          ';
      }
      
      $template_estatus .= '

        </table>
      </div>
    ';

    print($template_estatus);
  }
?>
