<?php

// $Id: basic_test_stu.php 7711 2013-10-23 13:07:37Z smallduh $

// --�t�γ]�w��
include "select_data_config.php";

//--�{�� session
sfs_check();

$curr_seme=$_POST['curr_seme'];
$curr_school_year=$_POST['curr_school_year'];
$area=$_POST['area'];
$parent=$_POST['parent'];
$phone=$_POST['phone'];
$address=$_POST['address']; 
$do_key=$_POST['do_key'];

if ($do_key =="CSV ��X") {	
	//if($curr_school_year)$filename = "year_".$curr_school_year.".csv";
	if($curr_school_year)$filename = "student.csv";
	if($curr_class_year)$filename = "student_".$curr_class_year.".csv";
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: text/x-csv ; Charset=Big5");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");
	
	$ma = "�ҰϥN�X,�ǮեN�X,���W�Ǹ�,�Ǹ�,�Z��,�y��,�ǥͩm�W,�����Ҹ�,�ʧO,�X�ͦ~,�X�ͤ�,�X�ͤ�,���~�Ǯ�,���~�~��,���w�~,�ǥͨ���,���߻�ê,���o��,�C���J��,���~���I��,��Ʊ��v,�a���m�W,�q��,�l���ϸ�,�a�}\n";

	$s = $curr_school_year*100;
	$e = ($curr_school_year+1)*100;
	
	$sql = "SELECT sch_id FROM school_base"; //�d�߾ǮեN�X
	$rs = $CONN->Execute($sql)or die($sql);
	$sch_id = $rs->fields['sch_id'];
	
	if($curr_class_year!="" and $curr_school_year=="")
		$query = "select a.* from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[curr_seme]' and b.seme_class='$_REQUEST[curr_class_year]'  and a.stud_study_cond in (0,5) order by b.seme_num ";
	if($curr_class_year=="" and $curr_school_year!="")
		$query = "select a.* from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[curr_seme]' and b.seme_class>$s and b.seme_class<$e and a.stud_study_cond in (0,5) order by b.seme_class, b.seme_num";
	$result = $CONN->Execute($query)or die($query);
	
	$i=1;
	while (!$result->EOF) {
		$stud_id = $result->fields['stud_id'];
		$student_sn = $result->fields['student_sn'];
		$s_register_phone = $result->fields['stud_tel_1'];
		$s_home_phone = $result->fields['stud_tel_2'];
		$s_offical_phone = $result->fields['stud_tel_3'];
		$stud_sex = $result->fields['stud_sex'];
		$stud_name = $result->fields['stud_name'];
		$curr_class_num = $result->fields['curr_class_num'];
		$stud_birthday = $result->fields['stud_birthday'];
		$stud_person_id = $result->fields['stud_person_id'];
		$addr_zip = $result->fields['addr_zip'];
		$s_addres = $result->fields['stud_addr_2'];
		//�P�_�q��
		if($phone==1)$s_phone=$s_register_phone;
		if($phone==2)$s_phone=$s_home_phone;
		if($phone==3)$s_phone=$s_offical_phone;
		//�d�ߤ����m�W
		$query2 = "select fath_name,moth_name,guardian_name from stud_domicile where student_sn ='$student_sn'";
		$result2 = $CONN->Execute($query2)or die ($query2) ;
		$fath_name = $result2->fields['fath_name'];
		$moth_name = $result2->fields['moth_name'];
		$guardian_name = $result2->fields['guardian_name'];
		//�P�_�a���m�W
		if($parent==1) $parent_name=$guardian_name;
		if($parent==2) $parent_name=$fath_name;
		if($parent==3) $parent_name=$moth_name;
		//�P�_��}
		if($address==1)$s_address=$s_addres_1;
		if($address==2)$s_address=$s_addres_2;
		$birth = explode("-" , $stud_birthday);//�X�ͤ��
		$birth[0]=$birth[0]-1911;//�ഫ������
		$curr_class_num_c=substr($curr_class_num,1,2); //���Z�O
		$curr_class_num_n=substr($curr_class_num,-2); //���y��
		$now_curr_seme=substr($_REQUEST['curr_seme'],0,3); //���Ǧ~��
		$over_curr_seme = $now_curr_seme+1; //���~�~��
		$arr = array($area,$sch_id,$i,$stud_id,$curr_class_num_c,$curr_class_num_n,$stud_name,$stud_person_id,$stud_sex,$birth[0],$birth[1],$birth[2],$sch_id,$over_curr_seme,1,0,0,$area,0,0,1,$parent_name,$s_phone,$addr_zip,$s_addres);
		$data[] = implode(",", $arr);
		$result->MoveNext();
		$i++;
	}
	
	$ma .= implode("\n", $data);
	echo $ma;
	exit;
}

//�L�X���Y
head("�妸�إ߾ǥ͸��");
print_menu($menu_p);

?>

<table border="0" width="100%" cellspacing="0" cellpadding="0" >
<tr><td valign=top bgcolor="#CCCCCC">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
<tr><td>
<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post" name="pform">

<?php

	//�C�X�~�קO���
	if (!$curr_seme) $curr_seme = sprintf("%03d%d",curr_year(),curr_seme());
	$class_seme_p = get_class_seme(); //�Ǧ~��
	$main.="�Ǵ��G".menu_sel($class_seme_p,"curr_seme",$curr_seme);
	//�C�X�~�ŧO���
	$school_year_p = year_base($_REQUEST[curr_year]);
	$main.="�~�šG".menu_sel($school_year_p,"curr_school_year",$curr_school_year);
	$main .= "<input type=submit name='do_key' value='CSV ��X'>\n";
	$parent_sel="�a���G".menu_sel($parent_arr,"parent",$parent);
	$phone_sel="�q�ܡG".menu_sel($phone_arr,"phone",$phone);
	$address_sel="��}�G".menu_sel($address_arr,"address",$address);
	//��X���
	$main .= "��X���G ".$area_sel.$parent_sel.$phone_sel.$address_sel;
	echo $main;
	
	/*
	//�C�X�~�קO���
	if (!$curr_seme)$curr_seme = sprintf("%03d%d",curr_year(),curr_seme());
	$class_seme_p = get_class_seme(); //�Ǧ~��
	$main .= "<select name='sel_curr_seme' onchange=location.href=this.options[this.selectedIndex].value;>\n";
	while(list($tttkey,$tttvalue)= each ($class_seme_p)) {
		if ( $tttkey == $curr_seme )	  
			 $main .= "<option value=$_SERVER[PHP_SELF]?curr_seme=$tttkey selected>".$tttvalue."</option>\n";
		else
			 $main .= "<option value=$_SERVER[PHP_SELF]?curr_seme=$tttkey>".$tttvalue."</option>\n";
	} 
	$main .= "</select><input type=hidden name='curr_seme' value='$curr_seme'>\n";
	//�C�X�~�ŧO���
	$school_year_p = year_base($_REQUEST[curr_year]);
	$main .= "\n<select name='sel_curr_school_year' onchange=location.href=this.options[this.selectedIndex].value;>";
	$main .= "<option value=''>�п�ܦ~��</option>\n";
	while(list($ttkey,$ttvalue)= each ($school_year_p)) {
		if ( $ttkey == $year )	  
			 $main .= "<option value=$_SERVER[PHP_SELF]?curr_seme=$curr_seme&year=$ttkey selected>".$ttvalue."��</option>\n";
		else
			 $main .= "<option value=$_SERVER[PHP_SELF]?curr_seme=$curr_seme&year=$ttkey>".$ttvalue."��</option>\n";
	} 
	$main .= "</select><input type=hidden name=curr_school_year value='$year'> OR \n";
	//�C�X�Z�ſ��
	$class_year_p = class_base($_REQUEST[curr_seme]);
	$main .= "<select name='sel_curr_class_year' onchange=location.href=this.options[this.selectedIndex].value;>\n";
	$main .= "<option value=''>�п�ܯZ��</option>\n";
	while(list($tkey,$tvalue)= each ($class_year_p)) {
		if ( $tkey == $class )	  
			 $main .= "<option value=$_SERVER[PHP_SELF]?curr_seme=$curr_seme&class=$tkey selected>".$tvalue."</option>\n";
		else
			 $main .= "<option value=$_SERVER[PHP_SELF]?curr_seme=$curr_seme&class=$tkey>".$tvalue."</option>\n";
	}             	 
	$main .= "</select>\n";
	$main .= "<input type=hidden name=curr_class_year value='$class'><input type=submit name='do_key' value='CSV ��X'>\n";
	//��X���
	$parent_sel="�a���G".menu_sel($parent_arr,"parent",$parent);
	$phone_sel="�q�ܡG".menu_sel($phone_arr,"phone",$phone);
	$address_sel="��}�G".menu_sel($address_arr,"address",$address);
	$main .= "��X���G ".$area_sel.$parent_sel.$phone_sel.$address_sel;

	echo $main;
	
	*/
	
	//�C�X�W�U
	$year=$curr_school_year;
	$s = $year*100;
	$e = ($year+1)*100;
	
	$sql = "SELECT sch_id FROM school_base"; //�d�߾ǮեN�X
	$rs = $CONN->Execute($sql)or die($sql);
	$sch_id = $rs->fields['sch_id'];
	
	if($class!="" and $year=="")
		$query = "select a.* from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[curr_seme]' and b.seme_class='$class'  and a.stud_study_cond in (0,5) order by b.seme_num ";
	if($class=="" and $year!="")
		$query = "select a.* from stud_base a,stud_seme b where a.student_sn=b.student_sn and b.seme_year_seme='$_REQUEST[curr_seme]' and b.seme_class>$s and b.seme_class<$e and a.stud_study_cond in (0,5) order by b.seme_class, b.seme_num";
	$result = $CONN->Execute($query)or die($query);

	$i=1;
	$list .= "<table border='0' width='100%' style='font-size:12px;' bgcolor='#C0C0C0' cellpadding='3' cellspacing='1'>";
	$list .= "<tr bgcolor='#FFFFCC' align='center'><td>��<br>��<br>�N<br>�X<td>��<br>��<br>�N<br>�X<td>��<br>�W<br>��<br>��<td>��<br>��<td>�Z<br>��<td>�y<br>��<td>��<br>��<br>�m<br>�W<td>��<br>��<br>��<br>��<td>��<br>�O<td>�X<br>��<br>�~<td>�X<br>��<br>��
				<td>�X<br>��<br>��<td>��<br>�~<br>��<br>��<td>��<br>�~<br>�~<br>��<td>��<br>�w<br>�~<td>��<br>��<br>��<br>��<td>��<br>��<br>��<br>ê<td>��<br>�o<br>��<td>�C<br>��<br>�J<br>��<td>��<br>�~<br>��<br>�I<br>��<td>��<br>��<br>��<br>�v
				<td>�a<br>��<br>�m<br>�W<td>�q<br>��<td>�l<br>��<br>��<br>��<td>�a<br>�}</td></tr><tr bgcolor='#FFFFFF'>";
	while (!$result->EOF) {
		$stud_id = $result->fields['stud_id'];
		$student_sn = $result->fields['student_sn'];
		$s_register_phone = $result->fields['stud_tel_1'];
		$s_home_phone = $result->fields['stud_tel_2'];
		$s_offical_phone = $result->fields['stud_tel_3'];
		$stud_sex = $result->fields['stud_sex'];
		$stud_name = $result->fields['stud_name'];
		$curr_class_num = $result->fields['curr_class_num'];
		$stud_birthday = $result->fields['stud_birthday'];
		$stud_person_id = $result->fields['stud_person_id'];
		$addr_zip = $result->fields['addr_zip'];
		$s_addres = $result->fields['stud_addr_2'];
		//�P�_�q��
		if($phone==1)$s_phone=$s_register_phone;
		if($phone==2)$s_phone=$s_home_phone;
		if($phone==3)$s_phone=$s_offical_phone;
		//�d�ߤ����m�W
		$query2 = "select fath_name,moth_name,guardian_name from stud_domicile where student_sn ='$student_sn'";
		$result2 = $CONN->Execute($query2)or die ($query2) ;
		$fath_name = $result2->fields['fath_name'];
		$moth_name = $result2->fields['moth_name'];
		$guardian_name = $result2->fields['guardian_name'];
		//�P�_�a���m�W
		if($parent==1) $parent_name=$guardian_name;
		if($parent==2) $parent_name=$fath_name;
		if($parent==3) $parent_name=$moth_name;
		//�P�_��}
		if($address==1)$s_address=$s_addres_1;
		if($address==2)$s_address=$s_addres_2;
		//�d�ߤ����m�W
		$query2 = "select fath_name,moth_name,guardian_name from stud_domicile where student_sn ='$student_sn'";
		$result2 = $CONN->Execute($query2)or die ($query2) ;
		$fath_name = $result2->fields['fath_name'];
		$moth_name = $result2->fields['moth_name'];
		$guardian_name = $result2->fields['guardian_name'];
		$birth = explode("-" , $stud_birthday);//�X�ͤ��
		$birth[0]=$birth[0]-1911;//�ഫ������
		$curr_class_num_c=substr($curr_class_num,1,2); //���Z�O
		$curr_class_num_n=substr($curr_class_num,-2); //���y��
		$now_curr_seme=substr($_REQUEST['curr_seme'],0,3); //���Ǧ~��
		$over_curr_seme = $now_curr_seme+1;
		$arr = array("<td>".$area,$sch_id,$i,$stud_id,$curr_class_num_c,$curr_class_num_n,$stud_name,$stud_person_id,$stud_sex,$birth[0],$birth[1],$birth[2],$sch_id,$over_curr_seme,1,0,0,$area,0,0,1,$parent_name,$s_phone,$addr_zip,$s_addres);
	
		$data[] = implode("<td>", $arr);
		$result->MoveNext();
		$i++;
	}
	
	$list .= implode("<tr bgcolor=#FFFFFF>", $data);
	$list .= "</table>";
	echo $list;

?>

</td>
</tr>
<tr>
<td >

</td>
</tr>
</table>
</td></tr></table>

<?php foot() ?>
