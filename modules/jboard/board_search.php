<?php
                                                                                                                             
// $Id: board_search.php 7728 2013-10-28 09:02:05Z smallduh $

// --�t�γ]�w��
include "board_config.php"; 
if($is_standalone)
	include	"header.php";
else
	head("�հȧG�i�d��");

?>
<table border=0 width=100%>
<form method=get name=myform action="<?php echo $PHP_SELF ?>">
<tr><td align=center><B>�հȧG�i�d��</B> &nbsp;<select name="bk_id" >
	<option value="">�������</option>

<?php
	$bk_id = $_REQUEST['bk_id'];
	$query = "select bk_id,board_name from jboard_kind ";
	$result= $CONN->Execute($query) or  trigger_error('�t�ο��~',E_USER_ERROR);
	while( $row = $result->fetchRow()){
		if ($row["bk_id"] == $bk_id  ){
			echo sprintf(" <option value=\"%s\" selected>%s</option>",$row["bk_id"],$row["board_name"]);
			$board_name = $row["board_name"];
		}
		else
			echo sprintf(" <option value=\"%s\">%s</option>",$row["bk_id"],$row["board_name"]);
	}
	echo "</select>";
?>
&nbsp;<input type="text" name="s_str" maxlength=256 value="<?php echo $s_str ?>">
&nbsp;<input type="submit" name="key" value="�j�M">&nbsp;<a href="board_view.php">�^������i�C��</a></td>
</tr>
</form>
</table>
<?php
$s_str = $_REQUEST['s_str'];
$page = $_GET['page'];
$s_str = strip_tags($s_str);
if($s_str) {
	//�d�ߦr��B�z 
	
	$sstr = split ('[ +]', $s_str,10);
	reset($sstr);
	while(list($tid,$tname)= each ($sstr)){
		if (chop($tname)) 
			$tempstr .= " (b_con like '%$tname%' or  b_sub like '%$tname%') and";
	}
	$tempstr = substr($tempstr,0,-3);
	
	
	
///mysqli	
	
	$sql_select = "select count(b_id) as cc from jboard_p  where ";
	if ($bk_id!="") 
		$sql_select .= " bk_id=? and ";
	$sql_select .= "($tempstr) ";
	
$mysqliconn = get_mysqli_conn();
$stmt = "";
$stmt = $mysqliconn->prepare($sql_select);
$stmt->bind_param('s', $bk_id);
$stmt->execute();
$stmt->bind_result($tol_num);
$stmt->fetch();
$stmt->close();
///mysqli

	/*
	$sql_select = "select count(b_id) as cc from jboard_p  where ";
	if ($bk_id!="") 
		$sql_select .= " bk_id='$bk_id' and ";
	$sql_select .= "($tempstr) ";

	$result = $CONN->Execute($sql_select)or trigger_error('�t�ο��~',E_USER_ERROR);
	$row= $result->fetchRow();
	//�d���`��
//	$page_count=5;
	$tol_num = $row[0];
	*/
	
	$totalpage= intval($tol_num/$page_count);
	if($tol_num/$page_count <> 0)
		$totalpage++;
	
	//�P�_���Ʀp�G���s�b�Τ����`�ɡA���w����
	if(!$page || $page < 1)
		$page=1;
	
	if($page > $totalpage)
		$page=$totalpage;

	//�d�߳�쪩��
	$query = "select bk_id,board_name from jboard_kind order by bk_id";
	$result = $CONN->Execute($query);
	while($row= $result->fetchRow())
		$board_kind_p [$row[0]] = $row[1];	
	
	$start_row = (($page>0?$page-1:0))*$page_count;
	
	$sql_select = "select b_id,bk_id,b_open_date,  b_unit, b_title, b_name, b_sub, b_con  from jboard_p  where ";
	if ($bk_id!="") 
		$sql_select .= " bk_id=? and ";
	$sql_select .= "($tempstr) order by b_open_date desc limit $start_row,$page_count ";

	///mysqli	
$stmt = "";
$stmt = $mysqliconn->prepare($sql_select);
$stmt->bind_param('s', $bk_id);
$stmt->execute();
$stmt->bind_result($b_id,$bk_id,$b_open_date,$b_unit,$b_title,$b_name,$b_sub,$b_con);
///mysqli
	
	
	/*
	$sql_select = "select b_id,bk_id,b_open_date,  b_unit, b_title, b_name, b_sub, b_con  from jboard_p  where ";
	if ($bk_id!="") 
		$sql_select .= " bk_id='$bk_id' and ";
	$sql_select .= "($tempstr) order by b_open_date desc limit $start_row,$page_count ";
	$result = $CONN->execute ($sql_select)or  trigger_error('�t�ο��~',E_USER_ERROR);
	*/
	
	//�̫�@��
	$end_row = $page*$page_count;
	if ($end_row > $tol_num)
		$end_row= $tol_num;

	echo "<table width=100% border=0 cellpadding=2 cellspacing=0><tr><td bgcolor=green nowrap><font size=-1 color=#ffffff>�w�j�M<b>$board_kind_p[$bk_id]</b>����<b>$s_str</b>�C &nbsp; </font></td><td bgcolor=green align=right nowrap><font size=-1 color=#ffffff> �@����<b>$tol_num</b>���d�ߵ��G�A�o�O��<b>".($start_row+1)."</b>-<b>$end_row</b>�� �C �j�M�@�O<b>".get_page_time()."</b>��C</font></td></tr>";
	$link_str = "bk_id=$bk_id&s_str=".urlencode($s_str);
	echo "<tr><td colspan=2 align=right>�����G".pagesplit($page,$totalpage,5,$link_str);
	echo "</td></tr></table>";
	
	while ($stmt->fetch()) {
	//while($row = $result->fetchRow()) {   		
		echo sprintf("<p><a href=board_show.php?b_id=%d>%s</a> -- <font color=green>(%s <i>%s</i>)</font><br>",$b_id,chang_word_color($sstr,$b_sub),$board_kind_p[$bk_id],$b_open_date); //�����C��
		echo sprintf("<font size=-1><b>...</b>%s<b>...</b></font></p>",chang_word_color($sstr,$b_con,100)); //�����C��		
		echo "</p>";
	}	
}

echo"<hr>";

if($is_standalone)
	include "footer.php";
else
	foot();
?>
