<?php
  // Valida que sea la opción de "moviseries-edit", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
  // User = Solo podra ver información.

  $ms_controller = new MovieSeriesController();

  if ($_POST['r']== 'movieseries-edit' && $_SESSION['roles'] == 'Admin' && !isset($_POST['crud']))
  {
    $ms = $ms_controller->get($_POST['imdb_id']); // Obtiene el registro a editar.

    if (empty($ms))
    {
      $template = ' 
        <div class="container">
          <p class="item error">NO existe la MovieSeries >>>>>> <b>%s</b></p>
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
			// Inicia la edicion de los campos de MovieSeries.
      // Estas variables se utilizan para activar el Radio dependiendo del valor guardado en la tabla.
      $category_movie = ($ms[0]['category']=='Movie')?'checked':'';
			$category_serie = ($ms[0]['category']=='Serie')?'checked':'';
			
			// Va obtener los estatus de la base de datos.
      $estatus_controller = new EstatusController();
			$estatus = $estatus_controller->get(); 
			// Se introucen al Combobox de Select, además se activara la opción del combo que tenga la tabla de datos.
			$estatus_select = '';
			for ($n=0; $n<count($estatus); $n++)
			{
				// Determina cual de la lista del ComboBox esta selecccionado, y posteriormente lo activa en el ComboBox,
				// $ms[0]['estatus'] = Proviene de la tabla MovieSeries de la base de datos
				//$estatus[$n]['estatus'] = Proviene de la tabla Estatus de la base de datos
				$selected = ($ms[0]['estatus']==$estatus[$n]['estatus']) ? 'selected':'';

				$estatus_select .= '<option value ="'.$estatus[$n]['estatus_id'].'"'.$selected.'>'.$estatus[$n]['estatus'].'</option>';
			}

			// Se despliega el formulario para poder editar los campos de la tabla "MovieSeries"
      $template_ms =' 
        <h2 class="p1">Editar MovieSeries</h2>
        <form method="POST" class = "item">
          <!-- Desplegando los datos del Usuario -->
          <div class = "p_25">
            <input type="text" placeholder="imdb_id" value = "%s" disabled required>
            <!-- Se pasa por input tipo oculto, porque los campos deshabilitados no se pasan al Backend -->
            <input type="hidden" name="imdb_id" value = "%s">
          </div>

          <div class = "p_25">
            <input type="text" name="title" placeholder="Titulo" value = "%s" required>
          </div>         
          <div class = "p_25">
            <textarea name="plott" cols="22" rows="10" placeholder="Descripcion - plott" >%s</textarea>
          </div>         
          <div class = "p_25">
            <input type="text" name="author" placeholder="Autor" value = "%s">
          </div>         
          <div class = "p_25">            
						<input type="text" name="actors" placeholder="Actores" value = "%s">
					</div>         
          <div class = "p_25">            
						<input type="text" name="country" placeholder="País" value = "%s">
					</div>         
					<div class = "p_25">            
						<input type="text" name="premiere" placeholder="Estreno" value = "%s">
					</div>         
          <div class = "p_25">            
						<input type="url" name="poster" placeholder="Poster" value = "%s">
					</div>         
          <div class = "p_25">            
						<input type="url" name="trailer" placeholder="Trailer" value = "%s">
					</div>         
          <div class = "p_25">            
						<input type="number" name="rating" placeholder="Rating" value = "%s" required>
					</div>         
          <div class = "p_25">            
						<input type="text" name="genres" placeholder="Géneros" value = "%s" required>
					</div>         
					<!-- Se forma el comboBox para los "Estatus" -->
					<div class = "p_25">            
						<select name="estatus" placeholder="Estatus" required>
							<option value="">Estatus</option>
							%s
						</select>
					<div class = "p_25">            
						<input type="radio" name="category" id="movie" value="Movie" %s required><label for="movie">Movie</label>
						<input type="radio" name="category" id="serie" value="Serie" %s required><label for="serie">Serie</label>
					</div>         

          <div class = "p_25">
            <input class="button edit" type="submit" value="Editar">
            <input type="hidden" name ="r" value="movieseries-edit">
            <input type="hidden" name ="crud" value="set">
          </div>
        </form>
      ';
      printf(
        $template_ms,
				$ms[0]['imdb_id'], // Este se muestra en una input deshabilitado
				$ms[0]['imdb_id'], // Este proviene del campo "hidden" que se manda del formulario.
        $ms[0]['title'], 
        $ms[0]['plott'],
				$ms[0]['author'],
				$ms[0]['actors'],
				$ms[0]['country'],
				$ms[0]['premiere'],
				$ms[0]['poster'],
				$ms[0]['trailer'],
				$ms[0]['rating'],
				$ms[0]['genres'],         
        $estatus_select,
				$category_movie,
				$category_serie
      );
    }

    
  }
	// Cuando se oprime el boton de "Editar"
	// Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
  else if ($_POST['r']== 'movieseries-edit' && $_SESSION['roles'] == 'Admin' && $_POST['crud'] == 'set')
  {
    // programar la inserción de los datos    
    $save_ms = array(
      'imdb_id'  => $_POST['imdb_id'], // Es el valor que tecle el usuario en el formulario anterior
      'title' => $_POST['title'],
      'plott' => $_POST['plott'],
			'author' => $_POST['author'],
			'actors' => $_POST['actors'],
			'country' => $_POST['country'],			
			'premiere' => $_POST['premiere'],
			'poster' => $_POST['poster'],
			'trailer' => $_POST['trailer'],
			'rating' => $_POST['rating'],
			'genres' => $_POST['genres'],
			'estatus' => $_POST['estatus'],
			'category' => $_POST['category']
		);
    $ms = $ms_controller->set($save_ms); // Graba a la Tabla de "MovieSeries" lo que tecleo el usuario.
    $template = '
      <div class = "container">
        <p class = "item edit">Movie o Serie <b>%s </b> Guardado En La Base De Datos </p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("movieseries")
        }

      </script>

    ';
    printf($template,$_POST['title']);
  }
  else
  {
    // Para generar la vista de NO autorizado.
    $controller = new ViewControllers();
    $controller->load_view('error401'); // Error401 = Error de que no se tiene permiso para accesar.
  }
?>
