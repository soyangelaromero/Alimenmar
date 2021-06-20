<?php 
	
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}

	include "../conexion.php";

    if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['nombre']) || empty($_POST['tripulacion']) || empty($_POST['capacidad']) || empty($_POST['operador']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idbarco        = $_POST['id'];
            $nombre         = $_POST['nombre'];
			$operador       = $_POST['operador'];
			$tripulacion    = $_POST['tripulacion'];
			$capacidad      = $_POST['capacidad'];


					$sql_update = mysqli_query($conection,"UPDATE barcos
															SET nombre = '$nombre', operador='$operador', tripulacion='$tripulacion',capacidad='$capacidad'
															WHERE codbarco= $idbarco ");

				if($sql_update){
					$alert='<p class="msg_save">Barco actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el barco.</p>';
				

			}


	}

}

	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_barcos.php');
		mysqli_close($conection);
	}
	$idbarco = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT * FROM barcos WHERE codbarco= $idbarco ");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_barcos.php');
	}else{

		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$idbarco       = $data['codbarco'];
			$nombre        = $data['nombre'];
			$operador      = $data['operador'];
			$tripulacion   = $data['tripulacion'];
			$capacidad     = $data['capacidad'];
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Barco</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar Barco</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $idbarco;?>">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre del Barco" value="<?php echo $nombre ?>">
				<label for="operador">Operador</label>
				<input type="text" name="operador" id="operador" placeholder="Operador" value="<?php echo $operador ?>"> 
				<label for="tripulacion">Tripulación</label>
				<input type="number" name="tripulacion" id="tripulacion" placeholder="Tripulación"value="<?php echo $tripulacion ?>">
				<label for="capacidad">Capacidad (Kg)</label>
				<input type="number" name="capacidad" id="capacidad" placeholder="Capacidad (Kg)" value="<?php echo $capacidad ?>">
				


				<input type="submit" value="Actualizar Barco " class="btn_save">

			</form>


		</div>


	</section>
</body>
</html>