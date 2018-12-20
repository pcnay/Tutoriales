<?php
  // Valida que sea la opción de "estatus-delete", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
  // User = Solo podra ver información.

  $estatus_controller = new EstatusController();

  if ($_POST['r']== 'estatus-delete' && $_SESSION['roles'] == 'Admin' && !isset($_POST['crud']))
  {
    $estatus = $estatus_controller->get($_POST['estatus_id']); // Obtiene el registro a borrar.

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
				<h2 class="p1">Eliminar Estatus</h2>
				<form method="POST" class="item">
					<div class="p1 f2">
						¿ Estas seguro de eliminar el Estatus :  <mark class="p1">%s</mark> ?
					</div>
					<div class = "p_25">
						<input class="button delete" type="submit" value = "SI"> <!-- Para procesar si es "SI"-->
						<input class="button add" type="button" value = "NO" onclick="history.back()">
						<input type="hidden" name = "estatus_id" value ="%s">
						<input type="hidden" name = "r" value = "estatus-delete">
						<input type="hidden" name = "crud" value = "del"> <!-- Este valor se pasa cuando se procesa el formulario al flujo del programa, es decir vuelve a realizar la ejecuciòn del programa y continua con los otros IF -->
					</div>
				</form>

			';
      printf(
        $template_estatus,
        $estatus[0]['estatus'],
        $estatus[0]['estatus_id']        
      );
    }

    
  }
  // Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
  else if ($_POST['r']== 'estatus-delete' && $_SESSION['roles'] == 'Admin' && $_POST['crud'] == 'del')
  {
    // programar el borrado del "Estatus"
   
    $estatus = $estatus_controller->del($_POST['estatus_id']); // Este variable viene del formulario anterior, donde preguntan si lo quieren "Borrar".
    $template = '
      <div class = "container">
        <p class = "item delete">Estatus <b>%s </b> Eliminado De La Base De Datos </p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("estatus")
        }

      </script>

    ';
    printf($template,$_POST['estatus_id']);
  }
  else
  {
    // Para generar la vista de NO autorizado.
    $controller = new ViewControllers();
    $controller->load_view('error401'); // Error401 = Error de que no se tiene permiso para accesar.
  }
?>
