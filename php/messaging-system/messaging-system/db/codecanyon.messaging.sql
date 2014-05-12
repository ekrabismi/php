--
-- Database: `codecanyon.messaging`
--

-- --------------------------------------------------------

--
-- Table structure for table `address_book`
--

CREATE TABLE `address_book` (
  `username` varchar(255) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  PRIMARY KEY (`username`,`recipient`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address_book`
--


-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sender` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `message_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `message`
--


-- --------------------------------------------------------

--
-- Table structure for table `message_recipient`
--

CREATE TABLE `message_recipient` (
  `message_id` bigint(20) unsigned NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'unread',
  PRIMARY KEY (`message_id`,`recipient`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_recipient`
--


-- --------------------------------------------------------

--
-- Table structure for table `message_sender`
--

CREATE TABLE `message_sender` (
  `message_id` bigint(20) unsigned NOT NULL,
  `sender` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'sent',
  PRIMARY KEY (`message_id`,`sender`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_sender`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` VALUES('johndoe', 'ed2b1f468c5f915f3f1cf75d7068baae', 'John', 'Doe');
INSERT INTO `user` VALUES('janedoe', 'ed2b1f468c5f915f3f1cf75d7068baae', 'Jane', 'Doe');
