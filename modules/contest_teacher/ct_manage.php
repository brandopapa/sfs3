<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

//�q�X����
head("���������v�� - �v�ɺ޲z");

sfs_check();

?>
<script type="text/javascript" src="./include/tr_functions.js"></script>
<script type="text/javascript" src="../../javascripts/JSCal2-1.9/src/js/jscal2.js"></script>
<script type="text/javascript" src="../../javascripts/JSCal2-1.9/src/js/lang/b5.js"></script>
<link type="text/css" rel="stylesheet" href="../../javascripts/JSCal2-1.9/src/css/jscal2.css">

<?php
$tool_bar=&make_menu($school_menu_p);

//�C�X���
echo $tool_bar;

//���o�ثe�Ǧ~��
$curr_year=curr_year();
$curr_seme=curr_seme();

//���o�Ҧ��Ǵ����, �C�~����ӾǴ�
$class_seme_p = get_class_seme(); //�Ǧ~��	
$class_seme_p=array_reverse($class_seme_p,1);

//�ثe��w�Ǵ�
  $c_curr_seme=($_POST['c_curr_seme']!="")?$_POST['c_curr_seme']:sprintf('%03d%1d',$curr_year,$curr_seme);
//�ثe��w�Ǵ�
//$c_curr_seme=sprintf('%03d%1d',$curr_year,$curr_seme);

//�ثe����ɶ�, �Ω���������Ĵ���
$Now=date("Y-m-d H:i:s");

if (!$MANAGER) {
 echo "<font color=red>��p! �A�S���޲z�v��, �t�θT��A�~��ާ@���\��!!!</font>";
 exit();
}

//����T���v�ɪ��ǥͤW�ǥؿ��O�_�s�b, ���s�b�۰ʫإ�
for ($i=2;$i<=4;$i++) {
 if (!file_exists($UPLOAD_P[$i])) {
	 if (!file_exists($UPLOAD_BASE)) {
 		 mkdir($UPLOAD_BASE,0777);
 	}
     mkdir(substr($UPLOAD_P[$i],0,strlen($UPLOAD_P[$i])-1),0777);
 }
}//end for

//POST �e�X��,�D�{���ާ@�}�l 

if (@$_POST['act']=="inserting") {
 
 //��Ƥ��e
 	$title=$_POST['title'];
 	$qtext=$_POST['qtext'];
	$sttime=$_POST['sday']." ".$_POST['stime_hour'].":".$_POST['stime_min'].":00";
	$endtime=$_POST['eday']." ".$_POST['etime_hour'].":".$_POST['etime_min'].":00";
	$memo=$_POST['memo'];
	$active=$_POST['active'];
	$password=$_POST['password'];
	$delete_enable=$_POST['delete_enable'];
	@$open_judge=$_POST['open_judge'];
	@$open_review=$_POST['open_review'];
	
  $query="insert into contest_setup (year_seme,title,qtext,sttime,endtime,memo,active,open_judge,open_review,password,delete_enable) values ('$c_curr_seme','$title','$qtext','$sttime','$endtime','$memo','$active','$open_judge','$open_review','$password','$delete_enable')";
  if (mysql_query($query)) {
 
   //���^�̫᪺ auto_increat ��ID��
  list($tsn)=mysql_fetch_row(mysql_query("SELECT LAST_INSERT_ID()"));
 
  	//�O�_�ҥε����w�]�Ӷ�
  	if ($_POST['init_score_setup']==1) {
  	 if ($active==2 or $active==3) {
  	  $i=0;
  	  foreach ($SCORE_PAINT as $sco_text) {
  	   $i++;
   	   $sco_sn="s".date("y").date("m").date("d").date("H").date("i").date("s").$i;
  	   $query="insert into contest_score_setup (tsn,sco_sn,sco_text) values ('$tsn','$sco_sn','$sco_text')";
  	   mysql_query($query); 
  	  }
  	 } // end if $active
  	 if ($active==4) {
  	  $i=0;
  	  foreach ($SCORE_IMPRESS as $sco_text) {
  	   $i++;
   	   $sco_sn="s".date("y").date("m").date("d").date("H").date("i").date("s").$i;
  	   $query="insert into contest_score_setup (tsn,sco_sn,sco_text) values ('$tsn','$sco_sn','$sco_text')";
  	   mysql_query($query); 
  	  }
  	 
  	 } // end if $active 
  	} // end if init_score_setup
    
    $_POST['act']='';
    
   } else {
   	echo "Error! query=".$query;
  }

} // end if $_POST['act']=inserting


//�R���v�ɸ�� (�ƥ��ˬd�ҵL���W��Ƥ~�� , �ҥH�����ˬd���L�ǥͤW���ɮ�)
if (@$_POST['act']=="delete") { 
 $TEST=get_test_setup($_POST['option1']);
  if ($TEST['active']==1) {
	//�R���d��Ƥ��ɤ����D��
 $query="delete from contest_ibgroup where tsn='".$_POST['option1']."'";
  mysql_query($query);
  //��sid �s�X
  mysql_query("optimize test_ibgroup");
  mysql_query("alter table test_ibgroup id");
  mysql_query("alter table test_ibgroup add id int(5) auto_increment not null primary key first");
 
 //�R���@���O�� contest_record1
  $query="delete from contest_record1 where tsn='".$_POST['option1']."'";
  mysql_query($query);
  //��sid �s�X
  mysql_query("optimize contest_record1");
  mysql_query("alter table contest_record1 id");
  mysql_query("alter table contest_record1 add id int(6) auto_increment not null primary key first");

 } else {
 	//�@�~�W����
 	//contest_record2 , filename�v�W�Ǫ��ɮ�
 	$query="select filename from contest_record2 where tsn='".$_POST['option1']."'";
 	$res=mysql_query($query);
 	while ($F=mysql_fetch_array($res,1)) {
 	   	  unlink ($UPLOAD_P[$TEST['active']].$F['filename']);
  	   	if ($TEST['active']==2) {
  	   		$a=explode(".",$F['filename']);
  	   		$filename_s=$a[0]."_s.".$a[1];
  	   		unlink ($UPLOAD_P[$TEST['active']].$filename_s); //�R���Y�Ϯ�
  	    } // end if active=2
 	} // end while
 	 mysql_query("delete from contest_record2 where tsn='".$_POST['option1']."'");
 	
 	//�Ӷ������O��
  //contest_score_user ,��select contest_score_setup��tsn=$_POST['option1']��sco_sn
	  $query="select sco_sn from contest_score_setup where tsn='".$_POST['option1']."'";
	  $res=mysql_query($query);
 	  while ($row=mysql_fetch_array($res,1)) {
 	   $sql_del="delete from contest_score_user where sco_sn='".$row['sco_sn']."'";
 	   mysql_query($sql_del);
 	  } // end while
	
 	//contest_score_setup �Ӷ������]�w
 	  mysql_query("delete from contest_score_setup where tsn='".$_POST['option1']."'");
 	
 	//contest_score_record2	�`���ε��y
 	  mysql_query("delete from contest_score_record2 where tsn='".$_POST['option1']."'");  
 } // end if $TEST['active']
  
 //�R���v�ɳ��W�O�� contest_user
   mysql_query("delete from contest_user where tsn='".$_POST['option1']."'");
 //�R���v�ɵ��f�]�w contest_judge_user
   mysql_query("delete from contest_judge_user where tsn='".$_POST['option1']."'");  
 //�R���v�ɰO��
 $query="delete from contest_setup where tsn='".$_POST['option1']."'";
 mysql_query($query);
 $_POST['act']='';
  
} // end if $_POST['act']=='delete'

//�ק�����Ӷ�
if (@$_POST['act']=='updating' or @$_POST['act']=='add_score_setup' or @$_POST['act']=='del_score_setup') {

 //��Ƥ��e
 	$title=$_POST['title'];
 	$qtext=$_POST['qtext'];
	$sttime=$_POST['sday']." ".$_POST['stime_hour'].":".$_POST['stime_min'].":00";
	$endtime=$_POST['eday']." ".$_POST['etime_hour'].":".$_POST['etime_min'].":00";
	$memo=$_POST['memo'];
	$active=$_POST['active'];
	@$open_judge=$_POST['open_judge'];
	@$open_review=$_POST['open_review'];
	$password=$_POST['password'];
	$delete_enable=$_POST['delete_enable'];
	
  $query="update contest_setup set title='$title',qtext='$qtext',sttime='$sttime',endtime='$endtime',memo='$memo',active='$active',open_judge='$open_judge',open_review='$open_review',password='$password',delete_enable='$delete_enable' where tsn='".$_POST['option1']."'";

  if (mysql_query($query)) {
  	//�Y���s�W�����ӥ�
  	switch ($_POST['act']) {
  	 case 'add_score_setup':
  	   $sco_sn="s".date("y").date("m").date("d").date("H").date("i").date("s");
       //���եN�X�O�_����
	     do {
	      $a=floor(rand(10,99));
	      $sco_sn_test=$sco_sn.$a;
	      $query="select count(*) as num from contest_score_setup where sco_sn='".$sco_sn_test."'";
	      $res=mysql_query($query);
	      list($exist)=mysql_fetch_row($res);
     	} while ($exist>0);
	     $sco_sn=$sco_sn_test;
       //��Ƥ��e
 	     $sco_text=$_POST['sco_text'];
  	   $query="insert into contest_score_setup (tsn,sco_sn,sco_text) values ('".$_POST['option1']."','$sco_sn','$sco_text')";
  	   mysql_query($query); 
			 $_POST['act']="update";
  	 break;
  	 case 'del_score_setup':
			 $query="delete from contest_score_setup where sco_sn='".$_POST['option2']."'";
       mysql_query($query);
       //��sid �s�X
		   mysql_query("optimize contest_score_setup");
  		 mysql_query("alter table contest_score_setup id");
  		 mysql_query("alter table contest_score_setup add id int(5) auto_increment not null primary key first");
       $_POST['act']="update";
  	 break;
  	 default:
      $_POST['act']='listone'; 	 
  	}
  	
   } else {
   	echo "Error! query=".$query;
   	exit();
  }
} // end if update

//�]�w�d��Ƥ����D�w��

   //�M��100�D
  if ($_POST['act']=='clear100') {
   clear100($_POST['option1']);
   $_POST['act']='search';
  }
  
   //�ɨ�100�D
  if ($_POST['act']=='get100') {
   $INFO=get100($_POST['option1'],$_POST['item_total']);
   $_POST['act']='search';
  }

  //�R��1�D
  if  ($_POST['act']=='search_delete_one') {
    $query="delete from contest_ibgroup where tsn='".$_POST['option1']."' and ibsn='".$_POST['option2']."'";
    mysql_query($query);
    $_POST['act']="search";
  }
    
  //�R���Ҧ��Ŀ諸�D��
  if ($_POST['act']=='search_delete_select') {
    foreach ($_POST['select_ibgroup'] as $ibsn) {
    	$query="delete from contest_ibgroup where tsn='".$_POST['option1']."' and ibsn='$ibsn'";
    	mysql_query($query);
    } // end foreach
    $_POST['act']="search";
  }

  //�x�s�Ŀ諸�D��
  if ($_POST['act']=='save_choice') {
  	foreach ($_POST['select_ibgroup'] as $ibsn) {
  	  //�g�J�D�إN�X
  		$query="select * from contest_itembank where ibsn='$ibsn'";
  		$res=mysql_query($query);
  		$row=mysql_fetch_array($res);
  		$query="insert into contest_ibgroup (tsn,ibsn,question,ans,ans_url) values ('".$_POST['option1']."','$ibsn','".SafeAddSlashes($row['question'])."','".SafeAddSlashes($row['ans'])."','".$row['ans_url']."')";
  		mysql_query($query);
 		} // end foreach
 		//�g�J�X�D��
 		$query="select ibsn from contest_ibgroup where tsn='".$_POST['option1']."'";
 		$result=mysql_query($query);
 		$tsort=0;
 		while ($row=mysql_fetch_row($result)) {
  		list($ibsn)=$row;
  		$tsort++;
  		mysql_query("update contest_ibgroup set tsort='$tsort' where tsn='".$_POST['option1']."' and ibsn='$ibsn'");
 		} //end while
    $_POST['act']="search";
	} // end if ($_POST['act']=='save_choice')

//�H�Ǹ����W�@�H
if ($_POST['act']=='edituser_add_by_stud_id') {
 //���w���Ǵ��ӾǸ�,�B���`�N�Ǥ����ǥ�, ���o studnent_sn
 $query="select stud_name,seme_class,seme_num,a.student_sn from stud_base a,stud_seme b where a.stud_study_cond in (0,15) and b.seme_year_seme='$c_curr_seme' and a.student_sn=b.student_sn and a.stud_id='".$_POST['stud_id']."'";
 $res=mysql_query($query);
 if (mysql_num_rows($res)==1) {
 	$row=mysql_fetch_array($res,1);
  //�Ѽ� �ǤJ $tsn �� ���W�ǥ� array
  $INFO=contest_add_user($_POST['option1'],$row);
  
 } elseif (mysql_num_rows($res)>1) {
  $INFO="�ǥ͸�Ʈw���`, �Ǹ��H�ƶW�L1�H, �гq���t�κ޲z��!";
 } else {
  $INFO="�d�L���ǥ�! ";
 }
 $_POST['option2']=$_POST['act'];
 $_POST['act']='edituser';
}

//�H�Z�Ůy�����W�@�H
if ($_POST['act']=='edituser_add_by_classnum') {
 $query="select stud_name,seme_class,seme_num,a.student_sn from stud_base a,stud_seme b where a.stud_study_cond in (0,15) and b.seme_year_seme='$c_curr_seme' and a.student_sn=b.student_sn and b.seme_class='".substr($_POST['classnum'],0,3)."' and b.seme_num=".substr($_POST['classnum'],3,2);
 $res=mysql_query($query);
 if (mysql_num_rows($res)==1) {
 	$row=mysql_fetch_array($res,1);
  //�Ѽ� �ǤJ $tsn �� ���W�ǥ� array
  $INFO=contest_add_user($_POST['option1'],$row);
 } elseif (mysql_num_rows($res)>1) {
  $INFO="�ǥ͸�Ʈw���`, �Ǹ��H�ƶW�L1�H, �гq���t�κ޲z��!";
 } else {
  $INFO="�d�L���ǥ�! ";
 }
 $_POST['option2']=$_POST['act'];
 $_POST['act']='edituser';
}

//��Z���W
if ($_POST['act']=='edituser_class_add') {
 $i=0;
 foreach ($_POST['class_id'] as $class_id) {
	$seme_class=sprintf("%d%02d",substr($class_id,6,2),substr($class_id,9,2));
  $query="select a.student_sn,stud_name,seme_class,seme_num from stud_seme a,stud_base b where a.student_sn=b.student_sn and a.seme_year_seme='$c_curr_seme' and a.seme_class='$seme_class' and b.stud_study_cond in (0,15)";
  $res=mysql_query($query);
  while ($STUDENT=mysql_fetch_array($res,1)) {
    $INFO=contest_add_user($_POST['option1'],$STUDENT);
    if (substr($INFO,0,4)=='���W') $i++;
  } // end while
 } // end foreach class_id	
	
	$INFO="�@���\���W".$i."��ǥ�!";
 $_POST['option2']=$_POST['act'];
 $_POST['act']='edituser';

} // end if edituser_class_add

//�R��1�H
if ($_POST['act']=='deleteuser') {
 $query="delete from contest_user where tsn='".$_POST['option1']."' and student_sn='".$_POST['option2']."'";
 mysql_query($query);
 $_POST['act']=$_POST['return'];
}


//�]�w�խ� ****************************************************
  if (@$_POST['act']=="editgroup_update") {
  	//���M���쥻�O���Ͳխ����O��
  	$query="update contest_user set ifgroup='' where tsn='".$_POST['option1']."' and ifgroup='".$_POST['option2']."'";
  	mysql_query($query);
   foreach ($_POST['ifgroup'] as $student_sn) {
  	$query="update contest_user set ifgroup='".$_POST['option2']."' where tsn='".$_POST['option1']."' and student_sn='".$student_sn."'";
    mysql_query($query);
   }
   $_POST['act']='edituser';
  }
  
//�]�w���f�Ѯv ****************************************************
  if (@$_POST['act']=="judge_add") {
    foreach ($_POST['judge_teacher'] as $teacher_sn) {
      $query="insert into contest_judge_user (teacher_sn,tsn) values ('$teacher_sn','".$_POST['option1']."')";
      mysql_query($query);
    }
    $_POST['act']='judge';
  }

  if (@$_POST['act']=="judge_del") {
      $query="delete from contest_judge_user where teacher_sn='".$_POST['option2']."' and tsn='".$_POST['option1']."'";
      mysql_query($query);
           
      //�N�����O���]�R��
      $query="delete from contest_score_record2 where teacher_sn='".$_POST['option2']."' and tsn='".$_POST['option1']."'";
      mysql_query($query); 
      
    	//�Ӷ������O��
     	//contest_score_user ,��select contest_score_setup��tsn=$_POST['option1']��sco_sn
	  	$query="select sco_sn from contest_score_setup where tsn='".$_POST['option1']."'";
	  	$res=mysql_query($query);
 	  	while ($row=mysql_fetch_array($res,1)) {
 	   		$sql_del="delete from contest_score_user where sco_sn='".$row['sco_sn']."' and teacher_sn='".$_POST['option2']."'";
 	   		mysql_query($sql_del);
 	  	} // end while      
      
      $_POST['act']=$_POST['return'];
  }

//�ɭ��e�{�}�l, �����]�b <form>�� , act�ʧ@ , option1, option2 �Ѽ�2�� return��^�e�@�Ӱʧ@
?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
 <input type="hidden" name="act" value="<?php echo $_POST['act'];?>">
 <input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">
 <input type="hidden" name="option2" value="<?php echo $_POST['option2'];?>">
 <input type="hidden" name="return" value="<?php echo $_POST['act'];?>">
<?php
//�w�]���C�X�v�ɩ���
if ($_POST['act']=='') {
	?>
	<table border="0" width="100%">
	 <tr>
	  <td>
			<select name="c_curr_seme" onchange="this.form.submit()">
			<?php
			 foreach ($class_seme_p as $tid=>$tname) {
    	?>
    		<option value="<?php echo $tid;?>" <?php if ($c_curr_seme==$tid) echo "selected";?>><?php echo $tname;?></option>
   		<?php
    	} // end while
    	?>
    </select> 
     <?php
      if ($c_curr_seme==sprintf('%03d%1d',$curr_year,$curr_seme)) {
     ?>
	  	<input type="button" value="�s�W�@���v��" onclick="document.myform.act.value='insert';document.myform.submit();">
	  	<?php
	  	}
	  	?>
	  	�t�ήɶ��G<?php echo date("Y-m-d H:i:s");?>
	  </td>
	 </tr>
	</table>
	<hr>
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D���b�i�檺�v��</td>
  	</tr>
  </table>
  <?php
  //���b�i��
  $query="select * from contest_setup where sttime<='$Now' and endtime>'$Now' and year_seme='$c_curr_seme'";
    test_list($query);
  ?>
  <br>
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D�|���}�l���v��</td>
  	</tr>
  </table>
  <?php
  //�٨S�}�l
  $query="select * from contest_setup where sttime>'$Now' and year_seme='$c_curr_seme'";
   test_list($query);
  ?>
  <br>
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D�w�������v��</td>
  	</tr>
  </table>
  <?php
  //�w����
  $query="select * from contest_setup where endtime<='$Now' and year_seme='$c_curr_seme'";
  test_list($query);
  ?>
<?php
} // end if act==''

//�s�W�@���v��
if ($_POST['act']=='insert') {
?>
 <input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme;?>">
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D�s�W�v�ɶ���</td>
  	</tr>
  </table>
  <?php
  $YEAR=date("Y")-1911;
  $TEST['tsn']='';
  $TEST['title']=$YEAR.'�~�׺��������v�ɮդ�����';
  $TEST['qtext']='';
  $TEST['sttime']=date("Y-m-d H:i:00");
  $TEST['endtime']=date("Y-m-d H:i:00");
  $TEST['memo']='';
  $TEST['active']='0';
  form_contest($TEST);
  ?>
  <table border="0" width="100%">
   	<tr>
  		<td style="font-size:10pt;color:#FF0000">
  		 <input type="button" value="�e�X" onclick="check_test_form('inserting')">  		 	
  		 <input type="reset" value="�M�����g">
  		 <input type="button" style="color:#FF00FF" value="�^�W�@��" onclick="document.myform.act.value='';document.myform.submit();">
  		 �`�N�I�Цb�s�W�v�ɫ�A�A�i���L�]�w(�]�A�v�ɳ��W�B�v�ɵ����ӥص�)�C
  		</td>
  	</tr>
  </table>
  <Script Languge="JavaScript">document.myform.title.focus();</Script>
 <?php
}// end if act==insert


//�]�w�v�ɤ��e
if ($_POST['act']=='update') {
?>
 <input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme;?>">
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D�]�w�v�ɤ��e</td>
  	</tr>
  </table>
  <?php
  $TEST=get_test_setup($_POST['option1']);
  form_contest($TEST);
  ?>
  <table border="0" width="100%">
   	<tr>
  		<td style="font-size:10pt;color:#FF0000">
  		 <input type="button" value="�e�X�]�w" onclick="check_test_form('updating')">  		 	
  		 <input type="reset" value="�M�����g">
  		 <input type="button" style="color:#FF00FF" value="�^�W�@��" onclick="document.myform.act.value='listone';document.myform.submit();">
  		</td>
  	</tr>
  </table>
  <Script Languge="JavaScript">document.myform.title.focus();</Script>
 <?php
}// end if act==update


//�i��Y�v�ɪ��޲z
if ($_POST['act']=='listone') {
	$TEST=get_test_setup($_POST['option1']);
	?>
 <input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme;?>">
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D�v�ɤ��e�޲z  	</tr>
  </table>
  <?php
  test_main($_POST['option1'],1); //�ĤG�ӰѼƳ]��1, ��������D��, �]��0������D��(�Ω���ɫe���i)
  ?>
  <table border="0">
   <tr>
     <td>
      <?php list_judge_user($_POST['option1']);?>
     </td>
   </tr>
   <tr>
   	 <td style="color:#FF0000;font-size:10pt">�����v�ɥثe�]�w�G�m�����\��G<?php echo $OPEN[$TEST['open_judge']];?>�n�m���Z���G�G<?php echo $OPEN[$TEST['open_review']];?>�n</td>
   </tr>
  </table>
  <table border="0" width="100%">
  	<tr>
  		<td>
  			<input type="button" value="���]���v�ɤ��e" onclick="document.myform.act.value='update';document.myform.submit();">
  			<input type="button" value="�v�ɳ��W�޲z" onclick="document.myform.act.value='edituser';document.myform.submit();">
  			<input type="button" value="���w���f�Ѯv" onclick="document.myform.act.value='judge';document.myform.submit();">
  			<?php
  			if ($TEST['active']==1) {
  			?>
  			<input type="button" value="�]�w�d��Ƥ����D��(�w��<?php echo $TEST['search_ibgroup'];?>�D)" onclick="document.myform.act.value='search';document.myform.submit();">
  			<?php
  			}
  			if ($TEST['testuser_num']==0 or $TEST['delete_enable']==1) {
  			?>
  			<input type="button" style="color:#FF0000" value="�R���v��" onclick="if (confirm('�z�T�w�n:\n�R�����v��?\n�`�N! �s�P�Ҧ��W�ǧ@�~�B�@���O��...���Ҥ@�֧R��!!!')) { document.myform.act.value='delete';document.myform.submit(); }">
  			<?php
  			}
  			?>
  			<input type="button" value="�C�L�W��" onclick="document.myform.act.value='print_user';document.myform.submit();">
  			<input type="button" style="color:#FF00FF" value="�^���v�ɺ޲z�C��" onclick="document.myform.act.value='';document.myform.submit();">
  		</td>
  	</tr>
  </table>
  <table border="0" width="100%">
   <tr>
    <td>�����v�ɤw���W�W��G�@�p<?php echo $TEST['testuser_num'];?>�H</td>	
   </tr>
  </table>
  <?php

  list_user($_POST['option1'],$_POST['act']);

} // end if act=listone

//�C�L�W��
if ($_POST['act']=='print_user') {
?>
 <input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme;?>">
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D�C�L�W��</td>
  	</tr>
  </table>
	<?php
	$TEST=get_test_setup($_POST['option1']);
  title_simple($TEST); 
  ?>
  <input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme;?>">
  <br>
  <font color="#800000">���ФĿ�n�L�X������</font>
  <table border="1" width="100%" style="border-collapse:collapse" bordercolor="#d0d0d0">
  	<tr>
  	  <td width="40" align="center" style="color:#800000">�D��</td><td><input type="checkbox" name="show_question" value="1">�n�C�L�X��</td>
  	</tr>
  	<tr>
  		<td width="40" align="center" style="color:#800000">����</td>
  		 <td>
  		 	<table border="0">
  		 	  <tr>
  	  		  <input type="hidden" name="print_chk[0]" value="stud_id">
  		  		<td><input type="checkbox" name="print_chk[1]" value="stud_name" checked>�m�W</td>
  		  		<td><input type="checkbox" name="print_chk[2]" value="seme_class" checked>�Z��</td>
  		  		<td><input type="checkbox" name="print_chk[3]" value="seme_num" checked>�y��</td>
  		  		<td><input type="checkbox" name="print_chk[4]" value="email_pass">�n�J�K�X</td>
  		  		<td><input type="checkbox" name="print_chk[5]" value="logintimes">�n�J����</td>
   		  		<td><input type="checkbox" name="print_chk[6]" value="lastlogin">�̫�n�J�ɶ�</td>
   		  	</tr>
   		  	<tr>
						<td><input type="checkbox" name="print_chk[7]" value="record">�v�ɰO��</td>
						<td><input type="checkbox" name="print_chk[8]" value="score">�v�ɦ��Z</td>
						<td><input type="checkbox" name="print_chk[9]" value="prize_text">�o���W��</td>
						<td><input type="checkbox" name="print_chk[10]" value="prize_memo">���f���y</td>
 					</tr>
 					<tr>
						<td><input type="checkbox" name="print_chk[11]" value="sign">ñ�W��</td>
						<td><input type="checkbox" name="print_chk[12]" value="chk" checked>�I�W��</td>
						<td><input type="checkbox" name="print_chk[13]" value="memo">�Ƶ���</td>
  		 	  	<td colspan="3"><input type="checkbox" name="print_chk[14]" value="mytitle"><input type="text" size="10" name="mytitle_text">(��e<input type="text" name="mytitle_width" size="3" value="100">)<font size="2" color="#FF0000"><--�ۭq���</font></td>
  		 	  </tr>
  		 	</table>				
			</td>
		</tr>
		<tr>
   		 <td width="40" align="center" style="color:#800000">���</td>
				<td>��쪺�j�p<input type="text" name="table_padding" value="4" size="3">�A�C�X���n���� <input type="text" name="table_page_break" value="25" size="2"> �A�C�����L���D�G<input type="checkbox" name="table_page_title" value="1" checked> �O</td>
    </tr>
  </table>
  <table border="0">
  	<tr>
  		<td>
  			<input type="button" value="�L�X�W��" onclick="document.myform.target='_blank';document.myform.action='ct_print_user.php';document.myform.submit();">
  			<input type="button" style="color:#FF00FF" value="�^�W�@��" onclick="document.myform.target='';document.myform.action='<?php echo $_SERVER['PHP_SELF'];?>';document.myform.act.value='listone';document.myform.submit();">
  		</td>
  	</tr>
  </table>
  <table border="0" width="100%">
   <tr>
    <td>�����v�ɤw���W�W��G�@�p<?php echo $TEST['testuser_num'];?>�H</td>	
   </tr>
  </table>
  <?php

  list_user($_POST['option1'],$_POST['act']);

} // end if act=print_user

//�]�w�d��Ƥ����D�� =========================================================================
if ($_POST['act']=='search') {
	$_POST['item_total']=($_POST['item_total']=='' or $_POST['item_total']=='0')?100:$_POST['item_total'];
?>
 <input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme;?>">

  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D�]�w�d��Ƥ����D��</td>
  	</tr>
  </table>
  <?php
  $TEST=get_test_setup($_POST['option1']);
  title_simple($TEST);   
  ?>
  <hr>
  <table border="0" width="100%">
  	<tr>
  	  <td style="color:#800000">
  	  ���ثe�t�Τ��D�w�@�� <?php echo $TEST['search_itembank'];?> �D�A������ϥΪ��D������ <?php echo $TEST['search_ibgroup'];?> �D
  	  </td>
  	</tr>
  	<tr>
  		<td style="color:#0000FF">
  			�D���ؼСG<input type="text" name="item_total" value="<?php echo $_POST['item_total'];?>" style="color:#FF0000" size="5">�D &nbsp;&nbsp;
  			<input type="button" style="font-size:10pt;font-family:�s�ө���" value="�üƸɨ��D���`��" onclick="document.myform.act.value='get100';document.myform.submit();">
				<input type="button" style="font-size:10pt;font-family:�s�ө���" value="��ʤĿ��D��" onclick="document.myform.act.value='list_itembank_for_choice';document.myform.submit();">
  			<input type="button" style="font-size:10pt;font-family:�s�ө���" value="�M���D���Ҧ��D��" onclick="document.myform.act.value='clear100';document.myform.submit();">
   			<input type="button" style="color:#FF00FF;font-size:10pt;font-family:�s�ө���" value="��^�޲z����" onclick="document.myform.act.value='listone';document.myform.submit();">
  			<font color="#FF0000"><?php echo $INFO;?></font>
  		</td>
  	</tr>
  </table>
  <?php
   list_test_ibgroup($_POST['option1']);
   
} // end if act='search'


//�]�w�d��Ƥ����D�� =========================================================================
if ($_POST['act']=='list_itembank_for_choice') {
	$_POST['item_total']=($_POST['item_total']=='' or $_POST['item_total']=='0')?100:$_POST['item_total'];
?>
 <input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme;?>">

  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D��ʤĿ�d��Ƥ����D��</td>
  	</tr>
  </table>
  <?php
  $TEST=get_test_setup($_POST['option1']);
  title_simple($TEST);   
  ?>
  <hr>
  <table border="0" width="100%">
  	<tr>
  	  <td style="color:#800000">
  	  ���ثe�t�Τ��D�w�@�� <?php echo $TEST['search_itembank'];?> �D�A������ϥΪ��D������ <?php echo $TEST['search_ibgroup'];?> �D
  	  </td>
  	</tr>
  	<tr>
  		<td style="color:#0000FF">
  			<input type="button" style="font-size:10pt;font-family:�s�ө���" value="�x�s�Ŀ諸�D�ث����}" onclick="document.myform.act.value='save_choice';document.myform.submit();">
   			<input type="button" style="color:#FF00FF;font-size:10pt;font-family:�s�ө���" value="��^�W�@��" onclick="document.myform.act.value='search';document.myform.submit();">
  			<font color="#FF0000"><?php echo $INFO;?></font>
  		</td>
  	</tr>
  </table>
  <?php
   list_itembank_for_choice($_POST['option1']);
   
} // end if act='search_choice_itembank'





//�v�ɦW��޲z =======================================
if (@$_POST['act']=="edituser") {
  $TEST=get_test_setup($_POST['option1']);
  ?>
 <input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme;?>">
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D�v�ɳ��W�޲z</td>
  	</tr>
  </table>
  <?php
  title_simple($TEST);   
  ?>
  <hr>
 <table border="0" width="100%">
   <tr>
    <td align="left" width="250" colspan="2" style="color:#800000">��������w���W�H�Ʀ@�p <?php echo $TEST['testuser_num'];?> �H</td>
    <td align="left"><input type="button" value="�H�Z�Ŭ������W" onclick="document.myform.act.value='edituser_class';document.myform.submit();"></td>
   </tr>
   <tr>
    <td align="right" width="110">��J�Ǹ�</td>
    <td width="140"><input type="text" id="stud_id" name="stud_id" size="10" value="">=></td>
    <td align="left"><input type="button" value="�H�Ǹ����W1�H" onclick="if (document.myform.stud_id.value!='') { document.myform.act.value='edituser_add_by_stud_id';document.myform.submit(); }"></td>
   </tr>
   <tr>
    <td align="right" width="110">��J�Z�Ůy��</td>
    <td width="140"><input type="text" id="classnum" name="classnum" size="10" value="">=></td>
    <td align="left"><input type="button" value="�H�Z�Ůy�����W1�H" onclick="if (document.myform.classnum.value!='') { document.myform.act.value='edituser_add_by_classnum';document.myform.submit(); }">(�榡:�Z��+�y��,�p70101��@�~1�Z1��)</td>
   </tr>
   <tr>
    <td><input type="button" style="color:FF00FF" value="�^�W�@��" align="center" onclick="document.myform.act.value='listone';document.myform.submit();"></td>
    <td colspan="2" style="color:#FF0000"><?php echo $INFO;?></td>
   </tr>
 </table>
 <script>
 <?php
  if ($_POST['option2']=='edituser_add_by_stud_id') {
  	echo "document.myform.stud_id.focus();\n";
  	
  } elseif($_POST['option2']=='edituser_add_by_classnum') {
    echo "document.myform.classnum.focus();\n";
  }
 ?>
 $('input:text').bind("keydown", function(e) { 
    if (e.which == 13)  
    { //Enter key 
      e.preventDefault(); //Skip default behavior of the enter key 
      var thisID=$(this).attr("id");
      if (thisID=='stud_id') {
        if (document.myform.stud_id.value!='') { 
        	document.myform.act.value='edituser_add_by_stud_id';
        	document.myform.submit(); 
        }
      } 
      if (thisID=='classnum') {
      	if (document.myform.classnum.value!='') { 
      		document.myform.act.value='edituser_add_by_classnum';
      		document.myform.submit(); 
      	}
      }
      
    } 
  }); 
 </script>
	
<?php
  list_user($_POST['option1'],$_POST['act']);
} // end if act=edituser

//��Z���W
if ($_POST['act']=='edituser_class') {

  $TEST=get_test_setup($_POST['option1']);
  title_simple($TEST);   

?>
<hr>
���ФĿ�Z�Ŷi����Z���W (���v�ɤw���W�H�Ʀ@�p <?php echo $TEST['testuser_num'];?> �H)	
 <input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme;?>">
<table border="0" >
 <tr>	
 	<?php
	//�q school_class ��X�Z��, �̦~��
	$query="SELECT DISTINCT c_year FROM `school_class` WHERE year ='".curr_year()."' AND semester ='".curr_seme()."' order by c_year";
	$res_year=mysql_query($query);
	while ($row_year=mysql_fetch_array($res_year)) {
 	?>
 	<td>
 	<table border="1" style="border-collapse:collapse" bordercolor="#800000">
 		<tr bgcolor="#FFCCFF">
 	    <td>���W</td>
 	    <td>�Z��</td>
 		  <td>�H��</td>
 		</tr>
 	<?php
 	//�C�X�C�@�~�Ū��Z��
 		$query="select class_id,c_year,c_name,c_kind  from `school_class` where c_year='".$row_year['c_year']."' and  year ='".curr_year()."' AND semester ='".curr_seme()."' order by class_id";
 		$res_class=mysql_query($query);
 		while($row_class=mysql_fetch_array($res_class)) {
 			$c_year=$row_class['c_year'];
 			$c_name=$row_class['c_name'];
 			$seme_class=sprintf("%d%02d",substr($row_class['class_id'],6,2),substr($row_class['class_id'],9,2));
 			list($class_stud_num)=mysql_fetch_row(mysql_query("select count(*) from stud_seme a,stud_base b where a.student_sn=b.student_sn and b.stud_study_cond in (0,15) and a.seme_year_seme='$c_curr_seme' and a.seme_class='$seme_class'"));
 	   ?>
 	  <tr>
 	    <td style="font-size:10pt;color:" align="center"><input type="checkbox" name="class_id[]" value="<?php echo $row_class['class_id'];?>"></td>
 	    <td><?php echo $school_kind_name[$c_year]."".$c_name."�Z";?></td>
 		  <td><?php echo $class_stud_num;?>�H</td>
 		</tr>
 	   
 	   <?php
   	} // end while $row_class
  	?>
  </table>
  </td>
  <?php
  } // end while $row_year
?> 
 </tr>
</table>
<input type="button" value="���W�H�W�Ŀ�Z��" onclick="document.myform.act.value='edituser_class_add';document.myform.submit();">
<input type="button" value="�^�W�@��" onclick="document.myform.act.value='edituser';document.myform.submit();">
<br>�����G�w���W�W��ä��|���еn���D
<?php
}


//�s��խ�
if ($_POST['act']=='editgroup') {
?>
 <input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme;?>">
   <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">�D�s���v�ɲխ��W��</td>
  	</tr>
  </table>
  <?php
  //�v�ɸ��
  $TEST=get_test_setup($_POST['option1']);
  //�ժ����
  $Stud=get_contest_user($_POST['option1'],$_POST['option2']);
  
  title_simple($TEST);   

?>
  <hr>
  <table border="1" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="3">
    <tr>
   		<td style="font-size:10pt;color:#800000" width="80" align="center" bgcolor="#FFCCCC">�b��(�m�W)</td>
   		<td style="font-size:10pt;color:#800000" width="150" align="center"><?php echo $Stud['stud_id'];?>(<?php echo $Stud['stud_name'];?>)</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center" bgcolor="#FFCCCC">�Z�Ůy��</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center"><?php echo $Stud['seme_class'].sprintf('%02d',$Stud['seme_num']);?></td>
   	</tr>
   </table>
   <table border="0" width="100%">
   	<tr>
   		<td>���бq�U���Ŀ惡�ͪ��խ�...
   		<input type="button" value="��^" onclick="document.myform.act.value='edituser';document.myform.submit();"></td>
		</tr>
 </table>
  <table border="1" style="border-collapse: collapse" bordercolor="#C0C0C0" cellpadding="1">
   	<tr bgcolor="#FFFFCC">
   		<td style="font-size:10pt;color:#800000" width="50" align="center">�޲z</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center">�b��(�Ǹ�)</td>
   		<td style="font-size:10pt;color:#800000" width="60" align="center">�m�W</td>
   		<td style="font-size:10pt;color:#800000" width="40" align="center">�Z��</td>
   		<td style="font-size:10pt;color:#800000" width="40" align="center">�y��</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center">�n�J�K�X</td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center">�n�J����</td>
   		<td style="font-size:10pt;color:#800000" width="130" align="center">�̫�n�J</td>
   	</tr>	
  <?php
  //���X�W�� , �|���Q���w���խ��̩ά����H���խ�, �B�D���H
 	$query="select a.*,b.stud_id,b.stud_name,b.email_pass,c.seme_class,c.seme_num from contest_user a,stud_base b,stud_seme c,contest_setup d where a.student_sn=b.student_sn and a.student_sn=c.student_sn and a.tsn=d.tsn and d.year_seme=c.seme_year_seme and a.tsn='".$_POST['option1']."' and (a.ifgroup='' or a.ifgroup='".$_POST['option2']."') and a.student_sn!='".$_POST['option2']."' order by c.seme_class,c.seme_num";
  
  $result=mysql_query($query);
    while ($row=mysql_fetch_array($result,1)) {
     
     if (chk_ifgroup($TEST,$row['student_sn'])) { //�L�@���O�� , �B�����S���խ�(�D�ժ�)
    ?>
   	<tr bgcolor="#FFFFFF">
   		<td style="font-size:10pt;color:#800000" width="50" align="center"><input type="checkbox" name="ifgroup[]" value="<?php echo $row['student_sn'];?>"<?php if ($row['ifgroup']==$_POST['option2']) { echo "checked";}?>></td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center"><?php echo @$row['stud_id'];?></td>
   		<td style="font-size:10pt;color:#800000" width="60" align="center"><?php echo @$row['stud_name'];?></td>
   		<td style="font-size:10pt;color:#000000" align="center" width="40"><?php echo @$row['seme_class'];?></td>
   		<td style="font-size:10pt;color:#000000" align="center" width="40"><?php echo @$row['seme_num'];?></td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center"><?php echo @$row['email_pass'];?></td>
   		<td style="font-size:10pt;color:#800000" width="80" align="center"><?php echo @$row['logintimes'];?></td>
   		<td style="font-size:10pt;color:#800000" width="130" align="center"><?php echo @$row['lastlogin'];?></td>
   	</tr>	
 		<?php
 		 } // end if DEL==1
    } // end while
  ?>
   </table>
   <table width="100%" border="0">
   	<tr>
   		<td><input type="button" value="�e�X�]�w" onclick="document.myform.act.value='editgroup_update';document.myform.submit();"></td>
   	</tr>
  </form>
   </table>
<?php
} // end if editgroup

//�]�w���f
if ($_POST['act']=='judge') {
  $TEST=get_test_setup($_POST['option1']);
	  title_simple($TEST); 

 //¾�����O
 $title_kind_p = post_kind();
 list_judge_user($_POST['option1']);
?>
 <input type="hidden" name="c_curr_seme" value="<?php echo $c_curr_seme;?>">
 <table border="0" width="100%">
   <tr>
    <td>���ФĿ糧�v�ɪ����f�Ѯv...
     <input type="button" value="�e�X�Ŀ�W��" onclick="document.myform.act.value='judge_add';document.myform.submit()">	
     <input type="button" value="��^�W�@��" style="color:#FF00FF" onclick="document.myform.act.value='listone';document.myform.submit()">
    </td>
   </tr>
 </table>
 <table border="1" style="border-collapse:collapse" bordercolor="#600000" width="800">
 	 <tr>
 	 	<td>
 	 		<?php
 foreach ($title_kind_p as $kind=>$post_title) {
    //���X���, ���ư� contest_judge ���� teacher_sn
   $query="select a.teacher_sn,a.class_num,b.name from teacher_post a,teacher_base b where a.teacher_sn=b.teacher_sn and a.post_kind='$kind' and b.teach_condition=0 and a.teacher_sn not in (select teacher_sn from contest_judge_user where tsn='".$_POST['option1']."')";
   $query.=($post_title=='�ɮv')?" order by a.class_num":" order by b.name";
 
   ?>
   <table border="0" width="100%">
     <tr><td style="color:#0000FF">¾�O�G<?php echo $post_title;?></td></tr>
   </table>
   <table border="0" cellspacing="0" width="820">

   <?php
   
   $result=mysql_query($query);
   $i=0;
   while ($row=mysql_fetch_array($result,1)) {
   $i++;
   if ($i%10==1) echo "<tr>";
     $p=($post_title=='�ɮv')?$row['class_num'].$row['name']:$row['name'];
     ?>
     <td width="80" style="font-size:10pt"><input type="checkbox" name="judge_teacher[]" value="<?php echo $row['teacher_sn'];?>"><?php echo $p;?></td>
     
     <?php
   if ($i%10==0) echo "</tr>";  
   } // end while
   if ($i%10>0) {
    for ($j=$i%10;$j<10;$j++) { echo "<td width='80'>&nbsp;</td>"; }
    echo "</tr>";	
   }
   
   echo "</table>";
 } // end foreach
 ?>
			</td> 
		</tr>
  </table>
  <?php
} // end if act=judge

?>
</form>
<?php
foot();
?>

 <Script language="JavaScript">
   function check_test_form(ACT) {
   	//�v�ɤ����� sday+stime_hour+stime_min
   	var starttime=document.myform.sday.value+" "+document.myform.stime_hour.value+":"+document.myform.stime_min.value+":00";
   	starttime=starttime.replace(/-/g, "/"); 
   	starttime=(Date.parse(starttime)).valueOf() ; // �����ഫ��Date���O�ҥN����
   	var endtime=document.myform.eday.value+" "+document.myform.etime_hour.value+":"+document.myform.etime_min.value+":00";
   	endtime=endtime.replace(/-/g, "/"); 
   	endtime=(Date.parse(endtime)).valueOf() ; // �����ഫ��Date���O�ҥN����
    if (starttime>=endtime) {
     alert ("�v�ɵ����ɶ����o����ε���}�l�ɶ�!");
     return false;
    }	
   	
    if (document.myform.title.value=='') {
    	alert("�п�J�v�ɼ��D!");
    	document.myform.title.focus();
    	return false;
    } else if (document.myform.qtext.value=='' && document.myform.active.value>1 ) {
    	alert("�п�J�v���D�ءA�D�ئb�v�ɶ}�l��~�|���G���n�J�ǥͬݨ�!");
    	document.myform.qtext.focus();
      return false;
    } else if (document.myform.active.value==0) {
    	alert("�п���v�����O!");
    	document.myform.active.focus();
      return false;
    } else {
    	document.myform.act.value=ACT;
    	document.myform.submit();
    } // end if
   }
   
   function automemo() { 
   	var strMEMO = new Array();  
    strMEMO[1]="<?php echo $PHP_MEMO[1];?>";
    strMEMO[2]="<?php echo $PHP_MEMO[2];?>";
    strMEMO[3]="<?php echo $PHP_MEMO[3];?>";
    strMEMO[4]="<?php echo $PHP_MEMO[4];?>";
    
    var intN=document.myform.active.value;

    document.myform.memo.value=strMEMO[intN];
    
   }
 
</Script>

  </Script>

