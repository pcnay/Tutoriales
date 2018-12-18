<?php
  // Valida que sea la opción de "estatus-add", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
  // User = Solo podra ver información.

  $estatus_controller = new EstatusController();

  if ($_POST['r']== 'estatus-edit' && $_SESSION['roles'] == 'Admin' && !isset($_POST['crud']))
  {
    $estatus = $estatus_controller->get($_POST['estatus_id']); // Obtiene el registro a editar.

    if (empty($estatus))
    {
      $template = ' 
        <div class="container">
          <p class="item error">NO existe el Estatus_ID <b>%s</b></p>
        </div>
        <script>
          window.onload = function()
          {
            reloadPage("estatus")
          }
        </script>
      ';  
      printf($template,$_POS['estatus_id']);
    }
    else
    {
      $template_estatus =' 
        <h2 class="p1">Editar un Estatus</h2>
        <form method="POST" class = "item">
          <div class = "p_25">
            <input type="text" placeholder="estatus_id" value = "%s" disabled required>
            <!-- Se pasa por input tipo oculto, porque los campos deshabilitados no se pasan al Backend -->
            <input type="hidden" name="estatus_id" value = "%s">
          </div>
          <div class = "p_25">
            <input type="text" name="estatus" placeholder="estatus" value = "%s" required>            
          </div>         
          <div class = "p_25">
            <input class="button edit" type="submit" value="Editar">
            <input type="hidden" name ="r" value="estatus-edit">
            <input type="hidden" name ="crud" value="set">
          </div>
        </form>
      ';
      printf(
        $template_estatus,
        $estatus[0]['estatus_id'],
        $estatus[0]['estatus_id'],
        $estatus[0]['estatus'] // input "text" que muestra el contenido de la descripción "Estatus"
      );
    }

    
  }
  // Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
  else if ($_POST['r']== 'estatus-edit' && $_SESSION['roles'] == 'Admin' && $_POST['crud'] == 'set')
  {
    // programar la inserción de los datos
    
    $save_estatus = array(
      'estatus_id' => $_POST['estatus_id'], // Este valor es del formulario anterior donde se copia la información desde el arreglo "$estatus"      
      'estatus' => $_POST['estatus'] // Es el valor que tecle el usuario en el formulario anterior
    );
    $estatus = $estatus_controller->set($save_estatus); // Graba a la Tabla de "Estatus" lo que tecleo el usuario.
    $template = '
      <div class = "container">
        <p class = "item edit">Estatus <b>%s </b> Guardado En La Base De Datos </p>
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
