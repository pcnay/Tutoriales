<?php
// Esta valor proviene del archivo "functions.js" seccion "Ajax" -> $('.add_product').click(function(e)
  //print_r($_POST);
  //exit;

  include ("../conexion.php");
  if (!empty($_POST))
  {
    if ($_POST['action'] == 'infoProducto')
    {
      //Extraer los datos del producto.
      $producto_id = $_POST['producto'];
      $query = mysqli_query($conexion,"SELECT codproducto,descripcion FROM producto WHERE codproducto = $producto_id AND estatus = 1");
      mysqli_close($conexion);
      $result = mysqli_num_rows($query);
      if ($result>0)
      {
        $data = mysqli_fetch_assoc($query);
        // el arraeglo "$data" se devuelve en formato JSON y los caracteres raros tildes los pasa a textos, 
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        exit;
      }
      echo 'error';
      exit;
    }

  }
?>