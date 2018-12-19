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
  else
  {
    $template_articulo = ' 
      <div class = "item">
        <table>
          <tr>
            <th>ID</th>
            <th>DESCRIPCION</th>
            <th>MARCA</th>
            <th>MODELO</th>
            <th>NUM SERIE</th>
            <th>NUM PARTE</th>
            <th>EXISTENCIA</th>
            <th>SR</th>
            <th>HISTORIAL</th>
            <th colspan="2"> <!-- Para que abarque dos celdas, por los botones de "Editar" y "Borrar" -->
              <form method ="POST"> 
                <!-- Se agrega un boton "hidden" para pasarlo cuando se oprime el boton de "Agregar" -->
                <input type ="hidden" name = "r" value ="articulo-add">
                <input class ="button add" type = "submit" value ="Agregar">                             
              </form>
            </th>
          </tr>';
      // Se obtiene los datos de la tabla de "articulos" de forma dinámica, para ser desplegados
      // Por cada renglon que se despliegue se muestra un boton de "Editar" y "Borrar".
    for ($n=0;$n < count($articulo); $n++)
      {
        $template_articulo .= ' 
          <tr>
            <td>'.$articulo[$n]['articulo_id'].'</td> 
            <td>'.$articulo[$n]['descripcion'].'</td> 
            <td>'.$articulo[$n]['marca'].'</td> 
            <td>'.$articulo[$n]['modelo'].'</td> 
            <td>'.$articulo[$n]['num_serial'].'</td>
            <td>'.$articulo[$n]['num_parte'].'</td>
            <td>'.$articulo[$n]['existencia'].'</td>
            <td>'.$articulo[$n]['sr'].'</td>
            <td>'.$articulo[$n]['historial'].'</td>      
            <td>
              <form method ="POST"> 
                <!-- Se agrega un boton "hidden" para pasarlo cuando se oprime el boton de "Editar". NO se ve para el usuario pero los programadores lo utilizan para mandar información de las rutas (directorios que se accesan) -->
                <input type ="hidden" name = "r" value ="articulo-edit">
                <input type ="hidden" name = "articulo_id" value ="'.$articulo[$n]['articulo_id'].'">
                <input class ="button edit" type = "submit" value ="Editar">                             
              </form>        
            </td>         
            <td>
              <form method ="POST"> 
                <!-- Se agrega un boton "hidden" para pasarlo cuando se oprime el boton de "Borrar". NO se ve para el usuario pero los programadores lo utilizan para mandar información de las rutas (directorios que se accesan) -->
                <input type ="hidden" name = "r" value ="articulo-delete">
                <input type ="hidden" name = "articulo_id" value ="'.$articulo[$n]['articulo_id'].'">
                <input class ="button delete" type = "submit" value ="Eliminar">                             
              </form>        
            </td>

          </tr>
          ';
      }

      $template_articulo .= '

        </table>
      </div>
    ';

    print($template_articulo);
  }
?>
