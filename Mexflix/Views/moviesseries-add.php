<?php
  // Valida que sea la opción de "users-add", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
  // User = Solo podra ver información.


  if ($_POST['r']== 'users-add' && $_SESSION['roles'] == 'Admin' && !isset($_POST['crud']))
  {
    print('
      <h2 class = "p1">Agregar Usuarios</h2>
      <form method="POST" class="item">
        <div class="p_25">
          <input type = "text" name="user" placeholder="Usuario" required>
        </div>
        <div class="p_25">
          <input type = "email" name="email" placeholder="Email" required>
        </div>
        <div class="p_25">
          <input type = "text" name="names" placeholder="Nombre" required>
        </div>
        <div class="p_25">
          <input type = "text" name="birthday" placeholder="AAAA-MM-DD - Cumpleaños" required>
        </div>
        <div class="p_25">
          <input type = "password" name="pass" placeholder="Clave Acceso" required>
        </div>
        <div class = "p_25">
          <input type= "radio" name = "roles" id="admin" value ="Admin" required>
          <label for="admin">Administrador</label>
          <input type= "radio" name = "roles" id="noadmin" value ="User" required>
          <label for="noadmin">Usuario</label>

        </div>
        <div class="p_25">
          <input class="button add" type="submit" value="Agregar">
          <input type="hidden" name="r" value="users-add">
          <input type="hidden" name="crud" value="set">
        </div>
      </form>
    ');
  }
  // Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
  else if ($_POST['r']== 'users-add' && $_SESSION['roles'] == 'Admin' && $_POST['crud'] == 'set')
  {
    // programar la inserción de los datos
    $users_controller = new UsersController();
    $new_user = array(
      'user' => $_POST['user'], // Es el valor que tecle el usuario en el formulario anterior
      'email' => $_POST['email'],
      'names' => $_POST['names'],
      'birthday' => $_POST['birthday'],
      'pass' => $_POST['pass'],
      'roles' => $_POST['roles']
    );
    $user = $users_controller->set($new_user); // Graba a la Tabla de "Users" lo que tecleo el usuario.

    $template = '
      <div class = "container">
        <p class = "item add">Usuario <b>%s </b> Guardado En La Base De Datos </p>
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
