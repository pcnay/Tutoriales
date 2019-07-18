<?php
  $clientes_controller = new ClientesController();

if(($_POST['r']=='clientes-delete') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
{
  $cliente = $clientes_controller->get($_POST['id_clientes']); // Obtiene el registro del usuario en cuestion, viene del formaulario de Clientes, cuando se muestran todos.
  if (empty($cliente))
  {
    $template = ' 
      <div class= "container">
          <p class="item error ">NO EXISTEN CLIENTE <b>%s</b></p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("clientes")
        }
      </script>
    ';
    printf($template,$_POST['id_clientes']);
  }
  else
  {
    // Realiza la pregunta si se desea eliminar
    $template_cliente = ' 
      <h2 class = "p1">Eliminar Cliente</h2>
      <form method="POST" class="item">
        <div class="p1 f2"><!-- Aumenta el doble la letra -->
          Estas Seguro de eliminar el Cliente :<mark class="p1">%s</mark>          
        </div>
        <div class="p_25">
          <input class="button delete" type ="submit" value = "SI">
          <!-- Regresa a la página anterior -->
          <input class="button add" type ="button" value = "NO" onclick="history.back()">
          <input type ="hidden" name="id_clientes" value = "%s">
          <input type ="hidden" name="r" value = "clientes-delete">
          <input type ="hidden" name="crud" value = "del">
        </div>
      </form>
    ';
  // Como se autoprocesa el formulario (No tiene "action"), es decir continua con el flujo de forma descendente, llegando al "else if ( ($_POST['r']=='clientes-edit') ...
   printf (
      $template_cliente,
      $cliente[0]['nombre'],
      $cliente[0]['id_clientes']      
    );
 }

}
 else if ( ($_POST['r']=='clientes-delete') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='del'))
 {
   // Se programa el borrado del cliente
    $clientes = $clientes_controller->del($_POST['id_clientes']);
   $template = '
     <div class="container">
       <p class="item delete">Cliente <b>%s</b> Borrado </p>
     </div> 
     <script>
       window.onload = function()
       {
         // Recarga la pantalla de Clientes nuevamente.
         reloadPage("clientes")
       }       
     </script>
   '; 
   printf($template,$_POST['id_clientes']);

 }
 else
 {
   // Para generar una vista de no autorizado.
   $controller = new ViewController();
   $controller->load_view('error401');
 }

?>
