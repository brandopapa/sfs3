#$Id: module.sql 8152 2014-09-30 01:15:55Z smallduh $
# ��ƪ�榡�G `score_paper`
#
# �бN�z����ƪ� CREATE TABLE �y�k�m��U�C
# �Y�L�A�h�бN���� module.sql �R���C

CREATE TABLE `score_paper` (
  `sp_sn` smallint(5) unsigned NOT NULL auto_increment,
  `file_name` varchar(255) NOT NULL default '',
  `sp_name` varchar(255) NOT NULL default '',
  `descriptive` text NOT NULL,
  `enable` enum('1','2') NOT NULL default '1',
  PRIMARY KEY  (`sp_sn`)
) ENGINE=MyISAM;



