<?php
  session_start();
  // Solo tienen accesos el "Administrador" y "Supervisor"
    
  if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
  {
    header ("location: ./");
  }

  include "../conexion.php";

// Cuando el usuario oprime el boton de "Actualizar Proveedor"
if (!empty($_POST))
{
  $alert = '';
  
  if (empty ($_POST['proveedor']) || empty ($_POST['contacto']) || empty ($_POST['telefono']) || empty ($_POST['direccion']))
  {
    $alert = '<p class = "msg_error">Todos los campos son obligatorios</p>';
  }
  else 
  {
    // Inicia la sección para actualizar al Proveedor.
    $codproveedor = $_POST['id'];
    $proveedor = $_POST['proveedor'];
    $contacto = $_POST['contacto'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $result = 0;

      $sql_update = mysqli_query($conexion,"UPDATE proveedor
                                              SET proveedor = '$proveedor', contacto = '$contacto', telefono='$telefono',direccion = '$direccion' WHERE codproveedor = $codproveedor");

      if ($sql_update)
      {
        $alert = '<p class= "msg_save">Proveedor Actualizado Correctamente</p>';
      }
      else
      {
        $alert = '<p class = "msg_error">Error al Actualiar El Proveedor</p>';        
      }     
      
    
  } // else if (empty ($_POST['nombre']) ||  

  //mysqli_close($conexion);

} // if (!empty($_POST)) Actualizar Cliente.

  // Recuperar los datos del Proveedor.
  // Valida que tenga valor el "id" que se encuentra en la URL. 
  // De estar en blanco se volvera a recargar la página de "lista_proveedor.php".
  if (empty($_REQUEST['id']))
  {
    header ('Location: lista_proveedor.php');
    mysqli_close($conexion);
  }

// Se obtiene el valor del id de la URL que se asigna en el href de Listado de Proveedores.
$codproveedor = $_REQUEST['id'];

$sql = mysqli_query($conexion,"SELECT * FROM proveedor WHERE codproveedor = $codproveedor AND estatus=1");
mysqli_close($conexion);

$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0)
{
  header ('Location: lista_proveedor.php');
}
else
{
 while ($data=mysqli_fetch_array($sql))
  {
    $codproveedor = $data['codproveedor'];
    $proveedor = $data['proveedor'];
    $contacto = $data['contacto'];
    $telefono = $data['telefono'];
    $direccion = $data['direccion'];

  }
}

?>  
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>

	<title>Actualizar Proveedor</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
    <div class = "form_register">
      <h1><i class="far fa-edit"></i> Actualizar Proveedor</h1>
      <hr>
      <div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>
      <!-- El formulario se autoprocesa, es decir que cuando se oprima el Input Submit se vuelve a ejecutar el archivos desde el inicio. -->

      <form action ="" method="POST">
        
        <label for="proveedor">Proveedor</label>
        <input type="text" name="proveedor" id="proveedor" placeholder ="Nombre Proveedor" value = "<?php echo $proveedor; ?>">
        <label for="contacto">Contacto</label>
        <input type="text" name="contacto" id="contacto" placeholder =" Nombre Del Contacto" value = "<?php echo $contacto; ?>">
        <label for="telefono">Telefono</label>
        <input type="number" name="telefono" id="telefono" placeholder ="Numero Telefonico" value = "<?php echo $telefono; ?>">
        <label for="direccion">Direccion</label>
        <input type="text" name="direccion" id="direccion" placeholder ="Direccion completa" value = "<?php echo $direccion; ?>">

        <!-- Campo oculto no se muesta en pantalla y se utiliza para pasar información desde el Formulario. -->
        <input type = "hidden" name="id" value = "<?php echo $codproveedor; ?>">

        <button type="submit" class = "btn_save"><i class="far fa-edit"></i> Actualizar Proveedor</button>   
        <!--<input type ="submit" value = "Actualizar Cliente" class = "btn_save"> -->

      </form>
      </div>
	
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>