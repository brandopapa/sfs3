<?php
// $Id: batchadd.php 7301 2013-06-05 14:26:52Z infodaes $

include "config.php";
sfs_check();

//���U���O
$type=($_REQUEST[type]);

//�ؼШ���t_id
$type_id=($_POST[type_id])?$_POST[type_id]:$_GET[type_id];
if($type_id=='') $type_id='9';

//�Ǵ��O
$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());

//�q�X����
head("���U�Ǫ�");
echo $menu;

// ���X�Z�Ű}�C
//$class_base = class_base($curr_year_seme);

//�]�w��V���O�ﶵ��
$col=5;

//���o�Ǧ~�Ǵ��}�C
$year_seme_arr = get_class_seme();

//���o�ǥͨ����C��
$type_select="SELECT d_id,t_name FROM sfs_text WHERE t_kind='stud_kind' AND d_id>0 order by t_order_id";

$recordSet=$CONN->Execute($type_select) or user_error("Ū�����ѡI<br>$type_select",256);
while (list($d_id,$t_name)=$recordSet->FetchRow()) {
        if($recordSet->currentrow() % $col==1) $data.="<tr bgcolor='#FFFFFF'>";
        //�]�w�x�s�橳��
        $pos = strpos($t_name, $keyword);
		/*  �M���w�]���O����
        //if ($pos === false) $bgcolor="#FFFFFF";  else  $bgcolor="$hint_color";
        if($target_id[$type]==$d_id){
		$bgcolor="$hint_color";  $checked="checked";
        } else {
		$bgcolor="#FFFFFF";   $checked="disabled";
        }
        */
        $data.="<td bgcolor='$bgcolor'><input type='checkbox' name='sel_stud[]' value='$d_id' id='stud_sel' $checked>$t_name</td>\n";
        if($recordSet->currentrow() % $col==0  or $recordSet->EOF) $data.="</tr>";
}

//        <tr bgcolor='#FFCCFF'><td colspan=$col align='center'><BR><h2><font face='�з���'><< �п���n�}�C���ǥͨ������O >></h2></td></tr>

$main="<table width='100%' cellspacing='1' cellpadding='3' bgcolor='$hint_color'>
        <form name=\"sel_stud\" method=\"post\" action=\"batchinsert.php\">
        <tr><td colspan=5><center><img border='0' src='images/pin.gif'>������Ǧ~(��)�G$year_seme_arr[$curr_year_seme]�@�@�@�@�@<a href='index.php?type=$type&work_year_seme=$curr_year_seme'><img border='0' src='images/back.gif'> �^�W�@��</a></center></td></tr>
        $data
        <tr><td colspan=$col align='center'>
                <input type='hidden' name='curr_year_seme' value='$curr_year_seme'>
                <input type='hidden' name='type' value='$type'>
                �@���B�G<input type='text' name='dollar' size='5' value=$dollars>
                <input type='submit' value='�W�C�Ŀ����O���ǥ�' name='B1'>
        </td></tr></form>
        </table>";

echo $main;


foot();

?>