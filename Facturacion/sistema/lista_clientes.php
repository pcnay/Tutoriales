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

	<title>Lista de Clientes</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

    <h1>Lista De Clientes</h1>
    <a href = "registro_cliente.php" class = "btn_new">Crear Cliente</a>
    
    <!-- Se agrega el formulario para la busqueda de usuarios. -->
    <form action="buscar_cliente.php" method="get" class = "form_search">
      <input type="text" name = "busqueda" id="busqueda" placeholder ="Buscar">
      <input type="submit" value = "Buscar" class = "btn_search">
    </form>
    
    <table>
      <tr>
        <th>ID</th>
        <th>NIT</th>
        <th>Nombre</th>
        <th>Telefono</th>
        <th>Direccion</th>
        <th>Acciones</th>
      </tr>
      <?php
        // Seccion para el paginador (Barra donde despliega las páginas)
        // Extraer los registros que esten activos
        $sql_registe = mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM cliente WHERE  estatus = 1");
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


        // Se obtiene los usuarios con su correspondiente nombre de "Rol" y que tengan en la columna "estatus = 1(Borrado logico)"
        $query = mysqli_query($conexion,"SELECT * FROM cliente WHERE estatus = 1  ORDER BY nombre ASC LIMIT $desde,$por_pagina");
        
        mysqli_close($conexion);

        $result = mysqli_num_rows($query);
        if ($result > 0)
        {
          while ($data = mysqli_fetch_array($query))
          {
            if ($data["nit"] == 0)
            {
              $nit = 'C/F';              
            }
            else
            {
              $nit = $data["nit"];
            }
      ?>
            <tr>
              <td><?php echo $data['idcliente']; ?></td>
              <td><?php echo $nit; ?></td>
              <td><?php echo $data['nombre']; ?></td>
              <td><?php echo $data['telefono']; ?></td>
              <td><?php echo $data['direccion']; ?></td>
              <td>
                <a class ="link_edit" href = "editar_cliente.php?id=<?php echo $data['idcliente']; ?>">Editar</a>
                |
                <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)  { ?>
                  <a class = "link_delete"  href = "eliminar_confirmar_cliente.php?id=<?php echo $data['idcliente']; ?>">Eliminar</a>            
                <?php } ?>

              </td>
            </tr>
      <?php        
          }
        }
      ?>

    </table>
    <div class = "paginador">
        <ul>
        <?php 
          if ($pagina != 1)
          {          
        ?>  
          <li><a href= "?pagina=<?php echo 1; ?>">|<</a></li>
          <li><a href= "?pagina=<?php echo $pagina-1; ?>"><<</a></li>
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
          <li><a href= "?pagina=<?php echo $pagina+1; ?>">>></a></li>
          <li><a href= "?pagina=<?php echo $total_paginas; ?>">>|</a></li>

        <?php
            }
        ?>
        </ul>

    </div>

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>