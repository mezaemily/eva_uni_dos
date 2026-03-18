-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-03-2026 a las 04:35:32
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
-- Base de datos: `apuestas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bets`
--

CREATE TABLE `bets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `match_id` bigint(20) UNSIGNED NOT NULL,
  `odd_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `potential_win` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bets`
--

INSERT INTO `bets` (`id`, `user_id`, `match_id`, `odd_id`, `amount`, `potential_win`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 100.00, 185.00, 'pending', '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(2, 3, 1, 2, 50.00, 105.00, 'pending', '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(3, 4, 2, 4, 200.00, 380.00, 'won', '2026-03-18 05:31:52', NULL),
(4, 2, 2, 4, 75.00, 142.50, 'lost', '2026-03-18 05:31:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bet_types`
--

CREATE TABLE `bet_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `bet_types`
--

INSERT INTO `bet_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Resultado final (1X2)', '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(2, 'Handicap asiático', '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(3, 'Más/Menos goles', NULL, NULL),
(4, 'Ambos equipos marcan', NULL, NULL);

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
-- Estructura de tabla para la tabla `challenges`
--

CREATE TABLE `challenges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `creator_id` bigint(20) UNSIGNED NOT NULL,
  `opponent_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `challenges`
--

INSERT INTO `challenges` (`id`, `creator_id`, `opponent_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 'pending', '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(2, 3, 4, 'accepted', '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(3, 4, 2, 'rejected', '2026-03-18 05:31:53', NULL),
(4, 2, 4, 'completed', '2026-03-18 05:31:53', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `challenge_bets`
--

CREATE TABLE `challenge_bets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `challenge_id` bigint(20) UNSIGNED NOT NULL,
  `bet_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `challenge_bets`
--

INSERT INTO `challenge_bets` (`id`, `challenge_id`, `bet_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(2, 1, 2, '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(3, 2, 3, '2026-03-18 05:31:53', NULL),
(4, 2, 4, '2026-03-18 05:31:53', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `match_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `match_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Este partido va a estar increíble, apuesto por el Real Madrid.', '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(2, 3, 1, 'El Barça tiene mejor forma últimamente, creo que ganan ellos.', '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(3, 4, 2, 'Los Lakers están en racha, buena cuota para apostar.', '2026-03-18 05:31:53', NULL),
(4, 2, 2, 'El partido de ayer estuvo emocionante hasta el final.', '2026-03-18 05:31:53', NULL);

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
-- Estructura de tabla para la tabla `followers`
--

CREATE TABLE `followers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `follower_id` bigint(20) UNSIGNED NOT NULL,
  `following_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `followers`
--

INSERT INTO `followers` (`id`, `follower_id`, `following_id`, `created_at`, `updated_at`) VALUES
(1, 2, 3, '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(2, 3, 4, '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(3, 4, 2, '2026-03-18 05:31:53', NULL),
(4, 2, 4, '2026-03-18 05:31:53', NULL);

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
-- Estructura de tabla para la tabla `matches`
--

CREATE TABLE `matches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sport_id` bigint(20) UNSIGNED NOT NULL,
  `team_home_id` bigint(20) UNSIGNED NOT NULL,
  `team_away_id` bigint(20) UNSIGNED NOT NULL,
  `match_date` datetime NOT NULL,
  `home_score` int(11) DEFAULT NULL,
  `away_score` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'scheduled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `matches`
--

INSERT INTO `matches` (`id`, `sport_id`, `team_home_id`, `team_away_id`, `match_date`, `home_score`, `away_score`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '2026-03-20 23:31:52', NULL, NULL, 'scheduled', '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(2, 2, 3, 4, '2026-03-22 23:31:52', NULL, NULL, 'scheduled', '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(3, 1, 2, 1, '2026-03-24 23:31:52', NULL, NULL, 'scheduled', '2026-03-18 05:31:52', NULL),
(4, 2, 4, 3, '2026-03-16 23:31:52', 102, 98, 'finished', '2026-03-18 05:31:52', NULL),
(5, 1, 2, 6, '2026-03-17 11:45:00', NULL, NULL, 'scheduled', '2026-03-18 08:49:10', '2026-03-18 08:49:10');

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
(1, '0000_01_01_000000_create_users_table', 1),
(2, '0000_03_11_173847_create_sports_table', 1),
(3, '0001_03_11_173848_create_teams_table', 1),
(4, '0002_03_11_173848_create_matches_table', 1),
(5, '0003_03_11_173849_create_bet_types_table', 1),
(6, '0004_03_11_173849_create_odds_table', 1),
(7, '0005_03_11_173850_create_bets_table', 1),
(8, '0006_03_11_173850_create_transactions_table', 1),
(9, '0007_03_11_173851_create_comments_table', 1),
(10, '0008_03_11_173851_create_followers_table', 1),
(11, '0009_03_11_173852_create_challenges_table', 1),
(12, '0010_03_11_173852_create_challenge_bets_table', 1),
(13, '0011_03_11_173853_create_mine_games_table', 1),
(14, '0012_03_11_173853_create_mine_tiles_table', 1),
(15, '0016_01_01_000001_create_cache_table', 1),
(16, '0017_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mine_games`
--

CREATE TABLE `mine_games` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bet_amount` decimal(10,2) NOT NULL,
  `mines` int(11) NOT NULL,
  `multiplier` decimal(10,2) NOT NULL,
  `winnings` decimal(10,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'playing',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mine_games`
--

INSERT INTO `mine_games` (`id`, `user_id`, `bet_amount`, `mines`, `multiplier`, `winnings`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 50.00, 5, 2.50, 125.00, 'won', '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(2, 3, 100.00, 10, 1.00, 0.00, 'lost', '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(3, 4, 75.00, 3, 1.80, 135.00, 'won', '2026-03-18 05:31:53', NULL),
(4, 2, 200.00, 8, 1.00, 0.00, 'playing', '2026-03-18 05:31:53', NULL),
(5, 4, 100.00, 3, 6.13, 0.00, 'lost', '2026-03-18 09:06:49', '2026-03-18 09:07:06'),
(6, 4, 100.00, 5, 1.96, 0.00, 'lost', '2026-03-18 09:07:43', '2026-03-18 09:07:48'),
(7, 4, 100.00, 7, 2.73, 273.00, 'won', '2026-03-18 09:07:54', '2026-03-18 09:07:59'),
(8, 4, 100.00, 8, 1.43, 0.00, 'lost', '2026-03-18 09:09:20', '2026-03-18 09:09:23'),
(9, 4, 100.00, 3, 1.10, 0.00, 'lost', '2026-03-18 09:09:28', '2026-03-18 09:09:31'),
(10, 4, 100.00, 3, 1.10, 0.00, 'lost', '2026-03-18 09:09:37', '2026-03-18 09:09:39'),
(11, 4, 100.00, 3, 1.10, 110.00, 'won', '2026-03-18 09:09:47', '2026-03-18 09:09:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mine_tiles`
--

CREATE TABLE `mine_tiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `game_id` bigint(20) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL,
  `is_mine` tinyint(1) NOT NULL,
  `revealed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mine_tiles`
--

INSERT INTO `mine_tiles` (`id`, `game_id`, `position`, `is_mine`, `revealed`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 0, 1, '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(2, 1, 7, 1, 0, '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(3, 2, 12, 1, 1, NULL, NULL),
(4, 2, 20, 0, 0, NULL, NULL),
(5, 5, 0, 0, 1, NULL, NULL),
(6, 5, 1, 0, 0, NULL, NULL),
(7, 5, 2, 0, 1, NULL, NULL),
(8, 5, 3, 0, 1, NULL, NULL),
(9, 5, 4, 0, 1, NULL, NULL),
(10, 5, 5, 1, 1, NULL, NULL),
(11, 5, 6, 0, 1, NULL, NULL),
(12, 5, 7, 0, 1, NULL, NULL),
(13, 5, 8, 0, 1, NULL, NULL),
(14, 5, 9, 0, 0, NULL, NULL),
(15, 5, 10, 0, 1, NULL, NULL),
(16, 5, 11, 0, 1, NULL, NULL),
(17, 5, 12, 0, 0, NULL, NULL),
(18, 5, 13, 1, 0, NULL, NULL),
(19, 5, 14, 0, 0, NULL, NULL),
(20, 5, 15, 0, 1, NULL, NULL),
(21, 5, 16, 0, 1, NULL, NULL),
(22, 5, 17, 0, 0, NULL, NULL),
(23, 5, 18, 0, 0, NULL, NULL),
(24, 5, 19, 1, 0, NULL, NULL),
(25, 5, 20, 0, 0, NULL, NULL),
(26, 5, 21, 0, 0, NULL, NULL),
(27, 5, 22, 0, 0, NULL, NULL),
(28, 5, 23, 0, 0, NULL, NULL),
(29, 5, 24, 0, 0, NULL, NULL),
(30, 6, 0, 0, 1, NULL, NULL),
(31, 6, 1, 0, 0, NULL, NULL),
(32, 6, 2, 0, 0, NULL, NULL),
(33, 6, 3, 0, 0, NULL, NULL),
(34, 6, 4, 0, 0, NULL, NULL),
(35, 6, 5, 0, 0, NULL, NULL),
(36, 6, 6, 0, 1, NULL, NULL),
(37, 6, 7, 0, 0, NULL, NULL),
(38, 6, 8, 0, 0, NULL, NULL),
(39, 6, 9, 0, 0, NULL, NULL),
(40, 6, 10, 0, 0, NULL, NULL),
(41, 6, 11, 0, 1, NULL, NULL),
(42, 6, 12, 1, 1, NULL, NULL),
(43, 6, 13, 0, 0, NULL, NULL),
(44, 6, 14, 0, 0, NULL, NULL),
(45, 6, 15, 0, 0, NULL, NULL),
(46, 6, 16, 1, 0, NULL, NULL),
(47, 6, 17, 0, 0, NULL, NULL),
(48, 6, 18, 0, 0, NULL, NULL),
(49, 6, 19, 0, 0, NULL, NULL),
(50, 6, 20, 1, 0, NULL, NULL),
(51, 6, 21, 1, 0, NULL, NULL),
(52, 6, 22, 0, 0, NULL, NULL),
(53, 6, 23, 0, 0, NULL, NULL),
(54, 6, 24, 1, 0, NULL, NULL),
(55, 7, 0, 0, 1, NULL, NULL),
(56, 7, 1, 1, 0, NULL, NULL),
(57, 7, 2, 0, 0, NULL, NULL),
(58, 7, 3, 0, 1, NULL, NULL),
(59, 7, 4, 0, 0, NULL, NULL),
(60, 7, 5, 1, 0, NULL, NULL),
(61, 7, 6, 0, 0, NULL, NULL),
(62, 7, 7, 0, 0, NULL, NULL),
(63, 7, 8, 1, 0, NULL, NULL),
(64, 7, 9, 0, 0, NULL, NULL),
(65, 7, 10, 0, 1, NULL, NULL),
(66, 7, 11, 0, 0, NULL, NULL),
(67, 7, 12, 0, 0, NULL, NULL),
(68, 7, 13, 0, 0, NULL, NULL),
(69, 7, 14, 0, 0, NULL, NULL),
(70, 7, 15, 0, 0, NULL, NULL),
(71, 7, 16, 0, 0, NULL, NULL),
(72, 7, 17, 1, 0, NULL, NULL),
(73, 7, 18, 0, 0, NULL, NULL),
(74, 7, 19, 0, 0, NULL, NULL),
(75, 7, 20, 1, 0, NULL, NULL),
(76, 7, 21, 0, 0, NULL, NULL),
(77, 7, 22, 1, 0, NULL, NULL),
(78, 7, 23, 0, 0, NULL, NULL),
(79, 7, 24, 1, 0, NULL, NULL),
(80, 8, 0, 0, 1, NULL, NULL),
(81, 8, 1, 1, 1, NULL, NULL),
(82, 8, 2, 0, 0, NULL, NULL),
(83, 8, 3, 1, 0, NULL, NULL),
(84, 8, 4, 0, 0, NULL, NULL),
(85, 8, 5, 0, 0, NULL, NULL),
(86, 8, 6, 0, 0, NULL, NULL),
(87, 8, 7, 1, 0, NULL, NULL),
(88, 8, 8, 0, 0, NULL, NULL),
(89, 8, 9, 0, 0, NULL, NULL),
(90, 8, 10, 1, 0, NULL, NULL),
(91, 8, 11, 0, 0, NULL, NULL),
(92, 8, 12, 0, 0, NULL, NULL),
(93, 8, 13, 0, 0, NULL, NULL),
(94, 8, 14, 0, 0, NULL, NULL),
(95, 8, 15, 0, 0, NULL, NULL),
(96, 8, 16, 0, 0, NULL, NULL),
(97, 8, 17, 1, 0, NULL, NULL),
(98, 8, 18, 0, 0, NULL, NULL),
(99, 8, 19, 0, 0, NULL, NULL),
(100, 8, 20, 0, 0, NULL, NULL),
(101, 8, 21, 1, 0, NULL, NULL),
(102, 8, 22, 1, 0, NULL, NULL),
(103, 8, 23, 0, 0, NULL, NULL),
(104, 8, 24, 1, 0, NULL, NULL),
(105, 9, 0, 0, 0, NULL, NULL),
(106, 9, 1, 0, 0, NULL, NULL),
(107, 9, 2, 0, 0, NULL, NULL),
(108, 9, 3, 0, 0, NULL, NULL),
(109, 9, 4, 0, 0, NULL, NULL),
(110, 9, 5, 0, 1, NULL, NULL),
(111, 9, 6, 0, 0, NULL, NULL),
(112, 9, 7, 0, 0, NULL, NULL),
(113, 9, 8, 0, 0, NULL, NULL),
(114, 9, 9, 0, 0, NULL, NULL),
(115, 9, 10, 0, 0, NULL, NULL),
(116, 9, 11, 0, 0, NULL, NULL),
(117, 9, 12, 0, 0, NULL, NULL),
(118, 9, 13, 0, 0, NULL, NULL),
(119, 9, 14, 0, 0, NULL, NULL),
(120, 9, 15, 0, 0, NULL, NULL),
(121, 9, 16, 1, 1, NULL, NULL),
(122, 9, 17, 0, 0, NULL, NULL),
(123, 9, 18, 0, 0, NULL, NULL),
(124, 9, 19, 0, 0, NULL, NULL),
(125, 9, 20, 0, 0, NULL, NULL),
(126, 9, 21, 1, 0, NULL, NULL),
(127, 9, 22, 0, 0, NULL, NULL),
(128, 9, 23, 0, 0, NULL, NULL),
(129, 9, 24, 1, 0, NULL, NULL),
(130, 10, 0, 1, 0, NULL, NULL),
(131, 10, 1, 0, 0, NULL, NULL),
(132, 10, 2, 0, 0, NULL, NULL),
(133, 10, 3, 0, 0, NULL, NULL),
(134, 10, 4, 0, 0, NULL, NULL),
(135, 10, 5, 0, 1, NULL, NULL),
(136, 10, 6, 1, 1, NULL, NULL),
(137, 10, 7, 0, 0, NULL, NULL),
(138, 10, 8, 0, 0, NULL, NULL),
(139, 10, 9, 0, 0, NULL, NULL),
(140, 10, 10, 0, 0, NULL, NULL),
(141, 10, 11, 0, 0, NULL, NULL),
(142, 10, 12, 0, 0, NULL, NULL),
(143, 10, 13, 0, 0, NULL, NULL),
(144, 10, 14, 0, 0, NULL, NULL),
(145, 10, 15, 0, 0, NULL, NULL),
(146, 10, 16, 0, 0, NULL, NULL),
(147, 10, 17, 0, 0, NULL, NULL),
(148, 10, 18, 1, 0, NULL, NULL),
(149, 10, 19, 0, 0, NULL, NULL),
(150, 10, 20, 0, 0, NULL, NULL),
(151, 10, 21, 0, 0, NULL, NULL),
(152, 10, 22, 0, 0, NULL, NULL),
(153, 10, 23, 0, 0, NULL, NULL),
(154, 10, 24, 0, 0, NULL, NULL),
(155, 11, 0, 0, 0, NULL, NULL),
(156, 11, 1, 1, 0, NULL, NULL),
(157, 11, 2, 0, 0, NULL, NULL),
(158, 11, 3, 1, 0, NULL, NULL),
(159, 11, 4, 0, 0, NULL, NULL),
(160, 11, 5, 0, 1, NULL, NULL),
(161, 11, 6, 0, 0, NULL, NULL),
(162, 11, 7, 0, 0, NULL, NULL),
(163, 11, 8, 0, 0, NULL, NULL),
(164, 11, 9, 0, 0, NULL, NULL),
(165, 11, 10, 0, 0, NULL, NULL),
(166, 11, 11, 1, 0, NULL, NULL),
(167, 11, 12, 0, 0, NULL, NULL),
(168, 11, 13, 0, 0, NULL, NULL),
(169, 11, 14, 0, 0, NULL, NULL),
(170, 11, 15, 0, 0, NULL, NULL),
(171, 11, 16, 0, 0, NULL, NULL),
(172, 11, 17, 0, 0, NULL, NULL),
(173, 11, 18, 0, 0, NULL, NULL),
(174, 11, 19, 0, 0, NULL, NULL),
(175, 11, 20, 0, 0, NULL, NULL),
(176, 11, 21, 0, 0, NULL, NULL),
(177, 11, 22, 0, 0, NULL, NULL),
(178, 11, 23, 0, 0, NULL, NULL),
(179, 11, 24, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `odds`
--

CREATE TABLE `odds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `match_id` bigint(20) UNSIGNED NOT NULL,
  `bet_type_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `odd_value` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `odds`
--

INSERT INTO `odds` (`id`, `match_id`, `bet_type_id`, `option_name`, `odd_value`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Real Madrid gana', 1.85, '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(2, 1, 1, 'FC Barcelona gana', 2.10, '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(3, 1, 1, 'Empate', 3.40, '2026-03-18 05:31:52', NULL),
(4, 2, 3, 'Más de 200.5 puntos', 1.90, '2026-03-18 05:31:52', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sports`
--

CREATE TABLE `sports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sports`
--

INSERT INTO `sports` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Fútbol', '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(2, 'Basquetbol', '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(3, 'Tenis', '2026-03-18 05:31:52', NULL),
(4, 'Béisbol', '2026-03-18 05:31:52', NULL),
(5, 'Boxeo', '2026-03-18 08:46:29', '2026-03-18 08:46:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sport_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `strength` int(11) NOT NULL DEFAULT 50,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `teams`
--

INSERT INTO `teams` (`id`, `sport_id`, `name`, `strength`, `created_at`, `updated_at`) VALUES
(1, 1, 'Real Madrid', 90, '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(2, 1, 'FC Barcelona', 88, '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(3, 2, 'LA Lakers', 85, '2026-03-18 05:31:52', NULL),
(4, 2, 'Chicago Bulls', 80, '2026-03-18 05:31:52', NULL),
(5, 5, 'Canelo Alvarez', 50, '2026-03-18 08:47:05', '2026-03-18 08:47:05'),
(6, 1, 'Newcastle United', 50, '2026-03-18 08:48:07', '2026-03-18 08:48:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `type`, `amount`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 'deposit', 1000.00, 'Depósito inicial de bienvenida', '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(2, 3, 'deposit', 750.00, 'Recarga de saldo', '2026-03-18 05:31:53', '2026-03-18 05:31:53'),
(3, 4, 'withdrawal', 300.00, 'Retiro a cuenta bancaria', '2026-03-18 05:31:53', NULL),
(4, 2, 'bet_win', 380.00, 'Ganancia por apuesta #3', '2026-03-18 05:31:53', NULL),
(5, 4, 'bet', 100.00, 'Apuesta Mines partida #5', '2026-03-18 09:06:49', '2026-03-18 09:06:49'),
(6, 4, 'bet', 100.00, 'Apuesta Mines partida #6', '2026-03-18 09:07:43', '2026-03-18 09:07:43'),
(7, 4, 'bet', 100.00, 'Apuesta Mines partida #7', '2026-03-18 09:07:54', '2026-03-18 09:07:54'),
(8, 4, 'bet_win', 273.00, 'Ganancia Mines partida #7 x2.73', '2026-03-18 09:07:59', '2026-03-18 09:07:59'),
(9, 4, 'bet', 100.00, 'Apuesta Mines partida #8', '2026-03-18 09:09:20', '2026-03-18 09:09:20'),
(10, 4, 'bet', 100.00, 'Apuesta Mines partida #9', '2026-03-18 09:09:28', '2026-03-18 09:09:28'),
(11, 4, 'bet', 100.00, 'Apuesta Mines partida #10', '2026-03-18 09:09:37', '2026-03-18 09:09:37'),
(12, 4, 'bet', 100.00, 'Apuesta Mines partida #11', '2026-03-18 09:09:47', '2026-03-18 09:09:47'),
(13, 4, 'bet_win', 110.00, 'Ganancia Mines partida #11 x1.1', '2026-03-18 09:09:50', '2026-03-18 09:09:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `balance`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Principal', 'admin', 'admin@apuestas.com', '$2y$12$8OpZUmBgHBkp382x.YDfeOJzXzKDr1o6nHiknyafPhkHchskvwqlW', 5000.00, 'admin', 'YYjKnXP3aCXof7l1aVSl9SeJmMsXQwvsgh4FD3h0zryLSu0GoEckVyhDJDwW', '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(2, 'Pablo ', 'pabloo', 'pablo@apuestas.com', '$2y$12$1G30aV7Q7I75ySAd.3ffN.4Sjgzznr17aVlpHPG21wOYGkeISEQZu', 1000.00, 'user', NULL, '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(3, 'Meza', 'mezai', 'meza@apuestas.com', '$2y$12$g3Lup.kfYIkiV2BnbaRjsuteHouGOtOAQ5l3tBUF39PxfPKW/aRQu', 750.00, 'user', NULL, '2026-03-18 05:31:52', '2026-03-18 05:31:52'),
(4, 'jaime p', 'jimil', 'pjaime@apuestas.com', '$2y$12$eweVCy7b9y8XCItqgf4Dleqq.2XZESb5qACuBYqZjkwcK/zSrFMia', 883.00, 'user', 'osvkhdLr2WfNMX80sLGyMDEyeiBgk0mNpH1x85HoM0BwgCRTFBJsBSs76Gjx', '2026-03-18 05:31:52', '2026-03-18 09:09:50'),
(5, 'Angel Duran', 'angel24092', 'angel240@gmail.com', '$2y$12$I1XByRDJGLzxGD8o3/7Qye7zF5PNujdc4Z/sRowbJvj9.qgky8kOW', 0.00, 'admin', NULL, '2026-03-18 05:56:32', '2026-03-18 08:46:12');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bets`
--
ALTER TABLE `bets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bets_user_id_foreign` (`user_id`),
  ADD KEY `bets_match_id_foreign` (`match_id`),
  ADD KEY `bets_odd_id_foreign` (`odd_id`);

--
-- Indices de la tabla `bet_types`
--
ALTER TABLE `bet_types`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `challenges_creator_id_foreign` (`creator_id`),
  ADD KEY `challenges_opponent_id_foreign` (`opponent_id`);

--
-- Indices de la tabla `challenge_bets`
--
ALTER TABLE `challenge_bets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `challenge_bets_challenge_id_foreign` (`challenge_id`),
  ADD KEY `challenge_bets_bet_id_foreign` (`bet_id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_match_id_foreign` (`match_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `followers_follower_id_foreign` (`follower_id`),
  ADD KEY `followers_following_id_foreign` (`following_id`);

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
-- Indices de la tabla `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matches_sport_id_foreign` (`sport_id`),
  ADD KEY `matches_team_home_id_foreign` (`team_home_id`),
  ADD KEY `matches_team_away_id_foreign` (`team_away_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mine_games`
--
ALTER TABLE `mine_games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mine_games_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `mine_tiles`
--
ALTER TABLE `mine_tiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mine_tiles_game_id_foreign` (`game_id`);

--
-- Indices de la tabla `odds`
--
ALTER TABLE `odds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `odds_match_id_foreign` (`match_id`),
  ADD KEY `odds_bet_type_id_foreign` (`bet_type_id`);

--
-- Indices de la tabla `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_sport_id_foreign` (`sport_id`);

--
-- Indices de la tabla `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bets`
--
ALTER TABLE `bets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `bet_types`
--
ALTER TABLE `bet_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `challenges`
--
ALTER TABLE `challenges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `challenge_bets`
--
ALTER TABLE `challenge_bets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `followers`
--
ALTER TABLE `followers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `matches`
--
ALTER TABLE `matches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `mine_games`
--
ALTER TABLE `mine_games`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `mine_tiles`
--
ALTER TABLE `mine_tiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT de la tabla `odds`
--
ALTER TABLE `odds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sports`
--
ALTER TABLE `sports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bets`
--
ALTER TABLE `bets`
  ADD CONSTRAINT `bets_match_id_foreign` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bets_odd_id_foreign` FOREIGN KEY (`odd_id`) REFERENCES `odds` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `challenges`
--
ALTER TABLE `challenges`
  ADD CONSTRAINT `challenges_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `challenges_opponent_id_foreign` FOREIGN KEY (`opponent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `challenge_bets`
--
ALTER TABLE `challenge_bets`
  ADD CONSTRAINT `challenge_bets_bet_id_foreign` FOREIGN KEY (`bet_id`) REFERENCES `bets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `challenge_bets_challenge_id_foreign` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_match_id_foreign` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `followers_following_id_foreign` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_sport_id_foreign` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matches_team_away_id_foreign` FOREIGN KEY (`team_away_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matches_team_home_id_foreign` FOREIGN KEY (`team_home_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mine_games`
--
ALTER TABLE `mine_games`
  ADD CONSTRAINT `mine_games_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mine_tiles`
--
ALTER TABLE `mine_tiles`
  ADD CONSTRAINT `mine_tiles_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `mine_games` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `odds`
--
ALTER TABLE `odds`
  ADD CONSTRAINT `odds_bet_type_id_foreign` FOREIGN KEY (`bet_type_id`) REFERENCES `bet_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `odds_match_id_foreign` FOREIGN KEY (`match_id`) REFERENCES `matches` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_sport_id_foreign` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
