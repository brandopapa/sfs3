<?php

// $Id: add_kind.php 5310 2009-01-10 07:57:56Z hami $

//�]�w�ɸ��J�ˬd
require "config.php";
// �{���ˬd
sfs_check();

//����ʧ@�P�_
if($_POST[act]=="insert"){
	add($_POST[data]);
	header("location: $_SERVER[PHP_SELF]");
}else{
	$main=&main_form();
}


//�q�X����
head("�ǰȵ{���]�w");
echo $main;
foot();

//�D�n���
function &main_form(){
	global $school_menu_p;

	$tool_bar=&make_menu($school_menu_p);
	$group_tree=get_group_tree();
	$main="
	$tool_bar
	<table  cellspacing='1' cellpadding='3' bgcolor='#C0C0C0' class='small'>
	<form action='$_SERVER[PHP_SELF]' method='POST'>
		<tr bgcolor='white'><td>
		<p>��J�����W�١G
		<input type='text' name='data[showname]' value=''>
		<input type='hidden' name='data[kind]' value='����'>
		</p><p>
		�N���������G".get_of_group("","data[of_group]",0,"����","1")."���U
		</p><p>
		<input type='checkbox' name='data[islive]' value=1>�ߧY�ҥ�
		</p><p>
		<input type='checkbox' name='data[isopen]' value=1>���\�@����Ͷi�J�s��
		</p><p>
		<input type='hidden' name='act' value='insert'>
		<input type='submit' value='�s�W�Ҳդ���'>
		</p></td>
		</tr>
		</form>
	</table>
	</form>
	<p>
	<table  cellspacing='1' cellpadding='3' bgcolor='#C0C0C0' class='small'>
	$group_tree
	</table>
	</p>";
	return $main;
}

//�s�W
function add($data){
	global $CONN;
	//���o�Ӥ����U�̫�@�ӱƧǼƦr
	$sort=get_sort($data[of_group]);

	$sql_insert = "insert into sfs_module (showname,dirname,sort,isopen,islive,of_group,ver,icon_image,author,creat_date,kind,txt) values ('$data[showname]','$data[dirname]','$sort','$data[isopen]','$data[islive]','$data[of_group]','$data[ver]','$data[icon_image]','$data[author]','$data[creat_date]','$data[kind]','$data[txt]')";
	$CONN->Execute($sql_insert) or user_error("�s�W���ѡI<br>$sql_insert",256);
	$msn=mysql_insert_id();
	return $msn;
}

//�𪬤������j
function get_group_tree($curr_msn="",$group=0,$level=-1){
	global $CONN;

 	$level++;

	$sql_select="select msn,showname from sfs_module where kind='����' and of_group='$group' order by sort";

	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(list($msn,$showname)=$recordSet->FetchRow()){
		$name[$msn]=$showname;
	}

	if(empty($name) or sizeof($name)<=0)return;
	for($i=0;$i<$level;$i++){
		$blank.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	foreach($name as $msn=>$showname){
		$tool="
		<td><a href='index.php?msn=$group&set_msn=$msn&mode=setup'>�]�w</a></td>
		";
		if($group==0){
			$option.="<tr bgcolor='white'><td>".$blank.$showname."</td>$tool</tr>";
		}elseif($group!=0){

			$option.="<tr bgcolor='white'><td>".$blank."".$showname."</td>$tool</tr>";
		}
		$option.=get_group_tree($curr_msn,$msn,$level);
	}
	return $option;
}
?>
