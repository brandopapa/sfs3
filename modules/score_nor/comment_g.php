<?php

// $Id: comment_g.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�ǰȨt�γ]�w�� */
include "../../include/config.php";
//sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}
 
/************************�D�n���e*************************/ 

$teacher_id=$_SESSION['session_log_id'];//���o�n�J�Ѯv��id
//$comm_length->���y���O,ex:�|�r�e��...
//$level->����,ex:��,�A,��,�B
//$comment->���y�Ǹ�
//$comm->���y�r��
//$show_mod->��ܩ����ýs�ץ\��,1->���,0->����
//$data->���O,����,���y���s�׿��
//$add_one->1��������y,0�Ϥ�
if(is_null($add_one))$add_one=1;

//�s�׵��y
if($add_comment!='' and $send_comm=="�T�w����")   mod_data();
//�D�n�禡
$main=&list_comment($cq);

//�q�X����
//head("���Z��J�t��");
//print_menu($menu_p);
?>
<html>
<body>
<style>
body,td,input,select,textarea{font-size: 12px; }
</style>
<script language="JavaScript1.2">
function show(){
	var test=document.myform.add_comment.value;
	switch(test){
	case 1:temp='�s�W';
	case 2:temp='�ק�';
	case 3:temp='�R��';
	}
	var t=confirm("�T�w����H");return t;
}

function helpme(){
	alert("�i�ϥλ����j\n1.�s�W��k�G����ܵ��y�����O�M���šA�A��J�A�����y�A��ܷs�W�A�A���T�w�N�����F�I\n2.�ק��k�G\n(1)�����y�G����w�@�ӵ��y�A��ܭק���y�A�����y�A�A���T�w�N�����F�I\n(2)�����y�����O���šG����w�@�ӵ��y�A��ܭק���y�A��ܧA�n���F���O�ε��šA���ݫ��T�w�I\n3.�R����k�G����w�@�ӵ��y�A��ܧR�����y�A�A���T�w�N�����F�I");
	}
</script>
<?
echo $main."</body></html>";
/**********************************************************/
//foot();

//�H�U�O�禡
//�q�X�W�h���C��
function &list_comment($cq){
	global $CONN,$comm_length,$level,$comment,$comm,$show_mod,$data,$add_one,$teacher_id,$send_comm,$add_comment;
	$data_kind=array('','���O','����','���y');
	$tmp_kind='';$tmp_level='';

	$sel="select * from comment_kind where kind_teacher_id='0' or kind_teacher_id='$teacher_id'";
	$comm_len=$CONN->Execute($sel);
	while(!$comm_len->EOF){
		$tmp_value=$comm_len->fields[0];
		$tmp_name=$comm_len->fields[2];
		$selected=($comm_length==$tmp_value)?"selected":"";
		$len.="<option value='$tmp_value' $selected>$tmp_name</option>\n";
		if($selected=='selected') $tmp_kind=$tmp_name;
		$comm_len->MoveNext();
	}
	$comm_length_select="���O�G<select name='comm_length' onChange='submit()'>
	<option value=''>������O</option>$len</select>";

	$sel="select * from comment_level where level_teacher_id='0' or level_teacher_id='$teacher_id'";
	$comm_lev=$CONN->Execute($sel);
	while(!$comm_lev->EOF){
		$tmp_value=$comm_lev->fields[0];
		$tmp_name=$comm_lev->fields[2];
		$selected=($level==$tmp_value)?"selected":"";
		$select.="<option value='$tmp_value' $selected>$tmp_name</option>\n";
		if($selected=='selected') $tmp_level=$tmp_name;
		$comm_lev->MoveNext();
	}
	$level_select="���šG<select name='level' onChange='submit()'>
	<option value=''></option>$select</select>";
	
	if($comment!='')	$point_of_kind=3;
	elseif($level!='') $point_of_kind=2;
	elseif($comm_length!='') $point_of_kind=1;
	for($k=1;$k<count($data_kind);$k++) {
	        $selected=($data==$k or $point_of_kind==$k)?"selected":"";
		$data_word.="<option value='$k' $selected>$data_kind[$k]</option>\n";
	}

	$sel="select serial,comm from comment where kind='$comm_length' and level='$level' and (teacher_id='0' or teacher_id='$teacher_id')";
	$comm_text=$CONN->Execute($sel);
	while(!$comm_text->EOF){
	        $c=(strlen($comm_text->fields[1])<=8)?$comm_text->fields[1]:substr($comm_text->fields[1],0,8)."...";
		$ser=$comm_text->fields[0];
		$selected=($comment==$comm_text->fields[0])?"selected":"";
		$comment_line.="<option value='$ser' $selected>$ser".":"."$c</option>\n";
		$comm_text->MoveNext();
	}
	$comm_act=($add_one==0)?"1'>��������y":"0'>������y";
	$comment_select.="���y�G<select name='comment' onChange='submit()'>
		<option value=''>��ܵ��y</option>$comment_line</select>  [���A:
		<a href='{$_SERVER['PHP_SELF']}?comm_length=$comm_length&level=$level&comment=$comment
		&show_mod=$show_mod&cq=$cq&add_one=$comm_act</a>]\n";

	$act=($show_mod==1)?'0\'>�i�^���j':'1\'>�i�s����w�j';
	$act_line="<a href='{$_SERVER['PHP_SELF']}?comm_length=$comm_length&level=$level&comment=$comment
		&comm=$comm&cq=$cq&add_one=$add_one&show_mod=$act</a>";

	//<select name='data'><option value=' '>--����--</option>$data_word</select>
	$selected1=($add_comment==1)?"selected":"";
	$selected2=($add_comment==2)?"selected":"";
	$selected3=($add_comment==3)?"selected":"";
	$mod_line_sel=($show_mod==1)?"�ڭn<select name='add_comment' >
		<option value='1' $selected1>�s�W</option>
		<option value='2' $selected2>�ק�</option>
		<option value='3' $selected3>�R��</option>
		</select>
		<select name='data' onChange='submit()'><option value=''>�H</option>$data_word</select>����":"";

	$mod_line_act=($show_mod==1)?"<tr bgcolor='#E1ECFF'><td>
		<input type='reset' value='���]'>\n
		<input type='submit' name='send_comm' value='�T�w����'></td></tr>":"";

	//$onsubmit=($show_mod==1)?"onsubmit='return show()'":"";
	$main="
	<img src='images/wizard.png' width='18' height='18' hspace='4' align='middle' border='0'>���y���u�� $act_line<p>
	<table cellspacing=1 cellpadding=4 width=100%  bgcolor='#1E3B89'>
	<tr bgcolor='#E1ECFF'><td>
	<form name='myform' method='post' action='{$_SERVER['PHP_SELF']}' $onsubmit>$mod_line_sel";
	if($show_mod==0){
		$main.=$comm_length_select;
		if($comm_length!='')  $main.=$level_select;
		if($comm_length!='' and $level!='')   $main.=$comment_select;
		//$main.=$act_line;
	}
	else{
		//$main.="�B�J 2�G��ܽs�׸�� : ";
		$font="<font color=red size='2'>  ( �s�W�ɥi���� )</font>";
		$font_comm="<font color=red size='2'>  ( ���O�P���Ť@�w�n�� )</font>";
                if( $data==3 )  $main.=$comm_length_select.$level_select.$comment_select."<br>".$font_comm;
		elseif( $data==2 )  $main.=$level_select.$font;
		elseif( $data==1 ) $main.=$comm_length_select.$font;
		elseif( $point_of_kind==3)  $main.=$comm_length_select.$level_select.$comment_select."<br>".$font_comm;
		elseif( $point_of_kind==2)  $main.=$level_select.$font;
		elseif( $point_of_kind==1) $main.=$comm_length_select.$font;
		else    $main.='';
	}
	$main.="
	<input type='hidden' name='show_mod' value='$show_mod'>\n
		<input type='hidden' name='add_one' value='$add_one'>\n
		<input type='hidden' name='cq' value='$cq'>
		<textarea name='comm' cols='50' rows='3' wrap='soft' style='width:100%'>\n";

	$sel="select comm from comment where serial='$comment' and kind='$comm_length' and level='$level'";
	$sel_comment=$CONN->Execute($sel);
	$end=substr($comm,-2);
	if($comm!='' and $end!='�C' and $end!='�A' and $sel_comment->fields[0]!='' and $add_one==1)
		$sel_comment->fields[0]='�A'.$sel_comment->fields[0];
	$word=($add_one==1)?$comm.$sel_comment->fields[0]:$sel_comment->fields[0];

	if($send_comm=='�T�w����'||$send_comm_back=='�T�w')    $mainc.='';
	elseif($data==1)   $mainc.=$tmp_kind;
	elseif($data==2)   $mainc.=$tmp_level;
	else $mainc.=$word;

	$main.="$mainc</textarea>�]100�r�H���^<font onclick='helpme()'>����</font>\n
	$mod_line_act
	</form></table><form name='back' action='give_comment.php' method='post'><table><tr><td>
	<input type='button' name='send_comm_back' value='�T�w' 
	onClick=\"window.opener.document.col1.".$cq.".value='".$mainc."';setTimeout('window.close()',100);\">
	</td></tr></table></form></table>\n";
	return  $main;
}

//�s�W,�ק���
function mod_data(){
	global $CONN,$teacher_id,$comm_length,$level,$comment,$comm,$show_mod,$data,$add_one,$add_comment;
	if(empty($comm))return;
	if($data!=''){
		switch($add_comment){
		case 1:         //�s�W
		        switch($data){
			        case 1:
					$comm_ins="insert into comment_kind values('0','$teacher_id','$comm')";
					$rs=$CONN->Execute($comm_ins);
					if(!$rs)	print $rs->ErrorMsg();
					break;
				case 2:
					$comm_ins="insert into comment_level values('0','$teacher_id','$comm')";
					$rs=$CONN->Execute($comm_ins);
					if(!$rs)	print $rs->ErrorMsg();
					break;
				case 3:
					if($comm_length!='' and $level!=''){
						$comm_ins="insert into comment values('0','$teacher_id','','','$comm_length','$level','$comm')";
						$rs=$CONN->Execute($comm_ins);
						if(!$rs)	print $rs->ErrorMsg();
					}
					else echo "�п�����O�P���šI";
					break;
			}
			break;
		case 2:          //�ק�
			switch($data){
				case 1:
					if($comm_length!=''){
						$sel="select kind_teacher_id from comment_kind where kind_serial='$comm_length' and kind_teacher_id='$teacher_id'";
						$rs_sel=$CONN->Execute($sel);
						if($rs_sel){
							$comm_ins="update comment_kind set kind_name='$comm' where kind_serial='$comm_length'";
							$rs=$CONN->Execute($comm_ins);
							if(!$rs)   print $rs->ErrorMsg();
						}
					}
					else echo "�п�����O�I";
                                        break;
				case 2:
					if($level!=''){
						$sel="select level_teacher_id from comment_level where level_serial='$level' and level_teacher_id='$teacher_id'";
						$rs_sel=$CONN->Execute($sel);
						if($rs_sel){
							$comm_ins="update comment_level set level_name='$comm' where level_serial='$level'";
							$rs=$CONN->Execute($comm_ins);
							if(!$rs)   print $rs->ErrorMsg();
						}
					}
					else echo "�п�ܵ��šI";
                                        break;
				case 3:
					if($comment!=''){
						$sel="select teacher_id from comment where serial='$comment' and teacher_id='$teacher_id'";
						$rs_sel=$CONN->Execute($sel);
						if($rs_sel){
							$comm_ins="update comment set kind='$comm_length',level='$level',comm='$comm' where serial='$comment'";
							$rs=$CONN->Execute($comm_ins);
							if(!$rs)   print $rs->ErrorMsg();
						}
					}
					else echo "�п�ܭn�ק諸���y�I";
					break;
			}
			break;
		case 3:         //�R��
			switch($data){
				case 1:
					if($comm_length!=''){
						$sel="select kind_teacher_id from comment_kind where kind_serial='$comm_length' and kind_teacher_id='$teacher_id'";
						$rs_sel=$CONN->Execute($sel);
						if($rs_sel){
							$comm_del="delete from comment_kind where kind_serial='$comm_length'";
							$rs=$CONN->Execute($comm_del);
							if(!$rs)	print $rs->ErrorMsg(); 
						}
					}
					else echo "�п�����O�I";
					break;
				case 2:
					if($level!=''){
						$sel="select level_teacher_id from comment_level where level_serial='$level' and level_teacher_id='$teacher_id'";
						$rs_sel=$CONN->Execute($sel);
						if($rs_sel){
							$comm_del="delete from comment_level where level_serial='$level'";
							$rs=$CONN->Execute($comm_del);
							if(!$rs)	print $rs->ErrorMsg();
						}
					}
					else echo "�п�ܵ��šI";
					break;
				case 3:
					if($comment!=''){ 
                                                $sel="select teacher_id from comment where serial='$comment' and teacher_id='$teacher_id'";
						$rs_sel=$CONN->Execute($sel);
						if($rs_sel){
							$comm_del="delete from comment where serial='$comment'";
							$rs=$CONN->Execute($comm_del);
							if(!$rs)	print $rs->ErrorMsg();
						}
					}
					else echo "�п�ܭn�R�������y�I";
					break;
			}
			break;
		}
	}
}
?>
