<?php

// $Id: index.php 6723 2012-03-15 00:43:06Z infodaes $

include "config.php";
include "module-upgrade.php";

//sfs_check(); �w�b��s�B���ˬd

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


//�ˬd�O�_���Ҳպ޲z�v
$SCRIPT_FILENAME = $_SERVER['SCRIPT_FILENAME'];
$is_module_manager=checkid($SCRIPT_FILENAME,1);

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($year_seme)){
	$ys=explode("-",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

//����ʧ@�P�_
if($act=="�w��"){
	sfs_check();
	$msg=add_set_room($time,$room,$teacher_sn);
	header("location: {$_SERVER['PHP_SELF']}?room=$room");
}elseif($act=="del"){
	sfs_check();
	del_set_room($date,$day,$sector,$room,$teacher_sn);
	header("location: {$_SERVER['PHP_SELF']}?room=$room");
}else{
	$main=&main_form($sel_year,$sel_seme,$room,$teacher_sn);
}


//�q�X����
head("�M��Ыǹw��");
echo $main.$msg;
foot();



/*******************************************************/
//�������
/*******************************************************/
//�D�n�w���e��
function &main_form($sel_year,$sel_seme,$room,$teacher_sn){
	global $today,$CONN,$SFS_PATH_HTML,$school_menu_p,$weekN7,$weekN,$daymm,$dayww,$sunday,$saturday,$midnoon,$is_module_manager,$after_school;
	$tool_bar=&make_menu($school_menu_p);
	//���o���ЯZ�ťN��
	$class_num=get_teach_class();
	$class_name=(empty($class_num))?"":class_id2big5($class_num,$sel_year,$sel_seme);
	$class_teacher_name=get_teacher_name($teacher_sn);
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
	$class_sel="<input type=radio name=class_kind value=0 ".$chk[0].">�̽Ҫ��Z�� <input type=radio name=class_kind value=1 ".$chk[1].">�ۿ�Z�� ".$sel1->get_select();

	//�]�w�e�T�� �� �T�[�w����� �}��w��
//	$daymm=3; //�ثe�t�� ��� 0
//	$dayww=7; //�ثe�t�� ��� 7
	$daysum=$daymm+$dayww;

	//�`�N�ƶ�
	$notes="
		<ol>
		<li class='small'>�M��ЫǷ|����Ҫ�]�w�����Ыǳ]�w�A�]���A�Y�Ҫ����ҵ{���L�]�w�M��ЫǡA���򦹨t�Υi��|�L�k�ϥΡC</li>
		<li class='small'>�@�P���C�Z�u���@�`����h�C�q���ä��j��r</li>
		<li class='small'>�p�w���ᤣ�ϥΡA�аO�o�����A�H����L�Ѯv�w���v�Q�C</li>
		<li class='small'>";

	$notes.=(  $daymm>0 ? "�e".$daymm."�Ѧܫe".$daysum."�ѡA�}����z�w���C":"�i�H�b�e�@�P�}�l�w���C");
	$notes.="</li>
		<li class='small'>�p�w���S���X�{�Z�ŦW�١A�h�O�Ӱ�S���ƽҤ]�S����ܯZ�šC</li>
		<li class='small'><font color='red'>�p�ݼW�[�i�w�����ҫ�`�ơA�г]�w���Ҳդ��Ҳ��ܼ�after_school�C</font></li>
		</ol>";

	//�p��X�Ű�Ҫ�
	if(!empty($room)){
		//��X�ӱЫǦ��W�Ҫ����
		$room_class=get_room_class($sel_year,$sel_seme,$room);
		//�i�w��
		$room_notfree=get_room_notfree($sel_year,$sel_seme,$room);

		//��X���~�רC��Ұ�̦h���`��
		$sections=get_most_class($sel_year,$sel_seme)+$after_school;

		//���ѬP���X�A���o�P�@���
		$mday=date("w");


		$day=$mday;

		//���o�P�����@�C
		for ($i=0;$i<$daysum; $i++) {
			$mktime=mktime (0,0,0,date("m")  ,date("d")+$i,date("Y"));
			$the_day=date("m��d��",$mktime);
			$all_mktime[$i]=date("Y-m-d",$mktime);
			$day=($day>=7)?$day%7:$day;
			$main_a.="<td align='center' nowrap>".$weekN7[$day]."</td>";
			$main_b.="<td align='center' nowrap>$the_day</td>";
			$day++;
		}

		//����`�C��
		$dayn=$daysum+1;

		//���o�Ҫ�
		$noon='�ȥ�';
		for ($j=0;$j<=$sections;$j++){
			if ($j==$midnoon){
				if($noon)
				$j=100;
				//$all_class.= "<tr></tr>";
			}
			switch ($j) {
			case 0:
				$j_title='����';
				break;
			case 100:
				$j_title=$noon;
				break;
			default:
				$j_title=$j;
				break;
			}
			$all_class.="<tr bgcolor='#E1ECFF' class='small'><td align='center'>$j_title</td>";
			//�C�L�X�U�`
			$sday=$mday;
			for ($i=0;$i<$daysum; $i++) {
				$mktime=$all_mktime[$i];
				//���w��
				$set_data=&get_set_room($mktime,$room);

				$sday=($sday>=7)?$sday%7:$sday;
				$show="";

				$k2=$sday."_".$j;
				$k3=$mktime."_".$k2;
				$sid=$room_class[$k2][ss_id];
				$tsn=$room_class[$k2][teacher_sn];
				$cid=$room_class[$k2][class_id];

				if(!empty($cid))	$tc=class_id_2_old($cid);
				//���W��
				$teacher_name=get_teacher_name($tsn);
				$subject_name=&get_ss_name("","","�u",$sid);
				$bgcolor="#FFFFFF";
				if($room_notfree[$sday][$j]) $show="" ;
				elseif(!empty($sid)){
					//�즳�W��
					$show="<font color='#0000FF'>$tc[5]</font><br>$subject_name<br><font color='#CC0000'>$teacher_name</font>";
				}elseif(!empty($set_data[$k3][teacher_sn])){
					//�w�w��
					$del_tool=($set_data[$k3][teacher_sn]==$teacher_sn)?"<br><a href='{$_SERVER['PHP_SELF']}?act=del&date=$mktime&day=$sday&sector=$j&teacher_sn=$teacher_sn&room=$room'><font color='#FF0000'>[����]</font></a>":"";
					$show="<font color='#0000FF'>".$class_arr[$set_data[$k3][seme_class]]."</font><br>".get_teacher_name($set_data[$k3][teacher_sn]).$del_tool;
					if ($set_data[$k3][teacher_sn]==$teacher_sn) $bgcolor="#FFF188";
				}elseif(($sday==0 && $sunday==0) or ($sday==6 && $saturday==0)){
					$show="";
				}elseif($i>($daymm-1)){
					if ($room_notfree[$sday][$j] == TRUE)
					  $show="" ;
					else
					  //�i�w��
					  if($is_module_manager) $com_type='checkbox'; else $com_type='radio';
					  $show="<input type='$com_type' name='time[]' value='$k3'><font color='#C0C0C0'>�Ű�</font>";					  
				}else{
					$show="<font color='#006600'>�L���F</font>";
				}

				//�C�@��
				$all_class.="<td align='center' nowrap bgcolor='$bgcolor'>
				$show
				</td>\n";
				$sday++;
			}
			if($j==100){ $j=$midnoon-1; $noon=''; }
			$all_class.= "</tr>\n" ;
		}
	    if (!isset($_SESSION['session_log_id'])) $disabled="disabled=true" ;else $disabled='';
		//�ӯZ�Ҫ�
		$main_class_list="
		<table width='100%' cellspacing='0' cellpadding='0'><tr><td>
		<table cellspacing='1' cellpadding='3' bgcolor='#9EBCDD'>
		<tr bgcolor='#E1ECFF' class='small'><td align='center'>��</td>$main_b</tr>
		<tr bgcolor='#E1ECFF' class='small'><td align='center'>�`</td>$main_a</tr>
		$all_class
		</table>
		<input type='submit' name='act' value='�w��' $disabled ></td></tr>
		<tr bgcolor='#FBFBC4'><td><img src='../../images/filefind.png' width='16' height='16' hspace='3' border='0'>��������</td></tr>
		<tr><td style='line-height:150%;'>$notes</td></tr>
		</table>
		";
	} else {
		//�u��ܪ`�N�ƶ�
		$main_class_list="
		<tr bgcolor='#FBFBC4'><td><img src='../../images/filefind.png' width='16' height='16' hspace='3' border='0'>��������</td></tr>
		<tr><td style='line-height:150%;'>$notes</td></tr>
		</table>
		";
	}

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
	$room_sel �w���̡G $class_name $class_teacher_name $class_sel
	$main_class_list
	</form>
	</td></tr></table>
	";
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
	$option</select>";

	return $main;
}
//���i�H�w�����`��
function get_room_notfree($sel_year,$sel_seme,$room){
	global $school_menu_p,$today,$teacher_sn,$CONN;

	$sql_select = "select notfree_time from spec_classroom where enable='1' and room_name = '$room' ";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);
	while(list($notfree_time) = $recordSet->FetchRow()){
		$day_sec = split("," , $notfree_time) ;
		foreach ($day_sec as $k=>$v) {
		  $d = substr($v,1);
		  $s = substr($v,0,1);
		  //echo "$s _ $d <br>" ;
		  $main[$s][$d]= TRUE ;
		}

	}
	return $main;
}

//��X�ЫǦC��
function get_room_class($sel_year,$sel_seme,$room){
	global $school_menu_p,$today,$teacher_sn,$CONN;
	//�q�Ҫ��d��
	$sql_select = "select class_id,teacher_sn,day,sector,ss_id from score_course where year='$sel_year' and semester='$sel_seme' and room='$room'";
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);
	while(list($class_id,$teacher_sn,$day,$sector,$ss_id) = $recordSet->FetchRow()){
		$k=$day."_".$sector;
		$main[$k][class_id]=$class_id;
		$main[$k][teacher_sn]=$teacher_sn;
		$main[$k][ss_id]=$ss_id;
	}
	return $main;
}


//�w���Ы�
function add_set_room($time,$room,$teacher_sn){
	global $CONN;
	foreach($time as $key=>$value){
		$t=explode("_",$value);
		if ($_POST[class_kind]==0) {
			$query="select class_id from score_course where year='".curr_year()."' and semester='".curr_seme()."' and day='$t[1]' and sector='$t[2]' and teacher_sn='".$_SESSION[session_tea_sn]."'";
			$res=$CONN->Execute($query);
			$c=explode("_",$res->fields[class_id]);
			$seme_class=intval($c[2].$c[3]);
			if ($seme_class=="0") $seme_class="";
		} else {
			$seme_class=$_POST[seme_class];
		}
		$str="INSERT INTO course_room (date,day,sector,room,teacher_sn,sign_date,seme_class) VALUES ('$t[0]','$t[1]','$t[2]','$room','$teacher_sn',now(),'$seme_class')";
		$CONN->Execute($str) or trigger_error("�w�����ѡG $str \n\n ���i��z�ӱߨM�w�F,�H�P��b�z�e�X[�w��]�ШD��,�w�g���H���w���F!", E_USER_ERROR);
	}
	return $msg;
}

//�R���w���Ы�
function del_set_room($date,$day,$sector,$room,$teacher_sn){
	global $CONN;
	$str="delete from course_room where date='$date' and day='$day' and sector='$sector' and room='$room' and teacher_sn='$teacher_sn'";
	$CONN->Execute($str) or trigger_error("SQL�y�k���~�G $str", E_USER_ERROR);
	return true;
}

//Ū���Ыǳ]�w
function &get_set_room($the_day,$room){
	global $CONN;
	$str="select date,day,sector,teacher_sn,seme_class from course_room where date='$the_day' and room='$room'";
	$recordSet=$CONN->Execute($str) or trigger_error("SQL�y�k���~�G $str", E_USER_ERROR);
	while(list($date,$day,$sector,$teacher_sn,$seme_class)=$recordSet->FetchRow()){
		$k=$date."_".$day."_".$sector;
		$main[$k][teacher_sn]=$teacher_sn;
		$main[$k][seme_class]=$seme_class;
	}
	return $main;
}
?>
