<?php
  
  if(($_POST['r']=='marcas-add') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
  {
    print ('
      <h2 class="p1">Agregar Marcas</h2>
      <!-- Como no se esta autoprocesando el formulario continua de forma descedente la ejecución del programa, llegando a "else if" -->
      <form method="POST" class="item">
        <div class="p_25">
          <input type="text" name = "descripcion" placeholder="Nombre de la Marca" required >
        </div>
        <div>
          <input class="button add" type="submit" value="Agregar">
          <input type="hidden" name="r" value="marcas-add">
          <input type="hidden" name="crud" value="set">
        </div>
      </form>
    ');
  }
  else if ( ($_POST['r']=='marcas-add') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='set'))
  {
    // Se programa la inserción de datos.
    $marcas_controller = new MarcasController();
    $nueva_marca = array(
      'id_marca' => 0,
      'descripcion' => $_POST['descripcion']
    );
    $marcas = $marcas_controller->set($nueva_marca);
    $template = ' 
      <div class="container">
        <p class="item add">Marca <b>%s</b> Guardado </p>
      </div>  
      <script>
        window.onload = function()
        {
          // Recarga la pantalla de Marcas nuevamente.
          reloadPage("marcas")
        }        
      </script>
    ';  
    printf($template,$nueva_marca['descripcion']);

  }
  else
  {
    // Para generar una vista de no autorizado.
    $controller = new ViewController();
    $controller->load_view('error401');
  }
  

?>


