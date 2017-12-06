# $Id: module_health_accident.sql 8539 2015-09-23 03:26:41Z chiming $
CREATE TABLE if not exists  health_accident_place (
  id int(6) unsigned NOT NULL default '1',
  `name` varchar(100) NOT NULL default '',
  `enable` varchar(1) NOT NULL default '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM;
INSERT INTO health_accident_place VALUES ( 1,'�޳�',1);
INSERT INTO health_accident_place VALUES ( 2,'�C���B�ʾ���',1);
INSERT INTO health_accident_place VALUES ( 3,'���q�Ы�',1);
INSERT INTO health_accident_place VALUES ( 4,'�M��Ы�',1);
INSERT INTO health_accident_place VALUES ( 5,'���Y',1);
INSERT INTO health_accident_place VALUES ( 6,'�ӱ�',1);
INSERT INTO health_accident_place VALUES ( 7,'�a�U��',1);
INSERT INTO health_accident_place VALUES ( 8,'��|�]���ʤ���',1);
INSERT INTO health_accident_place VALUES ( 9,'�Z��',1);
INSERT INTO health_accident_place VALUES ( 10,'�ե~',1);
INSERT INTO health_accident_place VALUES ( 999,'��L',1);

#
# ��ƪ�榡�G `health_accident_reason`
#

CREATE TABLE if not exists health_accident_reason (
  id int(6) unsigned NOT NULL default '1',
  `name` varchar(100) NOT NULL default '',
  `enable` varchar(1) NOT NULL default '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM;
INSERT INTO health_accident_reason VALUES ( 1,'�U�ҹC��',1);
INSERT INTO health_accident_reason VALUES ( 2,'�W�U�ҳ~��',1);
INSERT INTO health_accident_reason VALUES ( 3,'�ɺX',1);
INSERT INTO health_accident_reason VALUES ( 4,'���}����',1);
INSERT INTO health_accident_reason VALUES ( 5,'����',1);
INSERT INTO health_accident_reason VALUES ( 6,'�W�U�ӱ�',1);
INSERT INTO health_accident_reason VALUES ( 7,'�����',1);
INSERT INTO health_accident_reason VALUES ( 8,'��|��',1);
INSERT INTO health_accident_reason VALUES ( 999,'��L',1);

#
# ��ƪ�榡�G `health_accident_part`
#

CREATE TABLE  if not exists health_accident_part (
  id int(6) unsigned NOT NULL default '1',
  `name` varchar(100) NOT NULL default '',
  `enable` varchar(1) NOT NULL default '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM;
INSERT INTO health_accident_part VALUES ( 1,'�Y',1);
INSERT INTO health_accident_part VALUES ( 2,'�V',1);
INSERT INTO health_accident_part VALUES ( 3,'��',1);
INSERT INTO health_accident_part VALUES ( 4,'��',1);
INSERT INTO health_accident_part VALUES ( 5,'��',1);
INSERT INTO health_accident_part VALUES ( 6,'�I',1);
INSERT INTO health_accident_part VALUES ( 7,'��',1);
INSERT INTO health_accident_part VALUES ( 8,'�C��',1);
INSERT INTO health_accident_part VALUES ( 9,'�f��',1);
INSERT INTO health_accident_part VALUES ( 10,'�ջ��',1);
INSERT INTO health_accident_part VALUES ( 11,'�W��',1);
INSERT INTO health_accident_part VALUES ( 12,'�y',1);
INSERT INTO health_accident_part VALUES ( 13,'�U��',1);
INSERT INTO health_accident_part VALUES ( 14,'�v��',1);
INSERT INTO health_accident_part VALUES ( 15,'�|����',1);

#
# ��ƪ�榡�G `health_accident_status`
#

CREATE TABLE if not exists  health_accident_status (
  id int(6) unsigned NOT NULL default'1',
  `name` varchar(100) NOT NULL default '',
  `enable` varchar(1) NOT NULL default '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM;
INSERT INTO health_accident_status VALUES ( 1,'����',1);
INSERT INTO health_accident_status VALUES ( 2,'���Ψ��',1);
INSERT INTO health_accident_status VALUES ( 3,'������',1);
INSERT INTO health_accident_status VALUES ( 4,'������',1);
INSERT INTO health_accident_status VALUES ( 5,'���',1);
INSERT INTO health_accident_status VALUES ( 6,'�`�S��',1);
INSERT INTO health_accident_status VALUES ( 7,'�m�r��',1);
INSERT INTO health_accident_status VALUES ( 8,'����',1);
INSERT INTO health_accident_status VALUES ( 9,'�¶�',1);
INSERT INTO health_accident_status VALUES ( 10,'�~���L',1);
INSERT INTO health_accident_status VALUES ( 11,'�o�N',1);
INSERT INTO health_accident_status VALUES ( 12,'�w�t',1);
INSERT INTO health_accident_status VALUES ( 13,'���߹æR',1);
INSERT INTO health_accident_status VALUES ( 14,'�Y�h',1);
INSERT INTO health_accident_status VALUES ( 15,'���h',1);
INSERT INTO health_accident_status VALUES ( 16,'�G�h',1);
INSERT INTO health_accident_status VALUES ( 17,'���h',1);
INSERT INTO health_accident_status VALUES ( 18,'���m',1);
INSERT INTO health_accident_status VALUES ( 19,'�g�h',1);
INSERT INTO health_accident_status VALUES ( 20,'���',1);
INSERT INTO health_accident_status VALUES ( 21,'�y���',1);
INSERT INTO health_accident_status VALUES ( 22,'�l�o',1);
INSERT INTO health_accident_status VALUES ( 23,'���e',1);
INSERT INTO health_accident_status VALUES ( 24,'�����L',1);

#
# ��ƪ�榡�G `health_accident_attend`
#

CREATE TABLE if not exists  health_accident_attend (
  id int(6) unsigned NOT NULL default'1',
  `name` varchar(100) NOT NULL default '',
  `enable` varchar(1) NOT NULL default '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM;
INSERT INTO health_accident_attend VALUES ( 1,'�ˤf�B�z',1);
INSERT INTO health_accident_attend VALUES ( 2,'�B��',1);
INSERT INTO health_accident_attend VALUES ( 3,'����',1);
INSERT INTO health_accident_attend VALUES ( 4,'���[��',1);
INSERT INTO health_accident_attend VALUES ( 5,'�q���a��',1);
INSERT INTO health_accident_attend VALUES ( 6,'�a���a�^',1);
INSERT INTO health_accident_attend VALUES ( 7,'�դ�e��',1);
INSERT INTO health_accident_attend VALUES ( 8,'�åͱШ|',1);
INSERT INTO health_accident_attend VALUES ( 999,'��L�B�z',1);

#
# ��ƪ�榡�G `health_accident_record`
#

CREATE TABLE if not exists  health_accident_record (
	id int(10) unsigned NOT NULL auto_increment,
	`year` smallint(5) unsigned NOT NULL default '0',
	`semester` enum('0','1','2') NOT NULL default '0',
	student_sn int(10) unsigned NOT NULL default '0',
	sign_time datetime NOT NULL default '0000-00-00 00:00:00',
	obs_min int(6) unsigned NOT NULL default '0',
	`temp` decimal(3,1) NOT NULL default '0.0',
	place_id int(6) unsigned NOT NULL default '0',
	reason_id int(6) unsigned NOT NULL default '0',
	`memo` text NOT NULL default '',
	update_date timestamp,
	teacher_sn int(11) NOT NULL default '0',
	PRIMARY KEY (id)
) ENGINE=MyISAM;

#
# ��ƪ�榡�G `health_accident_part_record`
#

CREATE TABLE if not exists  health_accident_part_record (
	`pid` int(10) unsigned NOT NULL auto_increment,
	id int(10) unsigned NOT NULL default '0',
	part_id int(6) unsigned NOT NULL default '0',
	PRIMARY KEY (`pid`)
) ENGINE=MyISAM;

#
# ��ƪ�榡�G `health_accident_status_record`
#

CREATE TABLE if not exists  health_accident_status_record (
	`sid` int(10) unsigned NOT NULL auto_increment,
	id int(10) unsigned NOT NULL default '0',
	status_id int(6) unsigned NOT NULL default '0',
	PRIMARY KEY (`sid`)
) ENGINE=MyISAM;

#
# ��ƪ�榡�G `health_accident_attend_record`
#

CREATE TABLE if not exists  health_accident_attend_record (
	aid int(10) unsigned NOT NULL auto_increment,
	id int(10) unsigned NOT NULL default '0',
	attend_id int(6) unsigned NOT NULL default '0',
	PRIMARY KEY (aid)
) ENGINE=MyISAM;
 
