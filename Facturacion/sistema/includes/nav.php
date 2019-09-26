<nav>
			<ul>
				<li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
				
				<!-- Habilitando las opciones para el administrador -->
				<?php 					
					if ($_SESSION['rol'] == 1)
					{
				?>
				<li class="principal">
				
				<!-- <span class="arrow">  Se utiliza para colocar una flecha para indicar que tiene mas opciones en modo de pantalla pequeña -->
					<a href="#"><i class="fas fa-users"></i> Usuarios <span class="arrow"><i class="fas fa-angle-down"></i></span></a>
					<ul>
						<li><a href="registro_usuario.php"><i class="fas fa-user-plus"></i> Nuevo Usuario</a></li>
						<li><a href="lista_usuarios.php"><i class="fas fa-users"></i> Lista de Usuarios</a></li>
						<li><a href="#">Otra opcion de Usuarios</a></li>
					</ul>
				</li>
				<?php 
					} // if ($_SESSION['rol'] == 1)
				?>

				<li class="principal">
					<a href="#"><i class="fas fa-user"></i>Clientes<span class="arrow"><i class="fas fa-angle-down"></i></span></a>
					<ul>
						<li><a href="registro_cliente.php"><i class="fas fa-plus"></i> Nuevo Clientes</a></li>
						<li><a href="lista_clientes.php"><i class="fas fa-alt"></i> Lista Clientes</a></li>
					</ul>
				</li>

				<!-- Solo es visible para usuarios "Administrador" y "Supervisor"-->
				<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)	{?>
				<li class="principal">
					<a href="#"><i class="far fa-building"></i>Proveedores <span class="arrow"><i class="fas fa-angle-down"></i></span></a>
					<ul>
						<li><a href="registro_proveedor.php"><i class="far fa-building"></i> Nuevo Proveedor </a></li>
						<li><a href="lista_proveedor.php"><i class="far fa-list-alt"></i> Lista de Proveedores</a></li>
					</ul>
				</li>
				<?php } // if ($_SESSION['rol'] == 1)	($_SESSION['rol'] == 2) ?>

				<!-- Solo es visible para usuarios "Administrador" y "Supervisor"-->

					<li class="principal">
						<a href="#"><i class="fas fa-cubes"></i>Productos <span class="arrow"><i class="fas fa-angle-down"></i></span></a>
						<ul>
							<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)	{?>
								<li><a href="registro_producto.php"><i class="fas fa-plus"></i> Nuevo Producto</a></li>
							<?php } // if ($_SESSION['rol'] == 1)	($_SESSION['rol'] == 2) ?>				

							<li><a href="lista_producto.php"><i class="fas fa-cube"></i> Lista de Productos</a></li>
						</ul>
					</li>
				
				<li class="principal">
					<a href="#"><i class="far fa-file-alt"></i> Ventas <span class="arrow"><i class="fas fa-angle-down"></i></span></a>
					<ul>
						<li><a href="nueva_venta.php"><i class="fas fa-plus"></i>Nueva Venta</a></li>
						<li><a href="ventas.php"><i class="far fa-newspaper"></i>Ventas</a></li>
					</ul>
				</li>
			</ul>
		</nav>
