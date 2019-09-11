<?php
// Esta valor proviene del archivo "functions.js" seccion "Ajax" -> $('.del_product').click(function(e)

  include ("../conexion.php");
  session_start(); // Se inicia la sesion ya que se utiliza para insertar datos en la tabla de "Entrada"
  //print_r($_POST);exit;

  if (!empty($_POST))
  {
    // Son las acciones que realizara, de acuerdo con la informacion, desde Ajax
    if ($_POST['action'] == 'infoProducto')
    {
      //Extraer los datos del producto, para que los despliegue en la ventana Modal.
      $producto_id = $_POST['producto'];
      $query = mysqli_query($conexion,"SELECT codproducto,descripcion,existencia,precio FROM producto WHERE codproducto = $producto_id AND estatus = 1");
      mysqli_close($conexion);

      $result = mysqli_num_rows($query);
      if ($result>0)
      {
        $data = mysqli_fetch_assoc($query);
        // el arreglo "$data" se devuelve en formato JSON y los caracteres raros tildes los pasa a textos, 
        echo json_encode($data,JSON_UNESCAPED_UNICODE); // Retorna a "Functions.js"  si no hay error
        exit;
      }
      echo 'error'; // Retorna a "Functions.js"  si hay error
      exit;
    }

    // Son las acciones que realizara, de acuerdo con la informacion, esta información viene desde "functions.js" -> "addProduct" seccion de "Ajax"    
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

    // Son las acciones que realizara, de acuerdo con la informacion, esta información viene desde "functions.js" -> "delProduct" seccion de "Ajax"
    
    if ($_POST['action'] == 'delProduct')
    {

      // Probar que ingresa a esta condicion
      // 'producto_id' viene desde "$('.del_product').click(function(e)" cuando se hace click en el boton de "Eliminar"
      if (empty($_POST['producto_id']) || !is_numeric($_POST['producto_id']))
      {
        echo "Error Codigo Producto Vacio o no es numerico ";
      }
      else
      {
        // 'producto_id' viene desde "$('.del_product').click(function(e)" cuando se hace click en el boton de "Eliminar"
        $idproducto = $_POST['producto_id'];
        // Para este caso se cambia el valor del campo "estatus = 0"
        // $query_delete = mysqli_query($conexion,"DELETE FROM producto WHERE codproducto = $codproducto");
        $query_delete = mysqli_query($conexion,"UPDATE producto SET estatus = 0  WHERE codproducto = $idproducto");
        mysqli_close($conexion);    
    
        if ($query_delete)
        {
          // header("location: lista_producto.php");  
          echo 'OK';
        }
        else
        {
          echo "Error al Eliminar";
        }
      
      } // if (empty($_POST['product_id']) || is_numeric($_POST['product_id']))
      //echo "Error";

      exit;
    } // if ($_POST['action'] == 'delProduct')
    
    // Buscar Cliente viene desde la ventana de Ventas.
    if ($_POST['action'] == 'searchCliente')
    {
      // Para comprobar si esta ejecutando la condición , en al pagina de "Ventas" se hace click derecho y Inspeccionar Elemento, -> Console.
      //print_r($_POST); // Muestra el contenido de la esta variable global.
      // [action] => searchCliente
      //[cliente] => "d5" Lo que esta teclando en el campo "nit_cliente", cada vez que se oprime una tecla va cambiando.

      //echo "Buscar cliente";
      //exit;
      // Este valor viene desde el campo "nit_cliente" en el arreglo que es enviado desde el $.ajax({ .......})
      //  [action] => searchCliente
      //  [cliente] => "d5"
      if (!empty($_POST['cliente']))
      {
        $nit = $_POST['cliente'];
        // LIKE = Se realiza una busqueda en base a la variable "nit" 
        $query = mysqli_query($conexion,"SELECT * FROM cliente WHERE nit LIKE '$nit' AND estatus = 1");
        mysqli_close($conextion);
        $result = mysqli_num_rows($query);

        $data = '';
        if($result > 0)
        {
          $data = mysqli_fetch_assoc($query);
        }
        else
        {
          $data = 0;
        }
        // Decodifica a formato JSon y las tildes las maneje como texto.
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
      }
      exit;

    } // if ($_POST['action'] == 'searchCliente')

    // Grabar Cliente desde el Modulo de Ventas.
    // 'addCliente' es un input de la form "form_new_cliente_venta" del Modulo de Ventas.
    if ($_POST['action'] == 'addCliente')
    {
      //print_r($_POST);
        /* Muestra los datos en Console del Navegador 
        [action] => addCliente
        [idcliente] => 
        [nit_cliente] => 1212
        [nom_cliente] => juean
        [tel_cliente] => 8392839
        [dir_cliente] => kasjdlakdladsl
        */
      //exit;
      $nit = $_POST['nit_cliente'];
      $nombre = $_POST['nom_cliente'];
      $telefono = $_POST['tel_cliente'];
      $direccion = $_POST['dir_cliente'];
      $usuario_id = $_SESSION['idUser'];

      $query_insert = mysqli_query($conexion,"INSERT INTO cliente (nit,nombre,telefono,direccion,usuario_id) VALUES($nit,'$nombre',$telefono,'$direccion',$usuario_id)");
      // El resto de los campos estan definidos con valores por default.

      if ($query_insert)
      {
        $codCliente = mysqli_insert_id($conexion); // Extrae el "id" (lo genera de forma consecutiva) del cliente
        $msg = $codCliente;
      }
      else
      {
        $msg = 'error';
      }
      
      mysqli_close($conexion);
      echo $msg;
      exit;
       
    }

  } // if (!empty($_POST))
  //exit;
?> 