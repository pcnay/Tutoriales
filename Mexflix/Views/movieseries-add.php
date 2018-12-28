<?php
  // Valida que sea la opción de "movieseries-add", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
  // User = Solo podra ver información.


  if ($_POST['r']== 'movieseries-add' && $_SESSION['roles'] == 'Admin' && !isset($_POST['crud']))
  {
    print('
      <h2 class = "p1">Agregar MovieSeries</h2>
      <form method="POST" class="item">
        <div class="p_25">
          <input type = "text" name="imdb_id" placeholder="imdb_id" required>
        </div>
        <div class="p_25">
          <input type = "text" name="title" placeholder="title" required>
        </div>
        <div class="p_25">
          <textarea name="plott" cols="22" rows = "10" placeholder="descripcion"></textarea>
        </div>
        <div class="p_25">
          <input type = "text" name="author" placeholder="Autor">
        </div>
        <div class="p_25">
          <input type = "text" name="actors" placeholder="Actores">
        </div>
        <div class="p_25">
          <input type = "text" name="country" placeholder="País">
        </div>
        <div class="p_25">
          <input type = "text" name="premiere" placeholder="Estreno" required>
        </div>
        <div class="p_25">
          <input type = "url" name="poster" placeholder="Poster">
        </div>
        <div class="p_25">
          <input type = "url" name="trailer" placeholder="Trailer">
        </div>
        <div class="p_25">
          <input type = "number" name="rating" placeholder="Rating">
        </div>
        <div class="p_25">
          <input type = "text" name="genres" placeholder="Géneros" required>
        </div>
        <div class="p_25">
          <select name="estatus" placeholder="Estatus" required>
            <option value = "">status</option>
            %s
          </select>
        </div>

        <div class = "p_25">
          <input type= "radio" name = "category" id="movie" value ="Movie" required>
          <label for="movie">Movie</label>
          <input type= "radio" name = "category" id="serie" value ="Serie" required>
          <label for="serie">Serie</label>

        </div>
        <div class="p_25">
          <input class="button add" type="submit" value="Agregar">
          <input type="hidden" name="r" value="movieseries-add">
          <input type="hidden" name="crud" value="set">
        </div>
      </form>
    ');
  }
  // Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
  else if ($_POST['r']== 'moviseries-add' && $_SESSION['roles'] == 'Admin' && $_POST['crud'] == 'set')
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
