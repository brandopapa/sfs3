<?php
include_once('config.php');

sfs_check();

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//Ū���ثe�ާ@���Ѯv���S���޲z�v
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

//�ثe�Ǵ�
$c_curr_seme=sprintf("%03d%d",curr_year(),curr_seme());
//�ثe��w�Ǵ�
$the_seme=($_POST['the_seme']=="")?$c_curr_seme:$_POST['the_seme'];

//�ثe��w����
$the_page=($_POST['option2']>=1)?$_POST['option2']:1;


//���^�ܼ�
$M_SETUP=get_module_setup('class_report');
$PAGES=$M_SETUP['pages']; //�C�����C�X��

//�q�X SFS3 ���D
head();

//�C�X���
echo $tool_bar;

//post �᪺�ʧ@
//���w�]��
if ($_POST['act']=='') {
	$REP['seme_year_seme']=$c_curr_seme;
	$REP['open_input']=0;				//�}��p�Ѯv�n��
	$REP['open_read']=0;				//�}���s��
	$REP['open_classmates']=0;	//�}���s�����Z
	$REP['rep_sum']=1;					//�۰ʨD�`��
	$REP['rep_avg']=1;					//�۰ʨD����
	$REP['rep_rank']=0;					//�۰ʺ�ƦW
}
//select ���Z���ܤF
if ($_POST["change_class"]) {
	foreach ($_POST as $k=>$v) {
		$REP[$k]=$v;
	}
}
//�s�W�@�i���Z��
if ($_POST['act']=='insert') {
	foreach ($_POST as $k=>$v) {
		${$k}=$v;
	} //end foreach
	$sql="insert into `class_report_setup` set seme_year_seme='$seme_year_seme',seme_class='$seme_class',title='$title',teacher_sn='{$_SESSION['session_tea_sn']}',student_sn='$student_sn',open_input='$open_input',open_read='$open_read',rep_classmates='$rep_classmates',rep_sum='$rep_sum',rep_avg='$rep_avg',rep_rank='$rep_rank',update_sn='{$_SESSION['session_tea_sn']}'";
	$res=$CONN->Execute($sql) or die("SQL���~:$sql");
	$_POST['act']="";
} // end if

//�ק令�Z��]�w
if ($_POST['act']=='edit') {
	$sql="select * from `class_report_setup` where sn='{$_POST['option1']}'";
	$res=$CONN->Execute($sql) or die("SQL���~:$sql");
	$REP=$res->FetchRow();
}

//���ꦨ�Z��]�w
if ($_POST['act']=='unlock') {
	$sql="update `class_report_setup` set locked='0' where sn='{$_POST['option1']}'";
	$res=$CONN->Execute($sql) or die("SQL���~:$sql");
  $_POST['act']='';
	$_POST['option1']='';
}

if ($_POST['act']=='update') {
	foreach ($_POST as $k=>$v) {
		${$k}=$v;
	} //end foreach
	$sql="update `class_report_setup` set seme_year_seme='$seme_year_seme',seme_class='$seme_class',title='$title',teacher_sn='{$_SESSION['session_tea_sn']}',student_sn='$student_sn',open_input='$open_input',open_read='$open_read',rep_classmates='$rep_classmates',rep_sum='$rep_sum',rep_avg='$rep_avg',rep_rank='$rep_rank',update_sn='{$_SESSION['session_tea_sn']}' where sn='{$_POST['option1']}'";
	$res=$CONN->Execute($sql) or die("SQL���~:$sql");
	$_POST['act']='';
	$_POST['option1']='';
} // end if

//�R�����Z��
if ($_POST['act']=='DeleteOne') {
	//���o�������Z�檺�Ҧ��Ҹ�	
  $TESTS=get_report_test_all($_POST['option1']); 
	//�R���Ҧ��ǥͦ��Z
	foreach ($TESTS as $test_setup) {
		$sql="delete from class_report_score where test_sn='{$test_setup['sn']}'";
		$res=$CONN->Execute($sql) or die("SQL���~:$sql");
	}
	//�R�����Z�檺�Ҹճ]�w
		$sql="delete from class_report_test where report_sn='{$_POST['option1']}'";
		$res=$CONN->Execute($sql) or die("SQL���~:$sql");
	//�R�����Z��]�w	
		$sql="delete from class_report_setup where sn='{$_POST['option1']}'";
		$res=$CONN->Execute($sql) or die("SQL���~:$sql");

	$_POST['act']="";
	$_POST['option1']="";
}



//���稭��, �è��X�iŪ�������Z��
switch ($_SESSION['session_who']) {
	//�p�G�O�Ѯv, ���o�Ҧ��Ǵ�
	case '�Юv':
		$select_seme = get_class_seme(); //�Ǧ~��
		//���o�ثe�Ǵ����Ҧ��iŪ�������Z��
		$select_report=get_report("list",$the_seme,"",$the_page);
	break;

	//�p�G�O�ǥ�, ���o�N�ǾǴ�
	case '�ǥ�':
		echo "�����Юv�M�Υ\��!";
		exit();
	break;
} // end switch


$REP['seme_year_seme']=$the_seme;

$act=($_POST['act']=='')?'insert':'update';

?>
<form method="post" name="myform" action="<?php echo $_SERVER['php_self'];?>">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="change_class" value="">
	<input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">
	<input type="hidden" name="option2" value="<?php echo $_POST['option2'];?>">
	<select size="1" name="the_seme" onchange="document.myform.submit()">
		<?php
		foreach ($select_seme as $k=>$v) {
		?>
			<option value="<?php echo $k;?>"<?php if ($the_seme==$k) echo " selected";?>><?php echo $v;?></option>
		<?php
		}
		?>
	</select>
	<input type="button" value="��ܦ��Z����" onclick="form_report.style.display='block'">
	
		<table border="0" bgcolor="#ffffff" style="border-collapse:collapse" bordercolor="#800000">
		<tr>
			<td style="color:#800000">
				<div id="form_report" style="padding: 0px;display:<?php echo ($_POST['act']=="edit" or $_POST['change_class'])?"block":"none"; ?>">
				<fieldset style="line-height: 150%; margin-top: 0; margin-bottom: 0">
				<legend><font size=2 color=#0000dd>�п�J���Z��ӥ�</font></legend>
				<?php form_report($REP);?>
					<input type="button" value="�e�X���" onclick="check_save('<?php echo $act;?>')">
					<input type="button" value="���ê��" onclick="form_report.style.display='none'">
			</fieldset>
			</div>
			</td>
		</tr>
	</table>

	
	<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse;' bordercolor='#111111'>
		<tr bgcolor="#663300" style="color:#FFFFFF">
			<td align="center" width="30" style="font-size:9pt">�ާ@</td>
			<td align="center" width="200">���Z��W��</td>
			<td align="center" width="80">�Юv</td>
			<td align="center" width="60">�Z��</td>
			<td align="center" width="60">���Z��</td>
			<td align="center" width="80" style="font-size:9pt">���/�p�Ѯv</td>
			<td align="center" width="60" style="font-size:10pt">�}��n��</td>
			<td align="center" width="60" style="font-size:10pt">�}��d��</td>
			<td align="center" width="60" style="font-size:10pt">���Z�˦�</td>
			<td align="center" width="60" style="font-size:10pt">�έp�`��</td>
			<td align="center" width="60" style="font-size:10pt">�p�⥭��</td>
			<td align="center" width="60" style="font-size:10pt">���ѱƦW</td>
		</tr>
		<?php
		foreach ($select_report as $k=>$v) {
		?>
		<tr<?php if ($v['sn']==$_POST['option1']) echo " bgcolor='#FFFF00'";?>>
			<td align="center" style="color:#888888">
				<?php if ($v['locked']==0) { ?>
				<img src="images/edit.png" style="cursor:hand" title="�s��" onclick="document.myform.act.value='edit';document.myform.option1.value='<?php echo $v['sn'];?>';document.myform.submit();">
  			<img src="images/del.png"  style="cursor:hand" title="�R��" onclick="if (confirm('�z�T�w�n�R����?\n���Z��:<?php echo  '('.$v['seme_class_cname'].')'.$v['title'];?>')) { document.myform.act.value='DeleteOne'; document.myform.option1.value='<?php echo $v['sn'];?>'; document.myform.submit(); } ">
			<?php } else { 
					echo "<font size=\"2\"><i>��w</i></font>"; 
					if ($M_SETUP['unlock_self']) {
						?>
						 <img src="../score_manage/images/key.png" title="����" style="cursor:hand" onclick="confirm_unlockk('unlock',<?php echo $v['sn'];?>)">
						<?php
					}
			}?>
			</td>
			<td><?php echo $v['title'];?></td>
			<td align="center"><?php echo get_teacher_name($v['teacher_sn']);?></td>
			<td align="center"><?php echo $v['seme_class_cname'];?></td>
			<td align="center"><?php echo $v['test_num'];?></td>
			<td align="center"><?php echo ($v['student_sn']>0)?student_sn_to_stud_name($v['student_sn']):"";?></td>
			<td align="center"><?php echo ($v['open_input'])?"�O":"�_";?></td>
			<td align="center"><?php echo ($v['open_read'])?"�O":"�_";?></td>
			<td align="center"><?php echo ($v['rep_classmates'])?"���Z":"�ӤH";?></td>
			<td align="center"><?php echo ($v['rep_sum'])?"�O":"�_";?></td>
			<td align="center"><?php echo ($v['rep_avg'])?"�O":"�_";?></td>
			<td align="center"><?php echo ($v['rep_rank'])?"�O":"�_";?></td>
		</tr>
		<?php
		}
		?>	
	</table>
	<table>
		<tr>
			<td>���� :<?php select_pages($the_page);?></td>
		</tr>
	</table>
	
</form>
<Script language="JavaScript">
 //�˴���ƬO�_����
 function check_save(ACT) {
 	var ok=1;
 	if (document.myform.title.value=='') {
 		ok=0;
 		alert('�п�J���Z��W��');
 		document.myform.title.focus();
 		return false;
 	}
 	if (document.myform.seme_class.value=='') {
 		ok=0;
 		alert('�п�ܯZ��');
 		document.myform.rank.focus();
 		return false;
 	}
 	
 	if (ok==1) {
 		document.myform.act.value=ACT;
 		document.myform.submit();
 	}
 	
 }

//�T�{����
 function confirm_unlockk(ACT,SN) {
  C=confirm("�����Z��ҵ��⪺�������Ƥw�Q�ץX�ܾǴ����q���Z, \n ���F�O�s��l���㦨�Z�ӷ�, �]�Өt�μȮ���w, \n �z�T�w�n����? \n(�p�G�z���e�w�צܦ��Z�޲z��[���`���Z]�����@�����`���Z,\n ����Y�O���F�n����, \n�h�аO�o�ƥ��N�w�פJ���Ӧ����`���Z�R��!)");
  if (C) {
  	document.myform.act.value=ACT;
  	document.myform.option1.value=SN;
 		document.myform.submit(); 	
  } else {
   return false;
  }
  
 }

</Script>


