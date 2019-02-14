<aside class="main-sidebar">
	<section class="sidebar">
		<ul class="sidebar-menu">
			<!-- Se definen los botones del menu general, estan definidos en el Bootstrap 
				estos iconos estan definidos en el portal : "http://fontawesome.io/icons"
			-->

			<li class="active">
				<!-- Si no se tuvieran url amigables se tendría que teclear : <a href="index.php?ruta=inicio">, por lo que se mostrará la ruta completa en el barra de direcciones, pero con el archivo ".htaccess" se oculta la variable "ruta" -->
				<a href="inicio">
					<i class="fa fa-home"></i> 
					<span>Inicio</span>
				</a>
			</li>
			<li>
				<a href="usuarios">
					<i class="fa fa-user"></i>
					<span>Usuarios</span>
				</a>
			</li>
			<li>
				<a href="categorias">
					<i class="fa fa-product-hunt"></i>
					<span>Categorias</span>
				</a>
			</li>
			<li>
				<a href="clientes">
					<i class="fa fa-users"></i>
					<span>Clientes</span>
				</a>
			</li>

			<!-- Botonera en Arbol -->
			<li class="treeview">
				<a href="#">
					<i class="fa fa-list-ul"></i>
					<span>Ventas</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>  <!-- Despliega un icono al lado Izq.-->
					</span>
				</a>

				<!-- Menu desplegable -->
				<ul class="treeview-menu">
					<li>
						<a href = "ventas">
							<i class="fa fa-circle-o"></i>
							<span>Administrar Ventas</span>
						</a>
					</li>
					<li>
						<a href = "crear-venta">
							<i class="fa fa-circle-o"></i>
							<span>Crear Ventas</span>
						</a>
					</li>
					<li>
						<a href = "reportes">
							<i class="fa fa-circle-o"></i>
							<span>Reportes Ventas</span>
						</a>
					</li>

				</ul>

			</li>

		</ul>

	</section>
</aside>