<?php
  session_start();
  //Valida que solo el "Administrador" y "Supervisor"
  if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 )
  {
    header ("location: ./");
  }
  
  include "../conexion.php";
  
  // Cuando se oprime el boton de "Guardar Proveedor"
  if (!empty($_POST))
  {
    $alert = '';
    if (empty ($_POST['proveedor']) || empty ($_POST['contacto']) || empty ($_POST['telefono']) || empty ($_POST['direccion']))
    {
      $alert = '<p class = "msg_error">Todos los campos son obligatorios</p>';
    }
    else 
    {      
      $proveedor = $_POST['proveedor'];
      $contacto = $_POST['contacto'];
      $telefono = $_POST['telefono'];
      $direccion = $_POST['direccion'];
      $usuario_id = $_SESSION['idUser']; // Proviene desde el "index.php" donde se loguea el usuario.
      
        //echo "INSERT INTO cliente (nit,nombre,telefono,direccion,usuario_id) VALUES('$nit','$nombre','$telefono','$direccion','$usuario_id')";
        //exit;


      $query_insert = mysqli_query($conexion,"INSERT INTO proveedor(codproveedor,proveedor,contacto,telefono,direccion,usuario_id) VALUES(0,'$proveedor','$contacto',$telefono,'$direccion',$usuario_id)");

        //echo "INSERT INTO proveedor (codproveedor,proveedor,contacto,telefono,direccion,usuario_id) VALUES(0,'$proveedor','$contacto',$telefono,'$direccion',$usuario_id)";
        // exit;

        if ($query_insert)
        {
          $alert = '<p class= "msg_save">Proveedor Guardado Correctamente</p>';
        }
        else
        {
          $alert = '<p class = "msg_error">Error al Guardar Cliente</p>';        
        }
    
    } // if (empty ($_POST['nombre']) ||, ......

   mysqli_close($conexion);

  } // if (!empty($_POST))
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>

	<title>Registro Proveedor</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
    <div class = "form_register">
      <h1><i class="far fa-building"></i> Registro Proveedores</h1>
      <hr>
      <div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>

      <form action ="" method="POST">
        <label for="proveedor">Proveedor</label>
        <input type="text" name="proveedor" id="proveedor" placeholder ="Nombre Proveedor">
        <label for="contacto">Contacto</label>
        <input type="text" name="contacto" id="contacto" placeholder =" Nombre Del Contacto">
        <label for="telefono">Telefono</label>
        <input type="number" name="telefono" id="telefono" placeholder ="Numero Telefonico">
        <label for="direccion">Direccion</label>
        <input type="text" name="direccion" id="direccion" placeholder ="Direccion completa">

        <button type="submit" class = "btn_save"><i class="far fa-save fa-lg"></i> Guardar Proveedor</button>
        <!-- <input type ="submit" value = "Guardar Cliente" class = "btn_save"> -->

      </form>
    </div>
	
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>