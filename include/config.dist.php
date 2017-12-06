<?php
// set to the user defined error handler
session_start();
$old_error_handler = set_error_handler("error_die");

/**********************************
 �t�γ]�w
***********************************/
//�{���ڥؿ� PATH
$SFS_PATH = "/var/www/sfs3";

//�ǰȺ޲z�����{�� URL (�]�w�ɡA�O�d�̫᪺ "/" )
$SFS_PATH_HTML ="http://localhost/sfs3/"; 

//�Ǯխ��� URL
$HOME_URL ="http://localhost/";

//�Ǯ�IP �d��
/*�b��c class �]�w (�_�lIP �P ����IP �H - �j�})
�� array("163.17.169.1-163.17.169.128");

�h��IP �d��]�w
�� array("163.17.169","163.17.168.1-163.17.169.128","163.17.40.1");
*/
$HOME_IP = array("127.0.0"); // �@�� c class

/**********************************
  MYSQL �s���]�w
***********************************/
// mysql �D��
$mysql_host ="localhost";

// mysql �ϥΪ�
$mysql_user ="sfs3";

// mysql �K�X
$mysql_pass ="pass";

// ��Ʈw�W��
$mysql_db   ="sfs3";


/**********************************
  �W���ɮ׳]�w
***********************************/
//�W���ɮש�m��m�A�W���ؿ��v���ݳ]�� 777
$UPLOAD_PATH = "/home/cik/SFS3-STABLE/sfs3/data/";

//�O�W (alias)  apache �b�]�w�� httpd.conf ���[�J  WIN32 �bIIS�޲z�����]�w
$UPLOAD_URL = "/sfs3/data/";


/**********************************
  �{���ɭ�
***********************************/
//�{���Ҫ� webmin or treemenu or new
$SFS_THEME = "new";

//�Ҳ�������
$nocols = 4 ;

//�O�_��� SFS ��������T
$SHOW_SFS_VER = 1;

//�ثe�� SFS ���ݭn���} php.ini �������ܼƳ]�w
//�г]�w php.ini ���� register_globals=Off
$SFS_NEED_REGISTER_GLOBALS = 0;

//�O�_���çֳt�s�����(fast_link)
$SFS_HIDDEN_FAST_LINK=1;

//�O�_�����ߺݶ�������SFS����
$SFS_IS_CENTER_VER=0;

//�O�_���üҲռ��D
$SFS_IS_HIDDEN_TITLE=0;
	
/**********************************
  ���y��Ƴ]�w
***********************************/
//�W�Ǵ��}�l���
$SFS_SEME1 = 8 ; //�K��

//�U�Ǵ��}�l���
$SFS_SEME2 = 2 ; //�G��



// �~�q
$class_year = array("1"=>"�@�~","2"=>"�G�~","3"=>"�T�~","4"=>"�|�~","5"=>"���~","6"=>"���~","a"=>"���X��","b"=>"�S�ЯZ","c"=>"�귽�Z");

// �Z�W
$class_name = array("01"=>"��","02"=>"�A","03"=>"��","04"=>"�B","05"=>"��","06"=>"�v","07"=>"��","08"=>"��"); 

// �ꤤ �] 6 ,��p�] 0
$IS_JHORES=0;

/**********************************
��L�]�w
***********************************/

//�Юv�N���� �y�����}�Y�w�]�r�� ��: tea (tea0001 ,tea0002 ...)
$DEFAULT_TEA_ID_TITLE = "tea-";

//�Юv�N���� �y�����w�]�_�l�� ��: 00001 (tea00001 ,tea00002 ...)
$DEFAULT_TEA_ID_NUMS = "0001"; // " " �޸����i���� 

//�Юv�n���w�]�K�X
$DEFAULT_LOG_PASS = "demo";

//�ǥ͵n���w�]�K�X
$DEFAULT_STUD_LOG_PASS = "1111";

//�a���n���w�]�K�X
$DEFAULT_FAM_LOG_PASS = "3333";

//�W�Ҥ�Ƴ]�w
$weekN = array('�@','�G','�T','�|','��');

//----�@�ǦW�ٿﶵ
$school_kind_name=array("���X��","�@�~","�G�~","�T�~","�|�~","���~","���~","�@�~","�G�~","�T�~","�@�~","�G�~","�T�~");
$school_kind_color=array(
"#FFE1E1",
"#EBFFE1","#DEFFCD","#D0FFB9","#C3FFA5","#B6FF91","#A8FF7D",
"#FFF7CD","#FFF3B9","#FFF0A5",
"#E1E6FF","#CDD5FF","#B9C5FF");
$class_name_kind=array("","�@�B�G�B�T","�ҡB�A�B��","���B���B��","��L");
$class_name_kind_1=array("","�@","�G","�T","�|","��","��","�C","�K","�E","�Q","�Q�@","�Q�G","�Q�T","�Q�|","�Q��","�Q��","�Q�C","�Q�K","�Q�E","�G�Q","�G�Q�@","�G�Q�G","�G�Q�T","�G�Q�|","�G�Q��","�G�Q��","�G�Q�C","�G�Q�K","�G�Q�E","�T�Q","�T�Q�@","�T�Q�G","�T�Q�T","�T�Q�|","�T�Q��","�T�Q??","�T�Q?C","�T�Q�K","�T�Q�E","�|�Q","�|�Q�@","�|�Q�G","�|�Q�T","�|�Q�|","�|�Q��","�|�Q��","�|�Q�C","�|�Q�K","�|�Q�E","���Q");
$class_name_kind_2=array("","��","�A","��","�B","��","�v","��","��","��","��");
$class_name_kind_3=array("","��","��","��","�R","�H","�q","�M","��");


//------------���U�]�w�ŧ�
require "$SFS_PATH/include/sfs_API.php"; //�t�ή֤ߨ禡�w
//���s�{���ɮ�url
$rlogin = $SFS_PATH."/rlogin.php";

$conID = @mysql_connect ("$mysql_host","$mysql_user","$mysql_pass") or trigger_error("��Ʈw�L�k�s�W�A�γ\�����_�u�A�]�γ\�z����Ʈw�]�w���~�A���ˬd��Ʈw�]�w�í��s�Ұʸ�Ʈw�C", E_USER_ERROR);
@mysql_select_db($mysql_db,$conID); 


//ADODB ����
require_once("$SFS_PATH/pnadodb/adodb.inc.php"); # load code common to ADODB
require_once("$SFS_PATH/include/sfs_case_ado.php"); # �禡�w

$DB_TYPE = 'mysql';
$CONN = &ADONewConnection($DB_TYPE);  # create a connection
$CONN->Connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);# connect to postgresSQL, agora db

//���o Mysql �����ܼ�
if ($DB_TYPE == 'mysql')
	$DATA_VAR = get_mysql_var();

//�ݬݸ��|��s���s�b
if(!file_exists($UPLOAD_PATH."Module_Path.txt")){
	Creat_Module_Path();
}

/* 
���o�Ǯհ򥻸��
*/
$SCHOOL_BASE = get_school_base($mysql_db);
$school_long_name = $SCHOOL_BASE["sch_cname"];  /* �Ǯ�(����)�W�� */
$school_short_name = $SCHOOL_BASE["sch_cname_s"]; /* �ǮզW�� */
$school_sshort_name = $SCHOOL_BASE["sch_cname_ss"]; /* �Ǯ�²�� */ 
$path = $SFS_PATH; // �ۮe�� sfs1.1 �]�w 
$path_html = $SFS_PATH_HTML; // �ۮe�� sfs1.1 �]�w 


//���Z�����榡�]�w
$input_kind=array("","text","password","select","textarea","checkbox","radio");

//���~�T���榡�æ���
function error_die ($errno, $errstr, $errfile, $errline) {
	global $HAVE_SHOW_HEADER;
	switch ($errno) {
		case FATAL:
		case ERROR:
		case WARNING:
		case 256:
		//default:
		$msg=&error_tbl("������~","$errstr<p>�{���ثe�����m�G$errfile ���� $errline ��</p>");
		if(!$HAVE_SHOW_HEADER)head();
		echo($msg);
		if(!$HAVE_SHOW_HEADER)foot();
		die();
		break;
	 }
}
?>
