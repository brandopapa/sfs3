<?php
// $Id: list.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";

sfs_check();

//�q�X����
head("���@��");
print_menu($menu_p);

//��V������
$linkstr="work_year_seme=$work_year_seme&stud_class=$stud_class";
echo print_menu($MENU_P,$linkstr);

echo "<center><font size=5 color='blue'><BR><BR><BR>���@����P��n���p�⤣��SFS3�B�z�I</font></center>";
foot();
?>