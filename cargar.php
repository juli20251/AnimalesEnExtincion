<?php
require_once 'Class/Cuidador.php';
require_once 'Class/Presentaciones.php';
require_once 'Class/Animal.php';
require_once 'Class/Area.php';
require_once 'Class/Especies.php';

//Area
$Bosque = new Area(1, "Bosque");
$Tropical = new Area(2, "Tropical");
$areas = [$Bosque, $Tropical];

//Especie
$Marzopial = new Especies(1, $Tropical, "Marzopial", 10, 5);
$Felino = new Especies(2, $Bosque, "Felino", 9, 12);
$especie = [$Marzopial, $Felino];

//Animales
$PandaGigante = new Animal(1, $Marzopial, "PandaGigante", 8, "Macho");
$Piton = new Animal (2, $Felino, "Serpiente", 3, "Hembra");
$animales = [$PandaGigante, $Piton];

//CUIDADOR
$Avalos = new Cuidador(1, "Pablo", 123456789, "pablo@mail.com", $Bosque);
$Rodriguez = new Cuidador(2, "Bautista", 987654321, "bautista@mail.com", $Tropical);

$Cuidadores = [$Avalos, $Rodriguez];

$Bosque->SetCuidador($Avalos);
$Tropical->SetCuidador($Rodriguez);


//PRESENTACIONES
$Tecnopolis = new Presentaciones(1, $Bosque, $Avalos, "al publico", 120);
$Cordoba = new Presentaciones(2, $Tropical, $Rodriguez, "VIP", 60);
?>