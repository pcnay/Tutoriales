<?php
  print('<h2 class="p1">GESTION DE USUARIOS</h2>');
  $users_controller = new UsersController(); // Para accesar al CRUD de la tabla "Estatus".
  $users = $users_controller->get(); // Obtiene todos los valores de la tabla "Estatus", en arreglo asociativo.
  if (empty($users))
  {
    print('
      <div class = "container">
        <p class = "item error" >NO hay Usuarios </p>
      </div>');
  }
  else
  {
    $template_users = ' 
      <div class = "item">
        <table>
          <tr>
            <th>USUARIO</th>
            <th>CORREO</th>
            <th>NOMBRE</th>
            <th>CUMPLEAÑOS</th>
            <th>CONTRASEÑA</th>
            <th>ROL</th>

            <th colspan="2"> <!-- Para que abarque dos celdas, por los botones de "Editar" y "Borrar" -->
              <form method ="POST"> 
                <!-- Se agrega un boton "hidden" para pasarlo cuando se oprime el boton de "Agregar" -->
                <input type ="hidden" name = "r" value ="users-add">
                 <input class ="button add" type = "submit" value ="Agregar">                             
              </form>
            </th>
          </tr>';
          // Se obtiene los datos de la tabla de "Estatus" de forma dinámica, para ser desplegados
      // Por cada renglon que se despliegue se muestra un boton de "Editar" y "Borrar".
      for ($n=0;$n < count($users); $n++)
      {
        $template_users .= ' 
          <tr>
            <td>'.$users[$n]['user'].'</td> 
            <td>'.$users[$n]['email'].'</td> 
            <td>'.$users[$n]['names'].'</td> 
            <td>'.$users[$n]['birthday'].'</td> 
            <td>'.$users[$n]['pass'].'</td> 
            <td>'.$users[$n]['roles'].'</td> 
            <td>
              <form method ="POST"> 
                <!-- Se agrega un boton "hidden" para pasarlo cuando se oprime el boton de "Editar". NO se ve para el usuario pero los programadores lo utilizan para mandar información de las rutas (directorios que se accesan) -->
                <input type ="hidden" name = "r" value ="users-edit">
                <input type ="hidden" name = "user" value ="'.$users[$n]['user'].'">
                <input class ="button edit" type = "submit" value ="Editar">                             
              </form>        
            </td>         
            <td>
              <form method ="POST"> 
                <!-- Se agrega un boton "hidden" para pasarlo cuando se oprime el boton de "Borrar". NO se ve para el usuario pero los programadores lo utilizan para mandar información de las rutas (directorios que se accesan) -->
                <input type ="hidden" name = "r" value ="users-delete">
                <input type ="hidden" name = "user" value ="'.$users[$n]['user'].'">
                <input class ="button delete" type = "submit" value ="Eliminar">                             
              </form>        
            </td>

          </tr>
          ';
      }
      
      $template_users .= '

        </table>
      </div>
    ';

    print($template_users);
  }
?>
