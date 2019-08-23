<?php
  //include_once('../conexion.php');
  session_start();
  session_destroy();
  //mysqli_close($conexion);
  header ('location: ../'); // Regresa una carpeta antes, sube un nivel.
?>
