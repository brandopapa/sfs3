<?php

// $Id: chart_j.php 6265 2010-12-10 02:47:48Z brucelyc $

/* ���o�]�w�� */
include "config.php";

sfs_check();

if (($IS_JHORES=='0')&&($use_both=='0')) header("location: chart_e.php");

$year_seme=($_POST[year_seme])?$_POST[year_seme]:$_GET[year_seme];
$class_id=($_POST[class_id])?$_POST[class_id]: $_GET[class_id];
$stud_id=($_POST[stud_id])?$_POST[stud_id]:$_GET[stud_id];
$student_sn=($_POST[student_sn])?$_POST[student_sn]:$_GET[student_sn];
$act=($_POST[act])?$_POST[act]:$_GET[act];
$stu_num=($_POST[stu_num])?$_POST[stu_num]:$_GET[stu_num];

//���o���ЯZ�ťN��
$class_num=get_teach_class();
$class_all=class_num_2_all($class_num);
//�V�O�{��
$oth_arr_score = array("��{�u��"=>5,"��{�}�n"=>4,"��{�|�i"=>3,"�ݦA�[�o"=>2,"���ݧ�i"=>1);
$oth_arr_score_2 = array(5=>"��{�u��",4=>"��{�}�n",3=>"��{�|�i",2=>"�ݦA�[�o",1=>"���ݧ�i");


if(empty($class_num)){
	$act="error";
	$error_title="�L�Z�Žs��";
	$error_main="�䤣��z���Z�Žs���A�G�z�L�k�ϥΦ��\��C<ol>
	<li>�нT�{�z�ݥ��ɮv�C
	<li>�нT�{�аȳB�w�g�N�z�����и�ƿ�J�t�Τ��C
	</ol>";
}elseif($error==1){
	$act="error";
	$error_title="�ӯZ�ŵL�ǥ͸��";
	$error_main="�䤣��z���Z�žǥ͡A�G�z�L�k�ϥΦ��\��C<ol>
	<li>�нT�{�z�ݥ��ɮv�C
	<li>�нT�{�аȳB�w�g�N�z���ǥ͸�ƿ�J�t�Τ��C
	<li>�פJ�ǥ͸�ơG�y�ǰȨt�έ���>�а�>���U��>�פJ��ơz(<a href='".$SFS_PATH_HTML."modules/create_data/mstudent2.php'>".$SFS_PATH_HTML."modules/create_data/mstudent2.php</a>)</ol>";
}

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

//���o�Z�ťN��
$class_id=old_class_2_new_id($class_num,$sel_year,$sel_seme);
$seme_year_seme = sprintf("%03d%d",$sel_year,$sel_seme);

if ($class_num<>''){
	//���o���Ǵ��W���`���
	$query = "select days from seme_course_date where seme_year_seme='$seme_year_seme' and class_year='".substr($class_num,0,1)."'";
	$res= $CONN->Execute($query) or die($query);
	$TOTAL_DAYS = $res->fields[0];
}

//���o�Ҹռ˪O�s��
$exam_setup=&get_all_setup("",$sel_year,$sel_seme,$class_all[year]);
$interface_sn=$exam_setup[interface_sn];
if ($chknext)	$ss_temp = "&chknext=$chknext&nav_next=$nav_next";

//����ʧ@�P�_
if($act=="error"){
	$main=&error_tbl($error_title,$error_main);
}else{
	$main=&main_form($interface_sn,$sel_year,$sel_seme,$class_id,$student_sn);
}


//�q�X����
head("�s�@���Z��");

?>

<script language="JavaScript">
<!-- Begin
function jumpMenu(){
	location="<?php echo $_SERVER['SCRIPT_NAME']?>?act=<?php echo $act;?>&student_sn=" + document.col1.student_sn.options[document.col1.student_sn.selectedIndex].value;
}
//  End -->
</script>

<?php


echo $main;
foot();


//�[�ݼҪO
function &main_form($interface_sn="",$sel_year="",$sel_seme="",$class_id="",$student_sn=""){
	global $CONN,$input_kind,$school_menu_p,$cq,$comm,$chknext,$nav_next,$edit_mode,$submit,$chk_menu_arr;

	$year_seme=sprintf("%03s%1s",$sel_year,$sel_seme);
	$c=explode("_",$class_id);
	$seme_class=$c[2].$c[3];
	if (substr($seme_class,0,1)=="0") $seme_class=substr($seme_class,1,strlen($seme_class)-1);

	//�ഫ�Z�ťN�X
	$class=class_id_2_old($class_id);
	
	//���p�S�����w�ǥ͡A���o�Ĥ@��ǥ�
	if(empty($student_sn)) {
		$sql="select student_sn from stud_seme where seme_year_seme='$year_seme' and seme_class='$seme_class' order by seme_num";
		$rs=$CONN->Execute($sql);
		$student_sn=$rs->fields['student_sn'];
	}

	//�Y���O�S��$stud_id�A�h�q�X���~�T��
	if(empty($student_sn))header("location:{$_SERVER['SCRIPT_NAME']}?error=1");
	
	if ($chknext && $nav_next<>'')	$student_sn = $nav_next;
	
	//�D�o�ǥ�ID
	$query="select stud_id from stud_base where student_sn='$student_sn'";
	$res=$CONN->Execute($query);
	$stud_id=$res->fields['stud_id'];

	//���o�Ӿǥͤ�`�ͬ���{���q��
	$oth_data=&get_oth_value($stud_id,$sel_year,$sel_seme);
	
	//���o�ǥͤ�`�ͬ���{���Ƥξɮv���y��ĳ
	$nor_data=get_nor_value($student_sn,$sel_year,$sel_seme,"",($chk_menu_arr)?1:0);

	//���o�ǥͯʮu���p
	$abs_data=get_abs_value($stud_id,$sel_year,$sel_seme);
	
	//�ǥͼ��g���p
	$reward_data = get_reward_value($stud_id,$sel_year,$sel_seme);	

	//���o�ǥͦ��Z��
	$score_data = &get_score_value($stud_id,$student_sn,$class_id,$oth_data);

	//���o�ԲӸ��
	$html=&html2code2($class,$sel_year,$sel_seme,$oth_data,$nor_data,$abs_data,$reward_data,$score_data,$student_sn,($chk_menu_arr)?1:0);
	
	$gridBgcolor="#DDDDDC";
	//�w�s�@����C��
	$over_color = "#223322";
	//�����k������C��
	$non_color = "blue";

	$grid1 = new ado_grid_menu($_SERVER['SCRIPT_NAME'],$URI,$CONN);  //�إ߿��	   	
	$grid1->key_item = "student_sn";  // ������W  	
	$grid1->display_item = array("sit_num","stud_name");  // �����W   
	$grid1->bgcolor = $gridBgcolor;
	$grid1->display_color = array("1"=>"blue","2"=>"red");
	$grid1->color_index_item ="stud_sex" ; //�C��P�_��
	$grid1->class_ccs = " class=leftmenu";  // �C�����
	$grid1->sql_str = "select student_sn,stud_name,stud_sex,substring(curr_class_num,4,2)as sit_num  from stud_base where curr_class_num like '$class[2]%' and stud_study_cond=0 order by curr_class_num";   //SQL �R�O
	$grid1->do_query(); //����R�O 

	$stud_select = $grid1->get_grid_str($stud_id,$upstr,$downstr); // ��ܵe��

	//���o���w�ǥ͸��
	$stu=get_stud_base($student_sn,"");

	//�y��
	$stu_class_num=curr_class_num2_data($stu['curr_class_num']);

	//���o�Ǯո��
	$s=get_school_base();
	$tool_bar=&make_menu($school_menu_p);
	$checked=($chknext)?"checked":"";

	$main="
	$tool_bar
	<table bgcolor='#DFDFDF' cellspacing=1 cellpadding=4>
	<tr class='small'><td valign='top'>$stud_select
	</td><td bgcolor='#FFFFFF' valign='top'>
	<p align='center'>
	<font size=3>".$s[sch_cname]." ".$sel_year."�Ǧ~�ײ�".$sel_seme."�Ǵ����Z��</p>
	<table align=center cellspacing=4>
	<tr>
	<td>�Z�šG<font color='blue'>$class[5]</font></td><td width=40></td>
	<td>�y���G<font color='green'>$stu_class_num[num]</font></td><td width=40></td>
	<td>�m�W�G<font color='red'>$stu[stud_name]</font></td>
	</tr></table></font>
	$html
	</td></tr></table>
	";

	return $main;
}
?>
