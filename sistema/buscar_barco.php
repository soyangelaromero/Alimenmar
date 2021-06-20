<?php 
	session_start();
	if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
	{
		header("location: ./");
	}

	include "../conexion.php";	

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de Barcos</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<?php 

			$busqueda = strtolower($_REQUEST['busqueda']);
			if(empty($busqueda))
			{
				header("location: lista_barcos.php");
				mysqli_close($conection);
			}


		 ?>
		
		<h1>Lista de Barcos</h1>
		<a href="registro_jornada.php" class="btn_new">Crear Barco</a>
		
		<form action="buscar_barco.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
            <th>Codigo de Identificacion</th>
				<th>Nombre</th>
				<th>Operador</th>
                <th>Tripulacion</th>
				<th>Capacidad</th>
                <th>Acciones</th>
			</tr>
		<?php 
			//Paginador
		
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM barcos 
																WHERE ( codbarco LIKE '%$busqueda%' OR 
																		nombre LIKE '%$busqueda%' OR 
																		operador LIKE '%$busqueda%' OR
																		tripulacion LIKE '%$busqueda%' OR 
																		capacidad LIKE '%$busqueda%'
																		 ) 
																AND estatus = 1  ");

			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			$por_pagina = 5;

			if(empty($_GET['pagina']))
			{
				$pagina = 1;
			}else{
				$pagina = $_GET['pagina'];
			}

			$desde = ($pagina-1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			$query = mysqli_query($conection,"SELECT * FROM barcos WHERE 
										( codbarco LIKE '%$busqueda%' OR 
											nombre LIKE '%$busqueda%' OR 
											operador LIKE '%$busqueda%' OR 
											tripulacion LIKE '%$busqueda%' OR 
											capacidad LIKE '%$busqueda%') 
										AND
										estatus = 1 ORDER BY codbarco ASC LIMIT $desde,$por_pagina 
				");
			mysqli_close($conection);
			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
					
			?>
				<tr>

                    <td><?php echo $data["codbarco"]; ?></td>
					<td><?php echo $data["nombre"]; ?></td>
					<td><?php echo $data["operador"]; ?></td>
					<td><?php echo $data["tripulacion"]; ?></td>
					<td><?php echo $data['capacidad'] ?></td>

					<td>
						<a class="link_edit" href="editar_barco.php?id=<?php echo $data["codbarco"]; ?>">Editar</a>

					<?php if($_SESSION['rol']==1 ||$_SESSION['rol']==2){ ?>
						|
						<a class="link_delete" href="eliminar_confirmar_barco.php?id=<?php echo $data["codbarco"]; ?>">Eliminar</a>
					<?php } ?>
						
					</td>
				</tr>
			
		<?php 
				}

			}
		 ?>


		</table>
<?php 
	
	if($total_registro != 0)
	{
 ?>
		<div class="paginador">
			<ul>
			<?php 
				if($pagina != 1)
				{
			 ?>
				<li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
			<?php 
				}
				for ($i=1; $i <= $total_paginas; $i++) { 
					# code...
					if($i == $pagina)
					{
						echo '<li class="pageSelected">'.$i.'</li>';
					}else{
						echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
					}
				}

				if($pagina != $total_paginas)
				{
			 ?>
				<li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?> ">>|</a></li>
			<?php } ?>
			</ul>
		</div>
<?php } ?>


	</section>
</body>
</html>