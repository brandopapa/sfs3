<?php
                                                                                                                             
// $Id: esystem.php 5310 2009-01-10 07:57:56Z hami $

/***********************
 �t�ά����]�w�˴�
 1.�@�~�b���P�ǥ;��y�b���P�B
 2.�R���¸�� 
 
 ���{���v�����t�κ޲z�� 
 �b �t�κ޲z > �ǰȵ{���]�w > ���v�޲z���{��
 ***********************/

// --�t�γ]�w��
include "exam_config.php";

//�P�O�O�_���t�κ޲z��
$man_flag = checkid($_SERVER[SCRIPT_FILENAME],1) ;

if (!$man_flag) {	
	$str = "�A���Q���v�ϥΥ��\��A�ѦҨt�λ�����" ;
	redir("exam.php",3) ;
	exit;
}

if(!checkid(substr($_SERVER[PHP_SELF],1))){
	$go_back=1; //�^��ۤw���{�ҵe��  
	include "header.php";
	include "$rlogin";
	include "footer.php"; 
	exit;
}

$syncBtn= "�y���P�B";
$syncpassBtn= "�K�X�P�B";
include "header.php";
include "menu.php";

echo "<h2>�t�κ޲z</h2>";
//�ثe�Ǧ~
if ( $curr_year =="")
	$curr_year = sprintf("%03s",curr_year());

//����B�z  
switch ($_POST[key]) {
	case  $syncBtn : //�y���P�B��	
	$query = "select class_id,e_kind_id from exam_kind where class_id like '$curr_year%'  group by class_id order by class_id ";
	$result = $CONN->Execute($query);
	$addnum = 0;
	$chgnum = 0;
	while (!$result->EOF) {
		$class_temp = substr($result->fields[class_id],-3);
		$query2 = "select stud_id,stud_name,curr_class_num,email_pass from stud_base where stud_study_cond=0 and curr_class_num like '$class_temp%' order by curr_class_num ";
		$result2 = $CONN->Execute($query2);
		
		while(!$result2->EOF) {
			$stud_num = intval(substr($result2->fields[curr_class_num],-2));
			$result3 = $CONN->Execute("select stud_id,stud_num from exam_stud_data where stud_id ='".$result2->fields[stud_id]."'");
			if ($result3->RecordCount()>0) {
				if($stud_num != $result3->fields[stud_num]) {
					$query3  = "update  exam_stud_data set stud_num='$stud_num' where stud_id = '".$result2->fields[stud_id]."'";
					$CONN->Execute($query3) or die($query3);					
					$query3  = "update  exam_stud set stud_num='$stud_num' where stud_id = '".$result2->fields[stud_id]."'";
					$CONN->Execute($query3) or die($query3);
					$chgnum++;					
				
				}
			}
			else {
				$query3  = "insert into exam_stud_data (stud_id,stud_num,stud_pass) values('".$result2->fields[stud_id]."','$stud_num','$default_pass')";
				$CONN->Execute($query3) or die($query3);
				$addnum++;
			}
			$result2->MoveNext();
		}
		$result->MoveNext();
	}
	echo "<h2><font color=red>�����@�~�@���ʤF $chgnum ���A�s�W�F $addnum �� ���</font></h2><br>";
	break;
	
} //end switch

?>

<table border=1 width=600>
<form name=myform action="<?php echo $_SERVER[PHP_SELF] ?>" method=post>
  <tbody>
    <tr>
      <td bgColor="#80ffff">�ﶵ</td>      
      <td  bgColor="#80ffff">�ʧ@</td>      
    </tr>
    <tr>
      <td>
      <u>�ǥͧ@�~�y��</u> �P <u>���y�y���P�B</u><br>(�̧�ﵧ�Ʀh��A�i���20�����H�W)
      </td>     
      <td><input name=key type=submit value="<?php echo $syncBtn ?>"></td>
     </tr>
     
     <tr>
      <td colspan=2 bgColor="#80ffff">�����G�@�~�޲z�ǥ͸�ƪ�(exam_stud_data) �P�ǥ;��y��ƪ�(stud_base) ���P�A�b�s����J�έ��s�s�Z��A�а��楻���ާ@�A�H�P�B�ƨ�Ӹ�ƪ�</td>
    </tr>
</tbody>
</form>
</table>
<?php include "footer.php";
?>
