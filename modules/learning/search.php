<?php
                                                                                                                             
// $Id: search.php 5310 2009-01-10 07:57:56Z hami $

// --�t�γ]�w��
include "config.php"; 

	include	"header.php";
	$c_title= "<font size=5 face=�з��� color=#800000><b>$school_short_name �оǸ귽�� </b> ������Ʒj�M</font>";
?>

<table border=0 width=100%>
<form method=get name=myform action="<?php echo $PHP_SELF ?>">
<tr><td align=center>
<?php echo $c_title ?>
</td></tr>
<tr><td align=center>
<input type="text" name="s_str" maxlength=256 value="<?php echo $s_str ?>">
<input type="submit" name="key" value="�j�M">
	<INPUT TYPE="button" VALUE="�^�W�@��" onClick="history.back()"></td>
</td>
</tr>
<tr><td align=center>
���׬O���D�B���e�B�@�̩Τ���A�Ъ�����J����r<br>
�h���j�M����Шϥ� + �s�� �I
</td></tr>

</form>
</table>
<?php
if($s_str) {
	//�d�ߦr��B�z 
	
	$sstr = split ('[ +]', $s_str,10);
	while(list($tid,$tname)= each ($sstr)){
		if (chop($tname)) 
			$tempstr .= " (b_con like '%$tname%' or  b_sub like '%$tname%' or  b_name like '%$tname%'  or  b_open_date like '%$tname%') and";
	}
	$tempstr = substr($tempstr,0,-3);
	$sql_select = "select count(b_id) as cc from unit_c   where  ";
	$sql_select .= " b_days !='0' and ";    //�S���Q�R��
	$sql_select .= "($tempstr) ";

	$result = mysql_query ($sql_select)or die ($sql_select);
	$row= mysql_fetch_row($result);
	//�d���`��
	$page_count=10;
	$tol_num = $row[0];
	$totalpage= intval($tol_num/$page_count);
	if($tol_num/$page_count <> 0)
		$totalpage++;
	
	//�P�_���Ʀp�G���s�b�Τ����`�ɡA���w����
	if(!$page || $page < 1)
		$page=1;
	
	if($page > $totalpage)
		$page=$totalpage;

	$start_row = ($page-1)*$page_count;	
	$sql_select = "select a.*,b.* from unit_c a,unit_u b  where a.bk_id=b.u_id and  ";
	$sql_select .= " b_days !='0' and ";    //�S���Q�R��
	$sql_select .= "($tempstr) ";
	$sql_select .= " order by b_open_date desc limit $start_row,$page_count ";





	$result = mysql_query ($sql_select)or die ($sql_select);

	//�̫�@��
	$end_row = $page*$page_count;
	if ($end_row > $tol_num)
		$end_row= $tol_num;

	echo "<table width=100% border=0 cellpadding=2 cellspacing=0><tr><td bgcolor=green nowrap><font size=-1 color=#ffffff>�w�j�M<b>$board_kind_p[$bk_id]</b>����<b>$s_str</b>�C &nbsp; </font></td><td bgcolor=green align=right nowrap><font size=-1 color=#ffffff> �@����<b>$tol_num</b>���d�ߵ��G�A�o�O��<b>".($start_row+1)."</b>-<b>$end_row</b>�� �C �j�M�@�O<b>".get_page_time()."</b>��C</font></td></tr>";
	$link_str = "bk_id=$bk_id&s_str=".urlencode($s_str);
	echo "<tr><td colspan=2 align=right>�����G".pagesplit($page,$totalpage,5,$link_str);
	echo "</td></tr></table>";
	while($row = mysql_fetch_array($result)) {   
		$unit=$row[unit_m].$row[unit_t].$row[u_s];
		$unit_name=$row[unit_name];
		$sub=chang_word_color($sstr,$row[b_sub]);	
		$con=chang_word_color($sstr,$row[b_con],60);
		$dat=chang_word_color($sstr,$row[b_open_date]);
		$nam=chang_word_color($sstr,$row[b_name]). "�� $dat  �o��";
		echo "<a href=etoe.php?m_id=$row[b_id]&unit=$unit title=$unit_name >--($sub)</a>�@<font size=-1 color=green>$nam </font><br>"; //�����C��	
		echo "<font size=-1><b>...</b>$con<b>...</b></font><br>"; //�����C��	
//		echo sprintf("<a href=etoe.php?m_id=%s&unit=%s </a> -- <font color=green>(%s <i>%s</i>)</font><br>",$row[b_id],$unit,chang_word_color($sstr,$row[b_sub]),$board_kind_p[$row["bk_id"]],$row["b_open_date"]); //�����C��
//		echo sprintf("<font size=-1><b>...</b>%s<b>...</b></font><br>",chang_word_color($sstr,$row[b_con],60)); //�����C��		
		
	}	
}

echo"<hr>";


	include "footer.php";
?>
