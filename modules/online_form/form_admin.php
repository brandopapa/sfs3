<?php

// $Id: form_admin.php 5909 2010-03-17 02:29:41Z hami $

include "config.php";

sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

if(empty($act))$act="";

if($act=="add"){
	$ofsn=addnew($_SESSION['session_tea_sn']);
	header("location: {$_SERVER['PHP_SELF']}?act=add_step1&ofsn=$ofsn");
}elseif($act=="add_step1"){
	$main=&addForm1($_SESSION['session_tea_sn'],$ofsn);
}elseif($act=="add_step2"){
	$ofsn=add_step1($ofsn,$_SESSION['session_tea_sn'],$newForm);
	if(!empty($ofsn)){
		header("location: {$_SERVER['PHP_SELF']}?act=addForm2&ofsn=$ofsn&n=$n");
	}else{
		trigger_error("�إ߽u�W������ѡI", E_USER_ERROR);
	}
}elseif($act=="add_step3"){
	$result=add_step3($newForm,$ofsn,$col_n,$mode);
	if($result){
		header("location: {$_SERVER['PHP_SELF']}?act=ut_form&ofsn=$ofsn");
	}else{
		//error_msg("�إ߽u�W������ѡI");
	}
}elseif($act=="ut_form"){
	$main=&utfile($ofsn);
}elseif($act=="addForm2"){
	if($n<1)$n=1;
	$main=&addForm2($ofsn,$n);
}elseif($act=="edit_form"){
	$main=&edit_form($ofsn);
}elseif($act=="view_form"){
	$main=&view_form($ofsn);
}elseif($act=="enable_form"){
	able_form($ofsn,'1');
	header("location: {$_SERVER['PHP_SELF']}");
}elseif($act=="unable_form"){
	able_form($ofsn,'0');
	header("location: {$_SERVER['PHP_SELF']}");
}elseif($act=="view_form_result"){
	$main=&view_form_result($ofsn,$mode);
}elseif($act=="del"){
	del_form($ofsn);
	header("location: {$_SERVER['PHP_SELF']}");
}elseif($act=="save_modify"){
	save_modify($ofsn,$_SESSION['session_tea_sn'],$newForm);
	header("location: {$_SERVER['PHP_SELF']}");
}elseif($act=="view_demo"){
	$main=&view_demo();
}elseif($act=="unSign_list"){
	$main=&unSign_list($ofsn);
}elseif($act=="download"){
	$main=download($ofsn,$type);
}elseif($act=="school_sign_form"){
	$main=&view_form($ofsn);
}else{
	del_none();
	$main=&allAskForm($_SESSION['session_tea_sn']);
}

//�q�X����
head("�u�W���");

echo $main;
foot();




//�C�X�������H
function &unSign_list($ofsn){
	global $CONN;

	$f=get_form_data($ofsn);
	$nook=0;


	//��X�Ӷ���D�D�����
	$sql_select="select * from form_col where ofsn=$ofsn";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);
	while($c=$recordSet->FetchRow()){
		$main.="<td valign='top' style='font-size: 9px'>$c[col_title]</td>";
		$colsn[]=$c[col_sn];
		$cf[]=$c[col_function];
		$colchk[]=$c[col_chk];
	}


	//��X�Ҧ��H
	$sql_select="select teacher_sn,name from teacher_base where  teach_condition=0 order by teacher_sn";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);
	while(list($tsn,$teacher_name)=$recordSet->FetchRow()){

		$school_col_v="";
		$unSign=false;
		//��X�Ӯչ���D������
		for($i=0;$i<sizeof($colsn);$i++){
			$col_sn=$colsn[$i];
			$v=get_someone_value($tsn,$col_sn);
			$school_col_v.="<td>$v</td>";
			if(is_null($v) and $colchk[$i]=='1')$unSign=true;
		}


		if($unSign){
			$main2.="
			<tr bgcolor='white'>
			<td style='font-size:12px' nowrap>$teacher_name</td>
			$school_col_v
			</tr>";
			$nook++;
			$unsign_list[]=$teacher_name;
		}
	}
	$school_unsign_list=(is_array($unsign_list))?"<center>����������ơ]�]�t�y����z��쥼�񧹾�^�G $nook ���H�A�Ҧ��W��p�U�G</center><p>".implode("�B",$unsign_list):"";

	$data=(empty($school_unsign_list))?"<p align='center'>�������w��������I</p>".view_form_result($ofsn):"
	$school_unsign_list
	<p>
	<table cellspacing='1' cellpadding='2' align='center' bgcolor='lightGray'>
	<tr bgcolor='#E1E6FF'><td style='font-size:12px'>����H</td>$main</tr>
	$main2
	</table>";

	return $data;
}

//�U��������
function download($ofsn,$type){
	global $CONN,$UPLOAD_URL;
	$use_table_array=array("excel","word","sxw");
	if($type=="excel"){
		$file_type="application/vnd.ms-excel";
		$name2="xls";
	}elseif($type=="word"){
		$file_type="application/vnd.ms-word";
		$name2="doc";
	}elseif($type=="sxw"){
		$file_type="application/vnd.sun.xml.writer";
		$name2="sxw";
	}else{
		$file_type="text/plain";
		$name2="csv";
	}

	$f=get_form_data($ofsn);
	$ok=get_ok_count($ofsn);


	//��X�Ӷ���D�D�����
	$sql_select="select * from form_col where ofsn=$ofsn";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);
	while($c=$recordSet->FetchRow()){
		$main.=(in_array($type,$use_table_array))?"<td>$c[col_title]</td>":"\"".$c[col_title]."\",";
		$colsn[]=$c[col_sn];
		$cf[]=$c[col_function];

	}

	//��X�Ҧ��H
	$sql_select="select teacher_sn,name from teacher_base where  teach_condition=0 order by teacher_sn";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);
	while(list($tsn,$teacher_name)=$recordSet->FetchRow()){

		$school_col_v="";
		//��X�Ӯչ���D������
		for($i=0;$i<sizeof($colsn);$i++){
			$col_sn=$colsn[$i];

			$v=get_someone_value($tsn,$col_sn);

			$school_col_v.=(in_array($type,$use_table_array))?"<td align='center' class='small'>$v</td>":"\"".$v."\",";
		}


		if(in_array($type,$use_table_array)){
			$main2.="<tr><td>$teacher_name</td>$school_col_v</tr>";
		}else{
			$school_col_v=substr($school_col_v,0,-1);
			$main2.="\"".$teacher_name."\",".$school_col_v."\n";
		}
	}



	$filename="SFS3_Sign_".$ofsn."_data.".$name2;
	header("Content-type: ".$file_type.";CHARSET=big5");
	header("Content-Disposition: attachment; filename=$filename");
	if(in_array($type,$use_table_array)){
		echo "<table border='1'>
		<tr bgcolor='yellow'><td>����H</td>$main</tr>
		$main2
		</table>";
	}else{
		echo "\"����H\",".$main."\n".$main2;
	}
	exit;
}


//ok


//�C�X�Ҧ���������
function &allAskForm($teacher_sn=0){
	global $CONN,$today,$school_menu_p;
	$tool_bar=&make_menu($school_menu_p);

	$help_text="�`�N��I�y�R���z���s�@���A�Y��y�T�w�z�A�Ӷ������ƴN�q�q�R���o�I�]�]�A�Ҧ��H��Ӧ��լd�Ҷ�g����ơ^�ҥH�Фp�ߨϥΡC||�ҿסy�����z�N�O��Y�Ӷ�����ʼȰ��_�ӡA�p���A��Ƥ��|�����A���H�K�L�k�A�~�����A��M�A�A���y�ҥΡz�N�S�i�H�~�����F�C";
	$help=&help($help_text,$help_title="��������");

	$sql_select="select * from form_all where teacher_sn=$teacher_sn order by ofsn desc";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);

	while($f=$recordSet->FetchRow()){
		$ofsn=$f[ofsn];

		if($f[enable]=='1' and $today <= $f[of_dead_line]){
			$enableTXT="<font color='#0000FF'>on</font>";
			$enableTool="<a href='{$_SERVER['PHP_SELF']}?act=unable_form&ofsn=$ofsn'>����</a>";
		}else{
			$enableTXT="<font color='#808000'>off</font>";
			$enableTool="<a href='{$_SERVER['PHP_SELF']}?act=enable_form&ofsn=$ofsn'>�ҥ�</a>";
		}
		$ok=get_ok_count($ofsn);

		$alllist.="<tr bgcolor='#FFFFFF'>
		<td nowrap class='small'><a href='{$_SERVER['PHP_SELF']}?act=view_form_result&ofsn=$ofsn'>$f[of_title]</a></td>
		<td align='center' nowrap class='small'>$enableTXT</td>
		<td align='center' nowrap class='small'>$f[of_start_date] - $f[of_dead_line]</td>
		<td align='center' nowrap class='small'><a href='{$_SERVER['PHP_SELF']}?act=school_sign_form&ofsn=$ofsn'>�ݥ~�[</a></td>
		<td align='center' nowrap class='small'><a href='{$_SERVER['PHP_SELF']}?act=edit_form&ofsn=$ofsn'>�ק�</a></td>
		<td align='center' nowrap class='small'>$enableTool</td>
		<td align='center' nowrap class='small'><a href=\"javascript:func($ofsn);\">�R��</a></td>
		<td align='center' nowrap class='small'><a href='{$_SERVER['PHP_SELF']}?act=download&type=csv&ofsn=$ofsn'>csv</a></td>
		<td align='center' nowrap class='small'><a href='{$_SERVER['PHP_SELF']}?act=download&type=excel&&ofsn=$ofsn'>xls</a></td>
		<td align='center' nowrap class='small'><a href='{$_SERVER['PHP_SELF']}?act=download&type=word&&ofsn=$ofsn'>doc</a></td>
		<td align='center' nowrap class='small'>�w��G<a href='{$_SERVER['PHP_SELF']}?act=view_form_result&ofsn=$ofsn'>$ok</a>�A<a href='{$_SERVER['PHP_SELF']}?act=unSign_list&ofsn=$ofsn'>����W��</a></td></tr>\n
		";
	}



	if(empty($alllist)){
		$alllist="<tr bgcolor='#FFFFFF'><td nowrap class='small' colspan=11>�ثe�S�������ơC
		<p>�n���n<a href='form_admin.php?act=add'>�s�W�@�ӽլd��</a>�O�H</p></td></tr>\n";
	}

	$main="
 	<script>
	function func(ofsn){
	var sure = window.confirm('�T�w�n�R���o�g�����ơH�s�P�H�Ҷ񪺸�Ƴ��|�@�çR����I');
	if (!sure) {
	return;
	}

	location.href=\"{$_SERVER['PHP_SELF']}?act=del&ofsn=\" + ofsn;
	}
	</script>
	$tool_bar
	<table width='100%' cellspacing='1' cellpadding='2' bgcolor='#9EBCDD' align='center'>
	<tr bgcolor='#E1E6FF'>
	<td align='center' nowrap class='small'>�W��</td>
	<td align='center' nowrap class='small'>���A</td>
	<td align='center' nowrap class='small'>�_�W�ɶ�</td>
	<td align='center' colspan=4 nowrap class='small'>��������\��</td>
	<td align='center' colspan=3 nowrap class='small'>�U���x�s</td>
	<td align='center' colspan=2 nowrap class='small'>������G</td></tr>
	$alllist
	</table>";




	$all="
	$main
	<table bgcolor='#9EBCDD' cellspacing=0 cellpadding=4>
	<tr bgcolor='#FFFFFF'><td>
	$help
	</td></tr>
	</table>
	";
	return $all;
}


//�x�s�ק�
function save_modify($ofsn,$teacher_sn,$newForm){
	global $CONN;
	add_step1($ofsn,$teacher_sn,$newForm);
	//��X�D��
	$sql_select="select count(*) from form_col where ofsn=$ofsn";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);
	list($n)=$recordSet->FetchRow();
	//��s�����
	for($i=1;$i<=$n;$i++){
		$title=$i."_col_title";
		$text=$i."_col_text";
		$dataType=$i."_col_dataType";
		$value=$i."_col_value";
		$chk=$i."_col_chk";
		$function=$i."_col_function";
		$sort=$i."_col_sort";
		$col_sn=$i."_col_sn";
		add_col2db($ofsn,$newForm[$title],$newForm[$text],$newForm[$dataType],$newForm[$value],$newForm[$chk],$newForm[$function],$newForm[$sort],$newForm[$col_sn]);
	}
	return;
}

//�s�W�Χ�s�@�����A�����]�w�g�J��Ʈw
function add_col2db($ofsn,$title,$text,$dataType,$value,$chk,$function,$sort,$col_sn=0){
	global $CONN;
	if(!empty($col_sn)){
		$str="update form_col set ofsn=$ofsn,col_title='$title',col_text='$text',col_dataType='$dataType',col_value='$value',col_chk='$chk',col_function='$function',col_sort=$sort where col_sn=$col_sn";
	}else{
		$str="INSERT INTO form_col
		(ofsn,col_title,col_text,col_dataType,col_value,col_chk,col_function,col_sort)
		VALUES
		($ofsn,'$title','$text','$dataType','$value','$chk','$function','$sort')";
	}

	$recordSet=$CONN->Execute($str) or die($str);

	if(!empty($recordSet)){
		$ID=(!empty($col_sn))?$col_sn:mysql_insert_id();
	}else{
		trigger_error($str, E_USER_ERROR);
	}
	return $ID;
}


//�R�����إߪ�����
function del_none(){
	global $CONN,$today,$path,$DIR_TNCCENTER;
	$sql_delete="delete from form_all where of_title='�L�D�D' && teacher_sn={$_SESSION['session_tea_sn']}";
	$CONN->Execute($sql_delete) or die($sql_delete);
	return;
}



//�R���Y�@������
function del_form($ofsn){
	global $CONN;
	$str="delete from form_all where ofsn=$ofsn";
	$CONN->Execute($str) or die($str);
	$str="delete from form_col where ofsn=$ofsn";
	$CONN->Execute($str) or die($str);
	$str="delete from form_fill_in where ofsn=$ofsn";
	$CONN->Execute($str) or die($str);
	$str="delete from form_value where ofsn=$ofsn";
	$CONN->Execute($str) or die($str);
	return $ofsn;
}


//���}�@����
function addnew($teacher_sn){
	global $CONN,$today;
	$sql_insert="insert into form_all (of_title,of_start_date,of_dead_line,of_text,teacher_sn,of_date,enable) values('�L�D�D',now(),now(),'',$teacher_sn,now(),'0')";
	$CONN->Execute($sql_insert) or user_error($sql_insert,256);
	$ofsn=mysql_insert_id();
	return $ofsn;
}

//���o�Y�@��������
function get_form_data($ofsn){
	global $CONN;
	$sql_select="select * from form_all where ofsn=$ofsn";
	$recordSet=$CONN->Execute($sql_select) or user_error($sql_select,256);
	$f=$recordSet->FetchRow();
	return $f;
}

//���o������
function get_ok_count($ofsn){
	global $CONN;
	//��X�`��
	$sql_select="select count(*) from form_fill_in where ofsn=$ofsn";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);
	list($ok)=$recordSet->FetchRow();
	return $ok;
}


//�ҥΤ@�Ӷ����
function able_form($ofsn=0,$mode="1"){
	global $CONN;
	$str="update form_all set enable='$mode' where ofsn=$ofsn";
	$recordSet=$CONN->Execute($str) or die($str);
	return false;
}

//�[�ݬY�@��������e���G
function &view_form_result($ofsn=0,$mode=""){
	global $CONN,$UPLOAD_URL;
	$function_name=array("avg"=>"����","sum"=>"�`�p","count"=>"�p��");

	$f=get_form_data($ofsn);
	$ok=get_ok_count($ofsn);
	$sel_year=(empty($_REQUEST[sel_year]))?curr_year():$_REQUEST[sel_year];
	$sel_seme=(empty($_REQUEST[sel_seme]))?curr_seme():$_REQUEST[sel_seme];



	//��X�Ӷ���D�D�����
	$sql_select="select * from form_col where ofsn=$ofsn order by col_sn";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);
	while($c=$recordSet->FetchRow()){
		$main.="<td align='center' class='small'>$c[col_title]</td>";
		$colsn[]=$c[col_sn];
		$cf[]=$c[col_function];
		$col_type[]=$c[col_dataType];
	}

	if($mode=="class"){
		//��X�a�Z���Ѯv
		$sql_select="SELECT p.class_num,t.name,t.teacher_sn FROM teacher_post p , teacher_base t WHERE p.teacher_sn =t.teacher_sn and t.teach_condition =0 order by p.class_num";
	}else{
		//��X�Ҧ��Юv
		$sql_select="select teacher_sn,name from teacher_base where teach_condition=0 order by teacher_sn";
	}

	$recordSet=$CONN->Execute($sql_select) or user_error("���~�T���G",$sql_select,256);
	while($thedata=$recordSet->FetchRow()){
		//�p�G�O�Z�żҦ��A�S���Z�Ū��Ѯv���C�X
		if($mode=="class" and empty($thedata[class_num]))continue;

		$tsn=($mode=="class")?$thedata[teacher_sn]:$thedata[teacher_sn];
		$teacher_name=($mode=="class")?$thedata[name]:$thedata[name];
		$class_name=($mode=="class" and !empty($thedata[class_num]))?class_id2big5($thedata[class_num],$sel_year,$sel_seme):"";

		$school_col_v="";
		//��X�ӱЮv�Ҷ񪺪�����
		for($i=0;$i<sizeof($colsn);$i++){
			$col_sn=$colsn[$i];
			$type = $col_type[$i];
			$v=get_someone_value($tsn,$col_sn);
			if($type=='file')
				$v = "<a href='$UPLOAD_URL".get_store_path()."/".$ofsn."/".$col_sn."/$v'>$v</a>";
			$school_col_v.="<td align='center' class='small'>$v</td>";
		}

		$fill_time = get_someone_time($thedata[teacher_sn], $ofsn);
		$main2.="
		<tr bgcolor='white'><td class='small'>$class_name $teacher_name</td>
		$school_col_v
		<td ' class='small'>$fill_time</td>
		</tr>";
	}

	for($i=0;$i<sizeof($cf);$i++){
		$cfn=$cf[$i];
		$col_sn=$colsn[$i];
		if($cfn=="avg"){
			$cfrv=get_someone_value_avg($col_sn);
		}elseif($cfn=="count"){
			$cfrv=get_someone_value_count($col_sn);
		}elseif($cfn=="sum"){
			$cfrv=get_someone_value_sum($col_sn);
		}else{
			$cfrv="";
		}
		$main3.="<td>$cfrv</td>";
	}

	$mode_sel=($mode=="class")?"<a href='{$_SERVER[PHP_SELF]}?act=view_form_result&ofsn=$ofsn'>�������Юv�Ҧ�</a>":"<a href='{$_SERVER[PHP_SELF]}?act=view_form_result&ofsn=$ofsn&mode=class'>�������Z�żҦ�</a>";

	$data="
	<center>����ơG�w�� $ok �H��������C<p>
	$mode_sel
	</center>
	<table cellspacing='1' cellpadding='2' align='center' bgcolor='lightGray'>
	<tr bgcolor='#E1E6FF'><td align='center' class='small'>�D�ءG</td>$main<td>����ɶ�</td></tr>
	<tr bgcolor='yellow'><td align='center' class='small'>�J��\��</td>$main3<td></td></tr>
	$main2
	</table>";
	return $data;
}



//�ĤG�B�J�����
function &addForm2($ofsn,$n,$mode=""){
	global $CONN,$teacher_sn,$today;

	$title="�إ߱�������]�B�J�G�^";
	for($i=1;$i<=$n;$i++){
		$col.=get_col($i)."<hr>";
	}

	if(empty($mode))$mode="insert";



	$main="
	<form action='{$_SERVER['PHP_SELF']}' method='post'>
	$title
	$col
	<p>
	<input type='hidden' name='mode' value='$mode'>
	<input type='hidden' name='col_n' value='$n'>
	<input type='hidden' name='ofsn' value='$ofsn'>
	<input type='hidden' name='act' value='add_step3'>
	<center><input type='submit' value='�U�@�B'></center>
	</form>
	�����G
	<ul>
	<li>�y���D�z�G�N�O�z�n�ݪ����D�C
	<li>�y�w�]�ȡz�G�i�b����줤�w����J�@�ӹw�]�ȡC�]�D�����^
	<li>�y�����z�G�U�@��쪺��g�������ɡA�i�H�g�W�����C�]�D�����^
	<li>�y���D����z�G���\�ର�w�]�\��A�|�������C
	<li>�y�񵪫��A�z�G��g���ת���ƫ��A�C�]��ĳ��g�^
	<li>�y�J��\��z�G���\��|��Ҧ����񵪵��G�J��_�ӡA�Y�O�z��ܡy�[�`�z�A����t�η|���z����D���Ҧ�������G���[�`�C
	�Y��ܡy�p�ơz�h�|�p��C�ӵ��שҶ�g���H�ơC�]�D�����^
	</ul>
	<hr>
	�p�ޥ��G
	<ul>
	<li>�i���i�H����񵪶��ءH<p>
	�i�H�I�i�H�Q�Ρy�ﶵ�z����쫬�A�A������̿ﵪ�C
	<br>�@�k�G
	<ol>
	<li>�b�y�񵪫��A�z��ܡy�ﶵ�z�C
	<li>�M��b�y�񵪹w�]�ȡz���i�H��J�z���ﶵ�A�ﶵ�Ρy;�z�]�b�Τ����^�j�}�Y�i�C
	<li>�Ҧp�G�y�ժ�;�D��;�@��Юv;�N�ұЮv�z�o�˴N�|���ͥ|�ӿﶵ������D�C
	</ol>
	</ul>

	";
	return $main;
}


//�إ߷s����ݨ������
function &addForm1($teacher_sn,$ofsn,$mode=""){
	global $CONN,$login_user,$today,$school_menu_p;
	$f=array();

	if($mode=="modify"){
		$f=get_form_data($ofsn);
		$pt="�ק�u�W���";
		$col_num="";
		$enable_v="1";
		$act_v="save_modify";
		$form1="";
		$form2="";
	}else{
		$pt="�B�J�@�G�إߤ@�Ӷ���ݨ�";
		$col_num="
		<tr bgcolor='#FFFFFF'>
		<td align='right' nowrap>���ơG</td><td>
		<input type='text' name='n' class='tinyBorder' size=2> �D�]�]�N�O�n������D�ة���즳�X�ӡH�^
		</td>
		</tr>";
		$enable_v="0";
		$act_v="add_step2";
		$form1="<form action='{$_SERVER['PHP_SELF']}' method='post'>";
		$form2="<center><input type='submit' value='�U�@�B'></center></form>";
	}
	$tool_bar=&make_menu($school_menu_p);
	$main="
	$tool_bar
	<table bgcolor='#9EBCDD' cellspacing='1' cellpadding='4'>
	<tr bgcolor='#CDD5FF'><td colspan='2'>$pt</td></tr>
	$form1
	<tr bgcolor='#FFFFFF'>
	<td align='right'>����W�١G</td>
	<td colspan='5'><input type='text' name='newForm[of_title]' size='50' class='tinyBorder' value='".$f["of_title"]."'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
	<td align='right'>��������G</td>
	<td><textarea cols='40' rows='6' name='newForm[of_text]' class='tinyBorder' style='width:100%'>$f[of_text]</textarea></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
	<td align='right' nowrap>
	�������G</td><td>�q <input type='text' name='newForm[of_start_date]' value='$today' size='10' maxlength='10' class='tinyBorder'>
	�_�A�� <input type='text' name='newForm[of_dead_line]' size='10' maxlength='10' class='tinyBorder' value='$f[of_dead_line]'> ��</td>
	</tr>
	$col_num
	</table><p>
	<input type='hidden' name='newForm[enable]' value='$enable_v'>
	<input type='hidden' name='act' value='$act_v'>
	<input type='hidden' name='ofsn' value='$ofsn'>
	$form2
	";
	return $main;
}

//�إ߶���򥻸��
function add_step1($ofsn,$teacher_sn,$newForm=""){
	global $CONN;
	$sql_update="update form_all set of_title='$newForm[of_title]',of_start_date='$newForm[of_start_date]',of_dead_line='$newForm[of_dead_line]',of_text='$newForm[of_text]',teacher_sn=$teacher_sn,of_date=now(),enable='$newForm[enable]' where ofsn=$ofsn";
	$CONN->Execute($sql_update) or die($sql_update);
	return $ofsn;
}


//���]�w
function &get_col($n=0,$c=""){

	if(isset($c) and !empty($c)){
		$checked_1=($c[col_chk]=='1')?"checked":"";
		$checked_0=($c[col_chk]=='0')?"checked":"";
		$selected_varchar=($c[col_dataType]=='varchar')?"selected":"";
		$selected_int=($c[col_dataType]=='int')?"selected":"";
		$selected_date=($c[col_dataType]=='date')?"selected":"";
		$selected_bool=($c[col_dataType]=='bool')?"selected":"";
		$selected_file=($c[col_dataType]=='file')?"selected":"";
		$selected_sum=($c[col_function]=='sum')?"selected":"";
		$selected_avg=($c[col_function]=='avg')?"selected":"";
		$selected_count=($c[col_function]=='count')?"selected":"";
	}else{
		$checked_1="checked";
		$checked_0="";
		$selected_varchar="";
		$selected_int="";
		$selected_date="";
		$selected_bool="";
		$selected_file="";
		$selected_sum="";
		$selected_avg="";
		$selected_count="";
	}

	$main="
	<table width='96%' border='0' cellspacing='0' cellpadding='3' align='center' bgcolor='#123456'>
	<tr bgcolor='white'>
	<td align='right' bgcolor='#FBD08F'>���D $n �G</td>
	<td bgcolor='#FBD08F'>
	<input type='text' name='newForm[".$n."_col_title]' value='$c[col_title]' size='30' class='tinyBorder'>
	</td>
	<td align='right' nowrap>�w�]�ȡG</td>
	<td><input type='text' name='newForm[".$n."_col_value]' value='$c[col_value]' class='tinyBorder' size=15></td>
	</tr>
	<tr bgcolor='white'>
	<td colspan='2' rowspan='3'>�����G�]�i�ٲ��^<br>
	<textarea cols='20' rows='2' name='newForm[".$n."_col_text]' class='tinyBorder' style='width:100%'>$c[col_text]</textarea></td>
	<td align='right' nowrap>���D����H</td><td>
	<input type='radio' name='newForm[".$n."_col_chk]' value='1' $checked_1>�O
	<input type='radio' name='newForm[".$n."_col_chk]' value='0' $checked_0>�_
	</td>
	</tr>
	<tr bgcolor='white'>
	<td align='right' nowrap>
	�񵪫��A�G</td><td>
	<select name='newForm[".$n."_col_dataType]'>
	<option value='varchar' $selected_varchar>��r</option>
	<option value='int' $selected_int>�Ʀr</option>
	<option value='date' $selected_date>���</option>
	<option value='bool' $selected_bool>�ﶵ</option>
	<option value='file' $selected_file>�ɮ�</option>
	</select>
	</td>
	</tr>
	<tr bgcolor='white'>
	<td align='right' nowrap>�J��\��</td><td>
	<select name='newForm[".$n."_col_function]'>
	<option value=''>�L</option>
	<option value='sum' $selected_sum>�[�`</option>
	<option value='avg' $selected_avg>����</option>
	<option value='count' $selected_count>�p��</option>
	</select>
	</td>
	</tr>
	<input type='hidden' name='newForm[".$n."_col_sn]' value=$c[col_sn]>
	<input type='hidden' name='newForm[".$n."_col_sort]' value=$n>
	</table>
	";
	return $main;
}



//�ĤT�B�J
function add_step3($newForm,$ofsn,$col_n,$mode="update"){
	global $CONN;
	for($i=1;$i<=$col_n;$i++){
		$title=$i."_col_title";
		$text=$i."_col_text";
		$dataType=$i."_col_dataType";
		$value=$i."_col_value";
		$chk=$i."_col_chk";
		$function=$i."_col_function";
		$sort=$i."_col_sort";

		$a=$i."_col_title";
		if(!empty($newForm[$a])){
			if($mode=="insert"){
				$main=add_col2db($ofsn,$newForm[$title],$newForm[$text],$newForm[$dataType],$newForm[$value],$newForm[$chk],$newForm[$function],$newForm[$sort]);
			}elseif($mode=="update"){
				$main=add_col2db($newForm[$ofsn],$newForm[$title],$newForm[$text],$newForm[$dataType],$newForm[$value],$newForm[$chk],$newForm[$function],$newForm[$sort],$newForm[$col_sn]);
			}
		}
	}

	return $main;
}

//�W�[����
function &utfile($ofsn){

	//���o�Ӷ����ƪ����[��
	$allfile =& getFormFile("ofsn",$ofsn);
	able_form($ofsn,'1');

	$title="�W�Ǫ���]�B�J�T�^";
	$main="
	<script language='JavaScript'>
	function upload(){
		strFeatures = 'top=150,left=150,width=400,height=50,toolbar=0,menubar=0,location=0,directories=0,status=0';
		window.open('upload.php?col_name=ofsn&col_sn=$ofsn','upload',strFeatures);
		window.name = 'opener';
	}
	</script>
	$title
	<table border='0' cellspacing='0' cellpadding='4' align='center'>
	<tr>
		<td align='right' nowrap>���L�����ɡG<br>
		<input type='button' value='�s�W����' class='tinyBorder' onClick='upload()'>
		<input type='button' value='����' onClick='window.location.href=\"{$_SERVER['PHP_SELF']}\"'>

		</td><td>
		$allfile
		</td>
	</tr>
	</table><p>
	";
	return $main;
}


//�s��Y�@������
function &edit_form($ofsn){
	global $CONN,$today,$path,$DIR_TNCCENTER;
	$main=&addForm1($_SESSION['session_tea_sn'],$ofsn,"modify");
	//���o���D�Ҧ�������

	$sql_select="select * from form_col where ofsn=$ofsn order by col_sort";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);
	while($c=$recordSet->FetchRow()){
		$col.=get_col($c[col_sort],$c);
	}
	$all="
	<form action='{$_SERVER['PHP_SELF']}' method='POST'>
	$main
	$col
	<center><input type='submit' value='�ק粒��'></center>
	</form>
	";
	return $all;
}





//�d��
function &view_demo(){
	global $school_menu_p;
	$tool_bar=&make_menu($school_menu_p);
	$main="

	$tool_bar
	<table cellspacing=1 cellpadding=4 bgcolor='#9EBCDD'>
	<tr><td>�s�W�@�ӽլd��</td></tr>
	<tr><td><img src='images/demo1.png' width=471 height=125 border=1><p>&nbsp;</td></tr>
	<tr><td>��g��������T��</td></tr>
	<tr><td><img src='images/demo2.png' width=536 height=303 border=1><p>&nbsp;</td></tr>
	<tr><td>�]�w�U�����</td></tr>
	<tr><td><img src='images/demo3.png' width=629 height=427 border=1><p>&nbsp;</td></tr>
	<tr><td>�Y������i�H���y�s�W����z�A�Y�O�S��������y�����z�Y�i�C</td></tr>
	<tr><td><img src='images/demo4.png' width=440 height=86 border=1><p>&nbsp;</td></tr>
	<tr><td>�W�Ǫ�����y�s���z��X�z�n�W�Ǫ��ɮקY�i�A�W�Ǫ���Ƥ����C</td></tr>
	<tr><td><img src='images/demo5.png' width=409 height=140 border=1><p>&nbsp;</td></tr>
	<tr><td>�s�W��A�s�������T�|�X�{�b�޲z�������C</td></tr>
	<tr><td><img src='images/demo6.png' width=656 height=66 border=1><p>&nbsp;</td></tr>
	<tr><td>�Юv�n�J�ǰȨt�Ψt�Ϋ�|�ߧY�ݨ�����T�C</td></tr>
	<tr><td><img src='images/demo7.png' width=464 height=232 border=1><p>&nbsp;</td></tr>
	<tr><td>�Юv����ɪ��e���G</td></tr>
	<tr><td><img src='images/demo8.png' width=620 height=422 border=1><p>&nbsp;</td></tr>
	<tr><td>�����A������G�|�ߧY���ܡA�e�{�X�H�w�g����F�C</td></tr>
	<tr><td><img src='images/demo9.png' width=654 height=72 border=1><p>&nbsp;</td></tr>
	<tr><td>�i�H�[�ݸԲӪ�������G</td></tr>
	<tr><td><img src='images/demo10.png' width=642 height=266 border=1><p>&nbsp;</td></tr>
	<tr><td>�]�i�H��X���٨S����C</td></tr>
	<tr><td><img src='images/demo11.png' width=628 height=268 border=1><p>&nbsp;</td></tr>
	</tr></table>
	";
	return $main;
}

?>
