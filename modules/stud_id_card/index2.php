<?php
//$Id: index2.php 7711 2013-10-23 13:07:37Z smallduh $
include "config.php";

//�{��
sfs_check();

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($_REQUEST[year_seme])){
	$ys=explode("-",$_REQUEST[year_seme]);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}else{
	$sel_year=(empty($_REQUEST[sel_year]))?curr_year():$_REQUEST[sel_year]; //�ثe�Ǧ~
	$sel_seme=(empty($_REQUEST[sel_seme]))?curr_seme():$_REQUEST[sel_seme]; //�ثe�Ǵ�
}
$act=$_REQUEST[act];

//�D�n���e
if($act=="make"){
	downlod_ar($_REQUEST[all_stud],$sel_year,$sel_seme,"ooo");
}elseif($act=="make2"){
	downlod_ar($_REQUEST[all_stud],$sel_year,$sel_seme,"ooo2");
}else{
	$main=&main_form($sel_year,$sel_seme,$_REQUEST[all_stud]);
}

//�q�X�����������Y
head("�ǥ��ҦC�L�Ҳ�");

?>

<script language="JavaScript">
<!-- Begin
function submits(a){
	document.myform.act.value=a;
}
//  End -->
</script>

<?php

echo $main;

//�G������
foot();

function &main_form($sel_year,$sel_seme,$stud_arr){
	global $CONN,$school_menu_p;

	if(count($stud_arr)!=0){
		//���o�ǥ͸��
		$all_stud=get_stud_data($stud_arr);
		$n=0;
		foreach($all_stud as $stud_id=>$stu){
			$all.="<tr bgcolor='#FFFFFF'>
			<td valign=top align=center>$stud_id</td>
			<td valign=top align=center>$stu[stud_name]</td>
			<td valign=top align=center>$stu[stud_sex]</td>
			<td valign=top align=center>$stu[stud_birthday]</td>
			<td valign=top align=center>$stu[stud_person_id]</td>
			<td valign=top align=center>$stu[guardian_name]</td>
			</tr>";
			$n++;
		}
		
	}
	$tool_bar=&make_menu($school_menu_p);
    
	$main="
	$tool_bar
	<table bgcolor='#c0c0c0' cellspacing=1 cellpadding=2 class='small'>
	<tr class='title_mbody' align='center'>
	<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
	<td colspan=6>
	�Ǹ�<input type=text size=6 maxlength=6 name=all_stud[0] value=".$stud_arr[0]."> �Ǹ�<input type=text size=6 maxlength=6 name=all_stud[1] value=".$stud_arr[1]."> �Ǹ�<input type=text size=6 maxlength=6 name=all_stud[2] value=".$stud_arr[2]."><br>
	�Ǹ�<input type=text size=6 maxlength=6 name=all_stud[3] value=".$stud_arr[3]."> �Ǹ�<input type=text size=6 maxlength=6 name=all_stud[4] value=".$stud_arr[4]."> �Ǹ�<input type=text size=6 maxlength=6 name=all_stud[5] value=".$stud_arr[5]."><br>
	�Ǹ�<input type=text size=6 maxlength=6 name=all_stud[6] value=".$stud_arr[6]."> �Ǹ�<input type=text size=6 maxlength=6 name=all_stud[7] value=".$stud_arr[7]."> �Ǹ�<input type=text size=6 maxlength=6 name=all_stud[8] value=".$stud_arr[8]."><br>
	<input type='hidden' name='act' value=''>
	<input type='button' value='�C�X���' class='b1' OnClick='this.form.submit();'>
	<input type='button' value='�U���ǥ���(9�i/��)' class='b1' OnClick=\"submits('make');this.form.submit();\">
	<input type='button' value='�U���ǥ���(6�i/��)' class='b1' OnClick=\"submits('make2');this.form.submit();\">
	</form>
	</tr>
	<tr class='title_mbody'>
	<td valign=top align=center>�Ǹ�</td>
	<td valign=top align=center>�ǥͩm�W</td>
	<td valign=top align=center>�ʧO</td>
	<td valign=top align=center>�ͤ�</td>
	<td valign=top align=center>�����Ҹ�</td>
	<td valign=top align=center>���@�H</td>
	</tr>
	$all	
	</table><br>
	<font color='red'>�����G�Y�ϥΤ��i/���M�L�A�ШC���̦h��J����ǥ͡C</font>
	";
	return $main;
}

//���o�ǥ͸��
function get_stud_data($stud_arr){
	global $CONN;

	$all_id="'".implode("','",$stud_arr)."'";
	$sql_select = "select a.stud_id,a.stud_name,a.stud_sex,a.stud_birthday,a.stud_person_id,b.guardian_name from stud_base a left join stud_domicile b on a.student_sn=b.student_sn where a.stud_id in ($all_id) and a.stud_study_cond=0 order by a.stud_id";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(list($stud_id,$stud_name,$stud_sex,$stud_birthday,$stud_person_id,$guardian_name) = $recordSet->FetchRow()){
		$d=explode("-",$stud_birthday);
		$dy=$d[0]-1911;
		$birthday="���إ���".$dy."�~".$d[1]."��".$d[2]."��";
			
		$stud[$stud_id][stud_name]=$stud_name;
		$stud[$stud_id][stud_sex]=($stud_sex=='1')?"�k":"�k";
		$stud[$stud_id][stud_birthday]=$birthday;
		$stud[$stud_id][by]=$dy;
		$stud[$stud_id][bm]=$d[1];
		$stud[$stud_id][bd]=$d[2];
		$stud[$stud_id][stud_person_id]=$stud_person_id;
		$stud[$stud_id][guardian_name]=$guardian_name;
	}
	return $stud;
}

//�U���ǥ���
function downlod_ar($stud_arr=array(),$sel_year="",$sel_seme="",$oo_path=""){
	global $CONN,$UPLOAD_PATH;

	if ($oo_path=="ooo")
		$nums=9;
	elseif ($oo_path=="ooo2")
		$nums=6;

	//�ɦW����
	if(!empty($stud_id)){
		$filename="STUD_ID_CARD_".$class_id."_".$stud_id.".sxw";
	}else{
		$filename="STUD_ID_CARD_".$class_id.".sxw";
	}
	
        //�s�W�@�� zipfile ���
        $ttt = new EasyZIP;

        // �]�w �ɮץؿ�
        $ttt->setPath($oo_path);

        // �[�J��ӥؿ�
        $ttt->addDir("META-INF");

        // �[�J�ɮ�
        $ttt -> addFile("styles.xml");
        $ttt -> addFile("content.xml");
        $ttt -> addFile("meta.xml");
        $ttt -> addFile("settings.xml");

	if (is_dir($oo_path)) { 
		if ($dh = opendir($oo_path)) { 
			while (($file = readdir($dh)) !== false) { 
				if($file=="." or $file==".." or $file=="content.xml" or $file=="Configurations2" or $file=="Thumbnails" or strtoupper(substr($file,-4))=='.SXW') {
					continue;
				}elseif(is_dir($oo_path."/".$file)){
					if ($dh2 = opendir($oo_path."/".$file)) { 
						while (($file2 = readdir($dh2)) !== false) { 
							if($file2=="." or $file2==".."){
								continue;
							}else{
								$data = $ttt->read_file($oo_path."/".$file."/".$file2);
								$ttt->add_file($data,$file."/".$file2);
							}
						} 
						closedir($dh2); 
					} 
				}else{
					$data = $ttt->read_file($oo_path."/".$file);
					$ttt->add_file($data,$file);
				}
			} 
			closedir($dh); 
		} 
	} 
	
	
	//���o�Ǯո��
	$s=get_school_base();
		
	//���o�ǥ͸��
	$all_stud=get_stud_data($stud_arr);
	
	
	//Ū�X content.xml 
	$data = $ttt->read_file($oo_path."/content.xml");
	// �[�J���� tag

	$data = str_replace("<office:automatic-styles>",'<office:automatic-styles><style:style style:name="BREAK_PAGE" style:family="paragraph" style:parent-style-name="Standard"><style:properties fo:break-before="page"/></style:style>',$data);
	
	//��� content.xml
	$arr1 = explode("<office:body>",$data);
	//���Y
	$doc_head = $arr1[0]."<office:body>";
	$arr2 = explode("</office:body>",$arr1[1]);
	//��Ƥ��e
	$content_body = $arr2[0];
	//�ɧ�
	$doc_foot = "</office:body>".$arr2[1];
	$replace_data ="";

	$temp_arr["school_name"] = $s[sch_cname];

	$i=1;
	foreach($all_stud as $stud_id=>$stu){
		$temp_arr["stud_id".$i] = $stud_id;	
		$temp_arr["name".$i] = $stu[stud_name];
		$temp_arr["i".$i] = $stu[stud_sex];
		$temp_arr["birthday".$i] = $stu[stud_birthday];
		$temp_arr["by".$i] = $stu[by];
		$temp_arr["bm".$i] = $stu[bm];
		$temp_arr["bd".$i] = $stu[bd];
		$temp_arr["stud_pid".$i] = $stu[stud_person_id];
		$temp_arr["parent".$i] = $stu[guardian_name];

		//���ƿ��Ǯդ���ܾǥͨ����Ҧr���κ��@�H�m�W  98.05.22�ץ�
		$pos=strpos($temp_arr["school_name"], "���ƿ�");
		if($pos!==false){
            $temp_arr["stud_pid".$i]="**********";
            $temp_arr["parent".$i]="******";
        }	
        
		if($i%$nums==0){
			// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
			$replace_data.= $ttt->change_temp($temp_arr,$content_body);
			$i=1;
		}else{
			$i++;
		}
	}
	
	if(($i-1)%$nums!=0){
		for("";$i<=$nums;$i++){
			$temp_arr["stud_id".$i] ="";	
			$temp_arr["name".$i] = "";
			$temp_arr["i".$i] = "";
			$temp_arr["birthday".$i] = "";
			$temp_arr["by".$i] = "";
			$temp_arr["bm".$i] = "";
			$temp_arr["bd".$i] = "";
			$temp_arr["stud_pid".$i] = "";
			$temp_arr["parent".$i] = "";
		}
		$replace_data.= $ttt->change_temp($temp_arr,$content_body);
	}
	$replace_data =$doc_head.$replace_data.$doc_foot;
	
	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");
	
	//���� zip ��
	$sss = $ttt->file();

	//�H��y�覡�e�X sxw
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: application/vnd.sun.xml.writer");
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
