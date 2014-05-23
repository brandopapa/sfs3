CREATE TABLE `chc_basic12`(
  `sn` int(10) unsigned NOT NULL auto_increment,#�y����
  `academic_year` tinyint(3) unsigned NOT NULL,#�Ǧ~��
  `student_sn` int(10) unsigned NOT NULL, #�t�Τ��ǥ�sn
  `kind_id` tinyint(3) unsigned default '0',#�ǥͨ����O--8��
  `special` char(2) NOT NULL default '0',#���߻�ê 12�� 0 ~ 9�BA~B
  `unemployed` tinyint(1) unsigned default '0',#���~�Ҥu--0/�_�A1/�O�C
  `graduation` tinyint(1) unsigned default '1',#���w�~-- 0/�w�~�A1/���~
  `income` tinyint(1) unsigned default '0',#�g�ٮz�� 0�_ 2�C���J�� 1���C���J��
  `score_nearby` tinyint(3) unsigned default NULL,#2.�N��J�Ǥ���  
  `score_service` float default NULL,#3.�~�w�A��--�A�Ⱦǲ�
  `score_reward` float default NULL,#4.�~�w�A��--���y�O��
  `score_fault` tinyint(3) unsigned default NULL,#5.�~�w�A��--�L�O�L�O��
  `score_balance` tinyint(3) unsigned default NULL,#6.�Z�u��{--���žǲ��`�o��  
  `score_race` float default NULL, #7.�Z�u��{--�v�ɪ�{  
  `score_physical` tinyint(3) unsigned default NULL,#8.�Z�u��{--��A��
  `score_exam` tinyint(3) unsigned default NULL,#�Z�u��{--�Ш|�|���`��
  `update_sn` int(10) unsigned NOT NULL, #��s��
  `update_time` timestamp NOT NULL ,
  PRIMARY KEY  (`sn`),
  UNIQUE KEY `academic_year` (`academic_year`,`student_sn`),
  KEY `student_sn` (`student_sn`)
) ENGINE=MyISAM ;

