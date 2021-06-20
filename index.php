<?php 
	
$alert = '';
session_start();
if(!empty($_SESSION['active']))
{
	header('location: sistema/');
}else{

	if(!empty($_POST))
	{
		if(empty($_POST['cedula']) || empty($_POST['clave']))
		{
			$alert = 'Ingrese su cédula de identidad y su contraseña';
		}else{

			require_once "conexion.php";

			$cedula = mysqli_real_escape_string($conection,$_POST['cedula']);
			$pass= $_POST['clave'];

			$query = mysqli_query($conection,"SELECT * FROM usuario WHERE cedula= '$cedula' AND clave = '$pass'");
			mysqli_close($conection);
			$result = mysqli_num_rows($query);

			if($result > 0)
			{
				$data = mysqli_fetch_array($query);
				$_SESSION['active'] = true;
				$_SESSION['idUser'] = $data['idusuario'];
				$_SESSION['nombre'] = $data['nombre'];
				$_SESSION['cedula'] = $data['cedula'];
				$_SESSION['email']  = $data['email'];
				$_SESSION['user']   = $data['usuario'];
				$_SESSION['rol']    = $data['rol'];

				header('location: sistema/');
			}else{
				$alert = 'La cédula de identidad o la contraseña son incorrectos';
				session_destroy();
			}


		}

	}
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Inicio de Sesión</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<section id="container">
		
		<form action="" method="post">
			
			<img src="Images/logo.png" alt="Login" style="width: 250px; height: 250px">

			<input type="integer" name="cedula" placeholder="Cédula de Identidad">
			<input type="password" name="clave" placeholder="Contraseña">
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			<input type="submit" value="INGRESAR">

		</form>

	</section>
</body>
</html>