<!DOCTYPE html>
<html>
<head>
	<title>Libros</title>
	<link rel="stylesheet" media="screen" href="css/estilo.css" >
</head>
<body>
	<form class="formulario" method="post" action="libros_guardar_MySQLi.php" name="formulario">
		<ul>
		    <li>
		         <h2>INSERTE LOS DATOS DEL LIBRO</h2>
		         <span class="mensaje_obligatorio">* Campo obligatorio</span>
		    </li>
		    <li>
		        <label for="titulo">Titulo:*</label>
		        <input type="text" name="titulo" required>
		    </li>
		    <li>
		        <label for="anyo">Año de edición:*</label>
		        <input type="number" name="anyo" min="1900" max="2100" required>
		    </li>
		    <li>
		        <label for="precio">Precio:*</label>
		        <input type="number" name="precio" step="any" required>
		    </li>
		    <li>
		        <label for="adquisicion">Fecha de adquisición:*</label>
		        <input type="date" name="adquisicion" required>
		    </li>

		    <li>
		    	<button class="submit" type="submit" name="guardar">Guardar datos del libro</button>
		    </li>

		</ul>
	</form>
	
	<a href="libros_datos_MySQLi.php">Mostrar los libros guardados</a>
	</br>
	<a href="index.php">Volver</a>
</body>
</html>




