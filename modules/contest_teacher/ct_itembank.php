<?php

// $Id: reward_one.php 6735 2012-04-06 08:14:54Z smallduh $

//���o�]�w��
include_once "config.php";

sfs_check();

//�q�X����
head("���������v�� - �޲z�d��Ƥ����D�w");

?>
<script type="text/javascript" src="./include/tr_functions.js"></script>

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

if (!$MANAGER) {
 echo "<font color=red>��p! �A�S���޲z�v��, �t�θT��A�~��ާ@���\��!!!</font>";
 exit();
}

//POST �e�X��,�D�{���ާ@�}�l 
//�s�W�@�D
if ($_POST['act']=='inserting') {

$question=$_POST['question'];
$ans=$_POST['ans'];
$ans_url=$_POST['ans_url'];

$ibsn="i".date("y").date("m").date("d").date("H").date("i").date("s");

//���եN�X�O�_����
	do {
	 $a=floor(rand(10,99));
	 $ibsn_test=$ibsn.$a;
	 $query="select count(*) as num from contest_itembank where ibsn='".$ibsn_test."'";
	 $res=mysql_query($query);
	 list($exist)=mysql_fetch_row($res);
	} while ($exist>0);

	$ibsn=$ibsn_test;
	
//�s�J
	$query="insert into contest_itembank (ibsn,question,ans,ans_url) values ('$ibsn','$question','$ans','$ans_url')";
  if (mysql_query($query)) {
  	//�p��n���n�����X
  	list($ALL)=mysql_fetch_row(mysql_query("select count(*) as num from itembank"));
   	$_POST['option2']=ceil($ALL/$PHP_PAGE); //�L����i��
   	$_POST['act']='';
  }else{
   echo "Error! query=".$query;
   exit();
  }
}// end if inserting

//�ֶK�B�z���
if ($_POST['act']=='pasting') {
 	$data_arr=explode("\n",$_POST['items']);
  foreach ($data_arr as $ITEM) {
    $I[0]=$I[1]=$I[2]="";
    $I=explode("\t",$ITEM);
    $question=trim($I[0]);
		$ans=trim($I[1]);
		$ans_url=trim($I[2]);
    
    if ($question!="" and $ans!="") {
		
		//���եN�X�O�_����
		do {
			$ibsn="i".date("y").date("m").date("d").date("H").date("i").date("s");
	 		$a=floor(rand(10,99));
	 		$ibsn_test=$ibsn.$a;
	 		$query="select count(*) as num from contest_itembank where ibsn='".$ibsn_test."'";
	 		$res=mysql_query($query);
	 		list($exist)=mysql_fetch_row($res);
		} while ($exist>0);

		$ibsn=$ibsn_test;
	
		//�s�J
		$query="insert into contest_itembank (ibsn,question,ans,ans_url) values ('$ibsn','$question','$ans','$ans_url')";
  	mysql_query($query);
    } // end if question!='' and $ans!=''
  } // end foreach

  	//�p��n���n�����X
  	list($ALL)=mysql_fetch_row(mysql_query("select count(*) as num from itembank"));
   	$_POST['option2']=ceil($ALL/$PHP_PAGE); //�L����i��
   	$_POST['act']='';
  
} // end if pasting


//�ק�@�D
if ($_POST['act']=='updating') {
  $ibsn=$_POST['option1'];
	$query="update contest_itembank set question='".$_POST['question']."',ans='".$_POST['ans']."',ans_url='".$_POST['ans_url']."' where ibsn='".$ibsn."'";
  if (mysql_query($query)) {
  	//��s�D�������ѵ�
  	$query="update contest_ibgroup set question='".$_POST['question']."',ans='".$_POST['ans']."',ans_url='".$_POST['ans_url']."' where ibsn='".$ibsn."'";
  	mysql_query($query);
   $_POST['act']='';
  }else{
   echo "Error! query=".$query;
   exit();
  }
}// end if updating

//�R���@�D
if ($_POST['act']=='delete') {
  $ibsn=$_POST['option1'];
	$query="delete from contest_itembank where ibsn='".$ibsn."'";
  if (mysql_query($query)) {
  	mysql_query("optimize table contest_itembank");
    mysql_query("alter table contest_itembank drop id");
    mysql_query("alter table contest_itembank add id int(5) auto_increment not null primary key first");
    $_POST['act']='';
  }else{
   echo "Error! query=".$query;
   exit();
  }
}// end if delete

//���R��
if ($_POST['act']=='delete_tag') {
  foreach ($_POST['tag_it'] as $ibsn) { 
	 $query="delete from contest_itembank where ibsn='".$ibsn."'";
   mysql_query($query);
  }
  	mysql_query("optimize table contest_itembank");
    mysql_query("alter table contest_itembank drop id");
    mysql_query("alter table contest_itembank add id int(5) auto_increment not null primary key first");
    $_POST['act']='';
}// end if delete




//�ɭ��e�{�}�l, �����]�b <form>�� , act�ʧ@ , option1, option2 �Ѽ�2�� , return�O�U��^����
?>
<form method="post" name="myform" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
 <input type="hidden" name="act" value="<?php echo $_POST['act'];?>">
 <input type="hidden" name="option1" value="<?php echo $_POST['option1'];?>">
 <input type="hidden" name="option2" value="<?php echo $_POST['option2'];?>">
 <input type="hidden" name="RETURN" value="<?php echo $_POST['return'];?>">
<?php
//�w�]���s�W��� + �D�w�C��
if ($_POST['act']=='') {
	$IB['question']='';
	$IB['ans']='';
	$PAGE=($_POST['option2']=='')?1:$_POST['option2'];
?>

 <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">���s�W�D�w���D</td>
  	</tr>
  </table>
		<input type="hidden" name="ibsn" value="<?php echo $ibsn;?>">
  <?php
  @form_additem($ib);
  ?>
  <table border="0" width="100%">
  	<tr>
  		<td>
  		 <input type="button" value="�s�W�@�D" onclick="checkdata('inserting');">  		 	
  		 <input type="reset" value="���g">
  		 <input type="button" value="�ϥΧֶK�j�q�s�W" onclick="document.myform.act.value='paste';document.myform.submit();">
  		</td>
  	</tr>
  </table>
  <hr>
   <table border="0" width="100%">
  	<tr>
  		<td style="color:#800000">�D�D�w���D�C�� (�`�D�ơG<?php echo mysql_num_rows(mysql_query("select id from contest_itembank"));?>�D) <input type="button" value="�R���Ŀ���D" onclick="document.myform.act.value='delete_tag';document.myform.submit();">
  			</td>
  	</tr>
  </table>
  <?php
   listitembank($PAGE);

} // end if insert

//�ק���D
if ($_POST['act']=='update') {
	$IB=get_item($_POST['option1']);
	
?>

 <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">���s���D�w���D</td>
  	</tr>
  </table>
		<input type="hidden" name="ibsn" value="<?php echo $IB['ibsn'];?>">
  <?php
  @form_additem($IB);
  ?>
  <table border="0" width="100%">
  	<tr>
  		<td>
  		 <input type="button" value="�T�w�ק�" onclick="checkdata('updating');">  		 	
  		 <input type="reset" value="���g">
  		</td>
  	</tr>
  </table>
<?php
} // end if insert


if ($_POST['act']=='paste') {
?>	
 <table border="0" width="100%">
  	<tr>
  		<td style="color:#0000FF">���s���D�w���D - �� Excel �ֶK</td>
  	</tr>
 </table>
 <table border="0" width="100%">
   <tr>
    <td>
     <textarea cols="80" rows="10" name="items"></textarea>
    </td>
   </tr>
 </table> 
 <input type="button" value="�e�X" onclick="document.myform.act.value='pasting';document.myform.submit();">	
 <input type="button" value="�^�W�@��" style="color:#FF00FF" onclick="document.myform.act.value='';document.myform.submit();">
 <table border="0" width="100%">
  <tr>
    <td>�Ш̤U�ϩҥ�, �����}�� Excel �D�w��, �M���ܡu�D�ءv�B�u�Ѧҵ��סv�B�u�ѦҺ��}�v�T�ӳ���(���n�]�A�Ĥ@�檺���D), �ƻs��A�K��W���϶���, ���U�u�e�X�v�Y�i.</td>
  </tr>
  <tr>
    <td><img src="./images/item_paste.jpg" border="0"></td>
  </tr>
 </table>
<?php
}


 	?>
 	
</form>
<?php
foot();

?>
<Script Language="JavaScript">
	<?php
	if ($_POST['act']=='' or $_POST['act']=='update') {
		?>
   document.myform.question.focus();
  <?php
  }
  ?>
  function checkdata(VAL) {
    if (document.myform.question.value=='' || document.myform.ans.value=='') {
    	alert("��J�����e������!");
    	return false;
    } else {
    	document.myform.act.value=VAL;
      document.myform.submit();
    }
  } // end function;
  
  function del_itembank(IBSN) {
   Y=confirm('�z�T�w�n�R�����D?');
   
   if (Y) {
    document.myform.option1.value=IBSN;
    document.myform.act.value='delete';
    document.myform.submit();
   } else {
     return false;
   } // end if    
  } // end function
  
  function page(PAGE) {
   document.myform.option2.value=PAGE;
   document.myform.submit();
  }
  
  
  //���S�w�ؼ�, ����Υ�����
	function tag_all(SOURCE,STR) {
	var j=0;
	while (j < document.myform.elements.length)  {
	 if (document.myform.elements[j].name==SOURCE) {
	  if (document.myform.elements[j].checked) {
	   k=1;
	  } else {
	   k=0;
	  }	
	 }
	 	j++;
	}
	
  var i =0;
  while (i < document.myform.elements.length)  {
    if (document.myform.elements[i].name.substr(0,STR.length)==STR) {
      document.myform.elements[i].checked=k;
    }
    i++;
  }
 } // end function
    	
</Script>
