<?php 
  $template = '
    <article class = "item">
      <h2>Hola %s Bienvenido a MexFlix </h2>
      <h3>Tus películas y series favoritas</h3>
      <p>Tu nombre es <b>%s</b></p>
      <p>Tu email es <b>%s</b></p>
      <p>Tu cumpleaños es <b>%s</b></p>
      <p>Tu perfil de usuario tiene el nivel de <b>%s</b></p>
    </article>
    ';
  printf (
    $template,
    $_SESSION['user'],
    $_SESSION['names'],
    $_SESSION['email'],
    $_SESSION['birthday'],
    $_SESSION['roles']
  );
?>
