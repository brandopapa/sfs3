<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";


//�q�X����
head("���������v�� - �@�~�P���Z");

//sfs_check();
?>
<link type="text/css" rel="stylesheet" href="../contest_teacher/include/my.css">

<?php
$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

//�ثe����ɶ�, �Ω���������Ĵ���
$Now=date("Y-m-d H:i:s");

//POST �e�X��,�D�{���ާ@�}�l 


//�ɭ��e�{�}�l, �����]�b <form>�� , act�ʧ@ , option1, option2 �Ѽ�2��
?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
 <input type="hidden" name="act" value="<?php echo $_POST['act'];?>">
 <input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">
 <input type="hidden" name="option2" value="<?php echo $_POST['option2'];?>">
 <input type="hidden" name="RETURN" value="<?php echo $_POST['act'];?>">
<?php
if ($_POST['act']=='') {
	
   $query="select * from contest_setup where endtime<='$Now' and open_review='1' order by endtime desc";
   $result=mysql_query($query);
   if (@mysql_num_rows($result)>0) {
   ?>
  �п�ܭn�s�����@�~�Φ��Z�G
  <select size="1" name="tsn" onchange="this.form.submit()">
	<option value="" style="color:#FF00FF">--�п���v�ɶ���--</option>
	<?php
	  while ($TEST=mysql_fetch_array($result,1)) {
	  	?>
	  	<option  style="color:#0000FF" value="<?php echo $TEST['tsn'];?>"<?php if (@$_POST['tsn']==$TEST['tsn']) echo " selected";?>><?php echo $TEST['title'];?>�@(���O�G<?php echo $PHP_CONTEST[$TEST['active']];?>)</option>
	  	<?php
    }
	?>
	</select>

<?php
 } else {
      echo "<font color=#FF0000>����p�A�t�Τ��ثe���}�񤽧G�����v�ɦ��Z�I</font>";
 }
} // end if act==''
?>
</form>
<br>
<?php
if (@$_POST['tsn']!="") {
   $TEST=get_test_setup($_POST['tsn']);
   title_simple($TEST);
    	//�d��Ƥ���, �Ȥ��i���Z
    	if ($TEST['active']==1) {
    		$query="select a.*,b.stud_id,b.stud_name,c.seme_class,c.seme_num from contest_user a,stud_base b,stud_seme c where a.student_sn=b.student_sn and a.student_sn=c.student_sn and c.seme_year_seme='".$TEST['year_seme']."' and a.tsn='".$TEST['tsn']."' and a.prize_id>0 order by prize_id";
    		$result_user=mysql_query($query);
    		if (mysql_num_rows($result_user)) {
    			?>
    			<br>
    			<table border="1" width="700" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="3">
    				<tr bgcolor="#FFFFCC">
    					<td width="50" align="center" style="color:#0000FF">�Ǹ�</td>
    					<td width="80" align="center" style="color:#0000FF">�Z��</td>
    					<td width="50" align="center" style="color:#0000FF">�y��</td>
    					<td width="80" align="center" style="color:#0000FF">�m�W</td>
    					<td width="80" align="center" style="color:#0000FF">�@���D��</td>
    					<td width="80" align="center" style="color:#0000FF">�����D��</td>
    					<td width="80" align="center" style="color:#0000FF">�W��</td>
    					<td align="center" style="color:#0000FF">�Ƶ�</td>
    				</tr>
    			<?php
    			$i=0;
    		  while ($Stud=mysql_fetch_array($result_user,1)) {
    		  	$i++;
    		  	//�ˬd�O�_���խ�
			    	$query="select a.*,b.stud_id,b.stud_name,c.seme_class,c.seme_num from contest_user a,stud_base b,stud_seme c where a.student_sn=b.student_sn and a.student_sn=c.student_sn and c.seme_year_seme='".$TEST['year_seme']."' and  a.tsn='".$TEST['tsn']."' and a.ifgroup='".$Stud['student_sn']."' order by seme_class,seme_num";
    				$GROUPS=mysql_query($query);
    				$Group_num=mysql_num_rows($GROUPS);
    		  	 //�ǥͤw�����O��
    	       list($chk)=mysql_fetch_row(mysql_query("select count(*) from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."'")); //�`�D��
    	       list($NUM)=mysql_fetch_row(mysql_query("select count(*) from contest_record1 where tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."' and chk=1")); // ����

 			    //�Z���त��
    			$class_id=sprintf('%03d_%d_%02d_%02d',substr($TEST['year_seme'],0,3),substr($TEST['year_seme'],3,1),substr($Stud['seme_class'],0,1),substr($Stud['seme_class'],1,2));
  	  		$class_data=class_id_2_old($class_id);
					$Stud['seme_class']=$class_data[5];

						
						?>
   					<tr class="mytr<?php echo $i%2;?>">
   					  <td align="center"><?php echo $Stud['stud_id'];?></td>
      				<td align="center"><?php echo $Stud['seme_class'];?></td>
      				<td align="center"><?php echo $Stud['seme_num'];?></td>
    					<td align="center"><?php echo $Stud['stud_name'];?></td>
    					<td align="center" rowspan="<?php echo $Group_num+1;?>"><?php echo $chk;?></td>
    					<td align="center" rowspan="<?php echo $Group_num+1;?>"><?php echo $NUM;?></td>
    					<td align="center" rowspan="<?php echo $Group_num+1;?>"><?php echo $Stud['prize_text'];?></td>
    					<td style="font-size:10pt" rowspan="<?php echo $Group_num+1;?>"><?php echo $Stud['prize_memo'];?></td>
    				</tr>
    		  <?php
    		    if ($Group_num>0) {
    		     while ($row=mysql_fetch_array($GROUPS,1)) {
		 			    //�Z���त��
    					$class_id=sprintf('%03d_%d_%02d_%02d',substr($TEST['year_seme'],0,3),substr($TEST['year_seme'],3,1),substr($row['seme_class'],0,1),substr($row['seme_class'],1,2));
  	  				$class_data=class_id_2_old($class_id);
							$row['seme_class']=$class_data[5];
    		     ?>
   					<tr class="mytr<?php echo $i%2;?>">
   					  <td align="center"><?php echo $row['stud_id'];?></td>
      				<td align="center"><?php echo $row['seme_class'];?></td>
      				<td align="center"><?php echo $row['seme_num'];?></td>
    					<td align="center"><?php echo $row['stud_name'];?></td>
    				</tr>
    		     <?php
    		     } // end while
    		    } //end if Group_num>0
    		  
    		  } // end while
    		  ?>
    		 </table>
    		 <table border="0" width="100%">
    		   <tr>
    		   	 <td style="color:#FF0000">���p�ݽƬd���Z�A�Ь��v�ɿ�z���C</td>
    		   </tr>
    		 </table>
    		  <?php
    		} // if mysql_num_rows
    	
    	//��L�A�@�֤��i�@�~ 
    	} else {   //else if active==1
    		$query="select a.*,b.stud_id,b.stud_name,c.seme_class,c.seme_num from contest_user a,stud_base b,stud_seme c where a.student_sn=b.student_sn and a.student_sn=c.student_sn and c.seme_year_seme='".$TEST['year_seme']."' and a.tsn='".$TEST['tsn']."' and a.prize_id>0 order by prize_id";
    		$result_user=mysql_query($query);
    		if (mysql_num_rows($result_user)) {
    			?>
    			<br>
    			<table border="1" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="3">
    				<tr bgcolor="#FFFFCC">
    					<td width="50" align="center" style="color:#0000FF">�Ǹ�</td>
    					<td width="80" align="center" style="color:#0000FF">�Z��</td>
    					<td width="50" align="center" style="color:#0000FF">�y��</td>
    					<td width="80" align="center" style="color:#0000FF">�m�W</td>
    					<td width="256" align="center" style="color:#0000FF">�v�ɧ@�~</td>
    					<td width="80" align="center" style="color:#0000FF">�o���W��</td>
    					<td align="center" style="color:#0000FF">���f���y�Ψ�L�����ƶ�</td>
    				</tr>
    			<?php
    			$i=0;
    		  while ($Stud=mysql_fetch_array($result_user,1)) {
    		  	$i++;
    		  	//�ˬd�O�_���խ�
			    	$query="select a.*,b.stud_id,b.stud_name,c.seme_class,c.seme_num from contest_user a,stud_base b,stud_seme c where a.student_sn=b.student_sn and a.student_sn=c.student_sn and c.seme_year_seme='".$TEST['year_seme']."' and a.tsn='".$TEST['tsn']."' and a.ifgroup='".$Stud['student_sn']."' order by seme_class,seme_num";
    				$GROUPS=mysql_query($query);
    				$Group_num=mysql_num_rows($GROUPS);
   		  	 //�ǥͧ@�~�O��
    	       $query="select * from contest_record2 where tsn='".$TEST['tsn']."' and student_sn='".$Stud['student_sn']."'";
    	       $WORKS=mysql_fetch_array(mysql_query($query),1);
    	       $WORKS['prize_memo']=get_prize_memo($TEST['tsn'],$Stud['student_sn']);
 			    //�Z���त��
	    				$class_id=sprintf('%03d_%d_%02d_%02d',substr($TEST['year_seme'],0,3),substr($TEST['year_seme'],3,1),substr($Stud['seme_class'],0,1),substr($Stud['seme_class'],1,2));
  		  			$class_data=class_id_2_old($class_id);
							$Stud['seme_class']=$class_data[5];

						?>
   					<tr class="mytr<?php echo $i%2;?>">
   					  <td align="center"><?php echo $Stud['stud_id'];?></td>
      				<td align="center"><?php echo $Stud['seme_class'];?></td>
      				<td align="center"><?php echo $Stud['seme_num'];?></td>
    					<td align="center"><?php echo $Stud['stud_name'];?></td>
    					<td align="center" rowspan="<?php echo $Group_num+1;?>">
    					 <?php
    					   $a=explode(".",$WORKS['filename']);
  	   					$filename_s=$a[0]."_s.".$a[1];
  	   					switch ($TEST['active']) {
  	   		  			case '2':
  	   		  			?>
  	   		    		<img src="<?php echo $UPLOAD_U[2].$filename_s; ?>" border="0"><br>
  	   		  			<?php
  	   		  		break;
  	   		  		case '3':
  	   		   			?>
										<embed src="<?php echo $UPLOAD_U[3].$WORKS['filename'];?>" width=240 height=180 type=application/x-shockwave-flash Wmode="transparent"><br>
  	   		   			<?php
  	   		  		break;
  	   		  		default:  	   		
  	   				} // end switch
   			?>
    					
    						<a href="<?php echo $UPLOAD_U[$TEST['active']].$WORKS['filename'];?>" target='_blank'>�[�ݭ��</a>
    					
    					</td>
    					<td align="center" rowspan="<?php echo $Group_num+1;?>"><?php echo $Stud['prize_text'];?></td>
    					<td style="font-size:10pt" rowspan="<?php echo $Group_num+1;?>"><?php echo $WORKS['prize_memo'];?></td>
    				</tr>
    				<?php
    		    if ($Group_num>0) {
    		     while ($row=mysql_fetch_array($GROUPS,1)) {
		 			    //�Z���त��
	    				$class_id=sprintf('%03d_%d_%02d_%02d',substr($TEST['year_seme'],0,3),substr($TEST['year_seme'],3,1),substr($row['seme_class'],0,1),substr($row['seme_class'],1,2));
  		  			$class_data=class_id_2_old($class_id);
							$row['seme_class']=$class_data[5];
    		     ?>
   					<tr class="mytr<?php echo $i%2;?>">
   					  <td align="center"><?php echo $row['stud_id'];?></td>
      				<td align="center"><?php echo $row['seme_class'];?></td>
      				<td align="center"><?php echo $row['seme_num'];?></td>
    					<td align="center"><?php echo $row['stud_name'];?></td>
    				</tr>
    		     <?php
    		     } // end while
    		    } //end if Group_num>0

    		  } // end while
    		  ?>
    		 </table>
    		 <table border="0" width="100%">
    		   <tr>
    		   	 <td style="color:#FF0000">���p�ݽƬd���Z�A�Ь��v�ɿ�z���C</td>
    		   </tr>
    		 </table>
    		  <?php
    		} // if mysql_num_rows
    		
    		
    		
    	} // end if active 
 
} // end if $_POST['tsn']!=''
?>
