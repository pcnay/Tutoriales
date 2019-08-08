<?php
  
  if(($_POST['r']=='modelos-add') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
  {
    print ('
      <h2 class="p1">Agregar Modelos</h2>
      <!-- Como no se esta autoprocesando (no contiene "action") el formulario continua de forma descedente la ejecución del programa, llegando a "else if" -->
      <form method="POST" class="item">
        <div class="p_25">
          <input type="text" name = "descripcion" placeholder="Nombre del Modelo" required >
        </div>
        <div>
          <input class="button add" type="submit" value="Agregar">
          <input type="hidden" name="r" value="modelos-add">
          <input type="hidden" name="crud" value="set">
        </div>
      </form>
    ');
  }
  else if ( ($_POST['r']=='modelos-add') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='set'))
  {
    // Se programa la inserción de datos.
    $modelos_controller = new ModelosController();
    $nuevo_modelo = array(
      'id_modelo' => 0,
      'descripcion' => $_POST['descripcion']
    );
    $modelos = $modelos_controller->set($nuevo_modelo);
    $template = ' 
      <div class="container">
        <p class="item add">Modelo <b>%s</b> Guardado </p>
      </div>  
      <script>
        window.onload = function()
        {
          // Recarga la pantalla de Marcas nuevamente.
          reloadPage("modelos")
        }        
      </script>
    ';  
    printf($template,$nuevo_modelo['descripcion']);

  }
  else
  {
    // Para generar una vista de no autorizado.
    $controller = new ViewController();
    $controller->load_view('error401');
  }

?>
