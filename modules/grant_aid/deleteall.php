<?php
// $Id: deleteall.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
sfs_check();

//���U���O
$type=($_REQUEST[type]);

//�Ǵ��O
$curr_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme_tag= sprintf("%3d�Ǧ~�ײ�%d�Ǵ�",curr_year(),curr_seme());
$act=($_POST[act]);


if($act=="�_") { header("location: index.php?type=$type"); }
else
{
//�q�X����
head("���U�Ǫ�");
echo $menu;
echo "<table width='100%' cellspacing='1' cellpadding='3' bgcolor='$hint_color'><tr><td>";
if($act=="�O")
{
        $values="delete from grant_aid where type='$type' and year_seme='$curr_year_seme'";
        $recordSet=$CONN->Execute($values) or user_error("�R�����ѡI<br>$values",256);
        echo "<center><BR><BR><BR><H2><font face='�з���'><a href='index.php?type=$type'>�w�R�����Ǵ�<$curr_year_seme_tag>�Ҧ���[$type]���U����!<br><br>�Ы����^�C�ܭ����ˬd<BR><BR></a></center>";
} else
        echo "<center><form name='delete' method='post' action='$_SERVER[PHP_SELF]'><H2><BR><BR><BR><font face='�з���'>�z�u���n�R��< $curr_year_seme_tag >��[$type]�}�C������?</font><BR><BR><input type='hidden' name='type' value='$type'><input type='radio' value='�O' name='act'>�O�@<input type='radio' value='�_' checked name='act'>�_�@<BR><BR><input type='submit' value='�@�T�@�w�@' name='go' style='font-size: 16pt; font-family: �з���; font-weight: bold'></form></center>";
}
echo "</td></tr></table>";
foot();

?>