<?php
  $clientes_controller = new ClientesController();

if(($_POST['r']=='clientes-edit') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
{
  $cliente = $clientes_controller->get($_POST['id_clientes']); // Obtiene el registro del usuario en cuestion, viene del formaulario de Clientes, cuando se muestran todos.
  if (empty($cliente))
  {
    $template = ' 
      <div class= "container">
          <p class="item error ">NO EXISTEN CLIENTES <b>%s</b></p>
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
    // Se debe traer los datos de la pantalla para poder editarlo.
    $template_cliente = ' 
      <h2 class= "p1">Editar Cliente</h2>
      <form method = "POST" class = "item">
        <div class= "p_25">
          <input type="text" placeholder = "Id del Cliente" value="%s" disabled required>
          <!-- Este valor no se pasa al Backend, cuando estan deshabilitiados, por esta razón se agrega esta linea  -->    
          <input type="hidden" name = "id_clientes" value = "%s">
        </div>
        <div class= "p_25">
          <input type="text" name="nombre" placeholder = "Nombre" value="%s" required>
        </div>
        <div class="p_25">
          <input class ="button edit" type = "submit" value="Editar">           
          <input type="hidden" name = "r" value = "clientes-edit">
          <input type="hidden" name = "crud" value = "set">
        </div>
      </form>
    ';
  // Como se autoprocesa el formulario (No tiene "action"), es decir continua con el flujo de forma descendente, llegando al "else if ( ($_POST['r']=='clientes-edit') ...
   printf (
      $template_cliente,
      $cliente[0]['id_clientes'],
      $cliente[0]['id_clientes'],
      $cliente[0]['nombre']
    );
 }

}
 else if ( ($_POST['r']=='clientes-edit') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='set'))
 {
   // Se programa la inserción de datos.
   $salvar_cliente = array(
     'id_clientes' => $_POST['id_clientes'],
     'nombre' => $_POST['nombre']
   );
   $clientes = $clientes_controller->set($salvar_cliente);
   $template = '
     <div class="container">
       <p class="item edit">Cliente <b>%s</b> Guardado </p>
     </div> 
     <script>
       window.onload = function()
       {
         // Recarga la pantalla de Clientes nuevamente.
         reloadPage("clientes")
       }       
     </script>
   '; 
   printf($template,$nuevo_cliente['nombre']);

 }
 else
 {
   // Para generar una vista de no autorizado.
   $controller = new ViewController();
   $controller->load_view('error401');
 }

?>
