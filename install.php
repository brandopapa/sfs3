<?php

// $Id: install.php 8466 2015-07-20 16:05:21Z smallduh $
/*
// �ˬd php.ini
if (ini_get('register_globals')) {
  	echo "�z�n�I�ثe SFS ���ݭn���}�����ܼƳ]�w�A���z�� php.ini �������}�ܼƥ���]�w�A�г]�� register_globals=Off�A�í��s�Ұ� Apache�I"; exit;
}
*/
$cfg_file="./include/config.php";
$SFS_PATH = dirname(__FILE__);

//�ǰȺ޲z�����{�� URL (�]�w�ɡA�O�d�̫᪺ "/" )
//$SFS_PATH_HTML ="http://localhost/sfs3/"; 


//�ʺA�]�wphp ����ɶ��A�קK timeout
set_time_limit(180) ;

// �ˬd config.php �O�_�iŪ�B�i�g�J?
if(!chk_permit($cfg_file)){
	if (!is_file($cfg_file)){
		$memo = "�䤣�� $cfg_file ���ɮ�!";
		$memo2 = "�إߤ@�� config.php ���ť��ɮ�";
	}
	else 
		$memo = "$cfg_file �LŪ�g�v!";
  	$main="
	<table width='90%' align='center' cellspacing='1' cellpadding='10' bgcolor='red'><tr bgcolor='white'><td>
	<h2 align='center'>$memo </h2>
	��]�G
	<p>�w�˹L�{�����@�ǳ]�w�ȷ|�g�J $cfg_file �A�Y�O $cfg_file �LŪ�g�v�A����ѼƵL�k�g�J�A�t�ΫK�L�k���`�B�@�A�ҥH�A�Эק� $cfg_file ���ݩʡC</p>
	��k�G
	<p>�Цb include �ؿ��U$memo2 �A ���� chmod 666 config.php�A�� config.php ��Ū�g�v�I</p>
	<p>��M�]�i�H��FTP�n�骽���ק��v���ݩʦ�666�A�]�ܤ�K�I</p>
	</td></tr></table>
	";
}elseif($_POST['installsfs']=='yes_do_it_now') {
	//�}�]��Ʈw
	install_sfs_db($_POST['mysql_host'], $_POST['mysql_adm_user'], $_POST['mysql_adm_pass'],$_POST['mysql_db'],$_POST['mysql_user'],$_POST['mysql_pass']);
	// �N�]�w�g�J /include/config.php ��
	write_config();
	header("Location: {$_SERVER['SCRIPT_NAME']}?act=sfs_result&ud={$_POST['UPLOAD_PATH']}&uu={$_POST['UPLOAD_URL']}&sfsurl={$_POST['SFS_PATH_HTML']}");
}elseif($_GET['act']=="sfs_result"){
	$main=sfs_result($_GET['ud'],$_GET['uu'],$_GET['sfsurl']);
}else{
	require "./include/sfs_case_installform.php";
}

?>

<html>
<head>
<title>�հȦ�F�t�Χֳt�w��</title>
<meta http-equiv='Content-Type' content='text/html; charset=Big5'>
</head>
    <style type='text/css'>
    body,td{font-size: 12px}
    .small{font-size: 12px}
    </style>
<body background='images/bg.png'>
<?php echo $main;?>
</body>
</html>


<?php


/*  �禡��*/


//�ˬd�]�w��_�g�J
function chk_permit($file) {
	// �Y�LŪ���M�g�J�v�h�q�X���ܰT��!
	if (!(is_readable($file) && is_writeable($file))) {
		return false;
  	}
	return true;
}




//�۰ʦw�˸�Ʈw���禡�A�]�A�إ߸�Ʈw�B��ƪ�B�]�w�v��...���T�Ӱʧ@
function install_sfs_db($host, $adm_user, $adm_pass,$db,$user,$passwd){
	$link = @mysql_connect($host, $adm_user, $adm_pass)
	or die("�L�k�s����Ʈw $db ,
	<p>�нT�w�H�U��ƬO�_���T�G</p>
	<p>��Ʈw��m�G$host</p>
	<p>�޲z�̱b���G$adm_user</p>
	<p>�޲z�̱K�X�G$adm_pass</p>
	�Ц^�W���ק�I");

	if(mysql_select_db($db)){
		die("$db �w�s�b�C�z�i�H�� $db ��Ʈw�����A�άO�N�u��Ʈw�W�١v�令���P�� $db ���W�١A�Ҧp�G�u".$db.date("_md")."�v�A�Y�i�~��w�ˡC");
	}else{

		$sql="CREATE DATABASE $db";

		// �ۮe�� MySQL 4.1.X
		if (mysql_query($sql, $link)) {

			$str="grant all privileges on $db.* to $user@$host identified by '$passwd'";

			require "./include/sfs_case_sql.php";

			$sql_file="./db/sfs3.sql";

			$sql_query = fread(fopen($sql_file, 'r'), filesize($sql_file));

			run_sql($sql_query, $db);

			//mysql_db_query($db,$str,$link) or user_error("��Ʈw $db �L�k�إߡI�Ц^�W���ק�I",256);
			mysql_query($str,$link) or user_error("��Ʈw $db �L�k�إߡI�Ц^�W���ק�I",256);
			
			$str="grant create  on $db.* to sfs3addman@$host identified by '$passwd'";

			//mysql_db_query ($db,$str,$link) or user_error("�L�k�إߥΨӶפJ��ƪ��ϥΪ��v���I<br>$str",256);
			mysql_query ($str,$link) or user_error("�L�k�إߥΨӶפJ��ƪ��ϥΪ��v���I<br>$str",256);

			// ��s�v���A�H�K MySQL 4.1.X ���L�k���s�W�ϥΪ̳s�u
			mysql_query ("FLUSH PRIVILEGES", $link) or user_error("�L�k��s�ϥΪ��v���I�Ф�ʭ��s�Ұ� MySQL",256);

		} else {
			trigger_error("��Ʈw $db �L�k�إߡI�Ц^�W���ק�I", E_USER_ERROR);
		}
	}

	/* Closing connection */
	mysql_close($link);
}



//�w�˵��G
function sfs_result($ud,$uu,$sfsurl){
	$msg="
	<div style='color:white ;font-size: 30px' align='center'>���߱z�I�t�����Ӥw�g�w�˧����C</div><p></p>

	<table width='90%' align='center' cellspacing='0' cellpadding='10' bgcolor='red'>
	<tr bgcolor='#E2FFB6'><td colspan=3>���߱z�I�t�����Ӥw�g�w�˧����C���ۡA�z�����@�@�ǳ]�w�~�����ǰȨt�ιB�@�L�~�G</td></tr>
	<tr bgcolor='white'><td width='50%'>
	<ol>
	<li>�ק�include/config.php���v������Ū�A�T�O�z�t�Τ��|�Q«��A��k�p�U�G
	�bsfs3���ڥؿ��U�A��J�H�U���O�G
	<p style='color:blue'>chmod <font color='red'>644</font> include/config.php</p></li>
	<li>���� install.php�A��k�p�U�G 
	�bsfs3���ڥؿ��U�A��J�H�U���O�G
	<p style='color:blue'>rm -f install.php</p></li>

	<li>�إߤW�ǥؿ��u".$ud."�v�A��k�p�U�G
	<p style='color:blue'>mkdir $ud</p>
	<li>�ק�W�ǥؿ��u".$ud."�v�v����777�A��k�p�U�G
	<p style='color:blue'>chmod <font color='red'>777</font> $ud</p>
	</li>
	<li>�bapache �b�]�w�� httpd.conf ���[�J���U��ơA�]WIN32 �bIIS�޲z�����]�w�^�C�`�N�ؿ������n�� /<p>
	<font color='darkRed'>
	Alias $uu '$ud'<br>
	&lt;Directory '$ud'&gt;<br>
	Options None<br>
	AllowOverride None<br>
	Order allow,deny<br>
	Allow from all<br>
	&lt;/Directory&gt;
	</font>
	<p>
	<li>����A�Э��s�� apache�A��k�p�U�G<br>���� service httpd restart<br>
	�ΰ��� /etc/rc.d/init.d/httpd restart
	</li>
	</ol>
	</td><td width=10 background='images/line.png'></td><td valign='top' width='50%'>
	<ul>
	<li>�z�i�H���ݬ�<a href='$sfsurl' target='_blank'>�s�[�n���հȦ�F�t��</a>�I�]�|�}�b�s�����^�A�ݧ���A�Ц^��o�@�����~�򰵳]�w�C</li>
	<p>
	<li>�̫�A�i������]�w�G
	<p>
	<ol>
	<li>�жi��<a href='".$sfsurl."modules/school_setup/'  target='_blank'>�Ǯհ򥻳]�w</a>�I�o�u�n�]�w�@���Y�i�C
	<p>
	<li>���ۡA�i��<a href='".$sfsurl."modules/every_year_setup/class_year_setup.php'  target='_blank'>�Ǵ���]�w</a>�I�o�O�C�@�Ǵ��}�ǫe�N�n�]�w�n����I<font color='red'>�������A�C�@�Ǵ����n�]�w��I</font>
	<p>
	<li>�M��A�i��<a href='".$sfsurl."modules/teach_class/teach_list.php'  target='_blank'>�Юv�]�w</a>�I�o�˱Юv�~��ϥΦ�F�t�ΡI
	<p>
	<li>�̫�A�i��<a href='".$sfsurl."modules/create_data/mstudent2.php'  target='_blank'>�פJ�ǥͩαЮv���</a>�I�o�ˮհȦ�F�t�Ϊ���Ƥw�g�t���h�աI
	</ol>
	<p>
	<li>�Y�ݭn��J�b���K�X�A�п�J�b���G�u<font color='red'>1001</font>�v�A�K�X�G�u<font color='red'>demo</font>�v</li>
	<p>
	<li>��ĳ�z�A�⥻���s�_�ӡA���խY�٭n�ק�~���D�n��Ǭƻ�C</li>
	</ul>
	</td></tr></table>
	";
	return $msg;
}


// �N�]�w�g�J include/config.php ��

function write_config() {
  global $cfg_file;

$cfg1=<<<HERE
<?php
// set to the user defined error handler
session_start();
\$old_error_handler = set_error_handler("error_die");

/**********************************
 �t�γ]�w
***********************************/
//�{���ڥؿ� PATH
\$SFS_PATH = "$_POST[SFS_PATH]";

//�ǰȺ޲z�����{�� URL (�]�w�ɡA�O�d�̫᪺ "/" )
\$SFS_PATH_HTML ="$_POST[SFS_PATH_HTML]"; 

//�Ǯխ��� URL
\$HOME_URL ="$_POST[HOME_URL]";

//�Ǯ�IP �d��
/*�b��c class �]�w (�_�lIP �P ����IP �H - �j�})
�� array("163.17.169.1-163.17.169.128");

�h��IP �d��]�w
�� array("163.17.169","163.17.168.1-163.17.169.128","163.17.40.1");
*/
\$HOME_IP = array("$_POST[HOME_IP]"); // �@�� c class

/**********************************
  MYSQL �s���]�w
***********************************/
// mysql �D��
\$mysql_host ="$_POST[mysql_host]";

// mysql �ϥΪ�
\$mysql_user ="$_POST[mysql_user]";

// mysql �K�X
\$mysql_pass ="$_POST[mysql_pass]";

// ��Ʈw�W��
\$mysql_db   ="$_POST[mysql_db]";


/**********************************
  �W���ɮ׳]�w
***********************************/
//�W���ɮש�m��m�A�W���ؿ��v���ݳ]�� 777
\$UPLOAD_PATH = "$_POST[UPLOAD_PATH]";

//�O�W (alias)  apache �b�]�w�� httpd.conf ���[�J  WIN32 �bIIS�޲z�����]�w
\$UPLOAD_URL = "$_POST[UPLOAD_URL]";


/**********************************
  �{���ɭ�
***********************************/
//�{���Ҫ� webmin or treemenu or new
\$SFS_THEME = "new";

//�Ҳ�������
\$nocols = 4 ;

//�O�_��� SFS ��������T
\$SHOW_SFS_VER = 1;

//�ثe�� SFS ���ݭn���} php.ini �������ܼƳ]�w
//�г]�w php.ini ���� register_globals=Off
\$SFS_NEED_REGISTER_GLOBALS = 0;

//�O�_���çֳt�s�����(fast_link)
\$SFS_HIDDEN_FAST_LINK=1;

//�O�_�����ߺݶ�������SFS����
\$SFS_IS_CENTER_VER=0;

//�O�_���üҲռ��D
\$SFS_IS_HIDDEN_TITLE=0;
	
/**********************************
  ���y��Ƴ]�w
***********************************/
//�W�Ǵ��}�l���
\$SFS_SEME1 = $_POST[SFS_SEME1] ; //�K��

//�U�Ǵ��}�l���
\$SFS_SEME2 = $_POST[SFS_SEME2] ; //�G��



HERE;


 if ($_POST[SFS_JHORES] == 1) {

$cfg2=<<<HERE2A

// �~�q
\$class_year = array("1"=>"�@�~","2"=>"�G�~","3"=>"�T�~","4"=>"�|�~","5"=>"���~","6"=>"���~","a"=>"���X��","b"=>"�S�ЯZ","c"=>"�귽�Z");

// �Z�W
\$class_name = array("01"=>"��","02"=>"�A","03"=>"��","04"=>"�B","05"=>"��","06"=>"�v","07"=>"��","08"=>"��"); 

\$IS_JHORES=0;

HERE2A;

 } elseif ($_POST[SFS_JHORES] == 2) {

$cfg2=<<<HERE2B

// �~�q
\$class_year = array("7"=>"�@�~","8"=>"�G�~","9"=>"�T�~","a"=>"�ɮ�","b"=>"�S�ЯZ","c"=>"�귽�Z");

// �Z�W
\$class_name = array("01"=>"1","02"=>"2","03"=>"3","04"=>"4","05"=>"5","06"=>"6","07"=>"7","08"=>"8","09"=>"9"); 

\$IS_JHORES=6;

HERE2B;

 } elseif ($_POST[SFS_JHORES] == 3) {

$cfg22=<<<HERE2C

// �~�q
\$class_year = array("10"=>"�@�~","11"=>"�G�~","12"=>"�T�~","a"=>"�ɮ�","b"=>"�S�ЯZ","c"=>"�귽�Z");

// �Z�W
\$class_name = array("01"=>"1","02"=>"2","03"=>"3","04"=>"4","05"=>"5","06"=>"6","07"=>"7","08"=>"8","09"=>"9"); 

\$IS_JHORES=9;

HERE2C;

 }


$cfg3=<<<HERE3

/**********************************
��L�]�w
***********************************/

//�Юv�N���� �y�����}�Y�w�]�r�� ��: tea (tea0001 ,tea0002 ...)
\$DEFAULT_TEA_ID_TITLE = "tea-";

//�Юv�N���� �y�����w�]�_�l�� ��: 00001 (tea00001 ,tea00002 ...)
\$DEFAULT_TEA_ID_NUMS = "0001"; // " " �޸����i���� 

//�Юv�n���w�]�K�X
\$DEFAULT_LOG_PASS = "demo";

//�ǥ͵n���w�]�K�X
\$DEFAULT_STUD_LOG_PASS = "1111";

//�a���n���w�]�K�X
\$DEFAULT_FAM_LOG_PASS = "3333";

//�W�Ҥ�Ƴ]�w
\$weekN = array('�@','�G','�T','�|','��');

//----�@�ǦW�ٿﶵ
\$school_kind_name=array("���X��","�@�~","�G�~","�T�~","�|�~","���~","���~","�@�~","�G�~","�T�~","�@�~","�G�~","�T�~");
\$school_kind_color=array(
"#FFE1E1",
"#EBFFE1","#DEFFCD","#D0FFB9","#C3FFA5","#B6FF91","#A8FF7D",
"#FFF7CD","#FFF3B9","#FFF0A5",
"#E1E6FF","#CDD5FF","#B9C5FF");
\$class_name_kind=array("","�@�B�G�B�T","�ҡB�A�B��","���B���B��","��L");
\$class_name_kind_1=array("","�@","�G","�T","�|","��","��","�C","�K","�E","�Q","�Q�@","�Q�G","�Q�T","�Q�|","�Q��","�Q��","�Q�C","�Q�K","�Q�E","�G�Q","�G�Q�@","�G�Q�G","�G�Q�T","�G�Q�|","�G�Q��","�G�Q��","�G�Q�C","�G�Q�K","�G�Q�E","�T�Q","�T�Q�@","�T�Q�G","�T�Q�T","�T�Q�|","�T�Q��","�T�Q??","�T�Q?C","�T�Q�K","�T�Q�E","�|�Q","�|�Q�@","�|�Q�G","�|�Q�T","�|�Q�|","�|�Q��","�|�Q��","�|�Q�C","�|�Q�K","�|�Q�E","���Q");
\$class_name_kind_2=array("","��","�A","��","�B","��","�v","��","��","��","��");
\$class_name_kind_3=array("","��","��","��","�R","�H","�q","�M","��");


//------------���U�]�w�ŧ�
require "\$SFS_PATH/include/sfs_API.php"; //�t�ή֤ߨ禡�w
//���s�{���ɮ�url
\$rlogin = \$SFS_PATH."/rlogin.php";

\$conID = @mysql_connect ("\$mysql_host","\$mysql_user","\$mysql_pass") or trigger_error("��Ʈw�L�k�s�W�A�γ\�����_�u�A�]�γ\�z����Ʈw�]�w���~�A���ˬd��Ʈw�]�w�í��s�Ұʸ�Ʈw�C", E_USER_ERROR);
@mysql_select_db(\$mysql_db,\$conID); 


//ADODB ����
require_once("\$SFS_PATH/pnadodb/adodb.inc.php"); # load code common to ADODB
require_once("\$SFS_PATH/include/sfs_case_ado.php"); # �禡�w

\$DB_TYPE = 'mysql';
\$CONN = &ADONewConnection(\$DB_TYPE);  # create a connection
\$CONN->Connect(\$mysql_host,\$mysql_user,\$mysql_pass,\$mysql_db);# connect to postgresSQL, agora db

//���o Mysql �����ܼ�
if (\$DB_TYPE == 'mysql')
	\$DATA_VAR = get_mysql_var();

//�ݬݸ��|��s���s�b
if(!file_exists(\$UPLOAD_PATH."Module_Path.txt")){
	Creat_Module_Path();
}

/* 
���o�Ǯհ򥻸��
*/
\$SCHOOL_BASE = get_school_base(\$mysql_db);
\$school_long_name = \$SCHOOL_BASE["sch_cname"];  /* �Ǯ�(����)�W�� */
\$school_short_name = \$SCHOOL_BASE["sch_cname_s"]; /* �ǮզW�� */
\$school_sshort_name = \$SCHOOL_BASE["sch_cname_ss"]; /* �Ǯ�²�� */ 
\$path = \$SFS_PATH; // �ۮe�� sfs1.1 �]�w 
\$path_html = \$SFS_PATH_HTML; // �ۮe�� sfs1.1 �]�w 


//���Z�����榡�]�w
\$input_kind=array("","text","password","select","textarea","checkbox","radio");

//���~�T���榡�æ���
function error_die (\$errno, \$errstr, \$errfile, \$errline) {
	global \$HAVE_SHOW_HEADER;
	switch (\$errno) {
		case FATAL:
		case ERROR:
		case WARNING:
		case 256:
		//default:
		\$msg=&error_tbl("������~","\$errstr<p>�{���ثe�����m�G\$errfile ���� \$errline ��</p>");
		if(!\$HAVE_SHOW_HEADER)head();
		echo(\$msg);
		if(!\$HAVE_SHOW_HEADER)foot();
		die();
		break;
	 }
}
?>
HERE3;


# write into config.php

 $hfile=fopen($cfg_file, "w");
 if (!$hfile) { echo "�}�� $cfg_file ���~�A���ˬd $cfg_file �O�_���g�J�v?"; exit; }

 fputs($hfile, $cfg1);
 fputs($hfile, $cfg2);
 fputs($hfile, $cfg22);
 fputs($hfile, $cfg3);

 fclose($hfile);

}


?>
