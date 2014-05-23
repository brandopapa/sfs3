#
# ��ƪ�榡�G ``
#
# �бN�z����ƪ� CREATE TABLE �y�k�m��U�C
# �Y�L�A�h�бN���� module.sql �R���C


#
# ��ƪ�榡�G `hd_dir`
#

CREATE TABLE `hd_dir` (
  `dir_sn` int(11) NOT NULL auto_increment,
  `struct` int(11) NOT NULL default '0',
  `chinese_name` varchar(100) NOT NULL default '',
  `teacher_sn` int(11) NOT NULL default '0',
  `level` enum('a','b','c') NOT NULL default 'a',
  `enable` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`dir_sn`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;


#
# ��ƪ�榡�G `hd_file`
#

CREATE TABLE `hd_file` (
  `file_sn` int(11) NOT NULL auto_increment,
  `dir_sn` int(11) NOT NULL default '0',
  `source_name` varchar(100) NOT NULL default '',
  `comment` text NOT NULL,
  `teacher_sn` int(11) NOT NULL default '0',
  `file_level` enum('a','b','c') NOT NULL default 'a',
  `enable` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`file_sn`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;


#
# ��ƪ�榡�G `hd_quota`
#

CREATE TABLE `hd_quota` (
  `teacher_sn` int(11) NOT NULL default '0',
  `size` int(11) NOT NULL default '0',
  `many` int(11) NOT NULL default '0',
  `enable` enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (`teacher_sn`)
) TYPE=MyISAM;



