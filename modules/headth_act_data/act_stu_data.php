<?php

// $Id: act_stu_data.php 7707 2013-10-23 12:13:23Z smallduh $

// --�t�γ]�w��
include "act_data_config.php";

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

if ($do_key =="CSV ��X" OR $do_key =="XLS ��X") {	
	
	if($curr_school_year and $do_key =="XLS ��X")$filename = "year_".$curr_school_year.".xls";
	if($curr_class_year and $do_key =="XLS ��X")$filename = "class".$curr_class_year.".xls";
	if($curr_school_year and $do_key =="CSV ��X")$filename = "year_".$curr_school_year.".csv";
	if($curr_class_year and $do_key =="CSV ��X")$filename = "class".$curr_class_year.".csv";
	
	header("Content-disposition: filename=$filename");
	header("Content-type: application/octetstream; Charset=Big5");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");
	
	if($do_key =="XLS ��X")
		$ma .= "<table border=1>\n<tr><td>�N��</td><td>�m�W</td><td>�ʧO</td><td>�J�Ǧ~</td><td>�Z��</td><td>�y��</td><td>�ͤ�(�褸)</td><td>�����Ҧr��</td><td>���˩m�W</td><td>���˩m�W</td><td>�l���ϸ�</td><td>�q��</td><td>��}</td><td>����p���覡</td></tr>\n";
	if($do_key =="CSV ��X")
		$ma .= "�N��,�m�W,�ʧO,�J�Ǧ~,�Z��,�y��,�ͤ�(�褸),�����Ҧr��,���˩m�W,���˩m�W,�l���ϸ�,�q��,��},����p���覡\n";

	$s = $curr_school_year*100;
	$e = ($curr_school_year+1)*100;
	if($curr_class_year!="" and $curr_school_year=="")
		$query = "select a.* from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[curr_seme]' and b.seme_class='$_REQUEST[curr_class_year]'  and a.stud_study_cond in (0,5) order by b.seme_num ";
	if($curr_class_year=="" and $curr_school_year!="")
		$query = "select a.* from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[curr_seme]' and b.seme_class like '$curr_school_year%' and a.stud_study_cond in (0,5) order by b.seme_class";
		//$query = "select a.* from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[curr_seme]' and b.seme_class>'$s' and b.seme_class<'$e' and a.stud_study_cond in (0,5) order by b.seme_class";
	$result = $CONN->Execute($query)or die($query);

	while (!$result->EOF) {
		$stud_id = $result->fields['stud_id'];
		$s_home_phone = $result->fields['stud_tel_2'];
		$s_offical_phone = $result->fields['stud_tel_3'];
		$stud_sex = $result->fields['stud_sex'];
		$stud_name = $result->fields['stud_name'];
		$curr_class_num = $result->fields['curr_class_num'];
		$stud_birthday = $result->fields['stud_birthday'];
		$stud_person_id = $result->fields['stud_person_id'];
		$stud_study_year = $result->fields['stud_study_year'];
		$addr_zip = $result->fields['addr_zip'];
		//$s_addres = $result->fields['stud_addr_2'];
		$addr = change_addr(addslashes($result->fields[stud_addr_2]),1);
		$s_addres = "";
		for ($i=2;$i<=12;$i++) $s_addres .= $addr[$i];
		$query2 = "select fath_name,moth_name from stud_domicile where stud_id ='$stud_id'";
		$result2 = $CONN->Execute($query2)or die ($query2) ;
		$fath_name = $result2->fields['fath_name'];
		$moth_name = $result2->fields['moth_name'];
		
		if($do_key =="XLS ��X") $stud_num ="<tr><td>".$stud_id;
		if($do_key =="CSV ��X") $stud_num = $stud_id;
		
		$arr = array($stud_num,$stud_name,$stud_sex,$stud_study_year,substr($curr_class_num,1,2),substr($curr_class_num,-2),$stud_birthday,$stud_person_id,$fath_name,$moth_name,$addr_zip,$s_home_phone,$s_addres,$s_offical_phone); 
			
		if($do_key =="XLS ��X") $data[] = implode("<td>", $arr);
		if($do_key =="CSV ��X") $data[] = implode(",", $arr);
		
		$result->MoveNext();
	}
	if($do_key =="XLS ��X") $ma .= implode("</td>", $data);
	if($do_key =="CSV ��X") $ma .= implode("\n", $data);
	if($do_key =="XLS ��X") $ma .= "</table>";
	
	echo $ma;
	exit;
}


//�L�X���Y
head("�ץX���d���߸��");
print_menu($menu_p);

?>

<table border="0" width="100%" cellspacing="0" cellpadding="0" >
<tr><td valign=top bgcolor="#CCCCCC">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
<tr><td>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="pform">

<?php
	
	//�C�X�Ǧ~�קO
	if ($_REQUEST[curr_seme]=='')$_REQUEST[curr_seme] = sprintf("%03d%d",curr_year(),curr_seme());
	$class_seme_p = get_class_seme(); //�Ǧ~��
	$sel = new drop_select();
	$sel->s_name= "curr_seme";
	$sel->has_empty = false;
	$sel->is_submit = true;
	$sel->arr = $class_seme_p;
	$sel->id = $_REQUEST[curr_seme];
	$sel->do_select();

	//�C�X�~�ŧO
	$school_year_p = year_base($_REQUEST[curr_year]);
	$main  = "<select name='curr_school_year'>";
	$main .= "<option value=''>�п�ܦ~��</option>\n";
	while(list($ttkey,$ttvalue)= each ($school_year_p)) {
		if ($ttkey == $curr_school_year)	  
			 $main .= sprintf ("<option value=\"%s\" selected> %s�� </option>\n",$ttkey,$ttvalue);
		else
			 $main .= sprintf ("<option value=\"%s\"> %s�� </option>\n",$ttkey,$ttvalue);
	}             	 
	$main .= "</select>";
	
	//�C�X�Z��
	$class_year_p = class_base($_REQUEST[curr_seme]);
	$main .= "<select name='curr_class_year'>";
	$main .= "<option value=''>�п�ܯZ��</option>\n";
	while(list($tkey,$tvalue)= each ($class_year_p)) {
		if ($tkey == $curr_class_year)	  
			 $main .= sprintf ("<option value=\"%s\" selected>%s</option>\n",$tkey,$tvalue);
		else
			 $main .= sprintf ("<option value=\"%s\">%s</option>\n",$tkey,$tvalue);
	}             	 
	$main .= "</select><p>";
	$main .= " �����G �~�� �� �Z�ťu���@���U���I�I";
	echo $main;
?>

</td>
<td width=65% rowspan="2" valign=top >
<p><b><font size="4">�U�ת������X����</font></b></p>
<p>�U�ת�����p�ǰ��d�ˬd��T�B�z�t�� �� �x�����U�װ�p�i��|�Ѯv�Ҷ}�o�A�Բӻ����ЦܤU�C���}�d��<BR>
<a href= "http://health.wfes.tcc.edu.tw/">http://health.wfes.tcc.edu.tw/</a>

</td>
</tr>
<tr>
<td >
<input type=submit name="do_key" value="CSV ��X">
<input type=submit name="do_key" value="XLS ��X">
</td>
</tr>
</table>
</td></tr></table>

<?php foot() ?>
