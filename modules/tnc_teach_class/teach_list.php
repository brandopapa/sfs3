<?php

// $Id: teach_list.php 5310 2009-01-10 07:57:56Z hami $

// ���J�]�w��
include "teach_config.php";

// �{���ˬd
sfs_check();

require_once "module-upgrade.php";

// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}


// �ˬd php.ini �O�_���} file_uploads ?
check_phpini_upload();

//���b¾���A
if ($c_sel != "")
	$sel = $c_sel;
else if ($sel=="")
	$sel = 0 ; //�w�]����b¾���p

//����B�z 
switch ($do_key){ 
	case $editBtn: //�ק�
	  // �Y teach_id �ܰʡA�~�P�_�O�_���H�w�ϥθ� ID
	  	if ($teach_id != $old_teach_id) {
      		$sql_check_id="select teach_id from teacher_base where teach_id='$teach_id'";
        	$check_id=$CONN->Execute($sql_check_id);
        	$tt=$check_id->fields[teach_id];
        	if($tt) trigger_error("�ӱЮv�N���w�g���H�ϥΤF�I", E_USER_ERROR);
			$head_teach_id=substr($teach_id,0,1);			
			if(ereg ("([0-9]{1})", $head_teach_id, $regs)) trigger_error("�ӱЮv�N�� $teach_id ���n�I�Ĥ@�Ӧr�����\�Ʀr", E_USER_ERROR);
	  	}
        
		$sql_update = "update teacher_base set teach_id='$teach_id',teach_person_id='$teach_person_id',name='$name',sex='$sex',birthday='$birthday',birth_place='$birth_place',marriage='$marriage',address='$address',home_phone='$home_phone',cell_phone='$cell_phone',office_home='$office_home',teach_condition='$teach_condition',teach_memo='$teach_memo',teach_edu_kind='$teach_edu_kind',teach_edu_abroad='$teach_edu_abroad',teach_sub_kind='$teach_sub_kind',teach_check_kind='$teach_check_kind',teach_check_word='$teach_check_word',teach_is_cripple='$teach_is_cripple' where teacher_sn='$old_teacher_sn' ";
        $CONN->Execute($sql_update) or die ($sql_update);

        $upload_str = set_upload_path($img_path);

        //���ɳB�z
        if($_FILES['teacher_img']['tmp_name']){
            //�]�w�W���ɮ׸��|
            copy($_FILES['teacher_img']['tmp_name'], $upload_str."/$old_teacher_sn");
        }
        else if ($del_img) {
            if (file_exists($upload_str."/$old_teacher_sn"))
                unlink($upload_str."/$old_teacher_sn");
        }

        $sel = $teach_condition ;  //�]���ثe�b¾���A
	break;
	
	case $postBtn: //�T�w�s�W
        $sql_check_id="select teach_id from teacher_base where teach_id='$teach_id'";
        $check_id=$CONN->Execute($sql_check_id);
        $tt=$check_id->fields[teach_id];
        if($tt) trigger_error("�ӱЮv�N���w�g���H�ϥΤF�I", E_USER_ERROR);
        else{
            $sql_insert = "insert into teacher_base (teach_id,teach_person_id,name,sex,birthday,birth_place,marriage,address,home_phone,cell_phone,office_home,teach_condition,teach_memo,login_pass,teach_edu_kind,teach_edu_abroad,teach_sub_kind,teach_check_kind,teach_check_word,teach_is_cripple) values ('$teach_id','$teach_person_id','$name','$sex','$birthday','$birth_place','$marriage','$address','$home_phone','$cell_phone','$office_home','$teach_condition','$teach_memo','$DEFAULT_LOG_PASS','$teach_edu_kind','$teach_edu_abroad','$teach_sub_kind','$teach_check_kind','$teach_check_word','$teach_is_cripple')";
            $CONN->Execute($sql_insert) or die ($sql_insert);

            // �ھ� $teach_id �ӧ�X�s�W�Юv�� teacher_sn
            $sql_query = "select teacher_sn from teacher_base where teach_id='$teach_id'";
            $res=$CONN->Execute($sql_query) or die ($sql_query);
            $teacher_sn=$res->fields[0];

            $teacher_post_insert = "insert into teacher_post(teacher_sn, post_kind, post_office,post_level,official_level,post_class,post_num,bywork_num,salay,appoint_date,arrive_date,approve_date,approve_number,teach_title_id, class_num,update_time,update_id) VALUES ('$teacher_sn', '0','8','0','$official_level','$post_class','$post_num','$bywork_num','0','$appoint_date','$arrive_date','$approve_date','$approve_number','19','0','$update_time','admin')";
            $CONN->Execute($teacher_post_insert) or die ($teacher_post_insert);
            $upload_str = set_upload_path($img_path);
            //���ɳB�z
            if($_FILES['teacher_img']['tmp_name']){
                //�]�w�W���ɮ׸��|
                copy($_FILES['teacher_img']['tmp_name'], $upload_str."/$teacher_sn");
            }
         }
	break;
	
	case $delBtn: //�T�w�R��
		
		$sql_pro_check1="select pro_kind_id from pro_check_new where id_sn='$old_teacher_sn' and pro_kind_id=1";
		$rs_pro_check1=$CONN->Execute($sql_pro_check1);
		$your_pro_kind=$rs_pro_check1->fields['pro_kind_id'];
		$howmany_admin=999;
		if($your_pro_kind=="1"){
			$sql_pro_check2="select count(*) from pro_check_new where pro_kind_id='1'";
			$rs_pro_check2=$CONN->Execute($sql_pro_check2);
			$howmany_admin=$rs_pro_check2->fields[0];											
		}										
		//echo $howmany_adm; exit;		
		if($howmany_admin!=1){
			$query = "delete from teacher_base where teacher_sn='$old_teacher_sn'";
			$CONN->Execute($query);
			$query = "delete from teacher_post where teacher_sn='$old_teacher_sn'";
			$CONN->Execute($query);
			$query = "delete from teacher_connect where teacher_sn='$old_teacher_sn'";
			$CONN->Execute($query);
			$query = "delete from pro_check_new where id_sn='$old_teacher_sn'";
			$CONN->Execute($query);
		
			$teacher_sn ="";
		}
	break;


} 
//�L�X���Y
head("�Юv�򥻸��");
//����T
$field_data = get_field_info("teacher_base");

// �Y�O�ק窱�A, �h�Ϩ�e�������d�b�Q�ק諸�Юv
if ($old_teacher_sn) $teacher_sn=$old_teacher_sn;

//���s���r��
$linkstr = "teacher_sn=$teacher_sn&sel=$sel";
//�L�X���
print_menu($teach_menu_p,$linkstr);

if($do_key == $newBtn || $do_key == $postBtn) {//�s�W �νT�w�s�W�s	
	if ($is_IDauto)
		$teach_id = get_sfs_id(); //���o�y����		
}
else {
	//�x�s���U�@��
	if ($chknext)
		$teacher_sn = $nav_next;	
}


if($do_key == $newBtn || $do_key == $postBtn) {//�s�W �νT�w�s�W�s
	
	$teach_person_id = '';
	$name = '';
	$sex = '';	
	$birthday = '';
	$birth_place = '';
	$marriage = '';
	$address = '';
	$home_phone = '';
	$cell_phone = '';
	$office_home = '';
	$teach_condition = '';	
	$teach_edu_kind = '';
	$teach_edu_abroad = '';
	$teach_sub_kind = '';
    $teach_check_kind = '';
	$teach_check_word = '';
	$teach_is_cripple = '';	
	
}
else {	
	$query = "select teacher_sn from teacher_base where teacher_sn='$teacher_sn' and teach_condition ='$sel'";
	$res = $CONN->Execute($query) or die($query);
	//���]�w�Χ��ܦb¾���p�ΧR���O���� ��Ĥ@��
	if ($teacher_sn =="" || $res->RecordCount()==0) {
		$temp_sql = "select teacher_sn from teacher_base where teach_condition ='$sel' order by teacher_sn  ";
		$res2 = $CONN->Execute($temp_sql) or die($temp_sql);
		$teacher_sn = $res2->fields[0];
	}

	$sql_select = "select teach_id,teach_person_id,name,sex,age,birthday,birth_place,marriage,address,home_phone,cell_phone,office_home,teach_condition,teach_memo,teach_edu_kind,teach_edu_abroad,teach_sub_kind,teach_check_kind,teach_check_word,teach_is_cripple,update_time,update_id from teacher_base where teacher_sn='$teacher_sn' ";
	$recordSet = $CONN->Execute($sql_select)or die($sql_select);
	if(!$recordSet->EOF) {
		$teach_id = $recordSet->fields["teach_id"];
		$teach_person_id = $recordSet->fields["teach_person_id"];
		$name = $recordSet->fields["name"];
		$sex = $recordSet->fields["sex"];
		$age = $recordSet->fields["age"];
		$birthday = $recordSet->fields["birthday"];
		$birth_place = $recordSet->fields["birth_place"];
		$marriage = $recordSet->fields["marriage"];
		$address = $recordSet->fields["address"];
		$home_phone = $recordSet->fields["home_phone"];
		$cell_phone = $recordSet->fields["cell_phone"];
		$office_home = $recordSet->fields["office_home"];
		$teach_condition = $recordSet->fields["teach_condition"];
		$teach_memo = $recordSet->fields["teach_memo"];

		$teach_edu_kind = $recordSet->fields["teach_edu_kind"];
		$teach_edu_abroad = $recordSet->fields["teach_edu_abroad"];
		$teach_sub_kind = $recordSet->fields["teach_sub_kind"];
        $teach_check_kind = $recordSet->fields["teach_check_kind"];
		$teach_check_word = $recordSet->fields["teach_check_word"];
		$teach_is_cripple = $recordSet->fields["teach_is_cripple"];
		$update_time = $recordSet->fields["update_time"];

	}
}
include  "$SFS_PATH/include/sfs_oo_date.php";

// ����禡
$seldate = new date_class("myform");
//$seldate->demo ="none";
//����ˬdjavascript �禡
$seldate->date_javascript();

//�ͤ�
$birthday_str = $seldate->date_add("birthday",$birthday);

$seldate->do_check();

?>

<script language="JavaScript">
function checkok() {
	document.myform.nav_next.value = document.gridform.nav_next.value;		
	return date_check();
}
//-->
</script>


<TABLE BORDER=0 CELLPADDING=10 CELLSPACING=0 CLASS="tableBg" WIDTH="100%" ALIGN="CENTER"> 
<TR>
<td valign="top">
<!------------------ ������}�l --------------------!>
<?php    
	//�إߥ����� 
	$remove_p = remove(); //�b¾���p    
	$upstr = "���<select name=\"c_sel\" onchange=\"this.form.submit()\">\n"; 
	while (list($tid,$tname)=each($remove_p)){
		if ($sel== $tid)
			$upstr .= "<option value=\"$tid\" selected>$tname</option>\n";
		else
			$upstr .= "<option value=\"$tid\">$tname</option>\n";
	}
	$upstr .= "</select>"; 
	if($sel == 0) //�b¾����� �s�W�s 
		$downstr = "<hr size=1><input type=submit name=\"do_key\" value =\"$newBtn\">"; 

	$grid1 = new ado_grid_menu($_SERVER['PHP_SELF'],$URI,$CONN);  //�إ߿��
	$grid1->bgcolor = $gridBgcolor;  // �C��
	$grid1->row = $gridRow_num ;	     //��ܵ���
	$grid1->key_item = "teacher_sn";  // ������W
	$grid1->display_item = array("teacher_sn","name");  // �����W
	$grid1->display_color = array("1"=>"$gridBoy_color","2"=>"$gridGirl_color"); //�k�k�ͧO
	$grid1->color_index_item ="sex" ; //�C��P�_��
	$grid1->class_ccs = " class=leftmenu";  // �C�����
	$grid1->sql_str = "select teacher_sn,name,sex from teacher_base where teach_condition='$sel' order by teacher_sn";   //SQL �R�O
	$grid1->do_query(); //����R�O
	if ($do_key == $newBtn || $do_key == $postBtn)
		$grid1->disabled=1;
	$grid1->print_grid($teacher_sn,$upstr,$downstr); // ��ܵe��


?>
<!------------------ �����浲�� --------------------!>



</td>
<td  valign="top" width="100%" >

<form name ="myform" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" encType="multipart/form-data" <?php
	//��mnu���Ƭ�0�� �� form �� disabled

	if ($grid1->count_row==0 && !($do_key == $newBtn || $do_key == $postBtn))
		echo " disabled ";
	?> >
     	
<table border="1" cellspacing="0" cellpadding="2" bordercolorlight="#333354" bordercolordark="#FFFFFF"  width="100%" class=main_body >
<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[teach_id][d_field_cname] ?></td>
	<td CLASS="gendata" colspan="3">
	<?php
		if($do_key == $newBtn || $do_key == $postBtn) //�s�W �νT�w�s�W�s
			echo "<input type=\"text\"  name=\"teach_id\" value=\"$teach_id\">";
		else
			echo "<input type=\"text\"  name=\"teach_id\" value=\"$teach_id\">";
	?>
	</td>

	<td  rowspan="5">
    		<table border=0 cellpadding=0 cellspacing=0 width=100% >
    		<tr>
    			<td height=80% align=center>
 	
 	<?php 
    	
    	//�L�X�Ӥ�
    	
    		if (file_exists($UPLOAD_PATH."/$img_path/".$teacher_sn)&& $teacher_sn<>'') {
    			echo "<img src=\"".$UPLOAD_URL."$img_path/$teacher_sn\" width=\"$img_width\">";
    			echo "<br><font size=2><input type=checkbox name=\"del_img\" value=\"1\"> �R������</font>";
		}
		else {
			echo "<font size=2>�S���Ӥ�</font><br><img src=\"images/pixel_clear.gif\"  >";
			
		}
    	?>
    	
			</td>
		</tr>
		<tr>
			<td height=20% valign=bottom>
    				<input type="file" size=10 name="teacher_img" >
    			</td>
    		</tr>
    		</table>
	</td>
</tr>
<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[name][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="20" maxlength="20" name="name" value="<?php echo $name ?>"></td>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[sex][d_field_cname] ?></td>
	<td CLASS="gendata">

	<?php  
    	//�ʧO 
	$temp1=""; $temp2=""; 
	if($sex == 1 ){ 
		$temp1="checked "; $temp2=""; 
	} 
    	else if($sex == 2){ 
		$temp1=""; $temp2="checked "; 
	} 
	?> 
	<input type="radio" name="sex" value="1" <?php echo $temp1 ?>>�k &nbsp;&nbsp;<input type="radio" name="sex" value="2" <?php echo $temp2 ?>>�k 
	</td>
</tr>
<tr>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[teach_person_id][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="10" maxlength="10" name="teach_person_id" value="<?php echo $teach_person_id ?>"></td>
	<td align="right" CLASS="title_sbody1" nowrap><?php echo $field_data[marriage][d_field_cname] ?></td>
	<td >
	<?php 
    	 //�B�çO 
	$temp1=""; $temp2=""; 
	if($marriage == 1 ){ 
		$temp1="checked "; $temp2=""; 
	} 
	else if($marriage == 2){ 
	$temp1=""; $temp2="checked "; 
	} 
	?> 
	<input type="radio" name="marriage" value="2" <?php echo $temp2 ?>>�w�B <input type="radio" name="marriage" value="1" <?php echo $temp1 ?>>���B 
	</td>
</tr>
<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[birthday][d_field_cname] ?></td>
	<td CLASS="gendata"><?php echo $birthday_str ?></td>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[birth_place][d_field_cname] ?></td>
	<td >
	<?php
    	//�X�ͦa�}�C 
    	$sel1 = new drop_select(); //������O
    	$sel1->s_name = "birth_place"; //���W��
	$sel1->id = intval($birth_place);
	$sel1->arr = birth_state(); //���e�}�C
	$sel1->do_select();	
	?>
	</td>
</tr>
<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[teach_is_cripple][d_field_cname] ?></td>
	<td >
	<?php  
    	//�ݻ٤�U�P�_ 
    	$temp1=""; $temp2=""; 
    	if($teach_is_cripple == 0 ){ 
    		$temp1="checked "; $temp2=""; 
    	} 
    	else {   	 
    		$temp1=""; $temp2="checked "; 
    	} 
	?> 
	<input type="radio" name="teach_is_cripple" value="0" <?php echo $temp1 ?>>�_ &nbsp;&nbsp;<input type="radio" name="teach_is_cripple" value="1" <?php echo $temp2 ?>>�O     
	</td>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[teach_condition][d_field_cname] ?></td>
	<td CLASS="gendata">
	<?php
    	//�b¾���p
    	$sel1 = new drop_select(); //������O
    	$sel1->s_name = "teach_condition"; //���W��
	$sel1->id = intval($teach_condition);
	$sel1->arr = remove(); //���e�}�C	
	$sel1->do_select();
	?>    
	</td>
</tr>
<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[address][d_field_cname] ?></td>
	<td CLASS="gendata" colspan="4"><input type="text" size="60" maxlength="60" name="address" value="<?php echo $address ?>"></td>
	
</tr>

<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[home_phone][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="20" maxlength="20" name="home_phone" value="<?php echo $home_phone ?>"></td>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[cell_phone][d_field_cname] ?></td>
	<td CLASS="gendata" colspan="2"><input type="text" size="20" maxlength="20" name="cell_phone" value="<?php echo $cell_phone ?>"></td>
    
</tr>
<tr>
<td align="right" CLASS="title_sbody1"><?php echo $field_data[teach_edu_kind][d_field_cname] ?></td>
<td  CLASS="gendata" colspan="4">
    <?php
    	//�Ǿ�
    	$sel1 = new drop_select(); //������O
    	$sel1->s_name = "teach_edu_kind"; //���W��
	$sel1->id = intval($teach_edu_kind);
	$sel1->arr = tea_edu_kind(); //���e�}�C
	$sel1->do_select();
	
    	//�ꤺ�~�Ǿ��O 
    	$temp1=""; $temp2=""; 
    	if($teach_edu_abroad == 0 ){ 
    		$temp1="checked "; $temp2=""; 
    	} 
    	else if($teach_edu_abroad == 1){ 
    		$temp1=""; $temp2="checked "; 
    	} 
    	
    ?> 
 
    <input type="radio" name="teach_edu_abroad" value="0" <?php echo $temp1 ?>>�ꤺ &nbsp;<input type="radio" name="teach_edu_abroad" value="1" <?php echo $temp2 ?>>��~     
</td>
</tr>
<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[teach_sub_kind][d_field_cname] ?></td>
	<td CLASS="gendata"><input type="text" size="20" maxlength="40" name="teach_sub_kind" value="<?php echo $teach_sub_kind ?>"></td>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[teach_check_kind][d_field_cname] ;?></td>
	<td  CLASS="gendata" colspan="2">
	<?php
    	//�˩w���O
    	$sel1 = new drop_select(); //������O
    	$sel1->s_name = "teach_check_kind"; //���W��
	    $sel1->id = intval($teach_check_kind);
	    $sel1->arr = tea_check_kind(); //���e�}�C
	    $sel1->do_select();
	?>
	</td>    
</tr>
<tr>
	<td align="right" CLASS="title_sbody1"><?php echo $field_data[teach_check_word][d_field_cname] ?></td>
	<td CLASS="gendata" colspan="2"><input type="text" size="30" maxlength="30" name="teach_check_word" value="<?php echo $teach_check_word ?>"></td>	
	<td  colspan="2">�W���ק�ɶ��G <?php echo $update_time ?></td> 
</tr>
<tr>
	<td  align="center"  colspan="5" >
	<input type="hidden" name="old_teacher_sn" value="<?php echo $teacher_sn ?>">
	<input type="hidden" name="old_teach_id" value="<?php echo $teach_id ?>">
	<input type="hidden" name="update_id" value="<?php echo $_SESSION['session_log_id'] ?>">
	<?php	 
    	if ($do_key == $newBtn || $do_key == $postBtn)
    		echo "<input type=submit name=\"do_key\" value =\"$postBtn\" onClick=\"return checkok();\">"; 
    	else if ($grid1->count_row > 0){ 
    		if ($chknext) 
    			echo "<input type=checkbox name=chknext value=1 checked >";			 
    		else 
    			echo "<input type=checkbox name=chknext value=1 >"; 
    			
    		echo "�۰ʸ��U�@�� &nbsp;&nbsp;<input type=submit name=\"do_key\" value =\"$editBtn\" onClick=\"return checkok();\">&nbsp;&nbsp;<input type=submit name=\"do_key\" value =\"$delBtn\" onClick=\"return confirm('�T�w�R�� ".$name." �O��?');\" >"; 
    	} 
    	else 
    		echo "&nbsp;"; 
    ?> 
    <input type=hidden name=nav_next >
	</td>
</tr>
</table>
</form>
</TD>
</TR>
</TABLE>
<?php 
//�L�X���Y
foot();
?> 
