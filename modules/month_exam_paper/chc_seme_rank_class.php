<?php
// $Id: chc_seme_rank_class.php 5310 2009-01-10 07:57:56Z hami $
// �ޤJ SFS3 ���禡�w
//include "../../include/config.php";

// �ޤJ�z�ۤv�� config.php ��
@ini_set('error_reporting','E_ALL & ~E_NOTICE');
require "config.php";
include "chc_seme_advance_class.php";

// �{��
sfs_check();

	//�ഫ�������ܼ�
$act=($_POST['act'])?"{$_POST['act']}":"{$_GET['act']}";
$test_sort=($_POST['test_sort'])?"{$_POST['test_sort']}":"{$_GET['test_sort']}";
$class_num=($_POST['class_num'])?"{$_POST['class_num']}":"{$_GET['class_num']}";

//�{���ϥΪ�Smarty�˥���
$template_file = dirname (__file__)."/templates/chc_seme_rank_class.htm";


// �s�� SFS3 �����Y
head("��Ҧ��Z�i�h�B�d��");

// �z���{���X�Ѧ��}�l
print_menu($menu_p);
$curr_year = curr_year();
$curr_seme = curr_seme();

//��teacher_sn��X�L�O���@�Z���ɮv
$class_num=get_teach_class();
if($class_num){
   $class_id=sprintf("%03d",$curr_year)."_".$curr_seme."_".sprintf("%02d_%02d",substr($class_num,0,-2),substr($class_num,-2,2));
   //debug_msg("��".__LINE__."�� class_id ", $class_id);
   //�إߪ���
   $obj= new chc_seme_advance_class($CONN,$smarty);
   //��l��
   $obj->init();

   
   $obj->process($class_id);
   //��ܤ��e
   $obj->display($template_file);

   // SFS3 ������
   foot();

}else{
   $main="<table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'>".$_SESSION['session_tea_name']."�z����ɮv�����I �L�k�i��ާ@�I<br>�Y���ðݽ��ˬd�y�Юv�޲z�z����¾��ơC</td></tr></table>";

	//�]�w�D������ܰϪ��I���C��
	$back_ground="
		<table cellspacing=1 cellpadding=6 border=0 bgcolor='#B0C0F8' width='100%'>
			<tr bgcolor='#FFFFFF'>
				<td>
					$main
				</td>
			</tr>
		</table>";
	echo $back_ground;
}

function debug_msg($title, $showarry){
	echo "<pre>";
	echo "<br>$title<br>";
	print_r($showarry);
}

?>
