-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2024 a las 20:49:23
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `carrito`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `name`, `apellido`, `email`, `created`, `modified`, `status`) VALUES
(14, 'Pepe', 'Reina', 'joaquintumba010@icloud.com', '2024-06-01 17:54:07', '2024-06-01 17:54:07', 'activo'),
(15, 'Pepe', 'Reina', 'joaquintumba010@icloud.com', '2024-06-01 17:54:37', '2024-06-01 17:54:37', 'activo'),
(16, 'Jurgen', 'Klopp', 'kloppo@gmail.com', '2024-06-01 18:01:46', '2024-06-01 18:01:46', 'activo'),
(17, 'Jurgen', 'Klopp', 'kloppo@gmail.com', '2024-06-01 21:57:21', '2024-06-01 21:57:21', 'activo'),
(18, 'Roy ', 'Silva', 'roysilva@gmail.com', '2024-06-01 22:53:19', '2024-06-01 22:53:19', 'activo'),
(19, 'roy', 'silva22', 'sap.clever.14@gmail.com', '2024-06-01 23:07:08', '2024-06-01 23:07:08', 'activo'),
(20, 'roy', 'silva22', 'paulsilvaquesquen24@gmail.com', '2024-06-01 23:14:15', '2024-06-01 23:14:15', 'activo'),
(21, 'roy', 'silva22', 'paulsilvaquesquen24@gmail.com', '2024-06-01 23:15:34', '2024-06-01 23:15:34', 'activo'),
(22, 'roy', 'silva22', 'paulsilvaquesquen24@gmail.com', '2024-06-01 23:18:26', '2024-06-01 23:18:26', 'activo'),
(23, 'roy', 'silva22', 'paulsilvaquesquen24@gmail.com', '2024-06-01 23:23:05', '2024-06-01 23:23:05', 'activo'),
(24, 'roy', 'silva22', 'paulsilvaquesquen24@gmail.com', '2024-06-02 04:08:18', '2024-06-02 04:08:18', 'activo'),
(25, 'roy', 'silva22', 'paulsilvaquesquen24@gmail.com', '2024-06-02 18:47:49', '2024-06-02 18:47:49', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mis_productos`
--

CREATE TABLE `mis_productos` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `image` blob DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mis_productos`
--

INSERT INTO `mis_productos` (`id`, `name`, `description`, `price`, `created`, `modified`, `status`, `image`, `categoria`) VALUES
(22, 'Helado', 'De chocolate', 6.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f68656c61646f2e6a7067, 'Postre'),
(24, 'Pizza', 'Familiar ', 13.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f70697a7a612e6a7067, 'Comida Rápida'),
(26, 'Hamburguesa', 'Hamburguesa de carne con queso y papas fritas', 14.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f68616d62757267756573612e6a7067, 'Comida Rápida'),
(27, 'Tarta de Frambuesa', 'Delicioso postre de frambuesa, para consumo personal.', 5.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f74617274615f66616d6272756573612e6a7067, 'Postre'),
(29, 'Coca Cola', 'Lata para consumo personal', 4.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f6c61746120646520636f636120636f6c612e6a7067, 'Bebida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `orden`
--

INSERT INTO `orden` (`id`, `customer_id`, `total_price`, `created`, `modified`, `status`) VALUES
(20, 22, 14.00, '2024-06-01 23:18:27', '2024-06-01 23:18:27', NULL),
(21, 23, 6.00, '2024-06-01 23:23:08', '2024-06-01 23:23:08', NULL),
(22, 24, 15.00, '2024-06-02 04:08:37', '2024-06-02 04:08:37', NULL),
(23, 25, 14.00, '2024-06-02 18:47:52', '2024-06-02 18:47:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_articulos`
--

CREATE TABLE `orden_articulos` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `orden_articulos`
--

INSERT INTO `orden_articulos` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(22, 20, 26, 1),
(23, 21, 22, 1),
(24, 22, 27, 3),
(25, 23, 26, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `PASSWORD` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `NOMBRE`, `PASSWORD`, `EMAIL`) VALUES
(1, 'joaquin', '123', 'joaquin@gmail.com'),
(2, 'roy', '123', 'roy@gmail.com'),
(3, 'daniel', '123', 'daniel@gmail.com'),
(4, 'fabri', '123', 'fabri@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mis_productos`
--
ALTER TABLE `mis_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indices de la tabla `orden_articulos`
--
ALTER TABLE `orden_articulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `mis_productos`
--
ALTER TABLE `mis_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `orden_articulos`
--
ALTER TABLE `orden_articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `orden_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `orden_articulos`
--
ALTER TABLE `orden_articulos`
  ADD CONSTRAINT `orden_articulos_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orden` (`id`),
  ADD CONSTRAINT `orden_articulos_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `mis_productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
