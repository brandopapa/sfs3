# $Id: sfs3.sql 8468 2015-07-27 16:31:47Z smallduh $
# phpMyAdmin MySQL-Dump
# version 2.4.0
# http://www.phpmyadmin.net/ (download page)
#
# �D��: localhost
# �إߤ��: Apr 30, 2003 at 03:57 PM
# ���A������: 3.23.56
# PHP ����: 4.3.1
# ��Ʈw: `sfsbeta`
# --------------------------------------------------------

#
# ��ƪ�榡�G `board_check`
#

CREATE TABLE board_check (
  pc_id int(11) NOT NULL auto_increment,
  pro_kind_id varchar(12) NOT NULL default '0',
  post_office tinyint(4) NOT NULL default '-1',
  teach_id varchar(20) NOT NULL default 'none',
  teach_title_id tinyint(4) NOT NULL default '-1',
  is_admin char(1) NOT NULL default '',
  teacher_sn int(11) NOT NULL default '0',
  PRIMARY KEY  (pc_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `board_check`
#

INSERT INTO board_check VALUES (1, 'office1', 0, 'none', 0, '', 1);
INSERT INTO board_check VALUES (2, 'office2', 0, 'none', 0, '', 1);
# --------------------------------------------------------

#
# ��ƪ�榡�G `board_kind`
#

CREATE TABLE board_kind (
  bk_id varchar(12) NOT NULL default '0',
  board_name varchar(20) NOT NULL default '',
  board_date date NOT NULL default '0000-00-00',
  board_k_id char(1) NOT NULL default '',
  board_last_date date NOT NULL default '0000-00-00',
  board_is_upload char(1) NOT NULL default '',
  board_is_public char(1) NOT NULL default '',
  board_admin varchar(100) NOT NULL default '',
  PRIMARY KEY  (bk_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `board_kind`
#

INSERT INTO board_kind VALUES ('office1', '�аȳB', '2003-04-28', '0', '0000-00-00', '1', '1', '');
INSERT INTO board_kind VALUES ('office2', '�V�ɳB', '2003-04-28', '0', '0000-00-00', '1', '1', '');
# --------------------------------------------------------

#
# ��ƪ�榡�G `board_p`
#

CREATE TABLE board_p (
  b_id bigint(20) unsigned NOT NULL auto_increment,
  bk_id varchar(12) NOT NULL default '0',
  b_open_date date NOT NULL default '0000-00-00',
  b_days smallint(6) NOT NULL default '0',
  b_unit varchar(20) NOT NULL default '',
  b_title varchar(30) NOT NULL default '',
  b_name varchar(20) NOT NULL default '',
  b_sub varchar(60) NOT NULL default '',
  b_con text NOT NULL,
  b_hints smallint(6) NOT NULL default '0',
  b_upload varchar(60) NOT NULL default '',
  b_url varchar(150) NOT NULL default '',
  b_post_time datetime default NULL,
  b_own_id varchar(20) NOT NULL default '',
  b_is_intranet char(1) NOT NULL default '0',
  teacher_sn int(11) NOT NULL default '0',
  PRIMARY KEY  (b_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `board_p`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `book`
#

CREATE TABLE book (
  bookch1_id char(3) NOT NULL default '',
  book_id varchar(8) NOT NULL default '',
  book_name varchar(100) default NULL,
  book_num int(11) default NULL,
  book_author varchar(50) default NULL,
  book_maker varchar(50) default NULL,
  book_myear varchar(10) default NULL,
  book_bind varchar(6) default NULL,
  book_dollar varchar(8) default NULL,
  book_price int(11) default NULL,
  book_gid varchar(10) default NULL,
  book_content varchar(40) default NULL,
  book_isborrow tinyint(4) default NULL,
  book_isbn varchar(13) default NULL,
  book_isout tinyint(4) NOT NULL default '0',
  book_buy_date datetime NOT NULL default '0000-00-00 00:00:00',
  ISBN varchar(17) default NULL,
  book_sprice varchar(10) default NULL,
  create_date datetime NOT NULL default '0000-00-00 00:00:00',
  update_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (bookch1_id,book_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `book`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `bookch1`
#

CREATE TABLE bookch1 (
  bookch1_id char(3) NOT NULL default '',
  bookch1_name char(20) default NULL,
  bookch2_name char(20) default NULL,
  tolnum int(11) NOT NULL default '0',
  PRIMARY KEY  (bookch1_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `bookch1`
#

INSERT INTO bookch1 VALUES ('600', '����v�a��', '����v�a��', 0);
INSERT INTO bookch1 VALUES ('700', '�@�ɥv�a��', '�@�ɥv�a��', 0);
INSERT INTO bookch1 VALUES ('300', '�۵M�����', '�۵M�����', 0);
INSERT INTO bookch1 VALUES ('200', '�v����', '�v����', 0);
INSERT INTO bookch1 VALUES ('500', '���|�����', ' ���|�����', 0);
INSERT INTO bookch1 VALUES ('900', '���N��', '���N��', 0);
INSERT INTO bookch1 VALUES ('100', '������', '������', 0);
INSERT INTO bookch1 VALUES ('800', '�y����', '�y����', 0);
INSERT INTO bookch1 VALUES ('400', '���ά����', '���ά����', 0);
INSERT INTO bookch1 VALUES ('000', '�`��', '�`��', 0);
# --------------------------------------------------------

#
# ��ƪ�榡�G `borrow`
#

CREATE TABLE borrow (
  b_num int(11) NOT NULL auto_increment,
  stud_id varchar(20) NOT NULL default '',
  bookch1_id char(3) NOT NULL default '',
  book_id varchar(8) NOT NULL default '',
  out_date datetime NOT NULL default '0000-00-00 00:00:00',
  in_date datetime NOT NULL default '0000-00-00 00:00:00',
  curr_class_num int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (b_num)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `borrow`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `calendar`
#

CREATE TABLE calendar (
  cal_sn smallint(5) unsigned NOT NULL auto_increment,
  year smallint(4) unsigned NOT NULL default '0',
  month tinyint(2) unsigned NOT NULL default '0',
  day tinyint(2) unsigned NOT NULL default '0',
  week enum('0','1','2','3','4','5','6') NOT NULL default '0',
  time time NOT NULL default '00:00:00',
  place varchar(255) NOT NULL default '',
  thing text NOT NULL,
  kind varchar(255) NOT NULL default '',
  teacher_sn smallint(5) unsigned NOT NULL default '0',
  from_teacher_sn smallint(5) unsigned NOT NULL default '0',
  from_cal_sn mediumint(8) unsigned NOT NULL default '0',
  restart enum('0','md','d','w') NOT NULL default '0',
  restart_day date NOT NULL default '0000-00-00',
  restart_end date NOT NULL default '0000-00-00',
  import varchar(255) NOT NULL default '',
  post_time datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (cal_sn),
  KEY time (time),
  KEY teacher_sn (teacher_sn),
  KEY from_cal_sn (from_cal_sn),
  KEY week (week),
  KEY restart_day (restart_day,restart_end)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `calendar`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `comment`
#

CREATE TABLE comment (
  serial smallint(8) unsigned NOT NULL auto_increment,
  teacher_id varchar(20) default NULL,
  subject tinyint(3) unsigned default NULL,
  property tinyint(3) unsigned default NULL,
  kind tinyint(2) unsigned default NULL,
  level varchar(10) NOT NULL default '',
  comm varchar(200) NOT NULL default '',
  PRIMARY KEY  (serial)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `comment`
#

INSERT INTO comment VALUES (1, 0, 0, 0, 2, '1', '�O�Ǥ��«椽�n�q');
INSERT INTO comment VALUES (2, 0, 0, 0, 2, '1', '�A�ȼ��߫~�w�u�}');
INSERT INTO comment VALUES (3, 0, 0, 0, 2, '1', '�ԾĦn�Ǽ��ߤ��q');
INSERT INTO comment VALUES (4, 0, 0, 0, 2, '1', '���۩Mħ��u�ճW');
INSERT INTO comment VALUES (5, 0, 0, 0, 2, '1', '�V�O�����`�W�Яx');
INSERT INTO comment VALUES (6, 0, 0, 0, 2, '1', '���ߤ��q�~��ݥ�');
INSERT INTO comment VALUES (7, 0, 0, 0, 2, '1', '�~��ݥ��Ƿ~�u�}');
INSERT INTO comment VALUES (8, 0, 0, 0, 2, '1', '�ԫj���Ӵ`�W�Яx');
INSERT INTO comment VALUES (9, 0, 0, 0, 2, '1', '�Ӥ��W�i�~�w�u�}');
INSERT INTO comment VALUES (10, 0, 0, 0, 2, '1', '�A�ȼ���Ū�ѻ{�u');
INSERT INTO comment VALUES (11, 0, 0, 0, 2, '1', '�Y�u�ճW�欰���I');
INSERT INTO comment VALUES (12, 0, 0, 0, 2, '1', '�M�ߦV�ǿw��u��');
INSERT INTO comment VALUES (13, 0, 0, 0, 2, '1', '�W�C�e�T�~�ǭ��u');
INSERT INTO comment VALUES (14, 0, 0, 0, 2, '1', '����y�N�����w��');
INSERT INTO comment VALUES (15, 0, 0, 0, 2, '1', '�����u�ԾĦn��');
INSERT INTO comment VALUES (16, 0, 0, 0, 2, '1', '���ߪA�Ȧu�W�{�u');
INSERT INTO comment VALUES (17, 0, 0, 0, 2, '1', '�V�O�i���~���u�}');
INSERT INTO comment VALUES (18, 0, 0, 0, 2, '1', '�n�Ǥ��¼䨭�۷R');
INSERT INTO comment VALUES (19, 0, 0, 0, 2, '1', '�ͷR�P�Ǽ��ߤ��q');
INSERT INTO comment VALUES (20, 0, 0, 0, 2, '1', '�ͬ��W�߶ԱӦV��');
INSERT INTO comment VALUES (21, 0, 0, 0, 2, '1', '�B�ƶԱөʱ��M��');
INSERT INTO comment VALUES (22, 0, 0, 0, 2, '1', '���H�y�N�Ǧ槡�u');
INSERT INTO comment VALUES (23, 0, 0, 0, 2, '1', '�~�ǭ��u���ߤ���');
INSERT INTO comment VALUES (24, 0, 0, 0, 2, '1', '�Ƿ~�u�}�~��ݤ�');
INSERT INTO comment VALUES (25, 0, 0, 0, 2, '1', '�Ӧ���Ÿ������');
INSERT INTO comment VALUES (26, 0, 0, 0, 2, '1', '������§�Z�ժ��n');
INSERT INTO comment VALUES (27, 0, 0, 0, 2, '1', '�欰�}�n��Q�¥�');
INSERT INTO comment VALUES (28, 0, 0, 0, 2, '1', '���Ʊӱ��ʱ��Ũ}');
INSERT INTO comment VALUES (29, 0, 0, 0, 2, '1', '�ˤv���s���ߤ��q');
INSERT INTO comment VALUES (30, 0, 0, 0, 2, '1', '�ҷ~�{�u����i��');
INSERT INTO comment VALUES (31, 0, 0, 0, 2, '1', '���ߤ��q��W�@��');
INSERT INTO comment VALUES (32, 0, 0, 0, 2, '1', '�ݤH�M��~�ǭ��u');
INSERT INTO comment VALUES (33, 0, 0, 0, 2, '1', '�Ӧ�¼䩾�p�Թ�');
INSERT INTO comment VALUES (34, 0, 0, 0, 2, '1', '�`���۷R�I�R�{�u');
INSERT INTO comment VALUES (35, 0, 0, 0, 2, '1', '�ߩꤣ���I���q�P');
INSERT INTO comment VALUES (36, 0, 0, 0, 2, '1', '�u�@�V�O���e���');
INSERT INTO comment VALUES (37, 0, 0, 0, 2, '1', '�欰�ݲ���Q�¥�');
INSERT INTO comment VALUES (38, 0, 0, 0, 2, '1', '�I�Y�i���V�O�D��');
INSERT INTO comment VALUES (39, 0, 0, 0, 2, '1', '���L�Y��ܵ��T��');
INSERT INTO comment VALUES (40, 0, 0, 0, 2, '1', '�M�ӦV�Ǧ欰�ݥ�');
INSERT INTO comment VALUES (41, 0, 0, 0, 2, '1', '�M�ߦV���Y�w�u��');
INSERT INTO comment VALUES (42, 0, 0, 0, 2, '1', '�~�ǭ��u���߬���');
INSERT INTO comment VALUES (43, 0, 0, 0, 2, '1', '������§�o���Mħ');
INSERT INTO comment VALUES (44, 0, 0, 0, 2, '1', '�������¶ԾǦu�W');
INSERT INTO comment VALUES (45, 0, 0, 0, 2, '1', '§���P��믫���@');
INSERT INTO comment VALUES (46, 0, 0, 0, 2, '1', '�®𽴫k�@������');
INSERT INTO comment VALUES (47, 0, 0, 0, 2, '1', '���_�ݤH�A�ȼ���');
INSERT INTO comment VALUES (48, 0, 0, 0, 2, '1', '�ѩʵ��}���p�¾�');
INSERT INTO comment VALUES (49, 0, 0, 0, 2, '1', '�o���D�W��ݲn��');
INSERT INTO comment VALUES (50, 0, 0, 0, 2, '1', '�V�O�i���~���u�}');
INSERT INTO comment VALUES (51, 0, 0, 0, 2, '1', '�J�v�U�H�u�W�Ծ�');
INSERT INTO comment VALUES (52, 0, 0, 0, 2, '1', '���۩Mħ��u�ճW');
INSERT INTO comment VALUES (53, 0, 0, 0, 2, '1', '�B�ƶԱөʱ��M��');
INSERT INTO comment VALUES (54, 0, 0, 0, 2, '1', '�O�Ǥ��¶Ը�í��');
INSERT INTO comment VALUES (55, 0, 0, 0, 2, '1', '���d���P�A�ȼ���');
INSERT INTO comment VALUES (56, 0, 0, 0, 2, '1', '�ԫj���Ӵ`�W�Яx');
INSERT INTO comment VALUES (57, 0, 0, 0, 2, '1', '����ˤ��¾���');
INSERT INTO comment VALUES (58, 0, 0, 0, 2, '1', '����y�N�Ӥ��W�i');
INSERT INTO comment VALUES (59, 0, 0, 0, 2, '1', '�Ӧ���Ŭ���i��');
INSERT INTO comment VALUES (60, 0, 0, 0, 2, '1', '���������W�n��');
INSERT INTO comment VALUES (61, 0, 0, 0, 2, '1', '�A�ȼ��߷q�~�ָs');
INSERT INTO comment VALUES (62, 0, 0, 0, 2, '1', '�~�ǶW�s��t�a��');
INSERT INTO comment VALUES (63, 0, 0, 0, 2, '1', '�`���۷R�I�R�{�u');
INSERT INTO comment VALUES (64, 0, 0, 0, 2, '1', '���M��§�~�ǭ��u');
INSERT INTO comment VALUES (65, 0, 0, 0, 2, '1', '�M�ߦV�Ǹۿw�u��');
INSERT INTO comment VALUES (66, 0, 0, 0, 2, '1', '�~�ǭ��u���߬���');
INSERT INTO comment VALUES (67, 0, 0, 0, 2, '1', '�ԫj�������ߤ���');
INSERT INTO comment VALUES (68, 0, 0, 0, 2, '1', '������§�o���Mħ');
INSERT INTO comment VALUES (69, 0, 0, 0, 2, '1', '�������¶ԾǦu�W');
INSERT INTO comment VALUES (70, 0, 0, 0, 2, '1', '�ˤv���s���ߤ��q');
INSERT INTO comment VALUES (71, 0, 0, 0, 2, '1', '���d���ߴI���q�P');
INSERT INTO comment VALUES (72, 0, 0, 0, 2, '1', '���ߪA�Ȧu�W�{�u');
INSERT INTO comment VALUES (73, 0, 0, 0, 2, '1', '���ҥ���Z�կ¸�');
INSERT INTO comment VALUES (74, 0, 0, 0, 2, '1', '�O�ϤW�i��Ӷg��');
INSERT INTO comment VALUES (75, 0, 0, 0, 2, '1', '�u�@�{�u�~�ǭ��u');
INSERT INTO comment VALUES (76, 0, 0, 0, 2, '1', '�i��t�d�~�ǭ��u');
INSERT INTO comment VALUES (77, 0, 0, 0, 2, '1', '�欰�ݲ���Q�¥�');
INSERT INTO comment VALUES (78, 0, 0, 0, 2, '1', '���L�Y��ܵ��T��');
INSERT INTO comment VALUES (79, 0, 0, 0, 2, '1', '���������W�n��');
INSERT INTO comment VALUES (80, 0, 0, 0, 2, '1', '�X�s�u�k��������');
INSERT INTO comment VALUES (81, 0, 0, 0, 2, '1', '�I�Y�i���V�O�D��');
INSERT INTO comment VALUES (82, 0, 0, 0, 2, '1', '�M�ӦV�Ǧ欰�ݥ�');
INSERT INTO comment VALUES (83, 0, 0, 0, 2, '1', '�Ӧ���Ÿ������');
INSERT INTO comment VALUES (84, 0, 0, 0, 2, '1', '��u�ճW��W���y');
INSERT INTO comment VALUES (85, 0, 0, 0, 2, '1', '�۰ʦ۵o�ԫj�V�W');
INSERT INTO comment VALUES (86, 0, 0, 0, 2, '1', '�ʱ��ũM�A�ȶԳ�');
INSERT INTO comment VALUES (87, 0, 0, 0, 2, '1', '�ժ����۾īj���y');
INSERT INTO comment VALUES (88, 0, 0, 0, 2, '1', '���ߤ��q��߾ǲ�');
INSERT INTO comment VALUES (89, 0, 0, 0, 2, '1', '�q�~�ָs�l�l��§');
INSERT INTO comment VALUES (90, 0, 0, 0, 2, '1', '�t�d��¾�����īj');
INSERT INTO comment VALUES (91, 0, 0, 0, 2, '1', '�ԱӦn�Ǫéʯ«p');
INSERT INTO comment VALUES (92, 0, 0, 0, 2, '1', '�ݲ��ۿw�ũM�_�R');
INSERT INTO comment VALUES (93, 0, 0, 0, 2, '1', '�`�W�Яx���~�y��');
INSERT INTO comment VALUES (94, 0, 0, 0, 2, '1', '���U�X�@�Ԩ��V��');
INSERT INTO comment VALUES (95, 0, 0, 0, 2, '1', '�o�o�ԱӤѯu�w��');
INSERT INTO comment VALUES (96, 0, 0, 0, 2, '1', '��W���y�A�ȼ���');
INSERT INTO comment VALUES (97, 0, 0, 0, 2, '1', '�O���W��V�O����');
INSERT INTO comment VALUES (98, 0, 0, 0, 2, '1', '�I�i���ߩ|���۷R');
INSERT INTO comment VALUES (99, 0, 0, 0, 2, '1', '�J��¾�u����F�m');
INSERT INTO comment VALUES (100, 0, 0, 0, 2, '1', '���ҥ��褬�U�X�@');
INSERT INTO comment VALUES (101, 0, 0, 0, 2, '1', '�u�������~��ݲ�');
INSERT INTO comment VALUES (102, 0, 0, 0, 2, '1', '�`������W���y');
INSERT INTO comment VALUES (103, 0, 0, 0, 2, '1', '�өʬ�����o��');
INSERT INTO comment VALUES (105, 0, 0, 0, 2, '1', '�|��w�Ժݲ�����');
INSERT INTO comment VALUES (106, 0, 0, 0, 2, '1', '�ԾǤ��²����j��');
INSERT INTO comment VALUES (107, 0, 0, 0, 2, '1', '�t�W��§���p����');
INSERT INTO comment VALUES (108, 0, 0, 0, 2, '1', '�o���j������Z�v');
INSERT INTO comment VALUES (109, 0, 0, 0, 2, '1', '�᪾�i���ǲ߱M��');
INSERT INTO comment VALUES (110, 0, 0, 0, 2, '1', '�䨭�۷R�w���u�v');
INSERT INTO comment VALUES (111, 0, 0, 0, 2, '1', '�ા�۷R�u���X�s');
INSERT INTO comment VALUES (112, 0, 0, 0, 2, '1', '�I�R���y�۹�¾�');
INSERT INTO comment VALUES (113, 0, 0, 0, 2, '1', '���e���۫j���y');
INSERT INTO comment VALUES (114, 0, 0, 0, 2, '1', '��ݨI�ۻ��e�ݲ�');
INSERT INTO comment VALUES (115, 0, 0, 0, 2, '1', '�u�k�����J��¾�d');
INSERT INTO comment VALUES (116, 0, 0, 0, 2, '1', '�۰ʦ�ı�u�k����');
INSERT INTO comment VALUES (117, 0, 0, 0, 2, '1', '��װ��|�Ť庸��');
INSERT INTO comment VALUES (118, 0, 0, 0, 2, '1', '������§�A���Y��');
INSERT INTO comment VALUES (119, 0, 0, 0, 2, '1', '�ݤH�Mħ�����ӱ�');
INSERT INTO comment VALUES (120, 0, 0, 0, 2, '1', '�V�O���ӷũM�¾�');
INSERT INTO comment VALUES (121, 0, 0, 0, 2, '1', '�i��U�H���p�۹�');
INSERT INTO comment VALUES (122, 0, 0, 0, 2, '1', '���p�۹�I�q�訥');
INSERT INTO comment VALUES (123, 0, 0, 0, 2, '1', '�ԾĤ��ӻ᪾�i��');
INSERT INTO comment VALUES (124, 0, 0, 0, 2, '1', '�O�D�W�i���R�j��');
INSERT INTO comment VALUES (125, 0, 0, 0, 2, '1', '�µ��i�R���[�X�s');
INSERT INTO comment VALUES (126, 0, 0, 0, 2, '1', '�D���ߤ������o��');
INSERT INTO comment VALUES (127, 0, 0, 0, 2, '1', '�A�ȶԫj���ߤ��q');
INSERT INTO comment VALUES (128, 0, 0, 0, 2, '1', '��ݪG�M�i��t�d');
INSERT INTO comment VALUES (129, 0, 0, 0, 2, '1', '�`�W�Яx�éʯ«p');
INSERT INTO comment VALUES (130, 0, 0, 0, 2, '1', '�֩�U�H���ߪA��');
INSERT INTO comment VALUES (131, 0, 0, 0, 2, '1', '�O�Ǥ������M��§');
INSERT INTO comment VALUES (132, 0, 0, 0, 2, '1', '�w��@�Ҧw���u�v');
INSERT INTO comment VALUES (133, 0, 0, 0, 2, '2', '�|���{�u�Ԩ��V��');
INSERT INTO comment VALUES (134, 0, 0, 0, 2, '2', '�|���V�O�Z�ո���');
INSERT INTO comment VALUES (135, 0, 0, 0, 2, '2', '�|�־ǲߦu���۪v');
INSERT INTO comment VALUES (136, 0, 0, 0, 2, '2', '���p�������pí��');
INSERT INTO comment VALUES (137, 0, 0, 0, 2, '2', '�u���ǷR���');
INSERT INTO comment VALUES (138, 0, 0, 0, 2, '2', '�ҷ~�����~��ݥ�');
INSERT INTO comment VALUES (139, 0, 0, 0, 2, '2', '�Ƿ~��Ϋ�Q�¥�');
INSERT INTO comment VALUES (140, 0, 0, 0, 2, '2', '�窾�{�u������§');
INSERT INTO comment VALUES (141, 0, 0, 0, 2, '2', '��߾ǲߦw���u��');
INSERT INTO comment VALUES (142, 0, 0, 0, 2, '2', '�I�q�訥�u�W�n��');
INSERT INTO comment VALUES (143, 0, 0, 0, 2, '2', '§���P��A�ȧV�O');
INSERT INTO comment VALUES (144, 0, 0, 0, 2, '2', '�Ƿ~�|�Φw���u�v');
INSERT INTO comment VALUES (145, 0, 0, 0, 2, '2', '�|��X�s�Ԩ��V��');
INSERT INTO comment VALUES (146, 0, 0, 0, 2, '2', '�ǲ߻{�u�ʱ��ũM');
INSERT INTO comment VALUES (147, 0, 0, 0, 2, '2', '�A�ȼ���§���P��');
INSERT INTO comment VALUES (148, 0, 0, 0, 2, '2', '�ݤH��§���ʬy�Q');
INSERT INTO comment VALUES (149, 0, 0, 0, 2, '2', '�|���Τ߫�Q�¥�');
INSERT INTO comment VALUES (150, 0, 0, 0, 2, '2', '�A�ȼ��ߩ|���Ծ�');
INSERT INTO comment VALUES (151, 0, 0, 0, 2, '2', '�|��X�s�`�W�Яx');
INSERT INTO comment VALUES (152, 0, 0, 0, 2, '2', '���L���ᦳ�{��');
INSERT INTO comment VALUES (153, 0, 0, 0, 2, '2', '�~�ǩ|�Ϊ�§�u�k');
INSERT INTO comment VALUES (154, 0, 0, 0, 2, '2', '�����{�u���z��');
INSERT INTO comment VALUES (155, 0, 0, 0, 2, '2', '�Ƿ~�|�μ֩�U�H');
INSERT INTO comment VALUES (156, 0, 0, 0, 2, '2', '�Ƿ~�|����氷��');
INSERT INTO comment VALUES (157, 0, 0, 0, 2, '2', '��ݶi���ǲߩ|��');
INSERT INTO comment VALUES (158, 0, 0, 0, 2, '2', '���Ѥj�驾�pí��');
INSERT INTO comment VALUES (159, 0, 0, 0, 2, '2', '�ǲߵ�߫~��ݥ�');
INSERT INTO comment VALUES (160, 0, 0, 0, 2, '2', '���H�y�N����¥�');
INSERT INTO comment VALUES (161, 0, 0, 0, 2, '2', '�|���V�O���Ԧۦu');
INSERT INTO comment VALUES (162, 0, 0, 0, 2, '2', '�J�Ƽ��[�I�ۧV�O');
INSERT INTO comment VALUES (163, 0, 0, 0, 2, '2', '�|���īj�ԳҧJ�W');
INSERT INTO comment VALUES (164, 0, 0, 0, 2, '2', '�|��ߤv�ʱ��ϱj');
INSERT INTO comment VALUES (165, 0, 0, 0, 2, '2', '�y��Ծĩʱ��O�u');
INSERT INTO comment VALUES (166, 0, 0, 0, 2, '2', '�|���ԾĪéʩ���');
INSERT INTO comment VALUES (167, 0, 0, 0, 2, '2', '�y����I�R�n��');
INSERT INTO comment VALUES (168, 0, 0, 0, 2, '2', '�|�Ԥ_�Ǽ��ߤ��q');
INSERT INTO comment VALUES (169, 0, 0, 0, 2, '2', '�Ǧ�|����氷��');
INSERT INTO comment VALUES (170, 0, 0, 0, 2, '2', '�ǲ߻{�u�ʱ��ũM');
INSERT INTO comment VALUES (171, 0, 0, 0, 2, '2', '�H�J�Ӧw�ʱ��M��');
INSERT INTO comment VALUES (172, 0, 0, 0, 2, '2', '�|���V�O�w���u�v');
INSERT INTO comment VALUES (173, 0, 0, 0, 2, '2', '�窾�X�s�Ի��u�W');
INSERT INTO comment VALUES (174, 0, 0, 0, 2, '2', '�ԩ�ǲ߼��ߤ���');
INSERT INTO comment VALUES (176, 0, 0, 0, 2, '2', '�|���{�u�u�k��§');
INSERT INTO comment VALUES (177, 0, 0, 0, 2, '2', '�׾i�y�t�ʱ����v');
INSERT INTO comment VALUES (178, 0, 0, 0, 2, '2', '�֩�U�H�u�@�t�d');
INSERT INTO comment VALUES (179, 0, 0, 0, 2, '2', '�Ƿ~�|�Φw���u�x');
INSERT INTO comment VALUES (180, 0, 0, 0, 2, '2', '����n���Ի��V��');
INSERT INTO comment VALUES (181, 0, 0, 0, 2, '2', '�|���V�O���e�ۦu');
INSERT INTO comment VALUES (182, 0, 0, 0, 2, '2', '��ݶi���Ǧ�|��');
INSERT INTO comment VALUES (183, 0, 0, 0, 2, '2', '��u�ճW�w���u�v');
INSERT INTO comment VALUES (184, 0, 0, 0, 2, '2', '���H�y�N��Q�¥�');
INSERT INTO comment VALUES (185, 0, 0, 0, 2, '2', '�A�ȼ���§���P��');
INSERT INTO comment VALUES (186, 0, 0, 0, 2, '2', '�׾i�y�t�ʱ����v');
INSERT INTO comment VALUES (187, 0, 0, 0, 2, '2', '�Ƿ~�����|��ճW');
INSERT INTO comment VALUES (188, 0, 0, 0, 2, '2', '���Ѥj�驾�pí��');
INSERT INTO comment VALUES (189, 0, 0, 0, 2, '2', '�|��t�d�ʱ��ϱj');
INSERT INTO comment VALUES (190, 0, 0, 0, 2, '2', '�|��t�d���ߤ���');
INSERT INTO comment VALUES (191, 0, 0, 0, 2, '2', '��߾ǲߦw���u�v');
INSERT INTO comment VALUES (192, 0, 0, 0, 2, '2', '�y��Ծĩʱ��O�u');
INSERT INTO comment VALUES (193, 0, 0, 0, 2, '2', '�ݤH��§�éʷũM');
INSERT INTO comment VALUES (194, 0, 0, 0, 2, '2', '�|�ԩ�Ƿq�R�v��');
INSERT INTO comment VALUES (195, 0, 0, 0, 2, '2', '�ԩ�ǲ߼��ߤ���');
INSERT INTO comment VALUES (196, 0, 0, 0, 2, '2', '�|���{�u�Ԩ��V��');
INSERT INTO comment VALUES (197, 0, 0, 0, 2, '2', '�|���ԾǦu���۪v');
INSERT INTO comment VALUES (198, 0, 0, 0, 2, '2', '�|���īj�ԳҨ�W');
INSERT INTO comment VALUES (199, 0, 0, 0, 2, '2', '�|���ԾĪéʩ���');
INSERT INTO comment VALUES (200, 0, 0, 0, 2, '2', '����n���Ի��V��');
INSERT INTO comment VALUES (201, 0, 0, 0, 2, '2', '�J�Ƽ��[�I�ۧV�O');
INSERT INTO comment VALUES (202, 0, 0, 0, 2, '2', '�W���䨭�u�W�{�u');
INSERT INTO comment VALUES (203, 0, 0, 0, 2, '2', '��襭�e�u�v�ָs');
INSERT INTO comment VALUES (204, 0, 0, 0, 2, '2', '�Ƿ~�|��������§');
INSERT INTO comment VALUES (205, 0, 0, 0, 2, '2', '�u���ǷR���');
INSERT INTO comment VALUES (206, 0, 0, 0, 2, '2', '�|���n�Ƿq�ͼָs');
INSERT INTO comment VALUES (207, 0, 0, 0, 2, '2', '�Ƿ~�|�μ֩�U�H');
INSERT INTO comment VALUES (208, 0, 0, 0, 2, '2', '�����{�u���Ӽz');
INSERT INTO comment VALUES (209, 0, 0, 0, 2, '2', '�Ƿ~�����~�|�ݥ�');
INSERT INTO comment VALUES (210, 0, 0, 0, 2, '2', '�Ƿ~��Ϋ�Q�¥�');
INSERT INTO comment VALUES (211, 0, 0, 0, 2, '2', '�ԩ�Ƿ~�Z�ո���');
INSERT INTO comment VALUES (212, 0, 0, 0, 2, '2', '�I�q�訥�u�W�Ծ�');
INSERT INTO comment VALUES (213, 0, 0, 0, 2, '2', '�|���ĵo�Գҭt�d');
INSERT INTO comment VALUES (214, 0, 0, 0, 2, '2', '���U�X�s�Ծ�u�W');
INSERT INTO comment VALUES (215, 0, 0, 0, 2, '2', '�|���V�O�u�k��§');
INSERT INTO comment VALUES (216, 0, 0, 0, 2, '2', '�ݤH��§�ѯu����');
INSERT INTO comment VALUES (217, 0, 0, 0, 2, '2', '���[�n�ʨD�Ǥ��O');
INSERT INTO comment VALUES (218, 0, 0, 0, 2, '2', '�I�۰�w�|��۪v');
INSERT INTO comment VALUES (219, 0, 0, 0, 2, '2', '�{�u�����g���n��');
INSERT INTO comment VALUES (220, 0, 0, 0, 2, '2', '�ᦳ�z���i���L');
INSERT INTO comment VALUES (221, 0, 0, 0, 2, '2', '�R�n���ʭ誽����');
INSERT INTO comment VALUES (222, 0, 0, 0, 2, '2', '�y���B�ʼ䨭�۷R');
INSERT INTO comment VALUES (223, 0, 0, 0, 2, '2', '�ʥF�۪v������w');
INSERT INTO comment VALUES (224, 0, 0, 0, 2, '2', '�|�������N�Ӥ��M');
INSERT INTO comment VALUES (225, 0, 0, 0, 2, '2', '�|���i���ѯu����');
INSERT INTO comment VALUES (226, 0, 0, 0, 2, '2', '�᪾�i������X�s');
INSERT INTO comment VALUES (227, 0, 0, 0, 2, '2', '�y����I�R�n��');
INSERT INTO comment VALUES (228, 0, 0, 0, 2, '2', '�~�ǩ|�Ϊ�§�u�k');
INSERT INTO comment VALUES (229, 0, 0, 0, 2, '2', '�|���{�u�ߤѸ�y�t');
INSERT INTO comment VALUES (230, 0, 0, 0, 2, '2', '�~�w�P�Ƿ~���e�i�B');
INSERT INTO comment VALUES (231, 0, 0, 0, 2, '2', '�ʱ��n�������M�߽ҷ~');
INSERT INTO comment VALUES (232, 0, 0, 0, 2, '2', '�Ƿ~�|�i�������V��');
INSERT INTO comment VALUES (233, 0, 0, 0, 2, '2', '�|���{�u�ʥF�X�@�믫');
INSERT INTO comment VALUES (234, 0, 0, 0, 2, '2', '�Ƿ~�|�α���ʤ��K');
INSERT INTO comment VALUES (235, 0, 0, 0, 2, '2', '�|���{�u���Ѹ���t');
INSERT INTO comment VALUES (236, 0, 0, 0, 2, '2', '�V�O�������z���l');
INSERT INTO comment VALUES (237, 0, 0, 0, 2, '2', '�����P���I�q�訥');
INSERT INTO comment VALUES (238, 0, 0, 0, 2, '2', '�ʦn�^���۪����I');
INSERT INTO comment VALUES (239, 0, 0, 0, 2, '2', '�|���īj�ʱ��誽');
INSERT INTO comment VALUES (240, 0, 0, 0, 2, '3', '�欰���˥ͬ���');
INSERT INTO comment VALUES (241, 0, 0, 0, 2, '3', '�欰���˼ҽk���M');
INSERT INTO comment VALUES (242, 0, 0, 0, 2, '3', '���t�d�����Ӽŭl');
INSERT INTO comment VALUES (243, 0, 0, 0, 2, '3', '���Z��Τ����V�O');
INSERT INTO comment VALUES (244, 0, 0, 0, 2, '3', '���D�W�i�ʱ��x�H');
INSERT INTO comment VALUES (245, 0, 0, 0, 2, '3', '�����ĵo�i�k����');
INSERT INTO comment VALUES (246, 0, 0, 0, 2, '3', '�������@�믫����');
INSERT INTO comment VALUES (247, 0, 0, 0, 2, '3', '�{�פ��t�����V�O');
INSERT INTO comment VALUES (248, 0, 0, 0, 2, '3', '�����V�O�欰�H�K');
INSERT INTO comment VALUES (249, 0, 0, 0, 2, '3', '������C�W���䨭');
INSERT INTO comment VALUES (250, 0, 0, 0, 2, '3', '���D�W�i�N���Z��');
INSERT INTO comment VALUES (251, 0, 0, 0, 2, '3', '�����V�O��襭�e');
INSERT INTO comment VALUES (252, 0, 0, 0, 2, '3', '���l�L�צ��߾ǲ�');
INSERT INTO comment VALUES (253, 0, 0, 0, 2, '3', '�Ƿ~��������I�z');
INSERT INTO comment VALUES (254, 0, 0, 0, 2, '3', '���椣�@���p����');
INSERT INTO comment VALUES (255, 0, 0, 0, 2, '3', '�����{�u�������');
INSERT INTO comment VALUES (256, 0, 0, 0, 2, '3', '���椣�Ż{�Ѥ��M');
INSERT INTO comment VALUES (257, 0, 0, 0, 2, '3', '�y�[���I����H�K');
INSERT INTO comment VALUES (258, 0, 0, 0, 2, '3', '�����ݤH���ѩ|��');
INSERT INTO comment VALUES (259, 0, 0, 0, 2, '3', '�������s�ʱ��t��');
INSERT INTO comment VALUES (260, 0, 0, 0, 2, '3', '�Ǥ��w�ߩʱ��Bļ');
INSERT INTO comment VALUES (261, 0, 0, 0, 2, '3', '�����X�s����ʳ�');
INSERT INTO comment VALUES (262, 0, 0, 0, 2, '3', '�L���w�ߨ��Q�Ѹq');
INSERT INTO comment VALUES (263, 0, 0, 0, 2, '3', '�����r���p�L���');
INSERT INTO comment VALUES (264, 0, 0, 0, 2, '3', '�d�[�����A�ˤ���');
INSERT INTO comment VALUES (265, 0, 0, 0, 2, '3', '��ť�л��T���۫H');
INSERT INTO comment VALUES (266, 0, 0, 0, 2, '3', '�L�߻{�u�믫�A��');
INSERT INTO comment VALUES (267, 0, 0, 0, 2, '3', '�@�L���i���^���H');
INSERT INTO comment VALUES (268, 0, 0, 0, 2, '3', '�o�L�B�L�A�B���w');
INSERT INTO comment VALUES (269, 0, 0, 0, 2, '3', '�������i�i�k����');
INSERT INTO comment VALUES (270, 0, 0, 0, 2, '3', '���еL�`�N�Ӥ���');
INSERT INTO comment VALUES (271, 0, 0, 0, 2, '3', '�@�L�i�B�{�קC�H');
INSERT INTO comment VALUES (272, 0, 0, 0, 2, '3', '§�`���g�����P��');
INSERT INTO comment VALUES (273, 0, 0, 0, 2, '3', '�L�P���ߩ��a�ֺ�');
INSERT INTO comment VALUES (274, 0, 0, 0, 2, '3', '�������@�Ǯ�I�I');
INSERT INTO comment VALUES (275, 0, 0, 0, 2, '3', '�Ƿ~��ι�ǮճW');
INSERT INTO comment VALUES (276, 0, 0, 0, 2, '3', '�����V�O�i�k�');
INSERT INTO comment VALUES (277, 0, 0, 0, 2, '3', '�ɾǮɽ��@�ɤQ�H');
INSERT INTO comment VALUES (278, 0, 0, 0, 2, '3', '�欰�����N���Z��');
INSERT INTO comment VALUES (279, 0, 0, 0, 2, '3', '���M�ҷ~�ߦ��~��');
INSERT INTO comment VALUES (280, 0, 0, 0, 2, '3', '�������@�H�߳ॢ');
INSERT INTO comment VALUES (281, 0, 0, 0, 2, '3', '�L���w�ߦۨp�ۧQ');
INSERT INTO comment VALUES (282, 0, 0, 0, 2, '3', '���D�W�i��������');
INSERT INTO comment VALUES (283, 0, 0, 0, 2, '3', '���t�d���i�k�ŭl');
INSERT INTO comment VALUES (284, 0, 0, 0, 2, '3', '�j�����I�|���V�O');
INSERT INTO comment VALUES (285, 0, 0, 0, 2, '3', '���õL���i�k����');
INSERT INTO comment VALUES (286, 0, 0, 0, 2, '3', '�����л��V�d�v��');
INSERT INTO comment VALUES (287, 0, 0, 0, 2, '3', '�ҷ~��R�ݤp��');
INSERT INTO comment VALUES (288, 0, 0, 0, 2, '3', '���D�i�q�欰�ۨp');
INSERT INTO comment VALUES (289, 0, 0, 0, 2, '3', '���������Ǥp��');
INSERT INTO comment VALUES (290, 0, 0, 0, 2, '3', '�o�L�B�L�����{�u');
INSERT INTO comment VALUES (291, 0, 0, 0, 2, '3', '�Ƿ~�h�B�믫����');
INSERT INTO comment VALUES (292, 0, 0, 0, 2, '3', '�����V�O�欰�H�K');
INSERT INTO comment VALUES (293, 0, 0, 0, 2, '3', '���D�W�i�믫����');
INSERT INTO comment VALUES (294, 0, 0, 0, 2, '3', '�ߦ��G�Τ��u�W�h');
INSERT INTO comment VALUES (295, 0, 0, 0, 2, '3', '�|�ݱҵo�Ѹ��w');
INSERT INTO comment VALUES (296, 0, 0, 0, 2, '3', '�ǲߤ��M�믫����');
INSERT INTO comment VALUES (297, 0, 0, 0, 2, '3', '���l�L�ץΤߤ��M');
INSERT INTO comment VALUES (298, 0, 0, 0, 2, '3', 'Ū�Ѥ��M�ߤ�I�R');
INSERT INTO comment VALUES (299, 0, 0, 0, 2, '3', '�����X�s�Ƿ~�|��');
INSERT INTO comment VALUES (300, 0, 0, 0, 2, '3', '��i���믫');
INSERT INTO comment VALUES (301, 0, 0, 0, 2, '3', '���D�ƸѥΤߤ��M');
INSERT INTO comment VALUES (302, 0, 0, 0, 2, '3', '�ҷ~�����|�u�W�x');
INSERT INTO comment VALUES (303, 0, 0, 0, 2, '3', '�B���{�u�Ѹ�©�');
INSERT INTO comment VALUES (304, 0, 0, 0, 2, '3', '���w��ǩʱ��Bļ');
INSERT INTO comment VALUES (305, 0, 0, 0, 2, '3', '���Z��Ωʱ��i�k');
INSERT INTO comment VALUES (306, 0, 0, 0, 2, '3', '�������˭өʭϱj');
INSERT INTO comment VALUES (307, 0, 0, 0, 2, '3', '�ҷ~������ŭl');
INSERT INTO comment VALUES (308, 0, 0, 0, 2, '3', '�ɥͪ����ʱ��x��');
INSERT INTO comment VALUES (309, 0, 0, 0, 2, '3', '�����{�u�믫�A��');
INSERT INTO comment VALUES (310, 0, 0, 0, 2, '3', '�ۥ̸��ᤣ���Ծ�');
INSERT INTO comment VALUES (311, 0, 0, 0, 2, '3', '���{�u�n�^��');
INSERT INTO comment VALUES (312, 0, 0, 0, 2, '3', '�ʱ��i�k�����U��');
INSERT INTO comment VALUES (313, 0, 0, 0, 2, '3', '�����۷R�ۨp�ۧQ');
INSERT INTO comment VALUES (314, 0, 0, 0, 2, '3', '�ʱ��ϱj�믫����');
INSERT INTO comment VALUES (315, 0, 0, 0, 2, '3', '�ŭl�����k�i��');
INSERT INTO comment VALUES (316, 0, 0, 0, 2, '3', '�Bļ�L��x�j�n��');
INSERT INTO comment VALUES (317, 0, 0, 0, 2, '3', '�Ǥ��M�ߥ~�ȤӦh');
INSERT INTO comment VALUES (318, 0, 0, 0, 2, '3', '�i�B�w�C�ʱ��M��');
INSERT INTO comment VALUES (319, 0, 0, 0, 2, '3', '�����˰Q�ɥǤp��');
INSERT INTO comment VALUES (320, 0, 0, 0, 2, '3', '���������ʱ����z');
INSERT INTO comment VALUES (321, 0, 0, 0, 2, '3', '������ڳB�ư���');
INSERT INTO comment VALUES (322, 0, 0, 0, 2, '3', '����W�i��軴�B');
INSERT INTO comment VALUES (323, 0, 0, 0, 2, '3', '�ҷ~����J�Ƽŭl');
INSERT INTO comment VALUES (324, 0, 0, 0, 2, '3', '�婿�Ƿ~�ʱ��n��');
INSERT INTO comment VALUES (325, 0, 0, 0, 2, '3', '���^���H��ť�W�U');
INSERT INTO comment VALUES (326, 0, 0, 0, 2, '3', '�ƺC�L§���D�W�i');
INSERT INTO comment VALUES (327, 0, 0, 0, 2, '3', '�ͬ����˵�B����');
INSERT INTO comment VALUES (328, 0, 0, 0, 2, '3', '�L�ߦV�ǵ�B�H�K');
INSERT INTO comment VALUES (329, 0, 0, 0, 2, '3', '���B�n�ʦ]�`����');
INSERT INTO comment VALUES (330, 0, 0, 0, 2, '3', '��|��Ѫ����갰');
INSERT INTO comment VALUES (331, 0, 0, 0, 2, '3', '�x�֦n�ʭөʩt��');
INSERT INTO comment VALUES (332, 0, 0, 0, 2, '3', '�A�׭жƩʱ��ʼ�');
INSERT INTO comment VALUES (333, 0, 0, 0, 2, '4', '����y�N�өʹx�H');
INSERT INTO comment VALUES (334, 0, 0, 0, 2, '4', '�}�a���ǵL�z���x');
INSERT INTO comment VALUES (335, 0, 0, 0, 2, '4', '���椣�Ťf�O�߫D');
INSERT INTO comment VALUES (336, 0, 0, 0, 2, '4', '��|��ǯ}�a�ճW');
INSERT INTO comment VALUES (337, 0, 0, 0, 2, '4', '���u�����n�i����');
INSERT INTO comment VALUES (338, 0, 0, 0, 2, '4', '�ۥ̼Z���i������');
INSERT INTO comment VALUES (339, 0, 0, 0, 2, '4', '�Ƿ~��H�~�w���');
INSERT INTO comment VALUES (340, 0, 0, 0, 2, '4', '���u�ճW�^���n�x');
INSERT INTO comment VALUES (341, 0, 0, 0, 2, '4', '��ǹL���欰�L��');
INSERT INTO comment VALUES (342, 0, 0, 0, 2, '4', '��|�����]�`��k');
INSERT INTO comment VALUES (343, 0, 0, 0, 2, '4', '�ȥ������Q�ջ~');
INSERT INTO comment VALUES (344, 0, 0, 0, 2, '4', '�����O�D�J�@�ì�');
INSERT INTO comment VALUES (345, 0, 0, 0, 2, '4', '�n�i�����өʭϱj');
INSERT INTO comment VALUES (346, 0, 0, 0, 2, '4', '���Ƚҷ~�m�ҥǳW');
INSERT INTO comment VALUES (347, 0, 0, 0, 2, '4', '�ƺC�L§�ʱ��Ļ�');
INSERT INTO comment VALUES (348, 0, 0, 0, 2, '4', '�A�����I�x�֦���');
INSERT INTO comment VALUES (349, 0, 0, 0, 2, '4', '�n�ƥͭ������Ծ�');
INSERT INTO comment VALUES (350, 0, 0, 0, 2, '4', '�����۷R�欰����');
INSERT INTO comment VALUES (351, 0, 0, 0, 2, '4', '���u���Ǻ믫�A��');
INSERT INTO comment VALUES (352, 0, 0, 0, 2, '4', '�����˧���v���B');
INSERT INTO comment VALUES (353, 0, 0, 0, 2, '4', '�ۼɦ۱�ıi�x�H');
INSERT INTO comment VALUES (354, 0, 0, 0, 2, '4', '�ɥǮճW��ť�V��');
INSERT INTO comment VALUES (355, 0, 0, 0, 2, '4', '��|��Ѫ�x�H����');
INSERT INTO comment VALUES (356, 0, 0, 0, 2, '4', '��������欰�ıi');
INSERT INTO comment VALUES (357, 0, 0, 0, 2, '4', '�Ǥ��M�ߤߩʯBļ');
INSERT INTO comment VALUES (358, 0, 0, 0, 2, '4', '�ʦ�x�H�l�H�Q�v');
INSERT INTO comment VALUES (359, 0, 0, 0, 2, '4', '�����W�i�éʹx�H');
INSERT INTO comment VALUES (360, 0, 0, 0, 2, '4', '�����{�u�ʱ��x�H');
INSERT INTO comment VALUES (361, 0, 0, 0, 2, '4', '���u§���A�׶ƺC');
INSERT INTO comment VALUES (362, 0, 0, 0, 2, '4', '�������@�Z���i�k');
INSERT INTO comment VALUES (363, 0, 0, 0, 2, '4', '���u�ճW�Z�ï���');
INSERT INTO comment VALUES (364, 0, 0, 0, 2, '4', '�믫�����ͬ�����');
INSERT INTO comment VALUES (365, 0, 0, 0, 2, '4', '�欰�񿺭өʾ��Z');
INSERT INTO comment VALUES (366, 0, 0, 0, 2, '4', '�믫�Z�o�ͬ�����');
INSERT INTO comment VALUES (367, 0, 0, 0, 2, '4', '�������逸�����');
INSERT INTO comment VALUES (368, 0, 0, 0, 2, '4', '�Ƿ~�����۶B');
INSERT INTO comment VALUES (369, 0, 0, 0, 2, '4', '�n�h�c�ұj���n�G');
INSERT INTO comment VALUES (370, 0, 0, 0, 2, '4', '�������w�믫����');
INSERT INTO comment VALUES (371, 0, 0, 0, 2, '4', '�h���g���믫����');
INSERT INTO comment VALUES (372, 0, 0, 0, 2, '4', '����X�s�өʩt��');
INSERT INTO comment VALUES (373, 0, 0, 0, 2, '4', '�����{�u�i�k����');
INSERT INTO comment VALUES (374, 0, 0, 0, 2, '4', '�ʥF���Ū�Ѥ��M');
INSERT INTO comment VALUES (375, 0, 0, 0, 2, '4', '��ť�V�|�ʱ���p');
INSERT INTO comment VALUES (376, 0, 0, 0, 2, '4', '�ҷ~��κ믫����');
INSERT INTO comment VALUES (377, 0, 0, 0, 2, '4', '�ͬ��P�Ӻ믫�Bļ');
INSERT INTO comment VALUES (378, 0, 0, 0, 2, '4', '�ʱ��ĩѨ����z');
INSERT INTO comment VALUES (379, 0, 0, 0, 2, '4', '�L��Ū���o�����l');
INSERT INTO comment VALUES (380, 0, 0, 0, 2, '4', '�ͬ���������p�`');
INSERT INTO comment VALUES (381, 0, 0, 0, 3, '1', '�����ӱ��A�|�@��ϤT�A��ܧ֪��i�J�U�ؾǲ߱��ҡA�ߦ��ɽk��`�`���١C');
INSERT INTO comment VALUES (382, 0, 0, 0, 3, '1', '�ʱ��w�p�A�ҷ~�w���i�B�A���L���ݧV�O�A�r���ݥ��A�n�n�n�m�ߡC');
INSERT INTO comment VALUES (383, 0, 0, 0, 3, '1', '�ѽᤣ���A�V�O�����A�Ʋz�譱��{���ΡA�y����t�A�ݭn�n�n�m�ߡC');
INSERT INTO comment VALUES (384, 0, 0, 0, 3, '1', '����n�ʡA�ʦp��ߡA�߫����w�R�U�ӡC�ҷ~�w���i�B�A�������ɥ��O�A�_�h��{�|��n�C');
INSERT INTO comment VALUES (385, 0, 0, 0, 3, '1', '�ө��Y�¡A���A�����F���L���Ʀ��I���v�A�V�O�����A�����`�`���H���ɡC');
INSERT INTO comment VALUES (386, 0, 0, 0, 3, '1', '���ʤO�����A���Τ�������O�A�����w�ߩw�ʡA�ǲߤw���i�B�C');
INSERT INTO comment VALUES (387, 0, 0, 0, 3, '1', '�ǲߺ��J�ιҡA���ܮe�����ߡA���ɮɥ[�H���ɡC');
INSERT INTO comment VALUES (388, 0, 0, 0, 3, '1', '�ʱ��v�u�B����A���������C�D�ǥ��ɥ��O�A�_�h������n����{�C');
INSERT INTO comment VALUES (389, 0, 0, 0, 3, '1', '�ѥͼ��[�A���ߤ��ȡA�֩�U�H�A�ߨD�ǥ��ɥ��O�A���A�V�O�C');
INSERT INTO comment VALUES (390, 0, 0, 0, 3, '1', '����j��A���Ʋʲv�A�ҷ~��{�ΡA���|���ŵo�i�~�O�}���A�y���i��L�譱������C');
INSERT INTO comment VALUES (391, 0, 0, 0, 3, '1', '�ө��w�p�A�����P�H���A�߰��Ƥ����J�ӡA�e�����ߡA�ݮɮɤ��H���ɡB���h�C');
INSERT INTO comment VALUES (392, 0, 0, 0, 3, '1', '�����ӱ��A�`���״I�A�o���O��j�A���D�ǺA�פ����{�u�B�J�ӡA�Ѹ����n�A�����a��ѧV�O�C');
INSERT INTO comment VALUES (393, 0, 0, 0, 3, '1', '�өʬ���j��A�ܷ|�o��ۤv���N���C�A�ȼ��ߡA�����I��ʤߤj�N�C');
INSERT INTO comment VALUES (394, 0, 0, 0, 3, '1', '�ѽᤣ���A�Y�A�[�W��Ѫ��V�O�A��{�@�w��n�F�u�O��㤣��A�ܷR���ܡA�n�`�`�����C');
INSERT INTO comment VALUES (395, 0, 0, 0, 3, '1', '����n�ʡA�ܷR���ܡA�P�ͦ�۳B�r�֡A���L�g�r�ӧ֡A�H�P���I���v�C');
INSERT INTO comment VALUES (396, 0, 0, 0, 3, '1', '����ӱ��A���ƶԧ֡A��}�W���A�D�ǻ�{�u�A�r��]�ܺݥ��C');
INSERT INTO comment VALUES (397, 0, 0, 0, 3, '1', '�Ѹꤣ�ӡA�S���֦n�n���V�O�A�򤣤W�P�Ǫ��i�סF���b�a����I�ӧO�����ɡA�~���W�i�סC');
INSERT INTO comment VALUES (398, 0, 0, 0, 3, '1', '����n�ʡA���ʶq��j�A�D�ǺA�פw���i�B�A�i�׺��J�ιҡA�߼g�r���M�����ݾ�  �C');
INSERT INTO comment VALUES (399, 0, 0, 0, 3, '1', '�����ӱ��A����x�����ҡA�D�ǻ{�u�A�r��ݾ�A�bø�e�譱��{��ΡC');
INSERT INTO comment VALUES (400, 0, 0, 0, 3, '1', '�ʱ��w�p�B�ѹ�A�b���@���X��������o���A���p���U�A�o�ܮe���P�H�����@���A�ݦh���i�o���i��C');
INSERT INTO comment VALUES (401, 0, 0, 0, 3, '1', '�D�ǻ{�u�A�A�׻�ΡA���ƥ禳�d���P�A�߰��FŪ�Ѥ��~�A�y�A���i��L�譱������C');
INSERT INTO comment VALUES (402, 0, 0, 0, 3, '1', '���p�ѹ�A�Q���w�p�A�ͩʼ��[�A���ߤ��@�A�ȡA�b�ҷ~�W���h���V�O�C');
INSERT INTO comment VALUES (403, 0, 0, 0, 3, '1', '�өʤw������B�n�ʡA�P�ͦ�۳B�Ĭ��A�D�ǺA�ץ�ΡC');
INSERT INTO comment VALUES (404, 0, 0, 0, 3, '1', '�ѯu�꺩�Q�H�ߡA���ƫܱM�`�A���e�����ߡA���l���סA�S�ܯ�x�����Ұ��A�ת���{�C');
INSERT INTO comment VALUES (405, 0, 0, 0, 3, '1', '�ө��H�M�A��ۤv���F������o�R���F�b�ҷ~�W�V�O�����A�y�A���ɡC');
INSERT INTO comment VALUES (406, 0, 0, 0, 3, '1', '�өʶ����A���������`�N�O�A�ݱ`�`�����B���ɤ~�|���Ҧ��C');
INSERT INTO comment VALUES (407, 0, 0, 0, 3, '1', '�өʬ���j��A�ߧV�O�����A�Y��w�ߩ�ҷ~�W�A���u�󦹡C');
INSERT INTO comment VALUES (408, 0, 0, 0, 3, '1', '����j��A��C�s��A�P�H��B�ͫܧ֡A�ҷ~�ᦳ�i�i�A�ȱo�ų\\�C');
INSERT INTO comment VALUES (409, 0, 0, 0, 3, '1', '���߼z��A�_���ŬX�A�ᦳ�j�a�Өq�����d�A�ҷ~��{��ΡA�i�׫~�ǭ��u�C');
INSERT INTO comment VALUES (410, 0, 0, 0, 3, '1', '�ѽᤣ���A�]��֧V�O�A��{�|�ΡA���H�M�֡A�ֻP�H��A�B���ߧU�H�A�ܱo�H�t�C');
INSERT INTO comment VALUES (411, 0, 0, 0, 3, '1', '�өʷũM�B���}�A�Ѹꤣ�ӡA�ݾa��Ѥ��_���V�O�A�~�i�঳�Ҧ��A���_�����`�έ@�ߪ����ɤ��O�ݭn���C');
INSERT INTO comment VALUES (412, 0, 0, 0, 3, '1', '�ʤߤj�N�A�`�`�k��A�Ѹ�Y�Τ��ӡA���a��Ѫ��V�O�B���_�����`�M�ӧO���ɡC');
INSERT INTO comment VALUES (413, 0, 0, 0, 3, '1', '�ѽ�ӱ��A����M���A�r��ݥ��A�ҷ~��{�ΡA�ܷ߫R���ܡA���`�`�����C');
INSERT INTO comment VALUES (414, 0, 0, 0, 3, '1', '�߫�ӱK�A���p�k�Ī��b�X�A�ҷ~��{��ΡA�ߦ��ɲʤߡA���n�`�������C');
INSERT INTO comment VALUES (415, 0, 0, 0, 3, '1', '�x�֦n�ʡA�Q���^��A���ʶq�ܤj�A�ҷ~���ɥ��O�A�g�r�]�ܯ�v�C');
INSERT INTO comment VALUES (416, 0, 0, 0, 3, '1', '�ǲߤw���J�ιҡA�ߤW�ҫܮe�����ߡA���`�`���H�����C');
INSERT INTO comment VALUES (417, 0, 0, 0, 3, '1', '�ʱ��ũM�A�����P�H���A�����@�N�b�������X��{�A�y�h���y�C');
INSERT INTO comment VALUES (418, 0, 0, 0, 3, '1', '�����ӱ��A�ҥ~���ѫ��״I�A���ʶq�ܤj�A�ߨD�ǺA�פ����{�u�A�y�A�[�H�޾ɡC');
INSERT INTO comment VALUES (419, 0, 0, 0, 3, '1', '�өʷŬX�A�_�����}�A���ƥJ�ӡA�D�ǻ{�u�A�i�׫~�ǭ��u�C');
INSERT INTO comment VALUES (420, 0, 0, 0, 3, '1', '�w�R�����A������ڡA�Ƿ~�w�i�B�A�ȱo�ų\\�C');
INSERT INTO comment VALUES (421, 0, 0, 0, 3, '1', '����n�ʡA�ܦ���t���B��ɼ��A�ߤ����J�ӡA�ʲv�o�i�R�C');
INSERT INTO comment VALUES (422, 0, 0, 0, 3, '1', '����ӱ��A�ܦ��D�ʨD�����믫�A���ƥJ�ӡA���H�M���C');
INSERT INTO comment VALUES (423, 0, 0, 0, 3, '1', '���|���ŵo�i�A����s�x�A�i�ׯ�ʯ��R�A���Q�H�߷R�C');
INSERT INTO comment VALUES (424, 0, 0, 0, 3, '1', '�ʷŰ��A���ӷR���ܡA�ǲߤw���i�B�A�������V�O�A��P�~�֪��p�ġA���|�ʪ��o�i������w�C');
INSERT INTO comment VALUES (425, 0, 0, 0, 3, '1', '�ߦa���}�A�ҷ~��{�|�ΡA��ܨ�Τߵ{�סA�߿��줣���s�x�A�y�h���i�C');
INSERT INTO comment VALUES (426, 0, 0, 0, 3, '1', '�ũM�}���A�өʲ۩��x�p�A�ǲߺ����i�B�A�~��V�O�C');
INSERT INTO comment VALUES (427, 0, 0, 0, 3, '1', '�ʱ��ũM�X���A�ҷ~�|�ΡA��ø�e�ܦ�����A�[��Q���ӱK�A�Y��[�H���i�A�����Ҧ��C');
INSERT INTO comment VALUES (428, 0, 0, 0, 3, '1', '�ũM�X���B�M��§�A�O�H�~�|���w����A�A�p�G�`�۫V�P�ǡA���A���B�ʹN�|�U�ӷU�֤F�C');
INSERT INTO comment VALUES (429, 0, 0, 0, 3, '1', '���_�x�֤��ߡA�M�ߩ�Ƿ~�A�W�Ҷ��M�ߡA�u�@���t�d�A�~���d�t����������I');
INSERT INTO comment VALUES (430, 0, 0, 0, 3, '1', '���Ԫ��ѯФ���A�����w�Y����ì�I������W�C�e�T�A�����Z��í�w�P�u�V�A���ҩp�O����O���A�A�V�O�a�I���֩p�U���p�@�C');
INSERT INTO comment VALUES (431, 0, 0, 0, 3, '1', '�ѯu�Z�v�A�u�@���ߡC�ҷ~���p��ӤߡB��Ū�A���i��ﵽ�A�@�p��|�O�椧�C');
INSERT INTO comment VALUES (432, 0, 0, 0, 3, '1', '�ƾǥu�n�h�ΤߡA�h��A�۫H�p�]�i�H�ұo�n�C');
INSERT INTO comment VALUES (433, 0, 0, 0, 3, '1', '�߶Ԥ~��ɩ�A�h��Ǯɶ��A��s�ƾǡA���i�i�B�C');
INSERT INTO comment VALUES (434, 0, 0, 0, 3, '1', '�ѯu�v���A�ԩ�o�ݡA�Ƿ~�𭸲r�i�A�@������H��A�N�Ӧb�D�Ǥ����W�A�������N�C');
INSERT INTO comment VALUES (435, 0, 0, 0, 3, '1', '౴@�G�Ѯv�h��Ʊ�p����h����ڡA�h�ݧڽҷ~�W�����D�A�n���D�A�ڬݨ�p�R�R�����R���ܡA�ڬO�h�����L�r�I');
INSERT INTO comment VALUES (436, 0, 0, 0, 3, '1', '����`�ȪѪ��A���P�ǪA�ȡA�u�@���W�A�@�L�訥�A�믫�i�šI�ƾǦ��Z�����i�B�A �����F�z�Q�A�����ҩp�w�I�X�F�V�O�C');
INSERT INTO comment VALUES (437, 0, 0, 0, 3, '1', '���R�ԫj�A���|���u�C�C��۰����U�Ѯv��z�ЫǡA�q���ӫ�A�ԳҺ믫�A�O�Ѯv�P�ʡI���S�A���©p�C');
INSERT INTO comment VALUES (438, 0, 0, 0, 3, '1', '�����?ԡA�����ҡA�@�h�o�����B�A�N�Ӥ~�঳�ҵo�i�C');
INSERT INTO comment VALUES (439, 0, 0, 0, 3, '1', '���[�M�s�A�t�d�ĥ��A�ҷ~�p��h��߫��s�A�w�|�i�B�C');
INSERT INTO comment VALUES (440, 0, 0, 0, 3, '1', '�u�@���ѯСA�@����ì�v�A�n�n���V�O�A\r\n���ݩ���঳�n����{�C');
INSERT INTO comment VALUES (441, 0, 0, 0, 3, '1', '����}�ԡA�����ߧO�H�A�B�B���O�H�]�Q�A�s�ʯS�ΡC');
INSERT INTO comment VALUES (442, 0, 0, 0, 3, '1', '�ĥ����R�A�L���`���y�W�A�ˤ��P�H�A�ҷ~�|���ԫj�A�߼ƾǤ@�즳�ݥ[�j�C');
INSERT INTO comment VALUES (443, 0, 0, 0, 3, '1', '���F�V�O�A���|������A�p�w�ɤF�O�A�ƾ������F�z�Q�A�Ѯv�S��ԩǩp�O�H');
INSERT INTO comment VALUES (444, 0, 0, 0, 3, '1', '�믫�n���@�AŪ�ѭn�n���A���Z�~�|�n�C�Q�ءG���@�_�ӧa�I���֩p�I');
INSERT INTO comment VALUES (445, 0, 0, 0, 3, '1', '�ʱ��n�ԡA���o�����H�K�A�p���Ԩ��V��A�o��Ū�ѡA���Z���i��i�C');
INSERT INTO comment VALUES (446, 0, 0, 0, 3, '1', '�P�H�۳B�A�����e�p�A�u��p���A�B�ͥ����C�ߥ��I�R�A�~��w�ߦV�ǡC');
INSERT INTO comment VALUES (447, 0, 0, 0, 3, '1', '�Ѹꤣ�t�A�ѼƾǦ��Z�i�ݥX�A�p��y�[�ΤߡA��L���Z�]���|�i�B�I�V�O�a�I�h�ݮѡA�ֻ��ܡC');
INSERT INTO comment VALUES (448, 0, 0, 0, 3, '1', '�éʷũM�A�ݤH��§�A�u�@���ߡA�ԩ�ǲߡA�����ų�A�@�a�����O���ӡA�H���j���C');
INSERT INTO comment VALUES (449, 0, 0, 0, 3, '1', '�өʭϱj�A�ǿ��Ӥ����˰Q�A�ߥH�j�����G�A�A�ץ����z���A�@��ۧڲ`��A�[�H��i�A��ť�v���A�����V�ǡA�~�O�ǥ��������A�סA�@�A����|�C');
INSERT INTO comment VALUES (450, 0, 0, 0, 3, '1', '�o�o�Ӫ��ԾǡA�����O�~�w��ǰݧ󭫭n�Ať�q�v���л��A���O���i���y�_���A�H�S�H���C');
INSERT INTO comment VALUES (451, 0, 0, 0, 3, '1', '�ǮլO�Ӥj�a�x�A�����H�H��u���ǡA���i�L�z���x�A�}�a���ǡC�h�Τ߫��Ƿ~�A�۫H�ԥ���ɩ�C');
INSERT INTO comment VALUES (452, 0, 0, 0, 3, '1', '�[���o�o�A�������Z�A��ź�𭫡A����������C�P������͡A���`�N��ť�A���i�ɱ`�h���B���L�A�~�O�������D�C');
INSERT INTO comment VALUES (453, 0, 0, 0, 3, '1', '�O���j�H�u���h�����v�����A�ɶq�O���I�q�A�ר�W�Ҥ��A���i�H�K���ܡA�H�K�l�H�S���Q�v�A�ݤH�H�ۡA�O�H���]���w�A�I');
INSERT INTO comment VALUES (454, 0, 0, 0, 3, '1', '����h�Τ߫�ҡA�h���A�۫H�ƾǦ��Z�]�i�M��L��ؤ@�˦n�C');
INSERT INTO comment VALUES (456, 0, 0, 0, 1, '1', '�ũM�¾�');
INSERT INTO comment VALUES (457, 0, 0, 0, 1, '1', '�Z�ղn��');
INSERT INTO comment VALUES (458, 0, 0, 0, 1, '1', '�ᦳ�Ӯ�');
INSERT INTO comment VALUES (459, 0, 0, 0, 1, '1', '�i���G�M');
INSERT INTO comment VALUES (460, 0, 0, 0, 1, '1', '�۹�u��');
INSERT INTO comment VALUES (462, 0, 0, 0, 1, '1', '�w��@��');
INSERT INTO comment VALUES (463, 0, 0, 0, 1, '1', '�Ѹ��o�o');
INSERT INTO comment VALUES (464, 0, 0, 0, 1, '1', '�B�n����');
INSERT INTO comment VALUES (465, 0, 0, 0, 1, '1', '�éʯ«p');
INSERT INTO comment VALUES (466, 0, 0, 0, 1, '1', '�����F');
INSERT INTO comment VALUES (467, 0, 0, 0, 1, '1', '��ɤO�j');
INSERT INTO comment VALUES (468, 0, 0, 0, 1, '1', '�Գһ���');
INSERT INTO comment VALUES (469, 0, 0, 0, 1, '1', '�n���İ�');
INSERT INTO comment VALUES (470, 0, 0, 0, 1, '1', '����ѯu');
INSERT INTO comment VALUES (471, 0, 0, 0, 1, '1', '���R�w��');
INSERT INTO comment VALUES (472, 0, 0, 0, 1, '1', '���[�i��');
INSERT INTO comment VALUES (473, 0, 0, 0, 1, '1', '�ܵ��T��');
INSERT INTO comment VALUES (474, 0, 0, 0, 1, '1', '�|���īj');
INSERT INTO comment VALUES (475, 0, 0, 0, 1, '1', '�w�u�H�q');
INSERT INTO comment VALUES (476, 0, 0, 0, 1, '1', '�誽���p');
INSERT INTO comment VALUES (477, 0, 0, 0, 1, '1', '�����Z�v');
INSERT INTO comment VALUES (478, 0, 0, 0, 1, '1', '����n��');
INSERT INTO comment VALUES (479, 0, 0, 0, 1, '1', '�Mħ�i��');
INSERT INTO comment VALUES (480, 0, 0, 0, 1, '1', '���ᤣ��');
INSERT INTO comment VALUES (481, 0, 0, 0, 1, '1', '��ݦ���');
INSERT INTO comment VALUES (482, 0, 0, 0, 1, '1', '���̶}��');
INSERT INTO comment VALUES (483, 0, 0, 0, 1, '1', '�I�i����');
INSERT INTO comment VALUES (484, 0, 0, 0, 1, '1', '���V�۫�');
INSERT INTO comment VALUES (485, 0, 0, 0, 1, '1', '���p�۹�');
INSERT INTO comment VALUES (486, 0, 0, 0, 1, '1', '�N�Ӱ�j');
INSERT INTO comment VALUES (487, 0, 0, 0, 1, '1', '�����I��');
INSERT INTO comment VALUES (488, 0, 0, 0, 1, '1', '�����U��');
INSERT INTO comment VALUES (489, 0, 0, 0, 1, '1', '�Ŷ����p');
INSERT INTO comment VALUES (490, 0, 0, 0, 1, '1', 'Ū�ѱM��');
INSERT INTO comment VALUES (491, 0, 0, 0, 1, '1', '�M��ť��');
INSERT INTO comment VALUES (492, 0, 0, 0, 1, '1', '�z�ѤO�j');
INSERT INTO comment VALUES (493, 0, 0, 0, 1, '1', '�~�ǭ��u');
INSERT INTO comment VALUES (494, 0, 0, 0, 1, '1', '�Ǧ��M��');
INSERT INTO comment VALUES (495, 0, 0, 0, 1, '1', '�ԾĦn��');
INSERT INTO comment VALUES (496, 0, 0, 0, 1, '1', '�A�q����');
INSERT INTO comment VALUES (497, 0, 0, 0, 1, '1', '�[�����T');
INSERT INTO comment VALUES (498, 0, 0, 0, 1, '1', '�I�����R');
INSERT INTO comment VALUES (499, 0, 0, 0, 1, '1', '���q�i��');
INSERT INTO comment VALUES (500, 0, 0, 0, 1, '1', '��װ��|');
INSERT INTO comment VALUES (501, 0, 0, 0, 1, '1', '�I�R�Ũ}');
INSERT INTO comment VALUES (502, 0, 0, 0, 1, '1', '�w���u�v');
INSERT INTO comment VALUES (503, 0, 0, 0, 1, '1', '��Q�¥�');
INSERT INTO comment VALUES (504, 0, 0, 0, 1, '1', '�éʯ«p');
INSERT INTO comment VALUES (505, 0, 0, 0, 1, '1', '�o���D�W');
INSERT INTO comment VALUES (506, 0, 0, 0, 1, '1', '�����ӱ�');
INSERT INTO comment VALUES (507, 0, 0, 0, 1, '1', '�гy�i��');
INSERT INTO comment VALUES (508, 0, 0, 0, 1, '1', '�|���i��');
INSERT INTO comment VALUES (509, 0, 0, 0, 1, '1', '�D�����j');
INSERT INTO comment VALUES (510, 0, 0, 0, 1, '1', '�Ƿ~�u�}');
INSERT INTO comment VALUES (511, 0, 0, 0, 1, '1', '�ӦӦn��');
INSERT INTO comment VALUES (512, 0, 0, 0, 1, '1', '�ĵo�V�W');
INSERT INTO comment VALUES (513, 0, 0, 0, 1, '1', '�ߨD�i��');
INSERT INTO comment VALUES (514, 0, 0, 0, 1, '1', '��Ū�`��');
INSERT INTO comment VALUES (515, 0, 0, 0, 1, '1', '�ԩ�D��');
INSERT INTO comment VALUES (516, 0, 0, 0, 1, '1', '�|�ֻ{�u');
INSERT INTO comment VALUES (517, 0, 0, 0, 1, '1', '�M�߭P��');
INSERT INTO comment VALUES (518, 0, 0, 0, 1, '1', '�馳�i�B');
INSERT INTO comment VALUES (519, 0, 0, 0, 1, '1', '�⤣����');
INSERT INTO comment VALUES (520, 0, 0, 0, 1, '1', '�s�èD�u');
INSERT INTO comment VALUES (521, 0, 0, 0, 1, '1', '�ǲ߻{�u');
INSERT INTO comment VALUES (522, 0, 0, 0, 1, '1', '�᪾�{�u');
INSERT INTO comment VALUES (523, 0, 0, 0, 1, '1', '��ҿ��K');
INSERT INTO comment VALUES (524, 0, 0, 0, 1, '1', '�`������');
INSERT INTO comment VALUES (525, 0, 0, 0, 1, '1', '���ߤ��q');
INSERT INTO comment VALUES (526, 0, 0, 0, 1, '1', '�R������');
INSERT INTO comment VALUES (527, 0, 0, 0, 1, '1', '�A�ȶԷV');
INSERT INTO comment VALUES (528, 0, 0, 0, 1, '1', '�ߥ���M');
INSERT INTO comment VALUES (529, 0, 0, 0, 1, '1', '�J��¾�d');
INSERT INTO comment VALUES (530, 0, 0, 0, 1, '1', '�A�Ⱥɳd');
INSERT INTO comment VALUES (531, 0, 0, 0, 1, '1', '�|�u�W�x');
INSERT INTO comment VALUES (532, 0, 0, 0, 1, '1', '§���P��');
INSERT INTO comment VALUES (533, 0, 0, 0, 1, '1', '��W�@��');
INSERT INTO comment VALUES (534, 0, 0, 0, 1, '1', '�ͷR�P��');
INSERT INTO comment VALUES (535, 0, 0, 0, 1, '1', '�q�v����');
INSERT INTO comment VALUES (536, 0, 0, 0, 1, '1', '���[����');
INSERT INTO comment VALUES (537, 0, 0, 0, 1, '1', '�Ť妳§');
INSERT INTO comment VALUES (538, 0, 0, 0, 1, '1', '������H');
INSERT INTO comment VALUES (539, 0, 0, 0, 1, '1', '���ҥ���');
INSERT INTO comment VALUES (540, 0, 0, 0, 1, '1', '²����');
INSERT INTO comment VALUES (541, 0, 0, 0, 1, '1', '�`�W�Яx');
INSERT INTO comment VALUES (542, 0, 0, 0, 1, '1', '�|��ݲ�');
INSERT INTO comment VALUES (543, 0, 0, 0, 1, '1', '�X�@�L��');
INSERT INTO comment VALUES (544, 0, 0, 0, 1, '1', '�u�@�V�O');
INSERT INTO comment VALUES (545, 0, 0, 0, 1, '1', '���e���');
INSERT INTO comment VALUES (546, 0, 0, 0, 1, '1', '�R�@����');
INSERT INTO comment VALUES (547, 0, 0, 0, 1, '1', '�u�k����');
INSERT INTO comment VALUES (548, 0, 0, 0, 1, '1', '�ݤH����');
INSERT INTO comment VALUES (549, 0, 0, 0, 1, '1', '�ۭ��۷R');
INSERT INTO comment VALUES (550, 0, 0, 0, 1, '1', '��W���y');
INSERT INTO comment VALUES (551, 0, 0, 0, 1, '1', '�@������');
INSERT INTO comment VALUES (552, 0, 0, 0, 1, '1', '�A�פj��');
INSERT INTO comment VALUES (553, 0, 0, 0, 1, '1', '���`���Y');
INSERT INTO comment VALUES (554, 0, 0, 0, 1, '1', '���ߧU�H');
INSERT INTO comment VALUES (555, 0, 0, 0, 1, '1', '�i��{��');
INSERT INTO comment VALUES (556, 0, 0, 0, 1, '1', '�B�@�M��');
INSERT INTO comment VALUES (557, 0, 0, 0, 1, '1', '�ݤH����');
INSERT INTO comment VALUES (558, 0, 0, 0, 1, '1', '�欰í��');
INSERT INTO comment VALUES (559, 0, 0, 0, 1, '1', '�d���߭�');
INSERT INTO comment VALUES (560, 0, 0, 0, 1, '1', '�ݲ���§');
INSERT INTO comment VALUES (561, 0, 0, 0, 1, '1', '�椽�n�q');
INSERT INTO comment VALUES (562, 0, 0, 0, 1, '1', '������§');
INSERT INTO comment VALUES (563, 0, 0, 0, 1, '1', '���ߧU�H');
INSERT INTO comment VALUES (564, 0, 0, 0, 1, '1', '����M��');
INSERT INTO comment VALUES (565, 0, 0, 0, 1, '1', '�Գһ���');
INSERT INTO comment VALUES (566, 0, 0, 0, 1, '1', '����w��');
INSERT INTO comment VALUES (567, 0, 0, 0, 1, '1', '���[�X�s');
INSERT INTO comment VALUES (568, 0, 0, 0, 1, '1', '�|�u����');
INSERT INTO comment VALUES (569, 0, 0, 0, 1, '1', '�ͦR����');
INSERT INTO comment VALUES (570, 0, 0, 0, 1, '1', '��u����');
INSERT INTO comment VALUES (571, 0, 0, 0, 1, '1', '����r��');
INSERT INTO comment VALUES (572, 0, 0, 0, 1, '1', '�믫����');
INSERT INTO comment VALUES (573, 0, 0, 0, 1, '1', '�q�~�ָs');
INSERT INTO comment VALUES (574, 0, 0, 0, 1, '1', '���ߤ��q');
INSERT INTO comment VALUES (576, 0, 0, 0, 1, '1', '�y�����');
INSERT INTO comment VALUES (577, 0, 0, 0, 1, '1', '�����W�s');
INSERT INTO comment VALUES (578, 0, 0, 0, 1, '1', '��q��a');
INSERT INTO comment VALUES (579, 0, 0, 0, 1, '1', '�ժ��g�@');
INSERT INTO comment VALUES (580, 0, 0, 0, 1, '1', '�ժ���N');
INSERT INTO comment VALUES (581, 0, 0, 0, 1, '1', '�ժ��Ѫk');
INSERT INTO comment VALUES (582, 0, 0, 0, 1, '1', '�ժ����N');
INSERT INTO comment VALUES (583, 0, 0, 0, 1, '1', '�ժ�����');
INSERT INTO comment VALUES (584, 0, 0, 0, 1, '1', '�ժ��u��');
INSERT INTO comment VALUES (585, 0, 0, 0, 1, '1', '�ժ��t��');
INSERT INTO comment VALUES (586, 0, 0, 0, 1, '1', '�ժ��a��');
INSERT INTO comment VALUES (587, 0, 0, 0, 1, '1', '�ժ��B��');
INSERT INTO comment VALUES (588, 0, 0, 0, 1, '1', '�ժ��Ʋz');
INSERT INTO comment VALUES (589, 0, 0, 0, 1, '1', '�ժ��R��');
INSERT INTO comment VALUES (590, 0, 0, 0, 1, '1', '�ժ����@');
INSERT INTO comment VALUES (591, 0, 0, 0, 1, '1', '�ժ���v');
INSERT INTO comment VALUES (592, 0, 0, 0, 1, '1', '�ߩꤣ��');
INSERT INTO comment VALUES (593, 0, 0, 0, 1, '1', '���̯U�p');
INSERT INTO comment VALUES (594, 0, 0, 0, 1, '1', '�өʭϱj');
INSERT INTO comment VALUES (595, 0, 0, 0, 1, '1', '�e���D��');
INSERT INTO comment VALUES (596, 0, 0, 0, 1, '1', '�߯B��ļ');
INSERT INTO comment VALUES (597, 0, 0, 0, 1, '1', '�N�����z');
INSERT INTO comment VALUES (598, 0, 0, 0, 1, '1', '���{���w');
INSERT INTO comment VALUES (599, 0, 0, 0, 1, '1', '��ʦn��');
INSERT INTO comment VALUES (600, 0, 0, 0, 1, '1', '�[������');
INSERT INTO comment VALUES (601, 0, 0, 0, 1, '4', '�����۹�');
INSERT INTO comment VALUES (602, 0, 0, 0, 1, '1', '���z�]�`');
INSERT INTO comment VALUES (603, 0, 0, 0, 1, '1', '�I�q�訥');
INSERT INTO comment VALUES (604, 0, 0, 0, 1, '1', '��ť�V�|');
INSERT INTO comment VALUES (605, 0, 0, 0, 1, '1', '�İʦn��');
INSERT INTO comment VALUES (606, 0, 0, 0, 1, '1', '�ʱ��ĩ�');
INSERT INTO comment VALUES (607, 0, 0, 0, 1, '1', '�ʱ���p');
INSERT INTO comment VALUES (608, 0, 0, 0, 1, '1', '�ۨ��`��');
INSERT INTO comment VALUES (609, 0, 0, 0, 1, '1', '�����{�u');
INSERT INTO comment VALUES (610, 0, 0, 0, 1, '1', '���߼Ʋz');
INSERT INTO comment VALUES (611, 0, 0, 0, 1, '1', '�ۼɦ۱�');
INSERT INTO comment VALUES (612, 0, 0, 0, 1, '1', '�ҷ~���');
INSERT INTO comment VALUES (613, 0, 0, 0, 1, '1', '�ŭl��v');
INSERT INTO comment VALUES (614, 0, 0, 0, 1, '1', '�^�C�L��');
INSERT INTO comment VALUES (615, 0, 0, 0, 1, '1', '�o�o�g��');
INSERT INTO comment VALUES (616, 0, 0, 0, 1, '1', '���D�W�i');
INSERT INTO comment VALUES (617, 0, 0, 0, 1, '2', '���nŪ��');
INSERT INTO comment VALUES (618, 0, 0, 0, 1, '2', '�g���n��');
INSERT INTO comment VALUES (619, 0, 0, 0, 1, '2', '�ʥF���');
INSERT INTO comment VALUES (620, 0, 0, 0, 1, '2', '�j�����I');
INSERT INTO comment VALUES (621, 0, 0, 0, 1, '2', '�|��V�O');
INSERT INTO comment VALUES (622, 0, 0, 0, 1, '2', '�i��ǲ�');
INSERT INTO comment VALUES (623, 0, 0, 0, 1, '2', '����p�`');
INSERT INTO comment VALUES (624, 0, 0, 0, 1, '2', '�өʩt��');
INSERT INTO comment VALUES (625, 0, 0, 0, 1, '2', '���|�w');
INSERT INTO comment VALUES (626, 0, 0, 0, 1, '2', '�ߤ��M�@');
INSERT INTO comment VALUES (627, 0, 0, 0, 1, '3', '���t�d��');
INSERT INTO comment VALUES (628, 0, 0, 0, 1, '2', '���h�۫�');
INSERT INTO comment VALUES (629, 0, 0, 0, 1, '2', '�������');
INSERT INTO comment VALUES (630, 0, 0, 0, 1, '2', '�X��ӭ�');
INSERT INTO comment VALUES (631, 0, 0, 0, 1, '3', '�����P��');
INSERT INTO comment VALUES (632, 0, 0, 0, 1, '2', '��|��Ѫ');
INSERT INTO comment VALUES (633, 0, 0, 0, 1, '2', '�߯B����');
INSERT INTO comment VALUES (634, 0, 0, 0, 1, '3', '��C���V');
INSERT INTO comment VALUES (635, 0, 0, 0, 1, '2', '�믫����');
INSERT INTO comment VALUES (636, 0, 0, 0, 1, '3', '���@����');
INSERT INTO comment VALUES (637, 0, 0, 0, 1, '3', '���h���');
INSERT INTO comment VALUES (638, 0, 0, 0, 1, '2', '��v�q��');
INSERT INTO comment VALUES (639, 0, 0, 0, 1, '3', '�ʤߤj�N');
INSERT INTO comment VALUES (640, 0, 0, 0, 1, '2', '�ǦӤ��M');
INSERT INTO comment VALUES (641, 0, 0, 0, 1, '2', '���D�Ƹ�');
INSERT INTO comment VALUES (642, 0, 0, 0, 1, '2', '�ɾǮɰ�');
INSERT INTO comment VALUES (643, 0, 0, 0, 1, '2', '�ڦ�گ�');
INSERT INTO comment VALUES (644, 0, 0, 0, 1, '2', '�R�X���Y');
INSERT INTO comment VALUES (645, 0, 0, 0, 1, '3', '�B�ؤ���');
INSERT INTO comment VALUES (646, 0, 0, 0, 1, '2', '�A�Ȥ��');
INSERT INTO comment VALUES (647, 0, 0, 0, 1, '4', '�ŭl��v');
INSERT INTO comment VALUES (648, 0, 0, 0, 1, '3', '�j���n�G');
INSERT INTO comment VALUES (649, 0, 0, 0, 1, '4', '�|���L§');
INSERT INTO comment VALUES (650, 0, 0, 0, 1, '4', '�欰�ƺC');
INSERT INTO comment VALUES (651, 0, 0, 0, 1, '4', '�|���');
INSERT INTO comment VALUES (652, 0, 0, 0, 1, '4', '�ʱ��ʼ�');
INSERT INTO comment VALUES (653, 0, 0, 0, 1, '2', '�`������');
INSERT INTO comment VALUES (654, 0, 0, 0, 1, '3', '�N�Ӯ��I');
INSERT INTO comment VALUES (655, 0, 0, 0, 1, '3', '���ƦX�s');
INSERT INTO comment VALUES (656, 0, 0, 0, 1, '2', '�X�z���_');
INSERT INTO comment VALUES (657, 0, 0, 0, 1, '3', '�A�׻��B');
INSERT INTO comment VALUES (658, 0, 0, 0, 1, '3', '§�����g');
INSERT INTO comment VALUES (659, 0, 0, 0, 1, '3', '�M�Ӧۥ�');
INSERT INTO comment VALUES (660, 0, 0, 0, 1, '3', '���R�`�p');
INSERT INTO comment VALUES (661, 0, 0, 0, 1, '3', '�����H�K');
INSERT INTO comment VALUES (662, 0, 0, 0, 1, '2', '�o�L�B�L');
INSERT INTO comment VALUES (663, 0, 0, 0, 1, '2', '�����z');
INSERT INTO comment VALUES (664, 0, 0, 0, 1, '3', '����X�s');
INSERT INTO comment VALUES (665, 0, 0, 0, 1, '4', '�x�j�k��');
INSERT INTO comment VALUES (666, 0, 0, 0, 1, '3', '���e����');
INSERT INTO comment VALUES (667, 0, 0, 0, 1, '4', '�n�h�c��');
INSERT INTO comment VALUES (668, 0, 0, 0, 1, '4', '�ͬ�����');
INSERT INTO comment VALUES (669, 0, 0, 0, 1, '3', '�ʤߤj�N');
INSERT INTO comment VALUES (670, 0, 0, 0, 1, '3', '���ܤӦh');
INSERT INTO comment VALUES (671, 0, 0, 0, 1, '4', '�欰����');
INSERT INTO comment VALUES (672, 0, 0, 0, 1, '4', '�ۥ��Z�k');
INSERT INTO comment VALUES (673, 0, 0, 0, 1, '1', '�B�ƥD�[');
INSERT INTO comment VALUES (674, 0, 0, 0, 1, '3', '�믫����');
INSERT INTO comment VALUES (675, 0, 0, 0, 1, '1', '��F����');
INSERT INTO comment VALUES (676, 0, 0, 0, 1, '1', '����n��');
INSERT INTO comment VALUES (677, 0, 0, 0, 1, '1', 'Ū�ѧV�O');
INSERT INTO comment VALUES (678, 0, 0, 0, 1, '1', '�o���Τ�');
INSERT INTO comment VALUES (679, 0, 0, 0, 1, '1', '�{�u�u�W');
INSERT INTO comment VALUES (680, 0, 0, 0, 1, '1', '�|���{�u');
INSERT INTO comment VALUES (681, 0, 0, 0, 1, '1', '���Z�i�B');
INSERT INTO comment VALUES (682, 0, 0, 0, 1, '1', '�ǲ߻{�u');
INSERT INTO comment VALUES (683, 0, 0, 0, 1, '1', '�W�ҥΤ�');
INSERT INTO comment VALUES (684, 0, 0, 0, 1, '1', '�{�u�ѹ�');
INSERT INTO comment VALUES (685, 0, 0, 0, 1, '1', '�o���{�u');
INSERT INTO comment VALUES (686, 0, 0, 0, 1, '1', '�ԾǦu�k');
INSERT INTO comment VALUES (687, 0, 0, 0, 1, '1', '�{�u�t�d');
INSERT INTO comment VALUES (688, 0, 0, 0, 1, '1', '�`�W�Яx');
INSERT INTO comment VALUES (689, 0, 0, 0, 1, '1', '�{�u�n��');
INSERT INTO comment VALUES (690, 0, 0, 0, 1, '1', '�~�ǭ��u');
INSERT INTO comment VALUES (691, 0, 0, 0, 1, '1', '���i����');
INSERT INTO comment VALUES (692, 0, 0, 0, 1, '1', '��O�R�K');
INSERT INTO comment VALUES (693, 0, 0, 0, 1, '1', '�ʱ��¨}');
INSERT INTO comment VALUES (694, 0, 0, 0, 1, '1', '�I�R�Ծ�');
INSERT INTO comment VALUES (695, 0, 0, 0, 1, '1', '�X�s�M��');
INSERT INTO comment VALUES (696, 0, 0, 0, 1, '1', '�Ѹ�o�z');
INSERT INTO comment VALUES (697, 0, 0, 0, 1, '1', '�I�q�u�W');
INSERT INTO comment VALUES (698, 0, 0, 0, 1, '1', '�Ť妳§');
INSERT INTO comment VALUES (699, 0, 0, 0, 1, '1', '�~��ݥ�');
INSERT INTO comment VALUES (700, 0, 0, 0, 1, '1', '�I���w��');
INSERT INTO comment VALUES (701, 0, 0, 0, 1, '1', '�{�uť��');
INSERT INTO comment VALUES (702, 0, 0, 0, 1, '1', '�ĥ��i�R');
INSERT INTO comment VALUES (703, 0, 0, 0, 1, '1', '�Mħ�ˤ�');
INSERT INTO comment VALUES (704, 0, 0, 0, 1, '1', '���Z���');
INSERT INTO comment VALUES (705, 0, 0, 0, 1, '1', '�ߧ@�{�u');
INSERT INTO comment VALUES (706, 0, 0, 0, 1, '1', '�ʱ��ũM');
INSERT INTO comment VALUES (707, 0, 0, 0, 1, '1', 'Ū�ѻ{�u');
INSERT INTO comment VALUES (708, 0, 0, 0, 1, '2', '�ҷ~���');
INSERT INTO comment VALUES (709, 0, 0, 0, 1, '1', '�ݤH�e�p');
INSERT INTO comment VALUES (710, 0, 0, 0, 1, '1', '�éʯ¨}');
INSERT INTO comment VALUES (711, 0, 0, 0, 1, '1', '�ݤH�ˤ�');
INSERT INTO comment VALUES (712, 0, 0, 0, 1, '1', '�ԳҼ���');
INSERT INTO comment VALUES (713, 0, 0, 0, 1, '1', '�I�P����');
INSERT INTO comment VALUES (714, 0, 0, 0, 1, '1', '�ߦa���}');
INSERT INTO comment VALUES (715, 0, 0, 0, 1, '1', '�f���M��');
INSERT INTO comment VALUES (716, 0, 0, 0, 1, '1', '�⮩�O�j');
INSERT INTO comment VALUES (717, 0, 0, 0, 1, '1', '��S���j');
INSERT INTO comment VALUES (718, 0, 0, 0, 1, '1', '�@���u��');
INSERT INTO comment VALUES (719, 0, 0, 0, 1, '1', '�I�R�Ծ�');
INSERT INTO comment VALUES (720, 0, 0, 0, 1, '1', '�w�p�۹�');
INSERT INTO comment VALUES (721, 0, 0, 0, 1, '1', '�ʱ����p');
INSERT INTO comment VALUES (722, 0, 0, 0, 1, '1', '�A�q�訥');
INSERT INTO comment VALUES (723, 0, 0, 0, 1, '1', '�I�i����');
INSERT INTO comment VALUES (724, 0, 0, 0, 1, '1', '�ŬX��§');
INSERT INTO comment VALUES (725, 0, 0, 0, 1, '1', '�{�u�t�d');
INSERT INTO comment VALUES (726, 0, 0, 0, 1, '1', '�ǲ߻{�u');
INSERT INTO comment VALUES (727, 0, 0, 0, 1, '1', '�@�~�u��');
INSERT INTO comment VALUES (728, 0, 0, 0, 1, '1', '�Ѹ��o�o');
INSERT INTO comment VALUES (729, 0, 0, 0, 1, '4', '�����i��');
INSERT INTO comment VALUES (730, 0, 0, 0, 1, '4', '�n�ʦh��');
INSERT INTO comment VALUES (731, 0, 0, 0, 1, '3', '�ǲߤO�t');
INSERT INTO comment VALUES (732, 0, 0, 0, 1, '3', '������w');
INSERT INTO comment VALUES (733, 0, 0, 0, 1, '3', '�n�h�V�O');
INSERT INTO comment VALUES (734, 0, 0, 0, 1, '3', '�z�ѤO�t');
# --------------------------------------------------------

#
# ��ƪ�榡�G `comment_kind`
#

CREATE TABLE comment_kind (
  kind_serial tinyint(3) unsigned NOT NULL auto_increment,
  kind_teacher_id varchar(20) default NULL,
  kind_name varchar(50) NOT NULL default '',
  PRIMARY KEY  (kind_serial)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `comment_kind`
#

INSERT INTO comment_kind VALUES (1, 0, '�|�r�e��');
INSERT INTO comment_kind VALUES (2, 0, '�K�嵴��');
INSERT INTO comment_kind VALUES (3, 0, '�͵Ƥ���');
INSERT INTO comment_kind VALUES (5, 1001, 'test3');
# --------------------------------------------------------

#
# ��ƪ�榡�G `comment_level`
#

CREATE TABLE comment_level (
  level_serial tinyint(3) unsigned NOT NULL auto_increment,
  level_teacher_id varchar(20) default NULL,
  level_name varchar(50) NOT NULL default '',
  PRIMARY KEY  (level_serial)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `comment_level`
#

INSERT INTO comment_level VALUES (1, 0, '��');
INSERT INTO comment_level VALUES (2, 0, '�A');
INSERT INTO comment_level VALUES (3, 0, '��');
INSERT INTO comment_level VALUES (4, 0, '�B');
# --------------------------------------------------------

#
# ��ƪ�榡�G `course_class_time`
#

CREATE TABLE course_class_time (
  cct int(10) unsigned NOT NULL auto_increment,
  year smallint(5) unsigned NOT NULL default '0',
  seme enum('1','2') NOT NULL default '1',
  class_time varchar(4) NOT NULL default '',
  class_id varchar(11) NOT NULL default '',
  Cyear tinyint(2) unsigned default NULL,
  PRIMARY KEY  (cct),
  KEY year (year,seme)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `course_class_time`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `course_room`
#

CREATE TABLE course_room (
  crsn int(10) unsigned NOT NULL auto_increment,
  date date NOT NULL default '0000-00-00',
  day enum('0','1','2','3','4','5','6','7') NOT NULL default '0',
  sector tinyint(1) unsigned NOT NULL default '0',
  room varchar(50) NOT NULL default '',
  teacher_sn mediumint(8) unsigned NOT NULL default '0',
  sign_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (crsn),
  KEY teacher_sn (teacher_sn),
  KEY sector (sector),
  KEY day (day)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `course_room`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `course_ss_num`
#

CREATE TABLE course_ss_num (
  csn int(10) unsigned NOT NULL auto_increment,
  year smallint(5) unsigned NOT NULL default '0',
  seme enum('1','2') NOT NULL default '1',
  ss_id smallint(5) unsigned NOT NULL default '0',
  num tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (csn),
  KEY year (year,seme)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `course_ss_num`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `course_teach_num`
#

CREATE TABLE course_teach_num (
  ctn int(10) unsigned NOT NULL auto_increment,
  year smallint(5) unsigned NOT NULL default '0',
  seme enum('1','2') NOT NULL default '1',
  teacher_sn smallint(5) unsigned NOT NULL default '0',
  num tinyint(3) unsigned NOT NULL default '0',
  teach_year varchar(255) default NULL,
  PRIMARY KEY  (ctn),
  KEY year (year,seme)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `course_teach_num`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `course_teacher_ss_num`
#

CREATE TABLE course_teacher_ss_num (
  ctsn int(10) unsigned NOT NULL auto_increment,
  year smallint(5) unsigned NOT NULL default '0',
  seme enum('1','2') NOT NULL default '1',
  teacher_sn smallint(5) unsigned NOT NULL default '0',
  class_id varchar(11) NOT NULL default '',
  ss_id smallint(5) unsigned NOT NULL default '0',
  num tinyint(3) unsigned NOT NULL default '0',
  other varchar(20) default NULL,
  PRIMARY KEY  (ctsn),
  KEY year (year,seme)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `course_teacher_ss_num`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `course_tmp`
#

CREATE TABLE course_tmp (
  ctmp_sn mediumint(8) unsigned NOT NULL auto_increment,
  year smallint(5) unsigned NOT NULL default '0',
  semester enum('1','2') NOT NULL default '1',
  class_id varchar(11) NOT NULL default '',
  teacher_sn mediumint(9) NOT NULL default '0',
  class_year tinyint(2) unsigned NOT NULL default '0',
  class_name tinyint(2) unsigned NOT NULL default '0',
  day enum('0','1','2','3','4','5','6','7') default NULL,
  sector tinyint(1) NOT NULL default '0',
  ss_id smallint(5) unsigned NOT NULL default '0',
  room varchar(10) default NULL,
  other varchar(255) default NULL,
  PRIMARY KEY  (ctmp_sn),
  KEY class_name (class_name),
  KEY class_year (class_year),
  KEY year (year,semester)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `course_tmp`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `docup`
#

CREATE TABLE docup (
  docup_p_id int(11) NOT NULL default '0',
  docup_id int(11) NOT NULL auto_increment,
  docup_name varchar(80) NOT NULL default '',
  docup_date datetime NOT NULL default '0000-00-00 00:00:00',
  docup_owner varchar(12) NOT NULL default '',
  docup_store varchar(80) NOT NULL default '',
  docup_share char(3) NOT NULL default '0',
  docup_owerid varchar(6) NOT NULL default '',
  docup_file_size int(11) NOT NULL default '0',
  teacher_sn smallint(6) NOT NULL default '0',
  PRIMARY KEY  (docup_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `docup`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `docup_p`
#

CREATE TABLE docup_p (
  doc_kind_id int(11) NOT NULL default '0',
  docup_p_id int(11) NOT NULL auto_increment,
  docup_p_date datetime NOT NULL default '0000-00-00 00:00:00',
  docup_p_name varchar(60) default NULL,
  docup_p_memo text,
  docup_p_owner varchar(12) default NULL,
  docup_p_ownerid varchar(6) NOT NULL default '',
  docup_p_count int(11) NOT NULL default '0',
  teacher_sn smallint(6) NOT NULL default '0',
  PRIMARY KEY  (docup_p_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `docup_p`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `exam`
#

CREATE TABLE exam (
  exam_id int(11) NOT NULL auto_increment,
  exam_name varchar(60) NOT NULL default '',
  exam_memo text NOT NULL,
  exam_isopen char(1) NOT NULL default '',
  exam_isupload char(1) NOT NULL default '',
  exam_source_isopen char(1) NOT NULL default '',
  e_kind_id int(4) NOT NULL default '0',
  teach_id varchar(20) NOT NULL default '',
  teach_name varchar(20) NOT NULL default '',
  PRIMARY KEY  (exam_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `exam`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `exam_kind`
#

CREATE TABLE exam_kind (
  e_kind_id int(11) NOT NULL auto_increment,
  e_kind_memo text NOT NULL,
  e_kind_open char(1) NOT NULL default '',
  e_upload_ok char(1) NOT NULL default '',
  teach_id varchar(20) NOT NULL default '',
  teach_name varchar(20) NOT NULL default '',
  class_id varchar(10) NOT NULL default '',
  PRIMARY KEY  (e_kind_id,class_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `exam_kind`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `exam_stud`
#

CREATE TABLE exam_stud (
  exam_id int(11) NOT NULL default '0',
  stud_id varchar(20) NOT NULL default '',
  stud_name varchar(20) NOT NULL default '',
  stud_num tinyint(4) NOT NULL default '0',
  memo text NOT NULL,
  f_name varchar(120) NOT NULL default '',
  f_size float(10,2) NOT NULL default '0.00',
  cool char(1) NOT NULL default '',
  tea_comment varchar(30) NOT NULL default '',
  tea_grade int(11) default NULL,
  f_ctime datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (exam_id,stud_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `exam_stud`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `exam_stud_data`
#

CREATE TABLE exam_stud_data (
  stud_id varchar(20) NOT NULL default '',
  stud_pass varchar(10) NOT NULL default '',
  stud_num tinyint(4) NOT NULL default '0',
  stud_sit_num varchar(5) NOT NULL default '0',
  stud_memo varchar(80) NOT NULL default '',
  stud_c_time tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (stud_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `exam_stud_data`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `file_db`
#

CREATE TABLE file_db (
  FSN mediumint(8) unsigned NOT NULL auto_increment,
  eduer_unit_sn smallint(5) unsigned NOT NULL default '0',
  filename varchar(255) NOT NULL default '',
  main_data longblob NOT NULL,
  description text NOT NULL,
  type varchar(128) NOT NULL default '',
  size int(11) NOT NULL default '0',
  date datetime NOT NULL default '0000-00-00 00:00:00',
  category_sn smallint(6) NOT NULL default '0',
  col_name varchar(255) default NULL,
  col_sn mediumint(8) unsigned default '0',
  unit_sn tinyint(3) unsigned NOT NULL default '0',
  enable enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (FSN),
  KEY ESN (eduer_unit_sn),
  KEY msg_id (col_sn,unit_sn),
  FULLTEXT KEY description (description),
  FULLTEXT KEY filename (filename),
  KEY category (category_sn)
) ENGINE=MyISAM;


#
# �C�X�H�U��Ʈw���ƾڡG `file_db`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `fixed_check`
#

CREATE TABLE fixed_check (
  pc_id int(11) NOT NULL auto_increment,
  pro_kind_id varchar(12) NOT NULL default '',
  post_office tinyint(4) NOT NULL default '-1',
  teach_id varchar(20) NOT NULL default 'none',
  teach_title_id tinyint(4) NOT NULL default '-1',
  is_admin char(1) NOT NULL default '',
  PRIMARY KEY  (pc_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `fixed_check`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `fixed_kind`
#

CREATE TABLE fixed_kind (
  bk_id varchar(12) NOT NULL default '0',
  board_name varchar(20) NOT NULL default '',
  board_date date NOT NULL default '0000-00-00',
  board_k_id char(1) NOT NULL default '',
  board_last_date date NOT NULL default '0000-00-00',
  board_is_upload char(1) NOT NULL default '',
  board_is_public char(1) NOT NULL default '',
  board_admin varchar(100) NOT NULL default '',
  PRIMARY KEY  (bk_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `fixed_kind`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `fixedtb`
#

CREATE TABLE fixedtb (
  ID mediumint(9) NOT NULL auto_increment,
  even_T varchar(255) NOT NULL default '',
  even_doc text NOT NULL,
  unitId varchar(12) NOT NULL default '',
  user varchar(12) NOT NULL default '',
  even_date datetime NOT NULL default '0000-00-00 00:00:00',
  even_mode tinyint(4) NOT NULL default '0',
  rep_date datetime default NULL,
  rep_user varchar(12) default NULL,
  rep_doc text,
  rep_mode smallint(4) NOT NULL default '0',
  PRIMARY KEY  (ID)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `fixedtb`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `form_all`
#

CREATE TABLE form_all (
  ofsn smallint(5) unsigned NOT NULL auto_increment,
  of_title varchar(255) NOT NULL default '',
  of_start_date date NOT NULL default '0000-00-00',
  of_dead_line date NOT NULL default '0000-00-00',
  of_text text,
  of_who varchar(255) default NULL,
  teacher_sn smallint(5) unsigned NOT NULL default '0',
  of_communication varchar(255) default NULL,
  of_date datetime NOT NULL default '0000-00-00 00:00:00',
  enable enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (ofsn),
  KEY eduer_unit_sn (teacher_sn)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `form_all`
#

INSERT INTO form_all VALUES (1, '�L�D�D', '2002-12-30', '2002-12-30', '', NULL, 1, NULL, '2002-12-30 13:49:17', '0');
# --------------------------------------------------------

#
# ��ƪ�榡�G `form_col`
#

CREATE TABLE form_col (
  col_sn int(10) unsigned NOT NULL auto_increment,
  ofsn smallint(5) unsigned NOT NULL default '0',
  col_title varchar(255) NOT NULL default '',
  col_text text,
  col_dataType enum('date','varchar','int','bool') NOT NULL default 'date',
  col_value varchar(255) default NULL,
  col_chk enum('1','0') default NULL,
  col_function set('sum','avg','count') default NULL,
  col_sort tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (col_sn),
  KEY ofsn (ofsn)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `form_col`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `form_fill_in`
#

CREATE TABLE form_fill_in (
  schfi_sn int(10) unsigned NOT NULL auto_increment,
  ofsn smallint(5) unsigned NOT NULL default '0',
  teacher_sn smallint(5) unsigned NOT NULL default '0',
  man_name varchar(20) NOT NULL default '',
  tel varchar(10) NOT NULL default '',
  email varchar(50) NOT NULL default '',
  fill_time datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (schfi_sn),
  KEY ofsn (ofsn,teacher_sn),
  KEY SHN (teacher_sn)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `form_fill_in`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `form_value`
#

CREATE TABLE form_value (
  value_sn bigint(20) unsigned NOT NULL auto_increment,
  schfi_sn int(10) unsigned NOT NULL default '0',
  teacher_sn smallint(5) unsigned NOT NULL default '0',
  ofsn smallint(5) unsigned NOT NULL default '0',
  col_sn int(10) unsigned NOT NULL default '0',
  value varchar(255) NOT NULL default '',
  PRIMARY KEY  (value_sn),
  KEY schfi_sn (schfi_sn,ofsn,col_sn),
  KEY SHN (teacher_sn),
  KEY col_sn (col_sn)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `form_value`
#

# --------------------------------------------------------

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
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `grad_stud`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `gscore`
#

CREATE TABLE gscore (
  grad varchar(6) NOT NULL default '',
  classid varchar(4) NOT NULL default '',
  name varchar(10) default NULL,
  PRIMARY KEY  (grad,classid)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `gscore`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `inquire`
#

CREATE TABLE inquire (
  id int(11) NOT NULL auto_increment,
  even varchar(80) NOT NULL default '',
  doc varchar(255) NOT NULL default '',
  begdoc tinytext NOT NULL,
  bdate date NOT NULL default '0000-00-00',
  edate date NOT NULL default '0000-00-00',
  admin varchar(12) NOT NULL default '',
  hide_mode tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `inquire`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `lunchtb`
#

CREATE TABLE lunchtb (
  pDate date NOT NULL default '0000-00-00',
  pMday tinyint(4) NOT NULL default '0',
  pFood varchar(20) default NULL,
  pMenu varchar(120) default NULL,
  pFruit varchar(20) default NULL,
  pPs varchar(20) default NULL,
  pDesign varchar(20) default NULL,
  PRIMARY KEY  (pDate)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `lunchtb`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `new_board`
#

CREATE TABLE new_board (
  serial int(10) unsigned NOT NULL auto_increment,
  title varchar(200) NOT NULL default '�L�D�D',
  content text NOT NULL,
  teacher_sn smallint(5) unsigned NOT NULL default '1',
  post_date datetime NOT NULL default '0000-00-00 00:00:00',
  work_date date NOT NULL default '0000-00-00',
  FSN smallint(5) unsigned default NULL,
  image_url varchar(255) default NULL,
  PRIMARY KEY  (serial),
  KEY serial (serial)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `new_board`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `new_stud`
#

CREATE TABLE new_stud (
  newstud_sn int(10) NOT NULL auto_increment,
  stud_study_year tinyint(3) unsigned default NULL,
  old_school varchar(100) default NULL,
  stud_person_id varchar(20) default NULL,
  stud_name varchar(20) default NULL,
  stud_sex tinyint(3) unsigned default NULL,
  stud_tel_1 varchar(20) default NULL,
  stud_birthday date default NULL,
  guardian_name varchar(20) default NULL,
  stud_address varchar(200) default NULL,
  sure_study enum('1','0') default NULL,
  stud_id varchar(20) default NULL,
  class_year char(2) default NULL,
  class_sort tinyint(2) unsigned default NULL,
  class_site tinyint(2) unsigned default NULL,
  temp_score1 tinyint(4) NOT NULL default '-100',
  temp_score2 tinyint(4) NOT NULL default '-100',
  temp_score3 tinyint(4) NOT NULL default '-100',
  meno varchar(200) NOT NULL default '',
  UNIQUE KEY newstud_sn (newstud_sn)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `new_stud`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `pro_check_new`
#
CREATE TABLE pro_check_new (
  p_id int(10) unsigned NOT NULL auto_increment,
  pro_kind_id smallint(5) unsigned NOT NULL default '0',
  id_kind enum('�B��','�Юv','¾��','�Ǹ�','��L') default '��L',
  id_sn int(10) unsigned NOT NULL default '0',
  is_admin enum('0','1') NOT NULL default '0',
  set_sn int(10) unsigned NOT NULL default '0',
  p_start_date date NOT NULL default '0000-00-00',
  p_end_date date default NULL,
  oth_set varchar(20) default NULL,
  PRIMARY KEY  (p_id),
  KEY pro_kind_id (pro_kind_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `pro_check_new`
#

INSERT INTO pro_check_new VALUES (1, 1, '�Юv', 1, '0', 0, '0000-00-00', NULL, NULL);
INSERT INTO pro_check_new VALUES (2, 12, '¾��', 9, '1', 0, '0000-00-00', NULL, NULL);
INSERT INTO pro_check_new VALUES (6, 15, '�B��', 99, '0', 0, '0000-00-00', NULL, NULL);
INSERT INTO pro_check_new VALUES (7, 15, '�Юv', 1, '1', 0, '0000-00-00', NULL, NULL);
INSERT INTO pro_check_new VALUES (8, 13, '�B��', 3, '0', 0, '0000-00-00', NULL, NULL);
INSERT INTO pro_check_new VALUES (9, 13, '¾��', 9, '0', 0, '0000-00-00', NULL, NULL);
INSERT INTO pro_check_new VALUES (10, 56, '�Юv', 1, '0', 0, '0000-00-00', NULL, NULL);
INSERT INTO pro_check_new VALUES (11, 8, '�Юv', 1, '0', 0, '0000-00-00', NULL, NULL);
INSERT INTO pro_check_new VALUES (12, 2, '�Юv', 1, '0', 0, '0000-00-00', NULL, NULL);


#
# ��ƪ�榡�G `pro_check_stu`
#

CREATE TABLE pro_check_stu (
  pc_id int(11) NOT NULL auto_increment,
  pro_kind_id smallint(6) NOT NULL default '0',
  stud_id varchar(20) NOT NULL default '',
  teach_id varchar(20) NOT NULL default '',
  use_date datetime NOT NULL default '0000-00-00 00:00:00',
  use_last_date date NOT NULL default '0000-00-00',
  class_num varchar(6) NOT NULL default '',
  PRIMARY KEY  (pc_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `pro_check_stu`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `pro_module`
#

CREATE TABLE pro_module (
  pm_id bigint(11) NOT NULL auto_increment,
  pm_name varchar(30) NOT NULL default '',
  pm_item varchar(40) NOT NULL default '',
  pm_memo varchar(40) NOT NULL default '',
  pm_value varchar(100) NOT NULL default '',
  PRIMARY KEY  (pm_id),
  UNIQUE KEY pm_id (pm_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `pro_module`
#

INSERT INTO pro_module VALUES (1, 'book', 'lib_name', '�ϮѫǱ��X��ܳ���', '�~�H�Ϯѫ�');
INSERT INTO pro_module VALUES (2, 'book', 'barcore_cols', '�ϮѫǱ��X��ܦ��', '4');
INSERT INTO pro_module VALUES (3, 'book', 'barcare_type', '�ϮѫǱ��X�ϫ��榡(Png or Gif)', 'Png');
INSERT INTO pro_module VALUES (4, 'book', 'man_name', '�t�κ޲z���m�W', '�t�κ޲z��');
INSERT INTO pro_module VALUES (5, 'book', 'man_mail', '�޲z�� email', '');
INSERT INTO pro_module VALUES (6, 'book', 'data_mail', '��ƺ޲z��', '��ƺ޲z��');
INSERT INTO pro_module VALUES (7, 'book', 'man_ip1', '���ٮѭ��wIP 1', '163.17.169');
INSERT INTO pro_module VALUES (8, 'book', 'man_ip2', '���ٮѭ��wIP 2', '163.17.169.10');
INSERT INTO pro_module VALUES (9, 'book', 'man_ip3', '���ٮѭ��wIP 3', '163.17.169.11');
INSERT INTO pro_module VALUES (10, 'book', 'yetdate', '�ǥͭɾ\\���', '14');
INSERT INTO pro_module VALUES (11, 'book', 'tea_yetdate', '�Юv�ɾ\\���', '28');
INSERT INTO pro_module VALUES (12, 'book', 'sort_num', '�Ʀ�]��ܦW��', '40');
INSERT INTO pro_module VALUES (13, 'docup', 'file_max_size', '�W���ɮפj�p����(��� K)', '300');
INSERT INTO pro_module VALUES (14, 'lunch', 'IS_STANDALONE', '�O�_���W�ߪ��ɭ�(1�O,0�_)', '0');
INSERT INTO pro_module VALUES (15, 'mig', 'P_TITLE', '�{�����D', '�Ʀ�ۥ�');
INSERT INTO pro_module VALUES (16, 'mig', 'is_standalone', '�_���W�ߪ��ɭ�(1�O,0�_)', '0');
INSERT INTO pro_module VALUES (17, 'mig', 'convert_path', '���Y�{�����|(�Q�� whereis convert ���O�d', '/usr/bin/X11/');
INSERT INTO pro_module VALUES (18, 'mig', 'indexImgWidth', '�޹ϼe��(pix)', '96');
INSERT INTO pro_module VALUES (19, 'mig', 'ImgWidth', '���޹ϼe��(pix)', '500');
INSERT INTO pro_module VALUES (20, 'mig', 'maxFileSize', '���ɮ׭���j�p ���K', '13000');
INSERT INTO pro_module VALUES (21, 'mig', 'maxColumns', '������', '4');
INSERT INTO pro_module VALUES (22, 'score_input', 'yorn', '��y��n�A�O�_�C����Ұt�X�@�����ɦ��Z', 'y');
INSERT INTO pro_module VALUES (23, 'temp_compile', 'limit', '�C����ܸ�Ƶ���', '10');
INSERT INTO pro_module VALUES (24, 'board', 'page_count', '�C����ܵ���', '15');
INSERT INTO pro_module VALUES (25, 'board', 'is_standalone', '�O�_���W�ߪ��ɭ�(1 �O,0 �_', '0');
INSERT INTO pro_module VALUES (26, 'board', 'page_count', '�C����ܵ���', '15');
INSERT INTO pro_module VALUES (27, 'board', 'is_standalone', '�O�_���W�ߪ��ɭ�(1 �O,0 �_', '0');
# --------------------------------------------------------

#
# ��ƪ�榡�G `pro_module_main`
#

CREATE TABLE pro_module_main (
  pm_name varchar(30) NOT NULL default '',
  m_display_name varchar(60) NOT NULL default '',
  m_group_name varchar(30) NOT NULL default '',
  m_ver varchar(30) NOT NULL default '',
  m_create_date date NOT NULL default '0000-00-00',
  m_path varchar(60) NOT NULL default '',
  m_update_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (pm_name),
  UNIQUE KEY pm_name (pm_name)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `pro_module_main`
#

INSERT INTO pro_module_main VALUES ('book', '�ϮѺ޲z', '�հȦ�F', '2.0.1', '2002-12-15', 'school/book', '2003-03-19 08:30:00');
INSERT INTO pro_module_main VALUES ('docup', '����Ʈw', '�հȦ�F', '2.0.1', '2002-12-15', 'school/docup', '2003-03-19 08:30:00');
INSERT INTO pro_module_main VALUES ('lunch', '���\\���Ф��i', '�հȦ�F', '1.0.8', '2000-09-17', 'school/lunch', '2003-03-19 08:30:00');
INSERT INTO pro_module_main VALUES ('mig', '�Ʀ�ۥ�', '�հȦ�F', '2.0.1', '2002-12-15', 'school/mig', '2003-03-19 08:30:00');
INSERT INTO pro_module_main VALUES ('school_calendar', '�հȦ�ƾ�', '�հȦ�F', '1.0', '2003-03-24', 'school/school_calendar', '2003-03-24 08:30:00');
INSERT INTO pro_module_main VALUES ('board', '�հȧG�i��', '�հȦ�F', '2.0.1', '2002-12-15', '', '0000-00-00 00:00:00');
# --------------------------------------------------------

#
# ��ƪ�榡�G `pro_user_state`
#

CREATE TABLE pro_user_state (
  teacher_sn smallint(6) NOT NULL default '0',
  pu_state tinyint(4) NOT NULL default '0',
  pu_time datetime default NULL,
  pu_time_over datetime NOT NULL default '0000-00-00 00:00:00',
  pu_ip varchar(20) NOT NULL default ''
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `pro_user_state`
#

INSERT INTO pro_user_state VALUES (1, 0, '2003-04-30 01:08:59', '2003-04-30 01:10:53', '127.0.0.1');
# --------------------------------------------------------

#
# ��ƪ�榡�G `sch_doc1`
#

CREATE TABLE sch_doc1 (
  doc1_id varchar(10) NOT NULL default '',
  doc1_year_limit tinyint(3) unsigned NOT NULL default '0',
  doc1_kind tinyint(4) NOT NULL default '0',
  doc1_date date NOT NULL default '0000-00-00',
  doc1_date_sign datetime NOT NULL default '0000-00-00 00:00:00',
  doc1_unit varchar(60) NOT NULL default '',
  doc1_word varchar(60) NOT NULL default '',
  doc1_main tinytext NOT NULL,
  doc1_unit_num1 tinyint(4) NOT NULL default '0',
  doc1_unit_num2 varchar(6) NOT NULL default '',
  teach_id varchar(20) NOT NULL default '',
  doc1_k_id tinyint(1) NOT NULL default '0',
  doc_stat char(1) NOT NULL default '1',
  doc1_end_date date NOT NULL default '0000-00-00',
  doc1_infile_date date NOT NULL default '0000-00-00',
  do_teacher varchar(20) NOT NULL default '',
  PRIMARY KEY  (doc1_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `sch_doc1`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `sch_doc1_unit`
#

CREATE TABLE sch_doc1_unit (
  doc1_unit_num1 tinyint(4) NOT NULL auto_increment,
  doc1_unit_name varchar(20) NOT NULL default '',
  PRIMARY KEY  (doc1_unit_num1)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `sch_doc1_unit`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `school_base`
#

CREATE TABLE school_base (
  sch_id varchar(6) NOT NULL default '',
  sch_attr_id varchar(6) NOT NULL default '',
  sch_cname varchar(40) NOT NULL default '',
  sch_cname_s varchar(40) NOT NULL default '',
  sch_cname_ss varchar(40) NOT NULL default '',
  sch_ename varchar(40) NOT NULL default '',
  sch_sheng varchar(10) NOT NULL default '',
  sch_cdate date NOT NULL default '0000-00-00',
  sch_mark varchar(8) NOT NULL default '',
  sch_class varchar(8) NOT NULL default '',
  sch_montain char(2) NOT NULL default '',
  sch_area_tol float(10,2) NOT NULL default '0.00',
  sch_area_ext float(10,2) NOT NULL default '0.00',
  sch_area_pin float(10,2) NOT NULL default '0.00',
  sch_money float(10,2) NOT NULL default '0.00',
  sch_money_o float(10,2) NOT NULL default '0.00',
  sch_local_name varchar(10) NOT NULL default '',
  sch_post_num varchar(5) NOT NULL default '',
  sch_addr varchar(60) NOT NULL default '',
  sch_phone varchar(20) default NULL,
  sch_fax varchar(20) default NULL,
  sch_area varchar(20) NOT NULL default '',
  sch_kind varchar(6) NOT NULL default '',
  sch_url varchar(50) NOT NULL default '',
  sch_email varchar(30) NOT NULL default '',
  update_time datetime NOT NULL default '0000-00-00 00:00:00',
  update_id varchar(20) NOT NULL default '',
  update_ip varchar(15) NOT NULL default '',
  PRIMARY KEY  (sch_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `school_base`
#

INSERT INTO school_base VALUES ('', '����', '�ն�ۥѳn���y��', '�ն�ۥѳn���y��', '�ն�ۥѳn���y��', 'sfs', '', '0000-00-00', '���`', '�@��a��', '�_', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '', '', '', '2003-02-14 15:17:15', '', '127.0.0.1');
# --------------------------------------------------------

#
# ��ƪ�榡�G `school_class`
#

CREATE TABLE school_class (
  class_sn mediumint(8) unsigned NOT NULL auto_increment,
  class_id varchar(11) NOT NULL default '',
  year smallint(5) unsigned NOT NULL default '0',
  semester enum('1','2') NOT NULL default '1',
  c_year tinyint(2) unsigned NOT NULL default '0',
  c_name varchar(20) default NULL,
  c_kind varchar(30) default '�@��Z',
  c_sort tinyint(3) unsigned NOT NULL default '0',
  enable enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (class_sn),
  KEY year (year,semester)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `school_class`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `school_class_num`
#

CREATE TABLE school_class_num (
  curr_class_year varchar(5) NOT NULL default '',
  c_year char(3) NOT NULL default '0',
  c_num tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (curr_class_year,c_year)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `school_class_num`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `school_day`
#

CREATE TABLE school_day (
  day_kind varchar(40) NOT NULL default '',
  day date NOT NULL default '0000-00-00',
  year tinyint(2) unsigned NOT NULL default '0',
  seme enum('1','2') NOT NULL default '1',
  UNIQUE KEY year_seme (day_kind,year,seme)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `school_day`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `school_room`
#

CREATE TABLE school_room (
  room_id tinyint(3) unsigned NOT NULL auto_increment,
  room_name varchar(30) NOT NULL default '',
  room_tel varchar(20) NOT NULL default '',
  room_fax varchar(20) NOT NULL default '',
  enable enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (room_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `school_room`
#

INSERT INTO school_room VALUES (1, '�ժ���', '', '', '1');
INSERT INTO school_room VALUES (2, '�аȳB', '', '', '1');
INSERT INTO school_room VALUES (3, '�V�ɳB', '', '', '1');
INSERT INTO school_room VALUES (4, '�`�ȳB', '', '', '1');
INSERT INTO school_room VALUES (5, '���ɫ�', '', '', '1');
INSERT INTO school_room VALUES (6, '�H�ƫ�', '', '', '1');
INSERT INTO school_room VALUES (7, '�|�p��', '', '', '1');
INSERT INTO school_room VALUES (8, '�ť��ɮv', '', '', '1');
INSERT INTO school_room VALUES (9, '����Юv', '', '', '1');
INSERT INTO school_room VALUES (10, '���X��', '', '', '1');
INSERT INTO school_room VALUES (11, '�귽�Z', '', '', '1');
INSERT INTO school_room VALUES (12, '�S�ЯZ', '', '', '1');
INSERT INTO school_room VALUES (13, '��T����', '', '', '1');
# --------------------------------------------------------

#
# ��ƪ�榡�G `school_subject`
#

CREATE TABLE school_subject (
  sub_id int(10) unsigned NOT NULL auto_increment,
  seme_year_seme varchar(6) NOT NULL default '',
  sub_name char(3) NOT NULL default '',
  sub_course char(1) NOT NULL default '',
  sub_year char(2) NOT NULL default '',
  is_exam char(1) NOT NULL default '',
  sub_num char(2) NOT NULL default '',
  sub_percent char(3) NOT NULL default '',
  update_id varchar(20) NOT NULL default '',
  update_time timestamp NOT NULL,
  PRIMARY KEY  (sub_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `school_subject`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `score_course`
#

CREATE TABLE score_course (
  course_id mediumint(8) unsigned NOT NULL auto_increment,
  year smallint(5) unsigned NOT NULL default '0',
  semester enum('1','2') NOT NULL default '1',
  class_id varchar(11) NOT NULL default '',
  teacher_sn mediumint(9) NOT NULL default '0',
  class_year tinyint(2) unsigned NOT NULL default '0',
  class_name tinyint(2) unsigned NOT NULL default '0',
  day enum('0','1','2','3','4','5','6','7') default NULL,
  sector tinyint(1) NOT NULL default '0',
  ss_id smallint(5) unsigned NOT NULL default '0',
  room varchar(10) default NULL,
  allow enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (course_id),
  KEY class_name (class_name),
  KEY class_year (class_year),
  KEY year (year,semester)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `score_course`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `score_input_col`
#

CREATE TABLE score_input_col (
  col_sn smallint(5) unsigned NOT NULL auto_increment,
  interface_sn tinyint(4) NOT NULL default '0',
  col_text varchar(255) default NULL,
  col_value varchar(255) default NULL,
  col_type varchar(20) NOT NULL default '',
  col_fn varchar(255) default NULL,
  col_ss enum('n','y') NOT NULL default 'n',
  col_comment enum('n','y') NOT NULL default 'n',
  col_check enum('0','1') default '0',
  col_date datetime default NULL,
  enable enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (col_sn),
  KEY interface_sn (interface_sn)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `score_input_col`
#

INSERT INTO score_input_col VALUES (2, 1, '��`�欰��{', '��{�u��,��{�}�n,��{�|�i,�ݦA�[�o,���ݧ�i', 'select', '', 'n', 'n', '0', '2002-12-13 14:21:52', '1');
INSERT INTO score_input_col VALUES (3, 1, '���鬡�ʪ�{', '��{�u��,��{�}�n,��{�|�i,�ݦA�[�o,���ݧ�i', 'select', '', 'n', 'n', '0', '2002-12-13 14:21:57', '1');
INSERT INTO score_input_col VALUES (4, 1, '���@�A��', '��{�u��,��?{�}�n,��{�|�i,�ݦA�[�o,���ݧ�i', 'select', '', 'n', 'n', '0', '2002-12-13 14:21:47', '1');
INSERT INTO score_input_col VALUES (5, 1, '�ե~�S���{', '��{�u��,��{�}�n,��{�|�i,�ݦA�[�o,���ݧ�i', 'select', '', 'n', 'n', '0', '2002-12-13 14:22:21', '1');
INSERT INTO score_input_col VALUES (6, 1, '�ɮv���y�Ϋ�ĳ', '', 'textarea', '', 'n', 'y', '0', '2002-12-19 10:29:00', '1');
INSERT INTO score_input_col VALUES (7, 1, '����', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:23:17', '1');
INSERT INTO score_input_col VALUES (9, 1, '�ư��`��', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:24:47', '1');
INSERT INTO score_input_col VALUES (10, 1, '�f���`��', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:25:08', '1');
INSERT INTO score_input_col VALUES (11, 1, '�m�Ҹ`��', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:25:43', '1');
INSERT INTO score_input_col VALUES (12, 1, '���|����', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:26:01', '1');
INSERT INTO score_input_col VALUES (13, 1, '�����`��', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:26:38', '1');
INSERT INTO score_input_col VALUES (14, 1, '��L�`��', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:26:53', '1');
INSERT INTO score_input_col VALUES (16, 1, '�j�\\����', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:27:21', '1');
INSERT INTO score_input_col VALUES (17, 1, '�p�\\����', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:27:43', '1');
INSERT INTO score_input_col VALUES (18, 1, '�p�L����', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:27:58', '1');
INSERT INTO score_input_col VALUES (19, 1, '�ż�����', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:28:17', '1');
INSERT INTO score_input_col VALUES (20, 1, '�j�L����', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:28:30', '1');
INSERT INTO score_input_col VALUES (21, 1, 'ĵ�i����', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:28:43', '1');
INSERT INTO score_input_col VALUES (22, 1, '��L', '', 'text', '', 'n', 'n', '0', '2002-12-13 14:29:12', '1');
INSERT INTO score_input_col VALUES (24, 1, '�C�g�`��', '', 'text', 'get_ss_num', 'y', 'n', '0', '2002-12-17 11:38:07', '1');
INSERT INTO score_input_col VALUES (25, 1, '�V�O�{��', '��{�u��,��{�}�n,��{�|�i,�ݦA�[�o,���ݧ�i', 'select', '', 'y', 'n', '0', '2002-12-13 14:30:51', '1');
INSERT INTO score_input_col VALUES (26, 1, '�ǲߦ��N', '', 'text', 'get_ss_score', 'y', 'n', '0', '2002-12-17 11:38:51', '1');
INSERT INTO score_input_col VALUES (27, 1, '�ǲߴy�z��r����', '', 'text', '', 'y', 'y', '0', '2002-12-19 10:29:12', '1');
# --------------------------------------------------------

#
# ��ƪ�榡�G `score_input_interface`
#

CREATE TABLE score_input_interface (
  interface_sn tinyint(3) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  text text NOT NULL,
  html text NOT NULL,
  sshtml text,
  xml text,
  all_ss enum('n','y') NOT NULL default 'n',
  PRIMARY KEY  (interface_sn)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `score_input_interface`
#

INSERT INTO score_input_interface VALUES (1, '�w�]���Z��', '�����Z��A�X�E�~�@�e�ҵ{�A���Z�檩���ϥΤ��Ϥ������E�~�@�e�ҵ{�����p�������Z���q�q���Ѯ榡�C', '<table cellspacing="0" cellpadding="0" class="small">\r\n<tr>\r\n<td>\r\n	<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" class="small">\r\n	<tr bgcolor="white">\r\n	<td colspan="13" nowrap>�@�B��`�ͬ���{���q</td>\r\n	</tr>\r\n	<tr bgcolor="white">\r\n	<td nowrap>��`�欰��{</td>\r\n	<td colspan="3">{2_��J��}</td>\r\n	<td colspan="8" nowrap>�ɮv���y�Ϋ�ĳ</td>\r\n	<td nowrap>����</td>\r\n	</tr>\r\n	<tr bgcolor="white">\r\n	<td nowrap>���鬡�ʪ�{</td>\r\n	<td colspan="3">{3_��J��}</td>\r\n	<td rowspan="3" colspan="8">{6_��J��}</td>\r\n	<td rowspan="3" colspan="1">{7_��J��}</td>\r\n	</tr>\r\n	<tr bgcolor="white">\r\n	<td nowrap>���@�A��</td>\r\n	<td colspan="3">{4_��J��}</td>\r\n	</tr>\r\n	<tr bgcolor="white">\r\n	<td nowrap>�ե~�S���{</td>\r\n	<td colspan="3">{5_��J��}</td>\r\n	</tr>\r\n	<tr bgcolor="white">\r\n	<td nowrap>�ǥͯʮu���p<br>\r\n	</td>\r\n	<td nowrap>�ư�<br>�`��</td>\r\n	<td>{9_��J��}</td>\r\n	<td nowrap>�f��<br>�`��</td>\r\n	<td>{10_��J��}</td>\r\n	<td nowrap>�m��<br>�`��</td>\r\n	<td>{11_��J��}</td>\r\n	<td nowrap>���|<br>����</td>\r\n	<td>{12_��J��}</td>\r\n	<td nowrap>����<br>�`��</td>\r\n	<td>{13_��J��}</td>\r\n	<td nowrap>��L<br>�`��</td>\r\n	<td>{14_��J��}</td>\r\n	</tr>\r\n	<tr bgcolor="white">\r\n	<td nowrap>���g<br>\r\n	</td>\r\n	<td nowrap>�j�\\<br>����</td>\r\n	<td>{16_��J��}</td>\r\n	<td nowrap>�p�\\<br>����</td>\r\n	<td>{17_��J��}</td>\r\n	<td nowrap>�ż�<br>����</td>\r\n	<td>{18_��J��}</td>\r\n	<td nowrap>�j�L<br>����</td>\r\n	<td>{19_��J��}</td>\r\n	<td nowrap>�p�L<br>����</td>\r\n	<td>{20_��J��}</td>\r\n	<td nowrap>ĵ�i<br>����</td>\r\n	<td>{21_��J��}</td>\r\n	</tr>\r\n	<tr bgcolor="white">\r\n	<td nowrap>��L</td>\r\n	<td colspan="12">{22_��J��}</td>\r\n	</tr>\r\n	</table>\r\n</td></tr>\r\n<tr><td>\r\n	<table bgcolor="#9ebcdd" cellspacing="1" cellpadding="4" width="100%" class="small">\r\n	<tr bgcolor="#c4d9ff">\r\n	<td>���</td>\r\n	<td align="center">�C�g�`��</td>\r\n	<td align="center">�V�O�{��</td>\r\n	<td align="center">�ǲߦ��N</td>\r\n	<td align="center">�ǲߴy�z��r����</td>\r\n	</tr>\r\n\r\n	<!--���B�|�۰ʥ[�J�U��y�M��ج������z���]�w-->\r\n</table>\r\n</td>\r\n</tr>\r\n</table>\r\n', '<tr bgcolor=\'white\'>\r\n<td>{��ئW��}</td>\r\n<td align=\'center\'>{24_��J��}�`</td>\r\n<td>{25_��J��}</td>\r\n<td align=\'center\'>{26_��J��}</td>\r\n<td>{27_��J��}</td>\r\n</tr>\r\n', '<table:table-row table:style-name="ss_table.1"><table:table-cell table:style-name="ss_table.A2" table:value-type="string"><text:p text:style-name="P5">{ss_name}</text:p></table:table-cell><table:table-cell table:style-name="ss_table.A2" table:value-type="string"><text:p text:style-name="P5">{24_{ss_sn}}</text:p></table:table-cell><table:table-cell table:style-name="ss_table.A2" table:value-type="string"><text:p text:style-name="P5">{25_{ss_sn}}</text:p></table:table-cell><table:table-cell table:style-name="ss_table.A2" table:value-type="string"><text:p text:style-name="P5">{26_{ss_sn}}</text:p></table:table-cell><table:table-cell table:style-name="ss_table.E2" table:value-type="string"><text:p text:style-name="P11">{27_{ss_sn}}</text:p></table:table-cell></table:table-row>', 'y');
# --------------------------------------------------------

#
# ��ƪ�榡�G `score_input_value`
#

CREATE TABLE score_input_value (
  sc_sn int(10) unsigned NOT NULL auto_increment,
  interface_sn tinyint(4) NOT NULL default '0',
  date datetime NOT NULL default '0000-00-00 00:00:00',
  stud_id varchar(20) NOT NULL default '',
  class_id varchar(11) NOT NULL default '',
  value text NOT NULL,
  sel_year smallint(5) NOT NULL default '0',
  sel_seme enum('1','2') NOT NULL default '1',
  PRIMARY KEY  (sc_sn),
  KEY stud_id (stud_id),
  KEY class_id (class_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `score_input_value`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `score_setup`
#

CREATE TABLE score_setup (
  setup_id smallint(5) unsigned NOT NULL auto_increment,
  year smallint(5) unsigned NOT NULL default '0',
  semester enum('1','2') NOT NULL default '1',
  class_year tinyint(2) unsigned NOT NULL default '0',
  allow_modify enum('false','true') NOT NULL default 'false',
  performance_test_times tinyint(1) unsigned default NULL,
  practice_test_times tinyint(2) unsigned default NULL,
  test_ratio varchar(255) default NULL,
  rule varchar(255) NOT NULL default '',
  score_mode enum('all','severally') NOT NULL default 'all',
  sections tinyint(4) NOT NULL default '8',
  interface_sn tinyint(3) unsigned NOT NULL default '1',
  update_date datetime NOT NULL default '0000-00-00 00:00:00',
  enable enum('1','0','always') NOT NULL default '1',
  PRIMARY KEY  (setup_id),
  KEY year (year,semester)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `score_setup`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `score_ss`
#

CREATE TABLE score_ss (
  ss_id smallint(5) unsigned NOT NULL auto_increment,
  scope_id tinyint(3) unsigned NOT NULL default '0',
  subject_id tinyint(3) unsigned NOT NULL default '0',
  year smallint(5) unsigned NOT NULL default '0',
  semester enum('1','2') NOT NULL default '1',
  class_id varchar(11) NOT NULL default '',
  class_year tinyint(4) unsigned NOT NULL default '0',
  enable enum('1','0') NOT NULL default '1',
  need_exam enum('1','0') NOT NULL default '1',
  rate tinyint(3) unsigned NOT NULL default '0',
  sort float default NULL,
  sub_sort tinyint(3) unsigned default NULL,
  print enum('1','0') default NULL,
  link_ss varchar(200) NOT NULL default '',
  PRIMARY KEY  (ss_id),
  KEY scope_id (scope_id,subject_id,year),
  KEY class_year (class_year),
  KEY sort (sort),
  KEY class_id (class_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `score_ss`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `score_subject`
#

CREATE TABLE score_subject (
  subject_id tinyint(3) unsigned NOT NULL auto_increment,
  subject_name varchar(255) NOT NULL default '',
  subject_school set('0','1','2','3','4','5','6','7','8','9','10','11','12') default NULL,
  subject_kind enum('scope','subject') default NULL,
  enable enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (subject_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `score_subject`
#

INSERT INTO score_subject VALUES (1, ' �y��', '', 'scope', '1');
INSERT INTO score_subject VALUES (2, '���d�P��|', '', 'scope', '1');
INSERT INTO score_subject VALUES (3, '�ͬ�', '', 'scope', '1');
INSERT INTO score_subject VALUES (4, '�ƾ�', '', 'scope', '1');
INSERT INTO score_subject VALUES (5, '��X����', '', 'scope', '1');
INSERT INTO score_subject VALUES (6, '��y', '', 'subject', '1');
INSERT INTO score_subject VALUES (7, '�m�g�y��', '', 'subject', '1');
INSERT INTO score_subject VALUES (8, '�u�ʽҵ{', '', 'scope', '1');
INSERT INTO score_subject VALUES (9, '���|', '', 'scope', '1');
INSERT INTO score_subject VALUES (10, '���N�P�H��', '', 'scope', '1');
INSERT INTO score_subject VALUES (11, '�۵M�P�ͬ����', '', 'scope', '1');
INSERT INTO score_subject VALUES (12, '�۵M', '', 'subject', '1');
INSERT INTO score_subject VALUES (13, '�q��', '', 'subject', '1');
INSERT INTO score_subject VALUES (14, '���ɬ���', '', 'scope', '1');
# --------------------------------------------------------

#
# ��ƪ�榡�G `seme_class`
#

CREATE TABLE seme_class (
  current_school_year smallint(4) NOT NULL default '0',
  teach_id varchar(20) NOT NULL default '',
  teach_title_id tinyint(4) NOT NULL default '0',
  class_num varchar(6) NOT NULL default '',
  subject_id1 tinyint(3) NOT NULL default '0',
  subject_id2 tinyint(3) unsigned NOT NULL default '0',
  subject_id3 tinyint(3) unsigned NOT NULL default '0',
  subject_id4 tinyint(3) NOT NULL default '0',
  subject_id5 tinyint(3) unsigned NOT NULL default '0',
  subject_id6 tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (current_school_year,teach_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `seme_class`
#

INSERT INTO seme_class VALUES (891, '1002', 19, '200', 0, 0, 0, 0, 0, 0);
INSERT INTO seme_class VALUES (891, '1001', 9, '', 0, 0, 0, 0, 0, 0);
# --------------------------------------------------------

#
# ��ƪ�榡�G `sfs3_log`
#

CREATE TABLE sfs3_log (
  log_sn int(10) unsigned NOT NULL auto_increment,
  log text NOT NULL,
  mark varchar(255) NOT NULL default '',
  id varchar(20) NOT NULL default '',
  time datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (log_sn)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `sfs3_log`
#

INSERT INTO sfs3_log VALUES (1, '�R�� absent �Ҳզbsfs_module�����]�w�C<br>�R�� absent �Ҳզbpro_check_new�����v���]�w�C<br>�R�� absent �Ҳզbpro_module�����ܼƳ]�w�C<br>absent �O�зǼҲաA�}�l�i��ﶵ�θ�ƪ��ʡC<br>�� stud_absent ��W�� garbage_1051152485_stud_absent �C', 'del_module', '1001', '2003-04-24 10:48:05');
# --------------------------------------------------------

#
# ��ƪ�榡�G `sfs_log`
#

CREATE TABLE sfs_log (
  log_id bigint(20) NOT NULL auto_increment,
  log_user varchar(20) NOT NULL default '',
  log_table varchar(40) NOT NULL default '',
  log_time timestamp NOT NULL,
  log_ip varchar(16) NOT NULL default '',
  update_kind enum('insert','update','delete','query') NOT NULL default 'insert',
  chang_id varchar(20) NOT NULL default '',
  PRIMARY KEY  (log_id),
  KEY log_user (log_user)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `sfs_log`
#

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
) ;

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
# ��ƪ�榡�G `sfs_text`
#

CREATE TABLE sfs_text (
  t_id int(11) NOT NULL auto_increment,
  t_order_id int(11) NOT NULL default '0',
  t_kind varchar(20) NOT NULL default '',
  g_id tinyint(4) NOT NULL default '0',
  d_id varchar(20) NOT NULL default '',
  t_name varchar(50) NOT NULL default '',
  t_parent varchar(60) NOT NULL default '',
  p_id int(11) NOT NULL default '0',
  p_dot varchar(20) NOT NULL default '',
  PRIMARY KEY  (t_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `sfs_text`
#

INSERT INTO sfs_text VALUES (1, 0, 'addr', 1, '0', '��}', '', 0, '');
INSERT INTO sfs_text VALUES (23, 6, 'addr', 1, '6', '�s����', '1,3,5,', 5, '...');
INSERT INTO sfs_text VALUES (22, 5, 'addr', 1, '5', '��Z��', '1,3,5,', 5, '...');
INSERT INTO sfs_text VALUES (20, 4, 'addr', 1, '4', '���n��', '1,3,5,', 5, '...');
INSERT INTO sfs_text VALUES (17, 10, 'addr', 1, '10', '���l��', '1,3,4,', 4, '...');
INSERT INTO sfs_text VALUES (18, 9, 'addr', 1, '9', '�g����', '1,3,4,', 4, '...');
INSERT INTO sfs_text VALUES (24, 3, 'addr', 1, '3', '���w��', '1,3,5,', 5, '...');
INSERT INTO sfs_text VALUES (12, 6, 'addr', 1, '6', '���ק�', '1,3,4,', 4, '...');
INSERT INTO sfs_text VALUES (16, 8, 'addr', 1, '8', '�K�s��', '1,3,4,', 4, '...');
INSERT INTO sfs_text VALUES (13, 5, 'addr', 1, '5', '�T�r��', '1,3,4,', 4, '...');
INSERT INTO sfs_text VALUES (14, 7, 'addr', 1, '7', '������', '1,3,4,', 4, '...');
INSERT INTO sfs_text VALUES (15, 4, 'addr', 1, '4', '�����', '1,3,4,', 4, '...');
INSERT INTO sfs_text VALUES (21, 2, 'addr', 1, '2', '�q�M��', '1,3,5,', 5, '...');
INSERT INTO sfs_text VALUES (19, 1, 'addr', 1, '1', '���s��', '1,3,5,', 5, '...');
INSERT INTO sfs_text VALUES (10, 3, 'addr', 1, '3', '������', '1,3,4,', 4, '...');
INSERT INTO sfs_text VALUES (11, 2, 'addr', 1, '2', '���s��', '1,3,4,', 4, '...');
INSERT INTO sfs_text VALUES (6, 0, 'addr', 1, '0', '�j�P��', '1,3,4,', 4, '...');
INSERT INTO sfs_text VALUES (5, 1, 'addr', 1, '1', '�j����', '1,3,', 3, '..');
INSERT INTO sfs_text VALUES (4, 0, 'addr', 1, '0', '�~�H�m', '1,3,', 3, '..');
INSERT INTO sfs_text VALUES (3, 0, 'addr', 1, '0', '�O����', '1,', 1, '.');
INSERT INTO sfs_text VALUES (26, 2, 'addr', 1, '2', '�Z���m', '1,3,', 3, '..');
INSERT INTO sfs_text VALUES (25, 0, 'addr', 1, '0', '���s��', '1,3,5,', 5, '...');
INSERT INTO sfs_text VALUES (9, 1, 'addr', 1, '1', '�j�F��', '1,3,4,', 4, '...');
INSERT INTO sfs_text VALUES (27, 0, 'addr', 1, '0', '�ӥ���', '1,3,26,', 26, '...');
INSERT INTO sfs_text VALUES (28, 1, 'addr', 1, '1', '�ܤs��', '1,3,26,', 26, '...');
INSERT INTO sfs_text VALUES (29, 2, 'addr', 1, '2', '��ܧ�', '1,3,26,', 26, '...');
INSERT INTO sfs_text VALUES (30, 0, 'stud_kind', 1, '0', '�ǥͨ����O', '', 0, '');
INSERT INTO sfs_text VALUES (31, 0, 'stud_spe_kind', 1, '0', '�S��Z���O', '', 0, '');
INSERT INTO sfs_text VALUES (33, 0, 'preschool_status', 1, '0', '�J�Ǹ��', '', 0, '');
INSERT INTO sfs_text VALUES (32, 0, 'spe_class_kind', 1, '0', '�S��Z�Z�O', '', 0, '');
INSERT INTO sfs_text VALUES (34, 0, 'post_kind', 2, '0', '¾�O', '', 0, '');
INSERT INTO sfs_text VALUES (35, 0, 'preschool_status', 1, '0', '���ǰ�', '33,', 33, '.');
INSERT INTO sfs_text VALUES (36, 1, 'preschool_status', 1, '1', '�j�ǰ�', '33,', 33, '.');
INSERT INTO sfs_text VALUES (37, 2, 'preschool_status', 1, '2', '�H���NŪ', '33,', 33, '.');
INSERT INTO sfs_text VALUES (38, 3, 'preschool_status', 1, '3', '�H���NŪ', '33,', 33, '.');
INSERT INTO sfs_text VALUES (39, 1, 'post_kind', 2, '1', '�ժ�', '34,', 34, '.');
INSERT INTO sfs_text VALUES (40, 2, 'post_kind', 2, '2', '�Юv�ݥD��', '34,', 34, '.');
INSERT INTO sfs_text VALUES (41, 3, 'post_kind', 2, '3', '�D��', '34,', 34, '.');
INSERT INTO sfs_text VALUES (42, 4, 'post_kind', 2, '4', '�Юv�ݲժ�', '34,', 34, '.');
INSERT INTO sfs_text VALUES (43, 5, 'post_kind', 2, '5', '�ժ�', '34,', 34, '.');
INSERT INTO sfs_text VALUES (44, 6, 'post_kind', 2, '6', '�ɮv', '34,', 34, '.');
INSERT INTO sfs_text VALUES (45, 7, 'post_kind', 2, '7', '�M���Юv', '34,', 34, '.');
INSERT INTO sfs_text VALUES (46, 8, 'post_kind', 2, '8', '��߱Юv', '34,', 34, '.');
INSERT INTO sfs_text VALUES (47, 9, 'post_kind', 2, '9', '�եαЮv', '34,', 34, '.');
INSERT INTO sfs_text VALUES (48, 10, 'post_kind', 2, '10', '�N�z/�N�ұЮv', '34,', 34, '.');
INSERT INTO sfs_text VALUES (49, 11, 'post_kind', 2, '11', '�ݥ��Юv', '34,', 34, '.');
INSERT INTO sfs_text VALUES (50, 12, 'post_kind', 2, '12', '¾��', '34,', 34, '.');
INSERT INTO sfs_text VALUES (51, 13, 'post_kind', 2, '13', '�@�h', '34,', 34, '.');
INSERT INTO sfs_text VALUES (52, 14, 'post_kind', 2, '14', 'ĵ��', '34,', 34, '.');
INSERT INTO sfs_text VALUES (53, 15, 'post_kind', 2, '15', '�u��', '34,', 34, '.');
INSERT INTO sfs_text VALUES (54, 0, 'stud_kind', 1, '0', '�@��ǥ�', '30,', 30, '.');
INSERT INTO sfs_text VALUES (55, 1, 'stud_kind', 1, '1', '���H�ݻ�', '30,', 30, '.');
INSERT INTO sfs_text VALUES (56, 2, 'stud_kind', 1, '2', '�a���ݻ�', '30,', 30, '.');
INSERT INTO sfs_text VALUES (57, 3, 'stud_kind', 1, '3', '�C���J��', '30,', 30, '.');
INSERT INTO sfs_text VALUES (58, 4, 'stud_kind', 1, '4', '�j���ӥx�̿˪�', '30,', 30, '.');
INSERT INTO sfs_text VALUES (59, 5, 'stud_kind', 1, '5', '�\\���l�k', '30,', 30, '.');
INSERT INTO sfs_text VALUES (60, 6, 'stud_kind', 1, '6', '���~����', '30,', 30, '.');
INSERT INTO sfs_text VALUES (61, 7, 'stud_kind', 1, '7', '��D��', '30,', 30, '.');
INSERT INTO sfs_text VALUES (62, 8, 'stud_kind', 1, '8', '��æ��', '30,', 30, '.');
INSERT INTO sfs_text VALUES (63, 9, 'stud_kind', 1, '9', '����', '30,', 30, '.');
INSERT INTO sfs_text VALUES (64, 10, 'stud_kind', 1, '10', '�~�y��', '30,', 30, '.');
INSERT INTO sfs_text VALUES (65, 11, 'stud_kind', 1, '11', '���u��', '30,', 30, '.');
INSERT INTO sfs_text VALUES (66, 12, 'stud_kind', 1, '12', '���~�H���l�k', '30,', 30, '.');
INSERT INTO sfs_text VALUES (67, 13, 'stud_kind', 1, '13', '��|�Z�u', '30,', 30, '.');
INSERT INTO sfs_text VALUES (68, 14, 'stud_kind', 1, '14', '�C���˴�', '30,', 30, '.');
INSERT INTO sfs_text VALUES (69, 15, 'stud_kind', 1, '15', '��¾���l�k', '30,', 30, '.');
INSERT INTO sfs_text VALUES (70, 16, 'stud_kind', 1, '16', '���п��(�]��)', '30,', 30, '.');
INSERT INTO sfs_text VALUES (71, 17, 'stud_kind', 1, '17', '���п��(�]�f)', '30,', 30, '.');
INSERT INTO sfs_text VALUES (72, 18, 'stud_kind', 1, '18', '���߻�ê(�˩w)', '30,', 30, '.');
INSERT INTO sfs_text VALUES (73, 19, 'stud_kind', 1, '19', '��L', '30,', 30, '.');
INSERT INTO sfs_text VALUES (74, 1, 'stud_spe_kind', 1, '1', '��ê��', '31,', 31, '.');
INSERT INTO sfs_text VALUES (75, 2, 'stud_spe_kind', 1, '2', '���u��', '31,', 31, '.');
INSERT INTO sfs_text VALUES (76, 3, 'stud_spe_kind', 1, '3', '�귽�Z', '31,', 31, '.');
INSERT INTO sfs_text VALUES (77, 1, 'spe_class_kind', 1, '1', '�Ҵ�', '32,', 32, '.');
INSERT INTO sfs_text VALUES (78, 2, 'spe_class_kind', 1, '2', '�ҩ�', '32,', 32, '.');
INSERT INTO sfs_text VALUES (79, 3, 'spe_class_kind', 1, '3', '���o', '32,', 32, '.');
INSERT INTO sfs_text VALUES (80, 4, 'spe_class_kind', 1, '4', '���j����', '32,', 32, '.');
INSERT INTO sfs_text VALUES (81, 5, 'spe_class_kind', 1, '5', '�Ҿ�', '32,', 32, '.');
INSERT INTO sfs_text VALUES (82, 6, 'spe_class_kind', 1, '6', '���n', '32,', 32, '.');
INSERT INTO sfs_text VALUES (83, 7, 'spe_class_kind', 1, '7', '�Ұ�', '32,', 32, '.');
INSERT INTO sfs_text VALUES (84, 8, 'spe_class_kind', 1, '8', '�ҭ}', '32,', 32, '.');
INSERT INTO sfs_text VALUES (85, 9, 'spe_class_kind', 1, '9', '�Ҥ�(�ϻ�)', '32,', 32, '.');
INSERT INTO sfs_text VALUES (86, 10, 'spe_class_kind', 1, '10', '�y��', '32,', 32, '.');
INSERT INTO sfs_text VALUES (87, 11, 'spe_class_kind', 1, '11', '���߻�ê', '32,', 32, '.');
INSERT INTO sfs_text VALUES (88, 12, 'spe_class_kind', 1, '12', '�ǲߧx��', '32,', 32, '.');
INSERT INTO sfs_text VALUES (89, 13, 'spe_class_kind', 1, '13', '�b�a�Ш|', '32,', 32, '.');
INSERT INTO sfs_text VALUES (90, 14, 'spe_class_kind', 1, '14', '�h����ê', '32,', 32, '.');
INSERT INTO sfs_text VALUES (91, 15, 'spe_class_kind', 1, '15', '�@�봼���u��', '32,', 32, '.');
INSERT INTO sfs_text VALUES (92, 16, 'spe_class_kind', 1, '16', '����', '32,', 32, '.');
INSERT INTO sfs_text VALUES (93, 17, 'spe_class_kind', 1, '17', '���N', '32,', 32, '.');
INSERT INTO sfs_text VALUES (94, 18, 'spe_class_kind', 1, '18', '�R��', '32,', 32, '.');
INSERT INTO sfs_text VALUES (95, 19, 'spe_class_kind', 1, '19', '��|', '32,', 32, '.');
INSERT INTO sfs_text VALUES (96, 20, 'spe_class_kind', 1, '20', '��L', '32,', 32, '.');
INSERT INTO sfs_text VALUES (97, 0, 'tea_edu_kind', 2, '0', '�Юv�Ǿ��O', '', 0, '');
INSERT INTO sfs_text VALUES (98, 1, 'tea_edu_kind', 2, '1', '��s�Ҳ��~(�դh)', '97,', 97, '.');
INSERT INTO sfs_text VALUES (99, 2, 'tea_edu_kind', 2, '2', '��s�Ҳ��~(�Ӥh)', '97,', 97, '.');
INSERT INTO sfs_text VALUES (100, 3, 'tea_edu_kind', 2, '3', '��s�ҥ|�Q�Ǥ��Z���~', '97,', 97, '.');
INSERT INTO sfs_text VALUES (101, 4, 'tea_edu_kind', 2, '4', '�v�j�αШ|�ǰ|���~', '97,', 97, '.');
INSERT INTO sfs_text VALUES (102, 5, 'tea_edu_kind', 2, '5', '�j�ǰ|�դ@���t���~(���ײ߱Ш|�Ǥ�)', '97,', 97, '.');
INSERT INTO sfs_text VALUES (103, 6, 'tea_edu_kind', 2, '6', '�j�ǰ|�դ@���t���~(�L�ײ߱Ш|�Ǥ�)', '97,', 97, '.');
INSERT INTO sfs_text VALUES (104, 7, 'tea_edu_kind', 2, '7', '�v�d�M�첦�~', '97,', 97, '.');
INSERT INTO sfs_text VALUES (105, 8, 'tea_edu_kind', 2, '8', '��L�M�첦�~', '97,', 97, '.');
INSERT INTO sfs_text VALUES (106, 9, 'tea_edu_kind', 2, '9', '�v�d�Ǯղ��~', '97,', 97, '.');
INSERT INTO sfs_text VALUES (107, 10, 'tea_edu_kind', 2, '10', '�x�ƾǮղ��~', '97,', 97, '.');
INSERT INTO sfs_text VALUES (108, 11, 'tea_edu_kind', 2, '11', '��L', '97,', 97, '.');
INSERT INTO sfs_text VALUES (109, 0, 'tea_check_kind', 2, '0', '�Юv�˩w���', '', 0, '');
INSERT INTO sfs_text VALUES (110, 1, 'tea_check_kind', 2, '1', '����ά������˩w�X��', '109,', 109, '.');
INSERT INTO sfs_text VALUES (111, 2, 'tea_check_kind', 2, '2', '��߱Юv', '109,', 109, '.');
INSERT INTO sfs_text VALUES (112, 3, 'tea_check_kind', 2, '3', '�եαЮv�n�O', '109,', 109, '.');
INSERT INTO sfs_text VALUES (113, 4, 'tea_check_kind', 2, '4', '�n�p��', '109,', 109, '.');
INSERT INTO sfs_text VALUES (114, 5, 'tea_check_kind', 2, '5', '��L', '109,', 109, '.');
INSERT INTO sfs_text VALUES (115, 0, 'edu_kind', 1, '0', '�a���Ǿ��O', '', 0, '');
INSERT INTO sfs_text VALUES (116, 1, 'edu_kind', 1, '1', '�դh', '115,', 115, '.');
INSERT INTO sfs_text VALUES (117, 2, 'edu_kind', 1, '2', '�Ӥh', '115,', 115, '.');
INSERT INTO sfs_text VALUES (118, 3, 'edu_kind', 1, '3', '�j��', '115,', 115, '.');
INSERT INTO sfs_text VALUES (119, 4, 'edu_kind', 1, '4', '�M��', '115,', 115, '.');
INSERT INTO sfs_text VALUES (120, 5, 'edu_kind', 1, '5', '����', '115,', 115, '.');
INSERT INTO sfs_text VALUES (121, 6, 'edu_kind', 1, '6', '�ꤤ', '115,', 115, '.');
INSERT INTO sfs_text VALUES (122, 7, 'edu_kind', 1, '7', '��p���~', '115,', 115, '.');
INSERT INTO sfs_text VALUES (123, 8, 'edu_kind', 1, '8', '��p�w�~', '115,', 115, '.');
INSERT INTO sfs_text VALUES (124, 9, 'edu_kind', 1, '9', '�Ѧr(���N��)', '115,', 115, '.');
INSERT INTO sfs_text VALUES (125, 10, 'edu_kind', 1, '10', '���Ѧr', '115,', 115, '.');
INSERT INTO sfs_text VALUES (126, 0, 'official_level', 2, '0', '�x��', '', 0, '');
INSERT INTO sfs_text VALUES (127, 1, 'official_level', 2, '1', '²��', '126,', 126, '.');
INSERT INTO sfs_text VALUES (128, 2, 'official_level', 2, '2', '�˥�', '126,', 126, '.');
INSERT INTO sfs_text VALUES (129, 3, 'official_level', 2, '3', '�e��', '126,', 126, '.');
INSERT INTO sfs_text VALUES (130, 0, 'remove', 2, '0', '��¾���b¾���p', '', 0, '');
INSERT INTO sfs_text VALUES (131, 0, 'remove', 2, '0', '�b¾', '130,', 130, '.');
INSERT INTO sfs_text VALUES (132, 1, 'remove', 2, '1', '�եX', '130,', 130, '.');
INSERT INTO sfs_text VALUES (133, 2, 'remove', 2, '2', '�h��', '130,', 130, '.');
INSERT INTO sfs_text VALUES (134, 3, 'remove', 2, '3', '�N�Ҵ���', '130,', 130, '.');
INSERT INTO sfs_text VALUES (135, 4, 'remove', 2, '4', '�껺', '130,', 130, '.');
INSERT INTO sfs_text VALUES (136, 0, 'per_sick_kind', 1, '0', '�ӤH�f�v', '', 0, '');
INSERT INTO sfs_text VALUES (137, 1, 'per_sick_kind', 1, '1', '��Ŧ�f', '136,', 136, '.');
INSERT INTO sfs_text VALUES (138, 2, 'per_sick_kind', 1, '2', 'B���x���a��', '136,', 136, '.');
INSERT INTO sfs_text VALUES (139, 3, 'per_sick_kind', 1, '3', '�|����', '136,', 136, '.');
INSERT INTO sfs_text VALUES (140, 4, 'per_sick_kind', 1, '4', '���w', '136,', 136, '.');
INSERT INTO sfs_text VALUES (141, 5, 'per_sick_kind', 1, '5', '�ͪ�', '136,', 136, '.');
INSERT INTO sfs_text VALUES (142, 6, 'per_sick_kind', 1, '6', '���k', '136,', 136, '.');
INSERT INTO sfs_text VALUES (143, 7, 'per_sick_kind', 1, '7', '���', '136,', 136, '.');
INSERT INTO sfs_text VALUES (144, 8, 'per_sick_kind', 1, '8', '��Ŧ�f', '136,', 136, '.');
INSERT INTO sfs_text VALUES (145, 9, 'per_sick_kind', 1, '9', '��ͯf', '136,', 136, '.');
INSERT INTO sfs_text VALUES (146, 10, 'per_sick_kind', 1, '10', '�͵���', '136,', 136, '.');
INSERT INTO sfs_text VALUES (147, 11, 'per_sick_kind', 1, '11', '����', '136,', 136, '.');
INSERT INTO sfs_text VALUES (148, 12, 'per_sick_kind', 1, '12', '�S�����', '136,', 136, '.');
INSERT INTO sfs_text VALUES (149, 13, 'per_sick_kind', 1, '13', '����', '136,', 136, '.');
INSERT INTO sfs_text VALUES (150, 14, 'per_sick_kind', 1, '14', '����', '136,', 136, '.');
INSERT INTO sfs_text VALUES (151, 15, 'per_sick_kind', 1, '15', '���~�Ī��L��', '136,', 136, '.');
INSERT INTO sfs_text VALUES (152, 16, 'per_sick_kind', 1, '16', '�����', '136,', 136, '.');
INSERT INTO sfs_text VALUES (153, 17, 'per_sick_kind', 1, '17', '�w��¯l', '136,', 136, '.');
INSERT INTO sfs_text VALUES (154, 18, 'per_sick_kind', 1, '18', '�p��·�', '136,', 136, '.');
INSERT INTO sfs_text VALUES (155, 19, 'per_sick_kind', 1, '19', '�˴H', '136,', 136, '.');
INSERT INTO sfs_text VALUES (156, 0, 'fam_sick_kind', 1, '0', '�a�گf�v', '', 0, '');
INSERT INTO sfs_text VALUES (157, 1, 'fam_sick_kind', 1, '1', '������', '156,', 156, '.');
INSERT INTO sfs_text VALUES (158, 2, 'fam_sick_kind', 1, '2', '�}���f', '156,', 156, '.');
INSERT INTO sfs_text VALUES (159, 3, 'fam_sick_kind', 1, '3', 'B���x���a��', '156,', 156, '.');
INSERT INTO sfs_text VALUES (160, 4, 'fam_sick_kind', 1, '4', '���w', '156,', 156, '.');
INSERT INTO sfs_text VALUES (161, 5, 'fam_sick_kind', 1, '5', '�믫�e�f', '156,', 156, '.');
INSERT INTO sfs_text VALUES (162, 6, 'fam_sick_kind', 1, '6', '�͵���', '156,', 156, '.');
INSERT INTO sfs_text VALUES (163, 7, 'fam_sick_kind', 1, '7', '�L�өʯe�f', '156,', 156, '.');
INSERT INTO sfs_text VALUES (164, 8, 'fam_sick_kind', 1, '8', '��Ŧ��ޯe�f', '156,', 156, '.');
INSERT INTO sfs_text VALUES (165, 9, 'fam_sick_kind', 1, '9', '��?��c�e�f', '156,', 156, '.');
INSERT INTO sfs_text VALUES (166, 10, 'fam_sick_kind', 1, '10', '�~�F', '156,', 156, '.');
INSERT INTO sfs_text VALUES (167, 11, 'fam_sick_kind', 1, '11', '��L', '156,', 156, '.');
INSERT INTO sfs_text VALUES (168, 0, 'course9', 3, '0', '�ǲ߻��', '', 0, '');
INSERT INTO sfs_text VALUES (169, 1, 'course9', 3, '1', '�y��', '168,', 168, '.');
INSERT INTO sfs_text VALUES (170, 2, 'course9', 3, '2', '���d�P��|', '168,', 168, '.');
INSERT INTO sfs_text VALUES (171, 3, 'course9', 3, '3', '���|', '168,', 168, '.');
INSERT INTO sfs_text VALUES (172, 4, 'course9', 3, '4', '���N�P�H��', '168,', 168, '.');
INSERT INTO sfs_text VALUES (173, 5, 'course9', 3, '5', '�۵M�P���', '168,', 168, '.');
INSERT INTO sfs_text VALUES (174, 6, 'course9', 3, '6', '�ƾ�', '168,', 168, '.');
INSERT INTO sfs_text VALUES (175, 7, 'course9', 3, '7', '��X����', '168,', 168, '.');
INSERT INTO sfs_text VALUES (176, 0, 'subject_kind', 3, '0', '��ئW��', '', 0, '');
INSERT INTO sfs_text VALUES (177, 1, 'subject_kind', 3, '1', '��y', '176,', 176, '.');
INSERT INTO sfs_text VALUES (178, 2, 'subject_kind', 3, '2', '�ƾ�', '176,', 176, '.');
INSERT INTO sfs_text VALUES (179, 3, 'subject_kind', 3, '3', '���|', '176,', 176, '.');
INSERT INTO sfs_text VALUES (180, 4, 'subject_kind', 3, '4', '�۵M', '176,', 176, '.');
INSERT INTO sfs_text VALUES (181, 5, 'subject_kind', 3, '5', '�D�w�P���d', '176,', 176, '.');
INSERT INTO sfs_text VALUES (182, 6, 'subject_kind', 3, '6', '�ͬ��P�۲z', '176,', 176, '.');
INSERT INTO sfs_text VALUES (183, 7, 'subject_kind', 3, '7', '��|', '176,', 176, '.');
INSERT INTO sfs_text VALUES (184, 8, 'subject_kind', 3, '8', '�Ѫk', '176,', 176, '.');
INSERT INTO sfs_text VALUES (185, 9, 'subject_kind', 3, '9', '����', '176,', 176, '.');
INSERT INTO sfs_text VALUES (186, 10, 'subject_kind', 3, '10', '����', '176,', 176, '.');
INSERT INTO sfs_text VALUES (187, 11, 'subject_kind', 3, '11', '���y', '176,', 176, '.');
INSERT INTO sfs_text VALUES (188, 12, 'subject_kind', 3, '12', '�q��', '176,', 176, '.');
INSERT INTO sfs_text VALUES (189, 13, 'subject_kind', 3, '13', '�m�g�о�', '176,', 176, '.');
INSERT INTO sfs_text VALUES (190, 14, 'subject_kind', 3, '14', '�ͬ��Ш|', '176,', 176, '.');
INSERT INTO sfs_text VALUES (191, 15, 'subject_kind', 3, '15', '�𶢱Ш|', '176,', 176, '.');
INSERT INTO sfs_text VALUES (192, 16, 'subject_kind', 3, '16', '���|�A��', '176,', 176, '.');
INSERT INTO sfs_text VALUES (193, 17, 'subject_kind', 3, '17', '��μƾ�', '176,', 176, '.');
INSERT INTO sfs_text VALUES (194, 18, 'subject_kind', 3, '18', '��έ^��', '176,', 176, '.');
INSERT INTO sfs_text VALUES (195, 19, 'subject_kind', 3, '19', '�u������', '176,', 176, '.');
INSERT INTO sfs_text VALUES (196, 20, 'subject_kind', 3, '20', '���ɬ���', '176,', 176, '.');
INSERT INTO sfs_text VALUES (197, 21, 'subject_kind', 3, '21', '���ά���', '176,', 176, '.');
INSERT INTO sfs_text VALUES (198, 22, 'subject_kind', 3, '22', '¾�~�ͬ�', '176,', 176, '.');
INSERT INTO sfs_text VALUES (550, 0, 'non_display', 3, '0', '����ܥؿ�', '', 0, '');
INSERT INTO sfs_text VALUES (551, 0, 'non_display', 3, '0', 'include', '550,', 550, '.');
INSERT INTO sfs_text VALUES (552, 1, 'non_display', 3, '1', 'images', '550,', 550, '.');
INSERT INTO sfs_text VALUES (553, 2, 'non_display', 3, '2', 'image', '550,', 550, '.');
INSERT INTO sfs_text VALUES (554, 3, 'non_display', 3, '3', 'doc', '550,', 550, '.');
INSERT INTO sfs_text VALUES (555, 4, 'non_display', 3, '4', 'upgrade', '550,', 550, '.');
INSERT INTO sfs_text VALUES (556, 5, 'non_display', 3, '5', 'pass', '550,', 550, '.');
INSERT INTO sfs_text VALUES (557, 6, 'non_display', 3, '6', 'setup', '550,', 550, '.');
INSERT INTO sfs_text VALUES (558, 7, 'non_display', 3, '7', 'db', '550,', 550, '.');
INSERT INTO sfs_text VALUES (559, 8, 'non_display', 3, '8', 'themes', '550,', 550, '.');
INSERT INTO sfs_text VALUES (560, 9, 'non_display', 3, '9', 'docs', '550,', 550, '.');
INSERT INTO sfs_text VALUES (561, 10, 'non_display', 3, '10', 'templates', '550,', 550, '.');
INSERT INTO sfs_text VALUES (562, 11, 'non_display', 3, '11', 'util', '550,', 550, '.');
INSERT INTO sfs_text VALUES (563, 12, 'non_display', 3, '12', 'includes', '550,', 550, '.');
INSERT INTO sfs_text VALUES (564, 13, 'non_display', 3, '13', 'translations', '550,', 550, '.');
INSERT INTO sfs_text VALUES (565, 14, 'non_display', 3, '14', 'pnadodb', '550,', 550, '.');
INSERT INTO sfs_text VALUES (566, 15, 'non_display', 3, '15', 'updata', '550,', 550, '.');
INSERT INTO sfs_text VALUES (567, 0, '�������Y', 1, '0', '�������Y', '', 0, '');
INSERT INTO sfs_text VALUES (568, 1, '�������Y', 1, '1', '�P��', '567,', 567, '.');
INSERT INTO sfs_text VALUES (569, 2, '�������Y', 1, '2', '����', '567,', 567, '.');
INSERT INTO sfs_text VALUES (570, 3, '�������Y', 1, '3', '���~', '567,', 567, '.');
INSERT INTO sfs_text VALUES (571, 4, '�������Y', 1, '4', '���B', '567,', 567, '.');
INSERT INTO sfs_text VALUES (572, 5, '�������Y', 1, '5', '���`', '567,', 567, '.');
INSERT INTO sfs_text VALUES (573, 6, '�������Y', 1, '6', '�������`', '567,', 567, '.');
INSERT INTO sfs_text VALUES (574, 7, '�������Y', 1, '7', '������', '567,', 567, '.');
INSERT INTO sfs_text VALUES (575, 8, '�������Y', 1, '8', '������', '567,', 567, '.');
INSERT INTO sfs_text VALUES (576, 0, '�a�x����', 1, '0', '�a�x����', '', 0, '');
INSERT INTO sfs_text VALUES (577, 1, '�a�x����', 1, '1', '����', '576,', 576, '.');
INSERT INTO sfs_text VALUES (578, 2, '�a�x����', 1, '2', '���', '576,', 576, '.');
INSERT INTO sfs_text VALUES (579, 3, '�a�x����', 1, '3', '����', '576,', 576, '.');
INSERT INTO sfs_text VALUES (580, 0, '�a�x��^', 1, '0', '�a�x��^', '', 0, '');
INSERT INTO sfs_text VALUES (581, 1, '�a�x��^', 1, '1', '�M��', '580,', 580, '.');
INSERT INTO sfs_text VALUES (582, 2, '�a�x��^', 1, '2', '���q', '580,', 580, '.');
INSERT INTO sfs_text VALUES (583, 3, '�a�x��^', 1, '3', '���M��', '580,', 580, '.');
INSERT INTO sfs_text VALUES (584, 0, '�ޱФ覡', 1, '0', '�ޱФ覡', '', 0, '');
INSERT INTO sfs_text VALUES (585, 1, '�ޱФ覡', 1, '1', '���D', '584,', 584, '.');
INSERT INTO sfs_text VALUES (586, 2, '�ޱФ覡', 1, '2', '�v��', '584,', 584, '.');
INSERT INTO sfs_text VALUES (587, 3, '�ޱФ覡', 1, '3', '���', '584,', 584, '.');
INSERT INTO sfs_text VALUES (588, 0, '�~����', 1, '0', '�~����', '', 0, '');
INSERT INTO sfs_text VALUES (589, 1, '�~����', 1, '1', '�P�����P��', '588,', 588, '.');
INSERT INTO sfs_text VALUES (590, 2, '�~����', 1, '2', '�P���P��', '588,', 588, '.');
INSERT INTO sfs_text VALUES (591, 3, '�~����', 1, '3', '�P���P��', '588,', 588, '.');
INSERT INTO sfs_text VALUES (592, 4, '�~����', 1, '4', '�P�������P��', '588,', 588, '.');
INSERT INTO sfs_text VALUES (593, 5, '�~����', 1, '5', '�P�˱��P��', '588,', 588, '.');
INSERT INTO sfs_text VALUES (594, 6, '�~����', 1, '6', '�H��ͤH�a', '588,', 588, '.');
INSERT INTO sfs_text VALUES (595, 7, '�~����', 1, '7', '�W�~', '588,', 588, '.');
INSERT INTO sfs_text VALUES (596, 8, '�~����', 1, '8', '���Ω~��', '588,', 588, '.');
INSERT INTO sfs_text VALUES (597, 99, '�~����', 1, '99', '��L', '588,', 588, '.');
INSERT INTO sfs_text VALUES (598, 0, '�g�٪��p', 1, '0', '�g�٪��p', '', 0, '');
INSERT INTO sfs_text VALUES (599, 1, '�g�٪��p', 1, '1', '�I��', '598,', 598, '.');
INSERT INTO sfs_text VALUES (600, 2, '�g�٪��p', 1, '2', '�p�d', '598,', 598, '.');
INSERT INTO sfs_text VALUES (601, 3, '�g�٪��p', 1, '3', '���q', '598,', 598, '.');
INSERT INTO sfs_text VALUES (602, 4, '�g�٪��p', 1, '4', '�M�H', '598,', 598, '.');
INSERT INTO sfs_text VALUES (603, 5, '�g�٪��p', 1, '5', '�h�x', '598,', 598, '.');
INSERT INTO sfs_text VALUES (604, 0, '�߷R�x�����', 1, '0', '�߷R�x�����', '', 0, '');
INSERT INTO sfs_text VALUES (605, 1, '�߷R�x�����', 1, '1', '�D�w�P���d', '604,', 604, '.');
INSERT INTO sfs_text VALUES (606, 2, '�߷R�x�����', 1, '2', '��y', '604,', 604, '.');
INSERT INTO sfs_text VALUES (607, 3, '�߷R�x�����', 1, '3', '�ƾ�', '604,', 604, '.');
INSERT INTO sfs_text VALUES (608, 4, '�߷R�x�����', 1, '4', '�۵M', '604,', 604, '.');
INSERT INTO sfs_text VALUES (609, 5, '�߷R�x�����', 1, '5', '���|', '604,', 604, '.');
INSERT INTO sfs_text VALUES (610, 6, '�߷R�x�����', 1, '6', '�۹C', '604,', 604, '.');
INSERT INTO sfs_text VALUES (611, 7, '�߷R�x�����', 1, '7', '����', '604,', 604, '.');
INSERT INTO sfs_text VALUES (612, 8, '�߷R�x�����', 1, '8', '��|', '604,', 604, '.');
INSERT INTO sfs_text VALUES (613, 9, '�߷R�x�����', 1, '9', '����', '604,', 604, '.');
INSERT INTO sfs_text VALUES (614, 10, '�߷R�x�����', 1, '10', '���鬡��', '604,', 604, '.');
INSERT INTO sfs_text VALUES (615, 11, '�߷R�x�����', 1, '11', '���ɬ���', '604,', 604, '.');
INSERT INTO sfs_text VALUES (616, 12, '�߷R�x�����', 1, '12', '�m�g�оǬ���', '604,', 604, '.');
INSERT INTO sfs_text VALUES (617, 13, '�߷R�x�����', 1, '13', '�q��', '604,', 604, '.');
INSERT INTO sfs_text VALUES (618, 99, '�߷R�x�����', 1, '99', '��L', '604,', 604, '.');
INSERT INTO sfs_text VALUES (619, 0, '�S��~��', 1, '0', '�S��~��', '', 0, '');
INSERT INTO sfs_text VALUES (620, 1, '�S��~��', 1, '1', '�y��', '619,', 619, '.');
INSERT INTO sfs_text VALUES (621, 2, '�S��~��', 1, '2', '�Ю|', '619,', 619, '.');
INSERT INTO sfs_text VALUES (622, 3, '�S��~��', 1, '3', '��a', '619,', 619, '.');
INSERT INTO sfs_text VALUES (623, 4, '�S��~��', 1, '4', '��N', '619,', 619, '.');
INSERT INTO sfs_text VALUES (624, 5, '�S��~��', 1, '5', '���N', '619,', 619, '.');
INSERT INTO sfs_text VALUES (625, 6, '�S��~��', 1, '6', '���ֺt��', '619,', 619, '.');
INSERT INTO sfs_text VALUES (626, 7, '�S��~��', 1, '7', '�q��', '619,', 619, '.');
INSERT INTO sfs_text VALUES (627, 8, '�S��~��', 1, '8', '�u��', '619,', 619, '.');
INSERT INTO sfs_text VALUES (628, 9, '�S��~��', 1, '9', '�a��', '619,', 619, '.');
INSERT INTO sfs_text VALUES (629, 10, '�S��~��', 1, '10', '�t��', '619,', 619, '.');
INSERT INTO sfs_text VALUES (630, 11, '�S��~��', 1, '11', '�g�@', '619,', 619, '.');
INSERT INTO sfs_text VALUES (631, 12, '�S��~��', 1, '12', '�R��', '619,', 619, '.');
INSERT INTO sfs_text VALUES (632, 13, '�S��~��', 1, '13', '���@', '619,', 619, '.');
INSERT INTO sfs_text VALUES (633, 14, '�S��~��', 1, '14', '�Ѫk', '619,', 619, '.');
INSERT INTO sfs_text VALUES (634, 15, '�S��~��', 1, '15', '�]��', '619,', 619, '.');
INSERT INTO sfs_text VALUES (635, 16, '�S��~��', 1, '16', '���', '619,', 619, '.');
INSERT INTO sfs_text VALUES (636, 17, '�S��~��', 1, '17', '�^��', '619,', 619, '.');
INSERT INTO sfs_text VALUES (637, 18, '�S��~��', 1, '18', '����', '619,', 619, '.');
INSERT INTO sfs_text VALUES (638, 19, '�S��~��', 1, '19', '�~�y', '619,', 619, '.');
INSERT INTO sfs_text VALUES (639, 20, '�S��~��', 1, '20', '�q��', '619,', 619, '.');
INSERT INTO sfs_text VALUES (640, 99, '�S��~��', 1, '99', '��L', '619,', 619, '.');
INSERT INTO sfs_text VALUES (641, 0, '����', 1, '0', '����', '', 0, '');
INSERT INTO sfs_text VALUES (642, 1, '����', 1, '1', '�q���q�v', '641,', 641, '.');
INSERT INTO sfs_text VALUES (643, 2, '����', 1, '2', '�\\Ū', '641,', 641, '.');
INSERT INTO sfs_text VALUES (644, 3, '����', 1, '3', '�n�s', '641,', 641, '.');
INSERT INTO sfs_text VALUES (645, 4, '����', 1, '4', '�S��', '641,', 641, '.');
INSERT INTO sfs_text VALUES (646, 5, '����', 1, '5', '�Ȧ步�C', '641,', 641, '.');
INSERT INTO sfs_text VALUES (647, 6, '����', 1, '6', '�E���a', '641,', 641, '.');
INSERT INTO sfs_text VALUES (648, 7, '����', 1, '7', '����', '641,', 641, '.');
INSERT INTO sfs_text VALUES (649, 8, '����', 1, '8', '��N', '641,', 641, '.');
INSERT INTO sfs_text VALUES (650, 9, '����', 1, '9', '�־��t��', '641,', 641, '.');
INSERT INTO sfs_text VALUES (651, 10, '����', 1, '10', '�q��', '641,', 641, '.');
INSERT INTO sfs_text VALUES (652, 11, '����', 1, '11', '���֪Y��', '641,', 641, '.');
INSERT INTO sfs_text VALUES (653, 12, '����', 1, '12', '�R��', '641,', 641, '.');
INSERT INTO sfs_text VALUES (654, 13, '����', 1, '13', 'ø�e', '641,', 641, '.');
INSERT INTO sfs_text VALUES (655, 14, '����', 1, '14', '���l', '641,', 641, '.');
INSERT INTO sfs_text VALUES (656, 15, '����', 1, '15', '���y', '641,', 641, '.');
INSERT INTO sfs_text VALUES (657, 16, '����', 1, '16', '���y', '641,', 641, '.');
INSERT INTO sfs_text VALUES (658, 17, '����', 1, '17', '�s´', '641,', 641, '.');
INSERT INTO sfs_text VALUES (659, 18, '����', 1, '18', '�U��', '641,', 641, '.');
INSERT INTO sfs_text VALUES (660, 19, '����', 1, '19', '�i�p�ʪ�', '641,', 641, '.');
INSERT INTO sfs_text VALUES (661, 20, '����', 1, '20', '�@�����', '641,', 641, '.');
INSERT INTO sfs_text VALUES (662, 21, '����', 1, '21', '�q��', '641,', 641, '.');
INSERT INTO sfs_text VALUES (663, 99, '����', 1, '99', '��L', '641,', 641, '.');
INSERT INTO sfs_text VALUES (664, 0, '�ͬ��ߺD', 1, '0', '�ͬ��ߺD', '', 0, '');
INSERT INTO sfs_text VALUES (665, 1, '�ͬ��ߺD', 1, '1', '���', '664,', 664, '.');
INSERT INTO sfs_text VALUES (666, 2, '�ͬ��ߺD', 1, '2', '�Գ�', '664,', 664, '.');
INSERT INTO sfs_text VALUES (667, 3, '�ͬ��ߺD', 1, '3', '�`��', '664,', 664, '.');
INSERT INTO sfs_text VALUES (668, 4, '�ͬ��ߺD', 1, '4', '�@�����W��', '664,', 664, '.');
INSERT INTO sfs_text VALUES (669, 5, '�ͬ��ߺD', 1, '5', '��ż', '664,', 664, '.');
INSERT INTO sfs_text VALUES (670, 6, '�ͬ��ߺD', 1, '6', '�i�k', '664,', 664, '.');
INSERT INTO sfs_text VALUES (671, 7, '�ͬ��ߺD', 1, '7', '���O', '664,', 664, '.');
INSERT INTO sfs_text VALUES (672, 8, '�ͬ��ߺD', 1, '8', '�@���L�W��', '664,', 664, '.');
INSERT INTO sfs_text VALUES (673, 99, '�ͬ��ߺD', 1, '99', '��L', '664,', 664, '.');
INSERT INTO sfs_text VALUES (674, 0, '�H�����Y', 1, '0', '�H�����Y', '', 0, '');
INSERT INTO sfs_text VALUES (675, 1, '�H�����Y', 1, '1', '�M��', '674,', 674, '.');
INSERT INTO sfs_text VALUES (676, 2, '�H�����Y', 1, '2', '�X�s', '674,', 674, '.');
INSERT INTO sfs_text VALUES (677, 3, '�H�����Y', 1, '3', '����', '674,', 674, '.');
INSERT INTO sfs_text VALUES (678, 4, '�H�����Y', 1, '4', '�H��O�H', '674,', 674, '.');
INSERT INTO sfs_text VALUES (679, 5, '�H�����Y', 1, '5', '�n���n', '674,', 674, '.');
INSERT INTO sfs_text VALUES (680, 6, '�H�����Y', 1, '6', '�ۧڤ���', '674,', 674, '.');
INSERT INTO sfs_text VALUES (681, 7, '�H�����Y', 1, '7', '�N�z', '674,', 674, '.');
INSERT INTO sfs_text VALUES (682, 8, '�H�����Y', 1, '8', '�h�õ���', '674,', 674, '.');
INSERT INTO sfs_text VALUES (683, 99, '�H�����Y', 1, '99', '��L', '674,', 674, '.');
INSERT INTO sfs_text VALUES (684, 0, '�~�V�欰', 1, '0', '�~�V�欰', '', 0, '');
INSERT INTO sfs_text VALUES (685, 1, '�~�V�欰', 1, '1', '��ɤO�j', '684,', 684, '.');
INSERT INTO sfs_text VALUES (686, 2, '�~�V�欰', 1, '2', '����', '684,', 684, '.');
INSERT INTO sfs_text VALUES (687, 3, '�~�V�欰', 1, '3', '�B�n', '684,', 684, '.');
INSERT INTO sfs_text VALUES (688, 4, '�~�V�欰', 1, '4', '���ߤ��q', '684,', 684, '.');
INSERT INTO sfs_text VALUES (689, 5, '�~�V�欰', 1, '5', '�۫V�P��', '684,', 684, '.');
INSERT INTO sfs_text VALUES (690, 6, '�~�V�欰', 1, '6', '�`���ʸ�', '684,', 684, '.');
INSERT INTO sfs_text VALUES (691, 7, '�~�V�欰', 1, '7', '�n�C��', '684,', 684, '.');
INSERT INTO sfs_text VALUES (692, 8, '�~�V�欰', 1, '8', '�R�ۤϽ�', '684,', 684, '.');
INSERT INTO sfs_text VALUES (693, 99, '�~�V�欰', 1, '99', '��L', '684,', 684, '.');
INSERT INTO sfs_text VALUES (694, 0, '���V�欰', 1, '0', '���V�欰', '', 0, '');
INSERT INTO sfs_text VALUES (695, 1, '���V�欰', 1, '1', '�ԷV', '694,', 694, '.');
INSERT INTO sfs_text VALUES (696, 2, '���V�欰', 1, '2', '���R', '694,', 694, '.');
INSERT INTO sfs_text VALUES (697, 3, '���V�欰', 1, '3', '�۫H', '694,', 694, '.');
INSERT INTO sfs_text VALUES (698, 4, '���V�欰', 1, '4', '����í�w', '694,', 694, '.');
INSERT INTO sfs_text VALUES (699, 5, '���V�欰', 1, '5', '���Y', '694,', 694, '.');
INSERT INTO sfs_text VALUES (700, 6, '���V�欰', 1, '6', '�L���I�q', '694,', 694, '.');
INSERT INTO sfs_text VALUES (701, 7, '���V�欰', 1, '7', '�L���̿�', '694,', 694, '.');
INSERT INTO sfs_text VALUES (702, 8, '���V�欰', 1, '8', '�h�T���P', '694,', 694, '.');
INSERT INTO sfs_text VALUES (703, 99, '���V�欰', 1, '99', '��L', '694,', 694, '.');
INSERT INTO sfs_text VALUES (704, 0, '�ǲߦ欰', 1, '0', '�ǲߦ欰', '', 0, '');
INSERT INTO sfs_text VALUES (705, 1, '�ǲߦ欰', 1, '1', '�M��', '704,', 704, '.');
INSERT INTO sfs_text VALUES (706, 2, '�ǲߦ欰', 1, '2', '�n���V�O', '704,', 704, '.');
INSERT INTO sfs_text VALUES (707, 3, '�ǲߦ欰', 1, '3', '�����', '704,', 704, '.');
INSERT INTO sfs_text VALUES (708, 4, '�ǲߦ欰', 1, '4', '�H��n��', '704,', 704, '.');
INSERT INTO sfs_text VALUES (709, 5, '�ǲߦ欰', 1, '5', '����', '704,', 704, '.');
INSERT INTO sfs_text VALUES (710, 6, '�ǲߦ欰', 1, '6', '����', '704,', 704, '.');
INSERT INTO sfs_text VALUES (711, 7, '�ǲߦ欰', 1, '7', '�Q�ʰ���', '704,', 704, '.');
INSERT INTO sfs_text VALUES (712, 8, '�ǲߦ欰', 1, '8', '�b�~�Ӽo', '704,', 704, '.');
INSERT INTO sfs_text VALUES (713, 9, '�ǲߦ欰', 1, '9', '���߬Y��', '704,', 704, '.');
INSERT INTO sfs_text VALUES (714, 99, '�ǲߦ欰', 1, '99', '��L', '704,', 704, '.');
INSERT INTO sfs_text VALUES (715, 0, '���}�ߺD', 1, '0', '���}�ߺD', '', 0, '');
INSERT INTO sfs_text VALUES (716, 1, '���}�ߺD', 1, '1', '�o���n', '715,', 715, '.');
INSERT INTO sfs_text VALUES (717, 2, '���}�ߺD', 1, '2', '�f�Y', '715,', 715, '.');
INSERT INTO sfs_text VALUES (718, 3, '���}�ߺD', 1, '3', '�@�˥L�H', '715,', 715, '.');
INSERT INTO sfs_text VALUES (719, 4, '���}�ߺD', 1, '4', '�Y����Y', '715,', 715, '.');
INSERT INTO sfs_text VALUES (720, 5, '���}�ߺD', 1, '5', '�r��', '715,', 715, '.');
INSERT INTO sfs_text VALUES (721, 6, '���}�ߺD', 1, '6', '�I�g���}�ѥZ', '715,', 715, '.');
INSERT INTO sfs_text VALUES (722, 7, '���}�ߺD', 1, '7', '�I�g�q�ʪ���', '715,', 715, '.');
INSERT INTO sfs_text VALUES (723, 8, '���}�ߺD', 1, '8', '�W�ҦY�F��', '715,', 715, '.');
INSERT INTO sfs_text VALUES (724, 9, '���}�ߺD', 1, '9', '����', '715,', 715, '.');
INSERT INTO sfs_text VALUES (725, 10, '���}�ߺD', 1, '10', '�l��', '715,', 715, '.');
INSERT INTO sfs_text VALUES (726, 11, '���}�ߺD', 1, '11', '�l�r', '715,', 715, '.');
INSERT INTO sfs_text VALUES (727, 99, '���}�ߺD', 1, '99', '��L', '715,', 715, '.');
INSERT INTO sfs_text VALUES (728, 0, '�J�{�欰', 1, '0', '�J�{�欰', '', 0, '');
INSERT INTO sfs_text VALUES (729, 1, '�J�{�欰', 1, '1', '�L', '728,', 728, '.');
INSERT INTO sfs_text VALUES (730, 2, '�J�{�欰', 1, '2', '����i', '728,', 728, '.');
INSERT INTO sfs_text VALUES (731, 3, '�J�{�欰', 1, '3', '�o��', '728,', 728, '.');
INSERT INTO sfs_text VALUES (732, 4, '�J�{�欰', 1, '4', '�ݵh', '728,', 728, '.');
INSERT INTO sfs_text VALUES (733, 5, '�J�{�欰', 1, '5', '���ߤ��w', '728,', 728, '.');
INSERT INTO sfs_text VALUES (734, 6, '�J�{�欰', 1, '6', '���˪F��', '728,', 728, '.');
INSERT INTO sfs_text VALUES (735, 7, '�J�{�欰', 1, '7', '�{�l�h', '728,', 728, '.');
INSERT INTO sfs_text VALUES (736, 8, '�J�{�欰', 1, '8', '�Y�h', '728,', 728, '.');
INSERT INTO sfs_text VALUES (737, 9, '�J�{�欰', 1, '9', '��һ�ê', '728,', 728, '.');
INSERT INTO sfs_text VALUES (738, 99, '�J�{�欰', 1, '99', '��L', '728,', 728, '.');
INSERT INTO sfs_text VALUES (739, 16, 'non_display', 3, '16', 'CVS', '550,', 550, '.');
INSERT INTO sfs_text VALUES (740, 17, 'non_display', 3, '17', 'phpMyAdmin', '550,', 550, '.');
INSERT INTO sfs_text VALUES (741, 18, 'non_display', 3, '18', '.', '550,', 550, '.');
INSERT INTO sfs_text VALUES (742, 19, 'non_display', 3, '19', '..', '550,', 550, '.');
INSERT INTO sfs_text VALUES (743, 20, 'non_display', 3, '20', 'data', '550,', 550, '.');
INSERT INTO sfs_text VALUES (744, 0, '���m�����O', 1, '0', '���m�����O', '', 0, '');
INSERT INTO sfs_text VALUES (745, 1, '���m�����O', 1, '0', '�m��', '744,', 744, '.');
INSERT INTO sfs_text VALUES (746, 2, '���m�����O', 1, '1', '�ư�', '744,', 744, '.');
INSERT INTO sfs_text VALUES (747, 3, '���m�����O', 1, '2', '�f��', '744,', 744, '.');
INSERT INTO sfs_text VALUES (748, 4, '���m�����O', 1, '3', '�ల', '744,', 744, '.');
INSERT INTO sfs_text VALUES (749, 5, '���m�����O', 1, '4', '����', '744,', 744, '.');
INSERT INTO sfs_text VALUES (750, 6, '���m�����O', 1, '5', '���i�ܤO', '744,', 744, '.');
# --------------------------------------------------------

#
# ��ƪ�榡�G `soft`
#

CREATE TABLE soft (
  tapem_id char(2) NOT NULL default '',
  tape_id smallint(4) NOT NULL default '0',
  tape_name varchar(60) NOT NULL default '',
  tape_grade varchar(30) NOT NULL default '',
  tape_memo text NOT NULL,
  PRIMARY KEY  (tapem_id,tape_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `soft`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `softm`
#

CREATE TABLE softm (
  tapem_id char(2) NOT NULL default '',
  tapem_name char(30) NOT NULL default '',
  PRIMARY KEY  (tapem_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `softm`
#

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
) ;

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
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_absent`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_addr`
#

CREATE TABLE stud_addr (
  addr_id bigint(20) unsigned NOT NULL auto_increment,
  stud_id varchar(20) NOT NULL default '',
  stud_addr_h_a varchar(6) NOT NULL default '',
  stud_addr_h_b varchar(10) NOT NULL default '',
  stud_addr_h_c varchar(6) NOT NULL default '',
  stud_addr_h_d varchar(6) NOT NULL default '',
  stud_addr_h_e varchar(20) NOT NULL default '',
  stud_addr_h_f varchar(4) NOT NULL default '',
  stud_addr_h_g varchar(8) NOT NULL default '',
  stud_addr_h_h varchar(6) NOT NULL default '',
  stud_addr_h_i varchar(6) NOT NULL default '',
  stud_addr_h_j varchar(6) NOT NULL default '',
  stud_addr_h_k varchar(5) NOT NULL default '',
  stud_addr_h_l varchar(5) NOT NULL default '',
  stud_phone_h varchar(20) NOT NULL default '',
  stud_handphone_h varchar(20) NOT NULL default '',
  stud_addr_c_a varchar(6) NOT NULL default '',
  stud_addr_c_b varchar(10) NOT NULL default '',
  stud_addr_c_c varchar(6) NOT NULL default '',
  stud_addr_c_d varchar(6) NOT NULL default '',
  stud_addr_c_e varchar(20) NOT NULL default '',
  stud_addr_c_f varchar(4) NOT NULL default '',
  stud_addr_c_g varchar(8) NOT NULL default '',
  stud_addr_c_h varchar(6) NOT NULL default '',
  stud_addr_c_i varchar(6) NOT NULL default '',
  stud_addr_c_j varchar(6) NOT NULL default '',
  stud_addr_c_k varchar(5) NOT NULL default '',
  stud_addr_c_l varchar(5) NOT NULL default '',
  stud_phone_c varchar(20) NOT NULL default '',
  stud_handphone_c varchar(20) NOT NULL default '',
  update_id varchar(20) NOT NULL default '',
  update_time timestamp NOT NULL,
  is_same char(1) NOT NULL default '1',
  PRIMARY KEY  (addr_id),
  KEY stud_phone_h (stud_phone_h),
  KEY stud_id (stud_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_addr`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_addr_zip`
#

CREATE TABLE stud_addr_zip (
  zip char(3) NOT NULL default '',
  country varchar(10) NOT NULL default '',
  town varchar(10) NOT NULL default '',
  area_num varchar(6) NOT NULL default '',
  PRIMARY KEY  (zip)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_addr_zip`
#

INSERT INTO stud_addr_zip VALUES ('100', '�O�_��', '������', '02');
INSERT INTO stud_addr_zip VALUES ('103', '�O�_��', '�j�P��', '02');
INSERT INTO stud_addr_zip VALUES ('104', '�O�_��', '���s��', '02');
INSERT INTO stud_addr_zip VALUES ('105', '�O�_��', '�Q�s��', '02');
INSERT INTO stud_addr_zip VALUES ('106', '�O�_��', '�j�w��', '02');
INSERT INTO stud_addr_zip VALUES ('108', '�O�_��', '�U�ذ�', '02');
INSERT INTO stud_addr_zip VALUES ('110', '�O�_��', '�H�q��', '02');
INSERT INTO stud_addr_zip VALUES ('111', '�O�_��', '�h�L��', '02');
INSERT INTO stud_addr_zip VALUES ('112', '�O�_��', '�_���', '02');
INSERT INTO stud_addr_zip VALUES ('114', '�O�_��', '�����', '02');
INSERT INTO stud_addr_zip VALUES ('115', '�O�_��', '�n���', '02');
INSERT INTO stud_addr_zip VALUES ('116', '�O�_��', '��s��', '02');
INSERT INTO stud_addr_zip VALUES ('117', '�O�_��', '������', '02');
INSERT INTO stud_addr_zip VALUES ('200', '�򶩥�', '���R��', '02');
INSERT INTO stud_addr_zip VALUES ('201', '�򶩥�', '�H�q��', '02');
INSERT INTO stud_addr_zip VALUES ('202', '�򶩥�', '������', '02');
INSERT INTO stud_addr_zip VALUES ('203', '�򶩥�', '���s��', '02');
INSERT INTO stud_addr_zip VALUES ('204', '�򶩥�', '�w�ְ�', '02');
INSERT INTO stud_addr_zip VALUES ('205', '�򶩥�', '�x�x��', '02');
INSERT INTO stud_addr_zip VALUES ('206', '�򶩥�', '�C����', '02');
INSERT INTO stud_addr_zip VALUES ('207', '�s�_��', '�U���m', '02');
INSERT INTO stud_addr_zip VALUES ('208', '�s�_��', '���s�m', '02');
INSERT INTO stud_addr_zip VALUES ('209', '�s����', '�����n', '0836');
INSERT INTO stud_addr_zip VALUES ('210', '�s����', '�����_', '0837');
INSERT INTO stud_addr_zip VALUES ('211', '�s����', '������', '0838');
INSERT INTO stud_addr_zip VALUES ('212', '�s����', '�����F', '0839');
INSERT INTO stud_addr_zip VALUES ('220', '�s�_��', '�O����', '02');
INSERT INTO stud_addr_zip VALUES ('221', '�s�_��', '�����', '02');
INSERT INTO stud_addr_zip VALUES ('222', '�s�_��', '�`�|��', '02');
INSERT INTO stud_addr_zip VALUES ('223', '�s�_��', '�����', '02');
INSERT INTO stud_addr_zip VALUES ('224', '�s�_��', '��ڰ�', '02');
INSERT INTO stud_addr_zip VALUES ('226', '�s�_��', '���˰�', '02');
INSERT INTO stud_addr_zip VALUES ('227', '�s�_��', '���˰�', '02');
INSERT INTO stud_addr_zip VALUES ('228', '�s�_��', '�^�d��', '02');
INSERT INTO stud_addr_zip VALUES ('231', '�s�_��', '�s����', '02');
INSERT INTO stud_addr_zip VALUES ('232', '�s�_��', '�W�L��', '02');
INSERT INTO stud_addr_zip VALUES ('233', '�s�_��', '�Q�Ӱ�', '02');
INSERT INTO stud_addr_zip VALUES ('234', '�s�_��', '�éM��', '02');
INSERT INTO stud_addr_zip VALUES ('235', '�s�_��', '���M��', '02');
INSERT INTO stud_addr_zip VALUES ('236', '�s�_��', '�g����', '02');
INSERT INTO stud_addr_zip VALUES ('237', '�s�_��', '�T�l��', '02');
INSERT INTO stud_addr_zip VALUES ('238', '�s�_��', '��L��', '02');
INSERT INTO stud_addr_zip VALUES ('239', '�s�_��', '�a�q��', '02');
INSERT INTO stud_addr_zip VALUES ('241', '�s�_��', '�T����', '02');
INSERT INTO stud_addr_zip VALUES ('242', '�s�_��', '�s����', '02');
INSERT INTO stud_addr_zip VALUES ('243', '�s�_��', '���s��', '02');
INSERT INTO stud_addr_zip VALUES ('244', '�s�_��', '�L�f��', '02');
INSERT INTO stud_addr_zip VALUES ('247', '�s�_��', 'Ī�w��', '02');
INSERT INTO stud_addr_zip VALUES ('248', '�s�_��', '���Ѱ�', '02');
INSERT INTO stud_addr_zip VALUES ('249', '�s�_��', '�K����', '02');
INSERT INTO stud_addr_zip VALUES ('251', '�s�_��', '�H����', '02');
INSERT INTO stud_addr_zip VALUES ('252', '�s�_��', '�T�۰�', '02');
INSERT INTO stud_addr_zip VALUES ('253', '�s�_��', '�۪���', '02');
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
INSERT INTO stud_addr_zip VALUES ('400', '�O����', '����', '04');
INSERT INTO stud_addr_zip VALUES ('401', '�O����', '�F��', '04');
INSERT INTO stud_addr_zip VALUES ('402', '�O����', '�n��', '04');
INSERT INTO stud_addr_zip VALUES ('403', '�O����', '���', '04');
INSERT INTO stud_addr_zip VALUES ('404', '�O����', '�_��', '04');
INSERT INTO stud_addr_zip VALUES ('406', '�O����', '�_��', '04');
INSERT INTO stud_addr_zip VALUES ('407', '�O����', '���', '04');
INSERT INTO stud_addr_zip VALUES ('408', '�O����', '�n��', '04');
INSERT INTO stud_addr_zip VALUES ('411', '�O����', '�ӥ���', '04');
INSERT INTO stud_addr_zip VALUES ('412', '�O����', '�j����', '04');
INSERT INTO stud_addr_zip VALUES ('413', '�O����', '���p��', '04');
INSERT INTO stud_addr_zip VALUES ('414', '�O����', '�Q���', '04');
INSERT INTO stud_addr_zip VALUES ('420', '�O����', '�׭��', '04');
INSERT INTO stud_addr_zip VALUES ('421', '�O����', '�Z����', '04');
INSERT INTO stud_addr_zip VALUES ('422', '�O����', '�۩���', '04');
INSERT INTO stud_addr_zip VALUES ('423', '�O����', '�F�հ�', '04');
INSERT INTO stud_addr_zip VALUES ('424', '�O����', '�M����', '04');
INSERT INTO stud_addr_zip VALUES ('426', '�O����', '�s����', '04');
INSERT INTO stud_addr_zip VALUES ('427', '�O����', '��l��', '04');
INSERT INTO stud_addr_zip VALUES ('428', '�O����', '�j����', '04');
INSERT INTO stud_addr_zip VALUES ('429', '�O����', '������', '04');
INSERT INTO stud_addr_zip VALUES ('432', '�O����', '�j�{��', '04');
INSERT INTO stud_addr_zip VALUES ('433', '�O����', '�F����', '04');
INSERT INTO stud_addr_zip VALUES ('434', '�O����', '�s����', '04');
INSERT INTO stud_addr_zip VALUES ('435', '�O����', '��ϰ�', '04');
INSERT INTO stud_addr_zip VALUES ('436', '�O����', '�M����', '04');
INSERT INTO stud_addr_zip VALUES ('437', '�O����', '�j�Ұ�', '04');
INSERT INTO stud_addr_zip VALUES ('438', '�O����', '�~�H��', '04');
INSERT INTO stud_addr_zip VALUES ('439', '�O����', '�j�w��', '04');
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
INSERT INTO stud_addr_zip VALUES ('700', '�O�n��', '����', '06');
INSERT INTO stud_addr_zip VALUES ('701', '�O�n��', '�F��', '06');
INSERT INTO stud_addr_zip VALUES ('702', '�O�n��', '�n��', '06');
INSERT INTO stud_addr_zip VALUES ('703', '�O�n��', '���', '06');
INSERT INTO stud_addr_zip VALUES ('704', '�O�n��', '�_��', '06');
INSERT INTO stud_addr_zip VALUES ('708', '�O�n��', '�w����', '06');
INSERT INTO stud_addr_zip VALUES ('709', '�O�n��', '�w�n��', '06');
INSERT INTO stud_addr_zip VALUES ('710', '�O�n��', '�ñd��', '06');
INSERT INTO stud_addr_zip VALUES ('711', '�O�n��', '�k����', '06');
INSERT INTO stud_addr_zip VALUES ('712', '�O�n��', '�s�ư�', '06');
INSERT INTO stud_addr_zip VALUES ('713', '�O�n��', '�����', '06');
INSERT INTO stud_addr_zip VALUES ('714', '�O�n��', '�ɤ���', '06');
INSERT INTO stud_addr_zip VALUES ('715', '�O�n��', '�����', '06');
INSERT INTO stud_addr_zip VALUES ('716', '�O�n��', '�n�ư�', '06');
INSERT INTO stud_addr_zip VALUES ('717', '�O�n��', '���w��', '06');
INSERT INTO stud_addr_zip VALUES ('718', '�O�n��', '���q��', '06');
INSERT INTO stud_addr_zip VALUES ('719', '�O�n��', '�s�T��', '06');
INSERT INTO stud_addr_zip VALUES ('720', '�O�n��', '�x�а�', '06');
INSERT INTO stud_addr_zip VALUES ('721', '�O�n��', '�¨���', '06');
INSERT INTO stud_addr_zip VALUES ('722', '�O�n��', '�Ψ���', '06');
INSERT INTO stud_addr_zip VALUES ('723', '�O�n��', '����', '06');
INSERT INTO stud_addr_zip VALUES ('724', '�O�n��', '�C�Ѱ�', '06');
INSERT INTO stud_addr_zip VALUES ('725', '�O�n��', '�N�x��', '06');
INSERT INTO stud_addr_zip VALUES ('726', '�O�n��', '�ǥҰ�', '06');
INSERT INTO stud_addr_zip VALUES ('727', '�O�n��', '�_����', '06');
INSERT INTO stud_addr_zip VALUES ('730', '�O�n��', '�s���', '06');
INSERT INTO stud_addr_zip VALUES ('731', '�O�n��', '�����', '06');
INSERT INTO stud_addr_zip VALUES ('732', '�O�n��', '�ժe��', '06');
INSERT INTO stud_addr_zip VALUES ('733', '�O�n��', '�F�s��', '06');
INSERT INTO stud_addr_zip VALUES ('734', '�O�n��', '���Ұ�', '06');
INSERT INTO stud_addr_zip VALUES ('735', '�O�n��', '�U���', '06');
INSERT INTO stud_addr_zip VALUES ('736', '�O�n��', '�h���', '06');
INSERT INTO stud_addr_zip VALUES ('737', '�O�n��', '�Q����', '06');
INSERT INTO stud_addr_zip VALUES ('741', '�O�n��', '���ư�', '06');
INSERT INTO stud_addr_zip VALUES ('742', '�O�n��', '�j����', '06');
INSERT INTO stud_addr_zip VALUES ('743', '�O�n��', '�s�W��', '06');
INSERT INTO stud_addr_zip VALUES ('744', '�O�n��', '�s����', '06');
INSERT INTO stud_addr_zip VALUES ('745', '�O�n��', '�w�w��', '06');
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
INSERT INTO stud_addr_zip VALUES ('814', '������', '���Z��', '07');
INSERT INTO stud_addr_zip VALUES ('815', '������', '�j����', '07');
INSERT INTO stud_addr_zip VALUES ('817', '�n���Ѯq', '�F�F', '0827');
INSERT INTO stud_addr_zip VALUES ('819', '�n���Ѯq', '�n�F', '0827');
INSERT INTO stud_addr_zip VALUES ('820', '������', '���s��', '07');
INSERT INTO stud_addr_zip VALUES ('821', '������', '���˰�', '07');
INSERT INTO stud_addr_zip VALUES ('822', '������', '������', '07');
INSERT INTO stud_addr_zip VALUES ('823', '������', '�мd��', '07');
INSERT INTO stud_addr_zip VALUES ('824', '������', '�P�_��', '07');
INSERT INTO stud_addr_zip VALUES ('825', '������', '���Y��', '07');
INSERT INTO stud_addr_zip VALUES ('826', '������', '��x��', '07');
INSERT INTO stud_addr_zip VALUES ('827', '������', '������', '07');
INSERT INTO stud_addr_zip VALUES ('828', '������', '�æw��', '07');
INSERT INTO stud_addr_zip VALUES ('829', '������', '�򤺰�', '07');
INSERT INTO stud_addr_zip VALUES ('830', '������', '��s��', '07');
INSERT INTO stud_addr_zip VALUES ('831', '������', '�j�d��', '07');
INSERT INTO stud_addr_zip VALUES ('832', '������', '�L���', '07');
INSERT INTO stud_addr_zip VALUES ('833', '������', '���Q��', '07');
INSERT INTO stud_addr_zip VALUES ('840', '������', '�j���', '07');
INSERT INTO stud_addr_zip VALUES ('842', '������', '�X�s��', '07');
INSERT INTO stud_addr_zip VALUES ('843', '������', '���@��', '07');
INSERT INTO stud_addr_zip VALUES ('844', '������', '���t��', '07');
INSERT INTO stud_addr_zip VALUES ('845', '������', '������', '07');
INSERT INTO stud_addr_zip VALUES ('846', '������', '���L��', '07');
INSERT INTO stud_addr_zip VALUES ('847', '������', '�ҥP��', '07');
INSERT INTO stud_addr_zip VALUES ('848', '������', '�緽��', '07');
INSERT INTO stud_addr_zip VALUES ('849', '������', '�T����', '07');
INSERT INTO stud_addr_zip VALUES ('851', '������', '�Z�L��', '07');
INSERT INTO stud_addr_zip VALUES ('852', '������', '�X�_��', '07');
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
INSERT INTO stud_addr_zip VALUES ('950', '�O�F��', '�O�F��', '089');
INSERT INTO stud_addr_zip VALUES ('951', '�O�F��', '��q�m', '089');
INSERT INTO stud_addr_zip VALUES ('952', '�O�F��', '�����m', '089');
INSERT INTO stud_addr_zip VALUES ('953', '�O�F��', '�����m', '089');
INSERT INTO stud_addr_zip VALUES ('954', '�O�F��', '���n�m', '089');
INSERT INTO stud_addr_zip VALUES ('955', '�O�F��', '�����m', '089');
INSERT INTO stud_addr_zip VALUES ('956', '�O�F��', '���s��', '089');
INSERT INTO stud_addr_zip VALUES ('957', '�O�F��', '���ݶm', '089');
INSERT INTO stud_addr_zip VALUES ('958', '�O�F��', '���W�m', '089');
INSERT INTO stud_addr_zip VALUES ('959', '�O�F��', '�F�e�m', '089');
# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_base`
#

CREATE TABLE stud_base (
  stud_id varchar(20) NOT NULL default '',
  student_sn int(10) unsigned NOT NULL auto_increment,
  stud_name varchar(20) default NULL,
  stud_sex tinyint(3) unsigned default NULL,
  stud_birthday date default NULL,
  stud_blood_type tinyint(3) unsigned default NULL,
  stud_birth_place tinyint(3) unsigned default NULL,
  stud_kind varchar(60) default NULL,
  stud_country varchar(20) default NULL,
  stud_country_kind tinyint(3) unsigned default NULL,
  stud_person_id varchar(20) default NULL,
  stud_country_name varchar(20) default NULL,
  stud_addr_1 varchar(60) default NULL,
  stud_addr_2 varchar(60) default NULL,
  stud_tel_1 varchar(20) default NULL,
  stud_tel_2 varchar(20) default NULL,
  stud_tel_3 varchar(20) default NULL,
  stud_mail varchar(50) default NULL,
  stud_addr_a varchar(6) default NULL,
  stud_addr_b varchar(12) default NULL,
  stud_addr_c varchar(12) default NULL,
  stud_addr_d varchar(6) default NULL,
  stud_addr_e varchar(20) default NULL,
  stud_addr_f varchar(6) default NULL,
  stud_addr_g varchar(8) default NULL,
  stud_addr_h varchar(6) default NULL,
  stud_addr_i varchar(8) default NULL,
  stud_addr_j varchar(8) default NULL,
  stud_addr_k varchar(6) default NULL,
  stud_addr_l varchar(6) default NULL,
  stud_addr_m varchar(12) default NULL,
  stud_class_kind tinyint(3) unsigned default NULL,
  stud_spe_kind tinyint(3) unsigned default NULL,
  stud_spe_class_kind tinyint(3) unsigned default NULL,
  stud_spe_class_id tinyint(3) unsigned default NULL,
  stud_preschool_status tinyint(3) unsigned default NULL,
  stud_preschool_id varchar(8) default NULL,
  stud_preschool_name varchar(40) default NULL,
  stud_Mschool_status tinyint(3) unsigned default NULL,
  stud_mschool_id varchar(8) default NULL,
  stud_mschool_name varchar(40) default NULL,
  email_pass varchar(10) default NULL,
  stud_study_year int(10) unsigned not NULL default 0,
  curr_class_num varchar(6) default NULL,
  stud_study_cond tinyint(3) unsigned default 0,
  addr_zip varchar(5),
  stud_name_eng varchar(20),
  addr_move_in date,
  PRIMARY KEY  (stud_study_year,stud_id),
  UNIQUE KEY student_sn (student_sn)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_base`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_brother_sister`
#

CREATE TABLE stud_brother_sister (
  bs_id bigint(20) NOT NULL auto_increment,
  stud_id varchar(20) NOT NULL default '',
  bs_name varchar(20) NOT NULL default '0',
  bs_calling tinyint(3) unsigned NOT NULL default '0',
  bs_gradu varchar(20) NOT NULL default '',
  bs_birthyear tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (bs_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_brother_sister`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_compile`
#

CREATE TABLE stud_compile (
  compile_sn int(10) unsigned NOT NULL auto_increment,
  student_sn int(10) unsigned NOT NULL default '0',
  sort tinyint(3) unsigned NOT NULL default '0',
  old_class varchar(11) NOT NULL default '',
  new_class varchar(11) NOT NULL default '',
  site_num tinyint(3) unsigned NOT NULL default '0',
  sex tinyint(1) unsigned NOT NULL default '0',
  stud_birthday date NOT NULL default '0000-00-00',
  update_time datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (compile_sn)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_compile`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_domicile`
#

CREATE TABLE stud_domicile (
  stud_id varchar(20) NOT NULL default '',
  fath_name varchar(20) NOT NULL default '',
  fath_birthyear varchar(4) NOT NULL default '',
  fath_alive tinyint(3) unsigned NOT NULL default '1',
  fath_relation varchar(6) NOT NULL default '',
  fath_p_id varchar(20) NOT NULL default '',
  fath_education tinyint(3) unsigned NOT NULL default '0',
  fath_occupation varchar(20) NOT NULL default '',
  fath_unit varchar(20) NOT NULL default '',
  fath_work_name varchar(20) NOT NULL default '',
  fath_phone varchar(20) NOT NULL default '',
  fath_home_phone varchar(20) default NULL,
  fath_hand_phone varchar(20) default NULL,
  fath_email varchar(30) default NULL,
  moth_name varchar(20) NOT NULL default '',
  moth_birthyear varchar(4) NOT NULL default '',
  moth_alive tinyint(3) unsigned NOT NULL default '1',
  moth_relation varchar(6) NOT NULL default '',
  moth_p_id varchar(20) NOT NULL default '',
  moth_education tinyint(3) unsigned NOT NULL default '0',
  moth_occupation varchar(20) NOT NULL default '',
  moth_unit varchar(20) NOT NULL default '',
  moth_work_name varchar(20) NOT NULL default '',
  moth_phone varchar(20) NOT NULL default '',
  moth_home_phone varchar(20) default NULL,
  moth_hand_phone varchar(20) default NULL,
  moth_email varchar(30) default NULL,
  guardian_name varchar(20) NOT NULL default '',
  guardian_phone varchar(20) NOT NULL default '',
  guardian_address varchar(60) NOT NULL default '',
  guardian_relation varchar(20) NOT NULL default '',
  guardian_p_id varchar(20) default NULL,
  guardian_unit varchar(30) default NULL,
  guardian_work_name varchar(20) default NULL,
  guardian_hand_phone varchar(20) default NULL,
  guardian_email varchar(30) default NULL,
  grandfath_name varchar(20) NOT NULL default '',
  grandfath_alive tinyint(3) unsigned NOT NULL default '1',
  grandmoth_name varchar(20) NOT NULL default '',
  grandmoth_alive tinyint(3) unsigned NOT NULL default '1',
  update_time timestamp NOT NULL,
  update_id varchar(20) NOT NULL default '',
  PRIMARY KEY  (stud_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_domicile`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_eduh`
#

CREATE TABLE stud_eduh (
  eh_id bigint(20) unsigned NOT NULL auto_increment,
  stud_id varchar(20) default NULL,
  eh_from tinyint(3) unsigned default NULL,
  eh_from_date date default NULL,
  eh_teacher varchar(20) default NULL,
  eh_caes varchar(60) default NULL,
  eh_meth varchar(60) default NULL,
  eh_resion_memo varchar(40) default NULL,
  eh_is_over tinyint(3) unsigned default NULL,
  eh_over_memo varchar(40) default NULL,
  eh_over_date date default NULL,
  eh_case_date date default NULL,
  eh_case_memo text,
  eh_case_relation varchar(30) default NULL,
  PRIMARY KEY  (eh_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_eduh`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_grad`
#

CREATE TABLE stud_grad (
  stud_id varchar(20) NOT NULL default '',
  grad_kind varchar(10) default NULL,
  grad_date date default NULL,
  grad_word varchar(20) default NULL,
  grad_numb varchar(10) default NULL,
  PRIMARY KEY  (stud_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_grad`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_kinfolk`
#

CREATE TABLE stud_kinfolk (
  kin_id bigint(20) NOT NULL auto_increment,
  stud_id varchar(20) NOT NULL default '',
  kin_name varchar(20) default NULL,
  kin_calling varchar(6) default NULL,
  kin_phone varchar(20) default NULL,
  kin_hand_phone varchar(20) default NULL,
  kin_email varchar(40) default NULL,
  PRIMARY KEY  (kin_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_kinfolk`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_mid_abs`
#

CREATE TABLE stud_mid_abs (
  sma_year varchar(4) NOT NULL default '',
  sma_month char(2) NOT NULL default '',
  stud_id varchar(20) NOT NULL default '',
  sma_kind tinyint(3) unsigned NOT NULL default '0',
  sma_days int(10) unsigned default NULL,
  PRIMARY KEY  (stud_id,sma_year,sma_month,sma_kind)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_mid_abs`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_mid_rep`
#

CREATE TABLE stud_mid_rep (
  smr_id bigint(20) unsigned NOT NULL default '0',
  stud_id varchar(20) default NULL,
  smr_date date default NULL,
  smr_kind tinyint(3) unsigned default NULL,
  smr_num tinyint(3) unsigned default NULL,
  smr_res text,
  PRIMARY KEY  (smr_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_mid_rep`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_mid_sco`
#

CREATE TABLE stud_mid_sco (
  smc_id bigint(20) unsigned NOT NULL default '0',
  stud_id varchar(20) default NULL,
  smc_date date default NULL,
  smc_name varchar(20) default NULL,
  smc_score decimal(4,2) default NULL,
  smc_class1 varchar(60) default NULL,
  smc_class2 varchar(60) default NULL,
  smc_class3 varchar(60) default NULL,
  PRIMARY KEY  (smc_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_mid_sco`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_move`
#

CREATE TABLE stud_move (
  move_id bigint(20) NOT NULL auto_increment,
  stud_id varchar(20) NOT NULL default '',
  move_kind varchar(10) NOT NULL default '',
  move_year_seme varchar(6) NOT NULL default '',
  move_date date NOT NULL default '0000-00-00',
  move_c_unit varchar(30) default NULL,
  move_c_date date default '0000-00-00',
  move_c_word varchar(20) default NULL,
  move_c_num varchar(14) default NULL,
  update_time datetime NOT NULL default '0000-00-00 00:00:00',
  update_id varchar(20) NOT NULL default '',
  update_ip varchar(15) NOT NULL default '',
  school varchar(40) NOT NULL default '',
  reason text NOT NULL,
  PRIMARY KEY  (move_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_move`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_seme`
#

CREATE TABLE stud_seme (
  seme_year_seme varchar(6) NOT NULL default '',
  stud_id varchar(20) NOT NULL default '',
  seme_class varchar(10) default NULL,
  seme_class_name varchar(10) default NULL,
  seme_num tinyint(3) unsigned default NULL,
  seme_class_year_s int(10) unsigned default NULL,
  seme_class_s tinyint(3) unsigned default NULL,
  seme_num_s tinyint(3) unsigned default NULL,
  PRIMARY KEY  (seme_year_seme,stud_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_seme`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_seme_abs`
#

CREATE TABLE stud_seme_abs (
  seme_year_seme varchar(6) NOT NULL default '',
  stud_id varchar(20) NOT NULL default '',
  abs_kind tinyint(3) unsigned NOT NULL default 0,
  abs_days int(10) unsigned default NULL,
  PRIMARY KEY  (seme_year_seme,stud_id,abs_kind)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_seme_abs`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_seme_eduh`
#

CREATE TABLE stud_seme_eduh (
  seme_year_seme varchar(6) NOT NULL default '',
  stud_id varchar(20) NOT NULL default '',
  sse_relation tinyint(3) unsigned default NULL,
  sse_family_kind tinyint(3) unsigned default NULL,
  sse_family_air tinyint(3) unsigned default NULL,
  sse_farther tinyint(3) unsigned default NULL,
  sse_mother tinyint(3) unsigned default NULL,
  sse_live_state tinyint(3) unsigned default NULL,
  sse_rich_state tinyint(3) unsigned default NULL,
  sse_s1 varchar(40) default NULL,
  sse_s2 varchar(40) default NULL,
  sse_s3 varchar(40) default NULL,
  sse_s4 varchar(40) default NULL,
  sse_s5 varchar(40) default NULL,
  sse_s6 varchar(40) default NULL,
  sse_s7 varchar(40) default NULL,
  sse_s8 varchar(40) default NULL,
  sse_s9 varchar(40) default NULL,
  sse_s10 varchar(40) default NULL,
  sse_s11 varchar(40) default NULL,
  PRIMARY KEY  (seme_year_seme,stud_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_seme_eduh`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_seme_score`
#

CREATE TABLE stud_seme_score (
  sss_id bigint(20) unsigned NOT NULL auto_increment,
  seme_year_seme varchar(6) default NULL,
  student_sn int(10) unsigned NOT NULL default '0',
  ss_id smallint(5) unsigned default NULL,
  ss_score decimal(4,2) default NULL,
  ss_score_memo text,
  PRIMARY KEY  (sss_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_seme_score`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_seme_score_s`
#

CREATE TABLE stud_seme_score_s (
  sss_id bigint(20) unsigned NOT NULL default '0',
  ss_id bigint(20) unsigned default NULL,
  sss_kind tinyint(3) unsigned default NULL,
  sss_score decimal(4,2) default NULL,
  PRIMARY KEY  (sss_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_seme_score_s`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_seme_spe`
#

CREATE TABLE stud_seme_spe (
  ss_id bigint(20) unsigned NOT NULL auto_increment,
  seme_year_seme varchar(6) default NULL,
  stud_id varchar(20) default NULL,
  sp_date date default NULL,
  sp_memo text,
  teach_id varchar(20) NOT NULL default '',
  update_time timestamp NOT NULL,
  PRIMARY KEY  (ss_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_seme_spe`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_seme_talk`
#

CREATE TABLE stud_seme_talk (
  sst_id bigint(20) unsigned NOT NULL auto_increment,
  seme_year_seme varchar(6) default NULL,
  stud_id varchar(20) default NULL,
  sst_date date default NULL,
  sst_name varchar(20) default NULL,
  sst_main varchar(40) default NULL,
  sst_memo text,
  teach_id varchar(20) NOT NULL default '',
  update_time timestamp NOT NULL,
  PRIMARY KEY  (sst_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_seme_talk`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_seme_test`
#

CREATE TABLE stud_seme_test (
  st_id bigint(20) unsigned NOT NULL default '0',
  seme_year_seme varchar(6) default NULL,
  stud_id varchar(20) default NULL,
  st_numb varchar(20) default NULL,
  st_name varchar(20) default NULL,
  st_score_numb varchar(20) default NULL,
  st_data_from varchar(40) default NULL,
  st_chang_numb varchar(20) default NULL,
  st_name_long varchar(40) default NULL,
  PRIMARY KEY  (st_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_seme_test`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_sick_f`
#

CREATE TABLE stud_sick_f (
  sick_id bigint(20) unsigned NOT NULL auto_increment,
  stud_id varchar(20) NOT NULL default '',
  s_calling varchar(6) NOT NULL default '',
  sick varchar(100) NOT NULL default '',
  PRIMARY KEY  (sick_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_sick_f`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `stud_sick_p`
#

CREATE TABLE stud_sick_p (
  stud_id varchar(20) NOT NULL default '',
  sick varchar(100) NOT NULL default '',
  PRIMARY KEY  (stud_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `stud_sick_p`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `subj_cour`
#

CREATE TABLE subj_cour (
  seme_year_seme varchar(6) NOT NULL default '',
  seme_class varchar(10) NOT NULL default '',
  subj_id smallint(5) unsigned NOT NULL default '0',
  sc_num tinyint(3) unsigned NOT NULL default '0',
  sc_perr double NOT NULL default '0',
  sc_five_kind tinyint(3) unsigned NOT NULL default '0',
  sc_percent double NOT NULL default '0',
  sc_order tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (seme_year_seme,seme_class),
  UNIQUE KEY seme_year_seme (seme_year_seme,seme_class)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `subj_cour`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `subj_hour`
#

CREATE TABLE subj_hour (
  sj_id char(2) NOT NULL default '',
  sj_b_time varchar(4) NOT NULL default '',
  sj_e_time varchar(4) NOT NULL default '',
  sj_kind tinyint(3) unsigned NOT NULL default '0',
  sj_memo varchar(20) NOT NULL default '',
  PRIMARY KEY  (sj_id),
  UNIQUE KEY sj_id (sj_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `subj_hour`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `sys_data_field`
#

CREATE TABLE sys_data_field (
  d_table_name varchar(30) NOT NULL default '',
  d_field_name varchar(30) NOT NULL default '',
  d_field_cname varchar(30) NOT NULL default '',
  d_field_type varchar(30) NOT NULL default '',
  d_field_order tinyint(4) NOT NULL default '0',
  d_is_display tinyint(4) NOT NULL default '0',
  d_field_xml varchar(40) NOT NULL default '',
  PRIMARY KEY  (d_table_name,d_field_name),
  UNIQUE KEY d_table_name (d_table_name,d_field_name)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `sys_data_field`
#

INSERT INTO sys_data_field VALUES ('stud_base', 'stud_Mschool_status', '', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_mschool_id', '�Ш|���N��', 'varchar(8)', 0, 0, '�Ш|���ǮեN��_��p');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_spe_class_id', '�S��Z�W�ҩʽ�', 'tinyint(3) unsigned', 0, 0, '�S��Z�W�ҩʽ�');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_preschool_status', '�J�Ǹ��', 'tinyint(3) unsigned', 0, 0, '���X��J�Ǹ��');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_spe_class_kind', '�S��Z�Z�O', 'tinyint(3) unsigned', 0, 0, '�S��Z�Z�O');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_spe_kind', '�S��Z���O', 'tinyint(3) unsigned', 0, 0, '�S��Z���O');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_a', '��/��', 'varchar(6)', 0, 0, '�����W');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_b', '�m/��/��/��', 'varchar(12)', 0, 0, '�m���ϦW');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_c', '��/��', 'varchar(12)', 0, 0, '����');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_d', '�F', 'varchar(6)', 0, 0, '�F');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_e', '��/��', 'varchar(20)', 0, 0, '����');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_f', '�q', 'varchar(6)', 0, 0, '�q');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_g', '��', 'varchar(8)', 0, 0, '��');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_h', '��', 'varchar(6)', 0, 0, '��');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_i', '��', 'varchar(8)', 0, 0, '��');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_j', '��', 'varchar(8)', 0, 0, '��');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_k', '��', 'varchar(6)', 0, 0, '��');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_l', '�Ӥ�', 'varchar(6)', 0, 0, '�Ӥ�');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_m', '��L', 'varchar(12)', 0, 0, '��L');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_class_kind', '�Z�ũʽ�', 'tinyint(3) unsigned', 0, 0, '�Z�ũʽ�');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '�Ǹ�');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_name', '�m�W', 'varchar(20)', 0, 0, '�ǥͩm�W');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_sex', '�ʧO', 'tinyint(3) unsigned', 0, 0, '�ʧO');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_birthday', '�X�ͦ~���', 'date', 0, 0, '�X�ͦ~���');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_blood_type', '�嫬', 'tinyint(3) unsigned', 0, 0, '�嫬');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_birth_place', '�X�ͦa', 'tinyint(3) unsigned', 0, 0, '�X�ͦa');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_kind', '�ǥͨ����O', 'varchar(60)', 0, 0, '�ǥͨ����O');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_country', '���y', 'varchar(20)', 0, 0, '���y');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_country_kind', '�ҷӺ���', 'tinyint(3) unsigned', 0, 0, '�ҷӺ���');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_person_id', '�����Ҹ��X', 'varchar(20)', 0, 0, '�����Ҹ��X');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_country_name', '���~�a', 'varchar(20)', 0, 0, '���~�a');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_1', '���y�a�}', 'varchar(60)', 0, 0, '���y�a�}');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_addr_2', '�s���a�}', 'varchar(60)', 0, 0, '�s���a�}');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_tel_1', '���y�q��', 'varchar(20)', 0, 0, '���y�q��');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'grandmoth_birthyear', '', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'grandmoth_alive', '�����s�\\.', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'grandmoth_name', '�����m�W', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'grandfath_alive', '�����s�\\.', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'grandfath_birthyear', '', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'grandfath_name', '�����m�W', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'guardian_email', '�q�l�l��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'guardian_hand_phone', '��ʹq��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'guardian_work_name', '¾��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'guardian_p_id', '�������ҷ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'guardian_unit', '�A�ȳ��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'guardian_relation', '�P���@�H���Y', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'guardian_address', '�a�}', 'varchar(60)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'guardian_phone', '���@�H�q��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'guardian_name', '���@�H�m�W', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'is_same_gua', '', 'char(1)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_note', '', 'tinytext', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_email', '�q�l�l��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_hand_phone', '��ʹq��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_home_phone', '�q��(�v)', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_phone', '�q��(��)', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_work_name', '¾��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_unit', '�A�ȳ��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_occupation', '¾�~', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_education', '�Ш|�{��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_abroad', '', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_p_id', '�������ҷ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_country', '', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_relation', '�P�����Y', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_alive', '�s�\\.', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_birthyear', '�X�ͦ~��', 'varchar(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'moth_name', '���˩m�W', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_email', '�q�l�l��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_note', '', 'tinytext', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_hand_phone', '��ʹq��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_home_phone', '�q��(�v)', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_phone', '�q��(��)', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_work_name', '¾��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_unit', '�A�ȳ��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_occupation', '¾�~', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_abroad', '', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_education', '�Ш|�{��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_p_id', '�������ҷ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_country', '', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_alive', '�s�\\.', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_relation', '�P�����Y', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_birthyear', '�X�ͦ~��', 'varchar(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'fath_name', '���˩m�W', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'addr_id', '', 'bigint(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'update_time', '', 'timestamp', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_domicile', 'update_id', '', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_brother_sister', 'bs_birthyear', '�~��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_brother_sister', 'bs_gradu', '�NŪ�Ǯ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_brother_sister', 'bs_id', '�N��', 'bigint(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_brother_sister', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_brother_sister', 'bs_name', '�m�W', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_brother_sister', 'bs_calling', '�ٿ�', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_kinfolk', 'kin_id', '���ݥN��', 'bigint(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_kinfolk', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_kinfolk', 'kin_name', '�m�W', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_kinfolk', 'kin_calling', '�ٿ�', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_kinfolk', 'kin_phone', '�q��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_kinfolk', 'kin_hand_phone', '���', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_kinfolk', 'kin_email', '�q�l�l��', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'eh_id', '�Ӯ׽s��', 'bigint(20) unsigned', 0, 0, '�Ӯ׽s��');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '�Ǹ�');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'eh_from', '�Ӯרӷ�', 'tinyint(3) unsigned', 0, 0, '�Ӯרӷ�');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'eh_from_date', '���פ��', 'date', 0, 0, '���פ��');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'eh_teacher', '�{���Ѯv', 'varchar(20)', 0, 0, '�{���Ѯv');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'eh_caes', '���D���O', 'varchar(60)', 0, 0, '���D���O');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'eh_meth', '���t�欰', 'varchar(60)', 0, 0, '���t�欰');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'eh_resion_memo', '�A�����}��]', 'varchar(40)', 0, 0, '�A�����}��]');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'eh_is_over', '���ק_', 'tinyint(3) unsigned', 0, 0, '���ק_');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'eh_over_memo', '���׭�]', 'varchar(40)', 0, 0, '���׭�]');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'eh_over_date', '���פ��', 'date', 0, 0, '���פ��');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'eh_case_date', '���ɤ��', 'date', 0, 0, '���ɤ��');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'eh_case_memo', '���ɤ��e', 'text', 0, 0, '���ɤ��e');
INSERT INTO sys_data_field VALUES ('stud_eduh', 'eh_case_relation', '�Ӯ����p�s��', 'varchar(30)', 0, 0, '�Ӯ����p�s��');
INSERT INTO sys_data_field VALUES ('subj_hour', 'sj_id', '�`��', 'char(2)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('subj_hour', 'sj_b_time', '�}�l�ɶ�', 'varchar(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('subj_hour', 'sj_e_time', '�����ɶ�', 'varchar(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('subj_hour', 'sj_kind', '�ƽ����O', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('subj_hour', 'sj_memo', '���ʤ��e', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('subj_cour', 'sc_five_kind', '���|���O', 'tinyint(3) unsigned', 0, 0, '���|���O');
INSERT INTO sys_data_field VALUES ('subj_cour', 'seme_year_seme', '�Ǧ~�Ǵ�', 'varchar(6)', 0, 0, '�Ǧ~�Ǵ�');
INSERT INTO sys_data_field VALUES ('subj_cour', 'seme_class', '�Z��', 'varchar(10)', 0, 0, '�Z��');
INSERT INTO sys_data_field VALUES ('subj_cour', 'subj_id', '���W��', 'smallint(5) unsigned', 0, 0, '���W��');
INSERT INTO sys_data_field VALUES ('subj_cour', 'sc_num', '�`��', 'tinyint(3) unsigned', 0, 0, '�`��');
INSERT INTO sys_data_field VALUES ('subj_cour', 'sc_perr', '�v��', 'double', 0, 0, '�v��');
INSERT INTO sys_data_field VALUES ('subj_cour', 'sc_percent', '���|���', 'double', 0, 0, '���|���');
INSERT INTO sys_data_field VALUES ('subj_cour', 'sc_order', '�C�L�Ƨ�', 'tinyint(3) unsigned', 0, 0, '�C�L�Ƨ�');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_preschool_id', '�Ш|���N��', 'varchar(8)', 0, 0, '�Ш|���ǮեN��_���X��');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_preschool_name', '�ǮզW��', 'varchar(40)', 0, 0, '�ǮզW��_���X��');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_tel_2', '�s���q��', 'varchar(20)', 0, 0, '�s���q��');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_tel_3', '��ʹq��', 'varchar(20)', 0, 0, '��ʹq��');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_mail', '�q�l�l��H�c', 'varchar(50)', 0, 0, '�q�l�l��H�c');
INSERT INTO sys_data_field VALUES ('stud_mid_abs', 'sma_year', '�~', 'varchar(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_abs', 'sma_month', '��', 'char(2)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_abs', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_abs', 'sma_kind', '�ʮu���O', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_abs', 'sma_days', '�ʮu�Ѽ�', 'int(10) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_rep', 'smr_id', '�y����', 'bigint(20) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_rep', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_rep', 'smr_date', '���', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_rep', 'smr_kind', '���O', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_rep', 'smr_num', '����', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_rep', 'smr_res', '�ƥ�', 'text', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_sco', 'smc_id', '�y����', 'bigint(20) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_sco', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_sco', 'smc_date', '���', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_sco', 'smc_name', '���ΦW��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_sco', 'smc_score', '���Φ��Z', 'decimal(4,2)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_sco', 'smc_class1', '�Z�Ŭ���', 'varchar(60)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_sco', 'smc_class2', '�ǥ۪ͦv�|����', 'varchar(60)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_mid_sco', 'smc_class3', '�ǮըҦ次��', 'varchar(60)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_move', 'move_id', '�y����', 'bigint(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_move', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_move', 'move_kind', '�������O', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_move', 'move_year_seme', '���ʾǦ~�Ǵ�', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_move', 'move_date', '���ʤ��', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_move', 'move_c_unit', '���ʮ֭�����W��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_move', 'move_c_date', '�֭���', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_move', 'move_c_word', '�֭�r', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_move', 'move_c_num', '�֭㸹', 'varchar(14)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_move', 'update_time', '��ʮɶ�', 'datetime', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_move', 'update_id', '��ʥN��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_move', 'update_ip', '���IP', 'varchar(15)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_grad', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_grad', 'grad_kind', '���~���O', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_grad', 'grad_date', '���~���', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_grad', 'grad_word', '���~�r', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_grad', 'grad_numb', '���~��', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme', 'seme_year_seme', '�Ǧ~�Ǵ�', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme', 'seme_class', '�~��', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme', 'seme_class_name', '�Z��', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme', 'seme_num', '�y��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme', 'seme_class_year_s', '������_�~��', 'int(10) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme', 'seme_class_s', '������_�Z��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme', 'seme_num_s', '������_�y��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_abs', 'seme_year_seme', '�Ǧ~�Ǵ�', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_abs', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_abs', 'abs_kind', '�ʮu���O', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_abs', 'abs_days', '�ʮu�Ѽ�', 'int(10) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'seme_year_seme', '�Ǧ~�Ǵ�', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_relation', '�������Y', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_family_kind', '�a�x����', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_family_air', '�a�x��^', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_farther', '���ޱФ覡', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_mother', '���ޱФ覡', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_live_state', '�~����', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_rich_state', '�g�٪��p', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_s1', '�̳߷R���', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_s2', '�̧x�����', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_s3', '�S��~��', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_s4', '����', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_s5', '�ͬ��ߺD', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_s6', '�H�����Y', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_s7', '�~�V�欰', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_s8', '���V�欰', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_s9', '�ǲߦ欰', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_s10', '���}�ߺD', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_eduh', 'sse_s11', '�J�{�欰', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_score', 'ss_id', '�y����', 'bigint(20) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_score', 'seme_year_seme', '�Ǧ~�Ǵ�', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_score', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_score', 'ss_subject', '���', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_score', 'ss_score', '���Z', 'decimal(4,2)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_score', 'ss_score_memo', '��r�y�z', 'varchar(200)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_score_s', 'sss_id', '�y����', 'bigint(20) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_score_s', 'ss_id', '���N��', 'bigint(20) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_score_s', 'sss_kind', '�������', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_score_s', 'sss_score', '���Z', 'decimal(4,2)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_spe', 'ss_id', '�y����', 'bigint(20) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_spe', 'seme_year_seme', '�Ǧ~�Ǵ�', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_spe', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_spe', 'sp_date', '���', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_spe', 'sp_memo', '�u�}��{�ƥ�', 'text', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_talk', 'sst_id', '�y����', 'bigint(20) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_talk', 'seme_year_seme', '�Ǧ~�Ǵ�', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_talk', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_talk', 'sst_date', '�O�����', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_talk', 'sst_name', '�s����H', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_talk', 'sst_main', '�s���ƶ�', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_talk', 'sst_memo', '���e�n�I', 'text', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_test', 'st_id', '�y����', 'bigint(20) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_test', 'seme_year_seme', '�Ǧ~�Ǵ�', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_test', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_test', 'st_numb', '�߲z����s��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_test', 'st_name', '���禨�Z������²��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_test', 'st_score_numb', '���Z�s��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_test', 'st_data_from', '��ƨӷ�', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_test', 'st_chang_numb', '�ϥΪ��ഫ��s��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_seme_test', 'st_name_long', '���禨�Z��������W', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_mschool_name', '�ǮզW��', 'varchar(40)', 0, 0, '�ǮզW��_��p');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_study_year', '�J�Ǧ~', 'int(10) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_base', 'curr_class_num', '�ثe�Z��', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_base', 'stud_study_cond', '', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_base', 'email_pass', '', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_title', 'teach_title_id', '¾�٥N��', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_title', 'title_name', '¾��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_title', 'title_kind', '¾�����O', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_title', 'title_short_name', '²��', 'varchar(12)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_title', 'room_id', '�B�ǥN��', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_title', 'title_memo', '�Ƶ�', 'text', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'teach_id', '�Юv�N��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'teach_person_id', '�����Ҧr��', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'name', '�m�W', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'sex', '�ʧO', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'age', '�~��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'birthday', '�ͤ�', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'birth_place', '�X�ͦa', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'marriage', '���B���A', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'address', '��}', 'varchar(60)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'home_phone', '�a���q��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'cell_phone', '���', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'office_home', '�줽�ǹq��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'teach_condition', '�b¾���A', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'teach_memo', '�Ƶ�', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'login_pass', '�n�J�K�X', 'varchar(12)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'teach_edu_kind', '�̰��Ǿ�', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'teach_edu_abroad', '�Ǿ���O', 'varchar(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'teach_sub_kind', '�Юv�˩w��', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'teach_check_kind', '�˩w���', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'teach_check_word', '�Юv�Үѵn�O�r��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'teach_is_cripple', '�O�_�⦳�ݻ٤�U', 'char(2)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'update_time', '', 'timestamp', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_base', 'update_id', '', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_connect', 'teach_id', '�Юv�N��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_connect', 'email', '�q�l�l��@', 'varchar(50)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_connect', 'email2', '�q�l�l��G', 'varchar(50)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_connect', 'email3', '�q�l�l��T', 'varchar(50)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_connect', 'selfweb', '�ӤH�����@', 'varchar(50)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_connect', 'selfweb2', '�ӤH�����G', 'varchar(50)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_connect', 'classweb', '�Z�ŭ����@', 'varchar(50)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_connect', 'classweb2', '�Z�ŭ����G', 'varchar(50)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_connect', 'ICQ', 'ICQ', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sys_data_table', 'd_table_name', '��ƪ�W��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sys_data_table', 'd_table_cname', '����W��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sys_data_table', 'd_table_group', '�s�զW��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sys_data_field', 'd_table_name', '��ƪ�W��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sys_data_field', 'd_field_name', '���W��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sys_data_field', 'd_field_cname', '�������W��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sys_data_field', 'd_field_type', '��쫬�A', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sys_data_field', 'd_field_order', '�Ƨ�', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sys_data_field', 'd_is_display', '�O�_���', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sys_data_field', 'd_field_xml', 'XML TAG', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_kind', 'pro_kind_id', '�Ҳսs��', 'smallint(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_kind', 'pro_kind_name', '�ҲզW��', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_kind', 'pro_kind_order', '�ƦC����', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_kind', 'home_index', '�����{��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_kind', 'store_path', '�{�����|', 'varchar(200)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_kind', 'pro_author', '�@��', 'text', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_kind', 'pro_parent', '�W�h�Ҳսs��', 'smallint(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_kind', 'pro_isopen', '���\\�i�J', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_kind', 'pro_islive', '�O�_�ҥ�', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_check_stu', 'pc_id', '�{�Ҭy����', 'int(11)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_check_stu', 'pro_kind_id', '�Ҳսs��', 'smallint(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_check_stu', 'stud_id', '�ǥ;Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_check_stu', 'teach_id', '���v�Юv�N��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_check_stu', 'use_date', '�ҥΤ��', 'datetime', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_check_stu', 'use_last_date', '�����ҥΤ��', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_check_stu', 'class_num', '�Z�Žs��', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_check', 'pc_id', '�{�Ҭy����', 'bigint(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_check', 'pro_kind_id', '�Ҳսs��', 'smallint(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_check', 'post_office', '�Ҧb�B�ǽs��', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_check', 'teach_id', '�Юv�N��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_check', 'teach_title_id', '¾�٥N��', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_check', 'is_admin', '�O�_���޲z��', 'char(1)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'teach_id', '�Юv�N��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'post_kind', '¾�O�s��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'post_office', '�Ҧb�B�ǽs��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'post_level', '¾��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'official_level', '�x��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'post_class', '¾��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'post_num', '��¾�N��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'bywork_num', '��¾�N��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'salay', '�~��', 'mediumint(9)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'appoint_date', '���¾���', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'arrive_date', '��¾���', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'approve_date', '��¾�֭���', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'approve_number', '��¾�֭�帹', 'varchar(60)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'teach_title_id', '¾��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'class_num', '���ЯZ��', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'update_time', '��s�ɶ�', 'timestamp', 0, 0, '');
INSERT INTO sys_data_field VALUES ('teacher_post', 'update_id', '��s��ID', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_id', '�ǮեN��', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_attr_id', '�Ǯ��ݩ�', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_cname', '����', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_cname_s', '²��', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_cname_ss', '�u��', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_ename', '�^��W��', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_sheng', '�Ҧb����', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_cdate', '�خդ��', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_mark', '���O', 'varchar(8)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_class', '�ŧO', 'varchar(8)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_montain', '�s�a�ѧO', 'char(2)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_area_tol', '�զa�`���n', 'float(10,2)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_area_ext', '�զa�`�����n', 'float(10,2)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_area_pin', '�ةW���n', 'float(10,2)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_money', '�ꥻ����X', 'float(10,2)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_money_o', '�g�`����X', 'float(10,2)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_local_name', '�m���ϧO', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_post_num', '�l���ϸ�', 'varchar(5)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_addr', '�Ǯզa�}', 'varchar(60)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_phone', '�Ǯչq��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_fax', '�ǯu', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_area', '�Ǯզ�F��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_kind', '�Ǯ�����', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_url', '�Ǯպ��}', 'varchar(50)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'sch_email', '�q�l�l��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'update_time', '', 'datetime', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'update_id', '', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_base', 'update_ip', '', 'varchar(15)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_class', 'enable', '�O�_�s�b', 'enum(\'1\',\'0\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_class', 'c_year', '�~', 'tinyint(2) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_class', 'c_name', '�Z�W', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_class', 'c_kind', '����', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_class', 'c_sort', '�Z�W�Ƨ�', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_class', 'class_sn', '�y����', 'mediumint(8) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_class', 'class_id', '�Z�ťN��', 'varchar(11)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_class', 'year', '�Ǧ~��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_class', 'semester', '�Ǵ�', 'enum(\'1\',\'2\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_module', 'pm_id', '�y����', 'bigint(11)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_module', 'pm_name', '�W��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_module', 'pm_item', '�ﶵ', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_module', 'pm_memo', '����', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_module', 'pm_value', '�]�w��', 'varchar(100)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_module_main', 'pm_name', '�{���N��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_module_main', 'm_display_name', '�{���W��', 'varchar(60)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_module_main', 'm_group_name', '�s��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_module_main', 'm_ver', '����', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_module_main', 'm_create_date', '�إ߮ɶ�', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('pro_module_main', 'm_path', '�w�]�s��ؿ�', 'varchar(60)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'seme_year_seme', '�Ǧ~�Ǵ�', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'stud_id', '�ǥͥN��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_p_relation', '�������Y', 'varchar(8)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_air', '�a�x��^', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_edu_fath', '���ޱФ覡', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_edu_moth', '���ޱФ覡', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_live', '�~����', 'varchar(12)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_camer', '�g�٪��p', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_sub_like', '�̳߷R���', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_sub_diff', '�̧x�����', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_spec', '�S��~��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_hobby', '����', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_habit', '�ߺD', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_relation', '�H�����Y', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_behave_o', '�~�V�欰', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_behave_i', '���V�欰', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_behave_edu', '�ǲߦ欰', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_habit_bad', '���}�ߺD', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_behave_agi', '�J�{�欰', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_temp1', '', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'guid_temp2', '', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'update_time', '', 'datetime', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guidance', 'update_id', '', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case', 'guid_c_id', '�Ӯ׽s��', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case', 'guid_c_from', '�Ӯרӷ�', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case', 'guid_c_bdate', '���פ��', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case', 'guid_c_teacher', '�{���Ѯv', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case', 'guid_c_kind', '���D���O', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case', 'guid_c_behave', '���t�欰', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case', 'guid_c_reason', '�A�����}��]', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case', 'guid_c_isover', '���ק_', 'char(2)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case', 'guid_c_over_reason', '���פ��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case', 'guid_c_edate', '���ɤ��', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case', 'update_time', '��s�ɶ�', 'datetime', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case', 'update_id', '��s�̥N��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case_list', 'guid_l_id', '�y����', 'bigint(20) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case_list', 'guid_c_id', '�Ӯ׽s��', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case_list', 'guid_l_date', '���ɤ��', 'date', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case_list', 'guid_l_con', '���ɤ�', 'varchar(40)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case_list', 'update_id', '��s�̥N��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case_u', 'guid_u_id', '�Ӯ׽s��', 'bigint(20) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('stud_guid_case_u', 'guid_c_id', '���p�s��', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('seme_class', 'current_school_year', '�Ǧ~�Ǵ�', 'smallint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('seme_class', 'teach_id', '�Юv�N��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('seme_class', 'teach_title_id', '�Юv¾�٥N��', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('seme_class', 'class_num', '���ЯZ��', 'varchar(6)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('seme_class', 'subject_id1', '���Ь�ؤ@', 'tinyint(3)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('seme_class', 'subject_id2', '���Ь�ؤG', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('seme_class', 'subject_id3', '���Ь�ؤT', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('seme_class', 'subject_id4', '���Ь�إ|', 'tinyint(3)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('seme_class', 'subject_id5', '���Ь�ؤ�', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('seme_class', 'subject_id6', '���Ь�ؤ�', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_room', 'room_id', '�B�ǽs��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_room', 'room_name', '�B�ǦW��', 'varchar(30)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_room', 'room_tel', '�B�ǹq��', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_room', 'room_fax', '�B�Ƕǯu', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('school_room', 'enable', '�O�_�@��', 'enum(\'1\',\'0\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('comment', 'serial', '�y����', 'smallint(8) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('comment', 'teacher_id', '�Юv�N��', 'int(8) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('comment', 'subject', '���', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('comment', 'property', '', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('comment', 'kind', '���O', 'tinyint(2) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('comment', 'level', '����', 'varchar(10)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('comment', 'comm', '���y���e', 'varchar(200)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('comment_kind', 'kind_serial', '�y����', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('comment_kind', 'kind_teacher_id', '�Юv�N��', 'int(8) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('comment_kind', 'kind_name', '���O�W��', 'varchar(50)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('comment_level', 'level_serial', '�y����', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('comment_level', 'level_teacher_id', '�Юv�N��', 'int(8) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('comment_level', 'level_name', '����', 'varchar(50)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_col', 'col_sn', '�y����', 'smallint(5) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_col', 'interface_sn', '�ɭ��N��', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_col', 'col_text', '���W��', 'varchar(255)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_col', 'col_value', '���ﶵ', 'varchar(255)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_col', 'col_type', '��챱�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_col', 'col_fn', '���Ȩ禡', 'varchar(255)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_col', 'col_ss', '��ج���', 'enum(\'n\',\'y\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_col', 'col_comment', '�I�s���', 'enum(\'n\',\'y\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_col', 'col_check', '�ˬd�ŭ�', 'enum(\'0\',\'1\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_col', 'col_date', '�إ߮ɶ�', 'datetime', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_col', 'enable', '�O�_�@��', 'enum(\'1\',\'0\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_interface', 'interface_sn', '�˪��N��', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_interface', 'title', '���D', 'varchar(255)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_interface', 'text', '����', 'text', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_interface', 'html', '', 'text', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_interface', 'sshtml', '', 'text', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_interface', 'xml', '', 'text', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_interface', 'all_ss', '', 'enum(\'n\',\'y\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_value', 'sc_sn', '�y����', 'int(10) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_value', 'interface_sn', '�ɭ��N��', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_value', 'date', '�إߤ��', 'datetime', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_value', 'stud_id', '�Ǹ�', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_value', 'class_id', '�Z�ťN��', 'varchar(11)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_value', 'value', '��', 'text', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_value', 'sel_year', '�Ǧ~', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_input_value', 'sel_seme', '�Ǵ�', 'enum(\'1\',\'2\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_setup', 'setup_id', '�y����', 'smallint(5) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_setup', 'year', '�Ǧ~', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_setup', 'semester', '�Ǵ�', 'enum(\'1\',\'2\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_setup', 'class_year', '�~��', 'tinyint(2) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_setup', 'performance_test_times', '�w���Ҭd����', 'tinyint(1) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_setup', 'practice_test_times', '�w�]�Ҹզ���', 'tinyint(2) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_setup', 'test_ratio', '��v', 'varchar(255)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_setup', 'rule', '���ĳ]�w', 'varchar(255)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_setup', 'score_mode', '�U�~�űĥάۦP�]�w', 'enum(\'all\',\'severally\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_setup', 'sections', '�C��W�Ҹ`��', 'tinyint(4)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_setup', 'interface_sn', '���Z��ɭ�', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_setup', 'update_date', '��s�ɶ�', 'datetime', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_setup', 'enable', '�O�_�@��', 'enum(\'1\',\'0\',\'always\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_subject', 'subject_id', '��جy����', 'tinyint(3) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_subject', 'subject_name', '��ئW��', 'varchar(255)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_subject', 'subject_school', '�ŦX��ئ~��', 'set(\'0\',\'1\',\'2\',\'3\',\'4\',\'5\',\'6', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_subject', 'subject_kind', '������O(���ξǬ�)', 'enum(\'scope\',\'subject\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('score_subject', 'enable', '�O�_�@��', 'enum(\'1\',\'0\')', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sfs3_log', 'log_sn', 'log�s��', 'int(10) unsigned', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sfs3_log', 'log', '�D�n�T��', 'text', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sfs3_log', 'mark', '���ѼаO', 'varchar(255)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sfs3_log', 'id', '������', 'varchar(20)', 0, 0, '');
INSERT INTO sys_data_field VALUES ('sfs3_log', 'time', '�ɶ�', 'datetime', 0, 0, '');
# --------------------------------------------------------

#
# ��ƪ�榡�G `sys_data_table`
#

CREATE TABLE sys_data_table (
  d_table_name varchar(30) NOT NULL default '',
  d_table_cname varchar(30) NOT NULL default '',
  d_table_group varchar(30) NOT NULL default '',
  PRIMARY KEY  (d_table_name),
  UNIQUE KEY d_table_name (d_table_name)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `sys_data_table`
#

INSERT INTO sys_data_table VALUES ('score_input_col', '���Z��ɭ�-���', '���Z���');
INSERT INTO sys_data_table VALUES ('score_input_interface', '���Z��ɭ�', '���Z���');
INSERT INTO sys_data_table VALUES ('compclass', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('borrow', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('bookch1', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('book', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('board_p', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('board_kind', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('board_check', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('stud_guidance', '���ɰ򥻸��', '�ǥͻ��ɸ��');
INSERT INTO sys_data_table VALUES ('stud_guid_case_u', '���ɭӮ׸��-���p�O��', '�ǥͻ��ɸ��');
INSERT INTO sys_data_table VALUES ('pro_check', '�Ҳջ{��', '�t�γ]�w');
INSERT INTO sys_data_table VALUES ('pro_check_stu', '�ǥͻ{��', '�t�γ]�w');
INSERT INTO sys_data_table VALUES ('pro_kind', '�Ҳն���', '�t�γ]�w');
INSERT INTO sys_data_table VALUES ('stud_behabior', '', '�ǥͻ��ɸ��');
INSERT INTO sys_data_table VALUES ('stud_guid_case_list', '���ɭӮ׸��-���ɤ��e', '�ǥͻ��ɸ��');
INSERT INTO sys_data_table VALUES ('stud_guid_case', '���ɭӮ׸��', '�ǥͻ��ɸ��');
INSERT INTO sys_data_table VALUES ('pro_module_main', '�{���]�w�O��', '�t�γ]�w');
INSERT INTO sys_data_table VALUES ('stud_base', '�ǥͰ򥻸��', '�ǥ͸��');
INSERT INTO sys_data_table VALUES ('stud_brother_sister', '�ǥͥS�̩j�f', '�ǥ͸��');
INSERT INTO sys_data_table VALUES ('stud_domicile', '�ǥͮa�x���', '�ǥ͸��');
INSERT INTO sys_data_table VALUES ('stud_eduh', '���ɭӮ׸��', '�ǥ͸��');
INSERT INTO sys_data_table VALUES ('stud_grad', '���׷~����', '�ǥ͸��');
INSERT INTO sys_data_table VALUES ('stud_kinfolk', '��L����', '�ǥ͸��');
INSERT INTO sys_data_table VALUES ('stud_mid_abs', '�Ǵ��ʮu', '�������');
INSERT INTO sys_data_table VALUES ('stud_mid_rep', '�������g�O��', '�������');
INSERT INTO sys_data_table VALUES ('stud_mid_sco', '���θ��', '�������');
INSERT INTO sys_data_table VALUES ('stud_move', '��������', '�������');
INSERT INTO sys_data_table VALUES ('stud_seme', '�ӧO�Ǵ����', '�Ǵ����');
INSERT INTO sys_data_table VALUES ('stud_seme_abs', '�Ǵ��ʮu', '�Ǵ����');
INSERT INTO sys_data_table VALUES ('stud_seme_eduh', '�Ǵ����ɰ򥻸��', '�Ǵ����');
INSERT INTO sys_data_table VALUES ('stud_seme_score', '�Ǵ����Z', '�Ǵ����');
INSERT INTO sys_data_table VALUES ('stud_seme_score_s', '�Ǵ�����-�������Z', '�Ǵ����');
INSERT INTO sys_data_table VALUES ('stud_seme_spe', '�S���u�}��{', '�Ǵ����');
INSERT INTO sys_data_table VALUES ('stud_seme_talk', '�Ǵ����ɳX�ͰO��', '�Ǵ����');
INSERT INTO sys_data_table VALUES ('stud_seme_test', '�߲z���禨�Z', '�Ǵ����');
INSERT INTO sys_data_table VALUES ('stud_sick_f', '�ǥͮa�x�f�v', '�ǥͰ��d���');
INSERT INTO sys_data_table VALUES ('stud_sick_p', '�ǥͭӤH�f�v', '�ǥͰ��d���');
INSERT INTO sys_data_table VALUES ('subj_cour', '�~�Ŷ}�Һ��@', '�ҰȺ޲z');
INSERT INTO sys_data_table VALUES ('subj_hour', '�W�Үɶ��]�w', '�ҰȺ޲z');
INSERT INTO sys_data_table VALUES ('sys_data_field', '�t�����', '�t�γ]�w');
INSERT INTO sys_data_table VALUES ('sys_data_table', '�t�θ�ƪ�', '�t�γ]�w');
INSERT INTO sys_data_table VALUES ('teacher_base', '�Юv�򥻸��', '�Юv���');
INSERT INTO sys_data_table VALUES ('teacher_connect', '�Юv�������', '�Юv���');
INSERT INTO sys_data_table VALUES ('teacher_post', '�Юv��¾���', '�Юv���');
INSERT INTO sys_data_table VALUES ('teacher_subject', '�Юv���Ь��', '�Юv���');
INSERT INTO sys_data_table VALUES ('teacher_title', '�Юv¾�ٸ��', '�Юv���');
INSERT INTO sys_data_table VALUES ('pro_module', '�{���ﶵ�]�w', '�t�γ]�w');
INSERT INTO sys_data_table VALUES ('school_class', '�Z�Ÿ��', '�Ǯո��');
INSERT INTO sys_data_table VALUES ('school_base', '�Ǯհ򥻸��', '�Ǯո��');
INSERT INTO sys_data_table VALUES ('comment', '���y', '���Z���');
INSERT INTO sys_data_table VALUES ('comment_kind', '���y����', '���Z���');
INSERT INTO sys_data_table VALUES ('comment_level', '���y����', '���Z���');
INSERT INTO sys_data_table VALUES ('docup', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('docup_p', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('exam', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('exam_kind', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('exam_stud', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('exam_stud_data', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('file_db', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('fixed_check', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('fixed_kind', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('fixedtb', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('form_all', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('form_col', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('form_fill_in', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('form_value', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('goodstu', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('gscore', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('inquire', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('new_board', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('quire_data', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('sch_doc1', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('sch_doc1_unit', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('school_board', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('soft', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('softm', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('stud_addr', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('tape', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('tapem', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('tool', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('toolm', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('webcal_entry', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('webcal_entry_repeats', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('webcal_entry_user', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('webcal_user', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('webcal_user_layers', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('webcal_user_pref', '', '�հȼҲ�');
INSERT INTO sys_data_table VALUES ('sfs_log', '', '�t�γ]�w');
INSERT INTO sys_data_table VALUES ('sfs_text', '', '�t�γ]�w');
INSERT INTO sys_data_table VALUES ('school_class_num', '�Ǧ~�Z�ż�', '�Ǯո��');
INSERT INTO sys_data_table VALUES ('school_room', '�B�Ǹ��', '�Ǯո��');
INSERT INTO sys_data_table VALUES ('score_course', '�Ǵ��ƽҰO��', '�ҰȺ޲z');
INSERT INTO sys_data_table VALUES ('score_input_value', '���Z��ɭ�-��', '���Z���');
INSERT INTO sys_data_table VALUES ('score_setup', '���Z�򥻳]�w', '���Z���');
INSERT INTO sys_data_table VALUES ('score_subject', '�Ǭ���', '���Z���');
INSERT INTO sys_data_table VALUES ('seme_class', '�Ǵ��Z�ŰO��', '�Ǵ����');
# --------------------------------------------------------

#
# ��ƪ�榡�G `teacher_base`
#

CREATE TABLE teacher_base (
  teach_id varchar(20) NOT NULL default '',
  teach_person_id varchar(10) NOT NULL default '',
  name varchar(20) NOT NULL default '',
  sex tinyint(3) unsigned NOT NULL default '0',
  age tinyint(3) unsigned NOT NULL default '0',
  birthday date NOT NULL default '0000-00-00',
  birth_place tinyint(3) unsigned NOT NULL default '0',
  marriage tinyint(3) unsigned default NULL,
  address varchar(60) default NULL,
  home_phone varchar(20) default NULL,
  cell_phone varchar(20) default NULL,
  office_home varchar(20) default NULL,
  teach_condition tinyint(3) unsigned NOT NULL default '0',
  teach_memo varchar(30) default NULL,
  login_pass varchar(32) NOT NULL default '',
  teach_edu_kind tinyint(3) unsigned NOT NULL default '0',
  teach_edu_abroad varchar(4) NOT NULL default '',
  teach_sub_kind varchar(40) NOT NULL default '',
  teach_check_kind tinyint(3) unsigned NOT NULL default '0',
  teach_check_word varchar(30) NOT NULL default '',
  teach_is_cripple char(2) NOT NULL default '',
  update_time timestamp NOT NULL,
  update_id varchar(20) NOT NULL default '',
  teacher_sn smallint(6) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (teach_id),
  KEY teacher_sn (teacher_sn)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `teacher_base`
#

INSERT INTO teacher_base VALUES ('1001', '', '���Ѯv', 1, 0, '2000-01-01', 1, 1, '', '', '', '', 0, '', 'bac8fafaed7c982a04e229fe01ce2a7', 0, '', '', 0, '', '', 20011001103125, '', 1);
# --------------------------------------------------------

#
# ��ƪ�榡�G `teacher_connect`
#

CREATE TABLE teacher_connect (
  teacher_sn smallint(6) unsigned NOT NULL default '0',
  email varchar(50) default NULL,
  email2 varchar(50) default NULL,
  email3 varchar(50) default NULL,
  selfweb varchar(50) default NULL,
  selfweb2 varchar(50) default NULL,
  classweb varchar(50) default NULL,
  classweb2 varchar(50) default NULL,
  ICQ varchar(20) default NULL,
  PRIMARY KEY  (teacher_sn)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `teacher_connect`
#

# --------------------------------------------------------

#
# ��ƪ�榡�G `teacher_post`
#

CREATE TABLE teacher_post (
  teacher_sn smallint(6) unsigned NOT NULL default '0',
  post_kind int(4) unsigned NOT NULL default '0',
  post_office varchar(40) default NULL,
  post_level tinyint(3) unsigned NOT NULL default '0',
  official_level tinyint(3) unsigned default NULL,
  post_class varchar(40) default NULL,
  post_num varchar(20) default NULL,
  bywork_num varchar(20) default NULL,
  salay mediumint(9) NOT NULL default '0',
  appoint_date date default '0000-00-00',
  arrive_date date default '0000-00-00',
  approve_date date default '0000-00-00',
  approve_number varchar(60) default NULL,
  teach_title_id varchar(40) default NULL,
  class_num varchar(6) NOT NULL default '0',
  update_time timestamp NOT NULL,
  update_id varchar(20) NOT NULL default '',
  PRIMARY KEY  (teacher_sn)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `teacher_post`
#

INSERT INTO teacher_post VALUES (1, 5, '2', 0, 3, '0', '', '', 0, '0000-00-00', '0000-00-00', '0000-00-00', '', '9', '', 20011001103125, '');
# --------------------------------------------------------

#
# ��ƪ�榡�G `teacher_subject`
#

CREATE TABLE teacher_subject (
  subject_id tinyint(3) unsigned NOT NULL default '0',
  subject_name varchar(20) NOT NULL default '',
  subject_year tinyint(4) unsigned default NULL,
  PRIMARY KEY  (subject_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `teacher_subject`
#

INSERT INTO teacher_subject VALUES (1, '��y', 0);
INSERT INTO teacher_subject VALUES (2, '�ƾ�', 0);
INSERT INTO teacher_subject VALUES (3, '���|', 0);
INSERT INTO teacher_subject VALUES (4, '�۵M', 0);
INSERT INTO teacher_subject VALUES (5, '����', 0);
INSERT INTO teacher_subject VALUES (6, '����', 0);
INSERT INTO teacher_subject VALUES (7, '��|', 0);
INSERT INTO teacher_subject VALUES (8, '�ͬ��P��?z', 0);
INSERT INTO teacher_subject VALUES (9, '���d�Ш|', 0);
INSERT INTO teacher_subject VALUES (10, '�D�w', 0);
INSERT INTO teacher_subject VALUES (11, '���d', 0);
INSERT INTO teacher_subject VALUES (12, '�m�g����', 0);
INSERT INTO teacher_subject VALUES (13, '���鬡��', 0);
INSERT INTO teacher_subject VALUES (14, '�g�r', 0);
INSERT INTO teacher_subject VALUES (15, '�q��', 0);
INSERT INTO teacher_subject VALUES (16, '�^�y', 0);
# --------------------------------------------------------

#
# ��ƪ�榡�G `teacher_title`
#

CREATE TABLE teacher_title (
  teach_title_id tinyint(3) unsigned NOT NULL auto_increment,
  title_name varchar(50) NOT NULL default '',
  title_kind tinyint(4) NOT NULL default '0',
  title_short_name varchar(12) default NULL,
  room_id tinyint(4) NOT NULL default '0',
  title_memo text NOT NULL,
  enable enum('1','0') NOT NULL default '1',
  PRIMARY KEY  (teach_title_id)
) ;

#
# �C�X�H�U��Ʈw���ƾڡG `teacher_title`
#

INSERT INTO teacher_title VALUES (1, '�ժ�', 1, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (2, '�аȥD��', 2, '�D��', 0, '', '1');
INSERT INTO teacher_title VALUES (3, '�V�ɥD��', 2, '�D��', 0, '', '1');
INSERT INTO teacher_title VALUES (4, '�`�ȥD��', 2, '�D��', 0, '', '1');
INSERT INTO teacher_title VALUES (5, '���ɫǥD��', 2, '�D��', 0, '', '1');
INSERT INTO teacher_title VALUES (6, '�оǲժ�', 3, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (7, '���U�ժ�', 3, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (8, '�]�Ʋժ�', 3, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (9, '��T�ժ�', 3, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (10, '�ͬ��Ш|�ժ�', 3, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (11, '��òժ�', 3, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (12, '�X�ǲժ�', 3, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (13, '�ưȲժ�', 3, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (14, '���ɲժ�', 3, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (15, '�ݥ��H��', 3, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (16, '�ݥ��D�p', 3, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (18, '�Юv�ݾǦ~�D��', 4, '�Юv', 0, '', '1');
INSERT INTO teacher_title VALUES (19, '�ť��Юv', 4, '�Юv', 0, '', '1');
INSERT INTO teacher_title VALUES (20, '����Юv', 4, '�Юv', 0, '', '1');
INSERT INTO teacher_title VALUES (21, '���X��Юv', 5, '�Юv', 0, '', '1');
INSERT INTO teacher_title VALUES (22, '�S�бЮv', 6, '�Юv', 0, '', '1');
INSERT INTO teacher_title VALUES (17, '���X����', 3, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (101, '�H�ƥD��', 11, '�H�ƥD��', 0, '', '1');
INSERT INTO teacher_title VALUES (102, '�H�ƺ޲z��', 12, '�H��', 0, '', '1');
INSERT INTO teacher_title VALUES (103, '�|�p�D��', 13, '�D�p�D��', 0, '', '1');
INSERT INTO teacher_title VALUES (104, '�|�p��', 14, '�D�p', 0, '', '1');
INSERT INTO teacher_title VALUES (105, '�ժ�', 15, '�ժ�', 0, '', '1');
INSERT INTO teacher_title VALUES (106, '�F��', 16, '�F��', 0, '', '1');
INSERT INTO teacher_title VALUES (107, '�@�z�v', 17, '�@�z�v', 0, '', '1');
INSERT INTO teacher_title VALUES (108, '�@�h', 18, '�@�h', 0, '', '1');
INSERT INTO teacher_title VALUES (109, '�u��', 19, '�u��', 0, '', '1');
INSERT INTO teacher_title VALUES (110, 'ĵ��', 20, 'ĵ��', 0, '', '1');
INSERT INTO teacher_title VALUES (111, '����', 21, '����', 0, '', '1');
INSERT INTO teacher_title VALUES (23, '�a�ʥN�z�Юv', 7, '�Юv', 0, '', '1');
INSERT INTO teacher_title VALUES (24, '�L�ʥN�z�Юv', 7, '�Юv', 0, '', '1');
INSERT INTO teacher_title VALUES (25, '�N�z�Юv', 7, '�Юv', 0, '', '1');
INSERT INTO teacher_title VALUES (26, '�u���N�ұЮv', 8, '�Юv', 0, '', '1');

#
# ��ƪ�榡�G `parent_auth`
#

CREATE TABLE parent_auth (
  parent_sn int(11) NOT NULL auto_increment,
  parent_id varchar(10) NOT NULL default '',
  login_id varchar(20) NOT NULL default '',
  parent_pass varchar(20) NOT NULL default '',
  start_code varchar(10) NOT NULL default '',
  email varchar(60) NOT NULL default '',
  date datetime NOT NULL default '0000-00-00 00:00:00',
  enable tinyint(1) unsigned NOT NULL default '1',
  UNIQUE KEY parent_sn (parent_sn),
  KEY parent_id (parent_id)
) ;

#
# ��ƪ�榡�G `reward`
#

CREATE TABLE reward (
  reward_div varchar(4) NOT NULL default '0',
  reward_id bigint(20) NOT NULL auto_increment,
  stud_id varchar(20) NOT NULL default '',
  reward_kind varchar(10) NOT NULL default '',
  reward_year_seme varchar(6) NOT NULL default '',
  reward_date date NOT NULL default '0000-00-00',
  reward_reason text,
  reward_c_date date default '0000-00-00',
  reward_base text,
  reward_cancel_date date NOT NULL default '0000-00-00',
  update_id varchar(20) NOT NULL default '',
  update_ip varchar(15) NOT NULL default '',
  reward_sub tinyint(4) NOT NULL default '0',
  dep_id bigint(20) NOT NULL default '0',
  student_sn int(10) unsigned default '0',
  PRIMARY KEY  (reward_id)
) ;

#
# ��ƪ�榡�G `stud_seme_score_oth`
#

CREATE TABLE stud_seme_score_oth (
	seme_year_seme varchar(6) NOT NULL,
	stud_id varchar(20) NOT NULL,
	ss_kind varchar(12) NOT NULL,
	ss_id smallint(5) unsigned NOT NULL default'0',
	ss_val varchar(20) NOT NULL,
	PRIMARY KEY (seme_year_seme,stud_id,ss_kind,ss_id)
) ;

#
# ��ƪ�榡�G `stud_seme_rew`
#

CREATE TABLE stud_seme_rew (
	seme_year_seme varchar(6) NOT NULL,
        student_sn int(10) unsigned NOT NULL default '0',
	stud_id varchar(20) NOT NULL,
	sr_kind_id tinyint(4) NOT NULL,
	sr_num tinyint(4) NOT NULL,
	PRIMARY KEY (seme_year_seme,stud_id,sr_kind_id)
) ;

#
# ��ƪ�榡�G `stud_seme_score_nor`
#

CREATE TABLE stud_seme_score_nor (
	seme_year_seme varchar(6) NOT NULL,
	student_sn int(10) unsigned NOT NULL default '0',
	ss_id smallint(5) unsigned NOT NULL,
	ss_score decimal(4,2) default NULL,
	ss_score_memo text,
	PRIMARY KEY (seme_year_seme,student_sn,ss_id)
) ;
