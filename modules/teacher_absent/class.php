<?php
//$Id: supply.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
include_once "../../include/config.php";
include_once "../../include/sfs_case_score.php";
require_once "../../include/sfs_core_globals.php";
include_once "../../include/sfs_case_studclass.php";
include_once "../../include/sfs_case_subjectscore.php";

//�{��
sfs_check();

//�Y�S����ܰ���A�h�^��C��
if(empty($id)){
	header("Location: deputy.php?act='err'");
}

head("�ҰȳB�z");
$tool_bar=make_menu($school_menu_p);
echo $tool_bar;
	
//�q�X����
//������
$main=teacher_absent($id);
echo $main;

$deputy_class="";  //�N�ұЮv�Ҫ�
// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}
//�R���N��
if ($_POST[del]) {
	list($c_id,$v)=each($_POST[del]);
	$query = "delete from teacher_absent_course where c_id ='$c_id'";
	$CONN->Execute($query);
	$main=&room_setup_form();

}

if ($act == "�ק�T�w") {
	$sql_update = "update teacher_absent_course set 
	d_kind='$c_d_kind',start_date='$start_date',end_date='$end_date',class_name='$class_name',deputy_sn='$deputy_sn' ,times='$times' ,class_dis='$class_dis' where c_id=$c_id";
	$CONN->Execute($sql_update);
	$main=&room_setup_form();
}elseif ($act=="�s�W�T�w") {
	$sql_insert = "insert into teacher_absent_course (a_id,teacher_sn,class_dis,d_kind,deputy_sn,class_name, times,start_date,end_date) values 
								('$id','$teacher_sn','$class_dis','$c_d_kind','$deputy_sn','$class_name', '$times','$start_date','$end_date')";
	$CONN->Execute($sql_insert);
 	$main=&room_setup_form();

}elseif ($_POST[edit]) {	//�ק�N��
	list($c_id,$v)=each($_POST[edit]);	
	$main=&room_setup_form("edit",$c_id);
}elseif ($act=="�s�W") {
	$main=&room_setup_form("add",$c_id,$c_d_kind);

}elseif ($_POST[deputy]) {
	list($c_id,$v)=each($_POST[deputy]);
		$query="update teacher_absent_course set status='1',deputy_date='".date("Y-m-d H:i:s")."' where c_id='$c_id'";
		$CONN->Execute($query);
	$main=&room_setup_form();

} elseif ($_POST[deputy_c]) {
	list($c_id,$v)=each($_POST[deputy_c]);
		$query="update teacher_absent_course set status='0',deputy_date='".date("Y-m-d H:i:s")."' where c_id='$c_id'";
		$CONN->Execute($query);
	$main=&room_setup_form();

}else{
	$main=&room_setup_form();
}




echo $main;

//�Ҫ���
$main=class_form_search($teacher_sn);
echo $main;
echo $deputy_class;
/*
�禡��
*/

//�N�Ҹ��
function &room_setup_form($mode="",$cc_id,$c_d_kind){
	global $CONN,$id,$d_kind_arr,$times_kind_arr,$teacher_sn,$course_kind,$check2_sn,$c_start_date,$c_end_date,$class_dis,$deputy_class,$week_array;
	
	if ($check2_sn==0 and $class_dis<>0){
		$add_button="<input type=submit name='act' value='�s�W'>";
		$view_button="<input type=submit name='act' value='�s��'>";
	}

	$modify_submit_button="<input type='submit' name='act' value='�ק�T�w'>";
	

	if ($mode=="edit"){
		$b0="$view_button $add_button $modify_submit_button";
		$b1="$modify_submit_button";
	}elseif($mode=="add"){
		if($c_d_kind){
			
			$hidden="";
		}else{
			
			$hidden="<input type='hidden' name='act' value= '�s�W'>";

		}

		$d_kind_menu=d_make_menu("��ܳ��",$c_d_kind,$d_kind_arr,"c_d_kind",1);
		$d_class_menu=d_class_menu();

		$teacher_menu=deputy_teacher_menu("deputy_sn",0,$teacher_sn);
		if($c_d_kind==1 or $c_d_kind==2){
			$end_date_menu=$d_class_menu;
		}else{
			$end_date_menu="<input type='text' style='font-size: 18pt' size='10' maxlength='10' name='end_date'  value='$c_end_date' >";
		}
		$add_form="<tr class='title_mbody'>
		<td><br></td>
		<td>$d_kind_menu</td>
		<td><input type='text' style='font-size: 18pt' size='10' maxlength='10' name='start_date' value='$c_start_date'></td>
		<td align='center' >$end_date_menu</td>
		<td><input type='text' size='20' maxlength='20' name='class_name'></td>
		<td align='center' >$teacher_menu</td>
		<td align='center' ><input type='text' style='font-size: 18pt' size='2'  name='times' value='1'></td>
		<td align='center' ><input type='submit' name='act' value='�s�W�T�w'></td>		
		</tr>
		$hidden

		";

	}
	
	$button0="<tr  class='title_sbody2'><td colspan='5'>$b0</td></tr>";
	$button1=(!empty($b1))?"<tr  class='title_sbody2'><td colspan='5'>$b1</td></tr>":$button0;

	//Ū�����
	$sql_select = "select * from teacher_absent_course  where a_id='$id' and travel='0' order by c_id";
	$result = $CONN->Execute ($sql_select) or die($sql_select) ;
	$i=0;
	$d_sn_arr=array();
	while (!$result->EOF) {

		$c_id = $result->fields["c_id"];

		if ($check2_sn==0 and $class_dis<>0 ){
			$cancel_button="<input type='image' src='images/del.png' name='deputy_c[$c_id]' alt='����'>";
			$check_button="<input type='image' src='images/edit.png' name='deputy[$c_id]' alt=' �T�w'>";
		}

		$d_kind = $result->fields["d_kind"];
		$start_date = $result->fields["start_date"];

//���o�P���X
	
		$nw=d_week($start_date);
		
		$end_date = $result->fields["end_date"];
		$class_name = $result->fields["class_name"];
		$deputy_sn = $result->fields["deputy_sn"];
		$times = $result->fields["times"];
		$status = $result->fields["status"];
		
		$class_dis=$result->fields["class_dis"];
		$d_name=get_teacher_name($deputy_sn);
		
		$n_class_dis=$course_kind["$class_dis"];
	
		$ti = ($i++%2)+1;
		if($status ==0 and $check2_sn==0){
			$modify_button="<input type='image' src='images/edit.png' name='edit[$c_id]' alt='�ק�'>";
			$del_button="<input type='image' src='images/del.png' name='del[$c_id]' alt='�R��'>";
		}else{
			$modify_button="";
			$del_button="";

		}
		
		if ( $deputy_sn==0 ){
			$check_button="";
		}

		$check=($status=="0") ?
		"<font size=2 color=red>�ݽT�w</font>
		$check_button
		":"
		$cancel_button
		";

		
	//���
		$d_kind_menu=d_make_menu("��ܳ��",$d_kind,$d_kind_arr,"c_d_kind",0);

		$teacher_menu=deputy_teacher_menu("deputy_sn",$deputy_sn,$teacher_sn);
	
		$room=($mode=="edit" and $c_id==$cc_id)?
		"<td align='center' >
		$del_button
		$n_class_dis 
		$modify_button
		</td>
		<td align='center' >$d_kind_menu</td>
		<td align='center' ><input type='text' style='font-size: 16pt' size='10' maxlength='10' name='start_date' value='$start_date'></td>
		<td align='center' ><input type='text' style='font-size: 16pt' size='10' maxlength='10' name='end_date' value='$end_date'></td>
		<td><input type='text' size='20' maxlength='20' name='class_name' value='$class_name'></td>
		<td align='center' >$teacher_menu</td>
		<td align='center' ><input type='text' style='font-size: 16pt' size='2'  name='times' value='$times'></td>
		<td>$modify_submit_button</td>
		<input type='hidden' name='c_id' value= $c_id >
		":"
		<td align='center'>
		$del_button
		$n_class_dis 
		$modify_button
		</td>
		<td align='center'>		
		 $d_kind_arr[$d_kind] 
		<td align='center' ><font size=3>$start_date $nw</font></td>
		<td align='center'><font size=3>$end_date</font></td>		
		<td align='center'>$class_name</td>
		<td align='center'>
		$d_name $check
		</td>
		<td align='center'>$times</td>
		<td align='center'>$times_kind_arr[$d_kind]</td>
		";

		$room_data.="
		<tr class=nom_$ti>
		$room
		</tr>";
//�N�ҦѮv�Ҫ���
		$p_dc=1;
		for($j=0;$j<$i;$j++){
			if($deputy_sn==$d_sn_arr[$j-1]){
				$p_dc=0;	
			}
		}
		if($deputy_sn >0 and $p_dc){
			$deputy_class .=class_form_search($deputy_sn);	
		}
   		$d_sn_arr[$i]=$deputy_sn;
	


		$result->MoveNext();
	}


	//�����\���

	$main="	
	<table border='1' cellPadding='3' cellSpacing='0' class='main_body' width=100%>
	<form name ='myform' action='{$_SERVER['PHP_SELF']}' method='post'>
	<tr class='title_mbody'>
	<td  align='center'width=15%> $add_button �Ұ� $view_button</td>
	<td  align='center' width=10%>�N�Ҥ覡  </td>
	<td  align='center'width=20%>�N�Ҥ��</td>
	<td align='center'width=15%>��������θ`��</td>
	<td align='center'width=15%>��دZ��</td>
	<td align='center'width=15%>�N�z�H</td>
	<td align='center'width=5%>�ƶq</td>
	<td align='center'width=5%>���</td>
	
	</tr>	
	$room_data
	$add_form
	</table>
	<input type='hidden' name='id' value= $id >
	</form>
	";

	return $main;
}







//������
function teacher_absent($id){
	global $CONN,$course_kind,$view_tsn,$sel_year,$sel_seme,$teacher_sn,$class_dis,$check2_sn,$c_start_date,$c_end_date,$check1,$check2,$check3,$check4;

		$query="select * from teacher_absent where id='".$id."'";
		$result = mysql_query($query) or die ($query);
		$row = mysql_fetch_array($result);
		
		$view_tsn=$row["teacher_sn"];


		if($view_tsn <> $_SESSION[session_tea_sn]) exit();

		$sel_year=$row["year"];
		$sel_seme=$row["semester"];
		$teacher_sn=$row["teacher_sn"];
		$class_dis=$row["class_dis"];

		$t_name=get_teacher_name($row["teacher_sn"]);
		$reason=$row["reason"];
		$note=$row["note"];
		$locale=$row["locale"];

		$abs_kind_arr=tea_abs_kind();
		$abs_kind=$abs_kind_arr[$row["abs_kind"]];
		$n_class_dis=$course_kind[$row["class_dis"]];
		$start_date=substr($row["start_date"],0,16);
		$c_start_date=substr($start_date,0,10);

		$end_date=substr($row["end_date"],0,16);
		$c_end_date=substr($end_date,0,10);
	
		$day_hour=($row["day"]==0)?"":$row["day"] ."��";
		$day_hour.=($row["hour"]==0)?"":$row["hour"] ."��";

		$check2_sn=$row["check2_sn"];
		$de_name=get_teacher_name($row["deputy_sn"]);
		$c1_name=get_teacher_name($row["check1_sn"]);
		$c2_name=get_teacher_name($row["check2_sn"]);
		$c3_name=get_teacher_name($row["check3_sn"]);
		$c4_name=get_teacher_name($row["check4_sn"]);
		
		$main= "<table border=0 cellspacing=1 cellpadding=4 width=100% bgcolor=#cccccc >
		<tr bgcolor=#E1ECFF align=center>
		<td width=4%>�Ǹ�</td><td width=8%>�а��H</td><td width=6%>���O</td>	<td width=12%>�ƥ�</td><td width=16%>�}�l�ɶ�<br>�����ɶ�</td><td width=6% >���</td>
		<td width=6%>�Ұ�</td>	<td width=8%>¾�ȥN�z�H</td><td width=8%>$check1</td><td width=8%>$check2</td><td width=8%>$check3</td><td width=8%>$check4</td></tr>";

		$main.= "<tr bgcolor=#ffffff align=center>
		<td>$id</td>
		<td>$t_name</td>
		<td><font size=2>$abs_kind</font><br>
			<font size=2 color=blue>$note</font></td>	
		<td><font size=2>$reason</font><br><font size=2 color=blue>$locale</font></td>		
		<td>$start_date<br>$end_date</td>
		<td>$day_hour</td>
		<td><font size=2>$n_class_dis</font></td>	
		<td>$de_name</td>
		<td>$c1_name</td>
		<td>$c2_name</td>
		<td>$c3_name</td>
		<td>$c4_name</td></tr>";

	return $main;
}

function class_form_search($view_tsn){
	global $school_menu_p,$PHP_SELF,$class_id,$sel_year,$sel_seme;
	
	$list_class_table=search_teacher_class_table($sel_year,$sel_seme,$view_tsn);

	$main="
	$list_class_table
	";
	return $main;
}

//�Юv�����Ҫ�
function search_teacher_class_table($sel_year="",$sel_seme="",$view_tsn=""){
	global $CONN,$PHP_SELF,$class_year,$conID,$weekN,$school_menu_p,$sections;
	
	$main=teacher_all_class($sel_year,$sel_seme,$view_tsn)."<br>";

	return $main;
}


//�Юv�������`��
function teacher_all_class($sel_year="",$sel_seme="",$tsn=""){
	global $CONN,$PHP_SELF,$class_year,$conID,$weekN,$school_menu_p,$sections;

	$teacher_name=get_teacher_name($tsn);

	$double_class=array();
	$kk=array();
	
	//�C�g�����
	$dayn=sizeof($weekN)+1;

	//��X�Юv�Ӧ~�שҦ��ҵ{
	$sql_select = "select course_id,class_id,day,sector,ss_id,room from score_course where teacher_sn='$tsn' and year='$sel_year' and semester='$sel_seme' order by day,sector";

	$recordSet=$CONN->Execute($sql_select) or user_error("���~�T���G",$sql_select,256);
	while (list($course_id,$class_id,$day,$sector,$ss_id,$room)= $recordSet->FetchRow()) {
		$k=$day."_".$sector;
		$a[$k]=$ss_id;
		$b[$k]=$class_id;
		$room[$k]=$room;
		
		//�Y�O����`�Ʀ����ƪ������_��
		if(in_array($k,$kk))$double_class[]=$k;

		//��Ҧ�����`�Ʃ��}�C
		$kk[]=$k;
	}

	//���o�P�����@�C
	for ($i=1;$i<=count($weekN); $i++) {
		$main_a.="<td align='center' >�P��".$weekN[$i-1]."</td>";
	}

	//���o�`�ƪ��̤j��
	$sections=get_most_class($sel_year,$sel_seme);


	//���o�Ҫ�
	for ($j=1;$j<=$sections;$j++){

		if ($j==5){
			$all_class.= "<tr bgcolor='white'><td colspan='$dayn' align='center'>�ȥ�</td></tr>\n";
		}


		$all_class.="<tr bgcolor='#FBEC8C'><td align='center'>$j</td>";

		//�C�L�X�U�`
		for ($i=1;$i<=count($weekN); $i++) {

			$k2=$i."_".$j;

			//���o�Z�Ÿ��
			$the_class=get_class_all($b[$k2]);
			$class_name=($the_class[name]=="�Z")?"":$the_class[name];

			//���
			$subject_show="<font size=3>".get_ss_name("","","�u",$a[$k2])."</font>";

			//�Z�O
			$class_show="<font size=2> $class_name </font>";

			//�Y�O�Ӥ���`�Ʀ��b���ư}�C�z�A�q�X���⩳��
			$d_color=(in_array($k2,$double_class))?"red":"white";

			//�C�@��
			$all_class.="<td align='center'  width=18% bgcolor='$d_color'>
			 $sub$subject_show   $class_show
			
			<!--<input type='text' name='room' value='".$room[$i][$j]."' size='10'>-->
			</td>\n";
		}

		$all_class.= "</tr>\n" ;
	}


	//�ӯZ�Ҫ�
	$main_class_list="
	<tr bgcolor='#FBDD47'><td colspan=6>�y".$teacher_name."�z�½��`��</td></tr>
	<tr bgcolor='#FBF6C4'><td align='center' width=10%>�`</td>$main_a</tr>
	$all_class";

	$main="
	<table border='0' cellspacing='1' cellpadding='4' bgcolor='#D06030' width='100%'>
	$main_class_list
	</table>
	";
	return  $main;
}


function deputy_teacher_menu($s_name,$teacher_sn,$agent_sn) {
	$tm = new drop_select();
	$tm->s_name =$s_name;
	$tm->top_option = "��ܱЮv";
	$tm->id = $teacher_sn;
	$tm->arr = my_teacher_array($agent_sn);
	//$tm->is_submit = true;
	return $tm->get_select();
}

function d_class_menu() {
	$arr=array("�ɮv�ɶ�"=>"�ɮv�ɶ�","�ɮv�ɶ�(�W)"=>"�ɮv�ɶ�(�W)","��1�`"=>"��1�`","��2�`"=>"��2�`","��3�`"=>"��3�`","��4�`"=>"��4�`","��5�`"=>"��5�`","��6�`"=>"��6�`","��7�`"=>"��7�`","�ɮv�ɶ�(�U)"=>"�ɮv�ɶ�(�U)");
	$mon = new drop_select();
	$mon->s_name ="end_date";
	$mon->top_option = "��ܸ`��";
	//$mon->id = $d_kind;
	$mon->arr = $arr;
	//$mon->is_submit = $true;
	return $mon->get_select();
}



?>