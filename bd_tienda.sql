-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2020 a las 10:18:04
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritoclientes`
--

CREATE TABLE `carritoclientes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `total` float NOT NULL,
  `iva` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `carritoclientes`
--

INSERT INTO `carritoclientes` (`id`, `id_usuario`, `total`, `iva`) VALUES
(6, 15, 0, 0),
(12, 1, 112265, 17962.4),
(14, 14, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'sillas'),
(4, 'jardines'),
(6, 'sillones'),
(7, 'camas'),
(8, 'dormitorios'),
(12, 'indefinido'),
(14, 'cocina'),
(15, 'mesas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `rfc` varchar(15) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `edad` int(3) NOT NULL,
  `salario` int(7) NOT NULL,
  `sexo` tinyint(1) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `id_usuario`, `rfc`, `nombres`, `apellidos`, `edad`, `salario`, `sexo`, `foto`) VALUES
(1, 8, 'CUPU800825569', 'cliente', 'clientekek', 22, 10000, 0, '1588747468cliente310bdf01-s.jpg'),
(7, 14, 'CUPU900925569', 'cliente8', 'cliente7arr', 44, 34000, 0, '1588891801cliente8310bdf01-s.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `comentario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `id_producto`, `id_usuario`, `comentario`) VALUES
(1, 1, 14, '1589450863141comentario.txt'),
(2, 1, 1, '158961827211comentario.txt'),
(3, 1, 1, '158961848611comentario.txt'),
(4, 1, 1, '158961856811comentario.txt');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deudas`
--

CREATE TABLE `deudas` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `meses` int(11) NOT NULL,
  `meses_pagados` int(11) NOT NULL,
  `abono` int(11) NOT NULL,
  `deuda_actual` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `deudas`
--

INSERT INTO `deudas` (`id`, `id_venta`, `meses`, `meses_pagados`, `abono`, `deuda_actual`, `estado`) VALUES
(1, 18, 0, 0, 21524, 21524, 2),
(2, 19, 0, 0, 39568, 39568, 2),
(3, 20, 0, 0, 42236, 42236, 2),
(4, 21, 0, 0, 4872, 4872, 2),
(5, 22, 0, 0, 20132, 20132, 2),
(6, 24, 0, 0, 18044, 18044, 2),
(7, 25, 18, 18, 464, 464, 2),
(8, 26, 0, 0, 1624, 1624, 2),
(9, 28, 0, 0, 3248, 3248, 2),
(11, 31, 0, 0, 2274, 2274, 2),
(12, 33, 24, 4, 18664, 111975, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `domicilioclientes`
--

CREATE TABLE `domicilioclientes` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `calle_colonia` varchar(255) NOT NULL,
  `cp` int(6) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `domicilioclientes`
--

INSERT INTO `domicilioclientes` (`id`, `id_cliente`, `calle_colonia`, `cp`, `ciudad`, `estado`) VALUES
(2, 7, 'una calle una colonia', 23000, 'chilpancingo', 'guerrero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `domicilios`
--

CREATE TABLE `domicilios` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `calle_colonia` varchar(255) NOT NULL,
  `cp` int(6) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `domicilios`
--

INSERT INTO `domicilios` (`id`, `id_venta`, `calle_colonia`, `cp`, `ciudad`, `estado`) VALUES
(5, 18, 'por el centro #9000', 39999, 'oaxaca', 'oaxaca'),
(6, 19, 'una calle una colonia', 39000, 'chilpancingo', 'guerrero'),
(7, 20, 'por el centro #9000', 39999, 'oaxaca', 'oaxaca'),
(8, 21, 'aca', 10000, 'chilpancingo', 'guerrero'),
(9, 22, 'una calle una colonia', 23000, 'chilpancingo', 'guerrero'),
(11, 24, 'una calle una colonia', 23000, 'chilpancingo', 'guerrero'),
(12, 25, 'una calle una colonia', 23000, 'chilpancingo', 'guerrero'),
(13, 26, 'por el centro #9000', 39999, 'oaxaca', 'oaxaca'),
(17, 28, 'por el centro #9000', 39999, 'oaxaca', 'oaxaca'),
(18, 31, 'por el centro #9000', 39999, 'oaxaca', 'oaxaca'),
(20, 33, 'una calle una colonia', 23000, 'chilpancingo', 'guerrero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `unidades` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `precio` float NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `unidades`, `id_categoria`, `precio`, `imagen`, `descripcion`, `estado`) VALUES
(1, 'silla comun', 81, 1, 400, 'predeterminado.jpg', 'es un silla, sirve para sentarse', 0),
(2, 'mesa cuadrada', 38, 15, 15555, '1589357947mesa cuadradaiconpencil.png', 'es una mesita de madera cuadrada con foto de lapiz', 0),
(3, 'maseta', 106, 4, 140, '1589438852masetamaseta.jpg', 'es una maceta de barro muy bien hecha', 0),
(4, 'cama individual', 45, 8, 2800, '1589438921cama individualcama.jpg', 'es una cama individual muy comoda', 0),
(5, 'sillon negro de piel sintetica', 23, 6, 2300, '1589438960sillon negro de piel sinteticasillon.jpg', 'es una sillon de color negro de piel sintetica para 3 personas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productoventas`
--

CREATE TABLE `productoventas` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productoventas`
--

INSERT INTO `productoventas` (`id`, `id_venta`, `id_producto`, `cantidad`, `total`) VALUES
(4, 18, 1, 4, 1600),
(5, 18, 2, 1, 15555),
(6, 18, 3, 10, 1400),
(7, 19, 1, 4, 1600),
(8, 19, 2, 1, 15555),
(9, 19, 3, 10, 1400),
(10, 19, 2, 1, 15555),
(11, 20, 1, 4, 1600),
(12, 20, 2, 1, 15555),
(13, 20, 3, 10, 1400),
(14, 20, 2, 1, 15555),
(15, 20, 5, 1, 2300),
(16, 21, 1, 7, 2800),
(17, 21, 3, 10, 1400),
(18, 22, 1, 1, 400),
(19, 22, 3, 10, 1400),
(20, 22, 2, 1, 15555),
(21, 23, 1, 1, 400),
(22, 23, 2, 1, 15555),
(23, 23, 4, 1, 2800),
(24, 23, 5, 1, 2300),
(25, 24, 2, 1, 15555),
(26, 25, 1, 1, 400),
(27, 26, 3, 10, 1400),
(28, 26, 3, 10, 1400),
(29, 28, 3, 20, 2800),
(30, 28, 3, 20, 2800),
(31, 28, 3, 20, 2800),
(32, 31, 3, 14, 1960),
(33, 32, 1, 10, 4000),
(34, 33, 1, 8, 3200),
(35, 33, 2, 6, 93330);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'administrador'),
(2, 'empleado'),
(3, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_user`
--

CREATE TABLE `role_user` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`) VALUES
(1, 1),
(3, 12),
(3, 14),
(2, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id` int(11) NOT NULL,
  `calle_colonia` varchar(255) NOT NULL,
  `cp` int(6) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `calle_colonia`, `cp`, `ciudad`, `estado`) VALUES
(4, 'por el centro #9000', 39999, 'oaxaca', 'oaxaca');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiendacarritos`
--

CREATE TABLE `tiendacarritos` (
  `id` int(11) NOT NULL,
  `id_carrito` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `costo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tiendacarritos`
--

INSERT INTO `tiendacarritos` (`id`, `id_carrito`, `id_producto`, `cantidad`, `costo`) VALUES
(40, 12, 1, 6, 2400),
(41, 12, 2, 7, 108885),
(42, 12, 3, 7, 980);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$10$HbqMGSAjpIMJY2/ZvoGz/.iplvZiZ4hMk.cUkknvTOUGcaKgta2MK'),
(14, 'cliente8', 'cliente7@gmail.com', NULL, '$2y$10$4KwezngCiV6rgLK9IkUyAeMjZ07xIrtbBP8C/Zccer1GrTghX4Mrq'),
(15, 'pedrito', 'empleado2@gmail.com', NULL, '$2y$10$d7c1xQFeORJQ4ph1.M7yQul.xTE0Vtfl4Jp6Iz5HakyRFuuYFSnCa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventaclientes`
--

CREATE TABLE `ventaclientes` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventaclientes`
--

INSERT INTO `ventaclientes` (`id`, `id_cliente`, `id_venta`) VALUES
(1, 7, 22),
(3, 7, 24),
(4, 7, 25),
(5, 7, 33);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `importe` int(11) NOT NULL,
  `iva` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `entrega` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `importe`, `iva`, `total`, `fecha`, `hora`, `entrega`) VALUES
(18, 18555, 2969, 21524, '2020-05-16', '23:49:00', 3),
(19, 34110, 5458, 39568, '2020-05-16', '23:57:00', 2),
(20, 36410, 5826, 42236, '2020-05-17', '00:35:00', 2),
(21, 4200, 672, 4872, '2020-05-17', '00:37:00', 1),
(22, 17355, 2777, 20132, '2020-05-17', '02:50:00', 0),
(24, 15555, 2489, 18044, '2020-05-17', '02:54:00', 0),
(25, 400, 64, 464, '2020-05-17', '02:55:00', 0),
(26, 1400, 224, 1624, '2020-05-19', '00:59:00', 2),
(28, 2800, 448, 3248, '2020-05-19', '01:01:00', 2),
(31, 1960, 314, 2274, '2020-05-19', '01:04:00', 2),
(33, 96530, 15445, 111975, '2020-05-21', '02:31:00', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carritoclientes`
--
ALTER TABLE `carritoclientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `deudas`
--
ALTER TABLE `deudas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `domicilioclientes`
--
ALTER TABLE `domicilioclientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `domicilios`
--
ALTER TABLE `domicilios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productoventas`
--
ALTER TABLE `productoventas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiendacarritos`
--
ALTER TABLE `tiendacarritos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `ventaclientes`
--
ALTER TABLE `ventaclientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carritoclientes`
--
ALTER TABLE `carritoclientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `deudas`
--
ALTER TABLE `deudas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `domicilioclientes`
--
ALTER TABLE `domicilioclientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `domicilios`
--
ALTER TABLE `domicilios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productoventas`
--
ALTER TABLE `productoventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tiendacarritos`
--
ALTER TABLE `tiendacarritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `ventaclientes`
--
ALTER TABLE `ventaclientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
