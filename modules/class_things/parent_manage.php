<?php

// $Id: parent_manage.php 6707 2012-03-01 02:44:10Z infodaes $

/*�ޤJ�ǰȨt�γ]�w��*/
include "config.php";

$act=($_GET['act'])?$_GET['act']:$_POST['act'];
$id=($_GET['id'])?$_GET['id']:$_POST['id'];
$stid=($_GET['stid'])?$_GET['stid']:$_POST['stid'];
$Submit1=($_GET['Submit1'])?$_GET['Submit1']:$_POST['Submit1'];
$enable_stat=($_GET['enable_stat'])?$_GET['enable_stat']:$_POST['enable_stat'];
$parent_password=($_GET['parent_password'])?$_GET['parent_password']:$_POST['parent_password'];
$parent_id=($_GET['parent_id'])?$_GET['parent_id']:$_POST['parent_id'];

//�ϥΪ̻{��
sfs_check();
if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
$teacher_sn=$_SESSION['session_tea_sn'];//���o�n�J�Ѯv��id

//�q�X����
head("�Z�Ũư�");
print_menu($menu_p);
//�]�w�D������ܰϪ��I���C��
echo "<table border=0 cellspacing=1 cellpadding=2 width=100% bgcolor=#cccccc><tr><td bgcolor='#FFFFFF'>";

if($Submit1=="�x�s"){
	//����replace
	if($enable_stat=="0") $sql_replace = "delete from parent_auth where parent_id='$parent_id' and parent_pass='$parent_password'";
	else $sql_replace = "replace into parent_auth(parent_id,parent_pass,enable) values ('$parent_id','$parent_password','$enable_stat')";
	$CONN->Execute($sql_replace);
	//echo $parent_pass.$parent_id."-----------".$enable_stat;
}

//�C�X�a���b���W��

//��X���ЯZ��
$seme_year_seme=sprintf("%03d%d",$sel_year,$sel_seme);
$seme_class=teacher_sn_to_class_name($teacher_sn);
$sql="select stud_id,student_sn from stud_seme  where seme_year_seme='$seme_year_seme' and seme_class='$seme_class[0]'";
$rs=$CONN->Execute($sql);
$m=0;
while(!$rs->EOF){
        $stud_id[$m] = $rs->fields["stud_id"];
        $student_sn[$m] = $rs->fields["student_sn"];
	//�٦b�Ƕ�?
	if(!stud_id_live($stud_id[$m])) {$m++; $rs->MoveNext(); continue;};
	$stud_name[$m]=stud_id_to_stud_name($stud_id[$m]);
	$sql_guar="select sd.guardian_name , sd.guardian_p_id from stud_domicile as sd , stud_seme as ss where ss.stud_id='$stud_id[$m]' and sd.stud_id='$stud_id[$m]' ";
	$rs_guar=$CONN->Execute($sql_guar);		
	$guardian_name[$m] = $rs_guar->fields["guardian_name"];
	$guardian_p_id[$m] = $rs_guar->fields["guardian_p_id"];	
	$sql_parent="select * from parent_auth where parent_id='$guardian_p_id[$m]' ";
	//echo $sql_parent;
	$rs_parent=$CONN->Execute($sql_parent);
	$parent_sn[$m] = $rs_parent->fields["parent_sn"];
	//�Y�o��a����id�|���s�b��parent_auth���ܴN���L�إߨõ��@�ӱҰʽX
	if($parent_sn[$m]=="" && $guardian_p_id[$m]) {
		//�H���s�y�@�ӱK�X
		$new_code[$m]=creat_code();
		//�g�Jparent_auth��ƪ�
		$CONN->Execute("insert into parent_auth(parent_id,start_code,enable) values('$guardian_p_id[$m]','$new_code[$m]','1')");		
		//���s���@���s��
		$rs_parent = $CONN->Execute("select * from parent_auth where parent_id='$guardian_p_id[$m]' ");		
		$parent_sn[$m] = $rs_parent->fields["parent_sn"];					
	}
	$login_id[$m]=$rs_parent->fields['login_id'];
	$parent_pass[$m]=$rs_parent->fields['parent_pass'];
	$start_code[$m]=$rs_parent->fields['start_code'];
	$email[$m]=$rs_parent->fields['email'];	
	$date[$m]=$rs_parent->fields['date'];
	$enable[$m]=$rs_parent->fields["enable"];	
	if($enable[$m]==2) $C_enable[$m]="<font color='#456AEE'>�ҥ�</font>"; 
	elseif($enable[$m]==3) $C_enable[$m]="<font color='#D844EB'>����</font>"; 
	elseif($enable[$m]==1) $C_enable[$m]="<font color='#C11212'>�|���Ұ�</font>"; 
	else $C_enable[$m]="<font color='#FF0000'><a href='../stud_class/stud_dom1.php?stud_id=$stud_id[$m]'>���@�H��ƥ��إ�</a></font>"; 
	//�Y�o��a����id�|���s�b��parent_auth���ܴN���L�إߨõ��@�ӱҰʽX
	
	
	
	
	
	//if($parent_sn[$m]) $check="yes";
	//else $check="no";		
	/*
	if($act=="edit" && $id==$guardian_p_id[$m] && $stid==$stud_id[$m]) {
		if($parent_pass[$m]=="") $parent_pass[$m]=$guardian_p_id[$m];
		if($guardian_p_id[$m]=="") $main.="<tr bgcolor='#FFFFFF'><td colspan='6'>$stud_name[$m]�����@�H�����|���إߧ���A<a href='../stud_class/stud_dom1.php'>�e���إ�</a></td></tr>";		
		else $main.="<form name='form1' method='post' action='{$_SERVER['PHP_SELF']}' >
								<input type='hidden' name='parent_id' value='$guardian_p_id[$m]'>
								<tr bgcolor='#FFFFFF'>
									<td>$stud_name[$m]</td>
									<td>$guardian_name[$m]</td>
									<td>$guardian_p_id[$m]</td>
									<td><input type='text' name='parent_password' size=10 maxlength=20 value='$parent_pass[$m]'></td>
									<td><select name='enable_stat'>
											<option value='1' $selected1[$m]>�ҥ�</option>
											<option value='2' $selected2[$m]>����</option>
											<option value='0' $selected3[$m]>�R��</option>
											</select></td>
									<td><input type='submit' name='Submit1' value='�x�s'></td>
								</tr>
							</form>";
	}
	else $main.="<tr bgcolor='#FFFFFF'><td >$stud_name[$m]</td><td>$guardian_name[$m]</td><td>$guardian_p_id[$m]</td><td>$parent_pass[$m]</td><td>$C_enable[$m]</td><td><a href='{$_SERVER['PHP_SELF']}?act=edit&id={$guardian_p_id[$m]}&stid={$stud_id[$m]}'><button>�s��</button></a></td></tr>";
	*/
	$main.="<tr bgcolor='#FFFFFF'><td >$stud_name[$m]</td><td>$guardian_name[$m]</td><td>$guardian_p_id[$m]</td><td>$login_id[$m]</td><td>$parent_pass[$m]</td><td>$start_code[$m]</td><td>$C_enable[$m]</td><td>$email[$m]</td></tr>";
	$m++;
	$rs->MoveNext();
}
echo "<table  bgcolor='#000000' border=0 cellspacing=1 cellpadding=2>
		<tr bgcolor='#EEE726'><td>�ǥͩm�W</td><td>�a���m�W</td><td>�����Ҧr��</td><td>�b��</td><td>�K�X</td><td>�ҰʽX</td><td>���A</td><td>E-MAIL</td></tr>
		$main</table>";
	
	
//�����D������ܰ�
echo "</td>";
echo "</tr>";
echo "</table>";
//�{���ɧ�
foot();

function creat_code($level="",$many_char=""){		
		$number="1234567890";
		$small="abcdefghijklmnopqrstuvwxyz";
		$big="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$special="!@$%^&*()_+|=-[]{}?/";
		$much=0;
		if($level=="") $level=4;
		if($level>="1") {$passwordsource.=$number; $much=$much+10;}
		if($level>="2") {$passwordsource.=$small; $much=$much+26;}
		if($level>="3") {$passwordsource.=$big; $much=$much+26;}
		if($level>="4") {$passwordsource.=$special; $much=$much+21;}
		if($many_char=="") $many_char=10;
		for ($i=0;$i<$many_char;$i++){
			srand ((double) microtime() * 1000000);
			$value=rand(0,$much-1);
			$password[$i]=substr($passwordsource,$value,1);
		}
		$password=implode("",$password);
	return $password;	
}	
?>
