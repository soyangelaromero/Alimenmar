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
		if( empty($_POST['hora']) || empty($_POST['gananciab']) || empty($_POST['ganancian']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

            $idfactura =$_POST['id'];
			$hora     = $_POST['hora'];
			$mercancia   = $_POST['mercancia'];
			$gananciab   = $_POST['gananciab'];
            $gastos   = $_POST['gastos'];
            $ganancian  = $_POST['ganancian'];


					$sql_update = mysqli_query($conection,"UPDATE facturas
															SET  hora='$hora', mercancia='$mercancia',gananciab='$gananciab, gastos='$gastos'
                                                            ,ganancian='$ganancian'
															WHERE codfac= $idfactura");

				if($sql_update){
					$alert='<p class="msg_save">Factura actualizada correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar la Factura.</p>';
				

			}


	}

}

	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_facturas.php');
		mysqli_close($conection);
	}
	$codfac = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT * FROM facturas WHERE codfac= $codfac ");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_facturas.php');
	}else{

		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$idfactura       = $data['codfac'];
			$hora        = $data['hora'];
			$mercancia   = $data['mercancia'];
			$gananciab   = $data['gananciab'];
            $gastos   = $data['gastos'];
			$ganancian    = $data['ganancian'];
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Factura</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar Factura</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $idfactura;?>">
                <label for="fecha">Fecha</label>
				<input type="date" name="fecha" id="fecha" placeholder="Fecha de Creacion" value="<?php echo $fecha ?>">
				<label for="hora">Hora</label>
				<input type="text" name="hora" id="hora" placeholder="Hora" value="<?php echo $hora ?>"> 
				<label for="mercancia">Mercancia</label>
				<input type="number" name="mercancia" id="mercancia" placeholder="Mercancia"value="<?php echo $mercancia ?>">
				<label for="gananciab">Ganancia Bruta</label>
				<input type="number" name="gananciab" id="gananciab" placeholder="Ganancia Bruta" value="<?php echo $gananciab ?>">
				<label for="gastos">Gastos Operativos</label>
				<input type="number" name="gastos" id="gastos" placeholder="gastos" value="<?php echo $gastos ?>">
                <label for="ganancian">Ganancia Neta</label>
				<input type="number" name="ganancian" id="ganancian" placeholder="Ganancia Neta" value="<?php echo $ganancian ?>">


				<input type="submit" value="Actualizar Factura " class="btn_save">

			</form>


		</div>


	</section>
</body>
</html>