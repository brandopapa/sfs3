<?php

// $Id: index.php 5310 2009-01-10 07:57:56Z hami $

/*�ޤJ�ǰȨt�γ]�w��*/
require "config.php";

if($_GET['class_year_b']) $class_year_b=$_GET['class_year_b'];
else $class_year_b=$_POST['class_year_b'];

$new_loginid=($_GET['new_loginid'])?$_GET['new_loginid']:$_POST['new_loginid'];
$new_pass=($_GET['new_pass'])?$_GET['new_pass']:$_POST['new_pass'];
$new_pass2=($_GET['new_pass2'])?$_GET['new_pass2']:$_POST['new_pass2'];
$act=($_GET['act'])?$_GET['act']:$_POST['act'];
$submit_passt=($_GET['submit_pass'])?$_GET['submit_pass']:$_POST['submit_pass'];
$stud_id=($_GET['stud_id'])?$_GET['stud_id']:$_POST['stud_id'];

//�ϥΪ̻{��
sfs_check();
//�{�����Y
head("��¾�q�p");

print_menu($menu_p);
//�]�w�D������ܰϪ��I���C��


//�������e�иm�󦹳B
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

//����ʧ@�P�_
if($act=="score"){
	$main=&sea_score();	
}elseif($act=="absent"){
	$main=&sea_absent();
}elseif($act=="chpass"){
	$main=&sea_chpass();
}elseif($act=="chpass_a"){
	$main=&chpass_a();
}elseif($act=="show_score"){
	$main=&show_score($stud_id);	
}elseif($act=="show_absent"){
	$main=&show_absent($stud_id);	
}else{
	$main=&homebook();
}


//�q�X����

echo $main;
foot();

function &homebook(){
	global $CONN,$parent_menu_p;
	
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);	
	
	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
	$tool_bar=&make_menu($parent_menu_p);
	 $child_A=&get_child();
	 //echo $child_A[0][name];
	 foreach($child_A as $v){
	 	$C_v[num]=intval($v[num]);
		$C_v[Cclass]=class_id2big5($v[Cclass],$sel_year,$sel_seme);
	 	$child_list.="<tr  bgcolor='#FFCAF8'><td>$v[id]</td><td>$C_v[Cclass]</td><td>$C_v[num]</td><td><a href='home_book.php?stud_id=$v[id]'>$v[name]</a></td></tr>";
	 }
	$main="
	$tool_bar
	<table width='100%' cellspacing=1 cellpadding='6' bgcolor='#E1B2DB'><tr bgcolor='#FFCAF8'><td>
		<table width='30%' cellspacing=1 cellpadding='2' bgcolor='#E1B2DB'>
			<tr bgcolor='#FFCAF8'><td>�Ǹ�</td><td>�Z��</td><td>�y��</td><td>�m�W</td></tr>
			$child_list
		</table>	</td></tr>	
	</table>	
	";
	return $main;	
}

function &sea_score(){
	global $CONN,$parent_menu_p;
	
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);	
	
	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
	$tool_bar=&make_menu($parent_menu_p);
	 $child_A=&get_child();
	 //echo $child_A[0][name];
	 foreach($child_A as $v){
	 	$C_v[num]=intval($v[num]);
		$C_v[Cclass]=class_id2big5($v[Cclass],$sel_year,$sel_seme);
	 	$child_list.="<tr  bgcolor='#FFCAF8'><td>$v[id]</td><td>$C_v[Cclass]</td><td>$C_v[num]</td><td><a href='{$_SERVER['PHP_SELF']}?act=show_score&stud_id=$v[id]'>$v[name]</a></td></tr>";
	 }
	$main="
	$tool_bar
	<table width='100%' cellspacing=1 cellpadding='6' bgcolor='#E1B2DB'><tr bgcolor='#FFCAF8'><td>
		<table width='30%' cellspacing=1 cellpadding='2' bgcolor='#E1B2DB'>
			<tr bgcolor='#FFCAF8'><td>�Ǹ�</td><td>�Z��</td><td>�y��</td><td>�m�W</td></tr>
			$child_list
		</table>	</td></tr>	
	</table>	
	";
	return $main;
}

function &sea_absent(){
	global $CONN,$parent_menu_p;
	
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);		
	
	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
	$tool_bar=&make_menu($parent_menu_p);
	 $child_A=&get_child();
	 //echo $child_A[0][name];
	 foreach($child_A as $v){
	 	$C_v[num]=intval($v[num]);
		$C_v[Cclass]=class_id2big5($v[Cclass],$sel_year,$sel_seme);
	 	$child_list.="<tr  bgcolor='#FFCAF8'><td>$v[id]</td><td>$C_v[Cclass]</td><td>$C_v[num]</td><td><a href='{$_SERVER['PHP_SELF']}?act=show_absent&stud_id=$v[id]'>$v[name]</a></td></tr>";
	 }
	$main="
	$tool_bar
	<table width='100%' cellspacing=1 cellpadding='6' bgcolor='#E1B2DB'><tr bgcolor='#FFCAF8'><td>
		<table width='30%' cellspacing=1 cellpadding='2' bgcolor='#E1B2DB'>
			<tr bgcolor='#FFCAF8'><td>�Ǹ�</td><td>�Z��</td><td>�y��</td><td>�m�W</td></tr>
			$child_list
		</table>	</td></tr>	
	</table>	
	";
	return $main;
}

function &sea_chpass(){
	global $CONN,$parent_menu_p;
	
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);		
	
	$tool_bar=&make_menu($parent_menu_p);

	$main="
	$tool_bar
	<table width='100%' cellspacing=1 cellpadding='6' bgcolor='#E1B2DB'><tr bgcolor='#FFCAF8'><td>���]{$_SESSION['session_tea_name']}�^���b���K�X<p></p>
		<table width='30%' cellspacing=1 cellpadding='2' bgcolor='#E1B2DB'>
			<form name='chpass_form' method='post' action='{$_SERVER['PHP_SELF']}'>
			<tr bgcolor='#FFCAF8'><td>�b��</td><td><input type='text' name='new_loginid' size=20 maxlength=10 value='{$_SESSION['session_log_id']}'></td></tr>
			<tr bgcolor='#FFCAF8'><td>�K�X</td><td><input type='password' name='new_pass' size=20 maxlength=10></td></tr>
			<tr bgcolor='#FFCAF8'><td>�K�X�T�{</td><td><input type='password' name='new_pass2' size=20 maxlength=10></td></tr>
			<input type='hidden' name='act' value='chpass_a'>
			<tr bgcolor='#FFCAF8'><td colspan=='2'><input type='submit' name='submit_pass' value='�e�X'></td></tr>
			</form>
		</table>			
	</table>	
	";
	return $main;
}

function &chpass_a(){
	global $CONN,$parent_menu_p,$new_loginid,$new_pass,$new_pass2;	
	
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);		
	
	$tool_bar=&make_menu($parent_menu_p);
	if($new_loginid==$_SESSION['session_log_id']) $A1=0;
	else{
		//�s�b���O�_�w�Q�ΤF
		$sql1="select count(*) from parent_auth where login_id='$new_loginid'";
		$rs1=$CONN->Execute($sql1);
		$A1=$rs1->fields[0];
	}
	if ($A1==0) {
		//�s�b���O�_�w�Q�ΤF(�ˬd�O�_�ϥΧO�H�������Ҧr��)
		$sql1="select count(*) from parent_auth where parent_id='$new_loginid'";
		$rs1=$CONN->Execute($sql1);
		$A1=$rs1->fields[0];
	}

	//�K�X�O�_�۲�
	if($new_loginid=="") $msg= "�b�����i���ŭ�<span class='button'><a href='{$_SERVER['PHP_SELF']}?act=chpass'>���s���</a></span>";
	elseif($new_pass!=$new_pass2) $msg= "�⦸�ҿ�J���K�X���۲�<span class='button'><a href='{$_SERVER['PHP_SELF']}?act=chpass'>���s���</a></span>";
	elseif(strlen($new_pass)<=3 || strlen($new_pass2)<=3) $msg= "�K�X�r���Ƥ��o�C��4��<span class='button'><a href='{$_SERVER['PHP_SELF']}?act=chpass'>���s���</a></span>";
	elseif($A1!=0) $msg= "�ӱb���w�g���H�ϥΡA�Хt���b��<span class='button'><a href='{$_SERVER['PHP_SELF']}?act=chpass'>���s���</a></span>";
	else {//��s�b���K�X
		$sql="update parent_auth set login_id='$new_loginid',parent_pass='$new_pass' where  login_id='{$_SESSION['session_log_id']}'";
		$CONN->Execute($sql) or trigger_error("�s�b���K�X��s����" ,E_USER_ERROR);
		if($new_loginid!=$_SESSION['session_log_id']) {
			$_SESSION['session_log_id'] = "";
			$_SESSION['session_tea_sn'] = "";
			$_SESSION['session_tea_name'] = "";
			$_SESSION['session_who'] = "";
			$_SESSION['session_prob'] = "";				
			$msg="�z���b���K�X�w�g��s���\�I�ХH�s�b�����s�n�J�C";
		} 
		else $msg="�z���K�X�w�g��s���\�I";
	}	
	$main="
	$tool_bar
	$msg
	";
	return $main;
}

function &show_score($stud_id){
	global $CONN,$parent_menu_p,$test_sort_name;
	
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);		
	
	$tool_bar=&make_menu($parent_menu_p);
	//���Ǵ��ثe�ӥͤw�������Z�]�w�g�e��аȳB���^
	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�	
	$score_semester="score_semester_".$sel_year."_".$sel_seme;
	//�Ǹ��ܧǸ�
    $rs_sn=$CONN->Execute("select  student_sn  from  stud_base where stud_id='$stud_id'")  or trigger_error("SQL�y�k���~", E_USER_ERROR);;    
	$student_sn=$rs_sn->fields['student_sn'];	

	$sql="select * from $score_semester where 1=0";	
	if(!$CONN->Execute($sql)) {
		$msg="���Ǵ����Z�|���إߡI";
		$main="
		$tool_bar
		<table width='100%' cellspacing=1 cellpadding='6' bgcolor='#E1B2DB'><tr bgcolor='#FFCAF8'><td>
			<table width='30%' cellspacing=1 cellpadding='2' bgcolor='#E1B2DB'>
				<tr bgcolor='#FFCAF8'>$msg</tr>			
			</table>	</td></tr>	
		</table>";
		return $main;
	}
	
	//���ض��q���Z
	$sql="select * from $score_semester where student_sn='$student_sn' and sendmit='0' order by test_sort";	
	$rs=$CONN->Execute($sql) or trigger_error("SQL�y�k���~�G $sql", E_USER_ERROR);
	$i=0;
	//��ǥͩm�W
	$sql_cn="select stud_name from stud_base where stud_id='$stud_id'";
	$rs_cn=$CONN->Execute($sql_cn);
	$child_name=$rs_cn->fields['stud_name'];
	$msg.="<span style='background-color: rgb(255, 255, 153);'>".$child_name." ���Ǵ������Z</span><p>";
	while(!$rs->EOF){
		$ST[$i][ss_id]=$rs->fields['ss_id'];
		//����त��/
		$Ch_ST[$i][ss_id]=ss_id_to_subject_name($ST[$i][ss_id]);
		
		$ST[$i][test_sort]=$rs->fields['test_sort'];
		//���q�त��		
		$Ch_ST[$i][test_sort]=$test_sort_name[$ST[$i][test_sort]];
		
		$ST[$i][score]=$rs->fields['score'];
		if($ST[$i][score]<0 || $ST[$i][score]>255) $ST[$i][score]="";
		$msg.=$Ch_ST[$i][test_sort]."��".$Ch_ST[$i][ss_id]."�즨�Z�G <span style='background-color: rgb(185, 194, 253);'>".$ST[$i][score]."</span> ��<p>";		
		$i++;
		$rs->MoveNext();
	}
	$main="
	$tool_bar
	<table width='100%' cellspacing=1 cellpadding='6' bgcolor='#E1B2DB'><tr bgcolor='#FFCAF8'><td>
		<table width='30%' cellspacing=1 cellpadding='2' bgcolor='#E1B2DB'>
			<tr bgcolor='#FFCAF8'>$msg</tr>			
		</table>	</td></tr>	
	</table>	
	";
	return $main;	
}

function &show_absent($stud_id){
	global $CONN,$parent_menu_p;
	
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);		
	
	$tool_bar=&make_menu($parent_menu_p);
	//���Ǵ��ثe�ӥͪ��X�ʮu����
	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�	
	$sql_absent="select * from stud_absent where stud_id='$stud_id' and year='$sel_year' and semester='$sel_seme' order by date,section";
	$rs_absent=$CONN->Execute($sql_absent) or user_error("Ū�����ѡI<br>$sql_absent",256);
	$i=0;
	$section_name_A=array("uf"=>"�ɺX","1"=>"�Ĥ@�`","2"=>"�ĤG�`","3"=>"�ĤT�`","4"=>"�ĥ|�`","5"=>"�Ĥ��`","6"=>"�Ĥ��`","7"=>"�ĤC�`","8"=>"�ĤK�`","df"=>"���X","allday"=>"���",);
	while(!$rs_absent->EOF){
		$date[$i]=$rs_absent->fields['date'];
		$absent_kind[$i]=$rs_absent->fields['absent_kind'];
		$section[$i]=$rs_absent->fields['section'];
		$msg.="<tr bgcolor='#FFD5FB'><td>".$date[$i]."</td><td>".$section_name_A[$section[$i]]."</td><td>".$absent_kind[$i]."</td></tr>";
		$i++;
		$rs_absent->MoveNext();
	}
		
	//��ǥͩm�W
	$sql_cn="select stud_name from stud_base where stud_id='$stud_id'";
	$rs_cn=$CONN->Execute($sql_cn);
	$child_name=$rs_cn->fields['stud_name'];
	if($msg=="") $msg="�ثe�L����ʮu����";
	$msg=$child_name."�]".$sel_year."�Ǧ~��".$sel_seme."�Ǵ� �ʮu���Ρ^<br>".$msg;
	$main="
	$tool_bar
	<table width='100%' cellspacing=1 cellpadding='6' bgcolor='#E1B2DB'><tr bgcolor='#FFCAF8'><td>
		<table width='30%' cellspacing=1 cellpadding='2' bgcolor='#E1B2DB'>
			$msg
		</table></td></tr>	
	</table>	
	";
	return $main;	
}



//��ss_id��X��ئW�٪����
function  ss_id_to_subject_name($ss_id){
    global $CONN;
    
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);		
	
	$sql1="select subject_id from score_ss where ss_id=$ss_id";
    $rs1=$CONN->Execute($sql1);
    $subject_id = $rs1->fields["subject_id"];
    if($subject_id!=0){
        $sql2="select subject_name from score_subject where subject_id=$subject_id";
        $rs2=$CONN->Execute($sql2);
        $subject_name = $rs2->fields["subject_name"];
    }
    else{
        $sql3="select scope_id from score_ss where ss_id=$ss_id";
        $rs3=$CONN->Execute($sql3);
        $scope_id = $rs3->fields["scope_id"];
        $sql4="select subject_name from score_subject where subject_id=$scope_id";
        $rs4=$CONN->Execute($sql4);
        $subject_name = $rs4->fields["subject_name"];
    }
    return $subject_name;
}
?>
