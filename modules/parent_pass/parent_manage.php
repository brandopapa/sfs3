<?php
// $Id: parent_manage.php 5310 2009-01-10 07:57:56Z hami $
// �ޤJ SFS3 ���禡�w
include "../../include/config.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �s�� SFS3 �����Y
head("�a���b���޲z");

// �{��
sfs_check();

//
// �z���{���X�Ѧ��}�l

//�����ܼ��ഫ��*****************************************************
$var_name=($_GET['var_name'])?$_GET['var_name']:$_POST['var_name'];
$act=($_GET['act'])?$_GET['act']:$_POST['act'];
//$mode=($_GET['mode'])?$_GET['mode']:$_POST['mode'];
$name=($_GET['name'])?$_GET['name']:$_POST['name'];
$chg_cond=($_GET['chg_cond'])?$_GET['chg_cond']:$_POST['chg_cond'];
$parent_id=($_GET['parent_id'])?$_GET['parent_id']:$_POST['parent_id'];
$cond=($_GET['cond'])?$_GET['cond']:$_POST['cond'];
//********************************************************************

if(empty($act))$act="";

if($chg_cond=="yes_chg"){
//�ܧ�a�����ϥΪ��A
	if($cond==0) $sql="delete from parent_auth where parent_id='$parent_id' ";
	else $sql="update parent_auth set enable='$cond' where parent_id='$parent_id'";
	$CONN->Execute($sql)  or trigger_error("SQL�y�k���~�G $sql_st", E_USER_ERROR);
} 


//����ʧ@�P�_
if($act=="�C�X�����a�����"){
	$result=find_data("","all");
}elseif($act=="�d��"){
	$result=find_data($name);
}

$main=pre_form();

//��V������
echo print_menu($MENU_P);

echo $main;
echo $result;


//�j�M����
function pre_form(){
	$main="
	<table>
	<form action='{$_SERVER['PHP_SELF']}' method='post'>
	<tr><td><input type='submit' name='act' value='�C�X�����a�����'></td></tr>
	<tr><td>
	��J�a���m�W�G
	<input type='text' name='name' size='10'>
	<input type='submit' name='act' value='�d��'>	
	</td></tr>
	</form>
	</table>";
	return $main;
}

//�j�M���
function find_data($name="",$mode=""){
	global $CONN,$act;
		
	$wherestr=($mode=="all")?" where  sd.guardian_p_id=pa.parent_id   GROUP BY pa.parent_id order by sd.stud_id":" where sd.guardian_name='$name' and sd.guardian_p_id=pa.parent_id GROUP BY pa.parent_id";
	$query="select sd.guardian_name , sd.guardian_p_id ,pa.* from parent_auth as pa ,  stud_domicile as sd ".$wherestr;  		
	$recordSet = $CONN->Execute($query) or user_error($query,256);
	$i=0;
	//$date="<form action='{$_SERVER['PHP_SELF']}' method='post'>";
	while (!$recordSet->EOF){
		$parent_name[$i]=$recordSet->fields[guardian_name];
		$parent_id[$i]=$recordSet->fields[parent_id];
		$login_id[$i]=$recordSet->fields[login_id];
		$parent_pass[$i]=$recordSet->fields[parent_pass];		
		$enable[$i]=$recordSet->fields[enable];
		if($enable[$i]=='1') $checked1[$i]="checked";
		elseif($enable[$i]=='2') $checked2[$i]="checked";
		elseif($enable[$i]=='3') $checked3[$i]="checked";
		else $checked0[$i]="checked";
		$data.="<tr bgcolor='#FFFFFF'>		
		<td>$parent_name[$i]</td>
		<td>$login_id[$i]</td>
		<td>$parent_pass[$i]</td>		
		<td><form action='{$_SERVER['PHP_SELF']}' method='post'>
			<input type='radio' $checked1[$i] name='cond' value='1' onchange='this.form.submit()'>�|���Ұ�
			<input type='radio' $checked2[$i] name='cond' value='2' onchange='this.form.submit()'>�ҥ�
			<input type='radio' $checked3[$i] name='cond' value='3' onchange='this.form.submit()'>����
			<input type='radio' $checked0[$i] name='cond' value='0' onchange='this.form.submit()'>�R��
		</td><input type='hidden' name='chg_cond' value='yes_chg'><input type='hidden' name='parent_id' value='$parent_id[$i]'><input type='hidden' name='name' value='$name'><input type='hidden' name='mode' value='$mode'><input type='hidden' name='act' value='$act'></form>
		</tr>";
		$i++;
		$recordSet->MoveNext();
	}
	//$data.="<input type='hidden' name='name' value='$name'><input type='hidden' name='mode' value='$mode'><input type='hidden' name='act' value='$act'></form>";
	$main="
	<table cellspacing='1' cellpadding='4' bgcolor='#000000'>
	<tr bgcolor='#E1E1FF'><td>�a���m�W</td><td>�a���b��</td><td>�K�X</td><td>���A</td></tr>
	$data
	</table>";
	return $main;
}

// SFS3 ������
foot();

?>

