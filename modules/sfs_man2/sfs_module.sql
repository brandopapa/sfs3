# $Id: sfs_module.sql 8152 2014-09-30 01:15:55Z smallduh $

# phpMyAdmin MySQL-Dump
# version 2.4.0
# http://www.phpmyadmin.net/ (download page)
#
# �D��: localhost
# �إߤ��: Apr 01, 2003 at 11:23 AM
# ���A������: 3.23.56
# PHP ����: 4.3.1
# ��Ʈw: `sfs3`
# --------------------------------------------------------

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
) ENGINE=MyISAM;

#
# �C�X�H�U��Ʈw���ƾڡG `sfs_module`
#

INSERT INTO sfs_module VALUES (1, '�t�κ޲z', '', 7, 0, 1, 0, '', 'administrator_icon.png', '', '0000-00-00', '����', '');
INSERT INTO sfs_module VALUES (2, '�հȦ�F', '', 1, 0, 1, 0, '', 'school_icon.png', '', '0000-00-00', '����', '');
INSERT INTO sfs_module VALUES (8, '����Ʈw', 'docup', 4, 0, 1, 2, '2.0.1', '', 'hami', '2002-12-15', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (9, '���\\���Ф��i', 'lunch', 3, 0, 1, 2, '1.0.8', '', 'prolin', '2000-09-17', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (7, '�ϮѺ޲z�t��', 'book', 2, 0, 1, 2, '2.0.1', '', 'hami', '2002-12-15', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (41, '�n���Юv�޲z', 'tnc_teach_class', 6, 0, 1, 12, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (11, '�ն��ƾ�', 'school_calendar', 1, 0, 1, 2, '1.0', '', 'tad', '2003-03-24', '�Ҳ�', '');
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
INSERT INTO sfs_module VALUES (22, '�s�W�����Ҳ�', 'install_module', 4, 0, 1, 1, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (23, '���Z�椶���޲z', 'score_input_interface', 11, 0, 0, 1, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (24, '�Ҳ��v���޲z', 'sfs_man2', 1, 0, 1, 1, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (25, '�ҲհѼƺ޲z', 'sfs_module', 3, 0, 1, 1, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (26, '�t�οﶵ�M��]�w', 'sfs_text', 7, 0, 1, 1, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (27, '���m�Ҽ��g�޲z', 'absent', 1, 0, 1, 13, '', '', '', '0000-00-00', '�Ҳ�', '');
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
INSERT INTO sfs_module VALUES (56, '�Ʀ�ۥ�', 'mig', 5, 0, 1, 2, '2.0.1', '', 'hami', '2003-03-19', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (57, '�Юv�q�T��', 'teach_report_more', 22, 0, 1, 15, '', '', '', '0000-00-00', '�Ҳ�', '');
INSERT INTO sfs_module VALUES (58, '�ӤH���', 'teacher_self', 20, 0, 1, 15, '', '', '', '0000-00-00', '�Ҳ�', '');

