<?php 

    // Variable para mostrar mensajes de error o alerta
	$alert = '';
	
    // Inicia una nueva sesión o reanuda una sesión existente
	session_start();

    // Si ya existe una sesión activa, redirige al usuario al sistema
	if(!empty($_SESSION['active']))
	{
		header('location: sistema/'); // Redirección a la carpeta del sistema
	}else{

        // Verifica si el formulario fue enviado
		if(!empty($_POST))
		{
            // Si los campos usuario o clave están vacíos, muestra una alerta
			if(empty($_POST['usuario']) || empty($_POST['clave']))
			{
				$alert = 'Ingrese su usuario y contraseña';
			}else{

                // Incluye el archivo para conectar a la base de datos
				require_once "conexion.php";

                // Protege los datos ingresados por el usuario contra inyección SQL
				$user = mysqli_real_escape_string($conection,$_POST['usuario']);
				$pass = md5(mysqli_real_escape_string($conection,$_POST['clave'])); // Encripta la clave con MD5

                // Consulta SQL para verificar si el usuario y la contraseña son correctos
				$query = mysqli_query($conection,"SELECT u.idusuario,u.nombre,u.correo,u.usuario,r.idrol,r.rol 
													FROM usuario u 
													INNER JOIN rol r
													ON u.rol = r.idrol
													WHERE usuario= '$user' AND clave= '$pass'");
				
                // Cierra la conexión con la base de datos para liberar recursos
				mysqli_close($conection);

                // Cuenta el número de filas devueltas por la consulta
				$result = mysqli_num_rows($query);

                // Si hay al menos un registro coincidente, se autentica al usuario
				if($result > 0)
				{
                    // Extrae los datos del usuario autenticado
					$data = mysqli_fetch_array($query);
                    
                    // Inicia la sesión y almacena los datos del usuario en variables de sesión
					$_SESSION['active'] = true;
					$_SESSION['idUser'] = $data['idusuario'];
					$_SESSION['nombre'] = $data['nombre'];
					$_SESSION['email']  = $data['correo'];
					$_SESSION['user']   = $data['usuario'];
					$_SESSION['rol']    = $data['idrol'];
					$_SESSION['rol_name'] = $data['rol'];

                    // Redirige al sistema después de un inicio de sesión exitoso
					header('location: sistema/');
				}else{
                    // Si el usuario o la contraseña son incorrectos, muestra un mensaje de error
					$alert = 'El Usuario o contraseña son incorrectos';
                    
                    // Destruye cualquier sesión activa para mayor seguridad
					session_destroy();
				}
			}
		}	
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Login | Sistema de ventas </title>
	<!-- Archivo CSS para los estilos del formulario -->
	<link rel="stylesheet" type="text/css" href="css/style.css?1.0" media="all">
</head>
<body>

	<!-- Contenedor principal del formulario de inicio de sesión -->
	<section id="container">
		
		<!-- Formulario de inicio de sesión -->
		<form action="" method="post">

			<h3>Iniciar Sesión</h3>
			
			<!-- Imagen decorativa del formulario -->
			<img src="img/1.png" alt="Login">

            <!-- Campo para el nombre de usuario -->
			<input type="text" name="usuario" placeholder="Usuario">
			
            <!-- Campo para la contraseña -->
			<input type="password" name="clave" placeholder="Contraseña">
			
            <!-- Muestra mensajes de alerta dinámicamente -->
			<div class="alert"><?php echo isset($alert)? $alert : ''; ?></div>
			
            <!-- Botón para enviar el formulario -->
			<input type="submit" value="INGRESAR">
			
		</form>

	</section>
</body>
</html>
