<?php 
	session_start();
	if(isset($_SESSION['usuario'])){
		
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>inicio</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php require_once "menu.php"; ?>
	<link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="galeria">
        <h1>Nuevo San Ramón </h1>
        <div class="linea"></div>
        <div class="contenedor-imagenes">
            <div class="imagen">
                <img src="../img/1.png" alt="logo del Fraccionamiento">
                <div class="overlay">
                    <h2>Fraccionamiento</h2>
                </div>
            </div>
            <div class="imagen">
                <img src="../img/2.png" alt="Distancia a Tacotalpa">
                <div class="overlay">
                    <h2>Distancia a Tacotalpa</h2>
                </div>
            </div>
            <div class="imagen">
                <img src="../img/3.png" alt="Mapa de distancia">
                <div class="overlay">
                    <h2>A 6 km de Tacotalpa</h2>
                </div>
            </div>
            <div class="imagen">
                <img src="../img/4.png" alt="Planta Arquitectonica">
                <div class="overlay">
                    <h2>Planta Arquitectonica</h2>
                </div>
            </div>
            <div class="imagen">
                <img src="../img/5.png" alt="Areas">
                <div class="overlay">
                    <h2>Areas</h2>
                </div>
            </div>
            <div class="imagen">
                <img src="../img/6.png" alt="Areas">
                <div class="overlay">
                    <h2>Areas</h2>
                </div>
            </div>
            <div class="imagen">
                <img src="../img/7.png" alt="Areas Comerciales">
                <div class="overlay">
                    <h2>Areas Comerciales</h2>
                </div>
            </div>
            <div class="imagen">
                <img src="../img/8.png" alt="Areas Donacion">
                <div class="overlay">
                    <h2>Areas Donacion</h2>
                </div>
            </div>
            <div class="imagen">
                <img src="../img/9.png" alt="Acceso Principal">
                <div class="overlay">
                    <h2>Acceso Principal</h2>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<?php 
	}else{
		header("location:../index.php");
	}
 ?>