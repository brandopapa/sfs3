<?php

// $Id: newstud_input.php 8118 2014-09-15 05:35:09Z hami $

/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";
$class_year_b=$_REQUEST['class_year_b'];
if (empty($class_year_b)) $class_year_b=$IS_JHORES+1;

//�ϥΪ̻{��
sfs_check();

//�{�����Y
head("�s�ͽs�Z");
print_menu($menu_p,"class_year_b=$class_year_b");

//�]�w�D������ܰϪ��I���C��
echo "
<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc>
<tr>
<td bgcolor='#FFFFFF'>";

//�������e�иm�󦹳B
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
if ($_POST['act']=="�妸�إ߸��"){
    $main=import($_FILES['newstuddata']['tmp_name'],$_FILES['newstuddata']['name'],$_FILES['newstuddata']['size']);
}else{
	$main=main_form();
}
echo $main;

//�D�n���
function main_form(){
  global $CONN,$class_year,$IS_JHORES;
  if ($IS_JHORES == 0) { $tmpsel1=' selected'; $tmpsel2=''; } else { $tmpsel1=''; $tmpsel2=' selected'; }
	$main="
	<table border='0' cellspacing='0' cellpadding='0' >
	<tr><td valign=top>
		<table cellspacing='1' cellpadding='10' class=main_body >
		<form action ='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data' method=post>
		<tr><td  nowrap valign='top' bgcolor='#E1ECFF'>
		<p>�Ы��y�s���z��ܶפJ�ɮרӷ��G</p>
		<select name='class_year_b'>";
	while (list($k,$v)=each($class_year)) {
		$checked=($IS_JHORES+1==$k)?"selected":"";
		$main.="<option value='$k' $checked>$v</option>\n";
	}
	$main.="</select>
        <input type=file name='newstuddata'>
		<p><input type=submit name='act' value='�妸�إ߸��'></p>
		</td>
		<td valign='top' bgcolor='#FFFFFF'>
		<p><b><font size='4'>�s�͸�Ƨ妸���ɻ���</font></b></p>
		<ol>
		<li>���{�����ѥ����s�Z�e���s�Ͱ򥻸�ƶפJ�A�Y�O�w�s�Z�������ǥ͸�ƽХ�<a href=\"../create_data/\">�u�פJ��ơv</a>�Ҳնi��B�z�C</li>
		<li>�פJ���s�Ͱ򥻸��csv�ɮ榡�A�аѦ�<a href='newstud.csv'>�ynewstud.csv�z</a>�C</li>
		<li>�פJ����Ш�y�s�ͺ޲z�z�i���������ˬd�C</li>
		<li>�u�ꤤ�{�ɯZ�šv�B�u�ꤤ�{�ɮy���v��O������{�ɽs�Z�פJ�ΡA�Y�����H�ǰȨt�ζi���{�ɽs�Z�A�h�Яd�աC</li>
		</ol>
		</td>
		</tr>
		</table>
	</form>
	</td></tr></table>
	";
	return $main;
}


//�פJ���
function import($newstuddata,$newstuddata_name,$newstuddata_size){
	global $temp_path,$CONN,$ok_temp,$con_temp;
	
	//�ܼƩw�q �J�Ǧ~,�®զW,�����Ҧr��,�m�W,�^��m�W,�ʧO(�k��:1�A�k��:2),�q��,�ͤ�]�褸�^,�a���m�W,���y��},��Z��,���y�E�J���,�p����},�p�����,�{�ɯZ��,�{�ɮy��
	$tt_test[0][0]="�J�Ǧ~"; $tt_test[0][1]="stud_study_year";
	$tt_test[1][0]="�®զW"; $tt_test[1][1]="old_school";
	$tt_test[2][0]="�����Ҧr��"; $tt_test[2][1]="stud_person_id";
	$tt_test[3][0]="�m�W"; $tt_test[3][1]="stud_name";
	$tt_test[4][0]="�^��m�W"; $tt_test[4][1]="stud_name_eng";
	$tt_test[5][0]="�ʧO(�k��:1�A�k��:2)"; $tt_test[5][1]="stud_sex";
	$tt_test[6][0]="�q��"; $tt_test[6][1]="stud_tel_1";
	$tt_test[7][0]="�ͤ�]�褸�^"; $tt_test[7][1]="stud_birthday";
	$tt_test[8][0]="�a���m�W"; $tt_test[8][1]="guardian_name";
	$tt_test[9][0]="���y��}"; $tt_test[9][1]="stud_address";
	$tt_test[10][0]="��Z��"; $tt_test[10][1]="old_class";
	$tt_test[11][0]="���y�E�J���"; $tt_test[11][1]="addr_move_in";
	$tt_test[12][0]="�p����}"; $tt_test[12][1]="stud_addr_2";
	$tt_test[13][0]="�l���ϸ�"; $tt_test[13][1]="addr_zip";
	$tt_test[14][0]="�p�����"; $tt_test[14][1]="stud_tel_3";
	$tt_test[15][0]="�{�ɯZ��"; $tt_test[15][1]="temp_class";
	$tt_test[16][0]="�{�ɮy��"; $tt_test[16][1]="temp_site";
	
	$tt_test[17][0]="�����Ҧr��"; $tt_test[17][1]="stud_person_id";
	$tt_test[18][0]="��}"; $tt_test[18][1]="stud_address";
	$tt_test[19][0]="��p�Z��"; $tt_test[19][1]="old_class";
	$tt_test[20][0]="�ꤤ�{�ɯZ��"; $tt_test[20][1]="temp_class";
	$tt_test[21][0]="�ꤤ�{�ɮy��"; $tt_test[21][1]="temp_site";
	
	//echo $_FILES['newstuddata']['tmp_name'].$_FILES['newstuddata']['name'].$_FILES['newstuddata']['size'];
	if ($_FILES['newstuddata']['size'] >0 && $_FILES['newstuddata']['name'] != ""){
		$path_str = "temp/newstud";
		$UPLOAD_PATH=set_upload_path($path_str);
		$temp_path = $UPLOAD_PATH;
		$temp_file= $temp_path."newstud.csv";

		copy($_FILES['newstuddata']['tmp_name'] , $temp_file);
		$fd = fopen ($temp_file,"r");
		//$fd = fopen ($_FILES['newstuddata']['tmp_name'],"r");
		rewind($fd);
		$i=0;
		while ($tt = sfs_fgetcsv ($fd, 2000, ",")) {
			if ($i++ == 0)	continue ;
			$stud_study_year = trim($tt[0]);
			if ($stud_study_year && $i>1) break;
		}
		$query="select max(temp_id) from new_stud where stud_study_year='$stud_study_year'";
		$res=$CONN->Execute($query);
		$temp_id=$res->fields[0];
		$start_id=intval(substr($temp_id,1));
		rewind($fd);
		$fd = fopen ($temp_file,"r");
		$i =0;
		$class_year = $_POST['class_year_b'];
		while ($tt = sfs_fgetcsv ($fd, 2000, ",")) {
			//�Ĥ@�������Y , ���R��� �J�Ǧ~,�®զW,�����Ҧr��,�m�W,�^��m�W,�ʧO(�k��:1�A�k��:2),�q��,�ͤ�]�褸�^,�a���m�W,���y��},��Z��,���y�E�J���,�p����},�p�����,�{�ɯZ��,�{�ɮy��
			if ($i++ == 0){ 
			$ok_temp .="<font color='red'>�Ĥ@���������Y�A�Y�z���s�Ͱ򥻸���ɪ��Ĥ@���O�s�͸�ƪ��ܡA�Ӧ�ǥͱN�L�k�פJ�I</font><br>";
			 for ($ii=0;$ii<=count($tt);$ii++) {
			 	$chk=0;
			   for ($jj=0;$jj<=count($tt_test);$jj++) {
			    if (trim($tt[$ii])==$tt_test[$jj][0]) {
			     $chk=1;
			     $T[$ii]=$tt_test[$jj][1]; //$T[] ���ܼƦW�� , �p $T[0]='stud_study_year'; �ϥήɤ��۹��� $$T[0]=trim(addslashes($tt[0]))
			    } // end if
			   } // end for $jj
			  if ($chk==0) {
			   echo "���W��[".$tt[$ii]."]�L�k�ѧO , �Э��s�׭q!";
			   exit();
			  } // end if $chk==0
			 }	// end for $ii==0 
			 //���R����, ���L, �q $i==1 �}�l
				continue ;
			}
			

			//�N������쪺��ƶ�J���T�ܼƤ�
			for ($ii=0;$ii<=count($tt);$ii++) {
			  $$T[$ii]=trim(addslashes($tt[$ii]));
			  $$T[$ii]=preg_replace('/,/',' ',$tt[$ii]);
			}
			
			/***
			$stud_study_year = trim($tt[0]);  								//�J�Ǧ~
			$old_school = trim (addslashes($tt[1])); 					//�¾Ǯ�
			$stud_person_id = trim($tt[2]); 									//�����Ҧr��
			$stud_name = trim(addslashes($tt[3]));						//�m�W
			$stud_name_eng = trim(addslashes($tt[4]));				//�^��m�W
			$stud_sex = trim($tt[5]);													//�ʧO
			
			$stud_tel_1 = trim($tt[6]);												//�q��
			$stud_birthday = trim($tt[7]);										//�ͤ�
			$guardian_name = trim(addslashes($tt[8]));				//�a���m�W
			$stud_address = trim(addslashes($tt[9]));					//���y�a�}
			$old_class = trim(addslashes($tt[10]));						//�¯Z��
			$addr_move_in=trim($tt[11]);						//���y�E�J���
			$stud_addr_2= trim(addslashes($tt[12]));			//�p����}
			$addr_zip = trim($tt[13]);												//�l���ϸ�
			$stud_tel_3= trim($tt[14]);							//�p�����
			$temp_class = trim($tt[15]);											//�{�ɯZ��
			$temp_site = ($temp_class)?trim($tt[16]):0;				//�{�ɮy��
			***/
			
			
			if ($temp_class) $temp_class = $class_year.sprintf("%02d",$temp_class);
	    //if ($temp=="" or $temp==0) $temp_site=0;
	    if ($temp_class=="" or $temp_class==0) $temp_site=0;
			
			
			$id="A".sprintf("%04d",$start_id+$i-1);
			
			//�ͤ�B�z
			$sb=explode("/",$stud_birthday);
			if (count($sb)<3) {
				$sb=explode("-",$stud_birthday);
				$stud_birthday=$sb[0]."/".$sb[1]."/".$sb[2];
			}
			//���y�E�J���
			if ($addr_move_in!="") {
			  $sb=explode("/",$addr_move_in);
			  if (count($sb)<3) {
				  $sb=explode("-",$addr_move_in);
				  $addr_move_in=$sb[0]."/".$sb[1]."/".$sb[2];
			  }
		  }
			
			//�ˬd�ӵ���ƬO�_�s�b
			$sql_select = "select newstud_sn from new_stud where stud_study_year='$stud_study_year' and old_school='$old_school' and stud_person_id='$stud_person_id' and stud_name='$stud_name'";
			$result_s = $CONN->Execute($sql_select) or die($sql_select);
			$newstud_sn=$result_s->fields['newstud_sn'];
			if ($newstud_sn!="") { 
				$ok_temp .= "$old_school -- $stud_name �w�g�s�b!<br>"; 
				continue;
			} elseif (empty($stud_name))
				continue;
			else 
				$sql = "INSERT INTO new_stud (stud_study_year,old_school,stud_person_id,stud_name,stud_sex,stud_tel_1,stud_birthday,guardian_name,stud_address,sure_study,class_year,temp_id,old_class,addr_zip,temp_class,temp_site,stud_name_eng,addr_move_in,stud_addr_2,stud_tel_3) values ('$stud_study_year','$old_school','$stud_person_id','$stud_name','$stud_sex','$stud_tel_1','$stud_birthday','$guardian_name','$stud_address','1','$class_year','$id','$old_class','$addr_zip','$temp_class','$temp_site','$stud_name_eng','$addr_move_in','$stud_addr_2','$stud_tel_3')";
			$result = $CONN->Execute($sql) or die($sql);
			if ($result) {
				$stud_name=stripslashes($stud_name);
				$ok_temp .= "$old_school -- $stud_name �s�W���\!<br>";
			} else
				$con_temp = "��Ʒs�W����!$sql_insert<br>";
		}
	} else {
		echo "�ɮ׮榡���~!";
		exit;
	}
    unlink($temp_file);
}

//�����D������ܰ�
echo $ok_temp.$con_temp;
echo "</td>";
echo "</tr>";
echo "</table>";

//�{���ɧ�
foot();
?>