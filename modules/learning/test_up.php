<?php

include "config.php";
session_start();

//���Юv�i�J
if($_SESSION['session_who']=='�Юv'){


// ���ݭn register_globals
if (!ini_get('register_globals')) {
 	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

if ($unit ==""){
		exit();
}
// ���W��
	$m = substr ($unit, 0, 1); 
	$t = substr ($unit, 1, 2); 
	$u = trim (substr ($unit, 3, 4)); 
	//���o�U���U�O
	$sqlstr = "select * from unit_tome where  unit_m='$m' and unit_t='$t' " ;
	$result = mysql_query($sqlstr) or user_error("Ū�����ѡI<br>$sqlstr",256);
	$row= mysql_fetch_array($result);
	$c_tome = $row["unit_tome"];
	$tome_ver = $row["tome_ver"];
	//���o�椸�W��
	$sqlstr = "select * from unit_u where  unit_m='$m'  and unit_t='$t' and u_s='$u' and tome_ver='$tome_ver' ";
	$result = mysql_query($sqlstr);
	$row= mysql_fetch_array($result);
	$c_unit = $row["unit_name"];
	$u_id = $row["u_id"];

	echo "<a href=test_edit.php?unit=$unit >�^�W�@��</a>�@<a href=test.csv >�W���ɮ׮榡�d��</a>";	
	echo "�p�n�W�[�D�ءA�Х��U���榡�d����.csv�A�̮榡�ئn�D�w��A�W�ǴN�i�H�F�I���ɽХH�ק諸�覡�A�W�ǡC";
if ($act=="�妸�إ߸��"){
	$msg="";
	$b_edit_time = mysql_date();

	//$msg=import($_FILES['userdata']['tmp_name'],$_FILES['userdata']['name'],$_FILES['userdata']['size']);
	$userdata_size=$_FILES['userdata']['size'];
	$userdata_name=$_FILES['userdata']['name'];
	$userdata=$_FILES['userdata']['tmp_name'];
	$temp_file= $USR_DESTINATION."test.csv";	
	if ($userdata_size>0 && $userdata_name!=""){
		
		copy($userdata , $temp_file);
		$fd = fopen ($temp_file,"r");
		while ($tt = sfs_fgetcsv ($fd, 2000, ",")) {
			if ($i++ == 0) //�Ĥ@�������Y
				continue ;		
			 
			  $breed=trim($tt[0]);
			  $answer=trim(addslashes($tt[1]));
			  $ques=trim(addslashes($tt[2]));
			  $ch1=trim(addslashes($tt[3]));
			  $ch2=trim(addslashes($tt[4]));
			  $ch3=trim(addslashes($tt[5]));
			  $ch4=trim(addslashes($tt[6]));
			  $ch5=trim(addslashes($tt[7]));
			  $ch6=trim(addslashes($tt[8]));
		
		
			$strSQL = "insert into test_data set  u_id='$u_id',breed='$breed',answer='$answer',ques='$ques',ch1='$ch1',ch2='$ch2',ch3='$ch3',ch4='$ch4',ch5='$ch5',ch6='$ch6',unit_m='$m',unit_t='$t',u_s='$u',up_date='$b_edit_time',teacher_sn='$_SESSION[session_tea_sn]'";
			
			$result=$CONN->Execute($strSQL) or user_error("Ū�����ѡI<br>$sqlstr",256);;
	
			
			$name=stripslashes($ques);
			if($result){
				$msg.=" -- $name �s�W���\�I<br>";
				}
			else
				$msg.=" -- $name ��Ʒs�W���ѡI<br>";
			$i++;
		        
		}
	}
	else{
		$msg.="�ɮ׮榡���~";
	}
	unlink($temp_file);

	echo "<table cellspacing='1' cellpadding='10' class=main_body>
	<tr bgcolor='#E1ECFF'><td>".$msg."</td></tr></table>";
}else{
	 echo "	<table border='0' cellspacing='0' cellpadding='0' >
	<tr><td valign=top>
		<table cellspacing='1' cellpadding='10' class=main_body >
		<form action ='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data' method=post>
		<tr><td  nowrap valign='top' bgcolor='#E1ECFF'>
		<p>�Ы��y�s���z��ܶפJ�ɮרӷ��G</p>
		<input type=file name='userdata'>
		<p><input type=submit name='act' value='�妸�إ߸��'></p>
		<input type='hidden' name='unit' value='$unit'>	
		</td>
		<td valign='top' bgcolor='#FFFFFF'>
	
		</td>
		</tr>
		</table>
	</form>
	</td></tr></table>
	";
}
}
