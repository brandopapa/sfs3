<?php
// $Id$

include "config.php";
sfs_check();

//主選單設定
$school_menu_p=(empty($school_menu_p))?array():$school_menu_p;

//預設值設定
$col_default=array();


$act=$_REQUEST[act];

//執行動作判斷
if($act=="insert"){
	reward_add($_POST[data]);
	header("location: $_SERVER[PHP_SELF]?act=listAll");
}elseif($act=="update"){
	reward_update($_POST[data],$_POST[reward_div]);
	header("location: $_SERVER[PHP_SELF]?act=listAll");
}elseif($act=="del"){
	reward_del($_GET[reward_div]);
	header("location: $_SERVER[PHP_SELF]?act=listAll");
}elseif($act=="listAll"){
	$main=&reward_listAll();
}elseif($act=="modify"){
	$main=&reward_mainForm($_GET[reward_div],"modify");
}else{
	$main=&reward_mainForm($_POST[reward_div]);
}


//秀出網頁
head("{showname}");
echo $main;
foot();

//主要輸入畫面
function &reward_mainForm($reward_div="",$mode){
	global $school_menu_p,$col_default;
	
	if($mode=="modify" and !empty($reward_div)){
		$dbData=get_reward_data($reward_div);
	}
	
	if(is_array($dbData) and sizeof($dbData)>0){
		foreach($dbData as $a=>$b){
			$DBV[$a]=(!is_null($b))?$b:$col_default[$a];
		}
	}else{
		$DBV=$col_default;
	}
	
	$submit=($mode=="modify")?"update":"insert";
	
	//相關功能表
	$tool_bar=&make_menu($school_menu_p);
	
	$main="
	$tool_bar
	
	<table cellspacing='1' cellpadding='3' bgcolor='#C0C0C0' class='small'>
	<form action='$_SERVER[PHP_SELF]' method='post'>
	
	<tr bgcolor='#FFFFFF'>
	<td>reward_div</td>
	<td><input type='text' name='data[reward_div]' value='$DBV[reward_div]' size='4' maxlength='4'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>reward_id</td>
	<td><input type='text' name='data[reward_id]' value='$DBV[reward_id]' size='20' maxlength='20'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>stud_id</td>
	<td><input type='text' name='data[stud_id]' value='$DBV[stud_id]' size='20' maxlength='20'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>reward_kind</td>
	<td><input type='text' name='data[reward_kind]' value='$DBV[reward_kind]' size='10' maxlength='10'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>reward_year_seme</td>
	<td><input type='text' name='data[reward_year_seme]' value='$DBV[reward_year_seme]' size='6' maxlength='6'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>reward_date</td>
	<td><input type='text' name='data[reward_date]' value='$DBV[reward_date]' size='10' maxlength='10'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>reward_reason</td>
	<td><textarea name='data[reward_reason]' cols='40' rows='5'>$DBV[reward_reason]</textarea>
	</td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>reward_c_date</td>
	<td><input type='text' name='data[reward_c_date]' value='$DBV[reward_c_date]' size='10' maxlength='10'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>reward_base</td>
	<td><textarea name='data[reward_base]' cols='40' rows='5'>$DBV[reward_base]</textarea>
	</td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>reward_cancel_date</td>
	<td><input type='text' name='data[reward_cancel_date]' value='$DBV[reward_cancel_date]' size='10' maxlength='10'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>update_id</td>
	<td><input type='text' name='data[update_id]' value='$DBV[update_id]' size='20' maxlength='20'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>update_ip</td>
	<td><input type='text' name='data[update_ip]' value='$DBV[update_ip]' size='15' maxlength='15'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>reward_sub</td>
	<td><input type='text' name='data[reward_sub]' value='$DBV[reward_sub]' size='4' maxlength='4'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>dep_id</td>
	<td><input type='text' name='data[dep_id]' value='$DBV[dep_id]' size='20' maxlength='20'></td>
	</tr>
	
	<tr bgcolor='#FFFFFF'>
	<td>student_sn</td>
	<td><input type='text' name='data[student_sn]' value='$DBV[student_sn]' size='10' maxlength='10'></td>
	</tr>
	
	</table>
	<input type='hidden' name='reward_div' value='$reward_div'>
	<input type='hidden' name='act' value='$submit'>
	<input type='submit' value='送出'>
	</form>

	<a href='$_SERVER[PHP_SELF]?act=listAll'>列出全部</a>
	";
	return $main;
}

//新增
function reward_add($data){
	global $CONN;
	
	$sql_insert = "insert into reward (reward_div,reward_id,stud_id,reward_kind,reward_year_seme,reward_date,reward_reason,reward_c_date,reward_base,reward_cancel_date,update_id,update_ip,reward_sub,dep_id,student_sn) values ('$data[reward_div]','$data[reward_id]','$data[stud_id]','$data[reward_kind]','$data[reward_year_seme]','$data[reward_date]','$data[reward_reason]','$data[reward_c_date]','$data[reward_base]','$data[reward_cancel_date]','$data[update_id]','$data[update_ip]','$data[reward_sub]','$data[dep_id]','$data[student_sn]')";
	$CONN->Execute($sql_insert) or user_error("新增失敗！<br>$sql_insert",256);
	$reward_div=mysql_insert_id();
	return $reward_div;
}

//更新
function reward_update($data,$reward_div){
	global $CONN;
	
	$sql_update = "update reward set reward_div='$data[reward_div]',reward_id='$data[reward_id]',stud_id='$data[stud_id]',reward_kind='$data[reward_kind]',reward_year_seme='$data[reward_year_seme]',reward_date='$data[reward_date]',reward_reason='$data[reward_reason]',reward_c_date='$data[reward_c_date]',reward_base='$data[reward_base]',reward_cancel_date='$data[reward_cancel_date]',update_id='$data[update_id]',update_ip='$data[update_ip]',reward_sub='$data[reward_sub]',dep_id='$data[dep_id]',student_sn='$data[student_sn]'  where reward_div='$reward_div'";
	$CONN->Execute($sql_update) or user_error("更新失敗！<br>$sql_update",256);
	return $reward_div;
}

//刪除
function reward_del($reward_div=""){
	global $CONN;
	$sql_delete = "delete from reward where reward_div='$reward_div'";
	$CONN->Execute($sql_delete) or user_error("刪除失敗！<br>$sql_delete",256);
	return true;
}

//列出所有
function &reward_listAll(){
	global $CONN,$school_menu_p;
	//相關功能表
	$tool_bar=&make_menu($school_menu_p);
	$sql_select="select reward_div,reward_id,stud_id,reward_kind,reward_year_seme,reward_date,reward_reason,reward_c_date,reward_base,reward_cancel_date,update_id,update_ip,reward_sub,dep_id,student_sn from reward";
	$recordSet=$CONN->Execute($sql_select) or user_error("讀取失敗！<br>$sql_select",256);
	while (list($reward_div,$reward_id,$stud_id,$reward_kind,$reward_year_seme,$reward_date,$reward_reason,$reward_c_date,$reward_base,$reward_cancel_date,$update_id,$update_ip,$reward_sub,$dep_id,$student_sn)=$recordSet->FetchRow()) {
		$data.="<tr bgcolor='#FFFFFF'><td>$reward_div</td><td>$reward_id</td><td>$stud_id</td><td>$reward_kind</td><td>$reward_year_seme</td><td>$reward_date</td><td>$reward_reason</td><td>$reward_c_date</td><td>$reward_base</td><td>$reward_cancel_date</td><td>$update_id</td><td>$update_ip</td><td>$reward_sub</td><td>$dep_id</td><td>$student_sn</td><td nowrap><a href='$_SERVER[PHP_SELF]?act=modify&reward_div=$reward_div'>修改</a> | <a href='$_SERVER[PHP_SELF]?act=del&reward_div=$reward_div'>刪除</a></td></tr>";
	}
	$main="
	$tool_bar
	<table width='96%' cellspacing='1' cellpadding='3' bgcolor='#C0C0C0' class='small'>
	<tr bgcolor='#E6E9F9'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td>功能</td></tr>
	$data
	</table>";
	return $main;
}

//取得某一筆資料
function get_reward_data($reward_div){
	global $CONN;
	$sql_select="select reward_div,reward_id,stud_id,reward_kind,reward_year_seme,reward_date,reward_reason,reward_c_date,reward_base,reward_cancel_date,update_id,update_ip,reward_sub,dep_id,student_sn from reward where reward_div='$reward_div'";
	$recordSet=$CONN->Execute($sql_select) or user_error("讀取失敗！<br>$sql_select",256);
	$theData=$recordSet->FetchRow();
	return $theData;
}


?>