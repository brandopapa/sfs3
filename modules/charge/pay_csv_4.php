<?php
// $Id: pay_csv.php 5310 2009-01-10 07:57:56Z hami $

include "config.php";
include "my_fun.php";

sfs_check();

//�Ǵ��O
$work_year_seme=$_REQUEST[work_year_seme];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());

$item_id=$_REQUEST[item_id];
$selected_stud=$_POST[selected_stud];
$dollars=$_POST[dollars];
$grade=substr($class_id,0,1);

// ���X�Z�ŦW�ٰ}�C
//$class_base= class_base($work_year_seme);

if($_POST['act']=='���ͥɤs�Ȧ�CSV'){
	// ���X�Z�ŦW�ٰ}�C
	$class_base=class_base($work_year_seme);
	
	//���o���ئW��
	$sql="select * from charge_item where item_id=$item_id";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);

	$detail_list=get_item_detail_list($item_id);
	$student_arr=get_item_all_stud_list($item_id);

	$detail_column_array=array();
	$detail_column='';
	
	foreach($detail_types as $key=>$value){
		$value.='�p�p';
		$sql_select="select * from charge_detail where item_id=$item_id and detail_type=$key order by detail_sort";
		$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
		while(! $res->EOF){
			$detail_name=$res->fields['detail'];
			$detail_column_array[]=$detail_name;
			$detail_column.=",$detail_name";
			
			//���F�i��p�p  ���͹����}�C
			$type_summary_arr[$detail_name]=$value;
				
			$res->MoveNext();		
		}
		$detail_column_array[]=$value;
		$detail_column.=",$value";
	}
	$detail_column.=",�X�p,�~�ťN�X,�Z�O�N�X";
	
	
/*
echo "<PRE>";
echo $detail_column."<BR><BR>";
print_r($detail_column_array);

echo "</PRE>";
exit;	
*/	

	//�}�l��X���
	foreach($student_arr as $key=>$value){
		//echo "<pre>";
		//print_r($detail_list);	
		//echo "</pre>";
	
		$stud_id=$value['stud_id'];
		$stud_name=$value['stud_name'];
		$stud_class_no=substr($value['record_id'],-2);
		$stud_class_id=substr($value['record_id'],-5,3);
		$stud_class_grade=substr($stud_class_id,0,1);
		$stud_person_id=$value['stud_person_id'];
		//�Ǹ�,�Z��,�m�W,�y��,�����Ҹ�,��K�N�X
		$row_data="$stud_id,{$class_base[$stud_class_id]},$stud_name,$stud_class_no,$stud_person_id,";
		//foreach($detail_list as $key=>$detail_item){
		$total=0;
		foreach($detail_column_array as $key=>$detail_item){
			$dollars=$value['detail']["$detail_item"]['original'];
			$decrease_dollars=$value['detail']["$detail_item"]['decrease_dollars'];
			if($detail_item) $need_to_pay=$dollars-$decrease_dollars; else $need_to_pay='';
			
			if(substr($detail_item,-4) != '�p�p'){
				$total+=$need_to_pay;
				$value['detail'][$type_summary_arr[$detail_item]]['original']+=$need_to_pay;
			}
			$row_data.=",$need_to_pay";
		}
		//�[�W �X�p	�~�ťN�X �Z�O�N�X
		$row_data.=",$total,$stud_class_grade,$stud_class_id";
		$data.="$row_data\n";
}

	//�ɦW
	$filename=$work_year_seme."_�ɤs�Ȧ榬�O�M�U".$res->fields[item].".csv";
	
	################################    ��X CSV    ##################################
	$Str="�Ǹ�,�Z��,�m�W,�y��,�����Ҹ�,��K�N�X".$detail_column;
	

	$Str.="\n".$data;

	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: text/x-csv");
	//header("Pragma: no-cache");
					//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");

	header("Expires: 0");
	echo $Str;
	exit;	
};

//�q�X����
head("���O�޲z");

print_menu($menu_p);

//��V������
$linkstr="work_year_seme=$work_year_seme&item_id=$item_id";
echo print_menu($MENU_P,$linkstr);


//���o�~�׻P�Ǵ����U�Կ��
$seme_list=get_class_seme();
$main="<BR>����X��CSV�A�Y�o�{�Ҧ����O���B�Ҭ� 0�A�нվ�Ҳ��ܼ� is_sort(���ثe�ɱƧǥN��)�A�N��]��'�_'�C<BR>���ϥΫe�A�Цb�ӥس]�w���N���O�ӥس]�w�n'���k�b��'�C";
$main.="<BR>�����k�b��ﶵ�P�U�����ƽнվ�Ҳ��ܼ�'�ӥئ��k�b��ѷ�'��'�ӥئ��k�b��ѷӦC������'�A�������G�ܼơA�Ы����^�w�]�ȡC";
$main.="<BR>����X���ɮ׫��A���Ѣ��A�Щ�Ӣ�ѢӢڤ��}�Ҩåt�s����ڢ�C<BR><BR>";
$main.="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#AAAAAA' width='100%'><form name='myform' method='post' action='$_SERVER[PHP_SELF]'>
	<select name='work_year_seme' onchange='this.form.submit()'>";
foreach($seme_list as $key=>$value){
	$main.="<option ".($key==$work_year_seme?"selected":"")." value=$key>$value</option>";
}
$main.="</select><select name='item_id' onchange='this.form.submit()'><option></option>";

//���o�~�׶���
$sql_select="select * from charge_item where year_seme='$work_year_seme' order by end_date desc";
$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

while(!$res->EOF) {
	$main.="<option ".($item_id==$res->fields[item_id]?"selected":"")." value=".$res->fields[item_id].">".$res->fields[item]."(".$res->fields[start_date]."~".$res->fields[end_date].")</option>";
	$res->MoveNext();
}
$main.="</select>";

if($item_id)
{
	//��ܯZ��
	//$class_list=get_item_class($item_id,$class_base,$class_id);
	$main.=$class_list."<input type='submit' value='���ͥɤs�Ȧ�CSV' name='act'>";
}
echo $main.$studentdata."</form></table>";
foot();
?>
