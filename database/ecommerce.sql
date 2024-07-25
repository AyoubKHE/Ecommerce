-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 25 juil. 2024 à 17:07
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
-- Structure de la table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `items_count` int(11) NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cartsitems`
--

CREATE TABLE `cartsitems` (
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `productVariation_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `communes`
--

CREATE TABLE `communes` (
  `id` int(10) UNSIGNED NOT NULL,
  `postal_code` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `wilaya_id` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `communes`
--

INSERT INTO `communes` (`id`, `postal_code`, `name`, `wilaya_id`) VALUES
(1, '01001', 'Adrar', 1),
(2, '01002', 'Tamest', 1),
(3, '01003', 'Charouine', 1),
(4, '01004', 'Reggane', 1),
(5, '01005', 'Inozghmir', 1),
(6, '01006', 'Tit', 1),
(7, '01007', 'Ksar Kaddour', 1),
(8, '01008', 'Tsabit', 1),
(9, '01009', 'Timimoun', 1),
(10, '01010', 'Ouled Said', 1),
(11, '01011', 'Zaouiet Kounta', 1),
(12, '01012', 'Aoulef', 1),
(13, '01013', 'Timokten', 1),
(14, '01014', 'Tamentit', 1),
(15, '01015', 'Fenoughil', 1),
(16, '01016', 'Tinerkouk', 1),
(17, '01017', 'Deldoul', 1),
(18, '01018', 'Sali', 1),
(19, '01019', 'Akabli', 1),
(20, '01020', 'Metarfa', 1),
(21, '01021', 'O Ahmed Timmi', 1),
(22, '01022', 'Bouda', 1),
(23, '01023', 'Aougrout', 1),
(24, '01024', 'Talmine', 1),
(25, '01025', 'B Badji Mokhtar', 1),
(26, '01026', 'Sbaa', 1),
(27, '01027', 'Ouled Aissa', 1),
(28, '01028', 'Timiaouine', 1),
(29, '02001', 'Chlef', 2),
(30, '02002', 'Tenes', 2),
(31, '02003', 'Benairia', 2),
(32, '02004', 'El Karimia', 2),
(33, '02005', 'Tadjna', 2),
(34, '02006', 'Taougrite', 2),
(35, '02007', 'Beni Haoua', 2),
(36, '02008', 'Sobha', 2),
(37, '02009', 'Harchoun', 2),
(38, '02010', 'Ouled Fares', 2),
(39, '02011', 'Sidi Akacha', 2),
(40, '02012', 'Boukadir', 2),
(41, '02013', 'Beni Rached', 2),
(42, '02014', 'Talassa', 2),
(43, '02015', 'Herenfa', 2),
(44, '02016', 'Oued Goussine', 2),
(45, '02017', 'Dahra', 2),
(46, '02018', 'Ouled Abbes', 2),
(47, '02019', 'Sendjas', 2),
(48, '02020', 'Zeboudja', 2),
(49, '02021', 'Oued Sly', 2),
(50, '02022', 'Abou El Hassen', 2),
(51, '02023', 'El Marsa', 2),
(52, '02024', 'Chettia', 2),
(53, '02025', 'Sidi Abderrahmane', 2),
(54, '02026', 'Moussadek', 2),
(55, '02027', 'El Hadjadj', 2),
(56, '02028', 'Labiod Medjadja', 2),
(57, '02029', 'Oued Fodda', 2),
(58, '02030', 'Ouled Ben Abdelkader', 2),
(59, '02031', 'Bouzghaia', 2),
(60, '02032', 'Ain Merane', 2),
(61, '02033', 'Oum Drou', 2),
(62, '02034', 'Breira', 2),
(63, '02035', 'Ben Boutaleb', 2),
(64, '03001', 'Laghouat', 3),
(65, '03002', 'Ksar El Hirane', 3),
(66, '03003', 'Benacer Ben Chohra', 3),
(67, '03004', 'Sidi Makhlouf', 3),
(68, '03005', 'Hassi Delaa', 3),
(69, '03006', 'Hassi R Mel', 3),
(70, '03007', 'Ain Mahdi', 3),
(71, '03008', 'Tadjmout', 3),
(72, '03009', 'Kheneg', 3),
(73, '03010', 'Gueltat Sidi Saad', 3),
(74, '03011', 'Ain Sidi Ali', 3),
(75, '03012', 'Beidha', 3),
(76, '03013', 'Brida', 3),
(77, '03014', 'El Ghicha', 3),
(78, '03015', 'Hadj Mechri', 3),
(79, '03016', 'Sebgag', 3),
(80, '03017', 'Taouiala', 3),
(81, '03018', 'Tadjrouna', 3),
(82, '03019', 'Aflou', 3),
(83, '03020', 'El Assafia', 3),
(84, '03021', 'Oued Morra', 3),
(85, '03022', 'Oued M Zi', 3),
(86, '03023', 'El Haouaita', 3),
(87, '03024', 'Sidi Bouzid', 3),
(88, '04001', 'Oum El Bouaghi', 4),
(89, '04002', 'Ain Beida', 4),
(90, '04003', 'Ainmlila', 4),
(91, '04004', 'Behir Chergui', 4),
(92, '04005', 'El Amiria', 4),
(93, '04006', 'Sigus', 4),
(94, '04007', 'El Belala', 4),
(95, '04008', 'Ain Babouche', 4),
(96, '04009', 'Berriche', 4),
(97, '04010', 'Ouled Hamla', 4),
(98, '04011', 'Dhala', 4),
(99, '04012', 'Ain Kercha', 4),
(100, '04013', 'Hanchir Toumghani', 4),
(101, '04014', 'El Djazia', 4),
(102, '04015', 'Ain Diss', 4),
(103, '04016', 'Fkirina', 4),
(104, '04017', 'Souk Naamane', 4),
(105, '04018', 'Zorg', 4),
(106, '04019', 'El Fedjoudj Boughrar', 4),
(107, '04020', 'Ouled Zouai', 4),
(108, '04021', 'Bir Chouhada', 4),
(109, '04022', 'Ksar Sbahi', 4),
(110, '04023', 'Oued Nini', 4),
(111, '04024', 'Meskiana', 4),
(112, '04025', 'Ain Fekroune', 4),
(113, '04026', 'Rahia', 4),
(114, '04027', 'Ain Zitoun', 4),
(115, '04028', 'Ouled Gacem', 4),
(116, '04029', 'El Harmilia', 4),
(117, '05001', 'Batna', 5),
(118, '05002', 'Ghassira', 5),
(119, '05003', 'Maafa', 5),
(120, '05004', 'Merouana', 5),
(121, '05005', 'Seriana', 5),
(122, '05006', 'Menaa', 5),
(123, '05007', 'El Madher', 5),
(124, '05008', 'Tazoult', 5),
(125, '05009', 'Ngaous', 5),
(126, '05010', 'Guigba', 5),
(127, '05011', 'Inoughissen', 5),
(128, '05012', 'Ouyoun El Assafir', 5),
(129, '05013', 'Djerma', 5),
(130, '05014', 'Bitam', 5),
(131, '05015', 'Metkaouak', 5),
(132, '05016', 'Arris', 5),
(133, '05017', 'Kimmel', 5),
(134, '05018', 'Tilatou', 5),
(135, '05019', 'Ain Djasser', 5),
(136, '05020', 'Ouled Selam', 5),
(137, '05021', 'Tigherghar', 5),
(138, '05022', 'Ain Yagout', 5),
(139, '05023', 'Fesdis', 5),
(140, '05024', 'Sefiane', 5),
(141, '05025', 'Rahbat', 5),
(142, '05026', 'Tighanimine', 5),
(143, '05027', 'Lemsane', 5),
(144, '05028', 'Ksar Belezma', 5),
(145, '05029', 'Seggana', 5),
(146, '05030', 'Ichmoul', 5),
(147, '05031', 'Foum Toub', 5),
(148, '05032', 'Beni Foudhala El Hakania', 5),
(149, '05033', 'Oued El Ma', 5),
(150, '05034', 'Talkhamt', 5),
(151, '05035', 'Bouzina', 5),
(152, '05036', 'Chemora', 5),
(153, '05037', 'Oued Chaaba', 5),
(154, '05038', 'Taxlent', 5),
(155, '05039', 'Gosbat', 5),
(156, '05040', 'Ouled Aouf', 5),
(157, '05041', 'Boumagueur', 5),
(158, '05042', 'Barika', 5),
(159, '05043', 'Djezzar', 5),
(160, '05044', 'Tkout', 5),
(161, '05045', 'Ain Touta', 5),
(162, '05046', 'Hidoussa', 5),
(163, '05047', 'Teniet El Abed', 5),
(164, '05048', 'Oued Taga', 5),
(165, '05049', 'Ouled Fadel', 5),
(166, '05050', 'Timgad', 5),
(167, '05051', 'Ras El Aioun', 5),
(168, '05052', 'Chir', 5),
(169, '05053', 'Ouled Si Slimane', 5),
(170, '05054', 'Zanat El Beida', 5),
(171, '05055', 'Amdoukal', 5),
(172, '05056', 'Ouled Ammar', 5),
(173, '05057', 'El Hassi', 5),
(174, '05058', 'Lazrou', 5),
(175, '05059', 'Boumia', 5),
(176, '05060', 'Boulhilat', 5),
(177, '05061', 'Larbaa', 5),
(178, '06001', 'Bejaia', 6),
(179, '06002', 'Amizour', 6),
(180, '06003', 'Ferraoun', 6),
(181, '06004', 'Taourirt Ighil', 6),
(182, '06005', 'Chelata', 6),
(183, '06006', 'Tamokra', 6),
(184, '06007', 'Timzrit', 6),
(185, '06008', 'Souk El Thenine', 6),
(186, '06009', 'Mcisna', 6),
(187, '06010', 'Thinabdher', 6),
(188, '06011', 'Tichi', 6),
(189, '06012', 'Semaoun', 6),
(190, '06013', 'Kendira', 6),
(191, '06014', 'Tifra', 6),
(192, '06015', 'Ighram', 6),
(193, '06016', 'Amalou', 6),
(194, '06017', 'Ighil Ali', 6),
(195, '06018', 'Ifelain Ilmathen', 6),
(196, '06019', 'Toudja', 6),
(197, '06020', 'Darguina', 6),
(198, '06021', 'Sidi Ayad', 6),
(199, '06022', 'Aokas', 6),
(200, '06023', 'Beni Djellil', 6),
(201, '06024', 'Adekar', 6),
(202, '06025', 'Akbou', 6),
(203, '06026', 'Seddouk', 6),
(204, '06027', 'Tazmalt', 6),
(205, '06028', 'Ait Rizine', 6),
(206, '06029', 'Chemini', 6),
(207, '06030', 'Souk Oufella', 6),
(208, '06031', 'Taskriout', 6),
(209, '06032', 'Tibane', 6),
(210, '06033', 'Tala Hamza', 6),
(211, '06034', 'Barbacha', 6),
(212, '06035', 'Beni Ksila', 6),
(213, '06036', 'Ouzallaguen', 6),
(214, '06037', 'Bouhamza', 6),
(215, '06038', 'Beni Melikeche', 6),
(216, '06039', 'Sidi Aich', 6),
(217, '06040', 'El Kseur', 6),
(218, '06041', 'Melbou', 6),
(219, '06042', 'Akfadou', 6),
(220, '06043', 'Leflaye', 6),
(221, '06044', 'Kherrata', 6),
(222, '06045', 'Draa Kaid', 6),
(223, '06046', 'Tamridjet', 6),
(224, '06047', 'Ait Smail', 6),
(225, '06048', 'Boukhelifa', 6),
(226, '06049', 'Tizi Nberber', 6),
(227, '06050', 'Beni Maouch', 6),
(228, '06051', 'Oued Ghir', 6),
(229, '06052', 'Boudjellil', 6),
(230, '07001', 'Biskra', 7),
(231, '07002', 'Oumache', 7),
(232, '07003', 'Branis', 7),
(233, '07004', 'Chetma', 7),
(234, '07005', 'Ouled Djellal', 7),
(235, '07006', 'Ras El Miaad', 7),
(236, '07007', 'Besbes', 7),
(237, '07008', 'Sidi Khaled', 7),
(238, '07009', 'Doucen', 7),
(239, '07010', 'Ech Chaiba', 7),
(240, '07011', 'Sidi Okba', 7),
(241, '07012', 'Mchouneche', 7),
(242, '07013', 'El Haouch', 7),
(243, '07014', 'Ain Naga', 7),
(244, '07015', 'Zeribet El Oued', 7),
(245, '07016', 'El Feidh', 7),
(246, '07017', 'El Kantara', 7),
(247, '07018', 'Ain Zaatout', 7),
(248, '07019', 'El Outaya', 7),
(249, '07020', 'Djemorah', 7),
(250, '07021', 'Tolga', 7),
(251, '07022', 'Lioua', 7),
(252, '07023', 'Lichana', 7),
(253, '07024', 'Ourlal', 7),
(254, '07025', 'Mlili', 7),
(255, '07026', 'Foughala', 7),
(256, '07027', 'Bordj Ben Azzouz', 7),
(257, '07028', 'Meziraa', 7),
(258, '07029', 'Bouchagroun', 7),
(259, '07030', 'Mekhadma', 7),
(260, '07031', 'El Ghrous', 7),
(261, '07032', 'El Hadjab', 7),
(262, '07033', 'Khanguet Sidinadji', 7),
(263, '08001', 'Bechar', 8),
(264, '08002', 'Erg Ferradj', 8),
(265, '08003', 'Ouled Khoudir', 8),
(266, '08004', 'Meridja', 8),
(267, '08005', 'Timoudi', 8),
(268, '08006', 'Lahmar', 8),
(269, '08007', 'Beni Abbes', 8),
(270, '08008', 'Beni Ikhlef', 8),
(271, '08009', 'Mechraa Houari B', 8),
(272, '08010', 'Kenedsa', 8),
(273, '08011', 'Igli', 8),
(274, '08012', 'Tabalbala', 8),
(275, '08013', 'Taghit', 8),
(276, '08014', 'El Ouata', 8),
(277, '08015', 'Boukais', 8),
(278, '08016', 'Mogheul', 8),
(279, '08017', 'Abadla', 8),
(280, '08018', 'Kerzaz', 8),
(281, '08019', 'Ksabi', 8),
(282, '08020', 'Tamtert', 8),
(283, '08021', 'Beni Ounif', 8),
(284, '09001', 'Blida', 9),
(285, '09002', 'Chebli', 9),
(286, '09003', 'Bouinan', 9),
(287, '09004', 'Oued El Alleug', 9),
(288, '09007', 'Ouled Yaich', 9),
(289, '09008', 'Chrea', 9),
(290, '09010', 'El Affroun', 9),
(291, '09011', 'Chiffa', 9),
(292, '09012', 'Hammam Melouane', 9),
(293, '09013', 'Ben Khlil', 9),
(294, '09014', 'Soumaa', 9),
(295, '09016', 'Mouzaia', 9),
(296, '09017', 'Souhane', 9),
(297, '09018', 'Meftah', 9),
(298, '09019', 'Ouled Selama', 9),
(299, '09020', 'Boufarik', 9),
(300, '09021', 'Larbaa', 9),
(301, '09022', 'Oued Djer', 9),
(302, '09023', 'Beni Tamou', 9),
(303, '09024', 'Bouarfa', 9),
(304, '09025', 'Beni Mered', 9),
(305, '09026', 'Bougara', 9),
(306, '09027', 'Guerrouaou', 9),
(307, '09028', 'Ain Romana', 9),
(308, '09029', 'Djebabra', 9),
(309, '10001', 'Bouira', 10),
(310, '10002', 'El Asnam', 10),
(311, '10003', 'Guerrouma', 10),
(312, '10004', 'Souk El Khemis', 10),
(313, '10005', 'Kadiria', 10),
(314, '10006', 'Hanif', 10),
(315, '10007', 'Dirah', 10),
(316, '10008', 'Ait Laaziz', 10),
(317, '10009', 'Taghzout', 10),
(318, '10010', 'Raouraoua', 10),
(319, '10011', 'Mezdour', 10),
(320, '10012', 'Haizer', 10),
(321, '10013', 'Lakhdaria', 10),
(322, '10014', 'Maala', 10),
(323, '10015', 'El Hachimia', 10),
(324, '10016', 'Aomar', 10),
(325, '10017', 'Chorfa', 10),
(326, '10018', 'Bordj Oukhriss', 10),
(327, '10019', 'El Adjiba', 10),
(328, '10020', 'El Hakimia', 10),
(329, '10021', 'El Khebouzia', 10),
(330, '10022', 'Ahl El Ksar', 10),
(331, '10023', 'Bouderbala', 10),
(332, '10024', 'Zbarbar', 10),
(333, '10025', 'Ain El Hadjar', 10),
(334, '10026', 'Djebahia', 10),
(335, '10027', 'Aghbalou', 10),
(336, '10028', 'Taguedit', 10),
(337, '10029', 'Ain Turk', 10),
(338, '10030', 'Saharidj', 10),
(339, '10031', 'Dechmia', 10),
(340, '10032', 'Ridane', 10),
(341, '10033', 'Bechloul', 10),
(342, '10034', 'Boukram', 10),
(343, '10035', 'Ain Bessam', 10),
(344, '10036', 'Bir Ghbalou', 10),
(345, '10037', 'Mchedallah', 10),
(346, '10038', 'Sour El Ghozlane', 10),
(347, '10039', 'Maamora', 10),
(348, '10040', 'Ouled Rached', 10),
(349, '10041', 'Ain Laloui', 10),
(350, '10042', 'Hadjera Zerga', 10),
(351, '10043', 'Ath Mansour', 10),
(352, '10044', 'El Mokrani', 10),
(353, '10045', 'Oued El Berdi', 10),
(354, '11001', 'Tamanghasset', 11),
(355, '11002', 'Abalessa', 11),
(356, '11003', 'In Ghar', 11),
(357, '11004', 'In Guezzam', 11),
(358, '11005', 'Idles', 11),
(359, '11006', 'Tazouk', 11),
(360, '11007', 'Tinzaouatine', 11),
(361, '11008', 'In Salah', 11),
(362, '11009', 'In Amguel', 11),
(363, '11010', 'Foggaret Ezzaouia', 11),
(364, '12001', 'Tebessa', 12),
(365, '12002', 'Bir El Ater', 12),
(366, '12003', 'Cheria', 12),
(367, '12004', 'Stah Guentis', 12),
(368, '12005', 'El Aouinet', 12),
(369, '12006', 'Lahouidjbet', 12),
(370, '12007', 'Safsaf El Ouesra', 12),
(371, '12008', 'Hammamet', 12),
(372, '12009', 'Negrine', 12),
(373, '12010', 'Bir El Mokadem', 12),
(374, '12011', 'El Kouif', 12),
(375, '12012', 'Morsott', 12),
(376, '12013', 'El Ogla', 12),
(377, '12014', 'Bir Dheheb', 12),
(378, '12015', 'El Ogla El Malha', 12),
(379, '12016', 'Gorriguer', 12),
(380, '12017', 'Bekkaria', 12),
(381, '12018', 'Boukhadra', 12),
(382, '12019', 'Ouenza', 12),
(383, '12020', 'El Ma El Biodh', 12),
(384, '12021', 'Oum Ali', 12),
(385, '12022', 'Thlidjene', 12),
(386, '12023', 'Ain Zerga', 12),
(387, '12024', 'El Meridj', 12),
(388, '12025', 'Boulhaf Dyr', 12),
(389, '12026', 'Bedjene', 12),
(390, '12027', 'El Mazeraa', 12),
(391, '12028', 'Ferkane', 12),
(392, '13001', 'Tlemcen', 13),
(393, '13002', 'Beni Mester', 13),
(394, '13003', 'Ain Tallout', 13),
(395, '13004', 'Remchi', 13),
(396, '13005', 'El Fehoul', 13),
(397, '13006', 'Sabra', 13),
(398, '13007', 'Ghazaouet', 13),
(399, '13008', 'Souani', 13),
(400, '13009', 'Djebala', 13),
(401, '13010', 'El Gor', 13),
(402, '13011', 'Oued Chouly', 13),
(403, '13012', 'Ain Fezza', 13),
(404, '13013', 'Ouled Mimoun', 13),
(405, '13014', 'Amieur', 13),
(406, '13015', 'Ain Youcef', 13),
(407, '13016', 'Zenata', 13),
(408, '13017', 'Beni Snous', 13),
(409, '13018', 'Bab El Assa', 13),
(410, '13019', 'Dar Yaghmouracene', 13),
(411, '13020', 'Fellaoucene', 13),
(412, '13021', 'Azails', 13),
(413, '13022', 'Sebbaa Chioukh', 13),
(414, '13023', 'Terni Beni Hediel', 13),
(415, '13024', 'Bensekrane', 13),
(416, '13025', 'Ain Nehala', 13),
(417, '13026', 'Hennaya', 13),
(418, '13027', 'Maghnia', 13),
(419, '13028', 'Hammam Boughrara', 13),
(420, '13029', 'Souahlia', 13),
(421, '13030', 'Msirda Fouaga', 13),
(422, '13031', 'Ain Fetah', 13),
(423, '13032', 'El Aricha', 13),
(424, '13033', 'Souk Thlata', 13),
(425, '13034', 'Sidi Abdelli', 13),
(426, '13035', 'Sebdou', 13),
(427, '13036', 'Beni Ouarsous', 13),
(428, '13037', 'Sidi Medjahed', 13),
(429, '13038', 'Beni Boussaid', 13),
(430, '13039', 'Marsa Ben Mhidi', 13),
(431, '13040', 'Nedroma', 13),
(432, '13041', 'Sidi Djillali', 13),
(433, '13042', 'Beni Bahdel', 13),
(434, '13043', 'El Bouihi', 13),
(435, '13044', 'Honaine', 13),
(436, '13045', 'Tianet', 13),
(437, '13046', 'Ouled Riyah', 13),
(438, '13047', 'Bouhlou', 13),
(439, '13048', 'Souk El Khemis', 13),
(440, '13049', 'Ain Ghoraba', 13),
(441, '13050', 'Chetouane', 13),
(442, '13051', 'Mansourah', 13),
(443, '13052', 'Beni Semiel', 13),
(444, '13053', 'Ain Kebira', 13),
(445, '14001', 'Tiaret', 14),
(446, '14002', 'Medroussa', 14),
(447, '14003', 'Ain Bouchekif', 14),
(448, '14004', 'Sidi Ali Mellal', 14),
(449, '14005', 'Ain Zarit', 14),
(450, '14006', 'Ain Deheb', 14),
(451, '14007', 'Sidi Bakhti', 14),
(452, '14008', 'Medrissa', 14),
(453, '14009', 'Zmalet El Emir Aek', 14),
(454, '14010', 'Madna', 14),
(455, '14011', 'Sebt', 14),
(456, '14012', 'Mellakou', 14),
(457, '14013', 'Dahmouni', 14),
(458, '14014', 'Rahouia', 14),
(459, '14015', 'Mahdia', 14),
(460, '14016', 'Sougueur', 14),
(461, '14017', 'Sidi Abdelghani', 14),
(462, '14018', 'Ain El Hadid', 14),
(463, '14019', 'Ouled Djerad', 14),
(464, '14020', 'Naima', 14),
(465, '14021', 'Meghila', 14),
(466, '14022', 'Guertoufa', 14),
(467, '14023', 'Sidi Hosni', 14),
(468, '14024', 'Djillali Ben Amar', 14),
(469, '14025', 'Sebaine', 14),
(470, '14026', 'Tousnina', 14),
(471, '14027', 'Frenda', 14),
(472, '14028', 'Ain Kermes', 14),
(473, '14029', 'Ksar Chellala', 14),
(474, '14030', 'Rechaiga', 14),
(475, '14031', 'Nadorah', 14),
(476, '14032', 'Tagdemt', 14),
(477, '14033', 'Oued Lilli', 14),
(478, '14034', 'Mechraa Safa', 14),
(479, '14035', 'Hamadia', 14),
(480, '14036', 'Chehaima', 14),
(481, '14037', 'Takhemaret', 14),
(482, '14038', 'Sidi Abderrahmane', 14),
(483, '14039', 'Serghine', 14),
(484, '14040', 'Bougara', 14),
(485, '14041', 'Faidja', 14),
(486, '14042', 'Tidda', 14),
(487, '15001', 'Tizi Ouzou', 15),
(488, '15002', 'Ain El Hammam', 15),
(489, '15003', 'Akbil', 15),
(490, '15004', 'Freha', 15),
(491, '15005', 'Souamaa', 15),
(492, '15006', 'Mechtrass', 15),
(493, '15007', 'Irdjen', 15),
(494, '15008', 'Timizart', 15),
(495, '15009', 'Makouda', 15),
(496, '15010', 'Draa El Mizan', 15),
(497, '15011', 'Tizi Ghenif', 15),
(498, '15012', 'Bounouh', 15),
(499, '15013', 'Ait Chaffaa', 15),
(500, '15014', 'Frikat', 15),
(501, '15015', 'Beni Aissi', 15),
(502, '15016', 'Beni Zmenzer', 15),
(503, '15017', 'Iferhounene', 15),
(504, '15018', 'Azazga', 15),
(505, '15019', 'Iloula Oumalou', 15),
(506, '15020', 'Yakouren', 15),
(507, '15021', 'Larba Nait Irathen', 15),
(508, '15022', 'Tizi Rached', 15),
(509, '15023', 'Zekri', 15),
(510, '15024', 'Ouaguenoun', 15),
(511, '15025', 'Ain Zaouia', 15),
(512, '15026', 'Mkira', 15),
(513, '15027', 'Ait Yahia', 15),
(514, '15028', 'Ait Mahmoud', 15),
(515, '15029', 'Maatka', 15),
(516, '15030', 'Ait Boumehdi', 15),
(517, '15031', 'Abi Youcef', 15),
(518, '15032', 'Beni Douala', 15),
(519, '15033', 'Illilten', 15),
(520, '15034', 'Bouzguen', 15),
(521, '15035', 'Ait Aggouacha', 15),
(522, '15036', 'Ouadhia', 15),
(523, '15037', 'Azzefoun', 15),
(524, '15038', 'Tigzirt', 15),
(525, '15039', 'Ait Aissa Mimoun', 15),
(526, '15040', 'Boghni', 15),
(527, '15041', 'Ifigha', 15),
(528, '15042', 'Ait Oumalou', 15),
(529, '15043', 'Tirmitine', 15),
(530, '15044', 'Akerrou', 15),
(531, '15045', 'Yatafen', 15),
(532, '15046', 'Beni Ziki', 15),
(533, '15047', 'Draa Ben Khedda', 15),
(534, '15048', 'Ouacif', 15),
(535, '15049', 'Idjeur', 15),
(536, '15050', 'Mekla', 15),
(537, '15051', 'Tizi Nthlata', 15),
(538, '15052', 'Beni Yenni', 15),
(539, '15053', 'Aghrib', 15),
(540, '15054', 'Iflissen', 15),
(541, '15055', 'Boudjima', 15),
(542, '15056', 'Ait Yahia Moussa', 15),
(543, '15057', 'Souk El Thenine', 15),
(544, '15058', 'Ait Khelil', 15),
(545, '15059', 'Sidi Naamane', 15),
(546, '15060', 'Iboudraren', 15),
(547, '15061', 'Aghni Goughran', 15),
(548, '15062', 'Mizrana', 15),
(549, '15063', 'Imsouhal', 15),
(550, '15064', 'Tadmait', 15),
(551, '15065', 'Ait Bouadou', 15),
(552, '15066', 'Assi Youcef', 15),
(553, '15067', 'Ait Toudert', 15),
(554, '16001', 'Alger Centre', 16),
(555, '16002', 'Sidi Mhamed', 16),
(556, '16003', 'El Madania', 16),
(557, '16004', 'Hamma Anassers', 16),
(558, '16005', 'Bab El Oued', 16),
(559, '16006', 'Bologhine Ibn Ziri', 16),
(560, '16007', 'Casbah', 16),
(561, '16008', 'Oued Koriche', 16),
(562, '16009', 'Bir Mourad Rais', 16),
(563, '16010', 'El Biar', 16),
(564, '16011', 'Bouzareah', 16),
(565, '16012', 'Birkhadem', 16),
(566, '16013', 'El Harrach', 16),
(567, '16014', 'Baraki', 16),
(568, '16015', 'Oued Smar', 16),
(569, '16016', 'Bourouba', 16),
(570, '16017', 'Hussein Dey', 16),
(571, '16018', 'Kouba', 16),
(572, '16019', 'Bachedjerah', 16),
(573, '16020', 'Dar El Beida', 16),
(574, '16021', 'Bab Azzouar', 16),
(575, '16022', 'Ben Aknoun', 16),
(576, '16023', 'Dely Ibrahim', 16),
(577, '16024', 'Bains Romains', 16),
(578, '16025', 'Rais Hamidou', 16),
(579, '16026', 'Djasr Kasentina', 16),
(580, '16027', 'El Mouradia', 16),
(581, '16028', 'Hydra', 16),
(582, '16029', 'Mohammadia', 16),
(583, '16030', 'Bordj El Kiffan', 16),
(584, '16031', 'El Magharia', 16),
(585, '16032', 'Beni Messous', 16),
(586, '16033', 'Les Eucalyptus', 16),
(587, '16034', 'Birtouta', 16),
(588, '16035', 'Tassala El Merdja', 16),
(589, '16036', 'Ouled Chebel', 16),
(590, '16037', 'Sidi Moussa', 16),
(591, '16038', 'Ain Taya', 16),
(592, '16039', 'Bordj El Bahri', 16),
(593, '16040', 'Marsa', 16),
(594, '16041', 'Haraoua', 16),
(595, '16042', 'Rouiba', 16),
(596, '16043', 'Reghaia', 16),
(597, '16044', 'Ain Benian', 16),
(598, '16045', 'Staoueli', 16),
(599, '16046', 'Zeralda', 16),
(600, '16047', 'Mahelma', 16),
(601, '16048', 'Rahmania', 16),
(602, '16049', 'Souidania', 16),
(603, '16050', 'Cheraga', 16),
(604, '16051', 'Ouled Fayet', 16),
(605, '16052', 'El Achour', 16),
(606, '16053', 'Draria', 16),
(607, '16054', 'Douera', 16),
(608, '16055', 'Baba Hassen', 16),
(609, '16056', 'Khracia', 16),
(610, '16057', 'Saoula', 16),
(611, '17001', 'Djelfa', 17),
(612, '17002', 'Moudjebara', 17),
(613, '17003', 'El Guedid', 17),
(614, '17004', 'Hassi Bahbah', 17),
(615, '17005', 'Ain Maabed', 17),
(616, '17006', 'Sed Rahal', 17),
(617, '17007', 'Feidh El Botma', 17),
(618, '17008', 'Birine', 17),
(619, '17009', 'Bouira Lahdeb', 17),
(620, '17010', 'Zaccar', 17),
(621, '17011', 'El Khemis', 17),
(622, '17012', 'Sidi Baizid', 17),
(623, '17013', 'Mliliha', 17),
(624, '17014', 'El Idrissia', 17),
(625, '17015', 'Douis', 17),
(626, '17016', 'Hassi El Euch', 17),
(627, '17017', 'Messaad', 17),
(628, '17018', 'Guettara', 17),
(629, '17019', 'Sidi Ladjel', 17),
(630, '17020', 'Had Sahary', 17),
(631, '17021', 'Guernini', 17),
(632, '17022', 'Selmana', 17),
(633, '17023', 'Ain Chouhada', 17),
(634, '17024', 'Oum Laadham', 17),
(635, '17025', 'Dar Chouikh', 17),
(636, '17026', 'Charef', 17),
(637, '17027', 'Beni Yacoub', 17),
(638, '17028', 'Zaafrane', 17),
(639, '17029', 'Deldoul', 17),
(640, '17030', 'Ain El Ibel', 17),
(641, '17031', 'Ain Oussera', 17),
(642, '17032', 'Benhar', 17),
(643, '17033', 'Hassi Fedoul', 17),
(644, '17034', 'Amourah', 17),
(645, '17035', 'Ain Fekka', 17),
(646, '17036', 'Tadmit', 17),
(647, '18001', 'Jijel', 18),
(648, '18002', 'Erraguene', 18),
(649, '18003', 'El Aouana', 18),
(650, '18004', 'Ziamma Mansouriah', 18),
(651, '18005', 'Taher', 18),
(652, '18006', 'Emir Abdelkader', 18),
(653, '18007', 'Chekfa', 18),
(654, '18008', 'Chahna', 18),
(655, '18009', 'El Milia', 18),
(656, '18010', 'Sidi Maarouf', 18),
(657, '18011', 'Settara', 18),
(658, '18012', 'El Ancer', 18),
(659, '18013', 'Sidi Abdelaziz', 18),
(660, '18014', 'Kaous', 18),
(661, '18015', 'Ghebala', 18),
(662, '18016', 'Bouraoui Belhadef', 18),
(663, '18017', 'Djmila', 18),
(664, '18018', 'Selma Benziada', 18),
(665, '18019', 'Boussif Ouled Askeur', 18),
(666, '18020', 'El Kennar Nouchfi', 18),
(667, '18021', 'Ouled Yahia Khadrouch', 18),
(668, '18022', 'Boudria Beni Yadjis', 18),
(669, '18023', 'Kemir Oued Adjoul', 18),
(670, '18024', 'Texena', 18),
(671, '18025', 'Djemaa Beni Habibi', 18),
(672, '18026', 'Bordj Taher', 18),
(673, '18027', 'Ouled Rabah', 18),
(674, '18028', 'Ouadjana', 18),
(675, '19001', 'Setif', 19),
(676, '19002', 'Ain El Kebira', 19),
(677, '19003', 'Beni Aziz', 19),
(678, '19004', 'Ouled Sidi Ahmed', 19),
(679, '19005', 'Boutaleb', 19),
(680, '19006', 'Ain Roua', 19),
(681, '19007', 'Draa Kebila', 19),
(682, '19008', 'Bir El Arch', 19),
(683, '19009', 'Beni Chebana', 19),
(684, '19010', 'Ouled Tebben', 19),
(685, '19011', 'Hamma', 19),
(686, '19012', 'Maaouia', 19),
(687, '19013', 'Ain Legraj', 19),
(688, '19014', 'Ain Abessa', 19),
(689, '19015', 'Dehamcha', 19),
(690, '19016', 'Babor', 19),
(691, '19017', 'Guidjel', 19),
(692, '19018', 'Ain Lahdjar', 19),
(693, '19019', 'Bousselam', 19),
(694, '19020', 'El Eulma', 19),
(695, '19021', 'Djemila', 19),
(696, '19022', 'Beni Ouartilane', 19),
(697, '19023', 'Rosfa', 19),
(698, '19024', 'Ouled Addouane', 19),
(699, '19025', 'Belaa', 19),
(700, '19026', 'Ain Arnat', 19),
(701, '19027', 'Amoucha', 19),
(702, '19028', 'Ain Oulmane', 19),
(703, '19029', 'Beidha Bordj', 19),
(704, '19030', 'Bouandas', 19),
(705, '19031', 'Bazer Sakhra', 19),
(706, '19032', 'Hammam Essokhna', 19),
(707, '19033', 'Mezloug', 19),
(708, '19034', 'Bir Haddada', 19),
(709, '19035', 'Serdj El Ghoul', 19),
(710, '19036', 'Harbil', 19),
(711, '19037', 'El Ouricia', 19),
(712, '19038', 'Tizi Nbechar', 19),
(713, '19039', 'Salah Bey', 19),
(714, '19040', 'Ain Azal', 19),
(715, '19041', 'Guenzet', 19),
(716, '19042', 'Talaifacene', 19),
(717, '19043', 'Bougaa', 19),
(718, '19044', 'Beni Fouda', 19),
(719, '19045', 'Tachouda', 19),
(720, '19046', 'Beni Mouhli', 19),
(721, '19047', 'Ouled Sabor', 19),
(722, '19048', 'Guellal', 19),
(723, '19049', 'Ain Sebt', 19),
(724, '19050', 'Hammam Guergour', 19),
(725, '19051', 'Ait Naoual Mezada', 19),
(726, '19052', 'Ksar El Abtal', 19),
(727, '19053', 'Beni Hocine', 19),
(728, '19054', 'Ait Tizi', 19),
(729, '19055', 'Maouklane', 19),
(730, '19056', 'Guelta Zerka', 19),
(731, '19057', 'Oued El Barad', 19),
(732, '19058', 'Taya', 19),
(733, '19059', 'El Ouldja', 19),
(734, '19060', 'Tella', 19),
(735, '20001', 'Saida', 20),
(736, '20002', 'Doui Thabet', 20),
(737, '20003', 'Ain El Hadjar', 20),
(738, '20004', 'Ouled Khaled', 20),
(739, '20005', 'Moulay Larbi', 20),
(740, '20006', 'Youb', 20),
(741, '20007', 'Hounet', 20),
(742, '20008', 'Sidi Amar', 20),
(743, '20009', 'Sidi Boubekeur', 20),
(744, '20010', 'El Hassasna', 20),
(745, '20011', 'Maamora', 20),
(746, '20012', 'Sidi Ahmed', 20),
(747, '20013', 'Ain Sekhouna', 20),
(748, '20014', 'Ouled Brahim', 20),
(749, '20015', 'Tircine', 20),
(750, '20016', 'Ain Soltane', 20),
(751, '21001', 'Skikda', 21),
(752, '21002', 'Ain Zouit', 21),
(753, '21003', 'El Hadaik', 21),
(754, '21004', 'Azzaba', 21),
(755, '21005', 'Djendel Saadi Mohamed', 21),
(756, '21006', 'Ain Cherchar', 21),
(757, '21007', 'Bekkouche Lakhdar', 21),
(758, '21008', 'Benazouz', 21),
(759, '21009', 'Es Sebt', 21),
(760, '21010', 'Collo', 21),
(761, '21011', 'Beni Zid', 21),
(762, '21012', 'Kerkera', 21),
(763, '21013', 'Ouled Attia', 21),
(764, '21014', 'Oued Zehour', 21),
(765, '21015', 'Zitouna', 21),
(766, '21016', 'El Harrouch', 21),
(767, '21017', 'Zerdazas', 21),
(768, '21018', 'Ouled Hebaba', 21),
(769, '21019', 'Sidi Mezghiche', 21),
(770, '21020', 'Emdjez Edchich', 21),
(771, '21021', 'Beni Oulbane', 21),
(772, '21022', 'Ain Bouziane', 21),
(773, '21023', 'Ramdane Djamel', 21),
(774, '21024', 'Beni Bachir', 21),
(775, '21025', 'Salah Bouchaour', 21),
(776, '21026', 'Tamalous', 21),
(777, '21027', 'Ain Kechra', 21),
(778, '21028', 'Oum Toub', 21),
(779, '21029', 'Bein El Ouiden', 21),
(780, '21030', 'Fil Fila', 21),
(781, '21031', 'Cheraia', 21),
(782, '21032', 'Kanoua', 21),
(783, '21033', 'El Ghedir', 21),
(784, '21034', 'Bouchtata', 21),
(785, '21035', 'Ouldja Boulbalout', 21),
(786, '21036', 'Kheneg Mayoum', 21),
(787, '21037', 'Hamadi Krouma', 21),
(788, '21038', 'El Marsa', 21),
(789, '22001', 'Sidi Bel Abbes', 22),
(790, '22002', 'Tessala', 22),
(791, '22003', 'Sidi Brahim', 22),
(792, '22004', 'Mostefa Ben Brahim', 22),
(793, '22005', 'Telagh', 22),
(794, '22006', 'Mezaourou', 22),
(795, '22007', 'Boukhanafis', 22),
(796, '22008', 'Sidi Ali Boussidi', 22),
(797, '22009', 'Badredine El Mokrani', 22),
(798, '22010', 'Marhoum', 22),
(799, '22011', 'Tafissour', 22),
(800, '22012', 'Amarnas', 22),
(801, '22013', 'Tilmouni', 22),
(802, '22014', 'Sidi Lahcene', 22),
(803, '22015', 'Ain Thrid', 22),
(804, '22016', 'Makedra', 22),
(805, '22017', 'Tenira', 22),
(806, '22018', 'Moulay Slissen', 22),
(807, '22019', 'El Hacaiba', 22),
(808, '22020', 'Hassi Zehana', 22),
(809, '22021', 'Tabia', 22),
(810, '22022', 'Merine', 22),
(811, '22023', 'Ras El Ma', 22),
(812, '22024', 'Ain Tindamine', 22),
(813, '22025', 'Ain Kada', 22),
(814, '22026', 'Mcid', 22),
(815, '22027', 'Sidi Khaled', 22),
(816, '22028', 'Ain El Berd', 22),
(817, '22029', 'Sfissef', 22),
(818, '22030', 'Ain Adden', 22),
(819, '22031', 'Oued Taourira', 22),
(820, '22032', 'Dhaya', 22),
(821, '22033', 'Zerouala', 22),
(822, '22034', 'Lamtar', 22),
(823, '22035', 'Sidi Chaib', 22),
(824, '22036', 'Sidi Dahou Dezairs', 22),
(825, '22037', 'Oued Sbaa', 22),
(826, '22038', 'Boudjebaa El Bordj', 22),
(827, '22039', 'Sehala Thaoura', 22),
(828, '22040', 'Sidi Yacoub', 22),
(829, '22041', 'Sidi Hamadouche', 22),
(830, '22042', 'Belarbi', 22),
(831, '22043', 'Oued Sefioun', 22),
(832, '22044', 'Teghalimet', 22),
(833, '22045', 'Ben Badis', 22),
(834, '22046', 'Sidi Ali Benyoub', 22),
(835, '22047', 'Chetouane Belaila', 22),
(836, '22048', 'Bir El Hammam', 22),
(837, '22049', 'Taoudmout', 22),
(838, '22050', 'Redjem Demouche', 22),
(839, '22051', 'Benachiba Chelia', 22),
(840, '22052', 'Hassi Dahou', 22),
(841, '23001', 'Annaba', 23),
(842, '23002', 'Berrahel', 23),
(843, '23003', 'El Hadjar', 23),
(844, '23004', 'Eulma', 23),
(845, '23005', 'El Bouni', 23),
(846, '23006', 'Oued El Aneb', 23),
(847, '23007', 'Cheurfa', 23),
(848, '23008', 'Seraidi', 23),
(849, '23009', 'Ain Berda', 23),
(850, '23010', 'Chetaibi', 23),
(851, '23011', 'Sidi Amer', 23),
(852, '23012', 'Treat', 23),
(853, '24001', 'Guelma', 24),
(854, '24002', 'Nechmaya', 24),
(855, '24003', 'Bouati Mahmoud', 24),
(856, '24004', 'Oued Zenati', 24),
(857, '24005', 'Tamlouka', 24),
(858, '24006', 'Oued Fragha', 24),
(859, '24007', 'Ain Sandel', 24),
(860, '24008', 'Ras El Agba', 24),
(861, '24009', 'Dahouara', 24),
(862, '24010', 'Belkhir', 24),
(863, '24011', 'Ben Djarah', 24),
(864, '24012', 'Bou Hamdane', 24),
(865, '24013', 'Ain Makhlouf', 24),
(866, '24014', 'Ain Ben Beida', 24),
(867, '24015', 'Khezara', 24),
(868, '24016', 'Beni Mezline', 24),
(869, '24017', 'Bou Hachana', 24),
(870, '24018', 'Guelaat Bou Sbaa', 24),
(871, '24019', 'Hammam Maskhoutine', 24),
(872, '24020', 'El Fedjoudj', 24),
(873, '24021', 'Bordj Sabat', 24),
(874, '24022', 'Hamman Nbail', 24),
(875, '24023', 'Ain Larbi', 24),
(876, '24024', 'Medjez Amar', 24),
(877, '24025', 'Bouchegouf', 24),
(878, '24026', 'Heliopolis', 24),
(879, '24027', 'Ain Hessania', 24),
(880, '24028', 'Roknia', 24),
(881, '24029', 'Salaoua Announa', 24),
(882, '24030', 'Medjez Sfa', 24),
(883, '24031', 'Boumahra Ahmed', 24),
(884, '24032', 'Ain Reggada', 24),
(885, '24033', 'Oued Cheham', 24),
(886, '24034', 'Djeballah Khemissi', 24),
(887, '25001', 'Constantine', 25),
(888, '25002', 'Hamma Bouziane', 25),
(889, '25003', 'El Haria', 25),
(890, '25004', 'Zighoud Youcef', 25),
(891, '25005', 'Didouche Mourad', 25),
(892, '25006', 'El Khroub', 25),
(893, '25007', 'Ain Abid', 25),
(894, '25008', 'Beni Hamiden', 25),
(895, '25009', 'Ouled Rahmoune', 25),
(896, '25010', 'Ain Smara', 25),
(897, '25011', 'Mesaoud Boudjeriou', 25),
(898, '25012', 'Ibn Ziad', 25),
(899, '26001', 'Medea', 26),
(900, '26002', 'Ouzera', 26),
(901, '26003', 'Ouled Maaref', 26),
(902, '26004', 'Ain Boucif', 26),
(903, '26005', 'Aissaouia', 26),
(904, '26006', 'Ouled Deide', 26),
(905, '26007', 'El Omaria', 26),
(906, '26008', 'Derrag', 26),
(907, '26009', 'El Guelbelkebir', 26),
(908, '26010', 'Bouaiche', 26),
(909, '26011', 'Mezerena', 26),
(910, '26012', 'Ouled Brahim', 26),
(911, '26013', 'Damiat', 26),
(912, '26014', 'Sidi Ziane', 26),
(913, '26015', 'Tamesguida', 26),
(914, '26016', 'El Hamdania', 26),
(915, '26017', 'Kef Lakhdar', 26),
(916, '26018', 'Chelalet El Adhaoura', 26),
(917, '26019', 'Bouskene', 26),
(918, '26020', 'Rebaia', 26),
(919, '26021', 'Bouchrahil', 26),
(920, '26022', 'Ouled Hellal', 26),
(921, '26023', 'Tafraout', 26),
(922, '26024', 'Baata', 26),
(923, '26025', 'Boghar', 26),
(924, '26026', 'Sidi Naamane', 26),
(925, '26027', 'Ouled Bouachra', 26),
(926, '26028', 'Sidi Zahar', 26),
(927, '26029', 'Oued Harbil', 26),
(928, '26030', 'Benchicao', 26),
(929, '26031', 'Sidi Damed', 26),
(930, '26032', 'Aziz', 26),
(931, '26033', 'Souagui', 26),
(932, '26034', 'Zoubiria', 26),
(933, '26035', 'Ksar El Boukhari', 26),
(934, '26036', 'El Azizia', 26),
(935, '26037', 'Djouab', 26),
(936, '26038', 'Chahbounia', 26),
(937, '26039', 'Meghraoua', 26),
(938, '26040', 'Cheniguel', 26),
(939, '26041', 'Ain Ouksir', 26),
(940, '26042', 'Oum El Djalil', 26),
(941, '26043', 'Ouamri', 26),
(942, '26044', 'Si Mahdjoub', 26),
(943, '26045', 'Tlatet Eddoair', 26),
(944, '26046', 'Beni Slimane', 26),
(945, '26047', 'Berrouaghia', 26),
(946, '26048', 'Seghouane', 26),
(947, '26049', 'Meftaha', 26),
(948, '26050', 'Mihoub', 26),
(949, '26051', 'Boughezoul', 26),
(950, '26052', 'Tablat', 26),
(951, '26053', 'Deux Bassins', 26),
(952, '26054', 'Draa Essamar', 26),
(953, '26055', 'Sidi Errabia', 26),
(954, '26056', 'Bir Ben Laabed', 26),
(955, '26057', 'El Ouinet', 26),
(956, '26058', 'Ouled Antar', 26),
(957, '26059', 'Bouaichoune', 26),
(958, '26060', 'Hannacha', 26),
(959, '26061', 'Sedraia', 26),
(960, '26062', 'Medjebar', 26),
(961, '26063', 'Khams Djouamaa', 26),
(962, '26064', 'Saneg', 26),
(963, '27001', 'Mostaganem', 27),
(964, '27002', 'Sayada', 27),
(965, '27003', 'Fornaka', 27),
(966, '27004', 'Stidia', 27),
(967, '27005', 'Ain Nouissy', 27),
(968, '27006', 'Hassi Maameche', 27),
(969, '27007', 'Ain Tadles', 27),
(970, '27008', 'Sour', 27),
(971, '27009', 'Oued El Kheir', 27),
(972, '27010', 'Sidi Bellater', 27),
(973, '27011', 'Kheiredine ', 27),
(974, '27012', 'Sidi Ali', 27),
(975, '27013', 'Abdelmalek Ramdane', 27),
(976, '27014', 'Hadjadj', 27),
(977, '27015', 'Nekmaria', 27),
(978, '27016', 'Sidi Lakhdar', 27),
(979, '27017', 'Achaacha', 27),
(980, '27018', 'Khadra', 27),
(981, '27019', 'Bouguirat', 27),
(982, '27020', 'Sirat', 27),
(983, '27021', 'Ain Sidi Cherif', 27),
(984, '27022', 'Mesra', 27),
(985, '27023', 'Mansourah', 27),
(986, '27024', 'Souaflia', 27),
(987, '27025', 'Ouled Boughalem', 27),
(988, '27026', 'Ouled Maallah', 27),
(989, '27027', 'Mezghrane', 27),
(990, '27028', 'Ain Boudinar', 27),
(991, '27029', 'Tazgait', 27),
(992, '27030', 'Safsaf', 27),
(993, '27031', 'Touahria', 27),
(994, '27032', 'El Hassiane', 27),
(995, '28001', 'Msila', 28),
(996, '28002', 'Maadid', 28),
(997, '28003', 'Hammam Dhalaa', 28),
(998, '28004', 'Ouled Derradj', 28),
(999, '28005', 'Tarmount', 28),
(1000, '28006', 'Mtarfa', 28),
(1001, '28007', 'Khoubana', 28),
(1002, '28008', 'Mcif', 28),
(1003, '28009', 'Chellal', 28),
(1004, '28010', 'Ouled Madhi', 28),
(1005, '28011', 'Magra', 28),
(1006, '28012', 'Berhoum', 28),
(1007, '28013', 'Ain Khadra', 28),
(1008, '28014', 'Ouled Addi Guebala', 28),
(1009, '28015', 'Belaiba', 28),
(1010, '28016', 'Sidi Aissa', 28),
(1011, '28017', 'Ain El Hadjel', 28),
(1012, '28018', 'Sidi Hadjeres', 28),
(1013, '28019', 'Ouanougha', 28),
(1014, '28020', 'Bou Saada', 28),
(1015, '28021', 'Ouled Sidi Brahim', 28),
(1016, '28022', 'Sidi Ameur', 28),
(1017, '28023', 'Tamsa', 28),
(1018, '28024', 'Ben Srour', 28),
(1019, '28025', 'Ouled Slimane', 28),
(1020, '28026', 'El Houamed', 28),
(1021, '28027', 'El Hamel', 28),
(1022, '28028', 'Ouled Mansour', 28),
(1023, '28029', 'Maarif', 28),
(1024, '28030', 'Dehahna', 28),
(1025, '28031', 'Bouti Sayah', 28),
(1026, '28032', 'Khettouti Sed Djir', 28),
(1027, '28033', 'Zarzour', 28),
(1028, '28034', 'Oued Chair', 28),
(1029, '28035', 'Benzouh', 28),
(1030, '28036', 'Bir Foda', 28),
(1031, '28037', 'Ain Fares', 28),
(1032, '28038', 'Sidi Mhamed', 28),
(1033, '28039', 'Ouled Atia', 28),
(1034, '28040', 'Souamaa', 28),
(1035, '28041', 'Ain El Melh', 28),
(1036, '28042', 'Medjedel', 28),
(1037, '28043', 'Slim', 28),
(1038, '28044', 'Ain Errich', 28),
(1039, '28045', 'Beni Ilmane', 28),
(1040, '28046', 'Oultene', 28),
(1041, '28047', 'Djebel Messaad', 28),
(1042, '29001', 'Mascara', 29),
(1043, '29002', 'Bou Hanifia', 29),
(1044, '29003', 'Tizi', 29),
(1045, '29004', 'Hacine', 29),
(1046, '29005', 'Maoussa', 29),
(1047, '29006', 'Teghennif', 29),
(1048, '29007', 'El Hachem', 29),
(1049, '29008', 'Sidi Kada', 29),
(1050, '29009', 'Zelmata', 29),
(1051, '29010', 'Oued El Abtal', 29),
(1052, '29011', 'Ain Ferah', 29),
(1053, '29012', 'Ghriss', 29),
(1054, '29013', 'Froha', 29),
(1055, '29014', 'Matemore', 29),
(1056, '29015', 'Makdha', 29),
(1057, '29016', 'Sidi Boussaid', 29),
(1058, '29017', 'El Bordj', 29),
(1059, '29018', 'Ain Fekan', 29),
(1060, '29019', 'Benian', 29),
(1061, '29020', 'Khalouia', 29),
(1062, '29021', 'El Menaouer', 29),
(1063, '29022', 'Oued Taria', 29),
(1064, '29023', 'Aouf', 29),
(1065, '29024', 'Ain Fares', 29),
(1066, '29025', 'Ain Frass', 29),
(1067, '29026', 'Sig', 29),
(1068, '29027', 'Oggaz', 29),
(1069, '29028', 'Alaimia', 29),
(1070, '29029', 'El Gaada', 29),
(1071, '29030', 'Zahana', 29),
(1072, '29031', 'Mohammadia', 29),
(1073, '29032', 'Sidi Abdelmoumene', 29),
(1074, '29033', 'Ferraguig', 29),
(1075, '29034', 'El Ghomri', 29),
(1076, '29035', 'Sedjerara', 29),
(1077, '29036', 'Moctadouz', 29),
(1078, '29037', 'Bou Henni', 29),
(1079, '29038', 'Guettena', 29),
(1080, '29039', 'El Mamounia', 29),
(1081, '29040', 'El Keurt', 29),
(1082, '29041', 'Gharrous', 29),
(1083, '29042', 'Gherdjoum', 29),
(1084, '29043', 'Chorfa', 29),
(1085, '29044', 'Ras Ain Amirouche', 29),
(1086, '29045', 'Nesmot', 29),
(1087, '29046', 'Sidi Abdeldjebar', 29),
(1088, '29047', 'Sehailia', 29),
(1089, '30001', 'Ouargla', 30),
(1090, '30002', 'Ain Beida', 30),
(1091, '30003', 'Ngoussa', 30),
(1092, '30004', 'Hassi Messaoud', 30),
(1093, '30005', 'Rouissat', 30),
(1094, '30006', 'Balidat Ameur', 30),
(1095, '30007', 'Tebesbest', 30),
(1096, '30008', 'Nezla', 30),
(1097, '30009', 'Zaouia El Abidia', 30),
(1098, '30010', 'Sidi Slimane', 30),
(1099, '30011', 'Sidi Khouiled', 30),
(1100, '30012', 'Hassi Ben Abdellah', 30),
(1101, '30013', 'Touggourt', 30),
(1102, '30014', 'El Hadjira', 30),
(1103, '30015', 'Taibet', 30),
(1104, '30016', 'Tamacine', 30),
(1105, '30017', 'Benaceur', 30),
(1106, '30018', 'Mnaguer', 30),
(1107, '30019', 'Megarine', 30),
(1108, '30020', 'El Allia', 30),
(1109, '30021', 'El Borma', 30),
(1110, '31001', 'Oran', 31),
(1111, '31002', 'Gdyel', 31),
(1112, '31003', 'Bir El Djir', 31),
(1113, '31004', 'Hassi Bounif', 31),
(1114, '31005', 'Es Senia', 31),
(1115, '31006', 'Arzew', 31),
(1116, '31007', 'Bethioua', 31),
(1117, '31008', 'Marsat El Hadjadj', 31),
(1118, '31009', 'Ain Turk', 31),
(1119, '31010', 'El Ancar', 31),
(1120, '31011', 'Oued Tlelat', 31),
(1121, '31012', 'Tafraoui', 31),
(1122, '31013', 'Sidi Chami', 31),
(1123, '31014', 'Boufatis', 31),
(1124, '31015', 'Mers El Kebir', 31),
(1125, '31016', 'Bousfer', 31),
(1126, '31017', 'El Karma', 31),
(1127, '31018', 'El Braya', 31),
(1128, '31019', 'Hassi Ben Okba', 31),
(1129, '31020', 'Ben Freha', 31),
(1130, '31021', 'Hassi Mefsoukh', 31),
(1131, '31022', 'Sidi Ben Yabka', 31),
(1132, '31023', 'Messerghin', 31),
(1133, '31024', 'Boutlelis', 31),
(1134, '31025', 'Ain Kerma', 31),
(1135, '31026', 'Ain Biya', 31),
(1136, '32001', 'El Bayadh', 32),
(1137, '32002', 'Rogassa', 32),
(1138, '32003', 'Stitten', 32),
(1139, '32004', 'Brezina', 32),
(1140, '32005', 'Ghassoul', 32),
(1141, '32006', 'Boualem', 32),
(1142, '32007', 'El Abiodh Sidi Cheikh', 32),
(1143, '32008', 'Ain El Orak', 32),
(1144, '32009', 'Arbaouat', 32),
(1145, '32010', 'Bougtoub', 32),
(1146, '32011', 'El Kheither', 32),
(1147, '32012', 'Kef El Ahmar', 32),
(1148, '32013', 'Boussemghoun', 32),
(1149, '32014', 'Chellala', 32),
(1150, '32015', 'Krakda', 32),
(1151, '32016', 'El Bnoud', 32),
(1152, '32017', 'Cheguig', 32),
(1153, '32018', 'Sidi Ameur', 32),
(1154, '32019', 'El Mehara', 32),
(1155, '32020', 'Tousmouline', 32),
(1156, '32021', 'Sidi Slimane', 32),
(1157, '32022', 'Sidi Tifour', 32),
(1158, '33001', 'Illizi', 33),
(1159, '33002', 'Djanet', 33),
(1160, '33003', 'Debdeb', 33),
(1161, '33004', 'Bordj Omar Driss', 33),
(1162, '33005', 'Bordj El Haouasse', 33),
(1163, '33006', 'In Amenas', 33),
(1164, '34001', 'Bordj Bou Arreridj', 34),
(1165, '34002', 'Ras El Oued', 34),
(1166, '34003', 'Bordj Zemoura', 34),
(1167, '34004', 'Mansoura', 34),
(1168, '34005', 'El Mhir', 34),
(1169, '34006', 'Ben Daoud', 34),
(1170, '34007', 'El Achir', 34),
(1171, '34008', 'Ain Taghrout', 34),
(1172, '34009', 'Bordj Ghdir', 34),
(1173, '34010', 'Sidi Embarek', 34),
(1174, '34011', 'El Hamadia', 34),
(1175, '34012', 'Belimour', 34),
(1176, '34013', 'Medjana', 34),
(1177, '34014', 'Teniet En Nasr', 34),
(1178, '34015', 'Djaafra', 34),
(1179, '34016', 'El Main', 34),
(1180, '34017', 'Ouled Brahem', 34),
(1181, '34018', 'Ouled Dahmane', 34),
(1182, '34019', 'Hasnaoua', 34),
(1183, '34020', 'Khelil', 34),
(1184, '34021', 'Taglait', 34),
(1185, '34022', 'Ksour', 34),
(1186, '34023', 'Ouled Sidi Brahim', 34),
(1187, '34024', 'Tafreg', 34),
(1188, '34025', 'Colla', 34),
(1189, '34026', 'Tixter', 34),
(1190, '34027', 'El Ach', 34),
(1191, '34028', 'El Anseur', 34),
(1192, '34029', 'Tesmart', 34),
(1193, '34030', 'Ain Tesra', 34),
(1194, '34031', 'Bir Kasdali', 34),
(1195, '34032', 'Ghilassa', 34),
(1196, '34033', 'Rabta', 34),
(1197, '34034', 'Haraza', 34),
(1198, '35001', 'Boumerdes', 35),
(1199, '35002', 'Boudouaou', 35),
(1200, '35004', 'Afir', 35),
(1201, '35005', 'Bordj Menaiel', 35),
(1202, '35006', 'Baghlia', 35),
(1203, '35007', 'Sidi Daoud', 35),
(1204, '35008', 'Naciria', 35),
(1205, '35009', 'Djinet', 35),
(1206, '35010', 'Isser', 35),
(1207, '35011', 'Zemmouri', 35),
(1208, '35012', 'Si Mustapha', 35),
(1209, '35013', 'Tidjelabine', 35),
(1210, '35014', 'Chabet El Ameur', 35),
(1211, '35015', 'Thenia', 35),
(1212, '35018', 'Timezrit', 35),
(1213, '35019', 'Corso', 35),
(1214, '35020', 'Ouled Moussa', 35),
(1215, '35021', 'Larbatache', 35),
(1216, '35022', 'Bouzegza Keddara', 35),
(1217, '35025', 'Taourga', 35),
(1218, '35026', 'Ouled Aissa', 35),
(1219, '35027', 'Ben Choud', 35),
(1220, '35028', 'Dellys', 35),
(1221, '35029', 'Ammal', 35),
(1222, '35030', 'Beni Amrane', 35),
(1223, '35031', 'Souk El Had', 35),
(1224, '35032', 'Boudouaou El Bahri', 35),
(1225, '35033', 'Ouled Hedadj', 35),
(1226, '35035', 'Laghata', 35),
(1227, '35036', 'Hammedi', 35),
(1228, '35037', 'Khemis El Khechna', 35),
(1229, '35038', 'El Kharrouba', 35),
(1230, '36001', 'El Tarf', 36),
(1231, '36002', 'Bouhadjar', 36),
(1232, '36003', 'Ben Mhidi', 36),
(1233, '36004', 'Bougous', 36),
(1234, '36005', 'El Kala', 36),
(1235, '36006', 'Ain El Assel', 36),
(1236, '36007', 'El Aioun', 36),
(1237, '36008', 'Bouteldja', 36),
(1238, '36009', 'Souarekh', 36),
(1239, '36010', 'Berrihane', 36),
(1240, '36011', 'Lac Des Oiseaux', 36),
(1241, '36012', 'Chefia', 36),
(1242, '36013', 'Drean', 36),
(1243, '36014', 'Chihani', 36),
(1244, '36015', 'Chebaita Mokhtar', 36),
(1245, '36016', 'Besbes', 36),
(1246, '36017', 'Asfour', 36),
(1247, '36018', 'Echatt', 36),
(1248, '36019', 'Zerizer', 36),
(1249, '36020', 'Zitouna', 36),
(1250, '36021', 'Ain Kerma', 36),
(1251, '36022', 'Oued Zitoun', 36),
(1252, '36023', 'Hammam Beni Salah', 36),
(1253, '36024', 'Raml Souk', 36),
(1254, '37001', 'Tindouf', 37),
(1255, '37002', 'Oum El Assel', 37),
(1256, '38001', 'Tissemsilt', 38),
(1257, '38002', 'Bordj Bou Naama', 38),
(1258, '38003', 'Theniet El Had', 38),
(1259, '38004', 'Lazharia', 38),
(1260, '38005', 'Beni Chaib', 38),
(1261, '38006', 'Lardjem', 38),
(1262, '38007', 'Melaab', 38),
(1263, '38008', 'Sidi Lantri', 38),
(1264, '38009', 'Bordj El Emir Abdelkader', 38),
(1265, '38010', 'Layoune', 38),
(1266, '38011', 'Khemisti', 38),
(1267, '38012', 'Ouled Bessem', 38),
(1268, '38013', 'Ammari', 38),
(1269, '38014', 'Youssoufia', 38),
(1270, '38015', 'Sidi Boutouchent', 38),
(1271, '38016', 'Larbaa', 38),
(1272, '38017', 'Maasem', 38),
(1273, '38018', 'Sidi Abed', 38),
(1274, '38019', 'Tamalaht', 38),
(1275, '38020', 'Sidi Slimane', 38),
(1276, '38021', 'Boucaid', 38),
(1277, '38022', 'Beni Lahcene', 38),
(1278, '39001', 'El Oued', 39),
(1279, '39002', 'Robbah', 39),
(1280, '39003', 'Oued El Alenda', 39),
(1281, '39004', 'Bayadha', 39),
(1282, '39005', 'Nakhla', 39),
(1283, '39006', 'Guemar', 39),
(1284, '39007', 'Kouinine', 39),
(1285, '39008', 'Reguiba', 39),
(1286, '39009', 'Hamraia', 39),
(1287, '39010', 'Taghzout', 39),
(1288, '39011', 'Debila', 39),
(1289, '39012', 'Hassani Abdelkrim', 39),
(1290, '39013', 'Hassi Khelifa', 39),
(1291, '39014', 'Taleb Larbi', 39),
(1292, '39015', 'Douar El Ma', 39),
(1293, '39016', 'Sidi Aoun', 39),
(1294, '39017', 'Trifaoui', 39),
(1295, '39018', 'Magrane', 39),
(1296, '39019', 'Beni Guecha', 39),
(1297, '39020', 'Ourmas', 39),
(1298, '39021', 'Still', 39),
(1299, '39022', 'Mrara', 39),
(1300, '39023', 'Sidi Khellil', 39),
(1301, '39024', 'Tendla', 39),
(1302, '39025', 'El Ogla', 39),
(1303, '39026', 'Mih Ouansa', 39),
(1304, '39027', 'El Mghair', 39),
(1305, '39028', 'Djamaa', 39),
(1306, '39029', 'Oum Touyour', 39),
(1307, '39030', 'Sidi Amrane', 39),
(1308, '40001', 'Khenchela', 40),
(1309, '40002', 'Mtoussa', 40),
(1310, '40003', 'Kais', 40),
(1311, '40004', 'Baghai', 40),
(1312, '40005', 'El Hamma', 40),
(1313, '40006', 'Ain Touila', 40),
(1314, '40007', 'Taouzianat', 40),
(1315, '40008', 'Bouhmama', 40),
(1316, '40009', 'El Oueldja', 40),
(1317, '40010', 'Remila', 40),
(1318, '40011', 'Cherchar', 40),
(1319, '40012', 'Djellal', 40),
(1320, '40013', 'Babar', 40),
(1321, '40014', 'Tamza', 40),
(1322, '40015', 'Ensigha', 40),
(1323, '40016', 'Ouled Rechache', 40),
(1324, '40017', 'El Mahmal', 40),
(1325, '40018', 'Msara', 40),
(1326, '40019', 'Yabous', 40),
(1327, '40020', 'Khirane', 40),
(1328, '40021', 'Chelia', 40),
(1329, '41001', 'Souk Ahras', 41),
(1330, '41002', 'Sedrata', 41),
(1331, '41003', 'Hanancha', 41),
(1332, '41004', 'Mechroha', 41),
(1333, '41005', 'Ouled Driss', 41),
(1334, '41006', 'Tiffech', 41),
(1335, '41007', 'Zaarouria', 41),
(1336, '41008', 'Taoura', 41),
(1337, '41009', 'Drea', 41),
(1338, '41010', 'Haddada', 41),
(1339, '41011', 'Khedara', 41),
(1340, '41012', 'Merahna', 41),
(1341, '41013', 'Ouled Moumen', 41),
(1342, '41014', 'Bir Bouhouche', 41),
(1343, '41015', 'Mdaourouche', 41),
(1344, '41016', 'Oum El Adhaim', 41),
(1345, '41017', 'Ain Zana', 41),
(1346, '41018', 'Ain Soltane', 41),
(1347, '41019', 'Quillen', 41),
(1348, '41020', 'Sidi Fredj', 41),
(1349, '41021', 'Safel El Ouiden', 41),
(1350, '41022', 'Ragouba', 41),
(1351, '41023', 'Khemissa', 41),
(1352, '41024', 'Oued Keberit', 41),
(1353, '41025', 'Terraguelt', 41),
(1354, '41026', 'Zouabi', 41),
(1355, '42001', 'Tipaza', 42),
(1356, '42002', 'Menaceur', 42),
(1357, '42003', 'Larhat', 42),
(1358, '42004', 'Douaouda', 42),
(1359, '42005', 'Bourkika', 42),
(1360, '42006', 'Khemisti', 42),
(1361, '42010', 'Aghabal', 42),
(1362, '42012', 'Hadjout', 42),
(1363, '42013', 'Sidi Amar', 42),
(1364, '42014', 'Gouraya', 42),
(1365, '42015', 'Nodor', 42),
(1366, '42016', 'Chaiba', 42),
(1367, '42017', 'Ain Tagourait', 42),
(1368, '42022', 'Cherchel', 42),
(1369, '42023', 'Damous', 42),
(1370, '42024', 'Meurad', 42),
(1371, '42025', 'Fouka', 42),
(1372, '42026', 'Bou Ismail', 42),
(1373, '42027', 'Ahmer El Ain', 42),
(1374, '42030', 'Bou Haroun', 42),
(1375, '42032', 'Sidi Ghiles', 42),
(1376, '42033', 'Messelmoun', 42),
(1377, '42034', 'Sidi Rached', 42),
(1378, '42035', 'Kolea', 42),
(1379, '42036', 'Attatba', 42),
(1380, '42040', 'Sidi Semiane', 42),
(1381, '42041', 'Beni Milleuk', 42),
(1382, '42042', 'Hadjerat Ennous', 42),
(1383, '43001', 'Mila', 43),
(1384, '43002', 'Ferdjioua', 43),
(1385, '43003', 'Chelghoum Laid', 43),
(1386, '43004', 'Oued Athmenia', 43),
(1387, '43005', 'Ain Mellouk', 43),
(1388, '43006', 'Telerghma', 43),
(1389, '43007', 'Oued Seguen', 43),
(1390, '43008', 'Tadjenanet', 43),
(1391, '43009', 'Benyahia Abderrahmane', 43),
(1392, '43010', 'Oued Endja', 43),
(1393, '43011', 'Ahmed Rachedi', 43),
(1394, '43012', 'Ouled Khalouf', 43),
(1395, '43013', 'Tiberguent', 43),
(1396, '43014', 'Bouhatem', 43),
(1397, '43015', 'Rouached', 43),
(1398, '43016', 'Tessala Lamatai', 43),
(1399, '43017', 'Grarem Gouga', 43),
(1400, '43018', 'Sidi Merouane', 43),
(1401, '43019', 'Tassadane Haddada', 43),
(1402, '43020', 'Derradji Bousselah', 43),
(1403, '43021', 'Minar Zarza', 43),
(1404, '43022', 'Amira Arras', 43),
(1405, '43023', 'Terrai Bainen', 43),
(1406, '43024', 'Hamala', 43),
(1407, '43025', 'Ain Tine', 43),
(1408, '43026', 'El Mechira', 43),
(1409, '43027', 'Sidi Khelifa', 43),
(1410, '43028', 'Zeghaia', 43),
(1411, '43029', 'Elayadi Barbes', 43),
(1412, '43030', 'Ain Beida Harriche', 43),
(1413, '43031', 'Yahia Beniguecha', 43),
(1414, '43032', 'Chigara', 43),
(1415, '44001', 'Ain Defla', 44),
(1416, '44002', 'Miliana', 44),
(1417, '44003', 'Boumedfaa', 44),
(1418, '44004', 'Khemis Miliana', 44),
(1419, '44005', 'Hammam Righa', 44),
(1420, '44006', 'Arib', 44),
(1421, '44007', 'Djelida', 44),
(1422, '44008', 'El Amra', 44),
(1423, '44009', 'Bourached', 44),
(1424, '44010', 'El Attaf', 44),
(1425, '44011', 'El Abadia', 44),
(1426, '44012', 'Djendel', 44),
(1427, '44013', 'Oued Chorfa', 44),
(1428, '44014', 'Ain Lechiakh', 44),
(1429, '44015', 'Oued Djemaa', 44),
(1430, '44016', 'Rouina', 44),
(1431, '44017', 'Zeddine', 44),
(1432, '44018', 'El Hassania', 44),
(1433, '44019', 'Bir Ouled Khelifa', 44),
(1434, '44020', 'Ain Soltane', 44),
(1435, '44021', 'Tarik Ibn Ziad', 44),
(1436, '44022', 'Bordj Emir Khaled', 44),
(1437, '44023', 'Ain Torki', 44),
(1438, '44024', 'Sidi Lakhdar', 44),
(1439, '44025', 'Ben Allal', 44),
(1440, '44026', 'Ain Benian', 44),
(1441, '44027', 'Hoceinia', 44),
(1442, '44028', 'Barbouche', 44),
(1443, '44029', 'Djemaa Ouled Chikh', 44),
(1444, '44030', 'Mekhatria', 44),
(1445, '44031', 'Bathia', 44),
(1446, '44032', 'Tachta Zegagha', 44),
(1447, '44033', 'Ain Bouyahia', 44),
(1448, '44034', 'El Maine', 44),
(1449, '44035', 'Tiberkanine', 44),
(1450, '44036', 'Belaas', 44),
(1451, '45001', 'Naama', 45),
(1452, '45002', 'Mechria', 45),
(1453, '45003', 'Ain Sefra', 45),
(1454, '45004', 'Tiout', 45),
(1455, '45005', 'Sfissifa', 45),
(1456, '45006', 'Moghrar', 45),
(1457, '45007', 'Assela', 45),
(1458, '45008', 'Djeniane Bourzeg', 45),
(1459, '45009', 'Ain Ben Khelil', 45),
(1460, '45010', 'Makman Ben Amer', 45),
(1461, '45011', 'Kasdir', 45),
(1462, '45012', 'El Biod', 45),
(1463, '46001', 'Ain Temouchent', 46),
(1464, '46002', 'Chaabet El Ham', 46),
(1465, '46003', 'Ain Kihal', 46),
(1466, '46004', 'Hammam Bouhadjar', 46),
(1467, '46005', 'Bou Zedjar', 46),
(1468, '46006', 'Oued Berkeche', 46),
(1469, '46007', 'Aghlal', 46),
(1470, '46008', 'Terga', 46),
(1471, '46009', 'Ain El Arbaa', 46),
(1472, '46010', 'Tamzoura', 46),
(1473, '46011', 'Chentouf', 46),
(1474, '46012', 'Sidi Ben Adda', 46),
(1475, '46013', 'Aoubellil', 46),
(1476, '46014', 'El Malah', 46),
(1477, '46015', 'Sidi Boumediene', 46),
(1478, '46016', 'Oued Sabah', 46),
(1479, '46017', 'Ouled Boudjemaa', 46),
(1480, '46018', 'Ain Tolba', 46),
(1481, '46019', 'El Amria', 46),
(1482, '46020', 'Hassi El Ghella', 46),
(1483, '46021', 'Hassasna', 46),
(1484, '46022', 'Ouled Kihal', 46),
(1485, '46023', 'Beni Saf', 46),
(1486, '46024', 'Sidi Safi', 46),
(1487, '46025', 'Oulhaca El Gheraba', 46),
(1488, '46026', 'Tadmaya', 46),
(1489, '46027', 'El Emir Abdelkader', 46),
(1490, '46028', 'El Messaid', 46),
(1491, '47001', 'Ghardaia', 47),
(1492, '47002', 'El Meniaa', 47),
(1493, '47003', 'Dhayet Bendhahoua', 47),
(1494, '47004', 'Berriane', 47),
(1495, '47005', 'Metlili', 47),
(1496, '47006', 'El Guerrara', 47),
(1497, '47007', 'El Atteuf', 47),
(1498, '47008', 'Zelfana', 47),
(1499, '47009', 'Sebseb', 47),
(1500, '47010', 'Bounoura', 47),
(1501, '47011', 'Hassi Fehal', 47),
(1502, '47012', 'Hassi Gara', 47),
(1503, '47013', 'Mansoura', 47),
(1504, '48001', 'Relizane', 48),
(1505, '48002', 'Oued Rhiou', 48),
(1506, '48003', 'Belaassel Bouzegza', 48),
(1507, '48004', 'Sidi Saada', 48),
(1508, '48005', 'Ouled Aiche', 48),
(1509, '48006', 'Sidi Lazreg', 48),
(1510, '48007', 'El Hamadna', 48),
(1511, '48008', 'Sidi Mhamed Ben Ali', 48),
(1512, '48009', 'Mediouna', 48),
(1513, '48010', 'Sidi Khettab', 48),
(1514, '48011', 'Ammi Moussa', 48),
(1515, '48012', 'Zemmoura', 48),
(1516, '48013', 'Beni Dergoun', 48),
(1517, '48014', 'Djidiouia', 48),
(1518, '48015', 'El Guettar', 48),
(1519, '48016', 'Hamri', 48),
(1520, '48017', 'El Matmar', 48),
(1521, '48018', 'Sidi Mhamed Ben Aouda', 48),
(1522, '48019', 'Ain Tarek', 48),
(1523, '48020', 'Oued Essalem', 48),
(1524, '48021', 'Ouarizane', 48),
(1525, '48022', 'Mazouna', 48),
(1526, '48023', 'Kalaa', 48),
(1527, '48024', 'Ain Rahma', 48),
(1528, '48025', 'Yellel', 48),
(1529, '48026', 'Oued El Djemaa', 48),
(1530, '48027', 'Ramka', 48),
(1531, '48028', 'Mendes', 48),
(1532, '48029', 'Lahlef', 48),
(1533, '48030', 'Beni Zentis', 48),
(1534, '48031', 'Souk El Haad', 48),
(1535, '48032', 'Dar Ben Abdellah', 48),
(1536, '48033', 'El Hassi', 48),
(1537, '48034', 'Had Echkalla', 48),
(1538, '48035', 'Bendaoud', 48),
(1539, '48036', 'El Ouldja', 48),
(1540, '48037', 'Merdja Sidi Abed', 48),
(1541, '48038', 'Ouled Sidi Mihoub', 48);

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
(20, '2024_07_04_124120_create_preferences_of_showcase_table', 1),
(21, '2024_07_10_175701_add_is_leaf_category_column_to_productsCategories_table', 2),
(22, '2024_07_18_122236_create_carts_table', 3),
(23, '2024_07_18_122404_create_carts_items_table', 3),
(24, '2024_07_18_122405_create_cartsItems_table', 4),
(25, '2024_07_18_122237_create_carts_table', 5),
(26, '2024_07_18_122406_create_cartsItems_table', 5),
(27, '2024_07_18_122238_create_carts_table', 6),
(28, '2024_07_18_122407_create_cartsItems_table', 6),
(29, '2024_07_22_135140_add_email_verification_token_field_tousers_table', 7),
(30, '2024_07_23_114555_create_wilayas_table', 8),
(31, '2024_07_23_114556_create_wilayas_table', 9),
(32, '2024_07_23_114638_create_communes_table', 9),
(33, '2024_07_23_114557_create_wilayas_table', 10),
(34, '2024_07_23_114639_create_communes_table', 10);

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
  `price` decimal(8,2) NOT NULL,
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
(5, 'DYED OXFORD - Chemise', 'DYED OXFORD - Chemise', 1, NULL, 1800.00, '2024-07-06 14:07:02', '2024-07-06 14:07:02', 1, 4),
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
(16, 'CHALLENGER™ - Veste coupe-vent', 'CHALLENGER™ - Veste coupe-vent', 1, NULL, 6800.00, '2024-07-06 15:08:04', '2024-07-06 15:08:04', 1, 3);

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
(2, 'Couleur', 'Couleur'),
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
  `parent_id` smallint(5) UNSIGNED DEFAULT NULL,
  `is_leaf_category` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `productscategories`
--

INSERT INTO `productscategories` (`id`, `name`, `description`, `image_path`, `ordering`, `is_active`, `show_on_website_header`, `created_at`, `updated_at`, `added_by`, `parent_id`, `is_leaf_category`) VALUES
(1, 'Homme', 'Homme', 'products_categories/id_1/PWkORM6oxR2Y68VBzdHqJPjmu8bX2fwL8wN0HApB.jpg', NULL, 1, 1, '2024-07-05 08:21:40', '2024-07-10 18:58:58', 1, NULL, 0),
(2, 'T-shirts homme', 'T-shirts homme', 'products_categories/id_2/poJALDbGTSKm1tGVF7mvtwacQATOxpvp0gnEjXIr.jpg', NULL, 1, 0, '2024-07-05 08:35:34', '2024-07-06 10:58:25', 1, 1, 1),
(3, 'Chemises Homme', 'Chemises Homme', 'products_categories/id_3/OUKuAPzLr2UFkHEU7qeabNa1WQuGqPdhGwQpWK62.png', NULL, 1, 0, '2024-07-05 08:58:32', '2024-07-06 10:58:25', 1, 1, 1),
(4, 'Sweats et hoodies homme', 'Sweats et hoodies homme', 'products_categories/id_4/qpXNmZmkMY6TcHYenXk5V9cMRk4I1fOYHQAxwaew.png', NULL, 1, 0, '2024-07-05 09:02:20', '2024-07-06 10:58:25', 1, 1, 1),
(5, 'Jeans Homme', 'Jeans Homme', 'products_categories/id_5/BpHFixYp60meynpNcgnc44Dt44GphtTeuK8Ctsqg.png', NULL, 1, 0, '2024-07-05 09:04:22', '2024-07-06 10:58:25', 1, 1, 1),
(6, 'Vestes Homme', 'Vestes Homme', 'products_categories/id_6/AF3Hn6qmCA0EGIw2zvwpsWqa1GiFkxVu2zgEhfdT.png', NULL, 1, 0, '2024-07-05 09:20:27', '2024-07-06 10:58:25', 1, 1, 1),
(7, 'Vêtements de sport homme', 'Vêtements de sport homme', 'products_categories/id_7/OCVk2NuMOe3gVPoNP8mMT7FczdxddYmrAxyZrulg.png', NULL, 1, 0, '2024-07-05 09:44:28', '2024-07-06 10:58:25', 1, 1, 1),
(8, 'Manteaux Homme', 'Manteaux Homme', 'products_categories/id_8/ouiku8hqnXjztydgp0yABELx06xPUsAv3g3nToiq.png', NULL, 1, 0, '2024-07-05 09:49:00', '2024-07-06 10:58:25', 1, 1, 1),
(9, 'Femme', 'Femme', 'products_categories/id_9/P13Hsf86zElqW0ZEx3hNvfjnp9M7xnferzBXorwD.png', NULL, 1, 0, '2024-07-05 09:54:33', '2024-07-05 09:54:54', 1, NULL, 0),
(10, 'Tops & T-shirts femme', 'Tops & T-shirts femme', 'products_categories/id_10/EXgKEGyTT97Wkxo95UiBLoP41FIMBwBgPljedzBi.png', NULL, 1, 0, '2024-07-05 09:58:35', '2024-07-05 09:58:35', 1, 9, 1),
(11, 'Chemises Femme', 'Chemises Femme', 'products_categories/id_11/h6kK6YdfKH77oI0rbfzoCGC1HAOkpzp2Qg1IKMr0.png', NULL, 1, 0, '2024-07-05 10:01:53', '2024-07-05 10:01:53', 1, 9, 1),
(12, 'Vestes femme', 'Vestes femme', 'products_categories/id_12/y4uxuDzqrQmB0kj5iU1NdKhuIGN5wysbThklQQDu.png', NULL, 1, 0, '2024-07-05 10:10:38', '2024-07-05 10:10:38', 1, 9, 1),
(13, 'Manteaux femme', 'Manteaux femme', 'products_categories/id_13/yvFz5rtf0ch5qoQTgxVdcXWsFVL7iqXAUKrQ7GPX.png', NULL, 1, 0, '2024-07-05 10:12:55', '2024-07-05 10:12:55', 1, 9, 1),
(14, 'Enfant', 'Enfant', 'products_categories/id_14/FWrtadqx8c3gT9TFk0LBxHg33lJ4j42g6dp9686m.png', NULL, 1, 0, '2024-07-05 10:17:34', '2024-07-05 10:17:59', 1, NULL, 0),
(17, 'Bébé', 'Bébé', 'products_categories/id_17/vsOMHZxDxXcvjwPkoQtfYyyGdFy04KNXLF2o4Hw0.png', NULL, 1, 0, '2024-07-05 10:32:29', '2024-07-05 10:32:29', 1, 14, 0),
(18, 'Garçon', 'Garçon', 'products_categories/id_18/50TJI3nu5xrJTpSeDgCx8oybjv2IClKqyss1ZkwH.png', NULL, 1, 0, '2024-07-05 10:34:39', '2024-07-05 10:34:39', 1, 14, 0),
(19, 'Fille', 'Fille', 'products_categories/id_19/J4QrI3R83b9p6FAh64C1wYOEuZP1vxTjo41u59pj.png', NULL, 1, 0, '2024-07-05 10:37:30', '2024-07-05 10:37:30', 1, 14, 0),
(20, 'Jeans Garçons', 'Jeans Garçons', 'products_categories/id_20/weqp2FYZnRWaWUqvEqw6C30pFuHOhbrD6a0mXKVV.png', NULL, 1, 0, '2024-07-05 10:40:17', '2024-07-05 10:40:17', 1, 18, 1),
(21, 'Jeans Filles', 'Jeans Filles', 'products_categories/id_21/tvHwJMn92SWjhz9KvPrFN4VGfWIwhaYhmvi791uQ.png', NULL, 1, 0, '2024-07-05 10:40:41', '2024-07-05 10:40:41', 1, 19, 1),
(22, 'T-shirts Garçons', 'T-shirts Garçons', 'products_categories/id_22/FzbqgDH5l0Wl2mEX0H4tLbJgZ8Sd5ZaV60Ifl3U4.png', NULL, 1, 0, '2024-07-05 10:41:27', '2024-07-05 10:41:27', 1, 18, 1),
(23, 'Shorts Garçons', 'Shorts Garçons', 'products_categories/id_23/K5FiCLNpE4uaXfmtyhC9z1h4y8iDIq4DKN5WZ124.png', NULL, 1, 0, '2024-07-05 10:45:13', '2024-07-05 10:45:13', 1, 18, 1),
(24, 'Chemises Garçons', 'Chemises Garçons', 'products_categories/id_24/xSeII3RRrEVdHytYEh1R8s6IPl6HhsgQcLyVH4cf.png', NULL, 1, 0, '2024-07-05 10:48:50', '2024-07-05 10:48:50', 1, 18, 1),
(25, 'T-shirts Filles', 'T-shirts Filles', 'products_categories/id_25/HQ889rsET3IcE5iizuf2CHI4D3usr1Sd5F3HnqN6.png', NULL, 1, 0, '2024-07-05 10:51:44', '2024-07-05 10:51:44', 1, 19, 1),
(26, 'Robes Filles', 'Robes Filles', 'products_categories/id_26/RriPNoPZCNwY9QhTuEOtF1i9BzE9x71hMCIaTTdE.png', NULL, 1, 0, '2024-07-05 10:55:36', '2024-07-05 10:55:36', 1, 19, 1),
(27, 'Vestes Filles', 'Vestes Filles', 'products_categories/id_27/h4M2aWmNnfWd86tEqxD1I5PWlmY49Dn03uSdZl3i.png', NULL, 1, 0, '2024-07-05 10:59:08', '2024-07-05 10:59:08', 1, 19, 1),
(28, 'Manteaux Garçons', 'Manteaux Garçons', 'products_categories/id_28/7HHObfP8F968unGiHm2LFJaYSzXK3RvO9ONrYrkz.png', NULL, 1, 0, '2024-07-05 11:00:59', '2024-07-05 11:00:59', 1, 18, 1),
(29, 'T-shirts Bébé', 'T-shirts Bébé', 'products_categories/id_29/Mk4RD8R6juOmbGJzVYtdicxsuUzIyLo4l70WA1PV.png', NULL, 1, 0, '2024-07-05 11:06:13', '2024-07-05 11:06:13', 1, 17, 1),
(30, 'Grenouillères bébé', 'Grenouillères bébé', 'products_categories/id_30/wr9N7m8HVT8neeG5U8wW64iALijxXhskBJHT9jTy.png', NULL, 1, 0, '2024-07-05 11:09:48', '2024-07-05 11:09:48', 1, 17, 1),
(31, 'Chaussures Hommes', 'Chaussures Hommes', 'products_categories/id_31/Hd2J4G6cARs4P0Kf4uXWSf0QvLvrnJoAVaVYN60G.png', NULL, 1, 0, '2024-07-05 11:17:06', '2024-07-06 10:58:25', 1, 1, 1),
(32, 'Chaussures Femmes', 'Chaussures Femmes', 'products_categories/id_32/UuKNGmW41RDMRDcO8fNcUejAC55mwxDJC5u1AOVu.png', NULL, 1, 0, '2024-07-05 11:19:44', '2024-07-05 11:19:44', 1, 9, 1),
(33, 'Chaussures Garçons', 'Chaussures Garçons', 'products_categories/id_33/xxTCgbj63X6wqjwF0bSErJLeU22pEejTZnLoICsn.png', NULL, 1, 0, '2024-07-05 11:21:50', '2024-07-05 11:21:50', 1, 18, 1),
(34, 'Chaussures Filles', 'Chaussures Filles', 'products_categories/id_34/sLmDNc5mxR9Sr6wk8FykBIkroUoJ4hR5pnPpRiV3.png', NULL, 1, 0, '2024-07-05 11:24:41', '2024-07-05 11:24:41', 1, 19, 1),
(35, 'Chaussures Bébé', 'Chaussures Bébé', 'products_categories/id_35/dHzwCxMZgOv4XZ6VpTMep68uVFJ2HKJWizZ7oIlN.png', NULL, 1, 0, '2024-07-05 11:26:32', '2024-07-05 11:26:32', 1, 17, 1);

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
(2, 2, 0),
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
  `price` decimal(8,2) DEFAULT NULL,
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
(1, 2800.00, 3, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-23 10:30:32'),
(2, 2500.00, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-08 10:44:28'),
(3, 2500.00, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-08 10:44:28'),
(4, 2500.00, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-08 10:44:28'),
(5, 2300.00, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-08 10:44:28'),
(6, 2500.00, 19, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-20 19:04:45'),
(7, 2500.00, 19, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-20 19:05:51'),
(8, 2500.00, 20, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-08 10:44:28'),
(9, 2500.00, 19, 1, NULL, 2, '2024-07-06 13:32:49', '2024-07-20 19:06:21'),
(10, 2500.00, 20, 1, NULL, 3, '2024-07-06 13:47:53', '2024-07-25 13:31:46'),
(11, 2500.00, 25, 1, NULL, 3, '2024-07-06 13:47:53', '2024-07-08 09:18:31'),
(12, 2500.00, 25, 1, NULL, 3, '2024-07-06 13:47:53', '2024-07-23 10:30:22'),
(13, 2500.00, 25, 1, NULL, 3, '2024-07-06 13:47:54', '2024-07-21 17:58:46'),
(14, 2500.00, 25, 1, NULL, 3, '2024-07-06 13:47:54', '2024-07-08 09:18:31'),
(15, 2500.00, 25, 1, NULL, 3, '2024-07-06 13:47:54', '2024-07-08 09:18:31'),
(16, 2500.00, 25, 1, NULL, 3, '2024-07-06 13:47:54', '2024-07-08 09:18:31'),
(17, 2500.00, 25, 1, NULL, 3, '2024-07-06 13:47:54', '2024-07-08 09:18:31'),
(18, 2500.00, 21, 1, NULL, 3, '2024-07-06 13:47:54', '2024-07-25 13:32:01'),
(19, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(20, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(21, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-20 19:13:34'),
(22, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(23, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(24, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-20 19:12:11'),
(25, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(26, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(27, NULL, 15, 1, NULL, 4, '2024-07-06 14:00:02', '2024-07-06 14:00:02'),
(28, NULL, 33, 1, NULL, 5, '2024-07-06 14:07:02', '2024-07-23 18:27:22'),
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
(88, NULL, 12, 1, NULL, 11, '2024-07-06 14:45:19', '2024-07-20 19:13:17'),
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
(148, NULL, 10, 1, NULL, 16, '2024-07-06 15:08:05', '2024-07-06 15:08:05'),
(149, 2500.00, 15, 1, NULL, 2, '2024-07-15 18:08:29', '2024-07-22 17:13:33'),
(150, NULL, 15, 1, NULL, 2, '2024-07-21 18:00:09', '2024-07-21 18:00:09');

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
(1, 3, 13),
(2, 1, 2),
(2, 2, 11),
(2, 3, 14),
(3, 1, 2),
(3, 2, 8),
(3, 3, 15),
(4, 1, 3),
(4, 2, 6),
(4, 3, 16),
(5, 1, 3),
(5, 2, 7),
(5, 3, 14),
(6, 1, 3),
(6, 2, 10),
(6, 3, 15),
(7, 1, 4),
(7, 2, 10),
(7, 3, 16),
(8, 1, 4),
(8, 2, 7),
(8, 3, 13),
(9, 1, 4),
(9, 2, 11),
(9, 3, 16),
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
(148, 2, 11),
(149, 1, 1),
(149, 2, 17),
(149, 3, 15),
(150, 1, 1),
(150, 2, 11),
(150, 3, 14);

-- --------------------------------------------------------

--
-- Structure de la table `systempermissions`
--

CREATE TABLE `systempermissions` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `systempermissions`
--

INSERT INTO `systempermissions` (`id`, `name`) VALUES
(3, 'catégories des produits'),
(4, 'commandes'),
(2, 'Produits'),
(1, 'Utilisateurs');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `role` enum('admin','user','client') NOT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `email_verification_token` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `phone`, `birth_date`, `image_path`, `is_active`, `last_login`, `role`, `added_by`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `email_verification_token`) VALUES
(1, 'Ayoub', 'Kheyar', 'a', 'a@a.com', '$2y$10$fKuYXgInREPJZFJ19iNF7.iRpq4ExxcuT.M0A1IFe92HfqUwWQOPe', '0785496521', '2000-01-12', 'users/id_1/admin.jpg', 1, '2024-07-25 12:42:04', 'admin', NULL, NULL, NULL, '2024-07-04 19:47:49', '2024-07-25 11:42:04', NULL, ''),
(28, 'Kheyar', 'Ayoub', NULL, 'itsayoubkheyar06@gmail.com', '$2y$10$5wGmNcwZ8BIGNGToZkEvD.Nd6MUGfs/5nlxRjOAgAUHwHn17qJv4e', '0541614618', NULL, NULL, 1, '2024-07-25 14:32:42', 'client', NULL, '2024-07-25 11:47:47', NULL, '2024-07-25 11:46:11', '2024-07-25 13:32:42', NULL, '');

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

-- --------------------------------------------------------

--
-- Structure de la table `wilayas`
--

CREATE TABLE `wilayas` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `code` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `wilayas`
--

INSERT INTO `wilayas` (`id`, `code`, `name`) VALUES
(1, 1, 'Adrar'),
(2, 2, 'Chlef'),
(3, 3, 'Laghouat'),
(4, 4, 'Oum El Bouaghi'),
(5, 5, 'Batna'),
(6, 6, 'Béjaïa'),
(7, 7, 'Biskra'),
(8, 8, 'Béchar'),
(9, 9, 'Blida'),
(10, 10, 'Bouira'),
(11, 11, 'Tamanrasset'),
(12, 12, 'Tébessa'),
(13, 13, 'Tlemcen'),
(14, 14, 'Tiaret'),
(15, 15, 'Tizi Ouzou'),
(16, 16, 'Alger'),
(17, 17, 'Djelfa'),
(18, 18, 'Jijel'),
(19, 19, 'Sétif'),
(20, 20, 'Saïda'),
(21, 21, 'Skikda'),
(22, 22, 'Sidi Bel Abbès'),
(23, 23, 'Annaba'),
(24, 24, 'Guelma'),
(25, 25, 'Constantine'),
(26, 26, 'Médéa'),
(27, 27, 'Mostaganem'),
(28, 28, 'M\'Sila'),
(29, 29, 'Mascara'),
(30, 30, 'Ouargla'),
(31, 31, 'Oran'),
(32, 32, 'El Bayadh'),
(33, 33, 'Illizi'),
(34, 34, 'Bordj Bou Arreridj'),
(35, 35, 'Boumerdès'),
(36, 36, 'El Tarf'),
(37, 37, 'Tindouf'),
(38, 38, 'Tissemsilt'),
(39, 39, 'El Oued'),
(40, 40, 'Khenchela'),
(41, 41, 'Souk Ahras'),
(42, 42, 'Tipaza'),
(43, 43, 'Mila'),
(44, 44, 'Aïn Defla'),
(45, 45, 'Naâma'),
(46, 46, 'Aïn Témouchent'),
(47, 47, 'Ghardaïa'),
(48, 48, 'Relizane');

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
-- Index pour la table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cartsitems`
--
ALTER TABLE `cartsitems`
  ADD PRIMARY KEY (`cart_id`,`productVariation_id`),
  ADD KEY `cartsitems_productvariation_id_foreign` (`productVariation_id`);

--
-- Index pour la table `communes`
--
ALTER TABLE `communes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `communes_wilaya_id_foreign` (`wilaya_id`);

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
-- Index pour la table `wilayas`
--
ALTER TABLE `wilayas`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT pour la table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `communes`
--
ALTER TABLE `communes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1542;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `productsimages`
--
ALTER TABLE `productsimages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `productsvariations`
--
ALTER TABLE `productsvariations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT pour la table `systempermissions`
--
ALTER TABLE `systempermissions`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `userspermissions`
--
ALTER TABLE `userspermissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `wilayas`
--
ALTER TABLE `wilayas`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

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
-- Contraintes pour la table `cartsitems`
--
ALTER TABLE `cartsitems`
  ADD CONSTRAINT `cartsitems_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cartsitems_productvariation_id_foreign` FOREIGN KEY (`productVariation_id`) REFERENCES `productsvariations` (`id`);

--
-- Contraintes pour la table `communes`
--
ALTER TABLE `communes`
  ADD CONSTRAINT `communes_wilaya_id_foreign` FOREIGN KEY (`wilaya_id`) REFERENCES `wilayas` (`id`);

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
