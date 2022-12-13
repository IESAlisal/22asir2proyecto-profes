<!DOCTYPE html>
<html>
<head>
	<title>Guardar libros</title>
	<link rel="stylesheet" media="screen" href="css/estilo.css" >
</head>
<body>


<?php
include_once 'funcionesBaseDatos.php';


function estaVacio($campo, $valor)
{
	$vacio = false;
	if ($valor == "")
    {
        echo("<div class='error'>Falta el campo $campo</div>");
        $vacio = true;
    }
    return $vacio;
}


$todoOK = true;
if (isset($_POST['titulo']))
{

    $titulo = $_POST['titulo'];
    if(!estaVacio("título", $titulo))
    	echo "El título es $titulo <br/>";
    else
    	$todoOK = false;
}

if (isset($_POST['anyo']))
{
    $anyo = $_POST['anyo'];
    if(!estaVacio("año", $anyo))
    	echo "El año es $anyo <br/>";
    else
    	$todoOK = false;
}

if (isset($_POST['precio']))
{
    $precio = $_POST['precio'];
    if(!estaVacio("precio", $precio))
    	echo "El precio es $precio <br/>";
    else
    	$todoOK = false;
}


if (isset($_POST['adquisicion']))
{
	$adquisicion = $_POST['adquisicion'];
    if(!estaVacio("fecha de adquisición", $adquisicion))
    {
    	list($year, $mon, $day) = explode('-', $adquisicion);

        if (checkdate($mon, $day, $year))
            echo "La fecha de adquisición es $adquisicion <br/>";
        else
        {
            echo "<div class='error'>Fecha incorrecta<br></div>";
            $todoOK = false;
        }
    }
    else
    	$todoOK = false;

}

if ($todoOK)
{
	if(insertarLibro($titulo, $anyo, $precio, $adquisicion))
		echo "<div class='aviso'>Datos guardados correctamente</div>";
	else
		echo "<div class='error'>No se ha podido insertar</div>";
}


?>
<br>
<a href="libros.php">Volver</a>
</body>
</html>

