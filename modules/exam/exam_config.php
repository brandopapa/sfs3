<?php
                                                                                                                             
// $Id: exam_config.php 5310 2009-01-10 07:57:56Z hami $

/*
**
**	�ǥͧ@�~�ި�t��2.0��
**	�@�̡G
**	HaMi(cik@mail.wpes.tcc.edu.tw)
**	chilang(tea50@mail.wkes.tcc.edu.tw)
**	�{���ӷ��G�ն�ۥѳn���y��( http://sfs.wpes.tcc.edu.tw )
**
**	�ϥΥ��x Linux
**	�ϥθ�Ʈw MySQL
**	���t�λݵ��X�ǰȨt�ΡA�~�i�B�@�C
**
*/
//���J�ǰȨt��
include_once "../../include/config.php";
//���J�禡�w
include_once "../../include/sfs_case_PLlib.php";

/* �W���ɮץت��ؿ� */
$path_str = "school/exam/";
set_upload_path($path_str);
$upload_path = $UPLOAD_PATH.$path_str;


//�W���ؿ�URL
$uplaod_url = $UPLOAD_URL.$path_str; 

//���o�Ҳճ]
$m_arr = &get_sfs_module_set("exam");
extract($m_arr, EXTR_OVERWRITE);


//�����\�W�ǰ��ɦW
$limit_file_name = array("php","php3","inc");

//�H�U�ŧ��------------------------------------------------

mysql_select_db( "$dbname");

//�P�O�O�_�Q�I�s�L
$isload =1;


/**
 *	�ˬd�K�X�O�_�з�
 *
 *	���w�ϥέ^��μƦr
 *
 *	@param $chk - string - �ˬd�r��
 *	@param $less - integer - �ִ̤X�Ӧr��
 *	@param $max - integer - �̦h�X�Ӧr��
 *	@return bolean 
 */
function chk_pass($chk,$less=3,$max=10) {
	if (eregi("^[a-zA-Z0-9]{"."$less,$max"."}$",$chk,$arr) )
		return true;
	else
		return false;
}


// ���o�Z�� $class_id�줸�����G 0-3 ->�Ǧ~ 4->�Ǵ� 5->�~�� 6- �Z�� 
function get_class_name($class_id) {
	global $class_year, $class_name ;
	$class_name=class_base();
	$temp_year = substr($class_id,4,1); //���o�~��	
	$temp_class = $temp_year.sprintf("%02d",substr($class_id,5)); //���o�Z��
	return  $class_name[$temp_class];
}
?>
