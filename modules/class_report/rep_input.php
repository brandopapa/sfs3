<?php
include_once('config.php');

sfs_check();

//�s�@��� ( $school_menu_p�}�C�]�w�� module-cfg.php )
$tool_bar=&make_menu($school_menu_p);

//Ū���ثe�ާ@���Ѯv���S���޲z�v
$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);

//�ثe�Ǵ�
$c_curr_seme=sprintf("%03d%d",curr_year(),curr_seme());


//POST�᪺�ʧ@
//�x�s�@�����Z
if ($_POST['act']=='insert') {
	//���Z��]�w��$_POST['the_report'];	
	$report_sn=$_POST['the_report'];  					//���Z��sn

	//�s�J�Ҹզ��Z�]�w
	$subject=$_POST['subject'];
	$test_date=$_POST['test_date'];
	$memo=$_POST['memo'];
	$real_sum=1;
	$update_sn=$_SESSION['session_tea_sn'];
	$rate=$_POST['rate'];
	$sql="insert into `class_report_test` set report_sn='$report_sn',subject='$subject',test_date='$test_date',real_sum='$real_sum',memo='$memo',update_sn='$update_sn',rate='$rate'";
	$res=$CONN->Execute($sql) or die("SQL���~:$sql");
	
	//���^�۰ʷs�W�� sn  ��, �H�n���ӧO�ǥͤ��ƪ�����
	$res=$CONN->Execute("SELECT LAST_INSERT_ID()");
	$test_sn=$res->fields[0];	
	
	//�s�J�Ҧ��n�������Z $_POST['score'];
	foreach ($_POST['score'] as $student_sn=>$score) {
		if ($score!="") {
		 $sql="insert into `class_report_score` set test_sn='$test_sn',student_sn='$student_sn',score='$score',update_sn='$update_sn'";
		 $res=$CONN->Execute($sql) or die("SQL���~:$sql");
	  }
	}
	
	//�s�J���Z���ʰO��
	$last_edit_sn=($_SESSION['session_who']=='�Юv')?"t".$_SESSION['session_tea_sn']:"s".$_SESSION['session_tea_sn']; 	// �̫��ʦ��Z��sn 
	$last_edit_time=date("Y-m-d H:i:s"); 				// �̫��ʦ��Z���ɶ�
	$sql="update `class_report_setup` set last_edit_sn='$last_edit_sn',last_edit_time='$last_edit_time' where sn='$report_sn'";
	$res=$CONN->Execute($sql) or die("SQL���~:$sql");

	$_POST['act']='';

} // end if insert

//��s�@�����Z
if ($_POST['act']=='update') {
	//���Z��]�w��$_POST['the_report'];	
	$report_sn=$_POST['the_report'];  					//���Z��sn

	//�s�J�Ҹզ��Z�]�w
	$subject=$_POST['subject'];
	$test_date=$_POST['test_date'];
	$memo=$_POST['memo'];
	$real_sum=1;
	$rate=$_POST['rate'];
	$update_sn=$_SESSION['session_tea_sn'];
	//�Юv�~���� rate (�[�v)
	$sql=($_SESSION['session_who']=='�Юv')?"update `class_report_test` set report_sn='$report_sn',subject='$subject',test_date='$test_date',real_sum='$real_sum',memo='$memo',update_sn='$update_sn',rate='$rate' where sn='{$_POST['option1']}'":"update `class_report_test` set report_sn='$report_sn',subject='$subject',test_date='$test_date',real_sum='$real_sum',memo='$memo',update_sn='$update_sn' where sn='{$_POST['option1']}'";
	$res=$CONN->Execute($sql) or die("SQL���~:$sql");
	
	//�s�J�Ҧ��n�������Z $_POST['score'];
	foreach ($_POST['score'] as $student_sn=>$score) {
		$sql="select sn from `class_report_score` where test_sn='{$_POST['option1']}' and student_sn='$student_sn'";
		$res=$CONN->Execute($sql) or die("SQL���~:$sql");
		if ($res) {
		  $sn=$res->fields[0];
			if ($sn>0) {
		  	$sql="update `class_report_score` set score='$score',update_sn='$update_sn' where sn='$sn'";
				$res=$CONN->Execute($sql) or die("SQL���~:$sql");
			} else {
		  //�s�����
				if ($score!="") {
		 			$sql="insert into `class_report_score` set test_sn='{$_POST['option1']}',student_sn='$student_sn',score='$score',update_sn='$update_sn'";
					$res=$CONN->Execute($sql) or die("SQL���~:$sql");
				}
		 	} // end if $>0
		} // end if $res
	}  // end foreach
	
	//�s�J���Z���ʰO��
	$last_edit_sn=($_SESSION['session_who']=='�Юv')?"t".$_SESSION['session_tea_sn']:"s".$_SESSION['session_tea_sn']; 	// �̫��ʦ��Z��sn 
	$last_edit_time=date("Y-m-d H:i:s"); 				// �̫��ʦ��Z���ɶ�
	$sql="update `class_report_setup` set last_edit_sn='$last_edit_sn',last_edit_time='$last_edit_time' where sn='$report_sn'";
	$res=$CONN->Execute($sql) or die("SQL���~:$sql");

	$_POST['act']='';

} // end if update

//�R���@�����Z
if ($_POST['act']=='DeleteOne') {
  //���Z��]�w��$_POST['the_report'];	
	$report_sn=$_POST['the_report'];  					//���Z��sn
	
	//�R���Ҧ�����
		$sql="delete from `class_report_score` where test_sn='{$_POST['option1']}'";
		$res=$CONN->Execute($sql) or die("SQL���~:$sql");

	//�R���Ҹճ]�w
		$sql="delete from `class_report_test` where sn='{$_POST['option1']}' and report_sn='$report_sn'";
		$res=$CONN->Execute($sql) or die("SQL���~:$sql");
		
		$_POST['act']='';
}


switch ($_SESSION['session_who']) {
	//�p�G�O�Ѯv, ���o�Ҧ��Ǵ�
	case '�Юv':
		$select_seme = get_class_seme(); //�Ǧ~��
		//���o�ثe�Ǵ����Ҧ��iŪ�������Z��
		$select_report=get_report("input",$c_curr_seme);
	break;

	//�p�G�O�ǥ�, ���o�N�ǾǴ�
	case '�ǥ�':
		$sql="select seme_class from stud_seme where seme_year_seme='$c_curr_seme' and student_sn='{$_SESSION['session_tea_sn']}'";
		$res=$CONN->execute($sql) or die("SQL���~:$sql");
		$class_num=$res->fields[0];
		//�ӯZ�Ťw�b�Ǫ��`�Ǵ���
		$select_seme=get_class_seme_select($class_num);
		//���o�ثe�Ǵ����Ҧ��iŪ�������Z��
		$select_report=get_report("input",$c_curr_seme,$class_num);
	break;
} // end switch


//���Z��ץX
if ($_POST['act']=='output') {
	  $REP_SETUP=get_report_setup($_POST['the_report']);
    $filename =  $REP_SETUP['title'].".xls"; 	
    header("Content-disposition: filename=$filename");
    header("Content-type: application/octetstream");	  
    //header("Pragma: no-cache");
	  				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	  header("Expires: 0"); 

 list_class_score($REP_SETUP,0,1,1,1);
 exit();
}


//�q�X SFS3 ���D
head();

//�C�X���
echo $tool_bar;

$SS=0;  //�O�U�@�X�����, �Ω������J

moveit2("myform");

?>
<script type="text/javascript" src="../../javascripts/JSCal2-1.9/src/js/jscal2.js"></script>
<script type="text/javascript" src="../../javascripts/JSCal2-1.9/src/js/lang/b5.js"></script>
<link type="text/css" rel="stylesheet" href="../../javascripts/JSCal2-1.9/src/css/jscal2.css">
<style type="text/css">
 .bg_0 { background-color:#FFFFFF;font-size:9pt  }
 .bg_Over { background-color:#CCFFCC;font-size:10pt;color:#FF0000  }
</style>

<form method="post" name="myform" action="<?php echo $_SERVER['php_self'];?>">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">
	�n��J�����Z��
	<select size="1" name="the_report" onchange="document.myform.option1.value='';document.myform.submit()">
		<option value="">--�п�ܦ��Z��--</option>
		<?php
		foreach ($select_report as $k=>$v) {
		?>
			<option value="<?php echo $v['sn'];?>"<?php if ($_POST['the_report']==$v['sn']) echo " selected";?>><?php echo "[".$v['seme_class_cname']."]".$v['title'];?></option>
		<?php
		}
		?>
	</select>	
	<?php
	//�Y����w���Z��, �C�X�W��
	if ($_POST['the_report']!="") {
	  $REP_SETUP=get_report_setup($_POST['the_report']);
   //�C�X���Z
   if ($_POST['act']=='') {
   	?>
   	<input type="button" value="�s�W�@�����Z" onclick="document.myform.act.value='InsertOne';document.myform.submit()"<?php if ($REP_SETUP['locked']) echo " disabled";?>>
   	<?php
   	if ($REP_SETUP['locked']) echo "<br><font color=red size=2><i>�����Z�w�צܱаȳB, �L�k�A�i��s��!!</i></font>";
   	if ($_SESSION['session_who']=='�Юv') {
   		?>
   		<input type="button" value="�ץX���Z" onclick="document.myform.act.value='output';document.myform.submit()">
   		<?php
   		list_class_score($REP_SETUP,1,1,1,1);
  	} else {
   		list_class_score($REP_SETUP,1,$REP_SETUP['rep_sum'],$REP_SETUP['rep_avg'],$REP_SETUP['rep_rank']);
  	}
   	?>
   	<input type="button" value="�s�W�@�����Z" onclick="document.myform.act.value='InsertOne';document.myform.submit()"<?php if ($REP_SETUP['locked']) echo " disabled";?>>
   	<BR>
   	<font color=red size=2>���`�N! ��@���Z���[�v�ȷU���A�Ӧ��Z�Ҧ��`������ҷU���C</font>
   	<?php
   }
   //�s�W���Z
   if ($_POST['act']=='InsertOne') {
   	//�ǤJ���Z��]�w,��س]�w,�ǥͦ��Z
   	$TEST_SETUP['test_date']=date("Y-m-d");
   	$TEST_SETUP['rate']=1;
   	form_class_score($REP_SETUP,$TEST_SETUP,$SCORE); 
   	?>
   		  <input type="button" value="�x�s���" onclick="check_save('insert')">
   <?php
   }
   //�ק�Y�����Z
   if ($_POST['act']=='edit') {
    $TEST_SETUP=get_report_test($_POST['option1']);
   	$SCORE=get_report_score($_POST['option1']);
  	//�C�X���
    $SS=form_class_score($REP_SETUP,$TEST_SETUP,$SCORE);  
   	?>
   		  <input type="button" value="�x�s���" onclick="check_save('update')">
   <?php
 
   }
	

	} // end if ($_POST['the_report'])
	?>

</form>
<Script Language="JavaScript">
	
	var SS=<?php echo $SS;?>;
	var ss=0;
	
 function check_save(ACT) {
   	var ok=1;
 	if (document.myform.test_date.value=='') {
 		ok=0;
 		alert('�п�J�Ҹդ��');
 		document.myform.test_date.focus();
 		return false;
 	}
 	if (document.myform.subject.value=='') {
 		ok=0;
 		alert('�п�J�Ҹլ��');
 		document.myform.subject.focus();
 		return false;
 	}
 	
 	if (ok==1) {
 		document.myform.act.value=ACT;
 		document.myform.submit();
 	}
 
 }
 
 //��ؿ��, �ƹ����b�W����
 function OverLine(w) {
   document.getElementById(w).className = 'bg_over';  
 }
 
 //��ؿ��, �ƹ����}��
 function OutLine(w) {
   document.getElementById(w).className = 'bg_0';
 } 
 
 
 //��J���Z, ���o�J�I��
 function set_ower(thetext,ower) {
	ss=ower;
	thetext.style.background = '#FFFF00';
	thetext.select();
	return true;
}

//��J���Z, ���}�J�I��
function unset_ower(thetext) {
	if(thetext.value>100 && ss>2){ thetext.style.background = '#FF0000'; alert("��J���Z����100��");}
	else if(thetext.value<0 && ss>2){ thetext.style.background = '#AA5555'; alert("��J���Z���t��"); }
	else if(thetext.value<60 && ss>2){ thetext.style.background = '#FFCCCC'; }
	else { thetext.style.background = '#FFFFFF'; }
	return true;
}
 
// handle keyboard events
if (navigator.appName == "Mozilla")
	document.addEventListener("keyup",keypress,true);
else if (navigator.appName == "Netscape")
	document.captureEvents(Event.KEYPRESS);
if (navigator.appName != "Mozilla")
	document.onkeypress=keypress;

function keypress(e) {
	if (navigator.appName == "Microsoft Internet Explorer")
		tmp = window.event.keyCode;
	else if (navigator.appName == "Navigator")
		tmp = e.which;
	else if (navigator.appName == "Navigator" || navigator.appName == "Netscape")
		tmp = e.keyCode;
		
	if (tmp == 13){
		var GG='SS_'+ss;
	  var TT = document.getElementById(GG).value;
	  var tt = parseFloat(document.getElementById(GG).value);
		if (isNaN(tt) && ss>2 && TT!=''){
			alert('���~������!');
			document.getElementById(GG).value ='';
			return false;
		} else {
			if (ss<SS) ss++;	
			GG='SS_'+ss;
			document.getElementById(GG).focus();
		} 
	} // end if tmp==13
		return true;
}
</script>



