<?php
  session_start();
  // Para validar los roles de los usuarios.
  // Solo tiene acceso a esta pantalla el Administrador (1) y Supervisor
  if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 )
  {
    header ("location: ./");
  }

  include "../conexion.php";
  // Borrar el Proveedor, cuando se oprime el boton del formulario de "data_delete"
  if (!empty($_POST))
  {
    if (empty($_POST['codproveedor']))
    {
      header("location: lista_proveedor.php");
      mysqli_close($conexion);
    }

    $codproveedor = $_POST['codproveedor'];
    // Para este caso se cambia el valor del campo "estatus = 0"
    // $query_delete = mysqli_query($conexion,"DELETE FROM proveedor WHERE codproveedor = $codproveedor");
    $query_delete = mysqli_query($conexion,"UPDATE proveedor SET estatus = 0  WHERE codproveedor = $codproveedor");
    mysqli_close($conexion);    

    if ($query_delete)
    {
      header("location: lista_proveedor.php");  
    }
    else
    {
      echo "Error al Eliminar";
    }
  }

// $_REQUEST[] =  Esta variable global puede recibir tanto valores de $_POST, $_GET
// Validando que el idproveedor existe en la base de datos.
  if (empty($_REQUEST['id']))
  {
    header("location: lista_proveedor.php");    
    mysqli_close($conexion);
  }
  else
  {    
    $codproveedor = $_REQUEST['id'];
    $query = mysqli_query($conexion,"SELECT * FROM proveedor WHERE codproveedor=$codproveedor");
    mysqli_close($conexion);

    $result = mysqli_num_rows($query);
    if ($result>0)
    {
      while ($data=mysqli_fetch_array($query))
      {
        $proveedor = $data['proveedor'];        
      }
    }
    else
    {
      header("location: lista_proveedor.php");
    }

  }
?>
<!DOCTYPE html>
<html lang="en">
<!-- Se utiliza esta plantilla, ya que como es el mismo encabezado para todas las opciones del menu. -->

<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>
	<title>Eliminar Proveedor</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
      <i class="far fa-building fa-7x" style="color:#e66262"></i>
      <br><br>
      <h2>Estas Seguro de eliminar el Proveedor ?</h2>
      <p>Proveedor : <span><?php echo $proveedor; ?></span></p>
       <!-- Como no tiene "action" se recargara este archivo nuevamentes, ejecuntandose desde el inicio, se anexa un campo "hidden" para mandar el id del usuario --> 
      <form method="post" action="">
        <input type="hidden" name="codproveedor" value="<?php echo $codproveedor; ?>">
        |
        <a href ="lista_proveedor.php" class="btn_cancel"><i class="fas fa-ban"></i>Cancelar</a>
        <button type="submit" class ="btn_ok"><i class="far fa-trash-alt"></i>Eliminar </button>
        <!-- <input type ="submit" value ="Eliminar" class ="btn_ok">  -->
      </form>
    </div>

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>