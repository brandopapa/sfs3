-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- �D��: localhost
-- �إߤ��: Dec 17, 2012, 12:50 PM
-- ���A������: 5.0.51
-- PHP ����: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- ��Ʈw: `sfs3`
-- 

-- --------------------------------------------------------

-- 
-- ��ƪ�榡�G `reward_exchange`
-- 

CREATE TABLE `reward_exchange` (
  `sn` int(11) NOT NULL auto_increment,
  `student_sn` int(10) default '0',
  `reward_year_seme` varchar(6) default NULL,
  `reward_date` date default NULL,
  `reward_kind` varchar(10) NOT NULL default '',
  `reward_numbers` tinyint(4) NOT NULL,
  `reward_reason` text,
  PRIMARY KEY  (`sn`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- �C�X�H�U��Ʈw���ƾڡG `reward_exchange`
-- 

