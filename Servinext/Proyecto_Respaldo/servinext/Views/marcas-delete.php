<?php
  $marcas_controller = new MarcasController();

if(($_POST['r']=='marcas-delete') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
{
  $marca = $marcas_controller->get($_POST['id_marca']); // Obtiene el registro de la marca en cuestion, viene del formulario de Marca, cuando se muestran todos.
  if (empty($marca))
  {
    $template = ' 
      <div class= "container">
          <p class="item error ">NO EXISTEN MARCA <b>%s</b></p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("marcas")
        }
      </script>
    ';
    printf($template,$_POST['id_marca']);
  }
  else
  {
    // Realiza la pregunta si se desea eliminar
    $template_marca = ' 
      <h2 class = "p1">Eliminar Marca</h2>
      <form method="POST" class="item">
        <div class="p1 f2"><!-- Aumenta el doble la letra -->
          Estas Seguro de eliminar la Marca :<mark class="p1">%s</mark>          
        </div>
        <div class="p_25">
          <input class="button delete" type ="submit" value = "SI">
          <!-- Regresa a la página anterior -->
          <input class="button add" type ="button" value = "NO" onclick="history.back()">
          <input type ="hidden" name="id_marca" value = "%s">
          <input type ="hidden" name="r" value = "marcas-delete">
          <input type ="hidden" name="crud" value = "del">
        </div>
      </form>
    ';
  // Como se autoprocesa el formulario (No tiene "action"), es decir continua con el flujo de forma descendente, llegando al "else if ( ($_POST['r']=='marcas-edit') ...
   printf (
      $template_marca,
      $marca[0]['descripcion'],
      $marca[0]['id_marca']      
    );
 }

}
 else if ( ($_POST['r']=='marcas-delete') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='del'))
 {
   // Se programa el borrado de la marca
    $marca = $marcas_controller->del($_POST['id_marca']);
   $template = '
     <div class="container">
       <p class="item delete">Marca <b>%s</b> Borrada </p>
     </div> 
     <script>
       window.onload = function()
       {
         // Recarga la pantalla de Marca nuevamente.
         reloadPage("marcas")
       }       
     </script>
   '; 
   printf($template,$_POST['id_marca']);

 }
 else
 {
   // Para generar una vista de no autorizado.
   $controller = new ViewController();
   $controller->load_view('error401');
 }

?>

