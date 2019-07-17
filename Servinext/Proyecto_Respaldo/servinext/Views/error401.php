<?php
  print('
    <h2 class="p1 error" >Error 401: NO tienes acceso para este recurso </h2> 
    <img class = "p1 img-404" src = "./Public/img/error404.png" alt = "NO tienes Accesso ">
    <!-- Centra el boton, la pasa a Block (Baja el boton)  y lo centra -->
    <input type= "button" class="button add block mauto" value="Regresar" onclick="history.back()">

  ');
?>