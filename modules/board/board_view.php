<?php
// $Id: board_view.php 7280 2013-05-06 02:24:51Z hsiao $
// --�t�γ]�w��
include "board_config.php";

session_start();

$bk_id = $_REQUEST['bk_id'];

$page = $_REQUEST['topage'];

//�]���s�W�ܼƪ��ܼƪ�l��
if ($header_text_size==3) $header_text_size=12;
if ($font_size=="") $font_size=12;

//�n�X
if ($_GET[logout]== "yes"){
	session_start();
	$CONN -> Execute ("update pro_user_state set pu_state=0,pu_time_over=now() where teacher_sn='{$_SESSION['session_tea_sn']}'") or user_error("��s���ѡI",256);
	session_destroy();
	$_SESSION[session_log_id]="";
	$_SESSION[session_tea_name]="";
	Header("Location: $_SERVER[PHP_SELF]");
}

//�O�_���W�ߪ��ɭ�
if ($is_standalone)
	include "header.php";
else
	head("�հȧG�i��");

if ($topage !="")
	$page = $topage;
$sql_select = "select  a.b_id from board_p a,board_kind b where ";
if ($bk_id!="")
	$sql_select .= " a.bk_id='$bk_id' ";
else
	$sql_select .= " to_days(a.b_open_date)+ a.b_days > to_days(curdate()) and b.board_is_public=1 ";

$sql_select .= " and a.bk_id = b.bk_id order by a.b_open_date desc ,a.b_post_time desc ";
$result = $CONN->Execute($sql_select)or die ($sql_select);
$tol_num= $result->RecordCount();
if ($tol_num % $page_count > 0 )
	$tolpage = intval($tol_num / $page_count)+1;
else
	$tolpage = intval($tol_num / $page_count);

$sql_select = "select  a.* from board_p a,board_kind b where ";
if ($bk_id != "")
	$sql_select .= " a.bk_id='$bk_id' ";
else
	$sql_select .= " to_days(a.b_open_date)+ a.b_days > to_days(curdate()) and b.board_is_public=1 ";

//���ϥ����w�B�ǥB�n���w���i���
if(! $bk_id and $m_arr["display_limit"]) $sql_select .= " and to_days(a.b_open_date)<=to_days(curdate())";
	
$sql_select .= " and a.bk_id = b.bk_id order by a.b_open_date desc ,a.b_post_time desc ";
$sql_select .= " limit ".($page * $page_count).", $page_count";
$result = $CONN->Execute($sql_select)or die ($sql_select);

$temp_con="";
while ($row = $result->fetchRow()){
	$bb_id = $row["b_id"];
	$bkk_id = $row["bk_id"];
	$b_open_date = $row["b_open_date"];
	$b_days = $row["b_days"];
	$b_unit = $row["b_unit"];
	$b_title = $row["b_title"];
	$b_name = $row["b_name"];
	$b_sub = $row["b_sub"];
	$b_hints = $row["b_hints"];
	$b_upload = $row["b_upload"];
	$b_own_id = $row["b_own_id"];
	$b_post_time = $row["b_post_time"];
	$b_is_intranet = $row["b_is_intranet"];
	$teacher_sn = $row["teacher_sn"];
	$b_is_sign = $row['b_is_sign'];

	if ($b_is_intranet == "1") //�������
		$b_i_temp = "<img src=\"images/school.gif\" alt=\"�դ����\" border=0>";
	else
		$b_i_temp ="";

	if ($b_is_sign == "1") //ñ�����
		$b_sign_temp = "<img src=\"images/sign.png\" alt=\"ñ�����\" border=0>";
	else
		$b_sign_temp ="";

	$bgcolor =($i++ % 2)?$table_bg_color:"#".dechex((float) hexdec($table_bg_color)+$offset_color);
	$temp_con .="<tr bgcolor='$bgcolor' onMouseOver=setBG('$record_bg_color',this) onMouseout=setBGOff('$bgcolor',this) onFocus=setBG('$record_bg_color',this) onBlur=setBGOff('$bgcolor',this) style='text-height:$record_height pt;text-align:center;color:$record_text_color;font-size:$font_size pt;'>";

	//�ˬd�O�_���������(�إߪ̡B�t�κ޲z�����i�ݨ��������)
//	if (($b_is_intranet== 0 ) || ($b_own_id == $_SESSION[session_log_id] )|| (checkid($_SERVER[SCRIPT_FILENAME],1)) || ($b_is_intranet == '1' && check_home_ip())){
	//if (($b_is_intranet== 0 ) || ($teacher_sn == $_SESSION[session_tea_sn] )|| (checkid($_SERVER[SCRIPT_FILENAME],1)) || ($b_is_intranet == '1' && $is_home_ip)){
	if (($b_is_intranet== 0 ) || isset($_SESSION[session_tea_sn] )|| (checkid($_SERVER[SCRIPT_FILENAME],1)) || ($b_is_intranet == '1' && $is_home_ip)){
		$temp_con .= sprintf("<td nowrap>%s</td><td style='text-align:left;'><a href=\"board_show.php?b_id=%d\">%s</a> $b_i_temp $b_sign_temp</td><td nowrap>%s</td>",$b_open_date,$bb_id,$b_sub,$b_unit);
	} else {
		$temp_con .= sprintf("<td nowrap>%s</td><td style='text-align:left;'>%s $b_i_temp $b_sign_temp</td><td nowrap>%s</td>",$b_open_date,$b_sub,$b_unit);
	}
	if ($enable_title!="0") $temp_con .= sprintf("<td nowrap>%s</td>",$b_title);
	if ($enable_days!="0") $temp_con .= sprintf("<td nowrap>%3d</td>",$b_days);
	if ($enable_point!="0") $temp_con .= sprintf("<td>%3d</td>",$b_hints);
	$temp_con .= "</tr>\n";
}


?>
<center>
<script language="JavaScript">
<!--
function setBG(TheColor,thetable) {
thetable.bgColor=TheColor
}
function setBGOff(TheColor,thetable) {
thetable.bgColor=TheColor
}

//-->
</script>

<form action="<?php echo $_SERVER[PHP_SELF] ?>" method="get" name="bform">
<table width="95%"  >
<tr >
<td nowrap>
<select name="bk_id" onchange="document.bform.submit()">
	<option value=""><?php echo ($top_item)?$top_item:"�հȧG�i��"; ?></option>
	<option value="">�w�w�w�w�w</option>

<?php
	$query = "select bk_id,board_name from board_kind ";
	$result= $CONN->Execute($query) or die ($query);
	while( $row = $result->fetchRow()){
		if ($row["bk_id"] == $bk_id  ){
			echo sprintf(" <option value=\"%s\" selected>%s</option>",$row["bk_id"],$row["board_name"]);
			$board_name = $row["board_name"];
		}
		else
			echo sprintf(" <option value=\"%s\">%s</option>",$row["bk_id"],$row["board_name"]);
	}
	echo "</select>";
	if ($_SESSION[session_log_id] != "")
		echo "<a href=\"$_SERVER[PHP_SELF]?logout=yes\">�n�X�t��</a>";
	if ($bk_id!="")
		echo "</td><td align=center width=100%><b>".$board_name."�G�i��</b>�V<a href=\"board.php?bk_id=$bk_id\">�i�K�G�i</a></td>";
	else
		echo "</td><td align=center width=100% bgxolor=#FFFFFF>".(($title_img)?"<img src=\"$title_img\" alt=\"�հȧG�i��\">":"");


	echo "</td>";
	echo "<td align=right nowrap >";

	echo "<a href=\"board_search.php?bk_id=$bk_id\">���j�M</a>&nbsp��";
	echo " <select name=\"topage\"  onchange=\"document.bform.submit()\">";
	for ($i= 0 ; $i < $tolpage ;$i++)
		if ($page == $i)
			echo sprintf(" <option value=\"%d\" selected>%2d</option>",$i,$i+1);
		else
			echo sprintf(" <option value=\"%d\" >%2d</option>",$i,$i+1);

		echo "</select>�� /�@ $tolpage ��</td>";

	?>
</tr>
</table>
<!--�^����ܶ]���O-->
<?php
        $query = "select b_id,b_sub,b_is_intranet,b_title from board_p where b_is_marquee = '1' and to_days(b_open_date)+b_days > to_days(current_date());";
        $result = $CONN->Execute($query) or die($query);
        if ($result){
        $html_link = '<p><FONT COLOR="'.$marquee_fontcolor.'">';
        $html_link .= '<MARQUEE WIDTH="'.$table_width.'" height="'.$marquee_height.'" BEHAVIOR="'.$marquee_behavior.'" BGColor="'.$marquee_backcolor.'" direction="'.$marquee_direction.'" scrollamount="'.$marquee_scrollamount.'">';
                $query = "select b_id,b_sub,b_is_intranet,b_title from board_p where b_is_marquee = '1' and to_days(b_open_date)+b_days > to_days(current_date());";
                $result = $CONN->Execute($query) or die($query);
                while ($row = $result->fetchRow()){
                        $html_link .= '&nbsp;'.'<a href="board_show.php?b_id='.$row['b_id'].'">'.$row['b_sub'].'&nbsp;(&nbsp;'.$row['b_title'].'&nbsp;)';
                        if ($row['b_is_intranet']=='1'){
                                $html_link .= '<font color="red"><sub>�դ����</sub></font>';
                        }
                        $html_link .= '</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }
                $html_link .= '</MARQUEE></FONT></p>';
                echo $html_link;
        }
?>
<?php
echo "<font color='$header_text_color' size='8'><table width='$table_width' bgcolor='$table_bg_color'  border='$table_border_width' bordercolor='$table_border_color' cellpadding='2' cellspacing='0' style='border-collapse: collapse'>
	<tr style='color:$header_text_color;background-color:$header_bg_color;text-align:center;line-height:$header_height pt;font-size:$header_text_size pt;'>
		<td width='10%'>���i���</td>
		<td width='50%'>��  �D</td>
		<td width='10%'>��  ��</td>";
if ($enable_title!="0") echo "<td width='10%'>¾  ��</td>";
if ($enable_days!="0") echo "<td width='10%'>���i�Ѽ�</td>";
if ($enable_point!="0") echo "<td width='10%'>�I�\��</td>";

echo "</tr>";

 echo $temp_con;
?>
</table></font>

<?php
if ($bk_id=="") {//��������
	if (!$no_footer) include "board_foot.php";
} else
	echo "<br><a href=\"board_view.php\">�^�G�i��C��</a>";
?>
</center>
</form>
<?php
//�O�_���W�ߪ��ɭ�
if ($is_standalone)
	include "footer.php";
else
	foot();
?>
