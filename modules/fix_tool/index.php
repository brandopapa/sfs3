<?php
//$Id: index.php 8584 2015-11-06 02:24:26Z chiming $

require_once "config.php";
//�{��
sfs_check();

//�q�X�����������Y
head("���D�u��c");

//�D�n���e
$main="";
echo $main;
print_menu($school_menu_p);

//�G������
?>
<ul>
    <font color="maroon" size="4">���ҲձM��������������
    </font>
    <p><font color="maroon" size="4">��U�B�z�U�վ��y���D�ɱM��
    </font></p>
    <p><font color="maroon" size="4">�Ǯվާ@�H����o�Ͱ��D�ɡA�Ь��ߦU�����B�z����
    </font></p>
    <p><font color="maroon" size="4">�̤��ߤH�����ܤ�i�ާ@���ҲաC
    </font></p>
    <p><font color="maroon" size="4">��sfs���y�t��</font><font color="blue" size="4"><b>��ƪ��c</b></font><font color="maroon" size="4">�P</font><font color="blue" size="4"><b>������</b></font><font color="maroon" size="4">���A�Ѫ̡A
    </font></p>
    <p><font color="maroon" size="4">�Фť��N�ާ@���ҲաA�_�h���y����ƲV�ÿ��m�C</font></p>
    <p><font color="maroon" size="4">�i<a href='fix_teacher_ID.php'>���ը����Ҧr���ˬd</a>�j</font></p>
</ul>
<p>
<?foot();
?></p>
