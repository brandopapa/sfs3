<?php
include_once('config.php');

sfs_check();

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//POST �᪺�ʧ@
if ($_POST['act']=="save") {
 foreach($_POST as $K=>$V) {
  ${$K}=$V;
 }

 $query="update ldap set enable='$enable',server_ip='$server_ip',server_port='$server_port',bind_dn='$bind_dn',base_dn='$base_dn', base_uid='$base_uid',chpass_url='$chpass_url',teacher_ou='$teacher_ou',stud_ou='$stud_ou',enable1='$enable1' where sn='1'";
 if ($CONN->Execute($query)) {
   $INFO=" �v��".date("Y-m-d H:i:s")."�i���x�s�ʧ@!";
   $INFO.=($enable)?"�@�`�N�I�аȥ��i�� LDAP�{�Ҵ���!!":"";
 } else {
   echo "SQL�y�k���~�I query=".$query;
   exit();
 }
}

$LDAP=get_ldap_setup();


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
		<tr>
			<td>LDAP �b���n�J�]�w </td>
		</tr>
		<tr>
			<td>
			 	<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse;' bordercolor='#111111'>
							<tr>
								<td bgcolor="#FFCCFF" valign="top">�Юv�n�J�Ҧ�</td>
								<td bgcolor="#FFFFCC">
										<input type="radio" name="enable" value="0"<?php if ($LDAP['enable']==0) echo " checked";?>>�����n�J
										<input type="radio" name="enable" value="1"<?php if ($LDAP['enable']==1) echo " checked";?>>LDAP �n�J
								</td>
							</tr>
							<tr>
								<td bgcolor="#FFCCFF" valign="top">�ǥ͵n�J�Ҧ�</td>
								<td bgcolor="#FFFFCC">
										<input type="radio" name="enable1" value="0"<?php if ($LDAP['enable1']==0) echo " checked";?>>�����n�J
										<input type="radio" name="enable1" value="1"<?php if ($LDAP['enable1']==1) echo " checked";?>>LDAP �n�J
								</td>
							</tr>
							<tr>
								<td bgcolor="#FFCCFF" valign="top">LDAP���A��IP</td>
								<td bgcolor="#FFFFCC">
										<input type="text" name="server_ip" value="<?php echo $LDAP['server_ip'];?>" size="30">
								</td>
							</tr>
							<tr>
								<td bgcolor="#FFCCFF" valign="top">LDAP port</td>
								<td bgcolor="#FFFFCC">
										<input type="text" name="server_port" value="<?php echo $LDAP['server_port'];?>" size="10">
										<br><font color=blue size=2>�@��LDAP���A���w�]�ϥ� 389 �� 636 port</font>
								</td>
							</tr>
							<tr>
								<td bgcolor="#FFCCFF" valign="top">Windows AD �� Bind dn</td>
								<td bgcolor="#FFFFCC">
												�b��@<input type="text" name="bind_dn" value="<?php echo $LDAP['bind_dn'];?>" size="30">
												<br><font color=blue size=2>�Y�b���n�[��DN���X�A�Ҧp: smallduh@fnjh.tc.edu.tw�A�Y��J fnjh.tc.edu.tw</font>
								</td>
							</tr>
							<tr>
								<td bgcolor="#FFCCFF" valign="top">OpenLDAP��Bind dn</td>
								<td bgcolor="#FFFFCC" valign="top">
										�b�����G<input type="text" name="base_uid" value="<?php echo $LDAP['base_uid']?>" size="5" /> <br>
										�Юv�b�� ou �ȡG<input type="text" name="teacher_ou" value="<?php echo $LDAP['teacher_ou']?>" size="10" />
										�A�ǥͱb�� ou �ȡG<input type="text" name="stud_ou" value="<?php echo $LDAP['stud_ou']?>" size="10" />
										<br />
										Base dn�G<input type="text" name="base_dn" value="<?php echo $LDAP['base_dn'];?>" size="40">
										<br><font color=blue size=2>�Ҧp: [OU=Users, ] DC=fnjh, DC=tcc, DC=edu, DC=tw</font>
								</td>
							</tr>
							<tr>
								<td bgcolor="#FFCCFF" valign="top">���K�X�����}url</td>
								<td bgcolor="#FFFFCC"><input type="text" name="chpass_url" value="<?php echo $LDAP['chpass_url'];?>" size="30">
										<br><font color=blue size=2>�ҥ�LDAP�n�J�A�N�L�k���쥻�s�b�ǰȥD�������K�X�A</font>
										<br><font color=blue size=2>�д��ѧ�� LDAP�K�X���W�s�����}�A��ϥΪ̭n��K�X�ɥi���H���ܳs���C </font>
								</td>
							</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td><input type="button" value="�x�s" onclick="document.myform.act.value='save';document.myform.submit();"><font color=red size=2><?php echo $INFO;?></font>
				<br><br><font color=red>���`�N! ���F�P�B�ĪG�A�ĥ� LDAP �n�J���\�A�t�η|�۰��мg LDAP ���b���K�X�ܾǰȥD�����C</font>
				</td>
		</tr>
		<tr style="color:#0000FF">
		 <td>
		 ���]�w�����G<br>
		 1.�Y�z��LDAP�O Windows Server �� Active Directory ���ҡA�z�u�n�]�w Windows AD �� bind dn ���@��Y�i�C<br>
		 2.�Y�z��LDAP�O Linux �� OpenLDAP�A���z���]�w�ɰȥ��`�N�G<br>
		 (1)�b���j�M���@�w�n�]�A�@��O uid �C <br>
		 (2)�uou�v�O���b���Ҧb���e�ϡA�z�i�H�����]�w�b base dn �o�@��A�]�i�H�̾ڱЮv�ξǥͱb�����O���w�C<br>
		 (3)��ǥͻP�Юv�� ou �Ȥ��P�ɡA�ЭӧO�]�w�b������줤�C<br>
		 (4)�Y���S�O�]�w�Юv�ξǥͪ� ou �ɡA�t�η|�� ou �� base dn �o���檺��ƦX�֦� bind dn.<br>
		 3.�ȴ��ѱЮv�P�ǥͨ�ب����i�Q�� LDAP �n�J.�@
		 </td>
		</tr>
	</table>
</form>
