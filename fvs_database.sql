-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 03, 2020 at 04:45 PM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

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
('542893419v', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

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
('827152364v', '60465', 2, 0),
('802360140v', '97466', 4, 0),
('542893419v', '20934', 1, 0),
('980171329v', '61556', 2, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`id`, `nic`, `party_id`, `image`, `name_si`, `name_ta`, `schedule_id`, `is_deleted`) VALUES
(1, '827152364v', 1, '../img/candidate/candidate_default.png', 'පියුමි දිසානායක', 'பியுமி திசனாநாயக்க', 1, 0);

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
('802360140v', '35109', 36, 0),
('975215236v', '45551', 36, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `election_schedule`
--

INSERT INTO `election_schedule` (`id`, `type`, `date_from`, `date_to`, `is_deleted`) VALUES
(1, 2, '2020-01-01 08:00:00', '2020-01-03 01:30:00', 0);

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
('542893419V', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0);

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

--
-- Dumping data for table `participate`
--

INSERT INTO `participate` (`id`, `schedule_id`, `voter_nic`) VALUES
(1, 1, '902360140v'),
(2, 1, '827152364v');

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
(10, 'Frontline Socialist Party', 'පෙරටුගාමී සමාජවාදී පක්ෂය', 'முன்னிலை சோஷலிஸ கட்சி ', 'Senadheera Gunathilake', '  01128374', '2012-04-09', '553/B2, Gemunu Mavatha, Udumulla Road, Battaramulla', '', '../img/partySymbol/10.png', 0),
(11, 'Muslim National Alliance', 'මුස්ලිම් ජාතික සන්ධානය', 'முஸ்லிம் தேசிய கூட்டமைப்பு', 'Masihudeen Naeemullah', '0112697505', '2018-09-12', '258, Katugastota Road, Kandy', '', '../img/partySymbol/11.png', 0),
(12, 'Ceylon Worker\'s Congress ', 'ලංකා කම්කරු කොංග්‍රසය ', 'இலங்கை தொழிலாளர் காங்கிரஸ் ', 'Anusha Sivaraja', '0112574524', '1939-05-04', '72, Ananda Coomaraswamy Mawatha, Colombo 07', '', '../img/partySymbol/12.png', 0),
(13, 'Sri Lanka Podujana Peramuna ', 'ශ්‍රී ලංකා පොදුජන පෙරමුණ', 'ஸ்ரீ லங்கா பொதுஜன பெரமுன', 'Sagara Kariyawasam', '0112518565', '2016-11-06', '8/11, Robert Alwis Mawatha, Boralesgamuwa', '', '../img/partySymbol/13.png', 0),
(14, 'Sri Lanka Muslim Congress', 'ශ්‍රී ලංකා මුස්ලිම් කොංග්‍රසය', 'Sri Lanka Muslim Congress', 'M. Nizam Kariappar', '0112436752', '1981-09-11', '“Darus Salam” 51, Vauxhall Lane, Colombo 02', '', '../img/partySymbol/14.png', 0),
(15, 'Socialist Alliance', 'සමාජවාදී ජනතා පෙරමුණ', 'சோஷலிஸ மக்கள் முன்னணி', 'D.C. Raja Collure', '0112695328', '2006-07-08', '91, Dr. N.M. Perera Mawatha, Colombo 08', '', '../img/partySymbol/15.png', 0),
(27, 'Th', 'à¶¢à¶±à·à¶°à·’à¶´à¶­à·’à·€à¶»à¶«à¶º', 'à®œà®©à®¾à®¤à®¿à®ªà®¤à®¿à®¤à¯ à®¤à¯‡à®°à¯à®¤à®²à¯', 'Akila Viraj Kariyawasam', '0775236985', '2020-01-02', 'jdfh', '#c7017f', '../img/partySymbol/', 0);

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

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`id`, `schedule_id`, `candidate_id`, `preference`) VALUES
(2, '1', '1', 1),
(1, '1', '1', 1);

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
('542893419v', 'Suresh Premachandran', '0714483674', '1954-10-14', 'Male', 'suresh@gmail.com', '', '', 88, 'T', 'admin', 0, 0, 0),
('802360140v', 'Akila Viraj Kariyawasam', '0724512365', '1980-12-23', 'Male', 'akila@gmail.com', '', '', 5, 'S', 'AEO', 0, 0, 0),
('827152364v', 'Mahinda Amaraweera', '0752368652', '1982-09-23', 'Male', 'mahi@gmail.com', '', '', 7, 'S', 'DO', 0, 0, 0),
('980171329v', 'Madushan Sandaruwan', '0771637551', '1998-01-17', 'Male', 'tg2017233@gmail.com', '', '', 26, 'S', 'admin', 0, 0, 0),
('975215236v', 'Aruna Perera', '0702536412', '1997-05-27', 'Male', 'aruna@gmail.com', '', '', 3, 'S', 'voter', 0, 0, 0),
('882531027v', 'Ravindu Madhishanka', '0728541236', '1988-01-17', 'Male', 'ravindu@gmail.com', '', '', 72, 'S', 'voter', 0, 0, 0),
('980250849V', 'sampath', '0763304183', '1998-01-25', 'Male', 'lahirusampath8899@gmail.com', 'a', 'a', 106, 'S', 'admin', 0, 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
