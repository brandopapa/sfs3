#
# �C�X�H�U��Ʈw���ƾڡG 
#
# jshow_set  �Y���O���]�w
# 
# ��컡���G
#						id �s��(�۰�)  
#						idtext ���廡��
#						memo ��ܵ��ϥΪ̪�����
#						max_width �W�ǹϤ���,���\���̤jwidth (�۰��Y��)
#						max_height �W�ǹϤ���,���\���̤j height (�۰��Y��)
#						init_pic_set �����w�ϮɡA�w�]�n��ܨ��i��
#						day_pic_set	 ���Ǥ��(�u�Ѥ�-��),���O�q���ǹ�(�G���}�C,�H serialize �s�X)
#						display_mode �i�ϼҦ� (0 ��Ʈw���Ҧ��Ϥ��̧ǦC�X,1 ��Ʈw���Ҧ��Ϥ��üƦC�X, 2 �̤�� )
#						update_time	��s���(�۰�)
#
CREATE TABLE jshow_setup (
  `kind_id` int(5) NOT NULL auto_increment,
	`id_name` varchar(30) not null,
	`memo` text,
	`max_width` int(5) not null,
	`max_height` int(5) not null,
	`init_pic_set` int(5) not null,
	`display_mode` tinyint(1) not null,
  `day_pic_set` text,
  `update_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (kind_id)
) Engine=MyISAM;

# jshow_check  �Y���O�����v�]�w
# 
# ��컡���G
#
CREATE TABLE jshow_check (
  `id` int(5) NOT NULL auto_increment,
  `kind_id` int(5) NOT NULL default '0',
  `post_office` tinyint(4) NOT NULL default '-1',
  `teach_id` varchar(20) NOT NULL default 'none',
  `teach_title_id` tinyint(4) NOT NULL default '-1',
  `is_admin` char(1) NOT NULL default '',
  `teacher_sn` int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) Engine=MyISAM;


#
# jshow_data �Ϥ����
# 
# ��컡���Gid �s��(�۰�)
#						kind_id �������O (jshow_set��kind_id) 
#						sub �Ϥ��D�D
#						memo ���廡��
#						filename �ɦW
#						display �O�_�i�� 0���� 1���}
#						upload_day  �W�Ǯɶ�
#						teacher_sn	�W�Ǫ�
#
CREATE TABLE jshow_pic(
 `id` int( 5 ) NOT NULL AUTO_INCREMENT ,
 `kind_id` int(5) NOT NULL default '0', 
 `sub` varchar( 128 ) NOT NULL default '',
 `memo` text NOT NULL ,
 `filename` text NOT NULL ,
 `display` tinyint(1) NOT NULL default '0', 
 `display_sub` tinyint(1) NOT NULL default '0',
 `display_memo` tinyint(1) NOT NULL default '0',
 `upload_day` datetime NOT NULL ,
 `teacher_sn` int( 6 ) NOT NULL ,
 `sort` int(3) not null default '100',
 PRIMARY KEY ( id ) 
) Engine=MyISAM;

