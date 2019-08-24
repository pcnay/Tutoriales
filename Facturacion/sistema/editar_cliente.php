<?php
  session_start();
  
  // todos tienen acceso 
    /*
  if ($_SESSION['rol'] != 1)
  {
    header ("location: ./");
  }
  */

  include "../conexion.php";

// Cuando el usuario oprime el boton de "Actualizar Cliente"
if (!empty($_POST))
{
  $alert = '';
  $option = '';
  if (empty ($_POST['nombre']) || empty ($_POST['telefono']) || empty ($_POST['direccion']))
  {
    $alert = '<p class = "msg_error">Todos los campos son obligatorios</p>';
  }
  else 
  {
    
    $idcliente = $_POST['id'];
    $nit = $_POST['nit'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $result = 0;

    if (is_numeric($nit) and $nit != 0)
    {
      // Revisando que no existe el cliente.
      $query = mysqli_query($conexion,"SELECT * FROM cliente WHERE (nit = '$nit' AND idcliente != $idcliente)");
      $result = mysqli_fetch_array($query);
      $result = count($result);
    }

    /* Para mostrarlo en pantalla, la consulta y se detiene la ejecución del programa.
    echo " SELECT * FROM usuario WHERE (usuario = '$usuario' AND idusuario != $idusuario)
    OR (correo = '$correo' AND idusuario != $idusuario)";
    exit;
    */    

    if ($result > 0)
    {
      $alert = '<p class = "msg_error">El nit ya existe, ingrese otro  </p>';        
    }
    else
    {
      if ($nit == '')
      {
        $nit = 0;
      }
      $sql_update = mysqli_query($conexion,"UPDATE cliente
                                              SET nit = $nit, nombre = '$nombre', telefono='$telefono',direccion = '$direccion' WHERE idcliente = $idcliente");

      if ($sql_update)
      {
        $alert = '<p class= "msg_save">Cliente Actualizado Correctamente</p>';
      }
      else
      {
        $alert = '<p class = "msg_error">Error al Actualiar El Cliente</p>';        
      }
      
      
    } // if ($result > 0)      
    
  } // else if (empty ($_POST['nombre']) ||  

  //mysqli_close($conexion);

} // if (!empty($_POST)) Actualizar Cliente.

  // Recuperar los datos del Cliente.
  // Valida que tenga valor el "id" que se encuentra en la URL. 
  // De estar en blanco se volvera a recargar la página de "lista_usuarios.php".
  if (empty($_REQUEST['id']))
  {
    header ('Location: lista_clientes.php');
    mysqli_close($conexion);
  }
// Se obtiene el valor del id de la URL que se asigna en el href de Listado de Usuarios.
$idcliente = $_REQUEST['id'];
$sql = mysqli_query($conexion,"SELECT * FROM cliente WHERE idcliente = $idcliente");
mysqli_close($conexion);

$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0)
{
  header ('Location: lista_clientes.php');
}
else
{
 while ($data=mysqli_fetch_array($sql))
  {
    $idcliente = $data['idcliente'];
    $nombre = $data['nombre'];
    $nit = $data['nit'];
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

	<title>Actualizar Usuarios</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
    <div class = "form_register">
      <h1>Actualizar Clientes</h1>
      <hr>
      <div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>
      <!-- El formulario se autoprocesa, es decir que cuando se oprima el Input Submit se vuelve a ejecutar el archivos desde el inicio. -->

      <form action ="" method="POST">
        <input type="hidden" name ="id" value="<?php echo $idcliente; ?>">
        <label for="nit">Capturar El NIT</label>
        <input type="number" name="nit" id="nit" placeholder ="Captura el NIT" value ="<?php echo $nit; ?>">
        <label for="nombre">Nombre </label>
        <input type="text" name="nombre" id="nombre" placeholder =" Nombre completo " value ="<?php echo $nombre; ?>">
        <label for="telefono">Telefono</label>
        <input type="number" name="telefono" id="telefono" placeholder ="Numero Telefonico" value ="<?php echo $telefono; ?>">
        <label for="direccion">Direccion</label>
        <input type="text" name="direccion" id="direccion" placeholder ="Direccion completa" value ="<?php echo $direccion; ?>">

        <input type ="submit" value = "Actualizar Cliente" class = "btn_save">

      </form>
      </div>
	
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>