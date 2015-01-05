<?php
//$Id: supply.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";
sfs_check();
//���o���O�}�C
$abs_kind_arr=tea_abs_kind();

// �P�_�O�_���޲z�v��
$isAdmin = (int)checkid($_SERVER[SCRIPT_FILENAME],1);

if ($_POST[d_check]==1) {
	$query1=" a.year='$sel_year'";
	$sel="���Ǧ~";
}else {
	$query1 = " a.year='$sel_year' and a.semester='$sel_seme' ";
	$sel = "�� " . $sel_seme . " �Ǵ�";
}

// �ץX�B�z
if ($isAdmin && isset($_POST['mode']) and $_POST['mode'] == 'export-csv') {

	if ($_POST[month] ) {
		$query1 .=" and a.month='$_POST[month]'";
	}
	$sql_select="SELECT  a.*, t.teach_id,t.name, t.teach_person_id, d.title_name FROM teacher_absent  a , teacher_base t, teacher_post c, teacher_title d
			WHERE a.teacher_sn=t.teacher_sn AND t.teacher_sn=c.teacher_sn AND c.teach_title_id=d.teach_title_id AND
		     a.check4_sn>0 and " .$query1 ;
	$sql_select .=" order by d.rank, a.start_date  desc ";
	$result = $CONN->Execute($sql_select) or die($sql_select);
	$arr = array();
	foreach ($result as $row) {
		$tempArr = array();
		$tempArr[] = $row['teach_person_id'];
		$tempArr[] = $row['name'];
		$tempArr[] = $row['teach_id'];
		$tempArr[] = $absExportIdArr[$abs_kind_arr[$row['abs_kind']]];
		$tempArr[] = $abs_kind_arr[$row['abs_kind']];
		$startDate = explode(' ',$row['start_date']);
		$startDate2 = explode('-', $startDate[0]);
		$tempArr[] = ($startDate2[0]-1911).$startDate2[1].$startDate2[2];

		$endDate = explode(' ',$row['end_date']);
		$endDate2 = explode('-', $endDate[0]);
		$tempArr[] = ($endDate2[0]-1911).$endDate2[1].$endDate2[2];

		$startTime = explode(':', $startDate[1]);
		$tempArr[] = $startTime[0].$startTime[1];

		$endTime = explode(':', $endDate[1]);
		$tempArr[] = $endTime[0].$endTime[1];

		$tempArr[] = ($row['day']?$row['day'].'��':'').($row['hour']?($row['hour']%8).'��':'');

		$tempArr[] = '';
		$tempArr[] = $row['locale'];
		// �����㤽���ʽ�A�L���
		$tempArr[] = '';
		// �ӽа���ȹC�ɧU, �L���
		$tempArr[] = '';

		$arr[] = '"'.implode('","' ,$tempArr).'"';

	}
	$filename = '�а�������.csv';
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: text/x-csv");
	//header("Pragma: no-cache");
	//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק�
	header("Cache-Control: max-age=0");
	header("Pragma: public");
	header("Expires: 0");

	echo implode("\n", $arr);

	exit;
}


head("�t���έp");
$tool_bar=make_menu($school_menu_p);
echo $tool_bar;




//��ܾǴ�
$year_seme_menu=year_seme_menu($sel_year,$sel_seme);

//��ܬO�_���Ǧ~
$check_arr=array("1"=>"���Ǧ~");
$d_check_menu=d_make_menu("��ܽd��",$_POST[d_check] , $check_arr,"d_check",1); 
//��ܤ��
$month=month_menu($_POST[month],$month_arr); 

//����
//$query1=" year='$sel_year' and semester='$sel_seme' ";





if ($_POST[month] ) {
$query1 .=" and a.month='$_POST[month]'";
}

?>

<table width=100% border=0 cellspacing=1 cellpadding=4 >
	<form name='menu_form' method='post' action='<?php echo $_SERVER['PHP_SELF']?>'>
<tr>
<td> <?php echo $year_seme_menu. $d_check_menu. $month ?>
<?php if ($isAdmin):?><input type="button" class="button" id="export-btn" value="�ץX�H���`���榡(CSV ��)" />
<span style="padding: 3px"><span style="background: #FFFF00;">�ץX����</span>: �L�k�ץX"�����㤽�t�ʽ�" �� "�O�_�ӽа���ȹC�ɧU"������</span>
<?php endif ?>
</td>
</tr>
		<?php
//���o�Юv�}�C
$tea_name_arr=my_teacher_array();
//$tea_name_arr=get_teacher_name();

$t=count($tea_name_arr);
$a=count($abs_kind_arr);
//$s_day=new array;
//$s_hour=new array;

$abs_month= $month_arr[$_POST[month]];
if ($isAdmin)
echo "<tr bgcolor=#cccccc><td> $sel_year  �Ǧ~�� $sel   $abs_month  (����) </td></tr>";
else 
echo "<tr bgcolor=#cccccc><td> $sel_year  �Ǧ~�� $sel   $abs_month  (���B��) </td></tr>";

$main="<tr><tr><table border=0 cellspacing=1 cellpadding=4 width=100% bgcolor=#cccccc class='main_body' >
	<tr bgcolor=#E1ECFF align=center><td>�m�W</td><td>¾��</td>";
$i=0;
while (list($key, $val) = each($abs_kind_arr) ){
	$i++;
	$abs[$i]=$key;	
	$main.="<td> $val </td>";
}
$main.="</tr>";
echo $main;

$query="select a.teacher_sn,a.name,d.title_name from teacher_base a,teacher_post c, teacher_title d WHERE
	a.teach_condition=0  AND c.teacher_sn=a.teacher_sn AND c.teach_title_id=d.teach_title_id  order by  d.rank";

//Ū�����
if ($isAdmin) {
	$sql_select="SELECT  a.*, t.name, d.title_name FROM teacher_absent  a , teacher_base t, teacher_post c, teacher_title d  
			WHERE a.teacher_sn=t.teacher_sn AND t.teacher_sn=c.teacher_sn AND c.teach_title_id=d.teach_title_id AND
		     a.check4_sn>0 and " .$query1 ;
	$sql_select .=" order by d.rank, a.start_date  desc ";
}
else {
	$query = "SELECT * FROM teacher_post WHERE teacher_sn={$_SESSION['session_tea_sn']}";
	$res=$CONN->Execute($query);
	$user_post_office = $res->fields['post_office'];
	$sql_select="SELECT  a.*, t.name, d.title_name FROM teacher_absent  a , teacher_base t, teacher_post c, teacher_title d
			WHERE a.teacher_sn=t.teacher_sn AND t.teacher_sn=c.teacher_sn AND c.teach_title_id=d.teach_title_id AND
		     a.check4_sn>0 and c.post_office=$user_post_office and " .$query1 ;
	$sql_select .=" order by d.rank, a.start_date  desc ";
	
}

$result = $CONN->Execute ($sql_select) or die($sql_select) ;
$tempArr = array();

while (!$result->EOF) {
		$teacher_sn=$result->fields["teacher_sn"];
		$t_post_k[$teacher_sn]=$result->fields["post_k"];
		$abs_kind=$result->fields["abs_kind"];
		$s_day[$teacher_sn][$abs_kind]+=$result->fields["day"];
		$s_hour[$teacher_sn][$abs_kind]+=$result->fields["hour"];
		$tempArr[] = $teacher_sn;
		$result->MoveNext();		
}
$tea_name_arr2 = array();
foreach ($tea_name_arr as $id=>$val) {
	if (in_array($id, $tempArr))
		$tea_name_arr2[$id] = $val;
}
while (list($key, $val) = each($tea_name_arr2) ){
	$post_k=teacher_post_k($key);
	$main="<tr bgcolor=#ddddff align=center OnMouseOver=sbar(this) OnMouseOut=cbar(this)><td > $val</td><td>$post_kind[$post_k]</td>";
	for ($i = 1; $i <= $a; $i++) {
		$m_day=$s_day[$key][$abs[$i]]+intval($s_hour[$key][$abs[$i]]/8);
		$m_hour=($s_hour[$key][$abs[$i]] % 8);
		$day_s=($m_day==0)?"":$m_day ."��";
		$hour_s=($m_hour==0)?"":$m_hour ."��";
		
   	 	$main.="<td >$day_s$hour_s</td>";
	
	}
	$main.="</tr>";
	echo $main;
}

echo "</table></td></tr>
<input type='hidden' id='mode' name='mode'/>
</form></table>";
foot();
?>
<script language="JavaScript1.2">

<!-- Begin
$(function(){
	$("#export-btn").click(function(){
		$("#mode").val('export-csv');
		$("form[name='menu_form']").submit();
	});
});

function sbar(st){st.style.backgroundColor="#F3F3F3";}

function cbar(st){st.style.backgroundColor="";}

//  End -->

</script>

