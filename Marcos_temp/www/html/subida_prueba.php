<?php

$file_size_max = 100000000;//Configurar el php.ini de apache (por defecto viene 2M creo)

if ($_FILES['archivo']["error"] > 0)
  {
  echo "Error: " . $_FILES['archivo']['error'] . "<br>";
  $message=2; 
  }
elseif($_FILES['archivo']['type'] != "video/mp4"){
	$message=1;
	echo "El archivo subido no es del tipo mp4, conviertalo antes.". $message . "<br>";
	}
elseif($_FILES['archivo']['size']>$file_size_max){
	$message=3;
	echo "El archivo es demasiado grande.". $message."<br>";
	}
else
  {
	$dir = 'media/';

	echo "Nombre temporal: " . $_FILES['archivo']['tmp_name'] . "<br>";

	if(move_uploaded_file($_FILES['archivo']['tmp_name'], $dir . $_FILES['archivo']['name'])){
	$message=0;
	header("Location:prueba.html");
	} 
	else{
	print_r(error_get_last());
	$message=4;
	}

	
   }
 ?>
