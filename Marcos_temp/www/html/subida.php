<?php

$host_db = "localhost";
$user_db = "root";
$pass_db = "Multimedia";
$db_name = "trabajo_multi";
$tbl_name = "Videos";
$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);
if ($conexion->connect_error) {
    die("La conexion falló: " . $conexion->connect_error);
}

$file_size_max = 100000000;//Configurar el php.ini de apache (por defecto viene 2M creo)

if ($_FILES['vidfile']["error"] > 0)
  {
  echo "Error: " . $_FILES['vidfile']['error'] . "<br>";
  header("Location:../upform.php?state=2");//Error al subir el archivo
  }
elseif($_FILES['vidfile']['size']>$file_size_max){
	header("Location:../upform.php?state=1");//Fichero demasiado grande
	}
else
  {
	$dir = '../media/videos/';
	session_start();
	if(isset($_SESSION['username'])){
		if(move_uploaded_file($_FILES['vidfile']['tmp_name'], $dir . $_FILES['vidfile']['name'])){
			$buscarUsuario = "SELECT * from Usuarios where nombre = '$_SESSION[username]'";
			$result = $conexion->query($buscarUsuario);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$id_usuario = $row['id_usuario'];
			$titulo = $_POST['vidtitle'];
			$categoria = $_POST['category'];
			$video = $_FILES['vidfile']['name'];
			$fecha = date("Y-m-d");
			if(isset($_POST['viddesc'])){
				$descripcion = $_POST['viddesc'];
			}
			else{$descripcion = null;}
			if(isset($_POST['vidprivate'])){
				$privado = $_POST['vidprivate'];
			}
			else{$privado = null;}
			$insertar = "INSERT INTO Videos (id_usuario, titulo, categoria, descripcion, privado,fecha) VALUES ('$id_usuario', '$titulo', '$categoria','$descripcion','$privado','$fecha')";
			$a = $conexion->query($insertar);
			if( $a == TRUE){
				header("Location:../upform.php?state=0");//Éxito
				$buscarVideo = "SELECT * from Videos where titulo = '$titulo' AND categoria = '$categoria' AND id_usuario = '$id_usuario'";
				$result = $conexion->query($buscarVideo);
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$id_video = $row['id_video'];
				exec("sudo /bin/bash /var/www/html/gestion/script_1.sh '$video' '$id_video'");
			}
			else{
				header("Location:../upform.php?state=4");//Error al acceder a la base de datos
			}
		} 
		else{
			header("Location:../upform.php?state=3");//Error al subir el archivo
		}
	}
	else{
		header("Location:../upform.php?state=7");//Sesión no iniciada
	}
  }
 ?>

