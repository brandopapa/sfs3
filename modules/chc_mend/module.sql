
CREATE TABLE `chc_mend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,#�y����
  `student_sn` int(10) unsigned NOT NULL,#�t�Τ��ǥ�sn
  `seme` varchar(6) NOT NULL DEFAULT '',#�Ǧ~�׾Ǵ�
  `scope` varchar(6) NOT NULL DEFAULT '',#���W�� 
  `score_src` float NOT NULL DEFAULT '0', #����l���Z(�p��)
  `score_test` float NOT NULL DEFAULT '0', #�ɦҦ��Z��l���Z
  `score_end` float NOT NULL DEFAULT '0', #�ɦҦ��Z(�ĭp��)
  `passok` varchar(20) NOT NULL DEFAULT '',#�O�_�q�L
  `update_sn` int(10) unsigned NOT NULL,#�n����
  `cr_time` datetime DEFAULT NULL,#�إ�/��s�ɶ�
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_sn` (`student_sn`,`seme`,`scope`)
) ENGINE=MyISAM ;
