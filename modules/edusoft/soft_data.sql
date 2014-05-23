# $Id: soft_data.sql 5311 2009-01-10 08:11:55Z hami $
# Table structure for table 'softm'
#

CREATE TABLE softm (
   tapem_id char(2) NOT NULL,
   tapem_name char(30) NOT NULL,
   PRIMARY KEY (tapem_id)
);

#
# Dumping data for table 'softm'
#

INSERT INTO softm VALUES( 'A', '�۵M��');
INSERT INTO softm VALUES( 'B', '��T��');
INSERT INTO softm VALUES( 'C', '���|��');
INSERT INTO softm VALUES( 'D', '���N��');
INSERT INTO softm VALUES( 'E', '�D����');
INSERT INTO softm VALUES( 'F', '��|��');
INSERT INTO softm VALUES( 'G', '�S����');
INSERT INTO softm VALUES( 'I', '��L��');
INSERT INTO softm VALUES( 'H', '��X��');
INSERT INTO softm VALUES( 'J', '�Ϯw��');
INSERT INTO softm VALUES( 'k', '�y����');
INSERT INTO softm VALUES( 'L', '������');


#
# Table structure for table 'soft'
#

CREATE TABLE soft (
   tapem_id char(2) NOT NULL,
   tape_id smallint(4) NOT NULL,
   tape_name varchar(60) NOT NULL,
   tape_grade varchar(30) NOT NULL,
   tape_memo text NOT NULL,
   PRIMARY KEY (tapem_id, tape_id)
);

#
# Dumping data for table 'soft'
#

INSERT INTO soft VALUES( 'A', '1', '���֥@��', '', '�����e�{�覡(IE)');
INSERT INTO soft VALUES( 'A', '2', '�x�W���a�贺�[', '', '�����e�{�覡(IE)
');
INSERT INTO soft VALUES( 'A', '3', '�@�e�f���ͪ��@�ɤG���ڭ̬ݶ��h', '', '�����e�{�覡(IE)
');
INSERT INTO soft VALUES( 'A', '4', '���н��yv2', '', '����256��M���m��ؿ�ܡA�������P�q���W��A�@��CD��بɨ��A���T�M�ӤH�q�����i�ϥΡC');
INSERT INTO soft VALUES( 'A', '5', '�@�ˬy�ͺA����  �G�O�W���ˬy��', '', '�x�W�٬F���Ш|�U
��ť���л��U�Ч�
');
INSERT INTO soft VALUES( 'A', '6', '�ͩR�{�H', '', '�ʪ����A,����,�Ϯ�����.�ն�p�ʪ�
');
INSERT INTO soft VALUES( 'A', '7', '�H��j�ʬ�v2', '', '�бz�@���ӱ����h���h�����H��@�ɡI');
INSERT INTO soft VALUES( 'A', '8', '�t�z�j�ʬ�v2', '', '�@�����ƪ��h�C��ʬ���СA���z�m���t�z���Ѥ����A���篫���ӪŤ��ҡC');
INSERT INTO soft VALUES( 'A', '9', '�Ѥ�ǲߦʬ�v2', '', '�ꤺ�Ĥ@���q����Ѥ��Ǧ��N�X�o���Ѥ媾�����ʬ�q�l�ѡA���e�z�L��ӥD���H���A�@�O�ͩ�{�N���p�i�šA�H�Τ���j�N�Ѥ�j�v�i��
�A�ǵۨ�H���۹J�a�X�Ѥ媾�Ѫ����СA�O�������q�l�Ѫ��@�j�зs�C');
INSERT INTO soft VALUES( 'A', '10', '�ʪ��ǲߦʬ�v2', '', '�\\Ū�T�Q�Ӱʪ��`�ѡA�i�i�@�B�R��������ѡC');
INSERT INTO soft VALUES( 'A', '11', '����j�ʬ�v2', '', '�a�x���йϮ��]');
INSERT INTO soft VALUES( 'A', '12', '�@�`�����Ӫ� �G�x�W���θs��', '', '1.�x�W�٬F���Ш|�U��ť���л��U�о�
2.�x�W�٬F���Ш|�U��ť�C����л��U�о�
');
INSERT INTO soft VALUES( 'A', '13', '�۵M�j�ʬ�', '', '�@�����ƪ��h�C��ʬ���СA�޻�z�i�J�������۵M�@�ɡC');
INSERT INTO soft VALUES( 'A', '14', '�x�W�������G����v2', '', '���Ū��j�������@�y���K���A�L�ƪ���P�l�b���y�M�_�R�A�D���w�j�۵M�̩_�����ͺA�����C
�ӡA���H�ŧQ�աA�i�}�@�����ʻP�P�ʭݨ㪺�������K���ȡC');
INSERT INTO soft VALUES( 'A', '15', '�o�{�ĴƳ�', '', '�u�o�{�ĴƳ��v���Ф��]�t�F�u�縥�Ҧ��v�Ρu��U�Ҧ��v��ءA���O�[�\\�F�u�t�Ƥ����v�B�u�o�{���v�v�B�u�ͪ��S�x�v�B�u���ئM���v�B�u�ݵ��ʬ�v�H�Ρu���������v���״I���e�C�t�X�Ш|���u�ר��ǲߥ��Шt�C�v�H�κ��ں��������s�A�����öQ�����v�O�|���ѡA�ର���|�j���Ҧ@�ɨä������C');
INSERT INTO soft VALUES( 'A', '16', '�Ӫ��g ���O�����m�g�Ч���', '', '�Ӫ��g
');
INSERT INTO soft VALUES( 'A', '17', '�h�C��CAI', '', '�ͪ��g
');
INSERT INTO soft VALUES( 'A', '18', '�}���P�a', '', '\"�a�y���,���s\"
');
INSERT INTO soft VALUES( 'A', '19', '�ּ֪��p���Fv2', '', '����
');
INSERT INTO soft VALUES( 'A', '20', '�@�f�� �G�`������', '', '�x�W�٬F���Ш|�U
��ť���л��U�Ч�
�m�g�۵M�q�T�r');
INSERT INTO soft VALUES( 'A', '21', '�p���ത����v2', '', '����256��M���m��ؿ�ܡA�������P�q���W��C');
INSERT INTO soft VALUES( 'A', '22', '�x�W������v2', '', '�{�ѽ������骺����A���x�c�y�M�_���\\��A���������P�A�H�Υͬ��v�C�F�ѦU��S�x�B�ߩʡB�����F�H�Υx�W�S�������C');
INSERT INTO soft VALUES( 'A', '23', '���s�j�ʬ�v2', '', '�i�J���s������ҳժ��]�A�B�αz�����z�A�����s�A�״_���I');
INSERT INTO soft VALUES( 'A', '24', '����--�|�����ᦷv2', '', '�j�a�t�CVCD���@
���������T�Q������
�z���D�ܡH���������g���I�U�����L�{�A�~��q���ΦФƦ����C�z�L��v���޾ɡA���z���������ͩR�����I�I�w�w�A�q�D���B���Z�B�Ƹ��B�ФơB�Ļe��k�פѼ�...�C
�D�R�̰��ۡG�ݽ��������ΰҧ��D���R�A���ѱ���Ĺ�o�����������ڤߡC
�ͩR���_�l�G�ͩR�q�p�p���Z�}�l�C���������|���_�_��̵ܳξA����v�ɡC
�u�n�ڪ��j�G�}�ߦӥX���p���ΡA�Ĥ@�\\�O����H
�p�Υ���j�G���������ǰ��˳N�H�e�p���~�h�ѼġH
���_�]�N�v�G�x�I���i�]�N�c������ΡA������X�ӴN�����R���ͻH�H
��i���@��G�V�|�I�~���j���]���ܩR�K���}�������A�N�p��樭�O�H
�j�a�@�_�ӡG�͡I�����a�ڤj���X�A�����P�l�ֶ魥�C�C
�������V�V�G�q�q�ݡH��������������ܭ��̸��״H�N���V�ѡH
�٦���h�A��h....
');
INSERT INTO soft VALUES( 'A', '25', '����--�j�۵M��������v2', '', '�j�a�t�CVCD���G
���������T�Q������
�x�W�O�����������_�w�A�w�o�{�����δN���@�U�T�d�h�ءA�۫H�z�@�w�ݹL�Bť�L�W�}�P�B�ꫬ�ΡB���t�l�B�Ѥ��B�����B�����B�e��....�C���O�z�i�ण���D�A�x�W���ꫬ�Τw�o�{���N���T�Q�K�ءA�Ѥ����C�ʦh�ءA���t�l���G�ʦh�ءA�䤤�e�}�S�����x�W���u���t�A�٬O�@�ɨ�L�a��ݤ��쪺�S���ȺةO�C�ꫬ�ί����g�l�����A�Y�ϦA�m�ܦa�L�ɡA�]���|�P���󦺦a�C�������v�䤧���T���t�B�����t�A�̷R�u�T�y�C�͡B�����B�n�����O�@����H�A�ͥθ����U�誺�o�n���o���A�����B�n���h�O�����e�͵o�n�C�٦��\\�h�������ǡG����B���Q�ءB�f���A�t�l��....���A�z�O���O�w�����Ϋݪ��Q�i��@���L��p�t�z���j�_�I�C���I���ڭ̸�۩��Ϊ��}�B�A��ť�j�۵M�����n�C
');
INSERT INTO soft VALUES( 'A', '26', '����--�Ѧa���C�Lv2', '', '�j�a�t�CVCD���T
���������T�Q������
�x�W�״I�h�ܪ��۵M�ͺA�A�y�N�X�W�S�������ŧɡC���׬O�u�����v���d���άO�u�Ӱ��ȡv���Գ��A���̦ۤv���ߦn���ξA���Ϯ����ҡC���׬O�C���ޡB�����ޡB�����ޡB�ˬy�B�e�f�B�h�A...���i�H�o�{���ܡC�³��B���O��B�զյe�ܡB�A���B�p�P�ڡB�����[���B�Ÿ��q�B�����N�B�­��\\�O...�C
�b�ˬy���Ҥ��A�u�Ѥ~�p����v�A�������򯵱K�Z���A��b�����ɦʵo�ʤ��C
�x�W���N�p��Ĺ�o�u�����s�Q�v���١H
�֬O�����������L�����H�֦�����n����C
���������}�_�A�մ�a�~����A�֬O����������a����H
���Ӥj���y�A���n���V�쳽�A���⳾���︹�O�u�˪L�̪��j�M�|�v�C
�u�Ѧa�����C�L�v�O�z�M�ݹ�Ų�A���n���⪺�a�z��s�q���D�M�o�s�S�O���p���F���B�͡C

');
INSERT INTO soft VALUES( 'A', '27', '����--���H�������\\v2', '', '�j�a�t�CVCD���|
���������T�Q������
����O���ʮa���ʪ��A�q�����ܪ��e�A�o�|���}�ɦh�ܪ���m�ӶǹF�ߡB��B�s�B�֡C
���䪺�������@�d�h�إH�W�A�x�W���񪺮���ܤ֦��T�ʦh�ج���C�o���ܤƸU�d������E���A�ۤƥX���R�h�m���x�W�����@�ɡC
�K�ѬO����̴��ݪ��u�`�A�j�h�ƪ����䳣�b���ɥʹ޲��Z�C�@��������Z���N�q�����Τf���Ʃ�X�ӡA�ί����ξ���ΨťաA�p�ʪ��v�v�몧��A�p�Ϥ��묯����סA�b�R�Ī����������x�����C��l�B�Z�l���X�᪺����Z�b�G�Q�|�p�ɤ��o�|�����n���ΡA�򱵵۶i�J�ƯB���A�M��ʸU�����@���ͦs���|�C

');
INSERT INTO soft VALUES( 'A', '28', '�C��--���D�����lv2', '', '�j�a�t�CVCD����
���������T�Q������
���H���C��O�̯�N��x�W�S�⪺�ͪ��A�@�I��]�S���A�a�B�ȼ��a���x�W�A��Էŷx����A�y�N�X�W�S��������Ѱ�C�x�W�֦��T�Q�h�ت�������ͪ��A�䤤�A�T�����@�O�u���b�x�W�~�ݱo�쪺�S���ءC�z���L�X�ةO�H
�z���D�ܡH���દ��H�۵쪺�髬�񶯵�j�H���X���L���٪����ʨ쩳�O�C���٬O����H���B�p���ܫC��H�p�B�쬰������w�j��y�H�C��Y�F��ɬ�����n�Ⲵ�y�Y�i�h�H�s�Գ����]���D�_�ӹ��s�Ԧӱo�W���ܡH�٦��p�B��B����B����...�C
�N���ڭ̤@�_�M�_���X�x�W����ڡC');
INSERT INTO soft VALUES( 'A', '29', '�����@��--�s���������cv2', '', '�j�a�t�CVCD����
���������T�Q������
�|���������O�W�A�����a�Φh�ܡG�_�h�����B�e�f�y�a�����B�����G����...�A�]�ӳгy�X�״I�h�����������[�C����E�v���v�A�z�O�_���g�n�_�A���Ū������U�A���S�����H���H�����c�H
�u�n�T�Q�����A�a�z�C�M���h�B���B��q�B�����B���B...�������_�[�A�i�}�@���_�������ӪŤ��ȡC
�H�����Y�A�����B��l���B���γ��K�B���D�B���H�B���b...�U�خ��v�ͪ��@�@�{���C�󧮪��O�G�ܨk�ܤk��������G�����ش��A�۳��|�۰ʡu�ܩʡv�ᶯ���A��������رڨϩR�C�P�R���l�ޤO�G�p�����i�H�M�a���@�r�������A�M���@�͡C����H���D�I�G�c�@�@�����D�`�N���ڰv�J�F�a�A���ˮ���ŧ�ʤߪ�����C�@���x�����R�G�F�B���̷R���s���b�@����j��A�Φ����[���u�F�B���x���v�C�����M�a�G��س����F�u�[��ı��v�A�Ⱖ�������i�H���b�P�@��C 
');
INSERT INTO soft VALUES( 'A', '30', '�p�t�z������v2', '', '
');
INSERT INTO soft VALUES( 'A', '31', '���ҫO�|v2', '', '�ѪŪ��}�}���h�M��
�_�Ყ��-�õ}�Ӫ��O�|
�{�ѻīB
�Ů𦾬V������
�`���෽
���t����
�ūǮ���-���a�y�ūפɰ�
�귽�^��-�q�ۤv�}�l');
INSERT INTO soft VALUES( 'A', '32', '�H�P����', '', '��ߥx�W��ǱШ|�]
�ר��ǲߥ��Шt�C
');
INSERT INTO soft VALUES( 'A', '33', '�k�E�ɤ�', '', '��ߥx�W��ǱШ|�] 
�ר��ǲߥ��Шt�C 
');
INSERT INTO soft VALUES( 'A', '34', '�{�ѧڭ̷R�@�ڭ�', '', '���إ���Ш|��
�ר��ǲߥ��Шt�C 
�x�W���P�����������I��');
INSERT INTO soft VALUES( 'B', '1', '���֥b��qv2', '', '�ն�M�~�Ш|��');
INSERT INTO soft VALUES( 'B', '2', 'DIY�b��qv2', '', '�ն�M�~�Ш|��');
INSERT INTO soft VALUES( 'B', '3', 'WINDOWS�b��qv2', '', '�ն�M�~�Ш|��');
INSERT INTO soft VALUES( 'B', '4', 'WORD97��Ƿ���v2', '', '�ն�M�~�Ш|��
');
INSERT INTO soft VALUES( 'B', '5', 'INTERNET��Ƿ���v2', '', '�ն�M�~�Ш|��');
INSERT INTO soft VALUES( 'B', '6', '�`���ֺj��', '', '�H�q�ʪ���覡�B�_�٪����ġB�l�ޤH���G�Ʊ��`���z�m�ߦU�عq�����r���ޯ�C�ϥΥ��n��ਲ਼�t�Ƿ|�q�����r�A�í��U�ֽ�A�A�X���a�j�p�U�ئ~�֨ϥΪ̡C');
INSERT INTO soft VALUES( 'B', '7', '�W���I�@�Iv2', '', 'windows �Ϥ廲�U�[�j�u��
');
INSERT INTO soft VALUES( 'B', '8', '�ʵe���d������DIY', '', '1.���ѦU���d���B�����s�@���e�A���зN�R���o���C
2.�ާ@�\\��²�K�A���p�B�ͻ��P���C
3.�R����F���N�C�B�ɤH�����Y���̦n�u��C
4.�U�إ\\��ĪG���ơA���i�p�p���N�]�p�j�v�C
5.�V�m�p�B�ͪ��Q���O�B�гy�O�B���N�]�p�M���P���̨αоǳn��C');
INSERT INTO soft VALUES( 'B', '9', '�ʵe�b��qv2', '', '�ն�M�~�Ш|��');
INSERT INTO soft VALUES( 'B', '10', '�@�|���Wv2', '', '�ն�M�~�Ш|��
�W�� �P�d�s�@');
INSERT INTO soft VALUES( 'B', '11', '����q���J��v2', '', '�ն�M�~�Ш|��');
INSERT INTO soft VALUES( 'B', '12', 'BCC�b��qv2', '', '�ն�M�~�Ш|��');
INSERT INTO soft VALUES( 'C', '1', '�a�W�[�av2', '', '\"�x�W�q,�j����\"
');
INSERT INTO soft VALUES( 'C', '2', '�x�W�m�g��Ƹ�T�t��', '', '\"�m�g���,�����]�ϥκ����s����)\"
');
INSERT INTO soft VALUES( 'C', '3', '�{�ѥx�W', '', '�����ѾǥͻP���|�j�����ҥͩҪ����g�a���@�������A�N�H�a�ϡB��r�B�Ϲ��B�n���B�ʵe���覡�A�e�{�x�W�H��B���|�B�a�z�B���v�B�Ш|�����P���V�A�ñĥΡq���ʦ��r���Ҧ��A�ϥΪ̥i�H�ǵ۶W�s��(Hyperlink)��{���A�A�̦ۤv�߷R�ξǲߵ{�צۥѿ���һݸ�T�A���Ѥ@���Ϊ��۾Ǥu��I����ǲι���ǲ߭���A�X�j�ǲ߼h���A�H��t�X�Ш|���Ҵ��Ҫ��ר��ǲ߬F���C ');
INSERT INTO soft VALUES( 'C', '4', '��X�l�����', '', '�쳷�P�s�ŷu
');
INSERT INTO soft VALUES( 'C', '5', '�P���ѺV�V��', '', '�᳥�ں�y��
');
INSERT INTO soft VALUES( 'C', '6', '�]���s���ͬ����a��§', '', '���а��  �]���s���ͪ��X�ͦa�s�F�A����Ψ䥮�~�ܨD�ǹL�{������v�T�O���B�ͤΨƥ�C');
INSERT INTO soft VALUES( 'C', '7', '���R���d�~���@��', '', '�H�P�A��
');
INSERT INTO soft VALUES( 'C', '8', '���R���d�~���G��', '', '�H�P�t�z
');
INSERT INTO soft VALUES( 'C', '9', '�����԰E��', '', '1.���W�����ܩM���Ѭ�Ǧ��۱K���i�������p�ʡA�ڭ̹��եH�{�N�����רӪY��j�H�����z�����A���s�N���ܥH��ǥ[�H�����A���ǲΪ����ܬG�ơA�����s���ͩR�C
2.�y�����԰E�סz�����Τ@���إ��ڦU��l�����A���n���]���F�����Ĥ@���޵o���F�ڭ̥H�Թꪺ�Ϥ�B�M�~���y���ѻ��A���Ĥl�̤F�Ѧѯ��v��Ǻ믫�C');
INSERT INTO soft VALUES( 'C', '10', '�Ш|�귽�g', '', '���F��ר��ǲߤ��ؼСA�����ХH���ެ����ߴ��ѥ���쪺�Ш|�귽�P�A�ȡA�w��U�椸���Ѫ���ơA���@�Ժɪ������P���СA�[�W���Сi�j�M�����j���j�j�\\��H�D�F���K�B²��B�e���ǲߪ��ҬɡC
���W�[�ǲߪ�����ʻP�ѻP�סA�]���гy�X�����Ъ��F��H�����ר��ǲߤp�U�ݡ��@�P�[�J�ּ־ǲߡB���d��������C�A���A���q�ǲߪ���V�A�z�L�i�C���j�覡�����|�j���F�Ѳר��ǲߪ����T�[���A�üW�[�i�ר��ǲߤp�U�ݿù��O�@�{���j�L�|�H���H�a�X�{�z�����e�Ӵ��ѱz�ǲ߷s���P�ߧӤp�~���A�åB�b�i�ӤH���O�j�Ρi�n�ͱ��˰ϡj�ڭ̦b�����ѻP�A�ǲߤ��ʪ��a��C');
INSERT INTO soft VALUES( 'C', '11', '�x�W�����繢��Ƥ���', '', '���Хx�W�������繢�C');
INSERT INTO soft VALUES( 'C', '12', '����H����Ǵ��z', '', '���h�C��q���Ч��D�n�O�w��ߦ۵M��ǳժ��]�������U���y���ꪺ��ǻP�޳N�z�i�ܤ��e�������A�t�X���p�Ǧ۵M�B�a�y��ǱЧ��A���Ф���~���Ԫ��H�e�۵M��ǩM�Ͳ��޳N���o�i���p�C
�ѩ󤤰��ޤ��d�򦨴N�����s�x�A�p�Ѥ��H�ǡB�ƾǡB�a�ǡB���Q�ؿv�B���z�ǡB�M���ƾǡB�A�ǡB�ͪ��ǡB���ľǤΨ�L�޳N�o��...���A�i�ץ]ù�U�H�A���ӪT�|�C�]�����Ч����e�ȥ��H�u�Ѥ�a�ǡv�B�u�ƾǡv�B�u�ؿv�P���١v�T�j�椸�A��o����z�P�\\��A�H�@������H��ǻP���z���N��C');
INSERT INTO soft VALUES( 'C', '13', '���n��}�P���', '', '�ҥj�g');
INSERT INTO soft VALUES( 'C', '14', '�x���Ѧa�e', '', '���U��
');
INSERT INTO soft VALUES( 'C', '15', '�����m�g�оǸɧU�Ч����@��', '', '�q�t�g
');
INSERT INTO soft VALUES( 'C', '16', '�����m�g�оǸɧU�Ч����G��', '', '�j�ݽg
');
INSERT INTO soft VALUES( 'D', '1', '�{�ѥx�W�m�g���N', '', '�x�W�m�g���N��Ʒ����y�ǡA�����бN���Сu�����v�B�u�����v�B�u���J�v�B�u���J�v�|�����N���o�i�B�γ~�B�ުk�Χ@�~�Y��C 
');
INSERT INTO soft VALUES( 'D', '2', '�ʼ@�j�[��', '', '�ʼ@�i���Ш|����K�~�A����l�ͬ��J�h�m�S�����A�z�L�����t�C���A�q�򥻥\\��۰�@���A�A���y�СB�˧�A�޻�A�Ӥ@��A�����ʼ@�ǩ_���ȡC');
INSERT INTO soft VALUES( 'D', '3', '�j�a�Ӱۺq�J��', '', '�ǲ������O���إ��ڬöQ����Ƹ겣�A�Ӻq�J���O�x�W������ƪ��N��B�o�����ծ��հ�ť�A�s�������ҳ߷R�C���s�q�J���A�ô��Ѻq�J�ճ߷R�̦۾Ǧ۰۪��u��A�G�s�@�����СA�t�X�ר��ǲߤ��ؼСA�H���F����Ƹ귽�P�����@�ɪ��z�Q�C');
INSERT INTO soft VALUES( 'D', '4', '�Ѫk������', '', '�w��ϥΥ����СA�s�@���i���Ъ��ηN�A�O�b����s����Ѫk�ר��ǲߡA�ǥѾ��N�B��N�W�a�Ѫk�@�~�����СA�Ѫk�Ψ㪺�Y��P���ʪ`�N
�ƶ��B����ǲߡB�M�ΦW�������B�����������ѡB���쪺�Ѫk�p�G�ơA�H�ξǲߵ��q�C�����椸�A�H�����״I�����e�A�f�t�{�N�P���]�p����A�Ͼǲߪ̦b�ǲ߮Ѫk���L�{���A���A�P���}�`�����A�i�ӷP�쬡��ͰʡA�ͽ�s�M�A���@�Ѫk�ǲߪ��įq�C');
INSERT INTO soft VALUES( 'D', '5', '���֤J���g', '', '���ڭ̤@�_�ӻ{�Ѥ��u�СA�Ƿ|�C�ӭ��ť��T���W�M�ۦW�C');
INSERT INTO soft VALUES( 'D', '6', '���N�ǲߦʬ�v1', '', '�Ѥ�ǲߦʬ�t�ꤺ�Ĥ@���q����Ѥ��Ǧ��N�X�o���Ѥ媾�����ʬ���ѡA���e�z�L��ӥD���H���A�@�O�ͩ�{�N���p�i�šA�H�Τ���j�N�Ѥ�j�v�i�šA�ǵۨ�H�۹J�a�X�Ѥ媾�Ѫ����СA�O�������q�l�Ѫ��@�j�зs�C');
INSERT INTO soft VALUES( 'D', '7', '�ൣ�����e', '', '�����e�O�ڰ�S��������A�ǲΤ�ƪ�����C���F���H�q�p�N�����|��Ĳ�{�ѳo�����N���_�A�p�Ǭ��ҽҵ{�ۤG�~�Ű_�A�N�[�J�F���������e�оǪ����e�A�H�J�оǩ�C�����覡�A�޾ɤp�B�Ͷi�J�����������@�ɸ̡C');
INSERT INTO soft VALUES( 'D', '8', '�������u�@�T�g�~�����M��', '', '���������ͬO�@��K���ƫB���Ш|�a�A�@����ø�����֪����_�ŵe�a�A��O�@��P�O�O���Ʒ~���O���a�C');
INSERT INTO soft VALUES( 'D', '9', '�J�褧��v2�q�O�W�ǲΫؿv�˹����N�r', '', '\"���J,���J,�j�J\"
');
INSERT INTO soft VALUES( 'D', '10', '��y����v2�q�O�W�ǲΫؿv�˹����N�r', '', '\"��k�N,�d��,���N,�ɶ�\"
');
INSERT INTO soft VALUES( 'D', '11', '�^�O����v2�q�O�W�ǲΫؿv�˹����N�r', '', '\"����,�~��\"
');
INSERT INTO soft VALUES( 'D', '12', '�mø����v2�q�O�W�ǲΫؿv�˹����N�r', '', '\"���e,�mø\"
');
INSERT INTO soft VALUES( 'D', '13', '�լ䤧��v2�q�O�W�ǲΫؿv�˹����N�r', '', '\"�j,��,��,��\"
');
INSERT INTO soft VALUES( 'D', '14', '�m������v2�q�O�W�ǲΫؿv�˹����N�r', '', '�Ͽj
');
INSERT INTO soft VALUES( 'D', '15', '����Q�G�ͨv���Jv2', '', '������J');
INSERT INTO soft VALUES( 'D', '16', '���鮣�s������Jv2', '', '������J');
INSERT INTO soft VALUES( 'D', '17', '�@�ɰʪ������Jv2', '', '�@�ɰʪ����J�]�p');
INSERT INTO soft VALUES( 'D', '18', '������v�@�ɯ��Jv2', '', '������J');
INSERT INTO soft VALUES( 'D', '19', '���γժ��]���Jv2', '', '���ί��J�]�p');
INSERT INTO soft VALUES( 'D', '20', '�s´�u���ժ��]�S��', '', '���нs´�u���޸�T �Y��ʾl���]�ú�~ ������ҹC���s´�u���] �s´�ުk��@�d��
');
INSERT INTO soft VALUES( 'E', '1', '�i���Ŀ�', '', '�s�@��CD�����ت��A�A�z�L���ں����A���ѥ������d��T�ξǲ߳q�D�C�b�z�פ譱�A���F���Ѥ@�������¦��i���ѥ~�A�P�ɥ[�J�F�{�N��i�Ǥ��p�⭹�����q���覡�A�H��U�ϥΪ̧P�_��`�����ߺD�O�_���šC');
INSERT INTO soft VALUES( 'E', '2', '�����i��', '', '�ר��ǲߥ��Шt�C');
INSERT INTO soft VALUES( 'E', '3', '�{�Ѥ�ݶq', '', '�u�Y�o���n�v�B�u���Y�~�n�v��j�椸�C');
INSERT INTO soft VALUES( 'E', '4', '�a�p�ަ^�a', '', '�ۨ��w��
');
INSERT INTO soft VALUES( 'F', '1', '�ǲε����AŢ�y', '', '�u�n�ǱM��q�Q���r�v�@�]�t�G�M�оǳn��A�����bWindows95���ҤU����A�u�����Ѧa�v�D�n�H����G�����p�����ξާ@���M�q�����������D�C�t�~�٦��ƭ��ൣ�q���аۡC�ӡuŢ�y�v���ثe�оǹL�{���ݭn�v�B�ܽd���Ч������䤤�@���C��ê��h�ئ]���A�u�O��i��ӧO�Ǳ©Τp�նǱ¡C�z�LCAI������Ъ����Ʈi�ܱЧ����S�ʡA�i�̤��P�������վ�ǲߪ��ɶ��F�P�ɤ]���״I��������r�Bgif�Ϥ��Bavi�v���ﴡ�䤤�C�K��ϥΪ̦ۧھǲߡC');
INSERT INTO soft VALUES( 'F', '2', '��N�B�� �@', '', '�ǥͽm�߰�N��వ�n�u�ε��v�������B�ʡA�w�W�[���ת��u�ʡB���Y�ʡA�קK�y���B�ʶˮ`�C���ɶ԰��u���Ρv�ڥ��\\�ҡA�����L�j���F��
�B����U�L�Bí�w��Ŧ���b�B�ղz�𮧡B�׾i�ߧӡC�u�����v�M�u�X�x�v���H���G�����B�X��۵M�Ͳz���c�B�F���B�Q���ܤƹB�ά��n�C');
INSERT INTO soft VALUES( 'F', '3', '��N�B�� �G', '', '�z�L�u�Ф~�ܽd�����v�B�u���Ѱʧ@�ܽd�����v�A�оɾǥͤF�ѮM�����A�ʧ@���s��B�զX�B�ܤƤΨ�`���A�çQ�Ρu�s��ʧ@�m�ߡv�A���ǥͼ��m�U�M���ʧ@���s��B�s�t�B�`�������ߡA�̫�H�u�����|�ҡv���u�걡�Ҥ������A���ǥͦb���F�򥻰ʧ@���F�ѫ�A�˲��ظ@��ڹB�Τ����ҡA�L�H���󬰲`��A��ണ�@�ǲߤ�����B�W�j�ǲߤ��ʾ��C');
INSERT INTO soft VALUES( 'F', '4', '��N�B�ʤT', '', '�P��N�B�ʤ@�B�G�C');
INSERT INTO soft VALUES( 'G', '1', '�S�бШ|��', '', '�����e�{
');
INSERT INTO soft VALUES( 'G', '2', '�S�дC��Ч���', '', '�����e�{
');
INSERT INTO soft VALUES( 'G', '3', '���_���Ѫ�', '', '�����e�{
');
INSERT INTO soft VALUES( 'I', '1', '�s���`�ئ��_�c', '', '�u�s���`�ئ��_�c�v�Ш|���ЬO�ѱШ|�s���q�x�����s�@�A��v���b��z�L���Ш|���Ъ�����ʤΤ��ʩʪ��\\��A���Ѥ��p�Ǯէ@���{�ѱШ|�s���q�x���\\��P�F�Ѽs���`�ػs�@�y�{�����U�оǤu��C�����Ъ��S��O�z�L�q���޳N�����γгy�u���������ǡv���ϥΪ̱o�H�Ϧp���{�����ǲ{���A�ï�ާ@��߸`�ػs�@�]�ƶi�Ӥް_�ǲ߿���A�������O�}�n�����U�Ч��ΫŶǴC��C');
INSERT INTO soft VALUES( 'I', '2', '�����ժ��]�@v2', '', '���إ���Ш|��
�ר��ǲߥ��Шt�C');
INSERT INTO soft VALUES( 'I', '3', '�����ժ��]�G', '', '���إ���Ш|��
�ר��ǲߥ��Шt�C');
INSERT INTO soft VALUES( 'H', '1', '�h�C�黲�U�оǤ@v2', '', '��.��.�w�զ���.��.�Ӫ�
');
INSERT INTO soft VALUES( 'H', '2', '�h�C�黲�U�оǤGv2', '', '��L��.�P�J.�U�j�w�a�ή��.
');
INSERT INTO soft VALUES( 'H', '3', '�h�C�黲�U�оǤTv2', '', '���J.����.�D���O.��y.
');
INSERT INTO soft VALUES( 'H', '4', '�h�C�黲�U�оǥ|v1', '', '���J�q.����.�x���Ѧa�e
');
INSERT INTO soft VALUES( 'H', '5', '�n�ǱM��@', '', '�q�����U�оǳn��----�n�ǱM��A�O�H�ثe���i����ޡA�N�Ш|���αШ|�U�B���Ҷ}�o���q�����U�оǳn��A�`�s�@�����Ф��qCD-ROM�r�A�ڭ̧Ʊ�o�M�M�誺�}�o�s�@�ണ�Ѯv�ͤ@���״I���оǸ귽�A�èϸ�T�Ш|�V�U�Ϯڤu�@�A��V�e��e�@�j�B�C');
INSERT INTO soft VALUES( 'H', '6', '�n�ǱM��Tv2', '', '��~�ӹq����ޤ�s��q�ACAI�n�骺�}�o�޳N�礣�_���A�зs�P��}�A�����M��~����W�@���[��i�A�j�������n�鳣�b�m��ù��W�ϥΡA�e������[�F���@�ǳn��h�O�Ρu�����t�v���覡�Ӷi��A�i���Ѿǲߪ�����A�u���F��J�Щ�֪��ĪG�C');
INSERT INTO soft VALUES( 'H', '7', '�n�ǱM��K�q���C��v2', '', '�Ш|����W�i�P�Ǩϥιq������A�N�������~�o�i�U�دq���C�����n��㦨�n�ǱM�衣�K�����Ф��A���e�]ù�U�H�A�|�Z���O�y�L�B�귽�O�|�B���d�@�ɡB�ƾǤѦa�B�q���J�����A���i�z�L���M��i��h���ƾǲߡA���P�Ǧh���h�����q���@�ɡA���o�@���s���C');
INSERT INTO soft VALUES( 'J', '1', '�Ÿ�.pop.����.�ȧ��Ϯwv2', '', '�\\�h�\\��');
INSERT INTO soft VALUES( 'J', '2', '���~�Ϯwv2', '', '�s�B��B��B�H�B��B�Q��B���ڡB���100');
INSERT INTO soft VALUES( 'J', '3', '�ᶡ���Ϯwv2', '', '�j��B���ߡB�mø�B�d��B�᳾���100');
INSERT INTO soft VALUES( 'J', '4', '��.�x�W�L�Hv2', '', 'YMCK��}��������');
INSERT INTO soft VALUES( 'J', '5', '�öǭ�d�g��v2', '', '��d�㦳�@���\\��A�g�`�[�Y�i����u��k�L��v���맮�C');
INSERT INTO soft VALUES( 'J', '6', '���� �Ϯwv2', '', '�ǲΫؿv�u�C��v�B�u����v���100');
INSERT INTO soft VALUES( 'A', '35', '�ڷR���s v2', '', '1.���оǡB�C���B�T�֩�@����������Ʈ��s�ʬ���гn��C
2.�ѻP�ʫܰ��A���ȥi�H�o���Q���O�^��v�e�ɥN�h�j�M���s���ܸ�A�٥i�H�ηӬ۾������s��ӡB��V8�h��v�A���W�N�ন���@�쮣�s�M�a�C
3.���e�O�ھڬ�����ǩ���Ǥu�~�ժ��]���]�p�v�ά�Ǯa�ҵo�i�����s�ʬ���Ѭ��ť��s�@�A�`�J�L�X���Ю��s�a�ڡC
4.�@���a�y�W���P�ɥN�������B�Ӫ��P60�X����߳]�p��3D���s�A�˲��ظ@�v�e�ɥN���ͪ��P���[�C
5.�Ϥ�íZ�������P�S�����ġA�b�n���ĪG���W�K�C��������ʡA�O�ˤl���ʤ��̥Ͱʪ��ǲ߰ʱЧ��C');
INSERT INTO soft VALUES( 'B', '13', '���a�j�Ϭr-�f�r�ʬ���� v2', '', '');
INSERT INTO soft VALUES( 'I', '4', '�����ժ��]�T', '', '');
INSERT INTO soft VALUES( 'I', '5', '�����ժ��]�|', '', '');
INSERT INTO soft VALUES( 'I', '6', '�q�l�Ƴժ��]', '', '');
INSERT INTO soft VALUES( 'k', '1', '���򪺰�y���_���@  v2', '�C�~��', '���ʹC�����]�p�j�ƫĤl��ť�O�z�Ѥλ��ܯ�O�A�ǥѿ����\\��λ��G�C�������ѫĤlť�B���BŪ�B�g����쪺��y��ǲ��_��C');
INSERT INTO soft VALUES( 'k', '2', '����ABC�s�ֶ顣�@�� v2', '�C�~��', '1.���i�s�ֶ�qA��Z�@�����Ӱ��C
2.���оǡB�C���B�T�֩�@�����^��r���ǲߥ��гn��C
3.�i��ܤ���B�^��G�ػy���o���C
4.�C�Ӧr���ҥH�ϧ��ܤƥX�j�g�P�p�g�A�[�`�L�H�A�åi�ǲߤ@�ӥH�Ӧr���_������r�C�åi�b�g�r�����m�ߤj�B�p�r�����g�k�C
5.��߳]�p�������B�C���A�b�n���ĪG���W�K����ʻP�ǲ߮ĪG�C
6.�����аۥi��ܳ�y�Υ����аۡA���ǩ����C
7.�b��~�Ϥ��A�p�B�ͥi�ɱ����x�зN�C');
INSERT INTO soft VALUES( 'k', '3', '����ABC�s�ֶ顣�G�� v2', '���B�C�~��', '1.ť�^��B���^��B�q�ۤ��ǭ^��A�ֽ�L�a����ı���оǡC
2.�S�u����@���a���s�^���q�A�u���۫ߤ��۵M�O�в`��C
3.�̲M�������y�o���A�nť�n�ǡA�Ԥ���N�|��ۻ��C
4.�q26�Ӧr���A�A��100�h�Ӥ�`��r�A�A�ǥͬ��y���A�`�Ǻ��i�C
5.�b��߳]�p���U���C�����A���աB�D�ԡA�ּּ֧֩M�^�媱�A�C
6.�mø�Ѧa�A���ϻP�ƹ��m�ߡA���Ť⸣�A�P�ɰ��i�Ч@�O�P�޿�C

');
INSERT INTO soft VALUES( 'k', '4', '����ABC�s�ֶ顣�T�� v2', '���B�C�~��', '1.�q���B�ʵe�M�C���A���Ĥl�۵M�Q���Q�ǡC
2.�z�L�p�U�l���޾ɻP���y�A�b�ĤG���q�����ʹC�����A���Ĥl���_�����ջP�m�ߡC
3.�D�ԯ������C���]�p�A���Ĥl�ɮi�ҾǡA���i�^��ť�O�A���ѯ����C');
INSERT INTO soft VALUES( 'L', '1', '����Do Re Mi �ֶ�(�@) v.2', '�C�~��', '1.�R�u�@�~�@�ץN��@�A�P���|���֭��ֱШ|���б¸s�X�@�A���ɤQ�K
  �Ӥ��߻s�@�C
2.�G�Q�K�ӳ̬���B�ˤ����C���A���ൣ�b�۵M���ǲߡB�ּ֤������C
3.�Ĩ��ʺA�оǪ������A�E�o�ൣ���Q���O�B�гy�O�C
4.�T�Q�h���w�ﭵ�P�V�m�ҳЧ@�����l�A���U�ൣ��ǽT���x���y���P
  �`���C
5.�ĺ��i���оǡA�ൣ�b�{�Ѹ`��B�۫ߡB�X������A�i�ۦ�զX�B��
  �@�C
6.�w�葉�� �ൣ�A�]�p�ƹ��m�߱оǡC
7.�������ۦ�e�m�ߡA�i�H���ൣ�ɨ���~���ֽ�C
8.�ൣ�i�H���Ъ����A���藍�|�P�칽�СC');
INSERT INTO soft VALUES( 'L', '2', '����Do Re Mi �ֶ�(�G) v.2', '�C�B���B���~��', '1.�H���״I���i���ǲߦw�ơA�ĥΪ��W�����ֱоǪk�A���Ĥl�g�Ѹg
  ��-����-�гy-�{�����۵M�ǲߡC
2.��20�Ӭ��⪺���ʳ]�p�A���p�B�ͤ@�Ӧ۵M�B�ּ֪��ǲ����ҡC
3.�h�F2�ӳЧ@�ϡA���p�B�ͦb�{�`��B�۫ߡB�X������A�i�ۥѵo��
  �Q���O�A���s�զX�Ч@�C
4.�䤤25���w�ﭵ�P�V�m�ӳ]�p�ҳЧ@�����l�A���U�p�B�ͺ�Ǵx����
  �߸`���C
5.�w�葉�֤p�B�ͦӳ]�p���ƹ��оǰϡA���p�B�ͻ��P���⸣�åΡC
6.�ۦ�m�ߥ��h�����p�B�ͺɱ��ɨ���~���ֽ�C
7.���z���p�B�ͪ��q���B�����֡B���`���B�L���O�B�u���w�֡C
 ');
INSERT INTO soft VALUES( 'k', '5', '����ABC�s�ֶ顣�|�� v2', '���B�C�~��', '1.���Ĥl�b�_�I�C�����A�i�����e�J�A�����A�إ߾ǲߪ����N�P�P�۫H�ߡC
2.�w��^��J�����Ĥl�A�D��L�̼��x�B�̥ͬ��ƪ���r�P�y���m�ߡC
3.�ĥ�TPR(Total Physical Resconse)�P�Ϲ����۵M�y���ǲߪk�A�q����ť�^��P���ʽm�ߨ����U�Ĥl�z�ѻy��A�E�o�ǲ߿���A���Ĳv���ǲ߭^��C
4.�n���B���쪺�q���C���A���Ĥl�q�{�������ա��D�Ԫ��ǲߤT�������A�J�A�ǭ^�媺���ߡA�ּ־Ƿ|�^��C
5.�S�u����@���a�w��ҵ{����r�P�y���A�Ч@�^���q�A�޵o�Ĥl�Τ�ť�B�}�f�ۡA�q�C���B�q�ۤ��۵M�ǲߡC
6.�Q�ιq���h�C�骺�S���A��{�����оǤ������z�Ѫ����Y���B�ʵ����y�P�ήe�B����Ū��B�ΡC');
INSERT INTO soft VALUES( 'L', '3', '����Do Re Mi �ֶ�(�T) v.2', '', '1.�b�_�۪�3D�������A18�Ӭ���B�ˤ����C���A���Ĥl�ּ֡B�L���O��
  �۵M�ӵM�Ƿ|���֡C
2.�ͬ��ƪ����֭��ְʺA�оǪk�A���p�B�͸g�Ѹg��-����-�гy-�{��
  ���L�{�A�E�o�Ĥl��b���Q���O�B�гy�O�C
3.�ĺ��i���оǡA���p�B�ͦb�{�Ѹ`��B�۫ߡB�ֲz����A�i�H�o���Q
  ���O�ɱ��a���Ч@�C
4.30���w�ﭵ�P�V�m�ҳЧ@�����l�A�Ѷ��֭��֮a�̺�߳Ч@�����֡A
  �����U�p�B�ͥ��״I�����֤��P���`���B�߰ʡC
5.�ۦ�B��~�ϯ����p�B�ͤ@�iø�e�B�Ч@������F���аϥi�H��ť�u
  �����q���A�i�Ӹ�ۮԮԤW�f�F���ϡB�ƹ��C���A���p�B�ͻ��P�a��
  ���åΡC
6.���e�Ժɪ��u�ˤl��U�v�A�޾ɿˤl�@�ɡA�u�ιq�������֡v����
  ��C');
INSERT INTO soft VALUES( 'D', '21', '123', '�C�~��&nbsp���~��&nbsp', '');
INSERT INTO soft VALUES( 'k', '6', '�����޿�j�_�Iv.2', '�C�~��&nbsp���~��&nbsp', '1.���ХH����ҵo�Q���ߴ��Ϫk���D�b�A�i��y�޿��ұоǡz�����гn��C
2.���P�����סB�i�����ǲ߳]�p�C');
INSERT INTO soft VALUES( 'k', '7', '�����޿�j�_�Iv.2', '�C�~��&nbsp���~��&nbsp', '1.���ХH����ҵo�Q���ߴ��Ϫk���D�b�A�i��u�޿��ұоǡv�����гn��C
2.���P�����סB�i�����ǲ߳]�p�A���t�Φ��B�J�a�V�m�Ĥl���޿��O�C
3.�s�o������C�����k�A�Ͱʬ��⪺�ʵe�t�X�A�ǥѦ����_�����L���D�ԡA�W�i�Ĥl�ǲߪ��ʤO�M���N�P�C
4.�_�I�����A�N�{�o�u�_�I�Үѡv�A�ݬݳo�����_�I���F�X���P�H�i�H�C�L�X�ӡA���Ĥl���ǲߪ�{�d�U�����C
5.�_�۵��ܭ��檺�_�I�G��+���R���v��y�C�����ҡA�����~�d�U���R�O�СC
6.�Ժɪ��ˤl��U�A���ѿˤl�̲M�����ǲ߾ɤޡF�зN�Q�����ߴ��Ϫk�m�ߥ��αm���զX�A���Ĥl���P�ǥH�P�ΡC');
INSERT INTO soft VALUES( 'D', '22', '���򪺶�~��v.2', '�C�~��&nbsp���~��&nbsp', '1.�K�B�K�B�K�I300�i����K�����K�ȡA�H�Ĥl�W�K�U�K�B���K�k�K�A�W�U�ۤϡB���k�A�˶K......�ɱ��K�ӵh�֡I
2.���d���I8�شڦ��d���I�v�A�A�[�W30�غٿסB���P��A���Ĥl�ۤv���d���A�C�L�X�Ӱe�����w���H�d���I
3.�e�B�e�B�e�I36��m��e���A�٦�4�ؤ��P�ʲӡA�b8�i�m��ϵe�ȸ̡A���N���x�зN�I
4.15�i�U������ϧΡA���Ĥl�̨ӧ��I��m�C
5.90�ثN�֭��ġA�@�e�N����ߡA���R�_�Ĥl���Ч@�O�C
6.�Ĥl���o�N�j�@�A�H�ɥi�H�Y��A�x�s�B�C�L�A�@�I�]���·СC');
INSERT INTO soft VALUES( 'D', '23', '���򪺫��ϼֶ�', '�C�~��&nbsp', '1.�U���U�ˡB���P�զX�����ϡA�a���Ĥl���P����߻P�D�ԡC
2.�S�u���ֱM�a�Ч@�Ͱʪ��۫ߡA���Ĥl�b�зN���֦����A�o�����O�����C
3.DIY�����ϲզX�A�ˤl�@�_�ʤ�B�ֽ�L�a�C');
