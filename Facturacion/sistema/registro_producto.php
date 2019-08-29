<?php
  session_start();
  //Valida que solo el "Administrador" y "Supervisor"
  if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 )
  {
    header ("location: ./");
  }
  
  include "../conexion.php";
  
  // Cuando se oprime el boton de "Guardar Producto"
  if (!empty($_POST))
  {
    //print_r($_POST);
    //exit;
    // Muestra en arreglo el contenido de los campos del formulario
    
    //print_r($_FILES);
    //exit;
    //Array ( [foto] => Array ( [name] => computadora.jpg [type] => image/jpeg [tmp_name] => /tmp/php9wtJYD [error] => 0 [size] => 7333 ) 

    $alert = '';
    if (empty ($_POST['proveedor']) || empty ($_POST['producto']) || empty ($_POST['precio']) || $_POST['precio'] <= 0 || empty ($_POST['cantidad']) || $_POST['cantidad'] <= 0) 
    {
      $alert = '<p class = "msg_error">Todos los campos son obligatorios</p>';
    }
    else 
    {      
      $proveedor = $_POST['proveedor'];
      $producto = $_POST['producto'];
      $precio = $_POST['precio'];
      $cantidad = $_POST['cantidad'];
      $usuario_id = $_SESSION['idUser']; // Proviene desde el "index.php" donde se loguea el usuario.
  
      //Array ( [foto] => Array ( [name] => computadora.jpg [type] => image/jpeg [tmp_name] => /tmp/php9wtJYD [error] => 0 [size] => 7333 ) 
      $foto = $_FILES['foto'];
      $nombre_foto = $foto['name'];
      $type = $foto['type'];
      $url_temp = $foto['tmp_name'];
      $imgProducto = 'img_producto.png'; // Es una imagen por defecto, si no se agrega foto.

      if ($nombre_foto != '')
      {
        $destino = 'img/uploads/'; // Donde subira la foto.
        $img_nombre = 'img_'.md5(date('d-m-Y H:m:s')); // Nombre foto de forma aleatoria y no se duplicara porque es fecha y hora completa.
        $imgProducto = $img_nombre.'.jpg';
        $src = $destino.$imgProducto;
      }
           
        //echo "INSERT INTO cliente (nit,nombre,telefono,direccion,usuario_id) VALUES('$nit','$nombre','$telefono','$direccion','$usuario_id')";
        //exit;


      $query_insert = mysqli_query($conexion,"INSERT INTO producto(codproducto,proveedor,descripcion,precio,existencia,usuario_id,foto) VALUES(0,$proveedor,'$producto',$precio,$cantidad,$usuario_id,'$imgProducto')");

        //echo "INSERT INTO proveedor (codproveedor,proveedor,contacto,telefono,direccion,usuario_id) VALUES(0,'$proveedor','$contacto',$telefono,'$direccion',$usuario_id)";
        // exit;

        if ($query_insert)
        {
          if ($nombre_foto != '')
          {
            move_uploaded_file($url_temp,$src); //Sube la imagen al servidor. 
          }
          $alert = '<p class= "msg_save">Producto Guardado Correctamente</p>';
        }
        else
        {
          $alert = '<p class = "msg_error">Error al Guardar El Producto</p>';        
        }
    
    } // if (empty ($_POST['nombre']) ||, ......

   //mysqli_close($conexion);

  } // if (!empty($_POST))
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>

	<title>Registro Producto</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
    <div class = "form_register">
      <h1><i class="far fas-cubes"></i> Registro Productos</h1>
      <hr>
      <div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>
      <!-- enctype="multipart/form-data" = Capacidad para adjuntar archivos-->
      <form action ="" method="POST" enctype="multipart/form-data">
        
        <label for="proveedor">Proveedor</label>
        <!-- Se agrega el combo Box de proveedor -->
        <?php 
          $query_proveedor = mysqli_query($conexion,"SELECT codproveedor,proveedor FROM proveedor WHERE estatus=1 ORDER BY proveedor ASC");
          $result_proveedor = mysqli_num_rows($query_proveedor);
          mysqli_close($conexion);          
        ?>

        <select name="proveedor" id="proveedor">
        <?php 
          if ($result_proveedor > 0)
          {
            while ($proveedor = mysqli_fetch_array($query_proveedor))
            {
        ?>
              <option value = "<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
        <?php
            }
          }
        ?>
          
        </select>

        <label for="producto">Producto</label>
        <input type="text" name="producto" id="producto" placeholder =" Nombre Del Producto">
        <label for="precio">Precio</label>
        <input type="number" name="precio" id="precio" placeholder ="Precio del Producto">
        <label for="Existencia">Cantidad</label>
        <input type="number" name="cantidad" id="cantidad" placeholder ="Cantidad del Producto">

        <!-- Para adjuntar la foto --> 
        <div class="photo">
          <label for="foto">Fotos</label>
          <div class="prevPhoto">
            <span class="delPhoto notBlock">X</span>
            <label for="foto"></label>
          </div>
          <div class="upimg">
            <input type="file" name="foto" id="foto">
          </div>
          <div id="form_alert"></div>
        </div>

        <button type="submit" class = "btn_save"><i class="far fa-save fa-lg"></i> Guardar Producto</button>
        <!-- <input type ="submit" value = "Guardar Cliente" class = "btn_save"> -->

      </form>
    </div>
	
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>