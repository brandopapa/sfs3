<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();


//�q�X����
head("���ά��� - ��ʶפJ");

$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}
//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();
//���o�Ҧ��Ǵ����, �C�~����ӾǴ�
$class_seme_p = get_class_seme(); //�Ǧ~��	
$class_seme_p=array_reverse($class_seme_p,1);

//�ثe��w�Ǵ�
$c_curr_seme=($_POST['c_curr_seme']!="")?$_POST['c_curr_seme']:sprintf('%03d%1d',$curr_year,$curr_seme);


$module_manager=checkid($_SERVER['SCRIPT_FILENAME'],1);
if ($module_manager!=1) {
 echo "��p , �z�S���L�޲z�v��!";
 exit();
}

//���U�x�s�s�� , �Q�� $_SESSION['club_sn'] ���x�s�ؼ�
if ($_POST['act']=="save") {
 $insert_num=0;
 $data_array=explode("\n",$_POST['data_array']);
  /* �@�C�@�Ӿǥ͸�� */
  /* 0�Ǧ~�Ǵ� 1�Ǹ�	2�~��	3�Z��	4�y��	5�m�W	6���ΦW��	7����F��	8���Z	9�Юv���y	10�ۧڬ٫� */
 foreach ($data_array as $line) {

 	$student_sn="";
  $S=explode("\t",$line);

  if (trim($S[0])!='') {
 	 $c_curr_seme=$S[0];
   //�Q�ξǸ����o student_sn
   if (trim($S[1])!='') {
     $query="select student_sn from stud_seme where stud_id='".$S[1]."' and seme_year_seme='$c_curr_seme'";
     $res=mysql_query($query);
     if (mysql_num_rows($res)==1) {
     list($student_sn)=mysql_fetch_row($res);
     } else {
      $student_sn="";
     }
   } 
   //�S����, �Q�ίZ�Ůy�����o studend_sn
   if ($student_sn=="") {
    $seme_class=sprintf("%d%02d",trim($S[2]),trim($S[3]));
    $seme_num=sprintf("%d",trim($S[4]));
    $query="select student_sn from stud_seme where seme_year_seme='$c_curr_seme' and seme_class='$seme_class' and seme_num='$seme_num'";
    $res=mysql_query($query);
     if (mysql_num_rows($res)==1) {
      list($student_sn)=mysql_fetch_row($res);
     } else {
      $student_sn="";
     }
   } // end if �Q�ίZ�Ůy�����o
   
   //���o�Ӿǥ�
   if ($student_sn!="") {
   	$association_name=trim($S[6]);		//���ΦW��
   	$score=trim($S[8]);							//���Z
   	$description=trim($S[9]); 				//�Юv���y
   	$stud_post=trim($S[7]);
   	$stud_feedback=trim($S[8]);
   	
   	if (trim($association_name)=='') continue;
   	
  	//�ˬd���S�����и�� , �����\����
  	switch ($_POST['no_double_score']) {
  		//��ƭ��ЮɡA���L
  		case '1': 
	  		$query="select student_sn from association where seme_year_seme='$c_curr_seme' and student_sn='$student_sn'";
  			$res=mysql_query($query);
  			if (mysql_num_rows($res)>0) {
  				$sql="";  //��ƭ���
  			} else {        
  		    $sql="insert into association (student_sn,seme_year_seme,association_name,score,description,update_sn,stud_post,stud_feedback) values ('$student_sn','$c_curr_seme','$association_name','$score','$description','".$_SESSION['session_tea_sn']."','$stud_post','$stud_feedback')"; 	 
  			}
  		break;
  		//��ƭ��Ю��мg
  		case '2':
  			$query="delete from association where seme_year_seme='$c_curr_seme' and student_sn='$student_sn'";
  			$res=$CONN->Execute($query) or die('SQL Error! query='.$query);
  		  $sql="insert into association (student_sn,seme_year_seme,association_name,score,description,update_sn,stud_post,stud_feedback) values ('$student_sn','$c_curr_seme','$association_name','$score','$description','".$_SESSION['session_tea_sn']."','$stud_post','$stud_feedback')"; 	 
  		break;
  		//�@�߷s�W
  		case '3':
  		  $sql="insert into association (student_sn,seme_year_seme,association_name,score,description,update_sn,stud_post,stud_feedback) values ('$student_sn','$c_curr_seme','$association_name','$score','$description','".$_SESSION['session_tea_sn']."','$stud_post','$stud_feedback')"; 	 
  		break;  		
  		
    }
  	
   	if ($sql!="") {
   		 $res=$CONN->Execute($sql) or die('SQL Error! query='.$sql);
       $insert_num++;
   	}
   } // end if student_sn!=''   
  } // end if �Ǧ~�Ǵ�  
 } // end foreach
} // end if 



?>
<form name="myform" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<!-- mode �Ѽ� insert , update ,�b submit�e�i�� mode.value �ȭק� -->
	<input type="hidden" name="act" value="">

<?php
$query="select seme_year_seme,count(*) as num from association group by seme_year_seme order by seme_year_seme";
$res=$CONN->Execute($query);
?>
<font color=blue size=4>���C�����θ�Ʈw���w�����U�Ǵ���ƼơG</font>
<table border='2' cellpadding='3' cellspacing='0' style='border-collapse: collapse; font-size=12px;' bordercolor='#111111' width='300'>
	<tr bgcolor='#FFDDDD' ALIGN='CENTER'>
		<td>�Ǧ~�Ǵ�</td><td>��Ƽ�</td>
	</tr>
<?php
 while ($row=$res->fetchRow()) {
 ?>
	<tr ALIGN='CENTER'>
		<td><a href='dup_del.php?ys=<?php echo $row['seme_year_seme'] ?>' target='_BLANK'><?php echo substr($row['seme_year_seme'],0,3);?>�Ǧ~��<?php echo substr($row['seme_year_seme'],-1);?>�Ǵ�</a></td><td><?php echo $row['num'];?> ��</td>
	</tr>  
 <?php
 }
?>
</table>
<table>
	<tr>
		<td style='color:#800000'>�жK�W��ơG</td>
	</tr>
	 <tr>
	  <td><textarea cols="100" rows="6" name="data_array"></textarea></td>
	</tr>
</table>
<table border="0">
 <tr>
 	<td><font color='#800000'>�Y�o�{�Y�Ǵ���Ʈw���w�s�b�Y�ǥ͸�ƮɡA�p��B�z�H</font><br/>
 		�C<input type="radio" name="no_double_score" value="1" checked>���L�ӵ����B�z<br/>
 		�C<input type="radio" name="no_double_score" value="2">�@���мg�A�ȫO�d�̪񪺳o�@��	<br/>
 		�C<input type="radio" name="no_double_score" value="3">���ӥͼW�[�o���s�O��(�ӥͱN���h�����ΰO��)<br/>
 	</td>
 </tr>
 <tr>
  <td><input type="button" value="�e�X���" onclick="if (document.myform.data_array.value!='') { document.myform.act.value='save';document.myform.submit(); }"></td>
 </tr>
</table>
<table border="0">
 <tr>
  <td style="color:#FF0000"><?php if ($_POST['act']=='save') echo "�����w���".$insert_num."���O��";?></td>
 </tr>
</table>
<table border="0">
 <tr>
  <td style="color:#0066FF">�פJ�覡�����G<br>
  	1.���{���פJ�����Φ��Z�A�ȨѦ��Z���X�ɨϥΡC<br>
  	2.�פJ�覡���N Excel ���Z�����ƻs���K�W�Y�i�A���Ъ`�N��춶��(�p�ϥ�)�A�C�@����ƥ����]�t�u�Ǧ~�Ǵ��v�C<br>
  	3.�u�Ǹ��v�Ρu�Z�šB�y���v�A�o�ⳡ���ܤ֥������䤤�@���A�H�K�ѧO�ǥͨ����C<br>
  	4.����U�u�e�X��ơv��A�t�η|���i���Ƥ��R�A�C�@�C�����@����ơC<br>
  	<font size=2>
  	(1)�Y�ӵ���Ʀ���J�u�Ǧ~�Ǵ��v�Ρu�Ǹ��v�A�t�ξڦ��u���@���Ӹ�ƪ������ѧO�A�ñN���ΰO���s�J�ӥ͹������Ǧ~�Ǵ����ΰO���C<br>
  	(2)�Y�ӵ���ƵL�Ǹ��A������J�u�Ǧ~�Ǵ��v�B�u�Z�šv�Ρu�y���v�A�h�t�η|�H<font color=red>�ӾǦ~�ת��Z�Ůy��</font>���������ѧO����A�s�J�ӥ͹������Ǧ~�Ǵ����ΰO���C<br>
  	(3)�ǥͩm�W�Ȩѫ��ɪ��ѧO�A�t�Τ����ĥΡA����줴�����O�d�C<br/>
  	(4)�Y��ʪ��ΦW�١A�ӵ���Ƥ����B�z�C<br/>
  	</font>
  	<img src="./images/demo.png" border="0"><br>
  	
  </td>
 </tr>
 <tr>
  <td>�i<a href="./images/demo.xls" style="color:#FF0000">����</a>�j�i�U�� EXCEL demo �ɮסC</td>
 </tr>
</table>
</form>

