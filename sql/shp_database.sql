-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 19, 2009 at 09:12 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6-1+lenny3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shp_database_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE IF NOT EXISTS `administrators` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `added` varchar(255) NOT NULL,
  `addedby` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `administrators`
--


-- --------------------------------------------------------

--
-- Table structure for table `domains`
--

CREATE TABLE IF NOT EXISTS `domains` (
  `id` int(11) NOT NULL auto_increment,
  `domain` varchar(255) NOT NULL,
  `path` varchar(1000) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `added` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `domains`
--


-- --------------------------------------------------------

--
-- Table structure for table `ftpgroup`
--

CREATE TABLE IF NOT EXISTS `ftpgroup` (
  `groupname` varchar(16) NOT NULL default '',
  `gid` smallint(6) NOT NULL default '5500',
  `members` varchar(16) NOT NULL default '',
  KEY `groupname` (`groupname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='ProFTP group table';

--
-- Dumping data for table `ftpgroup`
--

INSERT INTO `ftpgroup` (`groupname`, `gid`, `members`) VALUES
('ftpgroup', 2001, 'ftpuser'),
('ftpgroup', 2001, 'ftpuser');

-- --------------------------------------------------------

--
-- Table structure for table `ftpquotalimits`
--

CREATE TABLE IF NOT EXISTS `ftpquotalimits` (
  `name` varchar(30) default NULL,
  `quota_type` enum('user','group','class','all') NOT NULL default 'user',
  `per_session` enum('false','true') NOT NULL default 'false',
  `limit_type` enum('soft','hard') NOT NULL default 'soft',
  `bytes_in_avail` bigint(20) unsigned NOT NULL default '0',
  `bytes_out_avail` bigint(20) unsigned NOT NULL default '0',
  `bytes_xfer_avail` bigint(20) unsigned NOT NULL default '0',
  `files_in_avail` int(10) unsigned NOT NULL default '0',
  `files_out_avail` int(10) unsigned NOT NULL default '0',
  `files_xfer_avail` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ftpquotalimits`
--


-- --------------------------------------------------------

--
-- Table structure for table `ftpquotatallies`
--

CREATE TABLE IF NOT EXISTS `ftpquotatallies` (
  `name` varchar(30) NOT NULL default '',
  `quota_type` enum('user','group','class','all') NOT NULL default 'user',
  `bytes_in_used` bigint(20) unsigned NOT NULL default '0',
  `bytes_out_used` bigint(20) unsigned NOT NULL default '0',
  `bytes_xfer_used` bigint(20) unsigned NOT NULL default '0',
  `files_in_used` int(10) unsigned NOT NULL default '0',
  `files_out_used` int(10) unsigned NOT NULL default '0',
  `files_xfer_used` int(10) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ftpquotatallies`
--


-- --------------------------------------------------------

--
-- Table structure for table `ftpuser`
--

CREATE TABLE IF NOT EXISTS `ftpuser` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` varchar(32) NOT NULL default '',
  `passwd` varchar(32) NOT NULL default '',
  `uid` smallint(6) NOT NULL default '5500',
  `gid` smallint(6) NOT NULL default '5500',
  `homedir` varchar(255) NOT NULL default '',
  `shell` varchar(16) NOT NULL default '/sbin/nologin',
  `count` int(11) NOT NULL default '0',
  `accessed` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='ProFTP user table' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ftpuser`
--


-- --------------------------------------------------------

--
-- Table structure for table `jobqueue`
--

CREATE TABLE IF NOT EXISTS `jobqueue` (
  `id` int(11) NOT NULL auto_increment,
  `job` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `added` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `jobqueue`
--


-- --------------------------------------------------------

--
-- Table structure for table `userdbs`
--

CREATE TABLE IF NOT EXISTS `userdbs` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `added` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `userdbs`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `added` varchar(255) NOT NULL,
  `addedby` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--

