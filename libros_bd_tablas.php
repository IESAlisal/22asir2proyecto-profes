<html>
    <head>
        <title>Creación de tablas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body{
                text-align:center;
            }
            #menu{
                display:inline-block;
                text-align:left;
            }
            #menu li{
                margin-top:2em;
            }
        </style>
    </head>
    <body>
    
        <h1>Bienvenido a la aplicacion de libros</h1>
       
	   <?php 
	   ini_set("display_errors",true);
	   include_once 'funcionesBaseDatos.php';
	   
	   $basedatos=DATABASE;
	   $bbdd=crearBBDD($basedatos);
	   
	   if($bbdd ==0){
	       if(crearTablas($basedatos)==1){;
	       header("Location: login.php");
	       }}
	       else if ($bbdd ==1){
	           header("Location: login.php");
	       }
	  
	   ?>
    </body>
</html>
