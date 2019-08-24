<?php
  session_start();
    /* 
  Desactiva para ser usado por cualquier usuario.
  if ($_SESSION['rol'] != 1)
  {
    header ("location: ./");
  }
  */

  include "../conexion.php";
  
  if (!empty($_POST))
  {
    $alert = '';
    if (empty ($_POST['nombre']) || empty ($_POST['telefono']) || empty ($_POST['direccion']))
    {
      $alert = '<p class = "msg_error">Todos los campos son obligatorios</p>';
    }
    else 
    {      
      $nit = $_POST['nit'];
      $nombre = $_POST['nombre'];
      $telefono = $_POST['telefono'];
      $direccion = $_POST['direccion'];
      $usuario_id = $_SESSION['idUser']; // Proviene desde el "index.php" donde se loguea el usuario.
      
      $result = 0;
      if (is_numeric($nit) and $init != 0)
      {
        $query = mysqli_query($conexion,"SELECT * FROM cliente WHERE nit  = '$nit'");
        $result = mysqli_fetch_array($query);  
      }

      // Determina si existe el "NIT".
      if ($result >0)
      {
        $alert = '<p class = "msg_error">El número de NIT ya Existe</p>';       
      }
      else
      {
        //echo "INSERT INTO cliente (nit,nombre,telefono,direccion,usuario_id) VALUES('$nit','$nombre','$telefono','$direccion','$usuario_id')";
        //exit;

          $query_insert = mysqli_query($conexion,"INSERT INTO cliente (nit,nombre,telefono,direccion,usuario_id) 
          VALUES('$nit','$nombre',$telefono,'$direccion',$usuario_id)");

        if ($query_insert)
        {
          $alert = '<p class= "msg_save">Cliente Guardado Correctamente</p>';
        }
        else
        {
          $alert = '<p class = "msg_error">Error al Guardar Cliente</p>';        
        }

      } // if ($result > 0)

    } // if (empty ($_POST['nombre']) ||, ......

      //mysqli_close($conexion);

  } // if (!empty($_POST))
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>

	<title>Registro Clientes</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
    <div class = "form_register">
      <h1>Registro Clientes</h1>
      <hr>
      <div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>

      <form action ="" method="POST">
        <label for="nit">Capturar El NIT</label>
        <input type="number" name="nit" id="nit" placeholder ="Captura el NIT">
        <label for="nombre">Nombre </label>
        <input type="text" name="nombre" id="nombre" placeholder =" Nombre completo">
        <label for="telefono">Telefono</label>
        <input type="number" name="telefono" id="telefono" placeholder ="Numero Telefonico">
        <label for="direccion">Direccion</label>
        <input type="text" name="direccion" id="direccion" placeholder ="Direccion completa">

        <input type ="submit" value = "Guardar Cliente" class = "btn_save">

      </form>
    </div>
	
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>