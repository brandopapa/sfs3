# ��Ʈw�G �������ҲթҨϥΪ���ƪ���O, ��w�˦��Ҳծ�, SFS3 �t�η|�@�ְ���o�̪� MySQL ���O,�إ߸�ƪ�.
#					 �Y���Ҳդ��ݫإ߸�ƪ�, �h�d�ťէY�i.
#

#�ɦҾǴ��O�]�w
#�Ω�]�w�ثe���b�i�檺�ɦҾǴ�
# resit_year_seme �ثe�Ǵ�
# start_time	�Ҹն}�l�ɶ� (�Ω�@��������Ҩ��Ҧ�)
# end_time		�Ҹյ����ɶ� (�Ω�@��������Ҩ��Ҧ�)
# paper_mode	����Ҧ� 
#							0 ��ܨ̦Ҩ������]�w, �@����@��
#							1 �Ҹն}�l�ɶ���N�}��Ҧ�����Ҩ��ѻ��
#												
CREATE TABLE IF NOT EXISTS `resit_seme_setup` (
  `sn` int(10) unsigned NOT NULL auto_increment,
  `now_year_seme` varchar(4) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `paper_mode` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`sn`)
) ENGINE=MyISAM;

#�ը��]�w
#�Ω�O���C�����ը����]�w
# sn �y����
# seme_year_seme �Ǵ�
# class_year �~�� (1~9)
# scope ���O
# start_time �}�l�ɶ� (�� paper_mode �]�� 0 ��, �����Ҩ�����}�l�ɶ��̦��]�w)
# end_time �����ɶ� (�� paper_mode �]�� 0 ��, �����Ҩ��Ҹջ�������ɶ��̦��]�w)
# timer_mode �p�ɼҦ�(0�ӧO, �C�ӤH���� timer �]�w����ƭ˼ƭp�ɡF1�P��,�C�ӤH�������ɶ����O end_time �]�w��)
# timer �Ҹծɶ��p�ɪ��� (��)
# items �Ҹծ��H���X�X�D
# relay_answer �����O�_�ߧY�^�X����?
# double_papers �O�_�i���л��, �ǥͥi��|�_�u�A�i�ӻ�, �ΦP�ɨ�ӤH�n�J�P�@�b�����
CREATE TABLE IF NOT EXISTS `resit_paper_setup` (
  `sn` int(10) unsigned NOT NULL auto_increment,
  `seme_year_seme` varchar(4) NOT NULL,
  `class_year` tinyint(1) not null,
	`scope` varchar(15) not null,
	`start_time` datetime not null,
	`end_time` datetime not null,
	`timer_mode` tinyint(1) not null,
	`timer` int(5) not null,
	`items` int(3) not null,
	`relay_answer` tinyint(1) not null,
	`double_papers` tinyint(1) not null,
  PRIMARY KEY  (`sn`)
) ENGINE=MyISAM;

#���D�w
# sn �y����
# paper_sn �����D������ resit_paper_setup.sn �� 
# sort ���D��
# question �D�F
# cha �ﶵa
# chb �ﶵb
# chc �ﶵc 
# chd �ﶵd
# cha �ﶵa
# fig_q �D�F������ sn (���� resit_images.sn �� , �O�d�ŭȤ�����)
# fig_a �ﶵa������ sn (���� resit_images.sn �� , �O�d�ŭȤ�����)
# fig_b �ﶵb������ sn (���� resit_images.sn �� , �O�d�ŭȤ�����)
# fig_c �ﶵc������ sn (���� resit_images.sn �� , �O�d�ŭȤ�����)
# fig_d �ﶵd������ sn (���� resit_images.sn �� , �O�d�ŭȤ�����)
# answer �ѵ�
#
CREATE TABLE IF NOT EXISTS `resit_exam_items` (
  `sn` int(10) unsigned NOT NULL auto_increment,
	`paper_sn` int(10) not null,
	`sort` int(3) not null,
	`question` text not null,
	`cha` text not null,
	`chb` text not null,
	`chc` text not null,
	`chd` text not null,
	`fig_q`	int(6) null,
	`fig_a` int(6) null,	
	`fig_b` int(6) null,	
	`fig_c` int(6) null,	
	`fig_d` int(6) null,
	`answer` text not null,
  PRIMARY KEY (`sn`)
) ENGINE=MyISAM;

#���Z�Χ@���O�� (�Q��serialize���O�O���@���}�C, �çQ��unserilize�Ѷ})
# sn �y����
# student_sn �ǥͪ��y����
# paper_sn �ը����y����
# score �o��
# items �ǥͦҪ��D�� (�Q��serialize���O�O���@���}�C�A�x�s, Ū����Q��unserilize�Ѷ})
# answer �ǥͪ��@������ (�Q��serialize���O�O���@���}�C�A�x�s, Ū����Q��unserilize�Ѷ})
# entrance �O�_�w���
# entrance_time ����ɶ�
# complete �O�_�����Ҹ�
# complete_time �����ɶ�
# update_time �O���ɶ�
#
CREATE TABLE IF NOT EXISTS `resit_exam_score` (
  `sn` int(10) unsigned NOT NULL auto_increment,
  `student_sn` int(10) NOT NULL,
	`paper_sn` int(10) not null,
	`org_score` float unsigned null,
	`score` float unsigned null,
	`items` text not null,
	`answers` text not null,
	`entrance` tinyint(1) not null,
	`entrance_time` datetime not null,
	`complete` tinyint(1) not null,
	`complete_time` datetime not null,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`sn`)
) ENGINE=MyISAM;

#�Ϯw
create table `resit_images` (
	sn int(6) not null auto_increment,
	filetype char(50) not null,
	xx int(4) not null,
	yy int(4) not null,
	content longblob null,
	primary key (sn)
) ENGINE=MyISAM;

	
