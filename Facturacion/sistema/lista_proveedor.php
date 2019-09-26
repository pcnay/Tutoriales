<?php
  session_start();
  // Para validar los roles de los usuarios, solo el Administrador y Supervisor.  
  if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
  {
    header ("location: ./");
  }

  include "../conexion.php" 
?>

<!DOCTYPE html>
<html lang="en">
<!-- Se utiliza esta plantilla, ya que como es el mismo encabezado para todas las opciones del menu. -->
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>

	<title>Lista De Proveedor</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

    <h1><i class="fas fa-building"></i>Lista De Proveedor</h1>
    <a href = "registro_proveedor.php" class = "btn_new"><i class="fas fa-user-plus"></i> Crear Proveedor</a>
    
    <!-- Se agrega el formulario para la busqueda de usuarios. -->
    <form action="buscar_proveedor.php" method="get" class = "form_search">
      <input type="text" name = "busqueda" id="busqueda" placeholder ="Buscar">
      <button type="submit" class="btn_search"><i class="fas fa-search"></i></button>
      <!-- <input type="submit" value = "Buscar" class = "btn_search"> -->
    </form>
    
    <!-- Se agrega este "<div>" para poder utilizar el mediaquery de 760 px la pantalla. -->
    <div class="containerTable">    
      <table>
        <tr>
          <th>ID</th>
          <th>Proveedor</th>
          <th>Contacto</th>
          <th>Telefono</th>
          <th>Direccion</th>
          <th>Fecha</th>
          <th>Acciones</th>
        </tr>
        <?php
          // Seccion para el paginador (Barra donde despliega las páginas)
          // Extraer los registros que esten activos
          $sql_registe = mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM proveedor WHERE  estatus = 1");
          $result_register = mysqli_fetch_array($sql_registe);
          $total_registro = $result_register['total_registro'];
          $por_pagina = 8;
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


          // Se obtiene los proveedores y que tengan en la columna "estatus = 1(Borrado logico)"
          $query = mysqli_query($conexion,"SELECT * FROM proveedor WHERE estatus = 1  ORDER BY proveedor ASC LIMIT $desde,$por_pagina");
          
          mysqli_close($conexion);

          $result = mysqli_num_rows($query);
          if ($result > 0)
          {
            while ($data= mysqli_fetch_array($query))
            {
              // Para solo mostrar la fecha sin la hora.
              $formato = 'Y-m-d H:i:s';
              $fecha = DateTime::createFromFormat($formato,$data['date_add']);

        ?>
            <tr>
              <td><?php echo $data['codproveedor']; ?></td>
              <td><?php echo $data['proveedor']; ?></td>
              <td><?php echo $data['contacto']; ?></td>
              <td><?php echo $data['telefono']; ?></td>
              <td><?php echo $data['direccion']; ?></td>
              <td><?php echo $fecha->format('d-m-Y'); ?></td>
              <td>
                <a class ="link_edit" href = "editar_proveedor.php?id=<?php echo $data['codproveedor']; ?>">Editar</a>
                |
                <a class = "link_delete"  href = "eliminar_confirmar_proveedor.php?id=<?php echo $data['codproveedor']; ?>">Eliminar</a>            
              </td>
            </tr>
        <?php        
            } // while ($data = mysqli_fetch_array($query))

          } // ($result = 0)
        ?>
  
      </table>
    </div>
  
    <div class = "paginador">
        <ul>
        <?php 
          if ($pagina != 1)
          {          
        ?>  
          <li><a href= "?pagina=<?php echo 1; ?>"><i class="fas fa-step-backward"></i></a></li>
          <li><a href= "?pagina=<?php echo $pagina-1; ?>"><i class="fas fa-backward"></i></a></li>
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
                echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
              }               
            }
            if ($pagina != $total_paginas)
            {
        ?>        
          <li><a href= "?pagina=<?php echo $pagina+1; ?>"><i class="fas fa-forward"></i></a></li>
          <li><a href= "?pagina=<?php echo $total_paginas; ?>"><i class="fas fa-step-forward"></i></a></li>

        <?php
            }
        ?>
        </ul>

    </div>

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>