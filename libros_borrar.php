<?php 
include_once 'funcionesBaseDatos.php';
if(isset($_POST['borrar']))
{
	$mensaje = borrarLibro($_POST['libro']);
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Borrar libros</title>
	<link rel="stylesheet" media="screen" href="css/estilo.css" >
</head>
<body>

	<form class="formulario" action="" method="post" name="formulario">
    <ul>
        <li>
            <label for="libro">Libro:</label>
        	<select name="libro">
        		<?php
        		
	            $libros = getLibros();

	            foreach($libros as $libro)
				{
					echo "<option value='{$libro->numero_ejemplar}'";
	                echo ">{$libro->titulo} (año {$libro->anyo_edicion})</option>";
				}
	            	
            ?>
        	</select>
        </li>

        <li>
            <button class="submit" type="submit" name="borrar">Borrar</button>
        </li>
    </ul>

    <?php 
    	if(isset($mensaje))
    	{
    		echo "<div class='aviso'>El precio del libro borrado era $mensaje €</div>";
    	}
    ?>

</form>

<br>
<a href="libros.php">Volver</a>
</body>
</html>