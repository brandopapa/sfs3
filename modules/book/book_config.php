<?php
                                                                                                                             
// $Id: book_config.php 7794 2013-12-03 03:39:50Z infodaes $

	/** �ǰȺ޲z�]�w **/
	require_once "../../include/config.php";
	require_once "../../include/sfs_case_PLlib.php";

	include "./module-upgrade.php";
	//���o�Ҳճ]�w
	$m_arr = get_sfs_module_set("book");
	extract($m_arr, EXTR_OVERWRITE);	

	$pic_width=$pic_width?$pic_width:64;
	
	 //���ٮѵ{�����wIP�d��
	 $man_ip = array($man_ip1,$man_ip2,$man_ip3);

	/* �W���ɮץت��ؿ� */
	$path_str = "school/book";
	set_upload_path($path_str);
	$upload_path = $UPLOAD_PATH.$path_str;

	/*�U�����| */
	$download_url = $UPLOAD_URL.$path_str;

//�Ϯѱ��X�禡
function  barcode($text) { 
	$enc_text  =  urlencode($text); 	
	echo  "<img  src=\"barcode.php?code=$enc_text\" border=0 Alt=\"$text\">"; 
} 
//���o�ϮѫǤ�����

function get_booksay_option(){
global $CONN;
//�إߪ��
$CONN->Execute("
CREATE TABLE if not EXISTS `book_say` (
`bs_id` INT NOT NULL AUTO_INCREMENT,
`bs_title` VARCHAR( 30 ) NOT NULL ,
`bs_con` TEXT NOT NULL ,
`us_id` VARCHAR( 20 ) NOT NULL ,
`create_time` TIMESTAMP NOT NULL ,
PRIMARY KEY ( `bs_id` )
)");

$query = "select count(*) from book_say ";
$res = $CONN->Execute($query) or trigger_error("�d�߿��~ $query",E_USER_ERROR);
//�[�J�w�]��
if($res->fields[0]==0){
	$con=addslashes(read_file("b_begin.htm"));
	$CONN->Execute("insert into book_say(bs_title,bs_con)values('�t�_','$con')");
	$con= addslashes(read_file("b_order.htm"));
	$str = addslashes ('�Ϯѭɾ\�W�h');
	$CONN->Execute("insert into book_say(bs_title,bs_con)values('$str','$con')");
	$con=addslashes(read_file("b_teacher.htm"));
	$CONN->Execute("insert into book_say(bs_title,bs_con)values('�ϮѺ޲z�Ѯv','$con')");
	$con=addslashes(read_file("b_student.htm"));
	$CONN->Execute("insert into book_say(bs_title,bs_con)values('�ϮѺ޲z�p�q�u','$con')");
}

$query = "select bs_id,bs_title from book_say order by bs_id";
$res = $CONN->Execute($query) or trigger_error("�d�߿��~ $query",E_USER_ERROR);
while(!$res->EOF){
	$bs_id = $res->fields[bs_id];
	$bs_title = $res->fields[bs_title];
	$say_file .="<OPTION VALUE=\"booksay.php?sel=$bs_id\">$bs_title</OPTION>";
	$res->MoveNext();
}
return $say_file;
}

?>
