<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();

//�q�X����
head("²�T�o�e�έp");

print_menu($menu_p);

//�Ǵ��O
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());


//���o�Юv�m�W
$teacher_array=array();
$sql_select = "select name,teacher_sn from teacher_base";
$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
while (list($name,$teacher_sn) = $recordSet->FetchRow()) {
	$teacher_array[$teacher_sn]=$name;
}

//���o�w���~�׬���
$year_seme=$_POST['year_seme']?$_POST['year_seme']:sprintf('%03d%d',curr_year(),curr_seme());
$sql= "select distinct year_seme from sms_apol_task order by year_seme desc";
$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
$year_seme_radio="<table border='2' cellpadding='6' cellspacing='0' style='border-collapse: collapse; font-size=9pt;' bordercolor='#111111' id='AutoNumber1' width='100%'>
	<tr><td align='center' bgcolor='#ccccff'>��ܾǴ�</td></tr><tr><td>";
while(!$rs->EOF) {
	$this_year_seme=$rs->fields['year_seme'];
	$year=substr($this_year_seme,0,3);
	$seme=substr($this_year_seme,-1);
	$checked=($this_year_seme==$year_seme)?'checked':'';
	$year_seme_radio.="<input type='radio' value='$this_year_seme' name='year_seme' $checked onclick=\"this.form.submit();\">{$year}�Ǧ~�ײ�{$seme}�Ǵ�<br>";
	$rs->MoveNext();
}
$year_seme_radio.="</td></tr></table>";
$main="<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'><table><tr valign='top'><td>$year_seme_radio</td><td>";


//�������
$sql="SELECT teacher_sn,count(*) AS counter,sum(TotalRec) AS summary,MAX(ask_time) AS recenttime FROM sms_apol_task WHERE year_seme='$year_seme' GROUP BY teacher_sn";
$recordSet=$CONN->Execute($sql) or user_error($sql,256);
$main.="<table border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1' width='100%'>
		<tr bgcolor='#ccffff' align='center'><td>NO.</td><td>�Юv�N��</td><td>�Юv�m�W</td><td>�o�e����</td><td>�h�Ʋέp</td><td>�̫�o�e�ɶ�</td></tr>";
while(list($teacher_sn,$counter,$summary,$recenttime)=$recordSet->FetchRow()) {
	$num=sprintf('%03d',$recordSet->currentrow());
	$main.="<tr align='center'><td>$num</td><td>$teacher_sn</td><td>{$teacher_array[$teacher_sn]}</td><td>$counter</td><td>$summary</td><td>$recenttime</td></tr>";
}
$main.="</table></td></tr></table></form>";
echo $main;
foot();

?>