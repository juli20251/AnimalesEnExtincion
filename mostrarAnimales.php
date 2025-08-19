<?php
// Importamos la clase que gestiona los animales
require_once __DIR__ . '/utils/manageAnimal.php';

// Creamos un objeto para manejar los animales
$gestorAnimales = new ManageAnimal();

// Obtenemos la lista de animales
$animales = $gestorAnimales->getAnimales();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Animales</title>
</head>
<body>
    <h1>Animales Registrados</h1>

    <ul>
        <?php 
        // Recorremos todos los animales y los mostramos en pantalla
        foreach ($animales as $animal): ?>
            <li>
                <strong>Nombre:</strong> <?= htmlspecialchars($animal->getNombre()) ?><br>
                <strong>Edad:</strong> <?= $animal->getEdad() ?> años<br>
                <strong>Sexo:</strong> <?= $animal->getSexo() ?><br>
                <strong>Especie:</strong> <?= htmlspecialchars($animal->getEspecie()->getNombre()) ?><br>
                <hr>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
