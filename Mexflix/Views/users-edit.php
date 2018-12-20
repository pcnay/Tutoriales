<?php
  // Valida que sea la opción de "users-add", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
  // User = Solo podra ver información.

  $users_controller = new UsersController();

  if ($_POST['r']== 'users-edit' && $_SESSION['roles'] == 'Admin' && !isset($_POST['crud']))
  {
    $user = $users_controller->get($_POST['user']); // Obtiene el registro a editar.

    if (empty($user))
    {
      $template = ' 
        <div class="container">
          <p class="item error">NO existe el Usuario >>>>>> <b>%s</b></p>
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
      // Estas variables se utilizan para activar el Radio dependiendo del valor guardado en la tabla.
      $role_admin = ($user[0]['roles']=='Admin')?'checked':'';
      $role_user = ($user[0]['roles']=='User')?'checked':'';
      
      $template_user =' 
        <h2 class="p1">Editar un Usuario</h2>
        <form method="POST" class = "item">
          <!-- Desplegando los datos del Usuario -->
          <div class = "p_25">
            <input type="text" placeholder="usuario" value = "%s" disabled required>
            <!-- Se pasa por input tipo oculto, porque los campos deshabilitados no se pasan al Backend -->
            <input type="hidden" name="user" value = "%s">
          </div>

          <div class = "p_25">
            <input type="email" name="email" placeholder="Email" value = "%s" required>
          </div>         
          <div class = "p_25">
            <input type="text" name="names" placeholder="Nombre" value = "%s" required>
          </div>         
          <div class = "p_25">
            <input type="text" name="birthday" placeholder="AAAA-MM-DD  Cumpleaños" value = "%s" required>
          </div>         
          <div class = "p_25">
            <input type="password" name="pass" placeholder="Contraseña" value = "%s" required>
          </div>         
          <div class = "p_25">
            <input type="radio" name="roles" id="admin" value="Admin" %s required><label for ="admin">Administrador</label>
            <input type="radio" name="roles" id="noadmin" value="User" %s required><label for ="noadmin">Usuario</label>            
          </div>         

          <div class = "p_25">
            <input class="button edit" type="submit" value="Editar">
            <input type="hidden" name ="r" value="users-edit">
            <input type="hidden" name ="crud" value="set">
          </div>
        </form>
      ';
      printf(
        $template_user,
        $user[0]['user'], //// input "text" que muestra el contenido de la descripción "Estatus"
        $user[0]['user'],
        $user[0]['email'],
        $user[0]['names'],
        $user[0]['birthday'],
        $user[0]['pass'],
        $role_admin,
        $role_user
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
