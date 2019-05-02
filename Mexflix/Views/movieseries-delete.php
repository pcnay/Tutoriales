<?php
  // Valida que sea la opción de "movieseries-delete", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
  // User = Solo podra ver información.

  $ms_controller = new MovieSeriesController();

  if ($_POST['r']== 'movieseries-delete' && $_SESSION['roles'] == 'Admin' && !isset($_POST['crud']))
  {
    $ms = $ms_controller->get($_POST['imdb_id']); // Obtiene el registro a borrar.

    if (empty($ms))
    {
      $template = ' 
        <div class="container">
          <p class="item error">NO existe la MovieSerie <b>%s</b></p>
        </div>
        <script>
          window.onload = function()
          {
            reloadPage("movieseries")
          }
        </script>
      ';  
      printf($template,$_POS['imdb_id']);
    }
    else
    {
      $template_ms =' 
				<h2 class="p1">Eliminar MovieSerie</h2>
				<form method="POST" class="item">
					<div class="p1 f2">
						¿ Estas seguro de eliminar La MovieSerie :  <mark class="p1">%s</mark> ?
					</div>
					<div class = "p_25">
						<input class="button delete" type="submit" value = "SI"> <!-- Para procesar si es "SI"-->
						<input class="button add" type="button" value = "NO" onclick="history.back()">
						<input type="hidden" name = "imdb_id" value ="%s">
						<input type="hidden" name = "r" value = "movieseries-delete">
						<input type="hidden" name = "crud" value = "del"> <!-- Este valor se pasa cuando se procesa el formulario al flujo del programa, es decir vuelve a realizar la ejecuciòn del programa y continua con los otros IF -->
					</div>
				</form>

			';
      printf(
        $template_ms,
        $ms[0]['imdb_id'],
        $ms[0]['imdb_id']        
      );
    }

    
  }
  // Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
  else if ($_POST['r']== 'movieseries-delete' && $_SESSION['roles'] == 'Admin' && $_POST['crud'] == 'del')
  {
    // programar el borrado del "Usuario"
   
    $ms = $ms_controller->del($_POST['imdb_id']); // Este variable viene del formulario anterior, donde preguntan si lo quieren "Borrar".
    $template = '
      <div class = "container">
        <p class = "item delete">MovieSerie <b>%s </b> Eliminada De La Base De Datos </p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("movieseries")
        }

      </script>

    ';
    printf($template,$_POST['imdb_id']);
  }
  else
  {
    // Para generar la vista de NO autorizado.
    $controller = new ViewControllers();
    $controller->load_view('error401'); // Error401 = Error de que no se tiene permiso para accesar.
  }
?>
