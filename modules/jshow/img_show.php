<?php
// �N���ɱq��Ʈw���X��q�X
// �o�q�{�����ϥΤ覡�� <img src="img_show.php">
// �o�ˤ~�����Φb��L�����W
// �{���}�l
include_once('config.php');

$kind_id=$_GET['kind_id'];
$id=$_GET['id'];

	$query="select * from jshow_pic where id='".$id."'";
	$res=$CONN->Execute($query) or die($query);
	$row= $res->fetchRow();	
	$filename=$row['filename'];
	
	//Ū������
	 $sFP=fopen($USR_DESTINATION.$filename,"r");							//���J�ɮ�
   $sFilesize=filesize($USR_DESTINATION.$filename); 				//�ɮפj�p
   $sFiletype=filetype($USR_DESTINATION.$filename);  				//�ɮ��ݩ�

	 $picture=fread($sFP,$sFilesize);

	 fclose($sFP);
	 
Header("Content-type: $sFiletype");
//Header("Content-type: images/gif");
// �бN��Ʈw�����Ϥ���쪺��ƨ��X�� $picture �ܼ�

echo $picture;

// �{������
?>