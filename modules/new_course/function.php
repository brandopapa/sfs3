<?php
// $Id: function.php 8102 2014-08-31 15:06:51Z infodaes $

//�C�X�Y�ӯZ�Ū��Ҫ�
function search_class_table($sel_year="",$sel_seme="",$class_id="",$tsn="" , $view_room="") {
	global $CONN,$PHP_SELF,$class_year,$conID,$weekN,$school_menu_p,$sections,$midnoon,$SFS_PATH_HTML;

	if(empty($class_id)){
		//���o���ЯZ�ťN��
		$class_num=get_teach_class();
		$class_id=old_class_2_new_id($class_num,$sel_year,$sel_seme);
	}

	//���o�Z�Ÿ��
	$the_class=get_class_all($class_id);

	//�C�g�����
	$dayn=sizeof($weekN)+1;
	
	$sql_select = "select course_id,teacher_sn,cooperate_sn,day,sector,ss_id,room from score_course where class_id='$class_id' order by day,sector";

	$recordSet=$CONN->Execute($sql_select) or user_error("���~�T���G",$sql_select,256);
	while (list($course_id,$teacher_sn,$cooperate_sn,$day,$sector,$ss_id,$room)= $recordSet->FetchRow()) {
		$k=$day."_".$sector;
		$a[$k]=$ss_id;
		$b[$k]=$teacher_sn;
		$co[$k]=$cooperate_sn;
		$r[$k]=$room;
	}

	//���o�P�����@�C
	for ($i=1;$i<=count($weekN); $i++) {
		$main_a.="<td align='center' >�P��".$weekN[$i-1]."</td>";
	}

	//���o�ҸթҦ��]�w
	$sm=get_all_setup("",$sel_year,$sel_seme,$the_class[year]);
	$sections=$sm[sections];

//	if($sections==0)
//		trigger_error("�Х��]�w $sel_year �Ǧ~ $sel_seme �Ǵ� [���Z�]�w]����,�A�ާ@�Ҫ�]�w<br><a href=\"$SFS_PATH_HTML/modules/every_year_setup/score_setup.php\">�i�J�]�w</a>",E_USER_ERROR);
	if(!empty($class_id)){

		//���o�Ҫ�
		for ($j=1;$j<=$sections;$j++){

			if ($j==$midnoon){
				$all_class.= "<tr bgcolor='white'><td colspan='$dayn' align='center'>�ȥ�</td></tr>\n";
			}

			$all_class.="<tr bgcolor='#E1ECFF'><td align='center'>$j</td>";

			//�C�L�X�U�`
			for ($i=1;$i<=count($weekN); $i++) {

				$k2=$i."_".$j;

				
				$teacher_search_mode=(!empty($tsn) and $tsn==$b[$k2])?true:false;
				$room_search_mode=(!empty($view_room) and $view_room==$r[$k2])?true:false;

				//��ت��U�Կ��
				$subject_sel="<font size=3>".get_ss_name("","","�u",$a[$k2])."</font>";
				
				//�Юv���U�Կ��
				$teacher_sel="<font size=2><a href='teacher_class.php?sel_year=$sel_year&sel_seme=$sel_seme&view_tsn=$b[$k2]'>".get_teacher_name($b[$k2])."</a></font>";
				if($co[$k2]) $teacher_sel.="<br><font size=1><a href='teacher_class.php?sel_year=$sel_year&sel_seme=$sel_seme&view_tsn=$co[$k2]'>*".get_teacher_name($co[$k2])."*</a></font>";
				
				$room_name=(empty($r[$k2]))?"&nbsp;":"<font color='red'>$r[$k2]</font>";
				
				$align="align='center'";
				$color=($teacher_search_mode or $room_search_mode)?"#FFF158":"white";


				//�C�@��
				$all_class.="<td $align bgcolor='$color' width=110>
				$subject_sel<br>
				$teacher_sel<br>
				<font size='2'>$room_name</font>
				</td>\n";
			}

			$all_class.= "</tr>\n" ;
		}
		
		if((!empty($tsn)) or (!empty($view_room)))$class_name="<tr bgcolor='#B9C5FF'><td colspan=6>$the_class[name] �ҵ{��</td></tr>";

		//�ӯZ�Ҫ�
		$main_class_list="
		$class_name
		<tr bgcolor='#E1ECFF'><td align='center'>�`</td>$main_a</tr>
		$all_class
		";
	}else{
		$main_class_list="";
	}

	$main="
	<table border='0' cellspacing='1' cellpadding='4' bgcolor='#9EBCDD' width='80%'>
	$main_class_list
	</table>
	";
	return  $main;
}

?>
