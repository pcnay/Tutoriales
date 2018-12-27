<?php
  print('<h2 class="p1">GESTION DE MOVIESERIES</h2>');
  $ms_controller = new MovieSeriesController(); // Para accesar al CRUD de la tabla "Estatus".
  $ms = $ms_controller->get(); // Obtiene todos los valores de la tabla "Estatus", en arreglo asociativo.
  if (empty($ms))
  {
    print('
      <div class = "container">
        <p class = "item error" >NO hay MovieSeries</p>
      </div>');
  }
  else
  {
    $template_ms = ' 
      <div class = "item">
        <!-- Solo se mostraran algunos campos en la tabla, se agrega un boton para "mostrar" toda la información. -->
        <table>
          <tr>
            <th>IMDB Id</th>
            <th>TITULO</th>
            <th>ESTRENO</th>
            <th>GENEROS</th>
            <th>ESTATUS</th>
            <th>CATGORIA</th>

            <th colspan="3"> <!-- Para que abarque tres celdas, por los botones de "Editar", "mostrar y "Borrar" -->
              <form method ="POST"> 
                <!-- Se agrega un boton "hidden" para pasarlo cuando se oprime el boton de "Agregar" -->
                <input type ="hidden" name = "r" value ="movieseries-add">
                 <input class ="button add" type = "submit" value ="Agregar">                             
              </form>
            </th>
          </tr>';
          // Se obtiene los datos de la tabla de "Estatus" de forma dinámica, para ser desplegados
      // Por cada renglon que se despliegue se muestra un boton de "Editar" y "Borrar".
      for ($n=0;$n < count($ms); $n++)
      {
        $template_ms .= ' 
          <tr>
            <td>'.$ms[$n]['imdb_id'].'</td> 
            <td>'.$ms[$n]['title'].'</td> 
            <td>'.$ms[$n]['premiere'].'</td> 
            <td>'.$ms[$n]['genres'].'</td> 
            <td>'.$ms[$n]['estatus'].'</td> 
            <td>'.$ms[$n]['category'].'</td> 
            <td>            
              <form method ="POST"> 
                <!-- Se agrega un boton "hidden" para pasarlo cuando se oprime el boton de "Editar". NO se ve para el usuario pero los programadores lo utilizan para mandar información de las rutas (directorios que se accesan) -->
                <input type ="hidden" name = "r" value ="movieseries-show">
                <input type ="hidden" name = "imdb_id" value ="'.$ms[$n]['imdb_id'].'">
                <input class ="button show" type = "submit" value ="Mostrar">                             
              </form>        
            </td>         

            <td>            
              <form method ="POST"> 
                <!-- Se agrega un boton "hidden" para pasarlo cuando se oprime el boton de "Editar". NO se ve para el usuario pero los programadores lo utilizan para mandar información de las rutas (directorios que se accesan) -->
                <input type ="hidden" name = "r" value ="movieseries-edit">
                <input type ="hidden" name = "imdb_id" value ="'.$ms[$n]['imdb_id'].'">
                <input class ="button edit" type = "submit" value ="Editar">                             
              </form>        
            </td>         
            <td>
              <form method ="POST"> 
                <!-- Se agrega un boton "hidden" para pasarlo cuando se oprime el boton de "Borrar". NO se ve para el usuario pero los programadores lo utilizan para mandar información de las rutas (directorios que se accesan) -->
                <input type ="hidden" name = "r" value ="movieseries-delete">
                <input type ="hidden" name = "imdb_id" value ="'.$ms[$n]['imdb_id'].'">
                <input class ="button delete" type = "submit" value ="Eliminar">                             
              </form>        
            </td>

          </tr>
          ';
      }
      
      $template_ms .= '

        </table>
      </div>
    ';

    print($template_ms);
  }
?>
