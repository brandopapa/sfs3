<?php
// $Id: module-upgrade.php 5765 2009-11-25 06:00:23Z brucelyc $

if(!$CONN){
        echo "go away !!";
        exit;
}

// ��s�O���ɸ��|
$upgrade_path = "upgrade/".get_store_path($path);
$upgrade_str = set_upload_path("$upgrade_path");

$up_file_name =$upgrade_str."2009-11-04.txt";
if (!is_file($up_file_name)){
	$query = "ALTER TABLE `csrc_record` change `id` `id` int(10) unsigned NOT NULL auto_increment";
	if ($CONN->Execute($query)) {
		$temp_query = "�ק�id�ݩ� -- by brucelyc (2009-11-04)\n$query";
		$fd = fopen ($up_file_name, "w");
		fwrite($fd,$temp_query);
		fclose ($fd);
	}
}

$up_file_name =$upgrade_str."2009-11-25.txt";
if (!is_file($up_file_name)){
	$query_arr=array();
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,0,'�N�~�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,1,'�դ���q�N�~�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,2,'�ե~�оǥ�q�N�~�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,3,'�ե~��q�N�~�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,4,'�������r')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,5,'����Ǭr�ƪ����r')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,6,'��L�r�ƪ����r')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,7,'�Ĥ��ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,8,'�B�ʡB�C���ˮ`')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,9,'�Y�Өƥ�(�D�۱�)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,10,'��l�۱�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,11,'�ǥͦ۱��B�۶�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,12,'��¾���u�۱��B�۶�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,13,'�s���ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,14,'����B��߶ˮ`')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,15,'�u�a��ضˤH�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,16,'�ؿv���~��ˤH�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,17,'�uŪ���Ҷˮ`')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (1,18,'��L�N�~�ˮ`�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,0,'�w�����@�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,1,'�դ���ĵ')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,2,'�ե~��ĵ')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,3,'�դ��]�I(��)�D�}�a')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,4,'�z�����M�`')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,5,'���ݰ]���B�����D��')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,6,'��L�]���D��')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,7,'��~�ȯɨƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,8,'����ȯ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,9,'�����ȯ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,10,'�D�B�F�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,11,'�D���`')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,12,'�D�j�s�m��')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,13,'�D���~�ǯ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,14,'�D�ۤH��ū')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,15,'�D�ʫI�`�εT��(18���H�W)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,16,'�D�ʫI�`�Ӧ��h��(18���H�W)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,17,'�D�����Z(18���H�W)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,18,'��L�D�ɤO�ˮ`')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,19,'�~�H�I�J���Z�v�ͨƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,20,'�D�~�H�J�I�B�}�a�Ǯո�T�t��')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,21,'���ݤH���D�q�������B�F�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (2,22,'��L�ն�w�����@�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,0,'�ɤO�ƥ�P���t�欰')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,1,'�񰫥����ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,2,'�������ިƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,3,'�@�밫�ިƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,4,'�ïA���H�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,5,'�ïA�j�s�m��')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,6,'�ïA���~�ǯ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,7,'�ïA�ۤH�j�[')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,8,'�ïA���Ѯץ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,9,'�ïA��ըƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,10,'�ïA�ʫI�`�εT��')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,11,'�ïA�����Z�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,12,'�ïA�κj���u�ĤM��ި�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,13,'�ïA�ιH�Ϭr�~�M�`�������')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,14,'�ïA���`���ǡB����')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,15,'�ïA���`�a�x')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,16,'�ïA�a���B�}�a�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,17,'�t���ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,18,'��L�H�k�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,19,'���a�X�����N��(����¾(�t)�H�W)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,20,'�ǥ����Z�Ǯը�§�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,21,'�ǥ����Z�оǨƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,22,'�������J�ն�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,23,'�ǥͶ���@��')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,24,'�J�I�B�}�a�Ǯո�T�t��')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,25,'�q�������B�F�Ǹo�ץ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,26,'���q�Ʃʥ���αq�Ƥ�����')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (3,27,'��L�ն�ɤO�ΰ��t�欰')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (4,0,'�ޱнĬ�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (4,1,'�v���P�ǥͶ��Ĭ�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (4,2,'�v���P�a�����Ĭ�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (4,3,'��F�H���P�ǥͶ��Ĭ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (4,4,'��F�H���P�a�����Ĭ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (4,5,'��@�B��h�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (4,6,'�ǥͧܪ��ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (4,7,'��L�����ޱнĬ�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,0,'�ൣ�֦~�O�@�ƥ�(18���H�U)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,1,'�b�~�C��')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,2,'���a�X���T�餺')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,3,'�X�J���������')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,4,'�ൣ�Τ֦~�֧Q�k���O�@���ɭӮ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,5,'�D���')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,6,'�ൣ�Τ֦~�j���B��')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,7,'�ൣ�Τ֦~�D�D�k�Q��')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,8,'��B�j�B�R�B��ൣ�Τ֦~')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,9,'����B���Ѧ��`���ߤ��v�a�B�Ϯѵ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,10,'�I��(�r�~�B�ި��ī~)���`���߰��d����')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,11,'�D���߭h��')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,12,'�����ൣ�Τ֦~�T���Ωʥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,13,'�ൣ�Τ֦~���q�Ʃʥ���αq�Ƥ�����')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,14,'��L�H�Ϩൣ�Τ֦~�ʥ�����v����')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,15,'�D�ʫI�`�εT��(18���H�U)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,16,'�D�ʫI�`�Ӧ��h��(18���H�U)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,17,'�D�����Z(18���H�U)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,18,'��L�ൣ�֦~�O�@�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (5,19,'�����I�a�x')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (6,0,'�ѵM�a�`�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (6,1,'���a')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (6,2,'���a')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (6,3,'�_�a')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (6,4,'�s�Y�Τg�۬y')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (6,5,'�p��')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (6,6,'�J�I������')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (6,7,'��L���j�a�`')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (7,0,'�e�f�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (7,1,'�@��e�f')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (7,2,'�k�w�e�f(�z�f�r)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (7,3,'�k�w�e�f(���֯f)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (7,4,'�k�w�e�f(�V����)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (7,5,'�k�w�e�f(�ʤ�y)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (7,6,'�k�w�e�f(���k)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (7,7,'�k�w�e�f(�n����)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (7,8,'�k�w�e�f(SARS)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (7,9,'�k�w�e�f(��L)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (7,10,'�@��e�f(�����g)')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (8,0,'��L�ƥ�')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (8,1,'��¾�����������D')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (8,2,'�`�Ȫ����D')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (8,3,'�H�ƪ����D')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (8,4,'��F�����D')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (8,5,'�аȪ����D')";
	$query_arr[] = "insert into csrc_item (main_id,sub_id,memo) values (8,6,'��L�����D')";
	while(list($k,$v)=each($query_arr)) {
		echo $v."<br>";
		$CONN->Execute($v);
	}
	$temp_query = "�[�J�զw�ƶ� -- by brucelyc (2009-11-25)";
	$fd = fopen ($up_file_name, "w");
	fwrite($fd,$temp_query);
	fclose ($fd);
}
?>
