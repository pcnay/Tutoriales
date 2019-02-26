<?php
// 
print ('
   <h2 class "p1 error" >Error 401: NO tienes permiso para realizar esta operacion</h2>
   <!-- Ajustando la imagen al tamaño natural, utiliznado una clase para modificarlo en el CSS -->
   <img class="p1 img-404" src = "./public/img/not-found.png" alt = "Error 401">

    <input class = "button add block mauto" type = "button" value ="Regresar" onclick="history.back()">

    <!-- onclick="history.back()" = Regresa a la ruta anterior -->    
  ');