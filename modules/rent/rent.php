<?php

// $Id: rent.php 7709 2013-10-23 12:24:27Z smallduh $
include "config.php";
include "my_fun.php";
include "../../include/sfs_oo_zip2.php";

//sfs_check();

$rent_place=$_POST[rent_place];
$record_id=$_POST[record_id];
$linkstr="rent_place=$rent_place";
$days=$_POST[days]?$_POST[days]:$m_arr['days'];
$oo_path='ooo';
if($_POST['act']=='�C�L'){
	//���o���ئW��
	$sql="select *,WEEKDAY(rent_date) AS dayofweek from rent_record where record_id=$record_id";
	$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
	
	/*
	$test=$res->getrows();
	echo "<pre>";
	print_r($test);
	echo "</pre>";
	exit;
	*/
	
	//�ɦW
	$filename=$record_id."-".$res->fields[rent_place]."���a���ɳ�_".$res->fields[borrower].".sxw";

	//�s�W�@�� zipfile ���
	$ttt = new EasyZIP;
	//Ū�X xml �ɮ�	 & �[�J xml �ɮר� zip ���A�@�������ɮ� 
	
	$template=basename($_POST[ooo_template]);
	$ttt->setPath("$oo_path/$template");
	$ttt->addDir('META-INF');
	$ttt->addFile('settings.xml');
	$ttt->addFile('styles.xml');
	$ttt->addFile('meta.xml');
	$data = & $ttt->read_file(dirname(__FILE__)."/$oo_path/$template/content.xml");
	// �[�J���� tag
	//$data = str_replace("<office:automatic-styles>",'<office:automatic-styles><style:style style:name="sfs_break_page" style:family="paragraph" style:parent-style-name="Standard"><style:properties fo:break-before="page"/></style:style>',$data);
	//��� content.xml
	$arr1 = explode("<office:body>",$data);
		$content_head = $arr1[0]."<office:body>";  //���Y
	$arr2 = explode("</office:body>",$arr1[1]);
		$content_body = $arr2[0];  //��Ƥ��e
		$content_foot = "</office:body>".$arr2[1];  //�ɧ�
	//foreach($data_arr as $key=>$val){
		//���X���
		$my_content_body=$content_body;
		//�N content.xml �� tag ���N
		$temp_arr["school"]=$school_short_name;
		$temp_arr["borrower"]=$res->fields[borrower];
		$temp_arr["ask_time"]=$res->fields[ask_time];
		$temp_arr["rent_date"]=$res->fields[rent_date].' �P��'.$c_day[$res->fields[dayofweek]];
		$temp_arr["rent_place"]=$res->fields[rent_place];
		$temp_arr["contact"]=$res->fields[contact];
		$temp_arr["record_id"]=sprintf("%05d",$record_id);
		$temp_arr["time_section"]=($res->fields[morning]=='Y'?"[�W��] ":"").($res->fields[afternoon]=='Y'?"[�U��] ":"").($res->fields[evening]=='Y'?"[�߶�]":"");
		$temp_arr["purpose"]=$res->fields[purpose];
		$temp_arr["rent"]=$res->fields[rent];
		$temp_arr["clean"]=$res->fields[clean];
		$temp_arr["prove"]=$res->fields[prove];
		$temp_arr["total"]=$res->fields[rent]+$res->fields[clean]+$res->fields[prove];
		$temp_arr["real"]=$res->fields[rent]+$res->fields[clean];
		$temp_arr["now"]=date('Y-m-d');
		
		// change_temp �|�N�}�C���� big5 �ର UTF-8 �� openoffice �i�HŪ�X
		$replace_data.=$ttt->change_temp($temp_arr,$my_content_body,0);
		//$replace_data.="<text:p text:style-name=\"break_page\"/>";  //����
	//}
	//Ū�X XML ���Y
	$replace_data =$content_head.$replace_data.$content_foot;

	// �[�J content.xml ��zip ��
	$ttt->add_file($replace_data,"content.xml");
	
	//���� zip ��
	$sss = & $ttt->file();
	
	//�H��y�覡�e�X sxw
	header("Content-disposition: attachment; filename=$filename");
	header("Content-type: application/vnd.sun.xml.writer");
	//header("Pragma: no-cache");
				//�t�X SSL�s�u�ɡAIE 6,7,8�U�������D�A�i��ק� 
				header("Cache-Control: max-age=0");
				header("Pragma: public");
	header("Expires: 0");

	echo $sss;
	exit;
};



//�q�X����

head("���a�X���޲z");

echo print_menu($MENU_P,$linkstr);

if($_POST['act']=='�s�W'){
		//��������a���O
		$sql="select * from rent_place where rent_place='$rent_place'";
		$res=$CONN->Execute($sql) or user_error("�s�W���ѡI<br>$sql",256);
		
		$rent="rent_".$_POST[a_borrower_type];
		$prove="prove_".$_POST[a_borrower_type];
		$clean="clean_".$_POST[a_borrower_type];

		$rent=''.$res->fields[$rent];
		$prove=''.$res->fields[$prove];
		$clean=''.$res->fields[$clean];
		
		//echo "<BR>$rent ==>  $prove ==> $clean";
		
		//�[�J�s����
		$sql="INSERT INTO rent_record(ask_time,rent_place,purpose,borrower,borrower_type,rent_date,morning,afternoon,evening,note,contact,head_count,rent,prove,clean) values (now(),'$rent_place','$_POST[a_purpose]','$_POST[a_borrower]','$_POST[a_borrower_type]','$_POST[a_rent_date]','$_POST[a_morning]','$_POST[a_afternoon]','$_POST[a_evening]','$_POST[a_note]','$_POST[a_contact]',$_POST[a_head_count],$rent,$prove,$clean);";
		$res=$CONN->Execute($sql) or user_error("�s�W���ѡI<br>$sql",256);
};
if($_POST['act']=='�ק�'){
	$sql="update rent_record set ask_time='$_POST[ask_time]',purpose='$_POST[purpose]',borrower='$_POST[borrower]',borrower_type='$_POST[borrower_type]',rent_date='$_POST[rent_date]',morning='$_POST[morning]',afternoon='$_POST[afternoon]',evening='$_POST[evening]',note='$_POST[note]',contact='$_POST[contact]',head_count=$_POST[head_count],rent=$_POST[rent],prove=$_POST[prove],clean=$_POST[clean],reply='$_POST[reply]' where record_id=$_POST[record_id];";
	$res=$CONN->Execute($sql) or user_error("�ק異�ѡI<br>$sql",256);
	$record_id=0;
};

if($_POST['act']=='�R��'){
	$sql="delete from rent_record where record_id=$record_id";
	$res=$CONN->Execute($sql) or user_error("�R�����إ��ѡI<br>$sql",256);
};

$main="<table><form name='form_place' method='post' action='$_SERVER[PHP_SELF]'>�����ɳ��a�G
	<select name='rent_place' onchange='this.form.submit()'><option value=''>*�������a*</option>";

//���o���ɳ��a����
$sql="select * from rent_place order by rank";
$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql_select",256);
while(!$res->EOF) {
	$main.="<option ".($_POST[rent_place]==$res->fields[rent_place]?"selected":"")." value=".$res->fields[rent_place].">(".$res->fields[rank].")".$res->fields[rent_place]."</option>";
	$res->MoveNext();
}
$main.="</select>�@���C���¬����G<input type='text' size='3' name='days' value=$days>�Ѥ�<input type='submit' value='���s�C��'>�@���s�צC�L�G<select name='record_id' onchange='this.form.submit()'><option></option>";

//���o���ɳ��a����
$sql="select *,WEEKDAY(rent_date) AS dayofweek,TO_DAYS(curdate())-TO_DAYS(rent_date) as past_days from rent_record where TO_DAYS(curdate())-TO_DAYS(rent_date)<=$days".($rent_place?" AND rent_place='$rent_place'":'')." order by rent_date";
//echo $sql;
$res=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
while(!$res->EOF) {
	$main.="<option ".($record_id==$res->fields[record_id]?"selected":"")." value=".$res->fields[record_id].">(".$res->fields[rent_date].")".$res->fields[borrower]."</option>";
	$res->MoveNext();
}

$report=$record_id?get_ooo_template($oo_path)."<input type='submit' name='act' value='�C�L'>":"";
$main.="</select>$report</table>";

$res->MoveFirst();
$showdata="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size:11pt' bordercolor='#111111' width='100%'>
	<tr bgcolor='#CCCCFF'>
	<td align='center' rowspan='2'>NO.</td>
	<td align='center' rowspan='2'>���ɳ��a</td>
	<td align='center' rowspan='2'>���ɪ�<BR>[�ݩ�]</td>
	<td align='center' rowspan='2'>�ШD���</td>
	<td align='center' rowspan='2'>�Ρ@�@�~</td>
	
	<td align='center' rowspan='2'>�ɥΤ��</td>
	<td align='center' colspan='3'>�ɥήɬq</td>
	<td align='center' rowspan='2'>����<BR>�H��</td>
	<td align='center' rowspan='2'>���O�ƶ�</td>
	<td align='center' rowspan='2'>�p����T</td>
	<td align='center' colspan='3'>���ɶO��</td>
	
	<td align='center' rowspan='2'>�ơ@�@��</td>
	<td align='center' rowspan='2'>�\��<BR>�ާ@</td>
	</tr><tr bgcolor='#DDDDFF'>
	<td align='center'>�W��</td>
	<td align='center'>�U��</td>
	<td align='center'>�ߤW</td>
	
	<td align='center'>�޲z���@</td>
	<td align='center'>���q�ɶK</td>
	<td align='center'>�O�Ҫ�</td>
	</tr>";

while(!$res->EOF) {
	//echo "====".$_POST[rent_place]."::::::".$res->fields[rent_place];
	//$showdata.="<input type='hidden' name='record_id' value='".$res->fields[record_id]."'</td>";
	if($record_id==$res->fields[record_id]){
		//�s��
		$showdata.="<tr bgcolor=#AAFFCC><td align='center'>".($res->CurrentRow()+1)."</td>";
		$showdata.="<td align='center'>---</td>";
		$showdata.="<td align='center'><input type='text' name='borrower' size=10 value='".$res->fields[borrower]."'><BR>".get_type_select($res->fields[borrower_type],'borrower_type')."</td>";
		
		$showdata.="<td><input type='text' name='ask_time' size=10 value='".$res->fields[ask_time]."'></td>";
		$showdata.="<td><input type='text' name='purpose' size=12 value='".$res->fields[purpose]."'></td>";

		$showdata.="<td><input type='text' name='rent_date' size=10 value='".$res->fields[rent_date]."'></td>";
		$showdata.="<td><input type='checkbox' name='morning' value='Y'".($res->fields[morning]=='Y'?' checked':'')."></td>";
		$showdata.="<td><input type='checkbox' name='afternoon' value='Y'".($res->fields[afternoon]=='Y'?' checked':'')."></td>";
		$showdata.="<td><input type='checkbox' name='evening' value='Y'".($res->fields[evening]=='Y'?' checked':'')."></td>";
		$showdata.="<td><input type='text' name='head_count' size=4 value='".$res->fields[head_count]."'></td>";
		$showdata.="<td><input type='text' name='note' size=20 value='".$res->fields[note]."'></td>";
		$showdata.="<td><input type='text' name='contact' size=20 value='".$res->fields[contact]."'></td>";
		$showdata.="<td><input type='text' name='rent' size=4 value='".$res->fields[rent]."'></td>";
		$showdata.="<td><input type='text' name='prove' size=4 value='".$res->fields[prove]."'></td>";
		$showdata.="<td><input type='text' name='clean' size=4 value='".$res->fields[clean]."'></td>";
		
		$showdata.="<td align='center'><input type='text' name='reply' value='".$res->fields[reply]."'>";
		$showdata.="<td align='center'><input type='submit' value='�ק�' name='act' onclick='return confirm(\"�T�w�n���[ ".$res->fields[borrower].'==>'.$res->fields[rent_place]." ]?\")'>";
		$showdata.="<BR><input type='submit' value='�R��' name='act' onclick='return confirm(\"�u���n�R��[ ".$res->fields[borrower].'==>'.$res->fields[rent_place]." ]?\")'></td></tr>";
	} else {	
		if($res->fields[past_days]>0) $bgcolor=$m_arr[past]; elseif($res->fields[past_days]>=7) $bgcolor=$m_arr[recent]; else $bgcolor=$m_arr[far];
		$showdata.="<tr bgcolor='$bgcolor'><td align='center'>".($res->CurrentRow()+1)."</td>";
		$showdata.="<td align='center'>".$res->fields[rent_place]."</td>";
		$showdata.="<td align='center'>".$res->fields[borrower]."<BR>[ ".$borrower_type[$res->fields[borrower_type]]." ]</td>";
		$showdata.="<td align='center'>".$res->fields[ask_time]."</td>";
		$showdata.="<td align='center'>".$res->fields[purpose]."</td>";
		
		$showdata.="<td align='center'>".$res->fields[rent_date].'(�P��'.$c_day[$res->fields[dayofweek]].")<BR>(".$res->fields[past_days].")</td>";
		$showdata.="<td align='center'>".($res->fields[morning]?'��':'')."</td>";
		$showdata.="<td align='center'>".($res->fields[afternoon]?'��':'')."</td>";
		$showdata.="<td align='center'>".($res->fields[evening]?'��':'')."</td>";
		$showdata.="<td align='center'>".$res->fields[head_count]."</td>";
		$showdata.="<td align='center'>".$res->fields[note]."</td>";
		$showdata.="<td align='center'>".$res->fields[contact]."</td>";
		$showdata.="<td align='center'>".$res->fields[rent]."</td>";
		$showdata.="<td align='center'>".$res->fields[prove]."</td>";
		$showdata.="<td align='center'>".$res->fields[clean]."</td>";
		$showdata.="<td align='center'>".$res->fields[reply]."</td>";
		
		$showdata.="<td></td></tr>";
	}
	$res->MoveNext();
}
	//�s�W����
	if(!$record_id AND $rent_place){
		$showdata.="<tr></tr><tr bgcolor='#FFCCCC'><td align='center'><img border=0 src='images/add.gif' alt='�}�C�s����'></td>";
		$showdata.="<td>---</td>";
		$showdata.="<td align='center'><input type='text' name='a_borrower' size=10><BR>".get_type_select('private','a_borrower_type')."</td>";
		$showdata.="<td align='center'>--</td>";
		$showdata.="<td align='center'><input type='text' name='a_purpose' size=12></td>";
		
		$showdata.="<td align='center'><input type='text' name='a_rent_date' size=10></td>";
		$showdata.="<td><input type='checkbox' name='a_morning' value='Y'></td>";
		$showdata.="<td><input type='checkbox' name='a_afternoon' value='Y'></td>";
		$showdata.="<td><input type='checkbox' name='a_evening' value='Y'></td>";
		$showdata.="<td align='center'><input type='text' name='a_head_count' size=4></td>";
		$showdata.="<td><input type='text' name='a_note' size=20></td>";
		$showdata.="<td colspan='5'><input type='text' name='a_contact' size=20></td>";
		//$showdata.="<td align='center'><input type='text' name='a_rent' size=4></td>";
		//$showdata.="<td align='center'><input type='text' name='a_prove' size=4></td>";
		//$showdata.="<td align='center'><input type='text' name='a_clean' size=4></td>";
		
	$showdata.="<td align='center'><input type='submit' value='�s�W' name='act'><BR><input type='reset' value='���]'></td></tr>";
	}
	$showdata.="</form></table>";

echo $main.$showdata;

foot();

?>
