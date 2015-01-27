<?php

// $Id: class_year_setup.php 5310 2009-01-10 07:57:56Z hami $

//���J�Z�ų]�w
include "config.php";

sfs_check();

if (!ini_get('register_globals')) {
	ini_set("magic_quotes_runtime", 0);
	extract( $_POST );
	extract( $_GET );
	extract( $_SERVER );
}

if(empty($sel_year))$sel_year = curr_year(); //�ثe�Ǧ~
if(empty($sel_seme))$sel_seme = curr_seme(); //�ثe�Ǵ�
if(empty($_REQUEST['act']))$_REQUEST['act']="";

//����ʧ@�P�_
if($_REQUEST['act']=="�x�s�]�w"){
	save_all_setup($sel_year,$sel_seme,$c_num,$c_name_kind,$mode);
	header("location: {$_SERVER['PHP_SELF']}?act=view&sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($_REQUEST['act']=="��s�Z�ŦW��"){
	update_one_class_name($sel_year,$sel_seme,$c_name);
	header("location: {$_SERVER['PHP_SELF']}?act=view&sel_year=$sel_year&sel_seme=$sel_seme");
}elseif($_REQUEST['act']=="view" or $_REQUEST['act']=="�[�ݳ]�w"){
	$main=&main_form($sel_year,$sel_seme,"view");
}elseif($_REQUEST['act']=="�}�l�]�w" or $_REQUEST['act']=="�ק�]�w" or $_REQUEST['act']=="setup"){
	$main=&main_form($sel_year,$sel_seme,"edit");
}elseif($_REQUEST['act']=="class_setup"){
	$main=&main_form($sel_year,$sel_seme,"view",$Cyear);
}else{
	$main=&pre_form($sel_year,$sel_seme);
}


//�q�X����
head("�Z�ų]�w");
echo $main;
foot();


/*
�禡��
*/
//�򥻳]�w���
function &pre_form($sel_year,$sel_seme){
	global $school_menu_p;
	//�����\���
	$tool_bar=&make_menu($school_menu_p);
	//����
	$help_text="
	�п�ܤ@�ӾǦ~�B�Ǵ��H���]�w�C||
	<span class='like_button'>�}�l�]�w</span> �|�}�l�i��ӾǦ~�Ǵ����~�ų]�w�C||
	<span class='like_button'>�[�ݳ]�w</span>�|�C�X�ӾǦ~�Ǵ����~�ų]�w�C
	";
	$help=&help($help_text);

	//���o�~�׻P�Ǵ����U�Կ��
	$date_select=&date_select($sel_year,$sel_seme);

	$main="
	$tool_bar
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<tr bgcolor='#FFFFFF'><td>
		<table>
		<form action='{$_SERVER['PHP_SELF']}' method='post'>
  		<tr><td>�п�ܱ��]�w���Ǧ~�סG</td><td>$date_select</td></tr>
		<tr><td colspan='2'><input type='submit' name='act' value='�}�l�]�w' class='b1'>
		<input type='submit' name='act' value='�[�ݳ]�w' class='b1'>
		</td></tr>
		</form>
		</table>
	</td></tr>
	</table>
	<br>
	$help
	";
	return $main;
}



//�D�n���]�w���
function &main_form($sel_year,$sel_seme,$mode="edit",$Cyear=""){
	global $CONN,$school_kind_name,$school_kind_end,$school_kind_name_n,$school_menu_p,$class_name_kind,$school_kind_color,$IS_JHORES;
	
	
	foreach($school_kind_name as $key=>$value){
		
		//���o��Ʈw�̭즳�Z�ż�
		$num=get_year_class_num($sel_year,$sel_seme,$key);
		//�p�G�O�[�ݼҦ��A�S�����N���n�C�X�ӡC
		if(empty($num) and $mode=="view")continue;
		
		//��p�q�X 0-6�A�ꤤ�q�X7-12
		if((($IS_JHORES=='0' and $key <= 6) or ($IS_JHORES=='6' and $key >=7) or $_REQUEST['op']==all) or $mode=="view"){
			if($key==0){
				$pre_text="";
			}elseif($key <= 6){
				$pre_text="��p";
			}elseif($key <= 9){
				$pre_text="�ꤤ";
			}elseif($key <= 12){
				$pre_text="����";
			}
			
		}else{
			continue;	
		}
		
		
		$end_txt=($key==0)?"":"��";
		
		if($_REQUEST[act]!="view"){
			$op_link=($_REQUEST[op]=="all")?"<a href='$_SERVER[PHP_SELF]?act=$_REQUEST[act]&sel_year=$sel_year&sel_seme=$sel_seme'>�C�X�w�]�~��</a>":"<a href='$_SERVER[PHP_SELF]?op=all&act=$_REQUEST[act]&sel_year=$sel_year&sel_seme=$sel_seme'>�C�X�Ҧ��~��</a>";
		}else{
			$op_link="";
		}
		
		

		//���o�Z�ũR�W�覡
		$yc_name=get_year_class_name($sel_year,$sel_seme,$key);
		$class_nk="";
		for($i=0;$i<sizeof($class_name_kind);$i++){
			$selected=($yc_name==$i)?"selected":"";
			$class_nk.="<option value='$i' $selected>$class_name_kind[$i]</option>\n";
		}

		//���o�Z�ų]�w�s�����
		$class_setup_button=(!empty($num))?"<a href='{$_SERVER['PHP_SELF']}?act=class_setup&Cyear=$key&sel_year=$sel_year&sel_seme=$sel_seme'>".$school_kind_name[$key]."�U�Z�ų]�w</a>":"";

		$classnk=($mode=="edit")?"<select name='c_name_kind[$key]'>$class_nk</select>\n":$class_name_kind[$yc_name];
		$select_class_num=($mode=="edit")?"<input type='text' name='c_num[$key]' size='3' value='$num'>\n":$num;
		
		$db_mode=(empty($num))?"insert":"update";
		$insert_or_update=$db_mode."-".$num;

		$all_year.="<tr bgcolor='$school_kind_color[$key]'>
		<td>".$pre_text.$school_kind_name[$key].$end_txt."
		<input type='hidden' name='mode[$key]' value='$insert_or_update'></td>
		<td>�@ $select_class_num �Z</td>
		<td>$classnk</td>
		<td>$class_setup_button</td>
		</tr>";
	}

	//�p�G�O�[�ݼҦ��A�ܤ@�q�X�Y�i�C
	if($mode=="view"){
		$test_ratio_set=($sm[score_mode]=="all")?$all_mode:$severally_mode;
		$submit="�ק�]�w";
	}else{
		$test_ratio_set=$all_mode."\n".$severally_mode;
		$submit="�x�s�]�w";
	}

	$tmp=&class_setup($sel_year,$sel_seme,$Cyear);
	$class_setup=(!is_null($Cyear) and $_REQUEST['act']=="class_setup")?"<td bgcolor='white' width=6></td><td valign='top'>".$tmp."</td>":"";
	


	//����
	$help_text="
	�u���Ǵ��Ǯզ~�šv�ФĿ�ثe�Q�թҦ����~�šC
	||�S�����~�šA�N���ݭn��Z�żơC
	";
	$help=&help($help_text);

	$semester_name=($sel_seme=='2')?"�U":"�W";

	$date_text="<font color='#607387'>
	<font color='#000000'>$sel_year</font> �Ǧ~
	<font color='#000000'>$semester_name</font>�Ǵ�
	</font>";


	//�����\���
	$tool_bar=&make_menu($school_menu_p);

	$main="
	$tool_bar
	<table cellspacing=0 cellpadding=0><tr><td valign='top'>
		<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
			<form action='{$_SERVER['PHP_SELF']}' method='post'>
   			<tr bgcolor='#FFFFFF'>
			<td colspan='4'>���]�w���Ǧ~�סG $date_text $op_link</td></tr>
			<tr bgcolor='#E1ECFF'><td>�Ǯզ~��</td><td>�Z�ż�</td><td>�W�ٺ���</td><td>�U�Z�C��</td></tr>
			$all_year
			<input type='hidden' name='sel_year' value='$sel_year'>
			<input type='hidden' name='sel_seme' value='$sel_seme'>
			<tr bgcolor='#FFFFFF'><td valign='top' colspan='4' align='center'><input type='submit' name='act' value='$submit' class='b1'></td></tr>
			</form>
			</table>
	</td>$class_setup</tr></table>
	<p>
	$help
	</p>
	";
	return $main;
}

//�s�@�Z��id
function make_class_id($year,$semester,$c_year,$c_sort){
	//�� $class_id �����~����찵�ӽվ�
	if(strlen($year)==2)$year="0".$year;
	if(strlen($c_year)==1)$c_year="0".$c_year;
	if(strlen($c_sort)==1)$c_sort="0".$c_sort;

	$semester=$semester*1;
	$class_id=$year."_".$semester."_".$c_year."_".$c_sort;
	return $class_id;
}


//�s�W�@�ӯZ�ų]�w
function add_setup($year,$semester,$c_year,$c_sort,$c_name){
	global $CONN;
	
	$class_id=make_class_id($year,$semester,$c_year,$c_sort);
	if($c_name!=""){
		$sql_insert = "insert into school_class (class_id,year,semester,c_year,c_name,c_sort,enable) values ('$class_id',$year,'$semester','$c_year','$c_name',$c_sort,'1')";
	}else{
		$sql_insert = "insert into school_class (class_id,year,semester,c_year,c_sort,enable) values ('$class_id',$year,'$semester','$c_year',$c_sort,'1')";		
	}	
	$CONN->Execute($sql_insert) or user_error("������~�G$sql_insert<br>",256);
	return mysql_insert_id();
}


//��s�@�ӯZ�ų]�w
function update_setup($year,$semester,$c_year,$c_sort,$c_name){
	global $CONN;
	if($c_name==""){
		return;
	}
	$class_id=make_class_id($year,$semester,$c_year,$c_sort);
	$sql_update = "update school_class set c_name='$c_name' where class_id='$class_id'";
	
	if($CONN->Execute($sql_update))	return;
	return  false;
}


//�R���@�ӯZ�ũΤ@��Ӧ~�ų]�w
function delete_class($year,$semester,$c_year="",$c_sort=""){
	global $CONN;
	if(!empty($c_sort))$and_c_sort="and c_sort=$c_sort";
	$sql_delete = "delete from school_class where year=$year and semester='$semester' and c_year='$c_year' $and_c_sort";
	if($CONN->Execute($sql_delete))	return;
	return  false;
}

//�s�W�Ҧ��Z�ų]�w
function save_all_setup($sel_year="",$sel_seme="",$c_num="",$c_name_kind="",$mode=""){
	global $CONN,$class_name_kind_1,$class_name_kind_2,$class_name_kind_3;

	foreach($c_num as $i => $n){
		//����$mode�A�Ĥ@�ӬO�n�s�W�Χ�s�A�ĤG�ӬO�O�������ƥجO�h��
		$m=explode("-",$mode[$i]);
		$db_mode=$m[0];
		
		//�쥻���Z�żƶq
		$num=$m[1];
				
		$class_nk="";
		
		//���p�Z�żƤ��O�ť�
		if(!empty($n)){
			//���R�Z�ŦW��			
			if($c_name_kind[$i]=='1' or $c_name_kind[$i]=='2' or $c_name_kind[$i]=='3'){
				$class_nk=${"class_name_kind_".$c_name_kind[$i]};
			}elseif($c_name_kind[$i]=='4'){
				$class_nk="other";
			}else{
				$class_nk=$class_name_kind_1;
			}
			
			
			//�H�Y�~�Ū��Z�żƬ��̾�
			for($j=1;$j<=$n;$j++){
				//���p $cnk ���S���ӼƦr�������W�١A����Z�ŦW�٥έ�Ʀr�s�ɡA�Y�O��L�h�� $c_name �]���ťաC
				if($class_nk=="other"){
					$c_name="";
				}else{
					$c_name=(empty($class_nk[$j]))?$j:$class_nk[$j];
				}
				//����s�W�Χ�s
				if($db_mode=="insert"){
					add_setup($sel_year,$sel_seme,$i,$j,$c_name);
				}elseif($db_mode=="update"){
					update_setup($sel_year,$sel_seme,$i,$j,$c_name);
				}
			}
			
			//���p��Ӫ���Ƥ��]�w�٦h�A���n�R���h�X�Ӫ��³]�w�C
			if($num > $n){
				$start=$n+1;

				for($k=$start;$k<=$num;$k++){
					delete_class($sel_year,$sel_seme,$i,$k);
				}
			}elseif($num < $n and !empty($num)){
			//���p��Ӫ���Ƥ��]�w�٤֡A���n�s�W�h�X�Ӫ��s�]�w�C
				$start=$num+1;

				for($k=$start;$k<=$n;$k++){
					//�Z�ŦW��
					$cnk=$class_nk[$k];
					//���p$cnk���S���ӼƦr�������W�١A����Z�ŦW�٥έ�Ʀr�s��
					$c_name=(empty($cnk))?$k:$cnk;
					add_setup($sel_year,$sel_seme,$i,$k,$c_name);
				}
			}
			
		}elseif(!empty($num)){
			//���p�Ƕi�Ӹ�ƬO�ťժ��A���O��ӨëD�ťժ��A���n���R���ʧ@�C
			delete_class($sel_year,$sel_seme,$i,$k);
		}
	}
	
	return;
}



//�Y�Ӧ~�Ū��Z�ų]�w
function &class_setup($sel_year,$sel_seme,$Cyear){
	global $CONN,$school_kind_name,$class_name_kind;

	$sql_select = "select class_id,c_name from school_class where year='$sel_year' and semester = '$sel_seme' and c_year='$Cyear' and enable='1' order by c_sort";
	$recordSet=$CONN->Execute($sql_select);
	while(list($class_id,$c_name)=$recordSet->FetchRow()){
	
		$data.="<tr bgcolor='white'>
		<td align='center'>".$school_kind_name[$Cyear]."<input type='text' name='c_name[$class_id]' value='$c_name' size=3>�Z</td>
		</tr>";
	}
	
	
	$main="
	<table bgcolor='#9EBCDD' cellspacing=1 cellpadding=4>
	<form action='{$_SERVER['PHP_SELF']}' method='post'>
	<tr bgcolor='#E1ECFF'><td>�ק�".$school_kind_name[$Cyear]."�ŭӧO�Z�ŦW��</td></tr>
	$data
	</table>
	<br>
	<input type='hidden' name='sel_year' value='$sel_year'>
	<input type='hidden' name='sel_seme' value='$sel_seme'>
	<div align='center'><input type='submit' name='act' value='��s�Z�ŦW��' class='b1'></div>
	</form>
	";

	return $main;
}

//���o�Z�ż�
function get_year_class_num($sel_year,$sel_seme,$key){
	global $CONN;
	$sql_select = "select count(*) from school_class where year='$sel_year' and semester = '$sel_seme' and c_year='$key' and enable='1'";
	$recordSet=$CONN->Execute($sql_select);
	list($num)=$recordSet->FetchRow();
	if($num==0)$num="";
	return $num;
}

//��s�Y�@�Z�Ū��W��
function update_one_class_name($sel_year,$sel_seme,$c_name){
	global $CONN;
	if(empty($c_name))return;
	while(list($class_id,$name)=each($c_name)){
		$sql_update = "update school_class set c_name='$name' where year=$sel_year and semester='$sel_seme' and  class_id='$class_id' and enable='1'";
		$CONN->Execute($sql_update) or trigger_error($sql_update, E_USER_ERROR);
	}
	return  true;
}

//���o�Y�@�Z���R�W�覡
function get_year_class_name($sel_year,$sel_seme,$c_year){
	global $CONN,$class_name_kind_1,$class_name_kind_2,$class_name_kind_3;

	$sql_select = "select c_name from school_class where year='$sel_year' and semester = '$sel_seme' and c_year='$c_year' and enable='1'";

	$recordSet=$CONN->Execute($sql_select)  or trigger_error($sql_select, E_USER_ERROR);

	while(list($c_name) = $recordSet->FetchRow()){
		if(in_array($c_name,$class_name_kind_1))return 1;
		if(in_array($c_name,$class_name_kind_2))return 2;
		if(in_array($c_name,$class_name_kind_3))return 3;
		if(!empty($c_name))return 4;
	}
	return 0;
}

?>
