
# ��Ʈw�G `netstate` ���c����
#

#�]�ưO��
CREATE TABLE net_base (
  id int(5) not null auto_increment,
  net_name varchar(30) not null,
  net_kind tinyint(1) not null,
  net_ip varchar(200) not null,
  net_ip_show tinyint(1) not null,
  net_url text null,
  net_url_show tinyint(1) not null,
  net_location varchar(30) null,
  net_memo text null,
  net_check tinyint(1) not null,
  primary key (id)
) ENGINE=MyISAM ;

#�q���Ыǹq��IP�O��
CREATE TABLE net_roomsite (
  net_edit int(3) not null,
  net_ip varchar(18) not null,
  site_num int(2) not null,
  ipmac tinyint(1) not null,
  primary key (net_edit)
) ENGINE=MyISAM ;

#������b�K
CREATE TABLE net_firewall (
  id int(1) not null auto_increment,
  firewall_ip varchar(64) not null,
  firewall_user varchar(30) not null,
  firewall_pwd varchar(64) not null,
  primary key (id)
) ENGINE=MyISAM ;

