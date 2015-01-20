#$Id: module.sql 5311 2009-01-10 08:11:55Z hami $
#
# ��ƪ�榡�G `stud_clan`
#

CREATE TABLE IF NOT EXISTS `stud_subkind` (
  `student_sn` int(11) NOT NULL default '0',
  `clan` varchar(30) NOT NULL default '',
  `area` varchar(20) NOT NULL default '',
  `memo` varchar(20) NOT NULL default '',
  `note` varchar(20) NOT NULL default '',
  `type_id` varchar(5) NOT NULL default '',
  PRIMARY KEY  (`student_sn`,`type_id`)
);

#
# ��ƪ�榡�G `stud_subkind_ref`
#

CREATE TABLE IF NOT EXISTS `stud_subkind_ref` (
  `type_id` varchar(5) NOT NULL default '',
  `clan_title` varchar(20) NOT NULL default '',
  `area_title` varchar(20) NOT NULL default '',
  `memo_title` varchar(20) NOT NULL default '',
  `note_title` varchar(20) NOT NULL default '',
  `clan` text NOT NULL,
  `area` text NOT NULL,
  `memo` text NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY  (`type_id`)
) ;

INSERT INTO `stud_subkind_ref` VALUES ('1', '�n�O���O', '��ê�{��', '', '', '����\r\nť��\r\n�y��\r\n����\r\n�C���˴�\r\n�h����ê', '����\r\n����\r\n������\r\n����\r\n������', '', '');
INSERT INTO `stud_subkind_ref` VALUES ('2', '�n�O�˥N', '�n�O���O', '', '', '��\r\n��\r\n����', '����\r\nť��\r\n�y��\r\n����\r\n�C���˴�\r\n�h����ê', '', '');
INSERT INTO `stud_subkind_ref` VALUES ('3', '�ŦX���', '���Ĵ���', '', '', '�Ĥ@��\r\n�ĤG��\r\n�ĤT��', '�~��(12/31)\r\n�~��(06/30)', '', '');
INSERT INTO `stud_subkind_ref` VALUES ('9', '�ڧO', '�ϰ�', '', '', '���W��\r\n�|�ͱ�\r\n���n��\r\n������\r\n������\r\n�ɮL��\r\n���A��\r\n�F����\r\n�Q��\r\n�Ӿ|�ձ�\r\n���\r\n������\r\n������\r\n���_�ܶ���', '�s�a\r\n���a', '', '');
INSERT INTO `stud_subkind_ref` VALUES ('100', '�~�y�˥N', '���y', '�w�J�y', '�~�֮t�Z45�H�W', '��\r\n��', '���I��\r\n�����ڥ���\r\n�n���w\r\n�����ΧQ��\r\n�����ļ���\r\n�w�D���@�M��\r\n���ڧ�\r\n�D�j�Q��\r\n���a�Q\r\n�s�[��\r\n�Ȭ�����\r\n��Q��\r\n����\r\n���Q����\r\n�ڦ�\r\n�Z��\r\n�O�[�Q��\r\n�q�l\r\n�իXù��\r\n�Z�H��\r\n�[���j\r\n�������d\r\n���Q\r\n���ۤ��\r\n�����j���[\r\n�j��\r\n���J\r\n����\r\n�h�����[\r\n�ĺ��˦h\r\n�R�F����\r\n����\r\n����\r\n�k��\r\n��v��\r\n�w��\r\n��þ\r\n�ʦa����\r\n�����Դ�\r\n����\r\n�I���Q\r\n�B�q\r\n�L��\r\n���\r\n��ԧJ\r\n�R����\r\n�H��C\r\n�q�j�Q\r\n���R�[\r\n�饻\r\n���ħJ\r\n�_��\r\n�n��\r\n��¯S\r\n���ڹ�\r\n�Բ����\r\n�����\r\n�߳��{\r\n�c�˳�\r\n�D��\r\n���Ӧ��\r\n�����a��\r\n�����L\r\n�����\r\n���ǭ�\r\n�X�j\r\n������\r\n���T��J\r\n���y��\r\n��\r\n�æ���\r\n���[�ԥ�\r\n�`�ΧQ��\r\n����\r\n���[\r\n�ڰ򴵩Z\r\n�ڮ���\r\n�کԦc\r\n���|\r\n�i��\r\n�����\r\nù������\r\n�Xù��\r\n�뤺�[��\r\n�s�[�Y\r\n�n�D\r\n��Z��\r\n�v������\r\n���\r\n��h\r\n�F�[\r\n���ԧB�j����\r\n�𥧦��\r\n�g�ը�\r\n�Q�J��\r\n����y\r\n�^��\r\n�Z�|����\r\n����\r\n�e�����\r\n�|���\r\n����\r\n��߻�\r\n����\r\n�L�ץ����\r\n�V�n\r\n', '\r\n�O\r\n�_', '\r\n�O\r\n�_');

INSERT INTO `sfs_text` VALUES (0, 100, 'stud_kind', 1, '100', '�~�y�Τj���t���l�k', '30,', 30, '.');    