<?php
  session_start();
  // Para validar los roles de los usuarios.
  // Solo acceso los "Administradores" y "Supervisores"
  
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

	<title>Lista de Proveedores </title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
    <?php 
      $busqueda = strtolower($_REQUEST['busqueda']);
      if (empty($busqueda))
      {
        header("location:lista_proveedor.php");
        mysqli_close($conexion);
      }

    ?>
    <h1><i class="far fa-building"></i>Lista De Proveedores</h1>
    <a href = "registro_proveedor.php" class = "btn_new"><i class="fas fa-plus"></i> Crear Proveedor</a>
    
    <!-- Se agrega el formulario para la busqueda de usuarios. -->
    <form action="buscar_proveedor.php" method="get" class = "form_search">
      <input type="text" name = "busqueda" id="busqueda" placeholder ="Buscar" value = "<?php echo $busqueda; ?>">
      <button type="submit" class= "btn_search"><i class = "fas fa-search"></i></button>
      <!-- <input type="submit" value = "Buscar" class = "btn_search"> -->
    </form>
    
    <table>
      <tr>
        <th>ID</th>
        <th>PROVEEDOR</th>
        <th>CONTACTO</th>
        <th>TELEFONO</th>
        <th>DIRECCION</th>
        <th>FECHA</th>
        <th>Acciones</th>
      </tr>
      <?php
        // Seccion para el paginador (Barra donde despliega las páginas)
        // Extraer los registros que esten activos
        $sql_registe = mysqli_query($conexion,"SELECT COUNT(*) AS total_registro 
                                                FROM proveedor WHERE  
                                                (codproveedor LIKE '%$busqueda%' OR 
                                                proveedor LIKE '%$busqueda%' OR
                                                contacto LIKE '%$busqueda%' OR
                                                telefono LIKE '%$busqueda%') AND 
                                                estatus = 1");
        
        $result_register = mysqli_fetch_array($sql_registe);
        $total_registro = $result_register['total_registro'];

        // Los registros a desplegar por pantalla
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


        // Se obtiene los clientes de la columna "estatus = 1(Borrado logico)"
        // Se puede suprimir los campos que no se requiere buscar.
        $query = mysqli_query($conexion,"SELECT * FROM proveedor WHERE 
                                          (codproveedor LIKE '%$busqueda%' OR 
                                          proveedor LIKE '%$busqueda%' OR
                                          contacto LIKE '%$busqueda%' OR
                                          telefono LIKE '%$busqueda%') AND 
                                          estatus = 1  ORDER BY proveedor ASC LIMIT $desde,$por_pagina");
        mysqli_close($conexion);

        $result = mysqli_num_rows($query);

        // Desplegara los datos con la busqueda indicada.
        if ($result > 0)
        {
          while ($data = mysqli_fetch_array($query))
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
              <a class ="link_edit" href = "editar_proveedor.php?id=<?php echo $data['codproveedor']; ?>"><i class="far fa-edit"></i> Editar</a>
              |
              <a class = "link_delete"  href = "eliminar_confirmar_proveedor.php?id=<?php echo $data['codproveedor']; ?>"><i class="far fa-trash-alt"></i> Eliminar</a>            
            </td>
          </tr>
      <?php        
          } // while ($data = mysqli_fetch_array($query))

        } // if ($result > 0)
      ?>

    </table>

    <!-- Si en la busqueda no tiene registros. -->
    <?php
      if ($total_registro != 0)
      {
     
        ?>

        <div class = "paginador">
            <ul>
            <?php 
              if ($pagina != 1)
              {          
            ?>  
              <li><a href= "?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>" >|<</a></li>
              <li><a href= "?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
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
                    echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
                  }               
                }
                if ($pagina != $total_paginas)
                {
            ?>        
              <li><a href= "?pagina=<?php echo $pagina+1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
              <li><a href= "?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>">>|</a></li>

            <?php
                }
            ?>
            </ul>

        </div>
    <?php
      }
    ?>  

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>