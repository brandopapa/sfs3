<?php

$ys=$_GET['ys'];
if($ys)
{

include "config.php";

sfs_check();


//�q�X����
head("$ys �Ǵ����ά����C��");

if(checkid($_SERVER['SCRIPT_FILENAME'],1)){

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

if($_POST['act']=='�R�����' and $_POST['sn']){
	$sn_list=implode(',',$_POST['sn']);
	
	//�R��
	$sql="DELETE FROM association WHERE club_sn=0 AND sn in ($sn_list)";
	$res=$CONN->Execute($sql) or user_error("�R�����ѡI<br>$sql",256);
}

//������
$stud_select="SELECT a.*,b.curr_class_num,b.stud_name,b.stud_id FROM association a INNER JOIN stud_base b ON a.student_sn=b.student_sn WHERE a.seme_year_seme='$ys' AND a.club_sn=0 ORDER BY b.curr_class_num,a.seme_year_seme";
$rs=$CONN->Execute($stud_select) or user_error("Ū�����ѡI<br>$stud_select",256);
$data="<tr align='center' bgcolor='#ffdddd'><td>�Z��</td><td>�y��</td><td>�m�W</td><td>�Ǹ�</td>
	<td>�Ǵ��O</td><td>���ΦW��</td><td>���¾��</td><td>���Z</td><td>���ɱЮv���y</td><td>�פJ���</td>";
while(!$rs->EOF) {
	$class_id=substr($rs->fields['curr_class_num'],0,3);
	$class_num=substr($rs->fields['curr_class_num'],-2);
	$sn=$rs->fields['sn'];
	$data.="<tr align='center'><td>$class_id</td><td>$class_num</td><td>{$rs->fields['stud_name']}</td><td>{$rs->fields['stud_id']}</td>
			<td>{$rs->fields['seme_year_seme']}</td><td>{$rs->fields['association_name']}</td><td>{$rs->fields['stud_post']}</td><td>{$rs->fields['score']}</td><td>{$rs->fields['description']}</td><td>{$rs->fields['update_time']}</td>";
	$rs->MoveNext();
}
echo "<form name='myform' method='post' action='$_SERVER[SCRIPT_NAME]'>
		<table border='2' cellpadding='0' cellspacing='0' style='border-collapse: collapse; font-size:11pt' bordercolor='#111111' id='AutoNumber1' width='100%'>
		$data
		</table></form>";
} else echo "<br><br><br><p align='center'>�㦳�Ҳպ޲z�v���̡A��i�i��ާ@�I</p>";
foot();
}
?>