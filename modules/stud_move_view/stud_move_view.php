<?php

// $Id: stud_move_view.php 7712 2013-10-23 13:31:11Z smallduh $

// ���J�]�w��
include "stud_move_config.php";
// �{���ˬd
sfs_check();

$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

	$sel_year = curr_year(); //��ܾǦ~
	$sel_seme = curr_seme(); //��ܾǴ�
	$curr_seme = curr_year().curr_seme(); //�{�b�Ǧ~�Ǵ�
	
$today = date("Y-m-d") ;

//�����w����A���o�e�@��
if (!$beg_date) {
	 $beg_date =GetMonthAdd( $today ,-1) ;
	 list($ty,$tm,$td) = split('[/-]' , $beg_date) ;
	 $beg_date= "$ty-$tm-01" ;
}	
if (!$end_date) {
	 $end_date = $today  ;
}	

if ($Submit=='�ץX��J�ǥ͸��') {
	 $filename = "newstud.xls";
	 header("Content-disposition: filename=$filename");
	 header("Content-type: application/octetstream");
	 //header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	 header("Expires: 0");	  
	 
	echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; Charset=Big5\"></head><body><table border=1>\n";
	echo "<tr><td>�N��</td><td>�m�W</td><td>�ʧO</td><td>�J�Ǧ~</td><td>�Z��</td><td>�y��</td><td>�ͤ�(�褸)</td><td>�����Ҧr��</td><td>���˩m�W</td><td>���˩m�W</td><td>�l���ϸ�</td><td>�q��</td><td>��}</td><td>����p�覡</td><td>�a�}�Ƶ��A�פJ�e�n�R�������</td></tr>\n";
	
  $query = "select a.* from stud_move m, stud_base a  where a.student_sn=m.student_sn and m.move_kind in (2,3,4) and m.move_date>='$beg_date' and m.move_date<='$end_date'  and a.stud_study_cond in (0,5) order by a.curr_class_num ";
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
		
		$addr_all = $result->fields[stud_addr_1];

		$query2 = "select fath_name,moth_name from stud_domicile where stud_id ='$stud_id'";
		$result2 = $CONN->Execute($query2)or die ($query2) ;
		$fath_name = $result2->fields[fath_name];
		$moth_name = $result2->fields[moth_name];

		echo sprintf("<tr><td>=T(\"%s\")</td><td>%s</td><td>%d</td><td>%s</td>",$stud_id,$stud_name,$stud_sex,substr($stud_id,0,2));
		
		echo sprintf("<td>%d</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",substr($curr_class_num,1,2),substr($curr_class_num,-2),$stud_birthday,$stud_person_id,$fath_name,$moth_name,$addr_zip); 

		echo sprintf("<td>=T(\"%s\")</td><td>%s</td><td>=T(\"%s\")</td><td>%s</td>",$s_home_phone,stripslashes($s_addres),$s_offical_phone,stripslashes($addr_all)); 


		echo"</tr>\n";
		$result->MoveNext();

	}
	echo "</table></body></html>";

	 exit ;
	 
}	
//���o���---------------------------------------------------------------------------
    $class_list_p = class_base($curr_seme);
		$query = "select a.*,b.stud_name , b.curr_class_num from stud_move a ,stud_base b where a.student_sn=b.student_sn and a.move_date>='$beg_date' and a.move_date<='$end_date'  order by a.move_date desc,a.stud_id desc ";
		$result = $CONN->Execute($query) or die ($query);
		while(!$result->EOF) {
	    $move_kind= $result->fields["move_kind"];
			$stud_name = $result->fields["stud_name"];
			$move_date = $result->fields["move_date"];
			$stud_id = $result->fields["stud_id"];
			$curr_class_num = $result->fields["curr_class_num"];
			
			unset($tmp_array) ;
			$tmp_array[stud_id]= $stud_id ;
			$tmp_array[stud_name]= $stud_name ;
			$tmp_array[move_date]= $move_date ;
			$tmp_array[class_num]= substr($curr_class_num,0,3) ;
			//$tmp_array[class_num]=$class_list_p[substr($curr_class_num,0,3)] ; 
			$tmp_array[class_seat_num]= substr($curr_class_num,3,2) ;       
			//��J
			if (in_array( $move_kind ,array(2,3,4))) {
				$in_array[] =$tmp_array ; 
		  }	
			//�եX	
			if (in_array( $move_kind ,array(6,7,8,11,12))) {
				$out_array[] =$tmp_array ; 

		  } 

			$result->moveNext();
		}
		
//---------------------------------------------------------------------------
head("��J�եX�W�U�d��");
print_menu($menu_p);
//echo $beg_date ;

$template_dir = $SFS_PATH."/".get_store_path()."/templates";
// �ϥ� smarty tag
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";
//$smarty->debugging = true;


$smarty->assign("beg_date",$beg_date);
$smarty->assign("end_date",$end_date);
$smarty->assign("arr_in",$in_array); //�դJ
$smarty->assign("arr_out",$out_array);//��X


$smarty->assign("template_dir",$template_dir);

$smarty->display("$template_dir/main.htm");

foot();

?>