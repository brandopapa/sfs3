<?php

// $Id: scorecard_setup.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�]�w�� */
include "config.php";

sfs_check();


if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}


//����ʧ@�P�_
if($act=="add"){
	add_col($C);
	header("location: {$_SERVER['PHP_SELF']}");
}elseif($act=="update"){
	update_col($C,$interface_sn);
	header("location: {$_SERVER['PHP_SELF']}?interface_sn=$interface_sn");
}elseif($act=="view"){
	$main=view($interface_sn);
}elseif($act=="�^�_�w�]��"){
	$main=clear_html($interface_sn);
	header("location: {$_SERVER['PHP_SELF']}?interface_sn=$interface_sn");
}else{
	$main=&main_form($interface_sn);
}


//�q�X����
head("���Z�檩���]�w");
echo $main;
foot();


//�D�n����
function &main_form($interface_sn=""){
	global $input_kind,$school_menu_p;

	$tool_bar=&make_menu($school_menu_p);

	if(empty($interface_sn)){
		//�Ҧ��{�s�˪O
		$get_sc_list=&get_sc_list("text");
		$main="
		$tool_bar
		<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4><tr bgcolor='#FFFFFF'><td valign='top'>
		�п�ܤ@�Ӧ��Z��˪O�G<p>
		$get_sc_list
		</td></tr></table>";
		return $main;
		exit;
	}

	//���o�Ӽ˪O���
	$C=&get_sc($interface_sn);

	//�Ҧ��{�s�˪O
	$get_sc_list=&get_sc_list();

	$submit=(!empty($interface_sn))?"�x�s�ק�":"�s�W";
	$submit_act=(!empty($interface_sn))?"update":"add";

	
	if(empty($C[html])){
		$data=&make_templeat($interface_sn);
		$ssdata=&make_ss_templeat($interface_sn);
		$ssdata_title=&make_ss_templeat($interface_sn,"title");

		$textarea_html="<table cellspacing=0 cellpadding=0>\n<tr><td>\n<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4 width='100%'>\n$data\n</table>\n</td></tr><tr><td>\n<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>\n<tr bgcolor='#C4D9FF'>\n<td>���</td>\n$ssdata_title\n<!--���B�|�۰ʥ[�J�U��y�M��ج������z���]�w-->\n</table>\n</td></tr></table>";
		$ss_textarea_html=$ssdata;

	}else{
		$textarea_html=$C[html];
		$ss_textarea_html=$C[sshtml];
	}

	$show_html=&html2code($interface_sn,$textarea_html,$ss_textarea_html,"",true);


	$checked_y=($C[all_ss]=='y')?"checked":"";
	$checked_n=($C[all_ss]=='n' or empty($C[all_ss]))?"checked":"";

	$main="
	<script language=\"JavaScript\">
	function OpenWindow()
	{
	alert(\"�Юv��g���Z��ɡA���U�����s�|�X�{���ת���g���U�u��C\");
	}
	</script>
	$tool_bar
	<table cellspacing=0 cellpadding=0><tr><td valign='top'>
		<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
		<tr class='small' bgcolor='#FFFFFF'>
		<form action='{$_SERVER['PHP_SELF']}' method='post'>
		<td><font size=3 color='#D06030'>".$C[title]."�G</font><p><font color='#865992'>".nl2br($C[text])."</font>
		</td></tr><tr class='small' bgcolor='#EBEBEB'><td>
		<p>�п�J�������һy�k�G</p>
		<textarea cols='60' rows='10' name='C[html]' class='small' style='width:100%'>".htmlspecialchars($textarea_html)."</textarea><br>
		<p>�M��ج����������һy�k�G�]�u�n&lt;tr>&lt;/tr>�o�@�q�Ӥw�^</p>
		<textarea cols='60' rows='10' name='C[sshtml]' class='small' style='width:100%'>".htmlspecialchars($ss_textarea_html)."</textarea><br>
		</td></tr>
		<tr class='small' ><td valign='top'>
		���Z��۰ʦC�X��ؼҦ��G<input type='radio' name='C[all_ss]' value='y' $checked_y> �C�X�Ҧ�����<input type='radio' name='C[all_ss]' value='n' $checked_n>�ȦC�X���
		<input type='hidden' name='act' value='$submit_act'>
		<input type='hidden' name='interface_sn' value='$interface_sn'>
		<p><input type='submit' value='$submit'><input type='submit' name='act' value='�^�_�w�]��'></p>
		</td></tr>
		</form>
		</table>
	</td><td valign='top'>$get_sc_list</td></tr>
	</table><br>
	�Юv��g���w���G<br>
	$show_html
	";
	return $main;
}

//�s�W�@�ӳ]�w
function add_col($C){
	global $CONN;
	$sql_insert = "insert into score_input_interface (title,text,html,sshtml,all_ss) values ('$C[title]','$C[text]','$C[html]','$C[sshtml]','$C[all_ss]')";
	if($CONN->Execute($sql_insert))	return mysql_insert_id();
	die($sql_insert);
	return  false;
}

//��s�@�ӳ]�w
function update_col($C,$interface_sn){
	global $CONN;
	$sql_update = "update score_input_interface set html='$C[html]',sshtml='$C[sshtml]',all_ss='$C[all_ss]' where interface_sn=$interface_sn";
	if($CONN->Execute($sql_update))	return;
	die($sql_update);
	return  false;
}

//�M��HTML�]�w
function clear_html($interface_sn){
	global $CONN;
	$sql_update = "update score_input_interface set html='',sshtml='' where interface_sn=$interface_sn";
	if($CONN->Execute($sql_update))	return;
	die($sql_update);
	return  false;
}

//���o�M��صL�������˪O�X
function &make_templeat($interface_sn){
	global $CONN,$input_kind;

	$sql_select = "select *  from score_input_col where interface_sn=$interface_sn and col_ss='n'";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);

	while($C=$recordSet->FetchRow()){
		$template="{".$C[col_sn]."_��J��}";
		$data.="<tr bgcolor='white'>\n<td>$C[col_text]</td><td>$template</td>\n</tr>\n";
	}
	return $data;
}

//���o�M��ئ��������˪O�X
function &make_ss_templeat($interface_sn,$get_what=""){
	global $CONN,$input_kind;

	$sql_select = "select *  from score_input_col where interface_sn=$interface_sn and col_ss='y'";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);

	while($C=$recordSet->FetchRow()){
		$template=($get_what=="title")?$C[col_text]:"{".$C[col_sn]."_��J��}";
		$data.="<td>$template</td>\n";
	}
	$main=($get_what=="title")?$data:"<tr bgcolor='white'>\n<td>{��ئW��}</td>\n$data</tr>\n";
	return $main;
}


?>
