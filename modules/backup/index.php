<?php

// $Id: index.php 7696 2013-10-23 08:04:10Z smallduh $

include "config.php";

sfs_check();


if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}


//����ʧ@�P�_
if($act=="�U����Ƴƥ�"){
	download_sql($tbl_name);
	exit;
}else{
	$main=pre_form();
}


//�q�X����
head("�ǰȨt�θ�Ƴƥ�");
echo $main;
foot();


/*
�禡��
*/

//�򥻳]�w���
function pre_form(){
	global $school_menu_p,$mysql_db,$CONN;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);

	//���o�Ҧ����W��
	$result = mysql_list_tables($mysql_db);

	if (!$result) {
		user_error("�L�k���o��ƪ��ơC",256);
	}
	$n=3;
	$i=$n+1;
	while ($row=mysql_fetch_row($result)) {
		$tr1=(($i%$n)==1)?"<tr bgcolor='#F8F8F8'>":"";
		$tr2=(($i%$n)==0)?"</tr>":"";
		$option.="$tr1<td><input type='checkbox' name='tbl_name[]' value='$row[0]' checked>
		<font size=2 face='arial'>$row[0]</font></td>$tr2";
		$i++;
	}

	mysql_free_result($result);

	$main="
	$tool_bar
	<table cellspacing=0 cellpadding=0><tr><td>
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=1>

	<form method='post' action='$_SERVER[PHP_SELF]' name='db_dump'>
	$option
    	</table>
	</td><td valign='top'>
	<input type='submit'  name='act' value='�U����Ƴƥ�' /></td></tr></table>
	</form>
	";
	return $main;
}


//�U����Ƴƥ�
function download_sql($tbl_name){
	global $CONN,$mysql_db,$SFS_PATH,$UPLOAD_PATH;
	$today=date("YmdHi");
	for($i=0;$i<sizeof($tbl_name);$i++){
		$data.=table_data($tbl_name[$i]);
	}
	$filename="backup_".$mysql_db."_".$today;
	/*
	//�ƥ���D���W
	if(!opendir($UPLOAD_PATH."backup")) mkdir ($UPLOAD_PATH."backup", "0700");

	$full_filename=$UPLOAD_PATH."backup/".$filename;
	$fp=fopen($full_filename,"w");
	fwrite($fp,$data);
	fclose($fp);
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$filename);
	echo $data;
	exit;
	*/
	header("Content-Disposition: attachment; filename=".$filename);
	header("Content-type: text/plain");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	
	header("Expires: 0");
	echo $data;
	exit;
	
}




?>
