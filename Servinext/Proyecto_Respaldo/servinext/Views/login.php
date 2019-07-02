<form class="item" method="post">
<!-- NO se utilizara el parámetro "action", porque el paso de informnación a las ventanas seran por las rutas se utilizan las variables globales $_POST, $_GET -->
	<div class="p_25">
		<!-- "p_25" son valores de la libreria "responsible", son 0.25 a los lados.-->
		<input type="text" name="user" placeholder="usuario" required>		
	</div>
	<div class="p_25">
		<input type="password" name="pass" placeholder="Password" required>
	</div>
	<div class="p_25">
		<!-- Este boton es el que procesara el formulario-->
		<input type="submit" name="button" value="Enviar" >
	</div>
	<!-- Cuando se oprime el boton de "Enviar", se generara las variables globales $_POST['user'],$_POST['password']--> 
</form>
<!-- Se agrega este código para cuando no exista el usuario, muestre un mensaje.-->
<?php
		if(isset($_GET['error']))
{?>
	<div class="container">
		<p class="item error"><?php print $_GET['error']; ?></p>
	</div>
<?php } ?>

