<?php

// $Id: reward_one.php 7062 2013-01-08 15:37:05Z smallduh $

//���o�]�w��
include_once "config.php";
include "../../include/sfs_case_dataarray.php";

sfs_check();


//�q�X����
head("��ǥ͸ɵn�L�ո��");

	//�����\���
$tool_bar=&make_menu($school_menu_p);
echo $tool_bar;

$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}


//�ثe�Ǵ�
$c_curr_seme=sprintf("%03d%d",curr_year(),curr_seme());

//���o�Ҧ��Ǵ�
$seme_list=get_class_seme();

//�ثe��w�Ǵ�
$work_year_seme=$_POST['work_year_seme'];
if ($work_year_seme=='') $work_year_seme = $c_curr_seme;
$move_year_seme = intval(substr($work_year_seme,0,-1)).substr($work_year_seme,-1,1);


  //�w�I�諸�ǥ� student_sn
  $selected_student=$_POST['selected_student'];


//�W�[�@�Ӫ��ΰO��
if ($_POST['act']=='club_add') {
 $year_seme=sprintf("%03d",substr($_POST['year_seme'],0,strlen($_POST['year_seme'])-1)).substr($_POST['year_seme'],-1);
 $query="insert into association (student_sn,seme_year_seme,association_name,score,stud_post,description,update_sn,update_time) values ('".$selected_student."','$year_seme','".$_POST['association_name']."','".$_POST['score']."','".$_POST['stud_post']."','".$_POST['description']."','".$_SESSION['session_tea_sn']."',NOW())";
 mysql_query($query);
 $_POST['act']='';
}
//�R���@�Ӫ��ΰO��
if ($_POST['act']=='club_delete') {
 $query="delete from association where sn='".$_POST['option1']."'";
 mysql_query($query);
 $_POST['act']='';
 $_POST['option1']='';
}

?>

<form method="post" name="myform" act="<?php echo $_SERVER['php_self'];?>">
	<input type="hidden" name="act" value="<?php echo $_POST['act'];?>">
	<input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">	
		�������J���Ǵ��G
	<select name="work_year_seme" onchange="document.myform.submit();">
  <?php
		foreach($seme_list as $key=>$value) {
	?>		
	 <option value="<?php echo $key;?>" <?php if ($key==$work_year_seme) echo " selected";?>><?php echo $value;?></option>
	 <?php
	 }
	 ?>
	</select><br>
	
<?php
  //�w��Ǵ��C�X�ǥ�
if ($work_year_seme!='') {
  	$check_student=0;
  	//���o�ӾǴ���J�ǥͲM��
		$sql="SELECT a.*,b.stud_id,b.stud_name,b.stud_sex,b.stud_study_year FROM stud_move a LEFT JOIN stud_base b ON a.student_sn=b.student_sn WHERE a.move_kind in (2,3,14) AND move_year_seme='$move_year_seme' ORDER BY move_date DESC";
		$recordSet=$CONN->Execute($sql) or user_error("Ū��stud_move�Bstud_base��ƥ��ѡI<br>$sql",256);
		$col=3; //�]�w�C�@�C��ܴX�H
		$studentdata="����ܱ��ɵn���ǥ͡G<table>";
		while(!$recordSet->EOF) {
			$currentrow=$recordSet->currentrow()+1;
			if($currentrow % $col==1) $studentdata.="<tr>";
			$student_sn=$recordSet->fields['student_sn'];
			$stud_id=$recordSet->fields['stud_id'];
			$stud_name=$recordSet->fields['stud_name'];
			$stud_move_date=$recordSet->fields['move_date'];
			if($recordSet->fields['stud_sex']=='1') $color='#CCFFCC'; else  $color='#FFCCCC';
			if($student_sn==$selected_student) {
				$color='#FFFFAA';
				$stud_study_year=$recordSet->fields['stud_study_year'];
				$selected_student_id=$stud_id;
			}
	    
	    if ($student_sn==$selected_student) {
			  $student_radio="<input type='radio' value='$student_sn' name='selected_student' checked onclick='document.myform.submit()'>( $student_sn - $stud_id ) $stud_name - $stud_move_date";	
			  $check_student=1;
			} else {
			  $student_radio="<input type='radio' value='$student_sn' name='selected_student' onclick='document.myform.submit()'>( $student_sn - $stud_id ) $stud_name - $stud_move_date";	
			}
			$studentdata.="<td bgcolor='$color' align='center'> $student_radio </td>";

			if( $currentrow % $col==0  or $recordSet->EOF) $studentdata.="</tr>";
			$recordSet->movenext();
	  } // end while
			$studentdata.='</table><hr>';
		
    echo $studentdata;
    
    //�Y�w�I��ǥ�, �C�X�ӥͪ���Ƥηs�W���
    if ($check_student) {
    ?>
		  <font color='#800000'>���ɵn���ΰO��</font>
		  <table border='1' style='border-collapse:collapse' bordercolor='#800000'>
		    <tr bgcolor='#FFCCFF'>
		     <td align='center'>�Ǵ�</td>
		     <td align='center'>���ΦW��</td>
		     <td align='center'>���Z(0-100��)</td>
		     <td align='center'>¾��</td>
		     <td align='center'>���ɦѮv���y</td>
		     <td align='center'>&nbsp;</td>
			  </tr>
		<?php
			$query="select * from association where student_sn='$selected_student' order by seme_year_seme";
			$res=mysql_query($query);
			while ($row=mysql_fetch_array($res,1)) {
			 ?>
		    <tr>
		     <td align='center'><?php echo $row['seme_year_seme'];?></td>
		     <td align='center'><?php echo $row['association_name'];?></td>
		     <td align='center'><?php echo $row['score'];?></td>
				 <td align='center'><?php echo $row['stud_post'];?></td>
		     <td><?php echo $row['description'];?></td>
		     <td align='center'>
		     	<?php
		     	if ($row['club_sn']>0) {
		     	?>
		     	 <font size="2" color=red><i>�դ�����</i></font>
		     	<?php
		     	} else {
		     	?>
		     	<input type="button" value="�R��" onclick="if(confirm('�z�T�w�n�R���ӥͪ�\����:�u<?php echo $row['association_name'];?>�v�O��?')) { document.myform.option1.value='<?php echo $row['sn'];?>';document.myform.act.value='club_delete';document.myform.submit(); } ">
			   <?php
			    }
			   ?>
			   </td>
			  </tr>
				<?php
			}  			
			?>  
		    <tr>
		     <td align='center'><input type=;text' name='year_seme' size='5'></td>
		     <td align='center'><input type='text' name='association_name' size='20'></td>
		     <td align='center'><input type='text' name='score' size='5'></td>
		     <td align='center'><input type='text' name='stud_post' size='8'></td>
		     <td><input type='text' name='description' size='50'></td>
		     <td><input type="button" value="�s�W���θ��" onclick="check_input()">
			  </tr>
		  </table>
      ������:<br>
      1.�Ǵ��п�J�Ǧ~+�Ǵ��O, �p: 99�Ǧ~��1�Ǵ�, �h��J 991 �C<br>
      2.�H���ҲթҸɵn�����, �b���μҲդ��L�k�d�o, �����Z�椺�i���`��X.
   <?php
  
	} // end if selected_student
    
    
 } // end if ($work_year_seme!='')
?>
	
	

</form>



<?php
foot();
?>

<script>
 function check_input() {
   if (document.myform.year_seme.value=='') {
   	alert('����J�Ǧ~�Ǵ�');
    return false;
   }
   if (document.myform.association_name.value=='') {
   	alert('����J���ΦW��');
    return false;
   }
 
  document.myform.act.value='club_add';
  document.myform.submit();

 }

</script>