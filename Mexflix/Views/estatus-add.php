<?php
  // Valida que sea la opción de "estatus-add", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
  // User = Solo podra ver información.


  if ($_POST['r']== 'estatus-add' && $_SESSION['roles'] == 'Admin' && !isset($_POST['crud']))
  {
    print('
      <h2 class = "p1">Agregar Estatus</h2>
      <form method="POST" class="item">
        <div class="p_25">
          <input type = "text" name="estatus" placeholder="Nombre De Estatus" required>
        </div>
        <div class="p_25">
          <input class="button add" type="submit" value="Agregar">
          <input type="hidden" name="r" value="estatus-add">
          <input type="hidden" name="crud" value="set">
        </div>
      </form>
    ');
  }
  // Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
  else if ($_POST['r']== 'estatus-add' && $_SESSION['roles'] == 'Admin' && $_POST['crud'] == 'set')
  {
    // programar la inserción de los datos
    $estatus_controller = new EstatusController();
    $new_estatus = array(
      'estatus_id' => 0,
      'estatus' => $_POST['estatus'] // Es el valor que tecle el usuario en el formulario anterior
    );
    $estatus = $estatus_controller->set($new_estatus); // Graba a la Tabla de "Estatus" lo que tecleo el usuario.
    $template = '
      <div class = "container">
        <p class = "item add">Estatus <b>%s </b> Guardado En La Base De Datos </p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("estatus")
        }

      </script>

    ';
    printf($template,$_POST['estatus']);
  }
  else
  {
    // Para generar la vista de NO autorizado.
    $controller = new ViewControllers();
    $controller->load_view('error401'); // Error401 = Error de que no se tiene permiso para accesar.
  }
?>
