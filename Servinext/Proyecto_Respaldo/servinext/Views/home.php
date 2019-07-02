<?php
  $template = '
    <article class="item">
      <h2>Hola %s Bienvenid@ al Control de SGI</h2>
      <p>Tu Nombre es: <b>%s</b> </p>
      <p>Tu email es : <b>%s</b> </p>
      <p>Tu cumpleaños es : <b>%s</b> </p>
      <p>Tu perfil de usuario  : <b>%s</b> </p>
    </article>
  ';
  
  printf ($template,
    $_SESSION['user'],
    $_SESSION['name'],
    $_SESSION['email'],
    $_SESSION['birthday'],
    $_SESSION['role']
  );
?>