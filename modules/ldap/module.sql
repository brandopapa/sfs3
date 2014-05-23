
# ��Ʈw�G �������ҲթҨϥΪ���ƪ���O, ��w�˦��Ҳծ�, SFS3 �t�η|�@�ְ���o�̪� MySQL ���O,�إ߸�ƪ�.
#					 �Y���Ҳդ��ݫإ߸�ƪ�, �h�d�ťէY�i.
#
#
#	server_ip		, LDAP server ���s�u ip �� dn
# ldap_port 	, LDAP �s�� port
# bind_dn			, �b�� bind �� @ �᭱�n�[�� DN  , �p  smallduh@fnjh.tc.edu.tw 
#	base_dn			, Ū���b����T�n�ϥΪ� DN , �p: OU=Users, DC=fnjh, DC=tcc, DC=edu, DC=tw 
# filter			, ldap_search �z��W�����
# attributes	, ldap_search �z����󤤪��C�ܶ���
# nologin			, �T��n�J�ǰȨt�Ϊ��b���C��
# chpass_url	, �e���ܧ�K�X���W�s��


CREATE TABLE IF NOT EXISTS `ldap` (
  `sn` int(4) NOT NULL auto_increment,
	`enable` tinyint(1) not null,
	`server_ip` varchar(64) not null,
	`server_port` int(5) not null,
  `bind_dn` text NOT NULL,
	`base_dn` text,
	`filter` text,
	`attributes` text,
  `nologin` text,
  `chpass_url` text,
  PRIMARY KEY  (`sn`)
) AUTO_INCREMENT=1 ;

insert into `ldap` (enable,server_ip,server_port,bind_dn,base_dn,filter,attributes,nologin,chpass_url) values ('0','','389','???.???.edu.tw','DC=???, DC=???, DC=edu, DC=tw','','','','http://');




