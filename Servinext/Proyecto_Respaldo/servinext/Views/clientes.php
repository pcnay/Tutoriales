<?php
  print('<h2 class="p1">GESTION DE CLIENTES</h2>');
  $clientes_controller = new ClientesController();
  $clientes = $clientes_controller->get();
  // Devuelve un arreglo.
  if (empty($clientes))
  {
    print ('
      <div class= "container">
        <p class="item error ">NO EXISTEN CLIENTES</p>
      </div>
      ');
  }
  else
  {
    $template_clientes = '
      <div class="item">
        <table>
          <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th colspan="2">
              <!-- Para manipular las rutas de la aplicación, cuando se oprime el boton de "Enviar" el Router.php lee el valor de la variable global $_POST, forma parte del Table Header -->
              <form method="POST">
                <input type="hidden" name="r" value="clientes-add">
                <input class="button add" type = "submit" value="Agregar">      
              </form>              
            </th>
          </tr>
          <!-- Se generan las filas de forma dinámica.-->';
    for ($n=0;$n<count($clientes);$n++)
    {
      $template_clientes .='
         <tr>
          <td>'.$clientes[$n]['id_clientes'].'</td>
          <td>'.$clientes[$n]['nombre' ].'</td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="clientes-edit">
              <input type="hidden" name="id_clientes" value="'.$clientes[$n]['id_clientes'].' ">
              <input class="button edit" type = "submit" value="Editar">      
            </form>                        
          </td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="clientes-delete">
              <input type="hidden" name="id_clientes" value="'.$clientes[$n]['id_clientes'].' ">
              <input class="button delete" type = "submit" value="Eliminar">      
            </form>                        
          </td>
         </tr>
      ';
    }       
    $template_clientes .='       
        </table>
      </div>    
    ';
    print($template_clientes);
  }

?>


