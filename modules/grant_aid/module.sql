
# ��ƪ�榡�G `grant_aid`
#
# �бN�z����ƪ� CREATE TABLE �y�k�m��U�C
# �Y�L�A�h�бN���� module.sql �R���C

CREATE TABLE `grant_aid` (
  `type` char(20) default '',
  `year_seme` varchar(6) default '',
  `student_sn` int(10) unsigned default '0',
  `class_num` varchar(6) default '',
  `dollar` int(10) unsigned default '0',
  `sn` int(10) unsigned auto_increment,
  PRIMARY KEY  (`sn`),
  KEY `year_seme` (`year_seme`)
);

