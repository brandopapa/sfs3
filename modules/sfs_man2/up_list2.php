<?php
// $Id: up_list2.php 6577 2011-10-11 06:59:18Z brucelyc $

// �ޤJ SFS3 ���禡�w
include "../../include/config.php";
include "../../include/sfs_case_PLlib.php";

// �ޤJ�z�ۤv�� config.php ��
require "config.php";

// �{��
sfs_check();
$tool_bar=&make_menu($school_menu_p);

$act=($_POST['act'])?"{$_POST['act']}":"{$_GET['act']}";
$mod_m=($_POST['mod_m'])?"{$_POST['mod_m']}":"{$_GET['mod_m']}";
$txt=($_POST['txt'])?"{$_POST['txt']}":"{$_GET['txt']}";
$full_txt_name=($_POST['full_txt_name'])?"{$_POST['full_txt_name']}":"{$_GET['full_txt_name']}";

if ($full_txt_name<>''){
	$full_txt_name=$UPLOAD_PATH."upgrade/include/".basename($full_txt_name);
	$fd = fopen($full_txt_name,"r");
	$contents = fread ($fd, filesize($full_txt_name));
	echo "<html>
	<head>
	<meta http-equiv=\"Content-Type\" content=\"text/html; Charset=Big5\">
	</head>
	<body>
	<pre>
	 $contents;
	</pre>
	</body>
	</html>";
	exit;

}


if($act=='now'){
	//�ߧY�ɯšA�N�o�ӼҲժ��ɯ��ɤޤJ���椧
	$path=$SFS_PATH."/modules/".$mod_m."/module-upgrade.php";
	include "../".$mod_m."/module-upgrade.php";
}elseif($act=='reup'){
	//���s�ɯšA���������
	$del_file=$SFS_PATH."/data/upgrade/modules/".$mod_m."/".$txt;
	if(file_exists($del_file)) {
		unlink($del_file);
		$path=$SFS_PATH."/modules/".$mod_m."/module-upgrade.php";
		if($mod_m!="score_input") include "../".$mod_m."/module-upgrade.php";
	}
}elseif($act=="ing_now"){
	//�֤ߥߧY�ɯ�
	include "../../include/sfs_upgrade_list.php";

}elseif($act=="ing_reup"){
	//�֤߭��s�ɯ�
	//���s�ɯšA���������
	$del_file=$UPLOAD_PATH."/upgrade/include/".$txt;
		
	if(file_exists($del_file)) {
		unlink($del_file);
		include "../../include/sfs_upgrade_list.php";
	}
}

// �s�� SFS3 �����Y
head("�ҲդɯŪ��A");
echo $tool_bar;
//
// �{���X�Ѧ��}�l


//�C�X�ӤɯŪ��t�ή֤�
//�� include/upgrade_files �ؿ��U�N�Ҧ��֤߸ӤɯŪ��ɮצC�X
$ing_file=search_include_upgrade();
//print_r ($ing_file);

foreach($ing_file as $ing_val){
	//�����ɦs�b
	$ing_txt=$UPLOAD_PATH."/upgrade/include/".$ing_val;
	if(file_exists($ing_txt)) {
		$IS_REUPGRADE=$IS_REUPGRADE?"<font style='border: 2px outset #EAF6FF '><a href='{$_SERVER['PHP_SELF']}?act=ing_reup&txt=$ing_val'>���s�ɯ�</a></font>":"";
		$ing_susu=" <a href=\"$_SERVER[PHP_SELF]?full_txt_name=$ing_txt\" target=\"show_con\" onClick=\"window.open('about:blank', 'show_con','resizeable=1,scrollbars=1,width=400')\" >�w�ɯ�</a> $IS_REUPGRADE";
		$ing_val_str.=$ing_val.$ing_susu."<br><font color='red'>��s�ɶ��G".date("Y-m-d H:i:s",filemtime($ing_txt))."</font><p>";
	}
	else {
		$ing_susu="���ɯ� <font style='border: 2px outset #EAF6FF '><a href='{$_SERVER['PHP_SELF']}?act=ing_now'>�ߧY�ɯ�</a></font>";
		$i_str=array();
		$i_str=explode(".",$ing_val);
		$ing_val_str.=$i_str[0]." ".$ing_susu."<p>";
	}

}

$IL="<tr bgcolor='#FFFFFF' onmouseover=\"style.background='#FFF6BA'\" onmouseout=\"style.background='#FFFFFF'\"><td>include</td><td>�t�ή֤�</td><td nowrap>$ing_val_str</td></tr>";



//�C�X�ҸӤɯŪ��Ҳ�
//�j�Mmodule�U�C�@�ӼҲլO�_�� module-upgrade.php �o���ɮצs�b/home/apache/htdocs/sfs3_stable/sfs3/modules/sfs_man2/up_list2.php
$dir_name = realpath ("../../modules");//������|
$all_upg_mods=search_upgrade_module($dir_name);//�}�C�A�Ҧ��ӤɯżҲ�
//print_r($all_upg_mods);
$ady_upg_mods=already_upgrade_module();
foreach($ady_upg_mods as $ady1){
	$aa=explode("/",$ady1);
	$new_ady_upg_mods[mn][]=$aa[0];
	$new_ady_upg_mods[$aa[0]][]=$aa[1];
}

//print_r($ady_upg_mods);

foreach($all_upg_mods as $val){
	$susu="";

	if(in_array($val[p2],$new_ady_upg_mods[mn])){
		//�Y�w�ɯūh��ܥX������

		foreach($new_ady_upg_mods[$val[p2]] as $vv) {
			$full_txt_name=$UPLOAD_PATH."upgrade/modules/".$val[p2]."/".$vv;
			if($val[p2]=="score_input") $susu.=$vv." �w�ɯ� <font style='border: 2px outset #EAF6FF '><a href='{$_SERVER['PHP_SELF']}?act=reup&mod_m={$val[p2]}&txt=$vv'>�R��������</a></font><br><font color='red'>��s�ɶ��G".date("Y-m-d H:i:s",filemtime($full_txt_name))."</font><p>";
			else{
				$IS_REUPGRADE=$IS_REUPGRADE?"<font style='border: 2px outset #EAF6FF '><a href='{$_SERVER['PHP_SELF']}?act=reup&mod_m={$val[p2]}&txt=$vv'>���s�ɯ�</a></font>":"";
				
				
				$susu.=$vv." <a href=\"$_SERVER[PHP_SELF]?full_txt_name=$full_txt_name\" target=\"show_con\" onClick=\"window.open('about:blank', 'show_con','resizeable=1,scrollbars=1,width=400')\" >�w�ɯ� </a>$IS_REUPGRADE<br><font color='red'>��s�ɶ��G".date("Y-m-d H:i:s",filemtime($full_txt_name))."</font><p>";
				}
		}

	}
	else {
		if($val[p2]=="score_input") $susu="���ɯ� �A<font color='#FF827E'>�Ъ����ާ@�Ҳնi��ɯ�</font><p>";

		else $susu="���ɯ� <font style='border: 2px outset #EAF6FF '><a href='{$_SERVER['PHP_SELF']}?act=now&mod_m={$val[p2]}'>�ߧY�ɯ�</a></font><p>";
	}

	$ML.="<tr bgcolor='#FFFFFF' onmouseover=\"style.background='#FFF6BA'\" onmouseout=\"style.background='#FFFFFF'\"><td>$val[p2]</td><td>$val[msg]</td><td nowrap>$susu</td></tr>";
}

$main="
<table  BORDER=0 CELLPADDING=10 CELLSPACING=1 BGCOLOR='#E6E6FA' WIDTH='100%' ALIGN='CENTER'><tr bgcolor='#B6BFFB'><td width='25%'>�^��W�١]�֤ߡ^</td><td width='25%'>����W��</td><td>���A</td></tr>
	$IL
</table>
<table  BORDER=0 CELLPADDING=10 CELLSPACING=1 BGCOLOR='#E6E6FA' WIDTH='100%' ALIGN='CENTER'><tr bgcolor='#B6BFFB'><td width='25%'>�^��W�١]�Ҳա^</td><td width='25%'>����W��</td><td>���A</td></tr>
	$ML
</table>";



echo "<table  BORDER=0 CELLPADDING=10 CELLSPACING=2 class='main_body' WIDTH='100%' ALIGN='CENTER'>
			<tr bgcolor='#FFFFFF'>
				<td>$main</td>
			</tr>
		</table>";
// SFS3 ������
foot();



//�Ҧ��ӤɯŪ��Ҳ�
function  search_upgrade_module($dir_name){
		global $upg_mods,$ikey;
		if(!$ikey) $ikey=0;
        $d  =  dir($dir_name);
        while($entry  =  $d->read()){
                if($entry=="."  ||  $entry=="..")  continue;
                $ddir_name=$dir_name."/".$entry;
				//echo $ddir_name."<br>\n";
                if(is_dir($ddir_name)){
					search_upgrade_module($ddir_name);
                }else{//�Y���ɮ�
					if(basename($ddir_name)=="module-upgrade.php"){
						//�O�_���з���
						$cfg=dirname($ddir_name)."/module-cfg.php";
						 if(file_exists($cfg)){
						 	$ar=explode("/",$ddir_name);
							$in=count($ar)-2;
							$upg_mods[$ikey][p2]=$ar[$in];
							//�O�U������|
							//echo $ddir_name;
							$upg_mods[$ikey][path]=$ddir_name;
							//��module-cfg��X�Ҳլ������
							include $cfg;
							$upg_mods[$ikey][msg]=$MODULE_PRO_KIND_NAME;
							$ikey++;
						}
					}
                }
        }
        $d->close();
		return $upg_mods;
}

//�w�g�ɯŪ��Ҳ�
function  already_upgrade_module(){
	global $UPLOAD_PATH;
	$module_path=$UPLOAD_PATH."upgrade/modules";
	$d  =  dir($module_path);
	$i=0;
	while($entry  =  $d->read()){
		if($entry=="."  ||  $entry=="..")  continue;
		$module_path2=$module_path."/".$entry;
		$dd  =  dir($module_path2);
		while($entry2 = $dd->read()){
			if($entry2=="."  ||  $entry2=="..")  continue;
			$module_path3=$module_path2."/".$entry2;
			$aum[$i]=$entry."/".$entry2;
			$i++;
		}
	}
	$d->close();
	return $aum;

}

//�ӤɯŪ��֤��ɮ�
function search_include_upgrade(){
	global $SFS_PATH;
	$dir_name=$SFS_PATH."/include/upgrade_files";
	$d  =  dir($dir_name);
	$i=0;
	while($entry  =  $d->read()){
        if($entry=="."  ||  $entry=="..")  continue;
        $ddir_name=$dir_name."/".$entry;
		//echo $ddir_name."<br>\n";
        if(is_file($ddir_name)) {
			$include_up[$i]=substr(basename($ddir_name),2,4)."-".substr(basename($ddir_name),6,2)."-".substr(basename($ddir_name),8,2).".txt";
			$i++;
		}
	}
    $d->close();
	return $include_up;
}
?>
