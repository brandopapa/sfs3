{{* $Id: index.tpl 5310 2011-01-01 $ *}}
{{include file="$SFS_TEMPLATE/header.tpl"}}
{{include file="$SFS_TEMPLATE/menu.tpl"}}
�@�B�d�ҤΨϥΤ�k<br>
(1)�Сi<a href="javascript: msg_form()">����</a>�j�}�Ҽu�X�e���C<br>
(2)�ϥΤ�k�q�`�O�b�ն魺���]�m�@�ӥi�}�Ҽu�X���������A�W�s����m�]�w�� {{$SFS_PATH_HTML}}modules/school_msn/main_index.php</br>
��ĳ�� JavaScript ���O�p�U�G<br>
 window.open('{{$SFS_PATH_HTML}}{{$MSN_WINDOW}}','messageWindow','resizable=0,toolbar=no,scrollbars=auto');<br>
<br>
�G�B����:<br>
1.�ն�MSN�O�@�ӥi�H�ѾǮձЮv�����i��T����y���ɮ׶ǻ����Ҳ�.<br>
2.��������:�D�e�����u�X�e��, �@�]�A�|�Ӱϰ� <br>
<img src='./images/main.png' border='0'><br>
(1)�������i��: �|�۰ʧ�� sfs3 ��  board �Ҳթ� jboard �Ҳդ����̷s���i.<br>
<font color=red><b>���аO�o�]�w�Ҳ��ܼ�, �i������]�w�C</b></font><br>
(2)�դ��T����y��: �ϥΪ̵o�G���}�T����, �Ӥ��}�T���|�e�{��.<br>
(3)�u��C: �i�ާ@���U�إ\��.<br>
(4)���A��: ���ܥثe�u�X�H�n�J�v, �Y���H�o�p�T���A, �|�X�{�u<img src='./images/msg.gif' border='0'>�T��(1)�v����, �����I��Y�iŪ���p�T.<br>
<br>
3.�u��C����:<br>
(1)<img src='./images/reload.jpg' border='0'>�G���s��z�e���C<br>
(2)<img src='./images/post.jpg' border='0'>�G�o�e�T���ΤW���ɮסC<br>
(3)<img src='./images/download.jpg' border='0'>�G�U���ɮסC<br>
(4)<img src='./images/manage.jpg' border='0'>�G�޲z�T���C<br>
(5)<img src='./images/state.jpg' border='0'>�G�]�w�ۤv�����A�C<br>
(6)<img src='./images/logout.jpg' border='0'>�G�n�X�C<br>



{{include file="$SFS_TEMPLATE/footer.tpl"}}

<Script language="JavaScript">

function msg_form()
{
 flagWindow=window.open('{{$SFS_PATH_HTML}}{{$MSN_WINDOW}}','messageWindow','resizable=0,toolbar=no,scrollbars=auto');
}

</Script>