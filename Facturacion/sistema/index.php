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
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="divContainer">
			<div>
				<h1 class="titlePanelControl">Panel de Control</h1>
			</div>
			<div class="dashboard">
				<a href="lista_usuarios.php">
					<i class = "fas fa-users"></i>
					<p>
						<strong>Usuarios</strong><br/>
						<span>40</span>						
					</p>
				</a>
				<a href="lista_clientes.php">
					<i class = "fas fa-users"></i>
					<p>
						<strong>Clientes</strong><br/>
						<span>10800</span>						
					</p>
				</a>
				<a href="lista_proveedor.php">
					<i class = "far fa-building"></i>
					<p>
						<strong>Proveedores</strong><br/>
						<span>200</span>						
					</p>
				</a>
				<a href="lista_producto.php">
					<i class = "fas fa-cubes"></i>
					<p>
						<strong>Producto</strong><br/>
						<span>2000</span>						
					</p>
				</a>
				<a href="ventas.php">
					<i class = "far fa-file-alt"></i>
					<p>
						<strong>Ventas</strong><br/>
						<span>500</span>						
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
								<label>Nombre:</label><span>Abel OS</span>								
							</div>
							<div>
								<label>Correo:</label><span>nombreCorreo@correo.com</span>	
							</div>
							<h4>Datos Usuarios</h4>
							<div>
								<label>Rol:</label><span>Administrador</span>								
							</div>
							<div>
								<label>Usario:</label><span>Admin</span>	
							</div>

							<h4>Cambiar Contraseña</h4>
							<form action="" method = "post" name="frmChangePass" id="frmChangePass">
								<div>
									<input type="password" name="txtPassUser" id="txtPassUser" placeholder="Contraseña Actual " required>
								</div>
								<div>
									<input type="password" name="txtNewPassUser" id="txtNewPassUser" placeholder="Nueva Contraseña" required>									
								</div>
								<div>
									<input type="password" name="txtPassConfirm" id="txtPassConfirm" placeholder="Confirmar Contraseña" required>									
								</div>
								<div>
									<button type="submit" class="btn_save btnChangePass"><i class="fas fa-key"></i> Cambiar Contraseña</button>									
								</div>
								
							</form>

					</div> <!-- <div class="divDataUser"> -->

				</div> <!-- <div class="containerDataUser"> -->

				<div class="containerDataEmpresa">
					<div class="logoEmpresa">
						<img src="img/logoEmpresa.png">
					</div>

					<h4>Datos De La Empresa</h4>

					<form action="" method = "post" name="frmEmpresa" id="frmEmpresa">
						<input type="hidden" name="action" value="updateDataEmpresa"> 

						<div>
							<label>Nit:</label>
							<input type="text" name="txtNit" id="txtNit" placeholder="Nit De La Empresa " value="" required>
						</div>
						<div>
						<label>Nombre:</label>
							<input type="text" name="txtNombre" id="txtNombre" placeholder="Nombre De La Empresa" value="" required>
						</div>
						<div>
						<label>Razon Social:</label>
							<input type="text" name="txtRSocial" id="txtRSocial" placeholder="Razon Social De La Empresa" value="" >
						</div>
						<div>
						<label>Telefono:</label>
							<input type="text" name="txtTelEmpresa" id="txtTelEmpresa" placeholder="Número Teléfonico" value="" required>
						</div>
						<div>
						<label>Correo Electrónico:</label>
							<input type="email" name="txtEmailEmpresa" id="txtEmailEmpresa" placeholder="Correo Electrónico" value="" required>
						</div>
						<div>
						<label>Dirección :</label>
							<input type="text" name="txtDirEmpresa" id="txtDirEmpresa" placeholder="Direccion De La Empresa" value="" required>
						</div>
						<div>
						<label>IVA (%) :</label>
							<input type="text" name="txtIva" id="txtIva" placeholder="Impuesto Al Valor Agregado (IVA)" value="" required>
						</div>

						<div class="alertFormEmpresa" style="display:none;"></div>

						<div>
							<button type="submit" class="btn_save btnChangePass"><i class="far fa-save fa-lg"></i> Guardar Datos</button>									
						</div>								
					</form>

				</div> <!-- <div class="containerDataEmpresa"> -->
				
			</div> <!-- <div class="containerPerfil"> -->

		</div> <!-- class="divInfoSistema"-->

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>