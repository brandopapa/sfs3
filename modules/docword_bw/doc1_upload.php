<?php

// $Id: mstudent2.php 7546 2013-09-19 03:35:15Z hami $

// --�t�γ]�w��
include "docword_config.php";
//�޲z���ˬd
if(checkid($PHP_SELF))
	$ischecked = true;
//-----------------------------------
include "header.php";
prog(5); //�W��menu (�b docword_config.php ���]�w)

//���o�ثe�Ǧ~
$curr_year = curr_year();

//���o�ثe�Ǵ�
$curr_seme =  curr_seme();

//$newer_only=$_POST['newer_only'];

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//�L�X���Y
//head("�妸�إߤ�����");
//print_menu($menu_p);

if ($do_key=="�妸�إ߸��"){

	//���o�l���ϸ��N�������m�� �}�C
	//$zip_arr = get_zip_arr();
	$rst=-1;
	//�ثe���
	$month = date("m");
	//�ثe�Ǧ~
	//$class_year = curr_year();
	//�ثe�Ǵ�
	//$curr_seme =curr_seme();
	


	//�Ǧ~�Ǵ�
	//$seme_year_seme = sprintf("%04d", curr_year().curr_seme());

	
	//�P�_�O�_�j�~
//	if (curr_seme()==1 and $month < $SFS_SEME2)
//		$class_year++;
	//���X csv ����
	$temp_file= $temp_path."docword.csv";
	echo $temp_file;
	if ($_FILES['docdata']['size'] >0 && $_FILES['docdata']['name'] != ""){
//		copy($_FILES['docdata']['tmp_name'] , $temp_file);		
		$fd = fopen ($_FILES['docdata']['tmp_name'],"r");
		
		for ($i=0;$i<2;$i++){
		    $tt = sfs_fgetcsv ($fd, 5000, ",");
		    // �u����פJ�ɪ��ĤG�C
//		    if ($i==1)
//		      $c_year = $class_year-$tt[3]+1+$IS_JHORES; // �p��~�šA$IS_JHORES �ϤT�ؾǨ�~�ŭp�⥿�`
		}
/*
		$query = "select c_sort,c_name  from school_class where year='$class_year' and semester='$curr_seme' and c_year='$c_year' ";
		$res = $CONN->Execute($query)or die ($query) ;
		if ($res->EOF){
		  $con_temp =  "�z���פJ�ɤ� $c_year �~��(�J�Ǧ~: $tt[3])�A�|���]�w�Z�żơA�Ъ`�N�o�Ӧ~�Ŧb�Q�վǨ�O�_���ġH�Y�ݦ��Ħ~�Žd��A�ЦܱаȳB->�Ǵ���]�w�A�N�Z�żƳ]�w�n����A�A���楻�{���C<br>�������椤�_���d�߫��O���G $query";
		}
		else {
			while (!$res->EOF) {
				$temp_class_name[$res->fields[0]] = $res->fields[1];
				$res->MoveNext();
			}
*/									
			
			//�i��פJ��ƪ��ˬd			
			rewind($fd);
			$j =0;
			$doc1_id_array=array();
			$curr_class_num_array=array();
			while ($ck_tt = sfs_fgetcsv ($fd, 5000, ",")) {
				if ($j++ == 0){ //�Ĥ@�������Y�A���ˬd
                    continue ;
                }
				$doc1_id= trim($ck_tt[0]); //���o�帹				
//				$doc1_date_sign= trim($ck_tt[1]); //����ɶ�
//				$doc1_date= trim($ck_tt[2]); //�Ӥ���
//				$doc1_kind= trim($ck_tt[3]); //�������O
//				$doc1_word= trim($ck_tt[4]).trim($ck_tt[5]); //�Ӥ�r��
//				$doc1_main= trim($ck_tt[6]); //�Ӥ�K�n
//				$doc1_unit= trim($ck_tt[7]); //�Ӥ���
//				$doc1_unit_sel= trim($ck_tt[9]); //�ӿ�B��

				//�ˬd�帹�O�_�s�b
				if($doc1_id=="") {
					$msg="����r�� ����ťաA��� ".$j." ��������";
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				
				//�ˬd�帹�O�_����
				if(in_array($doc1_id,$doc1_id_array))  {
					$msg="�z�ҭn�פJ�������Ƥ�����r���G$doc1_id ����"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				
				//�S�����ƫh�[�J�帹�}�C
				$doc1_id_array[$j]=$doc1_id;
				
				
				$doc1_date_sign_s = trim ($ck_tt[1]);				

				//�ˬd������ ����ɶ�
				if($doc1_date_sign_s=="") {
					$msg="���o�帹�G$doc1_id ������S��[������ ����ɶ�]";
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				else{					
					$doc1_date_sign = DateTime::createFromFormat('Y�~M��d�� H:i', (substr($doc1_date_sign_s,0,3) + 1911).substr($doc1_date_sign_s,3));
				}
				
				$doc1_date_s = trim($ck_tt[2]);								
				//�ˬd�Ӥ���			
				if($doc1_date_s=="") {
					$msg="���o�帹�G$doc1_id ������S��[�Ӥ���]"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				else{					
					$doc1_date = DateTime::createFromFormat('Y�~MM��dd��', (substr($doc1_date_s,0,3) + 1911).substr($doc1_date_s,3));
				}
				
				$doc1_kind = trim($ck_tt[3]);				
				//�ˬd�������O
				if($doc1_kind=="") {
					$msg="���o�帹�G$doc1_id ������S��[�������O] ";
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}
				//�ˬd�Ӥ�r��
				$doc1_word=trim($ck_tt[4]).trim($ck_tt[5]);
				if($doc1_word=="") {
					$msg="���o�帹�G$doc1_id ������S��[�Ӥ�r��]"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;									
					foot();	
					exit;
					}
								
				$doc1_main = trim ($ck_tt[6]);
				//�ˬd�Ӥ�K�n
				if($doc1_main=="") {
					$msg="���o�帹�G$doc1_id ������S��[�Ӥ�K�n]"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;									
					foot();	
					exit;
					}
				
				
/*				
				$stud_birthday_array=split("[/.-]",$stud_birthday);
				if($stud_birthday_array[0]<1900 || $stud_birthday_array[0]>2030 || $stud_birthday_array[1]<1 || $stud_birthday_array[1]>12 || $stud_birthday_array[2]<1 || $stud_birthday_array[2]>31) {
					$msg="���o�帹�G$doc1_id  �m�W�G$stud_name ���ͤ�] $stud_birthday �^��g���~"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;				
					foot();
					exit;
				}
*/				
				$doc1_unit = trim ($ck_tt[7]);
				//�ˬd�Ӥ���
				if($doc1_unit=="") {
					$msg="���o�帹�G$doc1_id ������S��[�Ӥ���]"; 
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;					
					foot();
					exit;
				}				

				//�ˬd�{�s��Ʈw���O�_�Ӥ帹���w�s�b
				$sql="select doc1_id from sch_doc1 where doc1_id='$doc1_id'";
				$rs=$CONN->Execute($sql) or trigger_error($sql,256);
				$m=0;
				if(!$rs->EOF){
					$msg="���o�帹�G$doc1_id �w�ϥΡA�Ьd���I";
					$alert="<p></p><table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td align='center'><h1><img src='images/caution.png' align='middle' border=0> ĵ�i</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'> $msg </td></tr></table>";
					echo $alert;
					foot();
					exit;
				}
				
				//���S���D�F
				$check_pass="ok";
			}
			
			$doc_unit_p = doc_unit();
			while(list($tkey,$tvalue)= each ($doc_unit_p)){
				$doc_unit_p_array[$tvalue] = $tkey;
			}								
      $doc_kind_p = doc_kind();
			while(list($tkey,$tvalue)= each ($doc_kind_p)){
				 $doc1_kind_array[$tvalue] = $tkey;
			}					
						
			//�ˬd�q�L�~���A�Ϥ��}�l�g�J��Ʈw
			if($check_pass=="ok"){			
				rewind($fd);
				$i =0;
				while ($tt = sfs_fgetcsv ($fd, 5000, ",")) {
					if ($i++ == 0){ //�Ĥ@�������Y
						$ok_temp .="<font color='red'>�Ĥ@���������Y�A�Y�z���������ɪ��Ĥ@���O�����ƪ��ܡA�Ӹ�ƶ��N�L�k�פJ�I</font><br>";
						continue ;
					}
										
					//�ק諸�{���X
					$doc1_id= trim($tt[0]);
					$doc1_date_sign = (substr(trim($tt[1]),0,3) + 1911).'-'.str_replace('��','',str_replace('��','-',substr(trim($tt[1]),5))).':00';
					//$doc1_date_sign = date('Y-M-d H:i:00',strtotime($doc1_date_sign_s));//������ ����ɶ�
					$doc1_date = (substr(trim($tt[2]),0,3) + 1911).'-'.str_replace('��','',str_replace('��','-',substr(trim($tt[2]),5)));
					//$doc1_date = date('Y-M-d', strtotime($doc1_date_s)); //�Ӥ���
					$doc1_kind = $doc1_kind_array[trim($tt[3])]; //�������O
					$doc1_word = trim($tt[4]).trim($tt[5]); //�Ӥ�r��
					$doc1_main = trim($tt[6]); //�Ӥ�K�n
					$doc1_unit = trim($tt[7]); //�Ӥ���
					$doc1_unit_sel = trim($tt[9]); //�ӿ�B��
					$doc1_year_limit = 1;
					$doc1_unit_num1 = $doc_unit_p_array[$doc1_unit_sel];
					$doc1_unit_num2 = '';
//					$go=true;				
//					if($newer_only and $stud_study_year<>$class_year) $go=false;
//					if($go) {

            $sql_insert = "insert into sch_doc1 (doc1_id,doc1_year_limit,doc1_kind,doc1_date,
            doc1_date_sign,doc1_unit,doc1_word,doc1_main,doc1_unit_num1,doc1_unit_num2,teach_id,doc1_k_id,do_teacher) 
            values ('$doc1_id','$doc1_year_limit','$doc1_kind','$doc1_date','$doc1_date_sign',
            '$doc1_unit','$doc1_word','$doc1_main','$doc1_unit_num1','$doc1_unit_num2','$session_log_id','0','')";						
						$result2 = $CONN->Execute($sql_insert);
						if ($result2) {
							$ok_temp .= "$doc1_id �s�W���\!<br>";
						}	else $con_temp .= "$doc1_id �s�W��ƥ���! <br>";
//					} else $con_temp .="�帹: $doc1_id �פJ���w�T��!!<BR>";
				}
			}
		//}
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
<tr><td  nowrap>�ɮסG<input type=file name=docdata><BR><BR><font color='red'>PS.���~�פw���������ƽФŭ��жפJ�I</font></td>
<td width=65% rowspan="2" valign=top>
<?php
if ($con_temp<>''){
	echo "<b>�s�W���~<b><p>";
	echo "<font size=4>$con_temp</font>";
}
else
	echo '
<p><b><font size="4">�����Ƨ妸���ɻ���</font></b></p>
<p>1.���{���u��إߦ��夽���ơC<br>
2.�Q�� excel �Ψ�L�u����J�����ơA�s�� csv �ɡA�ëO�d�Ĥ@�C���D�ɡA�p 
<a href=docworddemo.csv target=new>�d����</a><BR>
3.����H�褸���ǡC<br>';

?>

</td>
</tr>
<tr><td nowrap><input type=submit name="do_key" value="�妸�إ߸��"></td></tr>
</form>
</table>
</td></tr></table>

<?php
echo $ok_temp;
foot();


?> 
