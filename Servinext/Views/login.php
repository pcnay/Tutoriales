<!-- Con este formulario se crean las variables globales GET_$ ("user", "pass")para ser utilizadas en la ventana de controlador -->
<form class = "item" method = "post">

  <div class = "p_25">
    <input type="text" name="user" placeholder="usuario" required>
  </div>
  <div class = "p_25">
    <input type="password" name="pass" placeholder="password" required>
  </div>
  <div class = "p_25">
    <input type="submit" class="button" value = "Enviar">
  </div>
</form>
<!-- Se esta pasando el mensaje de error por "GET" -->
<?php if (isset($_GET['error']) ) { ?>
  <div class = "container">
    <p class = "item error"><?php print $_GET['error']; ?></p>
  </div>
<?php } ?>