<?php

// $Id: comment.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�ǰȨt�γ]�w�� */
include "config.php";
sfs_check();
 
/************************�D�n���e*************************/ 

$teacher_id=$_SESSION['session_log_id'];//���o�n�J�Ѯv��id

//���򪬺A�]�w
if(is_null($_REQUEST[add_one])){
	$_REQUEST[add_one]=1;
}

//�D�n�禡
$main=&list_comment($_REQUEST[cq]);

echo "<html><body bgcolor='#E7F3FF'><style>body,td,input,select,textarea{font-size: 12px; }</style>
$main
</body></html>";



/**********************************************************/


//�H�U�O�禡
//�q�X�W�h���C��
function &list_comment($cq){
	global $CONN,$comment,$data,$teacher_id,$send_comm,$add_comment,$is_modify;
	
	$data_kind=array('','���O','����','���y');
	
	$tmp_kind="";
	$tmp_level="";

	//���o�@�P���Юv���y�H�θӱЮv���y
	$comm_length_select=get_kind($teacher_id);

	//��ܦ@�P���Юv�H�θӱЮv����
	$level_select=get_level($teacher_id);
	
	//���o���y�U�Կ��
	$comment_select=get_comm($teacher_id);
	
	
	$sel="select comm from comment where serial='$_REQUEST[comment]' and kind='$_REQUEST[comm_length]' and level='$_REQUEST[level]'";
	$sel_comment=$CONN->Execute($sel);
	list($the_comment) = $sel_comment->FetchRow();
	$end=substr($_REQUEST[comm],-2);
	if($_REQUEST[comm]!="" and $end!='�C' and $end!='�A' and $the_comment!="" and $_REQUEST[add_one]==1){
		$the_comment='�A'.$the_comment;
	}
	
	$word=($_REQUEST[add_one]==1)?$_REQUEST[comm].$the_comment:$the_comment;

	$mainc.=$word;
	
		
	$main="	<form name='myform' method='post' action='{$_SERVER['PHP_SELF']}'>
	$comm_length_select
	$level_select
	$comment_select
	<br>
	<input type='hidden' name='add_one' value='$_REQUEST[add_one]'>\n
	<input type='hidden' name='cq' value='$cq'>
	<textarea name='comm' cols='50' rows='5' wrap='soft' style='width:100%;height:100px'>$mainc</textarea>	
	</form>
	<form name='back' action='input.php' method='post'>
	<input type='button' name='send_comm_back' value='�T�w' 
	onClick=\"window.opener.document.col1.".$cq.".value='".$mainc."';setTimeout('window.close()',100);\">�]100�r�H���^
	</form>";
	return  $main;
}


//���o�@�P���H�θӱЮv���y����
function get_kind($teacher_id=0){
	global $CONN;
	if(empty($teacher_id))return;
	$sel="select * from comment_kind where kind_teacher_id='0' or kind_teacher_id='$teacher_id'";
	
	$comm_len=$CONN->Execute($sel);
	while(!$comm_len->EOF){
		$tmp_value=$comm_len->fields[0];
		$tmp_name=$comm_len->fields[2];
		$selected=($_REQUEST[comm_length]==$tmp_value)?"selected":"";
		$len.="<option value='$tmp_value' $selected>$tmp_name</option>\n";
		if($selected=='selected') $tmp_kind=$tmp_name;
		$comm_len->MoveNext();
	}
	
	$comm_length_select="
	���O�G
	<select name='comm_length' onChange='submit()'>
	<option value=''>������O</option>
	$len
	</select>";
	return $comm_length_select;
}

//��ܦ@�P���Юv�H�θӱЮv����
function get_level($teacher_id=0){
	global $CONN;
	if(empty($teacher_id) or empty($_REQUEST[comm_length]))return;
	$sel="select * from comment_level where level_teacher_id='0' or level_teacher_id='$teacher_id'";
	
	$comm_lev=$CONN->Execute($sel);
	while(!$comm_lev->EOF){
		$tmp_value=$comm_lev->fields[0];
		$tmp_name=$comm_lev->fields[2];
		$selected=($_REQUEST[level]==$tmp_value)?"selected":"";
		$select.="<option value='$tmp_value' $selected>$tmp_name</option>\n";
		if($selected=='selected') $tmp_level=$tmp_name;
		$comm_lev->MoveNext();
	}
	
	$level_select="
	���šG
	<select name='level' onChange='submit()'>
	<option value=''></option>
	$select
	</select>";
	return $level_select;
}

//���o���y
function get_comm($teacher_id=0){
	global $CONN;
	if(empty($_REQUEST[comm_length]) or empty($_REQUEST[level]) or empty($teacher_id))return;
	
	$sel="select serial,comm from comment where kind='$_REQUEST[comm_length]' and level='$_REQUEST[level]' and (teacher_id='0' or teacher_id='$teacher_id')";
	$comm_text=$CONN->Execute($sel);
	while(!$comm_text->EOF){
		$c=(strlen($comm_text->fields[1])<=8)?$comm_text->fields[1]:substr($comm_text->fields[1],0,8)."...";
		$ser=$comm_text->fields[0];
		$selected=($_REQUEST[comment]==$comm_text->fields[0])?"selected":"";
		$comment_line.="<option value='$ser' $selected>$c</option>\n";
		$comm_text->MoveNext();
	}
	$comm_act=($_REQUEST[add_one]==0)?"1'>��������y":"0'>������y";
	$comment_select.="
	���y�G<select name='comment' onChange='submit()'>
	<option value=''>��ܵ��y</option>
	$comment_line
	</select>
	[���A�G<a href='{$_SERVER['PHP_SELF']}?comm_length=$_REQUEST[comm_length]&level=$_REQUEST[level]&comment=$_REQUEST[comment]&cq=$_REQUEST[cq]&add_one=$comm_act</a>]\n";
	return $comment_select;
}
?>
