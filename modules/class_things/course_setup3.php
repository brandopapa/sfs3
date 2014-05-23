<?php


// $Id: course_setup3.php 7728 2013-10-28 09:02:05Z smallduh $

/* ���o�򥻳]�w�� */
require_once "config.php";

include_once "$SFS_PATH/include/sfs_oo_overlib.php";
include_once "../../include/sfs_case_score.php";
//include_once "../../include/sfs_case_subjectscore.php";

$m_arr = &get_sfs_module_set('course_paper');
extract($m_arr, EXTR_OVERWRITE);
if ($midnoon=='') $midnoon=5;

//$CONN->debug = true;
sfs_check();

$now_teacher_sn=$_SESSION['session_tea_sn'];//���o�n�J�Ѯv��id
//��X���ЯZ��
$class_name=teacher_sn_to_class_name($now_teacher_sn);
$class_id =$class_name[3] ; // �榡�G094_1_06_03  


if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}


if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�

//���~�]�w
if($error==1){
	$act="error";
	$error_title="�L�~�ũM�Z�ų]�w";
	$error_main="�䤣��� ".$sel_year." �Ǧ~�סA�� ".$sel_seme." �Ǵ����~�šB�Z�ų]�w�A�G�z�L�k�ϥΦ��\��C<ol><li>�Х���y<a href='".$SFS_PATH_HTML."modules/every_year_setup/class_year_setup.php'>�Z�ų]�w</a>�z�]�w�~�ťH�ίZ�Ÿ�ơC<li>�H��O�o�C�@�Ǵ����Ǵ��X���n�]�w�@����I</ol>";
}



//����ʧ@�P�_
if($act=="error"){
	$main=&error_tbl($error_title,$error_main);
}elseif($act=="�x�s�Ҫ�"){
	save_class_table($sel_year,$sel_seme,$class_id,$ss_id,$teacher_sn,$room);
	header("location: {$_SERVER['PHP_SELF']}");
}elseif($act=="delete"){
	$dd = explode("_",$sel);
	$query = "delete from score_course  where  day='$dd[0]' and sector='$dd[1]' and year=$sel_year and semester=$sel_seme and class_id='$class_id'";
	$CONN->Execute($query) or trigger_error("SQL ���~!! $query",E_USER_ERROR);
	$act="list_class_table";
	$main=&list_class_table($sel_year,$sel_seme,$class_id);

}elseif($act=="���s�]�w"){
	$query = "delete from score_course where year=$sel_year and semester=$sel_seme and class_id='$class_id' and teacher_sn = '$now_teacher_sn' ";
	$CONN->Execute($query) or trigger_error("SQL ���~!! $query",E_USER_ERROR);
	header("location: {$_SERVER['PHP_SELF']}?act=view_class&sel_year=$sel_year&sel_seme=$sel_seme&class_id=$class_id");
}elseif($act=="downlod_ct"){	
	downlod_ct($class_id,$sel_year,$sel_seme);
	
	//downlod_all_ct($class_id,$mode,$sel_year,$sel_seme);
	//header("location: {$_SERVER['PHP_SELF']}?act=list_class_table&sel_year=$sel_year&sel_seme=$sel_seme&class_id=$class_id");

}elseif($act=="downlod_ct_htm"){	

	download_ct_htm($class_id,$sel_year,$sel_seme);
	//header("location: {$_SERVER['PHP_SELF']}?act=list_class_table&sel_year=$sel_year&sel_seme=$sel_seme&class_id=$class_id");

}else{
  	$act="list_class_table";

	$main=list_class_table($sel_year,$sel_seme,$class_id);
	//$main=&class_form($sel_year,$sel_seme);
}


//�q�X����
head("���Z�\�Ҫ�");

?>

<style type="text/css">
<!--
.noborder {
	border: none;
	background-color: #E0DDFF;
}
.showborder {
  /*background-color: #FFFFFF;*/
}	
.editing {
	border: none;
  background-color: #E1ECFF;
}	
-->
</style>

<script language="JavaScript">
<!-- Begin


//���w���
function setkmo(idx,ss_id,ss_name, ID) {
	
	var replay;
	//
	if (ID.checked==true) {
		
  	replay=select_sub(idx , ss_id , ss_name);

		if (replay=='OK'){ID.checked=false;}
		//�B�z����,��ܨS���w����`��
		if (replay=='NO'){alert("�`�N�G\n\n����`���A�A���ءI�I");
		ID.checked=false;}
	}
	return ;	
}	

///----- ����ܪ��ƨ禡-----------------

function  select_sub(idx ,ss_id , ss_name) {
	var i =0;
	var check_i ;
	var ok = 0 ;
	var v ,v_ss , v_tea ,v_tea_name;
	

	while (i < document.F2.elements.length) {
		var obj=document.F2.elements[i];
		//�p�G�Ocheckbox����A�ӥB�O�Q���U���A�ӥB�O�ҥΪ�disabled==false
		if (obj.type=='checkbox'&& obj.checked==1  ) {
			v = obj.value ;
			
			//��ئW
			v_ss = "inp_ss_id[" + v + "]" ;
			MM_changeProp(v_ss ,'','value', ss_name ,'INPUT/TEXT') ;
			MM_changeProp(v_ss ,'','className', 'editing' ,'INPUT/TEXT') ; 				
			 
			//��إN��		
			v_ss = "ss_id[" + v + "]" ;
			MM_changeProp(v_ss ,'','value',ss_id,'INPUT/hidden') ;
      
			
			obj.checked=false ;
			ok = 1 ;
		}
		i++;
	}
	if (ok ==1 )
	   return 'OK' ; //�Ǧ^�B�z���\���T��
	else    
	   return 'NO';//�_�h�N�Ǧ^����

}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_setTextOfTextfield(objName,x,newText) { //v3.0
  var obj = MM_findObj(objName); if (obj) obj.value = newText;
}

function MM_changeProp(objName,x,theProp,theValue) { //v6.0
	
  var obj = MM_findObj(objName);
  if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
    if (theValue == true || theValue == false)
      eval("obj."+theProp+"="+theValue);
    else eval("obj."+theProp+"='"+theValue+"'");

  }
  //alert("obj."+theProp+"='"+theValue+"'") ;
}


//  End -->
</script>

<?php

echo $main;
foot();

/*
�禡��
*/




//�C�X�Y�ӯZ�Ū��Ҫ�
function list_class_table($sel_year,$sel_seme,$class_id="",$mode=""){
	global $CONN,$class_year,$conID,$weekN,$menu_p,$SFS_PATH_HTML ,$course_input,$midnoon;

	//���o�Z�Ÿ��
	$the_class=get_class_all($class_id);

	$class_data=class_id_2_old($class_id);
	$class_teacher=get_class_teacher($class_data[2]);
	$class_man=$class_teacher[name];
	$class_man_sn=$class_teacher[sn];
	

	//�C�g�����
	$dayn=sizeof($weekN)+1;
	
	//��X�Y�Z�Ҧ��ҵ{
	$sql_select = "select course_id,teacher_sn,day,sector,ss_id,room from score_course where class_id='$class_id' order by day,sector";
	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	while (list($course_id,$teacher_sn,$day,$sector,$ss_id,$room)= $recordSet->FetchRow()) {
		$k=$day."_".$sector;
		$a[$k]=$ss_id;
		$b[$k]=$teacher_sn;
		$r[$k]=$room;
	}

	//���o�P�����@�C
	for ($i=1;$i<=count($weekN); $i++) {
		$main_a.="<td align='center' >�P��".$weekN[$i-1]."</td>";
	}
	
	//���o�ҸթҦ��]�w
	$sm=&get_all_setup("",$sel_year,$sel_seme,$the_class[year]);
	$sections=$sm[sections];
	if($sections==0)
		trigger_error("�Х��]�w $sel_year �Ǧ~ $sel_seme �Ǵ� [���Z�]�w]����,�A�ާ@�Ҫ�]�w<br><a href=\"$SFS_PATH_HTML/modules/every_year_setup/score_setup.php\">�i�J�]�w</a>",E_USER_ERROR);

	if(!empty($class_id)){
	
		//���o�ӯZ�ϥά��
		$select_ss_arr= &get_class_subject_name_arr($class_id,$sel_year,$sel_seme,$the_class[year]) ;


		//�Z�Ū��ƽұ���
		$course_class_arr = get_course_class_arr($sel_year,$sel_seme,$class_id);
	
		$def_color = $color;
		
		//�C�X��ؿ�� prolin 20050804
		if ($course_input) {  //���\�ק�Ҫ�
    		$i = 0 ;
    		$set_kmo_str = "<input name=\"radiobutton\" type=\"radio\" value=\"$i\" onClick=\"setkmo('$i' ,'0' ,  '-' ,this)\">�M�� &nbsp;| &nbsp; \n" ;	
    		foreach( $select_ss_arr as 	$k=> $v ) {
    			 $i++ ;
    		   $set_kmo_str .= "<input name=\"radiobutton\" type=\"radio\" value=\"$i\" onClick=\"setkmo('$i' , '$k' ,'$v', this )\" >$v &nbsp;| &nbsp; \n" ;
    		}
	  }
	  
	  
		//���o�Ҫ�
		for ($j=1;$j<=$sections;$j++){

			if ($j==$midnoon){
				$all_class.= "<tr bgcolor='white'><td colspan='$dayn' align='center'>�ȥ�</td></tr>\n";
			}


			$all_class.="<tr bgcolor='#E1ECFF'><td align='center'>$j</td>";
			
			//�C�L�X�U�`			
			for ($i=1;$i<=count($weekN); $i++) {
				$color = $def_color;
				$k2=$i."_".$j;
				
				

				$teacher_sel='';
				$subject_sel='';
				$room_sel='';
				$re_set ='';
				

				//���Z�w�����Ҫ�
				if(!empty($course_class_arr[$k2][ss_id])) {
					$chk_str ="" ;
					$teacher_sel = "<font color='blue' size=2>".$course_class_arr[$k2][name]."</font>";
					$subject_sel =  $select_ss_arr[$a[$k2]];
					$room_sel="<font color='#000000' size=2>".$r[$k2]."</font>";
					$color = "#FFE5E5";
					
					//�ɮv�ۤw����
					if ($course_class_arr[$k2][teacher_sn] == $class_man_sn )  {
						$color = "#E0DDFF" ;
					  // $re_set = "<a href=\"$del_link&sel=$k2\"><img src=\"images/remove.png\" border=0 alt=\"�R��\"></a>";
					  //��ت��U�Կ��
					  $chk_str = "<input name=\"chk[$k2]\" type=\"checkbox\" id=\"chk[$k2]\" value=\"$k2\">\n" ;
					
					  $subject_sel = "<input name=\"inp_ss_id[$k2]\" type=\"text\" value=\"". $select_ss_arr[$a[$k2]]."\" size=\"8\" readonly class=\"noborder\"> \n" ;
					  $subject_sel .= "<input type=\"hidden\" name=\"ss_id[$k2]\" value=\"".$a[$k2]."\">\n";

					  $teacher_sel = "<input type=\"hidden\" name=\"teacher_sn[$k2]\" value=\"".$class_man_sn."\">\n";
					  $room_sel="<font color='#000000' size=2>".$r[$k2]."</font>";
					  $re_set ="";					   
				  }
				}
				//���ƽ�
				else{
					//��ت��U�Կ��
					$chk_str = "<input name=\"chk[$k2]\" type=\"checkbox\" id=\"chk[$k2]\" value=\"$k2\">\n" ;

					$subject_sel = " <input name=\"inp_ss_id[$k2]\" type=\"text\" value=\"\" size=\"8\" readonly  class=\"showborder\" > \n" ;
					$subject_sel .= "<input type=\"hidden\" name=\"ss_id[$k2]\" value=\"0\">\n";
					
					$teacher_sel = "<input type=\"hidden\" name=\"teacher_sn[$k2]\" value=\"".$class_man_sn."\">\n";
					$room_sel="" ;
					$re_set ="";
				}
				
				//�C�@��
				$debug_str=($debug)?"<small><font color='#aaaaaa'>-".$a[$k2]."</font></small><br>":"";
				$all_class.="<td $align bgcolor='$color'>
				$chk_str
				$subject_sel
				$re_set<br>$debug_str
				$teacher_sel

				</td>\n";
			

			}

			$all_class.= "</tr>\n" ;
		}

    if ($course_input) {  //���\�ק�Ҫ�
		   $submit="<input type='submit' name='act' value='�x�s�Ҫ�'>
		   <input type='submit' name='act' value='���s�]�w' onClick=\"return confirm('�T�w���s�]�w�Q�Z�Ҫ�H\\n�Ҫ�]�w�N�R��!!!');\">";
    }
    
    
		//�ӯZ�Ҫ�
		$main_class_list="
		<form action='{$_SERVER['PHP_SELF']}' method='post' name= 'F2' >
		<tr><td colspan='6'  bgcolor='#FFFFFF'><font color=blue>����w���`���A�A���w��ءC�`�N�G�b����L�ʧ@�e�n�����x�s�I</font>
		<a href='{$_SERVER['PHP_SELF']}?act=downlod_ct&class_id=$class_id&sel_year=$sel_year&sel_seme=$sel_seme'>
		<img src='images/dl_ct.png' alt='�ϥ�OpenOffice��X�Ҫ�' width='84' height='24' hspace='6' vspace='0' border='0' align='middle'>
		</a> | 
		<a href='?act=downlod_ct_htm&class_id=$class_id&sel_year=$sel_year&sel_seme=$sel_seme' target='_blank' >
		��X�����Ҫ�
		</a>
		<br>
		$set_kmo_str</td></tr>
		<tr bgcolor='#E1ECFF'><td align='center'>�`</td>$main_a</tr>
		$all_class
		
		<tr bgcolor='#E1ECFF'><td colspan='6' align='center'>
		<input type='hidden' name='sel_year' value='$sel_year'>
		<input type='hidden' name='sel_seme' value='$sel_seme'>
		<input type='hidden' name='class_id' value='$class_id'>
		<input type='hidden' name='set_teacher_sn' value='$set_teacher_sn'>
		
		$submit
		</td></tr>
		</form>
		";
	}else{
		$main_class_list="";
	}
	
	$tool_bar=&make_menu($menu_p);
	

		
	$url_str =$SFS_PATH_HTML.get_store_path()."/sel_class.php";

	$main="
	$tool_bar

		<table border='0' cellspacing='1' cellpadding='4' bgcolor='#9EBCDD'>

		$main_class_list
		</table>

	";
	return  $main;
}




//�x�s�Ҫ�
function save_class_table($sel_year="",$sel_seme="",$class_id="",$ss_id="",$teacher_sn="",$room=""){
	global $CONN;
	reset($ss_id);
	while(list($k,$v)=each($ss_id)){
		$kk=explode("_",$k);
		$day=$kk[0];
		$sector=$kk[1];

		$teacher=$teacher_sn[$k];
    //echo " $k $teacher <br>";
		$subject=$ss_id[$k];
		$r=$room[$k];
		//�����o�ݬݦ��L�ҵ{
		$c=&get_course("",$day,$sector,$class_id);
		//���p�S���ҵ{��ơA��Ʈw���]�L�ӽҵ{�A������L
		if(empty($subject) and empty($c[course_id]))continue;
		
		if(empty($c[course_id])){
			add_course($sel_year,$sel_seme,$teacher,$class_id,$day,$sector,$subject,$r);
		}else{
			update_course($c[course_id],$sel_year,$sel_seme,$teacher,$class_id,$day,$sector,$subject,$r);
		}

	}
	return ;
}

//�x�s�@���ҵ{��ơ]�@�Z�@�Ѫ��Y�@�`�^
function add_course($sel_year,$sel_seme,$teacher,$class_id,$day,$sector,$subject,$room){
	global $CONN;
	//��class_id�����ª��Ǧ~
	$c=class_id_2_old($class_id);

	$sql_insert = "insert into score_course
	 (year,semester,class_id,teacher_sn, class_year,class_name,day,sector,ss_id,room) values
	($sel_year,'$sel_seme','$class_id','$teacher','$c[3]','$c[4]','$day','$sector','$subject','$room')";
	if($CONN->Execute($sql_insert))	return true;
	die($sql_insert);
	return false;
}

//��s�@���ҵ{��ơ]�@�Z�@�Ѫ��Y�@�`�^
function update_course($course_id="",$sel_year="",$sel_seme="",$teacher,$class_id="",$day,$sector,$subject,$room){
	global $CONN;
	//��class_id�����ª�?Ǧ~
	$c=class_id_2_old($class_id);

	if(!empty($course_id)){
		$where="where course_id = '$course_id'";
	}else{
		$where="where class_id = '$class_id'  and  day='$day'  and sector='$sector'";
	}
	$sql_update = "update score_course set year=$sel_year, semester='$sel_seme', class_id='$class_id',teacher_sn='$teacher', class_year='$c[3]',class_name='$c[4]', day='$day', sector='$sector', ss_id='$subject', room='$room' $where";
//	echo $sql_update;
	$CONN->Execute($sql_update) or die($sql_update);
	return true;
}



//���o�Y�@���ҵ{���
function &get_course($course_id="",$day="",$sector="",$class_id=""){
	global $CONN;
	if(!empty($course_id)){
		$where="where course_id = '$course_id'";
	}else{
		$where="where class_id='$class_id' and day='$day' and sector='$sector'";
	}
	$sql_select = "select * from score_course $where";
	
	$recordSet=$CONN->Execute($sql_select) or die($sql_select);
	$array = $recordSet->FetchRow();
	return $array;
}




//�Ҧ��Юv�@�P�����ƽұ��ΰ}�C(�P�_�O�_���İ�)
function get_course_tea_arr($sel_year,$sel_seme) {
	global $CONN;
	$query = "select ss_id ,class_id,day,sector,teacher_sn from score_course where year='$sel_year' and semester='$sel_seme' ";
	$res = $CONN->Execute($query) or trigger_error("SQL ���~",E_USER_ERROR);
	while (!$res->EOF) {
		$temp_ds = $res->fields[day]."_".$res->fields[sector];
		$temp_arr[$res->fields[teacher_sn]][$temp_ds][ss_id] = $res->fields[ss_id];
		$temp_arr[$res->fields[teacher_sn]][$temp_ds][class_id] = $res->fields[class_id];
		$res->MoveNext();
	}
	return $temp_arr;
}

//�Y�Z���ƽұ���
function get_course_class_arr($sel_year,$sel_seme,$class_id) {
	global $CONN;
	$query = "SELECT a.teacher_sn,a.ss_id,a.day,a.sector,b.name FROM score_course a RIGHT JOIN teacher_base b ON a.teacher_sn=b.teacher_sn WHERE a.year='$sel_year' and a.semester='$sel_seme' and a.class_id='$class_id' ";
	$res = $CONN->Execute($query) or trigger_error("SQL ���~",E_USER_ERROR);
	while (!$res->EOF) {
		$temp_ds = $res->fields[day]."_".$res->fields[sector];
		$temp_arr[$temp_ds][teacher_sn]=$res->fields[teacher_sn];
		$temp_arr[$temp_ds][name]=$res->fields[name];
		$temp_arr[$temp_ds][ss_id]=$res->fields[ss_id];
		$res->MoveNext();
	}
	return $temp_arr;
}


//�ѯZ�ŧǸ�class_id�d�X�~��[year]�A�Z��[sort]�A�Z�W[name]
function get_class_all($class_id=""){
	global $CONN,$school_kind_name;
	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	// init $the_class
	$the_class=array();

	$sql_select = "select c_year,c_name,c_sort from school_class where class_id='$class_id'";
	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	list($the_class[year],$name,$the_class[sort]) = $recordSet->FetchRow();
	$y=$the_class[year];
	$the_class[name]=$school_kind_name[$y]."".$name."�Z";
	return $the_class;
}


//���o��ئW�ٰ}�C
function &get_subject_name_arr(){
	global $CONN;

	// �T�w�s�u����
	if (!$CONN) user_error("��Ʈw�s�u���s�b�I���ˬd�����]�w�I",256);

	$sql_select = "select subject_id,subject_name,enable from score_subject where enable = '1' ";

	$recordSet=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

	// init $tmp_arr
	$temp_arr=array();

	while (!$recordSet->EOF) {
		$temp_arr[$recordSet->fields[subject_id]][subject_name] = $recordSet->fields[subject_name];
		$temp_arr[$recordSet->fields[subject_id]][enable] = $recordSet->fields[enable];
		$recordSet->MoveNext();
	}

//	$name=($subject_enable=='1')?$subject_name:"<font color='red'>$subject_name</font>";

	return  $temp_arr;
}

//���o�ӯZ�ϥά��
function  &get_class_subject_name_arr($class_id , $sel_year , $sel_seme, $the_class_year ) {
    global $CONN;
    

		$subject_name_arr =  &get_subject_name_arr();
		
		$sql_select="select ss_id,scope_id,subject_id,enable from score_ss where class_id='$class_id' and enable='1' order by sort,sub_sort";

		$res = $CONN->Execute($sql_select) or trigger_error("SQL ���~ $sql_select",E_USER_ERROR);
		if ($res->RecordCount() ==0){
			$sql_select="select ss_id,scope_id,subject_id,enable from score_ss where class_year='$the_class_year' and year='$sel_year' and semester='$sel_seme' and enable='1' and class_id='' order by sort,sub_sort";
			$res = $CONN->Execute($sql_select) or trigger_error("SQL ���~ $sql_select",E_USER_ERROR);
		}
		

		while(!$res->EOF){
			$scope_id = $res->fields[scope_id];
			$subject_id = $res->fields[subject_id];
			
			$subject_name= $subject_name_arr[$subject_id][subject_name];
			if (empty($subject_name))
				$subject_name= $subject_name_arr[$scope_id][subject_name];

			//if($subject_name_arr[$scope_id][enable])
			//	$subject_name =  "<font color='red'>$subject_name</font>";

			$select_ss_arr[$res->fields[ss_id]] = $subject_name;  //��ذ}�C
			$res->MoveNext();
		}	
		return $select_ss_arr ;
}			


//���X�U�`�W�Үɶ��}�C
function section_table_this($sel_year,$sel_seme){
    global $CONN;
	$query="select * from section_time where year='$sel_year' and semester='$sel_seme' order by sector";
	$res=$CONN->Execute($query);
	while(!$res->EOF) {
		$section_table[$res->fields[sector]]=explode("-",$res->fields[stime]);
		$res->MoveNext();
	}
	$query = "select MAX(sections) from score_setup where year = '$sel_year' and semester='$sel_seme'";
	$res=$CONN->Execute($query);
	$max_sector=$res->fields[0];
	for ($i=1;$i<=$max_sector;$i++) {
		if ($section_table[$i][0]=="") {
			$section_table[$i][0]=" ";
			$section_table[$i][1]=" ";
		}
	}
	return $section_table;
}

//�U���\�Ҫ�
function downlod_ct($class_id="",$sel_year="",$sel_seme=""){
	global $CONN,$weekN,$school_kind_name,$midnoon;
	if(empty($class_id))trigger_error("�L�Z�Žs���A�L�k�U���C�]���S�����Z�Žs���A�G�L�k���o�Z�Žҵ{��ƥH�K�U���C", E_USER_ERROR);

	$oo_path = "ooo_course";
	
	
	$filename="course_".$class_id.".sxw";
	
	if(empty($class_id)){
		//���o���ЯZ�ťN��
		$class_num=get_teach_class();
	}
	
	//���o�Z�Ÿ��
	$the_class=get_class_all($class_id);
	
	//�C�g�����
	$dayn=sizeof($weekN)+1;
	
	$sql_select = "select course_id,teacher_sn,day,sector,ss_id,room from score_course where class_id='$class_id' order by day,sector";

	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	while (list($course_id,$teacher_sn,$day,$sector,$ss_id,$room)= $recordSet->FetchRow()) {
		$k=$day."_".$sector;
		$a[$k]=$ss_id;
		$b[$k]=$teacher_sn;
		$r[$k]=$room;
	}
	
	//���o�ӯZ�ϥά��
	$select_ss_arr= &get_class_subject_name_arr($class_id,$sel_year,$sel_seme,$the_class[year]) ;

	
  //�ഫ�Z�ťN�X
	$class=class_id_2_old($class_id);
	$class_teacher=get_class_teacher($class[2]);
	$class_man=$class_teacher[name];
	
		//�C�`�W�Үɶ�
	$section_table=&section_table_this($sel_year,$sel_seme);	

	//���o�ҸթҦ��]�w
	$sm=&get_all_setup("",$sel_year,$sel_seme,$the_class[year]);
	$sections=$sm[sections];
	if(!empty($class_id)){
		//���o�Ҫ�
		for ($j=1;$j<=$sections;$j++){
			//�Y�O�̫�@�C�n�Τ��P���˦�
			$ooo_style=($j==$sections)?"4":"2";
			
			if ($j==$midnoon){
				//�w�]���ȥ�OpenOffice.org���{���X
				$all_class.= "<table:table-row table:style-name=\"course_tbl.3\"><table:table-cell table:style-name=\"course_tbl.A3\" table:number-columns-spanned=\"6\" table:value-type=\"string\"><text:p text:style-name=\"P12\">�ȶ���</text:p></table:table-cell><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/><table:covered-table-cell/></table:table-row>";
			}
			//echo $j . $time_set[$j] ;
			$all_class.="<table:table-row table:style-name=\"course_tbl.1\"><table:table-cell table:style-name=\"course_tbl.A".$ooo_style."\" table:value-type=\"string\"><text:p text:style-name=\"P8\">�� $j �`</text:p><text:p text:style-name=\"P15\">" . $section_table[$j][0] .'~' . $section_table[$j][1] . "</text:p></table:table-cell>";
			//�C�L�X�U�`
			$wn=count($weekN);
			for ($i=1;$i<=$wn;$i++) {
				//�Y�O�̫�@��n�Τ��P���˦�
				$ooo_style2=($i==$wn)?"F":"B";
			
				$k2=$i."_".$j;
				
				//$teacher_search_mode=(!empty($tsn) and $tsn==$b[$k2])?true:false;
				//���
				//$subject_sel=&get_ss_name("","","�u",$a[$k2]);
        $ss_id = $a[$k2] ;
				$subject_sel= $select_ss_arr[$ss_id] ;
				//echo $subject_sel ;
				
				//�Юv
				$teacher_sel=get_teacher_name($b[$k2]);
				
				//�C�@��
				if ($class_man <> $teacher_sel ) 
				   $all_class.="<table:table-cell table:style-name=\"course_tbl.".$ooo_style2.$ooo_style."\" table:value-type=\"string\"><text:p text:style-name=\"P14\">$subject_sel</text:p><text:p text:style-name=\"P10\"><text:span text:style-name=\"teacher_name\">$teacher_sel</text:span></text:p></table:table-cell>";
				else 
				   $all_class.="<table:table-cell table:style-name=\"course_tbl.".$ooo_style2.$ooo_style."\" table:value-type=\"string\"><text:p text:style-name=\"P9\">$subject_sel</text:p><text:p text:style-name=\"P10\"><text:span text:style-name=\"teacher_name\">$teacher_sel</text:span></text:p></table:table-cell>";
			}
			$all_class.="</table:table-row>";
		}
		
	}else{
		$all_class="";
	}
	


	//���o�Ǯո��
	$s=get_school_base();

	//�s�W�@�� zipfile ���
	$ttt = new EasyZip;
	$ttt->setPath($oo_path);
	$ttt->addDir('META-INF');
	$ttt->addfile("settings.xml");
	$ttt->addfile("styles.xml");
	$ttt->addfile("meta.xml");

	//Ū�X content.xml 
	$data = $ttt->read_file(dirname(__FILE__)."/$oo_path/content.xml");

	//�N content.xml �� tag ���N
	$temp_arr["city_name"] = "";//$s[sch_sheng];
	$temp_arr["school_name"] = $s[sch_cname];
	$temp_arr["Cyear"] = $stu[stud_name];
	$temp_arr["stu_class"] = $class[5];
	$temp_arr["teacher_name"] = $class_man;
	$temp_arr["year"] = $sel_year;
	$temp_arr["seme"] = $sel_seme;
	$temp_arr["all_course"] = $all_class;
	/*
	$temp_arr["time1"] = "07:50~08:05";
	$temp_arr["time2"] = "08:05~08:20";
	$temp_arr["time3"] = "08:20~08:40";
  */
	// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
	$replace_data = $ttt->change_temp($temp_arr,$data,0);
	
	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");
	
	//���� zip ��
	$sss = & $ttt->file();

	//�H��y�覡�e�X ooo.sxw
	header("Content-disposition: attachment; filename=$filename");
	//header("Content-type: application/octetstream");
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

//�U���\�Ҫ�
function download_ct_htm($class_id="",$sel_year="",$sel_seme=""){
	global $CONN,$weekN,$school_kind_name,$smarty,$midnoon,$SFS_PATH;
	if(empty($class_id))trigger_error("�L�Z�Žs���A�L�k�U���C�]���S�����Z�Žs���A�G�L�k���o�Z�Žҵ{��ƥH�K�U���C", E_USER_ERROR);


	
	//���o�Z�Ÿ��
	$the_class=get_class_all($class_id);
	

	//���o�ӯZ�ϥά��
	$select_ss_arr= &get_class_subject_name_arr($class_id,$sel_year,$sel_seme,$the_class[year]) ;	
	
	$sql_select = "select course_id,teacher_sn,day,sector,ss_id,room from score_course where class_id='$class_id' order by day,sector";

	$recordSet=$CONN->Execute($sql_select) or trigger_error("���~�T���G $sql_select", E_USER_ERROR);
	while (list($course_id,$teacher_sn,$day,$sector,$ss_id,$room)= $recordSet->FetchRow()) {
		$k=$day."_".$sector;
		$all_class[a][$day][$sector]=$select_ss_arr[$ss_id] ;
		$all_class[b][$day][$sector]=get_teacher_name($teacher_sn);
		$all_class[c][$day][$sector]=$room;
	}
	
	
  //�ഫ�Z�ťN�X
	$class=class_id_2_old($class_id);
	$class_teacher=get_class_teacher($class[2]);
	$class_man=$class_teacher[name];
	
	//�C�`�W�Үɶ�
	$section_table=&section_table_this($sel_year,$sel_seme);	

	//���o�ҸթҦ��]�w
	$sm=&get_all_setup("",$sel_year,$sel_seme,$the_class[year]);
	$sections=$sm[sections];
  
  //�Ǯո��
  $s=get_school_base();


//�ϥμ˪�
$template_dir = $SFS_PATH."/".get_store_path()."/templates";
// �ϥ� smarty tag
$smarty->left_delimiter="{{";
$smarty->right_delimiter="}}";
//$smarty->debugging = true;

$smarty->assign("school_name",$s[sch_cname]); 
$smarty->assign("class_name",$class[5]); 
$smarty->assign("class_teacher",$class_man); 
$smarty->assign("year",$sel_year); 
$smarty->assign("seme",$sel_seme); 
$smarty->assign("all_class",$all_class); 
$smarty->assign("weekN",$weekN); 
$smarty->assign("midnoon",$midnoon-1);
$smarty->assign("sections",$sections);
$smarty->assign("section_table",$section_table); 
$smarty->assign("template_dir",$template_dir);
$smarty->display("$template_dir/course_prn.htm");


	
	exit;
	return;
}
?>
