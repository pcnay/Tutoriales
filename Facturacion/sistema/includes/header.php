<?php 
//session_start();

// Con esta condicion no se muestra el encabezado, cuando no se tiene la sesión activa.
if (empty($_SESSION['active']))
{
	//header ('location: ../index.php');
	header ('location: ../');
}

?>

<header>
		<div class="header">
			
			<h1>Sistema Facturación</h1>
			<div class="optionsBar">
				<p>Tijuana, <?php echo fechaC();?></p>
				<span>|</span>
				<span class="user"><?php echo $_SESSION['usuario'].' - '.$_SESSION['rol']; ?></span>
				<img class="photouser" src="img/user.png" alt="Usuario">
				<a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
    <?php include "nav.php"; ?>
</header>

<div class="modal">
	<div class="bodyModal">
	
		<!-- Se copia el código en "function.js" ya que se muestra a tráves de JavaScript .-->

	</div> <!-- <div class="bodyModal"> -->

</div>
