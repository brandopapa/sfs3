<?php
// $Id: quick_input_m.php 5310 2009-01-10 07:57:56Z hami $
/*�ޤJ�ǰȨt�γ]�w��*/
include "../../include/config.php";
include "../../include/sfs_case_score.php";

//�ޤJ���
include "./my_fun.php";

//������
$col_num = 3;
$signBtn = "�n�����Z";


//�ϥΪ̻{��
sfs_check();

$edit=$_GET['edit'];
$class_id=($_GET['class_id']!="")?$_GET['class_id']:$_POST['class_id'];
$ss_id=($_GET['ss_id']!="")?$_GET['ss_id']:$_POST['ss_id'];
$curr_sort=($_GET['curr_sort']!="")?$_GET['curr_sort']:$_POST['curr_sort'];
$score_semester=$_POST['score_semester'];
$test_kind=$_POST['test_kind'];


//�s�J��Ʈw 
if($_POST[score_semester] <>'') {
//	$query = "select score_id from $score_semester where ss_id='$ss_id' and test_sort='$curr_sort' and  test_kind='$test_kind'";
//	$res= $CONN->Execute($query) or die($query);	
	$sn_temp_arr = explode(",",$_POST[sn_hidden]);
	if ($_POST[input_state]<>'new') {
		while(list($id,$sn)=each($sn_temp_arr)) {
			if($sn){			    
				if($_POST["t_$sn"]=="") $_POST["t_$sn"]="-100";
				//�g�J�Ǵ����Z��ƪ�
				$query = "update  $score_semester set score='".$_POST["t_$sn"]."' where score_id=$sn";				
				$CONN->Execute($query) or die($query);				
			}
		}
	}
	else {
		while(list($id,$sn)=each($sn_temp_arr)) {
			if ($sn) {
				if($_POST["t_$sn"]=="") $_POST["t_$sn"]="-100";
				//�g�J�Ǵ����Z��ƪ�
				$sql3="INSERT INTO $score_semester (class_id,student_sn,ss_id,score,test_name,test_kind,test_sort,update_time,sendmit) values('$_POST[class_id]','$sn','$_POST[ss_id]','".$_POST["t_$sn"]."','$_POST[test_kind]','$_POST[test_kind]','$curr_sort',now(),'0')";
				$CONN->Execute($sql3) or die($sql3);
			}
		}
	}
		
	$sd_year=substr($class_id,0,3);
	$sd_seme=substr($class_id,4,1);
	$seme_year_seme=sprintf("%03d%d",$sd_year,$sd_seme);
	$st_sn_A=class_id_2_student_sn($class_id);			
	for($i=0;$i<count($st_sn_A);$i++){
		
								
		//���s�p��Ǵ��`���Z
		$end_score[$i]=seme_score($st_sn_A[$i],$ss_id,$sd_year,$sd_seme);
		//echo $end_score[$i]."<br>";
		//�g�J
		$sss_id_qry="select sss_id from stud_seme_score where seme_year_seme='$seme_year_seme' and ss_id='$ss_id' and student_sn='$st_sn_A[$i]'";
        $sss_id_rs=$CONN->Execute($sss_id_qry) or trigger_error("�Ǵ��`���Z��ƪ��إ�",E_USER_ERROR);
        $sss_id[$i]=$sss_id_rs->fields['sss_id'];
        if($sss_id[$i]){//��s���Z
        	$CONN->Execute("UPDATE stud_seme_score SET ss_score='$end_score[$i]' WHERE  sss_id='$sss_id[$i]'");
			//echo "UPDATE stud_seme_score SET ss_score='$end_score[$i]' WHERE  sss_id='$sss_id[$i]' <br>";
        }
        else{//�s�W���Z
        	$CONN->Execute("INSERT INTO stud_seme_score (seme_year_seme,student_sn,ss_id,ss_score) values('$seme_year_seme','$st_sn_A[$i]','$ss_id','$end_score[$i]')");           
		}
	}
	//exit;
	if($curr_sort=="255"){
	echo "<html><body>
	<script LANGUAGE=\"JavaScript\">	
	javascript:opener.document.form5.submit();
    window.close();
	</script>
	</body>
	</html>";		
	}
	else{ 
	echo "<html><body>
	<script LANGUAGE=\"JavaScript\">	
	javascript:opener.document.form6.submit();
    window.close();	
	</script>
	</body>
	</html>";
	}
	exit;
}
?>
<html>
<meta http-equiv="Content-Type" content="text/html; Charset=Big5">
<head>
<title>���Z��J</title>

</head>
<body onLoad="set_default()" >
<form name="myform" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<?php

/*****************************************************************************************************/

$score_semester=sprintf("score_semester_%d_%d",substr($class_id,0,3),substr($class_id,4,1));

$subject_name=ss_id_to_subject_name($ss_id); 
$full_class_name=class_id_to_full_class_name($class_id);
//echo $full_class_name;
if ($edit=='s1'){
	$test_kind ="�w�����q";
    $test_kind_name ="�w�����q";
}
elseif (($edit=='s2')&&($curr_sort!=255)){
	$test_kind ="���ɦ��Z";
    $test_kind_name ="���ɦ��Z";
}
else{
	$test_kind ="���Ǵ�";
    $test_kind_name ="���Ǵ�";
}
$temp_str = sprintf("%s %s %s",$full_class_name,$subject_name,$test_kind_name);
echo "<b>$temp_str</b>";
	
	$query = "select a.score_id,a.score,b.stud_name,b.curr_class_num from $score_semester a, stud_base b where a.student_sn=b.student_sn and a.ss_id='$ss_id' and a.class_id='$class_id' and  a.test_sort='$curr_sort' and a.test_kind='$test_kind' order by b.curr_class_num";	
	$rs=&$CONN->Execute($query) or die($query);
	$input_state="";
	
	$sd_year=substr($class_id,0,3);
	$sd_seme=substr($class_id,4,1);
	$seme_year_seme=sprintf("%03d%d",$sd_year,$sd_seme);
	
	//�|���ظ�Ʈɶȧ�ǥͰ򥻸��
	if ($rs->EOF) {
		$temp_arr = explode ("_",$class_id);
		$class_id_temp = intval($temp_arr[2]).$temp_arr[3];
		//$query = "select student_sn,stud_name,curr_class_num from stud_base where curr_class_num like '$class_id_temp%' and stud_study_cond=0 order by curr_class_num";
		$query = "select a.student_sn,a.stud_name,a.curr_class_num from stud_base a,stud_seme b where a.stud_study_cond=0 and a.curr_class_num like '$class_id_temp%' and a.student_sn = b.student_sn and b.seme_year_seme = '$seme_year_seme' and b.seme_class='$class_id_temp' order by a.curr_class_num ";
		$rs = $CONN->Execute($query) or die($query);
		$input_state="new";

	}
	echo "<table border=1>\n";
	$ii =0;
	$sn_hidden =""; 		
	while (!$rs->EOF){
		if ($input_state=="")
			$sn = $rs->fields[score_id];
		else 
			$sn = $rs->fields[student_sn];
		
		$sit_num = substr($rs->fields[curr_class_num],-2);
		$stud_name = $rs->fields[stud_name];
		$test_score = $rs->fields[score];
		if($test_score == -100 or $test_score =='0')	
			$test_score='';
		if($ii % $col_num == 0)
			echo "<tr>";
		echo "<td bgcolor=#e3f9ef>$sit_num</td>";
		echo "<td bgcolor=#ffcbfb>$stud_name</td>";
		echo "<td><input type=\"text\" name=\"t_$sn\" size=6 maxlength=5 value=\"$test_score\" onFocus=\"set_ower(this,$ii)\" onBlur=\"unset_ower(this)\"  ></td>";
		
		if($ii++ % $col_num == ($col_num-1))
			echo "</tr>\n";
		$sn_hidden .= "$sn,";
		$rs->MoveNext();
	}
	echo "</table>";
?>
<input type="button" name="do_key" value="<?php echo $signBtn ?>" onClick="document.myform.submit()">
&nbsp;&nbsp;<input type="button" name="go_away" value="���" onClick="check_change()">
&nbsp;&nbsp;<input type="button" name="reset_allBtn" value="�M��" onClick="reset_all()">
<input type="hidden" name="score_semester" value="<?php echo $score_semester ?>">
<input type="hidden" name="ss_id" value="<?php echo $ss_id ?>">
<input type="hidden" name="curr_sort" value="<?php echo $curr_sort ?>">
<input type="hidden" name="test_kind" value="<?php echo $test_kind ?>">
<input type="hidden" name="class_id" value="<?php echo $class_id ?>">
<input type="hidden" name="sn_hidden" value="<?php echo $sn_hidden ?>">
<input type="hidden" name="input_state" value="<?php echo $input_state ?>">

</form>

<script >
var ss=0;
var is_change = false;
function set_default(){
document.myform.elements[ss].focus();
}

function check_change(){
if(is_change){
	if (confirm('�z�w�g����ƬO�_�n���} ?'))
		window.close();
}
else
	window.close();
}


function set_ower(thetext,ower) {
ss=ower;
thetext.style.background = '#FFFF00';
//thetext.select();
return true;
}

function unset_ower(thetext) {
thetext.style.background = '#FFFFFF';
return true;
}

function reset_all() {
	for (var i=0;i<document.myform.elements.length;i++)
	 {
	    var e = document.myform.elements[i];
	    if (e.type == 'text')
        	       e.value = '';
	}
  document.myform.elements[0].focus();
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
   else if (navigator.appName == "Navigator"||navigator.appName == "Netscape")
       tmp = e.keyCode;
  if( document.myform.elements[ss].type != 'text')
		return true;
        else if (tmp == 13){ 
		var tt = parseFloat(document.myform.elements[ss].value);
		
		if (isNaN(tt) || tt >100 || tt < 0 ){			
			alert('���~������!');
			document.myform.elements[ss].value ='';
			return false;
		}
		else {			
			ss++;
			document.myform.elements[ss].focus();
			is_change = true;
			return true;
		}
	}
        else    return true;
}
</script>




</body>
</html>
