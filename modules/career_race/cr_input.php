<?php
//���o�]�w��
include_once "config.php";

sfs_check();

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//Ū���ثe�ާ@���Ѯv���S���޲z�v
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

$R_select=explode(',',$rank_select);
$N_select=explode(',',$nature_select);

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ� , �Y����w�h�H��w���Ǵ��@�����ǥͯZ�Ůy�����̾�, �_�h�H�̷s�Ǵ����Ӹꬰ��
$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

//���o�ثe�Ҧ��Z��
$class_array=class_base();

//�w�]�å���w�ǥ�
$start=0;

/** submit �᪺�ʧ@ **************************************************/
//�R���浧
if ($_POST['act']=='DeleteOne') {
	$sn=$_POST['option1'];
	$query="delete from career_race where sn='$sn'";
	mysql_query($query);
	$_POST['act']='';
}

//�x�s�@��
if ($_POST['act']=='save') {
	
 	$student_sn=$_POST['student_sn'];
	$level=$_POST['level'];
	$squad=$_POST['squad'];
	$name=$_POST['r_name'];
	$rank=$_POST['rank'];
  $certificate_date=$_POST['certificate_date'];
	$sponsor=$_POST['sponsor'];
	$memo=$_POST['memo'];
	$word=strip_tags(trim($_POST['word']));
	$weight=$_POST['weight'];
	$weight_tech=$_POST['weight_tech'];
	$year=$_POST['year'];
	$nature=$_POST['nature'];
	
	$query="insert into career_race set student_sn='$student_sn',level='$level',squad='$squad',name='$name',
	rank='$rank',certificate_date='$certificate_date',sponsor='$sponsor',memo='$memo',
	word='{$word}', weight='{$weight}', weight_tech='{$weight_tech}',year='$year',nature='$nature' ,	update_sn='".$_SESSION['session_tea_sn']."'";
   		if (!mysql_query($query)) {
   		 $MSG="�x�s��ƥ���!";
   		  echo$query;die($MSG);
			} 
	$_POST['act']='';
}

//���w edit ���ǥ�
if ($_POST['act']=='update') {
  $student_sn=$_POST['student_sn'];
	$level=$_POST['level'];
	$squad=$_POST['squad'];
	$name=$_POST['r_name'];
	$rank=$_POST['rank'];
  $certificate_date=$_POST['certificate_date'];
	$sponsor=$_POST['sponsor'];
	$memo=$_POST['memo'];
	$word=strip_tags(trim($_POST['word']));
	$weight=$_POST['weight'];
	$weight_tech=$_POST['weight_tech'];
	$year=$_POST['year'];
	$nature=$_POST['nature'];
	
	$query="update career_race set level='$level',squad='$squad',name='$name',rank='$rank', certificate_date='$certificate_date',sponsor='$sponsor',memo='$memo', word='$word',weight='$weight',weight_tech='$weight_tech',year='$year',nature='$nature' where sn='".$_POST['option1']."' and student_sn='$student_sn'";
   		if (!mysql_query($query)) {
   		 $MSG="�x�s��ƥ���!";
   		 echo$query;die($MSG);
			}  
  $_POST['act']='';
}

//�Y�����w�s��
if ($_POST['act']=='edit') {
	$query="select a.student_sn,a.curr_class_num from stud_base a,career_race b where a.student_sn=b.student_sn and b.sn='".$_POST['option1']."'";
  $res=mysql_query($query);
  $row=mysql_fetch_array($res,1);
  $_POST['to_class']=substr($row['curr_class_num'],0,3);
  $_POST['to_student']=$row['student_sn'];
  //echo $query;
  
}


//���o�Z�ũҦ��ǥ� array
if (isset($_POST['to_class'])) {
	$query="select a.student_sn,a.stud_id,a.seme_class,a.seme_num,b.stud_name from stud_seme a,stud_base b where a.student_sn=b.student_sn and a.seme_year_seme='$c_curr_seme' and a.seme_class='".$_POST['to_class']."' order by a.seme_num";
	$res=mysql_query($query);
	$student_array=array();
	while ($row=mysql_fetch_array($res,1)) {
		$student_array[$row['student_sn']]=$row['seme_num']." ".$row['stud_name'];
	}
}

//�Q��select���w���ǥ� 
if (isset($_POST['to_student'])) {
	$student_sn=$_POST['to_student'];
}

//

/**************** �}�l�q�X���� ******************/
//�q�X SFS3 ���D
head();

//�C�X���
echo $tool_bar;

//print_r($class_array);

?>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">

<table border="0" width="100%" cellspacing="1" cellpadding="2" bgcolor="#CCCCCC">
<tr>
  <td  width="100%" valign="top" bgcolor="#ffffff">
	<!-- �ǥ͸�ƤΤw�n�����O��  -->
	<table border="0" >
		<tr>
			<td colspan="2" style="color:#800000">���п�w�ǥ�</td>
		</tr>
		<tr>
			<td>�Z��</td>
			<td>
				<select size="1" name="to_class" onchange="document.myform.submit()">
					<option value="">---</option>
					<?php
					 foreach ($class_array as $k=>$v) {
					 ?>
					 <option value="<?php echo $k;?>" <?php if ($k==$_POST['to_class']) echo "selected";?>><?php echo $v;?></option>
					 <?php
					 }
					?>
				</select>
			</td>
			<td>�m�W</td>
			<td>
				<select size="1" name="to_student"  onchange="document.myform.submit()">
					<option value="">---</option>
					<?php
					 foreach ($student_array as $k=>$v) {
					 ?>
					 <option value="<?php echo $k;?>" <?php if ($k==$student_sn) { $start=1; echo "selected"; } ?>><?php echo $v;?></option>
					 <?php
					 }
					?>
				</select>
				<?php
				if ($start==1) {
				?>
					<input type="button" value="��ܿ�J���" onclick="race_form.style.display='block';">
				<?php
				}
				?>
			</td>
		</tr>
	</table>
	<?php
	if ($start==1) {
		//Ū���ӥͤw�n�����v�ɰO��
		$race_record_all=get_race_record("","",$student_sn);
		?>
	<!-- �n�����  -->
	<table border="0" bgcolor="#ffffff" style="border-collapse:collapse" bordercolor="#800000">
		<tr>
			<td style="color:#800000">
				<div id="race_form" style="padding: 0px;<?php if ($_POST['act']=="") echo ";display:none";?>">
				<fieldset style="line-height: 150%; margin-top: 0; margin-bottom: 0">
				<legend><font size=2 color=#0000dd>�п�J�v�ɲӥ�</font></legend>
				<?php
	 				if ($_POST['act']=='edit') {
	 					//�Y���I��s��, �h�N��Ʃ�J�}�C
	   				foreach ($race_record_all[$_POST['option1']] as $k=>$v){
	     				$race_record[$k]=$v;
	   				} // end foreach
	 					 $act='update';
					 } else {
						$race_record['level']=5;	
						$race_record['squad']=1;
						$race_record['certificate_date']=date("Y-m-d");
						$act='save';
					 }
						form_race_record($race_record);
					?>
					<input type="hidden" name="student_sn" value="<?php echo $student_sn;?>">
					<input type="button" value="�x�s�@���O��" onclick="check_save('<?php echo $act;?>')">
			</fieldset>
			</div>
			</td>
		</tr>
	</table>
		<font color="#800000">���ӥͪ��Ҧ��ѻP�v�ɰO��</font>
		<?php
		
		list_race_record($race_record_all,0,1);
		
	} // end if start
	?>

	</td>	
</tr>
</table>
</form>

<Script language="JavaScript">
 //�˴���ƬO�_����
 function check_save(ACT) {
 	var ok=1;
 	if (document.myform.r_name.value=='') {
 		ok=0;
 		alert('�п�J�v�ɦW��');
 		document.myform.r_name.focus();
 		return false;
 	}
 	if (document.myform.rank.value=='') {
 		ok=0;
 		alert('�п�J�o���W��, �p�u��1�W�v�B�u�u���v....���C');
 		document.myform.rank.focus();
 		return false;
 	}
 	if (document.myform.certificate_date.value=='') {
 		ok=0;
 		alert('�п�J�ҮѤ��');
 		document.myform.certificate_date.focus();
 		return false;
 	}
 	if (document.myform.sponsor.value=='') {
 		ok=0;
 		alert('�п�J�|����');
 		document.myform.sponsor.focus();
 		return false;
 	}
 	
 	if (ok==1) {
 		document.myform.act.value=ACT;
 		document.myform.submit();
 	}
 	
 }

</Script>
