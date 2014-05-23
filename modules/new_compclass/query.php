<?php

// $Id: query.php 6408 2011-04-18 03:49:04Z infodaes $

include "config.php";
include "module-upgrade.php";

sfs_check();
$template_file = dirname (__file__)."/templates/chc_query_room.htm";
// ���ݭn register_globals
if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}
//���o�Ҳճ]�w
$m_arr = &get_sfs_module_set('course_paper');
extract($m_arr, EXTR_OVERWRITE);
if ($midnoon=='') $midnoon=5;

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($year_seme)){
	$ys=explode("-",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

//����ʧ@�P�_
$main=&main_query_form($sel_year,$sel_seme,$room,$teacher_sn,$page);


//�q�X����
head("�d�߱M��Ыǹw������");
echo $main;
foot();

/*******************************************************/
//�������
/*******************************************************/
//�D�n�d�ߵe��
function &main_query_form($sel_year,$sel_seme,$room,$teacher_sn,$page){
   global $today,$CONN,$SFS_PATH_HTML,$school_menu_p,$weekN7,$weekN,$daymm,$dayww,$sunday,$saturday,$midnoon;
   include_once "../../include/chi_page2.php";

   //--�B�z����
   $size=20;  //�C��20��
   if($page=='') {
      $page=0;
   }
   //debug_msg("��".__LINE__."�� _REQUEST ", $_REQUEST);
   if($room=='all'){
      $qStr="";
   }elseif($room!=''){
      $qStr=" WHERE room='".$room."'";
   }
	$tool_bar=&make_menu($school_menu_p);
	$class_arr=class_base();

	//��X�ЫǦC��

	$room_sel=&get_room($sel_year,$sel_seme,"room",$room,jumpMenu);
	$sel1=new drop_select();
	$sel1->s_name="seme_class";
	$sel1->id=$_POST[seme_class];
	$sel1->arr=class_base();
	$sel1->has_empty=false;
	$sel1->is_submit=true;
	$chk[intval($_POST[class_kind])]="checked";
	$tol=0;

	if($room!=''){
      $SQL="select crsn from course_room ".$qStr;
      $rs=&$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
      $tol=$rs->RecordCount();
	}
	//debug_msg("��".__LINE__."�� tol ", $tol);

   $start=$page*$size;
   if($room!=''){
      $SQL="select * from course_room ".$qStr." order by date desc, sector desc limit $start , $size";
      //debug_msg(__LINE__."��  SQL", time().$SQL);
   	$rs=&$CONN->Execute($SQL) or die("�L�k�d�ߡA�y�k:".$SQL);
   	while ($rs and $ro=$rs->FetchNextObject(false)) {

   		$roomR[] = get_object_vars($ro);
   	}
   }
   

   
   $goto="{$_SERVER['PHP_SELF']}?act=$act&sel_year=$sel_year&sel_seme=$sel_seme&room=$room";

   $Chi_page= new Chi_Page($tol,$size,$page,$goto) ;  //�覡2
   $ShowPage=$Chi_page->show_page();//�覡2
   
	$main="
	<script language='JavaScript'>
	function jumpMenu(){
		if(document.myform.room.options[document.myform.room.selectedIndex].value!=''){
			location=\"{$_SERVER['PHP_SELF']}?act=$act&sel_year=$sel_year&sel_seme=$sel_seme&room=\" + document.myform.room.options[document.myform.room.selectedIndex].value;
		}
	}
	</script>
	<table width='100%' cellspacing='0' cellpadding='0'>
	<tr><td>$tool_bar
	<form action='{$_SERVER['PHP_SELF']}' method='post' name='myform'>
   $room_sel $ShowPage
   </form>
	</td></tr></table>
	";
   $ii=count($roomR);
   if($ii>0){
      $main.="<table  width='100%'  border='0' align='center' cellpadding='2' cellspacing='1' bgcolor='#9EBCDD'>
      <tr align=center  style='font-size:10pt' bgcolor='white'>
      <td nowrap bgcolor=#FFFFCC>�ϥΤ��</td>
      <td nowrap bgcolor=#FFFFCC>�P��</td>
      <td nowrap bgcolor=#FFFFCC>�`��</td>
      <td nowrap bgcolor=#FFFFCC>�a�I</td>
      <td nowrap bgcolor=#FFFFCC>�ɥΤH</td>
      <td nowrap bgcolor=#FFFFCC>�ɥίZ��</td>
      <td nowrap bgcolor=#FFFFCC>�w���n�O�ɶ�</td></tr>";
      foreach($roomR as $r){
         $class_num=$r[seme_class];
		 
		 switch ($r[sector]) {
			case 0:
				$j_title='����';
				break;
			case 100:
				$j_title='�ȥ�';
				break;
			default:
				$j_title="�� $r[sector] �`";
				break;
			}
		 
         //$cht_class_num=class_id2big5($class_num,$sel_year,$sel_seme);
         $main.="<tr align=center  style='font-size:10pt' bgcolor='white'>
      <td nowrap>$r[date]</td>
      <td nowrap>".$weekN7[$r[day]]."</td>
      <td nowrap>$j_title</td>
      <td nowrap>$r[room]</td>
      <td nowrap>".get_teacher_name($r[teacher_sn])."</td>
      <td nowrap>".$class_num."</td>
      <td nowrap>$r[sign_date]</td></tr>";
      }
      $main.= '</table>';
   }
   
	return $main;
}

//��X�ЫǦC��
function &get_room($sel_year,$sel_seme,$name="room",$now_room="",$jump_fn=""){
	global $school_menu_p,$today,$teacher_sn,$CONN;
	//�q�Ҫ��d��
	$sql_select = "select room_name from spec_classroom where enable='1'";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);
	while(list($room) = $recordSet->FetchRow()){
		if(empty($room))continue;
		$selected=($now_room==$room)?"selected":"";
		$option.="<option value='$room' $selected>$room</option>\n";
	}
	
	$jump=(!empty($jump_fn))?" onChange='$jump_fn()'":"";
	
	$main="<select name='$name' size='1' $jump>
	<option value=''>�п�ܱM��Ы�</option>
	<option value='all'>�����M��Ы�</option>
	$option</select>";
	
	return $main;
}


function debug_msg($title, $showarry){
	echo "<pre>";
	echo "<br>$title<br>";
	print_r($showarry);
}


?>
