<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();

//�q�X����
head("�N��J��");
print_menu($menu_p);

$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

echo "<br><br><FONT SIZE=5 color='red'>�����հѥ[���L�ϧK�դJ�ǾǮժ����O�G[ ".$school_nature_array[$school_nature]." ]";
echo "<br><br>�����վǥͰѥ[���L�ϧK�դJ�ǡA�i�o���Ť��G$school_nature</FONT>";
echo "<br><br><br><br>�����ץ��Ǯժ����O�A�Шt�κ޲z���� [�Ҳ��v���޲z] �վ㥻�Ҳժ��Ҳ��ܼ� school_nature �Y�i�I";
foot();?>