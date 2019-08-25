<?php
  session_start();
  // Para validar los roles de los usuarios.
  // Solo tiene acceso a esta pantalla el Administrador (1)
  if ($_SESSION['rol'] != 1)
  {
    header ("location: ./");
  }

  include "../conexion.php";
  // Borrar al Usuario, cuando se oprime el boton del formulario de "data_delete"
  if (!empty($_POST))
  {
    // Evitar que el usuario "1" sea eliminado desde el Inspector de elementos del navegador.
    if ($_POST['idusuario']==1)
    {
      header("location: lista_usuarios.php");  
      //mysqli_close($conexion);
      exit;
    }

    $idusuario = $_POST['idusuario'];
    // Para este caso se cambia el valor del campo "estatus = 0"
    // $query_delete = mysqli_query($conexion,"DELETE FROM usuario WHERE idusuario = $idusuario ");
    $query_delete = mysqli_query($conexion,"UPDATE usuario SET estatus = 0  WHERE idusuario = $idusuario ");
    //mysqli_close($conexion);    

    if ($query_delete)
    {
      header("location: lista_usuarios.php");  
    }
    else
    {
      echo "Error al Eliminar";
    }
  }

// $_REQUEST[] =  Esta variable global puede recibir tanto valores de $_POST, $_GET
// Validando que el idusuario no sea 1
  if (empty($_REQUEST['id']) || $_REQUEST['id'] == 1)
  {
    header("location: lista_usuarios.php");    
    mysqli_close($conexion);
  }
  else
  {
    
    $idusuario = $_REQUEST['id'];
    $query = mysqli_query($conexion,"SELECT u.nombre,u.usuario,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.idusuario=$idusuario");
    //mysqli_close($conexion);

    $result = mysqli_num_rows($query);
    if ($result>0)
    {
      while ($data=mysqli_fetch_array($query))
      {
        $nombre = $data['nombre'];
        $usuario = $data['usuario'];
        $rol = $data['rol'];
      }
    }
    else
    {
      header("location: lista_usuarios.php");
    }

  }
?>
<!DOCTYPE html>
<html lang="en">
<!-- Se utiliza esta plantilla, ya que como es el mismo encabezado para todas las opciones del menu. -->

<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>
	<title>Eliminar Usuario</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
      <i class="fas fa-user-times fa-7x" style = "color:#c66262"></i>
      <br/>
      <br/> 
      <h2>Estas Seguro de eliminar el usuario</h2>
      <p>Nombre : <span><?php echo $nombre; ?></span></p>
      <p>Usuario : <span><?php echo $usuario; ?></span></p>
      <p>Rol : <span><?php echo $rol; ?></span></p>
      <!-- Como no tiene "action" se recargara este archivo nuevamentes, ejecuntandose desde el inicio, se anexa un campo "hidden" para mandar el id del usuario --> 
      <form method="post" action="">
        <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">

        <a href ="lista_usuarios.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
        <!-- <input type ="submit" value ="Aceptar" class ="btn_ok"> -->
        <button type ="submit" class ="btn_ok"><i class="far fa-trash-alt"></i> Aceptar</button>
        

      </form>
    </div>

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>