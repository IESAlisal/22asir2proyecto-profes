<!DOCTYPE html>
<html>
<head>
	<title>Ejercicio 8</title>
	<link rel="stylesheet" media="screen" href="css/estilo.css" >
</head>
<body>

	<?php
	   ini_set("display_errors",true);
		require_once 'funcionesBaseDatos.php';
		if(isset($_POST["actualizar"]))
		{
		    //echo "Actualizando...";
		    $librosprecios = $_POST["librosprecios"];
			$precio = $_POST["precio"];
			//echo "----------------------",
			//print_r($precio);
			//echo "----------------------------";
			modificarLibroMySQLi($librosprecios, $precio);
			echo "<div class='aviso'>Actualizados los precios</div>";
		}
		else{
		   // echo "NO recibo campo ' actualizar'";
		}
	?>

	<form class="formulario" action="" method="post" name="formulario">
	    <ul>
		    <li>
		         <h2>Libros que se van a actualizar</h2>
		         <span class="mensaje_obligatorio">* Campo obligatorio</span>
		    </li>

		    <li>
		        <label for="libro">Libros:*</label>
		        <select name="libro">
		            <?php
						$libros = getLibrosTitulo();
						foreach ($libros as $libro) 
						{
						    echo "<option value='$libro'";
						    //Si se ha recibido el equipo y coincide con el que estamos mostrando
						    //ponemos selected a true
						    if (isset($_POST['libro']) && $libro == $_POST['libro'])
                        	    echo " selected='true'";

						    echo ">$libro</option>";
						}
		    		?>
		        </select>
		    </li>

		    <li>
		        <button class="submit" type="submit" name="mostrar">Mostrar</button>
		    </li>
		</ul>
	</form>

	
		<?php
			// Comprobamos si tenemos que mostrar los jugadores
		    if (isset($_POST['mostrar'])) 
		    {
		?>
		<form id="actualizarPrecio" method="post" action="">
		<table class="tabla">
		<thead>
			<tr>
				<th>Titulo</th>
				<th>Peso</th>
			</tr>
		</thead>
		<tbody>
			<?php
		        
		        $libro = $_POST['libro'];
		        $librosprecios = getLibrosPrecio($libro);
		        foreach ($librosprecios as $libroprecio) 
		        {
		        	echo "<input type='hidden' name='libro' value='{$_POST['libro']}'>"; //Para que se mantenga al recargar la página
		        	echo "<tr>"."<input type='hidden' name='librosprecios[]' value='{$libroprecio['numero_ejemplar']}'>";
		        	echo "<td>".$libroprecio["titulo"]."</td>";
		        	echo "<td><input type='text' size='4' name='precio[]' value='{$libroprecio['precio']}'> Euros </td></tr>";
		        }
			?>
		</tbody>
	</table>
		<button class="submit actualizar" type="submit" name="actualizar">Actualizar</button>
	</form>
	
		<?php
		    }
		?>		
		<br>
	<a href="index.php">Volver</a>
	
</body>
</html>