<?php
  // Para validar los roles de los usuarios.
  // Solo tiene acceso a esta pantalla el Administrador (1)
  session_start();
  if ($_SESSION['rol'] != 1)
  {
    header ("location: ./");
  }

  include "../conexion.php";
  
  if (!empty($_POST))
  {
    $alert = '';
    if (empty ($_POST['nombre']) || empty ($_POST['correo']) || empty ($_POST['usuario']) || empty ($_POST['clave']) || empty ($_POST['rol']) )
    {
      $alert = '<p class = "msg_error">Todos los campos son obligatorios</p>';
    }
    else 
    {
      //Se retorna una carpeta, ya que este archivo se encuentra en el subdirectorio "sistema"
      
      $nombre = $_POST['nombre'];
      $correo = $_POST['correo'];
      $usuario = $_POST['usuario'];
      $clave = MD5($_POST['clave']);
      $rol = $_POST['rol'];

      // Revisando que no existe el correo y usuario.
      $query = mysqli_query($conexion,"SELECT * FROM usuario WHERE usuario = '$usuario' OR correo = '$correo'");
      mysqli_close($conexion);

      $result = mysqli_fetch_array($query);
      if ($result > 0)
      {
        $alert = '<p class = "msg_error">El correo y/o usuario ya existe </p>';        
      }
      else
      {
        // $rol = es de tipo entero, por esta razon no es entre comillas
        $query_insert = mysqli_query($conexion,"INSERT INTO usuario (idusuario,nombre,correo,usuario,clave,rol) 
                                                VALUE (0,'$nombre','$correo','$usuario','$clave',$rol)");
        if ($query_insert)
        {
          $alert = '<p class= "msg_save">Usuario Creado Correctamente</p>';
        }
        else
        {
          $alert = '<p class = "msg_error">Error al Crear El Usuario</p>';        
        }
      }

    }

  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>

	<title>Registro Usuarios</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
    <div class = "form_register">
      <h1>Registro Usuarios</h1>
      <hr>
      <div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>

      <form action ="" method="POST">
        <label for="nombre">Nombre </label>
        <input type="text" name="nombre" id="nombre" placeholder =" Nombre completo">
        <label for="correo">Correo Electronico </label>
        <input type="email" name="correo" id="correo" placeholder ="Correo Electronico">
        <label for="usuario">Usuario </label>
        <input type="text" name="usuario" id="usuario" placeholder ="Usuario">
        <label for="clave">Clave</label>
        <input type="password" name="clave" id="clave" placeholder ="Clave de acceso">
        <label for="rol">Tipo Usuario</label>

        <?php
          $query_rol = mysqli_query($conexion,"SELECT * FROM rol ");
          mysqli_close($conexion);
          $result_rol = mysqli_num_rows($query_rol);
        ?>
        
        <!-- Para obtener los registros de la tabla "rol" -->
        <select name = "rol" id = "rol">
          <?php
            if ($result_rol > 0)
            {
              while ($rol = mysqli_fetch_array($query_rol))
              {
          ?> 
                <option value = "<?php echo $rol['idrol']; ?>"><?php echo $rol['rol']; ?> </option>
          <?php
              }
            }
          ?>
            
        </select>
        <input type ="submit" value = "Crear usuario" class = "btn_save">



      </form>
    </div>
	
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>