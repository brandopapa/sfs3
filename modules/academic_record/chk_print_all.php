<?php

// $Id: chk.php 5453 2009-04-17 03:07:33Z brucelyc $

// ���o�]�w��
include "config.php";

sfs_check();

//���ɮv���ЯZ��
$class_num=get_teach_class();
$class_id=sprintf("%03d_%d_%02d_%02d",curr_year(),curr_seme(),substr($class_num,-3,strlen($class_num)-2),substr($class_num,-2));
$curr_year_seme=sprintf("%03d%d",curr_year(),curr_seme());

if($_POST['act']=='�C�L'){
	$selected_stud=$_POST['selected_stud'];
	$item_px=$_POST['item_px'];
	$sign_h=$_POST['sign_h'];
	$title=$_POST['title'];
	//����html�X
	$newpage="<P style='page-break-after:always'></P>";
	$stud_count=count($selected_stud);
	if($stud_count){
		$stud_count--;
		$seme_year_seme =sprintf("%03d",curr_year()).curr_seme();
		$sel_year=curr_year();
		$sel_seme=curr_seme();

		//�Nclass_id�ରclass_num
		$class_id_arr=explode('_',$class_id);
		$class_num=($class_id_arr[2]+0).$class_id_arr[3];

		//�ഫ�Z�ťN�X
		$class=class_id_2_old($class_id);
		$class_name=$class[5];
		
		//�ˮ֪���
		$itemdata=get_chk_item($sel_year,$sel_seme);
		
		foreach($selected_stud as $counter=>$sn_value) {			
			//���o���w�ǥ͸��
			$stu=get_stud_base($sn_value,"");

			$stud_id=$stu['stud_id'];
			$stud_name=$stu['stud_name'];
			$curr_class_num=substr($stu['curr_class_num'],-2);
				
			//�ˮ֪��
			$chk_item=chk_kind();
			$chk_value=get_chk_value($sn_value,$sel_year,$sel_seme,$chk_item,"value");
	
			//��L��{��r
			$query="select * from stud_seme_score_nor where seme_year_seme='$seme_year_seme' and student_sn='$sn_value' order by ss_id";
			$res=$CONN->Execute($query);
			$r=array();
			while(!$res->EOF) {
				$r[$res->fields['ss_id']]=$res->fields['ss_score_memo'];
				$res->MoveNext();
			}
			$nor_memo=$r;

			//�}�l����HTML���
			$chk_data.="<p align='center'><font size=5>$school_long_name<BR>$sel_year �Ǧ~�ײ� $sel_seme �Ǵ���`�ͬ���{�ˮ֪�</font></p>";
			$chk_data.="<table align='center' cellspacing='4'><tr>
						<td>�Z�šG<font color='blue'>$class_name</font></td><td width='40'></td>
						<td>�y���G<font color='green'>$curr_class_num</font></td><td width='40'></td>
						<td>�m�W�G<font color='red'>$stud_name</font></td>
						</tr></table></font>";
			$chk_data.="<table  STYLE='font-size: ".$item_px."px' border=2 cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolorlight='#000000' bordercolordark='#000000' width='100%'>
						<tr bgcolor='#FFCCCC'><td colspan='2' align='center'>��`�ͬ��ˮֶ���</td><td align='center'>��{���p</td><td align='center'>�Ƶ�</td></tr>";
			
			//�����Ƭ��G���}�C
			$data_array=array();			
			foreach($itemdata['items'] as $key=>$value) {
				$main=$value['main'];
				$sub=$value['sub'];
				$data_array[$main][$sub]=$value['item'];
			}
			//�Ԧ��ˮֶ��ر��ΦC��
			foreach($data_array as $key=>$main) {
				$rowspan=count($main)-1;
				$chk_data.="<tr><td rowspan=$rowspan align='center'>".$main[0]."</td>";
				for($i=1;$i<=$rowspan;$i++){
					$chk_data.="<td>".$main[$i]."</td>";
					$chk_data.="<td align='center' width='120'>".$chk_value[$key][$i]['score']."</td><td>".$chk_value[$key][$i]['memo']."</td></tr>";					
				}
			}
			//�欰�y�z
			$chk_data.="<table border=2 cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolorlight='#000000' bordercolordark='#000000' width='100%'>
						<tr><td rowspan=4 align='center' bgcolor='#c4d9ff' width=80>�欰�y�z<BR>�P<BR>�����ĳ</td>
						<td align='center' bgcolor='#c4d9ff' width=80>��`�ͬ�</td><td>$nor_memo[0]</td></tr>
						<tr><td align='center' bgcolor='#c4d9ff' width=80>���鬡��</td><td>$nor_memo[1]</td></tr>
						<tr><td align='center' bgcolor='#c4d9ff' width=80>���@�A��</td><td>���դ�: $nor_memo[2]<br>������: $nor_memo[3]</td></tr>
						<tr><td align='center' bgcolor='#c4d9ff' width=80>�S���{</td><td>���դ�: $nor_memo[4] <br>���ե~: $nor_memo[5]</td></tr>
						</table>";
			//ñ���B�z
			$chk_data.="<table border=2 cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolorlight='#000000' bordercolordark='#000000' width='100%'>
						<tr align='center' bgcolor=#FFAAAA><td>�ɮv</td><td>$title</td><td>�ժ�</td></tr><tr height=$sign_h><td></td><td></td><td></td></tr></table>";
			//����
			if($counter<$stud_count) $chk_data.=$newpage;
		}
		echo $chk_data;
	} else $chk_data="�z�å��������ǥ͡I";
	
	exit;
}

//�q�X����
head("�C�L�Z�žǥ͸Ԧ���`�ͬ��ˮ֪�");

echo <<<HERE
<script>
function tagall(status) {
  var i =0;

  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name=='selected_stud[]') {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}
</script>
HERE;

echo print_menu($school_menu_p);

$main="<table border='1' cellpadding='3' cellspacing='0' style='border-collapse: collapse' bordercolor='#AAAAAA' width='100%'>
		<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]' target='_BLANK'>";

//���ostud_base���Z�žǥͦC��þڥH�P�esql��ӫ����
$stud_select="SELECT a.student_sn,a.seme_num,b.stud_name,b.stud_sex FROM stud_seme a,stud_base b WHERE seme_year_seme='$curr_year_seme' and a.seme_class='$class_num' and a.student_sn=b.student_sn ORDER BY seme_num";
$recordSet=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
//�Hcheckbox�e�{
$col=7; //�]�w�C�@�C��ܴX�H
$studentdata="";
while(list($student_sn,$seme_num,$stud_name,$stud_sex)=$recordSet->FetchRow()) {
	if($recordSet->currentrow() % $col==1) $studentdata.="<tr>";
	if (array_key_exists($student_sn,$listed)) {
			$studentdata.="<td bgcolor=".($listed[$recordSet->fields[student_sn]-1]?"#CCCCCC":"#FFFFDD").">��($seme_num)$stud_name</td>";
	} else {
		$studentdata.="<td bgcolor=".($stud_sex==1?"#CCFFCC":"#FFCCCC")."><input type='checkbox' name='selected_stud[]' value='$student_sn' id='stud_selected'>($seme_num)$stud_name</td>";
	}
	if($recordSet->currentrow() % $col==0  or $recordSet->EOF) $studentdata.="</tr>";
}
$studentdata.="<tr height='50'><td align='center' colspan=$col>				
				<input type='button' name='all_stud' value='����' onClick='javascript:tagall(1);'>
				<input type='button' name='clear_stud'  value='������' onClick='javascript:tagall(0);'>
				���ˮֶ��ئr��j�p�G<input type='text' name='item_px' value=12 size=2>px 
				���B�ǥD�����Y�G<input type='radio' value='�оɥD��' name='title'>�о� <input type='radio' value='�V�ɥD��' name='title'>�V�� <input type='radio' value='�ǰȥD��' name='title' checked>�ǰ�  
				��ñ���C���G<input type='text' name='sign_h' value=60 size=2> 
				<input type='submit' value='�C�L' name='act'></td></tr>";

echo $main.$studentdata."</form></table>";

?>
