<?php
  $tc_controller = new TcController();

if(($_POST['r']=='tc-edit') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
{
  $tc = $tc_controller->get($_POST['id_tipo_componente']); // Obtiene el registro del tipo componente en cuestion, viene del formaulario de Tipo Componentes, cuando se muestran todos.
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
    // Se debe traer los datos de la pantalla para poder editarlo.
    $template_tc = ' 
      <h2 class= "p1">Editar Tipo Componente</h2>
      <form method = "POST" class = "item">
        <div class= "p_25">
          <input type="text" placeholder = "Id Tipo Componente" value="%s" disabled required>
          <!-- Este valor no se pasa al Backend, cuando estan deshabilitiados, por esta razón se agrega esta linea  -->    
          <input type="hidden" name = "id_tipo_componente" value = "%s">
        </div>
        <div class= "p_25">
          <input type="text" name="descripcion" placeholder = "Nombre Del Componente" value="%s" required>
        </div>
        <div class="p_25">
          <input class ="button edit" type = "submit" value="Editar">           
          <input type="hidden" name = "r" value = "tc-edit">
          <input type="hidden" name = "crud" value = "set">
        </div>
      </form>
    ';
  // Como se autoprocesa el formulario (No tiene "action"), es decir continua con el flujo de forma descendente, llegando al "else if ( ($_POST['r']=='tc-edit') ...
   printf (
      $template_tc,
      $tc[0]['id_tipo_componente'],
      $tc[0]['id_tipo_componente'],
      $tc[0]['descripcion']
    );
 }

}
 else if ( ($_POST['r']=='tc-edit') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='set'))
 {
   // Se programa la inserción de datos.
   $salvar_tc = array(
     'id_tipo_componente' => $_POST['id_tipo_componente'],
     'descripcion' => $_POST['descripcion']
   );
   $tc = $tc_controller->set($salvar_tc);
   $template = '
     <div class="container">
       <p class="item edit">Tipo Componente <b>%s</b> Guardado </p>
     </div> 
     <script>
       window.onload = function()
       {
         // Recarga la pantalla de Tipo Componente nuevamente.
         reloadPage("tc")
       }       
     </script>
   '; 
   printf($template,$salvar_tc['descripcion']);

 }
 else
 {
   // Para generar una vista de no autorizado.
   $controller = new ViewController();
   $controller->load_view('error401');
 }

?>