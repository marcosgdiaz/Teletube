<?php

include 'config.php';

$form_pass = $_POST['password'];
$tbl_name = "Usuarios";

$hash = password_hash($form_pass, PASSWORD_BCRYPT); 


$buscarUsuario = "SELECT * FROM $tbl_name
 WHERE nombre = '$_POST[username]' OR email='$_POST[email]' LIMIT 1";

$result = $conexion->query($buscarUsuario);

$count = mysqli_num_rows($result);

if ($count >= 1) {
    header("Location: ../login.php?state=err2");
}
else{
    $fecha=date("Y-m-d");
    $descripcion = null;
    $foto = null;		
    $query = "INSERT INTO Usuarios (nombre, email, password,fecha,descripcion,foto) VALUES ('$_POST[username]' , '$_POST[email]' , '$hash','$fecha', '$descripcion', '$foto' )";
    ;

    if ($conexion->query($query) === TRUE) {
        header("Location: ../login.php?state=success");
    }

    else {
        header("Location: ../login.php?state=err3");
        // echo "Error al crear el usuario." . $query . "<br>" . $conexion->error; 
    }
}
mysqli_close($conexion); 
?>
