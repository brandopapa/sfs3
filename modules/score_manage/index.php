<?php

// $Id: index.php 5310 2009-01-10 07:57:56Z hami $

/*�ޤJ�ǰȨt�γ]�w��*/
include "../../include/config.php";
//�ޤJ�禡�w
include "../../include/sfs_case_PLlib.php";
//�ޤJ���
include "./my_fun.php";
//�ϥΪ̻{��
sfs_check();

//�Ǧ~�Ǵ�
$year_seme=$_GET['year_seme'];
//�~��
$year_name=$_GET['year_name'];


//�P�_�O�_���޲z��
$is_man = checkid($_SERVER['SCRIPT_FILENAME'],1);

//if (!$is_man) {
//    header("Location: error.php");
//}

//�O�_�C�@����ҭn�t�X�@�����ɦ��Z
$rs_yorn=$CONN->Execute("SELECT pm_value FROM pro_module WHERE pm_name='score_input' AND pm_item='yorn'");
$yorn=$rs_yorn->fields['pm_value'];

//�{�����Y
head("���Z�޲z");
//�C�X��V���s�����Ҳ�
$menu_p = array("index.php"=>"���Z�޲z", "score_error.php"=>"���Z�ˬd");
print_menu($menu_p);
//�����ܼƳB�z
$class_id = $_GET[class_id];
if (empty($class_id))
	$class_id = $_POST[class_id];
if($class_id == $_POST[old_class_id] or $_GET[is_open]==1) {
	$stage = $_GET[stage];
	if (empty($stage))
		$stage = $_POST[stage];
}
else{
	$stage = '';
}


echo "<form name='myform' method='post' action='{$_SERVER['PHP_SELF']}'>\n";
//�]�w�D������ܰϪ��I���C��
echo "<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc><tr><td bgcolor=#FFFFFF>";

//�������e�иm�󦹳B
/***********************************************************************************/
$year_seme = ($_GET[year_seme])?"$_GET[year_seme]":"$_POST[year_seme]";
if($year_seme == '')
	$year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$class_seme_arr = get_class_seme();
$sel1 = new drop_select();
$sel1->s_name="year_seme";
$sel1->id= $year_seme;
$sel1->arr= $class_seme_arr;
$sel1->top_option="��ܾǦ~��";
$sel1->is_submit = true;
$year_seme_menu = $sel1->get_select();

$sel_year=substr($year_seme,0,-1);
$sel_seme=substr($year_seme,-1);
$score_semester="score_semester_".intval($sel_year)."_".intval($sel_seme);
$score_semester="score_semester_".intval($sel_year)."_".intval($sel_seme);
$this_year_seme = sprintf("%03d_%d_",$sel_year,$sel_seme);

//�ثe���Z�Ÿ��
$curr_class_base = class_base($year_seme);

$query = "select class_id from $score_semester where class_id like '$this_year_seme%' group by class_id order by class_id ";

$res = $CONN->Execute($query) or trigger_error("$sel_year �Ǧ~�� $sel_seme �Ǵ����Z���إ�" ,E_USER_ERROR);
//�p�G���]�Z�ŮɡA�H�Ĥ@�Z����l
if (empty($class_id)){
	$class_id = $res->fields[class_id];
	$temp_arr = explode("_",$res->fields[class_id]);
	$class_id=sprintf("%d%02d", $temp_arr[2],$temp_arr[3]);
}

//�N���Z�w�ǦܱаȳB���Z�ũ�J�}�C��
while(!$res->EOF) {
	$temp_arr = explode("_",$res->fields[class_id]);
	$tid =sprintf("%d%02d", $temp_arr[2],$temp_arr[3]);
	$temp_name = $curr_class_base[$tid];
	$class_in_arr[$tid] = $temp_name;
	$res->MoveNext();
}

//���ͯZ�Ū�����
$sel1 = new drop_select();
$sel1->s_name='class_id';
$sel1->id=$class_id;
$sel1->has_empty= false;
$sel1->arr = $class_in_arr;
$sel1->is_submit =true;
if (count($class_in_arr)<=10)
	$sel1->size= count($class_in_arr);
else 
	$sel1->size =10;

$class_menu = $sel1->get_select();
//�@���P�_�O�_���ܯZ�ť�
$class_menu .= "<input type=hidden name=old_class_id value=\"$class_id\">";

//��ܶ��q 
$temp_class_id = sprintf("%03d_%d_%02d_%02d",$sel_year,$sel_seme,substr($class_id,0,1),substr($class_id,1));

if ($yorn=='y')
	$query = "select test_sort from $score_semester where class_id='$temp_class_id' and test_sort<>254 group by test_sort";
else
	$query = "select test_sort from $score_semester where class_id='$temp_class_id' group by test_sort";
//echo $query; 
$res = $CONN->Execute($query) or trigger_error("SQL ���~",E_USER_ERROR);

if (empty($stage))
	$stage = $res->fields[0];
while(!$res->EOF){
	if ($res->fields[0]==254)
		$stage_arr[$res->fields[0]] = "���ɦ��Z";
	else if ($res->fields[0]==255)
		$stage_arr[$res->fields[0]] = "�������q";
	else
		$stage_arr[$res->fields[0]] = "��".$res->fields[0]."���q";	
	$res->MoveNext();
}
//��ܶ��q �U�Կ��
$sel1 = new drop_select();
$sel1->s_name = "stage";
$sel1->id = $stage;
$sel1->arr = $stage_arr;
$sel1->is_submit = true;
$sel1->has_empty = false;
$stage_menu = $sel1->get_select();

$menu="
 <table cellpadding='5' cellspacing='1' border='0' bgcolor='#0000ff' align='left'>
    <tbody bgcolor='#FFFFFFFF'>
        <tr >
            <td>$year_seme_menu</td>
	</tr>
	<tr>
	   <td>$class_menu</td>
        </tr>
   </tbody>
    </table>
<table align=left><tr><td width=10>&nbsp;&nbsp;</td></tr></table>
";

echo $menu;
//�H�W�����bar
/******************************************************************************************/


settype($year_name,integer);
settype($me,integer);

$hello="<font color=red> <B>".$sel_year."</b> </font>�Ǧ~�ײ� <font color=red><B>".$sel_seme."</b></font> �Ǵ� ";
$hello.="<font color=red><b>".$class_in_arr[$class_id]."</b></font>&nbsp;";

//if($stage==254) $hello.="���ɶ��q";
//elseif($stage==255) $hello.="�������q";
$hello.=$stage_menu;
$hello.=" �����Z<br><br>";

$score_semester="score_semester_".intval($sel_year)."_".intval($sel_seme);
$score_semester="score_semester_".intval($sel_year)."_".intval($sel_seme);


$sql="select a.ss_id,b.print from $score_semester a, score_ss b where a.ss_id=b.ss_id and b.enable=1 and  a.class_id='$temp_class_id' and test_sort='$stage' group by a.ss_id";
$rs=$CONN->Execute($sql);
$i=0;
while (!$rs->EOF) {
	$ss_id[$i++]=$rs->fields["ss_id"];
	$print[$i]=$rs->fields["print"];
	$rs->MoveNext();
}

for($i=0;$i<count($ss_id);$i++){
	$sql2="select count(*) from $score_semester where class_id='$temp_class_id' and test_sort='$stage' and ss_id='$ss_id[$i]' and sendmit='0'";
	$rs2=$CONN->Execute($sql2);
	$k = $rs2->fields[0];		
	if($k>0)
		$send="<img src='images/yes.png'>";
	else
		$send="<img src='images/no.png'>";
	
	if($yorn=="n" && $stage=="254")
		 $sql3="select sum(sendmit  in (0)) as ss,count(*) as cc from $score_semester where class_id='$temp_class_id' and ss_id='$ss_id[$i]' and test_kind='���ɦ��Z'";
	elseif($yorn=="n" && $stage!="254") {
		$temp_kind=($stage==255)?"���Ǵ�":"�w�����q"; 
		$sql3="select sum(sendmit  in (0)) as ss,count(*) as cc from $score_semester where class_id='$temp_class_id' and test_sort='$stage' and ss_id='$ss_id[$i]' and test_kind='$temp_kind'";
	}
	else
		$sql3="select sum(sendmit  in (0)) as ss,count(*) as cc from $score_semester where class_id='$temp_class_id' and test_sort='$stage' and ss_id='$ss_id[$i]'";
	
	$rs3=$CONN->Execute($sql3) or die($sql3);
	//echo $sql3."  $yorn ==n && $stage==254 <BR>";		
	//�`��
	$sendmit_tol = $rs3->fields[cc];
	//�w�W�Ǽ�
	$sendmit_num= $rs3->fields[ss];

	//�w�W����w
	if ($sendmit_tol>0 && $sendmit_tol == $sendmit_num) {
		$mit="<img src='images/lock.png'>";
		$open="<a href='./openlock.php?score_semester=$score_semester&score_semester=$score_semester&class_id=$temp_class_id&test_sort=$stage&ss_id=$ss_id[$i]&year_seme=$year_seme&year_name=$year_name&me=$me&stage=$stage&temp_class=$class_id'><img src='images/key.png' border='0'></a>";
	}
	//�w����Ʃ|���W��
	else{
		$mit="<img src='images/unlock.png'>";
		$open ="<a href='./closelock.php?score_semester=$score_semester&score_semester=$score_semester&class_id=$temp_class_id&test_sort=$stage&ss_id=$ss_id[$i]&year_seme=$year_seme&year_name=$year_name&me=$me&stage=$stage&temp_class=$class_id'><img src='images/door.png' border='0'></a>";
	}
	$delete="<a href='./delete.php?score_semester=$score_semester&score_semester=$score_semester&class_id=$temp_class_id&test_sort=$stage&ss_id=$ss_id[$i]&year_seme=$year_seme&year_name=$year_name&me=$me&stage=$stage&temp_class=$class_id'><img src='images/cancel.png' border='0'></a>";
	//���X��ئW��
	$subject_name=ss_id_to_subject_name($ss_id[$i]);
	$content.="<tr bgcolor='#FFFFFF'><td>$subject_name</td><td align=center>$send</td><td align=center>$mit</td><td align=center>$open</td><td align=center>$delete</td></tr>";
}
    $main="
    <table cellpadding='5' cellspacing='1' border='0' width='440' bgcolor='#0000ff' align='left'>
    <caption>$hello</caption>
    <tbody>
        <tr bgcolor='#B8BEF6'>
        <td width='110' align=center>��ئW��</td>
        <td width='110' align=center>�ǰe����</td>
        <td width='110' align=center>��w���p</td>
        <td width='110' align=center>�}��</td>
		<td width='110' align=center>�R��</td>
        </tr>
        $content
    </tbody>
    </table>";
    $description="
    <table cellpadding='5' cellspacing='0' border='0' width='440' align='left'>
    <tbody>
        <tr><td><img src='images/yes.png'>�ǥͦ��Z�w�g�ǰe��аȳB</td></tr>
        <tr><td><img src='images/no.png'>�ǥͦ��Z�٥��ǰe��аȳB</td></tr>
        <tr><td><img src='images/oh.png'>�ǰe��аȳB�����Z������ݥ��}��w����</td></tr>
        <tr><td><img src='images/lock.png'>�Ӭ�ئ��Z�H�Q��w�A�Ѯv�L�k�W��</td></tr>
        <tr><td><img src='images/unlock.png'>�Ӭ�إ��Q��w�A�Ѯv�i�H�W��</td></tr>
        <tr><td><img src='images/key.png'>���_�ͥ��}��w�A���Ѯv�୫�s�W�Ǧ��Z</td></tr>
		<tr><td><img src='images/door.png'>���ϥͰ�N��ƪ���w�A���Ѯv�L�k�W�Ǧ��Z</td></tr>
    </tbody>
    </table>";
    echo "<table><tr><td>";
    echo $main;
    echo "</td></tr><tr><td>";
    echo $description;
    echo "</td></tr></table>";

//}
//�����D������ܰ�
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</form>";
//�{���ɧ�
foot();
?>
