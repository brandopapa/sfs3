<?php

// $Id: explode_stu.php 8534 2015-09-20 12:23:57Z infodaes $

// --�t�γ]�w��
include "create_data_config.php";

//--�{�� session
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//���o�ثe�Ǵ�
$curr_seme =  curr_seme();
//-----------------------------------
if ($do_key =="Excel ��X") {	
	$filename = "class".$curr_class_year.".xls";
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");
	echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; Charset=Big5\"></head><body><table border=1>\n";
	echo "<tr><td>�N��</td><td>�m�W</td><td>�ʧO</td><td>�J�Ǧ~</td><td>�Z��</td><td>�y��</td><td>�ͤ�(�褸)</td><td>�����Ҧr��</td><td>���˩m�W</td><td>���˩m�W</td><td>�l���ϸ�</td><td>�q��</td><td>��}</td><td>����p���覡</td></tr>\n";
	
	if ($chk_all_year) {
	  $query = "select a.* from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[curr_seme]' and b.seme_class like '" . substr( $_REQUEST[curr_class_year],0,1) ."%'  and a.stud_study_cond in (0,5) order by  a.curr_class_num";
	}else   
	  $query = "select a.* from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[curr_seme]' and b.seme_class='$_REQUEST[curr_class_year]'  and a.stud_study_cond in (0,5) order by b.seme_num";
	//echo  $query ; 
	$result = $CONN->Execute($query)or die($query);
	$zip_arr = get_addr_zip_arr() ;
	
	while (!$result->EOF) {
		$stud_id = $result->fields[stud_id];
		//$s_addres = $result->fields[stud_addr_1];
		$s_home_phone = $result->fields[stud_tel_1];
		$s_offical_phone = $result->fields[stud_tel_2];
		$stud_sex = $result->fields[stud_sex];
		$stud_name = $result->fields[stud_name];
		$curr_class_num = $result->fields[curr_class_num];
		$stud_birthday = $result->fields[stud_birthday];
		$stud_person_id = $result->fields[stud_person_id];
		$addr_zip = $result->fields[addr_zip];
		$stud_study_year = $result->fields['stud_study_year'];
		//���o �l���ϸ�

		if ($addr_zip == '') {
			if ( $result->fields[stud_addr_a] <>'') {
		     $addr_ab = $result->fields[stud_addr_a] . $result->fields[stud_addr_b];  	
		     $addr_zip= $zip_arr[$addr_ab] ;
		  } 
    }

		$addr = change_addr(addslashes($result->fields[stud_addr_1]),1);
		$s_addres = "";
		for ($i=2;$i<=12;$i++) $s_addres .= $addr[$i];

		$query2 = "select fath_name,moth_name from stud_domicile where stud_id ='$stud_id'";
		$result2 = $CONN->Execute($query2)or die ($query2) ;
		$fath_name = $result2->fields[fath_name];
		$moth_name = $result2->fields[moth_name];

		echo sprintf("<tr><td>=T(\"%s\")</td><td>%s</td><td>%d</td><td>%s</td>",$stud_id,$stud_name,$stud_sex,$stud_study_year);
		
		echo sprintf("<td>%d</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",substr($curr_class_num,1,2),substr($curr_class_num,-2),$stud_birthday,$stud_person_id,$fath_name,$moth_name,$addr_zip); 

		echo sprintf("<td>=T(\"%s\")</td><td>%s</td><td>=T(\"%s\")</td>",$s_home_phone,stripslashes($s_addres),$s_offical_phone); 


		echo"</tr>\n";
		$result->MoveNext();

	}
	echo "</table></body></html>";
	exit;
}

//�L�X���Y
head("�妸�إ߾ǥ͸��");
print_menu($menu_p);

?>

<table border="0" width="35%" cellspacing="0" cellpadding="0" >
<tr><td valign=top bgcolor="#CCCCCC">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
<tr><td nowrap>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="pform">
<?php
	if ($_REQUEST[curr_seme]=='')
		$_REQUEST[curr_seme] = sprintf("%03d%d",curr_year(),curr_seme());
	$class_seme_p = get_class_seme(); //�Ǧ~��
	$sel = new drop_select();
	$sel->s_name= "curr_seme";
	$sel->has_empty = false;
	$sel->is_submit = true;
	$sel->arr = $class_seme_p;
	$sel->id = $_REQUEST[curr_seme];
	$sel->do_select();

?> &nbsp;
<select	name="curr_class_year">

<?php
	$class_year_p = class_base($_REQUEST[curr_seme]);
	while(list($tkey,$tvalue)= each ($class_year_p))
	 {
		if ($tkey == $curr_class_year)	  
			 echo  sprintf ("<option value=\"%s\" selected>%s</option>\n",$tkey,$tvalue);
		else
			 echo  sprintf ("<option value=\"%s\">%s</option>\n",$tkey,$tvalue);
		  }             	 
?>
</select>
<input name="chk_all_year" type="checkbox" id="chk_all_year" value="1">
<label for ="chk_all_year">���Ǧ~</label>
</td>
</tr>
<tr>
<td >
<input type=submit name="do_key" value="Excel ��X">
</td>
</tr>
</table>
</td></tr></table>

<?php foot() ?>
