-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-07-2024 a las 04:27:37
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
(25, 'roy', 'silva22', 'paulsilvaquesquen24@gmail.com', '2024-06-02 18:47:49', '2024-06-02 18:47:49', 'activo'),
(26, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-03 02:01:22', '2024-06-03 02:01:22', 'activo'),
(27, 'roy', 'silva22', 'paulsilvaquesquen24@gmail.com', '2024-06-03 02:12:54', '2024-06-03 02:12:54', 'activo'),
(28, 'roy', 'silva22', 'paulsilvaquesquen24@gmail.com', '2024-06-03 02:16:23', '2024-06-03 02:16:23', 'activo'),
(29, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-03 02:38:15', '2024-06-03 02:38:15', 'activo'),
(30, 'carlos', 'garcia', 'carlosgarcia10@gmail.com', '2024-06-05 19:20:24', '2024-06-05 19:20:24', 'activo'),
(31, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-05 20:11:14', '2024-06-05 20:11:14', 'activo'),
(32, 'Daniel', 'Alcántara Contreras', 'dan.iel1929@hotmail.com', '2024-06-14 05:19:42', '2024-06-14 05:19:42', 'activo'),
(33, 'Joaquin', 'Tumba', 'joaquintumba010@gmail.com', '2024-06-14 15:14:37', '2024-06-14 15:14:37', 'activo'),
(34, 'Roy ', 'Dibujito', 'roydibujito@gmail.com', '2024-06-14 15:17:38', '2024-06-14 15:17:38', 'activo'),
(35, 'Roy ', 'Dibujito', 'roydibujito@gmail.com', '2024-06-14 15:19:54', '2024-06-14 15:19:54', 'activo'),
(36, 'Roy ', 'Dibujito', 'roydibujito@gmail.com', '2024-06-14 15:20:39', '2024-06-14 15:20:39', 'activo'),
(37, 'Roy ', 'Dibujito', 'roydibujito@gmail.com', '2024-06-14 15:20:55', '2024-06-14 15:20:55', 'activo'),
(38, 'Joaquin', 'Tumba', 'joaquintumba010@gmail.com', '2024-06-18 17:15:02', '2024-06-18 17:15:02', 'activo'),
(39, 'Miguel', 'Angel', 'miguelangel@gmail.com', '2024-06-18 18:14:24', '2024-06-18 18:14:24', 'activo'),
(40, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-19 01:50:47', '2024-06-19 01:50:47', 'activo'),
(41, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-19 02:06:39', '2024-06-19 02:06:39', 'activo'),
(42, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-19 18:33:26', '2024-06-19 18:33:26', 'activo'),
(43, 'juanito', 'Alcachofa', 'paulsilvaquesquen24@gmail.com', '2024-06-19 19:37:58', '2024-06-19 19:37:58', 'activo'),
(44, 'roy ', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-19 20:28:30', '2024-06-19 20:28:30', 'activo'),
(45, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-28 20:57:02', '2024-06-28 20:57:02', 'activo'),
(46, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-28 20:58:02', '2024-06-28 20:58:02', 'activo'),
(47, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-28 21:00:33', '2024-06-28 21:00:33', 'activo'),
(48, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-28 21:03:12', '2024-06-28 21:03:12', 'activo'),
(49, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-28 21:13:33', '2024-06-28 21:13:33', 'activo'),
(50, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-28 21:15:54', '2024-06-28 21:15:54', 'activo'),
(51, 'roy ', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-28 21:24:27', '2024-06-28 21:24:27', 'activo'),
(52, 'roy ', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-06-28 21:26:56', '2024-06-28 21:26:56', 'activo'),
(53, 'Daniel', 'Alcántara Contreras', 'dan.iel1929@hotmail.com', '2024-07-10 02:52:46', '2024-07-10 02:52:46', 'activo'),
(54, 'asd', 'asd', 'cuentaUNI2021@hotmail.com', '2024-07-10 02:58:57', '2024-07-10 02:58:57', 'activo'),
(55, 'sdf', 'sdf', 'DanielAlcantara20104@hotmail.com', '2024-07-10 04:39:12', '2024-07-10 04:39:12', 'activo'),
(56, 'sdf', 'sdf', 'dan.iel1929@hotmail.com', '2024-07-10 04:47:55', '2024-07-10 04:47:55', 'activo'),
(57, 'Taco', 'sdf', 'dan.iel1929@hotmail.com', '2024-07-10 04:49:59', '2024-07-10 04:49:59', 'activo'),
(58, 'Taco', 'sdf', 'cuentaUNI2021@hotmail.com', '2024-07-10 04:57:55', '2024-07-10 04:57:55', 'activo'),
(59, 'Taco', 'rwer', 'benja@gmail.com', '2024-07-10 04:59:04', '2024-07-10 04:59:04', 'activo'),
(60, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-18 03:27:35', '2024-07-18 03:27:35', 'activo'),
(61, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-18 03:32:07', '2024-07-18 03:32:07', 'activo'),
(62, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-18 03:33:46', '2024-07-18 03:33:46', 'activo'),
(63, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-18 03:51:02', '2024-07-18 03:51:02', 'activo'),
(64, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-18 22:50:53', '2024-07-18 22:50:53', 'activo'),
(65, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-18 22:54:23', '2024-07-18 22:54:23', 'activo'),
(66, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-18 22:59:27', '2024-07-18 22:59:27', 'activo'),
(67, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-18 23:04:10', '2024-07-18 23:04:10', 'activo'),
(68, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-18 23:10:07', '2024-07-18 23:10:07', 'activo'),
(69, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-18 23:27:19', '2024-07-18 23:27:19', 'activo'),
(70, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-18 23:41:26', '2024-07-18 23:41:26', 'activo'),
(71, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-18 23:51:54', '2024-07-18 23:51:54', 'activo'),
(72, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:07:13', '2024-07-19 00:07:13', 'activo'),
(73, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:07:19', '2024-07-19 00:07:19', 'activo'),
(74, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:07:26', '2024-07-19 00:07:26', 'activo'),
(75, '', '', '', '2024-07-19 00:07:43', '2024-07-19 00:07:43', 'activo'),
(76, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:07:56', '2024-07-19 00:07:56', 'activo'),
(77, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:08:03', '2024-07-19 00:08:03', 'activo'),
(78, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:08:12', '2024-07-19 00:08:12', 'activo'),
(79, 'joaquin ', 'tumba', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:15:48', '2024-07-19 00:15:48', 'activo'),
(80, 'joaquin ', 'tumba', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:23:49', '2024-07-19 00:23:49', 'activo'),
(81, 'joaquin ', 'tumba', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:24:25', '2024-07-19 00:24:25', 'activo'),
(82, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:27:51', '2024-07-19 00:27:51', 'activo'),
(83, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:35:16', '2024-07-19 00:35:16', 'activo'),
(84, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:35:38', '2024-07-19 00:35:38', 'activo'),
(85, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:37:55', '2024-07-19 00:37:55', 'activo'),
(86, 'roy', 'tumba', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:41:58', '2024-07-19 00:41:58', 'activo'),
(87, 'roy', 'silva', 'paulsilvaquesquen24@gmail.com', '2024-07-19 00:45:48', '2024-07-19 00:45:48', 'activo'),
(88, 'Joaquin', 'Tumba', 'joaquintumba010@icloud.com', '2024-07-19 00:59:25', '2024-07-19 00:59:25', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_tarjeta`
--

CREATE TABLE `detalles_tarjeta` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `card_number` varchar(20) DEFAULT NULL,
  `card_expiry` varchar(7) DEFAULT NULL,
  `card_cvc` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalles_tarjeta`
--

INSERT INTO `detalles_tarjeta` (`id`, `customer_id`, `payment_method`, `card_number`, `card_expiry`, `card_cvc`) VALUES
(1, 72, 'BCP', NULL, NULL, NULL),
(2, 73, 'Interbank', NULL, NULL, NULL),
(3, 74, 'BCP', NULL, NULL, NULL),
(5, 76, 'BCP', NULL, NULL, NULL),
(6, 77, 'BCP', NULL, NULL, NULL),
(7, 78, 'Interbank', NULL, NULL, NULL),
(8, 79, 'BCP', NULL, NULL, NULL),
(9, 86, 'BCP', NULL, NULL, NULL),
(10, 87, 'BCP', NULL, NULL, NULL),
(11, 88, 'BCP', NULL, NULL, NULL);

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
  `categoria` varchar(50) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mis_productos`
--

INSERT INTO `mis_productos` (`id`, `name`, `description`, `price`, `created`, `modified`, `status`, `image`, `categoria`, `usuario_id`, `cantidad`) VALUES
(51, 'Alitas de pollo', 'Grandes alas de pollo hechas al horno', 6.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f57494e47532e6a7067, 'Comida Rápida', NULL, 15),
(54, 'coca cola', 'bebida gasificante', 5.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f6c61746120646520636f636120636f6c612e6a7067, 'Bebida', NULL, 5),
(55, 'tarta de Franbruesa', 'con crema de chantilli', 10.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f74617274615f66616d6272756573612e6a7067, 'Postre', NULL, 3),
(56, 'pizza', 'de peperooni con pimenton y tomate extra!!!!!', 16.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f70697a7a612e6a7067, 'Comida Rápida', NULL, 9),
(58, 'Brochetas de pollo', 'Para compartir en familia ', 13.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f62726f636865746120646520706f6c6c6f2e6a7067, 'Comida Rápida', NULL, 30),
(59, 'Pastel de fresa', 'Para disfrutar en un cumpleaños', 15.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f50617374656c2e6a7067, 'Postre', NULL, 12),
(60, 'Vaso de agua', 'La mejor bebida', 2.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f676c617373736f6677617465722e6a7067, 'Bebida', NULL, 100),
(61, 'Hamburguesa', 'Una gran hamburguesa de carne ', 11.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f68616d62757267756573612e6a7067, 'Comida Rápida', NULL, 24),
(62, 'Helado ', 'Para los amantes del chocolate', 5.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f68656c61646f2e6a7067, 'Postre', NULL, 20),
(63, 'Jugo de naranja', 'Jugo con extracto de naranja, refrescante para el verano', 4.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f6f72616e67656a756963652e6a7067, 'Bebida', NULL, 20),
(64, 'Muffins', 'Suaves y deliciosos muffins ', 6.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f4d756666696e732e6a7067, 'Postre', NULL, 30),
(65, 'Limonada', 'Refrescante jugo de limon', 5.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f6c696d6f6e6164612e6a7067, 'Bebida', NULL, 40),
(66, 'Papas fritas', 'Gran porcion de papitas fritas para compartir', 7.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f7061706173667269746173706f7263696f6e2e6a7067, 'Comida Rápida', NULL, 40),
(68, 'Pollo Frito', 'Crocantes piezas de pollo frito', 14.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f706f6c6c6f667269746f6f6f2e6a7067, 'Comida Rápida', NULL, 10),
(69, 'Empanadas', 'Rellenas de queso', 5.00, NULL, NULL, NULL, 0x4d756c74696d656469612f696d6167656e65732f656d70616e616461732e6a7067, 'Comida Rápida', NULL, 10);

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
(26, 29, 3.00, '2024-06-03 02:38:16', '2024-06-03 02:38:16', NULL),
(27, 30, 4.00, '2024-06-05 19:20:27', '2024-06-05 19:20:27', NULL),
(28, 31, 17.00, '2024-06-05 20:11:21', '2024-06-05 20:11:21', NULL),
(29, 32, 3.00, '2024-06-14 05:19:48', '2024-06-14 05:19:48', NULL),
(30, 33, 13.00, '2024-06-14 15:14:39', '2024-06-14 15:14:39', NULL),
(31, 34, 13.00, '2024-06-14 15:17:40', '2024-06-14 15:17:40', NULL),
(32, 35, 6.00, '2024-06-14 15:19:56', '2024-06-14 15:19:56', NULL),
(33, 36, 14.00, '2024-06-14 15:20:40', '2024-06-14 15:20:40', NULL),
(34, 37, 4.00, '2024-06-14 15:20:56', '2024-06-14 15:20:56', NULL),
(35, 38, 3.00, '2024-06-18 17:15:04', '2024-06-18 17:15:04', NULL),
(37, 40, 6.00, '2024-06-19 01:50:49', '2024-06-19 01:50:49', NULL),
(38, 41, 7.00, '2024-06-19 02:06:41', '2024-06-19 02:06:41', NULL),
(42, 45, 8.00, '2024-06-28 20:57:04', '2024-06-28 20:57:04', NULL),
(43, 46, 49.00, '2024-06-28 20:58:04', '2024-06-28 20:58:04', NULL),
(44, 47, 24.00, '2024-06-28 21:00:34', '2024-06-28 21:00:34', NULL),
(45, 48, 30.00, '2024-06-28 21:03:13', '2024-06-28 21:03:13', NULL),
(46, 49, 24.00, '2024-06-28 21:13:35', '2024-06-28 21:13:35', NULL),
(47, 50, 12.00, '2024-06-28 21:15:55', '2024-06-28 21:15:55', NULL),
(55, 58, 15.00, '2024-07-10 04:57:55', '2024-07-10 04:57:55', NULL),
(56, 59, 65.00, '2024-07-10 04:59:04', '2024-07-10 04:59:04', NULL),
(57, 60, 5.00, '2024-07-18 03:27:36', '2024-07-18 03:27:36', NULL),
(58, 61, 5.00, '2024-07-18 03:32:08', '2024-07-18 03:32:08', NULL),
(59, 62, 16.00, '2024-07-18 03:33:47', '2024-07-18 03:33:47', NULL),
(60, 63, 10.00, '2024-07-18 03:51:15', '2024-07-18 03:51:15', NULL),
(61, 66, 20.00, '2024-07-18 22:59:29', '2024-07-18 22:59:29', NULL),
(62, 67, 21.00, '2024-07-18 23:04:11', '2024-07-18 23:04:11', NULL),
(63, 68, 6.00, '2024-07-18 23:10:09', '2024-07-18 23:10:09', NULL),
(64, 69, 11.00, '2024-07-18 23:27:20', '2024-07-18 23:27:20', NULL),
(65, 70, 16.00, '2024-07-18 23:41:34', '2024-07-18 23:41:34', NULL),
(66, 79, 32.00, '2024-07-19 00:15:49', '2024-07-19 00:15:49', NULL),
(67, 80, 5.00, '2024-07-19 00:23:50', '2024-07-19 00:23:50', NULL),
(68, 81, 16.00, '2024-07-19 00:24:26', '2024-07-19 00:24:26', NULL),
(69, 82, 5.00, '2024-07-19 00:27:52', '2024-07-19 00:27:52', NULL),
(70, 84, 10.00, '2024-07-19 00:35:39', '2024-07-19 00:35:39', NULL),
(71, 85, 5.00, '2024-07-19 00:37:56', '2024-07-19 00:37:56', NULL),
(72, 86, 5.00, '2024-07-19 00:41:59', '2024-07-19 00:41:59', NULL),
(73, 87, 5.00, '2024-07-19 00:45:49', '2024-07-19 00:45:49', NULL),
(74, 88, 33.00, '2024-07-19 00:59:27', '2024-07-19 00:59:27', NULL);

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
(54, 44, 51, 4),
(55, 45, 51, 5),
(56, 46, 51, 4),
(57, 47, 51, 2),
(67, 57, 55, 1),
(68, 58, 54, 1),
(69, 59, 56, 1),
(70, 60, 55, 2),
(71, 61, 54, 4),
(72, 62, 56, 1),
(73, 62, 54, 1),
(74, 63, 51, 1),
(75, 64, 51, 1),
(76, 64, 55, 1),
(77, 65, 56, 1),
(78, 66, 56, 1),
(79, 66, 51, 1),
(80, 66, 54, 2),
(81, 67, 54, 1),
(82, 68, 56, 1),
(83, 69, 54, 1),
(84, 70, 54, 2),
(85, 71, 54, 1),
(86, 72, 54, 1),
(87, 73, 54, 1),
(88, 74, 51, 2),
(89, 74, 54, 1),
(90, 74, 56, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tipo` enum('gaseosas','verduras','otros') NOT NULL,
  `telefono` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `email`, `password`, `tipo`, `telefono`) VALUES
(1, 'roy', 'paulsilvaquesquen24@gmail.com', '$2y$10$Kvy9zqPfwyjGW6VHDw/xvud06ZhTbialkJgwCupHlD1MQU.OZ.wxC', 'gaseosas', '908619870'),
(2, 'daniel Alcantara', 'danieltutravieso@gmail.com', '$2y$10$AtGMo/PO3FrospNgNMwB5efCsyhl02rNL5LXooUH1BQ/myN0og0qO', 'verduras', '912149659'),
(5, 'joaquin ', 'joaquin@gmail.com', '$2y$10$QCtmyE9JG9OuDyfY0CMoc.gGB.DgQFrqUQ27LzNClwAgBa0KatWiC', 'verduras', '934594682'),
(8, 'Alex Sifuentes', 'alexsifuentes@gmail.com', '$2y$10$01GvElvVENpSHvMCi76zBelM4TueQmobXGdfthgfYPQSDamGE.8fi', 'otros', '912149659'),
(9, 'joaquin', 'joaquintumba010@gmail.com', '$2y$10$RYFPiK50XRQ1q7Sp4Ptya.6DvYF/JjXC9IKDSVv3MECEKn1lLi5Bi', 'verduras', '934594682'),
(10, 'Cristiano Ronaldo', 'camellonaldo7@gmail.com', '$2y$10$sLZeWvyzVrdH1GnQELL7oOR0bISOB.1KH5Dd5K2V07H.OMlrA0Iru', 'gaseosas', '934594682'),
(11, 'Jurgen Klopp', 'kloppo@gmail.com', '$2y$10$MojE.6F3pAF2jGovD48SqueyccOZcqsGih8UgxCrl.bjw1CIuiahW', 'verduras', '123456789'),
(13, 'pepe', 'pepe@gmail.com', '$2y$10$H7s9ySDB7.r5I/fnpVrWY.Ny3Z0NC/L9KqaOim5.ChJc8Yl5hnS4m', 'gaseosas', '123456789'),
(14, 'maradona', 'maradona@gmail.com', '$2y$10$FcEimsrLtFw1Kaa.vgvvX.0sSx5ZI7aHxnHc9XJXO4VM7Uhk5Quae', 'gaseosas', '123456789'),
(16, 'roy', 'roysilvaquesquen30@gmail.com', '$2y$10$Y6SNWgdy/vTGioiIbQEdSuQmQkO.lxmV3MtA3Un4Mq/JfnzKHgojS', 'verduras', '960224046'),
(18, 'carlos ', 'carlos@gmail.com', '$2y$10$ol8PuCfBGjSg1lUlTWjU6uyKI/OSCC.OXpA1jjlK178WNUJ13TcoO', 'gaseosas', '922978571'),
(19, 'juan diego', 'juandiego@gmail.com', '$2y$10$OmWx0BW7e9EvmrjEUAVb0e6J./BcUwG2GtZ4noKeJmEd7vv1GbNW6', 'verduras', '933751463'),
(20, 'daniel', 'daniel@gmail.com', '$2y$10$o5ZjMQGjswsVmKyN6J.V.eAJXEK6uhVu2F8cnEHeKE8Deqy4S4jL2', 'gaseosas', '912149659');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `PASSWORD` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `ROL` enum('administrador','vendedor','chef') NOT NULL DEFAULT 'vendedor',
  `ACTIVO` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `NOMBRE`, `PASSWORD`, `EMAIL`, `ROL`, `ACTIVO`) VALUES
(1, 'joaquin', '123', 'joaquin@gmail.com', 'vendedor', 1),
(2, 'roy', '123', 'roy@gmail.com', 'vendedor', 1),
(3, 'daniel', '123', 'daniel@gmail.com', 'vendedor', 1),
(4, 'fabri', '123', 'fabri@gmail.com', 'vendedor', 1),
(6, 'george', '123456', 'roysilvaquesquen30@gmail.com', 'administrador', 1),
(7, 'daniel ', '1234', 'danieltutravieso88@gmail.com', 'administrador', 1),
(11, 'joaquin', '1234', 'joaquintumba010@gmail.com', 'administrador', 1),
(12, 'adrian', '123', 'adrian@gmail.com', 'vendedor', 1),
(13, 'marcos', '1234', 'marcos@gmail.com', 'vendedor', 1),
(14, 'carlos', '123', 'carlos@gmail.com', 'vendedor', 1),
(17, 'roy', '999', 'roy@gmail.com', 'administrador', 1),
(18, 'george', '123456', 'george22@gmail.com', 'vendedor', 1),
(19, 'pepe', '1234', 'hola@gmail.com', 'vendedor', 1),
(21, 'carlos ', '123456', 'carlos@gmail.com', 'vendedor', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_proveedor`
--

CREATE TABLE `ventas_proveedor` (
  `id` int(11) NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_compra` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total_general` decimal(10,2) GENERATED ALWAYS AS (`cantidad` * `precio`) STORED,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas_proveedor`
--

INSERT INTO `ventas_proveedor` (`id`, `proveedor_id`, `nombre_producto`, `precio`, `fecha_compra`, `cantidad`, `usuario_id`) VALUES
(10, 10, 'Fanta 2L ', 7.00, '2024-06-15', 30, NULL),
(11, 10, 'Pepsi 1/2 L', 9.00, '2024-06-15', 50, NULL),
(12, 14, 'Fanta 2L ', 8.00, '2024-06-18', 15, NULL),
(13, 14, 'GUARANA 1L', 4.00, '2024-06-18', 40, NULL),
(14, 9, 'Coca Cola 3L', 5.00, '2024-06-18', 10, NULL),
(17, 16, 'coca cola de 3l', 10.00, '2024-06-18', 5, NULL),
(18, 18, 'inka kola 3L', 10.00, '2024-06-19', 6, NULL),
(19, 19, 'alcachofa', 5.00, '2024-06-19', 100, NULL),
(20, 19, 'culantro', 5.00, '2024-06-19', 5, NULL),
(21, 20, 'inka cola 3l', 10.00, '2024-06-19', 6, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalles_tarjeta`
--
ALTER TABLE `detalles_tarjeta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indices de la tabla `mis_productos`
--
ALTER TABLE `mis_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_id` (`usuario_id`);

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
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `ventas_proveedor`
--
ALTER TABLE `ventas_proveedor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedor_id` (`proveedor_id`),
  ADD KEY `fk_usuario_id_ventas` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `detalles_tarjeta`
--
ALTER TABLE `detalles_tarjeta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `mis_productos`
--
ALTER TABLE `mis_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `orden_articulos`
--
ALTER TABLE `orden_articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `ventas_proveedor`
--
ALTER TABLE `ventas_proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_tarjeta`
--
ALTER TABLE `detalles_tarjeta`
  ADD CONSTRAINT `detalles_tarjeta_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `mis_productos`
--
ALTER TABLE `mis_productos`
  ADD CONSTRAINT `fk_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`ID`);

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

--
-- Filtros para la tabla `ventas_proveedor`
--
ALTER TABLE `ventas_proveedor`
  ADD CONSTRAINT `fk_usuario_id_ventas` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`ID`),
  ADD CONSTRAINT `ventas_proveedor_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
