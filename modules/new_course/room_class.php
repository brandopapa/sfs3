<?php
// $Id: room_class.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�򥻳]�w�� */
include "config.php";

sfs_check();

$year_seme = $_REQUEST['year_seme'];
$class_id = $_REQUEST['class_id'];
$view_room = $_REQUEST['view_room'];

//�Y����ܾǦ~�Ǵ��A�i����Ψ��o�Ǧ~�ξǴ�
if(!empty($year_seme)){
	$ys=explode("-",$year_seme);
	$sel_year=$ys[0];
	$sel_seme=$ys[1];
}

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
//���~�]�w
if($error==1){
	$act="error";
	$error_title="�L�~�ũM�Z�ų]�w";
	$error_main="�䤣�� $sel_year �Ǧ~�ײ� $sel_seme �Ǵ����~�ų]�w�A�G�z�L�k�ϥΦ��\��C<ol><li>�Х���y<a href='".$SFS_PATH_HTML."school_affairs/every_year_setup/class_year_setup.php'>�Z�ų]�w</a>�z�]�w�~�ťH�ίZ�Ÿ�ơC<li>�H��O�o�C�@�Ǵ����Ǵ��X���n�]�w�@����I</ol>";
}

//����ʧ@�P�_
if($act=="error"){
	$main=error_tbl($error_title,$error_main);
}else{
	$main=class_form_search($sel_year,$sel_seme);
}


//�q�X����
head("�M��ЫǽҪ�d��");

echo $main;
foot();

/*
�禡��
*/

//�򥻳]�w���
function class_form_search($sel_year,$sel_seme){
	global $school_menu_p,$PHP_SELF,$view_room,$teacher_sn,$class_id;
	if(empty($view_tsn))$view_tsn=$teacher_sn;

  //�u�X�{���ƽҪ�
	//$teacher_select=select_teacher("teacher_sn",$view_tsn,'1',$sel_year,$sel_seme,"jumpMenu");
	//$teacher_select=select_teacher_in_course("teacher_sn",$view_tsn,'1',$sel_year,$sel_seme,"jumpMenu");
	
  //���o�M��ЫǦC��
  $room_select = select_room("room_name" , $view_room , $sel_year,$sel_seme,"jumpMenu" ) ;

	//���o�~�׻P�Ǵ����U�Կ��
	$date_select=class_ok_setup_year($sel_year,$sel_seme,"year_seme","jumpMenu_seme");

	$tool_bar=make_menu($school_menu_p);
	
	if ($view_room) 
	   $list_class_table=search_room_class_table($sel_year,$sel_seme,$view_room);

	$main="
	<script language='JavaScript'>
	function jumpMenu(){
		location=\"$PHP_SELF?act=$act&&year_seme=\" + document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value + \"&view_room=\" + document.myform.room_name.options[document.myform.room_name.selectedIndex].value;
	}
	function jumpMenu_seme(){
		if(document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value!=''){
			location=\"$PHP_SELF?act=$act&year_seme=\" + document.myform.year_seme.options[document.myform.year_seme.selectedIndex].value;
		}
	}
	</script>
	$tool_bar
	<table cellspacing='1' cellpadding='4'  bgcolor=#9EBCDD>
	<form action='$PHP_SELF' method='post' name='myform'>
	<tr bgcolor='#F7F7F7'>
	<td>$date_select</td>
	<td>�ЫǡG $room_select	</td>
	</tr>
	</form>
	</table>
	$list_class_table
	";
	return $main;
}

//�Юv�����Ҫ�
function search_room_class_table($sel_year="",$sel_seme="",$view_room=""){
	global $CONN,$PHP_SELF,$class_year,$conID,$weekN,$school_menu_p,$sections;
	
	$main=room_all_class($sel_year,$sel_seme,$view_room)."<br>";

	//���o�Юv�½Ҫ��Z�Ÿ�ơ]�}�C�^
	$sql_select = "SELECT class_id FROM score_course WHERE year = $sel_year AND semester=$sel_seme AND room ='$view_room' group by class_id";
	$recordSet=$CONN->Execute($sql_select) or user_error("���~�T���G",$sql_select,256);
	while(list($clas_id)= $recordSet->FetchRow()){
		$clas_id_array[]=$clas_id;
	}

	for($i=0;$i<sizeof($clas_id_array);$i++){
		$main.=search_class_table($sel_year,$sel_seme,$clas_id_array[$i], '' , $view_room )."<br>";
	}
	return $main;
}

//�M��Ыǽ��`��
function room_all_class($sel_year="",$sel_seme="",$view_room=""){
	global $CONN,$PHP_SELF,$class_year,$conID,$weekN,$school_menu_p,$sections,$midnoon;

	//$teacher_name=get_teacher_name($tsn);

	$double_class=array();
	$kk=array();
	
	//�C�g�����
	$dayn=sizeof($weekN)+1;

	//��X�Юv�Ӧ~�שҦ��ҵ{
	$sql_select = "select course_id,class_id,day,sector,ss_id, teacher_sn  from score_course where room='$view_room' and year='$sel_year' and semester='$sel_seme' order by day,sector";

	$recordSet=$CONN->Execute($sql_select) or user_error("���~�T���G",$sql_select,256);
	while (list($course_id,$class_id,$day,$sector,$ss_id,$teacher_sn)= $recordSet->FetchRow()) {
		$k=$day."_".$sector;
		$a[$k]=$ss_id;
		$b[$k]=$class_id;
		//$room[$k]=$room;
		
		$teacher_name=get_teacher_name($teacher_sn);
		$ta[$k]= $teacher_name ;
		$ta_sn[$k] = $teacher_sn ;
		
		//�Y�O����`�Ʀ����ƪ������_��
		if(in_array($k,$kk))$double_class[]=$k;

		//��Ҧ�����`�Ʃ��}�C
		$kk[]=$k;
	}

	//���o�P�����@�C
	for ($i=1;$i<=count($weekN); $i++) {
		$main_a.="<td align='center' >�P��".$weekN[$i-1]."</td>";
	}

	//���o�`�ƪ��̤j��
	$sections=get_most_class($sel_year,$sel_seme);


	//���o�Ҫ�
	for ($j=1;$j<=$sections;$j++){

		if ($j==$midnoon){
			$all_class.= "<tr bgcolor='white'><td colspan='$dayn' align='center'>�ȥ�</td></tr>\n";
		}


		$all_class.="<tr bgcolor='#FBEC8C'><td align='center'>$j</td>";

		//�C�L�X�U�`
		for ($i=1;$i<=count($weekN); $i++) {

			$k2=$i."_".$j;

			//���o�Z�Ÿ��
			$the_class=get_class_all($b[$k2]);
			$class_name=($the_class[name]=="�Z")?"":$the_class[name];
      
      //���ұЮv
      $teacher_name= $ta[$k2] ;
      if ($teacher_name) 
         $teacher_show= "<font size=2><a href='teacher_class.php?sel_year=$sel_year&sel_seme=$sel_seme&view_tsn=$ta_sn[$k2]'>$teacher_name</a></font>";
      else 
         $teacher_show="" ;   

       
			//���
			$subject_show="<font size=3>".get_ss_name("","","�u",$a[$k2])."</font>";

			//�Z�O
			if ($b[$k2]) 
			   $class_show="<font size=2><a href='index.php?sel_year=$sel_year&sel_seme=$sel_seme&class_id=$b[$k2]'>$class_name</a></font>";
			else 
			   $class_show="" ;   

			//�Y�O�Ӥ���`�Ʀ��b���ư}�C�z�A�q�X���⩳��
			$d_color=(in_array($k2,$double_class))?"red":"white";

			//�C�@��
			$all_class.="<td align='center'  width=110 bgcolor='$d_color'>
			$class_show<br>
			$subject_show<br>
			$teacher_show
			</td>\n";
		}

		$all_class.= "</tr>\n" ;
	}


	//�ӯZ�Ҫ�
	$main_class_list="
	<tr bgcolor='#FBDD47'><td colspan=6>�y".$view_room."�z�M��ЫǽҪ�]�Y���X�{���⩳��A��ܸӰ�Ҧ��İ�C�^</td></tr>
	<tr bgcolor='#FBF6C4'><td align='center'>�`</td>$main_a</tr>
	$all_class";

	$main="
	<table border='0' cellspacing='1' cellpadding='4' bgcolor='#D06030' width='80%'>
	$main_class_list
	</table>
	";
	return  $main;
}


//���o�M��ЫǪ��U�Կ��(�u�X�{���ƽҪ�)
function &select_room($col_name="room_name",$room_id="", $sel_year="",$sel_seme="",$jump_fn="",$day="",$sector=""){
	global $CONN;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
	if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
	
	$option="<option value='0'></option>";
	$jump=(!empty($jump_fn))?" onChange='$jump_fn()'":"";
	

	//���M��Ы�
	$sql_select2 =" SELECT room  FROM score_course 
	                where room <>''  and year='$sel_year' and  semester='$sel_seme'  group by room  " ;
  $recordSet2=$CONN->Execute($sql_select2) or trigger_error($sql_select2, E_USER_ERROR);
  while (list($room)= $recordSet2->FetchRow()) {
		   $selected=($room==$room_id)?"selected":"";
		   $option.="<option value='$room' $selected style='color: $color'>$room</option>\n";
  }	
  

	$select_teacher="
	<select name='$col_name' $jump>
	$option
	</select>";
	return $select_teacher;
}

?>

