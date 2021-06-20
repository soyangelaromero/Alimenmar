<?php 
	
	session_start();
	include "../conexion.php";

	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['nombre']) || empty($_POST['apellido'])  || empty($_POST['cedula']) || empty($_POST['direccion']) || empty($_POST['telefono'])
		|| empty($_POST['correo']) || empty($_POST['usuario'])  || empty($_POST['rol']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idUsuario = $_POST['id'];
			$nombre = $_POST['nombre'];
			$apellido = $_POST['apellido'];
			$cedula = $_POST['cedula'];
			$direccion = $_POST['direccion'];
			$telefono = $_POST['telefono'];
			$correo  = $_POST['correo'];
			$user   = $_POST['usuario'];
			$clave  = $_POST['clave'];
			$rol    = $_POST['rol'];


			$query = mysqli_query($conection,"SELECT * FROM usuario 
													   WHERE (cedula = '$cedula' AND idusuario != $idUsuario)
													   OR (correo = '$correo' AND idusuario != $idUsuario) ");

			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert='<p class="msg_error">El correo o el usuario ya existe.</p>';
			}else{

				if(empty($_POST['clave']))
				{

					$sql_update = mysqli_query($conection,"UPDATE usuario
															SET nombre = '$nombre', apellido='$apellido',cedula='$cedula',direccion='$direccion',telefono='$telefono', correo='$correo',usuario='$user',rol='$rol'
															WHERE idusuario= $idUsuario ");
				}else{
					$sql_update = mysqli_query($conection,"UPDATE usuario
															SET nombre = '$nombre', apellido='$apellido',cedula='$cedula',direccion='$direccion',telefono='$telefono', correo='$correo',usuario='$user',rol='$rol'
															WHERE idusuario= $idUsuario ");

				}

				if($sql_update){
					$alert='<p class="msg_save">Usuario actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el usuario.</p>';
				}

			}


		}

	}

	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_usuarios.php');
		mysqli_close($conection);
	}
	$idUsuario = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT u.idusuario, u.nombre, u.apellido,u.cedula, u.direccion, u.telefono,u.correo,u.usuario, (u.rol) as idrol, (r.rol) as rol
									FROM usuario u
									INNER JOIN rol r
									on u.rol = r.idrol
									WHERE idusuario= $idUsuario ");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_usuarios.php');
	}else{
		$option = '';
		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$idUsuario 	= $data['idusuario'];
			$nombre 	= $data['nombre'];
			$apellido 	= $data['apellido'];
			$cedula 	= $data['cedula'];
			$direccion 	= $data['direccion'];
			$telefono 	= $data['telefono'];
			$correo  	= $data['correo'];
			$user   	= $data['usuario'];
			$idrol   	= $data['idrol'];
			$rol     	= $data['rol'];

			if($idrol == 1){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
			}else if($idrol == 2){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';	
			}else if($idrol == 3){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
			}


		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Usuario</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar usuario</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $idUsuario; ?>">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre completo"value="<?php echo $nombre; ?>">
				<label for="apellido">Apellido</label>
				<input type="text" name="apellido" id="apellido" placeholder="Apellido"value="<?php echo $apellido; ?>">
				<input type="hidden" name="cedula" id="cedula" value="<?php echo $cedula; ?>">
				<label for="direccion">Direccion</label>
				<input type="text" name="direccion" id="direccion" placeholder="Direccion"value="<?php echo $direccion; ?>">
				<label for="telefono">Telefono</label>
				<input type="text" name="telefono" id="telefono" placeholder="Telefono"value="<?php echo $telefono; ?>">
				<label for="correo">Correo electrónico</label>
				<input type="email" name="correo" id="correo" placeholder="Correo electrónico"value="<?php echo $correo; ?>">
				<label for="usuario">Usuario</label>
				<input type="text" name="usuario" id="usuario" placeholder="Usuario"value="<?php echo $user; ?>">
				<label for="clave">Clave</label>
				<input type="password" name="clave" id="clave" placeholder="Clave de acceso">

				<?php 
					include "../conexion.php";
					$query_rol = mysqli_query($conection,"SELECT * FROM rol");
					mysqli_close($conection);
					$result_rol = mysqli_num_rows($query_rol);

				 ?>

				<input type="submit" value="Actualizar usuario" class="btn_save">

			</form>


		</div>


	</section>
</body>
</html>