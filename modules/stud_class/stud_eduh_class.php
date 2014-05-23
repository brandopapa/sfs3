<?php
// $Id: stud_eduh_class.php 5310 2009-01-10 07:57:56Z hami $

include "stud_reg_config.php";

sfs_check();

//���o���ЯZ�ťN��
$class_num = get_teach_class();
if ($class_num == '') {
        head("�v�����~");
        echo "<h3>�����@�~���ť��ɮv�v��</h3>";
        foot();
        exit;
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">

<style type="text/css">
<!--
TD {font-size: 10pt;}
BODY {font-size: 10pt;}

-->
</style>

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

</head>
<body>
<?php
$class_base = class_base();
$class_seme = get_class_seme();	
//�ثe�Ǧ~�Ǵ�
$seme_year_seme = $_GET[seme_year_seme];
if ($seme_year_seme=='')
	$seme_year_seme = sprintf("%03d%d",curr_year(),curr_seme());


echo "<span align=center>$school_short_name $class_seme[$seme_year_seme] -- $class_base[$class_num] �Ǵ����ɰO����</span>";
?>
<table  cellspacing=1  bgcolor="#cccccc">
 <tr bgcolor="#DBE9DC"><td>�y��</td><td>�m�W</td><td>�������Y</td><td>�a�x����</td><td>�a�x��^</td><td>���ޱФ覡</td><td>���ޱФ覡</td><td>�~����</td><td>�g�٪��p</td> <td>�̳߷R���</td><td>�̧x�����</td><td>�S��~��</td><td>����</td><td>�ͬ��ߺD</td><td>�H�����Y</td><td>�~�V�欰</td><td>���V�欰</td> <td>�ǲߦ欰</td><td>���}�ߺD</td><td>�J�{�欰</td> </tr>

<?php


$sse_relation_arr = sfs_text("�������Y");
$sse_family_kind_arr = sfs_text("�a�x����");
$sse_family_air_arr = sfs_text("�a�x��^");
$sse_farther_arr = sfs_text("�ޱФ覡");
$sse_mother_arr = sfs_text("�ޱФ覡");
$sse_live_state_arr = sfs_text("�~����");
$sse_rich_state_arr = sfs_text("�g�٪��p");

$sse_s1_arr = sfs_text("�߷R�x�����");
$sse_s2_arr = sfs_text("�߷R�x�����");
$sse_s3_arr = sfs_text("�S��~��");
$sse_s4_arr = sfs_text("����");
$sse_s5_arr = sfs_text("�ͬ��ߺD");
$sse_s6_arr = sfs_text("�H�����Y");
$sse_s7_arr = sfs_text("�~�V�欰");
$sse_s8_arr = sfs_text("���V�欰");
$sse_s9_arr = sfs_text("�ǲߦ欰");
$sse_s10_arr = sfs_text("���}�ߺD");
$sse_s11_arr = sfs_text("�J�{�欰");


$query = "select a.*,b.stud_name,b.curr_class_num from stud_seme_eduh a ,stud_base b where a.stud_id=b.stud_id and a.seme_year_seme='$seme_year_seme' and  b.curr_class_num like '$class_num%' order by b.curr_class_num ";
$recordSet = $CONN->Execute($query) or die($query);
while (!$recordSet->EOF) {

	$seme_year_seme = $recordSet->fields["seme_year_seme"];
	$stud_id = $recordSet->fields["stud_id"];
	$stud_name = $recordSet->fields["stud_name"];
	$curr_class_num = $recordSet->fields["curr_class_num"];
	$sse_relation = $sse_relation_arr[$recordSet->fields["sse_relation"]];
	$sse_family_kind = $sse_family_kind_arr[$recordSet->fields["sse_family_kind"]];
	$sse_family_air = $sse_family_air_arr[$recordSet->fields["sse_family_air"]];
	$sse_farther = $sse_farther_arr[$recordSet->fields["sse_farther"]];
	$sse_mother = $sse_mother_arr[$recordSet->fields["sse_mother"]];
	$sse_live_state = $sse_live_state_arr[$recordSet->fields["sse_live_state"]];
	$sse_rich_state = $sse_rich_state_arr[$recordSet->fields["sse_rich_state"]];	
	$sse_s1 = $recordSet->fields["sse_s1"];
	$sse_s2 = $recordSet->fields["sse_s2"];
	$sse_s3 = $recordSet->fields["sse_s3"];
	$sse_s4 = $recordSet->fields["sse_s4"];
	$sse_s5 = $recordSet->fields["sse_s5"];
	$sse_s6 = $recordSet->fields["sse_s6"];
	$sse_s7 = $recordSet->fields["sse_s7"];
	$sse_s8 = $recordSet->fields["sse_s8"];
	$sse_s9 = $recordSet->fields["sse_s9"];
	$sse_s10 = $recordSet->fields["sse_s10"];
	$sse_s11 = $recordSet->fields["sse_s11"];

	$sit_num = substr($curr_class_num,-2);
	$bgcolor = ($i++%2)?"#eeffff":"#ffffff";
	echo "<tr bgcolor='$bgcolor' onMouseOver=setBG('#AAFFCC',this) onMouseout=setBGOff('$bgcolor',this) >";
	
	echo "<td>$sit_num</td><td>$stud_name</td><td>$sse_relation</td><td>$sse_family_kind</td><td>$sse_family_air</td>
		<td>$sse_farther</td><td>$sse_mother</td><td>$sse_live_state</td><td>$sse_rich_state</td>";
	
	for($j=1;$j<=11;$j++) {
		$temp_arr = explode(",",${"sse_s".$j});
		$s_temp_arr = ${"sse_s".$j."_arr"};
		$temp_str='';
		while(list($id,$val)=each($temp_arr)){
			if ($val)
				$temp_str .= $s_temp_arr[$val].",";
		}
		echo "<td>$temp_str</td>";
	}
	echo "</tr>\n";
	$recordSet->MoveNext();
};
?>


</table>
</body>
</html>
