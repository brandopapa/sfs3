<?php
//�s�@ zipfile ��
function get_zip($FormData){
	global $UPLOAD_PATH;
	
	$ttt = new zipfile;
	
	//author.txt
	//Ū���ɮ�
	$data = $ttt->read_file(dirname(__FILE__)."/template/author.txt");
	
	//�ɮפ��e�m��
	$temp_arr=array();
	$temp_arr["dirname"] = $FormData[dirname];
	$temp_arr["showname"] = $FormData[showname];
	$temp_arr["author"] = $FormData[author];
	$temp_arr["email"] = $FormData[email];
	$temp_arr["creat_date"] = $FormData[creat_date];
	$temp_arr["description"] = $FormData[description];
	$temp_arr["ID"] = "//\$Id\$";
	$data = $ttt->change_temp2($temp_arr,$data);
	
	//�N�ɮץ[�J zip �ɤ�
	$ttt->add_file($data,"/".$FormData[dirname]."/author.txt");

	//config.php
	$data = $ttt->read_file(dirname(__FILE__)."/template/config.php");
	$temp_arr=array();
	$temp_arr["ID"] = "//\$Id\$";
	$data = $ttt->change_temp2($temp_arr,$data);
	$ttt->add_file($data,"/".$FormData[dirname]."/config.php");
	
	//module-cfg.php
	$data = $ttt->read_file(dirname(__FILE__)."/template/module-cfg.php");
	$temp_arr=array();
	$temp_arr["showname"] = $FormData[showname];
	$temp_arr["table_name"] = $FormData[table_name];
	$temp_arr["index_page"] = $FormData[index_page];
	$temp_arr["lable"] = $FormData[lable];
	$temp_arr["creat_date"] = $FormData[creat_date];
	$temp_arr["ID"] = "//\$Id\$";
	$data = $ttt->change_temp2($temp_arr,$data);
	$ttt->add_file($data,"/".$FormData[dirname]."/module-cfg.php");
	
	//module.sql
	if(!empty($FormData[table_name])){
		$data = $ttt->read_file(dirname(__FILE__)."/template/module.sql");
		$temp_arr=array();
		$temp_arr["ID"] = "\$Id\$";
		$temp_arr["table_name"] = $FormData[table_name];
		$temp_arr["sql"] =table_data($FormData[table_name],$mark,0);
		$data = $ttt->change_temp2($temp_arr,$data);
		$ttt->add_file($data,"/".$FormData[dirname]."/module.sql");
	}
	
	//INSTALL
	$data = $ttt->read_file(dirname(__FILE__)."/template/INSTALL");
	$temp_arr=array();
	$temp_arr["showname"] = $FormData[showname];
	$temp_arr["install"] = $FormData[install];
	$temp_arr["ID"] = "//\$Id\$";
	$data = $ttt->change_temp2($temp_arr,$data);
	$ttt->add_file($data,"/".$FormData[dirname]."/INSTALL");
	
	//NEWS
	$data = $ttt->read_file(dirname(__FILE__)."/template/NEWS");
	$temp_arr=array();
	$temp_arr["lable"] = $FormData[lable];
	$temp_arr["creat_date"] = $FormData[creat_date];
	$temp_arr["news"] = $FormData[news];	
	$temp_arr["ID"] = "//\$Id\$";
	$data = $ttt->change_temp2($temp_arr,$data);
	$ttt->add_file($data,"/".$FormData[dirname]."/NEWS");
	
	//README
	$data = $ttt->read_file(dirname(__FILE__)."/template/README");
	$temp_arr=array();
	$temp_arr["ID"] = "//\$Id\$";
	$temp_arr["readme"] = $FormData[readme];	
	$data = $ttt->change_temp2($temp_arr,$data);
	$ttt->add_file($data,"/".$FormData[dirname]."/README");

	//�p�G�O�q��Ʈw�L�Ӫ��AŪ�����P�� index.php
	if($FormData[index_mode]=="sql"){
		$data = $ttt->read_file($UPLOAD_PATH.$FormData[table_name]."_".$FormData[index_page]);	
	}else{
		$data = $ttt->read_file(dirname(__FILE__)."/template/index.php");
	}

	$temp_arr=array();
	$temp_arr["showname"] = $FormData[showname];
	$temp_arr["ID"] = "//\$Id\$";
	$data = $ttt->change_temp2($temp_arr,$data);
	$ttt->add_file($data,"/".$FormData[dirname]."/index.php");
	
	//��Ȧs�����ɲ���
	if($FormData[index_mode]=="sql"){
		unlink($UPLOAD_PATH.$FormData[table_name]."_".$FormData[index_page]);
	}
	
	//���� zip ��
	$sss = $ttt->file();
	
	$filename=$FormData[dirname].".zip";
	
	//�e�X zip ��
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: application/zip");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

	echo $sss;
	
	exit;
	return;
}

?>
