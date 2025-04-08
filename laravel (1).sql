-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2025 a las 01:59:15
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
-- Base de datos: `laravel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `id` bigint(20) NOT NULL,
  `name` varchar(256) NOT NULL,
  `total` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`id`, `name`, `total`, `created_at`, `updated_at`) VALUES
(1, 'Fito', 57, '2025-03-26 07:01:53', NULL),
(2, 'Fito', 66, '2025-03-26 10:08:03', '2025-03-26 10:08:03'),
(3, 'Fito', 44, '2025-03-26 10:08:12', '2025-03-26 10:08:12'),
(4, 'Fito', 20000, '2025-03-27 18:05:49', '2025-03-27 18:05:49'),
(5, 'Fito', 0, '2025-04-08 23:19:26', '2025-04-08 23:19:26'),
(6, 'Fito', 100, '2025-04-09 00:29:58', '2025-04-09 00:29:58'),
(7, 'Fito', 0, '2025-04-09 00:31:24', '2025-04-09 00:31:24'),
(8, 'Fito', 0, '2025-04-09 00:38:37', '2025-04-09 00:38:37'),
(9, 'Fito', 0, '2025-04-09 00:38:42', '2025-04-09 00:38:42'),
(10, 'Fito', 10, '2025-04-09 00:53:16', '2025-04-09 00:53:16'),
(11, 'Fito', 30000, '2025-04-09 01:43:06', '2025-04-09 01:43:06'),
(12, 'Fito', 100000, '2025-04-09 02:17:39', '2025-04-09 02:17:39'),
(13, 'Fito', 127750, '2025-04-09 02:32:23', '2025-04-09 02:32:23'),
(14, 'Fito', 198500, '2025-04-09 02:33:28', '2025-04-09 02:33:28'),
(15, 'Fito', 198000, '2025-04-09 02:39:29', '2025-04-09 02:39:29'),
(16, 'Fito', 100000, '2025-04-08 23:43:02', '2025-04-09 02:39:38'),
(17, 'Fito', 190000, '2025-04-09 02:46:54', '2025-04-09 02:46:54'),
(18, 'Fito', 100000, '2025-04-09 02:47:04', '2025-04-09 02:47:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estacionamientos`
--

CREATE TABLE `estacionamientos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patente` varchar(8) NOT NULL,
  `ingreso` datetime NOT NULL,
  `salida` datetime DEFAULT NULL,
  `servicio` enum('xHora','xHoraMoto','Estadía6','Estadía12','Estadía24','Lavado13','Lavado16') NOT NULL DEFAULT 'xHora',
  `total` decimal(10,2) DEFAULT NULL,
  `mediodepago` varchar(256) DEFAULT NULL,
  `cajasid` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estacionamientos`
--

INSERT INTO `estacionamientos` (`id`, `patente`, `ingreso`, `salida`, `servicio`, `total`, `mediodepago`, `cajasid`, `created_at`, `updated_at`) VALUES
(48, '333', '2025-04-08 04:53:58', '2025-04-08 04:54:08', 'xHora', 1700.00, 'Efectivo', 17, '2025-04-08 10:53:58', '2025-04-09 02:47:04'),
(49, '343', '2025-04-08 04:54:25', '2025-04-08 04:54:32', 'xHora', 1700.00, 'MP', 17, '2025-04-08 10:54:25', '2025-04-09 02:47:04'),
(50, '343', '2025-04-08 05:03:38', '2025-04-08 05:03:42', 'xHora', 1700.00, 'Tarjeta', 17, '2025-04-08 11:03:38', '2025-04-09 02:47:04'),
(51, 'WEWE', '2025-04-08 05:25:04', '2025-04-08 19:02:50', 'xHora', 52250.00, 'Efectivo', 17, '2025-04-08 11:25:04', '2025-04-09 02:47:04'),
(52, '6456', '2025-04-08 05:28:42', '2025-04-08 15:37:04', 'xHora', 34850.00, 'MP', 17, '2025-04-08 11:28:42', '2025-04-09 02:47:04'),
(53, '666', '2025-04-08 15:33:06', '2025-04-08 16:25:46', 'xHora', 3800.00, 'Efectivo', 17, '2025-04-08 21:33:06', '2025-04-09 02:47:04'),
(54, '444', '2025-04-08 15:37:01', '2025-04-08 20:31:27', 'Estadía6', NULL, NULL, NULL, '2025-04-08 21:37:01', '2025-04-09 02:31:27'),
(55, '446', '2025-04-08 17:01:24', '2025-04-08 17:02:59', 'Lavado16', 16000.00, 'Tarjeta', 17, '2025-04-08 23:01:24', '2025-04-09 02:47:04'),
(56, '068', '2025-04-08 19:03:59', '2025-04-08 19:04:52', 'Estadía12', 20000.00, 'Efectivo', 17, '2025-04-09 01:03:59', '2025-04-09 02:47:04'),
(57, '444', '2025-04-08 19:06:14', '2025-04-08 19:06:21', 'xHora', NULL, NULL, NULL, '2025-04-09 01:06:14', '2025-04-09 01:06:21'),
(58, '555', '2025-04-08 20:31:43', '2025-04-08 20:32:03', 'xHora', 1900.00, 'Pendiente', NULL, '2025-04-09 02:31:43', '2025-04-09 02:32:08'),
(59, '685', '2025-04-08 20:47:44', NULL, 'xHora', NULL, NULL, NULL, '2025-04-09 02:47:44', '2025-04-09 02:47:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_06_160823_create_estacionamientos_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('LuqvnfrloLaM7pHRIWy1q45OuNNV7l812i93cTTA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS3kwdEU5VlFrcXpmN3UzaXljQk93c0daSjY2T3VRM1pmMFY3djRNdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTM6Imh0dHA6Ly9nYXJhZ2UiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1744156743);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estacionamientos`
--
ALTER TABLE `estacionamientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `estacionamientos`
--
ALTER TABLE `estacionamientos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
