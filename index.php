<?php
/**
 * Zoológico Digital - Portal Principal
 * Sistema de Gestión Integral de Fauna - Interfaz de Usuario
 * 
 * Este archivo genera la página principal del zoológico digital,
 * mostrando información sobre animales, especies, áreas, cuidadores
 * y presentaciones obtenida desde la base de datos.
 * 
 * @author Sistema Zoológico Digital
 * @version 1.0
 */

// ============================================================================
// CARGA DE DEPENDENCIAS Y GESTORES
// ============================================================================

// Carga de datos fijos y configuraciones iniciales si es necesario
require_once 'cargar.php';

// Importación de todos los gestores de entidades del sistema
// Cada gestor se encarga de las operaciones CRUD de su respectiva entidad
require_once __DIR__ . '/utils/manageAnimal.php';      // Gestión de animales
require_once __DIR__ . '/utils/manageArea.php';        // Gestión de áreas/hábitats
require_once __DIR__ . '/utils/manageEspecies.php';    // Gestión de especies
require_once __DIR__ . '/utils/manageCuidador.php';    // Gestión de cuidadores
require_once __DIR__ . '/utils/managePresentaciones.php'; // Gestión de shows/presentaciones

// ============================================================================
// INSTANCIACIÓN DE GESTORES
// ============================================================================

// Creación de instancias de los gestores para acceder a los datos
// Cada gestor maneja la conexión y consultas a su tabla correspondiente
$gestorAnimales = new ManageAnimal();
$gestorAreas = new ManageArea();
$gestorEspecies = new ManageEspecies();
$gestorCuidadores = new ManageCuidador();
$gestorPresentaciones = new ManagePresentaciones();

// ============================================================================
// OBTENCIÓN DE DATOS DESDE LA BASE DE DATOS
// ============================================================================

// Recuperación de todos los datos necesarios para mostrar en la interfaz
// Estos datos se utilizarán para poblar las diferentes secciones de la página
$animales = $gestorAnimales->getAnimales();           // Lista completa de animales
$areas = $gestorAreas->getAreas();                   // Lista de áreas/hábitats
$especies = $gestorEspecies->getEspecies();          // Lista de especies
$cuidadores = $gestorCuidadores->getCuidadores();    // Lista de cuidadores
$presentaciones = $gestorPresentaciones->getPresentaciones(); // Lista de shows
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Zoológico Digital - Portal Completo</title>
    <link rel="stylesheet" type="text/css" href="index.css" />
</head>
<body>
    <div class="container">
        <!-- ================================================================ -->
        <!-- CABECERA PRINCIPAL -->
        <!-- ================================================================ -->
        <div class="header">
            <h1>🦁 Zoológico Digital</h1>
            <p>Sistema de Gestión Integral de Fauna - Portal del Visitante</p>
            
            <!-- Botones de acceso rápido a funciones principales -->
            <div class="quick-actions">
                <button class="quick-btn" onclick="openModal('ticketModal')">🎫 Comprar Entradas</button>
                <button class="quick-btn" onclick="openModal('reservaModal')">📅 Reservar Visita</button>
                <button class="quick-btn" onclick="showSection('eventos')">🎭 Ver Eventos</button>
                <button class="quick-btn" onclick="scrollToFAQ()">❓ FAQ</button>
            </div>
        </div>
        
        <!-- ================================================================ -->
        <!-- CONTROLES DE BÚSQUEDA Y FILTRADO -->
        <!-- ================================================================ -->
        <div class="search-controls">
            <div class="search-bar">
                <!-- Campo de búsqueda para filtrar contenido dinámicamente -->
                <input type="text" id="searchInput" class="search-input" placeholder="Buscar animales, especies, eventos...">
                
                <!-- Selector para filtrar por tipo de contenido -->
                <select id="filterType" class="filter-select">
                    <option value="all">Todos los tipos</option>
                    <option value="animal">Solo Animales</option>
                    <option value="especie">Solo Especies</option>
                    <option value="area">Solo Áreas</option>
                    <option value="cuidador">Solo Cuidadores</option>
                    <option value="presentacion">Solo Presentaciones</option>
                </select>
            </div>
        </div>
        
        <!-- ================================================================ -->
        <!-- NAVEGACIÓN POR PESTAÑAS -->
        <!-- ================================================================ -->
        <div class="nav-tabs">
            <!-- Pestañas para navegar entre diferentes secciones -->
            <button class="nav-tab active" onclick="showSection('overview')">📊 Resumen</button>
            <button class="nav-tab" onclick="showSection('animales')">🐾 Animales</button>
            <button class="nav-tab" onclick="showSection('especies')">🦋 Especies</button>
            <button class="nav-tab" onclick="showSection('areas')">🌳 Áreas</button>
            <button class="nav-tab" onclick="showSection('presentaciones')">🎭 Shows</button>
            <button class="nav-tab" onclick="showSection('entradas')">🎫 Entradas</button>
            <button class="nav-tab" onclick="showSection('eventos')">📅 Eventos</button>
        </div>
        
        <div class="content">
            <!-- ============================================================ -->
            <!-- SECCIÓN RESUMEN - Dashboard con estadísticas generales -->
            <!-- ============================================================ -->
            <div id="overview" class="section active">
                <!-- Tarjetas con estadísticas principales del zoológico -->
                <div class="stats">
                    <div class="stat-card">
                        <div class="stat-number"><?= count($animales) ?></div>
                        <div class="stat-label">Animales</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?= count($especies) ?></div>
                        <div class="stat-label">Especies</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?= count($areas) ?></div>
                        <div class="stat-label">Áreas</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?= count($cuidadores) ?></div>
                        <div class="stat-label">Cuidadores</div>
                    </div>
                </div>
                
                <h2 style="margin-bottom: 20px; color: #2c3e50;">🎯 Resumen por Áreas</h2>
                <div class="cards-grid">
                    <?php 
                    // Iteración por cada área para mostrar su información y animales
                    foreach ($areas as $area): 
                        // Filtrar animales que pertenecen al área actual
                        // Se verifica que el animal tenga especie, que la especie tenga área,
                        // y que el ID del área coincida con el área actual
                        $animalesEnArea = array_filter($animales, function($animal) use ($area) {
                            return $animal->getEspecie()->getArea() && 
                                   $animal->getEspecie()->getArea()->getId() === $area->getId();
                        });
                    ?>
                    <div class="card">
                        <div class="card-title">
                            <!-- Icono dinámico basado en el tipo de hábitat -->
                            <div class="card-icon"><?= $area->getTipoHabitat() === 'Bosque' ? '🌲' : '🌴' ?></div>
                            <?= htmlspecialchars($area->getTipoHabitat()) ?>
                        </div>
                        
                        <!-- Información del cuidador asignado al área -->
                        <div class="card-info">
                            <span class="card-label">Cuidador:</span>
                            <span class="card-value"><?= htmlspecialchars($area->getCuidador() ? $area->getCuidador()->getNombre() : 'Sin asignar') ?></span>
                        </div>
                        
                        <!-- Contador de animales en el área -->
                        <div class="card-info">
                            <span class="card-label">Animales:</span>
                            <span class="card-value"><?= count($animalesEnArea) ?></span>
                        </div>
                        
                        <!-- Lista detallada de animales en el área -->
                        <ul class="animal-list">
                            <?php foreach ($animalesEnArea as $animal): ?>
                                <li><?= htmlspecialchars($animal->getNombre()) ?> (<?= htmlspecialchars($animal->getEspecie()->getNombre()) ?>)</li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- ============================================================ -->
            <!-- SECCIÓN ANIMALES - Catálogo completo de animales -->
            <!-- ============================================================ -->
            <div id="animales" class="section">
                <h2 style="margin-bottom: 20px; color: #2c3e50;">🐾 Nuestros Animales</h2>
                <div class="cards-grid">
                    <?php foreach ($animales as $animal): ?>
                    <div class="card animal-card" data-search="<?= strtolower($animal->getNombre() . ' ' . $animal->getEspecie()->getNombre() . ' ' . $animal->getEspecie()->getArea()->getTipoHabitat()) ?>">
                        <div class="card-title">
                            <div class="card-icon">🐾</div>
                            <?= htmlspecialchars($animal->getNombre()) ?>
                        </div>
                        
                        <!-- Información detallada del animal -->
                        <div class="card-info">
                            <span class="card-label">Edad:</span>
                            <span class="card-value"><?= $animal->getEdad() ?> años</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Sexo:</span>
                            <span class="card-value"><?= htmlspecialchars($animal->getSexo()) ?></span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Especie:</span>
                            <span class="card-value"><?= htmlspecialchars($animal->getEspecie()->getNombre()) ?></span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Área:</span>
                            <span class="card-value"><?= htmlspecialchars($animal->getEspecie()->getArea()->getTipoHabitat()) ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- ============================================================ -->
            <!-- SECCIÓN ESPECIES - Información sobre especies del zoológico -->
            <!-- ============================================================ -->
            <div id="especies" class="section">
                <h2 style="margin-bottom: 20px; color: #2c3e50;">🦋 Especies en el Zoológico</h2>
                <div class="cards-grid">
                    <?php foreach ($especies as $especie): ?>
                    <div class="card especie-card" data-search="<?= strtolower($especie->getNombre() . ' ' . ($especie->getArea() ? $especie->getArea()->getTipoHabitat() : '')) ?>">
                        <div class="card-title">
                            <div class="card-icon">🦋</div>
                            <?= htmlspecialchars($especie->getNombre()) ?>
                        </div>
                        
                        <!-- Estadísticas de población por género -->
                        <div class="card-info">
                            <span class="card-label">Machos:</span>
                            <span class="card-value"><?= $especie->getCantidadMachos() ?></span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Hembras:</span>
                            <span class="card-value"><?= $especie->getCantidadHembras() ?></span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Total:</span>
                            <span class="card-value"><?= $especie->getCantidadMachos() + $especie->getCantidadHembras() ?></span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Área:</span>
                            <span class="card-value"><?= htmlspecialchars($especie->getArea() ? $especie->getArea()->getTipoHabitat() : 'N/A') ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- ============================================================ -->
            <!-- SECCIÓN ÁREAS - Información sobre hábitats y zonas -->
            <!-- ============================================================ -->
            <div id="areas" class="section">
                <h2 style="margin-bottom: 20px; color: #2c3e50;">🌳 Hábitats y Áreas</h2>
                <div class="cards-grid">
                    <?php foreach ($areas as $area): ?>
                    <div class="card area-card" data-search="<?= strtolower($area->getTipoHabitat() . ' ' . ($area->getCuidador() ? $area->getCuidador()->getNombre() : '')) ?>">
                        <div class="card-title">
                            <!-- Icono contextual según el tipo de hábitat -->
                            <div class="card-icon"><?= $area->getTipoHabitat() === 'Bosque' ? '🌲' : '🌴' ?></div>
                            <?= htmlspecialchars($area->getTipoHabitat()) ?>
                        </div>
                        
                        <!-- Información básica del área -->
                        <div class="card-info">
                            <span class="card-label">ID:</span>
                            <span class="card-value"><?= $area->getId() ?></span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Cuidador:</span>
                            <span class="card-value"><?= htmlspecialchars($area->getCuidador() ? $area->getCuidador()->getNombre() : 'Sin asignar') ?></span>
                        </div>
                        
                        <!-- Lista de animales que habitan en esta área -->
                        <div class="card-info">
                            <span class="card-label">Animales:</span>
                        </div>
                        <ul class="animal-list">
                            <?php
                            // Búsqueda de animales que pertenecen a esta área específica
                            foreach ($animales as $animal) {
                                if ($animal->getEspecie()->getArea() && 
                                    $animal->getEspecie()->getArea()->getId() === $area->getId()) {
                                    echo '<li>' . htmlspecialchars($animal->getNombre()) . ' (' . htmlspecialchars($animal->getEspecie()->getNombre()) . ')</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- ============================================================ -->
            <!-- SECCIÓN PRESENTACIONES - Shows y actividades especiales -->
            <!-- ============================================================ -->
            <div id="presentaciones" class="section">
                <h2 style="margin-bottom: 20px; color: #2c3e50;">🎭 Shows y Presentaciones</h2>
                <div class="cards-grid">
                    <?php foreach ($presentaciones as $presentacion): 
                        // Obtención de referencias a área y cuidador para la presentación
                        $area = $presentacion->getArea();
                        $cuidador = $presentacion->getCuidador();
                    ?>
                    <div class="card presentacion-card" data-search="<?= strtolower($presentacion->getTipo() . ' ' . ($area ? $area->getTipoHabitat() : '') . ' ' . ($cuidador ? $cuidador->getNombre() : '')) ?>">
                        <div class="card-title">
                            <div class="card-icon">🎭</div>
                            Show <?= htmlspecialchars($presentacion->getTipo()) ?>
                        </div>
                        
                        <!-- Detalles de la presentación -->
                        <div class="card-info">
                            <span class="card-label">Duración:</span>
                            <span class="card-value"><?= $presentacion->getDuracion() ?> minutos</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Área:</span>
                            <span class="card-value"><?= htmlspecialchars($area ? $area->getTipoHabitat() : 'N/A') ?></span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Cuidador:</span>
                            <span class="card-value"><?= htmlspecialchars($cuidador ? $cuidador->getNombre() : 'N/A') ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- ============================================================ -->
            <!-- SECCIÓN ENTRADAS - Precios y tarifas -->
            <!-- ============================================================ -->
            <div id="entradas" class="section">
                <h2 style="margin-bottom: 30px; color: #2c3e50;">🎫 Tarifas y Entradas</h2>
                
                <div class="cards-grid">
                    <!-- Tabla de precios de entradas generales -->
                    <div class="card">
                        <div class="card-title">
                            <div class="card-icon">🎫</div>
                            Entrada General
                        </div>
                        <table class="price-table">
                            <thead>
                                <tr>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Adultos</td>
                                    <td>$2,500</td>
                                </tr>
                                <tr>
                                    <td>Niños (3-12 años)</td>
                                    <td>$1,800</td>
                                </tr>
                                <tr>
                                    <td>Estudiantes</td>
                                    <td>$2,000</td>
                                </tr>
                                <tr>
                                    <td>Jubilados</td>
                                    <td>$1,500</td>
                                </tr>
                                <tr>
                                    <td>Menores de 3 años</td>
                                    <td>Gratis</td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn" style="margin-top: 15px;" onclick="openModal('ticketModal')">
                            Comprar Entradas Online
                        </button>
                    </div>
                    
                    <!-- Información de pases anuales -->
                    <div class="card">
                        <div class="card-title">
                            <div class="card-icon">⭐</div>
                            Pases Anuales
                        </div>
                        <table class="price-table">
                            <thead>
                                <tr>
                                    <th>Tipo de Pase</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Individual</td>
                                    <td>$18,000</td>
                                </tr>
                                <tr>
                                    <td>Familiar (4 personas)</td>
                                    <td>$45,000</td>
                                </tr>
                                <tr>
                                    <td>Estudiante</td>
                                    <td>$12,000</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <!-- Lista de beneficios del pase anual -->
                        <div style="margin-top: 15px; font-size: 14px; color: #6c757d;">
                            <strong>Beneficios:</strong>
                            <ul>
                                <li>Entrada ilimitada por un año</li>
                                <li>10% descuento en tienda</li>
                                <li>Acceso prioritario a eventos</li>
                                <li>Newsletter exclusivo</li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Descuentos especiales disponibles -->
                    <div class="card">
                        <div class="card-title">
                            <div class="card-icon">🎁</div>
                            Descuentos Especiales
                        </div>
                        <div class="card-info">
                            <span class="card-label">Grupos (+10):</span>
                            <span class="card-value">15% descuento</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Escuelas:</span>
                            <span class="card-value">20% descuento</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Martes familiares:</span>
                            <span class="card-value">2x1 en entradas</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Cumpleañeros:</span>
                            <span class="card-value">Entrada gratis</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ============================================================ -->
            <!-- SECCIÓN EVENTOS - Calendario y actividades especiales -->
            <!-- ============================================================ -->
            <div id="eventos" class="section">
                <h2 style="margin-bottom: 30px; color: #2c3e50;">📅 Calendario de Eventos</h2>
                
                <!-- Calendario visual para Enero 2025 -->
                <div class="info-card" style="margin-bottom: 30px;">
                    <h3>🗓️ Enero 2025</h3>
                    <div class="calendar-grid">
                        <!-- Encabezados de días de la semana -->
                        <div style="text-align: center; font-weight: bold; color: #667eea;">Dom</div>
                        <div style="text-align: center; font-weight: bold; color: #667eea;">Lun</div>
                        <div style="text-align: center; font-weight: bold; color: #667eea;">Mar</div>
                        <div style="text-align: center; font-weight: bold; color: #667eea;">Mié</div>
                        <div style="text-align: center; font-weight: bold; color: #667eea;">Jue</div>
                        <div style="text-align: center; font-weight: bold; color: #667eea;">Vie</div>
                        <div style="text-align: center; font-weight: bold; color: #667eea;">Sáb</div>
                        
                        <!-- Días del calendario - Primera semana -->
                        <div class="calendar-day" style="opacity: 0.3;">29</div> <!-- Días del mes anterior -->
                        <div class="calendar-day" style="opacity: 0.3;">30</div>
                        <div class="calendar-day" style="opacity: 0.3;">31</div>
                        <div class="calendar-day">1</div>
                        <div class="calendar-day">2</div>
                        <div class="calendar-day">3</div>
                        <div class="calendar-day">4</div>
                        
                        <!-- Días del calendario - Semanas siguientes con eventos marcados -->
                        <div class="calendar-day">5</div>
                        <div class="calendar-day">6</div>
                        <div class="calendar-day">7</div>
                        <div class="calendar-day">8</div>
                        <div class="calendar-day">9</div>
                        <div class="calendar-day">10</div>
                        <div class="calendar-day">11</div>
                        
                        <div class="calendar-day">12</div>
                        <div class="calendar-day">13</div>
                        <div class="calendar-day">14</div>
                        <!-- Días con eventos especiales marcados con punto indicador -->
                        <div class="calendar-day has-event">15<div class="event-dot"></div></div>
                        <div class="calendar-day">16</div>
                        <div class="calendar-day has-event">17<div class="event-dot"></div></div>
                        <div class="calendar-day has-event">18<div class="event-dot"></div></div>
                        
                        <div class="calendar-day">19</div>
                        <div class="calendar-day">20</div>
                        <div class="calendar-day">21</div>
                        <div class="calendar-day has-event">22<div class="event-dot"></div></div>
                        <div class="calendar-day">23</div>
                        <div class="calendar-day">24</div>
                        <div class="calendar-day has-event">25<div class="event-dot"></div></div>
                        
                        <div class="calendar-day">26</div>
                        <div class="calendar-day">27</div>
                        <div class="calendar-day">28</div>
                        <div class="calendar-day">29</div>
                        <div class="calendar-day has-event">30<div class="event-dot"></div></div>
                        <div class="calendar-day">31</div>
                        <div class="calendar-day" style="opacity: 0.3;">1</div> <!-- Primer día del próximo mes -->
                    </div>
                </div>
                
                <!-- Tarjetas con detalles de eventos específicos -->
                <div class="cards-grid">
                    <!-- Charla sobre conservación -->
                    <div class="card">
                        <div class="card-title">
                            <div class="card-icon">🦁</div>
                            Charla: Conservación de Felinos
                        </div>
                        <div class="card-info">
                            <span class="card-label">Fecha:</span>
                            <span class="card-value">15 de Enero</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Hora:</span>
                            <span class="card-value">14:00 - 15:30</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Lugar:</span>
                            <span class="card-value">Auditorio Principal</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Entrada:</span>
                            <span class="card-value">Gratuita con entrada al zoo</span>
                        </div>
                    </div>
                    
                    <!-- Show de aves tropicales -->
                    <div class="card">
                        <div class="card-title">
                            <div class="card-icon">🎭</div>
                            Show de Aves Tropicales
                        </div>
                        <div class="card-info">
                            <span class="card-label">Fecha:</span>
                            <span class="card-value">17-18 de Enero</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Hora:</span>
                            <span class="card-value">11:00, 15:00, 17:00</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Lugar:</span>
                            <span class="card-value">Área Tropical</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Duración:</span>
                            <span class="card-value">30 minutos</span>
                        </div>
                    </div>
                    
                    <!-- Visita nocturna especial -->
                    <div class="card">
                        <div class="card-title">
                            <div class="card-icon">🌙</div>
                            Visita Nocturna
                        </div>
                        <div class="card-info">
                            <span class="card-label">Fecha:</span>
                            <span class="card-value">22 de Enero</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Hora:</span>
                            <span class="card-value">19:30 - 21:30</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Cupo:</span>
                            <span class="card-value">30 personas máximo</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Precio:</span>
                            <span class="card-value">$3,500 por persona</span>
                        </div>
                        <button class="btn" style="margin-top: 10px;" onclick="openModal('reservaModal')">Reservar Plaza</button>
                    </div>
                    
                    <!-- Taller educativo para niños -->
                    <div class="card">
                        <div class="card-title">
                            <div class="card-icon">🎨</div>
                            Taller de Arte Animal
                        </div>
                        <div class="card-info">
                            <span class="card-label">Fecha:</span>
                            <span class="card-value">25 de Enero</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Hora:</span>
                            <span class="card-value">10:00 - 12:00</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Edades:</span>
                            <span class="card-value">8-14 años</span>
                        </div>
                        <div class="card-info">
                            <span class="card-label">Precio:</span>
                            <span class="card-value">$1,200 + materiales</span>
                        </div>
                        <button class="btn" style="margin-top: 10px;" onclick="openModal('reservaModal')">Inscribir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    
    <!-- ================================================================ -->
    <!-- SECCIÓN HISTORIA/NOSOTROS - Información institucional -->
    <!-- ================================================================ -->
    <div class="historia-section">
        <div class="historia-content">
            <h2 class="historia-title">🌿 Nuestra Historia</h2>
            
            <!-- Historia y misión del zoológico -->
            <div class="historia-text">
                Fundado en 1995, el Zoológico Digital nació como un sueño de conservación y educación ambiental en el corazón de Buenos Aires. 
                Durante más de 25 años, hemos sido pioneros en la implementación de tecnologías digitales para el manejo y cuidado de fauna, 
                convirtiéndonos en un referente internacional en conservación moderna.
            </div>
            
            <div class="historia-text">
                Nuestro compromiso va más allá de la exhibición de animales. Somos un centro de investigación, conservación y educación 
                que trabaja incansablemente para proteger especies en peligro de extinción y educar a las futuras generaciones sobre 
                la importancia de la biodiversidad. Cada visitante que recibimos se convierte en un embajador de la conservación.
            </div>
            
            <!-- Tarjetas con información institucional -->
            <div class="historia-highlights">
                <div class="highlight-card">
                    <h4>🎯 Nuestra Misión</h4>
                    <p>Conservar la biodiversidad mediante la educación, investigación y programas de reproducción, 
                    inspirando a las personas a valorar y proteger la vida silvestre.</p>
                </div>
                
                <div class="highlight-card">
                    <h4>👁️ Nuestra Visión</h4>
                    <p>Ser el zoológico líder en Latinoamérica, reconocido por nuestros programas de conservación 
                    y por crear conexiones significativas entre las personas y la naturaleza.</p>
                </div>
                
                <div class="highlight-card">
                    <h4>💚 Nuestros Valores</h4>
                    <p>Respeto por la vida, compromiso con la conservación, excelencia en el cuidado animal, 
                    educación transformadora y responsabilidad ambiental.</p>
                </div>
                
                <div class="highlight-card">
                    <h4>🏆 Logros Destacados</h4>
                    <p>Más de 50 especies reproducidas exitosamente, 3 programas internacionales de conservación, 
                    y más de 2 millones de visitantes educados en conservación.</p>
                </div>
            </div>
            
            <!-- ======================================================== -->
            <!-- SUBSECCIÓN CUIDADORES - Equipo profesional -->
            <!-- ======================================================== -->
            <h3 style="color: #2c3e50; margin: 40px 0 20px 0; font-size: 1.8rem;">👨‍⚕️ Nuestro Equipo de Cuidadores</h3>
            <div class="cards-grid">
                <?php 
                // Mostrar información de cada cuidador del zoológico
                foreach ($cuidadores as $cuidador): ?>
                <div class="card cuidador-card" data-search="<?= strtolower($cuidador->getNombre() . ' ' . $cuidador->getEmail() . ' ' . ($cuidador->getArea() ? $cuidador->getArea()->getTipoHabitat() : '')) ?>">
                    <div class="card-title">
                        <div class="card-icon">👨‍⚕️</div>
                        <?= htmlspecialchars($cuidador->getNombre()) ?>
                    </div>
                    
                    <!-- Información de contacto del cuidador -->
                    <div class="card-info">
                        <span class="card-label">Teléfono:</span>
                        <span class="card-value"><?= $cuidador->getTelefono() ?></span>
                    </div>
                    <div class="card-info">
                        <span class="card-label">Email:</span>
                        <span class="card-value"><?= htmlspecialchars($cuidador->getEmail()) ?></span>
                    </div>
                    <div class="card-info">
                        <span class="card-label">Área:</span>
                        <span class="card-value"><?= htmlspecialchars($cuidador->getArea() ? $cuidador->getArea()->getTipoHabitat() : 'N/A') ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- ================================================================ -->
    <!-- SECCIÓN FAQ - Preguntas frecuentes fija al final -->
    <!-- ================================================================ -->
    <div class="faq-section" id="faqSection">
        <div class="faq-container">
            <h2 class="faq-title">❓ Preguntas Frecuentes</h2>
            
            <!-- Conjunto de preguntas y respuestas más comunes -->
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>¿Cuáles son los horarios de apertura?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    El zoológico está abierto de lunes a viernes de 9:00 a 18:00, fines de semana de 8:30 a 19:00, y feriados de 9:00 a 17:00. La última entrada es una hora antes del cierre.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>¿Puedo llevar comida al zoológico?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    Sí, puedes traer tu propia comida y bebidas. Contamos con áreas de picnic designadas. No se permite alcohol. También tenemos cafeterías y restaurantes dentro del predio.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>¿El zoológico es accesible para sillas de ruedas?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    Sí, todas nuestras instalaciones son completamente accesibles. Ofrecemos préstamo gratuito de sillas de ruedas y tenemos baños adaptados en todo el predio.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>¿Hay descuentos para grupos?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    Ofrecemos 15% de descuento para grupos de 10 o más personas, y 20% para grupos escolares. Es necesario hacer reserva previa con al menos 7 días de anticipación.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>¿Puedo alimentar a los animales?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    Por la seguridad de los animales y visitantes, está prohibido alimentar a los animales con comida personal. Ofrecemos experiencias supervisadas de alimentación en horarios específicos.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>¿Hay estacionamiento disponible?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    Sí, contamos con estacionamiento para 200 vehículos por $500 pesos por día. Incluye 5 espacios para personas con discapacidad. El horario es de 8:00 a 20:00.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>¿Puedo cancelar o cambiar mi entrada?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    Las entradas online se pueden cancelar hasta 24 horas antes de la visita con reembolso completo. Los cambios de fecha se pueden hacer hasta 2 horas antes sin costo adicional.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFAQ(this)">
                    <span>¿Qué pasa si llueve?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    El zoológico permanece abierto durante la lluvia ligera. Muchas exhibiciones tienen áreas cubiertas. En caso de clima severo, algunas actividades al aire libre pueden cancelarse.
                </div>
            </div>
        </div>
    </div>

    <!-- ================================================================ -->
    <!-- MODALES PARA INTERACCIONES DEL USUARIO -->
    <!-- ================================================================ -->
    
    <!-- Modal para compra de entradas online -->
    <div id="ticketModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>🎫 Comprar Entradas Online</h2>
                <span class="close" onclick="closeModal('ticketModal')">&times;</span>
            </div>
            <div class="modal-body">
                <form id="ticketForm">
                    <!-- Selección de fecha de visita -->
                    <div class="form-group">
                        <label>Fecha de Visita:</label>
                        <input type="date" id="visitDate" required>
                    </div>
                    
                    <!-- Selección de cantidad de entradas por categoría -->
                    <div class="form-row">
                        <div class="form-group">
                            <label>Adultos ($2,500):</label>
                            <input type="number" id="adults" min="0" value="0" onchange="updateTotal()">
                        </div>
                        <div class="form-group">
                            <label>Niños ($1,800):</label>
                            <input type="number" id="children" min="0" value="0" onchange="updateTotal()">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Estudiantes ($2,000):</label>
                            <input type="number" id="students" min="0" value="0" onchange="updateTotal()">
                        </div>
                        <div class="form-group">
                            <label>Jubilados ($1,500):</label>
                            <input type="number" id="seniors" min="0" value="0" onchange="updateTotal()">
                        </div>
                    </div>
                    
                    <!-- Cálculo automático del total -->
                    <div class="card" style="background: #f8f9fa; margin: 20px 0; padding: 15px;">
                        <h4 style="color: #2c3e50;">Total: $<span id="totalPrice">0</span></h4>
                    </div>
                    
                    <!-- Datos del comprador -->
                    <div class="form-group">
                        <label>Nombre Completo:</label>
                        <input type="text" id="customerName" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" id="customerEmail" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Teléfono:</label>
                        <input type="tel" id="customerPhone" required>
                    </div>
                    
                    <!-- Botón de procesamiento de pago -->
                    <button type="button" class="btn btn-success" onclick="processPayment()">
                        💳 Procesar Pago
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para reserva de actividades especiales -->
    <div id="reservaModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>📅 Reservar Actividad</h2>
                <span class="close" onclick="closeModal('reservaModal')">&times;</span>
            </div>
            <div class="modal-body">
                <form id="reservaForm">
                    <!-- Selector de tipo de actividad -->
                    <div class="form-group">
                        <label>Tipo de Actividad:</label>
                        <select id="activityType" onchange="updateActivityInfo()" required>
                            <option value="">Seleccionar actividad</option>
                            <option value="visita">Visita Guiada ($800 adicional)</option>
                            <option value="feeding">Feeding Time ($1,200 adicional)</option>
                            <option value="cumpleanos">Cumpleaños ($8,500 hasta 15 niños)</option>
                            <option value="taller">Taller Educativo ($600 adicional)</option>
                            <option value="nocturna">Visita Nocturna ($3,500 por persona)</option>
                            <option value="arte">Taller de Arte ($1,200 + materiales)</option>
                        </select>
                    </div>
                    
                    <!-- Información dinámica de la actividad seleccionada -->
                    <div id="activityInfo" class="card" style="background: #f8f9fa; margin: 20px 0; display: none;">
                        <div id="activityDetails"></div>
                    </div>
                    
                    <!-- Datos de la reserva -->
                    <div class="form-group">
                        <label>Fecha:</label>
                        <input type="date" id="reservationDate" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Horario:</label>
                        <select id="timeSlot" required>
                            <option value="">Primero selecciona una actividad</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Número de Personas:</label>
                        <input type="number" id="peopleCount" min="1" max="30" required>
                    </div>
                    
                    <!-- Datos del responsable de la reserva -->
                    <div class="form-group">
                        <label>Nombre del Responsable:</label>
                        <input type="text" id="responsibleName" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" id="responsibleEmail" required>
                        </div>
                        <div class="form-group">
                            <label>Teléfono:</label>
                            <input type="tel" id="responsiblePhone" required>
                        </div>
                    </div>
                    
                    <!-- Campo adicional para comentarios especiales -->
                    <div class="form-group">
                        <label>Comentarios adicionales:</label>
                        <textarea id="comments" rows="3" placeholder="Alergias, necesidades especiales, etc."></textarea>
                    </div>
                    
                    <!-- Botón de confirmación de reserva -->
                    <button type="button" class="btn btn-success" onclick="processReservation()">
                        📅 Confirmar Reserva
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- SCRIPTS JAVASCRIPT - Funcionalidad interactiva -->
    <script src="./js/index.js">
    </script>
</body>
</html>