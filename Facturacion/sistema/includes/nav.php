<nav>
			<ul>
				<li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
				
				<!-- Habilitando las opciones para el administrador -->
				<?php 					
					if ($_SESSION['rol'] == 1)
					{
				?>
				<li class="principal">
					<a href="#"><i class="fas fa-users"></i> Usuarios</a>
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
					<a href="#">Clientes</a>
					<ul>
						<li><a href="registro_cliente.php"><i class="fas fa-plus"></i> Nuevo Clientes</a></li>
						<li><a href="lista_clientes.php"><i class="fas fa-alt"></i> Lista Clientes</a></li>
					</ul>
				</li>
				<?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)	{?>
				<li class="principal">
					<a href="#">Proveedores</a>
					<ul>
						<li><a href="registro_proveedor.php"><i class="far fa-building"></i> Nuevo Proveedor</a></li>
						<li><a href="#">Lista de Proveedores</a></li>
					</ul>
				</li>
				<?php } // if ($_SESSION['rol'] == 1)	($_SESSION['rol'] == 2) ?>

				<li class="principal">
					<a href="#">Productos</a>
					<ul>
						<li><a href="#">Nuevo Producto</a></li>
						<li><a href="#">Lista de Productos</a></li>
					</ul>
				</li>
				<li class="principal">
					<a href="#">Facturas</a>
					<ul>
						<li><a href="#">Nuevo Factura</a></li>
						<li><a href="#">Facturas</a></li>
					</ul>
				</li>
			</ul>
		</nav>
