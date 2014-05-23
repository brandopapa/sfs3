# $Id: module.sql 5741 2009-11-04 15:51:25Z brucelyc $

#
# ��ƪ�榡�G `csrc_record`
#

CREATE TABLE csrc_record (
  `id` int(10) unsigned NOT NULL auto_increment,
  `year` smallint(5) unsigned NOT NULL default '0',
  `semester` enum('1','2') NOT NULL default '1',
  `main_inc` int(5) unsigned NOT NULL default '0',
  `sub_inc` int(5) unsigned NOT NULL default '0',
  `level` int(5) unsigned NOT NULL default '0',
  `inc_date` timestamp,
  `inc_place` int(5) unsigned NOT NULL default '0',
  `dper` int(5) unsigned NOT NULL default '0',
  `aper` int(5) unsigned NOT NULL default '0',
  `oper` int(5) unsigned NOT NULL default '0',
  `update_date` timestamp,
  PRIMARY KEY (id)
) TYPE=MyISAM;

#
# ��ƪ�榡�G `csrc_item`
#

CREATE TABLE csrc_item (
  `main_id` int(5) unsigned NOT NULL default '0',
  `sub_id` int(5) unsigned NOT NULL default '0',
  `memo` text NOT NULL default '',
  PRIMARY KEY (main_id,sub_id)
) TYPE=MyISAM;
