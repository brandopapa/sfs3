<?php

// $Id: name_form.php 7706 2013-10-23 08:59:03Z smallduh $

/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";

//���J���ά��ʼҲժ����Ψ禡
include_once "../stud_club/my_functions.php";

if($_GET['many_col']) $many_col=$_GET['many_col'];
else $many_col=$_POST['many_col'];
//�ϥΪ̻{��
sfs_check();
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
$teacher_sn=$_SESSION['session_tea_sn'];//���o�n�J�Ѯv��id
//��X���ЯZ��
$class_name=teacher_sn_to_class_name($teacher_sn);

//��w���ǥ�
$STUDENT_SN=$_POST['STUDENT_SN'];
//�~��
$CLASS=substr($class_name[0],0,1);


	//�q�X����
	head("���ο��");

	print_menu($menu_p);

    $seme_year_seme=sprintf("%03d",curr_year()).curr_seme();
		
		$c_curr_seme=$seme_year_seme;

?>    
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>">
 <input type="hidden" name="mode" value="">
<table border="0">
  <tr>
   <td>
   <!-- �W��� -->
	 <?php    
    $sql="select student_sn,stud_id,seme_num from stud_seme where seme_class='$class_name[0]' and  seme_year_seme='$seme_year_seme' order by  seme_num";
    $rs=$CONN->Execute($sql);
    $m=0;
    ?>
    <table bgcolor='#000000' border=0 cellspacing=1 cellpadding=2>
    	<tr bgcolor='#FAF799'>
    		<td colspan='3'><?php echo $class_name[1];?></td>
    	</tr>
    <?php
	while(!$rs->EOF){
    		$student_sn[$m]=$rs->fields["student_sn"];
        $stud_id[$m] = $rs->fields["stud_id"];
        $site_num[$m] = $rs->fields["seme_num"];
        $rs_name=$CONN->Execute("select stud_name from stud_base where stud_id='$stud_id[$m]' and stud_study_cond =0 ");
        
        if ($rs_name->fields["stud_name"]) {
           $stud_name[$m] = $rs_name->fields["stud_name"];	
           ?>
           <tr bgcolor='#FFFFFF'>
           	<td><input type="radio" name="STUDENT_SN" value="<?php echo $student_sn[$m];?>"<?php if ($_POST['STUDENT_SN']==$student_sn[$m]) echo " checked";?> onclick='document.myform.submit()'></td>
           	<td><?php echo $site_num[$m];?></td>
           	<td><?php echo $stud_name[$m];?></td>
           </tr>
           <?php
		$m++;
	}
        $rs->MoveNext();
    }
	echo "</table>";
	?>
  
   </td>
   <td valign="top">
	 <!-- ��ܰ� -->
	 <?php
	 	//���o�Ǵ����γ]�w
	 	$SETUP=get_club_setup($c_curr_seme);
	 	//�i��Үɬq �ɤ�����~ 2012-06-01 12:12:00
		$StartSec=date("U",mktime(substr($SETUP['choice_sttime'],11,2),substr($SETUP['choice_sttime'],14,2),0,substr($SETUP['choice_sttime'],5,2),substr($SETUP['choice_sttime'],8,2),substr($SETUP['choice_sttime'],0,4)));
		$EndSec=date("U",mktime(substr($SETUP['choice_endtime'],11,2),substr($SETUP['choice_endtime'],14,2),0,substr($SETUP['choice_endtime'],5,2),substr($SETUP['choice_endtime'],8,2),substr($SETUP['choice_endtime'],0,4)));
		$nowsec=date("U",mktime(date("H"),date("i"),0,date("n"),date("j"),date("Y")));
		//��Үɬq�O�_�w�L
		if ($StartSec > $nowsec or $EndSec < $nowsec) {
			echo "�t�ήɶ�".date("Y-m-d H:i:s") ."<br>";
 			echo "��p�A�{�b�D��Үɬq�A�L�k�i���ҡI";
 			exit();
		}
		
		//�����\��צh�Ӫ��ή�
if ($SETUP['multi_join']==0) {
	//�ˬd�ǥͬO�_�w�ѥ[����
	//$my_club=get_student_join_club($STUDENT_SN,$c_curr_seme);
	if ($my_club=get_student_join_club($STUDENT_SN,$c_curr_seme)) {
		echo "���Ǵ����ͤw�ѥ[�U�C���ΡA���ݰѥ[��ҡI<br>";
		foreach ($my_club as $My) {
	 		echo "<font color=red>�i".$My['club_name']."�j</font><br>";
		}
		exit();
	}
} // end if $SETUP['multi_join']

//check_arrange();


if ($StartSec<$nowsec and $EndSec>$nowsec) {
	
	//���o�i��ת�����
	$query="select * from stud_club_base where year_seme='$c_curr_seme' and club_open='1' and (club_class='$CLASS' or club_class='100')"; 
	$res_club=mysql_query($query);
	$club_num=mysql_num_rows($res_club);
	/*
	//���Υi�ѿ�ܦW�B
	$club_for_stud_num=club_for_stud_num($CLASS,$c_curr_seme);

	//���o�Ӧ~�ŤH��
	$CLASS_num=class_student_num($CLASS,$c_curr_seme);
	// $CLASS_not_arranged �Ӧ~�ũ|��s�Z�H��
	
 //�ˬd���ζ}���`�����ƬO�_�����Ӧ~�žǥͿ��
  if ($CLASS_not_arranged>$club_for_stud_num) {
  	echo "���Υi�ѿ�פH�Ƥ����I<br>";
  	echo "$CLASS_name �žǥͦ@".$CLASS_num."�H , �|���s�Z���ǥͦ�".$CLASS_not_arranged."�H <br>";
  	echo "���M�ݥ��~�Ū��γѾl�i�ѿ�Ҫ��W�B�� ".$club_for_stud_num. "�H";
  	exit();
  }
	*/
	//=================================

	if ($_POST['mode']=='insert') {
	  foreach ($_POST['choice'] as $K=>$club_sn) {
	  if ($club_sn!="") {
	  	$CLUB_SET=get_club_base($club_sn);
	  	
	  	$club_student_num=get_club_student_num($c_curr_seme,$row['club_sn']);
			$club_student_number=$club_student_num[0]; //�����Τw�n�����H��
	  	
	  	if (($SETUP['choice_over']==0 and get_club_choice_rank($club_sn,1)>=$CLUB_SET['club_student_num']) or ($club_student_number>=$CLUB_SET['club_student_num'])) {
		   $INFO="���� �i".$CLUB_SET['club_name']."�j�H�Ƥw���I�����x�s!";
		   $query="delete from stud_club_temp where  year_seme='$c_curr_seme' and student_sn='".$STUDENT_SN."' and choice_rank='$K'";
		   mysql_query($query);
		  } else {
	    $query="select * from stud_club_temp where year_seme='$c_curr_seme' and student_sn='".$STUDENT_SN."' and choice_rank='$K'";
	    $result=mysql_query($query);
	    if (mysql_num_rows($result)) {
	   			$query="update stud_club_temp set club_sn='$club_sn' where year_seme='$c_curr_seme' and student_sn='".$STUDENT_SN."' and choice_rank='$K'";
	    	}else{
	   			$query="insert into stud_club_temp (club_sn,year_seme,student_sn,choice_rank) values ('$club_sn','$c_curr_seme','".$STUDENT_SN."','$K')";
	    } // end if mysql_num_rows
	    
	    if (mysql_query($query)) {
	     $INFO="�w��".date("Y-m-d H:i:s")."�x�s���@!";	    
	    }else{
	     echo "Error! query=$query";
	     exit();
	    }
	   } // end if $SETUP['choice_over']==0 and get_club_choice_rank($club_sn,1)>=$ ....
	  } // end if $club_sn!=""   
	  }	// end foreach
	
	} // end if ($_POST['mode']=='insert')	
	
	//=================================
	if ($_POST['STUDENT_SN']=='') {
		echo "�п�ܾǥ�:";
	} else {
	?>
 				<table border="0" width="100%">
					<?php
					    for ($i=1;$i<=$SETUP['choice_num'];$i++) {
					    	$choice=get_seme_stud_choice_rank($c_curr_seme,$STUDENT_SN,$i); //�Ǧ^�@club_sn
					    		//���o�i��ת�����
								$query="select * from stud_club_base where year_seme='$c_curr_seme' and club_open='1' and (club_class='$CLASS' or club_class='100') order by club_class,club_name"; 
								$res_club=mysql_query($query);
								?>
					    	 <tr>
					    	 	<td align="left">
										��<?php echo $i;?>���@
										<select size="1" name="choice[<?php echo $i;?>]">
											<option value="" style="color:#FF00FF">�п��...</option>
											<?php
											while ($row=mysql_fetch_array($res_club)) {
												$club_student_num=get_club_student_num($c_curr_seme,$row['club_sn']);
												$club_student_number=$club_student_num[0]; //�����Τw�n�����H��
												if (($SETUP['choice_over']==0 and get_club_choice_rank($row['club_sn'],$i)>=$row['club_student_num']) or ($club_student_number>=$row['club_student_num'])) {
													continue;
												}else{
											 ?>
											 <option value="<?php echo $row['club_sn'];?>"<?php if ($row['club_sn']==$choice) echo " selected";?> style="color:#800000"><?php echo $row['club_name'];?></option>
											 <?php
											 } // end if
											}
											?>			
										</select>
										<br><br>
					    	 	</td>
					    	</tr>
					    	<?php
					    }
					?>
					<tr>
						<td><input type="button" value="�x�s" onclick="document.myform.mode.value='insert';document.myform.submit()"></td>
					</tr>
					<tr>
						<td style="color:#FF0000;font-size:9pt"><br><br><?php echo $INFO;?></td>
					</tr>
				</table>
	<?php
	} // end if student_sn
} // end if $StartSec<$nowsec and $EndSec>$nowsec
	?>   
   </td>
  </tr>
</table>  


</form>
  
<?php
	//�����D������ܰ�
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	//�{���ɧ�
	foot();

?>
