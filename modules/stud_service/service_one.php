<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();
?>
<script type="text/javascript" src="./include/functions.js"></script>
<script type="text/javascript" src="./include/JSCal2-1.9/src/js/jscal2.js"></script>
<script type="text/javascript" src="./include/JSCal2-1.9/src/js/lang/b5.js"></script>
<link type="text/css" rel="stylesheet" href="./include/JSCal2-1.9/src/css/jscal2.css">

<?php

//�q�X����
head("�n���ǥͪA�Ⱦǲ߰O��");

$tool_bar=&make_menu($school_menu_p);

//Ū���A�����O $ITEM[0],$ITEM[1].....
$M_SETUP=get_module_setup('stud_service');
$ITEM=explode(",",$M_SETUP['item']);
$CONFIRM=($M_SETUP['confirm']==null)?0:$M_SETUP['confirm'];

//�C�X���
echo $tool_bar;

//�����ɫO�d�w post �����
  $sn=$_GET['sn'];
	$year_seme=$_POST['year_seme'];
	$service_date=$_POST['service_date'];
	$department=$_POST['department'];
	$sponsor=$_POST['sponsor'];
	$item=$_POST['item'];
	$memo=$_POST['memo'];
	$update_sn=$_POST['update_sn'];
	
	
//���o��Ʈw���Ҧ��Ǵ����, �C�~����ӾǴ�
$class_seme_p = get_class_seme(); //�Ǧ~��	
$class_seme_p=array_reverse($class_seme_p,1);
//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//�ثe��w�Ǵ�
$c_curr_seme=($_POST['c_curr_seme']=='')?$curr_year.$curr_seme:$_POST['c_curr_seme'];
//�ثe��w�Z��
$c_curr_class=$_POST['c_curr_class'];



//���o�ثe�n���̩Ҧb����
if ($department=='') {
$sql_select = "select post_office from teacher_post where teacher_sn='{$_SESSION['session_tea_sn']}'";
$recordSet = $CONN->Execute($sql_select);
$department= $recordSet->fields["post_office"];
}

//=[����U�R���ǥ�]===============================================
 if ($_GET['sn']!="" and $_GET['sn']!="new" and $_POST['check_del']!="" ){
 		delService_stud($_GET['sn'],$_POST['check_del']);
 }

//=[����U��s�ǥͪA�Ȯɶ���]===============================================
 if ($_POST['check_update']==1) {
 	if ($_GET['sn']!="" and $_GET['sn']!="new") {
 		     check_exist_service($_GET['sn'],1);
 	   //��s�ǥ͵n���ɶ�	
	  foreach($_POST['time_stud'] as $student_sn=>$minutes) {
	  	$studmemo=$_POST['studmemo'][$student_sn];
		$STUD=getService_stud_base($sn,$student_sn);
		$query="update stud_service_detail set minutes='$minutes',studmemo='$studmemo' where item_sn='".$_GET['sn']."' and student_sn='$student_sn' ";	
		if (mysql_query($query)) {
		 echo "��s ".$STUD['seme_class']."�Z".$STUD['seme_num']."��".$STUD['stud_name']." => (".$minutes."����)_".$STUD['memo'];
		 if ($studmemo!="") echo "<font color=red><i>".$studmemo."</i>";
		 echo "<br>";
		} else{
		  echo "�n���ǥͮɵo�Ϳ��~! Query=".$query;
		  exit();
		}
	  } // end forecah
	  ?>
	  <input type="button" value="��^" onclick="window.location='<?php echo $_SERVER['PHP_SELF'];?>?sn=<?php echo $_GET['sn'];?>'">
	  <?php
	  exit();
 	}
 }
 
//=[����U�n���A�Ȯɶ���]==================================================
if ($_POST['save']==1) {
	//�������Ŀ�ǥͦA�B�z
	if (count($_POST['selected_stud']))  {
		?>
		<table border="0" width="800">
			<tr>
				<td width="450" valign="top">			
		<?php
    //���n���A�ȶ��� , �s��ƫh���x�s, �A���o���A�ȸ�ƪ� sn
    if ($sn=="" or $sn=="new") {
    $query="insert into stud_service (year_seme,service_date,department,item,memo,update_sn,update_time,sponsor) values ('$year_seme','$service_date','$department','$item','$memo','$update_sn','".date('Y-m-d H:i:s')."','$sponsor')";
     if (mysql_query($query)) {
     		
     	list($item_sn)=mysql_fetch_row(mysql_query("SELECT LAST_INSERT_ID()"));
		  $_GET['sn']=$item_sn;
		 //echo "�s�W <font color=blue>$service_date �b �i".getPostRoom($department)."�j�i��m".$item."�n�A��...</font><br>\n";

	  }else{
	 	
		echo "�n���A�ȶ��صo�Ϳ��~! Query=".$query;
		exit();
		
	  }
	  //�Y���w�s�b���, �������o sn
	}else{
		$item_sn=$_GET['sn'];
       check_exist_service($item_sn,0); // ����ܥ��󤺮e
       $S=getService_one($item_sn); //���o���, �H�K�ˬd�O�_�w�{��
  } // end if  $sn=="new"
  if ($S['confirm']==0) {
	   //�A�n���ǥ�	
	  foreach($_POST['selected_stud'] as $student_sn=>$name) {
	  	$minutes=$_POST['time_stud'][$student_sn];
		$studmemo=$_POST['studmemo'][$student_sn];
		  if (check_exist_service_stud($item_sn,$student_sn)) {
			 echo "<font color=red>".$student_sn.$name." �n����Ƥw�s�b, �������еn��! </font><br>";
		  } else {
		$query="insert into stud_service_detail (student_sn,item_sn,minutes,studmemo) values ('$student_sn','$item_sn','$minutes','$studmemo')";	
		if (mysql_query($query)) {
		 //echo $student_sn.$name."(".$minutes."����) _".$memo;
		 //if ($studmemo!="") echo "<font color=red><i>".$studmemo."</i>";
		 //echo "<br>";
		} else{
		  echo "�n���ǥͮɵo�Ϳ��~! Query=".$query;
		  exit();
		}
		 } // end if mysql_num_rows ����ӥͬO�_�w�n��
	  } // end forecah
	 } // end if $S['confirm']	 
	 
	} // end if count($_POST['selected_stud'])
	/***
 ?>
 <font color="#800000">�H�W�ǥͤw�����n��! <br><input type="button" value="���s�n���s�A��" onclick="window.location='<?php echo $_SERVER['PHP_SELF'];?>?sn=new'">���I��k�C�w�n�����A�ȶi��ǥͪ��W��</font>
 
				</td>
  				<td width="350" valign="top">
						��<?php echo c_curr_seme;?>���Ǵ��ѱz�{�Ҫ��A�Ⱦǲ߶���
					 <?php
					  //list_pastservice(curr_year().curr_seme());
					  list_pastservice($c_curr_seme);
					 ?>				
					</td>
 			</tr>
 			</table> 
 <?php
 
 exit();
***/
} // end if ($_POST['save']==1)

//=[��s�n�����]===========================================================
if ($_POST['mode']=='updating_service') {
	$S=getService_one($_SESSION['sn']);
	if ($S['confirm']==0) { //�p�G�w�g�{�ҤF, �N������
  //���B����s input_sn �� input_time ���(��l�n���O��)
  $query="update stud_service set service_date='$service_date',department='$department',sponsor='$sponsor',item='$item',memo='$memo',update_sn='".$_SESSION['session_tea_sn']."' where sn='".$_SESSION['sn']."'";
  if (!mysql_query($query)) {
   echo "Error! Query=$query";
   exit();
  }
 }
}
//=[�R���n�����]===========================================================
if ($_POST['mode']=='delete_service') {
	$S=getService_one($_SESSION['sn']);
	if ($S['confirm']==0) { //�p�G�w�g�{�ҤF, �N����R��
  //���R���ǥ�
  $query="delete from stud_service_detail where item_sn='".$_SESSION['sn']."'";
  if (!mysql_query($query)) {
   echo "Error! Query=$query";
   exit();
  }
  //�A�R���O��
  $query="delete from stud_service where sn='".$_SESSION['sn']."'";
  if (mysql_query($query)) {
   $_SESSION['sn']='';
   $_GET['sn']='';
  $sn='';
 	$year_seme=$_POST['year_seme'];
	$service_date=date("Y-m-d");
	$department='';
	$item='';
	$memo='';
   } else {
   echo "Error! Query=$query";
   exit();
  }
 }
}
//====================================================================================================================

//�Y�A�ȸ�ƬO�ѥk�����Ŀ�Ө�, �w�]��ƨ��N $_POST��
if ($_GET['sn']!="" and $_GET['sn']!="new") {
	
	$S=getService_one($_GET['sn']);
	
	
	$sn=$S['sn'];
	$year_seme=$c_curr_seme=$S['year_seme'];
	$service_date=$S['service_date'];
	$department=$S['department'];
	$sponsor=$S['sponsor'];
	$item=$S['item'];
	$memo=$S['memo'];
	$confirm=$S['confirm']; //�O�_�{��
	$_SESSION['sn']=$_GET['sn'];
}

?>
<table border="1" style="border-collapse:collapse" bordercolor="#CCCCCC" width="830">
	<tr>
		<td>
			<!--- ��J��� --->
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?sn=<?php echo $_GET['sn'];?>" name="myform">
	<input type="hidden" name="target_service" value="">
	<input type="hidden" name="mode" value="">
			<table border="0" width="100%">
				<tr>
					<td>
						<font color="#800000">�A�Ȩƥ�o�ͩ�G</font>
				<select name="c_curr_seme" onchange="this.form.submit()">
					<?php
						while (list($tid,$tname)=each($class_seme_p)){
							if ($_GET['sn']!="" and $_GET['sn']!="new" and $c_curr_seme!=$tid) continue; //�p�G�O�ק�Ҧ��A�ȦC�X�ӾǴ��A�L�k��ܨ�L�Ǵ�
	  					if (substr($tid,0,3)>$curr_year-3) {
			    ?>
      				<option value="<?php echo $tid;?>" <?php if ($c_curr_seme==$tid) echo "selected";?>><?php echo $tname;?></option>
   				<?php
      				} // end if
    				} // end while
		    ?>
				</select> 
						
					</td>
					<td width="430" rowspan="3" style="color:#800000" valign="top">
						��<?php echo $c_curr_seme;?>���Ǵ��z�n�����A�Ⱦǲ߶���
					 <?php
					  //list_pastservice(curr_year().curr_seme());
					  list_pastservice($c_curr_seme);
					 ?>						
					</td>
			  </tr>
				<tr>
					<td width="400" style="color:#0000FF">�B�J1: <font style="font-size:9pt">�п�J<input type="button" value="�s�A�ȰO��" onclick="window.location='<?php echo $_SERVER['PHP_SELF'];?>?sn=new'">���I��k�C�w�n���A�ȼW��ǥ�</font></td>

				</tr>
			   <tr>
					<td width="400" valign="top">
					<?php
					  //�C�X�A�ȶ��ت��
					 $year_seme=($year_seme=='')?$c_curr_seme:$year_seme;
					service_table($sn,$year_seme,$service_date,$department,$sponsor,$item,$memo);
					?>			
								
					</td>
				</tr>
			</table>
			<?php
			if ($_GET['sn']!="" and $_GET['sn']!="new" and $_POST['update']=='' and $confirm==0) {
			 ?>
			 <input type="button" value="�ק�n�����e" onclick="document.myform.mode.value='update_service';document.myform.submit();">
			 <input type="button" value="�R���o���O��" onclick="javascript:confirm_delete();">
			 <?php
			}
			//
			if ($_POST['mode']=='update_service') {
			?>
			  <input type="button" value="�T�{���" onclick="document.myform.mode.value='updating_service';document.myform.submit()" style='color:#FF0000'>
			  <input type="button" value="��^" onclick="window.location='<?php echo $_SERVER['PHP_SELF'];?>?sn=<?php echo $_GET['sn'];?>'">
			<?php
			 exit();
			}
			
			
			//����U [�ק�U�C�ǥ͵n�����]�s��, ���楻�z�ᰱ�� ,���C�X�w�n���ǥ�
			if ($_GET['sn']!="" and $_GET['sn']!="new" and $_POST['update']==1) {
 			?>
 			 		</td>
	     </tr>
        </table>
 			<?php
			 			update_service_stud($_GET['sn']); 
 				exit();
			 }
			?>

			<table border="0" width="100%">
				<?php
				if ($CONFIRM==0 and $S['confirm']==0) {
					?>
				<tr>
					<td style="color:#FF0000;font-size:9pt">���`�N! ����ƥ����g�޲z���{�Ү֥i�~�|�C�J�ɼƲέp�C</td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td style="color:#0000FF">�B�J2: <font style="font-size:9pt">�п�ܭn�n�����A�ȰO�����ǥ�</font></td>
				</tr>
			</table>

	
 <?php
 
  if ($c_curr_seme!="" and $confirm==0) {
  	
    $s_y = substr($c_curr_seme,0,3);
    $s_s = substr($c_curr_seme,-1);
    
    //���X�~�ŻP�Z�ſ��
     $tmp=&get_class_select($s_y,$s_s,"","c_curr_class","this.form.submit",$c_curr_class); 
	//$year_seme=sprintf('%03d%d',$s_y,$s_s);
	//$class_array=class_base($c_curr_seme);
	//print_r($class_array);
	 
	 echo $tmp;
	 
  }
 
  if ($c_curr_class!="" and $c_curr_seme==substr($c_curr_class,0,3).substr($c_curr_class,4,1)) {
  	$Cyear=substr($c_curr_class,-5,2);
  	$Cnum=substr($c_curr_class,-2,2);
 	?>
 	<input type='button' name='all_stud' value='����' onClick='javascript:tagall(1);'><input type='button' name='clear_stud'  value='������' onClick='javascript:tagall(0);'>
 	<?php
    //�C�X�Ŀ�ǥͪ����
    student_select($c_curr_class);
	
 ?>
 <input type="hidden" name="year_seme" value="<?php echo $c_curr_seme;?>">
 <input type="hidden" name="update_sn" value="<?php echo $_SESSION['session_tea_sn'];?>">

 <table border="0" width="100%">
 	<tr>
 		<td style="color:#FF0000;font-size:10pt"><input type="button" value="�n���A�Ȯɶ�" style="color:#FF0000" onclick="check_save()">���`�N! �ȵn�����Ŀ諸�ǥ͡C</td>
 	</tr>
 </table>
 <?php
   } // end if c_curr_class
   ?>
  		</td>
	</tr>
</table>
   <?php
  //�C�X�w�n�����ǥ�
 if ($_GET['sn']!="" and $_GET['sn']!="new" and $_GET['update_stud']=="") {
 	echo "<br>";
  			list_service_stud($_GET['sn']);
 }
 
  

?>
</form>			
 

