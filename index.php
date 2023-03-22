<?php  	
session_start();
$alert = '';


if (!empty($_SESSION)) {
    header('location: system/');
}else{

if (!empty($_POST)) {
    if (empty($_POST['usuario']) || empty($_POST['clave'])) {
        $alert = "Inserte su Usuario y Contraseña";
    }else{
        require_once "conexion.php";

        $user = mysqli_real_escape_string($conection,$_POST['usuario']);
        $pass = md5(mysqli_real_escape_string($conection,$_POST['clave']));

        $query = mysqli_query($conection, "SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$pass'");
        mysqli_close($conection);
        $result = mysqli_num_rows($query);

        if ($result > 0 ) {
            $data = mysqli_fetch_array($query);

            $_SESSION['active'] = true;
            $_SESSION['idUser'] = $data['idusuario'];
            $_SESSION['nombre'] = $data['nombre'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['rol'] = $data['rol'];

            header('location: sistema/');
        }else{
            $alert = "El usuario o la clave son incorrectos";
            session_destroy();
        }
    }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Login | SISFINCO</title>
</head>
<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="" method="post">
                    <div class="inputbox">
                    <ion-icon name="person-circle-outline"></ion-icon>
                    <input type="text" name="usuario" autocomplete="off" placeholder="Usuario">
                    </div>
                    <br>
                    <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="clave" placeholder="Contraseña">
                    <br>
                    </div>
                    <div class="alert"><?php echo isset($alert)? $alert : ''; ?></div>
                    
                </form>
            </div>
        </div>
        <div><input type="submit" value="Ingresar" class="submit"></div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>