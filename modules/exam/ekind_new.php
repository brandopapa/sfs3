<?php                                                                                                                             
// $Id: ekind_new.php 8673 2015-12-25 02:23:33Z qfon $
// --�t�γ]�w��
include "exam_config.php";

//�P�_�O�_���޲z�� $perr_man �}�C�]�w�b exam_config.php
$man_flag = false;
//�P�O�O�_���t�κ޲z��
$man_flag = checkid($_SERVER[SCRIPT_FILENAME],1) ;

$curr_class_id = $_POST[curr_class_id];
if($curr_class_id =='')
	$curr_class_id = 1;
if (!$man_flag) {	
	$str = "�A���Q���v�ϥΥ��\��A�ѦҨt�λ�����" ;
	redir("exam.php",3) ;
	exit;
}

if(!checkid(substr($_SERVER[PHP_SELF],1))){
	$go_back=1; //�^��ۤw���{�ҵe��  
	include "header.php";
	include "$rlogin";
	include "footer.php"; 
	exit;
}

if($_POST[key] =='�s�W'){
	$curr_class_name = $_POST[curr_class_name];
	for ($i=0 ;$i <count($_POST[curr_class_name]);$i++) {
		$class_id = sprintf("%04d%d%02d",$_POST[curr_year],$_POST[curr_class_id],$curr_class_name[$i]);
		$result = $CONN->Execute("select class_id from exam_kind where class_id ='$class_id'");
		if ($result->RecordCount() ==0) {
			$sql_insert = "insert into exam_kind (e_kind_id,e_kind_memo,e_kind_open,e_upload_ok,teach_id,teach_name,class_id)
                 		values ('$_POST[e_kind_id]','$_POST[e_kind_memo]','$_POST[e_kind_open]','$_POST[e_upload_ok]','$_SESSION[session_log_id]','$_SESSION[session_tea_name]','$class_id')";
  			$CONN->Execute($sql_insert) or die($sql_insert); 
  		}
  		
  	}
  	//�ثe�~�Z curr_year() ->�Ǧ~�� $curr_class_year ->�~�� 
//  	$temp_year = (curr_year() - $curr_class_id + 1);
  	//�d�߬O�_�w�إ߾ǥͧ@�~��
  	//$query = "select count(stud_id) as cc from exam_stud_data where stud_id like '$temp_year%' ";
  	//$result = $CONN->Execute($query) or die($query);
  	
  	//�s�W�ǥͧ@�~��
  	//if ($result->fields[0] == 0) {
		$curr_class_id=intval($curr_class_id);
  		$query = "select stud_id ,curr_class_num from stud_base where curr_class_num like '$curr_class_id%' ";
  		$result = $CONN->Execute($query) or die($query);
  		while (!$result->EOF) {
			$stud_id = $result->fields[0];
			$query = "select stud_id from exam_stud_data where stud_id='$stud_id'";
			$res = $CONN->Execute($query);
			if ($res->EOF){
	  			$stud_num = substr($result->fields[1],-2);
  				$query = "insert into exam_stud_data (stud_id,stud_pass,stud_num) values ('$stud_id','$default_pass','$stud_num')";
  				$CONN->Execute($query) or die($query);
			}
			$result->MoveNext();
  		}
	//}
  	header ("Location: ekind.php");
  
}


$curr_year = intval(curr_year());
$curr_seme = curr_seme();
if (curr_seme() == 1 )
	$temp_seme = "�W�Ǵ�";
else
	$temp_seme = "�U�Ǵ�";
	

include "header.php";
?>
�s�W�Z�Ÿ��(<font color=red><?php echo $curr_year."�Ǧ~��".$temp_seme ?></font>)
<form action ="<?php echo $_SERVER[PHP_SELF] ?>" method="post" >
<input type= hidden name=curr_class_id value="<?php echo $curr_class_id ?>" >
<table border=1>

<tr>
	<td >�Z�ŦW��<BR>(�Z�O�i�ƿ�)</td><td valign=top>
	<?php
	$sel1 = new drop_select();
	$sel1->s_name ="curr_class_id";
	$sel1->id = $curr_class_id;
	$sel1->is_submit= true;
	$sel1->arr = year_base();
	$sel1->has_empty = false;
	$sel1->do_select();
	
	?>


	<select	name="curr_class_name[]" multiple>
	<?php
	$curr_class_id=intval($curr_class_id);
	$sql="select c_sort,c_name from school_class where year=$curr_year and semester=$curr_seme and c_year=$curr_class_id";
	$result = $CONN->Execute($sql) or die($sql);
	while(!$result->EOF){
		$class_name_arr[$result->fields[0]] = $result->fields[1];
		$result->MoveNext();
	}
	$class_temp ="";
	if(count($class_name_arr)>0) {
		while(list($tkey,$tvalue)= each ($class_name_arr)) {
		if ($tkey == $temp_class)
			$class_temp .=  sprintf ("<option value=\"%s\" selected>%s</option>\n",$tkey,$tvalue);
		else
			$class_temp .=   sprintf ("<option value=\"%s\">%s</option>\n",$tkey,$tvalue);
		}
		$class_temp .= "</select>";
		echo $class_temp ;
	}
	?>
	</td>
</tr>

<tr>
	<td>�O�_�}��i��</td><td>
		<input type="checkbox" name="e_kind_open" value=1  <? echo $e_kind_open; ?>> �O
	</td>
</tr>

<tr>
	<td>�O�_�}��W��</td><td>
		<input type="checkbox" name="e_upload_ok" value=1  <? echo $e_upload_ok; ?>> �O
	</td>
</tr>



<tr>
	<td valign=top>����</td><td>
		<textarea name="e_kind_memo" cols=40 rows=5 wrap=virtual><?php echo $e_kind_memo ?></textarea>
	</td>
</tr>
<tr>
	<td colspan=2 align=center>
	<input type="hidden" name=curr_year value="<? echo sprintf("%03s%d",curr_year(),curr_seme()); ?>">
	<input type="submit" name=key value="�s�W">
	&nbsp;&nbsp;<input type="button"  value= "�^�W��" onclick="history.back()">
	</td>
</tr>

</table>
</form>
<? include "footer.php"; ?>
