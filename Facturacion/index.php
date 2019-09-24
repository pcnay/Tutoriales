<?php
  
  // Como no tiene "action" se autoprocesa automaticamente, es decir que se vuelve a cargar el archivo "index.php" 
  $alert = '';
  session_start();

  if (!empty($_SESSION['active']))
  {
    header ('location: sistema/');
  }
  else
  {

    if (!empty($_POST))
    {
      // echo $alert = "Se realizo click en el boton *Ingresar*";
      if (empty($_POST['usuario']) || empty($_POST['clave']))
      {
        $alert = 'Ingrese su usuario y su clave';
      }
      else
      {
        require_once "conexion.php";      
        // Evita caracteres raros para que no afecte la base de datos.
        $user = mysqli_real_escape_string($conexion,$_POST['usuario']);
        $clave = md5(mysqli_real_escape_string($conexion,$_POST['clave']));
        /*
          Cuando se desea depurar parte del programa, se coloca estas opciones para que el programa se bote y nos muestre los valores de las variables que se quieren mostrar. 

            echo $clave;
            exit;

        */
        // Se obtiene el nombre del "rol"
        $query = mysqli_query ($conexion,"SELECT u.idusuario,u.nombre,u.correo,u.usuario,r.idrol,r.rol FROM usuario u 
        INNER JOIN rol r
        ON u.rol = r.idrol
        WHERE u.usuario = '$user' AND u.clave = '$clave'");

        mysqli_close($conexion);
        $result = mysqli_num_rows($query);
        if ($result>0)
        {
          $data = mysqli_fetch_array($query);
          // print_r($data);

          $_SESSION['active'] = true;
          $_SESSION['idUser'] = $data['idusuario'];
          $_SESSION['nombre'] = $data['nombre'];
          $_SESSION['correo'] = $data['correo'];
          $_SESSION['usuario'] = $data['usuario'];
          $_SESSION['rol'] = $data['idrol']; // Varios archivos ya manejan esta variable de SESSION.
          $_SESSION['rol_name'] = $data['rol'];
          header ('location: sistema/');
        } 
        else
        {
          $alert = "El usuario o la clave son incorrectos";
          session_destroy();
        }
        
      }

    }

  } // if (!empty($_SESSION['active']))

?>

<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Login  Sistema De Facturacion</title>
    <link rel = "stylesheet" type = "text/css" href = "css/style.css">
  </head>
  <body>
    <section id="container">
      <form action="" method="post">
        <h3>Iniciar Sesion</h3>
        <img src = "img/login.png" alt = "Login">
        <input type = "text" name = "usuario" placeholder = "Usuario">
        <input type = "password" name = "clave" placeholder = "Contraseña">
        <div class = "alert"><?php echo isset($alert)? $alert : ''; ?> </div>
        <input type = "submit" value = "INGRESAR">

      </form>
    </section>

  </body> 
</html>
