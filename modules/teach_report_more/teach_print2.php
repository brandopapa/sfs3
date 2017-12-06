<?php

// $Id: teach_print2.php 7712 2013-10-23 13:31:11Z smallduh $

//���J�]�w��
include "teach_report_config.php";
include "../../include/sfs_oo_zip2.php";

// --�{�� session 
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//���b¾���A
if ($c_sel != "")
	$sel = $c_sel;
else if ($sel=="")
	$sel = 0 ; //�w�]����b¾���p 
	
	
$button["sxw"]="OpenOffice.org Writer ��";
$button["csv"]="�¤�r�� csv ��";
$button["Word"]="MS Office Word ��";
$button["Excel"]="MS Office Excel ��";

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�


//����ʧ@�P�_
if($_POST['Submit'] == '�ץX') {
    if (isset($print_key) and $print_key=="sxw"){
    	dl_sxw($sel_year,$sel_seme,$cols, $sel);
    }elseif(isset($print_key) and $print_key=="csv"){
    	dl_csv($sel_year,$sel_seme,$cols, $sel);
    }elseif(isset($print_key)){
    	print_key($sel_year,$sel_seme,$print_key,$cols, $sel);
    }
}else{
	$main=&main_form($sel_year,$sel_seme, $sel);
}


//�q�X����
head("��¾���q�T���C�L");

echo $main;
foot();

//�D�n�e��
function &main_form($sel_year,$sel_seme , $sel =0 ){
	global $button;
	//���o�Юv���
	$row=&get_teacher_data( $sel);
	
	//��Ʈ榡���
	$import_option="";
	while(list($k,$v)=each($button)){
		$import_option.="<option value='$k'>$v</option>\n";
	}
		
	$import_sel="<select name='print_key' size='1'>$import_option</select>";
	
	$remove_p = remove(); //�b¾���p    
	$upstr = "���<select name=\"c_sel\" onchange=\"this.form.submit()\">\n"; 
	while (list($tid,$tname)=each($remove_p)){
		if ($sel== $tid)
			$upstr .= "<option value=\"$tid\" selected>$tname</option>\n";
		else
			$upstr .= "<option value=\"$tid\">$tname</option>\n";
	}
	$upstr .= "</select>"; 		
	
	$t_data="";
	for($i=0;$i<sizeof($row);$i++){
		$job = $row[$i]["title_name"];
		if ($row[$i]["class_num"]) {
			//�ť� 
			$job = class_id2big5($row[$i]["class_num"],$sel_year,$sel_seme);
		}
		
		$teach_person_id = $row[$i]["teach_person_id"];
		$teach_name = $row[$i]["name"];
		$birthday = $row[$i]["birthday"];
		$address = $row[$i]["address"];
		$home_phone = $row[$i]["home_phone"];
		
		//�ഫ������
		$birthday=( substr($birthday,0,4)>1911)?(substr($birthday,0,4) - 1911). substr($birthday,4):"";
	
		$color= ($i%2 == 1) ? "white" : "#fafafa";
		
		$t_data.= "
		<tr bgcolor='$color' class='small'>
		<td>$job</td>
		<td>$teach_person_id</td>
		<td>$teach_name</td>
		<td>$birthday</td>
		<td>$address</td>
		<td>$home_phone</td></tr>\n";
	}
	
	
	$main="
	<table cellspacing='1' cellpadding='4' align='center' bgcolor='#C0C0C0'>
	<tr bgcolor='#FFFFB9'><td colspan='6' class='small'>
	<form action='{$_SERVER['PHP_SELF']}' method='post'>
	$upstr <font color='#800000'>�@�� $i �����</font>
	�ץX���G $import_sel
	�ť���ơG<input type=text size=3 maxlength=2 name='cols' value='$cols'>
	<input type='submit' name='Submit' value='�ץX'></td></tr>
	<tr bgcolor='#D0D8F7' class='small'><td>¾��</td><td>�������r��</td><td>�m�W</td><td>�ͤ�</td><td>�a�}</td><td>�q��</td>
	</tr>
	$t_data
	</table>
	</form>";

	return $main;
}

//�C�L���
function print_key($sel_year="",$sel_seme="",$print_key="",$cols="" ,$sel =0){
	global $CONN,$button;
	
	//����Юv���
	$row=&get_teacher_data($sel);
	
	//�̦h����
	if ($cols > 20 )	$cols = 20;
	
	//�s�@�s�W�����
	for ($j =0 ;$j< $cols ;$j++){
		$add_col.="<td>&nbsp;</td>";
	}
	
	//�s�@�D�n���
	for($i=0;$i<sizeof($row);$i++){
		$job = $row[$i][title_name] ;
		if ($row[$i][class_num]) {
			//�ť� 
			$job = class_id2big5($row[$i][class_num],$sel_year,$sel_seme);
		}
		
		$teach_person_id = $row[$i]["teach_person_id"];
		$teach_name = $row[$i]["name"];
		$birthday = $row[$i]["birthday"];
		
		//�bexcel �����ഫ������
       	if (substr($birthday,0,4)>1911) {
       	    if ($print_key=="Word")	$birthday = (substr($birthday,0,4) - 1911). substr($birthday,4) ;
		}else{
       	    $birthday = " " ; 
		}
		
		$word_add_col=($print_key =="Word")?$add_col:"";
		
       	$address = $row[$i]["address"];
       	$home_phone = $row[$i]["home_phone"];
       
       	$main_data.="
		<tr>
		<td>$job</td>
		<td>$teach_person_id</td>
		<td>$teach_name</td>
		<td>$birthday</td>
		<td>$address</td>
		<td>$home_phone</td>
		$word_add_col
		</tr>\n";
	}
	
	//��X��excel�Bword	
	if ($print_key=="Excel")
		$filename =  "��¾���q�T��.xls"; 	
	else if ($print_key=="Word")
		$filename =  "��¾���q�T��.doc";
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
	
	echo "
	<html>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\">
	<body><table border=1>
	<tr><td colspan=".($cols+6)." align=center>
	��¾���q�T��</td></tr>
	<tr>
	<td>¾��</td><td>�������r��</td><td>�m�W</td><td>�ͤ�</td><td>�a�}</td><td>�q��</td>$add_col</tr>
	$main_data
	</table></body><html>";
	exit;
}

//�U���з�sxw��
function dl_sxw($sel_year,$sel_seme,$cols, $sel =0){
	global $CONN;
	//���o�Ǯո��
	$s=get_school_base();
	$oo_path = "ooo";
	$filename="teacher_data.sxw";
	
	//����Юv���
	$row=&get_teacher_data($sel);
	
	
	//��r�榡�AP3���k����AP4�m���AP5�m��
	$text_style=array("job"=>"P4","teach_person_id"=>"P5","teach_name"=>"P5","birthday"=>"P5","address"=>"P6","home_phone"=>"P5");
	
	$all_n=sizeof($row);
	//�@�C�����
	for($i=0;$i<$all_n;$i++){
		
		$n=(($all_n-$i)==1)?4:2;
		//���榡�A�̥���A2�A�̥k��F2�A��l��B2�A�̫�@��2�ܦ�4
		$table_style=array("job"=>"Table1.A".$n."","teach_person_id"=>"Table1.B".$n."","teach_name"=>"Table1.B".$n."","birthday"=>"Table1.B".$n."","address"=>"Table1.B".$n."","home_phone"=>"Table1.F".$n."");
	
		//¾��
		$c[job]=trim($row[$i][title_name]);
		if ($row[$i][class_num]) {
			//�ť� 
			$c[job]=class_id2big5($row[$i][class_num],$sel_year,$sel_seme);
		}
		
		$c[teach_person_id]=trim($row[$i]["teach_person_id"]);
		$c[teach_name]=trim($row[$i]["name"]);
		$birthday=trim($row[$i]["birthday"]);
		$c[birthday]=(substr($birthday,0,4)>1911)?(substr($birthday,0,4) - 1911). substr($birthday,4):$birthday; 
		$c[address]=trim($row[$i]["address"]);
       	$c[home_phone]=trim($row[$i]["home_phone"]);
		
		$cell="";
		reset($c);
		while(list($col_name,$col_value)=each($c)){
			$cell.=cell($table_style[$col_name],"string",$text_style[$col_name],$col_value);
		}
		/*
		for($j=0;$i<$cols;$j++){
			$cell.=cell($table_style[$teach_name],"string",$text_style[$teach_name],"");
		}
		*/
		$row_data.="<table:table-row>$cell</table:table-row>";

	}

	//�s�W�@�� zipfile ���
	$ttt = new EasyZip;
	$ttt->setPath($oo_path);
	$ttt->addDir("META-INF");
	$ttt->addFile("settings.xml");
	$ttt->addFile("styles.xml");
	$ttt->addFile("meta.xml");

	//Ū�X content.xml 
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");

	//�N content.xml �� tag ���N
	$temp_arr["city_name"] = $s[sch_sheng];	
	$temp_arr["school_name"] = $s[sch_attr_id].$s[sch_cname];
	$temp_arr["year"] = $sel_year;
	$temp_arr["seme"] = $sel_seme;
	$temp_arr["row_data"] = $row_data;
	
	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	$replace_data = $ttt->change_temp($temp_arr,$data,0);
	
	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");
	
	//���� zip ��
	$sss = & $ttt->file();

	//�H��y�覡�e�X ooo.sxw
	header("Content-disposition: attachment; filename=$filename");
	//header("Content-type: application/octetstream");
	header("Content-type: application/vnd.sun.xml.writer");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

	echo $sss;
	
	exit;
	return;
}

//�U���з�csv��
function dl_csv($sel_year,$sel_seme,$cols, $sel =0){
	global $CONN;
	$filename="teacher_data.csv";
	
	//����Юv���
	$row=&get_teacher_data($sel);

	$all_n=sizeof($row);
	//�@�C�����
	for($i=0;$i<$all_n;$i++){

		//¾��
		$c[job]="\"".trim($row[$i][title_name])."\"";
		if ($row[$i][class_num]) {
			//�ť� 
			$c[job]="\"".class_id2big5($row[$i][class_num],$sel_year,$sel_seme)."\"";
		}
		
		$c[teach_person_id]="\"".trim($row[$i]["teach_person_id"])."\"";
		$c[teach_name]="\"".trim($row[$i]["name"])."\"";
		$birthday=trim($row[$i]["birthday"]);
		$c[birthday]=(substr($birthday,0,4)>1911)?"\"".(substr($birthday,0,4) - 1911). substr($birthday,4)."\"":"\"".$birthday."\""; 
		$c[address]="\"".trim($row[$i]["address"])."\"";
       	$c[home_phone]="\"".trim($row[$i]["home_phone"])."\"";
		

		reset($c);
		$row_data[]=implode(",",$c);
	
	}

	$main=implode("\n",$row_data);
	
	//�H��y�覡�e�X ooo.csv
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: text/x-csv");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

	echo $main;
	
	exit;
	return;
}

//�s�yOOo��������
function cell($table_style,$value_type,$text_style,$text){
	$cell="<table:table-cell table:style-name=\"$table_style\" table:value-type=\"$value_type\"><text:p text:style-name=\"$text_style\">$text</text:p></table:table-cell>";
	return $cell;
}

//����Юv��ơA�]�A�qteach_person_id,name,birthday,address,home_phone,title_name,class_num�r
function &get_teacher_data( $sel = 0 ){
	global $CONN;
	
	//����Юv���
	$sql_select = "
	SELECT a.teach_person_id , a.name, a.birthday, a.address, a.home_phone, d.title_name ,b.class_num 
	FROM  teacher_base a , teacher_post b, teacher_title d 
	where  a.teacher_sn =b.teacher_sn  
	and b.teach_title_id = d.teach_title_id  
	and a.teach_condition = '$sel'   order by class_num, post_kind , post_office , a.teach_id "  ;              
	
	$recordSet=$CONN->Execute($sql_select) or user_error($sql_select,256);
	while($row=$recordSet->FetchRow()){
		$data[]=$row;
	}
	
	return $data;
}
?>
