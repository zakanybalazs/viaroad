-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2018. Jan 16. 10:17
-- Kiszolgáló verziója: 10.1.21-MariaDB
-- PHP verzió: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `promothe_sql`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `amortizacio`
--

CREATE TABLE `amortizacio` (
  `id` int(11) NOT NULL,
  `ervenyes` varchar(200) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `egyseg` int(3) NOT NULL,
  `timelog` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `amortizacio`
--

INSERT INTO `amortizacio` (`id`, `ervenyes`, `egyseg`, `timelog`) VALUES
(1, '2018-01', 9, '2018-01-08 09:22:12'),
(2, '2018-02', 9, '2018-01-10 10:12:40');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `autok`
--

CREATE TABLE `autok` (
  `id` int(10) NOT NULL,
  `rendszam` varchar(10) COLLATE utf8mb4_bin NOT NULL,
  `tulaj` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `kategoria` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'ceges',
  `ceg` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `marka` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `tipus` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `uzemanyag` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `fogyasztas` float NOT NULL,
  `terfogat` float DEFAULT NULL,
  `berletszam` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `berletkezdete` date NOT NULL,
  `berletvege` date NOT NULL,
  `forgalmihely` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'NA',
  `forgalminev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT 'NA',
  `szerzodeshely` varchar(255) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL DEFAULT 'NA',
  `szerzodesnev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'NA',
  `kartyaszam` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- A tábla adatainak kiíratása `autok`
--

INSERT INTO `autok` (`id`, `rendszam`, `tulaj`, `kategoria`, `ceg`, `marka`, `tipus`, `uzemanyag`, `fogyasztas`, `terfogat`, `berletszam`, `berletkezdete`, `berletvege`, `forgalmihely`, `forgalminev`, `szerzodeshely`, `szerzodesnev`, `kartyaszam`) VALUES
(3, 'MEA665', 'PintÃ©r JÃ¡nos', 'normal', '', 'Audi', 'A4 ', 'diesel', 6.4, NULL, '', '0000-00-00', '0000-00-00', 'NA', 'NA', 'NA', 'NA', '7081678015249501'),
(25, 'NDN239', 'ZÃ¡kÃ¡ny BalÃ¡zs', 'normal', '', 'Volkswagen', 'Golf', 'Benzin', 8.6, 1394, '', '0000-00-00', '0000-00-00', 'uploads/autok/forgalmi/NDN239forgalmi.gif', 'NDN239forgalmi.gif', 'uploads/autok/kolcsonadasi/N/A', 'N/A', ''),
(24, 'NZP780', 'ceges', 'ceges', 'DAKÃ“-P \'96 Kft.', 'Skoda', 'Rapid', 'Benzin', 1394, 8.6, 'B/0093', '2017-02-03', '2020-02-03', 'NA', 'NA', 'NA', 'NA', NULL),
(22, 'VIA123', 'ZÃ¡kÃ¡ny BalÃ¡zs', 'kartyas', '', 'Skoda', 'Rapid', 'Benzin', 6.8, 1394, '', '0000-00-00', '0000-00-00', 'uploads/autok/forgalmi/VIA123forgalmi.png', 'VIA123forgalmi.png', 'uploads/autok/kolcsonadasi/N/A', 'N/A', '7081678014337919'),
(23, 'VIA234', 'Viapan PolgÃ¡r', 'normal', '', 'Skoda', 'Rapid', 'Benzin', 6.8, 1394, '', '0000-00-00', '0000-00-00', 'uploads/autok/forgalmi/VIA234forgalmi.jpg', 'VIA234forgalmi.jpg', 'uploads/autok/kolcsonadasi/N/A', 'N/A', '');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cegek`
--

CREATE TABLE `cegek` (
  `ceg` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `telep` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `id` varchar(10) COLLATE utf8mb4_bin NOT NULL,
  `dij` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- A tábla adatainak kiíratása `cegek`
--

INSERT INTO `cegek` (`ceg`, `telep`, `id`, `dij`) VALUES
('DAKÃ“-P \'96 Kft.', '(7400 KaposvÃ¡r, FÃ¼redi utca 12.)', 'dakop', 354),
('DOLOGIDÅ Kft.', '(7542 Kisbajom, Kossuth L utca 111.)', 'di', NULL),
('Duna-HumÃ¡n Kft.', '(2400 DunaÃºjvÃ¡ros, DÃ³zsa GyÃ¶rgy utca 23.)', 'dunahuman', 354),
('HR Trainer Kft.', '(8638 Balatonlelle, KÃ¶ztÃ¡rsasÃ¡g utca 36.-38.)', 'hrtrainer', 354),
('MELÃ“-DIÃK DÃ©l IskolaszÃ¶vetkezet', '(7912 Nagypeterd, PetÅ‘fi utca 3.)', 'md', NULL),
('Munka-ErÅ‘ Kft.', '(2724 Ãšjlengyel, Ady Endre utca 11.)', 'me', NULL),
('SIÃ“-D1 Kft.', '(8600 SiÃ³fok, DÃ³zsa GyÃ¶rgy utca 1/4)', 'siod1', 354),
('Ã–nfoglalkoztatÃ³ SzociÃ¡lis SzÃ¶vetkezet', '(7542 Kisbajom, Kossuth L. utca 111.)', 'oszoc', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cegestigek`
--

CREATE TABLE `cegestigek` (
  `id` int(10) NOT NULL,
  `rendszam` varchar(25) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `kezd` date NOT NULL,
  `vege` date NOT NULL,
  `kolcsonid` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `osszeg` int(10) NOT NULL,
  `pdfhely` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `cegestigek`
--

INSERT INTO `cegestigek` (`id`, `rendszam`, `kezd`, `vege`, `kolcsonid`, `osszeg`, `pdfhely`) VALUES
(10, 'NZP780', '2018-01-01', '2018-01-31', 'di', 4602, 'uploads/cegeselszamolasok/TIG-NZP780-di-2018-01-31.pdf'),
(11, 'NZP780', '2018-01-01', '2018-01-31', 'md', 121068, 'uploads/cegeselszamolasok/TIG-NZP780-md-2018-01-31.pdf');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `csv`
--

CREATE TABLE `csv` (
  `csv_id` int(10) NOT NULL,
  `editor` varchar(250) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `timelog` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `csv` text COLLATE utf8mb4_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `csv`
--

INSERT INTO `csv` (`csv_id`, `editor`, `timelog`, `csv`) VALUES
(71, '', '2018-01-12 07:24:08', '[{\"date\":\"2017-12-31\",\"kartyaszam\":\"7081678014337919\",\"ceg\":\"Duna-Humu00e1n Kft.\",\"kilometeroraallas\":\"13400\",\"egysegar\":\"360,59\",\"osszeg\":\"56629,01\"},{\"date\":\"2018-01-08\",\"kartyaszam\":\"7081678014337919\",\"ceg\":\"Duna-Humu00e1n Kft.\",\"kilometeroraallas\":\"13507\",\"egysegar\":\"420\",\"osszeg\":\"30300\"},{\"date\":\"2018-01-31\",\"kartyaszam\":\"7081678014337919\",\"ceg\":\"Duna-Humu00e1n Kft.\",\"kilometeroraallas\":\"13599\",\"egysegar\":\"400\",\"osszeg\":\"46629,01\"}]');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `elszamolasok`
--

CREATE TABLE `elszamolasok` (
  `id` int(10) NOT NULL,
  `felhasznaloID` int(10) NOT NULL,
  `alairoID` int(10) NOT NULL,
  `irodavezetoID` int(10) NOT NULL,
  `rendszam` varchar(25) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `kezdo` date NOT NULL,
  `vege` date NOT NULL,
  `kephely` varchar(200) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `dokhely` varchar(200) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `statusz` varchar(200) COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `elszamolasok`
--

INSERT INTO `elszamolasok` (`id`, `felhasznaloID`, `alairoID`, `irodavezetoID`, `rendszam`, `kezdo`, `vege`, `kephely`, `dokhely`, `statusz`) VALUES
(34, 26, 4, 4, 'VIA234', '2018-01-01', '2018-01-14', 'uploads/elszamolasok/KEP-VIA234-2018-01-14.jpg', 'uploads/elszamolasok/TIG-VIA234-2018-01-14.pdf', 'done');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` int(100) NOT NULL,
  `felhasznalo` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `jelszo` varchar(250) COLLATE utf8mb4_bin NOT NULL,
  `authority` varchar(100) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `felhasznalo`, `jelszo`, `authority`) VALUES
(4, 'ZÃ¡kÃ¡ny BalÃ¡zs', '$2y$10$.ZDFlYmJlOTNhMGFlMDM2OkT4DKHWxbrd/kvJLuq4YX4H9xHaOAqO', 'superuser'),
(12, 'PintÃ©r JÃ¡nos', '$2y$10$.NWNiZDhhYjY4ZGEwZjIw.A76i7r2A0bXnQLgAy.xhZ0YucFYT7dm', 'superuser'),
(20, 'superuser', '$2y$10$.MDAwNDUzM2ZjMWVkMWZhOo7RQznUhyRwMEVq2LL7q5bx01U17rAe', 'superuser'),
(21, 'Peller SÃ¡ndor', '$2y$10$.OGFmNjA4MmIwNDI3MjNk.5oPRuSPKmQuQKfquLiRoWIru4ZzbE3u', 'cegadmin'),
(26, 'Viapan PolgÃ¡r', '$2y$10$.MDM2MDE5N2RiYWYyZjRl.dCaVft5CJ7OmusL66IYTzbWLwUNgkVq', 'user');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hozzarendel`
--

CREATE TABLE `hozzarendel` (
  `rendszam` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `felhasznalo` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- A tábla adatainak kiíratása `hozzarendel`
--

INSERT INTO `hozzarendel` (`rendszam`, `felhasznalo`, `id`) VALUES
('NZP780', 'ZÃ¡kÃ¡ny BalÃ¡zs', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kartyastig`
--

CREATE TABLE `kartyastig` (
  `tig_id` int(11) NOT NULL,
  `kartyaszam` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `idoszak` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `szamlazando` int(11) NOT NULL,
  `pdf_nev` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `pdf_hely` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `kartyastig`
--

INSERT INTO `kartyastig` (`tig_id`, `kartyaszam`, `idoszak`, `szamlazando`, `pdf_nev`, `pdf_hely`) VALUES
(4, '7081678014337919', '2018-02', 1929, '7081678014337919 2018-02.pdf', 'uploads/elszamolasok/TIG-7081678014337919-2018-02.pdf');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kilometer`
--

CREATE TABLE `kilometer` (
  `id` int(155) NOT NULL,
  `rendszam` varchar(100) NOT NULL,
  `kilometer` int(255) DEFAULT NULL,
  `datum` date DEFAULT NULL,
  `felhasznalo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `kilometer`
--

INSERT INTO `kilometer` (`id`, `rendszam`, `kilometer`, `datum`, `felhasznalo`) VALUES
(1, 'NZP-780', 2061, '2017-07-24', 'ZÃ¡kÃ¡ny BalÃ¡zs'),
(2, 'NDN-239', 324, '2017-11-12', 'ZÃ¡kÃ¡ny BalÃ¡zs'),
(3, 'NZP-810', 576, '2017-06-28', 'felhasznÃ¡lÃ³'),
(4, 'NYM-730', 1245, '2017-04-24', 'PintÃ©r JÃ¡nos'),
(5, 'NZP-760', NULL, NULL, NULL),
(6, 'NZP-830', 25789, '2017-05-30', 'irodavezetÅ‘'),
(7, 'NZP-820', NULL, NULL, NULL),
(8, 'NDN-239', 324, '2017-11-12', 'ZÃ¡kÃ¡ny BalÃ¡zs'),
(9, 'ALD-153', NULL, NULL, NULL),
(10, 'MEA665', NULL, NULL, NULL),
(11, 'NDM-158', NULL, NULL, NULL),
(12, 'DFG-532', 54155, '2017-05-31', 'irodavezetÅ‘'),
(13, 'JHK-572', 64647, '2017-05-31', 'felhasznÃ¡lÃ³'),
(14, '', NULL, NULL, NULL),
(15, '', NULL, NULL, NULL),
(16, '', NULL, NULL, NULL),
(17, '', NULL, NULL, NULL),
(18, '', NULL, NULL, NULL),
(19, '', NULL, NULL, NULL),
(20, 'VIA851', 111410, '2017-08-01', 'ZÃ¡kÃ¡ny BalÃ¡zs'),
(21, 'TES123', 33273, '2017-08-05', 'Teszt Elek'),
(22, 'asdfasdf', NULL, NULL, NULL),
(23, 'fgsdfgs', NULL, NULL, NULL),
(24, 'rtherth', NULL, NULL, NULL),
(25, 'fger', NULL, NULL, NULL),
(26, 'DFG321', NULL, NULL, NULL),
(27, 'asdfa', NULL, NULL, NULL),
(28, 'afgadsf', NULL, NULL, NULL),
(29, 'fgsdf', NULL, NULL, NULL),
(30, 'dfasd', NULL, NULL, NULL),
(31, 'asdfasd', NULL, NULL, NULL),
(32, 'VIA465', NULL, NULL, NULL),
(33, 'vafasdf', NULL, NULL, NULL),
(34, 'asdfasd', NULL, NULL, NULL),
(35, 'SDF', NULL, NULL, NULL),
(36, 'cdcs', NULL, NULL, NULL),
(37, 'VIA123', 13661, '2018-01-12', 'ZÃ¡kÃ¡ny BalÃ¡zs'),
(38, 'VIA234', 157, '2018-01-11', 'Viapan PolgÃ¡r'),
(39, 'NZP780', 30495, '2018-01-16', 'ZÃ¡kÃ¡ny BalÃ¡zs'),
(40, 'NDN239', 33487, '2018-01-16', 'ZÃ¡kÃ¡ny BalÃ¡zs');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `piszkozat`
--

CREATE TABLE `piszkozat` (
  `felhasznalo` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `rendszam` varchar(15) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `datum` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci,
  `kolcsonbe` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `honnan` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `hova` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `cel` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `kezdokm` int(100) DEFAULT NULL,
  `zarokm` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `piszkozat`
--

INSERT INTO `piszkozat` (`felhasznalo`, `rendszam`, `datum`, `kolcsonbe`, `honnan`, `hova`, `cel`, `kezdokm`, `zarokm`) VALUES
('PintÃ©r JÃ¡nos', 'MEA665', NULL, '', 'KaposvÃ¡r', 'Budapest', '', 250796, 0),
('felhasznÃ¡lÃ³', 'NZP-810', '', 'md', 'valahonnan', '', '', 576, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `szemelyadatok`
--

CREATE TABLE `szemelyadatok` (
  `felhasznaloid` int(10) NOT NULL,
  `vezeteknev` varchar(255) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `keresztnev` varchar(255) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `adoszam` varchar(10) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `beosztas` varchar(255) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `lakcim` varchar(255) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `szuletesiido` date DEFAULT NULL,
  `szuletesihely` varchar(255) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `szolgalatihely` varchar(255) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `alairoid` int(10) DEFAULT NULL,
  `irodavezetoid` int(10) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `szemelyadatok`
--

INSERT INTO `szemelyadatok` (`felhasznaloid`, `vezeteknev`, `keresztnev`, `adoszam`, `beosztas`, `lakcim`, `szuletesiido`, `szuletesihely`, `szolgalatihely`, `alairoid`, `irodavezetoid`, `email`) VALUES
(4, 'ZÃ¡kÃ¡ny', 'BalÃ¡zs', '095127440', 'FejlesztÅ‘', '7761 KozÃ¡rmisleny Viola u 40/2', '1995-01-09', 'Miskolc', 'PÃ©cs', 4, 4, 'zakany.balazs@viapangroup.com'),
(22, 'Teszt', 'Elek', '123234345', 'TesztelÅ‘', '1223 Teszt, Teszt utca 4', '1989-12-12', 'Teszt', 'Teszt', 4, 4, ''),
(26, 'Viapan', 'PolgÃ¡r', '095127440', 'TesztelÅ‘ kisinas', '1234 Budapest Nemis u. 19', '1999-01-01', 'KisujjkÃ¶z', 'PÃ©cs', 4, 4, '');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `utak`
--

CREATE TABLE `utak` (
  `id` int(100) NOT NULL,
  `felhasznalo` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `datum` datetime(6) NOT NULL,
  `rendszam` varchar(25) COLLATE utf8mb4_bin NOT NULL,
  `honnan` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `ceg` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `hova` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `cel` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `kezdokm` int(100) NOT NULL,
  `zarokm` int(100) NOT NULL,
  `km` int(100) NOT NULL,
  `kolcsonbe` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `fogyasztas` float NOT NULL,
  `uzemanyag` varchar(25) COLLATE utf8mb4_bin NOT NULL,
  `kep` varchar(64) COLLATE utf8mb4_bin NOT NULL,
  `kepnev` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `idoszak` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- A tábla adatainak kiíratása `utak`
--

INSERT INTO `utak` (`id`, `felhasznalo`, `datum`, `rendszam`, `honnan`, `ceg`, `hova`, `cel`, `kezdokm`, `zarokm`, `km`, `kolcsonbe`, `fogyasztas`, `uzemanyag`, `kep`, `kepnev`, `idoszak`) VALUES
(140, 'Viapan PolgÃ¡r', '2018-01-11 15:41:00.000000', 'VIA234', 'KaposvÃ¡r', NULL, 'PÃ©cs', 'HÃ©tzÃ¡rÃ³ akÃ¡rmi', 91, 157, 66, NULL, 6.8, 'Benzin', 'uploads/2018-01-11 1541VIA234.jpg', '2018-01-11 1541VIA234.jpg', NULL),
(141, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2018-01-12 11:14:00.000000', 'VIA123', 'PÃ©cs', NULL, 'PÃ©cs', 'KÃ©pfeltÃ¶ltÃ©sre', 13619, 13661, 42, NULL, 6.8, 'Benzin', 'uploads/2018-01-12 1114VIA123.jpg', '2018-01-12 1114VIA123.jpg', NULL),
(142, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2018-01-05 07:35:00.000000', 'NZP780', 'PÃ©cs', 'DakÃ³-p \'96 Kft.', 'KaposvÃ¡r', 'KintlÃ©vÅ‘sÃ©g Meeting', 30066, 30140, 74, 'md', 1394, 'Benzin', 'uploads/N/A', 'N/A', NULL),
(143, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2018-01-05 12:15:00.000000', 'NZP780', 'KaposvÃ¡r', 'DakÃ³-p \'96 Kft.', 'PÃ©cs', 'AutÃ³ leadÃ¡sa', 30140, 30213, 73, 'md', 1394, 'Benzin', 'uploads/N/A', 'N/A', NULL),
(144, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2018-01-05 14:30:00.000000', 'NZP780', 'PÃ©cs', 'DakÃ³-p \'96 Kft.', 'PÃ©cs', 'RPP Kft.', 30213, 30226, 13, 'di', 1394, 'Benzin', 'uploads/N/A', 'N/A', NULL),
(145, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2018-01-09 10:25:00.000000', 'NZP780', 'Zalaegerszeg', 'DakÃ³-p \'96 Kft.', 'PÃ©cs', 'TesztelÃ©s', 30226, 30421, 195, 'md', 1394, 'Benzin', 'uploads/N/A', 'N/A', NULL),
(146, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2018-01-08 10:25:00.000000', 'NDN239', 'KaposvÃ¡r', NULL, 'PÃ©cs', 'TesztelÃ©s', 33120, 33193, 73, NULL, 8.6, 'Benzin', 'uploads/N/A', 'N/A', NULL),
(147, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2018-01-16 09:14:00.000000', 'NZP780', 'KaposvÃ¡r', 'DAKÃ“-P \'96 Kft.', 'PÃ©cs', 'asdf', 30421, 30495, 74, 'md', 1394, 'Benzin', 'uploads/N/A', 'N/A', NULL),
(148, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2018-01-16 09:14:00.000000', 'NDN239', 'KaposvÃ¡r', NULL, 'PÃ©cs', 'asdfqwer', 33193, 33263, 70, NULL, 8.6, 'Benzin', 'uploads/N/A', 'N/A', NULL),
(149, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2018-01-16 09:20:00.000000', 'NDN239', 'Budapest', NULL, 'PÃ©cs', 'Mettinf', 33263, 33487, 224, NULL, 8.6, 'Benzin', 'uploads/N/A', 'N/A', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `uzemanyagar`
--

CREATE TABLE `uzemanyagar` (
  `id` int(10) NOT NULL,
  `ervenyes` date NOT NULL,
  `tipus` varchar(15) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `ar` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `uzemanyagar`
--

INSERT INTO `uzemanyagar` (`id`, `ervenyes`, `tipus`, `ar`) VALUES
(1, '2017-07-01', 'diesel', 340),
(2, '2017-07-01', 'Benzin', 339),
(3, '2017-08-01', 'diesel', 337),
(4, '2017-08-01', 'Benzin', 335);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `amortizacio`
--
ALTER TABLE `amortizacio`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `autok`
--
ALTER TABLE `autok`
  ADD PRIMARY KEY (`rendszam`),
  ADD KEY `id` (`id`);

--
-- A tábla indexei `cegek`
--
ALTER TABLE `cegek`
  ADD PRIMARY KEY (`ceg`);

--
-- A tábla indexei `cegestigek`
--
ALTER TABLE `cegestigek`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `csv`
--
ALTER TABLE `csv`
  ADD PRIMARY KEY (`csv_id`);

--
-- A tábla indexei `elszamolasok`
--
ALTER TABLE `elszamolasok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `hozzarendel`
--
ALTER TABLE `hozzarendel`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `kartyastig`
--
ALTER TABLE `kartyastig`
  ADD PRIMARY KEY (`tig_id`);

--
-- A tábla indexei `kilometer`
--
ALTER TABLE `kilometer`
  ADD UNIQUE KEY `id` (`id`);

--
-- A tábla indexei `piszkozat`
--
ALTER TABLE `piszkozat`
  ADD KEY `felhasznalo` (`felhasznalo`);

--
-- A tábla indexei `szemelyadatok`
--
ALTER TABLE `szemelyadatok`
  ADD UNIQUE KEY `felhasznaloid` (`felhasznaloid`);

--
-- A tábla indexei `utak`
--
ALTER TABLE `utak`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `uzemanyagar`
--
ALTER TABLE `uzemanyagar`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `amortizacio`
--
ALTER TABLE `amortizacio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT a táblához `autok`
--
ALTER TABLE `autok`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT a táblához `cegestigek`
--
ALTER TABLE `cegestigek`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT a táblához `csv`
--
ALTER TABLE `csv`
  MODIFY `csv_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT a táblához `elszamolasok`
--
ALTER TABLE `elszamolasok`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT a táblához `hozzarendel`
--
ALTER TABLE `hozzarendel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT a táblához `kartyastig`
--
ALTER TABLE `kartyastig`
  MODIFY `tig_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT a táblához `kilometer`
--
ALTER TABLE `kilometer`
  MODIFY `id` int(155) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT a táblához `utak`
--
ALTER TABLE `utak`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;
--
-- AUTO_INCREMENT a táblához `uzemanyagar`
--
ALTER TABLE `uzemanyagar`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
