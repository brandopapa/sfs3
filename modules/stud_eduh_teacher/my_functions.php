<?php
//�ˬd���Юv�O�_�����w�Z��
function get_course_class_select2($year_seme,$curr_class_id=""){

	global $CONN,$school_kind_name,$school_kind_color,$this_seme_year_seme;
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
  $query="select class_id from `score_eduh_teacher2` where year_seme='$year_seme' and teacher_sn='".$_SESSION['session_tea_sn']."' order by class_id";
  $res_class=mysql_query($query);
  //���X�]�w���ҵ{
    $res_class=mysql_query($query);
    while ($row_class=mysql_fetch_row($res_class)) {
     list($class_id)=$row_class;
      $query="select c_year,c_name from school_class where class_id='$class_id'";
      $res_class_name=mysql_query($query);
      list($c_year,$c_name)=mysql_fetch_row($res_class_name);
      $selected=($curr_class_id==$class_id)?"selected":"";
     $class_name_option.="<option value='$class_id' $selected style='background-color: $school_kind_color[$c_year];'>".$school_kind_name[$c_year]."".$c_name."�Z</option>\n";
    } // end while
	return $class_name_option;
} 

//�̬�ػs�@<select><option>�U�Կ��
function get_course_class_select($sel_year="",$sel_seme="",$col_name="class_id",$jump_fn="",$curr_class_id=""){

	global $CONN,$school_kind_name,$school_kind_color,$this_seme_year_seme;
  $option1="�п�ܯZ��";
  
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);
	
	$option_teacher=get_course_class_select2($this_seme_year_seme,$curr_class_id); //���ˬd���S����W�S�O���w�����Юv���Z��
	
  $query="select ss_id from `score_eduh_teacher` where year_seme='$this_seme_year_seme'";
  //echo $query."<br>";
  $res_course=mysql_query($query);
  //���X�]�w���ҵ{
  while ($row_course=mysql_fetch_array($res_course)) {
  	//���X�Ҫ������ҵ{���Z��
    $query="select distinct class_id from score_course where year='".substr($this_seme_year_seme,0,3)."' and semester='".substr($this_seme_year_seme,-1)."' and ss_id='".$row_course['ss_id']."' and teacher_sn='".$_SESSION['session_tea_sn']."'";
    //echo $query."<br>";
    $res_class=mysql_query($query);
    while ($row_class=mysql_fetch_row($res_class)) {
     list($class_id)=$row_class;
     //�ˬd�S�O���wtable��, ���v���L���w���Z, �Y��, ���n�A�C�X
     // if .... continue
      if (check_class_id($this_seme_year_seme,$_SESSION['session_tea_sn'],$class_id)) continue; //�b���w�Юv��ƪ�̤w���w���Z��, ���n���ЦC�X
      $query="select c_year,c_name from school_class where class_id='$class_id'";
      $res_class_name=mysql_query($query);
      list($c_year,$c_name)=mysql_fetch_row($res_class_name);
      $selected=($curr_class_id==$class_id)?"selected":"";
     $class_name_option.="<option value='$class_id' $selected style='background-color: $school_kind_color[$c_year];'>".$school_kind_name[$c_year]."".$c_name."�Z</option>\n";
    } // end while
  }// end while
 
  //if(empty($class_name_option))trigger_error("�d�L�Z�Ÿ��", E_USER_ERROR);

	$jump=(!empty($jump_fn))?" onChange='$jump_fn()'":"";

	$class_name_list="
	<select name='$col_name' $jump>
	<option value=''>$option1
	$option_teacher
	$class_name_option
	</select>";
	return $class_name_list;
} 

//����Y�Ǵ��Y�Юv�O�_�w���w�Y�Z
function check_class_id($year_seme,$teacher_sn,$class_id) {
	$query="select * from `score_eduh_teacher2` where year_seme='$year_seme' and teacher_sn='$teacher_sn' and class_id='$class_id'";
	$result=mysql_query($query);
	if (mysql_num_rows($result)>0) {
		return true;
	} else {
	  return false;
	}	
}

?>