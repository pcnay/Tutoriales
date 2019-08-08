<?php
  $modelos_controller = new ModelosController();

if(($_POST['r']=='modelos-edit') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
{
  $modelos = $modelos_controller->get($_POST['id_modelo']); // Obtiene el registro del modelo en cuestion, viene del formaulario de Modelos, cuando se muestran todos.
  if (empty($modelos))
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
    // Se debe traer los datos de la pantalla para poder editarlo.
    $template_modelos = ' 
      <h2 class= "p1">Editar Modelo</h2>
      <form method = "POST" class = "item">
        <div class= "p_25">
          <input type="text" placeholder = "Id Modelo" value="%s" disabled required>
          <!-- Este valor no se pasa al Backend, cuando estan deshabilitiados, por esta razón se agrega esta linea  -->    
          <input type="hidden" name = "id_modelo" value = "%s">
        </div>
        <div class= "p_25">
          <input type="text" name="descripcion" placeholder = "Nombre Del Modelo" value="%s" required>
        </div>
        <div class="p_25">
          <input class ="button edit" type = "submit" value="Editar">           
          <input type="hidden" name = "r" value = "modelos-edit">
          <input type="hidden" name = "crud" value = "set">
        </div>
      </form>
    ';
  // Como se autoprocesa el formulario (No tiene "action"), es decir continua con el flujo de forma descendente, llegando al "else if ( ($_POST['r']=='marcas-edit') ...
   printf (
      $template_modelos,
      $modelos[0]['id_modelo'],
      $modelos[0]['id_modelo'],
      $modelos[0]['descripcion']
    );
 }

}
 else if ( ($_POST['r']=='modelos-edit') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='set'))
 {
   // Se programa la inserción de datos.
   $salvar_modelo = array(
     'id_modelo' => $_POST['id_modelo'],
     'descripcion' => $_POST['descripcion']
   );
   $modelos = $modelos_controller->set($salvar_modelo);
   $template = '
     <div class="container">
       <p class="item edit">Modelo <b>%s</b> Guardado </p>
     </div> 
     <script>
       window.onload = function()
       {
         // Recarga la pantalla de Modelo nuevamente.
         reloadPage("modelos")
       }       
     </script>
   '; 
   printf($template,$salvar_modelo['descripcion']);

 }
 else
 {
   // Para generar una vista de no autorizado.
   $controller = new ViewController();
   $controller->load_view('error401');
 }

?>