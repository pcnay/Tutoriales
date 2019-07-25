<?php
  $usuarios_controller = new UsuariosController();

if(($_POST['r']=='usuarios-edit') && ($_SESSION['perfil']=='Admin') && (!isset($_POST['crud'])))
{  
  $usuario = $usuarios_controller->get($_POST['usuario']); // Obtiene el registro del usuario en cuestion, viene del formaulario de Usuarios, cuando se muestran todos.
  
    // var_dump($usuarios); Convierte de objeto a cadena de texto
  
  if (empty($usuario))
  {
    
    $template = ' 
      <div class= "container">
          <p class="item error ">NO EXISTE LA EL USUARIO <b>%s</b></p>          
      </div>
      
      <script>
        window.onload = function()
        {
          reloadPage("usuarios")
        }
      </script>
      
    ';
    printf($template,$_POST['usuario']);
  }
  else
  {
    // Se debe traer los datos de la pantalla para poder editarlo.
    // Asignado el valor de "radio" para ser desplegado.
    $perfil_admin = ($usuario[0]['perfil']=='Admin')? 'checked':' ';
    $perfil_user = ($usuario[0]['perfil']=='User')? 'checked':' ';

    $template_usuario = ' 
      <h2 class= "p1">Editar Usuario</h2>
      <form method = "POST" class = "item">
        <div class="p_25">
          <!-- Es el campo llave de la tabla, por esta razon esta deshabilitado-->
          <input type="text" placeholder="usuario" value="%s" disabled required>
          <input type ="hidden" name="usuario" value="%s">
        </div>
        <div class="p_25">
          <input type="email" name="email" placeholder="Correo Electronico" value="%s" required> 
        </div>
        <div class="p_25">
          <input type="text" name="nombre" placeholder="nombre" value="%s" required> 
        </div>
        <div class="p_25">
          <input type="text" name="cumpleanos" placeholder="cumpleaños" value="%s" required> 
        </div>
        <div class="p_25">
        <!-- El usuario debe teclear el password de nuevo, aun cuando lo lo cambie
          Si se despliega el valor del Password que esta en la tabla de Usuarios, a este valor le aplicará el MD5, por lo que la clave se perdera.
        -->
          <input type="password" name="clave" placeholder="Clave" value="" required> 
        </div>
        <div class="p_25">
          <input type="radio" name="perfil" id="admin" value="Admin" %s required><label for ="admin">Administrador</label>
          <input type="radio" name="perfil" id="noadmin" value="User" %s required><label for ="noadmin">Usuario</label>
        </div>


        <div class="p_25">
          <input class ="button edit" type = "submit" value="Editar">           
          <input type="hidden" name = "r" value = "usuarios-edit">
          <input type="hidden" name = "crud" value = "set">
        </div>
      </form>
    ';
  // Como se autoprocesa el formulario (No tiene "action"), es decir continua con el flujo de forma descendente, llegando al "else if ( ($_POST['r']=='usuarios-edit') ...
   printf (
    $template_usuario,
    $usuario[0]['usuario'],
    $usuario[0]['usuario'],
    $usuario[0]['email'],
    $usuario[0]['nombre'],
    $usuario[0]['cumpleanos'],
    // $usuario[0]['clave'], El usuario debe escribir la contraseña.
    $perfil_admin,
    $perfil_user
  );
 }

}

 else if ( ($_POST['r']=='usuarios-edit') && ($_SESSION['perfil']=='Admin') && ($_POST['crud']=='set'))
 {
   // Se programa la inserción de datos, de los datos capturados del usuario.
   $salvar_usuario = array(
     'usuario' => $_POST['usuario'],
     'nombre' => $_POST['nombre'],
     'email' => $_POST['email'],
     'cumpleanos' => $_POST['cumpleanos'],
     'clave' => $_POST['clave'],
      'perfil' => $_POST['perfil']
   );

   $usuario = $usuarios_controller->set($salvar_usuario);
   $template = '
     <div class="container">
       <p class="item edit">Usuario <b>%s</b> Guardado </p>
     </div> 
     <script>
       window.onload = function()
       {
         // Recarga la pantalla de Clientes nuevamente.
         reloadPage("usuarios")
       }       
     </script>
   '; 
   printf($template,$salvar_usuario['usuario']);

 }
 else
 {
   // Para generar una vista de no autorizado.
   $controller = new ViewController();
   $controller->load_view('error401');
 }

?>
