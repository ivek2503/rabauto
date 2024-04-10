-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 05:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zavrsni_ivan_magdalenic`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `ID` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email_adresa` varchar(100) NOT NULL,
  `hash_lozinka` varchar(255) NOT NULL,
  `admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`ID`, `ime`, `prezime`, `username`, `email_adresa`, `hash_lozinka`, `admin`) VALUES
(1, 'ivan', 'Magdalenić', 'ivek', 'magdalenic84@gmail.com', '$2y$10$Bfv01w4U5xWkEiMB8W5Yj.a2JakYFJ9U4xH9UU3BBAeLq2UQvJ9aO', 1),
(6, 'ivan', 'Magdalenić', 'Ivek1', 'ivanpivan84@gmail.com', '$2y$10$uZ.mSszmrD8KTbpJmALJCedi76CpyIruVASJN4tWLPHMawhNp5hm.', NULL),
(8, 'sinisa', 'magdalenic', 'sinisa', 'cikoyuk@gmail.com', '$2y$10$fIfLs9Ah2Ure5IsLfVNSD.C6JtTLB4lxnAaIUrPMEJ6lQgP75RVFm', NULL),
(9, 'niko', 'Magdalenić', 'nikec', 'nmagdalenic26@gmail.com', '$2y$10$lF7TXikCAkxSWAC11Phea.PTgi7nxjTTbbaQ6iw/137j4qse8H7im', NULL),
(10, 'Franjo', 'Kranjcec', 'ferika', 'franjokranjcec9@gmail.com', '$2y$10$s7k065FOQSFYltAMhuokUuLrp1IR6BEsQsoAi9h/qbOWpaG7fou/e', NULL),
(11, 'ivan', 'magdalenic', 'ivica123', 'ivan.magdalenic@skole.hr', '$2y$10$mZcQcM/woSi2efdRTqiIPuzcwTuxQGIqsRTTznS/IdGOUqghAtjQK', NULL),
(12, 'Štefanija', 'Magdalenić', 'stefica', 'dekeki12@gmail.com', '$2y$10$iDhrNl0U.obAWHEPVofFYOoxXvT9PryAw3F5v8hW1z6ZTYGtX/xKG', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `marke`
--

CREATE TABLE `marke` (
  `ID_marke` int(11) NOT NULL,
  `naziv_marke` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `marke`
--

INSERT INTO `marke` (`ID_marke`, `naziv_marke`) VALUES
(1, 'Audi'),
(2, 'BMW'),
(3, 'Mercedes-Benz'),
(4, 'Volkswagen'),
(5, 'Toyota'),
(6, 'Honda'),
(7, 'Ford'),
(8, 'Chevrolet'),
(9, 'Nissan'),
(10, 'Hyundai'),
(11, 'Kia'),
(12, 'Fiat'),
(13, 'Mazda'),
(14, 'Renault'),
(15, 'Subaru');

-- --------------------------------------------------------

--
-- Table structure for table `modeli`
--

CREATE TABLE `modeli` (
  `id_modela` int(11) NOT NULL,
  `id_marke` int(11) DEFAULT NULL,
  `naziv_modela` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `modeli`
--

INSERT INTO `modeli` (`id_modela`, `id_marke`, `naziv_modela`) VALUES
(1, 1, 'A3'),
(2, 1, 'A4'),
(3, 1, 'A5'),
(4, 1, 'A6'),
(5, 1, 'A7'),
(6, 1, 'A8'),
(7, 1, 'Q2'),
(8, 1, 'Q3'),
(9, 1, 'Q5'),
(10, 1, 'Q7'),
(11, 1, 'Q8'),
(12, 1, 'TT'),
(13, 1, 'R8'),
(14, 1, 'S3'),
(15, 1, 'S4'),
(16, 2, '1 Series'),
(17, 2, '2 Series'),
(18, 2, '3 Series'),
(19, 2, '4 Series'),
(20, 2, '5 Series'),
(21, 2, '6 Series'),
(22, 2, '7 Series'),
(23, 2, '8 Series'),
(24, 2, 'X1'),
(25, 2, 'X2'),
(26, 2, 'X3'),
(27, 2, 'X4'),
(28, 2, 'X5'),
(29, 2, 'X6'),
(30, 2, 'X7'),
(31, 3, 'A-Class'),
(32, 3, 'B-Class'),
(33, 3, 'C-Class'),
(34, 3, 'E-Class'),
(35, 3, 'S-Class'),
(36, 3, 'CLA'),
(37, 3, 'CLS'),
(38, 3, 'GLA'),
(39, 3, 'GLB'),
(40, 3, 'GLC'),
(41, 3, 'GLE'),
(42, 3, 'GLS'),
(43, 3, 'G-Class'),
(44, 3, 'SLC'),
(45, 3, 'SL'),
(46, 4, 'Golf'),
(47, 4, 'Polo'),
(48, 4, 'Passat'),
(49, 4, 'Tiguan'),
(50, 4, 'T-Roc'),
(51, 4, 'Touran'),
(52, 4, 'Arteon'),
(53, 4, 'Touareg'),
(54, 4, 'Up'),
(55, 4, 'ID.3'),
(56, 4, 'ID.4'),
(57, 4, 'Scirocco'),
(58, 4, 'Beetle'),
(59, 4, 'Jetta'),
(60, 4, 'CC'),
(61, 5, 'Corolla'),
(62, 5, 'Camry'),
(63, 5, 'Yaris'),
(64, 5, 'Rav4'),
(65, 5, 'Highlander'),
(66, 5, 'Prius'),
(67, 5, 'Sienna'),
(68, 5, 'Tacoma'),
(69, 5, 'Tundra'),
(70, 5, 'Supra'),
(71, 5, 'Sequoia'),
(72, 5, 'Land Cruiser'),
(73, 5, 'C-HR'),
(74, 5, 'Avalon'),
(75, 5, '4Runner'),
(76, 6, 'Civic'),
(77, 6, 'Accord'),
(78, 6, 'CR-V'),
(79, 6, 'HR-V'),
(80, 6, 'Pilot'),
(81, 6, 'Odyssey'),
(82, 6, 'Fit'),
(83, 6, 'Ridgeline'),
(84, 6, 'Insight'),
(85, 6, 'Passport'),
(86, 6, 'Clarity'),
(87, 6, 'Element'),
(88, 6, 'S2000'),
(89, 6, 'CR-Z'),
(90, 6, 'Prelude'),
(91, 7, 'Fiesta'),
(92, 7, 'Focus'),
(93, 7, 'Fusion'),
(94, 7, 'Mustang'),
(95, 7, 'Escape'),
(96, 7, 'Explorer'),
(97, 7, 'Edge'),
(98, 7, 'Expedition'),
(99, 7, 'Ranger'),
(100, 7, 'F-150'),
(101, 7, 'Transit'),
(102, 7, 'EcoSport'),
(103, 7, 'Bronco'),
(104, 7, 'Maverick'),
(105, 7, 'GT'),
(106, 8, 'Spark'),
(107, 8, 'Sonic'),
(108, 8, 'Cruze'),
(109, 8, 'Malibu'),
(110, 8, 'Impala'),
(111, 8, 'Camaro'),
(112, 8, 'Corvette'),
(113, 8, 'Trax'),
(114, 8, 'Equinox'),
(115, 8, 'Blazer'),
(116, 8, 'Traverse'),
(117, 8, 'Tahoe'),
(118, 8, 'Suburban'),
(119, 8, 'Colorado'),
(120, 8, 'Silverado'),
(121, 9, 'Micra'),
(122, 9, 'Versa'),
(123, 9, 'Sentra'),
(124, 9, 'Altima'),
(125, 9, 'Maxima'),
(126, 9, '370Z'),
(127, 9, 'GT-R'),
(128, 9, 'Kicks'),
(129, 9, 'Qashqai'),
(130, 9, 'Rogue'),
(131, 9, 'Murano'),
(132, 9, 'Pathfinder'),
(133, 9, 'Armada'),
(134, 9, 'Frontier'),
(135, 9, 'Titan'),
(136, 10, 'Accent'),
(137, 10, 'Elantra'),
(138, 10, 'Sonata'),
(139, 10, 'Veloster'),
(140, 10, 'Ioniq'),
(141, 10, 'Kona'),
(142, 10, 'Tucson'),
(143, 10, 'Santa Fe'),
(144, 10, 'Palisade'),
(145, 10, 'Venue'),
(146, 10, 'Nexo'),
(147, 10, 'Genesis G70'),
(148, 10, 'Genesis G80'),
(149, 10, 'Genesis G90'),
(150, 10, 'Santa Cruz'),
(151, 11, 'Rio'),
(152, 11, 'Forte'),
(153, 11, 'Optima'),
(154, 11, 'Stinger'),
(155, 11, 'Cadenza'),
(156, 11, 'K5'),
(157, 11, 'Soul'),
(158, 11, 'Niro'),
(159, 11, 'Sportage'),
(160, 11, 'Seltos'),
(161, 11, 'Sorento'),
(162, 11, 'Telluride'),
(163, 11, 'Carnival'),
(164, 11, 'K900'),
(165, 11, 'EV6'),
(166, 12, '500'),
(167, 12, '500X'),
(168, 12, '500L'),
(169, 12, '500e'),
(170, 12, 'Panda'),
(171, 12, 'Tipo'),
(172, 12, 'Punto'),
(173, 12, 'Qubo'),
(174, 12, 'Doblò'),
(175, 12, 'Ducato'),
(176, 12, '124 Spider'),
(177, 12, '500C'),
(178, 12, '595'),
(179, 12, '500L Living'),
(180, 12, 'Argo'),
(181, 13, 'Mazda2'),
(182, 13, 'Mazda3'),
(183, 13, 'Mazda6'),
(184, 13, 'MX-5 Miata'),
(185, 13, 'CX-3'),
(186, 13, 'CX-30'),
(187, 13, 'CX-5'),
(188, 13, 'CX-9'),
(189, 13, 'MX-30'),
(190, 14, 'Clio'),
(191, 14, 'Captur'),
(192, 14, 'Megane'),
(193, 14, 'Kadjar'),
(194, 14, 'Scenic'),
(195, 14, 'Talisman'),
(196, 14, 'Espace'),
(197, 14, 'Twingo'),
(198, 14, 'Koleos'),
(199, 14, 'Zoe'),
(200, 14, 'Arkana'),
(201, 14, 'Fluence'),
(202, 14, 'Kangoo'),
(203, 14, 'Trafic'),
(204, 14, 'Master'),
(205, 15, 'Impreza'),
(206, 15, 'Legacy'),
(207, 15, 'WRX'),
(208, 15, 'Outback'),
(209, 15, 'Forester'),
(210, 15, 'Crosstrek'),
(211, 15, 'BRZ'),
(212, 15, 'Ascent'),
(213, 15, 'XV'),
(214, 15, 'Levorg'),
(215, 15, 'Justy'),
(216, 15, 'Tribeca'),
(217, 15, 'Alcyone'),
(218, 15, 'Baja'),
(219, 15, 'Exiga'),
(220, 15, 'R1'),
(221, 15, 'R2'),
(222, 15, 'Traviq'),
(223, 15, 'Libero'),
(224, 15, 'Sambar'),
(225, 15, 'Domingo'),
(226, 15, 'Lucra'),
(227, 15, 'Stella');

-- --------------------------------------------------------

--
-- Table structure for table `oglasi`
--

CREATE TABLE `oglasi` (
  `ID` int(11) NOT NULL,
  `cijena` decimal(11,0) NOT NULL,
  `opis` varchar(500) NOT NULL,
  `godiste` int(11) NOT NULL,
  `kilometraza` int(11) NOT NULL,
  `snaga` int(100) NOT NULL,
  `datum_objave` date NOT NULL,
  `ID_prodavaca` int(11) NOT NULL,
  `id_modela` int(11) DEFAULT NULL,
  `zupanija` int(11) NOT NULL,
  `aktivan` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `oglasi`
--

INSERT INTO `oglasi` (`ID`, `cijena`, `opis`, `godiste`, `kilometraza`, `snaga`, `datum_objave`, `ID_prodavaca`, `id_modela`, `zupanija`, `aktivan`) VALUES
(2, 795652, 'prodavlem auta', 1244, 381057, 171, '2024-03-05', 1, 12, 20, 1),
(3, 404095, 'dghfgjh', 2017, 713015, 51, '2024-03-06', 1, 91, 20, 1),
(4, 633518, 'prodavlem auta', 2010, 117769, 435, '2024-03-06', 1, 95, 20, 1),
(5, 955307, 'dghdghd', 2019, 820494, 798, '2024-03-06', 1, 119, 20, 1),
(6, 875977, 'prodavlem auta', 2008, 529454, 252, '2024-03-06', 1, 148, 20, 1),
(7, 513965, 'fdhdgbd', 2011, 675176, 618, '2024-03-06', 1, 97, 20, 1),
(8, 941897, 'bokic', 2006, 63261, 463, '2024-03-06', 1, 95, 20, 1),
(9, 167587, 'fgfr', 2011, 125391, 238, '2024-03-06', 1, 108, 20, 1),
(10, 12245, 'dhvfvuhf', 2008, 813080, 352, '2024-03-06', 1, 18, 20, 1),
(11, 558466, 'etsziuzvio', 2008, 319992, 544, '2024-03-06', 1, 4, 20, 1),
(12, 755593, 'bokic', 2012, 762139, 177, '2024-03-06', 1, 112, 20, 1),
(13, 102566, 'Prodajem BMW E92 330i. Zvati na 0989818101', 2008, 600708, 471, '2024-03-08', 12, 18, 20, 1),
(15, 246053, 'sdfgsfdgfsdg', 2010, 554199, 357, '2024-03-08', 12, 92, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `slike`
--

CREATE TABLE `slike` (
  `id` int(11) NOT NULL,
  `id_oglas` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `slike`
--

INSERT INTO `slike` (`id`, `id_oglas`, `url`) VALUES
(2, 10, '65e8b13f7483d_audi_RS6.jpg'),
(3, 10, '65e8b13f76da8_rabauto_logo.jpg'),
(4, 11, '65e8b180db6db_audi_RS6.jpg'),
(5, 12, '65e8b83c3f1b3_audi_RS6.jpg'),
(6, 13, '65eb15d110a71_BMW E92 330i-3.jpg'),
(7, 13, '65eb15d11108b_BMW E92 330i-2.jpg'),
(8, 13, '65eb15d1115d8_BMW E92 330i-1.jpg'),
(9, 15, '65eb1a3dbbb87_BMW E92 330i-3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `zupanije`
--

CREATE TABLE `zupanije` (
  `id_zupanije` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `zupanije`
--

INSERT INTO `zupanije` (`id_zupanije`, `naziv`) VALUES
(1, 'Zagrebačka'),
(2, 'Krapinsko-zagorska'),
(3, 'Sisačko-moslavačka'),
(4, 'Karlovačka'),
(5, 'Varaždinska'),
(6, 'Koprivničko-križevačka'),
(7, 'Bjelovarsko-bilogorska'),
(8, 'Primorsko-goranska'),
(9, 'Ličko-senjska'),
(10, 'Virovitičko-podravska'),
(11, 'Požeško-slavonska'),
(12, 'Brodsko-posavska'),
(13, 'Zadarska'),
(14, 'Osječko-baranjska'),
(15, 'Šibensko-kninska'),
(16, 'Vukovarsko-srijemska'),
(17, 'Splitsko-dalmatinska'),
(18, 'Istarska'),
(19, 'Dubrovačko-neretvanska'),
(20, 'Međimurska');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email_adresa` (`email_adresa`);

--
-- Indexes for table `marke`
--
ALTER TABLE `marke`
  ADD PRIMARY KEY (`ID_marke`);

--
-- Indexes for table `modeli`
--
ALTER TABLE `modeli`
  ADD PRIMARY KEY (`id_modela`),
  ADD KEY `id_marke` (`id_marke`);

--
-- Indexes for table `oglasi`
--
ALTER TABLE `oglasi`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_prodavaca` (`ID_prodavaca`),
  ADD KEY `id_modela` (`id_modela`),
  ADD KEY `zupanija` (`zupanija`);

--
-- Indexes for table `slike`
--
ALTER TABLE `slike`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_oglas` (`id_oglas`);

--
-- Indexes for table `zupanije`
--
ALTER TABLE `zupanije`
  ADD PRIMARY KEY (`id_zupanije`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `marke`
--
ALTER TABLE `marke`
  MODIFY `ID_marke` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `modeli`
--
ALTER TABLE `modeli`
  MODIFY `id_modela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT for table `oglasi`
--
ALTER TABLE `oglasi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `slike`
--
ALTER TABLE `slike`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `zupanije`
--
ALTER TABLE `zupanije`
  MODIFY `id_zupanije` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `modeli`
--
ALTER TABLE `modeli`
  ADD CONSTRAINT `modeli_ibfk_1` FOREIGN KEY (`id_marke`) REFERENCES `marke` (`ID_marke`);

--
-- Constraints for table `oglasi`
--
ALTER TABLE `oglasi`
  ADD CONSTRAINT `oglasi_ibfk_1` FOREIGN KEY (`ID_prodavaca`) REFERENCES `korisnici` (`ID`),
  ADD CONSTRAINT `oglasi_ibfk_2` FOREIGN KEY (`id_modela`) REFERENCES `modeli` (`id_modela`),
  ADD CONSTRAINT `oglasi_ibfk_3` FOREIGN KEY (`zupanija`) REFERENCES `zupanije` (`id_zupanije`);

--
-- Constraints for table `slike`
--
ALTER TABLE `slike`
  ADD CONSTRAINT `slike_ibfk_1` FOREIGN KEY (`id_oglas`) REFERENCES `oglasi` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
