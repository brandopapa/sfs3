<?php

//$Id: stud_eduh_report.php 6515 2011-09-13 03:08:33Z infodaes $
include "config.php";
sfs_check();

//�q�X����
head("�a�x���p�έp");

//�ثe�Ǧ~�Ǵ�
$this_seme_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$c_curr_seme = $_REQUEST[c_curr_seme];
if ($c_curr_seme=='')
	$c_curr_seme = $this_seme_year_seme;
	
//��ܾǴ�
$class_seme_p = get_class_seme(); //�Ǧ~��	
$upstr = "<select name=\"c_curr_seme\" onchange=\"this.form.submit()\">\n";
while (list($tid,$tname)=each($class_seme_p)){
	if ($c_curr_seme== $tid)
      		$upstr .= "<option value=\"$tid\" selected>$tname</option>\n";
      	else
      		$upstr .= "<option value=\"$tid\">$tname</option>\n";
}
$upstr .= "</select><br>"; 
	

//���s���r��
$linkstr = "stud_id=$stud_id&c_curr_class=$c_curr_class&c_curr_seme=$c_curr_seme";
//�Ҳտ��
print_menu($menu_p,$linkstr);

$selection=$_POST['selection']?$_POST['selection']:'�������Y';

$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

$status_arr=array();
/*
$status_arr['�������Y']="SELECT sse_relation as `���Y`,count(*) as `�έp` FROM stud_seme_eduh WHERE seme_year_seme='$c_curr_seme' GROUP BY sse_relation";
$status_arr['�a�x����']="SELECT sse_family_kind as `�a�x����`,count(*) as `�έp` FROM stud_seme_eduh WHERE seme_year_seme='$c_curr_seme' GROUP BY sse_family_kind";
$status_arr['�a�x��^']="SELECT sse_family_air as `�a�x��^`,count(*) as `�έp` FROM stud_seme_eduh WHERE seme_year_seme='$c_curr_seme' GROUP BY sse_family_air";
$status_arr['���ޱФ覡']="SELECT sse_farther as `���ޱФ覡`,count(*) as `�έp` FROM stud_seme_eduh WHERE seme_year_seme='$c_curr_seme' GROUP BY sse_farther";
$status_arr['���ޱФ覡']="SELECT sse_mother as `���ޱФ覡`,count(*) as `�έp` FROM stud_seme_eduh WHERE seme_year_seme='$c_curr_seme' GROUP BY sse_mother";
$status_arr['�~����']="SELECT sse_live_state as `�~����`,count(*) as `�έp` FROM stud_seme_eduh WHERE seme_year_seme='$c_curr_seme' GROUP BY sse_live_state";
$status_arr['�g�٪��p']="SELECT sse_rich_state as `�g�٪��p`,count(*) as `�έp` FROM stud_seme_eduh WHERE seme_year_seme='$c_curr_seme' GROUP BY sse_rich_state";
*/


$status_arr['�������Y']="SELECT a.sse_relation as `���Y`,sum((1-abs(sign(b.stud_sex-1)))) as `�k`,sum((1-abs(sign(b.stud_sex-2)))) as `�k` FROM stud_seme_eduh a,stud_base b WHERE a.stud_id=b.stud_id and a.seme_year_seme='$c_curr_seme' GROUP BY sse_relation";
$status_arr['�a�x����']="SELECT sse_family_kind as `�a�x����`,sum((1-abs(sign(b.stud_sex-1)))) as `�k`,sum((1-abs(sign(b.stud_sex-2)))) as `�k` FROM stud_seme_eduh a,stud_base b WHERE a.stud_id=b.stud_id and a.seme_year_seme='$c_curr_seme' GROUP BY sse_family_kind";
$status_arr['�a�x��^']="SELECT sse_family_air as `�a�x��^`,sum((1-abs(sign(b.stud_sex-1)))) as `�k`,sum((1-abs(sign(b.stud_sex-2)))) as `�k` FROM stud_seme_eduh a,stud_base b WHERE a.stud_id=b.stud_id and a.seme_year_seme='$c_curr_seme' GROUP BY sse_family_air";
$status_arr['���ޱФ覡']="SELECT sse_farther as `���ޱФ覡`,sum((1-abs(sign(b.stud_sex-1)))) as `�k`,sum((1-abs(sign(b.stud_sex-2)))) as `�k` FROM stud_seme_eduh a,stud_base b WHERE a.stud_id=b.stud_id and a.seme_year_seme='$c_curr_seme' GROUP BY sse_farther";
$status_arr['���ޱФ覡']="SELECT sse_mother as `���ޱФ覡`,sum((1-abs(sign(b.stud_sex-1)))) as `�k`,sum((1-abs(sign(b.stud_sex-2)))) as `�k` FROM stud_seme_eduh a,stud_base b WHERE a.stud_id=b.stud_id and a.seme_year_seme='$c_curr_seme' GROUP BY sse_mother";
$status_arr['�~����']="SELECT sse_live_state as `�~����`,sum((1-abs(sign(b.stud_sex-1)))) as `�k`,sum((1-abs(sign(b.stud_sex-2)))) as `�k` FROM stud_seme_eduh a,stud_base b WHERE a.stud_id=b.stud_id and a.seme_year_seme='$c_curr_seme' GROUP BY sse_live_state";
$status_arr['�g�٪��p']="SELECT sse_rich_state as `�g�٪��p`,sum((1-abs(sign(b.stud_sex-1)))) as `�k`,sum((1-abs(sign(b.stud_sex-2)))) as `�k` FROM stud_seme_eduh a,stud_base b WHERE a.stud_id=b.stud_id and a.seme_year_seme='$c_curr_seme' GROUP BY sse_rich_state";

foreach($status_arr as $key=>$value){
	$menu.="<input type='radio' value='$key' name='selection' onclick='this.form.submit()'".($selection==$key?' checked':'').">$key<BR>";
}


$sql=$status_arr[$selection];
$res=$CONN->Execute($sql) or user_error("����έp���R���ѡI<br>$sql",256);


$showdata="<table border='2' cellpadding='8' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>";
$showdata.="<tr bgcolor=$Tr_BGColor>";
for($i=0;$i<$res->FieldCount();$i++){
	$r=$res->fetchfield($i);
	$showdata.="<td align='center'>".$r->name."</td>";	
}
$showdata.="<td>�έp</td><td>CSV��X</td></tr>";

$selection2=str_replace("����", "��",$selection);
$selection2=str_replace("����", "��",$selection2);
$tran_arr=sfs_text($selection2);

//print_r($tran_arr);

while(!$res->EOF) {
	$showdata.="<tr align='center'>";
	
	for($i=0;$i<$res->FieldCount();$i++){
		if($i) $target=$res->fields[$i]; else $target=$tran_arr[$res->fields[$i]];
		$showdata.="<td>$target</td>";
	}
	$key=$res->fields[0];
	$value=$tran_arr[$key];
	$summary=$res->fields[1]+$res->fields[2];
	$showdata.="<td>$summary</td><td align='center'><a href='csv_export.php?item=$selection&key=$key&value=$value&semester=$c_curr_seme'><img src='images/csv.png' border=0></a></td></tr>";
	$res->MoveNext();
}
$showdata.="</table>";

$main="<table cellpadding='5' cellspacing='5'>
	<form name='myform' method='post' action='$_SERVER[PHP_SELF]'>
	<tr><td valign='top'>$upstr$menu</td><td valign='top'>$showdata</td></tr></table></form>";
echo $main;
foot();

?>
