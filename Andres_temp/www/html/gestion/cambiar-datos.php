<?php 
include 'config.php';

$file_size_max = 100000000;//Configurar el php.ini de apache (por defecto viene 2M creo)
session_start();
if(isset($_SESSION['username'])){
	$buscarUsuario = "SELECT * from Usuarios where nombre = '$_SESSION[username]'";
	$result = $conexion->query($buscarUsuario);
	if ($result == FALSE) {
		mysqli_close($conexion); 
    	header("Location: ../ajustes.php?state=4");//Error en la consulta
    	exit();
    }
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$id_usuario = $row['id_usuario'];
	if (password_verify($_POST['pw'], $row['password'])) { 
		if (isset($_FILES["imgfile"]["name"])) {

	        $name = $_FILES["imgfile"]["name"];
	    	$tmp_name = $_FILES['imgfile']['tmp_name'];
	    	$error = $_FILES['imgfile']['error'];

	    	if (!empty($name)) {
				if ($error > 0){
				  //echo "Error: " . $_FILES['vidfile']['error'] . "<br>";  //Para debug, pero no es plan enseñar errores al usuario
				  header("Location:../ajustes.php?state=2");//Error al subir el archivo
				  exit();
				}
				elseif($_FILES['imgfile']['size']>$file_size_max){
					header("Location:../ajustes.php?state=1");//Fichero demasiado grande
					exit();
				}
				else{
					$dir = '../media/perfil/';
						if(move_uploaded_file($tmp_name, $dir . $name)){
							$a = strval($id_usuario).".jpg";
							$update = "UPDATE Usuarios SET foto='$a' WHERE id_usuario='$id_usuario'";
							$result = $conexion->query($update);
							if ($result == FALSE) {
					        	header("Location: ../ajustes.php?state=4");//Error en la consulta
					        	exit();
					        }
					        exec("/bin/bash /var/www/script_2.sh '$name' '$id_usuario'");
					    }
						else{
							mysqli_close($conexion); 
						    header("Location:../ajustes.php?state=3");//Error en la subida de la foto
							exit();
						}
				}
			}
		}
		if(isset($_POST['profdesc'])){
			if(!empty($_POST['profdesc'])){
				$update = "UPDATE Usuarios SET descripcion='$_POST[profdesc]' WHERE id_usuario='$id_usuario'";
				$result = $conexion->query($update);
				if ($result == FALSE) {
					mysqli_close($conexion); 
		        	header("Location: ../ajustes.php?state=4");//Error en la consulta
		        	exit();
		        }
			}
		}
		if(isset($_POST['newpw'])){	
			if(!empty($_POST['newpw'])){
				$form_pass = $_POST['newpw'];
				$hash = password_hash($form_pass, PASSWORD_BCRYPT);
				$update =  "UPDATE Usuarios SET password='$hash' WHERE id_usuario='$id_usuario'";
				$result = $conexion->query($update);
				if ($result == FALSE) {
					mysqli_close($conexion); 
		        	header("Location: ../ajustes.php?state=4");//Error en la consulta
		        	exit();
		        }
			}
		}
	}
	else{
		mysqli_close($conexion); 
		header("Location: ../ajustes.php?state=5");//Contraseña Incorrecta
		exit();
	}
	mysqli_close($conexion); 
	header("Location: ../ajustes.php?state=0");//Exito
}
?>

