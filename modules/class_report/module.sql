
# ��Ʈw�G �������ҲթҨϥΪ���ƪ���O, ��w�˦��Ҳծ�, SFS3 �t�η|�@�ְ���o�̪� MySQL ���O,�إ߸�ƪ�.
#					 �Y���Ҳդ��ݫإ߸�ƪ�, �h�d�ťէY�i.
#
#
#
# �Z�Ťp�Ҧ��Z�޲z

#���Z��]�w , �Ǵ��B�Z�šB���Z��W�١B���ɦѮv�y�����B�ikey���Z���ǥ͡B�O�_�}���J�B�O�_�έp�����B�O�_��ܱƦW�B�ǥͯ�_�d�ߥ��Z���Z
CREATE TABLE IF NOT EXISTS `class_report_setup` (
  `sn` int(11) NOT NULL auto_increment,
  `seme_year_seme` varchar(6) NOT NULL,
  `seme_class` varchar(10) NOT NULL,
  `title` varchar(128) NOT NULL,
  `teacher_sn` int(10) NOT NULL,
  `student_sn` int(10) NOT NULL,
  `open_input` tinyint(1) NOT NULL,
  `open_read` tinyint(1) NOT NULL,
  `rep_classmates` tinyint(1) not null,
  `rep_sum` tinyint(1) not NULL,
  `rep_avg` tinyint(1) not NULL,
  `rep_rank` tinyint(1) not null,
  `last_edit_sn` int(10) unsigned default NULL,
  `last_edit_time` datetime NOT NULL,
  `locked` tinyint(1) not null,
  `update_sn` int(10) unsigned default NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`sn`)
) AUTO_INCREMENT=1 ;

#���Z�椤���Ҹլ�ص�, �Ҹդ���B��ئW�١B�C�J�[�`�B����
CREATE TABLE  IF NOT EXISTS `class_report_test` (
  `sn` int(11) NOT NULL auto_increment,
  `report_sn` int(11)NOT NULL,
  `subject` varchar(32) NOT NULL,
  `test_date` date NOT NULL,
  `memo` varchar(64) NULL,
  `real_sum` tinyint(1) NOT NULL,
  `update_sn` int(10) unsigned default NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`sn`)
) AUTO_INCREMENT=1 ;

#�ǥͦ��Z, �y����,�ǥͬy����,��جy����,���Z
CREATE TABLE IF NOT EXISTS `class_report_score` (
  `sn` int(11) NOT NULL auto_increment,
  `test_sn` int(11)NOT NULL,
  `student_sn` int(10) NOT NULL,
  `score` decimal(5,2) NOT NULL,
  `update_sn` int(10) unsigned default NULL,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`sn`)
) AUTO_INCREMENT=1 ;

