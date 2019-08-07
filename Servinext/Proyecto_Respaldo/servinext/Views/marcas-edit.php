<?php
  $marcas_controller = new MarcasController();

if(($_POST['r']=='marcas-edit') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
{
  $marcas = $marcas_controller->get($_POST['id_marca']); // Obtiene el registro de la marca en cuestion, viene del formaulario de Marcas, cuando se muestran todos.
  if (empty($marcas))
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
    // Se debe traer los datos de la pantalla para poder editarlo.
    $template_marca = ' 
      <h2 class= "p1">Editar Marca</h2>
      <form method = "POST" class = "item">
        <div class= "p_25">
          <input type="text" placeholder = "Id de la Marca" value="%s" disabled required>
          <!-- Este valor no se pasa al Backend, cuando estan deshabilitiados, por esta razón se agrega esta linea  -->    
          <input type="hidden" name = "id_marca" value = "%s">
        </div>
        <div class= "p_25">
          <input type="text" name="descripcion" placeholder = "Nombre De La Marca" value="%s" required>
        </div>
        <div class="p_25">
          <input class ="button edit" type = "submit" value="Editar">           
          <input type="hidden" name = "r" value = "marcas-edit">
          <input type="hidden" name = "crud" value = "set">
        </div>
      </form>
    ';
  // Como se autoprocesa el formulario (No tiene "action"), es decir continua con el flujo de forma descendente, llegando al "else if ( ($_POST['r']=='marcas-edit') ...
   printf (
      $template_marca,
      $marcas[0]['id_marca'],
      $marcas[0]['id_marca'],
      $marcas[0]['descripcion']
    );
 }

}
 else if ( ($_POST['r']=='marcas-edit') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='set'))
 {
   // Se programa la inserción de datos.
   $salvar_marca = array(
     'id_marca' => $_POST['id_marca'],
     'descripcion' => $_POST['descripcion']
   );
   $marcas = $marcas_controller->set($salvar_marca);
   $template = '
     <div class="container">
       <p class="item edit">Marca <b>%s</b> Guardado </p>
     </div> 
     <script>
       window.onload = function()
       {
         // Recarga la pantalla de Marca nuevamente.
         reloadPage("marcas")
       }       
     </script>
   '; 
   printf($template,$salvar_marca['descripcion']);

 }
 else
 {
   // Para generar una vista de no autorizado.
   $controller = new ViewController();
   $controller->load_view('error401');
 }

?>