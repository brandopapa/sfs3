<?php
// $Id: grad_list.php 7711 2013-10-23 13:07:37Z smallduh $

//���J�]�w��
require("config.php") ;
include "../../include/sfs_oo_zip2.php";

// �{���ˬd
sfs_check();

if ($_POST[key]=="grade") {
	$gkind="���~";
	$grad_kind=1;
} else {
	$gkind="�׷~";
	$grad_kind=2;
}

//�s�W�@�� zipfile
$ttt=new EasyZip;

$oo_path="ooo/grad_list";

$ttt->setPath($oo_path);
$ttt->addDir('META-INF');
$ttt->addFile("settings.xml");
$ttt->addFile("meta.xml");

$data = & $ttt->read_file(dirname(__FILE__)."/$oo_path/styles.xml");
$sql="select * from school_base";
$rs=$CONN->Execute($sql);
$temp_sty["sch_cname"]=$rs->fields['sch_cname'];
$temp_sty["sel_year"]=curr_year();
$today=explode("-",date("Y-m-d",mktime(date("m"),date("d"),date("Y"))));
$temp_sty["year"]=Num2CNum(intval($today[0]-1911));
$temp_sty["month"]=Num2CNum(intval($today[1]));
$temp_sty["day"]=Num2CNum(intval($today[2]));
$temp_sty["gkind"]=$gkind;
$replace_data=$ttt->change_temp($temp_sty,$data);
$ttt->add_file($replace_data,"styles.xml");

$temp_arr["gkind"]=$gkind;
$data=$ttt->change_temp($temp_arr,$ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml"));

$seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
$seme_year = sprintf("%03d", curr_year());
$query="select student_sn from stud_seme where seme_year_seme='$seme_year_seme'";
$res=$CONN->Execute($query);
while(!$res->EOF) {
	$sn[]=$res->fields[student_sn];
	$res->MoveNext();
}
$all_sn="'".implode("','",$sn)."'";
$query="select * from stud_move where student_sn in ($all_sn) and move_kind in ('2','3','13','14','15') order by stud_id,move_date desc";
$res=$CONN->Execute($query);
while(!$res->EOF) {
	$id=$res->fields[stud_id];
	if ($oid!=$id) {
		$dd=array();
		$dd=explode("-",$res->fields[move_c_date]);
		$move_c_date=($dd[0]-1911).".".$dd[1].".".$dd[2];
		$mw[$id]=$move_c_date.$res->fields[move_c_word]."�r��".$res->fields[move_c_num]."��";
	}
	$oid=$id;
	$res->MoveNext();
}
$sex_arr=array("1"=>"�k","2"=>"�k");
$i=1;
$temp_str="";
$query="select a.*,c.stud_name,c.stud_sex,c.stud_person_id,c.stud_birthday,c.stud_addr_1,c.stud_study_year from 
grad_stud a left join stud_base c on a.student_sn=c.student_sn 
where a.stud_grad_year='$seme_year' and  a.grad_kind='$grad_kind' order by a.stud_id";
// echo $query;
$res=$CONN->Execute($query);
$all_num=$res->RecordCount();
while(!$res->EOF) {
	$dd=array();
	$dd=explode("-",$res->fields[stud_birthday]);
	$birthday=($dd[0]-1911).".".$dd[1].".".$dd[2];
	$dd=array();
	$dd=explode("-",$res->fields[grad_date]);
	$gword=($dd[0]-1911).".".$dd[1].".".$dd[2].$res->fields[grad_word]."�r��".$res->fields[grad_num]."��";
	$inday=$res->fields[stud_study_year].".08";
	if ($i%20== 0 || $i==$all_num)
		$temp_str.='<table:table-row><table:table-cell table:style-name="chart_1.A3" table:value-type="string"><text:p text:style-name="P2">'.$res->fields[stud_id].'</text:p></table:table-cell><table:table-cell table:style-name="chart_1.B3" table:value-type="string"><text:p text:style-name="P3">'.$res->fields[stud_name].'</text:p></table:table-cell><table:table-cell table:style-name="chart_1.B3" table:value-type="string"><text:p text:style-name="P2">'.$sex_arr[$res->fields[stud_sex]].'</text:p></table:table-cell><table:table-cell><table:sub-table><table:table-column table:style-name="chart_1.D1.1"/><table:table-column table:style-name="chart_1.D1.2"/><table:table-column table:style-name="chart_1.D1.3"/><table:table-row table:style-name="chart_1.D2.1"><table:table-cell table:style-name="chart_1.D2.1.1" table:value-type="string"><text:p text:style-name="P2">'.$res->fields[stud_person_id].'</text:p></table:table-cell><table:table-cell table:style-name="chart_1.D2.1.1" table:value-type="string"><text:p text:style-name="P2">'.$birthday.'</text:p></table:table-cell><table:table-cell table:style-name="chart_1.D2.1.1" table:value-type="string"><text:p text:style-name="P2">'.$inday.'</text:p></table:table-cell></table:table-row><table:table-row><table:table-cell table:style-name="chart_1.D3.1.2" table:number-columns-spanned="3" table:value-type="string"><text:p text:style-name="P3">'.$ttt->xml_reference_change($res->fields[stud_addr_1]).'</text:p></table:table-cell><table:covered-table-cell/><table:covered-table-cell/></table:table-row></table:sub-table></table:table-cell><table:table-cell table:style-name="chart_1.B3" table:value-type="string"><text:p text:style-name="P2">'.$mw[$res->fields[stud_id]].'</text:p></table:table-cell><table:table-cell table:style-name="chart_1.F3" table:value-type="string"><text:p text:style-name="P2">'.$gword.'</text:p></table:table-cell></table:table-row>';
	else
		$temp_str.='<table:table-row><table:table-cell table:style-name="chart_1.A2" table:value-type="string"><text:p text:style-name="P2">'.$res->fields[stud_id].'</text:p></table:table-cell><table:table-cell table:style-name="chart_1.D1.1.2" table:value-type="string"><text:p text:style-name="P3">'.$res->fields[stud_name].'</text:p></table:table-cell><table:table-cell table:style-name="chart_1.D1.1.2" table:value-type="string"><text:p text:style-name="P2">'.$sex_arr[$res->fields[stud_sex]].'</text:p></table:table-cell><table:table-cell><table:sub-table><table:table-column table:style-name="chart_1.D1.1"/><table:table-column table:style-name="chart_1.D1.2"/><table:table-column table:style-name="chart_1.D1.3"/><table:table-row table:style-name="chart_1.D2.1"><table:table-cell table:style-name="chart_1.D2.1.1" table:value-type="string"><text:p text:style-name="P2">'.$res->fields[stud_person_id].'</text:p></table:table-cell><table:table-cell table:style-name="chart_1.D2.1.1" table:value-type="string"><text:p text:style-name="P2">'.$birthday.'</text:p></table:table-cell><table:table-cell table:style-name="chart_1.D2.1.1" table:value-type="string"><text:p text:style-name="P2">'.$inday.'</text:p></table:table-cell></table:table-row><table:table-row table:style-name="chart_1.D1.1"><table:table-cell table:style-name="chart_1.D2.1.2" table:number-columns-spanned="3" table:value-type="string"><text:p text:style-name="P3">'.$ttt->xml_reference_change($res->fields[stud_addr_1]).'</text:p></table:table-cell><table:covered-table-cell/><table:covered-table-cell/></table:table-row></table:sub-table></table:table-cell><table:table-cell table:style-name="chart_1.D1.1.2" table:value-type="string"><text:p text:style-name="P2">'.$mw[$res->fields[stud_id]].'</text:p></table:table-cell><table:table-cell table:style-name="chart_1.F2" table:value-type="string"><text:p text:style-name="P2">'.$gword.'</text:p></table:table-cell></table:table-row>';
	$i++;
	$res->MoveNext();
}
$replace_data2=$data.iconv("Big5","UTF-8//IGNORE",$temp_str).'</table:table><text:p text:style-name="P4"/></office:body></office:document-content>';
$ttt->add_file($replace_data2,"content.xml");

//���� zip ��
$sss = & $ttt->file();

//�H��y�覡�e�X ooo.sxw
header("Content-disposition: attachment; filename=".$_POST[key]."_list.sxw");
header("Content-type: application/octetstream");
//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
header("Expires: 0");

echo $sss;
exit;
?>
