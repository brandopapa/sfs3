<?php
header('Content-type: text/html; charset=utf-8');
include_once ('config.php');
include_once ('my_functions.php');

ini_set('max_execution_time', 0); //?��?��?��?????


if (!isset($_SESSION['MSN_LOGIN_ID'])) {
  echo "<Script language=\"JavaScript\">window.close();</Script>";
	exit();
}


//?��???��??? *******************************************************
if ($_GET['act']=='post') {

//??�???師�?�?
$query="select teacher_sn from teacher_base where teach_id='".$_SESSION['MSN_LOGIN_ID']."'";
$result=mysql_query($query);
list($teacher_sn)=mysql_fetch_row($result);
$query="select post_kind from teacher_post where teacher_sn='".$teacher_sn."'";
$result=mysql_query($query);
list($POST_KIND)=mysql_fetch_row($result);

$m_to=(isset($_GET['set']))?$_GET['set']:"";

?>
<html>
<head>
<title>?��??�???</title>
<style>
A:link {font-size:9pt;color:#ff0000; text-decoration: none}
A:visited {font-size:9pt;color: #ff0000; text-decoration: none;}
A:hover {font-size:9pt;color: #ffff00; text-decoration: underline}
td {font-size:10pt}
</style>

<script src="./include/jquery.js" type="text/javascript"></script>
<script src='./include/jquery.MultiFile.js' type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="../../javascripts/JSCal2-1.9/src/js/jscal2.js"></script>
<script type="text/javascript" src="../../javascripts/JSCal2-1.9/src/js/lang/b5.js"></script>
<link type="text/css" rel="stylesheet" href="../../javascripts/JSCal2-1.9/src/css/jscal2.css">

<script language="javascript">
function choice()
{
	if (document.form1.m_to.value=='') {
    document.form1.m_to.value=document.form1.set.value;
  }else{
    document.form1.m_to.value=document.form1.m_to.value+";"+document.form1.set.value;
  }
}

function b_submit() {
	
	var save=1;
	 
	if (document.form1.msg.value=='') {
	  alert('?��???輸�?��?�容!!');
	  document.form1.msg.focus();
	  save=0;
    return false;
	}
	 
	 
	//�?人�???
	if (document.form1.option1.value==1) {
	  if (document.form1.m_to.value=='') {
  		alert('�???輸�?��??��?��?��?象�??帳�??�?');
  		document.form1.m_to.focus();
    	save=0;
    	return false;	    
	  }	
	}


	//?��???
	if (document.form1.option1.value==3) {
	  if (document.form1.stdate.value=='') {
  		alert('�???輸�?�起�??��??�?');
    	save=0;
    	return false;	    
	  }	
	  if (document.form1.enddate.value=='') {
  		alert('�???輸�?��????��??�?');
    	save=0;
    	return false;	    
	  }	
	  if (document.form1.delay_sec.value=='' || document.form1.delay_sec.value>300 || document.form1.delay_sec<5) {
  		alert('�?輸�?��?示�??��? ( 5�?~300�?�??? )');
    	save=0;
    	return false;	    
	  }	
	  if (document.form1.pic_file.value=='') {
  		alert('�????��??�?�?�?');
    	save=0;
    	return false;	    
	  }	

	}
 //確�?�????��??輸�??
 if (save) {	
	wait_post.style.display="none";
  wait.style.display="block";
  document.form1.act.value='save';
  document.form1.submit();
 }
    
} // end function

</script>
</head>
<body bgcolor="#FFFFFF">

<div align="center">
  <center>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="option1" value="0">

  <font color="#FF0000">?��??�???</font>

  <table border="1" cellpadding="3" cellspacing="0" width="100%" bordercolorlight="#800000" bordercolordark="#FFFFFF" bordercolor="#FFFFFF">
		<tr>
			<td bgColor="#ffffcc" width="60" style="font-size: 10pt">�??��???</td>
			<td bgColor="#CCFFCC" style="font-size: 10pt">
			<input value="0" type="radio" name="data_kind" onclick="chkpublic();">?��?? 
			<input value="1" CHECKED type="radio" name="data_kind" onclick="chkprivate();">�?�? 
			<?php
			 if ($POST_KIND<6) {
			 ?>
			<input value="2" type="radio" name="data_kind" onclick="chkfileshare();">�?�???�?
			<input value="3" type="radio" name="data_kind" onclick="chkpic();" ><font color=#FF0000>?��?????(??)</font> 
			<?php
		   } // end if
			?>
			</td>
		</tr>
		<tr id="Myfolder" style="display:none">
			<td bgColor="#ffffcc" width="60" style="font-size: 10pt">�?�?�???</td>
			<td bgColor="#CCFFCC" style="font-size: 10pt">
				<select size="1" name="folder">
				<?php
				mysql_query("set names 'utf8';");
				$query="select * from sc_msn_folder where open_upload=1 order by foldername";
				$result=mysql_query($query);
				while ($row=mysql_fetch_array($result)) {
	       ?>
	       <option value="<?php echo $row['idnumber'];?>"><?php echo $row['foldername'];?></option>
	       <?php			 
				}
				?>
			</select>
			</td>
		</tr>

		<tr id="Myprivate" style="display:block">
			<td bgColor="#ffffcc" width="60" style="font-size: 10pt">?��?��?�?</td>
			<td bgColor="#CCFFCC" style="font-size: 10pt">
			<input tabIndex="1" type="text" name="m_to" value="<?php echo $m_to;?>">
			
			<input type="button" style="font-size:10px" value="?��?�帳??" onclick="OpenTeacherID()" title="???�帳??">
			??
			<img style="cursor:pointer" border="1" width="16" height="16" src="./images/online.jpg" onclick="window.location='main_online.php'" title="?��?�???表�?��??">
			</td>
		</tr>
		<tr id="Mypublic" style="display:block">
			<td bgColor="#ffffcc" width="60" style="font-size: 10pt">
			�?示�????</td>
			<td bgColor="#CCFFCC" style="font-size: 10pt">
			<input value="3" type="radio" name="lasttime">3�? 
			<input value="5" type="radio" name="lasttime">5�? 
			<input value="7" type="radio" name="lasttime" CHECKED>7�?
			<input value="10" type="radio" name="lasttime">10�? 
			<input value="14" type="radio" name="lasttime">14�? 
			<input value="30" type="radio" name="lasttime">30�?</td> 
		</tr>
		<tr>
			<td bgColor="#ffffcc" width="60" style="font-size: 10pt">
			�??��?�容</td>
			<td bgColor="#ccffcc" style="font-size: 10pt">
			<textarea tabIndex="2" rows="6" cols="36" name="msg"></textarea> 
			</td>
			
		</tr>

		<tr id="Myfile" style="display:block">
			<td style="font-size: 10pt" bgColor="#ffffcc">
			????�?�?</td>
		
			<td bgColor="#ccffcc" style="font-size: 10pt">
				<table border="0" width="100%">
					<tr>
						<td><input type="file" class="multi" name="thefile[]"></td>
						<td align="left"><input type="button" value="???�此�?" name="B1"></td>
					</tr>
				</table>		
			</td>
		</tr>
  	<tr id="M_public" style="display:none">
			<td style="font-size: 10pt" bgColor="#ffffcc">說�??</td>
			<td bgColor="#ccffcc" style="font-size: 10pt;color:#FF0000">
				1.此�?��??�??��???��???��??MSN???????��?��??�交�???�?�?中�?以�?��???��?��???��????��??<br>
				2.?��?��?��?�IP???��?��?��?��??�?此�??��?�?�????��?��????��?��???�????��?��???��??�?????�??��??<br>
		</tr>
  	<tr id="M_private" style="display:block">
			<td style="font-size: 10pt" bgColor="#ffffcc">說�??</td>
			<td bgColor="#ccffcc" style="font-size: 10pt;color:#0000FF">
				1.?��?�以?��??�?人�??�給?��?��?????��??�?�??��??�??��?��?��??MSN?��?��?��?��?��??��??<br>
				2.?��????�??��?�以夾帶�?�?�?�?�??��??夾帶�?�??��?填寫�??��?�容�???以建議�?��??��?�容中填?��?�???說�????<br>
				3.??�?大�??��???<font color=red><?php echo $MAX_MB;?>MB</font></br>
				4.注�??! ?��??��??�???<font color=red><b><?php echo $PRESERVE_DAYS;?></b></font>�?!
			</td>
		</tr>
  	<tr id="M_fileshare" class="display:none">
			<td style="font-size: 10pt" bgColor="#ffffcc">說�??</td>
			<td bgColor="#ccffcc" style="font-size: 10pt;color:#FF00FF">
				1.�???�??��???��?��??�?�?�???, 以便?��?人�?�???容�???��?��?�???<br>
				2.?��????夾帶�???�?�?, �???�?�?大�?�??��???<font color=red><?php echo $MAX_MB;?>MB</font>??<br>
				3.�?示�?????��???��??��??�?�?中�?��??幾天, �?示�????�?�??��?��?�?�?�????�中�?�??��?�?.
			</td>
		</tr>	
  	<tr id="M_pic_sttime" style="display:none">
			<td style="font-size: 10pt" bgColor="#ffffcc">??�??��??</td>
			<td bgColor="#ccffcc" style="font-size: 10pt;color:#0000FF"><input type="text" id="stdate" name="stdate" value="<?php echo date("Y-m-d");?>" size="10"></td>
					<script type="text/javascript">
					new Calendar({
  		    	inputField: "stdate",
   		    	dateFormat: "%Y-%m-%d",
    	    	trigger: "stdate",
    	    	bottomBar: true,
    	    	weekNumbers: false,
    	    	showTime: 24,
    	    	onSelect: function() {this.hide();}
		    	});
					</script>
		</tr>
  	<tr id="M_pic_endtime" style="display:none">
			<td style="font-size: 10pt" bgColor="#ffffcc">�????��??</td>
			<td bgColor="#ccffcc" style="font-size: 10pt;color:#0000FF"><input type="text" id="enddate" name="enddate" value="<?php echo date("Y-m-d");?>" size="10"></td>
					<script type="text/javascript">
					new Calendar({
  		    	inputField: "enddate",
   		    	dateFormat: "%Y-%m-%d",
    	    	trigger: "enddate",
    	    	bottomBar: true,
    	    	weekNumbers: false,
    	    	showTime: 24,
    	    	onSelect: function() {this.hide();}
		    	});
					</script>		</tr>
  	<tr id="M_pic_delay" style="display:none">
			<td style="font-size: 10pt" bgColor="#ffffcc">延�?��???</td>
			<td bgColor="#ccffcc" style="font-size: 10pt;color:#0000FF"><input type="text" name="delay_sec" value="5" size="2">�?</td>
		</tr>
		<tr id="M_pic_file" style="display:none">
			<td style="font-size: 10pt" bgColor="#ffffcc">
			????�?�?
		  </td>
			<td>
			 <input type="file" name="pic_file">
			</td>
		</tr>
		
  	<tr id="M_pic" style="display:none">
			<td style="font-size: 10pt" bgColor="#ffffcc">說�??</td>
			<td bgColor="#ccffcc" style="font-size: 10pt;color:#0000FF">
				1.??�?說�??, �??��??簡�??<br>
				2.?��?��??? jpg/png/gif/swf/wmv ??種�?�?�?�?�?�?�?�?大�??��???<font color=red><?php echo $MAX_MB;?>MB</font></br>
				3.�?示�??�???系統�??��???��?��?�?�?�??��?�?????�?�?�???
			</td>
		</tr>
  </table>
  <table border="0">
   <tr id="wait" style="display:none;color:#FF0000">
    <td><br>�???????�?, �?�???...</td>
   </tr>
  </table>
  <table border="0" width="100%" bgcolor="#FFFFFF">
    <tr id="wait_post"> 
     <td colspan="2" align="right">
       <input type="button" onclick="b_submit()" value="????" name="B1">&nbsp;<input type="button" value="????" name="B2" onclick="window.close()">
      </td>
    </tr>
  </table>
 </form>
  </center>
</div>

</body>
</html>
<script language="javascript">
document.form1.m_to.focus();
chkprivate();

function OpenTeacherID() {
 dialogID=window.open('main_teachers_id.php?form_name=form1&item_name=m_to&selected_text=document.form1.m_to.value','test','toolbar=no,left=0,top=0,screenX=0,screenY=0,height=400,width=740,resizable=1,scrollbars');
 if(window.dialogID) dialogID.focus();
}

function chkprivate() {
  Myprivate.style.display="block";
  Myfolder.style.display="none";
  Myfile.style.display="block";
  Mypublic.style.display="none";
  M_public.style.display="none";
  M_private.style.display="block";
  M_fileshare.style.display="none";
  
  M_pic_sttime.style.display="none";
  M_pic_endtime.style.display="none";
  M_pic_delay.style.display="none";
  M_pic_file.style.display="none";
  M_pic.style.display="none";

 document.form1.option1.value="1";
}

//?��??�???
function chkpublic() {
  Mypublic.style.display="block";
  Myprivate.style.display="none";
  Myfolder.style.display="none";
  Myfile.style.display="none";
  M_public.style.display="block";
  M_private.style.display="none";
  M_fileshare.style.display="none";
  
  M_pic_sttime.style.display="none";
  M_pic_endtime.style.display="none";
  M_pic_delay.style.display="none";
  M_pic_file.style.display="none";
  M_pic.style.display="none";
  
  document.form1.option1.value="0";
}

//�?�???�?
function chkfileshare() {
  Mypublic.style.display="block";
  Myprivate.style.display="none";
  Myfolder.style.display="block";
  Myfile.style.display="block";
  M_public.style.display="none";
  M_private.style.display="none";
  M_fileshare.style.display="block"; 
  
  M_pic_sttime.style.display="none";
  M_pic_endtime.style.display="none";
  M_pic_delay.style.display="none";
  M_pic_file.style.display="none";
  M_pic.style.display="none";
  
  document.form1.option1.value="2";
}

function chkpic() {
  Mypublic.style.display="none";
  Myprivate.style.display="none";
  Myfolder.style.display="none";
  Myfile.style.display="none";
  M_public.style.display="none";
  M_private.style.display="none";  
  M_fileshare.style.display="none";
  
  M_pic_sttime.style.display="block";
  M_pic_endtime.style.display="block";
  M_pic_delay.style.display="block";
  M_pic_file.style.display="block";
  M_pic.style.display="block";  
   document.form1.option1.value="3";
}

</script>
<?php
} // end if act=='post' ******************************************

if ($_GET['act']=='read') {
 //�? UTF8 ?��???�?
 mysql_query("SET NAMES 'utf8'");
/*	
 if ($_GET['set']=="") {
   $query="select id,idnumber,teach_id,post_date,data_kind,data,relay from sc_msn_data where to_id='".$_SESSION['MSN_LOGIN_ID']."' and ifread=0 order by post_date limit 0,1";
  } else {
    $query="select id,idnumber,teach_id,post_date,data_kind,data,relay from sc_msn_data where to_id='".$_SESSION['MSN_LOGIN_ID']."' and idnumber='".$_GET['set']."' order by post_date limit 0,1";
  }
 $result=mysql_query($query);
 //確實????�?
 if ($row=mysql_fetch_row($result)) {
	 */
	  //mysqli
 $mysqliconn = get_mysqli_conn("sc_msn_data");
	
 if ($_GET['set']=="") {
   //$query="select id,idnumber,teach_id,post_date,data_kind,data,relay from sc_msn_data where to_id='".$_SESSION['MSN_LOGIN_ID']."' and ifread=0 order by post_date limit 0,1";
$query="select id,idnumber,teach_id,post_date,data_kind,data,relay from sc_msn_data where to_id='".$_SESSION['MSN_LOGIN_ID']."' and ifread=0 order by post_date limit 0,1";
$stmt="";
$stmt = $mysqliconn->prepare($query);
$stmt->execute();
$stmt->bind_result($id,$idnumber,$teach_id,$post_date,$data_kind,$data,$relay);
$stmt->fetch();
$stmt->close();
  
  } else {
   //$query="select id,idnumber,teach_id,post_date,data_kind,data,relay from sc_msn_data where to_id='".$_SESSION['MSN_LOGIN_ID']."' and idnumber='".$_GET['set']."' order by post_date limit 0,1";
  
$query="select id,idnumber,teach_id,post_date,data_kind,data,relay from sc_msn_data where to_id='".$_SESSION['MSN_LOGIN_ID']."' and idnumber=? order by post_date limit 0,1";
$stmt="";
$stmt = $mysqliconn->prepare($query);
$stmt->bind_param('s',$_GET['set']);
$stmt->execute();
$stmt->bind_result($id,$idnumber,$teach_id,$post_date,$data_kind,$data,$relay);
$stmt->fetch();
$stmt->close(); 
  }
 
 
 //$result=mysql_query($query);
 
 //確實????�?
 //if ($row=mysql_fetch_row($result)) {
   if ($idnumber) {
	$row=array($id,$idnumber,$teach_id,$post_date,$data_kind,$data,$relay);
	list($id,$idnumber,$teach_id,$post_date,$data_kind,$data,$relay)=$row;
  mysql_query("update sc_msn_data set ifread=1 where id=$id");	
  $name=get_name_state($teach_id);
  //?��?��??�?????�?
  if ($relay) {
  	$query_relay="select post_date,data from sc_msn_data where idnumber='".$relay."' and teach_id='".$_SESSION['MSN_LOGIN_ID']."' and to_id='".$teach_id."'";
  	$result_relay=mysql_query($query_relay);
  	list($r_post_date,$r_data)=mysql_fetch_row($result_relay);
  }
  //?��?��????�?
  $query_file="select filename,filename_r from sc_msn_file where idnumber='".$idnumber."'";
  $result_file=mysql_query($query_file);
  ?>
<html>
<head>
<title>�???�?人�???</title>
</head>
<script src="./include/jquery.js" type="text/javascript"></script>
<script src='./include/jquery.MultiFile.js' type="text/javascript" language="javascript"></script>
<body>
 <form name="form1" method="post" action="main_message.php" onsubmit="return checkdata()" enctype="multipart/form-data">
  <input type="hidden" name="act" value="">
	<input type="hidden" name="m_to" value="<?php echo $teach_id;?>">
	<input type="hidden" name="relay" value="<?php echo $idnumber;?>">
	<input type="hidden" name="data_kind" value="1">
  <table border="1" cellpadding="3" cellspacing="0" width="100%" bordercolorlight="#800000" bordercolordark="#FFFFFF" bordercolor="#FFFFFF">
    <tr>
      <td width="41" bgcolor="#FFFFCC">?��??</td>
      <td  bgcolor="#CCFFCC"><?php echo $post_date ?></td>
    </tr>
    <tr>
      <td width="41" bgcolor="#FFFFCC">�???</td>
      <td  bgcolor="#CCFFCC"><?php echo $name[0];?>(<?php echo $teach_id;?>)</td>
    </tr>
    <tr>
      <td width="41" bgcolor="#FFFFCC">??�?</td>
      <td  bgcolor="#CCFFCC" style="font-size:10pt">
      	<?php
      	if ($relay) {
      	?>
      	<table border="1" cellpadding="5" cellspacing="0"  bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" bordercolor="#FFFFFF" width="100%">
         <tr>
           <td style="font-size: 9pt" bgcolor="#B5FFFF">
           	??<?php echo $r_post_date;?>,?�說:<br><?php echo nl2br($r_data);?>
          </td>
         </tr>
        </table>
        <br>	
        <?php
         } //end if relay
        ?>
      	<?php echo AddLink2Text(nl2br($data));?>
      </td>
    </tr>
    <?php
     if (mysql_num_rows($result_file)) {
     ?>
     <tr>
      <td width="41" bgcolor="#FFFFCC">??�?</td>
      <td bgcolor="#CCFFCC" style="font-size:10pt">?��??�???<?php mysql_num_rows($result_file);?>????�?�?<br>
      	<?php 
      	 while ($row_file=mysql_fetch_row($result_file)) {
      	  list($filename,$filename_r)=$row_file;
      	  echo $filename_r;?>&nbsp;<a href="main_download.php?set=<?php echo $filename;?>">�?�?</a><br>
      	  <?php
      	 } // end while
      	?>
      </td>
    </tr>
    
     <?
     }
    ?>    
  </table>
  <table border="0" cellpadding="0" cellspacing="0" width="100%" bordercolorlight="#800000" bordercolordark="#FFFFFF" bordercolor="#FFFFFF">
    <tr>
      <td>?��????�?:</td>
    </tr>
    <tr>
      <td colspan='2'>
      <textarea rows="4" name="msg" cols="45"></textarea>
      </td>
    </tr>
    <tr id="Myfile" style="display:block">
			<td style="font-size: 10pt" valign='top' width='80'>????�?�?�?</td>
			<td style="font-size: 10pt">
				<table border="0" width="100%">
					<tr>
						<td><input type="file" class="multi" name="thefile[]"></td>
						<td align="left"><input type="button" value="???�此�?" name="B1"></td>
					</tr>
				</table>		
			</td>
		</tr>
    <tr id='wait_post' style='display:block'>
       <td align="left" colspan='2'>
      <input type="button" onclick="b_submit()" value="????" name="B1">&nbsp;<input type="button" value="????" name="B2" onclick="window.close()">
      </td>
    </tr>
  	<tr>
			<td colspan='2' style="font-size: 10pt;color:#0000FF">
			說�??�?<br>
				1.?��????�??��?�以夾帶�?�?�?�?�??��??夾帶�?�??��?填寫�??��?�容�???以建議�?��??��?�容中填?��?�???說�????<br>
				2.??�?大�??��???<font color=red><?php echo $MAX_MB;?>MB</font></br>
				3.注�??! 系統?��??��?��?��???��??起�???�???<font color=red><b><?php echo $PRESERVE_DAYS;?></b></font>�?!
			</td>
		</tr>
		<tr id='wait' style='display:none'>
		  <td style='color:#FF0000' colspan='2'><br>�??��????�?...</td>
		</tr>
  </table>
</form>
</body>
</html>
 <Script>
 function b_submit() {
	if (document.form1.msg.value=='') {
	  alert('?��???輸�?��?�容!!');
	  document.form1.msg.focus();
    return false;
	} else{
		wait_post.style.display="none";
  	wait.style.display="block";
  	document.form1.act.value='save';
  	document.form1.submit();
  }
 }
 

 
 </Script>
 
 <?php
 } // end if ($row=mysql_fetch_row($result))
} // end if $_GET['act']=='read'

//�??��??享�?�?
if ($_GET['act']=='upload') {
 


}
//?��?�??? *******************************************************
if ($_POST['act']=='save') {

mysql_query("SET NAMES 'utf8'");

$datetime=date("Y-m-d H:i:s");
$m_from=$_SESSION['MSN_LOGIN_ID'];
$m_to=$_POST['m_to'];
$relay=$_POST['relay'];
$msg=$_POST['msg'];
$lasttime=$_POST['lasttime'];
$data_kind=$_POST['data_kind'];
$folder=$_POST['folder'];

//$data_kind 
/***
0 ?��??�???(�??�夾�?)
1 �?人�???(?�夾�?)
2 �?�???�?(?�夾�?, �????��?�?�???)
3 ?��????? (�?夾�?)
***/

$idnumber=date("y").date("m").date("d").date("H").date("i").date("s");
 //測試�?碼�?��?��??�?
	do {
	 $a=floor(rand(10,99));
	 $idnumber_test=$idnumber.$a;
	 $query="select id from sc_msn_data where idnumber='".$idnumber_test."'";
	 $result=mysql_query($query);
	 $exist=mysql_num_rows($result);
	} while ($exist>0);

 $idnumber=$idnumber_test;

//�?種�?????�??��???
$save=0; $post_count=0;
switch ($data_kind) {
  //?��??
  case '0':
    $query="insert into sc_msn_data (idnumber,teach_id,to_id,data_kind,post_date,last_date,data,relay,folder) values ('$idnumber','$m_from','','$data_kind','$datetime','$lasttime','$msg','','')";
 		if (mysql_query($query)) {
 		  $save=1;
 		}
  break;
  //�?�?
  case '1':
		if ($data_kind==1 and $m_to!="" and $msg!="") {
			$a=explode(";",$m_to);
 			 foreach($a as $g) {
 				 	$query="select teach_id from teacher_base where teach_id='".$g."'";
  				$result=mysql_query($query);
  					if (mysql_num_rows($result)) {
 						   $query="insert into sc_msn_data (idnumber,teach_id,to_id,data_kind,post_date,last_date,data,relay,folder) values ('$idnumber','$m_from','$g','$data_kind','$datetime','$lasttime','$msg','$relay','private')";
 						   mysql_query($query);
 							 $save=1;
 							 $post_count++;
  				  }
  		 } 
		}  
  break;
  //�?�???�?
  case '2':
  	if ($m_to=="" and $data_kind==2 and $msg!="" and count($_FILES['thefile']['name'])>0) {
 			$query="insert into sc_msn_data (idnumber,teach_id,to_id,data_kind,post_date,last_date,data,relay,folder) values ('$idnumber','$m_from','$m_to','$data_kind','$datetime','$lasttime','$msg','$relay','$folder')";
 			mysql_query($query);
 			$save=1;
		}
  break;

}

//??�?人�??��??�?�???享�?�夾�? 
//????�?�? , �??��??????�??��??????
if ($save==1 and ($data_kind==1 or $data_kind==2)) {
 if (count($_FILES['thefile']['name'])>0) {
 $countFile=0;	
 for ($i=0;$i<count($_FILES['thefile']['name']);$i++) {
     $NowFile=$_FILES['thefile']['name'][$i]; //�???
     if ($NowFile!="") {
     	$countFile++;
    //檢�??��???
    $expand_name=explode(".",$NowFile);
    $nn=count($expand_name)-1;
    //?��?? , ??屬�?? $idnumber ??�?�?
    $filename=$_SESSION['MSN_LOGIN_ID']."_f".date("y").date("m").date("d").date("H").date("i").date("s").$i.".".$expand_name[$nn];
     copy($_FILES['thefile']['tmp_name'][$i],$download_path.$filename);
     $query="insert into sc_msn_file (idnumber,filename,filename_r) values ('$idnumber','$filename','$NowFile')";
     mysql_query($query);
   }
 }// end for
 } //end if file 	
}
 
 //?��?��?��??��????��??
 if ($data_kind==3) {
	
	//檢�?�??��?��???��?��???, ?��??��?��??建�?
	 if (!file_exists($UPLOAD_PIC)) {
     mkdir(substr($UPLOAD_PIC,0,strlen($UPLOAD_PIC)-1),0777);
 	}
	
  $stdate=$_POST['stdate'];
  $enddate=$_POST['enddate'];
  $delay_sec=$_POST['delay_sec'];
  if ($stdate!='' and $enddate!='' and $delay_sec!='' and $msg!='') {
   //????�?�?
   if ($_FILES['pic_file']['name']!="") {
       //檢�??��???
      $expand_name=explode(".",$_FILES['pic_file']['name']);
      $nn=count($expand_name)-1;
      $ATTR=strtolower($expand_name[$nn]); //�?�?寫�?��???
   	  
      //檢測?��?��??許�??�此�???�?�?
      if (check_file_attr($ATTR)) { 

      //?��??? 
      $filename_1=date('ymd').floor(rand(1000,9999)); //�??��????碼�???
      $filename=$filename_1.".".$ATTR;
       if ($ATTR=='swf' or $ATTR=='wmv') {
        //????
        copy($_FILES['pic_file']['tmp_name'],$UPLOAD_PIC.$filename);
        $query="insert into sc_msn_board_pic (teach_id,stdate,enddate,delay_sec,file_text,filename) values ('$m_from','$stdate','$enddate','$delay_sec','$msg','$filename')";
        mysql_query($query);
        $save=1;      
       } else {
       	//??????
        $filename_s=$filename_1."_s.".$ATTR;
       	  if (!ImageResize($_FILES['pic_file']['tmp_name'], $UPLOAD_PIC.$filename, 800, 600, 100)) {
       	   echo "ErroR!";
       	   exit();
       	  } else {      	  
       	  	//縮�??
       	  	ImageResize($_FILES['pic_file']['tmp_name'], $UPLOAD_PIC.$filename_s, 200, 150, 100);
            $query="insert into msn_board_pic (teach_id,stdate,enddate,delay_sec,file_text,filename) values ('$m_from','$stdate','$enddate','$delay_sec','$msg','$filename')";
            mysql_query($query);
					  $save=1;
          }
             
        } // end if swf
      }// end if attr
   }// end if files exist
  } 
 
	} // end if data_kind==3

  ?>
  <Script language="JavaScript">
	//????�?�?????示�???
 <?php
 switch ($data_kind) {
   case 0:
      if ($save) {
		    echo "alert('?????��???��??�???!');";
   		}else{
    		echo "alert('?��??�??��?��??失�??!');";
   		}	 	
   break;

   case 1:
      if ($save) {
		    echo "alert('?????��??".$post_count."??�???!');";
   		}else{
    		echo "alert('�??��?��??失�??!');";
   		}	 	

   break;

   case 2:
	   if ($save) {
  		  echo "alert('�?�?�??��????!?��?".$countFile."??�?�?.');";
   	 }else{
   		 echo "alert('�?�???享失??!');";
   	 } 	
   break;

   case 3:
      if ($save) {
		    echo "alert('?????��??1???��?????!');";
   		}else{
    		echo "alert('?��??????��??失�??!');";
   		}	 	
   break;
 }
  ?>

	window.close();
	
</Script>
  <?php
} // end if ($_POST['act']=='save') ******************************


?>  