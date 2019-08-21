<?php
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

    <h1>Lista De Usuarios</h1>
    <a href = "registro_usuario.php" class = "btn_new">Crear Usuario</a>
    <table>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Acciones</th>
      </tr>
      <?php
        // Se obtiene los usuarios con su correspondiente nombre de "Rol" 
        $query = mysqli_query($conexion,"SELECT u.idusuario,u.nombre,u.correo,u.usuario,r.rol FROM usuario u  INNER JOIN rol r ON u.rol = r.idrol");
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
                <a class ="link_edit" href = "#">Editar</a>
                |
                <a class = "link_delete"  href = "#">Eliminar</a>
              </td>
            </tr>
      <?php        
          }
        }
      ?>
    </table>
	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>