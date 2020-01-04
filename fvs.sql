-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 04, 2020 at 06:35 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fvs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `nic` char(12) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`nic`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`nic`, `password`) VALUES
('123456789V', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

-- --------------------------------------------------------

--
-- Table structure for table `assistant_election_officer`
--

DROP TABLE IF EXISTS `assistant_election_officer`;
CREATE TABLE IF NOT EXISTS `assistant_election_officer` (
  `nic` char(12) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dist_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nic`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assistant_election_officer`
--

INSERT INTO `assistant_election_officer` (`nic`, `password`, `dist_id`, `is_deleted`) VALUES
('443116652v', '89339', 1, 0),
('452094787v', '23665', 2, 0),
('454139033v', '62512', 3, 0),
('470346999v', '82745', 4, 0),
('988710356v', '16320', 5, 0),
('983535670v', '78303', 6, 0),
('974688009v', '15000', 7, 0),
('968601431v', '64897', 8, 0),
('956244501v', '38832', 9, 0),
('947767855v', '42224', 10, 0),
('940490746v', '81384', 11, 0),
('834667729v', '67475', 12, 0),
('844246346v', '95638', 13, 0),
('544717258v', '51550', 14, 0),
('693507280v', '25961', 15, 0),
('599405907v', '46654', 16, 0),
('585186415v', '55638', 17, 0),
('678733517v', '96175', 18, 0),
('987830651v', '61485', 19, 0),
('448404080v', '52587', 20, 0),
('603838449v', '76636', 22, 0),
('949438212v', '19411', 22, 0);

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

DROP TABLE IF EXISTS `candidate`;
CREATE TABLE IF NOT EXISTS `candidate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nic` varchar(12) NOT NULL,
  `party_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '../img/candidate/candidate_default.png',
  `name_si` varchar(255) CHARACTER SET utf8 NOT NULL,
  `name_ta` varchar(255) CHARACTER SET utf8 NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`id`, `nic`, `party_id`, `image`, `name_si`, `name_ta`, `schedule_id`, `is_deleted`) VALUES
(1, '567921439v', 12, '../img/candidate/', 'à¶©à·à¶»à·’à·ƒà·Š à·€à¶»à·Šà¶§à·’à¶œà¶±à·Š', 'à®Ÿà¯‡à®°à®¿à®¸à¯ à®µà¯†à®°à¯à®Ÿà®¿à®•à®©à¯', 1, 0),
(2, '506712485v', 10, '../img/candidate/', 'à¶©à·šà·€à·’à¶©à·Š à¶¸à·™à¶½à·Šà¶§à·™à¶§à¶½à·Š', 'à®Ÿà¯‡à®µà®¿à®Ÿà¯ à®®à¯†à®²à¯à®Ÿà¯†à®Ÿà¯à®Ÿà®²à¯', 1, 0),
(3, '452248157v', 1, '../img/candidate/', 'à¶’à¶©à·Šâ€à¶»à·’à¶ºà¶±à·Š à¶œà·œà¶½à·’à¶‚', 'à®…à®Ÿà¯à®°à®¿à®¯à®©à¯ à®•à¯‹à®²à®¿à®™à¯', 1, 0),
(4, '555859822v', 7, '../img/candidate/', 'à¶¶à·à¶»à¶§à·Š à¶´à·”à·ƒà·Š', 'à®ªà®¾à®°à¯†à®Ÿà¯ à®®à¯‹à®²à¯à®Ÿà¯à®¸à¯', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `disabled_card`
--

DROP TABLE IF EXISTS `disabled_card`;
CREATE TABLE IF NOT EXISTS `disabled_card` (
  `card_id` bigint(12) NOT NULL,
  `pin` int(5) NOT NULL,
  `nic` char(12) NOT NULL,
  PRIMARY KEY (`card_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `disabled_card`
--

INSERT INTO `disabled_card` (`card_id`, `pin`, `nic`) VALUES
(758241360254, 12345, '988605107v');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
CREATE TABLE IF NOT EXISTS `district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `prov_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id`, `name`, `prov_id`) VALUES
(1, 'Ampara', 3),
(2, 'Anuradhapura', 9),
(3, 'Badulla', 7),
(4, 'Batticaloa', 3),
(5, 'Colombo', 1),
(6, 'Galle', 2),
(7, 'Gampaha', 1),
(8, 'Hambantota', 2),
(9, 'Jaffna', 4),
(10, 'Kaluthara', 1),
(11, 'Kandy', 5),
(12, 'Kegalle', 6),
(13, 'Kurunegala', 8),
(14, 'Matale', 5),
(15, 'Matara', 2),
(16, 'Monaragala', 7),
(17, 'Nuwara Eliya', 5),
(18, 'Polonnaruwa', 9),
(19, 'Puttalam', 8),
(20, 'Ratnapura', 6),
(21, 'Trincomalee', 3),
(22, 'Vanni', 4);

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

DROP TABLE IF EXISTS `division`;
CREATE TABLE IF NOT EXISTS `division` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `dist_id` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`id`, `name`, `dist_id`, `is_deleted`) VALUES
(1, 'Colombo-North', 5, 0),
(2, 'Colombo Central', 5, 0),
(3, 'Borella', 5, 0),
(4, 'Colombo East', 5, 0),
(5, 'Colombo West', 5, 0),
(6, 'Dehiwala', 5, 0),
(7, 'Ratmalana', 5, 0),
(8, 'Kolonnawa', 5, 0),
(9, 'Kotte', 5, 0),
(10, 'Kaduwela', 5, 0),
(11, 'Avissawella', 5, 0),
(12, 'Homagama', 5, 0),
(13, 'Maharagama', 5, 0),
(14, 'Kesbewa', 5, 0),
(15, 'Moratuwa', 5, 0),
(16, 'Wattala', 7, 0),
(17, 'Negambo', 7, 0),
(18, 'Katana', 7, 0),
(19, 'Divulapitiya', 7, 0),
(20, 'Mirigama', 7, 0),
(21, 'Minuwangoda', 7, 0),
(22, 'Attanagalla', 7, 0),
(23, 'Gampaha', 7, 0),
(24, 'Ja Ela', 7, 0),
(25, 'Mahara', 7, 0),
(26, 'Dompe', 7, 0),
(27, 'Biyagama', 7, 0),
(28, 'Kelaniya', 7, 0),
(29, 'Panadura', 10, 0),
(30, 'Bandaragama', 10, 0),
(31, 'Horana', 10, 0),
(32, 'Bulathsinhala', 10, 0),
(33, 'Matugama', 10, 0),
(34, 'Kalutara', 10, 0),
(35, 'Beruwala', 10, 0),
(36, 'Agalawatte', 10, 0),
(37, 'Galagedera', 11, 0),
(38, 'Harispattuwa', 11, 0),
(39, 'Patha Dumbara', 11, 0),
(40, 'Uda Dumbara', 11, 0),
(41, 'Teldeniya', 11, 0),
(42, 'Kundasale', 11, 0),
(43, 'Hewaheta', 11, 0),
(44, 'Senkadagala', 11, 0),
(45, 'Mahanuwara', 11, 0),
(46, 'Yatinuwara', 11, 0),
(47, 'Udunuwara', 11, 0),
(48, 'Gampola', 11, 0),
(49, 'Nawalapitiya', 11, 0),
(50, 'Dambulla', 14, 0),
(51, 'Laggala', 14, 0),
(52, 'Matale', 14, 0),
(53, 'Rattota', 14, 0),
(54, 'N_Eliya Maskeliya', 17, 0),
(55, 'Kotmale', 17, 0),
(56, 'Hanguranketa', 17, 0),
(57, 'Walapane', 17, 0),
(58, 'Balapitiya', 6, 0),
(59, 'Ambalangoda', 6, 0),
(60, 'Karandeniya', 6, 0),
(61, 'Bentara Elpitiya', 6, 0),
(62, 'Hiniduma', 6, 0),
(63, 'Baddegama', 6, 0),
(64, 'Ratgama', 6, 0),
(65, 'Galle', 6, 0),
(66, 'Akmeemana', 6, 0),
(67, 'Habaraduwa', 6, 0),
(68, 'Deniyaya', 15, 0),
(69, 'Hakmana', 15, 0),
(70, 'Akuressa', 15, 0),
(71, 'Kamburupitiya', 15, 0),
(72, 'Devinuwara', 15, 0),
(73, 'Matara', 15, 0),
(74, 'Weligama', 15, 0),
(75, 'Mulkirigala', 8, 0),
(76, 'Beliatta', 8, 0),
(77, 'Tangalla', 8, 0),
(78, 'Tissamaharama', 8, 0),
(79, 'Kayts', 9, 0),
(80, 'Vaddukoddai', 9, 0),
(81, 'Kankesanthurai', 9, 0),
(82, 'Manipay', 9, 0),
(83, 'Kopay', 9, 0),
(84, 'Udupiddy', 9, 0),
(85, 'Point Pedro', 9, 0),
(86, 'Chawakachcheri', 9, 0),
(87, 'Nallur', 9, 0),
(88, 'Jaffna', 9, 0),
(89, 'Kilinochchi', 9, 0),
(90, 'Mannar', 22, 0),
(91, 'Vavuniya', 22, 0),
(92, 'Mullaitivu', 22, 0),
(93, 'Kalkudah', 4, 0),
(94, 'Batticaloa', 4, 0),
(95, 'Paddiruppu', 4, 0),
(96, 'Ampara', 1, 0),
(97, 'Samanthurai', 1, 0),
(98, 'Kalmunai', 1, 0),
(99, 'Pottuvil', 1, 0),
(100, 'Seruwila', 21, 0),
(101, 'Trincomalee', 21, 0),
(102, 'Mutur', 21, 0),
(103, 'Galgamuwa', 13, 0),
(104, 'Nikaweratiya', 13, 0),
(105, 'Yapahuwa', 13, 0),
(106, 'Hiriyala', 13, 0),
(107, 'Wariyapola', 13, 0),
(108, 'Panduwasnuwara', 13, 0),
(109, 'Bingiriya', 13, 0),
(110, 'Katugampola', 13, 0),
(111, 'Kuliyapitiya', 13, 0),
(112, 'Dambadeniya', 13, 0),
(113, 'Polgahawela', 13, 0),
(114, 'Kurunegala', 13, 0),
(115, 'Mawathagama', 13, 0),
(116, 'Dodangaslanda', 13, 0),
(117, 'Puttalam', 19, 0),
(118, 'Anamaduwa', 19, 0),
(119, 'Chilaw', 19, 0),
(120, 'Nattandiya', 19, 0),
(121, 'Wennappuwa', 19, 0),
(122, 'Medawachchiya', 2, 0),
(123, 'Horawupotana', 2, 0),
(124, 'Anuradhapura East', 2, 0),
(125, 'Anuradhapura West', 2, 0),
(126, 'Kalawewa', 2, 0),
(127, 'Mihintale', 2, 0),
(128, 'Kekirawa', 2, 0),
(129, 'Minneriya', 18, 0),
(130, 'Medirigiriya', 18, 0),
(131, 'Polonnaruwa', 18, 0),
(132, 'Mahiyangana', 3, 0),
(133, 'Wiyaluwa', 3, 0),
(134, 'Passara', 3, 0),
(135, 'Badulla', 3, 0),
(136, 'Hali Ela', 3, 0),
(137, 'Uva Paranagama', 3, 0),
(138, 'Welimada', 3, 0),
(139, 'Bandarawela', 3, 0),
(140, 'Haputale', 3, 0),
(141, 'Bibile', 16, 0),
(142, 'Monaragala', 16, 0),
(143, 'Wellawaya', 16, 0),
(144, 'Eheliyagoda', 20, 0),
(145, 'Ratnapura', 20, 0),
(146, 'Pelmadulla', 20, 0),
(147, 'Balangoda', 20, 0),
(148, 'Rakwana', 20, 0),
(149, 'Nivitigala', 20, 0),
(150, 'Kalawana', 20, 0),
(151, 'Kolonna', 20, 0),
(152, 'Dedigama', 12, 0),
(153, 'Galigamuwa', 12, 0),
(154, 'Kegalle', 12, 0),
(155, 'Rambukkana', 12, 0),
(156, 'Mawanella', 12, 0),
(157, 'Aranayake', 12, 0),
(158, 'Yatiyantota', 12, 0),
(159, 'Ruwanwella', 12, 0),
(160, 'Deraniyagalaa', 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `division_officer`
--

DROP TABLE IF EXISTS `division_officer`;
CREATE TABLE IF NOT EXISTS `division_officer` (
  `nic` char(12) NOT NULL,
  `password` varchar(255) NOT NULL,
  `work_divi_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nic`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `division_officer`
--

INSERT INTO `division_officer` (`nic`, `password`, `work_divi_id`, `is_deleted`) VALUES
('542893419v', '63767', 36, 0),
('596579933v', '73455', 124, 0),
('634006397v', '85214', 66, 0),
('802360140v', '35109', 36, 0),
('827152364v', '45551', 36, 0),
('836958912v', '59202', 36, 0);

-- --------------------------------------------------------

--
-- Table structure for table `election`
--

DROP TABLE IF EXISTS `election`;
CREATE TABLE IF NOT EXISTS `election` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) NOT NULL,
  `name_si` varchar(255) CHARACTER SET utf8 NOT NULL,
  `name_ta` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `election`
--

INSERT INTO `election` (`id`, `name_en`, `name_si`, `name_ta`) VALUES
(1, 'Presidential Election', 'à¶¢à¶±à·à¶°à·’à¶´à¶­à·’à·€à¶»à¶«à¶º', 'à®œà®©à®¾à®¤à®¿à®ªà®¤à®¿à®¤à¯ à®¤à¯‡à®°à¯à®¤à®²à¯'),
(2, 'Parliamentary Election', 'à¶´à·à¶»à·Šà¶½à·’à¶¸à·šà¶±à·Šà¶­à·” à¶¸à·à¶­à·’à·€à¶»à¶«à¶º', 'à®ªà®¾à®°à®¾à®³à¯à®®à®©à¯à®±à®¤à¯ à®¤à¯‡à®°à¯à®¤à®²à¯à®•à®³à¯'),
(3, 'Provincial Council Elections', 'à¶´à·…à·à¶­à·Š à·ƒà¶·à· à¶¡à¶±à·Šà¶¯ à·€à·’à¶¸à·ƒà·“à¶¸', 'à®®à®¾à®•à®¾à®£ à®šà®ªà¯ˆà®•à®³à¯ à®¤à¯‡à®°à¯à®¤à®²à¯à®•à®³à¯'),
(4, 'Local Authorities Election', 'à¶´à·…à·à¶­à·Š à¶´à·à¶½à¶± à¶†à¶ºà¶­à¶± à¶¡à¶±à·Šà¶¯ à·€à·’à¶¸à·ƒà·“à¶¸', 'à®‰à®³à¯à®³à¯‚à®°à¯ à®…à®¤à®¿à®•à®¾à®° à®šà®ªà¯ˆà®•à®³à¯ à®¤à¯‡à®°à¯à®¤à®²à¯à®•à®³à¯');

-- --------------------------------------------------------

--
-- Table structure for table `election_schedule`
--

DROP TABLE IF EXISTS `election_schedule`;
CREATE TABLE IF NOT EXISTS `election_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `election_schedule`
--

INSERT INTO `election_schedule` (`id`, `type`, `date_from`, `date_to`, `is_deleted`) VALUES
(1, 1, '2020-01-04 08:00:58', '2020-01-04 16:00:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inspector`
--

DROP TABLE IF EXISTS `inspector`;
CREATE TABLE IF NOT EXISTS `inspector` (
  `nic` char(12) NOT NULL,
  `password` varchar(255) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nic`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inspector`
--

INSERT INTO `inspector` (`nic`, `password`, `schedule_id`, `is_deleted`) VALUES
('966568770v', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `participate`
--

DROP TABLE IF EXISTS `participate`;
CREATE TABLE IF NOT EXISTS `participate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_id` int(11) NOT NULL,
  `voter_nic` char(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `party`
--

DROP TABLE IF EXISTS `party`;
CREATE TABLE IF NOT EXISTS `party` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) NOT NULL,
  `name_si` varchar(255) CHARACTER SET utf8 NOT NULL,
  `name_ta` varchar(255) CHARACTER SET utf8 NOT NULL,
  `secretary_name` varchar(255) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `start_date` date NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `color` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `party`
--

INSERT INTO `party` (`id`, `name_en`, `name_si`, `name_ta`, `secretary_name`, `contact`, `start_date`, `address`, `color`, `symbol`, `is_deleted`) VALUES
(1, 'Ilankai Tamil Arasu Kadchi', 'ඉලංකෙයි තමිල් අරසු කච්චි', 'இலங்கைத் தமிழ் அரசுக் கட்சி', 'Suresh Premachandran', '0212228776', '1949-12-18', '30, Martin Road, Jaffna.', '#FFFF00', '../img/partySymbol/1.png', 0),
(2, 'United People\'s Freedom Alliance', 'එක්සත් ජනතා නිදහස් සන්ධානය', 'ஐக்கிய மக்கள் சுதந்திர முன்னணி\r\n ', 'Mahinda Amaraweera', '0112686077', '2004-01-20', '301, T. B. Jayah Mawatha, Colombo 10.', '', '../img/partySymbol/2.png', 0),
(3, 'United National Party ', 'එක්සත් ජාතික පක්ෂය', 'ஐக்கிய தேசியக் கட்சி', 'Akila Viraj Kariyawasam ', '0112865374', '1946-09-06', '“Sirikotha”, 400, Kotte Road, Pitakotte', '', '../img/partySymbol/3.png', 0),
(4, 'United Socialist Party\r\n', 'එක්සත් සමාජවාදී පක්ෂය', 'ஐக்கிய சோசலிச கட்சி\r\n', 'Sirithunga Jayasuriya', '0112586199', '2007-03-24', '53/6, E. D. Dabare Mawatha, Narahenpita, Colombo 05', '', '../img/partySymbol/4.png', 0),
(5, 'Workers National Front', 'කම්කරු ජාතික පෙරමුණ', 'தொழிலாளர் தேசிய முன்னணி', 'M.Thilakaraja', '0112982998', '2015-07-05', '187 A, Dimbula Road, Hatton', '', '../img/partySymbol/5.png', 0),
(6, 'People\'s Liberation Front', 'ජනතා විමුක්ති පෙරමුණ', 'மக்கள் விடுதலை முன்னணி', 'M.T.Silva', '0112785612', '1965-05-14', '464/20, Pannipitiya Road, Pelawatte, Battaramulla', '', '../img/partySymbol/6.png', 0),
(7, 'Jathika Hela Urumaya', 'ජාතික හෙළ උරුමය', 'ஜாதிக ஹெல உறுமய ', 'Patalie Champika Ranawaka', '011 286612', '2004-04-02', '964/2, Pannipitiya Road, Battaramulla', '', '../img/partySymbol/7.png', 0),
(8, 'New Democratic Front', 'නව ප්‍රජාතන්ත්‍රවාදී පෙරමුණ', 'புதிய ஜனநாயக முன்னணி ', 'Shamila Perera', '0112785531', '1995-05-15', '9/6, Jayanthi Mawatha, Pelawatte, Battaramulla', '', '../img/partySymbol/8.png', 0),
(9, 'Nawa Sama Samaja Party ', 'නව සමසමාජ පක්ෂය', 'நவ சம சமாஜக் கட்சி', 'Wickramabahu Karunaratne', '0112430621', '1997-12-15', '17, Barracks Lane, Colombo 02', '', '../img/partySymbol/9.png', 0),
(10, 'Frontline Socialist Party', 'පෙරටුගාමී සමාජවාදී පක්ෂය', 'முன்னிலை சோஷலிஸ கட்சி ', 'Senadheera Gunathilake', '  01128374', '2012-04-09', '553/B2, Gemunu Mavatha, Udumulla Road, Battaramulla', '', '../img/partySymbol/party_default.png', 0),
(11, 'Muslim National Alliance', 'මුස්ලිම් ජාතික සන්ධානය', 'முஸ்லிம் தேசிய கூட்டமைப்பு', 'Masihudeen Naeemullah', '0112697505', '2018-09-12', '258, Katugastota Road, Kandy', '', '../img/partySymbol/party_default.png', 0),
(12, 'Ceylon Worker\'s Congress ', 'ලංකා කම්කරු කොංග්‍රසය ', 'இலங்கை தொழிலாளர் காங்கிரஸ் ', 'Anusha Sivaraja', '0112574524', '1939-05-04', '72, Ananda Coomaraswamy Mawatha, Colombo 07', '', '../img/partySymbol/party_default.png', 0),
(13, 'Sri Lanka Podujana Peramuna ', 'ශ්‍රී ලංකා පොදුජන පෙරමුණ', 'ஸ்ரீ லங்கா பொதுஜன பெரமுன', 'Sagara Kariyawasam', '0112518565', '2016-11-06', '8/11, Robert Alwis Mawatha, Boralesgamuwa', '', '../img/partySymbol/13.png', 0),
(14, 'Sri Lanka Muslim Congress', 'ශ්‍රී ලංකා මුස්ලිම් කොංග්‍රසය', 'Sri Lanka Muslim Congress', 'M. Nizam Kariappar', '0112436752', '1981-09-11', '“Darus Salam” 51, Vauxhall Lane, Colombo 02', '', '../img/partySymbol/party_default.png', 0),
(15, 'Socialist Alliance', 'සමාජවාදී ජනතා පෙරමුණ', 'சோஷலிஸ மக்கள் முன்னணி', 'D.C. Raja Collure', '0112695328', '2006-07-08', '91, Dr. N.M. Perera Mawatha, Colombo 08', '', '../img/partySymbol/party_default.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `province`
--

DROP TABLE IF EXISTS `province`;
CREATE TABLE IF NOT EXISTS `province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `province`
--

INSERT INTO `province` (`id`, `name`) VALUES
(1, 'Western Province'),
(2, 'Southern Province'),
(3, 'Eastern Province'),
(4, 'Nothern Province'),
(5, 'Central Province'),
(6, 'Sabaragamuwa Province'),
(7, 'Uva Province'),
(8, 'North Western Province'),
(9, 'North Central Province');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

DROP TABLE IF EXISTS `vote`;
CREATE TABLE IF NOT EXISTS `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_id` varchar(255) NOT NULL,
  `candidate_id` varchar(255) NOT NULL,
  `preference` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`,`schedule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=965421728 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `voter`
--

DROP TABLE IF EXISTS `voter`;
CREATE TABLE IF NOT EXISTS `voter` (
  `nic` varchar(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `b_day` date NOT NULL,
  `gender` char(6) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fingerprint_R` varchar(255) NOT NULL,
  `fingerprint_L` varchar(255) NOT NULL,
  `divi_id` int(11) NOT NULL,
  `language` char(1) NOT NULL,
  `role` varchar(6) NOT NULL DEFAULT 'voter',
  `is_disabled` tinyint(4) NOT NULL DEFAULT '0',
  `is_died` tinyint(4) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nic`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voter`
--

INSERT INTO `voter` (`nic`, `name`, `contact`, `b_day`, `gender`, `email`, `fingerprint_R`, `fingerprint_L`, `divi_id`, `language`, `role`, `is_disabled`, `is_died`, `is_deleted`) VALUES
('597310362v', 'Diannne Podmore', '0712546325', '1962-06-14', 'Female', 'dpodmore28@ox.ac.uk', '7', 'ABC', 2, 'E', 'voter', 0, 0, 0),
('652122117v', 'Tracee Sarfatti', '0712546325', '1957-09-28', 'Female', 'tsarfatti27@1und1.de', '57', 'ABC', 42, 'E', 'voter', 0, 0, 0),
('914274741v', 'Selma Cowitz', '0712546325', '1981-12-15', 'Female', 'scowitz26@goo.ne.jp', '97', 'ABC', 110, 'E', 'voter', 0, 0, 0),
('866484950v', 'Garreth Windeatt', '0712546325', '1961-01-06', 'Male', 'gwindeatt25@angelfire.com', '47', 'ABC', 4, 'E', 'voter', 0, 0, 0),
('643564942v', 'Raine Delle', '0712546325', '1963-06-22', 'Female', 'rdelle24@facebook.com', '68', 'ABC', 101, 'T', 'voter', 0, 0, 0),
('506712485v', 'Davidde Meltetal', '0712546325', '1973-04-29', 'Male', 'dmeltetal23@theguardian.com', '52', 'ABC', 160, 'E', 'voter', 0, 0, 0),
('684102072v', 'Darcey Coytes', '0712546325', '1989-12-20', 'Female', 'dcoytes22@merriam-webster.com', '42', 'ABC', 114, 'E', 'voter', 0, 0, 0),
('830459806v', 'Marlie Thunderman', '0712546325', '1982-05-09', 'Female', 'mthunderman21@stumbleupon.com', '96', 'ABC', 16, 'E', 'voter', 0, 0, 0),
('678733517v', 'Emmott Bugg', '0712546325', '1995-06-06', 'Male', 'ebugg20@hud.gov', '20', 'ABC', 126, 'E', 'AEO', 0, 0, 0),
('749605664v', 'Hilario Peek', '0712546325', '1953-06-23', 'Male', 'hpeek1z@jimdo.com', '40', 'ABC', 149, 'E', 'voter', 0, 0, 0),
('727645780v', 'Xena Balazin', '0712546325', '1946-04-18', 'Female', 'xbalazin1y@ftc.gov', '76', 'ABC', 149, 'T', 'voter', 0, 0, 0),
('985903536v', 'Jane Gee', '0712546325', '1996-09-26', 'Female', 'jgee1x@noaa.gov', '26', 'ABC', 94, 'E', 'voter', 0, 0, 0),
('785474411v', 'Kristina Cadle', '0712546325', '1978-11-19', 'Female', 'kcadle1w@alibaba.com', '22', 'ABC', 152, 'E', 'voter', 0, 0, 0),
('947767855v', 'Wade D\'Aguanno', '0712546325', '1963-06-14', 'Male', 'wdaguanno1v@bing.com', '24', 'ABC', 131, 'E', 'AEO', 0, 0, 0),
('577005751v', 'Rockey Bettley', '0712546325', '1957-10-10', 'Male', 'rbettley1u@i2i.jp', '83', 'ABC', 67, 'T', 'voter', 0, 0, 0),
('965803229v', 'Orazio Eddisford', '0712546325', '1994-05-12', 'Male', 'oeddisford1t@umich.edu', '99', 'ABC', 21, 'T', 'voter', 0, 0, 0),
('763832058v', 'Waiter Olkowicz', '0712546325', '1984-07-06', 'Male', 'wolkowicz1s@newyorker.com', '9', 'ABC', 91, 'T', 'voter', 0, 0, 0),
('949438212v', 'Frederich Dyter', '0712546325', '1987-12-28', 'Male', 'fdyter1r@flickr.com', '51', 'ABC', 35, 'E', 'AEO', 0, 0, 0),
('677701039v', 'Elmer Luckin', '0712546325', '1987-04-02', 'Male', 'eluckin1q@addtoany.com', '90', 'ABC', 140, 'E', 'voter', 0, 0, 0),
('454139033v', 'Wenona Shilburne', '0712546325', '1948-06-14', 'Female', 'wshilburne1p@tmall.com', '100', 'ABC', 16, 'T', 'AEO', 0, 0, 0),
('711129498v', 'Jade Monro', '0712546325', '1985-09-04', 'Female', 'jmonro1o@umn.edu', '81', 'ABC', 131, 'E', 'voter', 0, 0, 0),
('596579933v', 'Pavla Laurisch', '0712546325', '1976-12-09', 'Female', 'plaurisch1n@accuweather.com', '16', 'ABC', 8, 'T', 'DO', 0, 0, 0),
('818915955v', 'Michelina Hurdiss', '0712546325', '1947-12-27', 'Female', 'mhurdiss1m@illinois.edu', '50', 'ABC', 8, 'T', 'voter', 0, 0, 0),
('968601431v', 'Nehemiah MacCumeskey', '0712546325', '1964-06-21', 'Male', 'nmaccumeskey1l@istockphoto.com', '88', 'ABC', 38, 'T', 'AEO', 0, 0, 0),
('443116652v', 'Elliott Pilfold', '0712546325', '1984-10-26', 'Male', 'epilfold1k@webnode.com', '92', 'ABC', 154, 'T', 'AEO', 0, 0, 0),
('555859822v', 'Barret Moulds', '0712546325', '1956-09-23', 'Male', 'bmoulds1j@paypal.com', '12', 'ABC', 28, 'T', 'voter', 0, 0, 0),
('940490746v', 'Bethany Brightling', '0712546325', '1986-04-05', 'Female', 'bbrightling1i@indiatimes.com', '88', 'ABC', 97, 'T', 'AEO', 0, 0, 0),
('544717258v', 'Eward O\'Lenechan', '0712546325', '1980-06-29', 'Male', 'eolenechan1h@smugmug.com', '22', 'ABC', 54, 'T', 'AEO', 0, 0, 0),
('603838449v', 'Cecile Shark', '0712546325', '1965-11-24', 'Female', 'cshark1g@bbc.co.uk', '96', 'ABC', 120, 'T', 'AEO', 0, 0, 0),
('524437940v', 'Lula Counihan', '0712546325', '1944-09-27', 'Female', 'lcounihan1f@msu.edu', '93', 'ABC', 34, 'T', 'voter', 0, 0, 0),
('872317118v', 'Norene Olifard', '0712546325', '1950-02-12', 'Female', 'nolifard1e@slashdot.org', '5', 'ABC', 21, 'T', 'voter', 0, 0, 0),
('983535670v', 'Sharl Lezemere', '0712546325', '1976-05-21', 'Female', 'slezemere1d@yale.edu', '100', 'ABC', 115, 'T', 'AEO', 0, 0, 0),
('943879394v', 'Dixie Syvret', '0712546325', '1971-03-23', 'Female', 'dsyvret1c@eepurl.com', '48', 'ABC', 70, 'T', 'voter', 0, 0, 0),
('844246346v', 'Donall Mabbot', '0712546325', '1968-01-03', 'Male', 'dmabbot1b@newsvine.com', '79', 'ABC', 72, 'T', 'AEO', 0, 0, 0),
('591377809v', 'Meredeth Maillard', '0712546325', '1952-11-14', 'Male', 'mmaillard1a@businesswire.com', '58', 'ABC', 72, 'T', 'voter', 0, 0, 0),
('719081931v', 'Tracie Oram', '0712546325', '1997-02-27', 'Male', 'toram19@mysql.com', '76', 'ABC', 65, 'T', 'voter', 0, 0, 0),
('470845149v', 'Bibbye Arlett', '0712546325', '1979-05-05', 'Female', 'barlett18@va.gov', '37', 'ABC', 100, 'T', 'voter', 0, 0, 0),
('693507280v', 'Deeyn Jillis', '0712546325', '1985-01-01', 'Female', 'djillis17@printfriendly.com', '48', 'ABC', 20, 'T', 'AEO', 0, 0, 0),
('634006397v', 'Humbert Fairlem', '0712546325', '1994-02-11', 'Male', 'hfairlem16@lulu.com', '94', 'ABC', 43, 'T', 'DO', 0, 0, 0),
('868727971v', 'Junette Antonelli', '0712546325', '1988-01-15', 'Female', 'jantonelli15@prnewswire.com', '20', 'ABC', 124, 'T', 'voter', 0, 0, 0),
('611863961v', 'Walker Kornalik', '0712546325', '1971-01-04', 'Male', 'wkornalik14@eepurl.com', '42', 'ABC', 159, 'T', 'voter', 0, 0, 0),
('764874253v', 'Ephrayim Hotson', '0712546325', '1973-01-27', 'Male', 'ehotson13@twitter.com', '41', 'ABC', 17, 'T', 'voter', 0, 0, 0),
('538026584v', 'Aleda Shapter', '0712546325', '1961-02-03', 'Female', 'ashapter12@purevolume.com', '34', 'ABC', 79, 'T', 'voter', 0, 0, 0),
('834667729v', 'Alford Bene', '0712546325', '1949-08-08', 'Male', 'abene11@twitter.com', '26', 'ABC', 42, 'T', 'AEO', 0, 0, 0),
('759343953v', 'Putnem Farres', '0712546325', '1966-09-01', 'Male', 'pfarres10@nba.com', '73', 'ABC', 60, 'T', 'voter', 0, 0, 0),
('865539704v', 'Fleur Sill', '0712546325', '1944-06-26', 'Female', 'fsillz@tiny.cc', '13', 'ABC', 56, 'T', 'voter', 0, 0, 0),
('830930394v', 'Tommi Wilgar', '0712546325', '1953-07-19', 'Female', 'twilgary@si.edu', '34', 'ABC', 21, 'T', 'voter', 0, 0, 0),
('482897325v', 'Earl Oloshkin', '0712546325', '1975-04-16', 'Male', 'eoloshkinx@xing.com', '26', 'ABC', 78, 'T', 'voter', 0, 0, 0),
('883735269v', 'Wyn Merryfield', '0712546325', '1960-05-14', 'Male', 'wmerryfieldw@moonfruit.com', '29', 'ABC', 62, 'T', 'voter', 0, 0, 0),
('673431682v', 'Dulcie Fishbie', '0712546325', '1974-04-16', 'Female', 'dfishbiev@naver.com', '8', 'ABC', 51, 'T', 'voter', 0, 0, 0),
('648921656v', 'Dominica Wildbore', '0712546325', '1991-05-05', 'Female', 'dwildboreu@multiply.com', '11', 'ABC', 107, 'T', 'voter', 0, 0, 0),
('567921439v', 'Darice Vertigan', '0712546325', '1958-03-13', 'Female', 'dvertigant@bigcartel.com', '12', 'ABC', 13, 'T', 'voter', 0, 0, 0),
('599405907v', 'Alva Prawle', '0712546325', '1970-10-12', 'Male', 'aprawles@smh.com.au', '2', 'ABC', 26, 'T', 'AEO', 0, 0, 0),
('523165773v', 'Demetrius Didsbury', '0712546325', '1981-10-22', 'Male', 'ddidsburyr@washington.edu', '99', 'ABC', 55, 'T', 'voter', 0, 0, 0),
('554943727v', 'Maribel McDougall', '0712546325', '1961-10-08', 'Female', 'mmcdougallq@scribd.com', '31', 'ABC', 125, 'T', 'voter', 0, 0, 0),
('987830651v', 'Jemimah Hugonneau', '0712546325', '1997-11-09', 'Female', 'jhugonneaup@people.com.cn', '16', 'ABC', 45, 'T', 'AEO', 0, 0, 0),
('520412498v', 'Thorsten Dunkinson', '0712546325', '1993-09-29', 'Male', 'tdunkinsono@jimdo.com', '50', 'ABC', 125, 'T', 'voter', 0, 0, 0),
('988605107v', 'Baron Friskey', '0712546325', '1955-01-22', 'Male', 'bfriskeyn@auda.org.au', '54', 'ABC', 119, 'S', 'voter', 1, 0, 0),
('894305972v', 'Arel Sayton', '0712546325', '1947-10-30', 'Male', 'asaytonm@patch.com', '70', 'ABC', 2, 'S', 'voter', 0, 0, 0),
('923652223v', 'Pip Thyer', '0712546325', '1985-09-17', 'Male', 'pthyerl@miibeian.gov.cn', '93', 'ABC', 38, 'S', 'voter', 0, 0, 0),
('472153996v', 'Elnore Bengoechea', '0712546325', '1993-09-07', 'Female', 'ebengoecheak@psu.edu', '7', 'ABC', 158, 'T', 'voter', 0, 0, 0),
('795173537v', 'Genni Farnell', '0712546325', '1954-10-16', 'Female', 'gfarnellj@addtoany.com', '47', 'ABC', 121, 'S', 'voter', 0, 0, 0),
('644008353v', 'Melosa Pulley', '0712546325', '1948-12-30', 'Female', 'mpulleyi@sourceforge.net', '16', 'ABC', 79, 'S', 'voter', 0, 0, 0),
('674760741v', 'Caddric Surcombe', '0712546325', '1965-11-01', 'Male', 'csurcombeh@hibu.com', '63', 'ABC', 37, 'S', 'voter', 0, 0, 0),
('967076386v', 'Malcolm Lintall', '0712546325', '1995-08-11', 'Male', 'mlintallg@godaddy.com', '58', 'ABC', 157, 'S', 'voter', 0, 0, 0),
('452248157v', 'Adrian Golling', '0712546325', '1953-01-25', 'Female', 'agollingf@hao123.com', '73', 'ABC', 5, 'S', 'voter', 0, 0, 0),
('956244501v', 'Christean Stenson', '0712546325', '1991-08-05', 'Female', 'cstensone@dedecms.com', '28', 'ABC', 121, 'S', 'AEO', 0, 0, 0),
('806901427v', 'Meir Skin', '0712546325', '1954-09-02', 'Male', 'mskind@mapquest.com', '69', 'ABC', 79, 'S', 'voter', 0, 0, 0),
('666951333v', 'Allard Wardell', '0712546325', '1947-10-27', 'Male', 'awardellc@cafepress.com', '71', 'ABC', 153, 'S', 'voter', 0, 0, 0),
('675110692v', 'Eba Key', '0712546325', '1963-09-29', 'Female', 'ekeyb@geocities.jp', '18', 'ABC', 158, 'S', 'voter', 0, 0, 0),
('524068270v', 'Ferguson Gillanders', '0712546325', '1976-08-17', 'Male', 'fgillandersa@comsenz.com', '27', 'ABC', 31, 'S', 'voter', 0, 0, 0),
('600884328v', 'Fitz Dyott', '0712546325', '1948-09-18', 'Male', 'fdyott9@nih.gov', '74', 'ABC', 39, 'S', 'voter', 0, 0, 0),
('920303618v', 'Francois Cresser', '0712546325', '1976-12-24', 'Male', 'fcresser8@behance.net', '78', 'ABC', 159, 'S', 'voter', 0, 0, 0),
('984094551v', 'Jayne Curror', '0712546325', '1951-09-22', 'Female', 'jcurror7@nps.gov', '94', 'ABC', 10, 'S', 'voter', 0, 0, 0),
('532854731v', 'Case Klemencic', '0712546325', '1984-02-10', 'Male', 'cklemencic6@example.com', '65', 'ABC', 95, 'S', 'voter', 0, 0, 0),
('585186415v', 'Charisse Phelps', '0712546325', '1957-11-23', 'Female', 'cphelps5@delicious.com', '28', 'ABC', 141, 'S', 'AEO', 0, 0, 0),
('470346999v', 'Daveen Lamdin', '0712546325', '1963-01-26', 'Female', 'dlamdin4@chicagotribune.com', '48', 'ABC', 100, 'S', 'AEO', 0, 0, 0),
('582538870v', 'Rosamund Shilliday', '0712546325', '1950-08-03', 'Female', 'rshilliday3@prweb.com', '84', 'ABC', 128, 'S', 'voter', 0, 0, 0),
('475696190v', 'Kasey Wills', '0712546325', '1965-07-27', 'Female', 'kwills2@linkedin.com', '57', 'ABC', 133, 'S', 'voter', 0, 0, 0),
('836958912v', 'Harlan Shillaber', '0712546325', '1980-05-22', 'Male', 'hshillaber1@addthis.com', '16', 'ABC', 109, 'S', 'DO', 0, 0, 0),
('676873731v', 'Caria Copozio', '0712546325', '1965-03-24', 'Female', 'ccopozio0@si.edu', '21', 'ABC', 94, 'S', 'voter', 0, 0, 0),
('903009121v', 'Gwenette Dowey', '0712546325', '1989-09-19', 'Female', 'gdowey29@dmoz.org', '21', 'ABC', 35, 'E', 'voter', 0, 0, 0),
('576536998v', 'Cherye Basterfield', '0712546325', '1954-05-02', 'Female', 'cbasterfield2a@china.com.cn', '7', 'ABC', 53, 'E', 'voter', 0, 0, 0),
('624828269v', 'Skye Coils', '0712546325', '1945-08-29', 'Male', 'scoils2b@thetimes.co.uk', '97', 'ABC', 23, 'S', 'voter', 0, 0, 0),
('780039396v', 'Allen Le Brun', '0712546325', '1996-03-06', 'Male', 'ale2c@umn.edu', '65', 'ABC', 157, 'E', 'voter', 0, 0, 0),
('537689789v', 'Linc Squirrell', '0712546325', '1955-01-25', 'Male', 'lsquirrell2d@jugem.jp', '42', 'ABC', 53, 'E', 'voter', 0, 0, 0),
('574483400v', 'Sib Merwe', '0712546325', '1996-01-09', 'Female', 'smerwe2e@blogspot.com', '17', 'ABC', 65, 'S', 'voter', 0, 0, 0),
('479099544v', 'Wadsworth McNern', '0712546325', '1950-09-08', 'Male', 'wmcnern2f@zimbio.com', '74', 'ABC', 111, 'S', 'voter', 0, 0, 0),
('525891517v', 'Ryan Merioth', '0712546325', '1982-07-27', 'Male', 'rmerioth2g@google.es', '63', 'ABC', 60, 'E', 'voter', 0, 0, 0),
('709716149v', 'Tate Merdew', '0712546325', '1952-12-22', 'Female', 'tmerdew2h@sbwire.com', '99', 'ABC', 154, 'E', 'voter', 0, 0, 0),
('966568770v', 'Melva Daintree', '0712546325', '1984-07-06', 'Female', 'mdaintree2i@yelp.com', '51', 'ABC', 48, 'E', 'voter', 0, 0, 0),
('742282360v', 'Ingamar Phebey', '0712546325', '1989-12-17', 'Male', 'iphebey2j@si.edu', '66', 'ABC', 14, 'E', 'voter', 0, 0, 0),
('495321759v', 'Ingeberg Rodear', '0712546325', '1975-01-17', 'Female', 'irodear2k@mlb.com', '31', 'ABC', 129, 'S', 'voter', 0, 0, 0),
('687283641v', 'Shelby Rumens', '0712546325', '1995-03-20', 'Male', 'srumens2l@cpanel.net', '39', 'ABC', 8, 'E', 'voter', 0, 0, 0),
('665716593v', 'Connie Kalinke', '0712546325', '1951-12-16', 'Female', 'ckalinke2m@freewebs.com', '99', 'ABC', 34, 'S', 'voter', 0, 0, 0),
('448404080v', 'Billy Middlehurst', '0712546325', '1970-01-07', 'Female', 'bmiddlehurst2n@dailymotion.com', '75', 'ABC', 22, 'E', 'AEO', 0, 0, 0),
('988710356v', 'Radcliffe Gilyott', '0712546325', '1969-11-16', 'Male', 'rgilyott2o@discovery.com', '41', 'ABC', 102, 'S', 'AEO', 0, 0, 0),
('452094787v', 'Paola Falks', '0712546325', '1948-04-16', 'Female', 'pfalks2p@craigslist.org', '48', 'ABC', 83, 'E', 'AEO', 0, 0, 0),
('974688009v', 'Jerry Bobasch', '0712546325', '1954-06-28', 'Male', 'jbobasch2q@si.edu', '28', 'ABC', 44, 'E', 'AEO', 0, 0, 0),
('868978766v', 'Saree McGann', '0712546325', '1984-11-23', 'Female', 'smcgann2r@columbia.edu', '13', 'ABC', 38, 'E', 'voter', 0, 0, 0),
('123456789v', 'Mahinda Deshapriya', '0712546325', '1968-04-05', 'Male', 'tg2017233@gmail.com', '123456789v', '', 46, 'S', 'admin', 0, 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
