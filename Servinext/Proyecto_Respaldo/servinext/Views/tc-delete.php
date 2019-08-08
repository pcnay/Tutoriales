<?php
  $tc_controller = new TcController();

if(($_POST['r']=='tc-delete') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
{
  $tc = $tc_controller->get($_POST['id_tipo_componente']); // Obtiene el registro de la marca en cuestion, viene del formulario de Marca, cuando se muestran todos.
  if (empty($tc))
  {
    $template = ' 
      <div class= "container">
          <p class="item error ">NO EXISTEN TIPO COMPONENTE <b>%s</b></p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("tc")
        }
      </script>
    ';
    printf($template,$_POST['id_tipo_componente']);
  }
  else
  {
    // Realiza la pregunta si se desea eliminar
    $template_tc = ' 
      <h2 class = "p1">Eliminar Tipo Componente</h2>
      <form method="POST" class="item">
        <div class="p1 f2"><!-- Aumenta el doble la letra -->
          Estas Seguro de eliminar el Tipo De Componente :<mark class="p1">%s</mark>          
        </div>
        <div class="p_25">
          <input class="button delete" type ="submit" value = "SI">
          <!-- Regresa a la página anterior -->
          <input class="button add" type ="button" value = "NO" onclick="history.back()">
          <input type ="hidden" name="id_tipo_componente" value = "%s">
          <input type ="hidden" name="r" value = "tc-delete">
          <input type ="hidden" name="crud" value = "del">
        </div>
      </form>
    ';
  // Como se autoprocesa el formulario (No tiene "action"), es decir continua con el flujo de forma descendente, llegando al "else if ( ($_POST['r']=='tc-delete') ...
   printf (
      $template_tc,
      $tc[0]['descripcion'],
      $tc[0]['id_tipo_componente']      
    );
 }

}
 else if ( ($_POST['r']=='tc-delete') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='del'))
 {
   // Se programa el borrado de la marca
    $tc = $tc_controller->del($_POST['id_tipo_componente']);
   $template = '
     <div class="container">
       <p class="item delete">Tipo Componente <b>%s</b> Borrado </p>
     </div> 
     <script>
       window.onload = function()
       {
         // Recarga la pantalla de Tipo Componente nuevamente.
         reloadPage("tc")
       }       
     </script>
   '; 
   printf($template,$_POST['id_tipo_componente']);

 }
 else
 {
   // Para generar una vista de no autorizado.
   $controller = new ViewController();
   $controller->load_view('error401');
 }

?>

