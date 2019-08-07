<?php
  print('<h2 class="p1">GESTION DE MARCAS</h2>');
  // Mostrara en pantalla todas las marcas al mostrar la pantalla
  $marcas_controller = new MarcasController();
  $marcas = $marcas_controller->get();
  // Devuelve un arreglo.
  if (empty($marcas))
  {
    print ('
      <div class= "container">
        <p class="item error ">NO EXISTEN MARCAS</p>
      </div>
      ');
  }
  else
  {
    $template_marcas = '
      <div class="item">
        <table>
          <tr>
            <th>Id</th>
            <th>Descripcion</th>
            <th colspan="2">
              <!-- Para manipular las rutas de la aplicación, cuando se oprime el boton de "Enviar" el Router.php lee el valor de la variable global $_POST, forma parte del Table Header -->
              <form method="POST">
                <input type="hidden" name="r" value="marcas-add">
                <input class="button add" type = "submit" value="Agregar">      
              </form>              
            </th>
          </tr>
          <!-- Se generan las filas de forma dinámica.-->';
    for ($n=0;$n<count($marcas);$n++)
    {
      $template_marcas .='
         <tr>
          <td>'.$marcas[$n]['id_marca'].'</td>
          <td>'.$marcas[$n]['descripcion' ].'</td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="marcas-edit">
              <input type="hidden" name="id_marca" value="'.$marcas[$n]['id_marca'].' ">
              <input class="button edit" type = "submit" value="Editar">      
            </form>                        
          </td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="marcas-delete">
              <input type="hidden" name="id_marca" value="'.$marcas[$n]['id_marca'].' ">
              <input class="button delete" type = "submit" value="Eliminar">      
            </form>                        
          </td>
         </tr>
      ';
    }       
    $template_marcas .='       
        </table>
      </div>    
    ';
    print($template_marcas);
  }

?>


