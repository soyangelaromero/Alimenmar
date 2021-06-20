<?php 
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{
		if(empty($_POST['codfac']))
		{
			header("location: lista_facturas.php");
			mysqli_close($conection);
		}
		$codfac = $_POST['codfac'];

		//$query_delete = mysqli_query($conection,"UPDATE barcos SET estatus = 0 WHERE codbarco = $idbarco ");
		$query_delete = mysqli_query($conection,"DELETE FROM facturas  WHERE codfac = $codfac");
		mysqli_close($conection);
		if($query_delete){
			header("location: lista_barco.php");
		}else{
			echo "Error al eliminar";
		}

	}




	if(empty($_REQUEST['id']) )
	{
		header("location: lista_facturas.php");
		mysqli_close($conection);
	}else{

		$codfac = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT * FROM facturas WHERE codfac = $codfac ");
		
		mysqli_close($conection);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
                $codfac=$data['codfac'];
                $fecha=$data['fecha'];
                $hora=$data['hora'];
			}
		}else{
			header("location: lista_facturas.php");
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
			<p>Codigo de Factura: <span><?php echo $codfac; ?></span></p>
			<p>Fecha: <span><?php echo $fecha; ?></span></p>
            <p>Hora: <span><?php echo $hora; ?></span></p>

			<form method="post" action="">
				<input type="hidden" name="codfac" value="<?php echo $codfac; ?>">
				<a href="lista_facturas.php" class="btn_cancel">Cancelar</a>
				<input type="submit" value="Eliminar" class="btn_ok">
			</form>
		</div>


	</section>
</body>
</html>