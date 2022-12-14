<?php

include_once 'constantes.php';

function getConexionPDO()
{
	$opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
	try
	{
	    $dwes = new PDO('mysql:host='.HOST.';dbname='.DATABASE, USERNAME, PASSWORD, $opciones);
	    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    return $dwes;
	}
	catch(Exception $ex)
	{
	    echo "<h4>{$ex->getMessage()}</h4>";
	    return null;
	}
}



function getConexionMySQLi()
{
    $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
    $mysqli->set_charset("utf8");
    $error  = $mysqli->connect_errno;

    if ($error != null)
    {
        echo "<p>Error $error conectando a la base de datos: $mysqli->connect_error</p>";
        exit();
    }
    return $mysqli;
}
function getConexionMySQLi_sin_bbdd()
{
    $mysqli = new mysqli(HOST, USERNAME, PASSWORD);
    $mysqli->set_charset("utf8");
    $error  = $mysqli->connect_errno;
    
    if ($error != null)
    {
        echo "<p>Error $error conectando a la base de datos: $mysqli->connect_error</p>";
        exit();
    }
    return $mysqli;
}


function crearBBDD($basedatos){
    $conexion = getConexionMySQLi_sin_bbdd();
    $sql="select schema_name from information_schema.schemata where schema_name='$basedatos'";
    $stm=$conexion->prepare($sql);
    $stm->execute();
    
    $stm->bind_result($nombre_db);
    $existe=$stm->fetch();
    $stm->close();
   // $existe=0;
    if(!$existe){
        //crear la base de datos
        if ($conexion->query("CREATE DATABASE $basedatos") === true) { //ejecutando query
            
            echo "Base de datos $basedatos creada en MySQL por Objetos ";
            echo "<br>";
            
            
        } else {
            
            echo "Error al ejecutar consulta " . $this->conexion->error . " ";
             $existe=1;  
        }
        print_r ("Estoy aqui0");
        
    }
    $conexion->close();
    return $existe;
   
    
}

function crearTablas($basedatos){
    ini_set("display_errors",true);
    $conexion = getConexionMySQLi_sin_bbdd();
    $conexion->select_db($basedatos); 
    //$conexion = getConexionMySQLi();
    //print_r ("Estoy aqui0.1");
    $existe_l=0;
    $libros2="
        CREATE TABLE libros (
        titulo varchar(50) NOT NULL,
        anyo_edicion int(11) NOT NULL,
        precio float(10,2) NOT NULL,
        fecha_adquisicion date NOT NULL,
        numero_ejemplar int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY 
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";
    
    // Pasamos la variable $strInsert para ejecurar el query
    //print_r ("Estoy aqui1");
    if ($conexion->query($libros2) === true) { //ejecutando query para la creación de una tabla en MySQL
        
        echo "Tabla libros creada en MYSQL";
        echo "<br>";
        $existe_l=1;
        
    } else {
        
        echo "Error al crear tabla libros2 en MySQL " . $conexion->error . " ";
    }
   
    $existe_lg=0;
    $logins2="
        CREATE TABLE logins (
        usuario varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL PRIMARY KEY,
        passwd char(32) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL 
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    
    if ($conexion->query($logins2) === true) { //ejecutando query para la creación de una tabla en MySQL
        
        echo "Tabla logins creada en MYSQL";
        echo "<br>";
        $existe_lg=1;
        
    } else {
        
        echo "Error al crear tabla logins2 en MySQL " . $conexion->error . " ";
    }
    
    $conexion->close();
    if (($existe_l==1) && ($existe_lg==1)) return 1;
    
}


function usuarioCorrecto($usuario, $password)
{
    $conexion = getConexionMySQLi();
    
    $r=false;
    $sql="select usuario from logins where usuario=? and passwd=?";
    $stm=$conexion->prepare($sql);
    $p=md5($password);
    $stm->bind_param("ss",$usuario,$p);
    $stm->execute();
    $stm->bind_result($u);
    if($stm->fetch()){
        $r=true;
    }
    $stm->close();
    return $r;
}



function registrarUsuarioMySQLi($usuario, $password)
{
    $correcto = false;
    
    $conexion  = getConexionMySQLi();
    //$password = md5($password); //Se puede encriptar mediante php o mediante MySQL
    $sql      = "INSERT INTO logins (usuario,passwd) VALUES (?,md5(?))";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("ss",$usuario,$password);
    
    $consulta->execute();
    $consulta->close();
    $conexion->close();
   
        
        
        
        
}

function insertarLibroMySQLi($titulo, $anyo, $precio, $fechaAdquisicion)
{
    $conexion  = getConexionMySQLi();
    
    $conexion->autocommit(false);
   
    $consultaInsert = $conexion->stmt_init();
    $sqlInsert      = "insert into libros (titulo, anyo_edicion, precio, fecha_adquisicion)  values(?,?,?,?)";
    $consultaInsert->prepare($sqlInsert);
    $consultaInsert->bind_param('sids', $titulo, $anyo, $precio, $fechaAdquisicion); //int, int, string
    $consultaInsert->execute();
    $filasAfectadasInsert = $consultaInsert->affected_rows;
    $consultaInsert->close();
    
    if ($filasAfectadasInsert == 1)
    {
        $conexion->commit();
        return true;
    }
    else
    {
        $conexion->rollback();
        return false;
    }
}


function insertarLibro($titulo, $anyo, $precio, $fechaAdquisicion)
{
    $conexion = getConexionPDO();
    $sql = "INSERT into libros (titulo, anyo_edicion, precio, fecha_adquisicion) values (?,?,?,?)";
    $sentencia = $conexion->prepare($sql);
    
    $sentencia->bindParam(1, $titulo);
    $sentencia->bindParam(2, $anyo);
    $sentencia->bindParam(3, $precio);
    $sentencia->bindParam(4, $fechaAdquisicion);
    $numero = $sentencia->execute();
    unset($sentencia);
    
    unset($conexion);
    
    if($numero==1)
        return true;
        return false;
}




function getLibros()
{
	$conexion = getConexionMySQLi();
    $consulta = "select * from libros";
    $libros=[];
    if ($resultado = $conexion->query($consulta))
    {
        while ($libro = $resultado->fetch_object())
        {
            $libros[] = $libro;
        }
        $resultado->close();
    } 
    $conexion->close();
    return $libros;
}


function getLibrosTitulo()
{
    /*La tabla libros compuesta por los campos:
     * titulo, ciudad, conferencia y división
     * */
    $mysqli = getConexionMySQLi();
    $consulta = "select titulo from libros";
    
    if ($resultado = $mysqli->query($consulta))
    {
        
        /* obtener el array de objetos */
        while ($libro = $resultado->fetch_object())
        {
            $libros[] = $libro->titulo;
        }
        
        /* liberar el conjunto de resultados */
        $resultado->close();
    }
    $mysqli->close();
    echo $libros;
    return $libros;
    
}




function borrarLibro($numeroEjemplar)
{
    $conexion = getConexionPDO();
    $precio = 0;

    $consulta = "select precio from libros WHERE numero_ejemplar = $numeroEjemplar";
    if ($resultado = $conexion->query($consulta))
    {
        if ($libro = $resultado->fetch())
        {
            $precio = $libro['precio'];
        }
       unset($resultado);
    } 



    $sql = "DELETE FROM libros WHERE numero_ejemplar = ?";
    $sentencia = $conexion->prepare($sql);

    $sentencia->bindParam(1, $numeroEjemplar);
    
    //$numero = $sentencia->execute();
    unset($sentencia);

    unset($conexion);

    return $precio;
}

function borrarLibroMySQLi($numeroEjemplar)
{
    
    //if($numeroEjemplar===null || !isnumeric($numeroEjemplar)){
      //  return 0;
    //}
    
    $conexion = getConexionMySQLi();
    $precio = 0;
    
    $todo_bien = true;            // Definimos una variable para comprobar la ejecuciÃ³n
    $conexion->autocommit(false); // Deshabilitamos el modo transaccional automÃ¡tico
    
    
    $consulta = "select precio from libros WHERE numero_ejemplar = $numeroEjemplar";
    
    $resultado = $conexion->query($consulta);
    if ($resultado)
    {
        if ($libro = $resultado->fetch_array())
        {
            $precio = $libro['precio'];
        }
        $resultado->close();
    }
    
  

    
    $consultaDelete = $conexion->stmt_init();
    $sql = "DELETE FROM libros WHERE numero_ejemplar =  $numeroEjemplar";
   
    
    $consultaDelete->prepare($sql);
    
    if (!$consultaDelete->execute())
    {
        $todo_bien = false;
    }
    $consultaDelete->close();
    
    // Si todo fue bien, confirmamos los cambios y en caso contrario los deshacemos
    if ($todo_bien == true)
    {
        $conexion->commit();
    }
    else
    {
        $conexion->rollback();
    }
    
    $conexion->close();
    return $precio;
    
    
        
    
}

function modificarLibroMySQLi($numero_ejemplar,$precio)
{
    $conexion  = getConexionMySQLi();
    
    $conexion->autocommit(false);
    
    
    
    $consultaInsert = $conexion->stmt_init();
    $sqlInsert      = "update libros set precio=? where numero_ejemplar=?";
    $consultaInsert->prepare($sqlInsert);
    
    
    //for($i=0;$i<count($numero_ejemplar);$i++)
    //{
        echo "$numero_ejemplar[0]";
        echo "$precio[0]";
        //$consultaInsert->bind_param("ds", $precio[$i], $numero_ejemplar[$i]);
        $consultaInsert->bind_param("di", $precio[0], $numero_ejemplar[0]);
        $consultaInsert->execute();
       // print_r($conexion);
        
        $filasAfectadasInsert = $consultaInsert->affected_rows;
        
  
    
    
    
       $consultaInsert->close();
      
    
    if ($filasAfectadasInsert == 1)
    {
        $conexion->commit();
        return true;
    }
    else
    {
        $conexion->rollback();
        return false;
    }
}

function getLibrosPrecio($libro)
{
    /*La tabla jugadores, está compuesta po los campos:
     * codigo, titulo, procedencia, altura, peso, posición, titulo_equipo
     * */
    $mysqli = getConexionMySQLi();
    $consulta = "select numero_ejemplar, titulo, precio from libros where titulo = '$libro'";
    
    if ($resultado = $mysqli->query($consulta))
    {
        
        while ($libro = $resultado->fetch_array())
        {
            $libros[] = array("numero_ejemplar" => $libro["numero_ejemplar"], "titulo" => $libro["titulo"], "precio" => $libro["precio"]);
        }
        
        $resultado->close();
    }
    $mysqli->close();
    return $libros;
}





?>
