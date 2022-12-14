<?php
include_once 'funcionesBaseDatos.php';

// Comprobamos si tenemos que reservar
if (isset($_POST['registrar']))
{
    // Preparamos la consulta
    $nombre  =  $_POST['nombre'];
    $password     = $_POST['password'];
    $password2 = $_POST['password2'];
    
    if($password==$password2)
    {
      try
      {
        if(registrarUsuarioMySQLi($nombre, $password))
        {
            $mensaje = "Se ha registrado el usuario $nombre";
            session_start();
            $_SESSION['usuario'] = $nombre;
            header("Location: index.php");
        }
          
      }catch(Exception $e)
      {
        $error = "El usuario $nombre ya está registrado<br/>{$e->getMessage()}";
      }
        
    }
    else
        $error = "Las contraseñas no coinciden";
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registro</title>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/estilos.css">

  </head>

  <body class="text-center">
    <?php if(isset($mensaje)) echo "<div class='aviso-linea'>$mensaje</div>"; ?>
    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
    
    <form class="form-signin" action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' method='post'>
      <h1 class="h3 mb-3 font-weight-normal">Registro de usuarios</h1>
      <label for="inputEmail" class="sr-only">Nombre</label>
      <input type="text" name="nombre" class="form-control" placeholder="Nombre" required autofocus>
      <label for="inputPassword" class="sr-only">Contraseña</label>
      <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
      <label for="inputPassword" class="sr-only">Repita la contraseña</label>
      <input type="password" name="password2" class="form-control" placeholder="Repita la contraseña" required>
      
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="registrar">Registrar</button>
      <p class="mt-5 mb-3 text-muted">&copy; I.E.S. Alisal</p>
    </form>
    <br>
	<a href="login.php">Volver</a>
    
  </body>
</html>
