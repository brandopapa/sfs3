<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();


//�q�X����
head("���������v�� - �̷s����");


?>
<script type="text/javascript" src="./include/tr_functions.js"></script>
<script type="text/javascript" src="../../javascripts/JSCal2-1.9/src/js/jscal2.js"></script>
<script type="text/javascript" src="../../javascripts/JSCal2-1.9/src/js/lang/b5.js"></script>
<link type="text/css" rel="stylesheet" href="../../javascripts/JSCal2-1.9/src/css/jscal2.css">

<script src='include/mupload/jquery.MultiFile.js' type="text/javascript" language="javascript"></script>

<?php



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

//POST �e�X��,�D�{���ާ@�}�l 
//�s�W����
if ($_POST['act']=='inserting') {
 //��Ƥ��e
 	$title=$_POST['title'];
	$sttime=$_POST['sday']." ".$_POST['stime_hour'].":".$_POST['stime_min'].":00";
	$endtime=$_POST['eday']." ".$_POST['etime_hour'].":".$_POST['etime_min'].":00";
	$memo=$_POST['memo'];
	$htmlcode=$_POST['htmlcode'];

  $query="insert into contest_news (title,sttime,endtime,memo,updatetime,htmlcode) values ('$title','$sttime','$endtime','$memo','".date('Y-m-d H:i:s')."','$htmlcode')";
  if (!mysql_query($query)) {
   echo "query=".$query;
  }
    
  //���^�̫᪺ auto_increat ��ID��
  list($nsn)=mysql_fetch_row(mysql_query("SELECT LAST_INSERT_ID()"));

  //�B�z�ɮפW��
  news_files($nsn);
  
  $_POST['act']='';
  
} // end if inserting

if ($_POST['act']=='updating') {
 //��Ƥ��e
  
  $nsn=$_POST['option1'];
 
 	$title=$_POST['title'];
	$sttime=$_POST['sday']." ".$_POST['stime_hour'].":".$_POST['stime_min'].":00";
	$endtime=$_POST['eday']." ".$_POST['etime_hour'].":".$_POST['etime_min'].":00";
	$memo=$_POST['memo'];
	$htmlcode=$_POST['htmlcode'];

  $query="update contest_news set title='$title',sttime='$sttime',endtime='$endtime',memo='$memo',updatetime='".date('Y-m-d H:i:s')."',htmlcode='$htmlcode' where nsn='$nsn'";
  if (!mysql_query($query)) {
   echo "query=".$query;
  }
    
  //�B�z�ɮפW��
  news_files($nsn);
  
  $_POST['act']=$_POST['RETURN'];
  
} // end if updating

//�R������
if ($_POST['act']=='del') {
 	
 	$query="delete from contest_news where nsn='".$_POST['option1']."'";
 	mysql_query($query);
 	
 	$query="select * from contest_files where nsn='".$_POST['option1']."'";
 	$res=mysql_query($query);
 	while ($row=mysql_fetch_array($res,1)) {
 	 unlink ($UPLOAD_P[0].$row['filename']);
 	}
 	
 	$query="delete from contest_files where nsn='".$_POST['option1']."'";
 	mysql_query($query);

  //��^���e���A
 	$_POST['act']=$_POST['RETURN'];
	  
} // end if del

//�R�����������ɮ�
if ($_POST['act']=='del_file') {
 	
 	$query="select * from contest_files where fsn='".$_POST['option2']."'";
 	$res=mysql_query($query);
 	$row=mysql_fetch_array($res,1);
 	unlink ($UPLOAD_P[0].$row['filename']);
 	
 	$query="delete from contest_files where fsn='".$_POST['option2']."'";
 	mysql_query($query);

  //��^���e���A
 	$_POST['act']='update';
	  
} // end if del_file


//�ɭ��e�{�}�l, �����]�b <form>�� , act�ʧ@ , option1, option2 �Ѽ�2��
?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
 <input type="hidden" name="act" value="<?php echo $_POST['act'];?>">
 <input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">
 <input type="hidden" name="option2" value="<?php echo $_POST['option2'];?>">
 <input type="hidden" name="RETURN" value="<?php echo $_POST['act'];?>">
 
<table border="0" width="100%">
 <tr>
  <td>
  	<input type="button" value="�Ҧ�����" onclick="document.myform.act.value='all';document.myform.submit()">
<?php
if ($MANAGER and ($_POST['act']=='' or $_POST['act']=='all')) {

//����W�ǥؿ��O�_�s�b, ���s�b�۰ʫإ�
if (!file_exists($UPLOAD_NEWS_PATH)) {
	if (!file_exists($UPLOAD_BASE)) {
		mkdir($UPLOAD_BASE,0777);
	}
    mkdir(substr($UPLOAD_NEWS_PATH,0,strlen($UPLOAD_NEWS_PATH)-1),0777);
}

?>

    <input type="button" value="�s�W����" onclick="document.myform.act.value='insert';document.myform.submit();">

<?php
} //end if MANAGER
?>
  </td>
 </tr>
</table>
<?php
//�s�W���� ===========================================================================
if ($_POST['act']=='insert') {
 ?>
<div style="width:100%" align="center">
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF" align="center">�s�W�̷s����</td>
  	</tr>
  </table>
  <?php
  $news['nsn']='';
  $news['title']='';
  $news['memo']='';
  $news['sttime']=date("Y-m-d H:i:00");
  $news['endtime']=date("Y-m-d H:i:00");
  $news['htmlcode']=0;
  $mode="inserting";
  form_news($news); //�ǤJ�w�]��,�C�X���
  ?>
 <table border="0" width="100%">
 	<tr>
  		<td>&nbsp;</td>
  		<td style="font-size:10pt;color:#FF0000">
  		 <input type="button" value="�e�X���" onclick="check_form('inserting')">  		 	
  		 <input type="reset" value="�M�����g">
  		 <input type="button" style="color:#FF00FF" value="���" onclick="document.myform.act.value='<?php echo $_POST['RETURN'];?>';document.myform.submit();">
  		</td>
  	</tr>
 	  </form>
  </table>

</div>
<?php
} // end if _POST['mode']=='insert'

//�s�׮��� ===========================================================================
if ($_POST['act']=='update') {
 ?>
<div style="width:100%" align="center">
  <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF" align="center">�s�׮���</td>
  	</tr>
  </table>
  <?php
  $query="select * from contest_news where nsn='".$_POST['option1']."'";
  $res=mysql_query($query);
  $news=mysql_fetch_array($res);
  
  form_news($news); //�ǤJ, �C�X���
  
  ?>
 <table border="0" width="100%">
 	<tr>
  		<td>&nbsp;</td>
  		<td style="font-size:10pt;color:#FF0000">
  		 <input type="button" value="�e�X���" onclick="check_form('updating');">  		 	
  		 <input type="reset" value="�^�Э��g">
  		 <input type="button" style="color:#FF00FF" value="���" onclick="document.myform.act.value='<?php echo $_POST['RETURN'];?>';document.myform.submit();">
  		</td>
  	</tr>
 	  </form>
  </table>

</div>
<?php
} // end if _POST['mode']=='update'



//�L����Ѽ�, �C�X���� ===========================================================================
if ($_POST['act']=='' or $_POST['act']=='all') {
?>
<div style="width:100%" align="center">
 <table border="0" width="100%" cellpadding="5">
   	<?php
   	 $query=($_POST['act']=='')?"select * from contest_news where sttime<='$Now' and endtime>'$Now' order by updatetime desc":"select * from contest_news order by updatetime desc";;
   	 $result=mysql_query($query);
   	 if (mysql_num_rows($result)) {
   	  while ($NEW=mysql_fetch_array($result)) {
   	   echo "<tr><td>";	
   	 	 shownews($NEW);
   	 	 echo "</td></tr>";
   	  }
     } else {
     ?>
      <tr>
      	<td>�����L�̷s����</td>
      </tr>
     <?php	
     }// end if 
   	?>
</table>
</div>
<?php
} // end if $_POST['mode']==''
?>

</form>
<?php

foot();

?>

<Script language="JavaScript">
	<?php
  	if ($_POST['act']=='insert' or $_POST['act']=='update') { echo "document.myform.title.focus();"; }
   ?>
 function check_form(ACT) {
   var chk_err=0;
    //������ sday+stime_hour+stime_min
   	var starttime=document.myform.sday.value+" "+document.myform.stime_hour.value+":"+document.myform.stime_min.value+":00";
   	starttime=starttime.replace(/-/g, "/"); 
   	starttime=(Date.parse(starttime)).valueOf() ; // �����ഫ��Date���O�ҥN����
   	var endtime=document.myform.eday.value+" "+document.myform.etime_hour.value+":"+document.myform.etime_min.value+":00";
   	endtime=endtime.replace(/-/g, "/"); 
   	endtime=(Date.parse(endtime)).valueOf() ; // �����ഫ��Date���O�ҥN����
    if (starttime>=endtime) {
     alert ("�����ɶ����o����ε���}�l�ɶ�!");
     chk_err=1;
     return false;
    }	
  	
    if (document.myform.title.value=='') {
    	alert("�п�J���D!");
    	document.myform.title.focus();
    	chk_err=1;
    	return false;
    }  
    if (document.myform.memo.value=='') {
    	alert("�п�J�������e!");
    	document.myform.memo.focus();
      chk_err=1;
      return false;
    } // end if
    
     if (chk_err==0) {
     	 document.myform.RETURN.value='<?php echo $_POST['RETURN'];?>';
     	 document.myform.act.value=ACT;
			 document.myform.submit();
     }
   }
</Script> 
