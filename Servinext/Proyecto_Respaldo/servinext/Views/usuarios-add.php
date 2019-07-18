<?php
  
  if(($_POST['r']=='clientes-add') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
  {
    print ('
      <h2 class="p1">Agregar Clientes</h2>
      <!-- Como no se esta autoprocesando el formulario continua de forma descedente la ejecución del programa, llegando a "else if" -->
      <form method="POST" class="item">
        <div class="p_25">
          <input type="text" name = "nombre" placeholder="Nombre Cliente" required >
        </div>
        <div>
          <input class="button add" type="submit" value="Agregar">
          <input type="hidden" name="r" value="clientes-add">
          <input type="hidden" name="crud" value="set">
        </div>
      </form>
    ');
  }
  else if ( ($_POST['r']=='clientes-add') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='set'))
  {
    // Se programa la inserción de datos.
    $clientes_controller = new ClientesController();
    $nuevo_cliente = array(
      'id_clientes' => 0,
      'nombre' => $_POST['nombre']
    );
    $clientes = $clientes_controller->set($nuevo_cliente);
    $template = ' 
      <div class="container">
        <p class="item add">Cliente <b>%s</b> Guardado </p>
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
