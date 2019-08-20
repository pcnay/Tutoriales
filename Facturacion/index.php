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
        $user = $_POST['usuario'];
        $clave = $_POST['clave'];
        $query = mysqli_query ($conexion,"SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$clave'");
        $result = mysqli_num_rows($query);
        if ($result>0)
        {
          $data = mysqli_fetch_array($query);
          // print_r($data);

          $_SESSION['active'] = true;
          $_SESSION['idUser'] = $data['idusuario'];
          $_SESSION['nombre'] = $data['nombre'];
          $_SESSION['email'] = $data['email'];
          $_SESSION['user'] = $data['usuario'];
          $_SESSION['rol'] = $data['rol'];
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
