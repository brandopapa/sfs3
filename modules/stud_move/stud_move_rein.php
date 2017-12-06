<?php
//$Id: stud_move_rein.php 8116 2014-09-10 12:41:32Z hsiao $
include "stud_move_config.php";

//認證
sfs_check();

$m_arr = get_sfs_module_set();
extract($m_arr, EXTR_OVERWRITE);

$sel_year = curr_year(); //選擇學年
$sel_seme = curr_seme(); //選擇學期
$curr_seme=$sel_year.$sel_seme;
$seme_year_seme=sprintf("%03d",$sel_year).$sel_seme;
if ($_POST[move_out_kind]=="") $_POST[move_out_kind]="8"; //預設調出類別
if ($check_study_year!="1") $stud_study_year=$sel_year-intval(($IS_JHORES=="0")?6:3); //到目前可轉回的復學生
$smarty->assign("default_unit",$default_unit);
$smarty->assign("default_word",$default_word);

//按鍵處理
switch($_REQUEST[do_key]) {
	case $postReinBtn :
		$update_ip=getip();
		$temp_arr=explode("_",$_POST[stud_class]);
		$query="select stud_id from stud_base where student_sn='$_POST[student_sn]'";
		$res=$CONN->Execute($query) or die($query);
		$stud_id=$res->fields[stud_id];

		//加入異動記錄
		$sql_insert = "insert into stud_move (stud_id,move_kind,move_year_seme,move_date,move_c_unit,move_c_date,move_c_word,move_c_num,update_id,update_ip,update_time,student_sn) values ('$stud_id','$_POST[move_kind]','$curr_seme','$_POST[move_date]','$_POST[move_c_unit]','$_POST[move_c_date]','$_POST[move_c_word]','$_POST[move_c_num]','$_POST[update_id]','$update_ip','".date("Y-m-d h:i:s")."','$_POST[student_sn]')";
		$CONN->Execute($sql_insert) or die($sql_insert);

		//更新stud_base
		$temp_class=intval($temp_arr[2]).$temp_arr[3];
		$query="select max(seme_num) from stud_seme where seme_year_seme='$seme_year_seme' and seme_class='$temp_class'";
		$res=$CONN->Execute($query) or die($query);
		$new_site_num=$res->fields[0]+1;
		$temp_class_num=intval($temp_arr[2]).$temp_arr[3].sprintf("%02d",$new_site_num);
		$query="update stud_base set curr_class_num='$temp_class_num',stud_study_cond='0' where student_sn='$_POST[student_sn]'";
		$CONN->Execute($query) or die($query);

		//更新或新增stud_seme table
		$query="select c_name from school_class where class_id='$_POST[stud_class]' and enable='1'";
		$res=$CONN->Execute($query) or die($query);
		$seme_class_name=$res->fields[c_name];
		$query="replace INTO stud_seme (seme_year_seme,stud_id,seme_class,seme_class_name,seme_num,student_sn) VALUES ('$seme_year_seme', '$stud_id', '$temp_class', '$seme_class_name', '$new_site_num', '$_POST[student_sn]');";
		$CONN->Execute($query) or die($query);

	break;

	case "delete" :
		//先刪除異動資料
		$query="delete from stud_move where move_id ='$_GET[move_id]'";
		$CONN->Execute($query) or die ($query);
		//讀取上一個異動類別
		$query="select move_kind,move_year_seme from stud_move where student_sn='$_GET[student_sn]' order by move_date desc";
		$res=$CONN->Execute($query) or die ($query);
		$back_move_kind=$res->fields['move_kind'];
		//寫入原來的異動狀態
		$query="update stud_base set stud_study_cond='$back_move_kind' where student_sn='$_GET[student_sn]'";
		$CONN->Execute($query) or die ($query);
		//若非同一學期則將學籍表資料刪除
		if ($sel_year.$sel_seme!=$res->fields[move_year_seme]) {
			$query="delete from stud_seme where seme_year_seme='".sprintf("%03d",$sel_year).$sel_seme."' and student_sn='$_GET[student_sn]'";
			$CONN->Execute($query) or die ($query);
		}
	break;

	case $editBtn :
		//修改異動記錄
		$sql_update="update stud_move set move_kind='$_POST[move_kind]',move_date='$_POST[move_date]',move_c_unit='$_POST[move_c_unit]',move_c_date='$_POST[move_c_date]',move_c_word='$_POST[move_c_word]',move_c_num='$_POST[move_c_num]',update_id='".$_SESSION['session_log_id']."',update_ip='".getip()."',update_time='".date("Y-m-d h:i:s")."' where student_sn='$_POST[student_sn]' and move_id='$_POST[move_id]'";
		$CONN->Execute($sql_update) or die($sql_update);
	break;

	case "edit";
		$query="select * from stud_move where move_id='$_GET[move_id]'";
		$res=$CONN->Execute($query) or die ($query);
		$_POST[student_sn]=$res->fields[student_sn];
		$_POST[move_kind]=$res->fields[move_kind];
		$smarty->assign("default_date",$res->fields[move_date]);
		$smarty->assign("default_c_date",$res->fields[move_c_date]);
		$smarty->assign("default_unit",$res->fields[move_c_unit]);
		$smarty->assign("default_word",$res->fields[move_c_word]);
		$smarty->assign("default_num",$res->fields[move_c_num]);
		$query="select * from stud_base where student_sn='$_POST[student_sn]'";
		$res=$CONN->Execute($query) or die ($query);
		$stud_arr[$res->fields[student_sn]]=$res->fields[stud_id]."--".$res->fields[stud_name];
	break;
}

//調出類別選單
$sel1=new drop_select();
$sel1->s_name="move_out_kind";
$sel1->id=$_POST[move_out_kind];
$sel1->arr=$out_in_arr;
$sel1->has_empty=false;
$sel1->is_submit=true;
$smarty->assign("out_kind_sel",$sel1->get_select());

if (empty($stud_arr)) {
	$query="select student_sn,stud_id,stud_name,stud_sex from stud_base where stud_study_cond='$_POST[move_out_kind]' and stud_study_year>'$stud_study_year' order by stud_id";
	$res=$CONN->Execute($query) or die($query);
	while(!$res->EOF) {
		$stud_arr[$res->fields[student_sn]]=$res->fields[stud_id]."--".$res->fields[stud_name] ;
		$sex_arr[$res->fields[student_sn]]=$res->fields[stud_sex];
		$res->MoveNext();
	}
}


 
//學生選單
$sel1=new drop_select();
$sel1->s_name="student_sn";
$sel1->id=$_POST[student_sn];
$sel1->arr=$stud_arr;
$sel1->has_empty=false;
$sel1->is_display_color=true;
$sel1->color_index_arr=$sex_arr;
$sel1->color_item=array("black","blue","red");
$sel1->is_submit=true;
$smarty->assign("stud_sel",$sel1->get_select());


if ($_POST[student_sn]) {
   $query="select seme_class_name from stud_seme where student_sn='$_POST[student_sn]' order by seme_year_seme DESC ";
	 $res=$CONN->Execute($query) or die($query);
   $old_class_name= "原班級: ". $res->fields[seme_class_name];
} else 
  $old_class_name="" ;
  
  
//復學類別選單
$sel1=new drop_select();
$sel1->s_name="move_kind";
$sel1->id=$_POST[move_kind];
$sel1->arr=$rein_arr;
$sel1->has_empty=true;
$sel1->is_submit=true;
$smarty->assign("move_kind_sel",$sel1->get_select());

//班級選單
$smarty->assign("class_sel",get_class_select(curr_year(),curr_seme(),"","stud_class","this.form.submit",$_POST[stud_class]));

//取出復學記錄
$temp_move_kind="a.move_kind='".implode("' or a.move_kind='",array_keys($rein_arr))."'";

$query="select a.*,b.stud_name,b.stud_person_id,b.stud_birthday,c.seme_class from stud_move a,stud_seme c,stud_base b where a.student_sn=c.student_sn and  a.student_sn=b.student_sn and c.seme_year_seme='$seme_year_seme' and a.move_year_seme='$curr_seme' and ($temp_move_kind) order by a.move_date desc";


$res=$CONN->Execute($query) or die($query);
$smarty->assign("stud_move",$res->GetRows());
$session_path=$SFS_PATH_HTML.'modules/stud_move/session_in.php?para=';
$session_schoolnameeduno=$SCHOOL_BASE["sch_cname_ss"].'('.$SCHOOL_BASE['sch_id'].')';
$smarty->assign("sesion_path",$session_path);
$smarty->assign("session_schoolnameeduno",$session_schoolnameeduno);
$smarty->assign("SFS_TEMPLATE",$SFS_TEMPLATE);
$smarty->assign("module_name","學生復學作業");
$smarty->assign("SFS_MENU",$student_menu_p);
$smarty->assign("class_list",class_base());
$smarty->assign("kind_arr",$rein_arr);

$smarty->assign("old_class_name",$old_class_name);
$smarty->display("stud_move_stud_move_rein.tpl");
?>
