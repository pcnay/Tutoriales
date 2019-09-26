<?php
  session_start();
  // Para validar los roles de los usuarios.
  /* Todos los usuarios del sistema podrán listar Clientes

  if ($_SESSION['rol'] != 1)
  {
    header ("location: ./");
  }
  */

  include "../conexion.php" 
?>

<!DOCTYPE html>
<html lang="en">
<!-- Se utiliza esta plantilla, ya que como es el mismo encabezado para todas las opciones del menu. -->
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>

	<title>Lista de Productos</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
    <?php
      $busqueda = '';
      $search_proveedor = '';
      if (empty($_REQUEST['busqueda']) && empty($_REQUEST['proveedor']))
      {
        header("location:lista_producto.php");
      }

      // Asignar a una variable, si la busqueda es por "busqueda" o por "search_proveedor"
      if (!empty($_REQUEST['busqueda']))
      {
        $busqueda = strtolower($_REQUEST['busqueda']);
        // Esta variable se utiliza en la seccion del SELECT donde se obtienen todos los datos de los productos.
        $where ="(p.codproducto LIKE '%$busqueda%' OR p.descripcion LIKE '%$busqueda%') AND  p.estatus = 1";
        // Para utilizar el paginador cuando se filtre la busqueda.
        $buscar= 'busqueda='.$busqueda;
      }

      if (!empty($_REQUEST['proveedor']))
      {
        $search_proveedor = $_REQUEST['proveedor'];
        // Se utiliza para hacerlo generico en la consulta.
        $where = "p.proveedor LIKE $search_proveedor AND p.estatus = 1";
        // Para utilizar el paginador cuando se filtre la busqueda.
        $buscar= 'proveedor='.$search_proveedor;
      }

    ?>
    <h1><i class="fas fa-building"></i> Lista De Productos</h1>
    <a href = "registro_producto.php" class = "btn_new"><i class="fas fa-plus"></i> Alta Producto</a>
    
    <!-- Se agrega el formulario para la busqueda de producto. -->
    <form action="buscar_productos.php" method="get" class = "form_search">
      <input type="text" name = "busqueda" id="busqueda" placeholder ="Buscar" value = "<?php echo $busqueda; ?>">
      <button type="submit" class = "btn_search" ><i class="fas fa-search"></i></button>

      <!-- <input type="submit" value = "Buscar" class = "btn_search"> -->
    </form>
    
    <!-- Se agrega este "<div>" para poder utilizar el mediaquery de 760 px la pantalla. -->
    <div class="containerTable">    
      <table>
        <tr>
          <th>Código</th>
          <th>Descripcion</th>
          <th>Precio</th>
          <th>Existencia</th>

          <th>
            <!-- Se agrega la opción de buscar por proveedor. -->
            <?php 
              $pro = 0;
              if (!empty($_REQUEST['proveedor']))
              {
                $pro = $_REQUEST['proveedor'];
              }
              $query_proveedor = mysqli_query($conexion,"SELECT codproveedor,proveedor FROM proveedor WHERE estatus=1 ORDER BY proveedor ASC");
              $result_proveedor = mysqli_num_rows($query_proveedor);            
            ?>

            <select name="proveedor" id="search_proveedor">
              <option value = ""selected >Proveedor</option>
            <?php 
              if ($result_proveedor > 0)
              {
                while ($proveedor = mysqli_fetch_array($query_proveedor))
                {
                  if($pro == $proveedor['codproveedor'])
                  {
            ?>
                  <option value = "<?php echo $proveedor['codproveedor']; ?>" selected><?php echo $proveedor['proveedor']; ?></option>
            <?php
                  } // if($pro == $proveedor['codproveedor'])
                  else
                  {
            ?>
                  <option value = "<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>

            <?php

                  }

                }
              }
            ?>
              
            </select>

          </th>
          
          <th>Foto</th>
          <th>Acciones</th>
        </tr>
        <?php
          // Seccion para el paginador (Barra donde despliega las páginas)
          // Extraer los registros que esten activos
          // "search_proveedor" es numerico, no se agregan las % y ''
          // "$where" se define en la validacion de que se buscará por "proveedor" o "descripcion"
          $sql_registe = mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM producto AS p WHERE $where ");        
          
          $result_register = mysqli_fetch_array($sql_registe);
          $total_registro = $result_register['total_registro'];
          //echo $total_registro;
          //exit;

          $por_pagina = 1;

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


          // Se obtiene los productos con el estatus = 1(NO Borrado logico)
          // Se agrega la variable "$where" para que funcione cuando se busque por la caja de "buscar"
          $query = mysqli_query($conexion,"SELECT p.codproducto,p.descripcion,p.precio,p.existencia,pr.proveedor,p.foto 
          FROM producto p 
          INNER JOIN proveedor pr 
          ON p.proveedor = pr.codproveedor
          WHERE $where
          ORDER BY p.descripcion ASC LIMIT $desde,$por_pagina");
          
          mysqli_close($conexion);

          $result = mysqli_num_rows($query);
          if ($result > 0)
          {
            while ($data = mysqli_fetch_array($query))
            {
              if ($data['foto'] != 'img_producto.png')
              {
                $foto = 'img/uploads/'.$data['foto'];
              }
              else
              {
                $foto = 'img/uploads/'.$data['foto'];
              }
        ?>
              <!-- Cambiar a cada renglon un color-->
              <tr class="row<?php echo $data['codproducto']; ?>">
                <td><?php echo $data['codproducto']; ?></td>
                <td><?php echo $data['descripcion']; ?></td>
                <td class="celPrecio"><?php echo $data['precio']; ?></td>
                <td class="celExistencia"><?php echo $data['existencia']; ?></td>
                <td><?php echo $data['proveedor']; ?></td>

                <!-- Para mostrar la foto, se asigna clase para definir un tamaño constante. -->
                <td class="img_producto"><img src="<?php echo $foto; ?>" alt = "<?php echo $data['descripcion']; ?>"></td>

                <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)  { ?>         

                <td> 
                  <a class ="link_add add_product" product = "<?php echo $data['codproducto']; ?>" href = "#"><i class="fas fa-plus"></i> Agregar</a>
                  |
                  <a class ="link_edit" href = "editar_producto.php?id=<?php echo $data['codproducto']; ?>"><i class="fas fa-edit"></i> Editar</a>
                  |                
                  <a class = "link_delete del_product" product = "<?php echo $data['codproducto']; ?>" href = "#"><i class="fas fa-trash-alt"></i> Eliminar</a>            
                </td>

                <?php } ?>

              </tr>
        <?php        
            }
          }
        ?>

      </table>
    </div>  <!-- <div class="containerTable">  -->

    <!-- Se elimina los botones del paginador cuando no se tengan registros  -->
    <?php 
      if ($total_pagina != 0)
      {
    ?>
      <div class = "paginador">
        <ul>
        <?php 
          if ($pagina != 1)
          {          
        ?>  
          <li><a href= "?pagina=<?php echo 1; ?>&<?php echo $buscar; ?>"><i class="fas fa-step-backward"></i></a></li>
          <li><a href= "?pagina=<?php echo $pagina-1; ?>&<?php echo $buscar; ?>"><i class="fas fa-backward"></i></a></li>
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
          <li><a href= "?pagina=<?php echo $pagina+1; ?>&<?php echo $buscar; ?>"><i class="fas fa-forward"></i></a></li>
          <li><a href= "?pagina=<?php echo $total_paginas; ?>&<?php echo $buscar; ?>"><i class="fas fa-step-forward"></i></a></li>

        <?php
            }
        ?>
        </ul>

      </div>
    <?php } ?> <!-- if ($total_pagina != 0) -->

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>