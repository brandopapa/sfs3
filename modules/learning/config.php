<?php

// $Id: config.php 8705 2015-12-29 03:03:33Z qfon $

require_once "./module-cfg.php";
/* �ǰȨt�γ]�w�� */
require_once "../../include/config.php";
/* �ǰȨt�Ψ禡�w */
require_once "../../include/sfs_case_PLlib.php";
/* ���o�����ܼƭ� */
require_once "../../include/sfs_core_globals.php";

/* �W���ɮץت��ؿ� */
$path_str = "unit/";
set_upload_path($path_str);
$USR_DESTINATION = $UPLOAD_PATH.$path_str;
$download_path=$UPLOAD_URL."unit/";
/*�u�W����U�����| */
$downtest_path = $UPLOAD_URL."test/";
$TES_DESTINATION = $UPLOAD_PATH."test/";
//���W�ٰ}�C
$modules_s = array("a"=>"��y","b"=>"�ƾ�","c"=>"�۵M","d"=>"���|","e"=>"����","f"=>"�ͬ�","g"=>"����","h"=>"��X","i"=>"�m�g","j"=>"�^�y","k"=>"�D�D");
//$modules_s = array("k"=>"��T","l"=>"���","m"=>"�H�v","n"=>"�ͲP","o"=>"����");  //���jĳ�D


//���W�ٰ}�C
$modules = array("a"=>"��y��","b"=>"�ƾ�","c"=>"�۵M�P�ͬ����","d"=>"���|","e"=>"���N�P�H��","f"=>"�ͬ�","g"=>"���d�P��|","h"=>"��X����","i"=>"�m�g�y��","j"=>"�^�y","k"=>"�D�D�ǲ�");

//���W�ٰ}�C
$entry_s = array("a"=>"�椸���i","b"=>"�Ч����e","c"=>"�о��ɮ�","d"=>"�Q�פ���","e"=>"�ѦҺ���");
// $entry_s = array("a"=>"�椸���i","b"=>"�Ч����e","c"=>"�о��ɮ�","d"=>"�Q�פ���","e"=>"�ѦҺ���","f"=>"�u�W����");
$note_s = array(
"a"=>"�@�@�w��i�J���ǲ߸귽���A�������O�H�U���B�U�椸���W�e�A���Ѥj�a�@�Ӿ�z�Ʀ�оǸ�ƪ���a�A�z�i�H�b�ҫe�N�U���Ч����ɮ׶K�W�B�W�ǩΰ��n�s���A�P�ɻP�O�H���ɡA�W�ҮɴN�i�ϥ�
�H��i�o���U���귽�A�]�i���P�ǭ̦ۭשΰѦҡC<br>
	�@�@�������դ��v�ͮa���i�J�A�U����Ƥ���~�}��A�Ҧ����e�����z�]���v�ݭ�@�̡A���W�ұоǥ~�A���o���䥦�γ~�C<br>
	�@�@�Фj�a�@�_�ӥR�ꥻ��a�a�I",
"b"=>"�Ч����e�O���W�Үɥi��|�Ψ쪺���󤺮e�A��p�@�q��r�����B�@�i�Ϥ��B�@�q�v���A�p�G�O�@�ӳs���A�Ʊ�O�����s��ڭ̩ҭn�������A�Ӥ��O�������ؿ��C
	<br>�ڭ̧Ʊ�঳�t�Ϊ���z�k���A���j�a�ϥήɧ��K�C",
"c"=>"�о��ɮ׬O�����j�B�����������e�A�p��ӱЮסB��v���B���ʳn�鵥�A�]�Ʊ�O�����i�H�}�ҩΤU���ϥΪ��C",
"d"=>"�Q�פ��ʰϬO���Ѯv�ͤ��ʪ��޹D�A�Ѯv�i�H�X�@�~�D�ءA�ǥͽu�W�^���A�Χ�ߧ@���e������J�A�]�O�@�Ӥ������D�N�C",
"e"=>"�ѦҺ����N�O�t�~���ѰѦҪ������A�u�n���Ѻ��}�s���N�n�F�a�I");


//�ˬd�O�_������ ip
function check_ip() {
	global $man_ip,$REMOTE_ADDR ;
	$is_intranet = false;
	for($mi=0 ; $mi< count($man_ip) ;$mi++){
		$ee = explode ('.',$man_ip[$mi]);
		if ((count($ee) == 4 && $man_ip[$mi] == $REMOTE_ADDR) || count($ee) < 4 && $man_ip[$mi] == substr($REMOTE_ADDR,0,strlen($man_ip[$mi]))){
			$is_intranet = true;
			break;
		}		
	}
	return $is_intranet;
}

function redir_str( $surl ,$str="",$sec) {
  //�� $sec ���A��V��$sul �����A������b header����
  print("<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=big5\">");
  print("<meta http-equiv=\"refresh\" content=\"" . $sec . "; url=" . $surl ."\">  \n" ) ; 
  print("</head><body>");
  print($str);
  print("</body></html>");
  //�Ƶ��Aphp ����� Header("Location:cal2.php") ;�|���W��}�A�L�k�X�{�T���ε���
}

//�ˬd�ϥ��v
function board_checkid($chk){
	global $conID,$session_log_id ,$app_name,$session_tea_sn;
if($_SESSION['session_who'] =="�ǥ�"){	
	$dbquery = "select pro_kind_id from board_check where pro_kind_id ='$chk' and teach_id='$_SESSION[session_log_id]'";
		$result= mysql_query($dbquery,$conID)or die("<br>��Ʈw�s�����~<br>\n $dbquery");
		if (mysql_num_rows ($result)>0)	{
			return true;
		}
		else
			return false;

	return true;	
	
}else{
	$chkary= explode ("/",$chk);
	$pp	= $chkary[count($chkary)-2];
	$post_office = -1;
	$teach_title_id = -1;
	$teach_id = -1 ;
	$dbquery = " select a.teacher_sn,a.login_pass,a.name,b.post_office,b.teach_title_id ";
	$dbquery .="from teacher_base a ,teacher_post b  "; 
	$dbquery .="where a.teacher_sn = b.teacher_sn and a.teacher_sn='$_SESSION[session_tea_sn]'"; 
	$result= mysql_query($dbquery,$conID)or ("<br>��Ƴs�����~<br>\n $dbquery");
	
	if (mysql_num_rows($result) > 0){
		$row = mysql_fetch_array($result);
		$post_office = $row["post_office"];
		$teach_title_id	= $row["teach_title_id"];
		$teacher_sn =	$row["teacher_sn"];
	
		$dbquery = "select pro_kind_id from board_check where pro_kind_id ='$chk' and (post_office='$post_office' or post_office='99' or teach_title_id='$teach_title_id' or teacher_sn='$teacher_sn' )";

		$result= mysql_query($dbquery,$conID)or die("<br>��Ʈw�s�����~<br>\n $dbquery");
		if (mysql_num_rows ($result)>0)	{
			return true;
		}
		else
			return false;
	}
	else
		return false;
}
}
//�ˬd�ثe�Ǧ~
function stud_ye($stud_id){
	global $CONN;
    $stud_id=substr($stud_id,0,7);
	$rs_sn=$CONN->Execute("select curr_class_num from stud_base where stud_id='$stud_id'") or trigger_error("SQL�y�k���~ ", E_USER_ERROR);
	$stud_year= substr($rs_sn->fields["curr_class_num"],0,1);

	if($stud_year=='')
		$stud_year=1;
	return $stud_year;
}
?>
