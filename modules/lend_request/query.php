<?php

//$Id: query.php 6732 2012-03-28 01:54:06Z infodaes $
include "config.php";
sfs_check();
//�q�X����
head("���~�ɥά���");

$manager_sn=$_REQUEST['manager_sn'];
$status=$_POST['status'];
$nature=$_POST['nature'];
$EditSearch=$_POST['EditSearch'];
if($EditSearch){ $manager_sn=0; $nature=''; }

if($_POST['BtnSubmit']=='���к޲z�H�X��'){
	$item_selected=$_POST[item_selected];
	if($item_selected)
	{
		//print_r($item_selected);
		//�i��d�߬�����ӽЬ���
		$ask_items='';
		$executed='';
		foreach($item_selected as $value)
		{
			//�i��P�w�O�_���H�M�w�ɶ����w�g���w���F
			$item=explode(',',str_replace("^^","",$ask_items));
			$item_serial=$item[0];
			$sql_select="SELECT a.equ_serial,b.item FROM equ_request a,equ_equipments b WHERE equ_serial='$item_serial' AND a.equ_serial=b.sn";

			$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
			if($res->recordcount()){
				$executed.="[".$res->fields['equ_serial']."]".$res->fields['item']." �b�z�e�X�M�w�e�w�g�Q�w���F!!<br>";
			} else {
				$ask_items.="($session_tea_sn,NOW(),$value,'�ݮ�'),";
			}
		}
		$ask_items=SUBSTR($ask_items,0,-1).';';
		$ask_items=str_replace("^^","'",$ask_items);
		$sql="INSERT INTO equ_request(teacher_sn,ask_date,equ_serial,manager_sn,status) VALUES $ask_items";
		$res=$CONN->Execute($sql) or user_error("�g�J�ӽЬ������ѡI<br>$sql",256);
	}
}

//��V������
$linkstr="manager_sn=$manager_sn";
echo print_menu($MENU_P,$linkstr);


//�ˬd�O�_���]�wEMAIL�~��ɥ�
if($User_Email='Y' and ! $teacher_email) {
	echo "<BR><a href='../teacher_self/teach_connect.php'>�z�|���]�w�n�z���q�l�l��A<BR>�Ы����s���� �q�l�l��1(���G) ���]�w�A��i�i�檫�~�ɥΡI</a>";
	foot();
	exit;
	}


//�ˬd�O�_���O�����k����
if($m_arr['Delay_Refused'])
{
	$sql_select="SELECT CONCAT('[',a.equ_serial,']',b.item,':',a.lend_date,'~',a.refund_limit) as delayitem FROM equ_record a,equ_equipments b WHERE a.teacher_sn=$session_tea_sn AND a.equ_serial=b.serial AND ISNULL(a.refund_date) AND CURDATE()>a.refund_limit";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	if($res->recordcount())
	{
		$delay_items=$m_arr['Delay_Refused_announce'].'<ol>';
		while(!$res->EOF) {
			$delay_items.="<li>".$res->fields['delayitem']."</li>";
			$res->MoveNext();
		}
		echo "<BR><font color='red'>$delay_items</font></ol>";
		foot();
		exit;
	}	
}



//���o�޲z�H�g�ޤ����~����
if($manager_sn){
	$nature_select="<select name='nature' onchange='this.form.EditSearch.value=\"\"; this.form.submit()'><option></option>";
	$sql_select="SELECT nature,count(*) as amount FROM equ_equipments WHERE opened='Y' AND manager_sn=$manager_sn GROUP BY nature";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$res->EOF) {
		$nature_select.="<option ".($nature==$res->fields['nature']?"selected":"")." value=".$res->fields['nature'].">".$res->fields['nature']."(".$res->fields['amount'].")</option>";
		$res->MoveNext();
	}
	$nature_select.="</select>";
}

//echo $sql_select;

$main="<table align=center width=".$m_arr['Table_width']."% border='2' cellpadding='5' cellspacing='0' style='border-collapse: collapse' bordercolor='#111111' id='AutoNumber1'>";
$main.="<form name='form_query' method='post' action='$_SERVER[PHP_SELF]'>�޲z�̻P���~���O���w�G<select name='manager_sn' onchange='this.form.EditSearch.value=\"\"; this.form.submit()'><option></option>";

	//���o�w�ɥζ��ؤ��޲z�H
	$sql_select="SELECT manager_sn,count(*) as amount FROM equ_equipments WHERE opened='Y' GROUP BY manager_sn";
	$res=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
	while(!$res->EOF) {
		$main.="<option ".($manager_sn==$res->fields['manager_sn']?"selected":"")." value=".$res->fields['manager_sn'].">".$teacher_array[$res->fields['manager_sn']]['title']."-".$teacher_array[$res->fields['manager_sn']]['name']."(".$res->fields['amount'].")</option>";
		$res->MoveNext();
	}
	$main.="</select>".($manager_sn?$nature_select:'')."�@�@ �W�٬d�ߡG<input type='text' name='EditSearch' size='10' value='$EditSearch'><input type='submit' value='�d��' name='BtnSubmit'>";
	
if($manager_sn or $EditSearch)
{
	
$showdata.="
	<tr bgcolor='$Tr_BGColor'>
		<td align='center'>�޲z��</td>
		<td align='center'>���~�s��</td>
		<td align='center'>���~�W��</td>
		<td align='center'>�]���s��</td>
		<td align='center'>�ʶR���</td>
		<td align='center'>�s�y��</td>
		<td align='center'>����</td>
		<td align='center'>����</td>
		<td align='center'>�ɴ�</td>
		<td align='center'>���A</td>
	</tr>";	


//���o�w�w��������
$Requested_arr=array();
//$sql_select="SELECT * FROM equ_request WHERE ISNULL(memo)";
$sql_select="SELECT * FROM equ_request";  //�u�n���w�������K����A�w���F
$result=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);	
while(!$result->EOF)
{
	$Requested_arr[$result->fields['equ_serial']]['teacher_sn']=$result->fields['teacher_sn'];
	$Requested_arr[$result->fields['equ_serial']]['ask_date']=$result->fields['ask_date'];
	$Requested_arr[$result->fields['equ_serial']]['status']=$result->fields['status'];
	$result->MoveNext();
}

//echo "<PRE>";
//print_r($Requested_arr);
//echo "</PRE>";

//���o�ɥΥ��k����
$NoReturn_arr=array();
$sql_select="SELECT equ_serial,teacher_sn,lend_date,refund_limit,(TO_DAYS(CURDATE())-TO_DAYS(refund_limit)) as leftdays FROM equ_record WHERE ISNULL(refund_date)";
$result=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);	
while(!$result->EOF)
{
	$NoReturn_arr[$result->fields['equ_serial']]['teacher_sn']=$result->fields['teacher_sn'];
	$NoReturn_arr[$result->fields['equ_serial']]['lend_date']=$result->fields['lend_date'];
	$NoReturn_arr[$result->fields['equ_serial']]['refund_limit']=$result->fields['refund_limit'];
	$NoReturn_arr[$result->fields['equ_serial']]['leftdays']=$result->fields['leftdays'];
	$result->MoveNext();
}

//echo "<PRE>";
//print_r($NoReturn_arr);
//echo "</PRE>";
	
//���o���~����
$sql_select="SELECT * FROM equ_equipments WHERE opened='Y'";
if($EditSearch) $sql_select.=" AND item like '%$EditSearch%'"; else 
	if($manager_sn) $sql_select.=" AND manager_sn=$manager_sn AND nature='$nature'";

//$sql_select.=" ORDER BY nature";
$result=$CONN->Execute($sql_select) or user_error("Ū�����ѡI<br>$sql_select",256);
if($result->recordcount()){
	while(!$result->EOF)
	{
		$status=0;
		$BGColor=$m_arr['Lendable_BGColor'];
		$Alt_Message='';
		//�ˬd�O�_�w�g�w���F�@�@�@�@�@�@$Requested_arr[$result->fields['serial']]['teacher_sn']
		if (array_key_exists($result->fields['sn'],$Requested_arr)) {
    			$status=1;
    			$BGColor=$m_arr['Requested_BGColor'];
    			$Alt_Message=$teacher_array[$Requested_arr[$result->fields['sn']]['teacher_sn']]['name'].' '.$Requested_arr[$result->fields['sn']]['ask_date'].'['.$Requested_arr[$result->fields['sn']]['status'].']';
		}

		
		//�ˬd�O�_�w�g�~�ɤF
		if (array_key_exists($result->fields['serial'],$NoReturn_arr)) {
    			if($NoReturn_arr[$result->fields['serial']][leftdays]>0)
    			{
				$status=3;
				$BGColor=$m_arr['OverTime_BGColor'];
			} else {
				$status=2;
    				$BGColor=$m_arr['NotReturned_BGColor'];
			}
			$Alt_Message=$teacher_array[$NoReturn_arr[$result->fields['serial']]['teacher_sn']]['name'].' '.$NoReturn_arr[$result->fields['serial']]['refund_limit'].'('.$NoReturn_arr[$result->fields['serial']]['leftdays'].')';
		}
		
		
		$alt=$teacher_array[$NoReturn_arr[$result->fields['serial']]['teacher_sn']]['title'];
		$alt.='-'.$NoReturn_arr[$result->fields['serial']]['refund_limit'];
		$alt.='-'.$NoReturn_arr[$result->fields['serial']]['leftdays'];		
		if($NoReturn_arr[$result->fields['serial']]['leftdays']>0) $Status_gif='out'; else $Status_gif='in';
		
		$lend_pic="../../data/lend/pics/".$result->fields['barcode'].".jpg";
		$pic_show=$result->fields['barcode']?"onMouseOver=\"this.style.cursor='hand'; this.style.backgroundColor='#fccfaa';\" onMouseOut=\"this.style.backgroundColor='$BGColor';\" Onclick='receiver=window.open(\"$lend_pic\",\"���~�Ϥ�\",\"status=no,toolbar=no,location=no,menubar=no,width=$Pic_Width,height=$Pic_Height\");'":"";
		
		$showdata.="<tr bgcolor='$BGColor'><td>".$teacher_array[$result->fields['manager_sn']]['title']."-".$teacher_array[$result->fields['manager_sn']]['name']."</td>
			<td $pic_show>".($status?'':"<input type='checkbox' name='item_selected[]' value='^^".$result->fields['sn']."^^,".$result->fields['manager_sn']."'>").$result->fields['serial']."</td>
			<td $pic_show>".$result->fields['item']."</td>
			<td>".$result->fields['asset_no']."</td>
			<td>".$result->fields['sign_date']."</td>
			<td>".$result->fields['maker']."</td>
			<td>".$result->fields['model']."</td>
			<td align='center'>".$result->fields['healthy']."</td>
			<td align='center'>".$result->fields['days_limit']."��</td>
			<td align='center'><img src='images\\$status.gif' alt='$Alt_Message'></td></tr>";
		$result->MoveNext();
	}
	$showdata.="<tr><td colspan=10 align=center bgcolor='$Tr_BGColor'><input type='submit' value='���к޲z�H�X��' name='BtnSubmit' onclick='return confirm(\"�u���n���ХX��?\")'></td></tr>";
}
}

$showdata.="</table></form><BR>$executed";
echo $main.$showdata;

foot();

?>