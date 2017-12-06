#
# ��ƪ�榡�G `grad_stud`
#

CREATE TABLE grad_stud (
  grad_sn int(10) NOT NULL auto_increment,
  stud_grad_year tinyint(3) unsigned default NULL,
  class_year char(2) default NULL,
  class_sort tinyint(2) unsigned default NULL,
  stud_id varchar(20) default NULL,
  grad_kind tinyint(1) unsigned default NULL,
  grad_date date default NULL,
  grad_word varchar(20) default NULL,
  grad_num varchar(20) default NULL,
  grad_score float unsigned default NULL,
  UNIQUE KEY grad_sn (grad_sn)
) TYPE=MyISAM;

#
# ��ƪ�榡�G `school_day`
#

CREATE TABLE school_day (
  day_kind varchar(40) NOT NULL default '',
  day date NOT NULL default '0000-00-00',
  year tinyint(2) unsigned NOT NULL default '0',
  seme enum('1','2') NOT NULL default '1',
  UNIQUE KEY year_seme (day_kind,year,seme)
) TYPE=MyISAM;

#
# �C�X�H�U��Ʈw���ƾڡG `school_day`
#

#
# ��ƪ�榡�G `sfs_module`
#

CREATE TABLE sfs_module (
  msn smallint(5) unsigned NOT NULL auto_increment,
  showname varchar(100) NOT NULL default '',
  dirname varchar(100) NOT NULL default '',
  sort smallint(5) unsigned NOT NULL default '0',
  isopen tinyint(1) NOT NULL default '0',
  islive tinyint(4) NOT NULL default '1',
  of_group smallint(5) unsigned NOT NULL default '0',
  ver varchar(20) NOT NULL default '',
  icon_image varchar(255) NOT NULL default '',
  author varchar(100) NOT NULL default '',
  creat_date date NOT NULL default '0000-00-00',
  kind enum('�Ҳ�','����') NOT NULL default '�Ҳ�',
  txt varchar(255) NOT NULL default '',
  PRIMARY KEY  (msn),
  KEY sort (sort,of_group)
) TYPE=MyISAM;

#
# �C�X�H�U��Ʈw���ƾڡG `sfs_module`
#

INSERT INTO sfs_module VALUES (1, '�t�κ޲z', '', 7, 0, 1, 0, '', 'administrator_icon.png', '', '0000-00-00', '����', '');
INSERT INTO sfs_module VALUES (2, '�հȦ�F', '', 1, 1, 1, 0, '', 'school_icon.png', '', '0000-00-00', '����', '');
INSERT INTO sfs_module VALUES (8, '����Ʈw', 'docup', 4, 1, 1, 2, '2.0.1', '', 'hami', '2002-12-15', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (9, '���\\���Ф��i', 'lunch', 3, 1, 1, 2, '1.0.8', '', 'prolin', '2000-09-17', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (7, '�ϮѺ޲z�t��', 'book', 2, 1, 1, 2, '2.0.1', '', 'hami', '2002-12-15', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (41, '�n���Юv�޲z', 'tnc_teach_class', 6, 0, 1, 12, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (11, '�ն��ƾ�', 'school_calendar', 1, 1, 1, 2, '1.0', '', 'tad', '2003-03-24', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (12, '�а�', '', 2, 0, 1, 0, '', 'school_affairs_icon.png', '', '0000-00-00', '����', '');
INSERT INTO sfs_module VALUES (13, '�V��', '', 3, 0, 1, 0, '', 'student_counsellor_icon.png', '', '0000-00-00', '����', '');
INSERT INTO sfs_module VALUES (14, '����', '', 4, 0, 0, 0, '', 'advisory_icon.png', '', '0000-00-00', '����', '');
INSERT INTO sfs_module VALUES (15, '��¾��', '', 6, 0, 1, 0, '', 'school_teacher_icon.png', '', '0000-00-00', '����', '');
INSERT INTO sfs_module VALUES (16, '�оǲ�', '', 3, 0, 1, 12, '', 'student_edu_icon.png', '', '0000-00-00', '����', '');
INSERT INTO sfs_module VALUES (17, '���U��', '', 4, 0, 1, 12, '', 'student_reg_icon.png', '', '0000-00-00', '����', '');
INSERT INTO sfs_module VALUES (18, '�t�γƥ�', 'backup', 2, 0, 1, 1, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (19, '���w�s����', 'chang_root', 8, 0, 1, 1, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (20, '��Ʈw���޲z', 'database_info', 6, 0, 1, 1, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (21, '�Ǯճ]�w', 'school_setup', 1, 0, 1, 12, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (23, '���Z�椶���޲z', 'score_input_interface', 11, 0, 0, 1, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (24, '�Ҳ��v���޲z', 'sfs_man2', 1, 0, 1, 1, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (26, '�t�οﶵ�M��]�w', 'sfs_text', 7, 0, 1, 1, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (60, '���m�Ҽ��g�޲z', 'absent', 1, 0, 1, 13, '1.0', '', '', '2003-04-18', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (28, '�u�W�լd�t��', 'online_form', 13, 0, 1, 15, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (29, '�Ǵ���]�w', 'every_year_setup', 2, 0, 1, 12, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (30, '��ƾ�', 'calendar', 16, 0, 1, 15, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (31, '�Z�ž��y�޲z', 'stud_class', 1, 0, 1, 15, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (32, '�M��Ыǹw��', 'new_compclass', 15, 0, 1, 15, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (33, '���Z�޲z', 'score_input', 12, 0, 1, 15, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (34, '�Юv�޲z', 'teach_class', 5, 0, 1, 12, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (35, '��F�K�X�d��', 'teacher_pass', 9, 0, 1, 1, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (36, '���i�޲z', 'new_board', 14, 0, 1, 15, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (37, '�s�@���Z��', 'academic_record', 11, 0, 1, 15, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (40, '�ǮսҪ�ץX�t��', 'course_paper', 1, 0, 1, 16, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (42, '���Z�d��', 'score_list', 2, 0, 1, 16, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (43, '���Z�޲z', 'score_manage', 3, 0, 1, 16, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (44, '���y�޲z', 'stud_reg', 1, 0, 1, 17, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (45, '�ǥͲ���', 'stud_move', 2, 0, 1, 17, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (46, '�ǥ͸�Ƭd�߲έp', 'stud_query', 3, 0, 1, 17, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (47, '�פJ���', 'create_data', 4, 0, 1, 17, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (48, '�s�Z�@�~', 'stud_year', 5, 0, 1, 17, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (49, '���y����', 'stud_report', 6, 0, 1, 17, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (50, '���Z��J', 'score_input_all', 7, 0, 1, 17, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (51, 'S�Φ۰ʽs�Z', 'stud_compile', 8, 0, 1, 17, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (52, '�s�ͽs�Z', 'temp_compile', 9, 0, 1, 17, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (53, '���~�ͧ@�~', 'graduate', 10, 0, 1, 17, '', '', 'JRH', '2003-03-25', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (54, '���K�X', 'chpass', 21, 0, 1, 15, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (55, '�ŰȺ޲z', 'class_things', 2, 0, 1, 15, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (56, '�Ʀ�ۥ�', 'mig', 5, 1, 1, 2, '2.0.1', '', 'hami', '2003-03-19', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (57, '�Юv�q�T��', 'teach_report_more', 22, 0, 1, 15, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (58, '�ӤH���', 'teacher_self', 20, 0, 1, 15, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (59, '�ǮսҪ�d�ߨt��', 'new_course', 6, 1, 1, 2, '1.0', '', '', '2003-01-01', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (61, '�հȧG�i��', 'board', 7, 1, 1, 2, '', '', 'hami', '2003-04-06', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (62, '�հȧG�i��޲z�{��', 'board_man', 12, 0, 1, 1, '', '', 'hami', '2003-04-06', '�Ҳ�', '');
# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_absence`
#

CREATE TABLE stud_absence (
  abs_sn bigint(20) NOT NULL auto_increment,
  date date NOT NULL default '0000-00-00',
  stud_id varchar(20) NOT NULL default '',
  ab1 tinyint(1) default NULL,
  ab2 tinyint(1) default NULL,
  ab3 tinyint(1) default NULL,
  ab4 tinyint(1) default NULL,
  ab5 tinyint(1) default NULL,
  ab6 tinyint(1) default NULL,
  ab7 tinyint(1) default NULL,
  meno varchar(200) default NULL,
  PRIMARY KEY  (abs_sn)
) TYPE=MyISAM;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_absence`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_absent`
#

CREATE TABLE stud_absent (
  sasn int(10) unsigned NOT NULL auto_increment,
  year smallint(5) unsigned NOT NULL default '0',
  semester enum('1','2') NOT NULL default '1',
  class_id varchar(11) NOT NULL default '',
  stud_id varchar(20) NOT NULL default '',
  date date NOT NULL default '0000-00-00',
  absent_kind varchar(20) NOT NULL default '',
  section varchar(10) NOT NULL default '',
  sign_man_sn int(11) NOT NULL default '0',
  sign_man_name varchar(20) NOT NULL default '',
  sign_time datetime NOT NULL default '0000-00-00 00:00:00',
  txt text NOT NULL,
  PRIMARY KEY  (sasn),
  UNIQUE KEY date (stud_id,date,section),
  KEY year (year,semester,class_id,stud_id),
  KEY sign_man_sn (sign_man_sn)
) TYPE=MyISAM;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_absent`
#
#
# ��ƪ�榡�G `stud_addr_zip`
#

CREATE TABLE stud_addr_zip (
  zip char(3) NOT NULL default '',
  country varchar(10) NOT NULL default '',
  town varchar(10) NOT NULL default '',
  area_num varchar(6) NOT NULL default '',
  PRIMARY KEY  (zip)
) TYPE=MyISAM COMMENT='�l���ϸ�';

#
# �C�X�H�U��Ʈw���ƾڡG `stud_addr_zip`
#

INSERT INTO stud_addr_zip VALUES ('100', '�x�_��', '������', '02');
INSERT INTO stud_addr_zip VALUES ('103', '�x�_��', '�j�P��', '02');
INSERT INTO stud_addr_zip VALUES ('104', '�x�_��', '���s��', '02');
INSERT INTO stud_addr_zip VALUES ('105', '�x�_��', '�Q�s��', '02');
INSERT INTO stud_addr_zip VALUES ('106', '�x�_��', '�j�w��', '02');
INSERT INTO stud_addr_zip VALUES ('108', '�x�_��', '�U�ذ�', '02');
INSERT INTO stud_addr_zip VALUES ('110', '�x�_��', '�H�q��', '02');
INSERT INTO stud_addr_zip VALUES ('111', '�x�_��', '�h�L��', '02');
INSERT INTO stud_addr_zip VALUES ('112', '�x�_��', '�_���', '02');
INSERT INTO stud_addr_zip VALUES ('114', '�x�_��', '�����', '02');
INSERT INTO stud_addr_zip VALUES ('115', '�x�_��', '�n���', '02');
INSERT INTO stud_addr_zip VALUES ('116', '�x�_��', '��s��', '02');
INSERT INTO stud_addr_zip VALUES ('117', '�x�_��', '������', '02');
INSERT INTO stud_addr_zip VALUES ('200', '�򶩥�', '���R��', '02');
INSERT INTO stud_addr_zip VALUES ('201', '�򶩥�', '�H�q��', '02');
INSERT INTO stud_addr_zip VALUES ('202', '�򶩥�', '������', '02');
INSERT INTO stud_addr_zip VALUES ('203', '�򶩥�', '���s��', '02');
INSERT INTO stud_addr_zip VALUES ('204', '�򶩥�', '�w�ְ�', '02');
INSERT INTO stud_addr_zip VALUES ('205', '�򶩥�', '�x�x��', '02');
INSERT INTO stud_addr_zip VALUES ('206', '�򶩥�', '�C����', '02');
INSERT INTO stud_addr_zip VALUES ('207', '�x�_��', '�U���m', '02');
INSERT INTO stud_addr_zip VALUES ('208', '�x�_��', '���s�m', '02');
INSERT INTO stud_addr_zip VALUES ('209', '�s����', '�����n', '0836');
INSERT INTO stud_addr_zip VALUES ('210', '�s����', '�����_', '0837');
INSERT INTO stud_addr_zip VALUES ('211', '�s����', '������', '0838');
INSERT INTO stud_addr_zip VALUES ('212', '�s����', '�����F', '0839');
INSERT INTO stud_addr_zip VALUES ('220', '�x�_��', '�O����', '02');
INSERT INTO stud_addr_zip VALUES ('221', '�x�_��', '���', '02');
INSERT INTO stud_addr_zip VALUES ('222', '�x�_��', '�`�|�m', '02');
INSERT INTO stud_addr_zip VALUES ('223', '�x�_��', '����m', '02');
INSERT INTO stud_addr_zip VALUES ('224', '�x�_��', '�����', '02');
INSERT INTO stud_addr_zip VALUES ('226', '�x�_��', '���˶m', '02');
INSERT INTO stud_addr_zip VALUES ('227', '�x�_��', '���˶m', '02');
INSERT INTO stud_addr_zip VALUES ('228', '�x�_��', '�^�d�m', '02');
INSERT INTO stud_addr_zip VALUES ('231', '�x�_��', '�s����', '02');
INSERT INTO stud_addr_zip VALUES ('232', '�x�_��', '�W�L�m', '02');
INSERT INTO stud_addr_zip VALUES ('233', '�x�_��', '�Q�Ӷm', '02');
INSERT INTO stud_addr_zip VALUES ('234', '�x�_��', '�éM��', '02');
INSERT INTO stud_addr_zip VALUES ('235', '�x�_��', '���M��', '02');
INSERT INTO stud_addr_zip VALUES ('236', '�x�_��', '�g����', '02');
INSERT INTO stud_addr_zip VALUES ('237', '�x�_��', '�T�l��', '02');
INSERT INTO stud_addr_zip VALUES ('238', '�x�_��', '��L��', '02');
INSERT INTO stud_addr_zip VALUES ('239', '�x�_��', '�a�q��', '02');
INSERT INTO stud_addr_zip VALUES ('241', '�x�_��', '�T����', '02');
INSERT INTO stud_addr_zip VALUES ('242', '�x�_��', '�s����', '02');
INSERT INTO stud_addr_zip VALUES ('243', '�x�_��', '���s�m', '02');
INSERT INTO stud_addr_zip VALUES ('244', '�x�_��', '�L�f�m', '02');
INSERT INTO stud_addr_zip VALUES ('247', '�x�_��', 'Ī�w��', '02');
INSERT INTO stud_addr_zip VALUES ('248', '�x�_��', '���Ѷm', '02');
INSERT INTO stud_addr_zip VALUES ('249', '�x�_��', '�K���m', '02');
INSERT INTO stud_addr_zip VALUES ('251', '�x�_��', '�H����', '02');
INSERT INTO stud_addr_zip VALUES ('252', '�x�_��', '�T�۶m', '02');
INSERT INTO stud_addr_zip VALUES ('253', '�x�_��', '�۪��m', '02');
INSERT INTO stud_addr_zip VALUES ('260', '�y����', '�y����', '039');
INSERT INTO stud_addr_zip VALUES ('261', '�y����', '�Y����', '039');
INSERT INTO stud_addr_zip VALUES ('262', '�y����', '�G�˶m', '039');
INSERT INTO stud_addr_zip VALUES ('263', '�y����', '����m', '039');
INSERT INTO stud_addr_zip VALUES ('264', '�y����', '���s�m', '039');
INSERT INTO stud_addr_zip VALUES ('265', '�y����', 'ù�F��', '039');
INSERT INTO stud_addr_zip VALUES ('266', '�y����', '�T�P�m', '039');
INSERT INTO stud_addr_zip VALUES ('267', '�y����', '�j�P�m', '039');
INSERT INTO stud_addr_zip VALUES ('268', '�y����', '�����m', '039');
INSERT INTO stud_addr_zip VALUES ('269', '�y����', '�V�s�m', '039');
INSERT INTO stud_addr_zip VALUES ('270', '�y����', 'Ĭ�D��', '039');
INSERT INTO stud_addr_zip VALUES ('272', '�y����', '�n�D�m', '039');
INSERT INTO stud_addr_zip VALUES ('300', '�s�˥�', '�s�˥�', '035');
INSERT INTO stud_addr_zip VALUES ('302', '�s�˿�', '�˥_��', '035');
INSERT INTO stud_addr_zip VALUES ('303', '�s�˿�', '��f�m', '035');
INSERT INTO stud_addr_zip VALUES ('304', '�s�˿�', '�s�׶m', '035');
INSERT INTO stud_addr_zip VALUES ('305', '�s�˿�', '�s�H��', '035');
INSERT INTO stud_addr_zip VALUES ('306', '�s�˿�', '������', '035');
INSERT INTO stud_addr_zip VALUES ('307', '�s�˿�', '�|�L�m', '035');
INSERT INTO stud_addr_zip VALUES ('308', '�s�˿�', '�_�s�m', '035');
INSERT INTO stud_addr_zip VALUES ('310', '�s�˿�', '�˪F��', '035');
INSERT INTO stud_addr_zip VALUES ('311', '�s�˿�', '���p�m', '035');
INSERT INTO stud_addr_zip VALUES ('312', '�s�˿�', '��s�m', '035');
INSERT INTO stud_addr_zip VALUES ('313', '�s�˿�', '�y�۶m', '035');
INSERT INTO stud_addr_zip VALUES ('314', '�s�˿�', '�_�H�m', '035');
INSERT INTO stud_addr_zip VALUES ('315', '�s�˿�', '�o�ܶm', '035');
INSERT INTO stud_addr_zip VALUES ('320', '��鿤', '���c��', '03');
INSERT INTO stud_addr_zip VALUES ('324', '��鿤', '����', '03');
INSERT INTO stud_addr_zip VALUES ('325', '��鿤', '�s��m', '03');
INSERT INTO stud_addr_zip VALUES ('326', '��鿤', '������', '03');
INSERT INTO stud_addr_zip VALUES ('327', '��鿤', '�s�ζm', '03');
INSERT INTO stud_addr_zip VALUES ('328', '��鿤', '�[���m', '03');
INSERT INTO stud_addr_zip VALUES ('330', '��鿤', '��饫', '03');
INSERT INTO stud_addr_zip VALUES ('333', '��鿤', '�t�s�m', '03');
INSERT INTO stud_addr_zip VALUES ('334', '��鿤', '�K�w��', '03');
INSERT INTO stud_addr_zip VALUES ('335', '��鿤', '�j����', '03');
INSERT INTO stud_addr_zip VALUES ('336', '��鿤', '�_���m', '03');
INSERT INTO stud_addr_zip VALUES ('337', '��鿤', '�j��m', '03');
INSERT INTO stud_addr_zip VALUES ('338', '��鿤', 'Ī�˶m', '03');
INSERT INTO stud_addr_zip VALUES ('350', '�]�߿�', '�˫n��', '037');
INSERT INTO stud_addr_zip VALUES ('351', '�]�߿�', '�Y����', '037');
INSERT INTO stud_addr_zip VALUES ('352', '�]�߿�', '�T�W�m', '037');
INSERT INTO stud_addr_zip VALUES ('353', '�]�߿�', '�n�ܶm', '037');
INSERT INTO stud_addr_zip VALUES ('354', '�]�߿�', '���m', '037');
INSERT INTO stud_addr_zip VALUES ('356', '�]�߿�', '���s��', '037');
INSERT INTO stud_addr_zip VALUES ('357', '�]�߿�', '�q�]��', '037');
INSERT INTO stud_addr_zip VALUES ('358', '�]�߿�', '�b����', '037');
INSERT INTO stud_addr_zip VALUES ('360', '�]�߿�', '�]�ߥ�', '037');
INSERT INTO stud_addr_zip VALUES ('361', '�]�߿�', '�y���m', '037');
INSERT INTO stud_addr_zip VALUES ('362', '�]�߿�', '�Y�ζm', '037');
INSERT INTO stud_addr_zip VALUES ('363', '�]�߿�', '���]�m', '037');
INSERT INTO stud_addr_zip VALUES ('364', '�]�߿�', '�j��m', '037');
INSERT INTO stud_addr_zip VALUES ('365', '�]�߿�', '���w�m', '037');
INSERT INTO stud_addr_zip VALUES ('366', '�]�߿�', '���r�m', '037');
INSERT INTO stud_addr_zip VALUES ('367', '�]�߿�', '�T�q�m', '037');
INSERT INTO stud_addr_zip VALUES ('368', '�]�߿�', '���m', '037');
INSERT INTO stud_addr_zip VALUES ('369', '�]�߿�', '������', '04');
INSERT INTO stud_addr_zip VALUES ('400', '�x����', '����', '04');
INSERT INTO stud_addr_zip VALUES ('401', '�x����', '�F��', '04');
INSERT INTO stud_addr_zip VALUES ('402', '�x����', '�n��', '04');
INSERT INTO stud_addr_zip VALUES ('403', '�x����', '���', '04');
INSERT INTO stud_addr_zip VALUES ('404', '�x����', '�_��', '04');
INSERT INTO stud_addr_zip VALUES ('406', '�x����', '�_��', '04');
INSERT INTO stud_addr_zip VALUES ('407', '�x����', '���', '04');
INSERT INTO stud_addr_zip VALUES ('408', '�x����', '�n��', '04');
INSERT INTO stud_addr_zip VALUES ('411', '�x����', '�ӥ���', '04');
INSERT INTO stud_addr_zip VALUES ('412', '�x����', '�j����', '04');
INSERT INTO stud_addr_zip VALUES ('413', '�x����', '���p�m', '04');
INSERT INTO stud_addr_zip VALUES ('414', '�x����', '�Q��m', '04');
INSERT INTO stud_addr_zip VALUES ('420', '�x����', '�׭쥫', '04');
INSERT INTO stud_addr_zip VALUES ('421', '�x����', '�Z���m', '04');
INSERT INTO stud_addr_zip VALUES ('422', '�x����', '�۩��m', '04');
INSERT INTO stud_addr_zip VALUES ('423', '�x����', '�F����', '04');
INSERT INTO stud_addr_zip VALUES ('424', '�x����', '�M���m', '04');
INSERT INTO stud_addr_zip VALUES ('426', '�x����', '�s���m', '04');
INSERT INTO stud_addr_zip VALUES ('427', '�x����', '��l�m', '04');
INSERT INTO stud_addr_zip VALUES ('428', '�x����', '�j���m', '04');
INSERT INTO stud_addr_zip VALUES ('429', '�x����', '�����m', '04');
INSERT INTO stud_addr_zip VALUES ('432', '�x����', '�j�{�m', '04');
INSERT INTO stud_addr_zip VALUES ('433', '�x����', '�F����', '04');
INSERT INTO stud_addr_zip VALUES ('434', '�x����', '�s���m', '04');
INSERT INTO stud_addr_zip VALUES ('435', '�x����', '�����', '04');
INSERT INTO stud_addr_zip VALUES ('436', '�x����', '�M����', '04');
INSERT INTO stud_addr_zip VALUES ('437', '�x����', '�j����', '04');
INSERT INTO stud_addr_zip VALUES ('438', '�x����', '�~�H�m', '04');
INSERT INTO stud_addr_zip VALUES ('439', '�x����', '�j�w�m', '04');
INSERT INTO stud_addr_zip VALUES ('500', '���ƿ�', '���ƥ�', '04');
INSERT INTO stud_addr_zip VALUES ('502', '���ƿ�', '���m', '04');
INSERT INTO stud_addr_zip VALUES ('503', '���ƿ�', '��¶m', '04');
INSERT INTO stud_addr_zip VALUES ('504', '���ƿ�', '�q���m', '04');
INSERT INTO stud_addr_zip VALUES ('505', '���ƿ�', '������', '04');
INSERT INTO stud_addr_zip VALUES ('506', '���ƿ�', '�ֿ��m', '04');
INSERT INTO stud_addr_zip VALUES ('507', '���ƿ�', '�u��m', '04');
INSERT INTO stud_addr_zip VALUES ('508', '���ƿ�', '�M����', '04');
INSERT INTO stud_addr_zip VALUES ('509', '���ƿ�', '����m', '04');
INSERT INTO stud_addr_zip VALUES ('510', '���ƿ�', '���L��', '04');
INSERT INTO stud_addr_zip VALUES ('511', '���ƿ�', '���Y�m', '04');
INSERT INTO stud_addr_zip VALUES ('512', '���ƿ�', '�ùt�m', '04');
INSERT INTO stud_addr_zip VALUES ('513', '���ƿ�', '�H�߶m', '04');
INSERT INTO stud_addr_zip VALUES ('514', '���ƿ�', '�˴���', '04');
INSERT INTO stud_addr_zip VALUES ('515', '���ƿ�', '�j���m', '04');
INSERT INTO stud_addr_zip VALUES ('516', '���ƿ�', '�H�Q�m', '04');
INSERT INTO stud_addr_zip VALUES ('520', '���ƿ�', '�Ф���', '04');
INSERT INTO stud_addr_zip VALUES ('521', '���ƿ�', '�_����', '04');
INSERT INTO stud_addr_zip VALUES ('522', '���ƿ�', '�Ч��m', '04');
INSERT INTO stud_addr_zip VALUES ('523', '���ƿ�', '���Y�m', '04');
INSERT INTO stud_addr_zip VALUES ('524', '���ƿ�', '�˦{�m', '04');
INSERT INTO stud_addr_zip VALUES ('525', '���ƿ�', '�˶�m', '04');
INSERT INTO stud_addr_zip VALUES ('526', '���ƿ�', '�G�L��', '04');
INSERT INTO stud_addr_zip VALUES ('527', '���ƿ�', '�j���m', '04');
INSERT INTO stud_addr_zip VALUES ('528', '���ƿ�', '�ڭb�m', '04');
INSERT INTO stud_addr_zip VALUES ('530', '���ƿ�', '�G���m', '04');
INSERT INTO stud_addr_zip VALUES ('540', '�n�뿤', '�n�륫', '049');
INSERT INTO stud_addr_zip VALUES ('541', '�n�뿤', '���d�m', '049');
INSERT INTO stud_addr_zip VALUES ('542', '�n�뿤', '�����', '049');
INSERT INTO stud_addr_zip VALUES ('544', '�n�뿤', '��m�m', '049');
INSERT INTO stud_addr_zip VALUES ('545', '�n�뿤', '�H����', '049');
INSERT INTO stud_addr_zip VALUES ('546', '�n�뿤', '���R�m', '049');
INSERT INTO stud_addr_zip VALUES ('551', '�n�뿤', '�W���m', '049');
INSERT INTO stud_addr_zip VALUES ('552', '�n�뿤', '������', '049');
INSERT INTO stud_addr_zip VALUES ('553', '�n�뿤', '�����m', '049');
INSERT INTO stud_addr_zip VALUES ('555', '�n�뿤', '�����m', '049');
INSERT INTO stud_addr_zip VALUES ('556', '�n�뿤', '�H�q�m', '049');
INSERT INTO stud_addr_zip VALUES ('557', '�n�뿤', '�ˤs��', '049');
INSERT INTO stud_addr_zip VALUES ('558', '�n�뿤', '�����m', '049');
INSERT INTO stud_addr_zip VALUES ('600', '�Ÿq��', '��Ϥ�', '05');
INSERT INTO stud_addr_zip VALUES ('602', '�Ÿq��', '�f���m', '05');
INSERT INTO stud_addr_zip VALUES ('603', '�Ÿq��', '���s�m', '05');
INSERT INTO stud_addr_zip VALUES ('604', '�Ÿq��', '�˱T�m', '05');
INSERT INTO stud_addr_zip VALUES ('605', '�Ÿq��', '�����s�m', '05');
INSERT INTO stud_addr_zip VALUES ('606', '�Ÿq��', '���H�m', '05');
INSERT INTO stud_addr_zip VALUES ('607', '�Ÿq��', '�j�H�m', '05');
INSERT INTO stud_addr_zip VALUES ('608', '�Ÿq��', '���W�m', '05');
INSERT INTO stud_addr_zip VALUES ('611', '�Ÿq��', '����m', '05');
INSERT INTO stud_addr_zip VALUES ('612', '�Ÿq��', '�ӫO��', '05');
INSERT INTO stud_addr_zip VALUES ('613', '�Ÿq��', '���l��', '05');
INSERT INTO stud_addr_zip VALUES ('614', '�Ÿq��', '�F�۶m', '05');
INSERT INTO stud_addr_zip VALUES ('615', '�Ÿq��', '���}�m', '05');
INSERT INTO stud_addr_zip VALUES ('616', '�Ÿq��', '�s��m', '05');
INSERT INTO stud_addr_zip VALUES ('621', '�Ÿq��', '�����m', '05');
INSERT INTO stud_addr_zip VALUES ('622', '�Ÿq��', '�j�L��', '05');
INSERT INTO stud_addr_zip VALUES ('623', '�Ÿq��', '�ˤf�m', '05');
INSERT INTO stud_addr_zip VALUES ('624', '�Ÿq��', '�q�˶m', '05');
INSERT INTO stud_addr_zip VALUES ('625', '�Ÿq��', '���U��', '05');
INSERT INTO stud_addr_zip VALUES ('630', '���L��', '��n��', '05');
INSERT INTO stud_addr_zip VALUES ('631', '���L��', '�j��m', '05');
INSERT INTO stud_addr_zip VALUES ('632', '���L��', '�����', '05');
INSERT INTO stud_addr_zip VALUES ('633', '���L��', '�g�w��', '05');
INSERT INTO stud_addr_zip VALUES ('634', '���L��', '�ǩ��m', '05');
INSERT INTO stud_addr_zip VALUES ('635', '���L��', '�F�նm', '05');
INSERT INTO stud_addr_zip VALUES ('636', '���L��', '�x��m', '05');
INSERT INTO stud_addr_zip VALUES ('637', '���L��', '�[�I�m', '05');
INSERT INTO stud_addr_zip VALUES ('638', '���L��', '���d�m', '05');
INSERT INTO stud_addr_zip VALUES ('640', '���L��', '�椻��', '05');
INSERT INTO stud_addr_zip VALUES ('643', '���L��', '�L���m', '05');
INSERT INTO stud_addr_zip VALUES ('646', '���L��', '�j�|�m', '05');
INSERT INTO stud_addr_zip VALUES ('647', '���L��', '�l��m', '05');
INSERT INTO stud_addr_zip VALUES ('648', '���L��', '������', '05');
INSERT INTO stud_addr_zip VALUES ('649', '���L��', '�G�[�m', '05');
INSERT INTO stud_addr_zip VALUES ('651', '���L��', '�_����', '05');
INSERT INTO stud_addr_zip VALUES ('652', '���L��', '���L�m', '05');
INSERT INTO stud_addr_zip VALUES ('653', '���L��', '�f��m', '05');
INSERT INTO stud_addr_zip VALUES ('654', '���L��', '�|��m', '05');
INSERT INTO stud_addr_zip VALUES ('655', '���L��', '�����m', '05');
INSERT INTO stud_addr_zip VALUES ('700', '�x�n��', '����', '06');
INSERT INTO stud_addr_zip VALUES ('701', '�x�n��', '�F��', '06');
INSERT INTO stud_addr_zip VALUES ('702', '�x�n��', '�n��', '06');
INSERT INTO stud_addr_zip VALUES ('703', '�x�n��', '���', '06');
INSERT INTO stud_addr_zip VALUES ('704', '�x�n��', '�_��', '06');
INSERT INTO stud_addr_zip VALUES ('708', '�x�n��', '�w����', '06');
INSERT INTO stud_addr_zip VALUES ('709', '�x�n��', '�w�n��', '06');
INSERT INTO stud_addr_zip VALUES ('710', '�x�n��', '�ñd��', '06');
INSERT INTO stud_addr_zip VALUES ('711', '�x�n��', '�k���m', '06');
INSERT INTO stud_addr_zip VALUES ('712', '�x�n��', '�s����', '06');
INSERT INTO stud_addr_zip VALUES ('713', '�x�n��', '����m', '06');
INSERT INTO stud_addr_zip VALUES ('714', '�x�n��', '�ɤ��m', '06');
INSERT INTO stud_addr_zip VALUES ('715', '�x�n��', '����m', '06');
INSERT INTO stud_addr_zip VALUES ('716', '�x�n��', '�n�ƶm', '06');
INSERT INTO stud_addr_zip VALUES ('717', '�x�n��', '���w�m', '06');
INSERT INTO stud_addr_zip VALUES ('718', '�x�n��', '���q�m', '06');
INSERT INTO stud_addr_zip VALUES ('719', '�x�n��', '�s�T�m', '06');
INSERT INTO stud_addr_zip VALUES ('720', '�x�n��', '�x�жm', '06');
INSERT INTO stud_addr_zip VALUES ('721', '�x�n��', '�¨���', '06');
INSERT INTO stud_addr_zip VALUES ('722', '�x�n��', '�Ψ���', '06');
INSERT INTO stud_addr_zip VALUES ('723', '�x�n��', '���m', '06');
INSERT INTO stud_addr_zip VALUES ('724', '�x�n��', '�C�Ѷm', '06');
INSERT INTO stud_addr_zip VALUES ('725', '�x�n��', '�N�x�m', '06');
INSERT INTO stud_addr_zip VALUES ('726', '�x�n��', '�ǥ���', '06');
INSERT INTO stud_addr_zip VALUES ('727', '�x�n��', '�_���m', '06');
INSERT INTO stud_addr_zip VALUES ('730', '�x�n��', '�s�祫', '06');
INSERT INTO stud_addr_zip VALUES ('731', '�x�n��', '����m', '06');
INSERT INTO stud_addr_zip VALUES ('732', '�x�n��', '�ժe��', '06');
INSERT INTO stud_addr_zip VALUES ('733', '�x�n��', '�F�s�m', '06');
INSERT INTO stud_addr_zip VALUES ('734', '�x�n��', '���Ҷm', '06');
INSERT INTO stud_addr_zip VALUES ('735', '�x�n��', '�U��m', '06');
INSERT INTO stud_addr_zip VALUES ('736', '�x�n��', '�h��m', '06');
INSERT INTO stud_addr_zip VALUES ('737', '�x�n��', '�Q����', '06');
INSERT INTO stud_addr_zip VALUES ('741', '�x�n��', '������', '06');
INSERT INTO stud_addr_zip VALUES ('742', '�x�n��', '�j���m', '06');
INSERT INTO stud_addr_zip VALUES ('743', '�x�n��', '�s�W�m', '06');
INSERT INTO stud_addr_zip VALUES ('744', '�x�n��', '�s���m', '06');
INSERT INTO stud_addr_zip VALUES ('745', '�x�n��', '�w�w�m', '06');
INSERT INTO stud_addr_zip VALUES ('800', '������', '�s����', '07');
INSERT INTO stud_addr_zip VALUES ('801', '������', '�e����', '07');
INSERT INTO stud_addr_zip VALUES ('802', '������', '�d����', '07');
INSERT INTO stud_addr_zip VALUES ('803', '������', '�Q�L��', '07');
INSERT INTO stud_addr_zip VALUES ('804', '������', '���s��', '07');
INSERT INTO stud_addr_zip VALUES ('805', '������', '�X�z��', '07');
INSERT INTO stud_addr_zip VALUES ('806', '������', '�e���', '07');
INSERT INTO stud_addr_zip VALUES ('807', '������', '�T����', '07');
INSERT INTO stud_addr_zip VALUES ('811', '������', '�����', '07');
INSERT INTO stud_addr_zip VALUES ('812', '������', '�p���', '07');
INSERT INTO stud_addr_zip VALUES ('813', '������', '�����', '07');
INSERT INTO stud_addr_zip VALUES ('814', '������', '���Z�m', '07');
INSERT INTO stud_addr_zip VALUES ('815', '������', '�j���m', '07');
INSERT INTO stud_addr_zip VALUES ('817', '�n���Ѯq', '�F�F', '0827');
INSERT INTO stud_addr_zip VALUES ('819', '�n���Ѯq', '�n�F', '0827');
INSERT INTO stud_addr_zip VALUES ('820', '������', '���s��', '07');
INSERT INTO stud_addr_zip VALUES ('821', '������', '���˶m', '07');
INSERT INTO stud_addr_zip VALUES ('822', '������', '�����m', '07');
INSERT INTO stud_addr_zip VALUES ('823', '������', '�мd�m', '07');
INSERT INTO stud_addr_zip VALUES ('824', '������', '�P�_�m', '07');
INSERT INTO stud_addr_zip VALUES ('825', '������', '���Y�m', '07');
INSERT INTO stud_addr_zip VALUES ('826', '������', '��x�m', '07');
INSERT INTO stud_addr_zip VALUES ('827', '������', '�����m', '07');
INSERT INTO stud_addr_zip VALUES ('828', '������', '�æw�m', '07');
INSERT INTO stud_addr_zip VALUES ('829', '������', '�򤺶m', '07');
INSERT INTO stud_addr_zip VALUES ('830', '������', '��s��', '07');
INSERT INTO stud_addr_zip VALUES ('831', '������', '�j�d�m', '07');
INSERT INTO stud_addr_zip VALUES ('832', '������', '�L��m', '07');
INSERT INTO stud_addr_zip VALUES ('833', '������', '���Q�m', '07');
INSERT INTO stud_addr_zip VALUES ('840', '������', '�j��m', '07');
INSERT INTO stud_addr_zip VALUES ('842', '������', '�X�s��', '07');
INSERT INTO stud_addr_zip VALUES ('843', '������', '���@��', '07');
INSERT INTO stud_addr_zip VALUES ('844', '������', '���t�m', '07');
INSERT INTO stud_addr_zip VALUES ('845', '������', '�����m', '07');
INSERT INTO stud_addr_zip VALUES ('846', '������', '���L�m', '07');
INSERT INTO stud_addr_zip VALUES ('847', '������', '�ҥP�m', '07');
INSERT INTO stud_addr_zip VALUES ('848', '������', '�緽�m', '07');
INSERT INTO stud_addr_zip VALUES ('849', '������', '�T���m', '07');
INSERT INTO stud_addr_zip VALUES ('851', '������', '�Z�L�m', '07');
INSERT INTO stud_addr_zip VALUES ('852', '������', '�X�_�m', '07');
INSERT INTO stud_addr_zip VALUES ('880', '���', '������', '06');
INSERT INTO stud_addr_zip VALUES ('881', '���', '�����m', '06');
INSERT INTO stud_addr_zip VALUES ('882', '���', '��w�m', '06');
INSERT INTO stud_addr_zip VALUES ('883', '���', '�C���m', '06');
INSERT INTO stud_addr_zip VALUES ('884', '���', '�ըF�m', '06');
INSERT INTO stud_addr_zip VALUES ('885', '���', '���m', '06');
INSERT INTO stud_addr_zip VALUES ('890', '������', '���F��', '0823');
INSERT INTO stud_addr_zip VALUES ('891', '������', '������', '0823');
INSERT INTO stud_addr_zip VALUES ('892', '������', '����m', '0823');
INSERT INTO stud_addr_zip VALUES ('893', '������', '������', '0823');
INSERT INTO stud_addr_zip VALUES ('894', '������', '�P���m', '0823');
INSERT INTO stud_addr_zip VALUES ('896', '������', '�Q��', '0826');
INSERT INTO stud_addr_zip VALUES ('900', '�̪F��', '�̪F��', '08');
INSERT INTO stud_addr_zip VALUES ('901', '�̪F��', '�T�a�m', '08');
INSERT INTO stud_addr_zip VALUES ('902', '�̪F��', '���x�m', '08');
INSERT INTO stud_addr_zip VALUES ('903', '�̪F��', '���a�m', '08');
INSERT INTO stud_addr_zip VALUES ('904', '�̪F��', '�E�p�m', '08');
INSERT INTO stud_addr_zip VALUES ('905', '�̪F��', '����m', '08');
INSERT INTO stud_addr_zip VALUES ('906', '�̪F��', '����m', '08');
INSERT INTO stud_addr_zip VALUES ('907', '�̪F��', '�Q�H�m', '08');
INSERT INTO stud_addr_zip VALUES ('908', '�̪F��', '���v�m', '08');
INSERT INTO stud_addr_zip VALUES ('909', '�̪F��', '�ﬥ�m', '08');
INSERT INTO stud_addr_zip VALUES ('911', '�̪F��', '�˥жm', '08');
INSERT INTO stud_addr_zip VALUES ('912', '�̪F��', '���H�m', '08');
INSERT INTO stud_addr_zip VALUES ('913', '�̪F��', '�U���m', '08');
INSERT INTO stud_addr_zip VALUES ('920', '�̪F��', '��{��', '08');
INSERT INTO stud_addr_zip VALUES ('921', '�̪F��', '���Z�m', '08');
INSERT INTO stud_addr_zip VALUES ('922', '�̪F��', '�Ӹq�m', '08');
INSERT INTO stud_addr_zip VALUES ('923', '�̪F��', '�U�r�m', '08');
INSERT INTO stud_addr_zip VALUES ('924', '�̪F��', '�r���m', '08');
INSERT INTO stud_addr_zip VALUES ('925', '�̪F��', '�s��m', '08');
INSERT INTO stud_addr_zip VALUES ('926', '�̪F��', '�n�{�m', '08');
INSERT INTO stud_addr_zip VALUES ('927', '�̪F��', '�L��m', '08');
INSERT INTO stud_addr_zip VALUES ('928', '�̪F��', '�F����', '08');
INSERT INTO stud_addr_zip VALUES ('929', '�̪F��', '�[�y�m', '08');
INSERT INTO stud_addr_zip VALUES ('931', '�̪F��', '�ΥV�m', '08');
INSERT INTO stud_addr_zip VALUES ('932', '�̪F��', '�s��m', '08');
INSERT INTO stud_addr_zip VALUES ('940', '�̪F��', '�D�d�m', '08');
INSERT INTO stud_addr_zip VALUES ('941', '�̪F��', '�D�s�m', '08');
INSERT INTO stud_addr_zip VALUES ('942', '�̪F��', '�K��m', '08');
INSERT INTO stud_addr_zip VALUES ('943', '�̪F��', '��l�m', '08');
INSERT INTO stud_addr_zip VALUES ('944', '�̪F��', '�����m', '08');
INSERT INTO stud_addr_zip VALUES ('945', '�̪F��', '�d���m', '08');
INSERT INTO stud_addr_zip VALUES ('946', '�̪F��', '��K��', '08');
INSERT INTO stud_addr_zip VALUES ('947', '�̪F��', '���{�m', '08');
INSERT INTO stud_addr_zip VALUES ('950', '�x�F��', '�x�F��', '089');
INSERT INTO stud_addr_zip VALUES ('951', '�x�F��', '��q�m', '089');
INSERT INTO stud_addr_zip VALUES ('952', '�x�F��', '�����m', '089');
INSERT INTO stud_addr_zip VALUES ('953', '�x�F��', '�����m', '089');
INSERT INTO stud_addr_zip VALUES ('954', '�x�F��', '���n�m', '089');
INSERT INTO stud_addr_zip VALUES ('955', '�x�F��', '�����m', '089');
INSERT INTO stud_addr_zip VALUES ('956', '�x�F��', '���s��', '089');
INSERT INTO stud_addr_zip VALUES ('957', '�x�F��', '���ݶm', '089');
INSERT INTO stud_addr_zip VALUES ('958', '�x�F��', '���W�m', '089');
INSERT INTO stud_addr_zip VALUES ('959', '�x�F��', '�F�e�m', '089');
# --------------------------------------------------------

ALTER TABLE `board_p` CHANGE `b_url` `b_url` VARCHAR( 150 ) NOT NULL ;
ALTER TABLE `docup_p` CHANGE `docup_p_id` `docup_p_id` INT NOT NULL AUTO_INCREMENT;
ALTER TABLE `docup_p` CHANGE `doc_kind_id` `doc_kind_id` INT DEFAULT '0' NOT NULL ;
ALTER TABLE `docup` CHANGE `docup_p_id` `docup_p_id` INT NOT NULL ;
ALTER TABLE `score_setup` ADD `allow_modify` ENUM( 'false', 'true' ) NOT NULL ;
ALTER TABLE `score_ss` ADD `class_id` VARCHAR( 11 ) NOT NULL ,ADD `link_ss` VARCHAR( 200 ) NOT NULL ;
ALTER TABLE `sfs_text` ADD `t_order_id` INT NOT NULL ;
ALTER TABLE `sfs_text` CHANGE `d_id` `d_id` VARCHAR( 20 ) DEFAULT '0' NOT NULL ;
ALTER TABLE `board_p` ADD `teacher_sn` SMALLINT UNSIGNED NOT NULL ;
ALTER TABLE `board_check` ADD `teacher_sn` SMALLINT UNSIGNED NOT NULL ;
ALTER TABLE `docup` ADD `teacher_sn` SMALLINT UNSIGNED NOT NULL ;
ALTER TABLE `docup_p` ADD `teacher_sn` SMALLINT UNSIGNED NOT NULL ;

