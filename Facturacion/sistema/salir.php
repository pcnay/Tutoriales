<?php
  session_start();
  session_destroy();
  header ('location: ../'); // Regresa una carpeta antes, sube un nivel.
?>
