
# ��Ʈw�G `contest` ���c����
#

#�d��Ƥ����D�w
CREATE TABLE contest_itembank (
  id int(5) not null auto_increment,
  ibsn varchar(15) not null,
  question text not null,
  ans text not null,
  ans_url text null,
  primary key (id)
) ENGINE=MyISAM ;

#���D��, �C���v�ɱq�D�w���D��
#tsn �ߤ@�N�X, tsort�X�D����
create table contest_ibgroup (
id int(5) not null auto_increment,
tsn int(5) not null,
tsort int(3) not null,
ibsn varchar(15) not null,
question text not null,
ans text not null,
ans_url text null,
primary key (id)
) ENGINE=MyISAM;

#�d��Ƨ@���O��, 
create table contest_record1 (
id int(5) not null auto_increment,
tsn int(5) not null,
student_sn int(10) not null,
ibsn varchar(15) not null,
myans varchar(200) not null,
lurl varchar(200) not null,
anstime datetime not null,
chk tinyint(1) not null default '0',
primary key (id)
) ENGINE=MyISAM ;

#ø��, ²�����@���O�� (�ɮפW��)
create table contest_record2 (
id int(5) not null auto_increment,
tsn int(5) not null,
student_sn int(10) not null,
filename varchar(40) not null,
anstime datetime not null,
primary key (id)
) ENGINE=MyISAM;

#�v�ɬ����]�w
create table contest_setup (
tsn int(5) not null auto_increment,
year_seme varchar(4) not null,
title varchar(200) not null,
qtext varchar(200) not null,
sttime datetime not null,
endtime datetime not null,
memo blob not null,
active tinyint(1) not null,
open_judge tinyint(1) not null,
open_review tinyint(1) not null,
primary key (tsn)
) ENGINE=MyISAM;

#�C���v�ɪ������Ӷ�
create table contest_score_setup (
id int(5) not null auto_increment,
tsn int(5) not null,
sco_sn varchar(15) not null,
sco_text varchar(40) not null,
primary key (id)
) ENGINE=MyISAM;

#�C���v�ɪ��ǥͲӶ��������Z
create table contest_score_user (
id int(5) not null auto_increment,
student_sn int(10) not null,
teacher_sn int(10) not null,
sco_sn varchar(15) not null,
sco_num int(2) not null,
primary key (id)
) ENGINE=MyISAM;

#ø��, ²�����`���P���y
create table contest_score_record2 (
id int(5) not null auto_increment,
tsn int(5) not null,
student_sn int(10) not null,
teacher_sn int(10) not null,
score decimal(5,2) not null,
prize_memo text null,
primary key (id)
) ENGINE=MyISAM;

#�ҥͦW��b��
create table contest_user (
id int(5) not null auto_increment,
tsn int(5) not null,
student_sn int(10) not null,
lastlogin datetime not null,
logintimes int(3) not null,
prize_id int(2) null,
prize_text varchar(32) null,
ifgroup varchar(5) not null,
primary key (id)
) ENGINE=MyISAM;

#���f���b�� , �v�ɵ�����30�餺����
create table contest_judge_user (
id int(5) not null auto_increment,
teacher_sn int(10) not null,
tsn int(5) not null,
lastlogin datetime not null,
logintimes int(3) not null,
primary key (id)
) ENGINE=MyISAM;

#�̷s�����]�w
create table contest_news (
nsn int(5) not null auto_increment,
title varchar(200) not null,
sttime datetime not null,
endtime datetime not null,
memo blob not null,
updatetime datetime not null,
htmlcode tinyint(1) not null,
primary key (nsn)
) ENGINE=MyISAM;

#�ɮפU���]�w
create table contest_files (
fsn int(5) not null auto_increment,
nsn int(5) not null,
ftext varchar(200) not null,
filename varchar(36) not null,
primary key (fsn)
) ENGINE=MyISAM;

