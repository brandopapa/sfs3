<?php
// $Id: newstud_notification.php 5944 2010-05-18 08:22:16Z brucelyc $

/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";
$class_year_b=$_REQUEST['class_year_b'];
$act=$_REQUEST['act'];
$org=trim($_REQUEST['org']);
$num=trim($_REQUEST['num']);
$c_place=trim($_REQUEST['c_place']);
$c_date=trim($_REQUEST['c_date']);
$c_time=trim($_REQUEST['c_time']);
$p_date=trim($_REQUEST['p_date']);
$p_time=trim($_REQUEST['p_time']);
$note=trim($_REQUEST['note']);
$note2=trim($_REQUEST['note2']);
$ref_year=$_REQUEST['ref_year'];
if (empty($class_year_b)) $class_year_b=$IS_JHORES+1;

//�ϥΪ̻{��
sfs_check();
$year = date("Y")-1911;
if($act=="send"){
	if ($_POST[save]) {
		//�x�s�]�w
		$sql="replace into new_stud_notification (year,org,num,c_place,c_date,c_time,p_date,p_time,note,note2,class_year) values('$year','$org','$num','$c_place','$c_date','$c_time','$p_date','$p_time','$note','$note2','$class_year_b') ";
		$CONN->Execute($sql) or trigger_error($sql,256);
	}
	$sel_str="";
	if ($_POST[sel]=="0") {
		$hv="1";
	} elseif ($_POST[sel]=="1") {
		$start_num=$_POST[start_num];
		$end_num=$_POST[end_num];
		$sel_str="and temp_id >='A".$start_num."' and temp_id <= 'A".$end_num."'";
		$hv="1";
	} elseif ($_POST[sel]=="2" && count($_POST[sch])>0) {
		while (list($k,$v)=each($_POST[sch])) {
			$sel_str.="'$v',";
		}
		if ($sel_str) $sel_str=substr($sel_str,0,-1);
		$sel_str="and old_school in ($sel_str)";
		$hv="1";
	}
	if ($_POST[ooo] && $hv) {
		//����sxw
		$new_stud_table="new_stud";
		$new_stud_notification_table="new_stud_notification";
		make_ooo($new_stud_table,$new_stud_notification_table);
	}
	if ($_POST[html] && $hv) {
		//����html
		$new_stud_table="new_stud";
		$new_stud_notification_table="new_stud_notification";
		make_html($new_stud_table,$new_stud_notification_table);
	}
}

//�{�����Y
head("�s�ͽs�Z");
print_menu($menu_p,"class_year_b=$class_year_b");


//������v�~�׸��
$sql="select year from new_stud_notification order by year desc";
$rs=$CONN->Execute($sql) or trigger_error($sql,256);

$year_combo="<select name='ref_year' onchange='this.form.submit()'>";

if(! $ref_year) $ref_year=$year;
{
while ($data=$rs->FetchRow()) {
	if ($ref_year==$data['year'])
                $year_combo.="<option value='".$data['year']."' selected>".$data['year']."</option>";
        else
                $year_combo.="<option value='".$data['year']."' >".$data['year']."</option>";
	}
	}
$year_combo.="</select>";

$sql="select * from new_stud_notification where year=$ref_year and class_year='$class_year_b'";
$rs=$CONN->Execute($sql) or trigger_error($sql,256);
$org=$rs->fields['org'];
$num=$rs->fields['num'];
$c_place=$rs->fields['c_place'];
$c_date=$rs->fields['c_date'];
$c_time=$rs->fields['c_time'];
$p_date=$rs->fields['p_date'];
$p_time=$rs->fields['p_time'];
$note=$rs->fields['note'];
$note2=$rs->fields['note2'];

//�]�w�D������ܰϪ��I���C��
$main="<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc><tr><td bgcolor='#FFFFFF'>";

//�������e�иm�󦹳B
$main.="<form action='{$_SERVER['PHP_SELF']}' method='POST'>";

$grade_selected="<select name='class_year_b' OnChange='this.form.submit()'>";
while (list($k,$v)=each($class_year)) {
	$checked=($class_year_b==$k)?"selected":"";
	$grade_selected.="<option value='$k' $checked>$v</option>\n";
}
$grade_selected.="</select>";
$sel[intval($_POST[sel])]="checked";
$main.="<table cellspacing=5 cellpadding=0><tr><td valign='top'>
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<tr bgcolor='#E1ECFF'><td> $grade_selected  �J�ǳq����򥻸�Ƴ]�w�@�@�@( �u�� $year_combo �~�׳]�w )<td>�U�����
	</tr>
	<tr bgcolor='#FFF7CD'><td valign='top'>
	<table border='0'>
	<tr><td>���o�����G</td><td><input type='text' name='org' value='$org' size='20'></td></tr>
	<tr><td>���o�O�r���G</td><td><input type='text' name='num' value='$num' size='20'></td></tr>
	<tr><td>����a�I�G</td><td><input type='text' name='c_place' value='$c_place' size='20'></td></tr>
	<tr><td>�������G</td><td><input type='text' name='c_date' value='$c_date' size='20'></td></tr>
	<tr><td>����ɶ��G</td><td><input type='text' name='c_time' value='$c_time' size='20'></td></tr>
	<tr><td>���U����G</td><td><input type='text' name='p_date' value='$p_date' size='20'></td></tr>
	<tr><td>���U�ɶ��G</td><td><input type='text' name='p_time' value='$p_time' size='20'></td></tr>
	<tr><td>�`�N�ƶ��G<br>�]�q���p�^</td><td><textarea name='note' cols='40' rows='4'>$note</textarea></td></tr>
	<tr><td>�`�N�ƶ��G<br>�]�����p�^</td><td><textarea name='note2' cols='40' rows='4'>$note2</textarea></td></tr>
	<tr><td>�a���m�W�Φ��G</td><td><input type='radio' name='model' value='0' checked>XXX ����<br><input type='radio' name='model' value='1'>XXX ���a��<br><input type='radio' name='model' value='2'>XXX �����</td></tr>
	</table>
	<input type='hidden' name='act' value='send'>
	<input type='submit' name='save' value='�x�s $year �~�׸��'><input type='submit' name='ooo' value='�U���J�ǳq����(.sxw)'><input type='submit' name='html' value='�U���J�ǳq����(������)'>
	<td valign='top'><input type='radio' name='sel' value='0' $sel[0]>�ťճq����<br><br>
	<input type='radio' name='sel' value='1' $sel[1]>�̽s���G<br>�@�@�qA<input type='text' size='5' name='start_num'>��A<input type='text' size='5' name='end_num'><br>
	<br><input type='radio' name='sel' value='2' $sel[2]>�̾ǮաG<br>";
$query="select distinct old_school from new_stud where stud_study_year='$year' and class_year='$class_year_b'";
$res=$CONN->Execute($query);
$i=0;
while (!$res->EOF) {
	$old_school=$res->fields[old_school];
	$main.="�@�@<input type='checkbox' name='sch[$i]' value='$old_school'>".$old_school."<br>";
	$i++;
	$res->MoveNext();
}

//����
$help_text="
�U���J�ǳq����e�Х��N�s�Ͱ򥻸�ƶפJ�öi��۰ʽs�Z�A�H�K�������{�ɪ��Z�ũM�{�ɪ��y���C||
�p�G�z�U�����O���������q����A�Шϥ�IE�è�u�ɮסv���u�]�w�C�L�榡�v�A�N�����B���������e���M�šA�H�o��̨ήĪG�C
";
$help=help($help_text);

$main.="</tr></table></tr></table></form>$help
<br>
";
//�����D������ܰ�
$main.="</td></tr></table>";
echo $main;
//�{���ɧ�
foot();

function make_ooo($new_stud_table,$new_stud_notification_table){
	global $CONN,$year,$class_year,$class_year_b,$sel_str,$_POST;

	//Openofiice�����|
	$oo_path = "ooo_notification";

	//�ɦW����
	$filename=$year."�J�ǳq����.sxw";

	//�s�W�@�� EasyZip ���
	$ttt = new EasyZip;
	$ttt->setPath($oo_path);	
	$ttt->addDir("META-INF");
	$ttt->addfile("settings.xml");
	$ttt->addfile("styles.xml");
	$ttt->addfile("meta.xml");

	//Ū�X content.xml
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");

	// �[�J���� tag
	$data = str_replace("<office:automatic-styles>",'<office:automatic-styles><style:style style:name="BREAK_PAGE" style:family="paragraph" style:parent-style-name="Standard"><style:properties fo:break-before="page"/></style:style>',$data);

	//��� content.xml
	$arr1 = explode("<office:body>",$data);
	//���Y
	$con_head = $arr1[0]."<office:body>";
	$arr2 = explode("</office:body>",$arr1[1]);
	//��Ƥ��e
	$con_body = $arr2[0];
	//�ɧ�
	$con_foot = "</office:body>".$arr2[1];

	//�@�q���
	$sql9="select * from $new_stud_notification_table where year='$year' and class_year='$class_year_b'";
	$rs9=$CONN->Execute($sql9) or trigger_error($sql9,256);
	$fd_arr['org']=$rs9->fields['org'];
	$fd_arr['num']=$rs9->fields['num'];
	$fd_arr['c_place']=$rs9->fields['c_place'];
	$fd_arr['c_date']=$rs9->fields['c_date'];
	$fd_arr['c_time']=$rs9->fields['c_time'];
	$fd_arr['p_date']=$rs9->fields['p_date'];
	$fd_arr['p_time']=$rs9->fields['p_time'];
	$fd_arr['note']=str_replace("<br />","</text:p><text:p text:style-name=\"P2\">",nl2br($rs9->fields['note']));
	$fd_arr['note2']=str_replace("<br />","</text:p><text:p text:style-name=\"P2\">",nl2br($rs9->fields['note2']));
	$sql="select * from school_base";
	$res=$CONN->Execute($sql);
	$fd_arr["school_name"]=$res->fields['sch_cname'];
	$fd_arr["sch_addr"]=$res->fields['sch_addr'];
	$fd_arr["sch_post_num"]=$res->fields['sch_post_num'];
	$fd_arr["school_tel"]=$res->fields['sch_phone'];
	$sql="select * from school_room where room_id='2'";
	$res=$CONN->Execute($sql);
	$fd_arr["room_name"]=$res->fields['room_name'];
	$query="select * from temp_class where year='$year' order by class_id";
	$res=$CONN->Execute($query);
	if ($res)
		while (!$res->EOF) {
			$class_id=$res->fields[class_id];
			$cclass[$class_id]=$class_year[substr($class_id,0,1)].$res->fields[c_name]."�Z";
			$res->MoveNext();
		}

	if (!empty($sel_str)) {
		//�C�@��ǥͪ��򥻸��
		$sql="select * from $new_stud_table where stud_study_year='$year' $sel_str order by temp_id";
		$rs=$CONN->Execute($sql) or trigger_error($sql,256);
		$count=$rs->RecordCount();
		$replace_data ='';
		$i=1;
		while(!$rs->EOF){
			$temp_arr['old_school'] = $rs->fields['old_school'];
			$temp_arr['stud_name'] = $rs->fields['stud_name'];
			$temp_arr['stud_sex'] = ($rs->fields['stud_sex']=="2")?"�k":"�k";
			$birth=explode("-",$rs->fields['stud_birthday']);
			$temp_arr['stud_birthday'] =($birth[0]-1911).".".$birth[1].".".$birth[2];
			if ($_POST['model']==1)
				$temp_arr['guardian_name'] = $temp_arr['stud_name']." ���a��";
			elseif ($_POST['model']==2)
				$temp_arr['guardian_name'] = $temp_arr['stud_name']." �����";
			else
				$temp_arr['guardian_name'] = $rs->fields['guardian_name']." ����";
			$temp_arr['stud_address'] = $rs->fields['stud_address'];
			$temp_arr['temp_id'] = $rs->fields['temp_id'];
			$temp_arr['temp_class'] = $cclass[$rs->fields['temp_class']];
			$temp_arr['temp_site'] = $rs->fields['temp_site'];
			$temp_arr['class']=$c_year."�~".$c_name."�Z";
			$temp_arr['class_site'] = $rs->fields['class_site'];
			$temp_arr['old_class']=$rs->fields['old_class'];
			foreach($fd_arr as $fd_i => $fd_v){
				$temp_arr[$fd_i] = $fd_v;
			}

			$replace_data .= $ttt->change_temp($temp_arr,$con_body,0);
			if ($i<$count) $replace_data .='<text:p text:style-name="BREAK_PAGE"/>';
			$i++;
			$rs->MoveNext();
		}
	} else {
		//�ťժ��Ӧ������
		foreach($fd_arr as $fd_i => $fd_v){
			$temp_arr[$fd_i] = $fd_v;
		}
		$temp_arr['guardian_name'] = "�@�@�@";
		$temp_arr['temp_id'] = "�@�@�@";
		$temp_arr['temp_class'] = "�@�@�@�@";
		$replace_data .= $ttt->change_temp($temp_arr,$con_body,0);
	}

	$replace_data = $con_head.$replace_data.$con_foot;

	//��@�Ǧh�l�����ҥH�ťը��N
	$pattern[]="/\{([^\}]*)\}/";
	$replacement[]="";
	$replace_data=preg_replace($pattern, $replacement, $replace_data);
	$replace_data=str_replace ('&lt;br /&gt;', '</text:p><text:p text:style-name=\'Standard\'>', $replace_data);

	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");

	//���� zip ��
	$sss = $ttt->file();

	//�H��y�覡�e�X ooo.sxw
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: application/vnd.sun.xml.writer");
	echo $sss;
	exit;
}

function make_html($new_stud_table,$new_stud_notification_table){
	global $CONN,$year,$class_year,$class_year_b,$sel_str,$_POST;

	echo "	<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\"><title></title><style>
		<!--
			P { margin-bottom: 0.21cm }
			TD P { margin-bottom: 0.21cm }
			.dotline {BORDER-BOTTOM-STYLE: dotted; BORDER-LEFT-STYLE: dotted; BORDER-RIGHT-STYLE: dotted; BORDER-TOP-STYLE: dotted
		-->
		</style></head><body>";

	//�@�q���
	$sql9="select * from $new_stud_notification_table where year='$year' and class_year='$class_year_b'";
	$rs9=$CONN->Execute($sql9) or trigger_error($sql9,256);
	$org=$rs9->fields['org'];
	$num=$rs9->fields['num'];
	$c_place=$rs9->fields['c_place'];
	$c_date=$rs9->fields['c_date'];
	$c_time=$rs9->fields['c_time'];
	$p_date=$rs9->fields['p_date'];
	$p_time=$rs9->fields['p_time'];
	$note=nl2br($rs9->fields['note']);
	$note2=nl2br($rs9->fields['note2']);
	$sql="select * from school_base";
	$res=$CONN->Execute($sql);
	$school_name=$res->fields['sch_cname'];
	$sch_addr=$res->fields['sch_addr'];
	$sch_post_num=$res->fields['sch_post_num'];
	$school_tel=$res->fields['sch_phone'];
	$sql="select * from school_room where room_id='2'";
	$res=$CONN->Execute($sql);
	$room_name=$res->fields['room_name'];
	$query="select * from temp_class where year='$year' order by class_id";
	$res=$CONN->Execute($query);
	if ($res)
		while (!$res->EOF) {
			$class_id=$res->fields[class_id];
			$cclass[$class_id]=$class_year[substr($class_id,0,1)].$res->fields[c_name]."�Z";
			$res->MoveNext();
		}

	if (!empty($sel_str)) {
		//�C�@��ǥͪ��򥻸��
		$sql="select * from $new_stud_table where stud_study_year='$year' $sel_str order by temp_id";
		$rs=$CONN->Execute($sql) or trigger_error($sql,256);
		$count=$rs->RecordCount();
		$replace_data ='';
		$i=1;
		while(!$rs->EOF){
			$old_school = $rs->fields['old_school'];
			$stud_name = $rs->fields['stud_name'];
			$stud_sex = ($rs->fields['stud_sex']=="2")?"�k":"�k";
			$birth = explode("-",$rs->fields['stud_birthday']);
			$stud_birthday =($birth[0]-1911).".".$birth[1].".".$birth[2];
                        if ($_POST['model']==1)
                                $guardian_name = $stud_name." ���a��";
                        elseif ($_POST['model']==2)
                                $guardian_name = $stud_name." �����";
                        else
                                $guardian_name = $rs->fields['guardian_name']." ����";
			$stud_address = $rs->fields['stud_address'];
			$temp_id = $rs->fields['temp_id'];
			$temp_class = $cclass[$rs->fields['temp_class']];
			$temp_site = $rs->fields['temp_site'];
			$class = $c_year."�~".$c_name."�Z";
			$class_site = $rs->fields['class_site'];
			$old_class = $rs->fields['old_class'];
			foreach($fd_arr as $fd_i => $fd_v){
				$temp_arr[$fd_i] = $fd_v;
			}
			$np=($i<$count)?"<span lang=\"zh-tw\" style=\"font-size:8.0pt;font-family:&quot;Times New Roman&quot;mso-fareast-font-family:�s�ө���;mso-font-kerning:1.0pt;mso-ansi-language:zh-tw;mso-fareast-language:ZH-TW;mso-bidi-language:zh-tw\"><br clear=\"all\" style=\"mso-special-character:line-break;page-break-before:always\"></span>":"";
			$i++;
			show_html($sch_post_num,$sch_addr,$school_name,$room_name,$school_tel,$stud_address,$guardian_name,$stud_name,$stud_sex,$org,$num,$c_place,$c_date,$c_time,$p_date,$p_time,$note,$note2,$temp_id,$temp_class,$temp_site,$stud_birthday,$old_school,$old_class,$np);
			$rs->MoveNext();
		}
	} else { 
		show_html($sch_post_num,$sch_addr,$school_name,$room_name,$school_tel,"�@","�@�@�@","","",$org,$num,$c_place,$c_date,$c_time,$p_date,$p_time,$note,$note2,"","","","","","","");
	}
	echo "</body></html>";
	exit;
}

function show_html($sch_post_num,$sch_addr,$school_name,$room_name,$school_tel,$stud_address,$guardian_name,$stud_name,$stud_sex,$org,$num,$c_place,$c_date,$c_time,$p_date,$p_time,$note,$note2,$temp_id,$temp_class,$temp_site,$stud_birthday,$old_school,$old_class,$np) {

	echo "
<p STYLE=\"margin-bottom: 0cm\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"Dotum, sans-serif\">$sch_post_num</font><br>
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">$sch_addr<br>
".$school_name."�@".$room_name."<br>
�@�@�@�@�@�@�Ǯչq�ܡG</font><font FACE=\"Dotum, sans-serif\">$school_tel</font></p>
<p STYLE=\"margin-bottom: 0cm\">�@</p>
<p STYLE=\"margin-bottom: 0cm\"><font face=\"�з���\" size=\"4\">�@<br>�@�@�@�@�@�@".$stud_address."<br>�@�@�@�@�@�@".$guardian_name."�@��</p>
<p STYLE=\"margin-bottom: 0cm\"><br><br><br><br></p>
<hr width=\"95%\" class=\"dotline\" size=\"2\" color=\"#000000\">
<p ALIGN=\"CENTER\" STYLE=\"margin-bottom: 0cm\">
<font SIZE=\"5\" STYLE=\"font-size: 20pt\" FACE=\"�з���\">".$school_name."�J�ǳq����(�q���p)</font><br><br>
<center>
<table WIDTH=\"605\" BORDER=\"3\" BORDERCOLOR=\"#000000\" CELLPADDING=\"4\" CELLSPACING=\"0\">
<colgroup><col WIDTH=\"76\"><col WIDTH=\"208\"><col WIDTH=\"79\"><col WIDTH=\"204\"></colgroup>
<thead>
<tr>
<td WIDTH=\"76\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">�ǥͩm�W</font></td>
<td WIDTH=\"208\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">".$stud_name."�@</font></td>
<td WIDTH=\"79\" VALIGN=\"TOP\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">�ʡ@�@�O</font></td>
<td WIDTH=\"204\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">".$stud_sex."�@</font></td>
</tr>
</thead>
<tr>
<td>
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">���o����</font></td>
<td COLSPAN=\"3\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">".$org."�@</font></td>
</tr>
<tr>
<td>
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">���o��r��</font></td>
<td COLSPAN=\"3\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">".$num."�@</font></td>
</tr>
<tr>
<td WIDTH=\"76\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">����a�I</font></td>
<td COLSPAN=\"3\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">".$c_place."�@</font></td>
</tr>
<tr>
<td WIDTH=\"76\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">������</font></td>
<td WIDTH=\"208\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"Dotum, sans-serif\">".$c_date."�@</font></td>
<td WIDTH=\"79\" VALIGN=\"TOP\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">����ɶ�</font></td>
<td WIDTH=\"204\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"Dotum, sans-serif\">".$c_time."�@</font></td>
</tr>
<tr>
<td WIDTH=\"76\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">���U���</font></td>
<td WIDTH=\"208\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"Dotum, sans-serif\">".$p_date."�@</font></td>
<td WIDTH=\"79\" VALIGN=\"TOP\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">���U�ɶ�</font></td>
<td WIDTH=\"204\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"Dotum, sans-serif\">".$p_time."�@</font></td>
</tr>
</table>
</center>
<p STYLE=\"margin-bottom: 0cm\"><font SIZE=\"2\" FACE=\"�з���\">".$note."</font></p>
<hr width=\"95%\" class=\"dotline\" size=\"2\" color=\"#000000\">
<p ALIGN=\"CENTER\" STYLE=\"margin-bottom: 0cm\">
<font SIZE=\"5\" STYLE=\"font-size: 20pt\" FACE=\"�з���\">".$school_name."�J�ǳq����(�����p)</font><br>
<font SIZE=\"2\" STYLE=\"font-size: 12pt\" FACE=\"�з���\">����s���G<font SIZE=\"2\" STYLE=\"font-size: 12pt\" FACE=\"Dotum, sans-serif\">$temp_id</font>
�@�@�@�@�@�@�{�ɯZ�šG$temp_class  
�@�@�@�@�@�@�{�ɮy���G<font SIZE=\"2\" STYLE=\"font-size: 12pt\" FACE=\"Dotum, sans-serif\">$temp_site</font></font></p>
<center>
<table WIDTH=\"605\" BORDER=\"3\" BORDERCOLOR=\"#000000\" CELLPADDING=\"4\" CELLSPACING=\"0\">
<colgroup>
<col WIDTH=\"76\"><col WIDTH=\"166\"><col WIDTH=\"49\"><col WIDTH=\"49\">
<col WIDTH=\"49\"><col WIDTH=\"163\">
</colgroup>
<thead>
<tr>
<td WIDTH=\"76\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">�ǥͩm�W</font></td>
<td WIDTH=\"166\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">".$stud_name."�@</font></td>
<td WIDTH=\"49\" VALIGN=\"TOP\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">�ʡ@�O</font></td>
<td WIDTH=\"49\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">".$stud_sex."�@</font></td>
<td WIDTH=\"49\" VALIGN=\"TOP\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">�͡@��</font></td>
<td WIDTH=\"163\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">
<font FACE=\"Dotum, sans-serif\">".$stud_birthday."�@</font></font></td>
</tr>
</thead>
<tr>
<td WIDTH=\"76\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">�a���m�W</font></td>
<td COLSPAN=\"5\" WIDTH=\"507\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">".$guardian_name."�@</font></td>
</tr>
<tr>
<td WIDTH=\"76\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">���y�a�}</font></td>
<td COLSPAN=\"5\" WIDTH=\"507\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">".$stud_address."�@</font></td>
</tr>
<tr>
<td WIDTH=\"76\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">���~��p</font></td>
<td COLSPAN=\"2\" WIDTH=\"223\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">".$old_school."�@</font></td>
<td COLSPAN=\"2\" WIDTH=\"105\" VALIGN=\"TOP\">
<p ALIGN=\"CENTER\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">��p�Z��</font></td>
<td WIDTH=\"163\" VALIGN=\"TOP\">
<p ALIGN=\"LEFT\" STYLE=\"font-style: normal; font-weight: medium\">
<font SIZE=\"2\" STYLE=\"font-size: 11pt\" FACE=\"�з���\">".$old_class."�@</font></td>
</tr>
</table>
</center>
<p><font SIZE=\"2\" FACE=\"�з���\">$note2</font></p>
".$np;
	return;
}
?>
