<?php
// Esta valor proviene del archivo "functions.js" seccion "Ajax" -> $('.add_product').click(function(e)
  //print_r($_POST);
  //exit;

  include ("../conexion.php");
  session_start(); // Se inicia la sesion ya que se utiliza para insertar datos en la tabla de "Entrada"

  if (!empty($_POST))
  {
    if ($_POST['action'] == 'infoProducto')
    {
      //Extraer los datos del producto, para que los despliegue en la ventana Modal.
      $producto_id = $_POST['producto'];
      $query = mysqli_query($conexion,"SELECT codproducto,descripcion FROM producto WHERE codproducto = $producto_id AND estatus = 1");
      mysqli_close($conexion);

      $result = mysqli_num_rows($query);
      if ($result>0)
      {
        $data = mysqli_fetch_assoc($query);
        // el arreglo "$data" se devuelve en formato JSON y los caracteres raros tildes los pasa a textos, 
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        exit;
      }
      echo 'error';
      exit;
    }

    // Agregar de la tabla "producto" a la tabla "entrada"
    if ($_POST['action'] == 'addProduct')
    {
      // echo "Agregar Producto";
      if (!empty($_POST['cantidad']) || !empty($_POST['precio']) || !empty($_POST['producto_id']))
      {
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $producto_id = $_POST['producto_id'];
        $usuario_id = $_SESSION['idUser'];

        // Registra las entradas del producto a la tabla de "Entradas" 
        $query_insert = mysqli_query($conexion,"INSERT INTO entradas(codproducto,cantidad,precio,usuario_id) VALUES($producto_id,$cantidad,$precio,$usuario_id) ");

        if ($query_insert)
        {
          // Ejecutar el procedimiento Almacenado, para solo actualizar la "existencia" y el "precio" (utilizando Precio promedio ponderado). a la tabla "Producto"
          $query_upd = mysqli_query($conexion,"CALL actualizar_precio_producto($cantidad,$precio,$producto_id)");
          // Determina si hay registros en la consulta, son los que arroja el procedimiento almacenado.
          $result_pro = mysqli_num_rows($query_upd);
          if ($result_pro > 0)
          {
            $data = mysqli_fetch_assoc($query_upd);
            $data['producto_id'] = $producto_id;
            // el arreglo "$data" se devuelve en formato JSON y los caracteres raros tildes los pasa a textos  
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            exit;    
          }
          else
          {
            echo 'Error';
          }
          mysqli_close($conexion);

        } // if ($query_insert)        

      } // if (!empty($_POST['cantidad']) || !empty($_POST['precio']) || !empty($_POST
      else
      {
        echo "Error";
      }

      exit;  
    } // if ($_POST['action'] == 'infoProducto') 

  } // if (!empty($_POST))
  //exit;
?> 