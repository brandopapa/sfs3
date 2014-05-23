<?php
// $Id: sfs_core_auth.php 8041 2014-05-21 06:17:17Z brucelyc $

function sfs_check($go_back=1) {
	global $CONN,$SFS_PATH_HTML,$THEME_FILE,$scripts, $CDCLOGIN;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	// �{�ҼҦ�
	$auth_kind = 0;
	if(!empty($_REQUEST[_Msn])){
		$curr_msn=$_REQUEST[_Msn];
	}elseif(empty($_REQUEST[_Msn]) and $_SERVER[SCRIPT_NAME]!="/index.php"){
		$SCRIPT_NAME=$_SERVER[SCRIPT_NAME];
		$SN=explode("/",$SCRIPT_NAME);
		$m=getDBdata("",$SN[count($SN)-2]);
		$curr_msn=$m[msn];
		$auth_kind = $m['auth_kind'];		
	}
	
	$cdc_check_ok = true;
	if ($CDCLOGIN) { 	// �ˬd�۵M�H����
		
		switch ($auth_kind){
			case 3: // ���Y��
			 if (!isset($_SESSION['CerSn']) or  !check_home_ip()) {		 	
			 	$cdc_check_ok = false;
			 	$message = '�����@�~�����b�դ��ϥΦ۵M�H���ҡA�~��ާ@';
			 }
			 break;
			case 2: // �Y��
				if (!isset($_SESSION['CerSn'])) {
					$cdc_check_ok = false;
					$message = '�����@�~�����ϥΦ۵M�H���ҡA�~��ާ@';
				}
				break;
			case 1: // �ԷV
				if (!check_home_ip() and !isset($_SESSION['CerSn']) ) {
					$cdc_check_ok = false;
					$message = '�����@�~�����ϥΦ۵M�H���ҡA�~��ާ@';
				}
				break;
			case 4: //�ȯ�b�դ��ϥ�
				
				if (!check_home_ip()) {
					$cdc_check_ok = false;
					$message = '�����@�~�ȯ�b�դ��~��ާ@';
				}
				break;
		}
		
		//echo $auth_kind;
		if (!$cdc_check_ok) {
			head("������ާ@","",1);
			echo "<table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><tr><td>
			<h2>$message</h2>
			<h3>�z��IP�Ӧ�: {$_SERVER['REMOTE_ADDR']}
			</td></tr></table>";
			foot();
			exit;
		}
	}
//	$sql_select = "SELECT isopen FROM sfs_module where msn=$curr_msn";
//	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
//	list($isopen)=$recordSet->FetchRow();

//	if($isopen)return;

//	if($_SESSION['session_who']){
	if (!checkid2($_SESSION['session_who'])){
		session_destroy();
	}
//	}

	if($_SESSION['session_login_chk']&&(array_pop($scripts)!="chpass")&&($_SESSION['session_who'])=="�Юv"){
			head("�K�X�����ܧ�","",1);
			echo "<table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFF829' width='80%' align='center'><form action='".$SFS_PATH_HTML."modules/chpass/teach_cpass.php' method='post'><tr><td align='center'><h1><img src='../../images/warn.png' align='middle' border=0>�K�X�����ܧ�</h1></font></td></tr><tr><td align='center' bgcolor='#FFFFFF' width='90%'>�z���K�X�]<font color='red'>�u".$_SESSION['session_login_chk']."�v</font>�ҥH�����ܧ�C<br></td></tr><tr><td align=center><input type='submit' value='�ܧ�K�X'><br></td></tr></form></table>";
			foot();
			exit;
	}

	if(!checkid($_SERVER['SCRIPT_NAME'])){

			head("�K�X�ˬd","",1);
			include "$THEME_FILE"."_login.php";
			foot();
			exit;

	}

}

//���v�ǥͰ���Ҳջ{�Ҩ禡URL
function sfs_check_stu($set_class=0) {
	global $SFS_PATH_HTML;
	return "$SFS_PATH_HTML"."include/sfs_case_studauth.php?chkpath={$_SERVER['SCRIPT_FILENAME']}&set_class=$set_class";
}


//�����d����
function checkid($chk,$chk_admin=0){
	global $CONN;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	session_start();
	// �ˬdsession id �O�_���T
	sessionVerify();
	//���o�Ǯձ��v session ,hami 2003-3-5
	$session_prob = get_session_prot();
	//�ˬd $_SESSION[$session_prob] �O�_���Ű}�C
	if (!check_prob_kind($_SESSION[$session_prob]))
		return false;
	if(!$chk_admin)	$chk = $_SERVER['SCRIPT_FILENAME'];
 	$curr_file= get_path($chk); //���o�{�����|
	$dirname=explode("/",$curr_file);
	$query = "select *  from sfs_module where  islive='1' and dirname='$dirname[1]'";
	$result = $CONN->Execute($query) or $CONN->ErrorMsg();
	if ($result->EOF){
		return false;
	}
	//print_r($result->FetchRow());
	//print_r($_SESSION);
	list($pro_kind_id,$isopen)=$result->FetchRow();
	if($chk_admin==0 and !is_null($_SESSION[$session_prob][$pro_kind_id])){
		return true;
	}elseif($chk_admin=='1'){
		//�޲z�v�P�O
		//��e�i�H¾�ٰ��P�_(prolin92/8/19)
		$query=" SELECT teach_title_id FROM teacher_post where teacher_sn =$_SESSION[session_tea_sn] " ;
		//echo $query ;
		$result=$CONN->Execute($query);
		list($teach_title_id) = $result->FetchRow();

		$query= "select pro_kind_id from pro_check_new where pro_kind_id=$pro_kind_id and ((id_kind='�Юv' and id_sn=$_SESSION[session_tea_sn] )  or ( id_kind='¾��' and id_sn='$teach_title_id'))and is_admin='1'";
		$result=$CONN->Execute($query);
		if ($result->RecordCount()>0  and !is_null($_SESSION[$session_prob][$pro_kind_id]))
			return true;
	}
	return false;
}

// �ˬdsession id �O�_���T
function sessionVerify() {
                if ( !empty($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
                        $temp_ip = split(",", $_SERVER["HTTP_X_FORWARDED_FOR"]);
                        $user_ip = $temp_ip[0];
                } else {
                        $user_ip = $_SERVER["REMOTE_ADDR"];
                }

                if(!isset($_SESSION['user_agent'])){
                        $_SESSION['user_agent'] = MD5($user_ip.$_SERVER['HTTP_USER_AGENT']);
                        }
                         /* �p�G��session ID�O���y,�h���s���tsession ID */
                elseif ($_SESSION['user_agent'] != MD5($user_ip.$_SERVER['HTTP_USER_AGENT'])) {
                        $old_sessionid = session_id();  
                        session_regenerate_id(TRUE);
                        $new_sessionid = session_id();
                }
}


//����������
function checkid2($who=""){
	global $CONN;

	switch($who){
		case "�Юv":
			$query="select teach_id as id from teacher_base where teach_id='{$_SESSION['session_log_id']}' and teach_condition='0' and login_pass='{$_SESSION['session_log_pass']}'";
		break;

		case "�a��":
			$query="select parent_id as id from parent_auth where parent_id='{$_SESSION['session_log_id']}' and enable='2' and parent_pass='{$_SESSION['session_log_pass']}'";
		break;

		case "�ǥ�":
			$query="select stud_id as id from stud_base where stud_id='$_SESSION[session_log_id]' and email_pass='{$_SESSION['session_log_pass']}'";
		break;

		default:
		return false;
	}

	$r=$CONN->Execute($query);
	return $r->GetRows();
}

//�ˬd�{�ҼҲհ}�C���Ӽ�,�קK�Юv�L�]�w���@�v����,�{�ҿ��~
function check_prob_kind($prob){
	$temp = array_keys($prob);
	if (count($temp)>0)
		return true;
	else
		return false;
}

//���o���ЯZ�ťN��
function get_teach_class() {
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	//�Юv���ЯZ��
	$query = "select class_num from teacher_post where teacher_sn='{$_SESSION['session_tea_sn']}'";
	$result = $CONN->Execute($query) or $CONN->ErrorMsg();
	return  $result->fields[0];
}

//�ˬd���v�ǥ;ާ@�Z�Ũ禡
function check_stu_do_class($chk) {
	global $app_name ,$CONN;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$is_pass = 0;

	if (!$chk_admin)//���o�{�����|
		$chk = $_SERVER['SCRIPT_FILENAME'];

	$curr_file= get_path($chk); //���o�{�����|
	$query = "select b.class_num from pro_kind a ,pro_check_stu b where a.pro_kind_id= b.pro_kind_id and a.store_path='$curr_file'  and b.stud_id = '{$_SESSION['session_log_id']}' " ;
	$result = $CONN->Execute($query) or trigger_error("��Ʈw�s�����~�G $query", E_USER_ERROR);
	return $result->fields[class_num];
}

//�ˬd�O�_������ ip
function check_home_ip($man_ip="") {
	global $HOME_IP, $HOME_IPV6;
	
	if (!$man_ip)
		$man_ip = $HOME_IP;
	else 
		$man_ip = array_merge($man_ip, $HOME_IP);
	
	$flag = false;
    if ($_SERVER["HTTP_X_FORWARDED_FOR"])
       $remoIP=$_SERVER["HTTP_X_FORWARDED_FOR"];
    else
      $remoIP=$_SERVER['REMOTE_ADDR'];

    //�ˬdIPV4 �d��
	for($mi=0 ; $mi< count($man_ip) ;$mi++){
		if ($man_ip[$mi]<>'') {
			$ee = explode ('-',chop($man_ip[$mi]));
			if (count($ee) > 1) { //�� �_�l����IP
				$ee1 = explode ('.',$ee[0]); //�e�@�� IP
				$ee2 = explode ('.',$ee[1]); //��@�� IP
				//$rr = explode ('.',$_SERVER['REMOTE_ADDR']); // access IP
				$rr = explode ('.',$remoIP);
				if ($rr[0 ]== $ee1[0] && $rr[1] == $ee1[1] &&$rr[2]== $ee1[2] && $rr[3] >= $ee1[3] && $rr[3] <= $ee2[3]) {//�ˬd�̫�@�Ӽ�
					$flag = true;
					break;
				}

			}
			else { //�u���@�ճ]�w
				$ee = explode ('.',$man_ip[$mi]);
				if ((count($ee) == 4 && $man_ip[$mi] == $remoIP) || count($ee) < 4 && $man_ip[$mi] == substr($remoIP,0,strlen($man_ip[$mi]))){
					$flag = true;
					break;
				}
			}
		}
	}
	
	// �ˬd IPV6
	if (isset($HOME_IPV6) and !empty($HOME_IPV6)) {		
		$IPV6 = new Tc_IP6();
		$cidr = $HOME_IPV6;
		if( strpos($HOME_IPV6, '/')===false)$cidr= $cidr."/64";
	    if($IPV6->matchCIDR6( $remoIP, $cidr))
	    	$flag =  true;
	}
	return $flag;
}

//���o�Ǯձ��v session
function get_session_prot() {
	$session_prob = $_COOKIE[cookie_sch_id];
	if ($session_prob=='')
	$session_prob  = "DEFAULT";
	return $session_prob;
}

//�ˬd teacher_sn �O�_�s�b pro_user_state

function is_exist_teacher_sn(){
	global $CONN;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	$query = "select teacher_sn from pro_user_state where teacher_sn='$_SESSION[session_tea_sn]' and pu_state=1";
	$res = $CONN->Execute($query) or user_error("Ū�����ѡI<br>$sql_select",256);
	if ($res->RecordCount()>0)
		return true;
	else
		return false;
}

//�ثe�㦳���ި������H
function who_is_root(){
	global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	//pro_kind_id='1'���޲z�ҲաA��ƺ޲z�Ҳ��v���̧Y���޲z�̡C
	$sql_select = "select p_id,id_kind,id_sn,is_admin from pro_check_new where pro_kind_id='1'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	// init $root
	$root=array();
	while (list($p_id,$id_kind,$id_sn,$is_admin) = $recordSet->FetchRow()) {
		$root[$id_sn][id_kind]=$id_kind;
		$root[$id_sn][is_admin]=$is_admin;
		$root[$id_sn][p_id]=$p_id;
	}
	return $root;
}

//���o�Y�a���]���@�H�^�m�W
function get_parent_name($sn=""){
	global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	$sql_select = "select b.guardian_name from parent_auth a, stud_domicile b where a.parent_sn=$sn and a.parent_id=b.guardian_p_id";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	list($guardian_name) = $recordSet->FetchRow();
	return $guardian_name;
}

function pass_operate($pass=""){
	$pass=md5($pass);
	return substr($pass,10).substr($pass,0,9);
}

 function createLdapPassword($password)
{
  return '{MD5}' . base64_encode(pack('H*',md5($password)));	
}



function pass_check($pass="",$lid="",$pid=""){
	global $DEFAULT_LOG_PASS;
	if ($pass==$DEFAULT_LOG_PASS) {
		return "�K�X���i���t�ιw�]�K�X";
	} elseif (strlen($pass)<6) {
		return "�K�X�L�u";
	} elseif (strval(intval($pass))==$pass) {
		return "�K�X���i���ѼƦr�զ�";
	} elseif ($pass==$lid) {
		return "�K�X���i�M�b���ۦP";
	} elseif ($pass==$pid) {
		return "�K�X�̦n���n�O�����Ҧr��";
	}
}

//�ǥͪ��K�X����
function stud_pass_check($pass="",$lid="",$pid=""){
	global $DEFAULT_LOG_PASS;
	if ($pass==$DEFAULT_LOG_PASS) {
		return "�K�X���i���t�ιw�]�K�X";
	} elseif (strlen($pass)<4) {
		return "�K�X�L�u";
	} elseif ($pass==$lid) {
		return "�K�X���i�M�b���ۦP";
	} elseif ($pass==$pid) {
		return "�K�X�̦n���n�O�����Ҧr��";
	}
}

//�ҥεn�J�Ϥ����
function chk_login_img($s="",$v="",$mode=0) {
	global $UPLOAD_PATH;

	//Ū�]�w��
	$temp_file=$UPLOAD_PATH."system/chk_login_img";

	if (!is_file($temp_file))
		return true;
	else {
		if ($mode==1) return false;
		if ($mode==2) {
			$fp=fopen($temp_file,"r");
			while(!feof($fp)) {
				$temp_str=fgets($fp,50);
				$temp_arr=explode("=",$temp_str);
				if (!empty($temp_arr[0])) $c[strtoupper($temp_arr[0])]=intval($temp_arr[1]);
			}
			return $c;
		}
		if ($s==$v)
			return true;
		else
			return false;
	}
}

class CDC
{
        var $cer_sn = "";
        var $cert = "";
        var $cert_status = "";
        var $plain_text = "";
        var $encrypted_text = "";

        function setCerSn($sn="") {
                $sn=trim($sn);
                if ($sn) {
                        $this->cer_sn = $sn;
                }
        }

        function setCert($cert="") {
                $cert=trim($cert);
                if ($cert) {
                        $this->cert = str_replace("<br/>", chr(13).chr(10), $cert);
                }
        }

        function setPtxt($text="") {
                $text = trim($text);
                if ($text) {
                        $this->plain_text = $text;
                }
        }

        function setEtxt($text="") {
                $text = trim($text);
                if ($text) {
                        $this->encrypted_text = $text;
                }
        }

        function downloadCert() {
                $temp = "";

                //������
                if ($this->cer_sn <> "") {
                        $fp=fopen("http://moica.nat.gov.tw/PEXE_MOICA/DownLoadCert.CEXE?CertNo=".$this->cer_sn,"r");
                        while(!feof($fp)) {
                                $temp.=fgets($fp,2048);
                        }
                        fclose($fp);
                        return $temp;
                }
        }

        function readCert() {
                $cer_temp = "";

                if ($this->cert && $this->cer_sn) {
                        //�p�G�U������, �h�B�z�W�Ǫ����Ҥ��e
                        $fp = fopen("/tmp/".$this->cer_sn.".crt","w");
                        fputs($fp,$this->cert);
                        fclose($fp);

                        //�H�F���ھ������ҤW�Ǿ���
                        $output = shell_exec('openssl verify -CAfile '.dirname(__FILE__).'/../GRCA.crt -untrusted '.dirname(__FILE__).'/../MOICA.crt /tmp/'.$this->cer_sn.'.crt');
                        $o_arr = explode(":",$output);
                        if (trim($o_arr[1])<>"OK") {
				$o_arr = array();
				$output = shell_exec('openssl verify -CAfile '.dirname(__FILE__).'/../GRCA2.crt -untrusted '.dirname(__FILE__).'/../MOICA2.crt /tmp/'.$this->cer_sn.'.crt');
				$o_arr = explode(":",$output);
				if (trim($o_arr[1])<>"OK") {
                                	$this->cert_status = "unknown";
                                	return;
				}
                        }

                        //�d�߾��Ҫ��A
                        $output = shell_exec('openssl ocsp -issuer '.dirname(__FILE__).'/../MOICA.crt -CAfile '.dirname(__FILE__).'/../ca_chain.crt -cert /tmp/'.$this->cer_sn.'.crt -url http://moica.nat.gov.tw/cgi-bin/OCSP/ocsp_server.exe -validity_period 600');
                        $output2 = preg_split('/[\r\n]/', $output);
                        $output3 = preg_split('/: /', $output2[0]);
                        $this->cert_status = $output3[1];
                        unlink("/tmp/".$this->cer_sn.".crt");

                        return;
                }
        }

        public function verifySign() {
                if ($this->cert && $this->plain_text && $this->encrypted_text) {
                        $pubkeyid = openssl_pkey_get_public($this->cert);

                        //����
                        if (openssl_verify($this->plain_text, base64_decode($this->encrypted_text), $pubkeyid)) {
                                return 1;//�q�L����
                        } else {
                                return 0;//���ҥ���
                        }
                }
        }

        public function cerLogin() {
                if ($this->cer_sn && $this->plain_text && $this->encrypted_text) {
                        $this->readCert();
                        if ($this->cert_status == "good") {
                                return $this->verifySign();
                        } elseif ($this->cert_status == "revoked") {
                                return -1;
                        } else {
                                return;
                        }
                }
        }
        
        public static function getAuthKind($kind=0) {
        	if ($kind == 0) 
        	return array(0=>'(�e�P) �դ��~�Ҥ�����',4=>'(�դ�)�ȯ�b�դ��ϥ�',1=>'(�ԷV) �դ�������, �ե~������', 2=>'(�Y��) �դ��~�Ҷ�����',3=>'(���Y��) �ȯ�b�դ��H���ҵn�J');
        	elseif ($kind==1)
        	return array(0=>'�e�P',4=>'<span style="color:#e83">�դ�</span>',1=>'<span style="color:#e53">�ԷV</span>', 2=>'<span style="color:#f33">�Y��</span>',3=>'<span style="color:#fff;background:#f00">���Y��</span>');
        }
}


/**
 *   ipv6 class by axer@ms1.boe.tcc.edu.tw
 */

class Tc_IP6 {

	// return interger>0 when IP6 address is valid: not follow RFC 2373, but only check character and segments
	public function isValidIP6( $ip6) {
		if (strpos($ip6, '::') != strrpos($ip6, '::'))return -1; //Double ::
		if (strpos($ip6, '::') !== false) $ip6 = str_replace('::', str_repeat(':0', 8 - substr_count($ip6, ':')).':', $ip6);
		$ip6= strtoupper($ip6);
		$ip6parts = explode(':', $ip6);
		if( sizeof($ip6parts)!=8 )return -2; //Wrong seg
		if( preg_match( "/^[0-9ABCDEF:]+$/m",$ip6) <= 0){
			return -3;  //Illegel char.
		}
		return 1;
	}

	// ��z IP�A�^�Ǿ�z�L�� IP�A�����ɺ�0 ex:2001:0288:5400:0000:0000:0000:0000:0001
	public function normalizeIP6( $ip6){
		if (strpos($ip6, '::') !== false) $ip6 = str_replace('::', str_repeat(':0', 8 - substr_count($ip6, ':')).':', $ip6);
		$ip6= strtoupper($ip6);
		$ip6parts = explode(':', $ip6);
		$res="";
		foreach($ip6parts as $it){
			$res .= sprintf("%04s", $it).":";
		}
		$res = substr( $res, 0, -1);
		return $res;
	}

	// �NIP6����}��z����²���A ex: //2001:288:5400:0:0:0:0:1=>2001:288:5400::1
	public function foldingIP6( $ip6){
		if (strpos($ip6, '::') !== false) $ip6 = str_replace('::', str_repeat(':0', 8 - substr_count($ip6, ':')).':', $ip6);
		$ip6parts = explode(':', $ip6);
		$res="";
		//remove zero 0001=>1
		foreach($ip6parts as $it){
			$dec=base_convert( $it, 16, 10);
			$hex=strtoupper(base_convert( $dec, 10, 16));
			$res .= $hex .":";
		}
		$res = substr( $res, 0, -1);  //2001:288:5400:0:0:0:0:1
		for($ii=7; $ii>1; $ii--)
			if( $n = substr_count($res, str_repeat(':0',$ii))==1){
			$res=str_replace(str_repeat(':0',$ii),":",$res, $cnt);
			break;
			}
			return $res;
	}

	/**
	*   ExpandIPv6Notation2Bin()-  Convert an ipv6 address to bin string
	*   @param string $ip6 - an ipv6 address
	*   @return return the binary string of an ipv6 address if parameter ip6 is an ipv6 address,
	*           else it return an empty string.
	*/
	public function ExpandIPv6Notation2Bin($ip6) {
	if (strpos($ip6, '::') !== false)
		$ip6 = str_replace('::', str_repeat(':0', 8 - substr_count($ip6, ':')).':', $ip6);
				$ip6parts = explode(':', $ip6);
						$res="";
	foreach ($ip6parts as $part)
		$res .= str_pad(base_convert( $part, 16, 2), 16, 0, STR_PAD_LEFT);
		return $res;
	}

	/**
	*   MatchCIDR6 -- Check if an ipv6 address is in the CDIR6 subnet.
	*   @param string $cidr6 - an ipv6 subnet, ex 2001:288:5400/39 or 2001:288:5432:/64 or 2001:288:5478::/64..
	*   @param string $chkipv6 - an ipv6 address, ex ::1, 2001:288:5200::1, :: ,etc.
	*   @return return true if $chkipv6 is inside the $cidr6 subnet, or return false.
	*/
	public function MatchCIDR6( $chkipv6, $cidr6)
	{
		list($ip6, $prefixlen) = explode('/', $cidr6);
		$cidrbin= substr( $this->ExpandIPv6Notation2Bin($ip6), 0, $prefixlen);
		$chkip6bin= substr( $this->ExpandIPv6Notation2Bin($chkipv6), 0, $prefixlen);
		
		if(! strcmp($cidrbin,$chkip6bin))return true;
		return false;
	}
	
	function GetRealRemoteIp($ForDatabase= false, $DatabaseParts= 2) {
		$Ip = '0.0.0.0';
		if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] != '')
			$Ip = $_SERVER['HTTP_CLIENT_IP'];
		elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '')
		$Ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '')
		$Ip = $_SERVER['REMOTE_ADDR'];
		if (($CommaPos = strpos($Ip, ',')) > 0)
			$Ip = substr($Ip, 0, ($CommaPos - 1));
	
		$Ip = $this->IPv4To6($Ip);
		return ($ForDatabase ? IPv6ToLong($Ip, $DatabaseParts) : $Ip);
	}
	
	/**
	 * Convert an IPv4 address to IPv6
	 *
	 * @param string IP Address in dot notation (192.168.1.100)
	 * @return string IPv6 formatted address or false if invalid input
	 */
	function IPv4To6($Ip) {
		static $Mask = '::ffff:'; // This tells IPv6 it has an IPv4 address
		$IPv6 = (strpos($Ip, '::') === 0);
		$IPv4 = (strpos($Ip, '.') > 0);
	
		if (!$IPv4 && !$IPv6) return false;
		if ($IPv6 && $IPv4) $Ip = substr($Ip, strrpos($Ip, ':')+1); // Strip IPv4 Compatibility notation
		elseif (!$IPv4) return $Ip; // Seems to be IPv6 already?
		$Ip = array_pad(explode('.', $Ip), 4, 0);
		if (count($Ip) > 4) return false;
		for ($i = 0; $i < 4; $i++) if ($Ip[$i] > 255) return false;
	
		$Part7 = base_convert(($Ip[0] * 256) + $Ip[1], 10, 16);
		$Part8 = base_convert(($Ip[2] * 256) + $Ip[3], 10, 16);
		return $Mask.$Part7.':'.$Part8;
	}
	
 }
?>
