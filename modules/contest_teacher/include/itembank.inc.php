<?php

//���_�s�W�D�w
function form_additem($IB) {
?>
   <table border="0" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0">
  	<tr>
  		<td width="80" align="right">�D��</td>
  		<td><input type="text" name="question" size="100" value="<?php echo $IB['question'];?>"></td>
  	</tr>
  	<tr>
  		<td width="80" align="right">�Ѧҵ���</td>
  		<td><input type="text" name="ans" size="70" value="<?php echo $IB['ans'];?>"></td>
  	</tr>
  	<tr>
  		<td width="80" align="right">�ѦҺ��}</td>
  		<td><input type="text" name="ans_url" size="70" value="<?php echo $IB['ans_url'];?>"></td>
  	</tr>
  </table>
<?php
}

//�C�X�D�w���D
function listitembank($PAGE) {
	global $PHP_PAGE;
	?>
   <table border="1" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0">
  	<tr>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="20" align="center"><input type='checkbox' name="tag_chk" onclick="tag_all('tag_chk','tag_it');"</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="40" align="center">�s��</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" >�D�ؤ��e</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="20%">�ѦҸѵ�</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="10%">���}</td>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="50" align="center">�ާ@</td>
  	</tr>

   	<?php
   	 $row=mysql_fetch_row(mysql_query("select count(*) as num from contest_itembank"));
   	 list($ALL)=$row; 
   	 $PAGEALL=ceil($ALL/$PHP_PAGE); //�L����i��
   	 $st=($PAGE-1)*$PHP_PAGE;
   	 $query="select * from contest_itembank limit ".$st.",".$PHP_PAGE;
   	 $result=mysql_query($query);

     if (mysql_num_rows($result)) {
     
   	 while ($IB=mysql_fetch_array($result)) {   	 	
   	 	$ans_url=($IB['ans_url']=='')?"�L":"<a href='".$IB['ans_url']."' target='_blank'>".�s��."</a>";
   	 	
   	?>
  	<tr>
  		<td bgcolor="#CCFFCC" style="font-size:10pt;color:#000000" width="20" align="center"><input type='checkbox' name="tag_it[]" value="<?php echo $IB['ibsn'];?>"</td>
  		<td style="font-size:10pt;color:#000000" width="40" align="center"><?php echo $IB['id'];?></td>
  		<td style="font-size:10pt;color:#000000" ><?php echo $IB['question'];?></td>
  		<td style="font-size:10pt;color:#000000" width="20%"><?php echo $IB['ans'];?></td>
  		<td style="font-size:10pt;color:#000000" width="10%"><?php echo $ans_url;?></td>
  		
  		<td style="font-size:10pt;color:#000000" width="50" align="center">
  			<img src="./images/edit.png" border="0" style="cursor:hand" onclick="document.myform.option1.value='<?php echo $IB['ibsn'];?>';document.myform.act.value='update';document.myform.submit();">&nbsp;
  			<img src="./images/del.png"  border="0" style="cursor:hand" onclick="del_itembank('<?php echo $IB['ibsn'];?>');">
  		</td>
  	</tr>
  	<?php
  	} // end while  	
   } // end if mysql_num_rows > 0
  	?>
  	</table>
  	<table border="0" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0">
  	<tr>
  	 <td style="font-size:10pt">���� 
  	 <?php
  	 //���X
  	  for($i=1;$i<=$PAGEALL;$i++) {
  	  	if ($i==$PAGE) {
  		  	   echo "<font color=#FF00FF size=3><b><u>".$i."</u></b></font>&nbsp;";
				 }else{
  	   ?>
  	    <a href="javascript:page(<?php echo $i;?>)"><?php echo $i;?></a>&nbsp;
  	   <?php
  	     } // end if
  	  } //end for
  	 ?>
  	 </td>
  	</tr>
  </table>
  <font size="2" color="#FF0000">�����ܡG�i�H�ѡu�t�κ޲z/�Ҳպ޲z�v�A�վ�Ҳ��ܼơA���ܨC���e�{���ơC</font>
<?php
} // end function

function get_item($ibsn) {
 $query="select * from contest_itembank where ibsn='$ibsn'";
 $res=mysql_query($query);
 
 return mysql_fetch_array($res);
 
}

?>