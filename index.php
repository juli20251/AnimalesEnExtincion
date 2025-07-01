<?php
require_once 'cargar.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Presentaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f0f0f0;
        }
        .show {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        h2 {
            margin-top: 0;
            color: #2c3e50;
        }
        .section-title {
            color: #34495e;
            margin-bottom: 8px;
            text-decoration: underline;
            font-weight: bold;
        }
        ul {
            padding-left: 20px;
        }
        .disponible {
            color: green;
        }
        .no-disponible {
            color: gray;
        }
    </style>
</head>
<body>

<h1>Presentaciones de Animales</h1>

<form method="get">
    <label for="buscar">Buscar animal:</label>
    <input type="text" name="buscar" id="buscar" placeholder="Ej: Piton" value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>">
    <button type="submit">Buscar</button>
</form>
<hr>

<?php
$busqueda = isset($_GET['buscar']) ? strtolower(trim($_GET['buscar'])) : '';

$presentaciones = [$Tecnopolis, $Cordoba];

foreach ($presentaciones as $presentacion):
    $area = $presentacion->getId_area();
    $cuidador = $presentacion->getCuidador();

    $animalesFiltrados = [];
    foreach ($animales as $animal) {
        if ($animal->getEspecie()->getArea()->GetTipoHabitat() === $area->GetTipoHabitat()) {
            if ($busqueda === '' || strpos(strtolower($animal->getNombre()), $busqueda) !== false) {
                $animalesFiltrados[] = $animal;
            }
        }
    }

    if (empty($animalesFiltrados)) continue;
?>

<div class="show">
    <h2><?php echo htmlspecialchars($presentacion->getTipo()); ?></h2>
    <p><strong>Duración:</strong> <?php echo $presentacion->getDuracion(); ?> minutos</p>

    <div class="section-title">Área</div>
    <p><strong>Tipo de hábitat:</strong> <?php echo htmlspecialchars($area->GetTipoHabitat()); ?></p>

    <div class="section-title">Cuidador</div>
    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($cuidador->getNombre()); ?></p>

    <div class="section-title">Animales en esta área</div>
    <?php foreach ($animalesFiltrados as $animal): ?>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($animal->getNombre()); ?></p>
        <p><strong>Sexo:</strong> <?php echo htmlspecialchars($animal->getSexo()); ?></p>
        <p><strong>Edad:</strong> <?php echo htmlspecialchars($animal->getEdad()); ?> años</p>
        <p><strong>Especie:</strong> <?php echo htmlspecialchars($animal->getEspecie()->getNombre()); ?></p>
        <p><strong>Área:</strong> <?php echo htmlspecialchars($animal->getEspecie()->getArea()->GetTipoHabitat()); ?></p>
        <hr>
    <?php endforeach; ?>
</div>

<?php endforeach; ?>

</body>
</html>
