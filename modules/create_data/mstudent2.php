<?php

// $Id: mstudent2.php 8525 2015-09-14 02:09:49Z smallduh $

// --�t�γ]�w��
include "create_data_config.php";
//--�{�� session
sfs_check();
//���o�ثe�Ǧ~
$curr_year = curr_year();

//���o�ثe�Ǵ�
$curr_seme =  curr_seme();

$newer_only=$_POST['newer_only'];

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//�L�X���Y
head("�妸�إ߾ǥ͸��");
print_menu($menu_p);

if ($do_key=="�妸�إ߸��")
{

	//���o�l���ϸ��N�������m�� �}�C
	$zip_arr = get_zip_arr();
	$rst=-1;
	//�ثe���
	$month = date("m");
	//�ثe�Ǧ~
	$class_year = curr_year();
	//�ثe�Ǵ�
	$curr_seme =curr_seme();
	


	//�Ǧ~�Ǵ�
	$seme_year_seme = sprintf("%04d", curr_year().curr_seme());

	
	//�P�_�O�_�j�~
//	if (curr_seme()==1 and $month < $SFS_SEME2)
//		$class_year++;
	//���X csv ����
	$temp_file= $temp_path."stud.csv";
	if ($_FILES['userdata']['size'] >0 && $_FILES['userdata']['name'] != ""){
//		copy($_FILES['userdata']['tmp_name'] , $temp_file);		
		$fd = fopen ($_FILES['userdata']['tmp_name'],"r");
  $tt_analyse = sfs_fgetcsv ($fd, 5000, ",");
			//�i����Y�����R
			//�Ǹ�,�m�W,�^��m�W,�ʧO,�J�Ǧ~,�Z��,�y��,�ͤ�(�褸),�����Ҧr��,���˩m�W,���˩m�W,�l���ϸ�,�q��,��}(���t�����m��),����p���覡,�J�ǫe��p�W��,���y�E�J���(�褸),�ǥͦ�ʹq��,�s���a�},���@�H,���@�H��ʹq��
	//�ܼƩw�q 
	$tt_test[0]="�Ǹ�";
	$tt_test[1]="�m�W"; 
	$tt_test[2]="�^��m�W";
	$tt_test[3]="�ʧO";
	$tt_test[4]="�J�Ǧ~";
	$tt_test[5]="�Z��";
	$tt_test[6]="�y��";
	$tt_test[7]="�ͤ�(�褸)"; 
	$tt_test[8]="�����Ҧr��";
	$tt_test[9]="���˩m�W";
	$tt_test[10]="���˩m�W";
	$tt_test[11]="�l���ϸ�";
	$tt_test[12]="�q��"; 
	$tt_test[13]="��}(���t����?��)";
	$tt_test[14]="����p�覡"; 
	$tt_test[15]="�J�ǫe��p�W��"; 
	$tt_test[16]="���y�E�J���(�褸)";	
	$tt_test[17]="�ǥͦ�ʹq��"; 
	$tt_test[18]="�s���a�}"; 
	$tt_test[19]="���@�H"; 
	$tt_test[20]="���@�H��ʹq��"; 
	//�w�]�u�ˬd�O���s�b�� 21 �����, ����C����쪺�Ǹ�( $tt_test[$i) , $i �Y���Ǹ�)�O�U, ����Ū����ƫ�, �A�̹�ڸ�Ƥ��e�ɥ��Ǹ�
	$trans_field=array();
	for ($i=0;$i<count($tt_test);$i++) { $trans_field[$i]=-1; }
	foreach ($tt_analyse as $user_field=>$v) {
	  foreach ($tt_test as $sql_field=>$V) {
	   if ($v==$V) {
	   	$trans_field[$sql_field]=$user_field;   //�ĴX�檺���, �N�ӥ������ΨϥΪ̿�J���ĴX����	    
	   }
	  }
	} 		
	
	//���Y��Ƥ��R����, �y����ocsv����ƫ�, �Q�� trand_to_right_field �禡�ɥ�
		
		rewind($fd);
		for ($i=0;$i<2;$i++){
		    $tt_org = sfs_fgetcsv ($fd, 5000, ",");
		    // �u����פJ�ɪ��ĤG�C
		    if ($i==1) {
		      $tt=trans_to_right_field($tt_org);
		      $c_year = $class_year-$tt[4]+1+$IS_JHORES; // �p��~�šA$IS_JHORES �ϤT�ؾǨ�~�ŭp�⥿�`
		      
		    }
		}
		$query = "select c_sort,c_name  from school_class where year='$class_year' and semester='$curr_seme' and c_year='$c_year' ";
		$res = $CONN->Execute($query)or die ($query) ;
		if ($res->EOF){
		  $con_temp =  "�z���פJ�ɤ� $c_year �~��(�J�Ǧ~: $tt[4])�A�|���]�w�Z�żơA�Ъ`�N�o�Ӧ~�Ŧb�Q�վǨ�O�_���ġH�Y�ݦ��Ħ~�Žd��A�ЦܱаȳB->�Ǵ���]�w�A�N�Z�żƳ]�w�n����A�A���楻�{���C<br>�������椤�_���d�߫��O���G $query";
		}
		else {
			while (!$res->EOF) {
				$temp_class_name[$res->fields[0]] = $res->fields[1];
				$res->MoveNext();
			}
			
			//�i��פJ��ƪ��ˬd			
			rewind($fd);
			$j =0;
			$stud_id_array=array();
			$curr_class_num_array=array();
			while ($ck_tt_org = sfs_fgetcsv ($fd, 5000, ",")) {
				if ($j++ == 0){ //�Ĥ@�������Y�A���ˬd
                    continue ;
                }
				/*  ��Ӫ��{���X
				if (substr($ck_tt[0],0,1)==0)
					$stud_id= substr($ck_tt[0],1);
				else
					$stud_id= trim($ck_tt[0]);
				*/
				//�ɥ����Ǹ� 
				$ck_tt=trans_to_right_field($ck_tt_org);
				//�ק諸�{���X
				$stud_id= trim($ck_tt[0]);

				
				$rollin_year=trim($ck_tt[4]);

				//�ˬd�Ǹ��O�_�s�b
				if($stud_id=="") {
					$msg="�Ǹ��]�ǥͥN���^����ťաA��� ".$j." ���ǥ͸��";
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				
				//�ˬd�Ǹ��O�_����
				if(in_array($stud_id,$stud_id_array))  {
					$msg="�z�ҭn�פJ���ǥ͸�Ƥ��Ǹ��G$stud_id ����"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				
				//�S�����ƫh�[�J�Ǹ��}�C
				$stud_id_array[$j]=$stud_id;
				
				
				$stud_name = trim (addslashes($ck_tt[1]));
				//�ˬd�m�W
				if($stud_name=="") {
					$msg="�Ǹ��G$stud_id ���ǥͨS���m�W";
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				
				$stud_sex = trim($ck_tt[3]);				
				//�ˬd�ʧO				
				if($stud_sex!=1 && $stud_sex!=2) {
					$msg="�Ǹ��G$stud_id  �m�W�G$stud_name ���ǥͩʧO���~"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				
				$stud_study_year = chop ($ck_tt[4]);				
				// �ޤJ $IS_JHORES
				$year = $class_year-$stud_study_year+1+$IS_JHORES;
				$ck_query = "select c_sort,c_name  from school_class where year='$class_year' and semester='$curr_seme' and c_year='$year' and enable=1";
				$ck_res = $CONN->Execute($ck_query)or die ($ck_query) ;
				//�ˬd�J�Ǧ~��
				if ($ck_res->EOF) {
					$msg="�Ǹ��G$stud_id  �m�W�G$stud_name ���J�Ǧ~�ס] $stud_study_year �^��g���~�ίZ�š] $year �~�š^ �|���]�w";
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				$k=0;
				while(!$ck_res->EOF){
					$c_sort[$k]=$ck_res->fields['c_sort'];					
					$ck_res->MoveNext();
					$k++;
				}
				//�ˬd�Z��
				$class=trim($ck_tt[5]);
				if(!in_array($class,$c_sort)){
					$msg="�Ǹ��G$stud_id  �m�W�G$stud_name ���ǥͯZ�š] $year �~ $class �Z �^��g���~�ίZ�ũ|���]�w"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;									
					foot();	
					exit;
					}
								
				if($year==0) $class_name= sprintf("%03d",$ck_tt[5]);
				else $class_name = $year*100+$ck_tt[5];
				$class_name_id = $ck_tt[5];
				if($year==0) $curr_class_num=sprintf("%03d%02d",$ck_tt[5],$ck_tt[6]);
				else $curr_class_num= $class_name*100+$ck_tt[6];
				//�ˬd�y���O�_����			
				if(in_array($curr_class_num,$curr_class_num_array))  {
					$msg= "�z�ҭn�פJ���ǥ͸�Ƥ��y���] $year �~ $class �Z ".substr($curr_class_num,-1,2)." �� �^ ����"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				
				//�S�����ƫh�[�J�y���}�C
				$curr_class_num_array[$j]=$curr_class_num;
				
				$stud_birthday = trim ($ck_tt[7]);
				//�ˬd�ͤ�
				
				//$stud_birthday_array=explode("/",$stud_birthday);
				$stud_birthday_array=split("[/.-]",$stud_birthday);
				if($stud_birthday_array[0]<1900 || $stud_birthday_array[0]>2030 || $stud_birthday_array[1]<1 || $stud_birthday_array[1]>12 || $stud_birthday_array[2]<1 || $stud_birthday_array[2]>31) {
					$msg="�Ǹ��G$stud_id  �m�W�G$stud_name ���ͤ�] $stud_birthday �^��g���~"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;				
					foot();
					exit;
				}
				
				$stud_person_id = trim ($ck_tt[8]);
				//�ˬd������
				if($stud_person_id=="") {
					$msg="�����Ҥ���ťաA��� ".($j-1)." ���ǥ͸��";
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}				
				
				//�ˬd�����ҬO�_����
				if(in_array($stud_person_id,$stud_person_id_array))  {
					$msg="�z�ҭn�פJ���ǥ͸�Ƥ������Ҹ��G$stud_person_id ����"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;
					foot();
					exit;
				}
				
				//�S�����ƫh�[�J�Ǹ��}�C
				$stud_person_id_array[$j]=$stud_person_id;
				
				//�ˬd�{�s��Ʈw���O�_�Ө����ҬO�_����L���Ǹ��A�άO�ӾǸ����w�s����L��������
				$sql="select stud_id from stud_base where stud_person_id='$stud_person_id' and stud_study_cond='0' ";
				$rs=$CONN->Execute($sql) or trigger_error($sql,256);
				$m=0;
				while(!$rs->EOF){
					$old_id[$m]=$rs->fields['stud_id'];
					if($stud_id!=$old_id[$m]) {					
						$msg="�Ǹ��G$stud_id  �m�W�G$stud_name �������Ҧr���w�Q�Ǹ��G ".$old_id[$m]." �ϥΡA�Ьd���I";
						$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
						echo $alert;
						foot();
						exit;
					}
					$rs->MoveNext();
					$m++;
				}
				
				//���S���D�F
				$check_pass="ok";
			}
			//�ˬd�q�L�~���A�Ϥ��}�l�g�J��Ʈw
			if($check_pass=="ok"){			
				rewind($fd);
				$i =0;
				while ($tt_org = sfs_fgetcsv ($fd, 5000, ",")) {
					if ($i++ == 0){ //�Ĥ@�������Y
						$ok_temp .="<font color='red'>�Ĥ@���������Y�A�Y�z���ǥͰ򥻸���ɪ��Ĥ@���O�ǥ͸�ƪ��ܡA�Ӧ�ǥͱN�L�k�פJ�I</font><br>";
						continue ;
					}
					/*  ��Ӫ��{���X
					if (substr($tt[0],0,1)==0)
						$stud_id= substr($tt[0],1);
					else
						$stud_id= trim($tt[0]);
					*/
					//�ɥ����Ǹ�
					$tt=trans_to_right_field($tt_org);
					//�ק諸�{���X
					$stud_id= trim($tt[0]);
					$stud_name = trim (addslashes($tt[1]));
					
					$stud_name_eng = trim($tt[2]);
					
					//�[�J�N���Ϊťմ������\��
					$stud_name=str_replace('�@','',$stud_name); 
					
					$stud_sex = trim($tt[3]);
					$stud_study_year = chop ($tt[4]);
					
					$go=true;				
					if($newer_only and $stud_study_year<>$class_year) $go=false;
					if($go) {
				
						// �ޤJ $IS_JHORES
						$year = $class_year-$stud_study_year+1+$IS_JHORES;
						//���X�Z���~�Ŭ�0
						if($year==0) $class= sprintf("%03d",$tt[5]);
						else $class = $year*100+$tt[5];
						$class_name_id = $tt[5];
						if($year==0) $curr_class_num=sprintf("%03d%02d",$tt[5],$tt[6]);
						else $curr_class_num= $class*100+$tt[6];
						$seme_num = sprintf("%02d",$tt[6]);
						$stud_birthday = trim ($tt[7]);
						$stud_person_id = trim ($tt[8]);
						$fath_name = trim (addslashes($tt[9]));
						$moth_name = trim (addslashes($tt[10]));

						$stud_tel_1 = trim ($tt[12]);
						$stud_tel_2 = trim ($tt[14]);
						$stud_mschool_name = trim ($tt[15]);
						$zip_id = trim($tt[11]);
						//�Y��}��,�ϥΥ��μƦr,�N���ഫ���b��,�H�Q��� 2015.09.14 �ק� by smallduh.
						$search  = array('��', '��', '��', '��', '��','��', '��', '��', '��', '��');
						$replace = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
						$tt[13]=str_replace($search, $replace, $tt[13]);
						$addr = $zip_arr[$tt[11]].trim($tt[13]);
						
						//20120825�s�W���   ���y�E�J����B�ǥͦ�ʹq�ܡB�s���a�}�B���@�H�B���@�H��ʹq��
						$addr_move_in=trim($tt[16]);
						$stud_tel_3 = trim ($tt[17]);
						$stud_addr_2 = trim(addslashes($tt[18]));
						$stud_addr_2 = $stud_addr_2?$stud_addr_2:addslashes($addr);
						$guardian_name=trim($tt[19]);
						$guardian_hand_phone=trim($tt[20]);							
						$edu_key =  hash('sha256', strtoupper($stud_person_id));
						//��Ѧa�}
						$addr_arr = change_addr($addr);
						//�[�W����r���A�קK�\�\�\���D  �p�G���\���A�|�X�{�ýX 2015.09.14 �ק� by smallduh.
						foreach ($addr_arr as $k=>$v) {
						  $addr_arr[$k]=addslashes($v);
						}
						$addr=addslashes($addr);
						$stud_kind =',0,';
						//�ŭ�NULL���P�_�A�ץ���keyin���y�E�J����ɡA�򥻸�ơ]stud_list.php�^�E�J���-1911-00-00�����m�C�ק� by chunkai 102.9.6
						$sql_insert1 = "replace into stud_base (stud_id,stud_name,stud_name_eng,stud_person_id,stud_birthday,stud_sex,stud_study_cond,
						curr_class_num,stud_study_year,stud_addr_a,stud_addr_b,stud_addr_c,stud_addr_d,stud_addr_e,stud_addr_f,
						stud_addr_g,stud_addr_h,stud_addr_i,stud_addr_j,stud_addr_k,stud_addr_l,stud_addr_m,stud_addr_1,stud_addr_2,
						stud_tel_1,stud_tel_2,stud_kind,stud_mschool_name,addr_zip,enroll_school,addr_move_in,stud_tel_3,edu_key) 
						values ('$stud_id','$stud_name ','$stud_name_eng','$stud_person_id','$stud_birthday','$stud_sex','0','$curr_class_num','$stud_study_year',
						'$addr_arr[0]','$addr_arr[1]','$addr_arr[2]','$addr_arr[3]','$addr_arr[4]','$addr_arr[5]','$addr_arr[6]','$addr_arr[7]',
						'$addr_arr[8]','$addr_arr[9]','$addr_arr[10]','$addr_arr[11]','$addr_arr[12]','$addr','$stud_addr_2','$stud_tel_1',
						'$stud_tel_2','$stud_kind','$stud_mschool_name','$zip_id','$school_long_name','$addr_move_in','$stud_tel_3','$edu_key')";
						
						$sql_insert2 = "replace into stud_base (stud_id,stud_name,stud_name_eng,stud_person_id,stud_birthday,stud_sex,stud_study_cond,
						curr_class_num,stud_study_year,stud_addr_a,stud_addr_b,stud_addr_c,stud_addr_d,stud_addr_e,stud_addr_f,
						stud_addr_g,stud_addr_h,stud_addr_i,stud_addr_j,stud_addr_k,stud_addr_l,stud_addr_m,stud_addr_1,stud_addr_2,
						stud_tel_1,stud_tel_2,stud_kind,stud_mschool_name,addr_zip,enroll_school,addr_move_in,stud_tel_3,edu_key)
						 values ('$stud_id','$stud_name ','$stud_name_eng','$stud_person_id','$stud_birthday','$stud_sex','0','$curr_class_num','$stud_study_year',
						'$addr_arr[0]','$addr_arr[1]','$addr_arr[2]','$addr_arr[3]','$addr_arr[4]','$addr_arr[5]','$addr_arr[6]','$addr_arr[7]',
						'$addr_arr[8]','$addr_arr[9]','$addr_arr[10]','$addr_arr[11]','$addr_arr[12]','$addr','$stud_addr_2','$stud_tel_1',
						'$stud_tel_2','$stud_kind','$stud_mschool_name','$zip_id','$school_long_name',NULL,'$stud_tel_3','$edu_key')";
						($addr_move_in == '')?$sql_insert=$sql_insert2:$sql_insert=$sql_insert1;
				//	echo $sql_insert."<BR>";

						$result2 = $CONN->Execute($sql_insert);
						if ($result2) {
							$stud_name=stripslashes($stud_name);
							$ok_temp .= "$stud_id -- $stud_name �s�W���\!<br>";
							
							$guardian_name = $guardian_name?$guardian_name:$fath_name;
							$guardian_name = $guardian_name?$guardian_name:$moth_name;
							
							//���o student_sn
							$query = "select student_sn from stud_base where stud_id='$stud_id' and stud_study_year=$stud_study_year";
							$resss = $CONN->Execute($query);
							$student_sn= $resss->fields[0];

							//�[�J�a�x���p���
							$query = "replace into stud_domicile (stud_id,fath_name,moth_name,guardian_name,guardian_hand_phone,student_sn) values('$stud_id','$fath_name','$moth_name','$guardian_name','$guardian_hand_phone','$student_sn')";
							if (!$CONN->Execute($query))
								$con_temp .= "$stud_id - $stud_name �s�W�a�x���p��ƥ���! <br>";
							//�[�J�Ǧ~�Ǵ����
							$query = "replace into  stud_seme (seme_year_seme,stud_id,seme_class,seme_num,seme_class_name,student_sn) values('$seme_year_seme','$stud_id','$class','$seme_num','$temp_class_name[$class_name_id]','$student_sn')";
							if (!$CONN->Execute($query))
								$con_temp .= "$stud_id - $stud_name �s�W�Ǧ~��ƥ���! <br>";
					//	echo $query."<BR>";

						}	else $con_temp .= "$stud_id - $stud_name �s�W�򥻸�ƥ���! <br>";
					} else $con_temp .="�Ǹ�: $stud_id - $stud_name �J�Ǧ~( $rollin_year )�פJ���w�T��!!<BR>";
				}
			}
		}
	}
	else
	{
		echo "�ɮ׮榡���~!";
		exit;
	}
	unlink($temp_file);
	
}
?>

<table border="0" width="100%" cellspacing="0" cellpadding="0" >
<tr><td valign=top bgcolor="#CCCCCC">
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >

<form action ="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method=post>
<tr><td  nowrap>�ɮסG<input type=file name=userdata><BR><BR><font color='red'>PS.���~�פw�����ǥ͸�ƽФŭ��жפJ�I</font></td>
<td width=65% rowspan="2" valign=top>
<?php
if ($con_temp<>''){
	echo "<b>�s�W���~<b><p>";
	echo "<font size=4>$con_temp</font>";
}
else
	echo '
<p><b><font size="4">�ǥ͸�Ƨ妸���ɻ���</font></b></p>
<p>1.���{���u��إ߾ǥͰ򥻸�ơA��L�p�ǥͤ�f��Ƶ��A�ݦܾ��y�޲z�{���إߡC<br>
2.�Q�� excel �Ψ�L�u����J�ǥ͸�ơA�s�� csv �ɡA�ëO�d�Ĥ@�C���D�ɡA�p 
<a href=studdemo.csv target=new>�d����</a><BR>
3.���d���ɬ��U�ת����d�t�ζץX���ǥ͸���� Sheet1.xls ����s�� .csv �榡�ɡC<br>
4.�X�ͤ���H�褸���ǡC<br>
5.�a�}����:���U�C�覡�ƦC�A�{���~�i���`��ѡC<br>
<span style="background-color: #FFFF00"><font color="#0000FF">��(��)</font>�m(���)<font color="#0000FF">��(��)</font>�F<font color="#0000FF">��(��)</font>�q<font color="#0000FF">��</font>��<font color="#0000FF">��</font><font color="#000000">��</font><font color="#0000FF">��</font>��</span></p>
��:
  <li>�x�����~�H�m���s��11�F���s��34��6��</li>
  <li>�x�����~�H�m�j�P���ҦZ��9��</
';

?>

</td>

</tr>
<tr><td nowrap><input type='checkbox' name='newer_only' value='checked' checked>���w�u��פJ���Ǧ~�׷s�� ( �J�Ǧ~�� <?php echo $curr_year; ?> )<br><br>
<input type=submit name="do_key" value="�妸�إ߸��"></td></tr>

</form>
</table>
</td></tr></table>

<?php
echo $ok_temp;
foot();

//�N�����춶�Ǿɥ����t�X��Ʈw�����
function trans_to_right_field($tt_org) {
  global $trans_field,$tt_test;
  
  $tt=array();
  for ($i=0;$i<count($tt_test);$i++) {  	
  	if ($trans_field[$i]>-1) {
  		$tt[$i]=$tt_org[$trans_field[$i]];
    } else {
  	  $tt[$i]=""; 
    }
  } // end for
  
  return $tt;
  
}
?> 
