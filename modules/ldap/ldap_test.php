<?php
include_once('config.php');

sfs_check();

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

$LDAP=get_ldap_setup();

//POST �᪺�ʧ@
if ($_POST['act']=="login") {
	$log_id=$_POST['log_id'];
	$log_pass=$_POST['log_pass'];
		
	$server_ip = $LDAP['server_ip'];			//LDAP SERVER IP
	$server_port = $LDAP['server_port'];						//LDAP SERVER PORT
	$bind_dn = $LDAP['bind_dn'];										//LDAP �b���n bind �� DN
	$dn=$log_id."@".$bind_dn;							
	//$bind_dn_x=explode(".",$bind_dn);
	//$rdn="CN=".$log_id;
	//foreach($bind_dn_x as $v) { $rdn.=",DC=".$v; }
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
	
	//OpenLDAP�榡 , �� rdn�H base_dn���]�w�ȭ���
	//if (!$ldapbind) {
	//	$rdn1="CN=".$log_id.",".$LDAP['base_dn'];
	//	$ldapbind=ldap_bind($ldap_conn,$rdn1,$log_pass);	
	//}
	
	if ($ldapbind and $log_pass<>"") {
		$INFO="���ߡA�H�b�� $log_id �i��LDAP�{�Ҧ��\�I";
	} else {
	 $INFO="�H $dn �B $rdn �B$rdn1 �B$rdn2 �i�� LDAP �{�Ҭҥ��ѡA�Y�T�{LDAP���A���W���b���K�X�L�~�A�Фűҥ� LDAP�n�J�I�H�K�y���ǰȨt�εL�k�n�J���~��!!!<br>���w���_���A�n�J�Ҧ��w�j��]���u�D���n�J�v�A�нT�{�n�J�i���\�A�ҥ� LDAP�n�J�C";
	 $query="update ldap set enable='0' where sn='1'";
   $CONN->Execute($query);	 
	}
  
  ldap_unbind($ldap_conn);
  
}


//�q�X SFS3 ���D
head();

//�C�X���
echo $tool_bar;

if (!extension_loaded("ldap")) {
	echo "��p�I�A�� PHP �å��ҥ� LDAP �M��A���pô�t�κ޲z���i��w�ˡC";
	exit();
 } 



?>
<form name="myform" method="post" act="<?php echo $_SEVER['PHP_SELF'];?>">
	<input type="hidden" name="act" value="">
	
	<table border="0" bordercolor="#000000" style="border-collapse:collapse">
		<tr><td style="color:#FF0000"><?php echo $INFO;?></td></tr>
		<tr>
			<td>LDAP �b���n�J���� </td>
		</tr>
		<tr>
			<td>
			 	<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse;' bordercolor='#111111'>
							<tr>
								<td bgcolor="#FFCCFF" valign="top">LDAP�n�J�b��</td>
								<td bgcolor="#FFFFCC"><input type="text" name="log_id" value="" size="20"></td>
							</tr>
							<tr>
								<td bgcolor="#FFCCFF" valign="top">LDAP�b���K�X</td>
								<td bgcolor="#FFFFCC"><input type="password" name="log_pass" value="" size="30">
								</td>
							</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td><input type="button" value="�n�J����" onclick="document.myform.act.value='login';document.myform.submit();"><font color=red size=2>
				<br>
				�������G�Y�ǰȨt�Φ����Ѿǥ͵n�J�A�i�@�ֶi��ǥͱb�����աC
				</td>
		</tr>
	</table>
</form>
