<?php
//���o�]�w��
include_once "config.php";

sfs_check();


//�q�X����
head("���������v�� - �d��Ƥ���");

$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

//�ثe����ɶ�, �Ω���������Ĵ���
$Now=date("Y-m-d H:i:s");

//POST �e�X��,�D�{���ާ@�}�l ====================================================================
//�n�J, �ˬd���v�ɦ��L���ͦW��, �Y��, �}�l, �Y�L, ����
include_once('login.inc');

//��, �g�J��� **************************************************
if ($_POST['act']=='myans') {
 
 //����@���O�_�O��
 $TEST=get_test_setup($_POST['option1']);
 
 $NOWsec=NowAllSec(date("Y-m-d H:i:s"));
 $StartTest=NowAllSec($TEST['sttime']);
 $EndTest=NowAllSec($TEST['endtime']);
  //����w���D��
  $query="select count(*) as num from contest_record1 where tsn='".$_POST['option1']."' and student_sn='".$_SESSION['session_tea_sn']."'";
  $result=mysql_query($query);
  list($N)=mysql_fetch_row($result);  

 //�קK�s�u�O�ɰ��D�A1��w�Įɶ������x�s , 
 if ($NOWsec<$EndTest+1 and $N<$TEST['search_ibgroup']) {
  $ibsn=$_POST['ibsn'];
  $myans=$_POST['myans'];
  $lurl=$_POST['lurl'];
  $anstime=date("Y-m-d H:i:s");
  //�קK���Ч@��=========================================================
  $query="select * from contest_record1 where tsn='".$_POST['option1']."' and student_sn='".$_SESSION['session_tea_sn']."' and ibsn='".$ibsn."'";
  if (mysql_num_rows(mysql_query($query))==0) {
  	$query="insert into contest_record1 (tsn,student_sn,ibsn,myans,lurl,anstime) values ('".$_POST['option1']."','".$_SESSION['session_tea_sn']."','$ibsn','$myans','$lurl','$anstime')";
  		if (mysql_query($query)) {
  			$N++;
  			if ($N>=$TEST['search_ibgroup']) {
  			 $_POST['act']='End'; //�@������
  			} else {
   		   $_POST['act']='Start';
   		  }
  		} else {
   		echo "Error! Query=$query <br>";
   		echo "�гq���ʦҦѮv!";
   		exit();
   		}
  }// end if mysql_num_rows==0  ���D�|���@��
  $_POST['act']='Start';
 //�ɶ���F======
 } else {
   $_POST['act']='End';
 }
 // end if  $NOWsec<$EndTest+1 and $N<100 
  	
} // end if $_POST['act']=='myans'


//�ɭ��e�{�}�l, �����]�b <form>�� , act�ʧ@ , option1, option2 �Ѽ�2�� return��^�e�@�Ӱʧ@=============================
?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>"  enctype="multipart/form-data">
 <input type="hidden" name="act" value="<?php echo $_POST['act'];?>">
 <input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">
 <input type="hidden" name="option2" value="<?php echo $_POST['option2'];?>">
 <input type="hidden" name="return" value="<?php echo $_POST['act'];?>">

<?php
//���n�J
 if ($_POST['act']=='') {
   stud_login(1,$INFO);
 }

//�n�J���\, �}�l
if ($_POST['act']=='Start') {
 
 //���o�v�ɳ]�w 
 $TEST=get_test_setup($_POST['option1']);				//�v�ɳ]�w
 $STUD=get_student($_SESSION['session_tea_sn']);  //�ǥ͸��
 
 $NOWsec=NowAllSec(date("Y-m-d H:i:s"));
 $StartTest=NowAllSec($TEST['sttime']);
 $EndTest=NowAllSec($TEST['endtime']);
 //���X�v�ɸ��, �Y�٨S�}�l
 if ($NOWsec<$StartTest) {
  //�v�ɩ|���}�l�A���ܦh�[�Y�N�i�� ********************
  $LeaveTime=$StartTest-$NOWsec;
   ?>
   <table border="0" width="100%">
    <tr>
   	 <td style="color:#0000FF">
   	 	�n�J�ǥ͡G<?php echo $STUD['class_name']." ".$STUD['seme_num']."�� ".$STUD['stud_name'];?>�A�Z�����ɶ}�l�٦� <input type="text" name="time" size="9"> �A�Ъ`�N�I      	 	
   	 	</td> 
    </tr>
   </form>
   </table>
   <?php
   test_main($_POST['option1'],0);
   ?>
 <Script language="JavaScript">
 	var ACT='Start';
	//���ɩ|���i��A���ܨ�ƭp�ɫ�}�l
	var inttestsec=<?php echo $LeaveTime;?>;
	//���server�ɶ�
 
  checkLeaveTime();

</Script>
   
   <?php
  //���ɶi�椤
 } elseif ($NOWsec>=$StartTest and $NOWsec<$EndTest) {
 //�v�ɤw�}�l *****************************************
 //�ӥͤw�@���D��
  $LeaveTime=$EndTest-$NOWsec; //�Ѿl���
  $query="select count(*) as num from contest_record1 where tsn='".$_POST['option1']."' and student_sn='".$_SESSION['session_tea_sn']."'";
  list($N)=mysql_fetch_row(mysql_query($query));
  //�٨S�@������
  if ($N<$TEST['search_ibgroup']) {
  $N+=1; //�C�X�U�@�D
  $query="select * from contest_ibgroup where tsn='".$_POST['option1']."' and tsort='".$N."'";
  $ITEM=mysql_fetch_array(mysql_query($query)); //�D��
  ?>
  <input type='hidden' name='ibsn' value='<?php echo $ITEM['ibsn'];?>'>
  <table border="0" width="100%">
  <tr>
  	<td style="color:#800000">�ثe�v�ɡG<?php echo $TEST['title'];?> (<?php echo $PHP_CONTEST[$TEST['active']];?>�A<font color=red>�`�D�ơG<?php echo  $TEST['search_ibgroup'];?>�D</font>)</td> 
  </tr>

  <tr>
  	<td style="color:#0000FF">�n�J�ǥ͡G<?php echo $STUD['class_name']." ".$STUD['seme_num']."�� ".$STUD['stud_name'];?></td> 
  </tr>
  <tr>
  <td>
  <table border="1" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="5">
  	<tr>
  		<td width="80" align="right">�Ѿl�ɶ�</td>
  		<td style='color:#FF0000;font-ssize:10pt'><input type="text" name="time" value="" size="10">(�����H�ɪ`�N�@���ɶ��A�����ܥi��]�ӤH�q���t���Ӧ��~�t�A��ڮɶ��H���A���ݬ��D�C)</td>
  	</tr>
  	<tr>
  		<td width="80" align="right">�D��<?php echo $N;?></td>
  		<td style="color:#0000FF"><?php echo $ITEM['question'];?></td>
  	</tr>
  	<tr>
  		<td width="80" align="right">�A���@��</td>
  		<td><input type="text" name="myans" value="" size="80"></td>
  	</tr>
  	<tr>
  		<td width="80" align="right">���}���</td>
  		<td><input type="text" name="lurl" value="" size="80"></td>
  	</tr>
  	<tr>
  		<td width="80" align="right">&nbsp;</td>
  		<td style="font-size:9pt">���`�N, ���}�����ŦX���T�Ѽg�榡�]http://xxxx.xxx.xxx/xxx �^�A�Y�榡�����T�ɭP�L�k�PŪ�A�ۦ�t�d�C</td>
  	</tr>
  </table>
</td>
</tr>
  	<tr>
  		<td style="color:#FF0000">
  			 <input type="submit" value="�e�X���רø���U�@�D" onclick="checkmyans();">
  			 <input type="reset" value="�M�����g">
  			 <input type="button" value="���o�@�D" onclick="document.myform.act.value='myans';document.myform.submit()"> 
  		</td>
  	</tr>
</table>

<Script language="JavaScript">

  document.myform.myans.focus();
  var ACT='End';
	//���ɶi�椤�A���ܳѾl�ɶ�
	var inttestsec=<?php echo $LeaveTime;?>;
  checkLeaveTime();
 
 //�e���e�ˬd
 function checkmyans() {
   if (document.myform.myans.value!='' && document.myform.lurl.value!='') {
    document.myform.act.value='myans';
    document.myform.submit();
   } else {
   	alert('�@��������!!');
    return false;
   }
 }

</Script>

  <?php
 } else {
 	 $_POST['act']='End';
 } //end if $N<100
  //���ɵ���
 } else { 
 	$_POST['act']='End';
 }// end if $NOW<$StartTest  
} // end if act=start

//����, �C�X�@��
if ($_POST['act']=='End') {
 //���o�v�ɳ]�w 
 $TEST=get_test_setup($_POST['option1']);				//�v�ɳ]�w
 $STUD=get_student($_SESSION['session_tea_sn']);  //�ǥ͸��

?>
     <table border="0" width="100%">
     	<tr>
     		<td>�@������! �H�U���z���@�����ΡC</td>
     	</tr>
      <tr>
  	   <td style="color:#800000">�ثe�v�ɡG<?php echo $TEST['title'];?>(<?php echo $PHP_CONTEST[$TEST['active']];?>)</td> 
      </tr>
			<tr>
  			<td style="color:#0000FF">�n�J�ǥ͡G<?php echo $STUD['class_name']." ".$STUD['seme_num']."�� ".$STUD['stud_name'];?></td> 
  		</tr>
  	</table>	
		<table border="1" width="100%" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="2">
      <tr>
      	<td bgcolor="#FFCCCC" align="center" style="font-size:10pt" width="30">�D��</td>
        <td bgcolor="#FFCCCC" align="center" style="font-size:10pt">�D��</td>
        <td bgcolor="#FFCCCC" align="center" style="font-size:10pt" width="180">�A���@��</td>
        <td bgcolor="#FFCCCC" align="center" style="font-size:10pt" width="70">�A���s��</td>
        <td bgcolor="#FFCCCC" align="center" style="font-size:8pt" width="70">�e���ɶ�</td>
        <td bgcolor="#FFCCCC" align="center" style="font-size:10pt" width="180">�Ѧҵ���</td>
      </tr>
      <?php
      $I=0;
      $query="SELECT a.* , b.question,b.ans FROM contest_record1 AS a, contest_ibgroup AS b WHERE a.tsn=b.tsn and a.tsn='".$_POST['option1']."' and a.student_sn='".$_SESSION['session_tea_sn']."' and a.ibsn = b.ibsn order by a.anstime";
      $result=mysql_query($query);
      while ($ITEM=mysql_fetch_array($result)) {
      	$I++;
      	?>
      <tr>
      	<td style="font-size:10pt" width="30" align="center" ><?php echo $I;?></td>
        <td style="font-size:10pt"><?php echo $ITEM['question'];?></td>
        <td style="font-size:10pt" width="180"><?php echo $ITEM['myans'];?></td>
        <td style="font-size:10pt" width="70" align="center"><?php if ($ITEM['lurl']!="") { ?><a href="<?php echo $ITEM['lurl'];?>" target="_blank">�s��</a><?php } else { echo "�L"; }?></td>
        <td style="font-size:10pt" width="70" align="center" ><?php echo substr($ITEM['anstime'],-8,8);?></td>
        <td style="font-size:10pt" width="180"><?php echo $ITEM['ans'];?></td>
      </tr>
      <?php 
      }
      ?>
		</table>
		���`�N! ���}��i��L�k�A�˵��@��.
<?php
} // end if $_POST['act']='End';
?>

</form>
