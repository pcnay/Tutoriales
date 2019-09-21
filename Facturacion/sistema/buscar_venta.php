<?php
  session_start();
  // Para validar los roles de los usuarios.
  /* Todos los usuarios del sistema podrán listar Clientes

  if ($_SESSION['rol'] != 1)
  {
    header ("location: ./");
  }
  */

  include "../conexion.php" ;
  $busqueda = '';
  $fecha_de = '';
  $fecha_a = '';

  // Validando cuando se alteran los valores desde la barra de direcciones.
  if (isset($_REQUEST['busqueda']) && $_REQUEST['busqueda']=='')
  {
    header("location: ventas.php");
  }

  if (isset($_REQUEST['fecha_de']) || isset($_REQUEST['fecha_a']))
  {
    if ($_REQUEST['fecha_de'] == '' || $_REQUEST['fecha_a'] == '')
    {
      header("location: ventas.php");
    }
  }

  // Validando el campo de Busqueda
  if (!empty($_REQUEST['busqueda']))
  {
    if(!is_numeric($_REQUEST['busqueda'])) // Si no es número
    {
      header("location:venta.php");
    }
    $busqueda = strtolower($_REQUEST['busqueda']);
    $where = "nofactura = $busqueda";
    $buscar = "busqueda = $busqueda";

  }

  // Validando por rangos de fechas.
  if (!empty($_REQUEST['fecha_de']) && !empty($_REQUEST['fecha_a']))
  {
    $fecha_de = $_REQUEST['fecha_de'];
    $fecha_a = $_REQUEST['fecha_a'];
    $buscar = '';

    if($fecha_de > $fecha_a)
    {
      header("location: ventas.php");      
    }
    else if ($fecha_de == $fecha_a)
    {
      $where = "fecha LIKE '$fecha_de%'";
      $buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a";
    }
    else
    {
      // Es importante que se especifique la hora y con espacio en la variable, de lo contrario estaria funcionando de forma aleatoria.
      $f_de = $fecha_de.' 00:00:00';
      $f_a = $fecha_a.' 23:59:59';
      $where = "fecha BETWEEN '$f_de' AND '$f_a'";           
      $buscar = "fecha_de=$fecha_de&fecha_a=$fecha_a";
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<!-- Se utiliza esta plantilla, ya que como es el mismo encabezado para todas las opciones del menu. -->
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>

	<title>Lista de Ventas</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

    <h1><i class="far fa-newspaper"></i>Lista De Ventas </h1>
    <a href = "nueva_venta.php" class = "btn_new"><i class="fas fa-plus"></i>Nueva Venta</a>
    
    <!-- Se agrega el formulario para la busqueda una factura -->
    <form action="buscar_venta.php" method="get" class = "form_search">
      <input type="text" name = "busqueda" id="busqueda" placeholder ="No. Factura" value ="<?php echo $busqueda;?>">
      <button type="submit" class = "btn_search"><i class="fas fa-search"></i></button>
    </form>

    <div>
      <h5>Buscar por Fecha</h5>
      <form action="buscar_venta.php" method="get" class = "form_search_date">
        <label>De: </label>
        <input type="date" name ="fecha_de" id="fecha_de" value = "<?php echo $fecha_de;?>"required>
        <label>A</label>
        <input type="date" name ="fecha_a" id="fecha_a" value = "<?php echo $fecha_a;?>"required>
        <button type="submit" class = "btn_view"><i class="fas fa-search"></i></button>
      </form>

    </div>

    <table>
      <tr>
        <th>Num</th>
        <th>Fecha/Hora</th>
        <th>Cliente</th>
        <th>Vendedor</th>
        <th>Estado</th>
        <th class="textright">Total Factura </th>
        <th class="textright">Acciones</th>
      </tr>
      <?php
        // Seccion para el paginador (Barra donde despliega las páginas)
        // Extraer los registros que esten activos
        // estatus = 10 ; Son Canceladas
        // estatus = 2 ; Eliminadas
        $sql_registe = mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM factura WHERE $where");
        $result_register = mysqli_fetch_array($sql_registe);
        $total_registro = $result_register['total_registro'];
        $por_pagina = 5;
        if(empty($_GET['pagina']))
        {
          $pagina = 1;

        }
        else
        {
          $pagina = $_GET['pagina'];
        }

        $desde = ($pagina-1)*$por_pagina;
        // Se coloca -1 porque en la parametro de "LIMIT" utiliza desde 0 a X.
        $total_paginas = ceil($total_registro/$por_pagina);


        // Se obtiene las facturas, con los usuarios y clientes.
        // "estatus = 10" son facturas eliminadas.
        $query = mysqli_query($conexion,"SELECT f.nofactura,f.fecha,f.totalfactura,f.codcliente,f.estatus,u.nombre AS vendedor, cl.nombre AS cliente
        FROM factura f
        INNER JOIN usuario u
        ON f.usuario = u.idusuario
        INNER JOIN cliente cl
        ON f.codcliente = cl.idcliente
        WHERE ($where) AND (f.estatus != 10)
        ORDER BY f.fecha DESC LIMIT $desde,$por_pagina");
        
        mysqli_close($conexion);

        // Se prepara para mostrar todas las facturas en una tabla.
        $result = mysqli_num_rows($query);
        if ($result > 0)
        {
          while ($data = mysqli_fetch_array($query))
          {
            // Muestra el recuadro el estado de color, utilizando un "<span>" con clase de la factura 
            if ($data['estatus'] == 1)
            {
              $estado = '<span class="pagada">Pagada</span>';            
            }
            else
            {
              $estado = '<span class="anulada">Anulada</span>';
            }
        
      ?>  
            <!-- Este "id" se utilizan para la columna de "acciones" -->
            <tr id="row_<?php echo $data['nofactura']; ?>">
              <td><?php echo $data['nofactura']; ?></td>
              <td><?php echo $data['fecha']; ?></td>
              <td><?php echo $data['cliente']; ?></td>
              <td><?php echo $data['vendedor']; ?></td>
              <td class="estado"><?php echo $estado; ?></td>
              <td class = "textright totalfactura"><span>$</span><?php echo $data['totalfactura']; ?></td>
              <td>
                <div class = "div_acciones">
                  <div>
                    <button class= "btn_view view_factura " type="button" cl = "<?php echo $data['codcliente']; ?>" f="<?php echo $data['nofactura']; ?>"><i class="fas fa-eye"></i></button>
                  </div>
                  <!-- Solo se muestra este boton a "Administradores" y "Supervisores" -->
                  <?php
                    if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)
                    {
                      if ($data["estatus"] == 1)
                      {
                        ?>                    
                        <div class="div_factura">
                          <button class="btn_anular anular_factura" type="button" fac="<?php echo $data['nofactura']; ?>"><i class="fas fa-ban"></i></button>
                        </div>
                <?php }
                      else
                      { ?>
                        <div class="div_factura">
                        <button type = "button" class="btn_anular inactive"><i class="fas fa-ban"></i></button>
                        </div>
                <?php } ?>

              <?php } // if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)  ?>

                </div> <!-- <div class = "div_acciones"> -->

              </td>

            </tr>
      <?php        

          } // while ($data = mysqli_fetch_array($query))

        } // if ($result > 0)
      ?>

    </table>
    <div class = "paginador">
        <ul>
        <?php 
          if ($pagina != 1)
          {          
        ?>  
          <li><a href= "?pagina=<?php echo 1; ?>&<?php echo $buscar;?>"><i class="fas fa-step-backward"></i></a></li>
          <li><a href= "?pagina=<?php echo $pagina-1; ?>&<?php echo $buscar;?>"><i class="fas fa-backward"></i></a></li>
        <?php 
          }
            for ($i=1;$i<=$total_paginas;$i++)
            {
              // Para indicar que es la pantalla actual.
              if ($i == $pagina)
              {
                echo '<li class="pageSelected">'.$i.'</li>';  
              }
              else
              {
                echo '<li><a href="?pagina='.$i.'&'.$buscar.'">'.$i.'</a></li>';
              }               
            }
            if ($pagina != $total_paginas)
            {
        ?>        
          <li><a href= "?pagina=<?php echo $pagina+1; ?>&<?php echo $buscar;?>"><i class="fas fa-forward"></i></a></li>
          <li><a href= "?pagina=<?php echo $total_paginas; ?>&<?php echo $buscar;?>"><i class="fas fa-step-forward"></i></a></li>

        <?php
            }
        ?>
        </ul>

    </div>

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>