<?php
	session_start();
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/script.php"; ?>

	<title>Sisteme Ventas</title>
</head>
<body>
	<?php 
		include "includes/header.php"; 
		include "../conexion.php";

		// Obteniendo los datos de la Empresa
		$init = '';
		$nombreEmpresa = '';
		$razonSocial = '';
		$telEmpresa = '';
		$emailEmpresa = '';
		$dirEmpresa = '';
		$iva = '';

		$query_empresa = mysqli_query($conexion,"SELECT * FROM configuracion");
		$row_empresa = mysqli_num_rows($query_empresa);
		if ($row_empresa > 0)
		{
			while ($arrInfoEmpresa = mysqli_fetch_assoc($query_empresa))
			{
				$nit = $arrInfoEmpresa['nit'];
				$nombreEmpresa = $arrInfoEmpresa['nombre'];
				$razonSocial = $arrInfoEmpresa['razon_social'];
				$telEmpresa = $arrInfoEmpresa['telefono'];
				$emailEmpresa = $arrInfoEmpresa['email'];
				$dirEmpresa = $arrInfoEmpresa['direccion'];
				$iva = $arrInfoEmpresa['iva'];
			}
		}


		$query_dash = mysqli_query($conexion, "CALL dataDashboard();");
		$result_dash = mysqli_num_rows($query_dash);
		if($result_dash >0)
		{
			$data_dash = mysqli_fetch_assoc($query_dash);
			mysqli_close($conexion);		
		}
		// Con el inspector de elementos se puede ver este "print_r"
		//print_r($data_dash);

	?>
	<section id="container">
		<div class="divContainer">
			<div>
				<h1 class="titlePanelControl">Panel de Control</h1>
			</div>
			<div class="dashboard">
		<?php 
					if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)
					{
		?>
						<a href="lista_usuarios.php">
							<i class = "fas fa-users"></i>
							<p>
								<strong>Usuarios</strong><br/>
								<span><?= $data_dash['usuarios']; ?></span>						
							</p>
						</a>
		<?php }	?>

				<a href="lista_clientes.php">
					<i class = "fas fa-users"></i>
					<p>
						<strong>Clientes</strong><br/>
						<span><?= $data_dash['clientes']; ?></span>						
					</p>
				</a>
				
		<?php 
					if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)
					{
		?>
<				<a href="lista_proveedor.php">
					<i class = "far fa-building"></i>
					<p>
						<strong>Proveedores</strong><br/>
						<span><?php echo $data_dash['proveedores'];?></span>						
					</p>
				</a>
		<?php }	?>				
				<a href="lista_producto.php">
					<i class = "fas fa-cubes"></i>
					<p>
						<strong>Producto</strong><br/>
						<span><?php echo $data_dash['productos'];?></span>						
					</p>
				</a>
				<a href="ventas.php">
					<i class = "far fa-file-alt"></i>
					<p>
						<strong>Ventas</strong><br/>
						<span><?php echo $data_dash['ventas'];?></span>						
					</p>
				</a>

			</div> <!-- <div class="dashboard"> -->

		</div> <!-- <div class="divContainer">-->

		<div class="divInfoSistema">
			<div>
				<h1 class="titlePanelControl">Configuracion</h1>
			</div>
			<div class="containerPerfil">
				<div class="containerDataUser">
					<div class="logoUser">
						<img src="img/logoUser.png">
					</div>
					<div class="divDataUser">
						<h4>Informacion Personal</h4>
							<div>
								<label>Nombre:</label><span><?= $_SESSION['nombre']; ?></span>								
							</div>
							<div>
								<label>Correo:</label><span><?= $_SESSION['correo']; ?></span>	
							</div>
							<h4>Datos Usuarios</h4>
							<div>
								<label>Rol:</label><span><?php echo $_SESSION['rol_name']; ?></span>								
							</div>
							<div>
								<label>Usuario:</label><span><?php echo $_SESSION['usuario']; ?></span>	
							</div>

							<h4>Cambiar Contraseña</h4>
							<form action="" method = "post" name="frmChangePass" id="frmChangePass">
								<div>
									<input type="password" name="txtPassUser" id="txtPassUser" placeholder="Contraseña Actual " required>
								</div>
								<div>
									<input type="password" class="newPass" name="txtNewPassUser" id="txtNewPassUser" placeholder="Nueva Contraseña" required>									
								</div>
								<div>
									<input type="password" class="newPass" name="txtPassConfirm" id="txtPassConfirm" placeholder="Confirmar Contraseña" required>									
								</div>

								<!-- Aqui se coloca el mensaje, cuando las contraseña nueva y confirmación no coeinciden -->
								<div class="alertChangePass" style="display:none;">
								</div>

								<div>
									<button type="submit" class="btn_save btnChangePass"><i class="fas fa-key"></i> Cambiar Contraseña</button>									
								</div>
								
							</form>

					</div> <!-- <div class="divDataUser"> -->

				</div> <!-- <div class="containerDataUser"> -->

				<?php if ($_SESSION['rol'] == 1 )
							{ ?>
								<div class="containerDataEmpresa">
									<div class="logoEmpresa">
										<img src="img/logoEmpresa.png">
									</div>

									<h4>Datos De La Empresa</h4>

									<form action="" method = "post" name="frmEmpresa" id="frmEmpresa">
										<input type="hidden" name="action" value="updateDataEmpresa"> 

										<div>
											<label>Nit:</label>
											<input type="text" name="txtNit" id="txtNit" placeholder="Nit De La Empresa " value="<?php echo $nit; ?>" required>
										</div>
										<div>
										<label>Nombre:</label>
											<input type="text" name="txtNombre" id="txtNombre" placeholder="Nombre De La Empresa" value="<?php echo $nombreEmpresa; ?>" required>
										</div>
										<div>
										<label>Razon Social:</label>
											<input type="text" name="txtRSocial" id="txtRSocial" placeholder="Razon Social De La Empresa" value="<?= $razonSocial; ?>" >
										</div>
										<div>
										<label>Telefono:</label>
											<input type="text" name="txtTelEmpresa" id="txtTelEmpresa" placeholder="Número Teléfonico" value="<?= $telEmpresa; ?>" required>
										</div>
										<div>
										<label>Correo Electrónico:</label>
											<input type="email" name="txtEmailEmpresa" id="txtEmailEmpresa" placeholder="Correo Electrónico" value="<?php echo $emailEmpresa; ?>" required>
										</div>
										<div>
										<label>Dirección :</label>
											<input type="text" name="txtDirEmpresa" id="txtDirEmpresa" placeholder="Direccion De La Empresa" value="<?= $dirEmpresa; ?>" required>
										</div>
										<div>
										<label>IVA (%) :</label>
											<input type="text" name="txtIva" id="txtIva" placeholder="Impuesto Al Valor Agregado (IVA)" value="<?php echo $iva; ?>" required>
										</div>

										<div class="alertFormEmpresa" style="display:none;"></div>

										<div>
											<button type="submit" class="btn_save btnChangePass"><i class="far fa-save fa-lg"></i> Guardar Datos</button>									
										</div>								
									</form>

								</div> <!-- <div class="containerDataEmpresa"> -->
				<?php  } ?>
				
			</div> <!-- <div class="containerPerfil"> -->

		</div> <!-- class="divInfoSistema"-->

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>