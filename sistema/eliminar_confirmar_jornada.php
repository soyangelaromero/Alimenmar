<?php 
	session_start();
	if($_SESSION['rol'] != 1 and $_SESSION['rol'] !=2)
	{
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{
		if(empty($_POST['idjornada']))
		{
			header("location: lista_jornadas.php");
			mysqli_close($conection);
		}
		$idjornada = $_POST['idjornada'];

		$query_delete = mysqli_query($conection,"DELETE FROM jornadas WHERE idjornada =$idjornada ");
		//$query_delete = mysqli_query($conection,"UPDATE jornadas SET estatus = 0 WHERE idjornada = $idjornada ");
		mysqli_close($conection);
		if($query_delete){
			header("location: lista_jornadas.php");
		}else{
			echo "Error al eliminar";
		}

	}




	if(empty($_REQUEST['id']) )
	{
		header("location: lista_jornadas.php");
		mysqli_close($conection);
	}else{

		$idjornada = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT * FROM jornadas WHERE idjornada = $idjornada ");
		
		mysqli_close($conection);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
				$nit = $data['nit'];
				$fecha = $data['fecha'];
			}
		}else{
			header("location: lista_jornadas.php");
		}


	}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Jornada</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Está seguro de eliminar la siguiente Jornada?</h2>
			<p>Número de Jornada: <span><?php echo $nit; ?></span></p>
			<p>Fecha: <span><?php echo $fecha; ?></span></p>

			<form method="post" action="">
				<input type="hidden" name="idjornada" value="<?php echo $idjornada; ?>">
				<a href="lista_jornadas.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Eliminar" class="btn_ok">
			</form>
		</div>


	</section>
</body>
</html>