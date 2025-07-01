<?php
require_once __DIR__ . '/utils/manageAnimal.php';

$gestorAnimales = new ManageAnimal();
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
        <?php foreach ($animales as $animal): ?>
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
