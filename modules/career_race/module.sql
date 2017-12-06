
# ��Ʈw�G �������ҲթҨϥΪ���ƪ���O, ��w�˦��Ҳծ�, SFS3 �t�η|�@�ְ���o�̪� MySQL ���O,�إ߸�ƪ�.
#					 �Y���Ҳդ��ݫإ߸�ƪ�, �h�d�ťէY�i.
#
#
#
# �ͲP���ɰѻP�U���v�ɰO���n�� , �w�� 12bacis_career �Y�w�إ�


CREATE TABLE IF NOT EXISTS `career_race` (
  `sn` int(11) NOT NULL auto_increment,
  `student_sn` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `squad` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `rank` varchar(10) default NULL,
  `certificate_date` date default NULL,
  `sponsor` varchar(40) default NULL,
  `memo` text,
  `word` VARCHAR( 100 ) NOT NULL,
  `weight` FLOAT NOT NULL,
  `update_sn` int(10) unsigned default NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`sn`),
  KEY `student_sn` (`student_sn`)
) AUTO_INCREMENT=1 ;




