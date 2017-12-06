<?php

// $Id: stud_list_self.php 7404 2013-08-05 06:37:34Z infodaes $

// ���J�]�w��
include "config.php";
include "../../include/sfs_oo_date.php";

// �{���ˬd
sfs_check();

// ���O�d�d��
switch ($ha_checkary){
        case 2:
                ha_check();
                break;
        case 1:
                if (!check_home_ip()){
                        ha_check();
                }
                break;
}


//�L�X���Y
head("�ǥ͸�Ʀ۫�");


//����T
$field_data = get_field_info("stud_base");

//�Ҳտ��
print_menu($menu_p,$linkstr);

//�ˬd�O�_�}��s��򥻸��
if (!$base_edit){
   echo "�ثe���}��s��򥻸�ơI";
   exit;
}   

//�u����Ǵ�
$seme_year_seme=sprintf("%03d",curr_year()).curr_seme();

//���o�n�J�ǥͪ��Ǹ��M�y����
$query="select * from stud_seme where seme_year_seme='$seme_year_seme' and stud_id='".$_SESSION['session_log_id']."'";
$res=$CONN->Execute($query);
$student_sn=$res->fields['student_sn'];
if ($student_sn) {
	$query="select * from stud_base where student_sn='$student_sn'";
	$res=$CONN->Execute($query);
	if ($res->fields['stud_study_cond']!="0") {
		$student_sn="";
	} else {
		$stud_study_year=$res->fields['stud_study_year'];
	}
}

//�p�G�b�y�~�~��B�z
if ($student_sn) {

// �ˬd php.ini �O�_���} file_uploads ?
check_phpini_upload();

//����B�z 
switch ($_POST['do_key']){	
	case $editBtn: //�ק�
		if ($same_key) {
			$ttt = change_addr_str($_POST['stud_addr_1']);
			$stud_addr_a = $ttt[0];
			$stud_addr_b = $ttt[1];
			$stud_addr_c = $ttt[2];
			$stud_addr_d = $ttt[3];
			$stud_addr_e = $ttt[4];
			$stud_addr_f = $ttt[5];
			$stud_addr_g = $ttt[6];
			$stud_addr_h = $ttt[7];
			$stud_addr_i = $ttt[8];
			$stud_addr_j = $ttt[9];
			$stud_addr_k = $ttt[10];
			$stud_addr_l = $ttt[11];
		}

		$stud_kind_temp =",";
		while(list($tid,$tname)=each($_POST['stud_kind'])) $stud_kind_temp .= $tname.",";
		$sql_update = "update stud_base set stud_name_eng='{$_POST['stud_name_eng']}',stud_sex='{$_POST['stud_sex']}',stud_birthday='{$_POST['stud_birthday']}',stud_blood_type='{$_POST['stud_blood_type']}',stud_birth_place='{$_POST['stud_birth_place']}',stud_kind='$stud_kind_temp',stud_country='{$_POST['stud_country']}',stud_country_kind='{$_POST['stud_country_kind']}',stud_person_id='{$_POST['stud_person_id']}',stud_country_name='{$_POST['stud_country_name']}',stud_addr_1='{$_POST['stud_addr_1']}',stud_addr_2='{$_POST['stud_addr_2']}',stud_tel_1='{$_POST['stud_tel_1']}',stud_tel_2='{$_POST['stud_tel_2']}',stud_tel_3='{$_POST['stud_tel_3']}',stud_mail='{$_POST['stud_mail']}',stud_addr_a='$stud_addr_a',stud_addr_b='stud_addr_b',stud_addr_c='$stud_addr_c',stud_addr_d='$stud_addr_d',stud_addr_e='$stud_addr_e',stud_addr_f='$stud_addr_f',stud_addr_g='$stud_addr_g',stud_addr_h='$stud_addr_h',stud_addr_i='$stud_addr_i',stud_addr_j='$stud_addr_j',stud_addr_k='$stud_addr_k',stud_addr_l='$stud_addr_l',stud_addr_m='$stud_addr_m',stud_class_kind='{$_POST['stud_class_kind']}',stud_spe_kind='{$_POST['stud_spe_kind']}',stud_spe_class_kind='{$_POST['stud_spe_class_kind']}',stud_spe_class_id='{$_POST['stud_spe_class_id']}',stud_preschool_status='{$_POST['stud_preschool_status']}',stud_preschool_id='{$_POST['stud_preschool_id']}',stud_preschool_name='{$_POST['stud_preschool_name']}',stud_mschool_status='{$_POST['stud_mschool_status']}',stud_mschool_id='{$_POST['stud_mschool_id']}',stud_mschool_name='{$_POST['stud_mschool_name']}',addr_zip='{$_POST['addr_zip']}' where student_sn='$student_sn'";
		$CONN->Execute($sql_update) or die($sql_update);

		$upload_str = set_upload_path("$img_path/$stud_study_year");
		
		//���ɳB�z
		if($_FILES['stud_img']['tmp_name']){
			//�]�w�W���ɮ׸��|	
		 	copy($_FILES['stud_img']['tmp_name'], $upload_str."/".$_SESSION['session_log_id']);
		 }
		 else if ($_POST['del_img']) {
		 	if (file_exists($upload_str."/".$_SESSION['session_log_id']))
				unlink($upload_str."/".$_SESSION['session_log_id']);
		 } 
		//�O�� log
		sfs_log("stud_base","update",$_SESSION['session_log_id']);
	
	break;
}

//��ܸ��
$sql_select = "select * from stud_base where student_sn='$student_sn' ";	
$recordSet = $CONN->Execute($sql_select);
while (!$recordSet->EOF) {
	$stud_name = $recordSet->fields["stud_name"];
	$stud_name_eng=$recordSet->fields["stud_name_eng"];
	$stud_sex = $recordSet->fields["stud_sex"];
	$stud_birthday = $recordSet->fields["stud_birthday"];
	$stud_blood_type = $recordSet->fields["stud_blood_type"];
	$stud_birth_place = $recordSet->fields["stud_birth_place"];
	$stud_kind = $recordSet->fields["stud_kind"];
	$stud_country = $recordSet->fields["stud_country"];
	$stud_country_kind = $recordSet->fields["stud_country_kind"];
	$stud_person_id = $recordSet->fields["stud_person_id"];
	$stud_country_name = $recordSet->fields["stud_country_name"];
	$stud_addr_1 = $recordSet->fields["stud_addr_1"];
	$stud_addr_2 = $recordSet->fields["stud_addr_2"];
	$stud_tel_1 = $recordSet->fields["stud_tel_1"];
	$stud_tel_2 = $recordSet->fields["stud_tel_2"];
	$stud_tel_3 = $recordSet->fields["stud_tel_3"];
	$stud_mail = $recordSet->fields["stud_mail"];
	$stud_addr_a = $recordSet->fields["stud_addr_a"];
	$stud_addr_b = $recordSet->fields["stud_addr_b"];
	$stud_addr_c = $recordSet->fields["stud_addr_c"];
	$stud_addr_d = $recordSet->fields["stud_addr_d"];
	$stud_addr_e = $recordSet->fields["stud_addr_e"];
	$stud_addr_f = $recordSet->fields["stud_addr_f"];
	$stud_addr_g = $recordSet->fields["stud_addr_g"];
	$stud_addr_h = $recordSet->fields["stud_addr_h"];
	$stud_addr_i = $recordSet->fields["stud_addr_i"];
	$stud_addr_j = $recordSet->fields["stud_addr_j"];
	$stud_addr_k = $recordSet->fields["stud_addr_k"];
	$stud_addr_l = $recordSet->fields["stud_addr_l"];
	$stud_addr_m = $recordSet->fields["stud_addr_m"];
	$stud_class_kind = $recordSet->fields["stud_class_kind"];
	$stud_spe_kind = $recordSet->fields["stud_spe_kind"];
	$stud_spe_class_kind = $recordSet->fields["stud_spe_class_kind"];
	$stud_spe_class_id = $recordSet->fields["stud_spe_class_id"];
	$stud_preschool_status = $recordSet->fields["stud_preschool_status"];
	$stud_preschool_id = $recordSet->fields["stud_preschool_id"];
	$stud_preschool_name = $recordSet->fields["stud_preschool_name"];
	$stud_mschool_status = $recordSet->fields["stud_mschool_status"];
	$stud_mschool_id = $recordSet->fields["stud_mschool_id"];
	$stud_mschool_name = $recordSet->fields["stud_mschool_name"];
	$stud_study_year = $recordSet->fields["stud_study_year"];
	$curr_class_num = $recordSet->fields["curr_class_num"];
	$stud_study_cond = $recordSet->fields["stud_study_cond"];
	$addr_zip = $recordSet->fields["addr_zip"];
	$recordSet->MoveNext();
};

// ����禡
$seldate = new date_class("myform");
$seldate->demo ="none";

//����ˬdjavascript �禡
$seldate->date_javascript();

//�ͤ�
$stud_birthday_str = $seldate->date_add("stud_birthday",$stud_birthday);

$seldate->do_check();
?>

<script language="JavaScript">
<!--
function checkok() {
	return date_check();
}

function do_same(){
	document.myform.stud_addr_2.value=document.myform.stud_addr_1.value;
}
//-->
</script>

<table border="0" width="100%" cellspacing="0" cellpadding="0" CLASS="tableBg" >
<tr>
<td  valign="top" width="100%" >   
<form name="myform" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post" encType="multipart/form-data">
<table border="1" cellpadding="2" cellspacing="0"  bordercolorlight="#333354" bordercolordark="#FFFFFF" class="main_body" width="100%">
<tr>
	<td class=title_mbody colspan=5 align=center >
		<?php echo $stud_name."  (�Ǹ��G".$_SESSION['session_log_id'].")";?>
	</td>	
</tr>	
<tr>
<td align="right" CLASS="title_sbody1" nowrap>�^��m�W</td>
	<td colspan="4" >
	<input type="text" size="40" maxlength="60" name="stud_name_eng" value="<?php echo $stud_name_eng ?>"><br>
</tr>
<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_sex][d_field_cname] ?></td>
	<td >
	<?php  
    	//�ʧO 
    	$temp1="";
		$temp2=""; 
    	if($stud_sex == 1 ){ 
    		$temp1="checked "; $temp2=""; 
    	} 
    	else if($stud_sex == 2){ 
    		$temp1=""; $temp2="checked "; 
    	}
	?> 
	<input type="radio" name="stud_sex" value="1" <?php echo $temp1 ?>>�k &nbsp;&nbsp;<input type="radio" name="stud_sex" value="2" <?php echo $temp2 ?>>�k 
	</td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_birthday][d_field_cname] ?></td>
	<td ><input type="text" name="stud_birthday" size="8" value="<?php echo $stud_birthday ?>">�榡 yyyy-mm-dd</td>
    <td width="20%" height="83" rowspan="4">
    <table border=0 cellpadding=0 cellspacing=0 width=100%  >
    	<tr><td height=80% align=center>
    	<input type="hidden" name="stud_study_year" value="<?php echo $stud_study_year ?>"> 
    	<?php 
    	//�L�X�Ӥ�
    		$img =$stud_study_year."/".$_SESSION['session_log_id'];    		
    		if (file_exists($UPLOAD_PATH."$img_path/".$img)) {
    			echo "<img src=\"".$UPLOAD_URL."$img_path/$img\" width=\"$img_width\">";
				echo "<br><font size=2><input type=checkbox name=\"del_img\" value=\"1\"> �R������</font>";
			}
    	?>
    	</td></tr>
    	<tr><td height=20% valign=bottom>
    	<font size=2>�Ӥ�</font><input type="file" size=10 name="stud_img" >
    	</td></tr></table>
    </td>
	
  </tr>
  <tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_blood_type][d_field_cname] ?></td>
	<td >
	<?php
		//��ܦ嫬
		$sel1 = new drop_select(); //������O
		$sel1->s_name = "stud_blood_type"; //���W��
		$sel1->id = intval($stud_blood_type);
		$sel1->arr = blood(); //���e�}�C
		$sel1->do_select();
	?>	
	</td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_birth_place][d_field_cname] ?></td>
	<td >
	<?php
    	//�X�ͦa�}�C 
    	$sel1 = new drop_select(); //������O
    	$sel1->s_name = "stud_birth_place"; //���W��
		$sel1->id = intval($stud_birth_place);
		$sel1->arr = birth_state(); //���e�}�C
		$sel1->do_select();	
    ?>
	</td>
  </tr>
  <tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_country][d_field_cname] ?></td>
	<td ><input type="text" size="20" maxlength="20" name="stud_country" value="<?php echo ($stud_country=="")?$default_country:$stud_country  ?>"></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_country_kind][d_field_cname] ?></td>
	<td >
	<?php
    	//�ҷӺ��� 
    	$sel1 = new drop_select(); //������O
    	$sel1->s_name = "stud_country_kind"; //���W��
		$sel1->id = intval($stud_country_kind);
		$sel1->has_empty = false;
		$sel1->arr = stud_country_kind(); //���e�}�C
		$sel1->do_select();	
    ?>
	</td>
  </tr>
  <tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_person_id][d_field_cname] ?></td>
	<td ><input type="text" size="20" maxlength="20" name="stud_person_id" value="<?php echo $stud_person_id ?>"></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_country_name][d_field_cname] ?></td>
	<td ><input type="text" size="20" maxlength="20" name="stud_country_name" value="<?php echo $stud_country_name ?>"></td>
  </tr>
<tr>
  	<td align="right" CLASS="title_sbody1" nowrap>��}</td>
	<td   colspan="4" >
	<?php echo $field_data[stud_addr_1][d_field_cname] ?>:
	<input type="text" size="40" maxlength="60" name="stud_addr_1" value="<?php echo $stud_addr_1 ?>"><br>
	<?php echo $field_data[stud_addr_2][d_field_cname] ?>:
	<input type="text" size="40" maxlength="60" name="stud_addr_2" value="<?php echo $stud_addr_2 ?>">
	<input type="text" size="3" maxlength="3" name="addr_zip" value="<?php echo $addr_zip ?>" title="��J�l���ϸ�">
	<?php
	 if ($stud_addr_1 == $stud_addr_2)
	 	$disable_str = " disabled ";
	 ?>
	<input type="button" name="same_addr" value="<?php echo $sameBtn ?>" <?php echo $disable_str ?> onclick="do_same()">
</tr>
<tr>
<td   colspan="5" >
	<!-- �����ɤ��y�a�} -->
	�����ɤ��y�a�} &nbsp;&nbsp;&nbsp;<input type="checkbox" name="same_key" value="1"><b><?php echo $sameBtn ?></b>
	<BR>
	<table>
	<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_addr_a][d_field_cname] ?></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_addr_b][d_field_cname] ?></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_addr_c][d_field_cname] ?></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_addr_d][d_field_cname] ?></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_addr_e][d_field_cname] ?></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_addr_f][d_field_cname] ?></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_addr_g][d_field_cname] ?></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_addr_h][d_field_cname] ?></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_addr_i][d_field_cname] ?></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_addr_j][d_field_cname] ?></td>	
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_addr_k][d_field_cname] ?></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_addr_l][d_field_cname] ?></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_addr_m][d_field_cname] ?></td>
	</tr>
	<tr>
	<td ><input type="text" size="5" maxlength="6" name="stud_addr_a" value="<?php echo $stud_addr_a ?>"></td>
	<td ><input type="text" size="5" maxlength="12" name="stud_addr_b" value="<?php echo $stud_addr_b ?>"></td>
	<td ><input type="text" size="5" maxlength="12" name="stud_addr_c" value="<?php echo $stud_addr_c ?>"></td>	
	<td ><input type="text" size="5" maxlength="6" name="stud_addr_d" value="<?php echo $stud_addr_d ?>"></td>
	<td ><input type="text" size="5" maxlength="20" name="stud_addr_e" value="<?php echo $stud_addr_e ?>"></td>
	<td ><input type="text" size="3" maxlength="6" name="stud_addr_f" value="<?php echo $stud_addr_f ?>"></td>	
	<td ><input type="text" size="5" maxlength="8" name="stud_addr_g" value="<?php echo $stud_addr_g ?>"></td>
	<td ><input type="text" size="3" maxlength="6" name="stud_addr_h" value="<?php echo $stud_addr_h ?>"></td>
	<td ><input type="text" size="5" maxlength="8" name="stud_addr_i" value="<?php echo $stud_addr_i ?>"></td>
	<td ><input type="text" size="5" maxlength="8" name="stud_addr_j" value="<?php echo $stud_addr_j ?>"></td>	
	<td ><input type="text" size="3" maxlength="6" name="stud_addr_k" value="<?php echo $stud_addr_k ?>"></td>
	<td ><input type="text" size="3" maxlength="6" name="stud_addr_l" value="<?php echo $stud_addr_l ?>"></td>
	<td ><input type="text" size="5" maxlength="12" name="stud_addr_m" value="<?php echo $stud_addr_m ?>"></td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td colspan="5" >
	<?php echo $field_data[stud_tel_1][d_field_cname] ?>:
	<input type="text" size="10" maxlength="20" name="stud_tel_1" value="<?php echo $stud_tel_1 ?>">&nbsp;
	<?php echo $field_data[stud_tel_2][d_field_cname] ?>:
	<input type="text" size="10" maxlength="20" name="stud_tel_2" value="<?php echo $stud_tel_2 ?>">&nbsp;
	<?php echo $field_data[stud_tel_3][d_field_cname] ?>:
	<input type="text" size="10" maxlength="20" name="stud_tel_3" value="<?php echo $stud_tel_3 ?>">&nbsp;
	<br>
	<?php echo $field_data[stud_mail][d_field_cname] ?>:
	<input type="text" size="30" maxlength="50" name="stud_mail" value="<?php echo $stud_mail ?>">
	</td>
</tr>
<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_kind][d_field_cname] ?></td>
	<td  colspan="4">
	<?php  
	//�ǥͨ����O
		$sel1 = new checkbox_class(); //������O		
		$sel1->s_name = "stud_kind"; //���W��
		$sel1->id = $stud_kind;
		$sel1->arr = stud_kind(); //���e�}�C	
		$sel1->css = "main_body";
		$sel1->is_color =true;
		$sel1->do_select();
	?>	
	</td>
  </tr>
  <tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_class_kind][d_field_cname] ?></td>
	<td >
	<?php  
	//�Z�ũʽ�
		$sel1 = new drop_select(); //������O	
		$sel1->s_name = "stud_class_kind"; //���W��
		$sel1->id = intval($stud_class_kind);
		$sel1->arr = stud_class_kind(); //���e�}�C
		$sel1->has_empty =false;
		$sel1->do_select();	  
	?>		
	</td>
	<td align="right" CLASS="title_sbody1"  nowrap><?php echo $field_data[stud_spe_kind][d_field_cname] ?></td>
	<td  colspan="2">
	<?php 
	//�S��Z���O
		$sel1 = new drop_select(); //������O		
		$sel1->s_name = "stud_spe_kind"; //���W��
		$sel1->id = intval($stud_spe_kind);
		$sel1->arr = stud_spe_kind(); //���e�}�C
		$sel1->do_select();	  
	 ?>	
	</td>
  </tr>
  <tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_spe_class_kind][d_field_cname] ?></td>
	<td >
	<?php 
	//�S��Z�Z�O 
		$sel1 = new drop_select(); //������O		
		$sel1->s_name = "stud_spe_class_kind"; //���W��
		$sel1->id = intval($stud_spe_class_kind);
		$sel1->arr = stud_spe_class_kind(); //���e�}�C
		$sel1->do_select();
	 ?>	
	</td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[stud_spe_class_id][d_field_cname] ?></td>
	<td  colspan="2">
	<?php 
	//�S��Z�W�ҩʽ� 
		$sel1 = new drop_select(); //������O		
		$sel1->s_name = "stud_spe_class_id"; //���W��
		$sel1->id = intval($stud_spe_class_id);
		$sel1->arr = stud_spe_class_id(); //���e�}�C
		$sel1->do_select();
	 ?>	
	</td>
  </tr>
  <tr>
	<td align="right" CLASS="title_sbody1" nowrap>�J�ǫe���X��</td>
	<td  colspan="4">
	�J�Ǹ��:
	<?php 
	//�J�Ǹ��
		$sel1 = new drop_select(); //������O	
		$sel1->s_name = "stud_preschool_status"; //���W��
		$sel1->id = intval($stud_preschool_status);
		$sel1->arr = stud_preschool_status(); //���e�}�C	
		$sel1->do_select();
	 ?>
	&nbsp;���X��ǮեN��:<input type="text" size="4" maxlength="8" name="stud_preschool_id" value="<?php echo $stud_preschool_id ?>"> &nbsp;
	���X��W��:<input type="text" size="15" maxlength="40" name="stud_preschool_name" value="<?php echo $stud_preschool_name ?>">
	</td>
  </tr>
  <tr>
	<td align="right" CLASS="title_sbody1" nowrap>�J�ǫe��p</td>
	<td  colspan="4">
	�J�Ǹ��:
	<?php 
	//�J�Ǹ��
		$sel1 = new drop_select(); //������O	
		$sel1->s_name = "stud_mschool_status"; //���W��
		$sel1->id = intval($stud_mschool_status);
		$sel1->arr = stud_preschool_status(); //���e�}�C	
		$sel1->do_select();
	 ?>	
	&nbsp;��p�ǮեN��:<input type="text" size="4" maxlength="8" name="stud_mschool_id" value="<?php echo $stud_mschool_id ?>"> &nbsp;
	��p�W��:<input type="text" size="15" maxlength="40" name="stud_mschool_name" value="<?php echo $stud_mschool_name ?>">
	</td>
  </tr>
  <tr>
  	<td class=title_mbody colspan=5 align=center >
  		<?php
    		if($base_edit=='1')	echo "<input type=submit name=do_key value =\"$editBtn\" onClick=\"return checkok();\">&nbsp;&nbsp;"; else echo "<font size=1 color='red'>- �ȥi�s���A�T���� -</font>";
    	?>
  	</td>	
  </tr>
</table>
</form>
</table>
</td>
</tr>
</table>
<?php
} else {
	echo "�ӥͤw���b�y�I";
}

//�L�X���Y
foot();
?>
