<?php
//���J�]�w��
require("config.php") ;

// �{���ˬd
sfs_check();
$_reUpgrade = 1;

head() ;  

print_menu($menu_p);
?>
<h1>���s�ɯŸ�ƪ�</h1>
<div style="margin:10px;padding:10px; background: #af6">
<p>Q : ������n���s�ɯŸ�ƪ�?</p>
<p>A : �]�t�νվ�F���~�͸�ƪ��c, �p�Q�ըt�ΨS�����`��ܲ��~�ͦW�U, �Э��s�ާ@���B�J�ɯ�</p>
</div>
<?php 
require "module-upgrade.php";
