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
$c_curr_seme=$_POST['c_curr_seme'];
//�ثe��w�Z��
$c_curr_class=$_POST['c_curr_class'];


//���o�Ҧ��Ǵ����, �C�~����ӾǴ�
$class_seme_p = get_class_seme(); //�Ǧ~��	
$class_seme_p=array_reverse($class_seme_p,1);
//���o�ثe�Ǧ~��
$curr_year=curr_year();

//���o�n���̩Ҧb����
$sql_select = "select post_office from teacher_post where teacher_sn='{$_SESSION['session_tea_sn']}'";
$recordSet = $CONN->Execute($sql_select);
$post_office = $recordSet->fields["post_office"];

?>

<form method="post" action="<?php $_SERVER['PHP_SELF'];?>" name="myform" id="myform" target="">
	<input type="hidden" name="student_sn" value="">
	<input type="hidden" name="list_class_all" value="">
	<select name="c_curr_seme" onchange="this.form.submit()">
	<option style="color:#FF00FF">�п�ܾǴ�</option>
	<?php
	while (list($tid,$tname)=each($class_seme_p)){
	  if (substr($tid,0,3)>$curr_year-3) {
    ?>
      		<option value="<?php echo $tid;?>" <?php if ($c_curr_seme==$tid) echo "selected";?>><?php echo $tname;?></option>
   <?php
      }
    } // end while
    ?>
</select> 
 <?php
 
  if ($c_curr_seme!="") {
  	
    $s_y = substr($c_curr_seme,0,3);
    $s_s = substr($c_curr_seme,-1);
    
    //���X�~�ŻP�Z�ſ��
     $tmp=&get_class_select($s_y,$s_s,"","c_curr_class","this.form.submit",$c_curr_class); 
	 
	 echo $tmp;
	 
  }

  if ($c_curr_class!="") {
   	$Cyear=substr($c_curr_class,-5,2);
  	$Cnum=substr($c_curr_class,-2,2);
	$classid=class_id_2_old($c_curr_class);
	 $class=sprintf('%3d',$Cyear.$Cnum);
	?>
   <table border="0"  width="800">
     <tr>
   	  <td><?php echo "�i".$classid[5]."�j�ǥͪA�ȩ����`��";?></td>
   	  <td align="right">
   	  	<input type="checkbox" name="init_check" onclick="checkall('STUD');">����/������
   	  	<input type="button" value="�C�X�Ŀ�ǥͩ���" onclick="document.myform.list_class_all.value='<?php echo $class;?>';document.myform.submit()"></td>
     </tr>
   </table>
	<?php
     //�C�X�ǥ��`��
    student_service_select($class,$c_curr_seme);
	
 ?>
 <table border="0" width="800">
 	<tr>
 		<td style="color:#FF0000;font-size:10pt">���Ъ����I��ǥ��[�ݸӥͥ��Ǵ����A�ȩ��ӡC<br>���[�ݾ��~�A�ȩ��ӡA�ЧQ�Ρu<a href="service_list_all.php">�d�߾ǥ��`�ɼ�</a>�v�\��C</td>
 		<td align="right"><input type="button" value="�͵��C�L�Ŀ�ǥͩ���" onclick="print_kind()"></td>
 	</tr>
 </table>
 <table border="0" width="700">
 	 <tr>
 	   <td>
 <?php
  if ($_POST['student_sn']!='') {
  	list_service($_POST['student_sn'],$c_curr_seme,$classid[5]);
  }
  
 if ($_POST['list_class_all']!="") {
 	//list_class_all($_POST['list_class_all'],$c_curr_seme,$classid[5]);
 	
  //�C�X�Ŀ� 	  
  foreach ($_POST['STUD'] as $student_sn=>$seme_num) {
     		list_service($student_sn,$c_curr_seme,$classid[5]);
  }
	
 	
  }
  
 ?>
   </td>
  </tr>
</table>
</form>
 <?php
  } // end if c_curr_class
 
foot();

// =====<< �H�U���U�� function >>=====================================================================================


?>
<script language="javaScript">

function check_stud(student_sn) {

  	document.myform.student_sn.value=student_sn;
  	document.myform.submit();

}

 function print_kind() {
 	//
 	//flagWindow=window.open('service_print.php?c_curr_seme=<?php echo $c_curr_seme;?>&c_curr_class=<?php echo $c_curr_class;?>&list_class_all=<?php echo $class;?>','service_print','width=640,height=420,resizable=1,toolbar=1,scrollbars=1');
  document.getElementById("myform").target='_blank';
  document.getElementById("myform").action = 'service_print.php';
  document.myform.submit();
 }
 
 function print_here() {
  document.getElementById("myform").target='';
  document.getElementById("myform").action = 'service_list.php';
  document.myform.submit();
}
</Script>