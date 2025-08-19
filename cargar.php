<?php
require_once 'Class/Cuidador.php';
require_once 'Class/Presentaciones.php';
require_once 'Class/Animal.php';
require_once 'Class/Area.php';
require_once 'Class/Especies.php';

// Crear Áreas
$Bosque = new Area(1, "Bosque");
$Tropical = new Area(2, "Tropical");
$areas = [$Bosque, $Tropical];

// Crear Especies
$Marzopial = new Especies(1, $Tropical, "Marzopial", 10, 5);
$Felino = new Especies(2, $Bosque, "Felino", 9, 12);
$especies = [$Marzopial, $Felino];

// Crear Animales
$PandaGigante = new Animal(1, $Marzopial, "PandaGigante", 8, "Macho");
$Piton = new Animal(2, $Felino, "Serpiente", 3, "Hembra");
$animales = [$PandaGigante, $Piton];

// Crear Cuidadores
$Avalos = new Cuidador(1, $Bosque, "Pablo", 123456789, "pablo@mail.com");
$Rodriguez = new Cuidador(2, $Tropical, "Bautista", 987654321, "bautista@mail.com");

$cuidadores = [$Avalos, $Rodriguez];

// Asignar cuidadores a áreas
$Bosque->setCuidador($Avalos);
$Tropical->setCuidador($Rodriguez);

// Crear Presentaciones
$Tecnopolis = new Presentaciones(1, $Bosque, $Avalos, "al publico", 120);
$Cordoba = new Presentaciones(2, $Tropical, $Rodriguez, "VIP", 60);
?>
