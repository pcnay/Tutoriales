<?php
  // Valida que sea la opción de "equipos-delete", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
  // User = Solo podra ver información.

  $equipos_controller = new EquiposController();

  if ($_POST['r']== 'equipos-delete' && $_SESSION['perfil'] == 'Admin' && !isset($_POST['crud']))
  {
    $equipos = $equipos_controller->get($_POST['id_epo']); // Obtiene el registro a borrar.

    if (empty($equipos))
    {
      $template = ' 
        <div class="container">
          <p class="item error">NO existe el Equipo <b>%s</b></p>
        </div>
        <script>
          window.onload = function()
          {
            reloadPage("equipos")
          }
        </script>
      ';  
      printf($template,$_POS['id_epo']);
    }
    else
    {
      $template_equipo =' 
				<h2 class="p1">Eliminar Equipo</h2>
				<form method="POST" class="item">
					<div class="p1 f2">
						¿ Estas seguro de eliminar el Equipo :  <mark class="p1">%s</mark> ?
					</div>
					<div class = "p_25">
						<input class="button delete" type="submit" value = "SI"> <!-- Para procesar si es "SI"-->
						<input class="button add" type="button" value = "NO" onclick="history.back()">
						<input type="hidden" name = "id_epo" value ="%s">
						<input type="hidden" name = "r" value = "equipos-delete">
						<input type="hidden" name = "crud" value = "del"> <!-- Este valor se pasa cuando se procesa el formulario al flujo del programa, es decir vuelve a realizar la ejecuciòn del programa y continua con los otros IF -->
					</div>
				</form>

			';
      printf(
        $template_equipo,
        $equipos[0]['id_epo'],
        $equipos[0]['id_epo']        
      );
    }

    
  }
  // Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
  else if ($_POST['r']== 'equipos-delete' && $_SESSION['perfil'] == 'Admin' && $_POST['crud'] == 'del')
  {
    // programar el borrado del "Usuario"
   
    $equipos = $equipos_controller->del($_POST['id_epo']); // Este variable viene del formulario anterior, donde preguntan si lo quieren "Borrar".
    $template = '
      <div class = "container">
        <p class = "item delete">Equipo <b>%s </b> Eliminado De La Base De Datos </p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("equipos")
        }

      </script>

    ';
    printf($template,$_POST['id_epo']);
  }
  else
  {
    // Para generar la vista de NO autorizado.
    $controller = new ViewControllers();
    $controller->load_view('error401'); // Error401 = Error de que no se tiene permiso para accesar.
  }
?>
