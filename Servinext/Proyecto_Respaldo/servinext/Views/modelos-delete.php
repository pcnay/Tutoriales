<?php
  $modelos_controller = new ModelosController();

if(($_POST['r']=='modelos-delete') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
{
  $modelo = $modelos_controller->get($_POST['id_modelo']); // Obtiene el registro de la marca en cuestion, viene del formulario de Modelo, cuando se muestran todos.
  if (empty($modelo))
  {
    $template = ' 
      <div class= "container">
          <p class="item error ">NO EXISTEN MODELO <b>%s</b></p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("modelos")
        }
      </script>
    ';
    printf($template,$_POST['id_modelo']);
  }
  else
  {
    // Realiza la pregunta si se desea eliminar
    $template_modelo = ' 
      <h2 class = "p1">Eliminar Modelo</h2>
      <form method="POST" class="item">
        <div class="p1 f2"><!-- Aumenta el doble la letra -->
          Estas Seguro de eliminar el Modelo :<mark class="p1">%s</mark>          
        </div>
        <div class="p_25">
          <input class="button delete" type ="submit" value = "SI">
          <!-- Regresa a la página anterior -->
          <input class="button add" type ="button" value = "NO" onclick="history.back()">
          <input type ="hidden" name="id_modelo" value = "%s">
          <input type ="hidden" name="r" value = "modelos-delete">
          <input type ="hidden" name="crud" value = "del">
        </div>
      </form>
    ';
  // Como se autoprocesa el formulario (No tiene "action"), es decir continua con el flujo de forma descendente, llegando al "else if ( ($_POST['r']=='modelos-edit') ...
   printf (
      $template_modelo,
      $modelo[0]['descripcion'],
      $modelo[0]['id_modelo']      
    );
 }

}
 else if ( ($_POST['r']=='modelos-delete') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='del'))
 {
   // Se programa el borrado de la modelo
    $modelo = $modelos_controller->del($_POST['id_modelo']);
   $template = '
     <div class="container">
       <p class="item delete">Modelo <b>%s</b> Borrada </p>
     </div> 
     <script>
       window.onload = function()
       {
         // Recarga la pantalla de Modelo nuevamente.
         reloadPage("modelos")
       }       
     </script>
   '; 
   printf($template,$_POST['id_modelo']);

 }
 else
 {
   // Para generar una vista de no autorizado.
   $controller = new ViewController();
   $controller->load_view('error401');
 }

?>

