<?php
// �N���ɱq��Ʈw���X��q�X
// �o�q�{�����ϥΤ覡�� <img src="img_show.php">
// �o�ˤ~�����Φb��L�����W
// �{���}�l
include_once('board_config.php');
$name=$_POST['filename'];
$b_id=$_POST['b_id'];
$query="select org_filename,filetype,content from jboard_files where b_id='".$b_id."' and new_filename='".$name."'";
$res=$CONN->Execute($query);
$org_filename=$res->fields['org_filename'];
$filetype=$res->fields['filetype'];
$content=$res->fields['content'];
$content=stripslashes(base64_decode($content));

	header("Content-disposition: attachment; filename=$org_filename");
	header("Content-type: $filetype");
	//header("Pragma: no-cache");
	//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק�A���� no-cache
	header("Cache-Control: max-age=0");
	header("Pragma: public");
	header("Expires: 0");

 echo $content;

// �{������
?>