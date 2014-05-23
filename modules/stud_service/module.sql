
#
# ��ƪ�榡�G `stud_service`
#

#�A�ȩ���  
# year_seme �Ǧ~�� ,service_date��� , department�n����� , item�A�Ⱦǲ����� , memo�A�Ȳӥػ���, update_sn�O���� , update_time�O���ɶ�

CREATE TABLE IF NOT EXISTS `stud_service` (
  `sn` int(10) unsigned NOT NULL auto_increment,
  `year_seme` varchar(4) NOT NULL,
  `service_date` date NOT NULL,
  `department` tinyint(3) unsigned NOT NULL,
  `item` varchar(100) NOT NULL,
  `memo` text NOT NULL,
  `update_sn` int(10) unsigned NOT NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`sn`),
  KEY `year_seme` (`year_seme`),
  KEY `department` (`department`),
  KEY `service_date` (`service_date`)
) ;

#�C��ǥͪ��A�ȮɼưO��
# student_sn�ǥ� ,item_sn���s���A�ȩ���, minutes�A�ȤF�h�[�]���^ , bonus�n��

CREATE TABLE IF NOT EXISTS `stud_service_detail` (
  `sn` int(10) unsigned NOT NULL auto_increment,
  `student_sn` int(10) unsigned NOT NULL,
  `item_sn` int(10) unsigned NOT NULL,
  `minutes` tinyint(3) unsigned NOT NULL,
  `bonus` tinyint(3) unsigned NOT NULL,
  `studmemo` varchar(30) NOT NULL,
  PRIMARY KEY  (`sn`),
  KEY `student_sn` (`student_sn`),
  KEY `item_sn` (`item_sn`)
) ;