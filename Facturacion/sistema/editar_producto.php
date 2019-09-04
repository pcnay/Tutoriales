<?php
  session_start();
  //Valida que solo el "Administrador" y "Supervisor"
  if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 )
  {
    header ("location: ./");
  }
  
  include "../conexion.php";
  
  // Cuando se oprime el boton de "Actualizar Producto"
  if (!empty($_POST))
  {
    //print_r($_POST);
    //exit;
    // Muestra en arreglo el contenido de los campos del formulario
    
    //print_r($_FILES);
    //exit;
    //Array ( [foto] => Array ( [name] => computadora.jpg [type] => image/jpeg [tmp_name] => /tmp/php9wtJYD [error] => 0 [size] => 7333 ) 

    $alert = '';
    if (empty ($_POST['proveedor']) || empty ($_POST['producto']) || empty ($_POST['precio']) || empty($_POST['id']) || empty($_POST['foto_actual']) || empty($_POST['foto_remove'])) 
    {
      $alert = '<p class = "msg_error">Todos los campos son obligatorios</p>';
    }
    else 
    {      
      $codproducto = $_POST['id'];
      $proveedor = $_POST['proveedor'];
      $producto = $_POST['producto'];
      $precio = $_POST['precio'];
      $imgProducto = $_POST['foto_actual'];
      $imgRemove = $_POST['foto_remove'];
        
      //Array ( [foto] => Array ( [name] => computadora.jpg [type] => image/jpeg [tmp_name] => /tmp/php9wtJYD [error] => 0 [size] => 7333 ) 
      $foto = $_FILES['foto'];
      $nombre_foto = $foto['name'];
      $type = $foto['type'];
      $url_temp = $foto['tmp_name'];
      $upd = ''; // 

      if ($nombre_foto != '')
      {
        $destino = 'img/uploads/'; // Donde subira la foto.
        $img_nombre = 'img_'.md5(date('d-m-Y H:m:s')); // Nombre foto de forma aleatoria y no se duplicara porque es fecha y hora completa.
        $imgProducto = $img_nombre.'.jpg';
        $src = $destino.$imgProducto;
      }
      else
      {
        if ($_POST['foto_actual'] != $_POST['foto_remove'])
        {
          $imgProducto = 'img_producto.png';
        }
      }
           
       //echo "INSERT INTO cliente (nit,nombre,telefono,direccion,usuario_id) VALUES('$nit','$nombre','$telefono','$direccion','$usuario_id')";
        //exit;

      // Actualizando los daos del producto
      $query_update = mysqli_query($conexion,"UPDATE producto 
        SET descripcion = '$producto',
            proveedor = $proveedor,
            precio = $precio,
            foto = '$imgProducto'
        WHERE codproducto = $codproducto");

      if ($query_update)
        {
          if (($nombre_foto != '' && ($_POST['foto_actual'] != 'img_producto.png')) || ($_POST['foto_actual'] != $_POST['foto_remove']))
          {
            unlink ('img/uploads/',$_POST['foto_actual']);
          }

          if ($nombre_foto != '')
          {
            move_uploaded_file($url_temp,$src); //Sube la imagen al servidor. 
          }
          $alert = '<p class= "msg_save">Producto Actualizado Correctamente</p>';
        }
        else
        {
          $alert = '<p class = "msg_error">Error al Actualizar El Producto</p>';        
        }
    
    } // if (empty ($_POST['nombre']) ||, ......

   //mysqli_close($conexion);

  } // if (!empty($_POST))
  // Validar Producto
  // Valida si el "id" tenga valor (Se puede eliminar por la URL),
  // $_REQUEST = Recibe valor por $_GET, o $_POST
  if (empty($_REQUEST['id']))
  {
    header("location:lista_producto.php");    
  }
  else
  {
    $id_producto = $_REQUEST['id'];
    if (!is_numeric($id_producto))
    {
      header ("location:lista_producto.php");
    }

    // Se van a extraer los datos del producto que se va a editar, se crearan relaciones con INNER JOIN
    $query_producto = mysqli_query($conexion,"SELECT p.codproducto,p.descripcion,                                                                   p.precio,p.foto,pr.codproveedor,pr.proveedor 
                                    FROM producto p
                                    INNER JOIN proveedor pr 
                                    ON p.proveedor = pr.codproveedor 
                                    WHERE p.codproducto = $id_producto AND p.estatus = 1");
    $result_producto = mysqli_num_rows($query_producto);

    // Para desplegar la foto al editar el producto 
    $foto = '';
    $classRemove = 'notBlock';
    
    if ($result_producto > 0)
    {
      $data_producto = mysqli_fetch_assoc($query_producto);
      if($data_producto['foto'] != 'img_producto.png')
      {
        //Desplegando la imagen
        $classRemove = '';
        $foto = '<img id = "img" src = "img/uploads/'.$data_producto['foto'].' " alt = "Producto" ';
      }

      // se revisa el contenido del arreglo "$data_producto"
      print_r($data_producto);
      //exit;
    }
    else
    {
      header ("location:lista_producto.php");
    }

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>

	<title>Actualizar Producto</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
    <div class = "form_register">
      <h1><i class="fas fa-cube"></i> Actualizar Producto</h1>
      <hr>
      <div class="alert"><?php echo isset($alert) ? $alert: ''; ?></div>
      <!-- enctype="multipart/form-data" = Capacidad para adjuntar archivos-->
      <form action ="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name = "id" value = "<?php echo $data_producto['codproducto']; ?>">
        <input type="hidden" id="foto_actual" name="foto_actual" value="<?php echo $data_producto['foto']; ?>">
        <input type="hidden" id="foto_remove" name="foto_remove" value="<?php echo $data_producto['foto']; ?>">

        <label for="proveedor">Proveedor</label>
        <!-- Se agrega el combo Box de proveedor -->
        <?php 
          $query_proveedor = mysqli_query($conexion,"SELECT codproveedor,proveedor FROM proveedor WHERE estatus=1 ORDER BY proveedor ASC");
          $result_proveedor = mysqli_num_rows($query_proveedor);
          mysqli_close($conexion);          
        ?>

        <!-- "notItemOne" para no mostrar el primer elemento del combobox -->
        <select name="proveedor" id="proveedor" class="notItemOne">
        <!-- Se seleccionara el proveedor que se encuentra grabado en la base de datos .-->
        <option value = "<?php echo $data_producto['codproducto']; ?>" selected><?php echo $data_producto['proveedor']; ?></option>

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
        <input type="text" name="producto" id="producto" placeholder =" Nombre Del Producto" value = "<?php echo $data_producto['descripcion']; ?>">
        <label for="precio">Precio</label>
        <input type="number" name="precio" id="precio" placeholder ="Precio del Producto" value = "<?php echo $data_producto['precio']; ?>">
          <!-- Se suprime el input de "Cantidad-Existencia" ya que esta se modifica de acuerdo a "Entradas" y "Salidas"-->

        <!-- Para adjuntar la foto --> 
        <div class="photo">
          <label for="foto">Fotos</label>
          <div class="prevPhoto">
            <span class="delPhoto <?php $classRemove; ?>">X</span>
            
            <label for="foto"></label>
              <?php echo $foto; ?>
          </div>
          <div class="upimg">
            <input type="file" name="foto" id="foto">
          </div>
          <div id="form_alert"></div>
        </div>

        <button type="submit" class = "btn_save"><i class="far fa-save fa-lg"></i> Actualizar Producto</button>
        <!-- <input type ="submit" value = "Guardar Cliente" class = "btn_save"> -->

      </form>
    </div>
	
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>