
CREATE TABLE `chc_leader` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,#�y����
  `student_sn` int(10) unsigned NOT NULL,#�t�Τ��ǥ�sn
  `seme` varchar(6) NOT NULL DEFAULT '',#�Ǧ~��
  `kind` tinyint(3) unsigned DEFAULT '0',#�F�����O0�Z�ŷF��,1���ηF��,2���թʷF��
  `org_name` varchar(50) NOT NULL DEFAULT '',#�Z�W/���ΦW/��´�W
  `title` varchar(50) NOT NULL DEFAULT '',#�F���W��
  `memo` varchar(120) NOT NULL DEFAULT '',#�Ƶ�
  `update_sn` int(10) unsigned NOT NULL,#��s��
  `cr_time` datetime DEFAULT NULL,#�إ�/��s�ɶ�
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_sn` (`student_sn`,`seme`,`kind`,`org_name`,`title`)
) ENGINE=MyISAM ;
