<?php
// �N���ɱq��Ʈw���X��q�X
// �o�q�{�����ϥΤ覡�� <img src="img_show.php">
// �o�ˤ~�����Φb��L�����W
// �{���}�l
include_once('config.php');

$sn=intval($_GET['sn']);
$query="select filetype,content from resit_images where sn='".$sn."'";
$res=$CONN->Execute($query);
$filetype=$res->fields['filetype'];
$picture=$res->fields['content'];
Header("Content-type: $filetype");
//Header("Content-type: images/gif");
// �бN��Ʈw�����Ϥ���쪺��ƨ��X�� $picture �ܼ�
$picture=stripslashes(base64_decode($picture));
echo $picture;
// �{������
?>