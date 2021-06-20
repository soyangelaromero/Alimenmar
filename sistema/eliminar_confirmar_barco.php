<?php 
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{
		if(empty($_POST['idbarco']))
		{
			header("location: lista_barcos.php");
			mysqli_close($conection);
		}
		$idbarco = $_POST['idbarco'];

		//$query_delete = mysqli_query($conection,"UPDATE barcos SET estatus = 0 WHERE codbarco = $idbarco ");
		$query_delete = mysqli_query($conection,"DELETE FROM barcos  WHERE codbarco = $idbarco");
		mysqli_close($conection);
		if($query_delete){
			header("location: lista_barco.php");
		}else{
			echo "Error al eliminar";
		}

	}




	if(empty($_REQUEST['id']) )
	{
		header("location: lista_barcos.php");
		mysqli_close($conection);
	}else{

		$idbarco = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT * FROM barcos WHERE codbarco = $idbarco ");
		
		mysqli_close($conection);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
                $idbarco=$data['codbarco'];
                $nombre=$data['nombre'];
			}
		}else{
			header("location: lista_barcos.php");
		}


	}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Barco</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Está seguro de eliminar el siguiente barco?</h2>
			<p>Codigo de Identificacion: <span><?php echo $idbarco; ?></span></p>
			<p>Nombre: <span><?php echo $nombre; ?></span></p>

			<form method="post" action="">
				<input type="hidden" name="idbarco" value="<?php echo $idbarco; ?>">
				<a href="lista_barcos.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Eliminar" class="btn_ok">
			</form>
		</div>


	</section>
</body>
</html>