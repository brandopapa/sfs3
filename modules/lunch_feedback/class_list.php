<?php

// $Id: class_list.php 5310 2009-01-10 07:57:56Z hami $
include "config.php";

sfs_check();

//�q�X����
head("���\�N���լd");

//��V������
echo print_menu($MENU_P);

if(checkid($_SERVER['SCRIPT_FILENAME'],1))
{
//����̪�Ѽ�
$list_period=$m_arr[list_period];

$sql="select pDate,pMday from lunchtb where TO_DAYS(curdate())-TO_DAYS(pDate) between 0 AND $list_period ORDER BY pDate DESC";
$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
$days_list=$res->GetRows();

$list_date=$_POST[list_date];
if(!$list_date) $list_date=date("Y-m-d");
$list_class=$_POST[list_class];
if(!$list_class) $list_class=$class_id;

//���ͤ�����
$date_combo="<select name='list_date' onchange='this.form.submit()'>";
foreach($days_list as $value)
{
	if($list_date==$value[pDate]) $is_this_date='selected'; else $is_this_date='';
	$date_combo.="<option $is_this_date value='$value[pDate]'>".$value[pDate]."(".$c_day[$value[pMday]].")</option>";
}
$date_combo.="</select>";

//�Ǵ��O
$work_year_seme = sprintf("%03d%d",curr_year(),curr_seme());
//���X�Z�ŦW�ٰ}�C
$class_base = class_base($work_year_seme);
$unsigned=$class_base;

//��ܥ��~��
$show_grade=$_POST[show_grade];
$show_grade_checkbox="<input type='checkbox' name='show_grade'".($show_grade?' checked':'')." onclick='this.form.submit()'>��ܥ��~��";
$class_filter=$show_grade?substr($list_class,0,1):$list_class;

//�ƧǤ覡
$sort_method=$_POST[sort_method];
$method_arr=array('�Z��'=>'class_id','�D�ƭ�����'=>'item,class_id',);
if(!$sort_method) $sort_method=$method_arr[�Z��];
$sort_method_radio="�ƧǡG";
foreach($method_arr as $key=>$value)
{
	$sort_method_radio.="<input type='radio' value='$value' name='sort_method'".($sort_method==$value?' checked':'')." onclick='this.form.submit()'>$key ";
}
//���ͯZ�ſ��
$class_combo="<select name='list_class' onchange='this.form.submit()'><option></option>";
//�C�ܶ���Z��
$sql="select DISTINCT class_id from lunch_feedback where pDate='$list_date' ORDER BY class_id";
$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
$signed_class=$res->recordcount();
while(!$res->EOF)
{
	if($list_class==$res->fields[class_id]) $is_this_class='selected'; else	$is_this_class='';
	$class_combo.="<option $is_this_class value='".$res->fields[class_id]."'>".$class_base[$res->fields[class_id]]."</option>";	
	
	//�N���Z�Ŧۥ�����W��簣
	unset($unsigned[$res->fields[class_id]]);

	$res->MoveNext();
}

$class_combo.="</select>";

$unsigned_class="<BR>���w������Z�żơG$signed_class<BR><font color='#FF0000'>���|��������Z��(".count($unsigned)."�Z)�G";
	
foreach($unsigned as $key=>$value)
{
	$unsigned_class.=$value."�A";
}
$unsigned_class=substr($unsigned_class,0,-2)."�C";

$main="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' width='100%'><form name='form_day' method='post' action='$_SERVER[PHP_SELF]'>
	$date_combo $class_combo �@ $show_grade_checkbox �@�@ $sort_method_radio";

$showdata="<tr>
	<td align='center' bgcolor='#CCFF99' rowspan=2>�Z��</td>
	<td align='center' bgcolor='#CCFF99' rowspan=2>�D�ƭ��W��</td>
	<td align='center' bgcolor='#CCFF99' colspan=3>���N�׽լd</td>
	<td align='center' bgcolor='#CCFF99' rowspan=2>��r�N��</td>
	</tr>
	<tr>
	<td align='center' bgcolor='#CCFF99'>�ƶq</td>
	<td align='center' bgcolor='#CCFF99'>�⭻��</td>
	<td align='center' bgcolor='#CCFF99'>�åͦw��</td></tr>";
	//����Z�ūe�w������
	$sql="select * from lunch_feedback where pDate='$list_date' and class_id like '$class_filter%' ORDER BY $sort_method";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	while(!$res->EOF)
	{
		if($res->fields[item])
		{
			$showdata.="<tr bgcolor=#FFFFDD><td align='center'>".$class_base[$res->fields[class_id]]."</td>";
			$showdata.="<td align='center'>".$res->fields[item]."</td>";
			$showdata.="<td align='center'>".$res->fields[quantity]."</td>";
			$showdata.="<td align='center'>".$res->fields[taste]."</td>";
			$showdata.="<td align='center'>".$res->fields[hygiene]."</td>";		
			$showdata.="<td>".$res->fields[memo]."</td>";
			$showdata.="</td></tr>";
		}
		$res->MoveNext();
	}
if($m_arr['warning']<>'Y') $unsigned_class='';
	
$showdata.="</form></table>$unsigned_class";

echo $main.$showdata;

} else echo "�z�ëD�Ҳպ޲z��, �L�k�[���έp��T!!";

foot();

?>