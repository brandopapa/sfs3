<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

//���J�A�Ⱦǲ߼Ҳժ����Ψ禡
include_once "../stud_service/my_functions.php";

sfs_check();

// ���O�d�d��
switch ($ha_checkary){
        case 2:
                ha_check();
                break;
        case 1:
                if (!check_home_ip()){
                        ha_check();
                }
                break;
}


//�q�X����
head("�A�Ⱦǲ�- ��g�ۧڬ٫�");

//�Ҳտ��
print_menu($menu_p);

if ($_SESSION['session_who'] != "�ǥ�") {
	echo "�ܩ�p�I���\��Ҳլ��ǥͱM�ΡI";
	exit();
}

//�Ҳ��ܼ� $feedback_deadline ��g����


$C[1]="�@";
$C[2]="�G";
$C[3]="�T";
$C[4]="�|";
$C[5]="��";
$C[6]="��";
$C[7]="�C";
$C[8]="�K";
$C[9]="�E";

$TODAY=date("Y-m-d");

//�ثe��w�Ǵ�
$c_curr_seme=$_POST['c_curr_seme'];

//���o�Ҧ��Ǵ����, �C�~����ӾǴ�
$class_seme_p = get_class_seme(); //�Ǧ~��	

//���o�ثe�Ǧ~��
$curr_year=curr_year();

//��g����
$feedback_deadline=($feedback_deadline==0)?60:$feedback_deadline;

//�x�s���
if ($_POST['mode']=='save') {
 foreach ($_POST['feedback'] as $sn=>$feedback) {
  $query="update stud_service_detail set feedback='$feedback' where sn='$sn' and student_sn='".$_SESSION['session_tea_sn']."'";
  if (mysql_query($query)) {
   $SAVE_INFO="�v��".date("Y-m-d H:i:s")."�x�s����!";
  }else{
   echo "Error! Query=$query";
   exit();
  } 
 }
}


?>

<form method="post" action="<?php $_SERVER['PHP_SELF'];?>" name="myform">
	<select name="c_curr_seme" onchange="this.form.submit()">
	<option style="color:#FF00FF">�п�ܾǴ�</option>
	<?php
	foreach ($class_seme_p as $tid=>$tname) {
	  if (substr($tid,0,3)>$curr_year-3) {
    ?>
      		<option value="<?php echo $tid;?>" <?php if ($c_curr_seme==$tid) echo "selected";?>><?php echo $tname;?></option>
   <?php
      }
    } // end foreach
    ?>
</select> 
</form>
 <?php
 //�C�X�ӥ͸ӾǴ��Ҧ��A�Ⱦǲ߸�� 
 if ($c_curr_seme!="") {
  $query="select  a.*,b.sn as detail_sn,b.minutes,b.feedback,c.seme_class from stud_service a, stud_service_detail b,stud_seme c where a.sn=b.item_sn and a.year_seme='$c_curr_seme' and b.student_sn='".$_SESSION['session_tea_sn']."' and c.seme_year_seme='$c_curr_seme' and c.student_sn=b.student_sn";
  $res=mysql_query($query);
  if (mysql_num_rows($res)==0) {
   echo "���Ǵ��A�S������A�ȰO��!!";
   exit();
  } else {
   ?>
   <table border="0" width="100%">
    <tr>
     <td style="color:#0000FF">���Ǵ��A���A�ȰO���p�U�A�O�o�n��g�ۧڬ٫�G(��g����<?php echo $feedback_deadline;?>��)<font size="2" color=red><?php echo $SAVE_INFO;?></font></td>
    </tr>
   </table>
   <form method="post" name="myform1" action="<?php echo $_SERVER['PHP_SELF'];?>">
   	<input type="hidden" name="mode" value="">
   	<input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme;?>">
   <table border="1" style="border-collapse:collapse" bordercolor="#000000" width="820">
     <tr bgcolor="#FFCCFF">
       <td align="center" width="100">�~�ŤξǴ�</td>
       <td align="center" width="100">�~/��/��</td>
       <td align="center" width="240">�ѥ[�դ��~���@�A��<br>�ǲߨƶ��ά��ʶ���</td>
       <td align="center" width="50">�ɼ�</td>
       <td align="center" width="80">�n�����</td>
       <td align="center" width="350">�ۧڬ٫�</td>
     </tr>
     <?php
     $M=0;
     while ($row=mysql_fetch_array($res)) {
     	$c=substr($row['seme_class'],0,1);
      ?>
     <tr>
       <td align="center"><?php echo $C[$c]."-".substr($row['year_seme'],-1);?></td>
       <td align="center"><?php echo $row['service_date'];?></td>
       <td>�i<?php echo $row['item'];?>�j<br><?php echo $row['memo'];?>
       	<?PHP
       	 if ($row['confirm']==0) {
       	 ?>
       	 <br><font color=red size=1>�m�|���{��!�n</font>
       	 <?php
       	 }
       	?>
       	</td>
       <td align="center"><?php echo round($row['minutes']/60,2);?></td>
       <td align="center"><?php echo getPostRoom($row['department']);?></td>
       <td >
       	<?php
       	 if (deadline_days($row['service_date'])>$feedback_deadline) {
       	   echo $row['feedback'];
       	 } else {
       	?>
       	<textarea name="feedback[<?php echo $row['detail_sn'];?>]" rows="5" cols="45"><?php echo $row['feedback'];?></textarea>
       	<?php
         }
       	?>
       </td>
     </tr>
      <?php
      if ($row['confirm']==1) $M+=$row['minutes'];
     }
     ?>
     
   </table>
   <table border="0" width="100%">
    <tr>
     <td style="color:#800000;font-size:14pt"><b>���Ǵ��A���A�ȮɼƤw�֭p�F <?php echo round($M/60,2);?> �p��</b></td>
    </tr>
   </table>
   <input type="button" value="�x�s���" onclick="document.myform1.mode.value='save';document.myform1.submit()" style="color:#FF0000">
   </form>
   <?php
  }

 }
 
function deadline_days($day) {
 global $TODAY;
 /***
   $start_time_value=mktime($leaves_starttime_hours,$leaves_starttime_mins,1,
                            $leaves_starttime_month,$leaves_starttime_day,
                            $leaves_starttime_year);
   $end_time_value=mktime($leaves_endtime_hours,$leaves_endtime_mins,1,
                          $leaves_endtime_month,$leaves_endtime_day,
                          $leaves_endtime_year);
  ***/
   $start_time_value=mktime(0,0,1,substr($day,5,2),substr($day,8,2),substr($day,0,4));
   $end_time_value=mktime(0,0,1,substr($TODAY,5,2),substr($TODAY,8,2),substr($TODAY,0,4));
    
   $total_secs=$end_time_value-$start_time_value;
   //$total_mins=$total_secs/60;
   //$total_hours=$total_mins/60;

   $total_days=($total_secs/86400); // �Y��Ӯɶ����ۮt�Ѽ�
   //$hours=$total_hours%24; // �X�p��
   //$mins=$total_mins%60; // �X��
  
   return $total_days;
  
}
 
 ?>
 