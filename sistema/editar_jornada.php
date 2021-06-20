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
		if(empty($_POST['fecha']) || empty($_POST['horai']) || empty($_POST['horac'])  || empty($_POST['clima']) || empty($_POST['precioc']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idjornada  = $_POST['id'];
            $nit        = $_POST['nit'];
			$fecha      = $_POST['fecha'];
			$horai      = $_POST['horai'];
			$horac      = $_POST['horac'];
			$clima      = $_POST['clima'];
			$precioc    = $_POST['precioc'];

            $result= 0;

            if(is_numeric($nit) and $nit !=0)
            {
                $query = mysqli_query($conection,"SELECT * FROM jornadas WHERE (nit= '$nit' AND idjornada != idjornada)");

                $result=mysqli_fetch_array($query);
                

            }


			if($result > 0){
				$alert='<p class="msg_error">El numero de jornada ya existe.</p>';
			}else{

                if($nit=='')
                {
                    $nit=0;
                }

					$sql_update = mysqli_query($conection,"UPDATE jornadas
															SET nit = $nit, fecha='$fecha',horai='$horai',horac='$horac'
                                                            ,clima='$clima',precioc='$precioc'
															WHERE idjornada= $idjornada ");

				if($sql_update){
					$alert='<p class="msg_save">Jornada actualizada correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar la jornada.</p>';
				}

			}


	}

}

	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_jornadas.php');
		mysqli_close($conection);
	}
	$idjornada = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT * FROM jornadas WHERE idjornada= $idjornada ");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_jornadas.php');
	}else{

		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$idjornada  = $data['idjornada'];
			$nit        = $data['nit'];
			$fecha      = $data['fecha'];
			$horai      = $data['horai'];
			$horac      = $data['horac'];
			$clima      = $data['clima'];
            $precioc    = $data['precioc'];

		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Jornada</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar Jornada</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $idjornada;?>">
                <label for="nit">Número de Jornada</label>
				<input type="text" name="nit" id="nit" placeholder="Número de Jornada" value="<?php echo $nit;?>">
				<label for="fecha">Fecha</label>
				<input type="date" name="fecha" id="fecha" placeholder="Fecha de jornada"value="<?php echo $fecha;?>">
				<label for="horai">Hora de Inicio</label>
				<input type="time" name="horai" id="horai" placeholder="Hora de inicio"value="<?php echo $horai;?>">
				<label for="horac">Hora de Cierre</label>
				<input type="text" name="horac" id="horac" placeholder="Hora de cierre"value="<?php echo $horac;?>">
				<label for="clima">Estado del Clima</label>
				<input type="text" name="clima" id="clima" placeholder="Estado del clima"value="<?php echo $clima;?>">
                <label for="precioc">Precio Compra</label>
				<input type="number" min="1" step="any" name="precioc" id="precioc" placeholder="Precio Compra"value="<?php echo $precioc;?>">


				<input type="submit" value="Crear Jornada" class="btn_save">

			</form>


		</div>


	</section>
</body>
</html>