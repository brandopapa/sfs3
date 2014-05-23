# $Id: course_room.sql 5311 2009-01-10 08:11:55Z hami $

# phpMyAdmin MySQL-Dump
# version 2.3.3pl1
# http://www.phpmyadmin.net/ (download page)
#
# �D��: localhost
# �إߤ��: Feb 11, 2003 at 08:00 PM
# ���A������: 3.23.54
# PHP ����: 4.2.3
# ��Ʈw: `sfs3`
# --------------------------------------------------------

#
# ��ƪ�榡�G `course_room`
#

CREATE TABLE course_room (
  crsn int(10) unsigned NOT NULL auto_increment,
  date date NOT NULL default '0000-00-00',
  day enum('0','1','2','3','4','5','6','7') NOT NULL default '0',
  sector tinyint(1) unsigned NOT NULL default '0',
  room varchar(50) NOT NULL default '',
  teacher_sn mediumint(8) unsigned NOT NULL default '0',
  sign_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (crsn),
  KEY teacher_sn (teacher_sn),
  KEY sector (sector),
  KEY day (day)
) TYPE=MyISAM COMMENT='      ';



# ��ƪ�榡�G `spec_classroom`
#

CREATE TABLE spec_classroom (
  room_id smallint(5) unsigned NOT NULL auto_increment,
  room_name varchar(20) NOT NULL default '',
  enable enum('0','1') NOT NULL default '1',
  notfree_time varchar(250) default NULL,
  PRIMARY KEY  (room_id)
) TYPE=MyISAM;