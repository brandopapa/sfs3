<?php
// $Id: grouping.php 5310 2009-01-10 07:57:56Z hami $

include_once "config.php";
sfs_check();
$group_selected=$_POST['group_selected'];
$new_description=$_POST['new_description'];
$cols_count=5;

if($_POST['go']=='�x�s�ק�'){
	if($group_selected) {
		$kind_array=$_POST['kind'];
		foreach($kind_array as $value) $kind_list.="$value,";
		$kind_list=','.$kind_list;
		$update_sql="UPDATE stud_kind_group SET description='$new_description',kind_list='$kind_list' WHERE sn=$group_selected";
		$recordSet=$CONN->Execute($update_sql) or user_error("Ū�����ѡI<br>$update_sql",256);
	}
}

if($_POST['go']=='�ƻs��s�s��'){
	if($group_selected) {
		$kind_array=$_POST['kind'];
		foreach($kind_array as $value) $kind_list.="$value,";
		$kind_list=','.$kind_list;
		$insert_sql="INSERT INTO stud_kind_group SET description='$new_description',kind_list='$kind_list'";
		$recordSet=$CONN->Execute($insert_sql) or user_error("Ū�����ѡI<br>$insert_sql",256);
	}
}

if($_POST['go']=='�R��'){
		$del_sql="DELETE FROM stud_kind_group WHERE sn=$group_selected";
		$recordSet=$CONN->Execute($del_sql) or user_error("Ū�����ѡI<br>$del_sql",256);
}

//�q�X����
head("�s�����O�]�w");

//��V������
echo print_menu($MENU_P,$linkstr);

if(checkid($_SERVER['SCRIPT_FILENAME'],1)) {
//���o�s�զW��
$group_sql="SELECT * FROM stud_kind_group ORDER BY description";
$recordSet=$CONN->Execute($group_sql) or user_error("Ū�����ѡI<br>$group_sql",256);
$group_select="<select name='group_selected' onchange='this.form.submit();'><option value='-'>---------��ܸs��---------</option>";

while(!$recordSet->EOF){
	$sn=$recordSet->fields['sn'];
	$description=$recordSet->fields['description'];
	$selected='';
	if($group_selected==$sn) {
		$selected='selected';
		$kind_list=$recordSet->fields['kind_list'];
		$description_selected=$description;
	}
	$group_select.="<option $selected value=$sn>$description</option>";
	$recordSet->MoveNext();
}
$group_select.="</select>";

//���o�ǥͨ����C��
$type_select="SELECT d_id,t_name FROM sfs_text WHERE t_kind='stud_kind' AND d_id>0 order by t_order_id";
$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);

while(!$recordSet->EOF){
		$curr_row=($recordSet->currentrow()+1) % $cols_count;
        $d_id=$recordSet->fields['d_id'];

		$t_name=$recordSet->fields['t_name'];
		if(strpos($kind_list,",$d_id,")>-1) {
			$checked='checked';
			$col_bgcolor='#CCCCCC';
		} else {
			$checked='';
			$col_bgcolor='#FFCCCC';
		}
//echo "<BR>$d_id --- $checked";	
		$kind_checkbox_list.=($curr_row==1)?"<tr>":"";
		$kind_checkbox_list.="<td bgcolor='$col_bgcolor'><input type='checkbox' name='kind[]' value=$d_id $checked>($d_id)$t_name</td>";
		
		$recordSet->MoveNext();
		//�P�_�O�_�W�[�C��������
		if($curr_row==$cols_count or $recordSet->EOF) $table_body.="</tr>";
}

$listdata="<table width='100%' cellspacing='1' cellpadding='3'>
             <form name='my_form' method='post' action='$_SERVER[PHP_SELF]'>
			 <tr bgcolor=#CFCFAA><td colspan=$cols_count><input type='checkbox' name='tag' onclick='javascript:tagall(this.checked);'> <img border='0' src='images/pin.gif'>�����O�s�զC��G$group_select  
			 <input type='submit' name='go' value='�x�s�ק�' onClick=\"\$new_group=prompt('�п�J�ק�᪺�s�զW��?','$description_selected'); if(\$new_group) { document.my_form.new_description.value=\$new_group;} else return false;\">
			 <input type='reset' name='reset' value='�^�_��]�w'>
			 <input type='hidden' name='new_description' value=''>
			 <input type='submit' name='go' value='�ƻs��s�s��' onClick=\"\$new_group=prompt('�п�J�s�s�զW��?',''); if(\$new_group) { document.my_form.new_description.value=\$new_group; } else return false;\">
			 <input type='submit' name='go' value='�R��' onclick='return confirm(\"�u���n�R��[$description_selected]?\")'>

			 </td></tr>
			 <tr><td>$kind_checkbox_list</td></tr>";

$listdata.="</form></table>";
echo $listdata;
echo "<script>
function tagall(status) {
  var i =0;
  while (i < document.my_form.elements.length)  {
    if (document.my_form.elements[i].name=='kind[]') {
      document.my_form.elements[i].checked=status;
    }
    i++;
  }
}
</script>";
} else { echo "<h2><center><BR><BR><font color=#FF0000>�z�ëD�Ҳպ޲z���A�L�k�ϥΥ��\��!</font></center></h2>"; } 
foot();
?>
