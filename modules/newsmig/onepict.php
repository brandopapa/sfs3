<?php
ob_start();
session_start();
include "config.php";

//�o��{���O�s�D�s�����{��, ������ sys_check���ʧ@
if ($m_arr["IS_STANDALONE"]=='0'){
	//�q�X�����������Y
	head("�s�D�o�G");
}

//�D�n���e
$op_rdsno = $_GET["rdsno"];
$op_imgname = $_GET["imgname"];
$op_imgname = substr_replace($op_imgname,"Mi",0,2);
$op_dir_url = $htmlsavepath.$op_rdsno."/";
?>

<html>
<head>
<meta http-equiv="Content-Type" content="html/text;charset=Big5">
<title>�ն�s�D�o�G</title>
</head>

<body>
<br>
<center>
<img border="2" src="<? echo $op_dir_url.$op_imgname; ?>">
</center>
<br>
<?php
if ($m_arr["IS_STANDALONE"]=='0'){
	//SFS3�G������
	foot();
}
?>

</body>

</html>
