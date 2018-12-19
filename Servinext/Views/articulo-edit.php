<?php
  // Valida que sea la opción de "articulo-edit", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
  // User = Solo podra ver información.

  $articulo_controller = new ArticuloController();

  if ($_POST['r']== 'articulo-edit' && $_SESSION['roles'] == 'Admin' && !isset($_POST['crud']))
  {
    $articulo = $articulo_controller->get($_POST['articulo_id']); // Obtiene el registro a editar.

    if (empty($articulo))
    {
      $template = ' 
        <div class="container">
          <p class="item error">NO existe el ID Del Articulo<b>%s</b></p>
        </div>
        <script>
          window.onload = function()
          {
            reloadPage("articulo")
          }
        </script>
      ';  
      printf($template,$_POS['articulo_id']);
    }
    else
    {
      $template_articulo =' 
        <h2 class="p1">Editar un Articulo</h2>
        <form method="POST" class = "item">
          <div class = "p_25">
            <input type="text" placeholder="artiuclo_id" value = "%s" disabled required>
            <!-- Se pasa por input tipo oculto, porque los campos deshabilitados no se pasan al Backend -->
            <input type="hidden" name="articulo_id" value = "%s">
          </div>
          <div class = "p_25">
						<input type="text" name="descripcion" placeholder="Descripcion" value = "%s" required>            
						<input type="text" name="marca" placeholder="Marca" value = "%s" required>            <input type="text" name="modelo" placeholder="Modelo" value = "%s" required>          <input type="text" name="num_serial" placeholder="Numero de Serie" value = "%s" 
						required>
						<input type="text" name="num_parte" placeholder="Numero de Parte" value = "%s" 
						required>
						<input type="text" name="existencia" placeholder="Existencia" value = "%s" 
						required>
						<input type="text" name="historial" placeholder="Historial" value = "%s" 
						required>
						<input type="text" name="sr" placeholder="El SR" value = "%s" 
						required>
					</div>     
					    
          <div class = "p_25">
            <input class="button edit" type="submit" value="Editar">
            <input type="hidden" name ="r" value="articulo-edit">
            <input type="hidden" name ="crud" value="set">
          </div>
        </form>
      ';
      printf(
        $template_articulo,
				$articulo[0]['articulo_id'],
				$articulo[0]['articulo_id'],
				$articulo[0]['descripcion'],
				$articulo[0]['marca'],
				$articulo[0]['modelo'],
				$articulo[0]['num_serial'],
				$articulo[0]['num_parte'],
				$articulo[0]['existencia'],
				$articulo[0]['historial'],
				$articulo[0]['sr']        
      );
    }    
  }
  // Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
  else if ($_POST['r']== 'articulo-edit' && $_SESSION['roles'] == 'Admin' && $_POST['crud'] == 'set')
  {
    // programar la editción de los datos
    
    $save_articulo = array(
      'articulo_id' => $_POST['articulo_id'], // Este valor es del formulario anterior donde se copia la información desde el arreglo "$estatus"      
			'descripcion' => $_POST['descripcion'], // Es el valor que tecle el usuario en el formulario anterior
			'marca' => $_POST['marca'],
			'modelo' => $_POST['modelo'],
			'num_serial' => $_POST['num_serial'],
			'num_parte' => $_POST['num_parte'],
			'existencia' => $_POST['existencia'],
			'historial' => $_POST['historial'],
			'sr' => $_POST['sr'],
    );
    $articulo = $articulo_controller->set($save_articulo); // Graba a la Tabla de "Articulos" lo que tecleo el usuario.
    $template = '
      <div class = "container">
        <p class = "item edit">Articulo <b>%s </b> Guardado En La Base De Datos </p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("articulos")
        }

      </script>

    ';
    printf($template,$_POST['descripcion']);
  }
  else
  {
    // Para generar la vista de NO autorizado.
    $controller = new ViewControllers();
    $controller->load_view('error401'); // Error401 = Error de que no se tiene permiso para accesar.
  }
?>
