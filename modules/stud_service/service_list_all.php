<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();

//�q�X����
head("�ӤH�A�Ⱦǲ߰O��");

$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

//�ثe��w�Ǵ�
$c_curr_seme=sprintf("%03d%d",curr_year(),curr_seme());
//�ثe��w�Z��
$c_curr_class=$_POST['c_curr_class'];


?>

<form method="post" action="<?php $_SERVER['PHP_SELF'];?>" name="myform" id="myform" target="">
	<input type="hidden" name="student_sn" value="">
	<input type="hidden" name="list_class_all" value="">
	
 <?php
 
  if ($c_curr_seme!="") {
  	
    $s_y = substr($c_curr_seme,0,3);
    $s_s = substr($c_curr_seme,-1);
    
    //���X�~�ŻP�Z�ſ��
     $tmp=&get_class_select($s_y,$s_s,"","c_curr_class","change_class",$c_curr_class); 	 
	 echo $tmp;
	 
  }

  if ($c_curr_class!="") {
   	$Cyear=substr($c_curr_class,-5,2);
  	$Cnum=substr($c_curr_class,-2,2);
		$classid=class_id_2_old($c_curr_class);
	  $class=sprintf('%3d',$Cyear.$Cnum);
	?>
   <table border="0"  width="100%">
     <tr>
   	  <td><?php echo "�i".$classid[5]."�j�ǥ��`��";?></td>
   	  <td align="right">
  	  	<input type="hidden" name="all_past_data" value="1">
   	  	<input type="checkbox" name="init_check" onclick="checkall('STUD');">����/������
     </tr>
   </table>

	<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width=100%>
  <?php
 	$query="select a.student_sn,a.seme_num,b.stud_name from stud_seme a,stud_base b where a.seme_year_seme='$c_curr_seme' and a.seme_class='$class' and a.student_sn=b.student_sn";
  $res=$CONN->execute($query) or die("SQL���~:$query");;

  $i=0;
  while ($row=$res->fetchRow()) {
  		$i++;
  		if ($i%10==1) echo "<tr>";
			?>
  		<td><input type="checkbox" name="STUD[<?php echo $row['student_sn'];?>]" value="<?php echo $row['seme_num'];?>" >
  			<?php echo $row['seme_num'];?>.<?php echo $row['stud_name'];?></td>
    <?php
    if ($i%10==0) echo "</tr>";
   
   }
  ?>
  
  </table>
 <table border="0" width="100%">
 	<tr>
 		<td align="right"><input type="button" value="�͵��C�L�Ŀ�ǥͩ���" onclick="print_kind()"></td>
 	</tr>
 </table>
 <?php
 } // end if c_curr_class
 ?>
 </form>
 <?php
foot();

// =====<< �H�U���U�� function >>=====================================================================================


?>
<script language="javaScript">

function change_class() {
  document.getElementById("myform").target='';
  document.getElementById("myform").action = 'service_list_all.php';
  document.myform.submit();
}

function check_stud(student_sn) {

  	document.myform.student_sn.value=student_sn;
  	document.myform.submit();

}

 function print_kind() {
 	//
 	//flagWindow=window.open('service_print.php?c_curr_seme=<?php echo $c_curr_seme;?>&c_curr_class=<?php echo $c_curr_class;?>&list_class_all=<?php echo $class;?>','service_print','width=640,height=420,resizable=1,toolbar=1,scrollbars=1');
  document.getElementById("myform").target='_blank';
  document.getElementById("myform").action = 'service_print_all.php';
  document.myform.submit();
 }
 
</Script>