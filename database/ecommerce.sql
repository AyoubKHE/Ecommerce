-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 06 juil. 2024 à 19:28
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_number` varchar(50) NOT NULL,
  `street_number` varchar(50) NOT NULL,
  `address_line1` varchar(100) NOT NULL,
  `address_line2` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `region` varchar(50) NOT NULL,
  `postal_code` varchar(25) NOT NULL,
  `country_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `brands`
--

INSERT INTO `brands` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`, `added_by`) VALUES
(1, 'Adidas', 'Adidas', 1, '2024-07-04 19:53:14', '2024-07-04 19:53:14', 1),
(2, 'Nike', 'Nike', 1, '2024-07-04 19:53:32', '2024-07-04 19:53:32', 1),
(3, 'Lacoste', 'Lacoste', 1, '2024-07-04 19:54:07', '2024-07-04 19:54:07', 1),
(4, 'Polo', 'Polo', 1, '2024-07-04 19:54:33', '2024-07-04 19:54:33', 1),
(5, 'Armani', 'Armani', 1, '2024-07-04 19:55:11', '2024-07-04 19:55:11', 1),
(6, 'Chanel', 'Chanel', 1, '2024-07-04 19:57:40', '2024-07-04 19:57:40', 1),
(7, 'Dior', 'Dior', 1, '2024-07-04 19:57:54', '2024-07-04 19:57:54', 1),
(8, 'Gucci', 'Gucci', 1, '2024-07-04 19:58:07', '2024-07-04 19:58:07', 1),
(9, 'Louis Vuitton', 'Louis Vuitton', 1, '2024-07-04 19:58:22', '2024-07-04 19:58:22', 1),
(10, 'Zara', 'Zara', 1, '2024-07-04 19:58:35', '2024-07-04 19:58:35', 1),
(11, 'H&M', 'H&M', 1, '2024-07-04 19:58:50', '2024-07-04 19:58:50', 1),
(12, 'Levi\'s', 'Levi\'s', 1, '2024-07-06 14:38:33', '2024-07-06 14:38:33', 1);

-- --------------------------------------------------------

--
-- Structure de la table `countries`
--

CREATE TABLE `countries` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
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
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2024_04_12_192828_create_users_table', 1),
(5, '2024_04_12_193528_create_usersPermissions_table', 1),
(6, '2024_04_12_194037_create_systemPermissions_table', 1),
(7, '2024_04_12_194137_create_usersPermissions_systemPermissions_table', 1),
(8, '2024_04_16_134808_create_countries_table', 1),
(9, '2024_04_16_142544_create_addresses_table', 1),
(10, '2024_04_16_143054_create_users_addresses_table', 1),
(11, '2024_04_18_115546_create_productsCategories_table', 1),
(12, '2024_04_19_150439_create_brands_table', 1),
(13, '2024_04_20_145433_create_products_table', 1),
(14, '2024_04_20_150156_create_productsCategories_products_table', 1),
(15, '2024_04_20_150609_create_productsImages_table', 1),
(16, '2024_06_10_101043_create_productsAttributes_table', 1),
(17, '2024_06_10_101722_create_productsAttributesOptions_table', 1),
(18, '2024_06_23_173313_create_productsVariations_table', 1),
(19, '2024_06_23_173748_create_productsVariations_options_table', 1),
(20, '2024_07_04_124120_create_preferences_of_showcase_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `preferences_of_showcase`
--

CREATE TABLE `preferences_of_showcase` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `header` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`header`)),
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`body`)),
  `footer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`footer`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `rating` tinyint(4) DEFAULT NULL,
  `price` decimal(6,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `is_active`, `rating`, `price`, `created_at`, `updated_at`, `added_by`, `brand_id`) VALUES
(2, 'TEE VINTAGE LOGO EMB - T-shirt basique', 'TEE VINTAGE LOGO EMB - T-shirt basique', 1, NULL, 2500.00, '2024-07-06 13:32:47', '2024-07-06 13:32:47', 1, 5),
(3, 'HEAVY - T-shirt basique', 'HEAVY - T-shirt basique', 1, NULL, 2500.00, '2024-07-06 13:47:53', '2024-07-06 13:47:53', 1, 1),
(4, 'FORD SHORT SLEEVE - T-shirt imprimé', 'FORD SHORT SLEEVE - T-shirt imprimé', 1, NULL, 2500.00, '2024-07-06 14:00:01', '2024-07-06 14:00:01', 1, 2),
(5, 'DYED OXFORD - Chemise', 'DYED OXFORD - Chemise', 1, NULL, 1500.00, '2024-07-06 14:07:02', '2024-07-06 14:07:02', 1, 4),
(6, 'SHORT SLEEVE OXFORD WITH STAG - Chemise', 'SHORT SLEEVE OXFORD WITH STAG - Chemise', 1, NULL, 1800.00, '2024-07-06 14:11:29', '2024-07-06 14:11:29', 1, 5),
(7, 'FLOWER RESORT - Chemise', 'FLOWER RESORT - Chemise', 1, NULL, 2000.00, '2024-07-06 14:17:07', '2024-07-06 14:17:07', 1, 4),
(8, 'ARCHED VARSITY HOODY - Sweatshirt', 'ARCHED VARSITY HOODY - Sweatshirt', 1, NULL, 3500.00, '2024-07-06 14:24:51', '2024-07-06 14:24:51', 1, 3),
(9, 'LIFESTYLE UNISEX - Sweatshirt', 'LIFESTYLE UNISEX - Sweatshirt', 1, NULL, 2500.00, '2024-07-06 14:29:52', '2024-07-06 14:29:52', 1, 9),
(10, 'Scalpers Sweatshirt', 'Scalpers Sweatshirt', 1, NULL, 2500.00, '2024-07-06 14:34:03', '2024-07-06 14:34:03', 1, 3),
(11, '512™ SLIM TAPER - Jeans fuselé', '512™ SLIM TAPER - Jeans fuselé', 1, NULL, 2500.00, '2024-07-06 14:45:18', '2024-07-06 14:45:18', 1, 12),
(12, 'TEXAS STRETCH - Jean droit', 'TEXAS STRETCH - Jean droit', 1, NULL, 2000.00, '2024-07-06 14:49:58', '2024-07-06 14:49:58', 1, 12),
(13, 'SEAHAM - Jean slim', 'SEAHAM - Jean slim', 1, NULL, 1800.00, '2024-07-06 14:54:07', '2024-07-06 14:54:07', 1, 12),
(14, 'Veste mi-saison', 'Veste mi-saison', 1, NULL, 4000.00, '2024-07-06 15:00:25', '2024-07-06 15:00:25', 1, 1),
(15, 'RUDY - Veste légère', 'RUDY - Veste légère', 1, NULL, 4500.00, '2024-07-06 15:04:27', '2024-07-06 15:04:27', 1, 5),
(16, 'CHALLENGER™ - Veste coupe-vent', 'CHALLENGER™ - Veste coupe-vent', 1, NULL, 5500.00, '2024-07-06 15:08:04', '2024-07-06 15:08:04', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `productsattributes`
--

CREATE TABLE `productsattributes` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `productsattributes`
--

INSERT INTO `productsattributes` (`id`, `name`, `description`) VALUES
(1, 'Taille', 'taille'),
(2, 'Couleurs', 'Couleurs'),
(3, 'Matière', 'Matière'),
(4, 'Taille Pantalon', 'Taille Pantalon');

-- --------------------------------------------------------

--
-- Structure de la table `productsattributesoptions`
--

CREATE TABLE `productsattributesoptions` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `value` varchar(255) NOT NULL,
  `productAttribute_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `productsattributesoptions`
--

INSERT INTO `productsattributesoptions` (`id`, `value`, `productAttribute_id`) VALUES
(1, 'xs', 1),
(2, 's', 1),
(3, 'm', 1),
(4, 'l', 1),
(5, 'xl', 1),
(6, 'blanc', 2),
(7, 'noir', 2),
(8, 'rouge', 2),
(9, 'bleu', 2),
(10, 'vert', 2),
(11, 'jaune', 2),
(12, 'marron', 2),
(13, 'couton', 3),
(14, 'laine', 3),
(15, 'soie', 3),
(16, 'cuir', 3),
(17, 'flamant', 2),
(18, '28x30', 4),
(19, '28x32', 4),
(20, '29x30', 4),
(21, '29x32', 4),
(22, '30x30', 4),
(23, '30x32', 4),
(24, '30x34', 4),
(25, '31x30', 4),
(26, '31x32', 4),
(27, '31x34', 4);

-- --------------------------------------------------------

--
-- Structure de la table `productscategories`
--

CREATE TABLE `productscategories` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `show_on_website_header` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED NOT NULL,
  `parent_id` smallint(5) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `productscategories`
--

INSERT INTO `productscategories` (`id`, `name`, `description`, `image_path`, `ordering`, `is_active`, `show_on_website_header`, `created_at`, `updated_at`, `added_by`, `parent_id`) VALUES
(1, 'Homme', 'Homme', 'products_categories/id_1/PWkORM6oxR2Y68VBzdHqJPjmu8bX2fwL8wN0HApB.jpg', NULL, 1, 1, '2024-07-05 08:21:40', '2024-07-06 10:58:25', 1, NULL),
(2, 'T-shirts homme', 'T-shirts homme', 'products_categories/id_2/poJALDbGTSKm1tGVF7mvtwacQATOxpvp0gnEjXIr.jpg', NULL, 1, 0, '2024-07-05 08:35:34', '2024-07-06 10:58:25', 1, 1),
(3, 'Chemises Homme', 'Chemises Homme', 'products_categories/id_3/OUKuAPzLr2UFkHEU7qeabNa1WQuGqPdhGwQpWK62.png', NULL, 1, 0, '2024-07-05 08:58:32', '2024-07-06 10:58:25', 1, 1),
(4, 'Sweats et hoodies homme', 'Sweats et hoodies homme', 'products_categories/id_4/qpXNmZmkMY6TcHYenXk5V9cMRk4I1fOYHQAxwaew.png', NULL, 1, 0, '2024-07-05 09:02:20', '2024-07-06 10:58:25', 1, 1),
(5, 'Jeans Homme', 'Jeans Homme', 'products_categories/id_5/BpHFixYp60meynpNcgnc44Dt44GphtTeuK8Ctsqg.png', NULL, 1, 0, '2024-07-05 09:04:22', '2024-07-06 10:58:25', 1, 1),
(6, 'Vestes Homme', 'Vestes Homme', 'products_categories/id_6/AF3Hn6qmCA0EGIw2zvwpsWqa1GiFkxVu2zgEhfdT.png', NULL, 1, 0, '2024-07-05 09:20:27', '2024-07-06 10:58:25', 1, 1),
(7, 'Vêtements de sport homme', 'Vêtements de sport homme', 'products_categories/id_7/OCVk2NuMOe3gVPoNP8mMT7FczdxddYmrAxyZrulg.png', NULL, 1, 0, '2024-07-05 09:44:28', '2024-07-06 10:58:25', 1, 1),
(8, 'Manteaux Homme', 'Manteaux Homme', 'products_categories/id_8/ouiku8hqnXjztydgp0yABELx06xPUsAv3g3nToiq.png', NULL, 1, 0, '2024-07-05 09:49:00', '2024-07-06 10:58:25', 1, 1),
(9, 'Femme', 'Femme', 'products_categories/id_9/P13Hsf86zElqW0ZEx3hNvfjnp9M7xnferzBXorwD.png', NULL, 1, 1, '2024-07-05 09:54:33', '2024-07-05 09:54:54', 1, NULL),
(10, 'Tops & T-shirts femme', 'Tops & T-shirts femme', 'products_categories/id_10/EXgKEGyTT97Wkxo95UiBLoP41FIMBwBgPljedzBi.png', NULL, 1, 0, '2024-07-05 09:58:35', '2024-07-05 09:58:35', 1, 9),
(11, 'Chemises Femme', 'Chemises Femme', 'products_categories/id_11/h6kK6YdfKH77oI0rbfzoCGC1HAOkpzp2Qg1IKMr0.png', NULL, 1, 0, '2024-07-05 10:01:53', '2024-07-05 10:01:53', 1, 9),
(12, 'Vestes femme', 'Vestes femme', 'products_categories/id_12/y4uxuDzqrQmB0kj5iU1NdKhuIGN5wysbThklQQDu.png', NULL, 1, 0, '2024-07-05 10:10:38', '2024-07-05 10:10:38', 1, 9),
(13, 'Manteaux femme', 'Manteaux femme', 'products_categories/id_13/yvFz5rtf0ch5qoQTgxVdcXWsFVL7iqXAUKrQ7GPX.png', NULL, 1, 0, '2024-07-05 10:12:55', '2024-07-05 10:12:55', 1, 9),
(14, 'Enfant', 'Enfant', 'products_categories/id_14/FWrtadqx8c3gT9TFk0LBxHg33lJ4j42g6dp9686m.png', NULL, 1, 1, '2024-07-05 10:17:34', '2024-07-05 10:17:59', 1, NULL),
(17, 'Bébé', 'Bébé', 'products_categories/id_17/vsOMHZxDxXcvjwPkoQtfYyyGdFy04KNXLF2o4Hw0.png', NULL, 1, 0, '2024-07-05 10:32:29', '2024-07-05 10:32:29', 1, 14),
(18, 'Garçon', 'Garçon', 'products_categories/id_18/50TJI3nu5xrJTpSeDgCx8oybjv2IClKqyss1ZkwH.png', NULL, 1, 0, '2024-07-05 10:34:39', '2024-07-05 10:34:39', 1, 14),
(19, 'Fille', 'Fille', 'products_categories/id_19/J4QrI3R83b9p6FAh64C1wYOEuZP1vxTjo41u59pj.png', NULL, 1, 0, '2024-07-05 10:37:30', '2024-07-05 10:37:30', 1, 14),
(20, 'Jeans Garçons', 'Jeans Garçons', 'products_categories/id_20/weqp2FYZnRWaWUqvEqw6C30pFuHOhbrD6a0mXKVV.png', NULL, 1, 0, '2024-07-05 10:40:17', '2024-07-05 10:40:17', 1, 18),
(21, 'Jeans Filles', 'Jeans Filles', 'products_categories/id_21/tvHwJMn92SWjhz9KvPrFN4VGfWIwhaYhmvi791uQ.png', NULL, 1, 0, '2024-07-05 10:40:41', '2024-07-05 10:40:41', 1, 19),
(22, 'T-shirts Garçons', 'T-shirts Garçons', 'products_categories/id_22/FzbqgDH5l0Wl2mEX0H4tLbJgZ8Sd5ZaV60Ifl3U4.png', NULL, 1, 0, '2024-07-05 10:41:27', '2024-07-05 10:41:27', 1, 18),
(23, 'Shorts Garçons', 'Shorts Garçons', 'products_categories/id_23/K5FiCLNpE4uaXfmtyhC9z1h4y8iDIq4DKN5WZ124.png', NULL, 1, 0, '2024-07-05 10:45:13', '2024-07-05 10:45:13', 1, 18),
(24, 'Chemises Garçons', 'Chemises Garçons', 'products_categories/id_24/xSeII3RRrEVdHytYEh1R8s6IPl6HhsgQcLyVH4cf.png', NULL, 1, 0, '2024-07-05 10:48:50', '2024-07-05 10:48:50', 1, 18),
(25, 'T-shirts Filles', 'T-shirts Filles', 'products_categories/id_25/HQ889rsET3IcE5iizuf2CHI4D3usr1Sd5F3HnqN6.png', NULL, 1, 0, '2024-07-05 10:51:44', '2024-07-05 10:51:44', 1, 19),
(26, 'Robes Filles', 'Robes Filles', 'products_categories/id_26/RriPNoPZCNwY9QhTuEOtF1i9BzE9x71hMCIaTTdE.png', NULL, 1, 0, '2024-07-05 10:55:36', '2024-07-05 10:55:36', 1, 19),
(27, 'Vestes Filles', 'Vestes Filles', 'products_categories/id_27/h4M2aWmNnfWd86tEqxD1I5PWlmY49Dn03uSdZl3i.png', NULL, 1, 0, '2024-07-05 10:59:08', '2024-07-05 10:59:08', 1, 19),
(28, 'Manteaux Garçons', 'Manteaux Garçons', 'products_categories/id_28/7HHObfP8F968unGiHm2LFJaYSzXK3RvO9ONrYrkz.png', NULL, 1, 0, '2024-07-05 11:00:59', '2024-07-05 11:00:59', 1, 18),
(29, 'T-shirts Bébé', 'T-shirts Bébé', 'products_categories/id_29/Mk4RD8R6juOmbGJzVYtdicxsuUzIyLo4l70WA1PV.png', NULL, 1, 0, '2024-07-05 11:06:13', '2024-07-05 11:06:13', 1, 17),
(30, 'Grenouillères bébé', 'Grenouillères bébé', 'products_categories/id_30/wr9N7m8HVT8neeG5U8wW64iALijxXhskBJHT9jTy.png', NULL, 1, 0, '2024-07-05 11:09:48', '2024-07-05 11:09:48', 1, 17),
(31, 'Chaussures Hommes', 'Chaussures Hommes', 'products_categories/id_31/Hd2J4G6cARs4P0Kf4uXWSf0QvLvrnJoAVaVYN60G.png', NULL, 1, 0, '2024-07-05 11:17:06', '2024-07-06 10:58:25', 1, 1),
(32, 'Chaussures Femmes', 'Chaussures Femmes', 'products_categories/id_32/UuKNGmW41RDMRDcO8fNcUejAC55mwxDJC5u1AOVu.png', NULL, 1, 0, '2024-07-05 11:19:44', '2024-07-05 11:19:44', 1, 9),
(33, 'Chaussures Garçons', 'Chaussures Garçons', 'products_categories/id_33/xxTCgbj63X6wqjwF0bSErJLeU22pEejTZnLoICsn.png', NULL, 1, 0, '2024-07-05 11:21:50', '2024-07-05 11:21:50', 1, 18),
(34, 'Chaussures Filles', 'Chaussures Filles', 'products_categories/id_34/sLmDNc5mxR9Sr6wk8FykBIkroUoJ4hR5pnPpRiV3.png', NULL, 1, 0, '2024-07-05 11:24:41', '2024-07-05 11:24:41', 1, 19),
(35, 'Chaussures Bébé', 'Chaussures Bébé', 'products_categories/id_35/dHzwCxMZgOv4XZ6VpTMep68uVFJ2HKJWizZ7oIlN.png', NULL, 1, 0, '2024-07-05 11:26:32', '2024-07-05 11:26:32', 1, 17);

-- --------------------------------------------------------

--
-- Structure de la table `productscategories_products`
--

CREATE TABLE `productscategories_products` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `productCategory_id` smallint(5) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `productscategories_products`
--

INSERT INTO `productscategories_products` (`product_id`, `productCategory_id`, `is_active`) VALUES
(2, 2, 1),
(3, 2, 1),
(4, 2, 1),
(5, 3, 1),
(6, 3, 1),
(7, 3, 1),
(8, 4, 1),
(9, 4, 1),
(10, 4, 1),
(11, 5, 1),
(12, 5, 1),
(13, 5, 1),
(14, 6, 1),
(15, 6, 1),
(16, 6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `productsimages`
--

CREATE TABLE `productsimages` (
  `id` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `productsimages`
--

INSERT INTO `productsimages` (`id`, `image_path`, `is_default`, `created_at`, `updated_at`, `product_id`) VALUES
(1, 'products/id_2/TDAyewkbDOgAlrc85ySTjh3AaQjKCHVHipaw3sMB.png', 1, '2024-07-06 13:32:47', '2024-07-06 13:32:47', 2),
(2, 'products/id_2/wFJfKuLp3nEsb18FF6SRUNEeAGt4SNChmLMwGDZP.png', 0, '2024-07-06 13:32:47', '2024-07-06 13:32:47', 2),
(3, 'products/id_2/MhUlwydibNsbsLlOm0CeBy6S7fG9VWJoZbm9Yaul.png', 0, '2024-07-06 13:32:47', '2024-07-06 13:32:47', 2),
(4, 'products/id_2/WcOiW43ZeJWnBYRMjOH1JbqL5mTvH6jo6JzqJa53.png', 0, '2024-07-06 13:32:49', '2024-07-06 13:32:49', 2),
(5, 'products/id_3/gBFXOuth9eWUBOzxq1xhqPvt0mtBxnyaiS6ee6wG.png', 1, '2024-07-06 13:47:53', '2024-07-06 13:47:53', 3),
(6, 'products/id_3/3hXr02WFGoYwV0nSqyBO21eZEacrnmWTe8lnVQ2M.png', 0, '2024-07-06 13:47:53', '2024-07-06 13:47:53', 3),
(7, 'products/id_3/zbsnSN9jQZFICD8NRTCXORdWkC7BPtugSzca1U91.png', 0, '2024-07-06 13:47:53', '2024-07-06 13:47:53', 3),
(8, 'products/id_3/OdQycseNkofvQm0SOkvireIx8POgjXr9BLFfRT48.png', 0, '2024-07-06 13:47:53', '2024-07-06 13:47:53', 3),
(9, 'products/id_4/yonZsTVZ4CjoUZgDKLvUkAKCC6qZPXBZnYbkti3c.png', 1, '2024-07-06 14:00:02', '2024-07-06 14:00:02', 4),
(10, 'products/id_4/m9GQZbFsUvoFRz6AnlW1MIPhPwubnGzz6xcRy6Bn.png', 0, '2024-07-06 14:00:02', '2024-07-06 14:00:02', 4),
(11, 'products/id_4/yIXgjhNtENma9rZiFFxNCg3WhrpQ47tX4Ry40Ksu.png', 0, '2024-07-06 14:00:02', '2024-07-06 14:00:02', 4),
(12, 'products/id_4/oW2xVU4M6x8lKNNyIuIO4p82khhpbnyKLudcj9Tx.png', 0, '2024-07-06 14:00:02', '2024-07-06 14:00:02', 4),
(13, 'products/id_5/A2fWBV2xQ13cI9tDVUYbihQWrVGdFbSrmNTRoYlG.png', 1, '2024-07-06 14:07:02', '2024-07-06 14:07:02', 5),
(14, 'products/id_5/FEHpeMJJmjAM2ZzN27h6GtuZgQCuzHqCxdWZAyyO.png', 0, '2024-07-06 14:07:02', '2024-07-06 14:07:02', 5),
(15, 'products/id_5/mtxidIgyKK2Ty7CdlnET1wQoRmUfIjaaYba8Vcq0.png', 0, '2024-07-06 14:07:02', '2024-07-06 14:07:02', 5),
(16, 'products/id_5/ilowSaPCBjeFTF2Thz65OHCEq8H5e7LqXGeSce9m.png', 0, '2024-07-06 14:07:02', '2024-07-06 14:07:02', 5),
(17, 'products/id_6/Ib8XFVzJdttvEu6L1R9QC32SdXRL73VNejFUIhdj.png', 1, '2024-07-06 14:11:30', '2024-07-06 14:11:30', 6),
(18, 'products/id_6/aqNPoQj3qtea0NjXDXnlUM0KOUgO5NAMovk8AVrc.png', 0, '2024-07-06 14:11:30', '2024-07-06 14:11:30', 6),
(19, 'products/id_6/KdwZXr9bI8Oyx1q6qNZag5GaNZbmF6kTA0h9vWt3.png', 0, '2024-07-06 14:11:30', '2024-07-06 14:11:30', 6),
(20, 'products/id_6/rxfT4r57Awu6idz20SYh7wUIOCIHtnv6eBD9ngBD.png', 0, '2024-07-06 14:11:30', '2024-07-06 14:11:30', 6),
(21, 'products/id_7/SzyEKhl1AshmR24kK8zyRr5EzpqXb0pfo9ShIVJi.png', 1, '2024-07-06 14:17:09', '2024-07-06 14:17:09', 7),
(22, 'products/id_7/1Pe1EOBeP55A0uCWL9LHPwDlV3XC3iNrlcpi21hz.png', 0, '2024-07-06 14:17:09', '2024-07-06 14:17:09', 7),
(23, 'products/id_7/0s1yBPgUZiutwdJFUYNvM4iFRK3wmAua8Sz4eooJ.png', 0, '2024-07-06 14:17:10', '2024-07-06 14:17:10', 7),
(24, 'products/id_7/u6auiC38NHkEpCsXC2z3ub8i5PVcfJ0pVulW7wnv.png', 0, '2024-07-06 14:17:10', '2024-07-06 14:17:10', 7),
(25, 'products/id_8/TkMwKzw0rMv0BSYAmCeNHQI40LQ2XiuFMMqB9vKG.png', 1, '2024-07-06 14:24:52', '2024-07-06 14:24:52', 8),
(26, 'products/id_8/cPB17DO72cjh55stCIFqUXSpydl1hxiQ4s9eUF3W.png', 0, '2024-07-06 14:24:52', '2024-07-06 14:24:52', 8),
(27, 'products/id_8/yUEzZPlsGldYcSTCoZU1F24vAKLNjl1mCH6vc3qe.png', 0, '2024-07-06 14:24:52', '2024-07-06 14:24:52', 8),
(28, 'products/id_8/WOUMw6sSogFLZtT1UD7nQPtBKPN3ikGpXZIhy0VG.png', 0, '2024-07-06 14:24:52', '2024-07-06 14:24:52', 8),
(29, 'products/id_9/srRpU5GqJeBmL9V0iw3B3rf4vGxBI2mMeK3BXwFf.png', 1, '2024-07-06 14:29:52', '2024-07-06 14:29:52', 9),
(30, 'products/id_9/FJhEdci7EQHyrSjeiepvWTpxQ4jfrxrx1ZpkBfgl.png', 0, '2024-07-06 14:29:52', '2024-07-06 14:29:52', 9),
(31, 'products/id_9/g5d39TbTDdVhwSDdePttE5cfUzk7ifKLyKOv5KfZ.png', 0, '2024-07-06 14:29:53', '2024-07-06 14:29:53', 9),
(32, 'products/id_9/cIb7GscnCUmeC35XLF9ovrVBd3HuaKHDvAe8HRCZ.png', 0, '2024-07-06 14:29:53', '2024-07-06 14:29:53', 9),
(33, 'products/id_10/arMLcHQXfES0uk3e2bkhnQ1p9OgcEHmG8l2egHZU.png', 1, '2024-07-06 14:34:03', '2024-07-06 14:34:03', 10),
(34, 'products/id_10/4Wn4SnMQsCyK8MywYhU8x3ZwXWY1J3gG01kPRTHQ.png', 0, '2024-07-06 14:34:03', '2024-07-06 14:34:03', 10),
(35, 'products/id_10/1nLwQyJlGtNq8eruwNhFaJfmm1iaKtpqTtby2tFi.png', 0, '2024-07-06 14:34:03', '2024-07-06 14:34:03', 10),
(36, 'products/id_10/AhidZeayzLVqkSOAesq5VFLCa0fYActRncK4qLkx.png', 0, '2024-07-06 14:34:03', '2024-07-06 14:34:03', 10),
(37, 'products/id_11/cSNtDSiTOkK6cg5SGEywjrJKFBO21jYUUwBSnk3O.png', 1, '2024-07-06 14:45:18', '2024-07-06 14:45:18', 11),
(38, 'products/id_11/yeyUpI2lHn5vKg73EvhHLscOuF7aTQLfSItZgJAZ.png', 0, '2024-07-06 14:45:18', '2024-07-06 14:45:18', 11),
(39, 'products/id_11/kxBsQD5dD9pG39XqauJAqa2FpSBN9QyZd7K1MgYG.png', 0, '2024-07-06 14:45:18', '2024-07-06 14:45:18', 11),
(40, 'products/id_11/PZmjFEUlArmtDNWWzCr7XUGrpkh3r8T6ZXmB81Vn.png', 0, '2024-07-06 14:45:18', '2024-07-06 14:45:18', 11),
(41, 'products/id_12/P6v3268tDQ0FD5PuURyQTYnPdGrHntI5cjINP551.png', 1, '2024-07-06 14:49:58', '2024-07-06 14:49:58', 12),
(42, 'products/id_12/MBgKQTUqrJzRgVbwvN5WVkQKZHZ6O2Tjzqnlz07d.png', 0, '2024-07-06 14:49:58', '2024-07-06 14:49:58', 12),
(43, 'products/id_12/l36cDlrbcSxpVbg2jzn9SXKzcTnsjbl23DhqpInw.png', 0, '2024-07-06 14:49:58', '2024-07-06 14:49:58', 12),
(44, 'products/id_12/kn8QjDkDO5AnjBwj0FozmJ9XJPVac8oyAlzQiNjf.png', 0, '2024-07-06 14:49:58', '2024-07-06 14:49:58', 12),
(45, 'products/id_13/xMswDhrpisQmtTvnnyaDYPFI2qifDCK701Se37rf.png', 1, '2024-07-06 14:54:07', '2024-07-06 14:54:07', 13),
(46, 'products/id_13/JNt6seD0Lc9y3B62mUjUHxrRDSSxjeAOyFfhwB8s.png', 0, '2024-07-06 14:54:07', '2024-07-06 14:54:07', 13),
(47, 'products/id_13/RtgCHVZRnpsGQBhu7FV1s69Je1OuiwTzRbwSVwsE.png', 0, '2024-07-06 14:54:08', '2024-07-06 14:54:08', 13),
(48, 'products/id_13/w0KN5k57JDG6s9oph1WxPhJeTzFjiSflsnrEcMup.png', 0, '2024-07-06 14:54:08', '2024-07-06 14:54:08', 13),
(49, 'products/id_14/MbHyITk27eH3GWmpSjKWf4OModsajV8tvY1JflfY.png', 1, '2024-07-06 15:00:25', '2024-07-06 15:00:25', 14),
(50, 'products/id_14/7DXK3nVe8aWgzpoRMEMYOBNayl9aWVmnPg8dra91.png', 0, '2024-07-06 15:00:25', '2024-07-06 15:00:25', 14),
(51, 'products/id_14/KH3729dbOWKpI1ZHlPXKknmqlxQRAJLMSUAXX6zn.png', 0, '2024-07-06 15:00:25', '2024-07-06 15:00:25', 14),
(52, 'products/id_14/rEtQ31GxQf8LnQ3oTQCIUF2YIizYtDzulH76oWFn.png', 0, '2024-07-06 15:00:25', '2024-07-06 15:00:25', 14),
(53, 'products/id_15/Wh5bXRGYsoZSoy44oY0ddw7LEWjtbX2AR467RoFn.png', 0, '2024-07-06 15:04:27', '2024-07-06 15:04:27', 15),
(54, 'products/id_15/VzaHoq19k3w3FhVvGuV8UMNzpOflw3OznZ8JPm5r.png', 1, '2024-07-06 15:04:28', '2024-07-06 15:04:28', 15),
(55, 'products/id_15/9AidzJXLZZk38yWFn0A4poNBbckkn6TWOgzFt3Tb.png', 0, '2024-07-06 15:04:28', '2024-07-06 15:04:28', 15),
(56, 'products/id_15/aICh9TY5eQNoAFKrhDRQyvw2In73MtX31JXJDWsH.png', 0, '2024-07-06 15:04:28', '2024-07-06 15:04:28', 15),
(57, 'products/id_16/NmeiIYyvZHn6l0EZ3Acl2AWih9q36eCUu4HuwI3N.png', 1, '2024-07-06 15:08:04', '2024-07-06 15:08:04', 16),
(58, 'products/id_16/cTrcgraZNdSK6qezkbiLtUB0TAG0Et1CN6yb2aTo.png', 0, '2024-07-06 15:08:04', '2024-07-06 15:08:04', 16),
(59, 'products/id_16/55F5hvos07JH88vQMzpvBTaEk0ClGJjyaeTZaMpJ.png', 0, '2024-07-06 15:08:04', '2024-07-06 15:08:04', 16),
(60, 'products/id_16/g8syUlzrxTdmck3D2SczzYzGkOwNTbTgxZcDvyLD.png', 0, '2024-07-06 15:08:04', '2024-07-06 15:08:04', 16);

-- --------------------------------------------------------

--
-- Structure de la table `productsvariations`
--

CREATE TABLE `productsvariations` (
  `id` int(10) UNSIGNED NOT NULL,
  `price` decimal(6,2) DEFAULT NULL,
  `quantity_in_stock` int(10) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `image_path` varchar(255) DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `productsvariations`
--

INSERT INTO `productsvariations` (`id`, `price`, `quantity_in_stock`, `is_active`, `image_path`, `product_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-06 13:32:49'),
(2, NULL, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-06 13:32:49'),
(3, NULL, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-06 13:32:49'),
(4, NULL, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-06 13:32:49'),
(5, NULL, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-06 13:32:49'),
(6, NULL, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-06 13:32:49'),
(7, NULL, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-06 13:32:49'),
(8, NULL, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-06 13:32:49'),
(9, NULL, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-06 13:32:49'),
(10, NULL, 25, 1, NULL, 3, '2024-07-06 13:47:53', '2024-07-06 13:47:53'),
(11, NULL, 25, 1, NULL, 3, '2024-07-06 13:47:53', '2024-07-06 13:47:53'),
(12, NULL, 25, 1, NULL, 3, '2024-07-06 13:47:53', '2024-07-06 13:47:53'),
(13, NULL, 25, 1, NULL, 3, '2024-07-06 13:47:54', '2024-07-06 13:47:54'),
(14, NULL, 25, 1, NULL, 3, '2024-07-06 13:47:54', '2024-07-06 13:47:54'),
(15, NULL, 25, 1, NULL, 3, '2024-07-06 13:47:54', '2024-07-06 13:47:54'),
(16, NULL, 25, 1, NULL, 3, '2024-07-06 13:47:54', '2024-07-06 13:47:54'),
(17, NULL, 25, 1, NULL, 3, '2024-07-06 13:47:54', '2024-07-06 13:47:54'),
(18, NULL, 25, 1, NULL, 3, '2024-07-06 13:47:54', '2024-07-06 13:47:54'),
(19, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(20, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(21, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(22, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(23, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(24, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(25, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(26, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(27, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(28, NULL, 35, 1, NULL, 5, '2024-07-06 14:07:02', '2024-07-06 14:07:02'),
(29, NULL, 35, 1, NULL, 5, '2024-07-06 14:07:02', '2024-07-06 14:07:02'),
(30, NULL, 35, 1, NULL, 5, '2024-07-06 14:07:02', '2024-07-06 14:07:02'),
(31, NULL, 35, 1, NULL, 5, '2024-07-06 14:07:02', '2024-07-06 14:07:02'),
(32, NULL, 35, 1, NULL, 5, '2024-07-06 14:07:02', '2024-07-06 14:07:02'),
(33, NULL, 35, 1, NULL, 5, '2024-07-06 14:07:03', '2024-07-06 14:07:03'),
(34, NULL, 35, 1, NULL, 5, '2024-07-06 14:07:03', '2024-07-06 14:07:03'),
(35, NULL, 35, 1, NULL, 5, '2024-07-06 14:07:03', '2024-07-06 14:07:03'),
(36, NULL, 35, 1, NULL, 5, '2024-07-06 14:07:03', '2024-07-06 14:07:03'),
(37, NULL, 30, 1, NULL, 6, '2024-07-06 14:11:30', '2024-07-06 14:11:30'),
(38, NULL, 30, 1, NULL, 6, '2024-07-06 14:11:30', '2024-07-06 14:11:30'),
(39, NULL, 30, 1, NULL, 6, '2024-07-06 14:11:30', '2024-07-06 14:11:30'),
(40, NULL, 30, 1, NULL, 6, '2024-07-06 14:11:30', '2024-07-06 14:11:30'),
(41, NULL, 30, 1, NULL, 6, '2024-07-06 14:11:30', '2024-07-06 14:11:30'),
(42, NULL, 30, 1, NULL, 6, '2024-07-06 14:11:30', '2024-07-06 14:11:30'),
(43, NULL, 30, 1, NULL, 6, '2024-07-06 14:11:31', '2024-07-06 14:11:31'),
(44, NULL, 30, 1, NULL, 6, '2024-07-06 14:11:31', '2024-07-06 14:11:31'),
(45, NULL, 30, 1, NULL, 6, '2024-07-06 14:11:31', '2024-07-06 14:11:31'),
(46, NULL, 15, 1, NULL, 7, '2024-07-06 14:17:10', '2024-07-06 14:17:10'),
(47, NULL, 15, 1, NULL, 7, '2024-07-06 14:17:10', '2024-07-06 14:17:10'),
(48, NULL, 15, 1, NULL, 7, '2024-07-06 14:17:10', '2024-07-06 14:17:10'),
(49, NULL, 15, 1, NULL, 7, '2024-07-06 14:17:10', '2024-07-06 14:17:10'),
(50, NULL, 15, 1, NULL, 7, '2024-07-06 14:17:10', '2024-07-06 14:17:10'),
(51, NULL, 15, 1, NULL, 7, '2024-07-06 14:17:10', '2024-07-06 14:17:10'),
(52, NULL, 15, 1, NULL, 7, '2024-07-06 14:17:10', '2024-07-06 14:17:10'),
(53, NULL, 15, 1, NULL, 7, '2024-07-06 14:17:10', '2024-07-06 14:17:10'),
(54, NULL, 15, 1, NULL, 7, '2024-07-06 14:17:10', '2024-07-06 14:17:10'),
(55, NULL, 20, 1, NULL, 8, '2024-07-06 14:24:52', '2024-07-06 14:24:52'),
(56, NULL, 20, 1, NULL, 8, '2024-07-06 14:24:52', '2024-07-06 14:24:52'),
(57, NULL, 20, 1, NULL, 8, '2024-07-06 14:24:52', '2024-07-06 14:24:52'),
(58, NULL, 20, 1, NULL, 8, '2024-07-06 14:24:52', '2024-07-06 14:24:52'),
(59, NULL, 20, 1, NULL, 8, '2024-07-06 14:24:52', '2024-07-06 14:24:52'),
(60, NULL, 20, 1, NULL, 8, '2024-07-06 14:24:52', '2024-07-06 14:24:52'),
(61, NULL, 20, 1, NULL, 8, '2024-07-06 14:24:52', '2024-07-06 14:24:52'),
(62, NULL, 20, 1, NULL, 8, '2024-07-06 14:24:52', '2024-07-06 14:24:52'),
(63, NULL, 20, 1, NULL, 8, '2024-07-06 14:24:53', '2024-07-06 14:24:53'),
(64, NULL, 25, 1, NULL, 9, '2024-07-06 14:29:53', '2024-07-06 14:29:53'),
(65, NULL, 25, 1, NULL, 9, '2024-07-06 14:29:53', '2024-07-06 14:29:53'),
(66, NULL, 25, 1, NULL, 9, '2024-07-06 14:29:53', '2024-07-06 14:29:53'),
(67, NULL, 25, 1, NULL, 9, '2024-07-06 14:29:53', '2024-07-06 14:29:53'),
(68, NULL, 25, 1, NULL, 9, '2024-07-06 14:29:53', '2024-07-06 14:29:53'),
(69, NULL, 25, 1, NULL, 9, '2024-07-06 14:29:53', '2024-07-06 14:29:53'),
(70, NULL, 25, 1, NULL, 9, '2024-07-06 14:29:53', '2024-07-06 14:29:53'),
(71, NULL, 25, 1, NULL, 9, '2024-07-06 14:29:53', '2024-07-06 14:29:53'),
(72, NULL, 25, 1, NULL, 9, '2024-07-06 14:29:53', '2024-07-06 14:29:53'),
(73, NULL, 25, 1, NULL, 10, '2024-07-06 14:34:03', '2024-07-06 14:34:03'),
(74, NULL, 25, 1, NULL, 10, '2024-07-06 14:34:03', '2024-07-06 14:34:03'),
(75, NULL, 25, 1, NULL, 10, '2024-07-06 14:34:03', '2024-07-06 14:34:03'),
(76, NULL, 25, 1, NULL, 10, '2024-07-06 14:34:03', '2024-07-06 14:34:03'),
(77, NULL, 25, 1, NULL, 10, '2024-07-06 14:34:04', '2024-07-06 14:34:04'),
(78, NULL, 25, 1, NULL, 10, '2024-07-06 14:34:04', '2024-07-06 14:34:04'),
(79, NULL, 25, 1, NULL, 10, '2024-07-06 14:34:04', '2024-07-06 14:34:04'),
(80, NULL, 25, 1, NULL, 10, '2024-07-06 14:34:04', '2024-07-06 14:34:04'),
(81, NULL, 25, 1, NULL, 10, '2024-07-06 14:34:04', '2024-07-06 14:34:04'),
(82, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:18', '2024-07-06 14:45:18'),
(83, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:18', '2024-07-06 14:45:18'),
(84, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:18', '2024-07-06 14:45:18'),
(85, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(86, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(87, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(88, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(89, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(90, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(91, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(92, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(93, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(94, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(95, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(96, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(97, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(98, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(99, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(100, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(101, NULL, 15, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-06 14:45:19'),
(102, NULL, 20, 1, NULL, 12, '2024-07-06 14:49:58', '2024-07-06 14:49:58'),
(103, NULL, 20, 1, NULL, 12, '2024-07-06 14:49:58', '2024-07-06 14:49:58'),
(104, NULL, 20, 1, NULL, 12, '2024-07-06 14:49:58', '2024-07-06 14:49:58'),
(105, NULL, 20, 1, NULL, 12, '2024-07-06 14:49:58', '2024-07-06 14:49:58'),
(106, NULL, 20, 1, NULL, 12, '2024-07-06 14:49:58', '2024-07-06 14:49:58'),
(107, NULL, 20, 1, NULL, 12, '2024-07-06 14:49:58', '2024-07-06 14:49:58'),
(108, NULL, 20, 1, NULL, 12, '2024-07-06 14:49:58', '2024-07-06 14:49:58'),
(109, NULL, 20, 1, NULL, 12, '2024-07-06 14:49:58', '2024-07-06 14:49:58'),
(110, NULL, 20, 1, NULL, 12, '2024-07-06 14:49:58', '2024-07-06 14:49:58'),
(111, NULL, 20, 1, NULL, 12, '2024-07-06 14:49:58', '2024-07-06 14:49:58'),
(112, NULL, 20, 1, NULL, 13, '2024-07-06 14:54:08', '2024-07-06 14:54:08'),
(113, NULL, 20, 1, NULL, 13, '2024-07-06 14:54:08', '2024-07-06 14:54:08'),
(114, NULL, 20, 1, NULL, 13, '2024-07-06 14:54:08', '2024-07-06 14:54:08'),
(115, NULL, 20, 1, NULL, 13, '2024-07-06 14:54:08', '2024-07-06 14:54:08'),
(116, NULL, 20, 1, NULL, 13, '2024-07-06 14:54:08', '2024-07-06 14:54:08'),
(117, NULL, 20, 1, NULL, 13, '2024-07-06 14:54:08', '2024-07-06 14:54:08'),
(118, NULL, 20, 1, NULL, 13, '2024-07-06 14:54:08', '2024-07-06 14:54:08'),
(119, NULL, 20, 1, NULL, 13, '2024-07-06 14:54:08', '2024-07-06 14:54:08'),
(120, NULL, 20, 1, NULL, 13, '2024-07-06 14:54:08', '2024-07-06 14:54:08'),
(121, NULL, 20, 1, NULL, 13, '2024-07-06 14:54:08', '2024-07-06 14:54:08'),
(122, NULL, 25, 1, NULL, 14, '2024-07-06 15:00:25', '2024-07-06 15:00:25'),
(123, NULL, 25, 1, NULL, 14, '2024-07-06 15:00:25', '2024-07-06 15:00:25'),
(124, NULL, 25, 1, NULL, 14, '2024-07-06 15:00:25', '2024-07-06 15:00:25'),
(125, NULL, 25, 1, NULL, 14, '2024-07-06 15:00:25', '2024-07-06 15:00:25'),
(126, NULL, 25, 1, NULL, 14, '2024-07-06 15:00:25', '2024-07-06 15:00:25'),
(127, NULL, 25, 1, NULL, 14, '2024-07-06 15:00:25', '2024-07-06 15:00:25'),
(128, NULL, 25, 1, NULL, 14, '2024-07-06 15:00:25', '2024-07-06 15:00:25'),
(129, NULL, 25, 1, NULL, 14, '2024-07-06 15:00:26', '2024-07-06 15:00:26'),
(130, NULL, 25, 1, NULL, 14, '2024-07-06 15:00:26', '2024-07-06 15:00:26'),
(131, NULL, 15, 1, NULL, 15, '2024-07-06 15:04:28', '2024-07-06 15:04:28'),
(132, NULL, 15, 1, NULL, 15, '2024-07-06 15:04:28', '2024-07-06 15:04:28'),
(133, NULL, 15, 1, NULL, 15, '2024-07-06 15:04:28', '2024-07-06 15:04:28'),
(134, NULL, 15, 1, NULL, 15, '2024-07-06 15:04:28', '2024-07-06 15:04:28'),
(135, NULL, 15, 1, NULL, 15, '2024-07-06 15:04:28', '2024-07-06 15:04:28'),
(136, NULL, 15, 1, NULL, 15, '2024-07-06 15:04:28', '2024-07-06 15:04:28'),
(137, NULL, 15, 1, NULL, 15, '2024-07-06 15:04:28', '2024-07-06 15:04:28'),
(138, NULL, 15, 1, NULL, 15, '2024-07-06 15:04:28', '2024-07-06 15:04:28'),
(139, NULL, 15, 1, NULL, 15, '2024-07-06 15:04:28', '2024-07-06 15:04:28'),
(140, NULL, 10, 1, NULL, 16, '2024-07-06 15:08:04', '2024-07-06 15:08:04'),
(141, NULL, 10, 1, NULL, 16, '2024-07-06 15:08:05', '2024-07-06 15:08:05'),
(142, NULL, 10, 1, NULL, 16, '2024-07-06 15:08:05', '2024-07-06 15:08:05'),
(143, NULL, 10, 1, NULL, 16, '2024-07-06 15:08:05', '2024-07-06 15:08:05'),
(144, NULL, 10, 1, NULL, 16, '2024-07-06 15:08:05', '2024-07-06 15:08:05'),
(145, NULL, 10, 1, NULL, 16, '2024-07-06 15:08:05', '2024-07-06 15:08:05'),
(146, NULL, 10, 1, NULL, 16, '2024-07-06 15:08:05', '2024-07-06 15:08:05'),
(147, NULL, 10, 1, NULL, 16, '2024-07-06 15:08:05', '2024-07-06 15:08:05'),
(148, NULL, 10, 1, NULL, 16, '2024-07-06 15:08:05', '2024-07-06 15:08:05');

-- --------------------------------------------------------

--
-- Structure de la table `productsvariations_attributesoptions`
--

CREATE TABLE `productsvariations_attributesoptions` (
  `productVariation_id` int(10) UNSIGNED NOT NULL,
  `productAttribute_id` smallint(5) UNSIGNED NOT NULL,
  `productAttributeOption_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `productsvariations_attributesoptions`
--

INSERT INTO `productsvariations_attributesoptions` (`productVariation_id`, `productAttribute_id`, `productAttributeOption_id`) VALUES
(1, 1, 2),
(1, 2, 6),
(2, 1, 2),
(2, 2, 11),
(3, 1, 2),
(3, 2, 8),
(4, 1, 3),
(4, 2, 6),
(5, 1, 3),
(5, 2, 7),
(6, 1, 3),
(6, 2, 10),
(7, 1, 4),
(7, 2, 10),
(8, 1, 4),
(8, 2, 7),
(9, 1, 4),
(9, 2, 11),
(10, 1, 2),
(10, 2, 10),
(11, 1, 2),
(11, 2, 8),
(12, 1, 2),
(12, 2, 11),
(13, 1, 3),
(13, 2, 6),
(14, 1, 3),
(14, 2, 10),
(15, 1, 3),
(15, 2, 7),
(16, 1, 4),
(16, 2, 6),
(17, 1, 4),
(17, 2, 11),
(18, 1, 4),
(18, 2, 12),
(19, 1, 2),
(19, 2, 6),
(20, 1, 2),
(20, 2, 12),
(21, 1, 2),
(21, 2, 10),
(22, 1, 3),
(22, 2, 11),
(23, 1, 3),
(23, 2, 7),
(24, 1, 3),
(24, 2, 8),
(25, 1, 4),
(25, 2, 7),
(26, 1, 4),
(26, 2, 9),
(27, 1, 4),
(27, 2, 6),
(28, 1, 2),
(28, 2, 6),
(29, 1, 2),
(29, 2, 7),
(30, 1, 2),
(30, 2, 9),
(31, 1, 3),
(31, 2, 6),
(32, 1, 3),
(32, 2, 7),
(33, 1, 3),
(33, 2, 9),
(34, 1, 4),
(34, 2, 6),
(35, 1, 4),
(35, 2, 7),
(36, 1, 4),
(36, 2, 9),
(37, 1, 2),
(37, 2, 6),
(38, 1, 2),
(38, 2, 7),
(39, 1, 2),
(39, 2, 8),
(40, 1, 3),
(40, 2, 6),
(41, 1, 3),
(41, 2, 7),
(42, 1, 3),
(42, 2, 8),
(43, 1, 4),
(43, 2, 11),
(44, 1, 4),
(44, 2, 9),
(45, 1, 4),
(45, 2, 8),
(46, 1, 2),
(46, 2, 6),
(47, 1, 2),
(47, 2, 7),
(48, 1, 2),
(48, 2, 8),
(49, 1, 3),
(49, 2, 6),
(50, 1, 3),
(50, 2, 7),
(51, 1, 3),
(51, 2, 8),
(52, 1, 4),
(52, 2, 6),
(53, 1, 4),
(53, 2, 7),
(54, 1, 4),
(54, 2, 8),
(55, 1, 2),
(55, 2, 6),
(56, 1, 2),
(56, 2, 7),
(57, 1, 2),
(57, 2, 8),
(58, 1, 3),
(58, 2, 6),
(59, 1, 3),
(59, 2, 7),
(60, 1, 3),
(60, 2, 8),
(61, 1, 4),
(61, 2, 6),
(62, 1, 4),
(62, 2, 9),
(63, 1, 4),
(63, 2, 12),
(64, 1, 2),
(64, 2, 6),
(65, 1, 2),
(65, 2, 7),
(66, 1, 2),
(66, 2, 17),
(67, 1, 3),
(67, 2, 8),
(68, 1, 3),
(68, 2, 10),
(69, 1, 3),
(69, 2, 7),
(70, 1, 4),
(70, 2, 11),
(71, 1, 4),
(71, 2, 17),
(72, 1, 4),
(72, 2, 6),
(73, 1, 2),
(73, 2, 6),
(74, 1, 2),
(74, 2, 7),
(75, 1, 2),
(75, 2, 8),
(76, 1, 3),
(76, 2, 7),
(77, 1, 3),
(77, 2, 10),
(78, 1, 3),
(78, 2, 8),
(79, 1, 4),
(79, 2, 11),
(80, 1, 4),
(80, 2, 6),
(81, 1, 4),
(81, 2, 8),
(82, 2, 9),
(82, 4, 18),
(83, 2, 7),
(83, 4, 18),
(84, 2, 9),
(84, 4, 19),
(85, 2, 7),
(85, 4, 19),
(86, 2, 7),
(86, 4, 20),
(87, 2, 9),
(87, 4, 20),
(88, 2, 7),
(88, 4, 21),
(89, 2, 9),
(89, 4, 21),
(90, 2, 7),
(90, 4, 22),
(91, 2, 9),
(91, 4, 22),
(92, 2, 7),
(92, 4, 23),
(93, 2, 9),
(93, 4, 23),
(94, 2, 7),
(94, 4, 24),
(95, 2, 9),
(95, 4, 24),
(96, 2, 7),
(96, 4, 25),
(97, 2, 9),
(97, 4, 25),
(98, 2, 9),
(98, 4, 26),
(99, 2, 7),
(99, 4, 26),
(100, 2, 7),
(100, 4, 27),
(101, 2, 9),
(101, 4, 27),
(102, 2, 7),
(102, 4, 18),
(103, 2, 9),
(103, 4, 19),
(104, 2, 7),
(104, 4, 20),
(105, 2, 9),
(105, 4, 21),
(106, 2, 7),
(106, 4, 22),
(107, 2, 9),
(107, 4, 23),
(108, 2, 7),
(108, 4, 24),
(109, 2, 9),
(109, 4, 25),
(110, 2, 7),
(110, 4, 26),
(111, 2, 9),
(111, 4, 27),
(112, 2, 7),
(112, 4, 18),
(113, 2, 9),
(113, 4, 19),
(114, 2, 7),
(114, 4, 20),
(115, 2, 9),
(115, 4, 21),
(116, 2, 7),
(116, 4, 22),
(117, 2, 9),
(117, 4, 23),
(118, 2, 7),
(118, 4, 24),
(119, 2, 9),
(119, 4, 25),
(120, 2, 7),
(120, 4, 26),
(121, 2, 9),
(121, 4, 27),
(122, 1, 2),
(122, 2, 6),
(123, 1, 2),
(123, 2, 11),
(124, 1, 2),
(124, 2, 8),
(125, 1, 3),
(125, 2, 12),
(126, 1, 3),
(126, 2, 6),
(127, 1, 3),
(127, 2, 7),
(128, 1, 4),
(128, 2, 9),
(129, 1, 4),
(129, 2, 8),
(130, 1, 4),
(130, 2, 11),
(131, 1, 2),
(131, 2, 8),
(132, 1, 2),
(132, 2, 7),
(133, 1, 2),
(133, 2, 10),
(134, 1, 3),
(134, 2, 8),
(135, 1, 3),
(135, 2, 7),
(136, 1, 3),
(136, 2, 10),
(137, 1, 4),
(137, 2, 8),
(138, 1, 4),
(138, 2, 7),
(139, 1, 4),
(139, 2, 10),
(140, 1, 2),
(140, 2, 6),
(141, 1, 2),
(141, 2, 7),
(142, 1, 2),
(142, 2, 8),
(143, 1, 3),
(143, 2, 6),
(144, 1, 3),
(144, 2, 7),
(145, 1, 3),
(145, 2, 8),
(146, 1, 4),
(146, 2, 6),
(147, 1, 4),
(147, 2, 7),
(148, 1, 4),
(148, 2, 11);

-- --------------------------------------------------------

--
-- Structure de la table `systempermissions`
--

CREATE TABLE `systempermissions` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `role` enum('admin','user','customer') NOT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `phone`, `birth_date`, `image_path`, `is_active`, `last_login`, `role`, `added_by`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Ayoub', 'Kheyar', 'a', 'a@a.com', '$2y$10$fKuYXgInREPJZFJ19iNF7.iRpq4ExxcuT.M0A1IFe92HfqUwWQOPe', '0785496521', '2000-01-12', 'users/id_1/admin.jpg', 1, NULL, 'admin', NULL, NULL, NULL, '2024-07-04 19:47:49', '2024-07-04 19:47:49', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `userspermissions`
--

CREATE TABLE `userspermissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `userspermissions_systempermissions`
--

CREATE TABLE `userspermissions_systempermissions` (
  `userPermission_id` bigint(20) UNSIGNED NOT NULL,
  `systemPermission_id` smallint(5) UNSIGNED NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users_addresses`
--

CREATE TABLE `users_addresses` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address_id` bigint(20) UNSIGNED NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_country_id_foreign` (`country_id`);

--
-- Index pour la table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`),
  ADD KEY `brands_added_by_foreign` (`added_by`);

--
-- Index pour la table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_name_unique` (`name`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `preferences_of_showcase`
--
ALTER TABLE `preferences_of_showcase`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_name_unique` (`name`),
  ADD UNIQUE KEY `products_description_unique` (`description`) USING HASH,
  ADD KEY `products_added_by_foreign` (`added_by`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Index pour la table `productsattributes`
--
ALTER TABLE `productsattributes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productsattributes_name_unique` (`name`),
  ADD UNIQUE KEY `productsattributes_description_unique` (`description`) USING HASH;

--
-- Index pour la table `productsattributesoptions`
--
ALTER TABLE `productsattributesoptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productsattributesoptions_productattribute_id_foreign` (`productAttribute_id`);

--
-- Index pour la table `productscategories`
--
ALTER TABLE `productscategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productscategories_name_unique` (`name`),
  ADD UNIQUE KEY `productscategories_ordering_unique` (`ordering`),
  ADD UNIQUE KEY `productscategories_description_unique` (`description`) USING HASH,
  ADD KEY `productscategories_added_by_foreign` (`added_by`),
  ADD KEY `productscategories_parent_id_foreign` (`parent_id`);

--
-- Index pour la table `productscategories_products`
--
ALTER TABLE `productscategories_products`
  ADD PRIMARY KEY (`product_id`,`productCategory_id`),
  ADD KEY `productscategories_products_productcategory_id_foreign` (`productCategory_id`);

--
-- Index pour la table `productsimages`
--
ALTER TABLE `productsimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productsimages_product_id_foreign` (`product_id`);

--
-- Index pour la table `productsvariations`
--
ALTER TABLE `productsvariations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productsvariations_product_id_foreign` (`product_id`);

--
-- Index pour la table `productsvariations_attributesoptions`
--
ALTER TABLE `productsvariations_attributesoptions`
  ADD PRIMARY KEY (`productVariation_id`,`productAttribute_id`,`productAttributeOption_id`),
  ADD KEY `productAttribute_id_foreign` (`productAttribute_id`),
  ADD KEY `productAttributeOption_id_foreign` (`productAttributeOption_id`);

--
-- Index pour la table `systempermissions`
--
ALTER TABLE `systempermissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `systempermissions_name_unique` (`name`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_added_by_foreign` (`added_by`);

--
-- Index pour la table `userspermissions`
--
ALTER TABLE `userspermissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userspermissions_user_id_foreign` (`user_id`);

--
-- Index pour la table `userspermissions_systempermissions`
--
ALTER TABLE `userspermissions_systempermissions`
  ADD PRIMARY KEY (`userPermission_id`,`systemPermission_id`),
  ADD KEY `userspermissions_systempermissions_systempermission_id_foreign` (`systemPermission_id`);

--
-- Index pour la table `users_addresses`
--
ALTER TABLE `users_addresses`
  ADD PRIMARY KEY (`user_id`,`address_id`),
  ADD KEY `users_addresses_address_id_foreign` (`address_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `preferences_of_showcase`
--
ALTER TABLE `preferences_of_showcase`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `productsattributes`
--
ALTER TABLE `productsattributes`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `productsattributesoptions`
--
ALTER TABLE `productsattributesoptions`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `productscategories`
--
ALTER TABLE `productscategories`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pour la table `productsimages`
--
ALTER TABLE `productsimages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `productsvariations`
--
ALTER TABLE `productsvariations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT pour la table `systempermissions`
--
ALTER TABLE `systempermissions`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `userspermissions`
--
ALTER TABLE `userspermissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);

--
-- Contraintes pour la table `productsattributesoptions`
--
ALTER TABLE `productsattributesoptions`
  ADD CONSTRAINT `productsattributesoptions_productattribute_id_foreign` FOREIGN KEY (`productAttribute_id`) REFERENCES `productsattributes` (`id`);

--
-- Contraintes pour la table `productscategories`
--
ALTER TABLE `productscategories`
  ADD CONSTRAINT `productscategories_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `productscategories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `productscategories` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `productscategories_products`
--
ALTER TABLE `productscategories_products`
  ADD CONSTRAINT `productscategories_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `productscategories_products_productcategory_id_foreign` FOREIGN KEY (`productCategory_id`) REFERENCES `productscategories` (`id`);

--
-- Contraintes pour la table `productsimages`
--
ALTER TABLE `productsimages`
  ADD CONSTRAINT `productsimages_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Contraintes pour la table `productsvariations`
--
ALTER TABLE `productsvariations`
  ADD CONSTRAINT `productsvariations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Contraintes pour la table `productsvariations_attributesoptions`
--
ALTER TABLE `productsvariations_attributesoptions`
  ADD CONSTRAINT `productAttributeOption_id_foreign` FOREIGN KEY (`productAttributeOption_id`) REFERENCES `productsattributesoptions` (`id`),
  ADD CONSTRAINT `productAttribute_id_foreign` FOREIGN KEY (`productAttribute_id`) REFERENCES `productsattributes` (`id`),
  ADD CONSTRAINT `productsvariations_attributesoptions_productvariation_id_foreign` FOREIGN KEY (`productVariation_id`) REFERENCES `productsvariations` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `userspermissions`
--
ALTER TABLE `userspermissions`
  ADD CONSTRAINT `userspermissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `userspermissions_systempermissions`
--
ALTER TABLE `userspermissions_systempermissions`
  ADD CONSTRAINT `userspermissions_systempermissions_systempermission_id_foreign` FOREIGN KEY (`systemPermission_id`) REFERENCES `systempermissions` (`id`),
  ADD CONSTRAINT `userspermissions_systempermissions_userpermission_id_foreign` FOREIGN KEY (`userPermission_id`) REFERENCES `userspermissions` (`id`);

--
-- Contraintes pour la table `users_addresses`
--
ALTER TABLE `users_addresses`
  ADD CONSTRAINT `users_addresses_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  ADD CONSTRAINT `users_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
