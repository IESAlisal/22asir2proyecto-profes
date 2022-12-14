<?php
include_once 'funcionesBaseDatos.php';

// Comprobamos si ya se ha enviado el formulario
if (isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    if (empty($usuario) || empty($password))
        $error = "Debes introducir un nombre de usuario y una contraseña";
    else 
    {
        include_once 'funcionesBaseDatos.php';
        // Comprobamos las credenciales con la base de datos
        if(usuarioCorrecto($usuario, $password))
        {
            session_start();
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php");
        }
        else
        {
            // Si las credenciales no son válidas, se vuelven a pedir
            $error = "¡Usuario o contraseña no válidos!";
        }
    }
}
?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/estilos.css">

  </head>

  <body class="text-center">
    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
    
    <form class="form-signin" action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' method='post'>
      <h1 class="h3 mb-3 font-weight-normal">Login de usuarios</h1>
      <label for="usuario" class="sr-only">Usuario</label>
      <input type="text" name="usuario" class="form-control" placeholder="Usuario" required autofocus>
      <label for="password" class="sr-only">Contraseña</label>
      <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
      
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
      <p class="mt-5 mb-3 text-muted">&copy; I.E.S. Alisal</p>
    </form>

    <p>¿Aún no tienes cuenta?</p>
    <a class="btn btn-primary" href="registro.php">Registrarse</a>
    
  </body>
</html>
