<?php

include "config.php";

sfs_check();

//�q�X����
head("�������~�ͦW�U");
print_menu($menu_p);

//if(checkid($_SERVER['SCRIPT_FILENAME'],1)){

echo <<<HERE
<script>

function tagall(status,s) {
  var i =0;
  while (i < document.myform.elements.length)  {
    if(document.myform.elements[i].name==s) {
      document.myform.elements[i].checked=status;
    }
    i++;
  }
}


function check_select() {
  var i=0; j=0; answer=true;
  while (i < document.myform.elements.length)  {
    if(document.myform.elements[i].checked) {
		if(document.myform.elements[i].name=='sn[]') j++;
    }
    i++;
  }
  
  if(j==0) { alert("�|��������󪺬����I"); answer=false; }
  
  return answer;
}

</script>
HERE;
/*
if($_POST['act']=='�R�����' and $_POST['sn']){
	$sn_list=implode(',',$_POST['sn']);
	
	//�R��
	$sql="DELETE FROM association WHERE club_sn=0 AND sn in ($sn_list)";
	$res=$CONN->Execute($sql) or user_error("�R�����ѡI<br>$sql",256);
}
*/
//�x�v�j�ߴ����߭n���ǮեN�X
$school_id =  $SCHOOL_BASE['sch_id'];
//������~�~�צC��
$grad_year_radio='���~�~�סG';
$sql="SELECT DISTINCT stud_grad_year FROM grad_stud";
$rs=$CONN->Execute($sql) or user_error("Ū�����ѡI<br>$sql",256);
while(!$rs->EOF) {
	$grad_year=$rs->fields['stud_grad_year'];
	$checked=($grad_year==$_POST[grad_year])?'checked':'';
	$grad_year_radio.="<input type='radio' name='grad_year' value='$grad_year' $checked onclick=\"this.form.submit();\">$grad_year ";
	$rs->MoveNext();
}


if($_POST['grad_year']) {
	$grad_kind=array(1=>'���~',2=>'�׷~');
	//������
	$i=0;
	$stud_select="SELECT a.*,b.curr_class_num,b.stud_name,b.stud_person_id,b.stud_addr_1,b.stud_addr_2,b.stud_tel_1,b.stud_tel_2,b.enroll_school FROM grad_stud a LEFT JOIN stud_base b ON a.student_sn=b.student_sn WHERE a.stud_grad_year='{$_POST[grad_year]}' ORDER BY b.curr_class_num"; //a.class_year,a.class_sort,a.grad_kind,a.grad_num
        $rs=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
        $data="<tr align='center' bgcolor='#ffdddd'><td>NO.</td><td>�Z��</td><td>�y��</td><td>�Ǹ�</td><td>�ǮեN�X</td><td>�m�W</td><td>�����Ҧr��</td><td>�ʧO</td><td>���O</td><td>�ҮѸ�</td><td>���~���Z</td><td>�J�ǾǮ�</td><td>�ɾǾǮ�</td><td>���y�a�}</td><td>���y�q��</td><td>�p���a�}</td><td>�p���q��</td>";
        while(!$rs->EOF) {
                $i++;
                $person_id=($rs->fields['stud_person_id']);
                $sex = substr($person_id,1,1);
                $class_id=substr($rs->fields['curr_class_num'],0,3);
                $class_num=substr($rs->fields['curr_class_num'],-2);
                $nature=$grad_kind[$rs->fields['grad_kind']];
                $bgcolor=($rs->fields['grad_kind']==1)?'#ffffff':'#dddddd';
                $data.="<tr align='center' bgcolor='$bgcolor'><td>$i</td><td>$class_id</td><td>$class_num</td><td>{$rs->fields['stud_id']}</td><td>$school_id</td><td>{$rs->fields['stud_name']}</td><td>$person_id</td><td>$sex</td><td>$nature</td>
                                <td>{$rs->fields['grad_num']}</td><td>{$rs->fields['grad_score']}</td><td>{$rs->fields['enroll_school']}</td><td>{$rs->fields['new_school']}</td>
                                <td align='left'>{$rs->fields['stud_addr_1']}</td><td>{$rs->fields['stud_tel_1']}</td><td align='left'>{$rs->fields['stud_addr_2']}</td><td>{$rs->fields['stud_tel_2']}</td>";
                $rs->MoveNext();
	}
}
echo "<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'>$grad_year_radio
		<table border='2' cellpadding='0' cellspacing='0' style='border-collapse: collapse; font-size:9pt' bordercolor='#111111' id='AutoNumber1' width='100%'>
		$data
		</table></form>";
//} else echo "<br><br><br><p align='center'>�㦳�Ҳպ޲z�v���̡A��i�i��ާ@�I</p>";
foot();
?>