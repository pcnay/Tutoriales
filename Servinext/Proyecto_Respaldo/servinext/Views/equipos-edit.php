<?php
  // Valida que sea la opción de "equipos-edit", que este el usuario Logueado, y que el usuario sea : Administrador = Permitir Alta, Baja, Actualizar.
  // User = Solo podra ver información.

  $equipos_controller = new EquiposController();

  if ($_POST['r']== 'equipos-edit' && $_SESSION['perfil'] == 'Admin' && !isset($_POST['crud']))
  {
    $equipos = $equipos_controller->get($_POST['id_epo']); // Obtiene el registro a editar.

    //echo var_dump($equipos); // Para mostrar el contenido del arreglo en pantalla, utilizando el inspector de elementos, en la sección del "body" editar como HTML. "var_dump" pasa de objeto a texto para visualizarlo.
    // return $equipos; 
    
    if (empty($equipos))
    {
      $template = ' 
        <div class="container">
          <p class="item error">NO existe el equipo >>>>>> <b>%s</b></p>
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
			// Inicia la edicion de los campos de Equipos.
			
      // Va obtener el tipo de componente de la base de datos.      
      $tc_controller = new TcController();
      $tc = $tc_controller->get();
      
			// Se introducen al Combobox de Select, además se activara la opción del combo que tenga la tabla de datos.
			$tc_select = '';
			for ($n=0; $n<count($tc); $n++)
			{
				// Determina cual de la lista del ComboBox esta selecccionado, y posteriormente lo activa en el ComboBox,
				// $tc[0]['id_tipo_componente'] = Proviene de la tabla "t_Tipo_Componente" de la base de datos
				//$tc[$n]['descripcion'] = Proviene de la tabla "t_Tipo_Componente" de la base de datos
				$selected = ($equipos[0]['id_tipo_componente']==$tc[$n]['id_tipo_componente']) ? 'selected':'';

				$tc_select .= '<option value ="'.$tc[$n]['id_tipo_componente'].'"'.$selected.'>'.$tc[$n]['descripcion'].'</option>';
			}

      // Va obtener la "marca" de la base de datos.      
      $marcas_controller = new MarcasController();
      $marcas = $marcas_controller->get();
      
			// Se introducen al Combobox de Select, además se activara la opción del combo que tenga la tabla de datos.
			$marcas_select = '';
			for ($n=0; $n<count($marcas); $n++)
			{
				// Determina cual de la lista del ComboBox esta selecccionado, y posteriormente lo activa en el ComboBox,
				// $marcas[0]['id_marca'] = Proviene de la tabla "t_Marca" de la base de datos
				$selected = ($equipos[0]['id_marca']==$marcas[$n]['id_marca']) ? 'selected':'';

				$marcas_select .= '<option value ="'.$marcas[$n]['id_marca'].'"'.$selected.'>'.$marcas[$n]['descripcion'].'</option>';
			}

      // Va obtener la "modelo" de la base de datos.      
      $modelos_controller = new ModelosController();
      $modelos = $modelos_controller->get();
      
			// Se introducen al Combobox de Select, además se activara la opción del combo que tenga la tabla de datos.
			$modelos_select = '';
			for ($n=0; $n<count($modelos); $n++)
			{
				// Determina cual de la lista del ComboBox esta selecccionado, y posteriormente lo activa en el ComboBox,
				// $modelos[0]['id_modelo'] = Proviene de la tabla "t_Modelo" de la base de datos
				$selected = ($equipos[0]['id_modelo']==$modelos[$n]['id_modelo']) ? 'selected':'';

				$modelos_select .= '<option value ="'.$modelos[$n]['id_modelo'].'"'.$selected.'>'.$modelos[$n]['descripcion'].'</option>';
			}
			// Se despliega el formulario para poder editar los campos de la tabla "MovieSeries"
      $template_equipo =' 
        <h2 class="p1">Editar Equipos</h2>
        <form method="POST" class = "item">
          <!-- Desplegando los datos del Usuario -->
          <div class = "p_25">
            <input type="text" placeholder="id_epo" value = "%s" disabled required>
            <!-- Se pasa por input tipo oculto, porque los campos deshabilitados no se pasan al Backend -->
            <input type="hidden" name="id_epo" value = "%s">
          </div>

          <div class = "p_25">
            <input type="text" name="num_serie" placeholder="Numero De Serie" value = "%s">
          </div>  
          <div class = "p_25">
            <input type="text" name="num_inv" placeholder="Numero De Inventario" value = "%s">
          </div>  
          <div class = "p_25">
            <input type="text" name="num_parte" placeholder="Numero De Parte" value = "%s">
          </div>  
          <div class = "p_25">            
						<input type="number" name="existencia" placeholder="Existencia" value = "%s" required>
          </div>        
           
          <!-- Se forma el comboBox para los "Tipos Componentes" -->
					<div class = "p_25">            
						<select name="id_tipo_componente" placeholder="Componente" required>
							<option value="">Componete</option>
							%s
            </select>
          </div>
          <!-- Se forma el comboBox para las "Marcas" -->
					<div class = "p_25">            
						<select name="id_marca" placeholder="Marcas" required>
							<option value="">Marca</option>
							%s
            </select>
          </div>
          <!-- Se forma el comboBox para los "Modelos" -->
					<div class = "p_25">            
						<select name="id_modelo" placeholder="Modelos" required>
							<option value="">Modelos</option>
							%s
            </select>
          </div>
          <div class = "p_25">
            <textarea name="comentarios" cols="120" rows="10" placeholder="Comentarios" >%s</textarea>
          </div>         

          <div class = "p_25">
            <input class="button edit" type="submit" value="Editar">
            <input type="hidden" name ="r" value="equipos-edit">
            <input type="hidden" name ="crud" value="set">
          </div>
        </form>
      ';
      printf(
        $template_equipo,
				$equipos[0]['id_epo'], // Este se muestra en una input deshabilitado
				$equipos[0]['id_epo'], // Este proviene del campo "hidden" que se manda del formulario.
        $equipos[0]['num_serie'], 
        $equipos[0]['num_inv'],
        $equipos[0]['num_parte'],
        $equipos[0]['existencia'],   
        $tc_select,
        $marcas_select,
        $modelos_select,
        $equipos[0]['comentarios']   
      );
    }

    
  }
	// Cuando se oprime el boton de "Editar"
	// Como no se indica una Acción, el formulario se va autoprocesar, con la siguiente válidación.
  else if ($_POST['r']== 'equipos-edit' && $_SESSION['perfil'] == 'Admin' && $_POST['crud'] == 'set')
  {
    // programar la inserción de los datos    
    $save_equipo = array(
      'id_epo'  => $_POST['id_epo'], // Es el valor que tecle el usuario en el formulario anterior
      'num_serie' => $_POST['num_serie'],
      'num_inv' => $_POST['num_inv'],
			'num_parte' => $_POST['num_parte'],
			'existencia' => $_POST['existencia'],
      'id_tipo_componente' => $_POST['id_tipo_componente'],
      'id_marca' => $_POST['id_marca'],
      'id_modelo' => $_POST['id_modelo'],
			'comentarios' => $_POST['comentarios']
		);
    $equipo = $equipos_controller->set($save_equipo); // Graba a la Tabla de "t_Equipo" lo que tecleo el usuario.
    $template = '
      <div class = "container">
        <p class = "item edit">Equipo <b>%s </b> Guardado En La Base De Datos </p>
      </div>
      <script>
        window.onload = function()
        {
          reloadPage("equipos")
        }

      </script>

    ';
    printf($template,$_POST['id_tipo_componente']);
  }
  else
  {
    // Para generar la vista de NO autorizado.
    $controller = new ViewControllers();
    $controller->load_view('error401'); // Error401 = Error de que no se tiene permiso para accesar.
  }
?>
