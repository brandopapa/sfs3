<?php
// $Id: blank_class.php 5310 2009-01-10 07:57:56Z hami $

/* ���o�򥻳]�w�� */
include "config.php";

sfs_check();

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
head("�Ű�Юv�d�� ");

echo $main;
foot();

/*
�禡��
*/

//�򥻳]�w���
function class_form_search($sel_year,$sel_seme){
	global $school_menu_p,$PHP_SELF,$view_tsn,$teacher_sn,$class_id;
	if(empty($view_tsn))$view_tsn=$teacher_sn;
	
	//���o�~�׻P�Ǵ����U�Կ��
	$date_select=class_ok_setup_year($sel_year,$sel_seme,"year_seme","jumpMenu_seme");

	$tool_bar=make_menu($school_menu_p);

	$list_class_table=teacher_all_class($sel_year,$sel_seme,$view_tsn);

	$main="
	<script language='JavaScript'>
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
	<td>$date_select �Ҧ��Ű�</td>
	</tr>
	</form>
	</table>
	$list_class_table
	";
	return $main;
}


//�Юv���Ű��`��
function teacher_all_class($sel_year="",$sel_seme="",$tsn=""){
	global $CONN,$PHP_SELF,$class_year,$conID,$weekN,$school_menu_p,$sections,$midnoon;

	//�C�g�����
	$dayn=sizeof($weekN)+1;
	
	//���ƽұЮv sn 
	$sql_select2 =" SELECT teacher_sn  FROM score_course where teacher_sn<>'0'  and year='$sel_year' and  semester='$sel_seme'  group by teacher_sn " ;
  $recordSet2=$CONN->Execute($sql_select2) or trigger_error($sql_select2, E_USER_ERROR);
  while (list($tsn)= $recordSet2->FetchRow()) {
  	$sn_list[$tsn]=1 ;
  }	
	//����X�Ҧ��Юv���}�C
	$sql_select = "select name,teacher_sn from teacher_base where teach_condition='0'";
	$recordSet=$CONN->Execute($sql_select);
	while (list($name,$teacher_sn)= $recordSet->FetchRow()) {
		if ( $sn_list[$teacher_sn] ==1)  //���ƽҪ�
		   $t[$teacher_sn]=$name;
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

			$tlist="";
			reset($t);
			while(list($array_teacher_sn,$name)=each($t)){
				$tsn=get_teacher_course_num($sel_year,$sel_seme,$array_teacher_sn,$i,$j);
				if($tsn==0)$tlist.=$name."<br>";
			}


			//�C�@��
			$all_class.="<td align='center'  width=110 bgcolor='white' class='small' valign='top'>
			$tlist
			</td>\n";
		}
		$all_class.= "</tr>\n" ;
	}


	//�ӯZ�Ҫ�
	$main_class_list="
	<tr bgcolor='#FBF6C4'><td>�`</td>$main_a</tr>
	$all_class";

	$main="
	<table border='0' cellspacing='1' cellpadding='4' bgcolor='#D06030' width='80%'>
	$main_class_list
	</table>
	";
	return  $main;
}
?>
