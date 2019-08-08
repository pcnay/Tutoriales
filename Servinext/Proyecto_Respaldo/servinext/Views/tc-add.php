<?php
  
  if(($_POST['r']=='tc-add') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
  {
    print ('
      <h2 class="p1">Agregar Tipo Componente</h2>
      <!-- Como no se esta autoprocesando el formulario continua de forma descedente la ejecución del programa, llegando a "else if" -->
      <form method="POST" class="item">
        <div class="p_25">
          <input type="text" name = "descripcion" placeholder="Nombre del Componente" required >
        </div>
        <div>
          <input class="button add" type="submit" value="Agregar">
          <input type="hidden" name="r" value="tc-add">
          <input type="hidden" name="crud" value="set">
        </div>
      </form>
    ');
  }
  else if ( ($_POST['r']=='tc-add') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='set'))
  {
    // Se programa la inserción de datos.
    $tc_controller = new TcController();
    $nuevo_tc = array(
      'id_tipo_componente' => 0,
      'descripcion' => $_POST['descripcion']
    );
    $tc = $tc_controller->set($nuevo_tc);
    $template = ' 
      <div class="container">
        <p class="item add">Tipo Componente <b>%s</b> Guardado </p>
      </div>  
      <script>
        window.onload = function()
        {
          // Recarga la pantalla de Tipo Componente nuevamente.
          reloadPage("tc")
        }        
      </script>
    ';  
    printf($template,$nuevo_tc['descripcion']);

  }
  else
  {
    // Para generar una vista de no autorizado.
    $controller = new ViewController();
    $controller->load_view('error401');
  }
  

?>


