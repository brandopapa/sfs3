<?php

include "config.php";

sfs_check();

//�q�X����
head("�ǥͳq�T��Ʀ^��");
print_menu($menu_p);

//�Ǧ~�O
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());
//�ҰϥN�X	�������N�X	�Ǹ�	�Ǹ�	�Z��	�y��	�ǥͩm�W	�����Ҹ�	�ʧO	�X�ͦ~	�X�ͤ�	�X�ͤ�	���~�ǮեN�X	���~�~	���w�~	�ǥͨ���	���߻�ê	�N�ǰ�	�C���J��	���C���J��	���~�Ҥu�l�k	��Ʊ��v	�a���m�W	�����q��	��ʹq��	�l���ϸ�	�q�T�a�}	�g�@��Ʊ��v
//134517	103	1	0	1	12	0	0	0	0	��00	7891234	0912345678	920	�̪F����{���s�����s��1��	0

if($_POST['act']=='�T�w�^��' && $_POST['data']){
	$data=explode("\r\n",$_POST['data']);
	foreach($data as $key=>$value){
		$single=explode("\t",$value);
		/*
		Array
		(
			[0] => �ҰϥN�X
			[1] => �������N�X
			[2] => �Ǹ�
			[3] => �Ǹ�
			[4] => �Z��
			[5] => �y��
			[6] => �ǥͩm�W
			[7] => �����Ҹ�
			[8] => �ʧO
			[9] => �X�ͦ~
			[10] => �X�ͤ�
			[11] => �X�ͤ�
			[12] => ���~�ǮեN�X
			[13] => ���~�~
			[14] => ���w�~
			[15] => �ǥͨ���
			[16] => ���߻�ê
			[17] => �N�ǰ�
			[18] => �C���J��
			[19] => ���C���J��
			[20] => ���~�Ҥu�l�k
			[21] => ��Ʊ��v
			[22] => �a���m�W
			[23] => �����q��
			[24] => ��ʹq��
			[25] => �l���ϸ�
			[26] => �q�T�a�}
			[27] => �g�@��Ʊ��v
		)
		*/
		//���student_sn
		$stud_id=$single[3];
		if($single[2] && $stud_id) {
			$seme_class=sprintf("%d%02d",9,$single[4]);
			$res=$CONN->Execute("SELECT student_sn FROM stud_seme WHERE seme_year_seme='$curr_year_seme' AND stud_id='$stud_id' AND seme_class='$seme_class' AND seme_num='$seme_num'") or user_error("Ū�����ѡI<br>$sql",256);
			$student_sn=$res->fields['student_sn'];
			if($student_sn){
				//��s�򥻸��
				$birth_year=$single[9]+1911;
				$birthday=sprintf("%d-%02d-%02d",$birth_year,$single[10],$single[11]);
				$CONN->Execute("UPDATE stud_base SET stud_person_id='{$single[7]}',stud_birthday='$birthday',stud_tel_2='{$single[23]}',stud_tel_3='{$single[24]}',addr_zip='{$single[25]}',stud_addr_2='{$single[26]}' WHERE student_sn={$student_sn}") or user_error("Ū�����ѡI<br>$sql",256);
				//��s���@�H�m�W
				$CONN->Execute("UPDATE stud_domicile SET guardian_name='{$single[22]}' WHERE student_sn={$student_sn}") or user_error("Ū�����ѡI<br>$sql",256);
			} echo "<br>�Z�šG{$seme_class} �Ǹ��G{$stud_id} �m�W�G{$single[6]} �]���䤣�쥻�Ǵ��N�Ǭ����A��ƵL�k��s�I";
			/*
			echo "<pre>";
			print_r($single);
			echo "</pre>";
			*/
		}
	}
};

//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);
echo "<form name='myform' method='post' action='$_SERVER[PHP_SELF]'>";
echo "<br>����s���Ǧ~�סG".curr_year();
echo "<br>���K�W����ơG�Ш|�|����X�ɩҦ�����ơA�L���]�t�Ĥ@�C(���D�C)�C";
echo "<br>����s�^�g�P�_�̾ڡG�Ǹ��B�Z�šB�y���T�̶��۲�";
echo "<br>���|��s�^�g�����G�����Ҹ��B�X�ͦ~�B�X�ͤ�B�X�ͤ�B�a���m�W�B�����q�ܡB��ʹq�ܡB�l���ϸ��B�q�T�a�}";
echo "<br>���ֶK��ơG<br><textarea rows=33 name='data' cols=200></textarea>";
echo "<br><input type='submit' name='act' value='�T�w�^��' onclick='return confirm(\"�T�w�n�^�g�ǥͰ򥻸�ơH\")'>";
echo "</form>";
foot();
?>