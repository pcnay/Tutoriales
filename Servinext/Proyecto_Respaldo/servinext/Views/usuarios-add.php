<?php
  
  if(($_POST['r']=='usuarios-add') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
  {
    print ('
      <h2 class="p1">Agregar Usuario</h2>
      <!-- Como no se esta autoprocesando el formulario continua de forma descedente la ejecución del programa, llegando a "else if" -->
      <form method="POST" class="item">
        <div class="p_25">
          <input type="text" name = "usuario" placeholder="Usuario" required >
        </div>
        <div class="p_25">
          <input type="email" name = "email" placeholder="Correo Electronico" required >
        </div>
        <div class="p_25">
          <input type="text" name = "nombre" placeholder="Nombre Usuario" required >
        </div>
        <div class="p_25">
          <input type="text" name = "cumpleanos" placeholder="Cumpleaños (AAAA-MM-DD) " required >
        </div>
        <div class="p_25">
          <input type="password" name = "clave" placeholder="Contraseña" required >
        </div>
        <div class="p_25">
          <!-- Con "id" y "label" como tienen el mismo nombre estan asociados, para cuando le usuario oprima el circulo de cualquiera de los dos se seleccionara solamente uno. -->
          <input type="radio" name = "perfil" id="admin" value ="Admin" required><label for ="admin">Administrador</label>
          <input type="radio" name = "perfil" id="noadmin" value ="Usuario" required><label for ="noadmin">Usuario</label>
        </div>
        <div>
          <input class="button add" type="submit" value="Agregar">
          <input type="hidden" name="r" value="usuarios-add">
          <input type="hidden" name="crud" value="set">
        </div>
      </form>
    ');
  }
  else if ( ($_POST['r']=='usuarios-add') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='set'))
  {
    // Se programa la inserción de datos.
    // Los datos se obtienen de los datos que capturo el usuario desde el formulario.
    $usuarios_controller = new UsuariosController();
    $nuevo_usuario = array(
      'usuario' => $_POST['usuario'],
      'email' => $_POST['email'],
      'nombre' => $_POST['nombre'],
      'cumpleanos' => $_POST['cumpleanos'],
      'clave' => $_POST['clave'],
      'perfil' => $_POST['perfil']
    );
    // Pasarlo a la tabla de Usuario.
    $usuario = $usuarios_controller->set($nuevo_usuario);
    $template = ' 
      <div class="container">
        <p class="item add">Usuario <b>%s</b> Guardado </p>
      </div>  
      <script>
        window.onload = function()
        {
          // Recarga la pantalla de Usuario nuevamente.
          reloadPage("usuarios")
        }        
      </script>
    ';  
    printf($template,$nuevo_usuario['usuario']);

  }
  else
  {
    // Para generar una vista de no autorizado.
    $controller = new ViewController();
    $controller->load_view('error401');
  }
  

?>
