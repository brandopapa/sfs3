<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();


//�q�X����
head("�����޲z - ��T�]�Ƥ@����");

$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;


 for ($k=0;$k<2;$k++) {
 ?>
 <font color="#800000"><b><?php echo "��".$NET_KIND[$k];?></b></font>
 <table border="1" style="border-collapse:collapse" bordercolor="#800000">
 	<tr bgcolor="#FFCCFF">
 	  <td width="30" style="font-size:10pt" align="center">��</td>
 	  <td width="120" style="font-size:10pt" align="center">�W��</td>
 	  <td width="80" style="font-size:10pt" align="center">IP</td>
 	  <td width="180" style="font-size:10pt" align="center">�s�����}</td>
 	  <td width="120" style="font-size:10pt" align="center">�]�ƩҦb�a</td>
 	  <td width="60" style="font-size:10pt" align="center">�ثe���A</td>
 	  <td width="250" style="font-size:10pt" align="center">���O���e</td>
 	</tr>
 <?
 $query="select * from net_base where net_kind=$k order by net_ip";
 $res=mysql_query($query);
 $i=0;
 while ($E=mysql_fetch_array($res)) {
		
 $i++; 
 switch ($E['net_check']) {
 	case '1': //Port 80�^��
		if (!$socket = @fsockopen($E['net_ip'], 80, $errno, $errstr, 2)) 	{
  			//���u
  			$STATE="<font color=red>�L�T��</font>";
		} else {
  			$STATE="<font color=green>�W�u</font>";
  			fclose($socket);
		}
 	break;
 	case '2': //�ϥ�ping���覡
		exec("ping -c 4 -t 1 " . $E['net_ip'], $output, $result);
		//print_r($output);
		if ($result == 0) {
		//echo "Ping successful!";
     $STATE="<font color=green>�W�u</font>";
		}else {
     $STATE="<font color=red>�L�T��</font>";
		 //echo "Ping unsuccessful!";
	  }
	  break;
	  default:
	    $STATE="������";
	  break;
	 } // end switch
   ?>
  <tr>
 	  <td style="font-size:10pt" align="center"><?php echo $i;?></td>
 	  <td style="font-size:10pt"><?php echo $E['net_name'];?></td>
 	  <td style="font-size:10pt"><?php if ($E['net_ip_show']==1) { echo $E['net_ip']; } else { echo '---';} ?></td>
 	  <td style="font-size:10pt"><?php if ($E['net_url_show']==1) { ?> <a href="<?php echo $E['net_url'];?>" target="_blank"><?php echo $E['net_url'];?></a><?php } else { echo "---"; } ?></td>
 	  <td style="font-size:10pt" align="center"><?php echo $E['net_location'];?></td>
 	  <td  style="font-size:10pt" align="center"><?php echo $STATE;?></td>
 	  <td style="font-size:10pt"><?php echo $E['net_memo'];?></td>
 	</tr>
   <?php
	} // end while
  ?>
   </table>
   <br>
  <?php 
 } // end foreach

?>

