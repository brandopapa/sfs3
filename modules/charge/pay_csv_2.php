<?php
// $Id:  $

include "config.php";
include "my_fun.php";

sfs_check();

//�Ǵ��O
$work_year_seme=$_POST[work_year_seme];
if($work_year_seme=='') $work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());

$item_type=$_POST['item_type'];
$max_sort=$_POST['max_sort'];

$grade=substr($class_id,0,1);

if($_POST['act']=='����CSV'){
	//���o"���w�Ǵ�"�P"���O"���Ҧ������O�ӥ�
	$detail_list_all=array();
	$student_arr_all=array();
	
	$sql="select distinct item_id from charge_item where year_seme='$work_year_seme' AND item_type='$item_type' ORDER BY item_id";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	while(!$res->EOF) {
		$item_id_list.=$res->fields['item_id'].',';		
		$res->MoveNext();
	}
	$item_id_list=substr($item_id_list,0,-1);
	
	$detail_list=get_item_detail_list_multi($item_id_list);
	ksort($detail_list);
	$student_arr=get_item_all_stud_list_multi($item_id_list);
	
	ksort($student_arr); //�H�Z�Ůy���Ƨ�

	//�}�l��X���
	foreach($student_arr as $key=>$value)
	{
		$study_year=substr($value['stud_id'],0,2);
		$stud_name=$value['stud_name'];
		$stud_class_no=substr($value['record_id'],-2);
		$stud_class_serial=substr($value['record_id'],5,2);
		
		$row_data="$study_year,$stud_name,$stud_class_serial,$stud_class_no";

		for($i=1;$i<=$max_sort;$i++) {
			if (array_key_exists($i,$value['detail'])) {
				$detail_item=$value['detail'][$i][item];
				$dollars=$value['detail'][$i]['original'];
				$decrease_dollars=$value['detail'][$i]['decrease_dollars'];
				$need_to_pay=$dollars-$decrease_dollars;
				$row_data.=",$detail_item,$need_to_pay";
			} else $row_data.=",,";
		}
		$data.="$row_data\n";
	}

//echo "<pre>";
//print_r($student_arr);
//echo "</pre><BR><BR>";
//exit;	
	
	//�ɦW
	$filename=$work_year_seme."_���O�M�U(����H�U��)".$item_type.".csv";
	
	################################    ��X CSV    ##################################
	$Str="�J�ǾǦ~��,�ǥͩm�W,�Z��,�y��";
	//���Y�C�[�W���O�ӥ�
	for($i=1;$i<=$max_sort;$i++) {
			$Str.=",�ǲӶ�$i,�Ǫ��B$i";	
	}

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
$main="�������G
<li>��CSV��X�Y�w��Ǯթe�U����H�U�ӷ~�Ȧ��z�ǥͦ��O�Ʃy�ҳ]�p�C</li>
<li>��CSV���榡���ĩT�w�Ǹ��Ҧ��A�æ��������j�C</li>
<li>�榡�W�d�G�J�ǾǦ~��	�ǥͩm�W	�Z��	�y��	�ǲӶ�1	�Ǫ��B1	�ǲӶ�2	�Ǫ��B2.......�ǲӶ�15	�Ǫ��B15�C</li>
<li>�i�i��P�Ǵ��h���O���ت��ӥزΦX��X�A�߶��N��]���P�@�����O�A�åB 1.�ƧǤ��i���� 2.�ƧǶ����Ʀr�C</li>
<li>�ӥت��ƧǸ��X�Y����X�ɪ����ǽX�C</li>
<li>��X���ɮ׫��A���Ѣ��A�Щ�Ӣ�ѢӢڤ��}�Ҩåt�s����ڢ�C</li>
<BR><BR>����X�G


";
$main.="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#AAAAAA' width='100%'><form name='myform' method='post' action='$_SERVER[PHP_SELF]'>
	�@�����O���O�G<select name='work_year_seme' onchange='this.form.submit()'>";
foreach($seme_list as $key=>$value){
	$main.="<option ".($key==$work_year_seme?"selected":"")." value=$key>$value</option>";
}
$main.="</select><select name='item_type' onchange='this.form.submit()'><option></option>";

//���o�Ǵ����O
$sql_select="select item_type,count(*) as item_count from charge_item where year_seme='$work_year_seme' group by item_type order by item_type";
$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);

while(!$res->EOF) {
	$main.="<option ".($item_type==$res->fields['item_type']?"selected":"")." value='".$res->fields['item_type']."'>".$res->fields['item_type']."(".$res->fields['item_count'].")</option>";
	$res->MoveNext();
}
$main.="</select>";


//��ܳB�z���s
if($item_type)
{
	$error_message='';
	//������O�ӥ�
	$detail_array=array();
	$max_sort=0;
	$sql_select="select a.*,b.item,b.item_type from charge_detail a,charge_item b where a.item_id=b.item_id AND b.year_seme='$work_year_seme' AND b.item_type='$item_type' ORDER BY detail_sort";
//echo "$sql_select<BR>";

	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$res->EOF) {
		$detail_sort=$res->fields['detail_sort'];
		if($detail_sort>$max_sort) $max_sort=$detail_sort;
		$detail_array[$detail_sort]['detail'].=$res->fields['item']."=>".$res->fields['detail'].';';
		$detail_array[$detail_sort]['counter']+=1;
		$res->MoveNext();
	}
	//�}�l�ˬd
	$detail_messdage='';
	$error_count=0;
	foreach($detail_array as $key=>$value)
	{
		$detail=$value['detail'];
		$counter=$value['counter'];
		if($value['counter']>1 or $key==0) { $error_count+=1; $show_color='red'; } else  { $show_color='green'; }
		$detail_messdage.="<font color='$show_color'><BR>�@�@�� $key($counter)  $detail</font>";
	}
	$max_sort=max($max_sort,15);
	if(!$error_count) $class_list.=" ���ӥ�����:<input type='text' name='max_sort' value='$max_sort' size=3> <input type='submit' value='����CSV' name='act'>";
}
echo "$main $class_list <BR> $detail_messdage</form></table>";
foot();
?>
