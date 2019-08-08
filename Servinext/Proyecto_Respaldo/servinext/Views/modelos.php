<?php
  print('<h2 class="p1">GESTION DE MODELOS</h2>');
  // Mostrara en pantalla todas los modelos al mostrar la pantalla
  $modelos_controller = new ModelosController();
  $modelos = $modelos_controller->get();
  // Devuelve un arreglo.
  if (empty($modelos))
  {
    print ('
      <div class= "container">
        <p class="item error ">NO EXISTEN MODELO</p>
      </div>
      ');
  }
  else
  {
    $template_modelos = '
      <div class="item">
        <table>
          <tr>
            <th>Id</th>
            <th>Descripcion</th>
            <th colspan="2">
              <!-- Para manipular las rutas de la aplicación, cuando se oprime el boton de "Enviar" el Router.php lee el valor de la variable global $_POST, forma parte del Table Header -->
              <form method="POST">
                <input type="hidden" name="r" value="modelos-add">
                <input class="button add" type = "submit" value="Agregar">      
              </form>              
            </th>
          </tr>
          <!-- Se generan las filas de forma dinámica.-->';
    for ($n=0;$n<count($modelos);$n++)
    {
      $template_modelos .='
         <tr>
          <td>'.$modelos[$n]['id_modelo'].'</td>
          <td>'.$modelos[$n]['descripcion' ].'</td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="modelos-edit">
              <input type="hidden" name="id_modelo" value="'.$modelos[$n]['id_modelo'].' ">
              <input class="button edit" type = "submit" value="Editar">      
            </form>                        
          </td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="modelos-delete">
              <input type="hidden" name="id_modelo" value="'.$modelos[$n]['id_modelo'].' ">
              <input class="button delete" type = "submit" value="Eliminar">      
            </form>                        
          </td>
         </tr>
      ';
    }       
    $template_modelos .='       
        </table>
      </div>    
    ';
    print($template_modelos);
  }

?>


