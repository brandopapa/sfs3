#
# ��ƪ�榡�G `soft`
#
# �бN�z����ƪ� CREATE TABLE �y�k�m��U�C
# �Y�L�A�h�бN���� module.sql �R���C

CREATE TABLE soft (
  tapem_id char(2) NOT NULL default '',
  tape_id smallint(4) NOT NULL default '0',
  tape_name varchar(60) NOT NULL default '',
  tape_grade varchar(30) NOT NULL default '',
  tape_memo text NOT NULL,
  PRIMARY KEY  (tapem_id,tape_id)
) TYPE=ISAM PACK_KEYS=1;

CREATE TABLE softm (
  tapem_id char(2) NOT NULL default '',
  tapem_name char(30) NOT NULL default '',
  PRIMARY KEY  (tapem_id)
) TYPE=ISAM PACK_KEYS=1;


