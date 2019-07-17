<?php
  $template = '
    <article class="item">
      <h2 class= "p1">Hola %s Bienvenid@ al Control de SGI</h2>
      <p class= "p1 f1_25">Tu Nombre es: <b>%s</b> </p>
      <p class= "p1 f1_25">Tu email es : <b>%s</b> </p>
      <p class= "p1 f1_25">Tu cumpleaños es : <b>%s</b> </p>
      <p class= "p1 f1_25">Tu perfil de usuario  : <b>%s</b> </p>  
    </article>
  ';
  
  printf ($template,
    $_SESSION['usuario'],
    $_SESSION['nombre'],
    $_SESSION['email'],
    $_SESSION['cumpleanos'],
    $_SESSION['perfil']
  );
?>