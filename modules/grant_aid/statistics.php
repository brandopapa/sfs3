<?php
// $Id: statistics.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
sfs_check();

//�Ǯ�ID
$school_id=$SCHOOL_BASE["sch_id"];

//���U���O
$type=($_REQUEST[type]);

//�q�X����
head("���U�Ǫ�");
echo $menu;


//���o�Ǧ~�Ǵ��}�C
$year_seme_arr = get_class_seme();

//���o�������
$sql_select="select year_seme,count(*) as count,sum(dollar) as dollar from grant_aid where type='$type' group by year_seme";

$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
//print_r($recordSet->FetchRow());

while (list($year_seme,$count,$dollar)=$recordSet->FetchRow()) {
$data.="<tr bgcolor='#FFFFFF'><td align=center>$year_seme_arr[$year_seme]</td><td align=center>$count</td><td align=center>$dollar</td></tr>";
}
        $main="<table width='100%' cellspacing='1' cellpadding='3' bgcolor='$hint_color'><tr><td>
        <center><br><br><H2><font face='�з���'>�� $MODULE_PRO_KIND_NAME ��</H2><H3>[$type]�ӻ�έp��</H3>
        <br>�ǮզW�١G$school_long_name �@�@�@�ǮեN���G$school_id
        <table width='70%' cellspacing='1' cellpadding='3' bgcolor='#C0C0C0'>
        <tr bgcolor='#FFFFCC'>
        <td align=center>�Ǧ~(��)�O</td><td align=center>���U�H��</td><td align=center>���B</td></tr>$data</table><br>
        <a href='index.php?type=$type'><img border='0' src='images/back.gif'> �^�W�@��</a><br><br></center>
        </td></tr></table>";
echo $main;
foot();
?>