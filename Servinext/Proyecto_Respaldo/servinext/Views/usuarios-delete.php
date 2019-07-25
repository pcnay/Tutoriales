<?php
  $usuarios_controller = new UsuariosController();

if(($_POST['r']=='usuarios-delete') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
{
  $usuario = $usuarios_controller->get($_POST['usuario']); // Obtiene el registro del usuario en cuestion, viene del formaulario de Usuarios (boton eliminar), cuando se muestran todos.
  if (empty($usuario))
  {
    $template = ' 
      <div class= "container">
          <p class="item error ">NO EXISTEN USUARIO <b>%s</b></p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("usuarios")
        }
      </script>
    ';
    printf($template,$usuario[0]['usuario']); // $_POST['usuario']);
  }
  else
  {
    // Realiza la pregunta si se desea eliminar
    $template_usuario = ' 
      <h2 class = "p1">Eliminar Usuario</h2>
      <form method="POST" class="item">
        <div class="p1 f2"><!-- Aumenta el doble la letra -->
          Estas Seguro de eliminar el Usuario :<mark class="p1">%s</mark>          
        </div>
        <div class="p_25">
          <input class="button delete" type ="submit" value = "SI">
          <!-- Regresa a la página anterior -->
          <input class="button add" type ="button" value = "NO" onclick="history.back()">
          <input type ="hidden" name="usuario" value = "%s">
          <input type ="hidden" name="r" value = "usuarios-delete">
          <input type ="hidden" name="crud" value = "del">
        </div>
      </form>
    ';
  // Como se autoprocesa el formulario (No tiene "action"), es decir continua con el flujo de forma descendente, llegando al "else if ( ($_POST['r']=='clientes-edit') ...
   printf (
      $template_usuario,
      $usuario[0]['usuario'],
      $usuario[0]['usuario']      
    );
 }

}
 else if ( ($_POST['r']=='usuarios-delete') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='del'))
 {
   // Se programa el borrado del cliente
    $usuario = $usuarios_controller->del($_POST['usuario']); // usuario[0]['usuario']); //$_POST['usuario']);
   $template = '
     <div class="container">
       <p class="item delete">Usuario <b>%s</b> Borrado </p>
     </div> 
     <script>
       window.onload = function()
       {
         // Recarga la pantalla de Clientes nuevamente.
         reloadPage("usuarios")
       }       
     </script>
   '; 
   printf($template,$usuario[0]['usuario']);//$_POST['usuario']);

 }
 else
 {
   // Para generar una vista de no autorizado.
   $controller = new ViewController();
   $controller->load_view('error401');
 }

?>
