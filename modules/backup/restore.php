<?php

// $Id: restore.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();

if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//����ʧ@�P�_
if($act=="�i���Ʀ^��"){
	set_time_limit(300) ;
	$dest=$UPLOAD_PATH."".$_FILES['sfile']['name'];
	$main=up_file($dest,$_FILES['sfile']['tmp_name']);
	header("location: {$_SERVER['PHP_SELF']}?act=result&fname=$dest");
}elseif($act=="result"){
	$main=view_data($fname);
}else{
	$main=pre_form();
}


//�q�X����
head("�ǰȨt�θ���٭�");
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

	$main="
	$tool_bar
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<form method='post' action='{$_SERVER['PHP_SELF']}' enctype='multipart/form-data'>
	<tr bgcolor='white'><td class='small'>
	SQL�ɮסG<input type='file' name='sfile' size=50>
	<p>
	<div align='center'><input type='submit' name='act' value='�i���Ʀ^��'></div>
	</td></tr>
    	</table>
	</form>
	";
	return $main;
}


//�W���ɮ�
function up_file($dest,$up){
	global $school_menu_p,$CONN,$mark;
	if(!empty($dest)){
		if(copy($up,$dest)){
			$fpath_str = $dest;
			if (is_file ($fpath_str)){

				$fd = fopen($fpath_str, 'rb');
            			$sql_query = fread($fd, filesize($fpath_str));
           			fclose($fd);
				
				if (get_magic_quotes_runtime() == 1) {
            				$sql_query = stripslashes($sql_query);
        			}

				$an=0;
				$sql=explode($mark,$sql_query);
				$n=sizeof($sql)-1;//�R���̫�@�Ӫťժ���
				for($i=0;$i<$n;$i++){
					if(empty($sql[$i]))	continue;
					if(!$CONN->Execute($sql[$i])){
						$show_contents=nl2br(htmlspecialchars($sql[$i]));
						$an++;
						trigger_error("SQL�y�k���~�G<p>���~ $an".$show_contents."</p>", E_USER_ERROR);
					}
				}
				return true;
			}
		}else{
			trigger_error("�ɮפW�ǥ��ѡI$dest",E_USER_ERROR);
		}
	}else{
		trigger_error("�S���ɮצW�١I $dest",E_USER_ERROR);
	}
	return false;
}

function view_data($fname){
	global $school_menu_p,$CONN;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);

	$main="
	$tool_bar
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<tr bgcolor='white'><td class='small'>
	�w�g���\�N $fname ������Ʀ^�s���Ʈw���C
	</td></tr>
    	</table>
	";
	return $main;
}
?>
