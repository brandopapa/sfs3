<?php


//�w�]���ޤJ�ɡA���i�����C
include "config.php";




sfs_check();

head("�ۭq�˪�����");
print_menu($menu_p);


// smarty���@�ǳ]�w  -----------------------------------
$template_dir = $SFS_PATH."/".get_store_path()."/templates";

$tpl_defult=array("head"=>"prt_ps_head.htm","body"=>"prt_ps_body.htm","end"=>"prt_ps_end.htm");

//  �ۭq���˥��ɦW  -----------------------------------
$tpl_self=array("head"=>"my_prt_ps_head.htm","body"=>"my_prt_ps_body.htm","end"=>"my_prt_ps_end.htm");



?>
<H3>�p��վ㦨�Z�����q�Ϊ����d����</H3>
<HR size=1 color=red>
<P>1.�z����css�Phtml�y�k���@�ǻ{�ѡC<BR>
<P>2.�ƻs�Ҷ����T�ӽd���ɡA�ç���ɦW�C<BR>
<P>�d���ɪ���m���<?=$template_dir?>�ؿ��U�C<BR>
����<B><?=$tpl_defult[head]?></B>�B<B><?=$tpl_defult[body]?></B>�B<B><?=$tpl_defult[end]?></B>
�T���ɮסA�o�O�t�ιw�]���C<BR>
<P>�z�i�ƻs�W�z�T���ɮרç���ɦW���G<BR>
<FONT COLOR='#009900'>
<B><?=$tpl_self[head]?></B>�B<B><?=$tpl_self[body]?></B>�B<B><?=$tpl_self[end]?></B></FONT>
<P>3.�Q��CSS�PHTML�y�k�ק�<B><?=$tpl_self[body]?></B>�����e�Y�i�A�t����ɨä����n,���@�w�n���C<BR>
<P><FONT COLOR='red'>�`�N</FONT>�G��{{????}}�r�˪��F�褣�n���N���ק�A���O�{���|�Ψ쪺�ܼơC
<P>4.�N�W�z�T�ӧ�L���ɦA�Ǩ�D�����C<BR>
<P>5.�H��C�L�N�H�z���d���ɬ��D�C
<P>6.�P�ɩ�ߪ���s�z���t�ΡA�]���t�Υu�|��s�w�]�d���ɡC<BR>


<BR><BR>
<DIV style="color:blue" onclick="alert('�@�̸s�G\n���� ���K�e\n �M�s ���a��\n�G�L ������\n��� ���۶v\n�_�� ���Y�Y\n�j�� �Lڭ��');">��By ���ƿ��ǰȨt�ζ}�o�p��</DIV>
<BR><BR>
