<?php
  
  session_start();
  // Para validar los roles de los usuarios.
  // Solo tiene acceso a esta pantalla el Administrador (1)
  if ($_SESSION['rol'] != 1)
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

	<title>Lista de Usuarios</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

    <h1><i class="fas fa-users"></i>Lista De Usuarios</h1>
    <a href = "registro_usuario.php" class = "btn_new"><i class="fas fa-user-plus"></i> Crear Usuario</a>
    
    <!-- Se agrega el formulario para la busqueda de usuarios. -->
    <form action="buscar_usuario.php" method="get" class = "form_search">
      <input type="text" name = "busqueda" id="busqueda" placeholder ="Buscar">
      <!-- <input type="submit" value = "Buscar" class = "btn_search"> -->
      <button type="submit" class = "btn_search"><i class="fas fa-search fa-2x"></i></button>
    </form>
    
    <!-- Se agrega este "<div>" para poder utilizar el mediaquery de 760 px la pantalla. -->
    <div class="containerTable">
      <table>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Usuario</th>
          <th>Rol</th>
          <th>Acciones</th>
        </tr>
        <?php
          // Seccion para el paginador (Barra donde despliega las páginas)
          // Extraer los registros que esten activos
          $sql_registe = mysqli_query($conexion,"SELECT COUNT(*) AS total_registro FROM usuario WHERE  estatus = 1");
          $result_register = mysqli_fetch_array($sql_registe);
          $total_registro = $result_register['total_registro'];
          $por_pagina = 3;
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
          $query = mysqli_query($conexion,"SELECT u.idusuario,u.nombre,u.correo,u.usuario,r.rol FROM usuario u  INNER JOIN rol r ON u.rol = r.idrol WHERE estatus = 1  ORDER BY u.nombre ASC LIMIT $desde,$por_pagina");
          
          mysqli_close($conexion);

          $result = mysqli_num_rows($query);
          if ($result > 0)
          {
            while ($data = mysqli_fetch_array($query))
            {
        ?>
              <tr>
                <td><?php echo $data['idusuario']; ?></td>
                <td><?php echo $data['nombre']; ?></td>
                <td><?php echo $data['correo']; ?></td>
                <td><?php echo $data['usuario']; ?></td>
                <td><?php echo $data['rol']; ?></td>
                <td>
                  <a class ="link_edit" href = "editar_usuario.php?id=<?php echo $data['idusuario']; ?>"><i class="far fa-edit "></i> Editar</a>
                  <?php
                  if ($data['idusuario'] != 1) 
                  {
                  ?>
                  |
                  <!-- Si es el usuario = 1 (SuperUsuario) no se puede borrar -->
                  <a class = "link_delete"  href = "eliminar_confirmar_usuario.php?id=<?php echo $data['idusuario']; ?>"><i class="far fa-trash-alt"></i>Eliminar</a>
              <?php } ?>
              
                </td>
              </tr>
        <?php        
            }
          }
        ?>
      </table>

    </div> <!--     <div class="containerTable"> -->

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