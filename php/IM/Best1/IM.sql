-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2013 at 06:26 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--

-- Table structure for table `bmf_chatting`
--

CREATE TABLE IF NOT EXISTS `bmf_chatting` (
  `usr_id` int(11) NOT NULL,
  `usr_name` varchar(255) NOT NULL,
  `chatto` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=MEMORY DEFAULT CHARSET=latin1 MAX_ROWS=15000;

--
-- Dumping data for table `bmf_chatting`
--

INSERT INTO `bmf_chatting` (`usr_id`, `usr_name`, `chatto`, `timestamp`) VALUES
(2, 'Ben', 2, 1379347750);

-- --------------------------------------------------------

--
-- Table structure for table `bmf_invite`
--

CREATE TABLE IF NOT EXISTS `bmf_invite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` int(11) NOT NULL,
  `usr_name` varchar(255) NOT NULL,
  `chatto` int(11) NOT NULL,
  `chatto_name` varchar(255) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bmf_invite`
--

INSERT INTO `bmf_invite` (`id`, `usr_id`, `usr_name`, `chatto`, `chatto_name`, `timestamp`, `status`) VALUES
(1, 1, 'aaaaaaaaaaaaaa', 1, 'aaaaaaaaaaaaaa', 1258546078, 1),
(2, 3, 'Khijir', 2, 'Ben', 1379342172, 1),
(3, 2, 'Ben', 2, 'Ben', 1379347744, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bmf_lines`
--

CREATE TABLE IF NOT EXISTS `bmf_lines` (
  `line_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` int(11) NOT NULL,
  `usr_name` varchar(255) NOT NULL,
  `chatto` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `line_txt` text NOT NULL,
  PRIMARY KEY (`line_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `bmf_lines`
--

INSERT INTO `bmf_lines` (`line_id`, `usr_id`, `usr_name`, `chatto`, `timestamp`, `line_txt`) VALUES
(1, 1, 'aaaaaaaaaaaaaa', 1, 1258546086, 'asfd'),
(2, 1, 'aaaaaaaaaaaaaa', 1, 1258546096, 'sfadsfsadf'),
(3, 1, 'aaaaaaaaaaaaaa', 1, 1258546102, ':wink:'),
(4, 3, 'Khijir', 2, 1379324468, 'hi there'),
(5, 2, 'Ben', 3, 1379324489, 'hi'),
(6, 3, 'Khijir', 2, 1379324507, 'how are you'),
(7, 2, 'Ben', 3, 1379324523, 'yes fine and you?'),
(8, 3, 'Khijir', 2, 1379342181, 'hi there'),
(9, 2, 'Ben', 3, 1379342208, 'hi there'),
(10, 3, 'Khijir', 2, 1379342218, 'how are you?'),
(11, 2, 'Ben', 3, 1379342226, 'yes fine and you?');

-- --------------------------------------------------------

--
-- Table structure for table `bmf_online`
--

CREATE TABLE IF NOT EXISTS `bmf_online` (
  `usr_id` int(11) NOT NULL,
  `usr_name` varchar(255) NOT NULL,
  `usr_ip` varchar(15) NOT NULL,
  `rtime` int(11) NOT NULL,
  `status` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bmf_online`
--

INSERT INTO `bmf_online` (`usr_id`, `usr_name`, `usr_ip`, `rtime`, `status`) VALUES
(1, 'aaaaaaaaaaaaaa', '127.0.0.1', 1258546142, 0),
(2, 'Ben', '127.0.0.1', 1379348772, 1),
(3, 'Khijir', '127.0.0.1', 1379342246, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bmf_settings`
--

CREATE TABLE IF NOT EXISTS `bmf_settings` (
  `set_id` varchar(16) NOT NULL,
  `set_value` text NOT NULL,
  PRIMARY KEY (`set_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bmf_settings`
--

INSERT INTO `bmf_settings` (`set_id`, `set_value`) VALUES
('default_timezone', '3'),
('default_timeform', '0'),
('default_language', '0'),
('default_veffect', '1'),
('default_sound1', '3'),
('default_sound2', '2'),
('chat_refresh', '5'),
('main_refresh', '10'),
('main_ofactor', '3'),
('mssg_history', '24'),
('user_history', '336'),
('bar_style', ' font-family:verdana,sans-serif; \r\n font-size:9px; \r\n color:#000; \r\n background-color:#E1EBF2; \r\n font-weight:bold; \r\n text-transform:uppercase; \r\n margin:0px; \r\n padding:1px; \r\n width:auto; \r\n height:auto; \r\n position:fixed; \r\n float:left; \r\n top:auto; \r\n bottom:8px; \r\n left:auto; \r\n right:8px; \r\n border:1px solid #098DCE; \r\n border-bottom-width:2px; \r\n z-index:1;'),
('bar_elements', ' <div style="background-color:#03557E;color:#fff;padding:5px">Instant Messenger</div> \n <div style="padding:5px">{WELCOME} {USER} \n \n {ONLINE_LINK}<input style="color:#000;background-color:#ddd;padding:3px;font-weight:bold;border:1px solid #fff; cursor: pointer;" type="button" value="{ONLINE_LANG}: {ONLINE_NUM}" />{CLOSE_LINK} \n \n {SETTINGS_LINK}<input style="color:#000;background-color:#ddd;padding:3px;font-weight:bold;border:1px solid #fff;  cursor: pointer;" type="button" value="{SETTINGS_LANG}" />{CLOSE_LINK} \n </div>'),
('bar_chatreqt', ' <div style="background-color:#a00;color:#fff;padding:5px">Instant Messenger</div> \r\n <div style="padding:5px">{WELCOME} {USER} \r\n \r\n {CHATS_LINK}<input style="color:#000;background-color:#ddd;padding:3px;font-weight:bold;border:1px solid #fff" type="button" value="{CHATS_LANG}: {CHATS_NUM}" />{CLOSE_LINK}</div>'),
('acp_key', '9d47a623af14def9454559d31471b55f'),
('wrong_acp', '0'),
('admin_css', '2'),
('admin_lang', '0'),
('header_rdr', '1'),
('html_title', ':::BlaB! IM:::'),
('popup_ucp', '0'),
('optimize_tbl', '1'),
('del_gbuddies', '0'),
('no_session_err', '1'),
('ucp_width', '550'),
('ucp_height', '360'),
('ucp_effect', '1'),
('latest_mssg', '20'),
('ajax_delay', '10'),
('post_length', '129'),
('m_interval', '600'),
('stat_entries', '50'),
('notebook', 'notes...');

-- --------------------------------------------------------

--
-- Table structure for table `bmf_users`
--

CREATE TABLE IF NOT EXISTS `bmf_users` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_name` varchar(255) NOT NULL,
  `salt` char(40) NOT NULL,
  PRIMARY KEY (`usr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bmf_users`
--

INSERT INTO `bmf_users` (`usr_id`, `usr_name`, `salt`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e'),
(2, 'Ben', '722c0a14c58684163d59991e65ab942a'),
(3, 'Khijir', '2689ee6e24c04ac2181a49123b14a133');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
