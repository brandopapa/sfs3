<?php
//$Id: chi_select.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

//�{��
sfs_check();

//�q�X�����������Y
//head("SQL �d�߻��U��");
head($sfs3_module_title);
$tool_bar=@make_menu($school_menu_p);
echo $tool_bar;

if($_POST) {
	$dNUM=range('a', 'z');
?>
<script language="JavaScript">
function get_code() {
	document.pform.body.select();
	var
	hv=document.pform.body.createTextRange();
	hv.execCommand("Copy");
}
function Do(STR) {
	var currentMessage = document.pform.body.value;
	var autoadd = document.pform.add_do;
	if(autoadd.checked==true) {
		revisedMessage = currentMessage+STR+', ';}
		else {
		revisedMessage = currentMessage+STR+' ';}

//	revisedMessage = currentMessage+STR+' ';
	document.pform.body.value=revisedMessage;
	document.pform.body.focus();
	return;
	}
</script>
<?
echo "<table width='100%' cellspacing='1' cellpadding='1' border=0 align='center' bgcolor='Silver' style='font-size:10pt'><FORM  name='pform'>";
	$array_nu=0;
	$x=count($_POST[S_DB])-1;
	$y=0;
	foreach($_POST[S_DB] as $tb_name=>$tb_cname) {
	($y==$x) ? $y_word='':$y_word=' ';
	echo "<tr bgcolor='#F2F2F2' style='color:#800000;'><TD width=100% colspan=2>����ƪ�<INPUT TYPE='checkbox' value='$tb_name ".$dNUM[$array_nu].$y_word."' onclick='Do(this.value);'  readonly> $tb_name ".$dNUM[$array_nu]." $tb_cname</TD></TR>";
	$sql_select="select * from $tb_name limit 0,1 ";
	$sql_2="select  d_field_name,d_field_cname from  sys_data_field where d_table_name='$tb_name'"; 
	$col_name=initArray("d_field_name,d_field_cname",$sql_2);
	$result = mysql_query($sql_select);
	$word_len=0;
	echo "<TR bgcolor='White'><TD colspan=2>";
	for ($i = 0; $i < mysql_num_fields($result); $i++) {
		$Field_Name=mysql_field_name($result,$i);
		($col_name[$Field_Name]!='') ? $Field_Str="(".$col_name[$Field_Name].")": $Field_Str='';
		echo "<INPUT TYPE='checkbox' NAME='".$Field_Name."' value='".$dNUM[$array_nu].".".$Field_Name."' onclick='Do(this.value);' readonly>".$Field_Name."<FONT COLOR=blue>".$Field_Str ."</FONT>&nbsp;\n";
		$word_len+=strlen($Field_Name.$Field_Str);
		$word_len+=2;
		if($word_len >=75 ) {
		echo "<BR>";$word_len=0;}
		}
	echo "</TD></TR>";
	$array_nu++;
	$y++;
}
echo "<tr bgcolor='#F2F2F2' style='color:#800000;'><TD colspan=2>�y�k�զX��&nbsp;
<INPUT TYPE='checkbox' NAME='add_do' value='T'>�۰ʥ[�J�r��?<BR>
<INPUT TYPE='button' value=',' onclick='Do(this.value);'>
<INPUT TYPE='button' value='from' onclick='Do(this.value);'>
<INPUT TYPE='button' value='where' onclick='Do(this.value);'>
<INPUT TYPE='button' value='=' onclick='Do(this.value);'>
<INPUT TYPE='button' value='order by ' onclick='Do(this.value);'>
<INPUT TYPE='button' value='desc ' onclick='Do(this.value);'>
<INPUT TYPE='button' value='group by ' onclick='Do(this.value);'>
<INPUT TYPE='button' value='like ' onclick='Do(this.value);'>
<INPUT TYPE='button' value='count()' onclick='Do(this.value);'>
<INPUT TYPE='button' value='concat( , )' onclick='Do(this.value);'>


<BR>
select a.��1,b.��2 from ��1 a ,��2 b where a.��1=b.��1 <BR>
<FONT COLOR=blue>�y������Mozilla�t�C�ɡA�����ƹ��k��ۦ�ƻs�y�k�C</FONT>
</TD></TR><TR bgcolor='White'><TD width=70%>";
echo "<textarea name='body' cols='72' rows='10'  style='border-width: 0px; background-color: rgb(230, 236, 240); font-size:14pt;font-family:Arial;'>select  </textarea><TD width=30% valign=top>
<INPUT TYPE='button' value='�ƻs�y�k' onclick='get_code();'>
<BR><INPUT TYPE='reset' value='�M���y�k'><BR>
<INPUT TYPE='button' value='��^�W��'  onclick='self.history.back();'>

";
echo "</TD></TR></FORM></TABLE>";
//wrap='VIRTUAL'

}else {
mtb();
}

foot();


// �禡��
function mtb() {
//	global $CONN;
	global $CONN,$mysql_db;
$sql_get_tables = "SHOW TABLES FROM $mysql_db ";
$rs = $CONN->Execute($sql_get_tables);
$tb_all='';
while (!$rs->EOF) {
//	echo $rs->fields[0]."<BR>";
	$tb_all[$rs->fields[0]]='';
	$rs->MoveNext(); // ���ܤU�@���O��
	}
$SQL="select d_table_name ,d_table_cname from sys_data_table ";
$rs=$CONN->Execute($SQL) or die($SQL);
$arr=$rs->GetArray();
//�D�n���e
echo "<table width='100%' cellspacing='1' cellpadding='1' border=0 align='center' bgcolor='Silver'>
<FORM METHOD=POST ACTION='$PHP_SELF'>
<tr bgcolor='white' style='color:#800000;font-size:14pt;'>
<TD colspan=4>��ܬ����p����ƪ�<BR><FONT COLOR='blue' size='2'>�H�U���ثeSFS3��Ʈw $mysql_db �� ���Ҧ���ƪ�C��</FONT></TD></tr>";
echo "<tr bgcolor='white' style='color:#800000;font-size:9pt;'>";
	(($i%2)==0) ? $v_color=$color_col[0]:$v_color=$color_col[1];

for($i=0; $i<$rs->RecordCount(); $i++) {
	$tb_all[$arr[$i][d_table_name]]=$arr[$i][d_table_cname];
}
$i=0;
echo"<tr bgcolor='white' style='color:#800000;font-size:10pt;'><td>";
$word_len=0;
foreach($tb_all as $tb_name=>$tb_cname) {
	echo "<INPUT TYPE='checkbox' NAME='S_DB[$tb_name]' value='$tb_cname'>$tb_name<FONT COLOR='blue'>$tb_cname</FONT>\n";
	$word_len+=strlen($tb_name.$tb_cname);
	$word_len+=2;
	if($word_len >=78 ) {
		echo "<BR>\n";$word_len=0;}
	$i++;
}
echo "</td></tr><tr bgcolor='white' style='color:#800000;font-size:9pt;'><td>
<INPUT TYPE='reset' value='����'><INPUT TYPE='submit'></TD></tr>
</FORM></TABLE>";
}
function initArray($F1,$F3){
global $CONN;
// ��|����F �O���� $rs ��������m(EOF�GEnd Of File)�ɡA(�Y�G�٦��O���|�����X��)
	$col=split(",",$F1);
	$rs = $CONN->Execute($F3);
	if (!$rs) {
    Return $CONN->ErrorMsg(); 
	} else {
		while (!$rs->EOF) {
//	print $rs->fields['sch_id'] . " " . $rs->fields['sch_name'];
	if(count($col)==2) {
		$index=$col[0];$val=$col[1];
		$sch_all[$rs->fields[$index]]=$rs->fields[$val]; }
	if(count($col)==3) {
		$index=$col[0];$val=$col[1];$val2=$col[2];
		$sch_all[$rs->fields[$index]]=array($val=>$rs->fields[$val],$val2=>$rs->fields[$val2]);
		};
	$rs->MoveNext(); // ���ܤU�@���O��
	}
	}
	Return $sch_all;
}

?>