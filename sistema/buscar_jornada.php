<?php 
	session_start();
	if($_SESSION['rol'] != 1)
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
	<title>Lista de Jornadas</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<?php 

			$busqueda = strtolower($_REQUEST['busqueda']);
			if(empty($busqueda))
			{
				header("location: lista_jornadas.php");
				mysqli_close($conection);
			}


		 ?>
		
		<h1>Lista de Jornadas</h1>
		<a href="registro_jornada.php" class="btn_new">Crear Jornada</a>
		
		<form action="buscar_jornada.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>

		<table>
			<tr>
				<th>IDjornada</th>
				<th>Nro Jornada</th>
				<th>Fecha</th>
				<th>Hora de inicio</th>
				<th>Hora de cierre</th>
				<th>Estado del clima</th>
                <th>Precio Compra</th>
			</tr>
		<?php 
			//Paginador
		
			$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro FROM jornadas 
																WHERE ( idjornada LIKE '%$busqueda%' OR 
																		nit LIKE '%$busqueda%' OR 
																		fecha LIKE '%$busqueda%' OR 
																		horai LIKE '%$busqueda%' OR
                                                                        horac LIKE '%$busqueda%' OR
                                                                        clima LIKE '%$busqueda%' OR
                                                                        precioc LIKE '%$busqueda%'
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

			$query = mysqli_query($conection,"SELECT * FROM jornadas WHERE 
										( idjornada LIKE '%$busqueda%' OR 
											nit LIKE '%$busqueda%' OR 
											fecha LIKE '%$busqueda%' OR 
											horai LIKE '%$busqueda%' OR 
											horac  LIKE  '%$busqueda%' OR
                                            clima LIKE  '%$busqueda%' OR
                                            precioc  LIKE  '%$busqueda%') 
										AND
										estatus = 1 ORDER BY idjornada ASC LIMIT $desde,$por_pagina 
				");
			mysqli_close($conection);
			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
					
			?>
				<tr>
					<td><?php echo $data["idjornada"]; ?></td>
					<td><?php echo $data["nit"]; ?></td>
					<td><?php echo $data["fecha"]; ?></td>
					<td><?php echo $data["horai"]; ?></td>
					<td><?php echo $data["horac"] ?></td>
                    <td><?php echo $data["clima"] ?></td>
                    <td><?php echo $data["precioc"] ?></td>
					<td>
						<a class="link_edit" href="editar_jornada.php?id=<?php echo $data["idjornada"]; ?>">Editar</a>

					<?php if($_SESSION['rol']==1 ||$_SESSION['rol']==2){ ?>
						|
						<a class="link_delete" href="eliminar_confirmar_jornada.php?id=<?php echo $data["idjornada"]; ?>">Eliminar</a>
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