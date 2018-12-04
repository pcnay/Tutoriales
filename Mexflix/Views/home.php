<?php 
  $template = '
    <article class = "item">
      <h2 class = "p1">Hola %s Bienvenido a MexFlix </h2>
      <h3 class = "p1">Tus películas y series favoritas</h3>
      <p class = "p1 f1_25">Tu nombre es <b>%s</b></p>
      <p class = "p1 f1_25">Tu email es <b>%s</b></p>
      <p class = "p1 f1_25">Tu cumpleaños es <b>%s</b></p>
      <p class = "p1 f1_25">Tu perfil de usuario tiene el nivel de <b>%s</b></p>
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
