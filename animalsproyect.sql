-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-07-2025 a las 04:49:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `animalsproyect`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animal`
--

CREATE TABLE `animal` (
  `id_animal` int(11) NOT NULL,
  `id_especie` int(11) NOT NULL,
  `nombre` varchar(35) NOT NULL,
  `edad` int(3) NOT NULL,
  `sexo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `animal`
--

INSERT INTO `animal` (`id_animal`, `id_especie`, `nombre`, `edad`, `sexo`) VALUES
(1, 1, 'Copito', 4, 'M'),
(2, 1, 'Luna', 3, 'F'),
(3, 2, 'Simba', 5, 'M'),
(4, 2, 'Nala', 4, 'F'),
(5, 2, 'Messi', 38, 'Hombre'),
(6, 1, 'Ronaldo', 40, 'Hombre'),
(7, 1, 'Vinicius', 23, 'Hombre'),
(213, 3, 'prueba', 18, 'mujer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id_area` int(11) NOT NULL,
  `id_cuidador` int(11) NOT NULL,
  `tipohabitad` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id_area`, `id_cuidador`, `tipohabitad`) VALUES
(1, 1, 'Selva tropical'),
(2, 2, 'Sabana africana'),
(3, 1, 'Desierto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuidador`
--

CREATE TABLE `cuidador` (
  `id_cuidador` int(11) NOT NULL,
  `id_area` int(11) DEFAULT NULL,
  `nombre` varchar(30) NOT NULL,
  `telefono` int(13) NOT NULL,
  `email` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cuidador`
--

INSERT INTO `cuidador` (`id_cuidador`, `id_area`, `nombre`, `telefono`, `email`) VALUES
(1, 1, 'Laura Fernández', 123456789, 'laura@example.com'),
(2, 2, 'Carlos Méndez', 987654321, 'carlos@example.com'),
(3, 3, 'Pablo', 1133445566, 'pablo@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especies`
--

CREATE TABLE `especies` (
  `id_especies` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `cantidadMachos` int(11) NOT NULL,
  `cantidadHembras` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especies`
--

INSERT INTO `especies` (`id_especies`, `id_area`, `nombre`, `cantidadMachos`, `cantidadHembras`) VALUES
(1, 1, 'Mono aullador', 2, 3),
(2, 2, 'León africano', 1, 2),
(3, 3, 'pikachu', 11, 22),
(4, 1, 'sajkdsdajk', 2, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones`
--

CREATE TABLE `presentaciones` (
  `id_presentacion` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `id_cuidador` int(11) NOT NULL,
  `duracion` varchar(30) NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presentaciones`
--

INSERT INTO `presentaciones` (`id_presentacion`, `id_area`, `id_cuidador`, `duracion`, `tipo`) VALUES
(1, 1, 1, '45', 'Educativa sobre primates'),
(2, 2, 2, '30', 'Charla sobre grandes felinos');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id_animal`),
  ADD KEY `id_especie_animal` (`id_especie`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`),
  ADD KEY `id_cuidador_area` (`id_cuidador`);

--
-- Indices de la tabla `cuidador`
--
ALTER TABLE `cuidador`
  ADD PRIMARY KEY (`id_cuidador`);

--
-- Indices de la tabla `especies`
--
ALTER TABLE `especies`
  ADD PRIMARY KEY (`id_especies`),
  ADD KEY `id_area_especie` (`id_area`);

--
-- Indices de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD PRIMARY KEY (`id_presentacion`),
  ADD KEY `id_presentaciones_presentacion` (`id_area`),
  ADD KEY `id_cuidador_presentacion` (`id_cuidador`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `animal`
--
ALTER TABLE `animal`
  MODIFY `id_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cuidador`
--
ALTER TABLE `cuidador`
  MODIFY `id_cuidador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `especies`
--
ALTER TABLE `especies`
  MODIFY `id_especies` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id_presentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `id_especie_animal` FOREIGN KEY (`id_especie`) REFERENCES `especies` (`id_especies`);

--
-- Filtros para la tabla `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `id_cuidador_area` FOREIGN KEY (`id_cuidador`) REFERENCES `cuidador` (`id_cuidador`);

--
-- Filtros para la tabla `especies`
--
ALTER TABLE `especies`
  ADD CONSTRAINT `id_area_especie` FOREIGN KEY (`id_area`) REFERENCES `area` (`id_area`);

--
-- Filtros para la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD CONSTRAINT `id_cuidador_presentacion` FOREIGN KEY (`id_cuidador`) REFERENCES `cuidador` (`id_cuidador`),
  ADD CONSTRAINT `id_presentaciones_presentacion` FOREIGN KEY (`id_area`) REFERENCES `area` (`id_area`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
