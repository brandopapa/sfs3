<?php

include "config.php";
session_start();

sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
 	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}


if ($act=="�妸�إ߸��"){
	$msg="";

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
// �H�U�����_�_��			 
			  $p_id=trim($tt[0]);
			  $p_name=trim(addslashes($tt[1]));
			  $p_s1=trim(addslashes($tt[2]));
			  $p_s2=trim(addslashes($tt[3]));
			  $p_s3=trim(addslashes($tt[4]));
			  $p_s4=trim(addslashes($tt[5]));
			  $p_s5=trim(addslashes($tt[6]));
			$strSQL = "insert into poke_base set  p_id='$p_id',p_name='$p_name',p_s1='$p_s1',p_s2='$p_s2',p_s3='$p_s3',p_s4='$p_s4',p_s5='$p_s5'";
// �H�U���Ȼy�C��@�y	
//			$p_id=trim($tt[0]);
//			$p_name=trim(addslashes($tt[1]));
//		  	$p_s1=trim(addslashes($tt[2]));
//			$p_s2=trim(addslashes($tt[3]));
//			$p_s3=trim(addslashes($tt[4]));
//			$strSQL = "insert into kakka set  pdate='$p_id',pmday='$p_name',pfood='$p_s1',pmenu='$p_s2',pfruit='$p_s3'";
//			//echo 	$strSQL ;
			$result=$CONN->Execute($strSQL) or user_error("Ū�����ѡI<br>$sqlstr",256);;
	
			
		
			if($result){
				$msg.=" -- $name �s�W���\�I<br>";
				}
			else
				$msg.=" -- $p_name ��Ʒs�W���ѡI<br>";
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

