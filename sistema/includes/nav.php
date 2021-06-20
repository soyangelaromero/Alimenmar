		<nav>
			<ul>
				<li><a href="index.php">Inicio</a></li>
				<?php 
				if($_SESSION['active']){
			 ?>
				
			<?php } ?>

			<?php 
				if($_SESSION['rol'] == 1){
			 ?>
				<li class="principal">

					<a href="#">Usuarios</a>
					<ul>
						<li><a href="registro_usuario.php">Nuevo Usuario</a></li>
						<li><a href="lista_usuarios.php">Lista de Usuarios</a></li>
					</ul>
				</li>
			<?php } ?>
				<li class="principal">
					<a href="#">Jornadas</a>
					<ul>
						<li><a href="registro_jornada.php">Nueva Jornada</a></li>
						<li><a href="lista_jornadas.php">Lista de Jornadas</a></li>
					</ul>
				</li>
					<?php
				if($_SESSION['rol'] == 1 || $_SESSION['rol']==2){
					?>
				<li class="principal">
					<a href="#">Barcos</a>
					<ul>
						<li><a href="registro_barco.php">Nuevo Barco</a></li>
						<li><a href="lista_barcos.php">Lista de Barcos</a></li>
					</ul>
				</li>
				<?php } ?>
				<li class="principal">
					<a href="#">Facturas</a>
					<ul>
						<li><a href="registro_factura.php">Nueva Factura</a></li>
						<li><a href="lista_facturas.php">Lista de Facturas</a></li>
					</ul>
				</li>
					<?php
				if( $_SESSION['rol']==2){
					?>
				<li class="principal">
					<a href="#">Mi cuenta</a>
					<ul>
						<li><a href="lista_usuarios2.php">Visualizar</a></li>
					</ul>
				</li>
				<?php } ?>

			


			</ul>
		</nav>