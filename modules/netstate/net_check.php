<?php
include_once('config.php');
include_once('include/PHPTelnet.php');
sfs_check();


//�q�X����
head("�����޲z - ������ IP-MAC �\���˴�");

$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}

//�x�s������K�X
if ($_POST['act']=='password') {
  $firewall_ip=$_POST['firewall_ip'];
  $firewall_user=$_POST['firewall_user'];
  $firewall_pwd=$_POST['firewall_pwd'];
  
  $query="replace into net_firewall (id,firewall_ip,firewall_user,firewall_pwd) values ('1','$firewall_ip','$firewall_user','$firewall_pwd')";
  mysql_query($query);
  
}

//Ū��������b�K
$query="select * from net_firewall where id=1";
$res=mysql_query($query);
$row=mysql_fetch_array($res,1);
$firewall_ip=$row['firewall_ip'];
$firewall_user=$row['firewall_user'];
$firewall_pwd=$row['firewall_pwd'];

?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>">
 <input type="hidden" name="act" value="<?php echo $_POST['act'];?>">
 <input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">

<?php
 //����
 $telnet = new PHPTelnet();

 // if the first argument to Connect is blank,
 // PHPTelnet will connect to the local host via 127.0.0.1
 $result = $telnet->Connect($firewall_ip,$firewall_user,$firewall_pwd);

 if ($result == 0) { 
 	
 	
 	//�ҥ�IP-MAC�ި�
  if ($_POST['act']=='open_ip_mac') {
  	$telnet->DoCommand('config firewall ipmacbinding setting', $result);
  	$telnet->DoCommand('set bindthroughfw enable', $result);
  	$telnet->DoCommand('set undefinedhost allow', $result);
  	$telnet->DoCommand('end', $result);  
  	
  	//WAN1 �ɭ��]�n�ҥ� ipmac�~�� , �����ۦ��ʫإ�
  	
  }
  
  //�w�� WAN1 �ҥ�IP-MAC�ި�
  if ($_POST['act']=='open_wan1_ipmac') {
    $telnet->DoCommand('config system interface', $result);
  	$telnet->DoCommand('edit wan1', $result);
  	$telnet->DoCommand('set ipmac enable', $result);
  	$telnet->DoCommand('end', $result);  
  }
  
  //Ū�� firewall �]�w��
 	$telnet->DoCommand('show firewall ipmacbinding setting', $result);
 	// NOTE: $result may contain newlines
 	$RES=explode("\n",$result);
 	foreach ($RES as $k=>$v) { $RES[$k]=strtolower(trim($v)); }  //�h���e��ť�
  //Ū�� interface �]�w��
 	$telnet->DoCommand('show system interface', $result);
 	// NOTE: $result may contain newlines
 	$line=0;
 	$INTERFACE=array();
 	
 	$tmp_line=explode("\n",$result);
 	 foreach ($tmp_line as $k=>$v) { 
    $line++;
 		$INTERFACE[$line]=strtolower(trim($v)); 
	  	if (substr($INTERFACE[$line],0,9)=='--more-- ') $INTERFACE[$line]=trim(substr($INTERFACE[$line],10));
 	 }  //�h���e��ť�
  
  //�p�G�@���L�k��ܧ�, �e�X�ťմ���
  if ($INTERFACE[$line]=="--more--") {
   do {
    $line--;
    $telnet->DoCommand(' ', $result);
 		$tmp_line=explode("\n",$result);
 	 	foreach ($tmp_line as $k=>$v) { 
    	$line++;
 			$INTERFACE[$line]=strtolower(trim($v)); 
	  	if (substr($INTERFACE[$line],0,9)=='--more-- ') $INTERFACE[$line]=trim(substr($INTERFACE[$line],10));
 	 	}  //�h���e��ť�
   } while ($INTERFACE[$line]=="--more--");
  } // end if More 	


  //��s mysql ���� ipmac table �O��
  if ($_POST['act']=='update_ipmac') {
  	//���N�Ҧ��O���g�J 0 , ��ܬҥ���, �M���� ipmacbinding table , ���O�����A�אּ1
    mysql_query("update net_roomsite set ipmac='0'");
    //Ū��mysql �{���]�w
		$query="select * from net_roomsite where net_edit like '".$COMP_INT."%' and site_num>0 and pc_ip!=''";
 		$res=mysql_query($query);
 		while ($row=mysql_fetch_array($res,1)) {
   			$pc_ip[$row['net_edit']]=$row['pc_ip'];
    		$site_num[$row['net_edit']]=$row['site_num'];
 		} // end while  
  
   //Ū��ipmac table ==================================================================
 	$telnet->DoCommand('show firewall ipmacbinding table', $result);
 	//echo $result;
 	// NOTE: $result may contain newlines
 	
 	$line=0;
 	$ipmac_table=array();
 	
 	$tmp_line=explode("\n",$result);
 	 foreach ($tmp_line as $k=>$v) { 
    $line++;
 		$ipmac_table[$line]=strtolower(trim($v)); 
   	if (substr($ipmac_table[$line],0,9)=='--more-- ') $ipmac_table[$line]=trim(substr($ipmac_table[$line],10));
 	 }  //�h���e��ť�
  
  //�p�G�@���L�k��ܧ�, �e�X�ťմ���
  if ($ipmac_table[$line]=="--more--") {
   do {
    $line--;
    $telnet->DoCommand(' ', $result);
 		$tmp_line=explode("\n",$result);
 	 	foreach ($tmp_line as $k=>$v) { 
    	$line++;
 			$ipmac_table[$line]=strtolower(trim($v)); 
	  	if (substr($ipmac_table[$line],0,9)=='--more-- ') $ipmac_table[$line]=trim(substr($ipmac_table[$line],10));
 	 	}  //�h���e��ť�
   } while ($ipmac_table[$line]=="--more--");
  } // end if More
 // ====================================================================================
 
  //���R ipmac table
  $IPMAC=array(); //�O������ IP �w�Q�]�w
  for ($i=1;$i<count($ipmac_table)-1;$i++) {
  	//echo $ipmac_table[$i]."<br>";
   if (substr($ipmac_table[$i],0,4)=='edit') {
     $a=explode(" ",$ipmac_table[$i]);
     $b=explode(" ",$ipmac_table[$i+1]);
     //�s��$a �O�_���]�w��ip , �O���ܼg�J ipmac ���g�J 1
     if ($a[1]>100 and $b[2]=$pc_ip[$a[1]]) {
      mysql_query("update net_roomsite set ipmac='1' where net_edit='".$a[1]."'");
      $IPMAC[$a[1]]=$pc_ip[$a[1]];
     }     
   }
  } // end for  
  
 } // end if update_ipmac
 
 $telnet->Disconnect();

 //�ˬd firewall ���L�ҥ� IP-MAC �]�w
 	if ($RES[2]=='end' or $RES[2]=='' or $RES[3]=='') {
 		?>
  	<font color=red>�z�������𥼱Ұ� IP-MAC binding �\��! �n�ϥΥ��Ҳժ��q���ЫǤW���ި�A�����ҥθӥ\��C</font><br>
   <input type="button" value="�ҥ� IP-MAC binding �\��" onclick="document.myform.act.value='open_ip_mac';document.myform.submit();">    
   <?php
   exit();
  }

  //�ˬd���L�ҥΤ���
  $SET_INTERFACE="";
  foreach ($INTERFACE as $k=>$v) {
  	//if (substr($ipmac_table[$i],0,9)=='--more-- ') $ipmac_table[$i]=substr($ipmac_table[$i],10);

   if (substr($v,0,4)=='edit') { 
   	  $a=explode(" ",$v);
   	  $i_face=$a[1];   	
   	}
   if ($v=='set ipmac enable') { $SET_INTERFACE=$i_face; break; }
  }
  
  
  
  echo "<font color=blue>IP-MAC �]�w��:<br>";
  for ($i=1;$i<count($RES)-1;$i++) {
   echo $RES[$i]."<br>";
  }
  
  if ($SET_INTERFACE=="") {
   echo "<font color=red>�`�N! ���w����󤶭��ҥ� IP-MAC binding �\��! �z�����n�J������w�沈�n�ɭ��ҥΦ��\��C<br>";
   echo "�@�볣�O�w��s���������ɭ��ҥ�, �H�ɭ� wan1 ����, telnet �n�J�z���������, ���O�p�U:<br>";
   echo "config sys interface <br>";
   echo "edit wan1 <br>";
   echo "set ipmac enable<br>";
   echo "end<br></font>";
   ?>
       <input type="button" value="�w�� wan1 �ɭ��ҥ� IP-MAC �ި�" onclick="document.myform.act.value='open_wan1_ipmac';document.myform.submit();"><br>
       ���p�G�z�������𱵤������ɭ����O�b WAN1 , �Цۦ�ѦҤW�z���O�i���ʳ]�w, ���ū��U�ҥζs�C<br>
   <?php
   
  } else {
   ?>
   IP-MAC binding �ҥάɭ�:<?php echo $SET_INTERFACE;?></font><br><br>
   <font color=red>���߱z! �z��������w���`�ҥ� IP �j MAC �\��C</font><br>
   <br>
   ������q���ЫǤW�������: <br>
   �t�Φb�C���i�樾������O��, �|�۰ʱN IP-MAC binding �{�p�O���b��Ʈw��, �H�K�}�ҵ{���ɥi�ֳt�e�{���G, �����ۨ����𤤭��sŪ���{�p.<br>
   �Y�z�oı�q���Ы���w���p�P��ڦ��~, �Ы��U���s <input type="button" value="��s��Ʈw IP-MAC �{�p" onclick="document.myform.act.value='update_ipmac';document.myform.submit()">
 
   <?php
  }
  
 
 } else {
 	?>
  �L�k�n�J������I�п�J�n�J�b���αK�X:
  <table border="0">
   <tr>
    <td>�ע�<input type="text" name="firewall_ip" size="20"></td>
   </tr>

   <tr>
    <td>�b��<input type="text" name="firewall_user" size="20"></td>
   </tr>
   <tr>
    <td>�K�X<input type="password" name="firewall_pwd" size="20"></td>
   </tr>
   <tr>
   	<td>
     <input type="button" value="�x�s�í��s�˴�" onclick="document.myform.act.value='password';document.myform.submit()">
    </td>
   </tr>
  </table>
  
  <?php
 }

?>
</form>