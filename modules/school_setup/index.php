<?php

// $Id: index.php 6172 2010-09-18 08:49:51Z brucelyc $

// ���J�]�w��
include "school_base_config.php";

// �{���ˬd
sfs_check();

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

// �ˬd php.ini �O�_���} file_uploads ?
check_phpini_upload();

$sch_attr_p = array("����","�p��");
$sch_mark_p = array("���`","�o��","��W","����ۥ�");
$sch_class_p = array("�@��a��","�����a��","�S���a��");
$sch_montain_p = array("�_","�O");


// ���ɥؿ�
$file_dir = $UPLOAD_PATH."/school";

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

//����ʧ@�P�_
if($act=="�x�s�Ǯո��"){
	save_school_setup($school);
	header("location: {$_SERVER['PHP_SELF']}");
}else{
	$main=main_sett_form($sel_year,$sel_seme);
}


//�q�X����
head("�Ǯհ򥻸�Ƴ]�w");
echo $main;
foot();


function main_sett_form(){
	global $sch_attr_p,$sch_montain_p,$sch_mark_p,$sch_class_p,$UPLOAD_URL,$school_menu_p;

	//���o�Ǯո��"
	$school=get_school_setup();

	//���p�߳]�w
	$sch_attr_p_option="";
	for($i=0;$i<sizeof($sch_attr_p);$i++){
		$selected=($school["sch_attr_id"] == $sch_attr_p[$i])?"selected":"";
		$sch_attr_p_option.="<option value='$sch_attr_p[$i]' $selected>$sch_attr_p[$i]";
	}
	
	//�����]�w
	$sch_sheng_p = birth_state();
	$sch_sheng_option="";
	while(list($key,$value)=each($sch_sheng_p)){
		$selected=($school["sch_sheng"] == $value)?"selected":"";
		$sch_sheng_option.="<option value='$value' $selected>$value";
	}

	//�s�a�ѧO�]�w
	$sch_montain_option="";
	for($i=0;$i<sizeof($sch_montain_p);$i++){
		$selected=($school["sch_montain"] == $sch_montain_p[$i])?"selected":"";
		$sch_montain_option.="<option value='$sch_montain_p[$i]' $selected>$sch_montain_p[$i]";
	}

	//���O�]�w
	$sch_mark_p_option="";
	for($i=0;$i<sizeof($sch_mark_p);$i++){
		$selected=($school["sch_mark"] == $sch_mark_p[$i])?"selected":"";
		$sch_mark_p_option.="<option value='$sch_mark_p[$i]' $selected>$sch_mark_p[$i]";
	}
	
	//�ŧO�]�w
	$sch_class_p_option="";
	for($i=0;$i<sizeof($sch_class_p);$i++){
		$selected=($school["sch_class"] == $sch_class_p[$i])?"selected":"";
		$sch_class_p_option.="<option value='$sch_class_p[$i]' $selected>$sch_class_p[$i]";
	}
	
	//�����\���
	$tool_bar=make_menu($school_menu_p);

	//���o upload ���D�ɦW����
	$fileurl=$UPLOAD_URL;

	$main="
	<script language='JavaScript'>
		<!--
		var writeWin = null;

		function writeLeft(pic) {
		writeWin = window.open('','aWin','scrollbars,resizable,top=0,left=0,height=480,width=640');

		var ePen = \"<html><head><title>���ɮi��</title></head> \";
		ePen +=  \"<body text='#666666' bgcolor='#ffffff'> \";
		ePen +=  '<center><img src=\"".$UPLOAD_URL."school/'+pic+'\"></center></body></html>';

		var wd = writeWin.document;

		wd.open();
		wd.write(ePen);
		wd.close();
		}

		function blowOut() {
		if (writeWin != null && writeWin.open) writeWin.close();
		}
		window.onfocus=blowOut;
		// -->
	</script>

	$tool_bar
	<table cellspacing='1' cellpadding='3' class='main_body'>
	<form method='post' action='{$_SERVER['PHP_SELF']}' encType='multipart/form-data' >
	<tr>
		<td class='title_sbody2'  colspan='4' bgcolor=#cccccc><input type='submit' name='act' value='�x�s�Ǯո��'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�ǮեN�X�]�Ш|���^</td>
		<td><input type='text' size='6' maxlength='6' name='school[sch_id]' value='$school[sch_id]'>
		<a href='http://sfs.wpes.tcc.edu.tw/school/qid.php' target=new>�d��</a></td>
		<td class='title_sbody1'>�ݩ�</td>
		<td>
		<select name='school[sch_attr_id]'>
		<option value=''>
		$sch_attr_p_option
		</select>
		</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>����W�١]���Ρ^</td>
		<td colspan='3'><input type='text' size='40' maxlength='40' name='school[sch_cname]' value='$school[sch_cname]'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>����W�١]²�١^</td>
		<td colspan='3'><input type='text' size='40' maxlength='40' name='school[sch_cname_s]' value='$school[sch_cname_s]'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>����W�١]�u�١^</td>
		<td colspan='3'><input type='text' size='40' maxlength='40' name='school[sch_cname_ss]' value='$school[sch_cname_ss]'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�^��W��</td>
		<td colspan='3'><input type='text' size='40' maxlength='60' name='school[sch_ename]' value='$school[sch_ename]'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�����O</td>	
		<td>
		<select name='school[sch_sheng]'>
		<option value=''>
		$sch_sheng_option
		</select>	
		</td>
		<td  class='title_sbody1' >�]�դ���]�褸�^</td>
		<td><input type='text' size='10' maxlength='10' name='school[sch_cdate]' value='$school[sch_cdate]'>�]�ҡG1918-7-1�^</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>���O</td>
		<td>
		<select name='school[sch_mark]'>
		<option value=''>
		$sch_mark_p_option
		</select>
		</td>	
		<td  class='title_sbody1'>�ŧO</td>
		<td>
		<select name='school[sch_class]'>
		<option value=''>
		$sch_class_p_option
		</select>
		</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�s�a�ѧO</td>
		<td>
		<select name='school[sch_montain]'>
		<option value=''>
		$sch_montain_option
		</select>	
		</td>
		<td  class='title_sbody1'>�զa�`���n</td>
		<td><input type='text' size='10' maxlength='10' name='school[sch_area_tol]' value='$school[sch_area_tol]'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�զa�`�����n</td>
		<td><input type='text' size='10' maxlength='10' name='school[sch_area_ext]' value='$school[sch_area_ext]'></td>
		<td  class='title_sbody1'>�ةW���n</td>
		<td><input type='text' size='10' maxlength='10' name='school[sch_area_pin]' value='$school[sch_area_pin]'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�ꥻ����X</td>
		<td><input type='text' size='10' maxlength='10' name='school[sch_money]' value='$school[sch_money]'> ��</td>
		<td  class='title_sbody1'>�g�`����X</td>
		<td><input type='text' size='10' maxlength='10' name='school[sch_money_o]' value='$school[sch_money_o]'> ��</td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�m���ϧO</td>
		<td><input type='text' size='10' maxlength='10' name='school[sch_local_name]' value='$school[sch_local_name]'></td>
		<td  class='title_sbody1'>�l���ϸ�</td>
		<td><input type='text' size='5' maxlength='5' name='school[sch_post_num]' value='$school[sch_post_num]'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�Ǯզa�}</td>
		<td colspan='3'><input type='text' size='60' maxlength='60' name='school[sch_addr]' value='$school[sch_addr]'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�Ǯչq��</td>
		<td><input type='text' size='20' maxlength='20' name='school[sch_phone]' value='$school[sch_phone]'></td>
		<td  class='title_sbody1'>�Ǯնǯu</td>
		<td><input type='text' size='20' maxlength='20' name='school[sch_fax]' value='$school[sch_fax]'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�Ǯզ�F��</td>
		<td><input type='text' size='20' maxlength='20' name='school[sch_area]' value='$school[sch_area]'></td>
		<td  class='title_sbody1'>�Ǯ�����</td>
		<td><input type='text' size='6' maxlength='6' name='school[sch_kind]' value='$school[sch_kind]'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�Ǯպ��}</td>
		<td>http:// <input type='text' size='20' maxlength='50' name='school[sch_url]' value='$school[sch_url]'></td>
		<td  class='title_sbody1'>�q�l�l��</td>
		<td><input type='text' size='30' maxlength='30' name='school[sch_email]' value='$school[sch_email]'></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�Ǯե�����</td>
		<td colspan='3'><a href=\"javascript:writeLeft('sch_area_img')\">������</a>&nbsp;&nbsp;<input type='file'  name='sch_area_img' ></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�Ǯե�q��</td>
		<td colspan='3'><a href=\"javascript:writeLeft('sch_traffic_img')\">��q��</a>&nbsp;&nbsp;<input type='file'   name='sch_traffic_img' ></td>
	</tr>
	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody1'>�������D��</td>
		<td colspan='3'><a href=\"javascript:writeLeft('sch_title_img')\">�������D��</a>&nbsp;&nbsp;<input type='file'  name='sch_title_img' ></td>
	</tr>

	<tr bgcolor='#FFFFFF'>
		<td class='title_sbody2' width='634' colspan='4' ><input type='submit' name='act' value='�x�s�Ǯո��'></td>
	</tr>
	</table>
	</form>";
	return $main;
}

//���o�Ǯճ]�w
function get_school_setup(){
	global $CONN;
	$sql_select = "select * from school_base";
	$recordSet=$CONN->Execute($sql_select);
	$array = $recordSet->FetchRow();
	return $array;
}

//�x�s�Ǯո��
function save_school_setup($school){
	global $CONN,$file_dir;

	$CONN->Execute ("delete from school_base");
	$sql_insert = "insert into school_base (sch_id,sch_attr_id,sch_cname,sch_cname_s,sch_cname_ss,sch_ename,sch_sheng,sch_cdate,sch_mark,sch_class,sch_montain,sch_area_tol,sch_area_ext,sch_area_pin,sch_money,sch_money_o,sch_local_name,sch_post_num,sch_addr,sch_phone,sch_fax,sch_area,sch_kind,sch_url,sch_email,update_time,update_id,update_ip)
	values
	('$school[sch_id]','$school[sch_attr_id]','$school[sch_cname]','$school[sch_cname_s]','$school[sch_cname_ss]','$school[sch_ename]','$school[sch_sheng]','$school[sch_cdate]','$school[sch_mark]','$school[sch_class]','$school[sch_montain]','$school[sch_area_tol]','$school[sch_area_ext]','$school[sch_area_pin]','$school[sch_money]','$school[sch_money_o]','$school[sch_local_name]','$school[sch_post_num]','$school[sch_addr]','$school[sch_phone]','$school[sch_fax]','$school[sch_area]','$school[sch_kind]','$school[sch_url]','$school[sch_email]',now(),'$school[update_id]','{$_SERVER['REMOTE_ADDR']}')";
	$CONN->Execute ($sql_insert);
	//���ɳB�z
	
	//�إߥؿ�

	if (!is_dir($file_dir))	mkdir($file_dir, 0755); 
	
	//�Ǯչ��ɥؿ�

	// filelist.txt �O���ɦW
	$fp = fopen ("$file_dir/filelist.txt", "w");

	if($_FILES['sch_area_img']['tmp_name'] !="" ){
		copy($_FILES['sch_area_img']['tmp_name'], "$file_dir/sch_area_img");
		fwrite($fp, "sch_area_img:{$_FILES['sch_area_img']['name']}:{$_FILES['sch_area_img']['size']}\n");
	}

	if($_FILES['sch_traffic_img']['tmp_name'] !="") {
		 copy($_FILES['sch_traffic_img']['tmp_name'], "$file_dir/sch_traffic_img");
		fwrite($fp, "sch_traffic_img:{$_FILES['sch_traffic_img']['name']}:{$_FILES['sch_traffic_img']['size']}\n");
	}

	if($_FILES['sch_title_img']['tmp_name'] !="") {
		if (strtoupper(substr(PHP_OS,0,3)=='WIN')) $title_img="sch_title_img.png";
		else $title_img="sch_title_img";
		copy($_FILES['sch_title_img']['tmp_name'], "$file_dir/".$title_img);
		fwrite($fp, "sch_title_img:{$_FILES['sch_title_img']['name']}:{$_FILES['sch_title_img']['size']}\n");
	}
  	fclose($fp);
}
?>
