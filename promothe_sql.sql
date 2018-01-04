-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2017. Aug 11. 13:23
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
  `szerzodesnev` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'NA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- A tábla adatainak kiíratása `autok`
--

INSERT INTO `autok` (`id`, `rendszam`, `tulaj`, `kategoria`, `ceg`, `marka`, `tipus`, `uzemanyag`, `fogyasztas`, `terfogat`, `berletszam`, `berletkezdete`, `berletvege`, `forgalmihely`, `forgalminev`, `szerzodeshely`, `szerzodesnev`) VALUES
(1, 'DFG-532', 'irodavezetÅ‘', 'normal', '', 'Volkswagen', 'Polo', 'Benzin', 6.4, NULL, '', '0000-00-00', '0000-00-00', 'NA', 'NA', 'NA', 'NA'),
(2, 'JHK-572', 'felhasznÃ¡lÃ³', 'normal', '', 'Aston Martin', 'DB11', 'Benzin', 12.3, NULL, '', '0000-00-00', '0000-00-00', 'NA', 'NA', 'NA', 'NA'),
(3, 'MEA665', 'PintÃ©r JÃ¡nos', 'kartyas', '', 'Audi', 'A4 ', 'diesel', 6.4, NULL, '', '0000-00-00', '0000-00-00', 'NA', 'NA', 'NA', 'NA'),
(4, 'NDM-453', 'PintÃ©r JÃ¡nos', 'normal', '', 'Audi', 'A3', 'Diesel', 8.6, NULL, '', '0000-00-00', '0000-00-00', 'NA', 'NA', 'NA', 'NA'),
(5, 'NDN-239', 'ZÃ¡kÃ¡ny BalÃ¡zs', 'kartyas', '', 'Volkswagen', 'Golf 7', 'Benzin', 6.3, NULL, '', '0000-00-00', '0000-00-00', 'NA', 'NA', 'NA', 'NA'),
(6, 'NYM-730', 'ceges', 'ceges', 'DAKÃ“-P \'96 Kft.', 'Skoda', 'Rapid', 'Benzin', 8.6, NULL, 'B/0093', '2017-01-19', '2020-01-19', 'NA', 'NA', 'NA', 'NA'),
(7, 'NZP-760', 'ceges', 'ceges', 'Duna-HumÃ¡n Kft.', 'Skoda', 'Rapid', 'Benzin', 8.6, NULL, 'B/0092', '2017-02-03', '2020-02-03', 'NA', 'NA', 'NA', 'NA'),
(8, 'NZP-780', 'ceges', 'ceges', 'DAKÃ“-P \'96 Kft.', 'Skoda', 'Rapid', 'Benzin', 8.6, NULL, 'B/0093', '2017-02-03', '2017-02-03', 'NA', 'NA', 'NA', 'NA'),
(9, 'NZP-810', 'ceges', 'ceges', 'DAKÃ“-P \'96 Kft.', 'Skoda', 'Rapid', 'Benzin', 8.6, NULL, 'B/0093', '2017-02-10', '2020-02-10', 'NA', 'NA', 'NA', 'NA'),
(10, 'NZP-820', 'ceges', 'ceges', 'SIÃ“-D1 Kft.', 'Skoda', 'Rapid', 'Benzin', 8.6, NULL, 'B/0097', '2017-02-10', '2020-02-10', 'NA', 'NA', 'NA', 'NA'),
(11, 'NZP-830', 'ceges', 'ceges', 'HR Trainer Kft.', 'Skoda', 'Rapid', 'Benzin', 8.6, NULL, 'B/0098', '2017-02-10', '2020-02-10', 'NA', 'NA', 'NA', 'NA'),
(19, 'TES123', 'Teszt Elek', 'normal', '', 'Suzuki', 'Celerio â¤', 'Benzin', 4.3, NULL, '', '0000-00-00', '0000-00-00', 'uploads/autok/forgalmi/TES123forgalmi.jpg', 'TES123forgalmi.jpg', 'uploads/autok/kolcsonadasi/N/A', 'N/A'),
(18, 'VIA851', 'ZÃ¡kÃ¡ny BalÃ¡zs', 'normal', '', 'Aston Martin', 'Rapide S', 'Benzin', 12.4, 6.4, '', '0000-00-00', '0000-00-00', 'uploads/autok/forgalmi/VIA851forgalmi.jpg', 'VIA851forgalmi.jpg', 'uploads/autok/kolcsonadasi/VIA851szerzodes.jpg', 'VIA851szerzodes.jpg');

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
('DOLOGIDÅ Kft.', '(7542 Kisbajom, Kossuth L utca 111.)', 'di', 0),
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
(261, 'NZP-780', '2017-06-01', '2017-08-27', 'md', 61242, 'uploads/cegeselszamolasok/TIG NZP-780 md 2017-08-27.pdf'),
(262, 'NZP-780', '2017-06-01', '2017-08-27', 'me', 9204, 'uploads/cegeselszamolasok/TIG NZP-780 me 2017-08-27.pdf'),
(263, 'NZP-810', '2017-06-01', '2017-08-27', 'md', 108324, 'uploads/cegeselszamolasok/TIG NZP-810 md 2017-08-27.pdf'),
(264, 'NZP-780', '2017-06-01', '2017-08-27', 'oszoc', 8496, 'uploads/cegeselszamolasok/TIG NZP-780 oszoc 2017-08-27.pdf'),
(265, 'NZP-780', '2017-06-01', '2017-08-17', 'md', 61242, 'uploads/cegeselszamolasok/TIG NZP-780 md 2017-08-17.pdf'),
(266, 'NZP-780', '2017-06-01', '2017-08-17', 'me', 9204, 'uploads/cegeselszamolasok/TIG NZP-780 me 2017-08-17.pdf'),
(267, 'NZP-810', '2017-06-01', '2017-08-17', 'md', 108324, 'uploads/cegeselszamolasok/TIG NZP-810 md 2017-08-17.pdf'),
(268, 'NZP-780', '2017-06-01', '2017-08-17', 'oszoc', 8496, 'uploads/cegeselszamolasok/TIG NZP-780 oszoc 2017-08-17.pdf'),
(269, 'NZP-780', '2017-06-01', '2017-08-20', 'me', 9204, 'uploads/cegeselszamolasok/TIG NZP-780 me 2017-08-20.pdf'),
(270, 'NZP-780', '2017-06-01', '2017-08-20', 'md', 61242, 'uploads/cegeselszamolasok/TIG NZP-780 md 2017-08-20.pdf'),
(271, 'NZP-780', '2017-06-01', '2017-08-20', 'oszoc', 8496, 'uploads/cegeselszamolasok/TIG NZP-780 oszoc 2017-08-20.pdf'),
(272, 'NZP-810', '2017-06-01', '2017-08-20', 'md', 108324, 'uploads/cegeselszamolasok/TIG NZP-810 md 2017-08-20.pdf');

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
(29, 4, 12, 19, 'VIA850', '2017-08-01', '2017-08-20', 'uploads/elszamolasok/KEP VIA851 2017-08-20.jpg', 'uploads/elszamolasok/TIG VIA851 2017-08-20.pdf', 'done'),
(30, 22, 4, 4, 'TES123', '2017-08-01', '2017-08-07', 'uploads/elszamolasok/KEP TES123 2017-08-07.jpg', 'uploads/elszamolasok/TIG TES123 2017-08-07.pdf', 'done'),
(31, 4, 12, 19, 'VIA851', '2017-07-24', '2017-08-06', 'uploads/elszamolasok/KEP VIA851 2017-08-06.jpg', 'uploads/elszamolasok/TIG VIA851 2017-08-06.pdf', 'sent');

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
(13, 'sz.vera', '$2y$10$.ZTNmMGMxY2Q0OTg4N2NkO8TM4Jx2EHaV5/BC0irxKR0t4ZueDL2m', 'admin'),
(18, 'felhasznÃ¡lÃ³', '$2y$10$.OWNkYzM1ODExOWNmYzRi.kHkRdaGWI4IW8wyld0xLUNodXkEkbca', 'user'),
(19, 'irodavezetÅ‘', '$2y$10$.OWZhYmIwYmM3MmFlMTQy.s68oF4h4Yt9NtihPLhDJuzqWUsFL1qC', 'admin'),
(20, 'superuser', '$2y$10$.MDAwNDUzM2ZjMWVkMWZhOo7RQznUhyRwMEVq2LL7q5bx01U17rAe', 'superuser'),
(21, 'Peller SÃ¡ndor', '$2y$10$.OGFmNjA4MmIwNDI3MjNk.5oPRuSPKmQuQKfquLiRoWIru4ZzbE3u', 'cegadmin'),
(22, 'Teszt Elek', '$2y$10$.NmVhODhkMmY1NjQxNWJj.osNmIA0a8VFUlMMKvxwvFEOmrMcPPSi', 'user');

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
('NZP-780', 'ZÃ¡kÃ¡ny BalÃ¡zs', 8),
('NYM-730', 'PintÃ©r JÃ¡nos', 9),
('NZP-830', 'irodavezetÅ‘', 11),
('NZP-810', 'felhasznÃ¡lÃ³', 12);

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
(2, 'NDN-239', 164, '2017-08-09', 'ZÃ¡kÃ¡ny BalÃ¡zs'),
(3, 'NZP-810', 576, '2017-06-28', 'felhasznÃ¡lÃ³'),
(4, 'NYM-730', 1245, '2017-04-24', 'PintÃ©r JÃ¡nos'),
(5, 'NZP-760', NULL, NULL, NULL),
(6, 'NZP-830', 25789, '2017-05-30', 'irodavezetÅ‘'),
(7, 'NZP-820', NULL, NULL, NULL),
(8, 'NDN-239', 164, '2017-08-09', 'ZÃ¡kÃ¡ny BalÃ¡zs'),
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
(21, 'TES123', 33273, '2017-08-05', 'Teszt Elek');

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
  `irodavezetoid` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `szemelyadatok`
--

INSERT INTO `szemelyadatok` (`felhasznaloid`, `vezeteknev`, `keresztnev`, `adoszam`, `beosztas`, `lakcim`, `szuletesiido`, `szuletesihely`, `szolgalatihely`, `alairoid`, `irodavezetoid`) VALUES
(4, 'ZÃ¡kÃ¡ny', NULL, '095127440', 'FejlesztÅ‘', '7761 KozÃ¡rmisleny Viola u 40/2', '1995-01-09', 'Miskolc', 'PÃ©cs', 12, 19),
(22, 'Teszt', 'Elek', '123234345', 'TesztelÅ‘', '1223 Teszt, Teszt utca 4', '1989-12-12', 'Teszt', 'Teszt', 4, 4);

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
  `kepnev` varchar(100) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- A tábla adatainak kiíratása `utak`
--

INSERT INTO `utak` (`id`, `felhasznalo`, `datum`, `rendszam`, `honnan`, `ceg`, `hova`, `cel`, `kezdokm`, `zarokm`, `km`, `kolcsonbe`, `fogyasztas`, `uzemanyag`, `kep`, `kepnev`) VALUES
(38, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-04-19 09:00:00.000000', 'NZP-780', 'PÃ©cs', 'DAKÃ“-P \'96 Kft', 'PÃ©cs', '204394774', 120, 130, 10, 'md', 8.6, 'Benzin', 'uploads/teszt/482890.jpg', '482890.jpg'),
(40, 'PintÃ©r JÃ¡nos', '2017-04-17 09:00:00.000000', 'NDM-453', 'KaposvÃ¡r', 'DAKÃ“-P \'96 Kft', 'Budapest', 'Meeting', 4539, 4620, 81, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-04-17T09:00NDM-453', '2017-04-17T09:00NDM-453'),
(41, 'PintÃ©r JÃ¡nos', '2017-04-17 10:00:00.000000', 'NYM-730', 'KaposvÃ¡r', 'DAKÃ“-P \'96 Kft', 'SzigetszentmiklÃ³s', 'kirÃ¡ndulÃ¡s', 356, 400, 44, 'di', 8.6, 'Benzin', 'uploads/teszt/2017-04-17T10:00NYM-730', '2017-04-17T10:00NYM-730'),
(42, 'PintÃ©r JÃ¡nos', '2017-04-18 05:30:00.000000', 'NYM-730', 'SzigetszentmiklÃ³s', 'DAKÃ“-P \'96 Kft', 'KaposvÃ¡r', 'Haza', 400, 444, 44, 'di', 8.6, 'Benzin', 'uploads/teszt/2017-04-18T05:30NYM-730', '2017-04-18T05:30NYM-730'),
(44, 'PintÃ©r JÃ¡nos', '2017-04-18 12:12:00.000000', 'NYM-730', 'KaposvÃ¡r', 'DAKÃ“-P \'96 Kft', 'LillafÃ¼red', 'kirÃ¡ndulÃ¡s', 562, 945, 383, 'oszoc', 8.6, 'Benzin', 'uploads/teszt/2017-04-18T12:12NYM-730', '2017-04-18T12:12NYM-730'),
(45, 'PintÃ©r JÃ¡nos', '2017-03-07 05:05:00.000000', 'NYM-730', 'KaposvÃ¡r', 'DAKÃ“-P \'96 Kft', 'Nagypeterd', 'Internet bekÃ¶tÃ©s', 1001, 1095, 94, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-03-07T05:05NYM-730', '2017-03-07T05:05NYM-730'),
(46, 'PintÃ©r JÃ¡nos', '2017-04-01 15:20:00.000000', 'NYM-730', 'LovasberÃ©ny', 'DAKÃ“-P \'96 Kft', 'FelsÅ‘zsolca', 'Marketing kampÃ¡ny', 1111, 1156, 45, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-04-01T15:20NYM-730', '2017-04-01T15:20NYM-730'),
(47, 'PintÃ©r JÃ¡nos', '2017-04-24 13:01:00.000000', 'NYM-730', 'KaposvÃ¡r', 'DAKÃ“-P \'96 Kft', 'SomogysÃ¡rd', 'Meeting', 1156, 1221, 65, 'me', 8.6, 'Benzin', 'uploads/teszt/2017-04-24T13:01NYM-730', '2017-04-24T13:01NYM-730'),
(48, 'PintÃ©r JÃ¡nos', '2017-04-24 20:00:00.000000', 'NYM-730', 'KaposvÃ¡r', 'DAKÃ“-P \'96 Kft', 'PÃ©cs', 'Meeting', 1221, 1245, 24, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-04-24T20:00NYM-730.jpg', '2017-04-24T20:00NYM-730.jpg'),
(49, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-04-24 09:00:00.000000', 'NZP-780', 'PÃ©cs', 'DAKÃ“-P \'96 Kft', 'PÃ©cs', '204394774', 140, 150, 10, 'MelÃ³-DiÃ¡k DÃ©l IskolaszÃ¶vetkezet', 8.6, 'Benzin', 'uploads/teszt/2017-04-24T09:00NZP-780.jpg', '2017-04-24T09:00NZP-780.jpg'),
(51, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-04-27 09:00:00.000000', 'NZP-780', 'faf', 'DAKÃ“-P \'96 Kft', 'fergwrt', 'grwthr', 150, 1500, 1350, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-04-27T09:00NZP-780.jpg', '2017-04-27T09:00NZP-780.jpg'),
(52, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-05-08 15:40:00.000000', 'NZP-780', 'PÃ©cs', 'DAKÃ“-P \'96 Kft', 'Kozarmisleny', '204394774', 1511, 1535, 24, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-05-08 15:40NZP-780.jpg', '2017-05-08 15:40NZP-780.jpg'),
(53, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-04-12 09:05:00.000000', 'NDN-239', 'PÃ©cs', '', 'Cs;p', 'valami', 0, 10, 10, '', 6.3, 'Benzin', 'uploads/teszt/2017-04-12 09:05NDN-239.jpg', '2017-04-12 09:05NDN-239.jpg'),
(54, 'irodavezetÅ‘', '2017-05-29 09:30:00.000000', 'NZP-830', 'PÃ©cs', 'HR Trainer Kft', 'Budapest', 'Meeting', 25432, 25459, 27, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-05-29 09:30NZP-830.jpg', '2017-05-29 09:30NZP-830.jpg'),
(55, 'irodavezetÅ‘', '2017-05-30 08:25:00.000000', 'NZP-830', 'Budapest', 'HR Trainer Kft', 'PÃ©cs', 'Haza', 25459, 25503, 44, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-05-30 08:25NZP-830.jpg', '2017-05-30 08:25NZP-830.jpg'),
(56, 'irodavezetÅ‘', '2017-05-31 07:30:00.000000', 'NZP-830', 'PÃ©cs', 'HR Trainer Kft', 'KaposvÃ¡r', 'FolyamatinÃ©', 25503, 25588, 85, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-05-31 07:30NZP-830.jpg', '2017-05-31 07:30NZP-830.jpg'),
(57, 'irodavezetÅ‘', '2017-05-31 14:00:00.000000', 'NZP-830', 'KaposvÃ¡r', 'HR Trainer Kft', 'PÃ©cs', 'Haza', 25588, 25620, 32, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-05-31 14:00NZP-830.jpg', '2017-05-31 14:00NZP-830.jpg'),
(58, 'irodavezetÅ‘', '2017-05-16 08:00:00.000000', 'DFG-532', 'PÃ©cs', '', 'KozÃ¡rmisleny', 'Macska etetÃ©s', 45231, 45253, 22, '', 6.4, 'Benzin', 'uploads/teszt/2017-05-16 08:00DFG-532.jpg', '2017-05-16 08:00DFG-532.jpg'),
(59, 'irodavezetÅ‘', '2017-05-16 17:00:00.000000', 'DFG-532', 'KozÃ¡rmisleny', '', 'PÃ©cs', 'Vissza', 45253, 45303, 50, '', 6.4, 'Benzin', 'uploads/teszt/2017-05-16 17:00DFG-532.jpg', '2017-05-16 17:00DFG-532.jpg'),
(60, 'irodavezetÅ‘', '2017-05-18 08:35:00.000000', 'DFG-532', 'PÃ©cs', '', 'Szombathely', 'SzerelÅ‘ vagyok', 45303, 45415, 112, '', 6.4, 'Benzin', 'uploads/teszt/2017-05-18 08:35DFG-532.jpg', '2017-05-18 08:35DFG-532.jpg'),
(61, 'irodavezetÅ‘', '2017-05-31 08:00:00.000000', 'DFG-532', 'PÃ©cs', '', 'Mexico', 'Ã‰n ide PuzÃ³Ã©rt jÃ¶ttem', 45415, 54155, 8740, '', 6.4, 'Benzin', 'uploads/teszt/2017-05-31 08:00DFG-532.jpg', '2017-05-31 08:00DFG-532.jpg'),
(62, 'felhasznÃ¡lÃ³', '2017-05-31 08:00:00.000000', 'JHK-572', 'PÃ©cs', '', 'SalgÃ³tarjÃ¡n', 'fuck bitches', 64351, 64546, 195, '', 12.3, 'Benzin', 'uploads/teszt/2017-05-31 08:00JHK-572.jpg', '2017-05-31 08:00JHK-572.jpg'),
(63, 'felhasznÃ¡lÃ³', '2017-05-31 16:20:00.000000', 'JHK-572', 'SalgÃ³tarjÃ¡n', '', 'PÃ©cs', 'Haza', 64546, 64647, 101, '', 12.3, 'Benzin', 'uploads/teszt/2017-05-31 16:20JHK-572.jpg', '2017-05-31 16:20JHK-572.jpg'),
(64, 'felhasznÃ¡lÃ³', '2017-05-30 08:45:00.000000', 'NZP-810', 'Budapest', 'DAKÃ“-P \'96 Kft', 'PÃ©cs', 'Meeting', 32, 156, 124, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-05-30 08:45NZP-810.jpg', '2017-05-30 08:45NZP-810.jpg'),
(65, 'felhasznÃ¡lÃ³', '2017-06-02 08:50:00.000000', 'NZP-810', 'Szeged', 'DAKÃ“-P \'96 Kft', 'Valahova', 'MÃ¡r kifogytam az Ã¶tletekbÅ‘l', 156, 254, 98, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-06-02 08:50NZP-810.jpg', '2017-06-02 08:50NZP-810.jpg'),
(66, 'felhasznÃ¡lÃ³', '2017-06-09 09:00:00.000000', 'NZP-810', 'PÃ©cs', 'DAKÃ“-P \'96 Kft', 'KaposvÃ¡r', 'ðŸ˜±â˜ºï¸', 254, 342, 88, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-06-09 09:00NZP-810.jpg', '2017-06-09 09:00NZP-810.jpg'),
(68, 'felhasznÃ¡lÃ³', '2017-06-28 13:20:00.000000', 'NZP-810', 'ðŸŒ³ðŸ˜‚ðŸ˜©', 'DAKÃ“-P \'96 Kft', 'ðŸ˜ƒðŸ’•ðŸ¤¡ðŸ˜±ðŸ˜°ðŸ˜“', 'ðŸ˜ªðŸ˜“ðŸ˜‘ðŸ˜“ðŸ˜“', 456, 576, 120, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-06-28 13:20NZP-810.jpg', '2017-06-28 13:20NZP-810.jpg'),
(69, 'irodavezetÅ‘', '2017-05-30 18:00:00.000000', 'NZP-830', 'PÃ©cs', 'HR Trainer Kft', 'KaposvÃ¡r', 'Van', 25620, 25789, 169, 'di', 8.6, 'Benzin', 'uploads/teszt/2017-05-30T18:00NZP-830.jpg', '2017-05-30T18:00NZP-830.jpg'),
(70, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-02 12:57:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'Valahova', 'Valami', 1535, 1550, 15, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-06-02 12:57NZP-780.jpg', '2017-06-02 12:57NZP-780.jpg'),
(72, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-10 19:20:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'vadfva', 1550, 1581, 0, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-06-10 19:20 . NZP-780.\'.jpg\'', '2017-06-10 19:20 . NZP-780.\'.jpg\''),
(73, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-10 19:20:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'vadfva', 1550, 1573, 23, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-06-10 19:20 . NZP-780.\'.jpg\'', '2017-06-10 19:20 . NZP-780.\'.jpg\''),
(74, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 10:28:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Siker', 16, 33, 17, NULL, 6.3, 'Benzin', 'uploads/teszt/2017-06-14 10:28 . NDN-239.\'.jpg\'', '2017-06-14 10:28 . NDN-239.\'.jpg\''),
(75, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 10:28:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Siker', 16, 33, 17, NULL, 6.3, 'Benzin', 'uploads/teszt/2017-06-14 10:28 . NDN-239.\'.jpg\'', '2017-06-14 10:28 . NDN-239.\'.jpg\''),
(76, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 10:28:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Siker', 16, 31, 15, NULL, 6.3, 'Benzin', 'uploads/teszt/2017-06-14 10:28 . NDN-239.\'.jpg\'', '2017-06-14 10:28 . NDN-239.\'.jpg\''),
(77, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 10:28:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Siker', 16, 18, 2, NULL, 6.3, 'Benzin', 'uploads/teszt/2017-06-14 10:28 . NDN-239.\'.jpg\'', '2017-06-14 10:28 . NDN-239.\'.jpg\''),
(78, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 10:28:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Siker', 16, 17, 1, NULL, 6.3, 'Benzin', 'uploads/teszt/2017-06-14 10:28 . NDN-239\'.jpg\'', '2017-06-14 10:28 . NDN-239\'.jpg\''),
(79, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 10:28:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Siker', 16, 22, 6, NULL, 6.3, 'Benzin', 'uploads/teszt/2017-06-14 10:28NDN-239.jpg', '2017-06-14 10:28NDN-239.jpg'),
(80, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 10:28:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'Siker2', 1550, 1560, 10, 'md', 8.6, 'Benzin', 'uploads/teszt/2017-06-14 10:28NZP-780.jpg', '2017-06-14 10:28NZP-780.jpg'),
(82, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 10:52:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Meeting', 10, 18, 8, NULL, 6.3, 'Benzin', 'uploads/teszt/2017-06-14 10:52NDN-239.jpg', '2017-06-14 10:52NDN-239.jpg'),
(83, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 10:52:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Meeting', 10, 19, 9, NULL, 6.3, 'Benzin', 'uploads/teszt/2017-06-14 10:52NDN-239.jpg', '2017-06-14 10:52NDN-239.jpg'),
(84, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 10:52:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Meeting', 10, 24, 14, NULL, 6.3, 'Benzin', 'uploads/teszt/2017-06-14 10:52NDN-239.jpg', '2017-06-14 10:52NDN-239.jpg'),
(85, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 16:25:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Teszting', 10, 32, 22, NULL, 6.3, 'Benzin', 'uploads/teszt/2017-06-14 16:25NDN-239.jpg', '2017-06-14 16:25NDN-239.jpg'),
(86, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 17:39:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'gegre', 10, 20, 10, NULL, 6.3, 'Benzin', 'uploads/teszt/2017-06-14 17:39NDN-239.jpg', '2017-06-14 17:39NDN-239.jpg'),
(87, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 17:54:00.000000', 'NDN-239', 'PÃ©cs', NULL, 'KozÃ¡rmisleny', 'Meeting', 10, 21, 11, NULL, 6.3, 'Benzin', 'uploads/2017-06-14 17:54NDN-239.jpg', '2017-06-14 17:54NDN-239.jpg'),
(88, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 17:56:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', '204394774', 1550, 1569, 19, 'di', 8.6, 'Benzin', 'uploads/2017-06-14 17:56NZP-780.jpg', '2017-06-14 17:56NZP-780.jpg'),
(89, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 17:57:00.000000', 'NZP-780', 'PÃ©cs', 'DAKÃ“-P \'96 Kft', 'PÃ©cs', '204394774', 1550, 1578, 28, 'NA', 8.6, 'Benzin', 'uploads/2017-06-14 17:57NZP-780.jpg', '2017-06-14 17:57NZP-780.jpg'),
(90, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 17:59:00.000000', 'NDN-239', 'PÃ©cs', NULL, 'PÃ©cs', 'rtherthe', 10, 22, 12, NULL, 6.3, 'Benzin', 'uploads/2017-06-14 17:59NDN-239.jpg', '2017-06-14 17:59NDN-239.jpg'),
(91, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 17:59:00.000000', 'NDN-239', 'PÃ©cs', NULL, 'PÃ©cs', 'rtherthe', 10, 22, 12, NULL, 6.3, 'Benzin', 'uploads/2017-06-14 17:59NDN-239.jpg', '2017-06-14 17:59NDN-239.jpg'),
(92, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-14 18:02:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'dfghfj', 25, 52, 27, NULL, 6.3, 'Benzin', 'uploads/2017-06-14 18:02NDN-239.jpg', '2017-06-14 18:02NDN-239.jpg'),
(93, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 19:58:00.000000', 'NZP-780', 'PÃ©cs', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'test', 1550, 1568, 18, 'md', 8.6, 'Benzin', 'uploads/2017-06-15 19:58NZP-780.jpg', '2017-06-15 19:58NZP-780.jpg'),
(94, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 20:00:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'PÃ©cs', 'asd', 1550, 1582, 32, 'md', 8.6, 'Benzin', 'uploads/2017-06-15 20:00NZP-780.jpg', '2017-06-15 20:00NZP-780.jpg'),
(95, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 20:05:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'tesyt', 10, 41, 31, NULL, 6.3, 'Benzin', 'uploads/2017-06-15 20:05NDN-239.jpg', '2017-06-15 20:05NDN-239.jpg'),
(96, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 20:08:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'test', 1550, 1572, 22, 'md', 8.6, 'Benzin', 'uploads/2017-06-15 20:08NZP-780.jpg', '2017-06-15 20:08NZP-780.jpg'),
(97, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 20:17:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'feeling it', 10, 29, 19, NULL, 6.3, 'Benzin', 'uploads/2017-06-15 20:17NDN-239.jpg', '2017-06-15 20:17NDN-239.jpg'),
(98, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 20:21:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'feeling it more', 1550, 1568, 18, 'md', 8.6, 'Benzin', 'uploads/2017-06-15 20:21NZP-780.jpg', '2017-06-15 20:21NZP-780.jpg'),
(99, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 20:24:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'valamics', 1550, 1574, 24, 'di', 8.6, 'Benzin', 'uploads/2017-06-15 20:24NZP-780.jpg', '2017-06-15 20:24NZP-780.jpg'),
(100, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 20:42:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'asdf', 10, 29, 19, NULL, 6.3, 'Benzin', 'uploads/2017-06-15 20:42NDN-239.jpg', '2017-06-15 20:42NDN-239.jpg'),
(101, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 20:52:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'feeelin it', 10, 28, 18, NULL, 6.3, 'Benzin', 'uploads/2017-06-15 20:52NDN-239.jpg', '2017-06-15 20:52NDN-239.jpg'),
(102, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 21:07:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Meeting', 28, 44, 16, NULL, 6.3, 'Benzin', 'uploads/2017-06-15 21:07NDN-239.jpg', '2017-06-15 21:07NDN-239.jpg'),
(103, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 21:18:00.000000', 'NDN-239', 'PÃ©cs', NULL, 'Budapest', 'Meeting', 44, 67, 23, NULL, 6.3, 'Benzin', 'uploads/2017-06-15 21:18NDN-239.jpg', '2017-06-15 21:18NDN-239.jpg'),
(104, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 21:07:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Meeting', 28, 44, 16, NULL, 6.3, 'Benzin', 'uploads/2017-06-15 21:07NDN-239.jpg', '2017-06-15 21:07NDN-239.jpg'),
(105, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 21:18:00.000000', 'NDN-239', 'PÃ©cs', NULL, 'Budapest', 'Meeting', 44, 67, 23, NULL, 6.3, 'Benzin', 'uploads/2017-06-15 21:18NDN-239.jpg', '2017-06-15 21:18NDN-239.jpg'),
(107, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-06-15 21:29:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'This is the one', 89, 109, 20, NULL, 6.3, 'Benzin', 'uploads/2017-06-15 2129NDN-239.jpg', '2017-06-15 2129NDN-239.jpg'),
(108, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-07-17 07:26:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'meeting', 1550, 1585, 35, 'md', 8.6, 'Benzin', 'uploads/2017-07-17 0726NZP-780.jpg', '2017-07-17 0726NZP-780.jpg'),
(109, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-07-17 07:32:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'Lovaskocsi Ã©pÃ­tÃ©s', 1585, 1606, 21, 'di', 8.6, 'Benzin', 'uploads/2017-07-17 0732NZP-780.jpg', '2017-07-17 0732NZP-780.jpg'),
(110, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-07-17 07:37:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'DolgozÃ¡s', 1606, 1630, 24, 'oszoc', 8.6, 'Benzin', 'uploads/2017-07-17 0737NZP-780.jpg', '2017-07-17 0737NZP-780.jpg'),
(111, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-07-17 07:39:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'ErÅ‘lkÃ¶dÃ©s a Munka ErÅ‘ben', 1630, 1656, 26, 'me', 8.6, 'Benzin', 'uploads/2017-07-17 0739NZP-780.jpg', '2017-07-17 0739NZP-780.jpg'),
(112, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-07-18 08:31:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', '204394774', 109, 127, 18, NULL, 6.3, 'Benzin', 'uploads/2017-07-18 0831NDN-239.jpg', '2017-07-18 0831NDN-239.jpg'),
(115, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-07-24 08:45:00.000000', 'NZP-780', 'Helszinki', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'TankolÃ¡s', 2000, 2017, 17, 'NA', 8.6, 'Benzin', 'uploads/2017-07-24 0845NZP-780.jpg', '2017-07-24 0845NZP-780.jpg'),
(116, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-07-24 09:07:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'TankolÃ¡s', 2017, 2028, 11, 'NA', 8.6, 'Benzin', 'uploads/2017-07-24 0907NZP-780.jpg', '2017-07-24 0907NZP-780.jpg'),
(117, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-07-24 09:14:00.000000', 'NZP-780', 'Amsterdam', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'TankolÃ¡s', 2028, 2038, 10, 'NA', 8.6, 'Benzin', 'uploads/2017-07-24 0914NZP-780.jpg', '2017-07-24 0914NZP-780.jpg'),
(118, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-07-24 09:15:30.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'Rotterdam', 'Most biztos', 2038, 2060, 22, 'NA', 8.6, 'Benzin', 'uploads/N/A', 'N/A'),
(119, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-07-24 10:13:00.000000', 'NZP-780', 'KozÃ¡rmisleny', 'DAKÃ“-P \'96 Kft', 'KozÃ¡rmisleny', 'asdvadfbad', 2060, 2061, 1, 'di', 8.6, 'Benzin', 'uploads/N/A', 'N/A'),
(120, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-07-24 10:45:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'sadfrgb', 127, 135, 8, NULL, 6.3, 'Benzin', 'uploads/N/A', 'N/A'),
(121, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-07-31 16:34:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Valami', 135, 153, 18, NULL, 6.3, 'Benzin', 'uploads/N/A', 'N/A'),
(122, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-08-01 13:01:00.000000', 'VIA851', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'afvadfb', 111233, 111271, 38, NULL, 12.4, 'Benzin', 'uploads/N/A', 'N/A'),
(123, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-08-01 13:01:00.000000', 'VIA851', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'fghntghn', 111307, 111349, 42, NULL, 12.4, 'Benzin', 'uploads/N/A', 'N/A'),
(124, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-08-01 13:02:00.000000', 'VIA851', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'dghtjmyk', 111349, 111394, 45, NULL, 12.4, 'Benzin', 'uploads/N/A', 'N/A'),
(125, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-08-01 13:09:00.000000', 'VIA851', 'PÃ©cs', NULL, 'KozÃ¡rmisleny', 'Meeting a videotonnal', 111394, 111410, 16, NULL, 12.4, 'Benzin', 'uploads/N/A', 'N/A'),
(126, 'Teszt Elek', '2017-08-05 08:09:00.000000', 'TES123', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'Valami', 33245, 33273, 28, NULL, 4.3, 'Benzin', 'uploads/N/A', 'N/A'),
(127, 'ZÃ¡kÃ¡ny BalÃ¡zs', '2017-08-09 22:28:00.000000', 'NDN-239', 'KozÃ¡rmisleny', NULL, 'KozÃ¡rmisleny', 'dfgasfdg', 153, 164, 11, NULL, 6.3, 'Benzin', 'uploads/N/A', 'N/A');

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
-- AUTO_INCREMENT a táblához `autok`
--
ALTER TABLE `autok`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT a táblához `cegestigek`
--
ALTER TABLE `cegestigek`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;
--
-- AUTO_INCREMENT a táblához `elszamolasok`
--
ALTER TABLE `elszamolasok`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT a táblához `hozzarendel`
--
ALTER TABLE `hozzarendel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT a táblához `kilometer`
--
ALTER TABLE `kilometer`
  MODIFY `id` int(155) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT a táblához `utak`
--
ALTER TABLE `utak`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
--
-- AUTO_INCREMENT a táblához `uzemanyagar`
--
ALTER TABLE `uzemanyagar`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
