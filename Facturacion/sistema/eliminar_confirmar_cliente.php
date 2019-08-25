<?php
  session_start();
  // Para validar los roles de los usuarios.
  // Solo tiene acceso a esta pantalla el Administrador (1)
  if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 )
  {
    header ("location: ./");
  }

  include "../conexion.php";
  // Borrar al Cliente, cuando se oprime el boton del formulario de "data_delete"
  if (!empty($_POST))
  {
    if (empty($_POST['idcliente']))
    {
      header("location: lista_clientes.php");
      mysqli_close($conexion);
    }

    $idcliente = $_POST['idcliente'];
    // Para este caso se cambia el valor del campo "estatus = 0"
    // $query_delete = mysqli_query($conexion,"DELETE FROM usuario WHERE idusuario = $idusuario ");
    $query_delete = mysqli_query($conexion,"UPDATE cliente SET estatus = 0  WHERE idcliente = $idcliente ");
    mysqli_close($conexion);    

    if ($query_delete)
    {
      header("location: lista_clientes.php");  
    }
    else
    {
      echo "Error al Eliminar";
    }
  }

// $_REQUEST[] =  Esta variable global puede recibir tanto valores de $_POST, $_GET
// Validando que el idcliente existe en la base de datos.
  if (empty($_REQUEST['id']))
  {
    header("location: lista_clientes.php");    
    mysqli_close($conexion);
  }
  else
  {    
    $idcliente = $_REQUEST['id'];
    $query = mysqli_query($conexion,"SELECT * FROM cliente WHERE idcliente=$idcliente");
    mysqli_close($conexion);

    $result = mysqli_num_rows($query);
    if ($result>0)
    {
      while ($data=mysqli_fetch_array($query))
      {
        $nit = $data['nit'];
        $nombre = $data['nombre'];        
      }
    }
    else
    {
      header("location: lista_clientes.php");
    }

  }
?>
<!DOCTYPE html>
<html lang="en">
<!-- Se utiliza esta plantilla, ya que como es el mismo encabezado para todas las opciones del menu. -->

<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>
	<title>Eliminar Cliente</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
      <h2>Estas Seguro de eliminar el cliente</h2>
      <p>Nombre : <span><?php echo $nombre; ?></span></p>
      <p>Nit : <span><?php echo $nit; ?></span></p>      
      <!-- Como no tiene "action" se recargara este archivo nuevamentes, ejecuntandose desde el inicio, se anexa un campo "hidden" para mandar el id del usuario --> 
      <form method="post" action="">
        <input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">

        <a href ="lista_clientes.php" class="btn_cancel">Cancelar</a>
        <input type ="submit" value ="Eliminar" class ="btn_ok">   
      </form>
    </div>

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>