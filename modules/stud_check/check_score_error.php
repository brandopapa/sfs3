<?php
// $Id: check_score_error.php 5310 2009-01-10 07:57:56Z hami $
//���J�]�w��
include "stud_check_config.php";

//�{���ˬd
sfs_check();

if ($_GET[sel]='delete'){
	$query = "delete from stud_seme_score where seme_year_seme='$_GET[seme_year_seme]' and ss_id='$_GET[ss_id]'";
	$CONN->Execute($query);
}
	
head("���y����ˬd");
print_menu($menu_p);

$query = "select ss_id,year,semester from score_ss where enable=1 ";
$res = $CONN->Execute($query);
while(!$res->EOF){
	$seme_year_seme = sprintf("%03d%d",$res->fields[year],$res->fields[semester]);
	$temp_arr[$seme_year_seme][$res->fields[ss_id]]=1;
	$res->MoveNext();
}
$query = "select seme_year_seme,ss_id from stud_seme_score group by seme_year_seme,ss_id order by ss_id";
$res = $CONN->Execute($query);
echo "<h3>�����@�~�N�ˬd�Ǵ����Z,�妸�פJ��,�ѩ��إN�����~,�ɭP���Z��ƿ��m!!</h3>";
$temp_str ='';
while(!$res->EOF){
	$seme_year_seme = $res->fields[seme_year_seme];
	$ss_id = $res->fields[ss_id];
	if ($temp_arr[$seme_year_seme][$ss_id]<>1){
			$query = "select count(*) from stud_seme_score where seme_year_seme='$seme_year_seme' and ss_id='$ss_id'";
			$res2 = $CONN->Execute($query);
			$cc = $res2->fields[0];
			$temp_str .= "�ˬd�X�� $seme_year_seme �Ǵ����~��إN�� -- $ss_id �����~���,�@�� $cc �����,�O�_�R��? <a href=\"$_SERVER[PHP_SELF]?sel=delete&seme_year_seme=$seme_year_seme&ss_id=$ss_id\">�R�����~���</a><BR>";
			
	}
	$res->MoveNext();
}
if ($temp_str=='')
	echo "<br>���ˬd�X���~���Z���!!";
else
	echo $temp_str;

foot();

?>

