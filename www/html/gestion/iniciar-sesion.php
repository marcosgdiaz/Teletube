<?php
include 'config.php';
session_start();

$tbl_name = "Usuarios";


$username = $_POST['username'];
$password = $_POST['password'];


$sql = "SELECT * FROM $tbl_name WHERE nombre = '$username'";

$result = $conexion->query($sql);


if ($result->num_rows > 0) {     
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if (password_verify($password, $row['password'])) { 
        
        $_SESSION['id'] = $row['id_usuario'];
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);

        header("Location: ../index.php");
        /*echo "Bienvenido! " . $_SESSION['username'];*/
    }	
    header("Location: ../login.php?state=err1");
} else { 
    header("Location: ../login.php?state=err1");
}
mysqli_close($conexion); 
?>
