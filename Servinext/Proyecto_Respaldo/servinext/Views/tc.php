<?php
  print('<h2 class="p1">GESTION DE TIPO COMPONENTES</h2>');
  // Mostrara en pantalla todas las marcas al mostrar la pantalla
  $tc_controller = new TcController();
  $tc = $tc_controller->get();
  // Devuelve un arreglo.
  if (empty($tc))
  {
    print ('
      <div class= "container">
        <p class="item error ">NO EXISTEN TIPO COMPONENTE</p>
      </div>
      ');
  }
  else
  {
    $template_tc = '
      <div class="item">
        <table>
          <tr>
            <th>Id</th>
            <th>Descripcion</th>
            <th colspan="2">
              <!-- Para manipular las rutas de la aplicación, cuando se oprime el boton de "Enviar" el Router.php lee el valor de la variable global $_POST, forma parte del Table Header -->
              <form method="POST">
                <input type="hidden" name="r" value="tc-add">
                <input class="button add" type = "submit" value="Agregar">      
              </form>              
            </th>
          </tr>
          <!-- Se generan las filas de forma dinámica.-->';
    for ($n=0;$n<count($tc);$n++)
    {
      $template_tc .='
         <tr>
          <td>'.$tc[$n]['id_tipo_componente'].'</td>
          <td>'.$tc[$n]['descripcion' ].'</td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="tc-edit">
              <input type="hidden" name="id_tipo_componente" value="'.$tc[$n]['id_tipo_componente'].' ">
              <input class="button edit" type = "submit" value="Editar">      
            </form>                        
          </td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="tc-delete">
              <input type="hidden" name="id_tipo_componente" value="'.$tc[$n]['id_tipo_componente'].' ">
              <input class="button delete" type = "submit" value="Eliminar">      
            </form>                        
          </td>
         </tr>
      ';
    }       
    $template_tc .='       
        </table>
      </div>    
    ';
    print($template_tc);
  }

?>


