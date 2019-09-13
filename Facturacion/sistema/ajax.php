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

    // Agregando productos al detalle de la Venta.
    if ($_POST['action'] == 'addProductoDetalle')
    {
        //print_r($_POST);
        /* Muestra los datos en Console del Navegador 
          [action] => addProductoDetalle
          [producto] => 2
          [cantidad] => 3
        */
        if (empty($_POST['producto']) || empty($_POST['cantidad']))
        {
          // Se utiliza para validar en la seccion "successe" el valor que retorno
          echo 'error';
        }
        else
        {
          $codproducto = $_POST['producto'];
          $cantidad = $_POST['cantidad'];
          $token = md5($_SESSION['idUser']); // encriptando el "Id" del usuario.

          $query_iva = mysqli_query($conexion,"SELECT iva FROM configuracion");
          $result_iva = mysqli_num_rows($query_iva);

          // Grabando registros a la tabla de "detelle_temp" con el Procedimiento Almacenado, ademas esta retornando los registros que tiene la tabla de "detalle_temp"
          $query_detalle_temp = mysqli_query($conexion,"CALL add_detalle_temp($codproducto,$cantidad,'$token')");
          $result = mysqli_num_rows($query_detalle_temp);

          $detalleTabla = '';
          $sub_total = 0;
          $iva = 0;
          $total = 0;
          $arrayData = array();

          // Verificar que si esta obteniendo el número de registros de la tabla "detalle_temp", en el archivo "functions.js" ->$('#add_product_venta').click(function(e)->Success -> console.log(response);  
          // print_r ($result);
          // exit;

          if ($result > 0)
          {
            if ($result_iva > 0)
            {
              $info_iva = mysqli_fetch_assoc($query_iva);
              $iva = $info_iva['iva'];

            } // if ($result_iva > 0

            // Calculando el precio total del detalle de cada fila que se esta agregando a la nota de venta.
            // Este query "$query_detalle_temp" se creo con el Procedimiento Almacenado
            while ($data = mysqli_fetch_assoc($query_detalle_temp))
            {
              $precioTotal = round($data['cantidad']*$data['precio_venta'],2);
              $sub_total = round($sub_total+$precioTotal,2);
              $total = round($total+$precioTotal,2);

              // Para desplegar los renglones de los productos agregados al detalla de la venta se utilizará "Ajax". 
              $detalleTabla .= ' 
                <tr>
                  <td>'.$data['codproducto'].'</td>
                  <td colspan="2">'.$data['descripcion'].'</td>
                  <td class="textcenter">'.$data['cantidad'].'</td>
                  <td class="textright">'.$data['precio_venta'].'</td>
                  <td class="textright">'.$precioTotal.'</td>
                  <td class="">
                    <a class ="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i></a>
                  </td>
                </tr> ';

            } // while ($data = mysqli_fetch_assoc($query_detalle_temp))

            // Se calcula el total de la Venta.
            $impuesto = round($sub_total*($iva/100),2);
            $tl_sniva = round($sub_total-$impuesto,2);
            $total = round($tl_sniva+$impuesto,2);

            $detalleTotales = '                     
              <tr>
                <td colspan="5" class="textright">SUBTOTAL $.</td>
                <td class= "textright">'.$tl_sniva.'</td>
              </tr>
              <tr>
                <td colspan="5" class="textright">IVA ('.$iva.' %)</td>
                <td class= "textright">'.$impuesto.'</td>
              </tr>
              <tr>
                <td colspan="5" class="textright">TOTAL $</td>
                <td class= "textright">'.$total.'</td>
              </tr>';
               
              $arrayData['detalle'] = $detalleTabla;
              $arrayData['totales'] = $detalleTotales;

              // Retornando el este arreglo para Ajax, en Function.js "$('#add_product_venta').click(function(e)" 
              // Se retorna en formato "JSON" y con "JSON_UNESCAPED.." la convierta las tildes en forma normal, posteriormente se convierte a Objeto.       
              echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
              // Este valor es el que retorna a la llamada del Ajax y lo interpreta la seccion "successe" 

          } // if ($result > 0)
          else
          {
            echo "error";
          }
         mysqli_close($conexion);

        } // if (empty($_POST['producto']) || empty($_POST['cantidad']))
        exit;

    } // if ($_POST['action'] == 'addProductoDetalle')

    // Mostrando los detalles_temp de la venta actual, cuando el usuario cierre o se cambie de ventana.
    if ($_POST['action'] == 'searchForDetalle')
    {
        //print_r($_POST);
        /* Muestra los datos en Console del Navegador 
          [action] => addProductoDetalle
          [producto] => 2
          [cantidad] => 3
        */

        if (empty($_POST['user']))
        {
          // Se utiliza para validar en la seccion "successe" el valor que retorno
          echo 'error';
        }
        else
        {
          $token = md5($_SESSION['idUser']); // encriptando el "Id" del usuario.

          $query = mysqli_query($conexion,"SELECT tmp.correlativo,tmp.token_user,tmp.cantidad,tmp.precio_venta,p.codproducto,p.descripcion
            FROM detalle_temp tmp
            INNER JOIN producto p
            ON tmp.codproducto = p.codproducto
            WHERE token_user = '$token' ");

          $result = mysqli_num_rows($query);

          $query_iva = mysqli_query($conexion,"SELECT iva FROM configuracion");
          $result_iva = mysqli_num_rows($query_iva);


          $detalleTabla = '';
          $sub_total = 0;
          $iva = 0;
          $total = 0;
          $arrayData = array();

          if ($result > 0)
          {
            if ($result_iva > 0)
            {
              $info_iva = mysqli_fetch_assoc($query_iva);
              $iva = $info_iva['iva'];

            } // if ($result_iva > 0

            // Calculando el precio total del detalle de cada fila que se esta agregando a la nota de venta.
            // Este query "$query_detalle_temp" se creo con el Procedimiento Almacenado
            while ($data = mysqli_fetch_assoc($query))
            {
              $precioTotal = round($data['cantidad']*$data['precio_venta'],2);
              $sub_total = round($sub_total+$precioTotal,2);
              $total = round($total+$precioTotal,2);

              // Para desplegar los renglones de los productos agregados al detalla de la venta se utilizará "Ajax". 
              $detalleTabla .= ' 
                <tr>
                  <td>'.$data['codproducto'].'</td>
                  <td colspan="2">'.$data['descripcion'].'</td>
                  <td class="textcenter">'.$data['cantidad'].'</td>
                  <td class="textright">'.$data['precio_venta'].'</td>
                  <td class="textright">'.$precioTotal.'</td>
                  <td class="">
                    <a class ="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i></a>
                  </td>
                </tr> ';

            } // while ($data = mysqli_fetch_assoc($query_detalle_temp))

            // Se calcula el total de la Venta.
            $impuesto = round($sub_total*($iva/100),2);
            $tl_sniva = round($sub_total-$impuesto,2);
            $total = round($tl_sniva+$impuesto,2);

            $detalleTotales = '                     
              <tr>
                <td colspan="5" class="textright">SUBTOTAL $.</td>
                <td class= "textright">'.$tl_sniva.'</td>
              </tr>
              <tr>
                <td colspan="5" class="textright">IVA ('.$iva.' %)</td>
                <td class= "textright">'.$impuesto.'</td>
              </tr>
              <tr>
                <td colspan="5" class="textright">TOTAL $</td>
                <td class= "textright">'.$total.'</td>
              </tr>';
               
              $arrayData['detalle'] = $detalleTabla;
              $arrayData['totales'] = $detalleTotales;

              // Retornando el este arreglo para Ajax, en Function.js "$('#add_product_venta').click(function(e)" 
              // Se retorna en formato "JSON" y con "JSON_UNESCAPED.." la convierta las tildes en forma normal, posteriormente se convierte a Objeto.       
              echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
              // Este valor es el que retorna a la llamada del Ajax y lo interpreta la seccion "successe" 

          } // if ($result > 0)
          else
          {
            echo "error";
          }
          mysqli_close($conexion);

        } // if (empty($_POST['producto']) || empty($_POST['cantidad']))
        exit;

    } // if ($_POST['action'] == 'searchForDetalle')

    // Borrar registros de la tabla de Detalle de las Ventas, esta archivo viene desde "functions.js" -> function del_product_detalle(correlativo)...
    // Que es llamado  a través del Ajax.
    if ($_POST['action'] == 'delProductoDetalle')
    {
        // print_r($_POST);exit;
        /* Muestra los datos en Console del Navegador, en conjunto con esta instrucción 
        Array
          (
            [action] => delProductoDetalle
            [id_detalle] => 3
          )
        */

        if (empty($_POST['id_detalle']))
        {
          // Se utiliza para validar en la seccion "successe" el valor que retorno
          echo 'error';
        }
        else
        {
          $id_detalle = $_POST['id_detalle']; // Es el correlativo de detalle de venta.
          $token = md5($_SESSION['idUser']); // encriptando el "Id" del usuario.

          $query_iva = mysqli_query($conexion,"SELECT iva FROM configuracion");
          $result_iva = mysqli_num_rows($query_iva);

          $query_detalle_temp = mysqli_query($conexion,"CALL del_detalle_temp($id_detalle,'$token')");
          $result = mysqli_num_rows($query_detalle_temp);


          $detalleTabla = '';
          $sub_total = 0;
          $iva = 0;
          $total = 0;
          $arrayData = array();

          if ($result > 0)
          {
            if ($result_iva > 0)
            {
              $info_iva = mysqli_fetch_assoc($query_iva);
              $iva = $info_iva['iva'];

            } // if ($result_iva > 0

            // Calculando el precio total del detalle de cada fila que se esta agregando a la nota de venta.
            // Este query "$query_detalle_temp" se creo con el Procedimiento Almacenado
            while ($data = mysqli_fetch_assoc($query_detalle_temp))
            {
              $precioTotal = round($data['cantidad']*$data['precio_venta'],2);
              $sub_total = round($sub_total+$precioTotal,2);
              $total = round($total+$precioTotal,2);

              // Para desplegar los renglones de los productos agregados al detalla de la venta se utilizará "Ajax". 
              $detalleTabla .= ' 
                <tr>
                  <td>'.$data['codproducto'].'</td>
                  <td colspan="2">'.$data['descripcion'].'</td>
                  <td class="textcenter">'.$data['cantidad'].'</td>
                  <td class="textright">'.$data['precio_venta'].'</td>
                  <td class="textright">'.$precioTotal.'</td>
                  <td class="">
                    <a class ="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i></a>
                  </td>
                </tr> ';

            } // while ($data = mysqli_fetch_assoc($query_detalle_temp))

            // Se calcula el total de la Venta.
            $impuesto = round($sub_total*($iva/100),2);
            $tl_sniva = round($sub_total-$impuesto,2);
            $total = round($tl_sniva+$impuesto,2);

            $detalleTotales = '                     
              <tr>
                <td colspan="5" class="textright">SUBTOTAL $.</td>
                <td class= "textright">'.$tl_sniva.'</td>
              </tr>
              <tr>
                <td colspan="5" class="textright">IVA ('.$iva.' %)</td>
                <td class= "textright">'.$impuesto.'</td>
              </tr>
              <tr>
                <td colspan="5" class="textright">TOTAL $</td>
                <td class= "textright">'.$total.'</td>
              </tr>';
               
              $arrayData['detalle'] = $detalleTabla;
              $arrayData['totales'] = $detalleTotales;

              // Retornando el este arreglo para Ajax, en Function.js "$('#add_product_venta').click(function(e)" 
              // Se retorna en formato "JSON" y con "JSON_UNESCAPED.." la convierta las tildes en forma normal, posteriormente se convierte a Objeto.       
              echo json_encode($arrayData,JSON_UNESCAPED_UNICODE);
              // Este valor es el que retorna a la llamada del Ajax y lo interpreta la seccion "successe" 

          } // if ($result > 0)
          else
          {
            echo "error";
          }
          mysqli_close($conexion);

        } // if (empty($_POST['producto']) || empty($_POST['cantidad']))
        exit;




    } // if ($_POST['action'] == 'delProductoDetalle')
   
    // Anular Venta, ejecutado en el Ajax.
    if ($_POST['action'] == 'anularVenta')
    {
      $token = md5($_SESSION['idUser']); // se encripta id usuario para determinar cual usuario esta actualmente.
      $query_del = mysqli_query($conexion,"DELETE FROM detalle_temp WHERE token_user = '$token'");
      mysqli_close($conexion);
      if ($query_del)
      {
        echo 'ok';
      }
      else
      {
        echo 'error';
      }
      exit;
    } // if ($_POST['action'] == 'anularVenta')

    // Procesar Venta (Boton Procesar) 
    if ($_POST['action'] == 'procesarVenta')
    {
      // Para mostrar lo que viene de "functions.js" y se envia por Ajax, al archivo "ajax.php"
      /* 
      print_r($_POST);exit;
      
      Array(

          [action] => procesarVenta
          Este valor se obtiene dinamicamente, es asignado por Ajax cuando se encuentra el cliente. en la "Venta"
          [codcliente] => 6
          )
      */
      // Este dato viene de la sección de Ajax, data=
      if (empty($_POST['codcliente']))
      {
        $codcliente = 1;        
      }
      else
      {
        $codcliente = $_POST['codcliente'];        
      }
      $token = md5($_SESSION['idUser']); // Encriptando el "id" del usuario.
      $usuario = $_SESSION['idUser'];
      $query = mysqli_query ($conexion,"SELECT * FROM detalle_temp WHERE token_user =  '$token'");
      $result = mysqli_num_rows($query);
      // Se ejecuta el procedimiento Almacenado.
      if ($result > 0)
      {
        $query_procesar = mysqli_query($conexion,"CALL procesar_venta($usuario,$codcliente,'$token')");
        $result_detalle = mysqli_num_rows($query_procesar);
        if ($result_detalle > 0)
        {
          $data = mysqli_fetch_assoc($query_procesar);
          echo json_encode($data,JSON_UNESCAPED_UNICODE); // Lo convierte a formato JSON y las tildes la maneja como texto, para poder despues convertirlo a Objeto. Este valor es devuelto por "Ajax.php" a "Function.js"
        }
        else
        {
          echo "error"; // Este valor es devuelto por "Ajax.php" en "Functions.js"
        }
      }
      else
      {
        echo "error"; // Este valor es devuelto por "Ajax.php" en "Functions.js"
      }
      mysqli_close($conexion);
      exit;

    } // if ($_POST['action'] == 'procesarVenta')

  } // if (!empty($_POST))
  exit;
?> 