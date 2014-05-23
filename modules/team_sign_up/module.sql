# //$Id: module.sql 5311 2009-01-10 08:11:55Z hami $

# ��ƪ�榡�G `stud_team_kind`
#

CREATE TABLE stud_team_kind (
  id bigint(20) unsigned NOT NULL auto_increment,
  mid int(10) unsigned NOT NULL default '0',
  class_kind varchar(20) NOT NULL default '',
  stud_max int(10) unsigned default NULL,
  stud_back tinyint(3) unsigned default '0',
  class_max tinyint(3) unsigned default '0',
  week_set varchar(10) default NULL,
  year_set varchar(10) default NULL,
  doc varchar(50) default NULL,
  cost int(10) unsigned default NULL,
  teach varchar(20) default NULL,
  beg_date datetime default '0000-00-00 00:00:00',
  end_date datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='���γ��W���O';


# ��ƪ�榡�G `stud_team_sign`
#

CREATE TABLE stud_team_sign (
  sid bigint(20) unsigned NOT NULL auto_increment,
  kid int(10) unsigned NOT NULL default '0',
  class_id varchar(4) NOT NULL default '',
  stud_name varchar(20) NOT NULL default '',
  stud_id varchar(8) NOT NULL default '',
  bk_fg tinyint(4) NOT NULL default '0',
  sign_time timestamp(14) NOT NULL,
  PRIMARY KEY  (sid)
) TYPE=MyISAM COMMENT='���γ��W��';