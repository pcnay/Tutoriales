<?php
  
  print('<h2 class="p1">GESTION DE EQUIPOS</h2>');
  // Mostrara en pantalla todos los equipos al mostrar la pantalla
  $equipos_controller = new EquiposController();
  $equipos = $equipos_controller->get();
  // Devuelve un arreglo.
  if (empty($equipos))
  {
    print ('
      <div class= "container">
        <p class="item error ">NO EXISTEN EQUIPOS</p>
      </div>
      ');
  }
  else
  {
    $template_equipos = '
      <div class="item">
        <table>
          <tr>
            <th>Id</th>
            <th>Num. Serie</th>
            <th>Num. Inv</th>
            <th>Num. Parte</th>
            <th>Tipo Componente</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Existencia</th>
            <th colspan="2">
              <!-- Para manipular las rutas de la aplicación, cuando se oprime el boton de "Enviar" el Router.php lee el valor de la variable global $_POST, forma parte del Table Header -->
              <form method="POST">
                <input type="hidden" name="r" value="equipos-add">
                <input class="button add" type = "submit" value="Agregar">      
              </form>              
            </th>
          </tr>
          <!-- Se generan las filas de forma dinámica.-->';
    for ($n=0;$n<count($equipos);$n++)
    {
      $template_equipos .='
         <tr>
          <td>'.$equipos[$n]['id_epo'].'</td>
          <td>'.$equipos[$n]['num_serie' ].'</td>
          <td>'.$equipos[$n]['num_inv' ].'</td>
          <td>'.$equipos[$n]['num_parte' ].'</td>
          <td>'.$equipos[$n]['componente' ].'</td>
          <td>'.$equipos[$n]['marca' ].'</td>
          <td>'.$equipos[$n]['modelo' ].'</td>
          <td>'.$equipos[$n]['existencia' ].'</td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="equipos-edit">
              <input type="hidden" name="id_epo" value="'.$equipos[$n]['id_epo'].' ">
              <input class="button edit" type = "submit" value="Editar">      
            </form>                        
          </td>
          <td>
            <form method="POST">
              <input type="hidden" name="r" value="equipos-delete">
              <input type="hidden" name="id_epo" value="'.$equipos[$n]['id_epo'].' ">
              <input class="button delete" type = "submit" value="Eliminar">      
            </form>                        
          </td>
         </tr>
      ';
    }       
    $template_equipos .='       
        </table>
      </div>    
    ';
    print($template_equipos);
  }

?>


