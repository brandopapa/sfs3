<?php
include "config.php";

sfs_check();

$SEX[1]="�k";
$SEX[2]="�k";

//�q�X����
head("��A��޲z - �ֶK���ը����魫���");
$tool_bar=&make_menu($menu_p);
//�C�X���
echo $tool_bar;

//�{���}�l
$seme_class=$_POST['seme_class'];
$stud_data=$_POST['stud_data'];

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}
?>

<form name="myform" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<table border="0" width="100%">
 <tr>
  <td style="color:#0000FF"><br>���{���O���F��N���d���ߪ���Ư�ֳt�פJ�t�Φӳ]�p�A<br>�Y�K�W����Ʈ榡���~�A�פJ����ƫh���O�Ҧʤ����ʥ��T�A���O�I����k�٬O�@���@���C�C��J�C</td>
 </tr>	
 <tr>
  <td>
  	��k:<br>
  	1.�а��d���߱N��Ƴz�L�U�C�B�J�ץX : ����>����M��>�ͪ��o�|>���ը����魫���O�M��<br>
  	<img src='./images/source.jpg'><br>
  	2.�Q�� EXCEL�}��, �ˬd�C�@�����O�_�������, �p�U��, �b�魫���e, �C����쳣�n�����.<br>
  	<img src='./images/source1.png'><br>
  	3.�t�η|���i�νs�j�B�i�~�šj�B�i�Z�šj�B�i�y���j�o�|��, �úI���i�����j�B�i�魫�j�o������, <br>
  �Y�Y����ƪ���L���Ʀ��ʺ|�A�p�G�Ǹ����ʺ|, �|�ɭP��춶�Ǥ����T�A�ӵL�k���TŪ����ơA<br><font color=red>�а��ܱN�����ƾ���R��.</font><br>
  	4.�N��ƥ���ƻs/�K�W�A�M����e�X�Y�i�A�`�N! �Ĥ@����D��]�n�]�A!<br>
  	5.�`�N, ���U�e�X��, �פJ����Ʒ|�s�J<font color="#FF0000"><?php echo curr_year()."�Ǧ~��".curr_seme()."�Ǵ�</font> ���ǥ͸��";?><br>
  	6.�e�X��, <font color=red>�B�z��ƥi��|���I�[(����2400��ǥ͡A�n�B�z5����)</font>, �Y����ƵL�k�s�J, �Ф�ʽվ�.<br>
  	7.���жK��ƥu�| update ,���|���ͷs���.
  	</td>
 </tr>
  <tr>
   <td>
    		<textarea name="stud_data" cols="100" rows="10"></textarea>
    	</td>
    </tr>
    </table>
    <input type="submit" value="�e�X���">

	
<?php
//����ƪ��ܥ����R�����魫
if ($stud_data) {
	$data_arr=explode("\n",$stud_data);
	//��1�欰���D, �������W��
	//���h������ť�
	 $data_arr[0]=trim($data_arr[0]);
	//�h�����H�O�����b�@�����ť�
   $data_arr[0] = preg_replace('/\s(?=\s)/','', $data_arr[0]);
   $data_arr[0] = preg_replace('/[\n\r\t]/', ' ', $data_arr[0]);
  //����, ��J $T array()
	$T=explode(" ",$data_arr[0]); 
	//�D������, �Ǹ�, �~��	�Z��	�y��	�ǥ� ����, �魫 ���O�O�ĴX��
	for ($i=0; $i < count($T) ;$i++) {
	 if ($T[$i]=='�νs') $STUD_PERSON_ID=$i;
	 if ($T[$i]=='�Ǹ�') $STUDENT_SN=$i;
	 if ($T[$i]=='�~��') $YEAR_CLASS=$i;
	 if ($T[$i]=='�Z��') $CLASS=$i;
	 if ($T[$i]=='�y��') $NUM=$i;
	 if ($T[$i]=='�ǥ�') $STUD_NAME=$i;
	 if ($T[$i]=='����') $TALL=$i;
	 if ($T[$i]=='�魫') $WEIGH=$i;
	}
	
 //�}�l�B�z��2��᪺���
 $E=0; //���~
 $INPUT_NUM=0; //�B�z���\
	for ($i = 1 ; $i < count($data_arr); $i++ ) {
		//�h���e��ť�
	 $data_arr[$i] = trim($data_arr[$i]);
	 //�h�����H�O�����b�@�����ť�
   $data_arr[$i] = preg_replace('/\s(?=\s)/','', $data_arr[$i]);
   $data_arr[$i] = preg_replace('/[\n\r\t]/', ' ', $data_arr[$i]);

   //�ܦ��G���}�C
   $student=explode(" ",$data_arr[$i]);  //�Y���ǥͪ����
   //�Z��
   switch ($student[$YEAR_CLASS]) {
   	case '�@':
   	  $seme_class="1".sprintf("%02d",$student[$CLASS]);
   	break;
   	case '�G':
   	  $seme_class="2".sprintf("%02d",$student[$CLASS]);
   	break;
   	case '�T':
   	  $seme_class="3".sprintf("%02d",$student[$CLASS]);
   	break;
   	case '�|':
   	  $seme_class="4".sprintf("%02d",$student[$CLASS]);
   	break;
   	case '��':
   	  $seme_class="5".sprintf("%02d",$student[$CLASS]);
   	break;
   	case '��':
   	  $seme_class="6".sprintf("%02d",$student[$CLASS]);
   	break;
   	case '�C':
   	  $seme_class="7".sprintf("%02d",$student[$CLASS]);
   	break;
   	case '�K':
   	  $seme_class="8".sprintf("%02d",$student[$CLASS]);
   	break;
   	case '�E':
   	  $seme_class="9".sprintf("%02d",$student[$CLASS]);
   	break;    
   }
   
   //�H�����ҤίZ�Ŭ��D�n����, ���o�ǥͪ� student_sn
		$query="select a.student_sn from stud_base a,stud_seme b where a.student_sn=b.student_sn and a.stud_person_id='".$student[$STUD_PERSON_ID]."' and b.seme_year_seme='$c_curr_seme' and b.seme_class='$seme_class'";
    $result=mysql_query($query);
   	$row=mysql_fetch_row($result);
   	list($student_sn)=$row;
    $ERROR=1;
    if ($student_sn and $student[$TALL]>0 and $student[$WEIGH]>0) {
    	  $query="select student_sn from fitness_data where student_sn='".$student_sn."' and c_curr_seme='".$c_curr_seme."'";
   			$result_chk=mysql_query($query);
   			//�p�G�����
   			if (mysql_num_rows($result_chk)) {
   			  $query="update `fitness_data` set tall='".$student[$TALL]."',weigh='".$student[$WEIGH]."' where student_sn='".$student_sn."' and c_curr_seme='".$c_curr_seme."'";
   			} else {
   				$query="insert into `fitness_data` (c_curr_seme,student_sn,tall,weigh) values ('$c_curr_seme','".$student_sn."','".$student[$TALL]."','".$student[$WEIGH]."')";
				}	  
				//echo $query."<br>";
        if (mysql_query($query)) {
        	$ERROR=0;
          $INPUT_NUM++;
        } else {
          $ERROR=1;
        }    
    } 
    if ($ERROR==1) {
    	$E++;
      $ERR[$E]['PERSON_ID']=$student[$STUD_PERSON_ID];
      $ERR[$E]['YEAR_CLASS']=$student[$YEAR_CLASS];
      $ERR[$E]['CLASS']=$student[$CLASS];
      $ERR[$E]['NUM']=$student[$NUM];
      $ERR[$E]['STUD_NAME']=$student[$STUD_NAME];
      $ERR[$E]['TALL']=$student[$TALL];
      $ERR[$E]['WEIGH']=$student[$WEIGH];
    } // end if ($student_sn)


   
	} // end for
	echo "<br>�@���\��s ".$INPUT_NUM. "��ǥͪ������魫���!<br> �H�U���s�J���Ѫ����.<br>";
 ?>
 
 <table border="1" style="border-collapse:collapse" bordercolor="#CCCCCC">
	<tr  bgcolor="#FFCCFF">
		<td width="100" style="font-size:10pt" align="center">�νs</td>
		<td width="50" style="font-size:10pt" align="center">�~��</td>
		<td width="50" style="font-size:10pt" align="center">�Z��</td>
		<td width="50" style="font-size:10pt" align="center">�y��</td>
		<td width="100" style="font-size:10pt" align="center">�m�W</td>
		<td width="50" style="font-size:10pt" align="center">����</td>
		<td width="50" style="font-size:10pt" align="center">�魫</td>
	</tr>
 <?php
 for ($i=1;$i<=$E;$i++) {
 ?>
 	<tr>
		<td width="100" style="font-size:10pt" align="center"><?php echo $ERR[$i]['PERSON_ID'];?></td></td>
		<td width="50" style="font-size:10pt" align="center"><?php echo $ERR[$i]['YEAR_CLASS'];?></td>
		<td width="50" style="font-size:10pt" align="center"><?php echo $ERR[$i]['CLASS'];?></td>
		<td width="50" style="font-size:10pt" align="center"><?php echo $ERR[$i]['NUM'];?></td>
		<td width="100" style="font-size:10pt" align="center"><?php echo $ERR[$i]['STUD_NAME'];?></td>
		<td width="50" style="font-size:10pt" align="center"><?php echo $ERR[$i]['TALL'];?></td>
		<td width="50" style="font-size:10pt" align="center"><?php echo $ERR[$i]['WEIGH'];?></td>
	</tr>
 <?php 
 }
 ?>
</table>
 <?php
}
?>