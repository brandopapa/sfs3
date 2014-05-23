<?php
// $Id: login.php 7937 2014-03-17 02:26:35Z smallduh $

require "include/config.php" ; 

//���oLDAP�Ҳլ�����T
    $query="select * from sfs_module where dirname='ldap' and islive='1'";
  	$res=$CONN->Execute($query) or die('Error! SQL='.$query);;
     if ($res->RecordCount()>0) {
  		$query="select * from ldap limit 1";
  		$res=$CONN->Execute($query); // or die('Error! SQL='.$query);  
  		if (!$res) {
  			$LDAP['enable']=0;
  			$LDAP['enable1']=0;
  		} else {
  			$LDAP=$res->fetchrow();  
  		}
     } else {
      $LDAP['enable']=0;
      $LDAP['enable1']=0;
     }

//���M�����n�ܼ�
$session_log_id="";
$session_tea_name="";
$session_tea_sn="";
$session_prob_open="";
$session_who="";
$session_login_chk="";


//�ҥ�SESSION
session_start(); 

//�Y�ҥ� OpenID�B�w���Ҧ��\
if ($TaiChung_OpenID) {
	require_once "./include/OIDpackage/commonclass.php";
	$obj = new TC_OID_BASE();
	session_start();
	$obj->setFinishFile("login.php");
	//�i�� OPEN_ID�{��, �B�{�ҳq�L
	if( $obj->getResponseStatus($msg) >0) {
		$_POST['log_id']='';
		$_POST['log_pass']='';
		$_POST['log_who']='�Юv';
  	$arr= $obj->getResponseArray();
  	//�}�l��� $arr['tcguid'] �O�_�P sfs ��Ʈw�̪������Ҧr���۲�
  	//�� teach_base �̪� teach_person_id ���X
  	$sql="select teach_id,teach_person_id,login_pass from teacher_base where teach_condition=0";
		$res=$CONN->Execute($sql);
		while ($row=$res->FetchRow()) {
		  $ID_SHA=hash('sha256',$row['teach_person_id']);
		  //���
    	//�p�G���Ҧ��\, �� $_POST['log_id'] , $_POST['log_pass'] , $_POST['log_who'] ��J��� ,
  		//�õ��O $OpenID_login=1 , �H�K $log_pass ���n���� pass_operate �禡
			if ($arr['tcguid']==$ID_SHA) {
		   $_POST['log_id']=$row['teach_id'];
		   $OpenID_LOG_PASS=$row['login_pass'];
		   $LDAP['enable']=0; //�� LDAP ��������
		   $OpenID_login=1;
		   //echo $_POST['log_id'];
		   break;
		  } // end if
		} // end while

	}	
} //================================================================

/*
//session_register("session_log_id"); 
//session_register("session_log_pass");
//session_register("session_tea_name");
//session_register("session_tea_sn");
//session_register("session_prob_open");
//session_register("session_who");
//session_register("session_login_chk");
*/
//�p�G�۵M�H���ҵn�J���ҥ�, �ɦV��@��n�J
if ($_REQUEST['cdc'] && !$CDCLOGIN) header("Location: ".$SFS_PATH_HTML."login.php");

//�p�G�Ħ۵M�H���ҵn�J, �h���ͩ���
if ($_REQUEST['cdc'] && $_POST['id4']=="") {
	set_encrypt();
}

if ($_POST['id4']) $_POST[log_who]="CDC";

//�����h��ݪť�
$_POST['log_id']=trim($_POST['log_id']);
$_POST['log_pass']=trim($_POST['log_pass']);

//�ˬd�K�X���A
if (!empty($_POST['log_pass']))
	$_SESSION['session_login_chk']=pass_check($_POST['log_pass'],$_POST['log_id']);

//�t�X���ߺݪ�������,�O���Ǯ�ID
$session_prob = get_session_prot();
//session_register($session_prob);

//�ѨM���X�n�J���D
if (strstr($_POST['log_id'],"'")) {
	$_POST['log_id']=str_replace("'", "", $_POST['log_id']);
	bad_login($_POST['log_id'],1);
}
$_POST['log_pass']=str_replace("'", "", $_POST['log_pass']);

//���׳s���|�յn�J
if (chk_login_err()) $_POST[log_who]="";

if ($_POST['log_who']=='�Юv')
	//�ĥ� OpenID�n�J�ɡA���ҳq�L�A�K�X�۰ʦ۸�Ʈw���X�A���ݦA�N�K�X�s�X
	$log_pass = ($OpenID_login==1)?$OpenID_LOG_PASS:pass_operate($_POST['log_pass']);
	//$log_pass = pass_operate($_POST['log_pass']);
else 
   $log_pass = $_POST['log_pass'];

// �T�w�s�u����
if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

// �n�X
if ($_GET['logout'] == "yes"){
	$CONN -> Execute ("update pro_user_state set pu_state=0,pu_time_over=now() where teacher_sn='{$_SESSION['session_tea_sn']}'") or user_error("��s���ѡI",256);
	session_destroy();
	setcookie(session_name(),'',time()-3600);
        $_SESSION = array();
	header("Location: $SFS_PATH_HTML");
}
 
//�YOpenID�w���ҳq�L, ���L�Ϥ��ˬd
if (!$OpenID_login) {
  //�n�J�Ϥ����
  if (!chk_login_img($_SESSION["Login_img"],$_POST["log_pass_chk"])) $log_pass="";
  //kitten
  if ($_SESSION['CAPTCHA']['TYPE']==1 && $_SESSION["kittenCheck"]!="OK") $log_pass="";
}
switch($_POST[log_who]){
	case "�Юv":
	$REFERER=login_chk_teacher($_POST['log_id'],$log_pass);
	$REFERER = preg_replace('!\r|\n.*!s','',$REFERER);
	header("location: $REFERER");
	break;
	
	case "CDC":
	$REFERER=login_chk_cdc();
	$REFERER = preg_replace('!\r|\n.*!s','',$REFERER);
	header("location: $REFERER");
	break;

	case "�a��":
	$REFERER=login_chk_parent($_POST['log_id'],$log_pass);
	$REFERER = preg_replace('!\r|\n.*!s','',$REFERER);
	header("location: $REFERER");
	break;
	
	case "�ǥ�":
	$REFERER=login_chk_student($_POST['log_id'],$log_pass);
	$REFERER = preg_replace('!\r|\n.*!s','',$REFERER);
	header("location: $REFERER");
	break;
	
	case "��L":
	$REFERER=login_chk_other($_POST['log_id'],$log_pass);
	$REFERER = preg_replace('!\r|\n.*!s','',$REFERER);
	header("location: $REFERER");
	break;
	
	default:
	head("�K�X�ˬd", "", 1);
	include $THEME_FILE."_login.php";
	foot();
}

// ��X��¾���ŦX�ӱb���K�X���Юv
function login_chk_teacher($log_id = "", $log_pass = ""){
	global $CONN,$SFS_PATH_HTML,$session_prob,$LDAP,$OpenID_login;
	if (!get_magic_quotes_gpc()) {
              $log_id=addslashes($log_id) ;
              $log_pass=addslashes($log_pass) ;
        }

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	
	//�Y LDAP �Ҳձҥ�, �i�� LDAP �b������
  if ($LDAP['enable']) {
    $LDAP_LOGIN=login_chk_from_ldap("�Юv");
  } 
 
   //�Y LDAP�n�J���\��LDAP���Ұʫh�H���`�{������
  if (($LDAP['enable']==1 and $LDAP_LOGIN==true) or $LDAP['enable']==0) {  	 


	$sql_select = " select teacher_sn,name, login_pass from teacher_base where teach_condition = 0 and teach_id='$log_id' and login_pass='$log_pass' and teach_id<>''";
	$recordSet = $CONN -> Execute($sql_select) or trigger_error("��Ƴs�����~�G" . $sql_select, E_USER_ERROR);
        
	while(list($teacher_sn, $name , $login_pass) = $recordSet -> FetchRow()){
		$_SESSION['session_log_id'] = $log_id;
		$_SESSION['session_log_pass'] = $login_pass;
		$_SESSION['session_tea_sn'] = $teacher_sn;
		$_SESSION['session_tea_name'] = $name;
		$_SESSION['session_who'] = "�Юv";
		$_SESSION[$session_prob] = get_prob_power($teacher_sn,"�Юv");
		login_logger($teacher_sn,"�Юv");
		
		// ��s ldap �K�X
		$ldap_password = createLdapPassword($_POST['log_pass']);
		$query = "UPDATE teacher_base SET ldap_password='$ldap_password' WHERE teach_id='$log_id'";
		$CONN -> Execute($query);
		
		// �O���ϥΪ̪��A
		$query = "insert into pro_user_state (teacher_sn,pu_state,pu_time,pu_ip) values($teacher_sn,1,now(),'{$_SERVER['REMOTE_ADDR']}')";
		$CONN -> Execute($query) or user_error("�s�W���ѡI<br>$query",256);
		$REFERER=($_SERVER[HTTP_REFERER]==($SFS_PATH_HTML."login.php"))?$SFS_PATH_HTML."index.php":$_SERVER[HTTP_REFERER];
		return $REFERER;
	} // end while 
  
  }
	bad_login($log_id,2);
	return $_SERVER[HTTP_REFERER];
}


// ��X�a����Ƥ��ŦX�ӱb���K�X���a��
function login_chk_parent($log_id = "", $log_pass = ""){
	global $CONN,$SFS_PATH_HTML,$session_prob;

	if (!get_magic_quotes_gpc()) {
              $log_id=addslashes($log_id) ;
              $log_pass=addslashes($log_pass) ;
        }
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$AA = $CONN -> Execute("select * from parent_auth where 1=0") or user_error("Ū�����ѡI",256);
	if($AA){
		$sql_select = "select parent_id,parent_sn,parent_pass from parent_auth where (parent_id='$log_id' or login_id='$log_id') and parent_pass='$log_pass' and enable=2";
		//echo $sql_select;
		$recordSet = $CONN -> Execute($sql_select) or trigger_error("��Ƴs�����~�G" . $sql_select, E_USER_ERROR);
		while(list($login_id,$parent_sn,$parent_pass) = $recordSet -> FetchRow()){
			$_SESSION['session_log_id'] = $log_id;
			$_SESSION['session_log_pass'] = $parent_pass;
			$_SESSION['session_tea_sn'] = $parent_sn;
			//��X�a���m�W
			$parent_name=parent_name($parent_sn);
			$_SESSION['session_tea_name'] = $parent_name;
			//echo $login_id.$parent_sn.$name;
			$_SESSION['session_who'] = "�a��";
			$_SESSION[$session_prob] = get_prob_power($parent_sn,"�a��");
			login_logger($teacher_sn,"�a��");

			$REFERER=($_SERVER[HTTP_REFERER]==($SFS_PATH_HTML."login.php"))?$SFS_PATH_HTML."index.php":$_SERVER[HTTP_REFERER];
			return $REFERER;
		}
	}
	bad_login($log_id,2);
	return $_SERVER[HTTP_REFERER];	
}

// ��X�ǥ͸�Ƥ��ŦX�ӱb���K�X���ǥ�
function login_chk_student($log_id = "", $log_pass = ""){
	global $CONN,$SFS_PATH_HTML,$session_prob,$LDAP;
	if (!get_magic_quotes_gpc()) {
              $log_id=addslashes($log_id) ;
              $log_pass=addslashes($log_pass) ;
        }
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	
	//�Y LDAP �Ҳձҥ�, �i�� LDAP �b������
	
  if ($LDAP['enable1']) {
    $LDAP_LOGIN=login_chk_from_ldap("�ǥ�");    
  } 
  
  //�Y LDAP�n�J���\��LDAP���Ұʫh�H���`�{������
  if (($LDAP['enable1']==1 and $LDAP_LOGIN==true) or $LDAP['enable1']==0) {  	 
    
	$sql_select = "select student_sn,stud_name, email_pass from stud_base where stud_id='$log_id' and stud_study_cond in (0,15) and email_pass='$log_pass' and stud_id <>''";
	$recordSet = $CONN -> Execute($sql_select) or trigger_error("��Ƴs�����~�G" . $sql_select, E_USER_ERROR);
	
	while(list($student_sn,$name,$email_pass) = $recordSet -> FetchRow()){
		$_SESSION['session_log_id'] = $log_id;
		$_SESSION['session_tea_sn'] = $student_sn;
		$_SESSION['session_log_pass'] = $email_pass;
		$_SESSION['session_tea_name'] = $name;
		$_SESSION['session_who'] = "�ǥ�";
		$_SESSION[$session_prob] = get_prob_power($student_sn,"�ǥ�");
		login_logger($teacher_sn,"�ǥ�");
		
		// ��s ldap �K�X
		$ldap_password = createLdapPassword($_POST['log_pass']);
		$query = "UPDATE stud_base SET ldap_password='$ldap_password' WHERE stud_id='$log_id'";
		$CONN -> Execute($query);
		
		
		// �O���ϥΪ̪��A
		$query = "insert into pro_user_state (teacher_sn,pu_state,pu_time,pu_ip) values($student_sn,1,now(),'{$_SERVER['REMOTE_ADDR']}')";
		$CONN -> Execute($query) or user_error("�s�W���ѡI<br>$query",256);
		$REFERER=($_SERVER[HTTP_REFERER]==($SFS_PATH_HTML."login.php"))?$SFS_PATH_HTML."index.php":$_SERVER[HTTP_REFERER];
		return $REFERER;
	}
  }
	bad_login($log_id,2);
	return $_SERVER[HTTP_REFERER];
}


//��X�a���m�W
function parent_name($parent_sn = ""){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$sql_parent_name = "select sd.guardian_name from  stud_domicile as sd , parent_auth as pa where  sd.guardian_p_id=pa.parent_id  and pa.parent_sn='$parent_sn'";	
	$rs_parent_name =$CONN -> Execute($sql_parent_name) or trigger_error("��Ƴs�����~�G" . $sql_select, E_USER_ERROR);		
	$parent_name=$rs_parent_name->fields['guardian_name'];	
	return $parent_name;
}

// ��X��L���
function login_chk_other($log_id = "", $log_pass = ""){
	global $CONN,$SFS_PATH_HTML,$session_prob;
	
	return $_SERVER[HTTP_REFERER];
}

// ��X���U���ҧǸ��ŦX���Юv
function login_chk_cdc(){
	global $CONN,$SFS_PATH_HTML,$session_prob,$_POST;
	
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	if ($_POST['id4']) {
		$cdc = new CDC();
		$cdc->setCerSn($_POST['serialnumber']);
		$cdc->setPtxt($_SESSION['ToBeSign']);
		$cdc->setEtxt($_POST['encrypted']);
		$cdc->setCert($_POST['pk']);
		$isValid = $cdc->cerLogin();
		if ($isValid == 1) {
			$_SESSION['CerSn'] = $cdc->cer_sn;
			$sql_select = " select teacher_sn, name, login_pass, teach_id from teacher_base where teach_condition = 0 and cerno='".$cdc->cer_sn."' and teach_id<>''";
			$recordSet = $CONN -> Execute($sql_select) or trigger_error("��Ƴs�����~�G" . $sql_select, E_USER_ERROR);

			if ($recordSet->RecordCount() == 0) 
				return  $SFS_PATH_HTML.'login.php?cdc=1&cdc_error=1';
			
			
			while(list($teacher_sn, $name , $login_pass, $log_id) = $recordSet -> FetchRow()){
				$_SESSION['session_log_id'] = $log_id;
				$_SESSION['session_log_pass'] = $login_pass;
				$_SESSION['session_tea_sn'] = $teacher_sn;
				$_SESSION['session_tea_name'] = $name;
				$_SESSION['session_who'] = "�Юv";
				$_SESSION[$session_prob] = get_prob_power($teacher_sn,"�Юv");
				login_logger($teacher_sn,"�Юv");

				// �O���ϥΪ̪��A
				$query = "insert into pro_user_state (teacher_sn,pu_state,pu_time,pu_ip) values($teacher_sn,1,now(),'{$_SERVER['REMOTE_ADDR']}')";
				$CONN -> Execute($query) or user_error("�s�W���ѡI<br>$query",256);
				$REFERER=($_SERVER[HTTP_REFERER]==($SFS_PATH_HTML."login.php?cdc=1")||$_SERVER[HTTP_REFERER]==($SFS_PATH_HTML."login.php"))?$SFS_PATH_HTML."index.php":$_SERVER[HTTP_REFERER];
				return $REFERER;
			}
		}
	}

	bad_login($log_id,2);
	
	return $_SERVER[HTTP_REFERER];
}

//�O�����~�n�J
function bad_login($log_id="",$err_kind=0) {
	global $CONN,$REMOTE_ADDR;

	$err_arr=array("1"=>"�æ�������X����(SQL Injection)","2"=>"�@��n�J���~","3"=>"�b�����s�b","4"=>"�Ӯv�D�b¾","5"=>"�ӥͫD�b�y","6"=>"�Ӯa���b�����}�q");
	switch($err_kind){
		case 2:
			$query="select * from teacher_base where teach_id='$log_id'";
			$res=$CONN->Execute($query);
			if ($res->fields[teach_condition]=='') {
				$query="select * from stud_base where stud_id='$log_id' order by stud_study_year desc";
				$res=$CONN->Execute($query);
				if ($res->fields[stud_study_cond]=='') {
					$query="select * from parent_auth where parent_id='$log_id'";
					$res=$CONN->Execute($query);
					if ($res->fields[enable]=='') {
						$err_kind=3;
					} elseif ($res->fields[enable]!='2') {
						$err_kind=6;
					}
				} elseif ($res->fields[stud_study_cond]!='0') {
					$err_kind=5;
				}
			} elseif ($res->fields[teach_condition]!='0') {
				$err_kind=4;
			}
		case 1:
			$CONN->Execute("insert into bad_login (log_id,log_ip,err_kind,log_time) values ('$log_id','$REMOTE_ADDR','".$err_arr[$err_kind]."','".date("Y-m-d H:i:s")."')");
			break;
	}
}

//�έp�s����յn�J
function chk_login_err() {
	global $CONN,$REMOTE_ADDR,$UPLOAD_PATH;

	//Ū�]�w��
	$temp_file=$UPLOAD_PATH."system/bad_login_protect";

	if (!is_file($temp_file)) return false;

	$fp=fopen($temp_file,"r");
	$k=fgets($fp,10);
	fclose($fp);
	if (intval($k)<1) $k=3;

	$query="select * from bad_login where log_ip='$REMOTE_ADDR' and log_time>'".date("Y-m-d H:i:s",strtotime("-1 minute"))."'";
	$res=$CONN->Execute($query);
	if ($res) {
		if ($res->RecordCount()>$k) return true;
	}
}

//�O���n�J�O��
function login_logger($tea_sn,$who) {
	global $CONN,$REMOTE_ADDR;

	if ($tea_sn!="" && $who!="") {
		$t=date("Y-m-d H:i:s", time());
		$query="select count(teacher_sn) as n from login_log_new where teacher_sn = '$tea_sn' and who = '$who'";
		$res=$CONN->Execute($query);
		$num=$res->fields['n'];
		if ($num>9) {
			$query="delete from login_log_new where teacher_sn = '$tea_sn' and who = '$who' and (no='0' or no>'9')";
			$CONN->Execute($query);
			$query="update login_log_new set no=no-1 where teacher_sn = '$tea_sn' and who = '$who' order by teacher_sn,no";
			$CONN->Execute($query);
			$num=9;
		}
		$CONN->Execute("insert into login_log_new (teacher_sn,who,no,login_time,ip) values ('$tea_sn','$who','$num','$t','$REMOTE_ADDR')");
	}
}

function set_encrypt() {
	$seed_arr = array_merge(range("0","9"),range("A","Z"));
	$seed_arr = array_merge($seed_arr,range("a","z"));
	mt_srand((double)microtime()*1000000);
	for($i=0;$i<24;$i++) $p .= $seed_arr[mt_rand(0,61)];
	$_SESSION['ToBeSign'] = $p;
}

//2013.09.27
function login_chk_from_ldap($who) {
	global $CONN,$LDAP;

	$log_id=$_POST['log_id'];
	$log_pass=$_POST['log_pass'];
		
	$server_ip = $LDAP['server_ip'];								//LDAP SERVER IP
	$server_port = $LDAP['server_port'];						//LDAP SERVER PORT
	$bind_dn = $LDAP['bind_dn'];										//LDAP �b���n bind �� DN
	$dn=$log_id."@".$bind_dn;												//Windows AD bind �榡
	//$bind_dn_x=explode(".",$bind_dn);
	//$rdn="CN=".$log_id;
	//foreach($bind_dn_x as $v) { $rdn.=",DC=".$v; }	//Linux OpenLDAP bind �榡					
	
	//�i��s�u
	$ldap_conn=ldap_connect($server_ip,$server_port) or die("SORRY~~Could not cnnect to LDAP SERVER!!");
	//�H�U���ȥ��[�W�A�_�h Windows AD �L�k�b�����w OU �U�A�@�j�M���ʧ@
 	ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
 	ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);


  //AD�覡
	$ldapbind=ldap_bind($ldap_conn,$dn,$log_pass);
	
	//OpenLDAP �榡 , ���[ ou
	if (!$ldapbind) {
		$rdn = $LDAP['base_uid']."=$log_id,".$LDAP['base_dn'];
		$ldapbind=ldap_bind($ldap_conn,$rdn,$log_pass);	
	}

	//OpenLDAP �榡 , �[�W�Юv ou
	if (!$ldapbind and $LDAP['teacher_ou']!='') {
		$rdn1 = $LDAP['base_uid']."=$log_id,ou=".$LDAP['teacher_ou'].",".$LDAP['base_dn'];
		$ldapbind=ldap_bind($ldap_conn,$rdn1,$log_pass);	
	}

	//OpenLDAP �榡 , �[�W�ǥ� ou
	if (!$ldapbind and $LDAP['stud_ou']!='') {
		$rdn2 = $LDAP['base_uid']."=$log_id,ou=".$LDAP['stud_ou'].",".$LDAP['base_dn'];
		$ldapbind=ldap_bind($ldap_conn,$rdn2,$log_pass);	
	}
	
	if ($ldapbind and $log_pass<>"") {
		ldap_unbind($ldap_conn);
	//�n�J���\ , �u�����ǥͤήa��
	  $chk_ok=0;
		switch ($who) {
    	case '�Юv':
    		//�ˬd�Юv��Ʈw���L���H
        $sql_select = "select teacher_sn from teacher_base where teach_condition = 0 and teach_id='$log_id' and teach_id<>''";
				$res=$CONN->Execute($sql_select);
				if ($res->RecordCount()==1) {
				  $teacher_sn=$res->fields['teacher_sn'];
				  //�^�g�K�X
				  $sql="update teacher_base set login_pass ='".pass_operate($log_pass)."' where teacher_sn='$teacher_sn'";
				  $CONN->Execute($sql) or die('SQL�o�Ϳ��~! sql='.$sql);				  
				  $chk_ok=1;
				}
        break;
    	case '�ǥ�':
    		//�ˬd�ǥ͸�Ʈw���L���H
    		$sql_select = "select student_sn,stud_name, email_pass from stud_base where stud_id='$log_id' and stud_study_cond in (0,15) and stud_id <>''";
				$res=$CONN->Execute($sql_select);
				if ($res->RecordCount()==1) {
				  $student_sn=$res->fields['student_sn'];
				  //�^�g�K�X
				  $sql="update stud_base set email_pass ='".$log_pass."' where student_sn='$student_sn'";
				  $CONN->Execute($sql) or die('SQL�o�Ϳ��~! sql='.$sql);				  
				  $chk_ok=1;
				}
        break;
		} // end switch
		if ($chk_ok) {
			return 1;
		} else {
			return 0;
		}
	} else {
	//�n�J����
		return 0;
	}

}
?>
