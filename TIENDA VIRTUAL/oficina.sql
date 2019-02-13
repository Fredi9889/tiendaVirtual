-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-02-2019 a las 10:21:44
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `oficina`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `DNI` varchar(9) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `usuario` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`DNI`, `nombre`, `direccion`, `usuario`, `password`) VALUES
('12309845R', 'Alfredo', 'Calle de Alfredo', 'cliente', 'Alfredo'),
('12345612Q', 'Roberto', 'Calle de Roberto', 'cliente', 'Roberto'),
('12345678X', 'Pepe', 'Calle de Pepe', 'cliente', 'Pepe'),
('65476578Z', 'Maite', 'Calle de Maite', 'cliente', 'Maite'),
('87654321P', 'Administrador', 'Calle del administrador', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familia`
--

CREATE TABLE `familia` (
  `cod` varchar(6) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `familia`
--

INSERT INTO `familia` (`cod`, `nombre`) VALUES
('ESCRI', 'Escritorios'),
('SILLA', 'Sillas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea_pedido`
--

CREATE TABLE `linea_pedido` (
  `num_pedido` int(11) NOT NULL,
  `num_linea` int(11) NOT NULL,
  `producto` varchar(12) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `linea_pedido`
--

INSERT INTO `linea_pedido` (`num_pedido`, `num_linea`, `producto`, `cantidad`, `precio`) VALUES
(4, 7, '1', 4, '40'),
(4, 8, '2', 3, '195'),
(5, 9, '1', 10, '100'),
(5, 10, '2', 3, '195'),
(6, 11, '2', 3, '195'),
(7, 12, '1', 6, '60'),
(7, 13, '2', 3, '195'),
(7, 14, '3', 4, '60'),
(7, 15, '4', 3, '315'),
(8, 16, '1', 2, '20'),
(8, 17, '2', 2, '130'),
(8, 18, '3', 1, '15'),
(8, 19, '4', 4, '420'),
(9, 20, '2', 1, '65'),
(9, 21, '4', 1, '105');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `num_pedido` int(11) NOT NULL,
  `DNI` varchar(9) NOT NULL,
  `fecha` date NOT NULL,
  `total_pedido` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`num_pedido`, `DNI`, `fecha`, `total_pedido`) VALUES
(4, '12345678X', '2019-02-13', '235'),
(5, '12345678X', '2019-02-13', '295'),
(6, '12345678X', '2019-02-13', '195'),
(7, '12309845R', '2019-02-13', '630'),
(8, '65476578Z', '2019-02-13', '585'),
(9, '65476578Z', '2019-02-13', '170');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `cod` varchar(12) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `PVP` decimal(10,0) NOT NULL,
  `familia` varchar(6) NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`cod`, `nombre`, `descripcion`, `PVP`, `familia`, `stock`, `imagen`) VALUES
('1', 'Silla 1', 'Silla de madera', '10', 'SILLA', 100, 'img/9.jpg'),
('2', 'Escritorio 1', 'Escritorio de madera', '65', 'ESCRI', 50, 'img/4.jpg'),
('3', 'Silla 2', 'Silla replegable', '15', 'SILLA', 250, 'img/6.jpg'),
('4', 'Escritorio 2', 'Escritorio de oficina', '105', 'ESCRI', 20, 'img/1.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`DNI`,`usuario`);

--
-- Indices de la tabla `familia`
--
ALTER TABLE `familia`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD PRIMARY KEY (`num_linea`,`num_pedido`),
  ADD KEY `num_pedido` (`num_pedido`),
  ADD KEY `producto` (`producto`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`num_pedido`,`DNI`),
  ADD KEY `DNI` (`DNI`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`cod`,`nombre`),
  ADD KEY `familia` (`familia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  MODIFY `num_linea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `num_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD CONSTRAINT `linea_pedido_ibfk_1` FOREIGN KEY (`num_pedido`) REFERENCES `pedido` (`num_pedido`),
  ADD CONSTRAINT `linea_pedido_ibfk_2` FOREIGN KEY (`producto`) REFERENCES `producto` (`cod`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`DNI`) REFERENCES `cliente` (`DNI`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`familia`) REFERENCES `familia` (`cod`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
