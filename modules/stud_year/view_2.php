<?php
//$Id: view_2.php 5310 2009-01-10 07:57:56Z hami $
include "stud_year_config.php";
//�{��
##################����ƨ禡###########################
function get_order2($SQL) {
	//����,�覡,(�ĴX��,�C�դH��,�ƧǨ�)
	global $CONN ;
$rs=$CONN->Execute($SQL) or die($SQL);
$arr = $rs->GetArray();
return $arr ;
}
###############################################

sfs_check();
//�q�X�����������Y
if($_POST[sbase]!=''  ) {
	$sbase=$_POST[sbase];
	header("Location:$PHP_SELF?sbase=$sbase");
	}
if($_GET[sbase]!=''  ) {
	$sbase=$_GET[sbase];
	$SQL1="select stud_id ,student_sn ,stud_name ,stud_sex ,stud_study_year ,curr_class_num ,stud_study_cond  from stud_base where curr_class_num  like '$sbase%' order by curr_class_num ";
	$arr1=get_order2($SQL1);
	}
if($_GET[sn]!='') {
	$SQL2="select  a.student_sn, a.stud_name, a.curr_class_num, b.seme_year_seme, b.seme_class, b.seme_class_name, b.seme_num from  stud_base a , stud_seme b where  a.student_sn= b.student_sn   and a.student_sn='$_GET[sn]' order by  b.seme_year_seme,b.seme_num ";
	$arr2=get_order2($SQL2);
	} 

head("���y�d��2");print_menu($menu_p);
//if($_GET[sbase]=='') { print_menu($school_menu_p2);}
//else {$link2="mid=$_GET[mid]&item=$_GET[item]&sclass=$_GET[sclass]"; print_menu($school_menu_p2,$link2);}
?>

<table border=0 width='100%' style='font-size:10pt;'  cellspacing=0 cellpadding=0 bgcolor=silver>
<TR bgcolor='white'><TD colspan=2>
<FONT SIZE='' COLOR='red'>�����{���ȨѾ��y��Ʈֹ蠟�ΡC</FONT></td></tr>

<FORM ACTION="<?=$PHP_SELF?>" METHOD="POST" name=f1>
<TR bgcolor='white'><TD width=50% style='color:#800000;'>
�Z�O<INPUT TYPE="TEXT" NAME="sbase" VALUE="<?=$_GET[sbase]?>" Size="5">
<INPUT TYPE="SUBMIT" NAME="" VALUE="��n�e�X" style="border-style: groove;border-width:1px: groove;background-color:#FFFFFF;font-size:12px;Padding-left:0 px;Padding-right:0 px;">
<FONT COLOR='blue'>(1�~7�Z��p107,�ꤤ707)</FONT><BR>
���y��ƪ�stud_base�G</TD>
<TD width=50% valign=bottom style='color:#800000;'>
�Ǵ���ƪ�stud_seme�G
</TD></TR></form><tr bgcolor=white><TD valign=top>
<!--���y���-->
<table border=0 width='100%' style='font-size:11pt;'  cellspacing=1 cellpadding=0  bgcolor=silver>
<tr bgcolor=white>
	<td colspan=7 style='font-size:9pt;color:silver;' >stud_id�Ǹ�,student_sn�y����,stud_name�m�W,stud_sex�ʧO<BR>
	,stud_study_year�J�Ǧ~,curr_class_num,�ثe�~�Z,stud_study_cond�N�Ǫ��p</td>
</tr>
<tr bgcolor=#EFEFEF>
	<td>�Ǹ�</td>
	<td>�y����</td>
	<td>�m�W</td>
	<td>�ʧO</td>
	<td>�J�Ǧ~</td>
	<td>�ثe�~�Z</td>
	<td>�N�Ǫ��p</td>
</tr>
<?
for($i=0; $i<count($arr1); $i++) {
echo "<tr bgcolor=white>
	<td>".$arr1[$i][stud_id]."</td>
	<td><A HREF='$PHP_SELF?sbase=$sbase&sn=".$arr1[$i][student_sn]."'>".$arr1[$i][student_sn]."</A></td>
	<td>".$arr1[$i][stud_name]."</td>
	<td>".$arr1[$i][stud_sex]."</td>
	<td>".$arr1[$i][stud_study_year]."</td>
	<td>".$arr1[$i][curr_class_num]."</td>
	<td>".$arr1[$i][stud_study_cond]."</td>
</tr>";
}


?>
</table>
</TD><TD valign=top>
<!--�Ǵ����-->
<table border=0 width='100%' style='font-size:11pt;'  cellspacing=1 cellpadding=0 bgcolor=silver>
<tr bgcolor=white>
<td colspan=7 style='font-size:9pt;color:silver;' >student_sn�y����,stud_name�m�W,curr_class_num�ثe�~�Z,<BR>
seme_year_seme�Ǵ�,seme_class�Z��,seme_class_name�Z�W,seme_num�y��
</td>
</tr>

<tr bgcolor=#EFEFEF>
	<td>a�y����</td>
	<td>a�m�W</td>
	<td>a�ثe�~�Z</td>
	<td>b�Ǵ�</td>
	<td>b�Z��</td>
	<td>b�Z�W</td>
	<td>b�y��</td>
</tr>

<?
for($i=0; $i<count($arr2); $i++) {
echo "<tr bgcolor=white>
	<td>".$arr2[$i][student_sn]."</td>
	<td>".$arr2[$i][stud_name]."</td>
	<td>".$arr2[$i][curr_class_num]."</td>
	<td>".$arr2[$i][seme_year_seme]."</td>
	<td>".$arr2[$i][seme_class]."</td>
	<td>".$arr2[$i][seme_class_name]."</td>
	<td>".$arr2[$i][seme_num]."</td>
</tr>";
}
?>
<tr bgcolor=white>
<td colspan=7 style='font-size:9pt;' ><BR><BR>
</td>
</tr>
</table>


</TD></TR></TABLE>
<?
//�G������
foot();
?>
