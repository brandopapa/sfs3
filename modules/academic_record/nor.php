<?php

// $Id: nor.php 5310 2009-01-10 07:57:56Z hami $

// ���o�]�w��
include "config.php";

sfs_check();

//���o�Ǵ�
$edit_one=$_GET['edit_one'];
$pact=$_POST['pact'];
$edit_score=$_POST['edit_score'];
$edit_comment=$_POST['edit_comment'];
$save_comment=$_POST['save_comment'];
$default=$_POST['default'];
$print=$_POST['print'];
if (!$default) $stud_score=$_POST['stud_score'];

//�{�����Y
if (!$print) head("��`���Z�޲z");
$tool_bar=&make_menu($school_menu_p);

$main="$tool_bar<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc><tr><td bgcolor='#FFFFFF'>";

$sel_year = curr_year(); //�ثe�Ǧ~
$sel_seme = curr_seme(); //�ثe�Ǵ�
$teacher_sn=$_SESSION['session_tea_sn'];//���o�n�J�Ѯv��id

//��X���ЯZ��
$class_name=teacher_sn_to_class_name($teacher_sn);
$seme_year_seme=sprintf("%03d",curr_year()).curr_seme();

//�έp�Z�Ų{���H��
$sql="select count(student_sn) from stud_seme where seme_year_seme='$seme_year_seme' and seme_class='$class_num'";
$res=$CONN->Execute($sql);
$student_number=$res->fields[0];

//���o�ǥͦW��
$sql="select student_sn from stud_base where curr_class_num like '$class_name[0]%' and stud_study_cond='0' order by curr_class_num";
$rs=$CONN->Execute($sql) or die($sql);
while (!$rs->EOF) {
	$stud_sn[]=$rs->fields["student_sn"];
	$rs->MoveNext();
}

//���o�Ӧ��Z��M���Z�L������������
$i=0;
$comm_num=0;
if($edit_comment)
	$quick_input="<img src='images/comment1.png'  border='0' onClick=\"return OpenWindow2('quick_input_memo.php')\">";

$text_table="
	<td>��`�Ҭd���Z</td>
	<td colspan='4' align='center'>���鬡�ʦ��Z</td>
	<td rowspan='2' width='30'><a href='$_SERVER[PHP_SELF]?edit_one=E5'>���@�A��</a><br><font color='#ff0000'>(��5)</font></td>
	<td rowspan='2' width='30'><a href='$_SERVER[PHP_SELF]?edit_one=E6'>�ե~�S���{</a><br><font color='#ff0000'>(+5)</font></td>
	<td rowspan='2' width='300' nowrap>�ǲߴy�z��r����$quick_input</td>";
$text_table2="
	<tr>
	<td align='center' width='30'><a href='$_SERVER[PHP_SELF]?edit_one=E0'>�ɮv����</a><br><font color='#ff0000'>(��5)</font></td>
	<td align='center' width='30'><a href='$_SERVER[PHP_SELF]?edit_one=E1'>�Z�Ŭ���</a><br><font color='#ff0000'>(��5)</font></td>
	<td align='center' width='30'><a href='$_SERVER[PHP_SELF]?edit_one=E2'>���ά���</a><br><font color='#ff0000'>(��5)</font></td>
	<td align='center' width='30'><a href='$_SERVER[PHP_SELF]?edit_one=E3'>�۪v����</a><br><font color='#ff0000'>(��5)</font></td>
	<td align='center' width='30'><a href='$_SERVER[PHP_SELF]?edit_one=E4'>�Ҧ次��</a><br><font color='#ff0000'>(��5)</font></td></tr>";
 	
//�]�w�[��Z���
$score_sn=array("0"=>"1","1"=>"1","2"=>"1","3"=>"1","4"=>"1","5"=>"1","6"=>"0");
$nor_val=array("1"=>"��{�u��","2"=>"��{�}�n","3"=>"��{�|�i","4"=>"�ݦA�[�o","5"=>"���ݧ�i");   
$nor_kind=array("10"=>"1","9"=>"1","8"=>"2","7"=>"2","6"=>"3","5"=>"3","4"=>"3","3"=>"4","2"=>"4","1"=>"5","0"=>"5"); 

$text_str=($chk_menu_arr)?"":"<input type='submit' name='edit_comment' value='�s���r�y�z'>";
$main.="<script language=\"JavaScript\">
	var remote=null;
	function OpenWindow(p,x){
	strFeatures =\"top=300,left=20,width=500,height=210,toolbar=0,resizable=no,scrollbars=yes,status=0\";
	remote = window.open(\"comment.php?cq=\"+p,\"MyNew\", strFeatures);
	if (remote != null) {
	if (remote.opener == null)
	remote.opener = self;
	}
	if (x == 1) { return remote; }
	}
	function OpenWindow2(url_str){
		window.open (url_str,\"���Z�B�z\",\"toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=600,height=420\");
	}
	</script>
	<table bgcolor=#ffffff border=0 cellpadding=2 cellspacing=1>
	<form action='{$_SERVER['PHP_SELF']}' method='post' name='col1'>
	<tr bgcolor='#ffffff'><td>
	<input type='submit' name='edit_score' value='�s���`���Z'> 
	$text_str
	<input type='submit' name='print' value='�C�L����'>";
	if ($edit_comment || $edit_score)
		$main.="
			<input type='submit' name='default' value='�^�_���'>
			<input type='submit' name='save_comment' value='�x�s'>";
$main.="	
	<br>
	<table bgcolor='#9ebcdd' cellspacing='1' cellpadding='4' class='small'>
	<tr bgcolor='#c4d9ff'>
	<td align='center' rowspan='2'>�y��</td>
	<td align='center' rowspan='2'>�m�W</td>
	$text_table
	</tr>
	$text_table2
	";

//��ܦ��Z
while (list($m,$v)=each($stud_sn)) {
	$rs=$CONN->Execute("select stud_name,stud_id from stud_base where student_sn='$stud_sn[$m]'");

	//���o�y���Ωm�W
	$stud_name=$rs->fields['stud_name'];
	$stud_id[$m]=$rs->fields['stud_id'];
	$site_num=student_sn_to_site_num($stud_sn[$m]);
	$data[$site_num-1][stud_name]=$stud_name;
	$data[$site_num-1][stud_id]=$stud_id[$m];

	$table_score="";
	$table_temp="";

	//���o���x�s�ɮv�[���
	if (($pact=="s")&&($save_comment)) {
		for ($i=0;$i<7;$i++) {
//			settype($stud_score[$stud_id[$m]][$i],integer);
			$j=$stud_score[$stud_id[$m]][$i];
			if (($j < -5) or ($j > 5)) $j="";
			$tp[$i]=$j;
			$stud_score[$stud_id[$m]][$i]=$j;
		}
		$rs_nor=$CONN->Execute("select * from seme_score_nor where seme_year_seme='$seme_year_seme' and stud_id='$stud_id[$m]'");
		if ($rs_nor->recordcount()==1) {
			$rs_nor=$CONN->Execute("update seme_score_nor set score1='$tp[0]',score2='$tp[1]',score3='$tp[2]',score4='$tp[3]',score5='$tp[4]',score6='$tp[5]',score7='$tp[6]' where seme_year_seme='$seme_year_seme' and stud_id='$stud_id[$m]'");
		} else {
			$rs_nor=&$CONN->Execute("insert into seme_score_nor (seme_year_seme,stud_id,score1,score2,score3,score4,score5,score6,score7) values ('$seme_year_seme','$stud_id[$m]','$tp[0]','$tp[1]','$tp[2]','$tp[3]','$tp[4]','$tp[5]','$tp[6]')");
		}
		check_nor($seme_year_seme,$stud_id[$m],1,$nor_val[$nor_kind[$tp[0]+5]]);
		$i=round(($tp[1]+$tp[2]+$tp[3]+$tp[4])/4);
		check_nor($seme_year_seme,$stud_id[$m],2,$nor_val[$nor_kind[$i+5]]);
		check_nor($seme_year_seme,$stud_id[$m],3,$nor_val[$nor_kind[$tp[5]+5]]);
		check_nor($seme_year_seme,$stud_id[$m],4,$nor_val[$nor_kind[$tp[6]+5]]);
	} else {
		$rs_nor=$CONN->Execute("select * from seme_score_nor where seme_year_seme='$seme_year_seme' and stud_id='$stud_id[$m]'");
		$stud_score[$stud_id[$m]][0]=$rs_nor->fields['score1'];
		$stud_score[$stud_id[$m]][1]=$rs_nor->fields['score2'];
		$stud_score[$stud_id[$m]][2]=$rs_nor->fields['score3'];
		$stud_score[$stud_id[$m]][3]=$rs_nor->fields['score4'];
		$stud_score[$stud_id[$m]][4]=$rs_nor->fields['score5'];
		$stud_score[$stud_id[$m]][5]=$rs_nor->fields['score6'];
		$stud_score[$stud_id[$m]][6]=$rs_nor->fields['score7'];
	}

	$j=0;
	while ($j<count($score_sn)) {
		
		$score_value=$stud_score[$stud_id[$m]][$j];
		if(!$edit_score and  !$edit_one){
			$table_score.="<td align='center'>$score_value</td>";
		}elseif(!$edit_score and $edit_one){
			if(substr($edit_one,1,2)==$j)
				$table_score.="<td align='center'><input type='text' name='stud_score[".$stud_id[$m]."][".$j."]' value='$score_value' style='width: 100%' size='5' ></td>";
			else
				$table_score.="<td align='center'><input type='hidden' name='stud_score[".$stud_id[$m]."][".$j."]' value='$score_value'>$score_value</td>";
		}else{
			$table_score.="<td align='center'><input type='text' name='stud_score[".$stud_id[$m]."][".$j."]' value='$score_value' style='width: 100%' size='5' ></td>";
		}
		$j++;
	}
	$rs=&$CONN->Execute("select student_sn,ss_score_memo from stud_seme_score_nor where student_sn='$stud_sn[$m]' and ss_id='0' and seme_year_seme='$seme_year_seme'");
	$have_value=($rs->fields['student_sn'])?"1":"0";
	if ($stud_score[$stud_id[$m]][$j]=="") $stud_score[$stud_id[$m]][$j]=addslashes($rs->fields['ss_score_memo']);
	if (!$edit_comment) {
		$table_temp.=$stud_score[$stud_id[$m]][$j];
	} else {
		$col_name="stud_score[".$stud_id[$m]."][".$j."]";
		$id_name="V".$stud_id[$m]."_".$j;
		$button="<img src='".$SFS_PATH_HTML."images/comment.png' width='16' height='16' border='0' align='left' onClick=\"return OpenWindow('$id_name')\">";
		$table_temp.=$button."<input type='text' name='$col_name' id='$id_name' value='".$stud_score[$stud_id[$m]][$j]."' style='width: 100%'>";
	}
	$main.="
		<tr bgcolor=#ffffff>
		<td align='right'>$site_num &nbsp;</td>
             		<td>&nbsp; $stud_name &nbsp;</td>
             		$table_score
             		<td>".stripslashes($table_temp)."</td>
             		</tr>
             		";
	$ss_score_memo=$stud_score[$stud_id[$m]][$j];
	if (($pact=="c")&&($save_comment)) {
		$today=date("Y-m-d");
		if ($have_value=="0") {	
			$sql_data = "insert into stud_seme_score_nor (seme_year_seme,student_sn,ss_id,ss_score_memo) values ('$seme_year_seme','$stud_sn[$m]','0','$ss_score_memo')";
		} else {
			$sql_data= "update stud_seme_score_nor set ss_score_memo='$ss_score_memo' where student_sn='$stud_sn[$m]' and ss_id='0' and seme_year_seme='$seme_year_seme'";
		}
		$CONN->Execute($sql_data) or die($sql_data);
	}
	if ($save_comment) {
		$teacher_sn=$_SESSION['session_tea_sn'];
		$sql_update="select ccm_id from class_comment_admin where teacher_sn='$teacher_sn' and class_id='$class_id' and sel_year='$sel_year' and sel_seme='$sel_seme'";
		$rs=$CONN->Execute($sql_update) or die($sql_update);
		$update_data=$rs->FetchRow();
		if (empty($update_data)) {
			$sql_update="insert into class_comment_admin (teacher_sn,class_id,sel_year,sel_seme,update_time,update_teacher_sn,sendmit) values ('$teacher_sn','$class_id','$sel_year','$sel_seme','$today','$teacher_sn','1')";
		} else {
			$ccm_id=$rs->$update_data[ccm_id];
			$sendmit=($send_comment)?'0':'1';
			$sql_update="update class_comment_admin set update_time='$today',update_teacher_sn='$teacher_sn',sendmit='$sendmit' where ccm_id='$ccm_id'";
		}
		$CONN->Execute($sql_update) or die($sql_update);
	}
//	echo $m."---".$stud_id[$m]."--".$stud_score[$stud_id[$m]][stud_name]."<br>";
}
if ($edit_score or $edit_one) $act="<input type='hidden' name='pact' value='s'>";
elseif ($edit_comment) $act="<input type='hidden' name='pact' value='c'>";
else $act="";
$main.="</table>
	<input type='hidden' name='year_name' value='$year_name'>
	<input type='hidden' name='year_seme' value='$year_seme'>
	<input type='hidden' name='me' value='$me'>
	$act";
	if ($edit_comment || $edit_score || $edit_one) 
		$main.="
		<input type='submit' name='default' value='�^�_���'>
		<input type='submit' name='save_comment' value='�x�s'>";
$main.="</form>";

$main.="</tr></table></tr></table>";
if ($print) {
	//�w�qsmarty�ϥΪ�tag
	$smarty->left_delimiter="<{";
	$smarty->right_delimiter="}>";
	for ($i=0;$i<40;$i++) {
		$data[$i][site_num]=$i+1;
		for ($j=0;$j<=8;$j++) {
			$data[$i][$j]=$stud_score[$data[$i][stud_id]][$j];
		}
	}
	$s=get_school_base();
	$smarty->assign("school_name",$s[sch_cname]);
	$smarty->assign("sel_year",$sel_year);
	$smarty->assign("sel_seme",$sel_seme);
	$smarty->assign("class_name",$class_name[1]);
	$smarty->assign("stud_score",$data);
	$smarty->display("nor.tpl");
} else {
	echo $main;
	foot();
}

function score($type=""){
	if ($type=="1") 
		$end_num=-5;
	else
		$end_num=0;
	$default_selected=0;
	for ($i=5;$i>=$end_num;$i--) {
		$selected=($i==$default_selected)?"selected":"";
		$j=($i>0)?"+".$i:$i;
		$option_temp.="<option value='$i' $selected>$j</option>";
	}
	return $option_temp;
}

function check_nor($seme_year_seme,$stud_id,$ss_id,$ss_val) {
	global $CONN;
	
	$sql_chk="select * from stud_seme_score_oth where seme_year_seme='$seme_year_seme' and stud_id='$stud_id' and ss_id='$ss_id'";
	$rs_chk=$CONN->Execute($sql_chk);
	$chk_ss_id=$rs_chk->fields['ss_id'];
	$chk_ss_val=$rs_chk->fields['ss_val'];
       	if (($chk_ss_id!="")&&($ss_val!="")) {
     		$sql_chk="update stud_seme_score_oth set ss_val='$ss_val' where seme_year_seme='$seme_year_seme' and stud_id='$stud_id' and ss_id='$ss_id'";
      		$rs_chk=$CONN->Execute($sql_chk);
       	} else {
       		$sql_chk="insert into stud_seme_score_oth (seme_year_seme,stud_id,ss_kind,ss_id,ss_val) values ('$seme_year_seme','$stud_id','�ͬ���{���q','$ss_id','$ss_val')";
       		$rs_chk=$CONN->Execute($sql_chk);
      	}
}
?>
