<?php
  // Valida que sea la opción de "userss-delete", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
  // User = Solo podra ver información.

  $users_controller = new UsersController();

  if ($_POST['r']== 'users-delete' && $_SESSION['roles'] == 'Admin' && !isset($_POST['crud']))
  {
    $user = $users_controller->get($_POST['user']); // Obtiene el registro a borrar.

    if (empty($user))
    {
      $template = ' 
        <div class="container">
          <p class="item error">NO existe el Usuario <b>%s</b></p>
        </div>
        <script>
          window.onload = function()
          {
            reloadPage("users")
          }
        </script>
      ';  
      printf($template,$_POS['user']);
    }
    else
    {
      $template_user =' 
				<h2 class="p1">Eliminar Usuario</h2>
				<form method="POST" class="item">
					<div class="p1 f2">
						¿ Estas seguro de eliminar el Usuario :  <mark class="p1">%s</mark> ?
					</div>
					<div class = "p_25">
						<input class="button delete" type="submit" value = "SI"> <!-- Para procesar si es "SI"-->
						<input class="button add" type="button" value = "NO" onclick="history.back()">
						<input type="hidden" name = "user" value ="%s">
						<input type="hidden" name = "r" value = "users-delete">
						<input type="hidden" name = "crud" value = "del"> <!-- Este valor se pasa cuando se procesa el formulario al flujo del programa, es decir vuelve a realizar la ejecuciòn del programa y continua con los otros IF -->
					</div>
				</form>

			';
      printf(
        $template_user,
        $user[0]['user'],
        $user[0]['user']        
      );
    }

    
  }
  // Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
  else if ($_POST['r']== 'users-delete' && $_SESSION['roles'] == 'Admin' && $_POST['crud'] == 'del')
  {
    // programar el borrado del "Usuario"
   
    $user = $users_controller->del($_POST['user']); // Este variable viene del formulario anterior, donde preguntan si lo quieren "Borrar".
    $template = '
      <div class = "container">
        <p class = "item delete">Usuario <b>%s </b> Eliminado De La Base De Datos </p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("users")
        }

      </script>

    ';
    printf($template,$_POST['user']);
  }
  else
  {
    // Para generar la vista de NO autorizado.
    $controller = new ViewControllers();
    $controller->load_view('error401'); // Error401 = Error de que no se tiene permiso para accesar.
  }
?>
