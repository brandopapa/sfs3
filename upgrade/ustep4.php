<?php 
// $Id: ustep4.php 5310 2009-01-10 07:57:56Z hami $
	if ( !$conID_list = @mysql_connect ("$session_mysql_host","$session_mysql_user","$session_mysql_password")) {
		echo "�����{�Ҷi�J!!";
		exit;
	}
	
?>
<a name="this_step4">
<table border="0" >
  <tr>
    <td width="100%">
<p><b>���ɦ��\!!</b></p>
<p>sfs2.0 ��ƳW��ŦX "�Ш|������p���y�W�� 1.0 �� �ѦҳW�d"</p>
<p>�s���t�ά[�c�A�N �Ҧ��W���ɮײΤ@�m��b <font color=red> <?php echo $UPLOAD_PATH ?></font>&nbsp; 
�ؿ����A��K�{�����g�θ�ƺ��@�A
(�Ѧ� <?php echo $SFS_PATH ?>/include/config.php ���]�w)<BR>�A�ݤ�ʷh��(�ƻs) 
�즳���W���ɮץؿ��A�]�A�հȤ��i��(������)�B�Ʀ�ۥ�(����)�B�ǥͧ@�~(�@�~��)�B����Ʈw(�����)�C</p>

<p>�ާ@�B�J�G</p>
<p>���W�ǥؿ��v���G</p>
<p><span style="background-color: #CCCCFF"><pre>chmod 777 <?php echo $UPLOAD_PATH ?> </pre></span></p>
<p>�ƻs�ɮסG</p>
<p>�ҡG �հȧG�i��G</p>
<?php
	$new_path_html = $SFS_PATH_HTML;
	include "$session_sfs_path/include/config.php";	
	echo "<p><span style=\"background-color: #CCCCFF\"><pre>";
	echo "mkdir $UPLOAD_PATH"."board \n\n";
	echo "cp $path/school/board/updata/*  $UPLOAD_PATH"."board </pre></span></p>";
	echo "<p>(�ɮ׹�ڥؿ��Ѧ� $SFS_PATH/school/board/board_config.php ���]�w )</p>";
?>
<p>�{�b�A�A�i�H���� sfs2.0  <?php echo "<a href=\"$new_path_html\">$new_path_html</a>" ?></p>

</td>
  </tr>
</table>
