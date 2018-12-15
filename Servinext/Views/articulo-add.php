<?php
  // Valida que sea la opción de "articulo-add", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
  // User = Solo podra ver información.


  if ($_POST['r']== 'articulo-add' && $_SESSION['roles'] == 'Admin' && !isset($_POST['crud']))
  {
    print('
      <h2 class = "p1">Agregar Articulos</h2>
      <form method="POST" class="item">
        <div class="p_25">
          <input type = "text" name="descripcion" placeholder="Teclear Descripcion Articulo" required>
          <input type = "text" name="marca" placeholder="Teclear Marca Articulo" required>
          <input type = "text" name="modelo" placeholder="Teclear Modelo Articulo" required>
          <input type = "text" name="num_serial" placeholder="Teclear Serial Articulo" required>
          <input type = "text" name="num_parte" placeholder="Teclear Numero De Parte del Articulo" required>
          <input type = "text" name="existencia" placeholder="Teclear La existencia del Articulo" required>
          <input type = "text" name="historial" placeholder="Comentarios del Articulo" required>
          <input type = "text" name="sr" placeholder="Teclear SR del Articulo" required>

        </div>
        <div class="p_25">
          <input class="button add" type="submit" value="Agregar">
          <input type="hidden" name="r" value="articulo-add">
          <input type="hidden" name="crud" value="set">
        </div>
      </form>
    ');
  }
  // Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
  else if ($_POST['r']== 'articulo-add' && $_SESSION['roles'] == 'Admin' && $_POST['crud'] == 'set')
  {
    // programar la inserción de los datos
    $articulo_controller = new ArticuloController();
    $new_articulos = array(
      'articulo_id' => 0,
      'descripcion' => $_POST['descripcion'], // Es el valor que tecle el usuario en el formulario anterior
      'marca' => $_POST['marca'],        
      'modelo' => $_POST['modelo'],
      'num_serial' => $_POST['num_serial'],
      'num_parte' => $_POST['num_parte'],
      'existencia' => $_POST['existencia'],
      'historial' => $_POST['historial'],
      'sr' => $_POST['sr']
    );
    $articulo = $articulo_controller->set($new_articulos); // Graba a la Tabla de "Articulos" lo que tecleo el usuario.
    $template = '
      <div class = "container">
        <p class = "item add">Articulo <b>%s </b> Guardado En La Base De Datos </p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("articulos")
        }

      </script>

    ';
    printf($template,$_POST['descripcion']);
  }
  else
  {
    // Para generar la vista de NO autorizado.
    $controller = new ViewControllers();
    $controller->load_view('error401'); // Error401 = Error de que no se tiene permiso para accesar.
  }
?>
