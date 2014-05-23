# $Id: sfs2.sql 5311 2009-01-10 08:11:55Z hami $
# phpMyAdmin MySQL-Dump
# version 2.2.0rc3
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# �D��: localhost
# Generation Time: August 6, 2001, 11:30 am
# Server version: 3.22.32
# PHP Version: 4.0.6
# �ƾڮw : sfs2
# --------------------------------------------------------

#
# �ƾڪ����c 'pro_check'
#

DROP TABLE IF EXISTS pro_check;
CREATE TABLE pro_check (
   pc_id bigint(20) DEFAULT '0' NOT NULL auto_increment,
   pro_kind_id smallint(6) DEFAULT '0' NOT NULL,
   post_office tinyint(4) DEFAULT '-1' NOT NULL,
   teach_id varchar(20) DEFAULT 'none' NOT NULL,
   teach_title_id tinyint(4) DEFAULT '-1' NOT NULL,
   is_admin char(1) NOT NULL,
   PRIMARY KEY (pc_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'pro_check_stu'
#

DROP TABLE IF EXISTS pro_check_stu;
CREATE TABLE pro_check_stu (
   pc_id int(11) DEFAULT '0' NOT NULL auto_increment,
   pro_kind_id smallint(6) DEFAULT '0' NOT NULL,
   stud_id varchar(20) NOT NULL,
   teach_id varchar(20) NOT NULL,
   use_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   use_last_date date DEFAULT '0000-00-00' NOT NULL,
   class_num varchar(6) NOT NULL,
   PRIMARY KEY (pc_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'pro_kind'
#

DROP TABLE IF EXISTS pro_kind;
CREATE TABLE pro_kind (
   pro_kind_id smallint(6) DEFAULT '0' NOT NULL auto_increment,
   pro_kind_name varchar(40) NOT NULL,
   pro_kind_order tinyint(4) DEFAULT '0' NOT NULL,
   home_index varchar(30) NOT NULL,
   store_path varchar(200) NOT NULL,
   pro_author text NOT NULL,
   pro_parent smallint(6) DEFAULT '0' NOT NULL,
   PRIMARY KEY (pro_kind_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'school_base'
#
DROP TABLE IF EXISTS school_base;
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
) TYPE=MyISAM;

#
# Dumping data for table `school_base`
#

INSERT INTO school_base VALUES ('','����','�ն�ۥѳn���y��','�ն�ۥѳn���y��','�ն�ۥѳn���y��','sfs','�x����','0000-00-00','���`','�@��a��','�_','0.00','0.00','0.00','0.00','0.00','','','','','','','','sfs.wpes.tcc.edu.tw','','2001-10-01 21:20:56','','192.168.0.1');

    

#
# �ƾڪ����c 'school_class_num' �Ǧ~�ׯZ�ż�
#

DROP TABLE IF EXISTS school_class_num;
CREATE TABLE school_class_num (
   curr_class_year varchar(5) NOT NULL,
   c_year char(3) DEFAULT '0' NOT NULL,
   c_num tinyint(4) DEFAULT '0' NOT NULL,
   UNIQUE curr_class_year (curr_class_year, c_year)
);



#
# �ƾڪ����c 'school_room'
#
DROP TABLE IF EXISTS school_room;
CREATE TABLE school_room (
   room_id tinyint(3) unsigned DEFAULT '0' NOT NULL auto_increment,
   room_name varchar(30) NOT NULL,
   room_tel varchar(20) NOT NULL,
   room_fax varchar(20) NOT NULL,
   PRIMARY KEY (room_id)
);


#
# �ƾڪ����c 'seme_class'
#

DROP TABLE IF EXISTS seme_class;
CREATE TABLE seme_class (
   current_school_year smallint(4) DEFAULT '0' NOT NULL,
   teach_id varchar(20) NOT NULL,
   teach_title_id tinyint(4) DEFAULT '0' NOT NULL,
   class_num varchar(6) NOT NULL,
   subject_id1 tinyint(3) DEFAULT '0' NOT NULL,
   subject_id2 tinyint(3) unsigned DEFAULT '0' NOT NULL,
   subject_id3 tinyint(3) unsigned DEFAULT '0' NOT NULL,
   subject_id4 tinyint(3) DEFAULT '0' NOT NULL,
   subject_id5 tinyint(3) unsigned DEFAULT '0' NOT NULL,
   subject_id6 tinyint(3) unsigned DEFAULT '0' NOT NULL,
   PRIMARY KEY (current_school_year, teach_id)
);
# --------------------------------------------------------

DROP TABLE IF EXISTS stud_addr;
CREATE TABLE stud_addr (
   addr_id bigint(20) unsigned DEFAULT '0' NOT NULL auto_increment,
   stud_id varchar(20) NOT NULL,
   stud_addr_h_a varchar(6) NOT NULL,
   stud_addr_h_b varchar(10) NOT NULL,
   stud_addr_h_c varchar(6) NOT NULL,
   stud_addr_h_d varchar(6) NOT NULL,
   stud_addr_h_e varchar(20) NOT NULL,
   stud_addr_h_f varchar(4) NOT NULL,
   stud_addr_h_g varchar(8) NOT NULL,
   stud_addr_h_h varchar(6) NOT NULL,
   stud_addr_h_i varchar(6) NOT NULL,
   stud_addr_h_j varchar(6) NOT NULL,
   stud_addr_h_k varchar(5) NOT NULL,
   stud_addr_h_l varchar(5) NOT NULL,
   stud_phone_h varchar(20) NOT NULL,
   stud_handphone_h varchar(20) NOT NULL,
   stud_addr_c_a varchar(6) NOT NULL,
   stud_addr_c_b varchar(10) NOT NULL,
   stud_addr_c_c varchar(6) NOT NULL,
   stud_addr_c_d varchar(6) NOT NULL,
   stud_addr_c_e varchar(20) NOT NULL,
   stud_addr_c_f varchar(4) NOT NULL,
   stud_addr_c_g varchar(8) NOT NULL,
   stud_addr_c_h varchar(6) NOT NULL,
   stud_addr_c_i varchar(6) NOT NULL,
   stud_addr_c_j varchar(6) NOT NULL,
   stud_addr_c_k varchar(5) NOT NULL,
   stud_addr_c_l varchar(5) NOT NULL,
   stud_phone_c varchar(20) NOT NULL,
   stud_handphone_c varchar(20) NOT NULL,
   update_id varchar(20) NOT NULL,
   update_time timestamp(14),
   is_same char(1) DEFAULT '1' NOT NULL,
   PRIMARY KEY (addr_id),
   KEY stud_phone_h (stud_phone_h),
   KEY stud_id (stud_id)
);


# --------------------------------------------------------

#
# �ƾڪ����c 'stud_base'
#

DROP TABLE IF EXISTS stud_base;
CREATE TABLE stud_base (
   stud_id varchar(20) NOT NULL,
   stud_name varchar(20) NOT NULL,
   stud_person_id varchar(10) NOT NULL,
   stud_country varchar(20) NOT NULL,
   stud_abroad varchar(20) NOT NULL,
   addr_id bigint(20) unsigned DEFAULT '0' NOT NULL,
   stud_birthday date DEFAULT '0000-00-00' NOT NULL,
   stud_sex tinyint(3) unsigned DEFAULT '0' NOT NULL,
   stud_blood_type tinyint(3) unsigned DEFAULT '0' NOT NULL,
   stud_study_cond tinyint(3) unsigned DEFAULT '0',
   stud_study_year int(10) unsigned DEFAULT '0' NOT NULL,
   condition tinyint(3) unsigned DEFAULT '0' NOT NULL,
   stud_row tinyint(3) unsigned DEFAULT '0' NOT NULL,
   sister_brother tinyint(3) unsigned DEFAULT '0' NOT NULL,
   email_pass varchar(12) NOT NULL,
   create_date date DEFAULT '0000-00-00' NOT NULL,
   stud_kind tinyint(4) DEFAULT '0' NOT NULL,
   stud_class_kind tinyint(4) DEFAULT '0' NOT NULL,
   stud_spe_kind tinyint(4) DEFAULT '0' NOT NULL,
   stud_spe_class_kind tinyint(4) DEFAULT '0' NOT NULL,
   stud_preschool_id varchar(6) NOT NULL,
   stud_preschool_name varchar(40) NOT NULL,
   stud_preschool_status tinyint(4) DEFAULT '0' NOT NULL,
   stud_hospital varchar(20) NOT NULL,
   stud_graduate_kind char(2) NOT NULL,
   stud_graduate_date date DEFAULT '0000-00-00' NOT NULL,
   stud_graduate_word varchar(20) NOT NULL,
   stud_graduate_num varchar(14),
   stud_graduate_school varchar(30) NOT NULL,   
   class_num_1 varchar(6) NOT NULL,
   class_num_2 varchar(6) NOT NULL,
   class_num_3 varchar(6) NOT NULL,
   class_num_4 varchar(6) NOT NULL,
   class_num_5 varchar(6) NOT NULL,
   class_num_6 varchar(6) NOT NULL,
   class_num_7 varchar(6) NOT NULL,
   class_num_8 varchar(6) NOT NULL,
   class_num_9 varchar(6) NOT NULL,
   class_num_10 varchar(6) NOT NULL,
   class_num_11 varchar(6) NOT NULL,
   class_num_12 varchar(6) NOT NULL,
   update_id varchar(20) NOT NULL,
   update_time timestamp(14),
   curr_class_num varchar(6),
   PRIMARY KEY (stud_id)
);


# --------------------------------------------------------

#
# �ƾڪ����c 'stud_behabior'
#

DROP TABLE IF EXISTS stud_behabior;
CREATE TABLE stud_behabior (
   be_id bigint(20) unsigned DEFAULT '0' NOT NULL,
   be_date date DEFAULT '0000-00-00' NOT NULL,
   stud_id varchar(20) NOT NULL,
   be_reason varchar(50) DEFAULT '0' NOT NULL,
   update_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   update_id varchar(20) NOT NULL,
   PRIMARY KEY (be_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'stud_brother_sister'
#

DROP TABLE IF EXISTS stud_brother_sister;
CREATE TABLE stud_brother_sister (
   bs_id bigint(20) DEFAULT '0' NOT NULL auto_increment,
   stud_id varchar(20) NOT NULL,
   bs_name varchar(20) DEFAULT '0' NOT NULL,
   bs_calling tinyint(3) unsigned DEFAULT '0' NOT NULL,
   bs_gradu varchar(20) NOT NULL,
   bs_birthyear tinyint(3) unsigned DEFAULT '0' NOT NULL,   
   PRIMARY KEY (bs_id)
);


#
# Table structure for table stud_domicile
#

DROP TABLE IF EXISTS stud_domicile;
CREATE TABLE stud_domicile (
   addr_id bigint(20) DEFAULT '0' NOT NULL,
   stud_id varchar(20) NOT NULL,
   fath_name varchar(20) NOT NULL,
   fath_birthyear varchar(4) NOT NULL,
   fath_alive tinyint(3) unsigned DEFAULT '1' NOT NULL,
   fath_relation varchar(6) NOT NULL,
   fath_country varchar(20) NOT NULL,
   fath_p_id varchar(20) NOT NULL,
   fath_abroad varchar(20),
   fath_education tinyint(3) unsigned DEFAULT '0' NOT NULL,
   fath_occupation varchar(20) NOT NULL,
   fath_unit varchar(20) NOT NULL,
   fath_work_name varchar(20) NOT NULL,
   fath_phone varchar(20) NOT NULL,
   fath_home_phone varchar(20),
   fath_hand_phone varchar(20),
   fath_email varchar(30),
   fath_note tinytext NOT NULL,
   moth_name varchar(20) NOT NULL,
   moth_birthyear varchar(4) NOT NULL,
   moth_alive tinyint(3) unsigned DEFAULT '1' NOT NULL,
   moth_relation varchar(6) NOT NULL,
   moth_country varchar(20) NOT NULL,
   moth_p_id varchar(20) NOT NULL,
   moth_abroad varchar(20),
   moth_education tinyint(3) unsigned DEFAULT '0' NOT NULL,
   moth_occupation varchar(20) NOT NULL,
   moth_unit varchar(20) NOT NULL,
   moth_work_name varchar(20) NOT NULL,
   moth_phone varchar(20) NOT NULL,
   moth_home_phone varchar(20),
   moth_hand_phone varchar(20),
   moth_email varchar(30),
   moth_note tinytext NOT NULL,
   is_same_gua char(1) DEFAULT '0' NOT NULL,
   guardian_name varchar(20) NOT NULL,
   guardian_phone varchar(20) NOT NULL,
   guardian_address varchar(60) NOT NULL,
   guardian_relation varchar(20) NOT NULL,
   guardian_p_id varchar(20),
   guardian_unit varchar(30),
   guardian_work_name varchar(20),
   guardian_hand_phone varchar(20),
   guardian_email varchar(30),
   grandfath_name varchar(20) NOT NULL,
   grandfath_birthyear date DEFAULT '0000-00-00' NOT NULL,
   grandfath_alive tinyint(3) unsigned DEFAULT '1' NOT NULL,
   grandmoth_name varchar(20) NOT NULL,
   grandmoth_birthyear date DEFAULT '0000-00-00' NOT NULL,
   grandmoth_alive tinyint(3) unsigned DEFAULT '1' NOT NULL,
   update_time timestamp(14),
   update_id varchar(20) NOT NULL,
   PRIMARY KEY (addr_id)
);

    



# --------------------------------------------------------

#
# �ƾڪ����c 'stud_guid_case'
#

DROP TABLE IF EXISTS stud_guid_case;
CREATE TABLE stud_guid_case (
   guid_c_id varchar(10) NOT NULL,
   guid_c_from varchar(10),
   guid_c_bdate date DEFAULT '0000-00-00' NOT NULL,
   guid_c_teacher varchar(20),
   guid_c_kind varchar(20),
   guid_c_behave varchar(20),
   guid_c_reason varchar(20),
   guid_c_isover char(2) DEFAULT '�_' NOT NULL,
   guid_c_over_reason varchar(20),
   guid_c_edate date,
   update_time datetime,
   update_id varchar(20) NOT NULL,
   PRIMARY KEY (guid_c_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'stud_guid_case_list'
#

DROP TABLE IF EXISTS stud_guid_case_list;
CREATE TABLE stud_guid_case_list (
   guid_l_id bigint(20) unsigned DEFAULT '0' NOT NULL auto_increment,
   guid_c_id varchar(10) NOT NULL,
   guid_l_date date DEFAULT '0000-00-00' NOT NULL,
   guid_l_con varchar(40) NOT NULL,
   update_id varchar(20) NOT NULL,
   PRIMARY KEY (guid_l_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'stud_guid_case_u'
#

DROP TABLE IF EXISTS stud_guid_case_u;
CREATE TABLE stud_guid_case_u (
   guid_u_id bigint(20) unsigned DEFAULT '0' NOT NULL auto_increment,
   guid_c_id varchar(10) NOT NULL,
   PRIMARY KEY (guid_u_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'stud_guidance'
#

DROP TABLE IF EXISTS stud_guidance;
CREATE TABLE stud_guidance (
   seme_year_seme varchar(6) NOT NULL,   
   stud_id varchar(20) NOT NULL,
   guid_p_relation varchar(8) NOT NULL,
   guid_air varchar(6) NOT NULL,
   guid_edu_fath varchar(6) NOT NULL,
   guid_edu_moth varchar(6) NOT NULL,
   guid_live varchar(12) NOT NULL,
   guid_camer varchar(10) NOT NULL,
   guid_sub_like varchar(20),
   guid_sub_diff varchar(20),
   guid_spec varchar(20),
   guid_hobby varchar(20),
   guid_habit varchar(20),
   guid_relation varchar(20),
   guid_behave_o varchar(20),
   guid_behave_i varchar(20),
   guid_behave_edu varchar(20),
   guid_habit_bad varchar(20),
   guid_behave_agi varchar(20),
   guid_temp1 varchar(20),
   guid_temp2 varchar(20),
   update_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   update_id varchar(20) NOT NULL,
   PRIMARY KEY (seme_year_seme, stud_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'stud_kinfolk'
#

DROP TABLE IF EXISTS stud_kinfolk;
CREATE TABLE stud_kinfolk (
   kin_id bigint(20) DEFAULT '0' NOT NULL auto_increment,
   stud_id varchar(20) NOT NULL,
   kin_name varchar(20),
   kin_calling varchar(6),
   kin_phone varchar(20),
   kin_hand_phone varchar(20),
   kin_email varchar(40),
   PRIMARY KEY (kin_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'stud_move'
#

DROP TABLE IF EXISTS stud_move;
CREATE TABLE stud_move (
   move_id bigint(20) DEFAULT '0' NOT NULL auto_increment,
   stud_id varchar(20) NOT NULL,
   move_kind varchar(10) NOT NULL,
   move_year_seme varchar(6)  NOT NULL,   
   move_date date DEFAULT '0000-00-00' NOT NULL,
   move_c_unit varchar(30),
   move_c_date date DEFAULT '0000-00-00',
   move_c_word varchar(20),
   move_c_num varchar(14),
   update_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   update_id varchar(20) NOT NULL,
   update_ip varchar(15) NOT NULL,
   PRIMARY KEY (move_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'stud_psy_tests'
#

DROP TABLE IF EXISTS stud_psy_tests;
CREATE TABLE stud_psy_tests (
   psy_id bigint(20) unsigned DEFAULT '0' NOT NULL,
   stud_id varchar(20) NOT NULL,
   psy_num_id varchar(4),
   psy_name_s varchar(20),
   psy_score_id varchar(4),
   psy_resource varchar(30) NOT NULL,
   psy_tran_id varchar(4) NOT NULL,
   psy_name varchar(40) NOT NULL,
   update_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   update_id varchar(20) NOT NULL,
   PRIMARY KEY (psy_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'stud_score'
#

DROP TABLE IF EXISTS stud_score;
CREATE TABLE stud_score (
   seme_year_seme varchar(6) NOT NULL,   
   sub_id int(11) DEFAULT '0' NOT NULL,
   sub_attr_id tinyint(4) DEFAULT '0' NOT NULL,
   stud_id varchar(20) NOT NULL,
   sub_num tinyint(3) unsigned DEFAULT '0' NOT NULL,
   sub_percent float(10,2) DEFAULT '0.00' NOT NULL,
   sub_set5 char(2) NOT NULL,
   update_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   update_id varchar(20) NOT NULL,
   PRIMARY KEY (seme_year_seme, sub_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'stud_seme'
#

DROP TABLE IF EXISTS stud_seme;
CREATE TABLE stud_seme (
   stud_id varchar(20) NOT NULL,
   seme_year_seme char(6) NOT NULL,   
   seme_class varchar(10) NOT NULL,
   seme_class_name varchar(10) NOT NULL,
   seme_num char(2) NOT NULL,
   seme_class_s varchar(10) NOT NULL,
   seme_num_s char(2) NOT NULL,
   score_total float(10,2) DEFAULT '0.00' NOT NULL,
   score_total_t float(10,2),
   comment varchar(24) NOT NULL,
   seme_cadre varchar(12),
   assist_total float(10,2) unsigned DEFAULT '0.00' NOT NULL,
   absen_thing float(10,2) unsigned,
   absen_sick float(10,2) unsigned,
   absen_none float(10,2) unsigned,
   PRIMARY KEY (stud_id, seme_year_seme)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'stud_tea_parent'
#

DROP TABLE IF EXISTS stud_tea_parent;
CREATE TABLE stud_tea_parent (
   par_id bigint(20) unsigned DEFAULT '0' NOT NULL auto_increment,
   stud_id varchar(20) NOT NULL,
   par_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   par_for varchar(20) NOT NULL,
   par_subject varchar(20) NOT NULL,
   par_content varchar(50) NOT NULL,
   update_id varchar(20) NOT NULL,
   PRIMARY KEY (par_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'teacher_base'
#

DROP TABLE IF EXISTS teacher_base;
CREATE TABLE teacher_base (
   teach_id varchar(20) NOT NULL,
   teach_person_id varchar(10) NOT NULL,
   name varchar(20) NOT NULL,
   sex tinyint(3) unsigned DEFAULT '0' NOT NULL,
   age tinyint(3) unsigned DEFAULT '0' NOT NULL,
   birthday date DEFAULT '0000-00-00' NOT NULL,
   birth_place tinyint(3) unsigned DEFAULT '0' NOT NULL,
   marriage tinyint(3) unsigned,
   address varchar(60),
   home_phone varchar(20),
   cell_phone varchar(20),
   office_home varchar(20),
   teach_condition tinyint(3) unsigned DEFAULT '0' NOT NULL,
   teach_memo varchar(30),
   login_pass varchar(12) NOT NULL,
   teach_edu_kind tinyint(3) unsigned DEFAULT '0' NOT NULL,
   teach_edu_abroad varchar(4) NOT NULL,
   teach_sub_kind varchar(10) NOT NULL,
   teach_check_kind tinyint(3) unsigned DEFAULT '0' NOT NULL,
   teach_check_word varchar(30) NOT NULL,
   teach_is_cripple char(2) NOT NULL,
   update_time timestamp(14),
   update_id varchar(20) NOT NULL,
   PRIMARY KEY (teach_id)
);

# --------------------------------------------------------

#
# �ƾڪ����c 'teacher_connect'
#

DROP TABLE IF EXISTS teacher_connect;
CREATE TABLE teacher_connect (
   teach_id varchar(20) NOT NULL,
   email varchar(50),
   email2 varchar(50),
   email3 varchar(50),
   selfweb varchar(50),
   selfweb2 varchar(50),
   classweb varchar(50),
   classweb2 varchar(50),
   ICQ varchar(20),
   PRIMARY KEY (teach_id)
);
# --------------------------------------------------------

#
# �ƾڪ����c 'teacher_post'
#

DROP TABLE IF EXISTS teacher_post;
CREATE TABLE teacher_post (
   teach_id varchar(20) NOT NULL,
   post_kind tinyint(3) unsigned DEFAULT '0' NOT NULL,
   post_office tinyint(3) unsigned DEFAULT '0' NOT NULL,
   post_level tinyint(3) unsigned DEFAULT '0' NOT NULL,
   official_level tinyint(3) unsigned,
   post_class tinyint(3) unsigned DEFAULT '0' NOT NULL,
   post_num varchar(20),
   bywork_num varchar(20),   
   salay mediumint(9) DEFAULT '0' NOT NULL,
   appoint_date date DEFAULT '0000-00-00',
   arrive_date date DEFAULT '0000-00-00',
   approve_date date DEFAULT '0000-00-00',
   approve_number varchar(60),
   teach_title_id tinyint(3) unsigned DEFAULT '0' NOT NULL,
   class_num varchar(6) DEFAULT '0' NOT NULL,
   update_time timestamp(14),
   update_id varchar(20) NOT NULL,
   PRIMARY KEY (teach_id)
);

# --------------------------------------------------------

#
# �ƾڪ����c 'teacher_subject'
#

DROP TABLE IF EXISTS teacher_subject;
CREATE TABLE teacher_subject (
   subject_id tinyint(3) unsigned DEFAULT '0' NOT NULL,
   subject_name varchar(20) NOT NULL,
   subject_year tinyint(4) unsigned,
   PRIMARY KEY (subject_id)
);
# --------------------------------------------------------


#
# �ƾڪ����c 'teacher_title'
#
DROP TABLE IF EXISTS teacher_title;
CREATE TABLE teacher_title (
   teach_title_id tinyint(4) DEFAULT '0' NOT NULL,
   title_name varchar(20) NOT NULL,
   title_kind tinyint(4) DEFAULT '0' NOT NULL,
   title_short_name varchar(12),
   room_id tinyint(4) DEFAULT '0' NOT NULL,
   title_memo text NOT NULL,
   PRIMARY KEY (teach_title_id)
);


#
# �ƾڪ����c 'stud_sick_f'
#

DROP TABLE IF EXISTS stud_sick_f;
CREATE TABLE stud_sick_f (
   sick_id bigint(20) unsigned DEFAULT '0' NOT NULL auto_increment,
   stud_id varchar(20) NOT NULL,
   s_calling varchar(6) NOT NULL,
   sick varchar(100) NOT NULL,
   PRIMARY KEY (sick_id)
);


#
# �ƾڪ����c 'stud_sick_p'
#

DROP TABLE IF EXISTS stud_sick_p;
CREATE TABLE stud_sick_p (
   stud_id varchar(20) NOT NULL,
   sick varchar(100) NOT NULL,
   PRIMARY KEY (stud_id)
);


#
# �ƾڪ����c 'school_subject'
#

DROP TABLE IF EXISTS school_subject;
CREATE TABLE school_subject (
   sub_id int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
   seme_year_seme varchar(6) NOT NULL,
   sub_name char(3) NOT NULL,
   sub_course char(1) NOT NULL,
   sub_year char(2) NOT NULL,
   is_exam char(1) NOT NULL,
   sub_num char(2) NOT NULL,
   sub_percent char(3) NOT NULL,
   update_id varchar(20) NOT NULL,
   update_time timestamp(14),
   PRIMARY KEY (sub_id)
);




# phpMyAdmin MySQL-Dump
# version 2.2.0
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# �D��: localhost
# �إߤ��: October 1, 2001, 9:41 am
# ��Ʈw����: 3.22.32
# PHP����: 4.0.4pl1
# ��Ʈw: sfs2test
# --------------------------------------------------------

#
# Table structure for table sfs_text
#

DROP TABLE IF EXISTS sfs_text;
CREATE TABLE sfs_text (
   t_id int(11) DEFAULT '0' NOT NULL auto_increment,
   t_kind varchar(20) NOT NULL,
   g_id tinyint(4) DEFAULT '0' NOT NULL,
   d_id int(11) DEFAULT '0' NOT NULL,
   t_name varchar(50) NOT NULL,
   t_parent varchar(60) NOT NULL,
   p_id int(11) DEFAULT '0' NOT NULL,
   p_dot varchar(20) NOT NULL,
   PRIMARY KEY (t_id)
);

#
# Dumping data for table sfs_text
#

INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '1', 'addr', '1', '0', '��}', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '23', 'addr', '1', '6', '�s����', '1,3,5,', '5', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '22', 'addr', '1', '5', '��Z��', '1,3,5,', '5', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '20', 'addr', '1', '4', '���n��', '1,3,5,', '5', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '17', 'addr', '1', '10', '���l��', '1,3,4,', '4', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '18', 'addr', '1', '9', '�g����', '1,3,4,', '4', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '24', 'addr', '1', '3', '���w��', '1,3,5,', '5', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '12', 'addr', '1', '6', '���ק�', '1,3,4,', '4', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '16', 'addr', '1', '8', '�K�s��', '1,3,4,', '4', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '13', 'addr', '1', '5', '�T�r��', '1,3,4,', '4', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '14', 'addr', '1', '7', '������', '1,3,4,', '4', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '15', 'addr', '1', '4', '�����', '1,3,4,', '4', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '21', 'addr', '1', '2', '�q�M��', '1,3,5,', '5', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '19', 'addr', '1', '1', '���s��', '1,3,5,', '5', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '10', 'addr', '1', '3', '������', '1,3,4,', '4', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '11', 'addr', '1', '2', '���s��', '1,3,4,', '4', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '6', 'addr', '1', '0', '�j�P��', '1,3,4,', '4', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '5', 'addr', '1', '1', '�j����', '1,3,', '3', '..');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '4', 'addr', '1', '0', '�~�H�m', '1,3,', '3', '..');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '3', 'addr', '1', '0', '�x����', '1,', '1', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '26', 'addr', '1', '2', '�Z���m', '1,3,', '3', '..');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '25', 'addr', '1', '0', '���s��', '1,3,5,', '5', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '9', 'addr', '1', '1', '�j�F��', '1,3,4,', '4', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '27', 'addr', '1', '0', '�ӥ���', '1,3,26,', '26', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '28', 'addr', '1', '1', '�ܤs��', '1,3,26,', '26', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '29', 'addr', '1', '2', '��ܧ�', '1,3,26,', '26', '...');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '30', 'stud_kind', '1', '0', '�ǥͨ����O', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '31', 'stud_spe_kind', '1', '0', '�S��Z���O', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '33', 'preschool_status', '1', '0', '�J�Ǹ��', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '32', 'spe_class_kind', '1', '0', '�S��Z�Z�O', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '34', 'post_kind', '2', '0', '¾�O', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '35', 'preschool_status', '1', '0', '���ǰ�', '33,', '33', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '36', 'preschool_status', '1', '1', '�j�ǰ�', '33,', '33', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '37', 'preschool_status', '1', '2', '�H���NŪ', '33,', '33', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '38', 'preschool_status', '1', '3', '�H���NŪ', '33,', '33', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '39', 'post_kind', '2', '1', '�ժ�', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '40', 'post_kind', '2', '2', '�Юv�ݥD��', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '41', 'post_kind', '2', '3', '�D��', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '42', 'post_kind', '2', '4', '�Юv�ݲժ�', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '43', 'post_kind', '2', '5', '�ժ�', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '44', 'post_kind', '2', '6', '�ɮv', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '45', 'post_kind', '2', '7', '�M���Юv', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '46', 'post_kind', '2', '8', '��߱Юv', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '47', 'post_kind', '2', '9', '�եαЮv', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '48', 'post_kind', '2', '10', '�N�z/�N�ұЮv', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '49', 'post_kind', '2', '11', '�ݥ��Юv', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '50', 'post_kind', '2', '12', '¾��', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '51', 'post_kind', '2', '13', '�@�h', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '52', 'post_kind', '2', '14', 'ĵ��', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '53', 'post_kind', '2', '15', '�u��', '34,', '34', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '54', 'stud_kind', '1', '0', '�@��ǥ�', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '55', 'stud_kind', '1', '1', '���H�ݻ�', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '56', 'stud_kind', '1', '2', '�a���ݻ�', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '57', 'stud_kind', '1', '3', '�C���J��', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '58', 'stud_kind', '1', '4', '�j���ӥx�̿˪�', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '59', 'stud_kind', '1', '5', '�\\���l�k', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '60', 'stud_kind', '1', '6', '���~����', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '61', 'stud_kind', '1', '7', '��D��', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '62', 'stud_kind', '1', '8', '��æ��', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '63', 'stud_kind', '1', '9', '����', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '64', 'stud_kind', '1', '10', '�~�y��', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '65', 'stud_kind', '1', '11', '���u��', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '66', 'stud_kind', '1', '12', '���~�H���l�k', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '67', 'stud_kind', '1', '13', '��|�Z�u', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '68', 'stud_kind', '1', '14', '�C���˴�', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '69', 'stud_kind', '1', '15', '��¾���l�k', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '70', 'stud_kind', '1', '16', '���п��(�]��)', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '71', 'stud_kind', '1', '17', '���п��(�]�f)', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '72', 'stud_kind', '1', '18', '���߻�ê(�˩w)', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '73', 'stud_kind', '1', '19', '��L', '30,', '30', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '74', 'stud_spe_kind', '1', '1', '��ê��', '31,', '31', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '75', 'stud_spe_kind', '1', '2', '���u��', '31,', '31', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '76', 'stud_spe_kind', '1', '3', '�귽�Z', '31,', '31', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '77', 'spe_class_kind', '1', '1', '�Ҵ�', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '78', 'spe_class_kind', '1', '2', '�ҩ�', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '79', 'spe_class_kind', '1', '3', '���o', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '80', 'spe_class_kind', '1', '4', '���j����', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '81', 'spe_class_kind', '1', '5', '�Ҿ�', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '82', 'spe_class_kind', '1', '6', '���n', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '83', 'spe_class_kind', '1', '7', '�Ұ�', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '84', 'spe_class_kind', '1', '8', '�ҭ}', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '85', 'spe_class_kind', '1', '9', '�Ҥ�(�ϻ�)', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '86', 'spe_class_kind', '1', '10', '�y��', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '87', 'spe_class_kind', '1', '11', '���߻�ê', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '88', 'spe_class_kind', '1', '12', '�ǲߧx��', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '89', 'spe_class_kind', '1', '13', '�b�a�Ш|', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '90', 'spe_class_kind', '1', '14', '�h����ê', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '91', 'spe_class_kind', '1', '15', '�@�봼���u��', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '92', 'spe_class_kind', '1', '16', '����', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '93', 'spe_class_kind', '1', '17', '���N', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '94', 'spe_class_kind', '1', '18', '�R��', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '95', 'spe_class_kind', '1', '19', '��|', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '96', 'spe_class_kind', '1', '20', '��L', '32,', '32', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '97', 'tea_edu_kind', '2', '0', '�Юv�Ǿ��O', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '98', 'tea_edu_kind', '2', '1', '��s�Ҳ��~(�դh)', '97,', '97', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '99', 'tea_edu_kind', '2', '2', '��s�Ҳ��~(�Ӥh)', '97,', '97', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '100', 'tea_edu_kind', '2', '3', '��s�ҥ|�Q�Ǥ��Z���~', '97,', '97', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '101', 'tea_edu_kind', '2', '4', '�v�j�αШ|�ǰ|���~', '97,', '97', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '102', 'tea_edu_kind', '2', '5', '�j�ǰ|�դ@���t���~(���ײ߱Ш|�Ǥ�)', '97,', '97', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '103', 'tea_edu_kind', '2', '6', '�j�ǰ|�դ@���t���~(�L�ײ߱Ш|�Ǥ�)', '97,', '97', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '104', 'tea_edu_kind', '2', '7', '�v�d�M�첦�~', '97,', '97', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '105', 'tea_edu_kind', '2', '8', '��L�M�첦�~', '97,', '97', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '106', 'tea_edu_kind', '2', '9', '�v�d�Ǯղ��~', '97,', '97', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '107', 'tea_edu_kind', '2', '10', '�x�ƾǮղ��~', '97,', '97', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '108', 'tea_edu_kind', '2', '11', '��L', '97,', '97', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '109', 'tea_check_kind', '2', '0', '�Юv�˩w���', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '110', 'tea_check_kind', '2', '1', '����ά������˩w�X��', '109,', '109', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '111', 'tea_check_kind', '2', '2', '��߱Юv', '109,', '109', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '112', 'tea_check_kind', '2', '3', '�եαЮv�n�O', '109,', '109', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '113', 'tea_check_kind', '2', '4', '�n�p��', '109,', '109', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '114', 'tea_check_kind', '2', '5', '��L', '109,', '109', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '115', 'edu_kind', '1', '0', '�a���Ǿ��O', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '116', 'edu_kind', '1', '1', '�դh', '115,', '115', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '117', 'edu_kind', '1', '2', '�Ӥh', '115,', '115', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '118', 'edu_kind', '1', '3', '�j��', '115,', '115', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '119', 'edu_kind', '1', '4', '�M��', '115,', '115', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '120', 'edu_kind', '1', '5', '����', '115,', '115', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '121', 'edu_kind', '1', '6', '�ꤤ', '115,', '115', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '122', 'edu_kind', '1', '7', '��p���~', '115,', '115', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '123', 'edu_kind', '1', '8', '��p�w�~', '115,', '115', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '124', 'edu_kind', '1', '9', '�Ѧr(���N��)', '115,', '115', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '125', 'edu_kind', '1', '10', '���Ѧr', '115,', '115', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '126', 'official_level', '2', '0', '�x��', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '127', 'official_level', '2', '1', '²��', '126,', '126', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '128', 'official_level', '2', '2', '�˥�', '126,', '126', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '129', 'official_level', '2', '3', '�e��', '126,', '126', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '130', 'remove', '2', '0', '��¾���b¾���p', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '131', 'remove', '2', '0', '�b¾', '130,', '130', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '132', 'remove', '2', '1', '�եX', '130,', '130', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '133', 'remove', '2', '2', '�h��', '130,', '130', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '134', 'remove', '2', '3', '�N�Ҵ���', '130,', '130', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '135', 'remove', '2', '4', '�껺', '130,', '130', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '136', 'per_sick_kind', '1', '0', '�ӤH�f�v', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '137', 'per_sick_kind', '1', '1', '��Ŧ�f', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '138', 'per_sick_kind', '1', '2', 'B���x���a��', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '139', 'per_sick_kind', '1', '3', '�|����', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '140', 'per_sick_kind', '1', '4', '���w', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '141', 'per_sick_kind', '1', '5', '�ͪ�', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '142', 'per_sick_kind', '1', '6', '���k', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '143', 'per_sick_kind', '1', '7', '���', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '144', 'per_sick_kind', '1', '8', '��Ŧ�f', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '145', 'per_sick_kind', '1', '9', '��ͯf', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '146', 'per_sick_kind', '1', '10', '�͵���', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '147', 'per_sick_kind', '1', '11', '����', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '148', 'per_sick_kind', '1', '12', '�S�����', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '149', 'per_sick_kind', '1', '13', '����', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '150', 'per_sick_kind', '1', '14', '����', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '151', 'per_sick_kind', '1', '15', '���~�Ī��L��', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '152', 'per_sick_kind', '1', '16', '�����', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '153', 'per_sick_kind', '1', '17', '�w��¯l', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '154', 'per_sick_kind', '1', '18', '�p��·�', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '155', 'per_sick_kind', '1', '19', '�˴H', '136,', '136', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '156', 'fam_sick_kind', '1', '0', '�a�گf�v', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '157', 'fam_sick_kind', '1', '1', '������', '156,', '156', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '158', 'fam_sick_kind', '1', '2', '�}���f', '156,', '156', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '159', 'fam_sick_kind', '1', '3', 'B���x���a��', '156,', '156', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '160', 'fam_sick_kind', '1', '4', '���w', '156,', '156', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '161', 'fam_sick_kind', '1', '5', '�믫�e�f', '156,', '156', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '162', 'fam_sick_kind', '1', '6', '�͵���', '156,', '156', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '163', 'fam_sick_kind', '1', '7', '�L�өʯe�f', '156,', '156', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '164', 'fam_sick_kind', '1', '8', '��Ŧ��ޯe�f', '156,', '156', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '165', 'fam_sick_kind', '1', '9', '�����c�e�f', '156,', '156', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '166', 'fam_sick_kind', '1', '10', '�~�F', '156,', '156', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '167', 'fam_sick_kind', '1', '11', '��L', '156,', '156', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '168', 'course9', '3', '0', '�ǲ߻��', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '169', 'course9', '3', '1', '�y��', '168,', '168', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '170', 'course9', '3', '2', '���d�P��|', '168,', '168', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '171', 'course9', '3', '3', '���|', '168,', '168', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '172', 'course9', '3', '4', '���N�P�H��', '168,', '168', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '173', 'course9', '3', '5', '�۵M�P���', '168,', '168', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '174', 'course9', '3', '6', '�ƾ�', '168,', '168', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '175', 'course9', '3', '7', '��X����', '168,', '168', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '176', 'subject_kind', '3', '0', '��ئW��', '', '0', '');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '177', 'subject_kind', '3', '1', '��y', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '178', 'subject_kind', '3', '2', '�ƾ�', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '179', 'subject_kind', '3', '3', '���|', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '180', 'subject_kind', '3', '4', '�۵M', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '181', 'subject_kind', '3', '5', '�D�w�P���d', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '182', 'subject_kind', '3', '6', '�ͬ��P�۲z', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '183', 'subject_kind', '3', '7', '��|', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '184', 'subject_kind', '3', '8', '�Ѫk', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '185', 'subject_kind', '3', '9', '����', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '186', 'subject_kind', '3', '10', '����', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '187', 'subject_kind', '3', '11', '���y', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '188', 'subject_kind', '3', '12', '�q��', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '189', 'subject_kind', '3', '13', '�m�g�о�', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '190', 'subject_kind', '3', '14', '�ͬ��Ш|', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '191', 'subject_kind', '3', '15', '�𶢱Ш|', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '192', 'subject_kind', '3', '16', '���|�A��', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '193', 'subject_kind', '3', '17', '��μƾ�', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '194', 'subject_kind', '3', '18', '��έ^��', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '195', 'subject_kind', '3', '19', '�u������', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '196', 'subject_kind', '3', '20', '���ɬ���', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '197', 'subject_kind', '3', '21', '���ά���', '176,', '176', '.');
INSERT INTO sfs_text (t_id, t_kind, g_id, d_id, t_name, t_parent, p_id, p_dot) VALUES ( '198', 'subject_kind', '3', '22', '¾�~�ͬ�', '176,', '176', '.');   
