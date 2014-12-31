#
# ��ƪ�榡�G `health_disease_report`
#

CREATE TABLE health_disease_report (
  id int(10) unsigned NOT NULL auto_increment,
  student_sn int(10) unsigned NOT NULL default '0',
  dis_date date NOT NULL default '0000-00-00',
  dis_kind int(6) unsigned NOT NULL default '0',
  sym_str text NOT NULL default '',
  status varchar(2) NOT NULL default '',
  diag_date date NOT NULL default '0000-00-00',
  diag_hos varchar(50) NOT NULL default '',
  diag_name varchar(50) NOT NULL default '',
  chk_date date NOT NULL default '0000-00-00',
  chk_report varchar(50) NOT NULL default '',
  update_date timestamp,
  oth_chk text NOT NULL default '',
  oth_txt text NOT NULL default '',
  teacher_sn int(10) unsigned NOT NULL default '0',
  PRIMARY KEY (student_sn,dis_date),
  KEY `id` (`id`)
) ENGINE=MyISAM;

#
# ��ƪ�榡�G `health_inflection_item`
#

CREATE TABLE health_inflection_item (
  iid int(10) unsigned NOT NULL default '0',
  name varchar(50) NOT NULL default '',
  memo text NOT NULL default '',
  enable varchar(1) NOT NULL default '1',
  PRIMARY KEY (iid)
) ENGINE=MyISAM;
INSERT INTO health_inflection_item VALUES (1,'���y�P','��ʩI�l�D�P�V�B�㦳�U�C�g���G1.��M�o�f���o�N�]�շš�38�J�^�ΩI�l�D�P�V 2.�B���٦׻ĵh���Y�h�η��׹��·P',1);
INSERT INTO health_inflection_item VALUES (2,'�⨬�f�f��&#30129;�l�ʫ|�l��','�⨬�f�f�G�f�B��x�B�}�x�Ων��\�B�v���X�{�p���w�ά��l�F�l�ʫ|�l���G�o�N�B�|���X�{�p���w�μ��',1);
INSERT INTO health_inflection_item VALUES (3,'���m','�C�鸡�m�T���H�W�A�B�X�֤U�C����@���H�W�G1.�æR 2.�o�N 3.�H�G�G���Φ嵷 4.���m',1);
INSERT INTO health_inflection_item VALUES (4,'�o�N','�o�N�]�շš�38�J�^�B�����e�z�e�f�ίg��',1);
INSERT INTO health_inflection_item VALUES (5,'�����g','������h�B�`���B�ȥ��B���y�\�B�����F�������e�A����A���ɷ|�������U�X��F�������ͤj�q�H�ʤ��c���F���ɦիe�O�ڵ��~�j�B���h',1);
INSERT INTO health_inflection_item VALUES (99,'��L','�e�C���إ~���S��ǬV�f',1);

#
# ��ƪ�榡�G `health_inflection_record`
#

CREATE TABLE health_inflection_record (
  id int(10) unsigned NOT NULL auto_increment,
  student_sn int(10) unsigned NOT NULL default '0',
  iid int(10) unsigned NOT NULL default '0',
  dis_date date NOT NULL default '0000-00-00',
  weekday int(4) unsigned NOT NULL default '0',
  status varchar(2) NOT NULL default '',
  rmemo text NOT NULL default '',
  update_date timestamp,
  teacher_sn int(10) unsigned NOT NULL default '0',
  PRIMARY KEY (student_sn,dis_date),
  KEY `id` (`id`)
) ENGINE=MyISAM;
