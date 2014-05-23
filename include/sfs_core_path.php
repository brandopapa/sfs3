<?php

// $Id: sfs_core_path.php 5498 2009-06-17 08:56:47Z brucelyc $

  // �ˬd�O�_�ݩ���ܪ��ؿ��W��
  // �i�H��ܪ̶Ǧ^ true
  // ����ܪ̶Ǧ^ false
function is_display_path($chk){
  if (!$chk) user_error("�S���ǤJ�ѼơI���ˬd�C",256);
	$is_path= true;
	$pp = non_display_path();
	for($i=0; $i< count($pp); $i++){
		if ($pp[$i]==$chk){
			$is_path= false;
			break;
		}
	}
	return $is_path;
}

//�t�κ޲z---����ܥؿ��W(���n�ؿ��λ����B����)
// �Ǧ^ array
function non_display_path(){
	global $SFS_SCHOOL_LOGIN_PATH;
	$non_display=SFS_TEXT("non_display");
	if(!empty($non_display)){
		if(!empty($SFS_SCHOOL_LOGIN_PATH))
			$non_display[]=$SFS_SCHOOL_LOGIN_PATH;
		return $non_display;
	}else{
		return array(".","..","images","db","themes","pnadodb","include","upgrade","data","CVS","phpMyAdmin");
	}
}

//���o���|���
function get_path($chk){
	if (!$chk) user_error("�S���ǤJ�ѼơI���ˬd�C",256);
	global $SFS_PATH;
	$chk = str_replace("\\\\","/",$chk); 
	$pp = substr($chk,strlen($SFS_PATH)+1);
	return updir($pp);
}


//���o�W�h���|���
function updir( $path ){
	//if (!$path) user_error("�S���ǤJ�ѼơI���ˬd�C",256);
	$last = strrchr( $path, "/" );
	$n1   = strlen( $last );
	$n2   = strlen( $path );
	return substr( $path, 0, $n2-$n1 );
}


//���o�Ҧb���|�W�٨��
function get_store_path($path=""){
	global $SFS_PATH, $SFS_PATH_HTML;
	if ($path =="" || $path==$SFS_PATH)
		$path = $_SERVER['SCRIPT_FILENAME'];
	$ap_path = str_replace("\\\\","/",$path);
	$n1   = strlen( $SFS_PATH );
	$n2   = strlen( $ap_path );
	$SFS_PATH_List = substr($ap_path, $n1, $n2-$n1 );
	$store_path = updir($SFS_PATH_List);
	if (substr($store_path,0,1)=='/')
                $store_path = substr($store_path,1);
	return $store_path;
}

//���o�{�����|�W�٨��
function get_sfs_path($curr_msn=""){
	global $CONN,$SFS_PATH_HTML,$UPLOAD_PATH;
	
	//@include_once($UPLOAD_PATH."Module_Path.php");
	$file = $UPLOAD_PATH."Module_Path.txt";
	$fp = @fopen($file,'r');
	$contents = fread($fp, filesize($file));
	$MPath = unserialize($contents);
	if(empty($curr_msn) and $SCRIPT_NAME!="/index.php"){
		$SCRIPT_NAME=$_SERVER[SCRIPT_NAME];
		$SN=explode("/",$SCRIPT_NAME);
		$m=getDBdata("",$SN[count($SN)-2]);
		$curr_msn=$m[msn];
	}
	$path="<a href='$SFS_PATH_HTML' accesskey='H'><img src='".$SFS_PATH_HTML."images/gohome.png' alt='' width='16' height='16' hspace='3' border='0' align='absmiddle'>�ǰȺ޲z�t�έ���</a> / $MPath[$curr_msn]";
	
	return $path;
}



//�Ҳո��|���h�s��
function get_module_path($curr_msn=0,$home_name="����",$needlink=0){
	global $CONN,$SFS_PATH_HTML;

	if(empty($curr_msn)){
		$m_name=($needlink)?"<a href='$SFS_PATH_HTML'>$home_name</a>":$home_name;
		return $m_name;
	}

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$sql_select="select of_group,showname,kind from sfs_module where  msn='$curr_msn' order by sort";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	list($of_group,$showname,$kind)=$recordSet->FetchRow();
	$pre_path=get_module_path($of_group,$home_name,$needlink);
	if ($kind=="����")
		$p.=($needlink)?$pre_path." / <a href='$SFS_PATH_HTML"."index.php?_Msn=$curr_msn'>$showname</a>":$pre_path." / $showname";
	else
		$p.=($needlink)?$pre_path." / <a href='index.php'>$showname</a>":$pre_path." / $showname";
	return $p;
}

//���o�Y�@�����
function getDBdata($msn="",$dirname=""){
	global $CONN;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if(!empty($msn)){
		$where="msn='$msn'";
	}elseif(!empty($dirname)){
		$where="dirname='$dirname'";
	}else{
		return array();
	}

	// init $theData
	$theData=array();

	$sql_select="select * from sfs_module where $where";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	$theData=$recordSet->FetchRow();
	return $theData;
}




//�]�w�W�ǥؿ����|
function set_upload_path($path_str) {
	global $UPLOAD_PATH,$UPLOAD_URL;
	if ($path_str !="") {
		$arr = explode ("/",$path_str);
		//�إߥؿ�
		$temp = $UPLOAD_PATH;
		for($i=0;$i<count($arr);$i++){
			if ($arr[$i]<>''){
				$temp .= $arr[$i];
				if (!is_dir($temp))
					mkdir($temp, 0755); 
				$temp .= "/";		
			}
		}
	}
	return $temp;
}



//�ˬd�����\�W���ɮ�
function check_is_php_file ($filename) {
	if (!$filename) user_error("�S���ǤJ�ѼơI���ˬd�C",256);
	$res = SFS_TEXT("php_file");
	if (count($res)==0)
		$res = array("1"=>"php","2"=>"php3","3"=>"ini","4"=>"inc");
	$temp_arr = array_values ($res);
	$subname = substr( strrchr($filename, "." ), 1 );
	if (in_array ($subname, $temp_arr))
		return true;
	else
		return false;
}


// �ˬd�t�άO�_�]�w���i�W���ɮ�
function check_phpini_upload() {
	if (!ini_get(file_uploads)) 
		trigger_error("�z�� php.ini �������}�W���ɮ׳]�w�A�г]�� file_uploads=On�A�í��s�Ұ� Apache�I", E_USER_ERROR);

}


//�ˬd�W���ɦW�æ^�ǼȦs�ɦW
function check_upload_file($f=array(),$ext=array()) {
	global $_ENV;

	//���o�ɮפW�ǼȦs�ؿ�
	$tmp_path=ini_get("upload_tmp_dir");
	if (empty($tmp_path)) {
		$tmp_path=$_ENV["TMP"];
	}
	if (empty($tmp_path)) {
		$tmp_path="/tmp";
	}

	if (count($f)>0 && count($ext)>0) {
		$file_name=strtoupper($f['name']);
		$s_str="/";
		if (substr(strtoupper($_ENV['OS']),0,3)=="WIN") {
			$ff_arr=explode("\\",$f['tmp_name']);
			$ff_str=$ff_arr[0];
			for($i=1;$i<(count($ff_arr)-1);$i++) $ff_str.="\\".$ff_arr[$i];
			if (strtoupper($ff_str)==strtoupper($tmp_path)) $tmp_path=$ff_str;
			$s_str="\\";
		}
		if (in_array(substr($file_name,-3,3),$ext)) return $tmp_path.$s_str;
	}
}
?>
