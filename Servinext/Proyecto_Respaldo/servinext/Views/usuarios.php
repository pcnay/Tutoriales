<?php
  print('<h2 class="p1">GESTION DE USUARIOS</h2>');
  $usuarios_controller = new UsuariosController();
  $usuarios = $usuarios_controller->get();
  // Devuelve un arreglo.
  if (empty($usuarios))
  {
    print ('
      <div class= "container">
        <p class="item error ">NO EXISTEN USUARIOS</p>
      </div>
      ');
  }
  else
  {
    $template_usuarios = '
      <div class="item">
        <table>
          <tr>
            <th>Usuario</th>
            <th>Email</th>
            <th>Nombre</th>
            <th>Cumpleaños</th>
            <th>Clave</th>
            <th>Perfil</th>
            <th colspan="2">
              <!-- Para manipular las rutas de la aplicación, cuando se oprime el boton de "Enviar" el Router.php lee el valor de la variable global $_POST, forma parte del Table Header -->
              <form method="POST">
                <input type="hidden" name="r" value="usuarios-add">
                <input class="button add" type = "submit" value="Agregar">      
              </form>              
            </th>
          </tr>
          <!-- Se generan las filas de forma dinámica.-->';
    for ($n=0;$n<count($usuarios);$n++)
    {
      $template_usuarios .='
         <tr>
          <td>'.$usuarios[$n]['usuario'].'</td>
          <td>'.$usuarios[$n]['email' ].'</td>
          <td>'.$usuarios[$n]['nombre' ].'</td>
          <td>'.$usuarios[$n]['cumpleanos' ].'</td>
          <td>'.$usuarios[$n]['clave' ].'</td>
          <td>'.$usuarios[$n]['perfil' ].'</td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="usuarios-edit">
              <input type="hidden" name="id_usuarios" value="'.$usuarios[$n]['usuario'].' ">
              <input class="button edit" type = "submit" value="Editar">      
            </form>                        
          </td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="usuarios-delete">
              <input type="hidden" name="id_usuarios" value="'.$usuarios[$n]['usuario'].' ">
              <input class="button delete" type = "submit" value="Eliminar">      
            </form>                        
          </td>
         </tr>
      ';
    }       
    $template_usuarios .='       
        </table>
      </div>    
    ';
    print($template_usuarios);
  }

?>
