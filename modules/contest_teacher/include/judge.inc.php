<?php
//���o���f���
function get_judge_user($tsn,$teacher_sn) {
  $query="select a.name,b.* from teacher_base a,contest_judge_user b where a.teacher_sn=b.teacher_sn and a.teacher_sn='$teacher_sn' and b.tsn='$tsn'";
  $res=mysql_query($query);
  
  return mysql_fetch_array($res,1);	

}

//���f�n�J
function judge_login($active,$INFO) {
 global $PHP_CONTEST;
 $query="select b.* from contest_judge_user a,contest_setup b where a.tsn=b.tsn and a.teacher_sn='".$_SESSION['session_tea_sn']."' and b.open_judge=1";
 $result=mysql_query($query);
 if (mysql_num_rows($result)==0) {
  echo "��p, ���ܽбz�������v�ɵ���!";
  exit();
 }
 list($Teacher)=mysql_fetch_row(mysql_query("select name from teacher_base where teacher_sn='".$_SESSION['session_tea_sn']."'"));
?>
<br>
<div align="center">
	<table border="0" width="500">
   <tr>
   	  <td>�t�ήɶ��G<?php echo date("Y-m-d H:i:s");?></td>

   </tr>
	 <tr>
	  <td>
	   <?php echo $Teacher;?>�Ѯv �z�n�G
	  </td>
	 </tr>
	 <tr>
	  <td>
	<table border="1" width="500" style="border-collapse: collapse" bordercolor="#800000">
		<tr>
			<td>
			<table border="0" width="500" cellpadding="5">
        <tr>
        	<td width="100" bgcolor="#CCFFCC" style="font-size:10pt;color:#FF0000" align="center">�п���v�ɶ���</td>
        	<td bgcolor="#CCFFCC" style="font-size:10pt">
        		<select size="1" name="tsn">
        			<?php
        			while ($row=mysql_fetch_array($result)) {
        			?>
        			<option value="<?php echo $row['tsn']?>"><?php echo $row['title'];?>(<?php echo $PHP_CONTEST[$row['active']];?>)</option>
        		 <?php
 							} //end while
        		 ?>
        	</td>
        </tr>
			</table>
			</td>
		</tr>
	</table>
	  
	  </td>
	 </tr>
	</table>
	
	<br>
  <input type="button" style="color:#FF0000" value="�T�{�L�~" onclick="document.myform.act.value='login';document.myform.submit();"> 
  <br>
  <font color="#FF0000"><?php echo $INFO;?></font>
</div>
 <?php
}

//�C�X���f��
function list_judge_user($TSN) {
?>
 <table border="0" cellpadding="0" cellspacing="0">
 	<tr>
 	 <td style="color:#800000;font-size:10pt">
 	  ���ثe�w���w���f���v�ɪ��Ѯv�G	
 	 </td>
 	 <td>
 	 	<table border="0">
 	 		<tr>
 	 <?php
 	  $query="select a.teacher_sn,b.name from contest_judge_user a,teacher_base b where a.teacher_sn=b.teacher_sn and a.tsn='$TSN'";
 	  $res=mysql_query($query);
 	  $i=0;
 	  while ($row=mysql_fetch_array($res,1)) {
 	  $i++;
 	  ?>
 	   <td>
 	     <table border="1"  bgcolor="#FFFF99" bordercolor="#FF9900" style="border-collapse: collapse">
  		   	<tr><td style="color:#0066FF;font-size:10pt"><?php echo $row['name'];?><a style="cursor:hand" onclick="if (confirm('�z�T�w�n\n�R���u<?php echo $row['name'];?>�v�Ѯv?\n�N�s�P�����f�������O���@�֧R��.')) { document.myform.option2.value='<?php echo $row['teacher_sn'];?>';document.myform.act.value='judge_del';document.myform.submit(); }"> <img src="./images/del.png"  border="0"></a></td></tr>
  		 </table>
 	   </td>
 	  <?php
 	  }
 	  if ($i==0) echo "<td style='color:#FF0000'>�L</td>";
 	 ?>
 	   </tr>
    </table>
    </td>
 	</tr>
 </table>
<?php
} // end function list_judge_user

//���o���y
function get_prize_memo($tsn,$student_sn) {
 $query="select prize_memo from contest_score_record2 where tsn='$tsn' and student_sn='$student_sn'";
 $res=mysql_query($query);
 $D="";  
 while ($row=mysql_fetch_array($res,1)) {
   $D.=($D=='')?$row['prize_memo']:"<br>".$row['prize_memo'];
 }
 return $D;
} // end function get_prize_memo

