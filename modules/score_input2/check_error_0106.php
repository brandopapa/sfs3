<?php
//$Id: check_error_0106.php 5922 2010-03-26 04:03:15Z hami $

include_once "../../include2/config.php";
include_once "../../include2/sfs_case_subjectscore.php";
include_once "../../include2/sfs_case_studclass.php";

//�ʺA�]�wphp ����ɶ��A�קK timeout
set_time_limit(300) ;

sfs_check();
$query = "SELECT id_sn FROM pro_check_new WHERE pro_kind_id='1' and id_kind='�Юv' and id_sn='$_SESSION[session_tea_sn]'";
$res = $CONN->Execute($query);
if ($res->RecordCount()==0){
	head("���{�����ɯ�,�гs�����ޤH���B�z");
		echo "<BR /><BR /><CENTER><H2>���Z�޲z�{�����ɯ�,�гs�����ޤH���B�z</H2></CENTER>";
	foot();
	exit;

}

?>
<html>
<meta http-equiv="Content-Type" content="text/html; Charset=Big5">
<head>
<title>���Z�ˬd</title>

</head>
<body>
<?php
if ($_GET[do_key] == "delete"){

	$query = "select min(sss_id) as min_v ,count(*) as cc,seme_year_seme,student_sn,ss_id from stud_seme_score group by seme_year_seme,student_sn,ss_id having cc >1";
	$res = $CONN->Execute($query);
	$del_str = '';
	while(!$res->EOF){
		$min_v = $res->fields[min_v];
		$seme_year_seme = $res->fields[seme_year_seme];
		$student_sn = $res->fields[student_sn];
		$ss_id= $res->fields[ss_id];
		$query = "delete from stud_seme_score where sss_id<>$min_v and seme_year_seme='$seme_year_seme' and student_sn='$student_sn' and ss_id='$ss_id'  ";
//		echo $query;exit;
		if($CONN->Execute($query))
			$del_str .= ",".$res->fields[0];
		$res->MoveNext();

	}
//	echo $del_str;
}
else if ($_GET[do_key]=='query'){
	$temp_arr = explode(",",$_GET[check_str]);
	//�R��
	if ($_GET[do_del_id]<>''){
		$query = "delete from  stud_seme_score where sss_id='$_GET[do_del_id]'";
		$CONN->Execute($query);
	}
	$query = "select * from stud_seme_score where seme_year_seme='$temp_arr[0]' and ss_id=$temp_arr[1] and student_sn=$temp_arr[2] ";
	$res2 = $CONN->Execute($query) or die($query);
	$student_sn = $res2->fields[student_sn];
	$ss_id = $res2->fields[ss_id];
	$seme_year_seme = $res2->fields[seme_year_seme];
	if ($student_sn)
		$stud_name = student_sn_to_stud_name($student_sn);
	else
		$stud_name = "�S���Ǹ�";
	if ($ss_id>0)
		$ss_name = ss_id_to_subject_name($ss_id);
	else
		$ss_name = "�S����إN��";
	$tt_arr_1 = substr($seme_year_seme,0,3);
	$tt_arr_2 = substr($seme_year_seme,-1);
	echo  "$tt_arr_1 �Ǧ~�� $tt_arr_2 �Ǵ� $stud_name $ss_name �ۦP���Z <hr>";
	echo "<table border=1><tr><td>���</td><td>���Z</td><td>�ʧ@</td></tr>";
	while(!$res2->EOF){
		$ss_score = $res2->fields[ss_score];
		$sss_id = $res2->fields[sss_id];
		echo "<tr><td>$ss_name</td><td>$ss_score</td>";
		if ($res2->RecordCount()>1)
			echo "<td><a href=\"$_SERVER[PHP_SELF]?check_str=$_GET[check_str]&do_key=query&do_del_id=$sss_id\" >�R��</a></td>";
		else
			echo "<td>-</td>";
		echo "</tr>";

		$res2->MoveNext();
	}
	echo "</table></body></html>";
	exit;
}

$query = "select count(*) as cc,seme_year_seme,student_sn,ss_id from stud_seme_score group by seme_year_seme,student_sn,ss_id having cc >1";
$res2 = $CONN->Execute($query) ;//or die($query);
$temp_check='';
$html = "";
$html_detail = "";
$is_ok=true;
if ($res2->RecordCount()>0){
	$is_ok =false;
	$html .= "<H3>������ �Ǵ����Z�@��<font color=red> ".$res2->RecordCount()."</font>���O�����_ , <a href=\"#\" onClick=\"return OpenWindow('do_print=1','list_detail')\">�d�ݸԲӸ��</a> | <a href=\"$_SERVER[PHP_SELF]?do_key=delete\" onClick=\"return confirm('$doc1_unit_name \\n�T�w�R�����Ъ����Z�ȫO�d�@��?')\">�����u�O�d�@��</a></H3>";
}

if($_GET[do_print]==1){
	while(!$res2->EOF){
		$student_sn = $res2->fields[student_sn];
		$ss_id = $res2->fields[ss_id];
		$seme_year_seme= $res2->fields[seme_year_seme];
		if ($student_sn)
			$stud_name = student_sn_to_stud_name($student_sn);
		else
			$stud_name = "�S���Ǹ�";
		$cc = $res2->fields[cc];
		if($ss_id>0)
			$ss_name = ss_id_to_subject_name($ss_id);
		else
			$ss_name = "�S����إN��";
		$tt_arr_1 = substr($seme_year_seme,0,3);
		$tt_arr_2 = substr($seme_year_seme,-1);

		$temp_str = "$tt_arr_1 �Ǧ~�� $tt_arr_2 �Ǵ� $stud_name $ss_name $test_kind $test_sort ���q �� $cc ���ۦP���Z ";
		$temp_uri = "$seme_year_seme,$ss_id,$student_sn";
		$html_detail .= "$temp_str <a href=\"#\" onClick=\"return OpenWindow('check_str=$temp_uri&do_key=query','detail')\">�d��</a> <br />";
		$res2->MoveNext();
	}
}


if($is_ok == false){
	echo $html;
	echo $html_detail;
}


//�ק� primary key
else{

	$table = "stud_seme_score";
	$temp_table = $table."_tt";
	$CONN->Execute("DROP TABLE IF EXISTS $temp_table");
	$query ="
	CREATE TABLE $temp_table (
	  sss_id bigint(20) unsigned NOT NULL auto_increment,
	  seme_year_seme varchar(6) NOT NULL default '',
	  student_sn int(10) unsigned NOT NULL default '0',
	  ss_id smallint(5) unsigned NOT NULL default '0',
	  ss_score decimal(4,2) default NULL,
 	  ss_score_memo text,
	  PRIMARY KEY  (seme_year_seme,student_sn,ss_id),
	  UNIQUE KEY sss_id(sss_id)
	) ";
	$CONN->Execute($query) or die($query);

	if ($CONN->Execute("INSERT INTO `$temp_table` SELECT * FROM `$table`")){
		$CONN->Execute("DROP TABLE $table");
		$CONN->Execute("ALTER TABLE `$temp_table` RENAME `$table`");
		$CONN->Execute("ALTER TABLE `$table` ADD `teacher_sn` SMALLINT NOT NULL");
	 	$CONN->Execute("ALTER TABLE `$table` ADD `ss_update_time` TIMESTAMP NOT NULL");

	}
	$upgrade_path = "upgrade/".get_store_path();
	$upgrade_str = set_upload_path("$upgrade_path");
	$up_file_name =$upgrade_str."score_mester_change_0106.txt";
	$temp_query = "�ק�Ǵ���ƪ��c -- by hami (2003-11-10)\n
		��s�H���G".$_SESSION['session_tea_name'].$_SESSION['session_who'];
	$fp = fopen ($up_file_name, "w");
	fwrite($fp,$temp_query);
	fclose($fd);

	$message="<table cellspacing=1 cellpadding=6 border=0 bgcolor='#FFFF35' width='80%' align='center'><tr><td align='center' bgcolor='#FFFFFF' width='90%'> �Ǵ����Z��ƪ�w��s�����I<br></td></tr></table>";
	head("��s����!!");
	echo $message;
	foot();
	exit;
}


?>
</body>
</html>
<script language="JavaScript">
	var remote=null;
	function OpenWindow(p,name){
		strFeatures ="top=10,left=20,width=500,height=200,toolbar=0,resizable=yes,scrollbars=yes,status=0";
		remote = window.open("<?php echo $_SERVER[PHP_SELF] ?>?"+p,name, strFeatures);
	if (remote != null) {
		if (remote.opener == null)
			remote.opener = self;
	}
		if (x == 1) { return remote; }
	}

	function checkok() {
	return true;
	}

</script>
