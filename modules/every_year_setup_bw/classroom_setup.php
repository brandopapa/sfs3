<?php

// $Id: classroom_setup.php 7705 2013-10-23 08:58:49Z smallduh $

/* ���o�򥻳]�w�� */
require_once "config.php";
require_once "../../include/sfs_oo_zip2.php";
require_once "../../include/sfs_case_PLlib.php";
include ("$SFS_PATH/include/sfs_oo_overlib.php");

$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

//$CONN->debug = true;
sfs_check();

if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($year_seme)){
	$ys=explode("-",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

//���~�]�w
if($error==1){
	$act="error";
	$error_title="�L�~�ũM�Z�ų]�w";
	$error_main="�䤣��� ".$sel_year." �Ǧ~�סA�� ".$sel_seme." �Ǵ����~�šB�Z�ų]�w�A�G�z�L�k�ϥΦ��\��C<ol><li>�Х���y<a href='".$SFS_PATH_HTML."modules/every_year_setup/class_year_setup.php'>�Z�ų]�w</a>�z�]�w�~�ťH�ίZ�Ÿ�ơC<li>�H��O�o�C�@�Ǵ����Ǵ��X���n�]�w�@����I</ol>";
}

//����ʧ@�P�_
if($act=="error"){
	$main=&error_tbl($error_title,$error_main);
}elseif($act=="save"&&$room_id){
	save_room_table($sel_year,$sel_seme,$room_id,$set_id);
	$to=($go_on!="view_room")?"list_room_table":$go_on;
	header("location: {$_SERVER['PHP_SELF']}?act=$to&sel_year=$sel_year&sel_seme=$sel_seme&room_id=$room_id");
}elseif(($act=="list_room_table" or $act=="�}�l�]�w")&&$room_id){
	$act="list_room_table";
	$main=&list_room_table($sel_year,$sel_seme,$room_id);
}elseif(($act=="view_room" or $act=="�[�ݳ]�w")&&$room_id){
	$act="view_room";
	$main=&list_room_table($sel_year,$sel_seme,$room_id,"view");
}elseif($act=="�R���Ы�"&&$room_id){
	$main=del_classroom($room_id);
	header("location: {$_SERVER['PHP_SELF']}");
}elseif($act=="�ק�Ы�"&&$room_id){
	$main=edit_classroom($room_id,$room_name,$enable,$notfree_time);
	header("location: {$_SERVER['PHP_SELF']}");
}elseif($act=="�W�[�Ы�"&&$room_name){
	$main=add_classroom($room_name,$enable,$notfree_time);
	header("location: {$_SERVER['PHP_SELF']}");
}elseif($act=="���s�]�w"){
	$query = "delete from score_course where year=$sel_year and semester=$sel_seme and class_id='$class_id'";
	$CONN->Execute($query) or trigger_error("SQL ���~!! $query",E_USER_ERROR);
	header("location: {$_SERVER['PHP_SELF']}?act=view_class&sel_year=$sel_year&sel_seme=$sel_seme&class_id=$class_id");
}elseif($act=="downlod_ct"){	
	downlod_ct($class_id,$sel_year,$sel_seme);
	header("location: {$_SERVER['PHP_SELF']}?act=view_class&sel_year=$sel_year&sel_seme=$sel_seme&class_id=$class_id");
}else{
	$main=&room_form($sel_year,$sel_seme,$room_id);
}


//�q�X����
head("�M��Ыǳ]�w");
echo $main;
foot();

/*
�禡��
*/

//�򥻳]�w���
function &room_form($sel_year,$sel_seme,$room_id){
	global $CONN,$school_menu_p,$act;
	
	//���o�~�׻P�Ǵ����U�Կ��
	$date_select=&class_ok_setup_year($sel_year,$sel_seme,"year_seme","jumpMenu_seme");
	//�M��Ыǿ��
	$room_select=&select_room($sel_year,$sel_seme,"room_id",$room_id);
	
        $sql_select = "select * from spec_classroom where room_id='$room_id' ";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	@list($room_id,$room_name , $enable ,$notfree_time)= $recordSet->FetchRow() ;
	if ($enable) 
	   $chk_str = 	"<input name='enable' type='checkbox' value='1' checked>�}��w�� " ; 
	else 
	   $chk_str = 	"<input name='enable' type='checkbox' value='1' >�}��w��" ; 
	      
	//����
	$help_text="
	�п�ܤ@�ӾǦ~�B�Ǵ��H���]�w�C||
	<span class='like_button'>�}�l�]�w</span>�|�}�l�i��ӾǦ~�Z�ŽҪ��M��ЫǪ��]�w�C||
	<span class='like_button'>�[�ݳ]�w</span>�|�C�X�ӾǦ~�Ǵ��Z�ŽҪ��M��ЫǪ��]�w�C||
	<span class='like_button'>�s�W�Ы�</span>�|�N�z��J���ЫǦW�W�[��M��ЫǦC���C||
	<span class='like_button'>�ק�Ы�</span>�|�N�z�ҿ諸�M��Ыǰ����e�ק�C||
	���}��`���H�r�������j(�p11,13 -->��ܬP���@��1,3�`���}��w��)�C||
	���׸`���N����0�F�ȥ�`���N����100�C
	";
	$help=&help($help_text);

	$tool_bar=&make_menu($school_menu_p);

	$main="
	<script language='JavaScript'>
	function jumpMenu_seme(){
		if(document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value!=''){
			location=\"{$_SERVER['PHP_SELF']}?act=$act&year_seme=\" + document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value;
		}
	}
	</script>
	$tool_bar
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<tr bgcolor='#FFFFFF'><td>
		<table>
		<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
  		<tr><td>�п�ܱ��]�w���Ǧ~�סG</td><td>$date_select</td></tr>
		<tr><td>�п�ܱ��]�w���M��ЫǡG</td><td>$room_select</td></tr>
		<tr bgcolor='#DDDDDD' ><td align='right'>�s�W�B�R���έק�--�ЫǦW�١G<br>���}��`���G</td><td><input type='text' name='room_name'  value= '$room_name' size='16'>$chk_str<br>
                                 <input type='text' name='notfree_time' size='40' value='$notfree_time' ></td></tr>		
		<tr><td colspan='2'><input type='submit' name='act' value='�}�l�]�w'>
		<input type='submit' name='act' value='�W�[�Ы�'>
		<input type='submit' name='act' value='�R���Ы�'>
		<input type='submit' name='act' value='�ק�Ы�'>
		</td></tr>
		</form>
		</table>
	</td></tr>
	</table>
	<br>
	$help
	";
	return $main;
}

//�C�X�Y�ӱM��ЫǪ��Ҫ�
function &list_room_table($sel_year,$sel_seme,$room_id="",$mode=""){
	global $CONN,$class_year,$conID,$weekN,$school_menu_p,$go_on,$SFS_PATH_HTML,$all_ss_arr;

	//���o�Ǧ~
	$semester_name=($sel_seme=='2')?"�U":"�W";
	$date_text="<font color='#607387'>
	<font color='#000000'>$sel_year</font> �Ǧ~
	<font color='#000000'>$semester_name</font>�Ǵ�
	</font>
	<input type=hidden name=sel_year value='$sel_year'>
	<input type=hidden name=sel_seme value='$sel_seme'>
	";

	//�C�g�����
	$dayn=sizeof($weekN)+1;

	//���o�M��ЫǦW
	$room_name=get_classroom_name($room_id);

	//���o�Ҧ��ҵ{
	$all_ss_arr=get_all_ssname($sel_year,$sel_seme);

	//��X�Y�M��ЫǪ��Ҧ��ҵ{
	$sql_select = "select class_id,course_id,teacher_sn,day,sector,ss_id,room from score_course where year='$sel_year' and semester='$sel_seme' and room='$room_name' order by day,sector";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	while (list($class_id,$course_id,$teacher_sn,$day,$sector,$ss_id)= $recordSet->FetchRow()) {
		$k=$day."_".$sector;
		$a[$k]=$course_id;
		$b[$k]=$teacher_sn;
		$c[$k]=$class_id;
		$s[$k]=$ss_id;
	}

	//���o�P�����@�C
	for ($i=1;$i<=count($weekN); $i++) {
		$main_a.="<td align='center' >�P��".$weekN[$i-1]."</td>";
	}
	
	//���o�Ҹճ]�w�����̰��`��
	$query="select max(sections) from score_setup where year='$sel_year' and semester='$sel_seme'";
	$res=$CONN->Execute($query);
	$sections=$res->fields[0];
	if($sections==0) trigger_error("�Х��]�w $sel_year �Ǧ~ $sel_seme �Ǵ� [���Z�]�w]����,�A�ާ@�Ҫ�]�w<br><a href=\"$SFS_PATH_HTML/modules/every_year_setup/score_setup.php\">�i�J�]�w</a>",E_USER_ERROR);

	if(!empty($room_id)){

		//���o�Юv�}�C
		$tea_temp_arr = my_teacher_array();

		//���o�Z�Ű}�C
		$class_name=get_class_name($sel_year,$sel_seme,"");

		//�s�@���o�M��Ыǿ��
		$room_list=&select_room($sel_year,$sel_seme,"room_id",$room_id);
			
		//�s�W�@�ӤU�Կ����
		$room_select = new drop_select();
			
		$def_color = $color;
		//���o�Ҫ�
		for ($j=1;$j<=$sections;$j++){

			if ($j==5){
				$all_class.= "<tr bgcolor='white'><td colspan='$dayn' align='center'>�ȥ�</td></tr>\n";
			}

			$all_class.="<tr bgcolor='#E1ECFF'><td align='center'>$j</td>";

			//�C�L�X�U�`			
			for ($i=1;$i<=count($weekN); $i++) {
				$k2=$i."_".$j;

				//��ت��U�Կ��
				$room_select->s_name="set_id[$k2]";
				$room_select->id=$a[$k2];
				$room_select->arr=get_course_arr($sel_year,$sel_seme,$room_id,$k2);
				$room_sel=$room_select->get_select();
				$color=(empty($a[$k2]))?$def_color:"#F5E5E5";
				$class_sel=(empty($a[$k2]))?"":"<fieldset><legend><font color='#aaaaaa'>�ثe�]�w</font></legend><font color='#aaaaaa'>�Z��:</font><font color='red'>".$class_name[$c[$k2]]."</font>";
				$subject_sel=(empty($a[$k2]))?"":"<font color='#aaaaaa'>���:</font><font color='green'>".$all_ss_arr[$s[$k2]]."</font>";
				$teacher_sel=(empty($a[$k2]))?"":"<font color='#aaaaaa'>�Юv:</font><font color='blue'>".$tea_temp_arr[$b[$k2]]."</font></fieldset>";
				
				//�C�@��
				$debug_str=($debug)?"<small><font color='#aaaaaa'>-".$a[$k2]."</font></small><br>":"";
				$all_class.="<td $align bgcolor='$color'>
				$room_sel<br><small>$class_sel<br>$subject_sel<br>$teacher_sel<br>$debug_str</small>
				</td>\n";
			

			}

			$all_class.= "</tr>\n" ;
		}

		$submit=($mode=="view")?"
		<input type='hidden' name='act' value='list_room_table'>
		<input type='submit' value='�ק�]�w'>":"
		<input type='hidden' name='act' value='save'>
		<input type='submit' value='�x�s�]�w'>";

		//�ӯZ�Ҫ�
		$main_class_list="
		<form action='{$_SERVER['PHP_SELF']}' method='post'>
		<tr bgcolor='#E1ECFF'><td align='center'>�`</td>$main_a</tr>
		$all_class
		<tr bgcolor='#E1ECFF'><td colspan='6' align='center'>
		<input type='hidden' name='sel_year' value='$sel_year'>
		<input type='hidden' name='sel_seme' value='$sel_seme'>
		<input type='hidden' name='room_id' value='$room_id'>
		$submit
		</td></tr>
		";
	}else{
		$main_class_list="";
	}
	
	$tool_bar=&make_menu($school_menu_p);
	
	$checked=($go_on=="view_class")?"checked":"";
		
	$url_str =$SFS_PATH_HTML.get_store_path()."/sel_class.php";

	$main="
	$tool_bar
	<table cellspacing=0 cellpadding=0><tr><td>
		<table border='0' cellspacing='1' cellpadding='4' bgcolor='#9EBCDD'>
		<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
		<input type='hidden' name='go_on' value='$go_on'>
		<input type='hidden' name='act' value='list_room_table'>
		<tr><td colspan='6' nowrap bgcolor='#FFFFFF'>
		$date_text �A $room_list &nbsp;&nbsp;
		</tr>
		</form>
		$main_class_list
		</table>
	</td>
	<td valign='top' class='small' align='center'>
	$submit
	<p>
	$set_class_teacher
	</p>
	</td>
	</tr></table></form>
	";
	return  $main;
}

//�x�s�M��Ыǳ]�w
function save_room_table($sel_year="",$sel_seme="",$room_id="",$set_id=""){
	global $CONN;
	$room_name=get_classroom_name($room_id);
	while(list($k,$v)=each($set_id)){
		$kk=explode("_",$k);
		$day=$kk[0];
		$sector=$kk[1];

		//�����o�ݬݦ��L�ҵ{
		$c=get_course($sel_year,$sel_seme,"",$day,$sector,$room_name);

		//���p�S���ҵ{��ơA��Ʈw���]�L�ӽҵ{�A������L
		if(empty($set_id[$k]) and empty($c[course_id]))continue;
		
		if(empty($c[course_id])){
			add_room($v,$room_name);
		}else{
			update_room($c[course_id],$v,$room_name);
		}
	}
	return ;
}

//�x�s�@���Ыǳ]�w�]�@�Z�@�Ѫ��Y�@�`�^
function add_room($course_id="",$room_name=""){
	global $CONN;
	$sql_insert = "update score_course set room='$room_name' where course_id='$course_id'";
	if($CONN->Execute($sql_insert))	return true;
	die($sql_insert);
	return false;
}

//��s�@���Ыǳ]�w�]�@�Z�@�Ѫ��Y�@�`�^
function update_room($old_id="",$course_id="",$room_name=""){
	global $CONN;
	$sql_delete = "update score_course set room='' where course_id='$old_id'";
	$CONN->Execute($sql_delete) or die($sql_delete);
	$sql_update = "update score_course set room='$room_name' where course_id='$course_id'";
	if($CONN->Execute($sql_update))	return true;
	die($sql_update);
	return false;
}

//���o�M��ЫǦW
function get_classroom_name($room_id=""){
	global $CONN;
	$query="select room_name from spec_classroom where enable='1' and room_id='$room_id' order by room_id";
	$res=$CONN->Execute($query);
	$room_name=$res->fields[room_name];
	return $room_name;
}



//���o�Ҧ��ҵ{�]�w
function get_all_ssname($sel_year="",$sel_seme=""){
	global $CONN;
	$subject_name_arr=get_subject_name_arr();
	$sql_select="select class_year,ss_id,scope_id,subject_id from score_ss where year='$sel_year' and semester='$sel_seme' and enable='1' order by class_year,sort,sub_sort";
	$res = $CONN->Execute($sql_select) or trigger_error("SQL ���~ $sql_select",E_USER_ERROR);
	while(!$res->EOF){
		$scope_id = $res->fields[scope_id];
		$subject_id = $res->fields[subject_id];
			$subject_name= $subject_name_arr[$subject_id][subject_name];
		if (empty($subject_name))
			$subject_name= $subject_name_arr[$scope_id][subject_name];
		$all_ss_arr[$res->fields[ss_id]] = $subject_name;
		$res->MoveNext();
	}
	return $all_ss_arr;
}

//���o�Y�@���ҵ{���
function get_course($sel_year,$sel_seme,$course_id="",$day="",$sector="",$room_name=""){
	global $CONN;
	if(!empty($course_id)){
		$where="where course_id = '$course_id'";
	}else{
		$where="where year='$sel_year' and semester='$sel_seme' and room='$room_name' and day='$day' and sector='$sector'";
	}
	$sql_select = "select * from score_course $where";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);
	$array = $recordSet->FetchRow();
	return $array;
}

//�ЫǪ��U�Կ��
function &select_room($sel_year,$sel_seme,$name="room_id",$now_room){
	global $CONN;
	$data="<option value='0' >--���--</option>" ;
	$sql_select = "select room_id,room_name,enable from spec_classroom order by room_name";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	while(list($room_id,$room_name,$enable)= $recordSet->FetchRow()) {
		$selected=($now_room==$room_id)?"selected":"";
		$bgcolor=$enable?"#ffcccc":"#aaaaaa";
		$data.="<option value='$room_id' $selected style='background-color: $bgcolor;'>$room_name</option>";
	}
	$main="<select name='$name' size='1' OnChange='this.form.submit();'>$data</select>";
	return $main;
}

//�W�[�@���M��Ы�
function add_classroom($room_name , $enable , $notfree_time ){
	global $CONN;
	$query="select * from spec_classroom where room_name='$room_name' and enable='1'";
	$res=$CONN->Execute($query);
	if ($res->RecordCount()==0) {
		$sql_insert = "insert into spec_classroom (room_name , enable , notfree_time) values ('$room_name' ,'$enable' , '$notfree_time')";
		if($CONN->Execute($sql_insert))	return true;
		die($sql_insert);
	}
	return false;
}

//�R���@���M��Ы�
function del_classroom($room_id){
	global $CONN;
	$sql_update = "delete from spec_classroom where room_id='$room_id'";
	$CONN->Execute($sql_update);
	return false;
}

//�ק�@���M��Ы�
function edit_classroom($room_id, $room_name , $enable , $notfree_time  ){
	global $CONN;
	$sql_update = "update spec_classroom set room_name ='$room_name' ,enable='$enable' , notfree_time ='$notfree_time'  where room_id='$room_id'";
	$CONN->Execute($sql_update);
	return false;
}

//���o�Z�Žҵ{�}�C
function get_course_arr($sel_year,$sel_seme,$room_id,$date){
	global $CONN,$all_ss_arr;
	$d=explode("_",$date);
	$sql_select="select course_id,class_id,teacher_sn,ss_id from score_course where year='$sel_year' and semester='$sel_seme' and day='".$d[0]."' and sector='".$d[1]."' order by class_id";
	$res=$CONN->Execute($sql_select) or trigger_error("SQL ���~ $sql_select",E_USER_ERROR);
	while(list($course_id,$class_id,$teacher_sn,$ss_id)=$res->FetchRow()) {
		$c=explode("_",$class_id);
		if ($course_id) $data[$course_id]="(".intval($c[2]).$c[3].")".$all_ss_arr[$ss_id];
	}
	return $data;
}

//�U���\�Ҫ�
function downlod_ct($class_id="",$sel_year="",$sel_seme=""){
	global $CONN,$weekN,$school_kind_name;
	if(empty($class_id))trigger_error("�L�Z�Žs���A�L�k�U���C�]���S�����Z�Žs���A�G�L�k���o�Z�Žҵ{��ƥH�K�U���C", E_USER_ERROR);

	$oo_path = "ooo";
	
	
	$filename="course_".$class_id.".sxw";
	
	if(empty($class_id)){
		//���o���ЯZ�ťN��
		$class_num=get_teach_class();
	}
	
	//���o�Z�Ÿ��
	$the_class=get_class_all($class_id);
	
	//�C�g�����
	$dayn=sizeof($weekN)+1;
	
	$sql_select = "select course_id,teacher_sn,day,sector,ss_id,room from score_course where class_id='$class_id' order by day,sector";

	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	while (list($course_id,$teacher_sn,$day,$sector,$ss_id,$room)= $recordSet->FetchRow()) {
		$k=$day."_".$sector;
		$a[$k]=$ss_id;
		$b[$k]=$teacher_sn;
		$r[$k]=$room;
	}
	
	
	//���o�ҸթҦ��]�w
	$sm=&get_all_setup("",$sel_year,$sel_seme,$the_class[year]);
	$sections=$sm[sections];
	if(!empty($class_id)){
		//���o�Ҫ�
		for ($j=1;$j<=$sections;$j++){
			//�Y�O�̫�@�C�n�Τ��P���˦�
			$ooo_style=($j==$sections)?"4":"2";
			
			if ($j==5){
				//�w�]���ȥ�OpenOffice.org���{���X
				$all_class.= "<table:table-row table:style-name=\"course_tbl.3\"><table:table-cell table:style-name=\"course_tbl.A3\" table:number-columns-spanned=\"6\" table:value-type=\"string\"><text:p text:style-name=\"P12\">�ȶ���</text:p></table:table-cell><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/></table:table-row>";
			}
			
			$all_class.="<table:table-row table:style-name=\"course_tbl.1\"><table:table-cell table:style-name=\"course_tbl.A".$ooo_style."\" table:value-type=\"string\"><text:p text:style-name=\"P8\">�� $j �`</text:p></table:table-cell>";
			//�C�L�X�U�`
			$wn=count($weekN);
			for ($i=1;$i<=$wn;$i++) {
				//�Y�O�̫�@��n�Τ��P���˦�
				$ooo_style2=($i==$wn)?"F":"B";
			
				$k2=$i."_".$j;
				
				$teacher_search_mode=(!empty($tsn) and $tsn==$b[$k2])?true:false;
				//���
				$subject_sel=&get_ss_name("","","�u",$a[$k2]);
				
				//�Юv
				$teacher_sel=get_teacher_name($b[$k2]);
				//�C�@��
				$all_class.="<table:table-cell table:style-name=\"course_tbl.".$ooo_style2.$ooo_style."\" table:value-type=\"string\"><text:p text:style-name=\"P9\">$subject_sel</text:p><text:p text:style-name=\"P10\"><text:span text:style-name=\"teacher_name\">$teacher_sel</text:span></text:p></table:table-cell>";
			}
			$all_class.="</table:table-row>";
		}
		
	}else{
		$all_class="";
	}
	
	//�ഫ�Z�ťN�X
	$class=class_id_2_old($class_id);
	$class_teacher=get_class_teacher($class[2]);
	$class_man=$class_teacher[name];

	//���o�Ǯո��
	$s=get_school_base();
	//�s�W�@�� zipfile ���
	$ttt = new EasyZip;
	$ttt->setPath($oo_path);
	$ttt->addDir('META-INF');
	$ttt->addfile('settings.xml');
	$ttt->addfile('styles.xml');
	$ttt->addfile('meta.xml');

	//Ū�X content.xml 
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");

	//�N content.xml �� tag ���N
	$temp_arr["city_name"] = "";//$s[sch_sheng];
	$temp_arr["school_name"] = $s[sch_cname];
	$temp_arr["Cyear"] = $stu[stud_name];
	$temp_arr["stu_class"] = $class[5];
	$temp_arr["teacher_name"] = $class_man;
	$temp_arr["year"] = $sel_year;
	$temp_arr["seme"] = $sel_seme;
	$temp_arr["all_course"] = $all_class;

	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	$replace_data = $ttt->change_temp($temp_arr,$data,0);
	
	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");
	
	//���� zip ��
	$sss = &$ttt->file();

	//�H��y�覡�e�X ooo.sxw
	header("Content-disposition: attachment; filename=$filename");
	//header("Content-type: application/octetstream");
	header("Content-type: application/vnd.sun.xml.writer");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");

	echo $sss;
	
	exit;
	return;
}

//�Y�~�Ū��Z�Ű}�C�A�Y�S���w�~�ūh�O����
function get_class_name($sel_year,$sel_seme,$cyear=""){
	global $CONN,$class_year;
	$and_cyear=(empty($cyear))?"":"and c_year='$cyear'";
	$sql_select = "select class_id,c_year,c_name from school_class where year='$sel_year' and semester = '$sel_seme' and enable='1' $and_cyear order by c_year,c_sort";
	$recordSet=$CONN->Execute($sql_select)  or trigger_error($sql_select, E_USER_ERROR);
	while (list($class_id,$c_year,$c_name)= $recordSet->FetchRow()) {
		$temp_arr[$class_id]=$class_year[$c_year].$c_name."�Z";
	}
	return $temp_arr;
}

//�Юv�W�r�}�C�̩m�W�ƦC
function my_teacher_array(){
	global $CONN;
	$query= "select a.teacher_sn,a.name from teacher_base a,teacher_post b where a.teach_condition=0 and a.teacher_sn=b.teacher_sn  order by a.name ";
	$res=$CONN->Execute($query);
	$temp_arr = array();
	while(!$res->EOF){
		$temp_arr[$res->fields[0]] = $res->fields[1];
		$res->MoveNext();
	}
	return $temp_arr;
}
?>
