<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();


//�q�X����
head("�����޲z - �]�w��T�]��");

$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}

//�s�W�]��
if ($_POST['act']=='inserting') {
	$net_ip_show=$net_url_show=0;
  foreach($_POST as $k=>$v) {
   ${$k}=$v;
  }
  
  $query="insert into net_base (net_name,net_kind,net_ip,net_ip_show,net_url,net_url_show,net_location,net_memo,net_check) values ('$net_name','$net_kind','$net_ip','$net_ip_show','$net_url','$net_url_show','$net_location','$net_memo','$net_check')";
  mysql_query($query);
  $_POST['act']='';

} // end inserting

//�R���]��
if ($_POST['act']=='del') {
  
  $query="delete from net_base where id='".$_POST['option1']."'";
  mysql_query($query);
  $_POST['act']='';

} // end inserting

//�s��]��
if ($_POST['act']=='update') {
	$net_ip_show=$net_url_show=0;
  foreach($_POST as $k=>$v) {
   ${$k}=$v;
  }
  
  $query="update net_base set net_name='$net_name',net_kind='$net_kind',net_ip='$net_ip',net_ip_show='$net_ip_show',net_url='$net_url',net_url_show='$net_url_show',net_location='$net_location',net_memo='$net_memo',net_check='$net_check' where id='".$_POST['option1']."'";
  mysql_query($query);
  $_POST['act']='';

}


?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">
	<input type="hidden" name="option2" value="<?php echo $_POST['option2'];?>">
	<input type="hidden" name="act" value="<?php echo $_POST['act'];?>">

<?php
//�s�W�]��
if ($_POST['act']=='insert') {
 ?>
  ���s�n���@�ӳ]��
  
  <?php
   $E['net_url']="http://";
   equipment_form($E);
  ?>
  <input type="button" value="�T�w�s�W" onclick="document.myform.act.value='inserting';document.myform.submit()">
 <?php
 
} // end if insert

//�s��]��
if ($_POST['act']=='edit') {
 ?>
  ���s��]��
  
  <?php
   $E=get_equipment($_POST['option1']);
   equipment_form($E);
  ?>
  <input type="button" value="�T�w�ק�" onclick="document.myform.act.value='update';document.myform.submit()">
 <?php
 
} // end if insert


//�C�X�]��
if ($_POST['act']=='') {
?>
<input type="button" value="�s�W�]��" onclick="document.myform.act.value='insert';document.myform.submit()">
<input type="checkbox" value="1" name="check_online" onclick="document.myform.submit()">�Y���˴�
<br>
<?php
 foreach ($NET_KIND as $k=>$v) {
 ?>
 <font color="#800000"><b><?php echo "��".$v;?></b></font>
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
 if ($_POST['check_online']==1) {
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
	} else {
	    $STATE="������";
	}
   ?>
  <tr>
 	  <td style="font-size:10pt" align="center"><?php echo $i;?></td>
 	  <td style="font-size:10pt">
 	  	<img src="images/edit.png" style="cursor:hand" title="�s��" onclick="document.myform.act.value='edit';document.myform.option1.value='<?php echo $E['id'];?>';document.myform.submit()">
 	  	<img src="images/del.png" style="cursor:hand"  title="�R��" onclick="if (confirm('�z�T�w�n:\n�R���u<?php echo $E['net_name'];?>�v�O���H')) { document.myform.act.value='del';document.myform.option1.value='<?php echo $E['id'];?>';document.myform.submit(); } "><?php echo $E['net_name'];?></td>
 	  <td style="font-size:10pt"><?php echo $E['net_ip'];?></td>
 	  <td style="font-size:10pt"><a href="<?php echo $E['net_url'];?>" target="_blank"><?php echo $E['net_url'];?></a></td>
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
} // end if $_POST['act']==''
?>
</form>

<?php
//���o�Ҧ��]��
function get_equipment($k) {
	
  $query="select * from net_base where id='$k'";
  $res=mysql_query($query);
  $row=mysql_fetch_array($res,1);
  
  return $row;
} // end function

//���
function equipment_form($E) {
 global $NET_KIND;
?>
  <table border="0">
   <tr>
     <td>�]�ƦW��</td>
     <td><input type="text" name="net_name" value="<?php echo $E['net_name'];?>"></td>
   </tr>
   <tr>
     <td>�]�ƺ���</td>
     <td>
     	<select name="net_kind" size="1">
     		<?php
     		 foreach ($NET_KIND as $k=>$v) {
     		  ?>
     		  <option value="<?php echo $k;?>"<?php if ($k==$E['net_kind']) echo " selected";?>><?php echo $v;?></option>
     		  <?php
     		 }
     		?>
      </select>
     
     </td>
   </tr>
   <tr>
     <td>�]��IP</td>
     <td><input type="text" name="net_ip" value="<?php echo $E['net_ip'];?>">&nbsp;<input type="checkbox" name="net_ip_show" value="1"<?php if ($E['net_ip_show']==1) echo "checked";?>>�����s��</td>
   </tr>
   <tr>
     <td>�s�����}</td>
     <td><input type="text" name="net_url" value="<?php echo $E['net_url'];?>">&nbsp;<input type="checkbox" name="net_url_show" value="1"<?php if ($E['net_url_show']==1) echo "checked";?>>�����s��</td>
   </tr>
   <tr>
     <td>�s��a�I</td>
     <td><input type="text" name="net_location" value="<?php echo $E['net_location'];?>"></td>
   </tr>
   <tr>
     <td>��������</td>
     <td><textarea cols="50" rows="5" name="net_memo"><?php echo $E['net_memo'];?></textarea></td>
   </tr>
   <tr>
     <td>�����覡</td>
     <td>
     	 <input type="radio" value="1" name="net_check"<?php if ($E['net_check']==1) echo checked;?>>Port 80 �^��
       <input type="radio" value="2" name="net_check"<?php if ($E['net_check']==2) echo checked;?>>Ping �^��
     </td>
   </tr>
  </table>
  
<?php
} // end function

?>

