<? // $Id: head.php 5310 2009-01-10 07:57:56Z hami $ ?>
<html>
<head>
<title>�Ǯդ��i</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">

<script language="JavaScript"><!--
function show_profile(action,winwidth,winheight) {
	var PROFILE = null;
        PROFILE =  window.open ("", "ProfileWindow", "toolbar=no,width="+winwidth+",height="+winheight+",directories=no,status=no,scrollbars=yes,resizable=yes,menubar=yes,toolbar=yes");
        if (PROFILE != null) {
               if (PROFILE.opener == null) {
                   PROFILE.opener = self;
        	   }
	       PROFILE.location.href = action;
               }
}

function changepage() { 
   var errors='' ;
   var poster ='' ;
   if (errors=='') {
      //window.location.href="<?php echo basename($PHP_SELF)."?query=$query&sortmode=$sortmode&showpage="?>" + (document.myform.selpage.selectedIndex+1)  ;
      poster = "poster=" + document.myform.poster.options[document.myform.poster.selectedIndex].value ;
      window.location.href="<?php echo basename($PHP_SELF)."?query=$query&sortmode=$sortmode&showpage="?>" + document.myform.selpage.options[document.myform.selpage.selectedIndex].value + "&" + poster  ;
   }else     
      alert(errors) ;
}
// --></script>
<style>
.bodytext {  font-size: small}
.doctext {  font-size: small}
.titleshow {  font-size: small; color: #FFFFFF; text-align: center}
A:link { text-decoration: none};
A:visited { text-decoration: none};
A:active { text-decoration: none};


</style>
</head>


<?php

  
  switch ($sortmode) {
  	case 0 : $sortmodestr  = "�̽s�����" ;
  	         break ;
  	case 1 : $sortmodestr  = "�̤�����" ;
  	         break ;
  	case 2 : $sortmodestr  = "���s���������" ;
  	         break ;
  }
  $linkdata =  basename($PHP_SELF) . "?query=$query&poster=$poster&sortmode=" ;
?>
<form method="post" name = "myform" action="<?php echo basename($PHP_SELF). "?poster=$poster" ?>">

<div align="center">
  <center>
    <table border="0" cellpadding="1" cellspacing="1" width="90%" 
		bgcolor="#EBEBEB" bordercolor="#FFFFFF" align="center">
      <tr bgcolor="#006699"> 
        <th align="center"  valign="top" colspan="6" height="18" class="titleshow"> 
          �Ǯդ��i</th>
  </tr>
  <tr bgcolor="#D8E9FE" class="bodytext"> 
    <td width="36%" align="center" valign="top" colspan="2" class="bodytext">�`�p:<? echo $totalnum ?>�h���i</td>
    <td width="28%" align="center" valign="top" colspan="2" class="bodytext">��<?echo "$showpage/$totalpage" ?>��</td>
    <td width="36%" align="center" valign="top" colspan="2" class="bodytext">�ثe���A�G<?php echo $sortmodestr .  $sel_poster  ?></td>
  </tr>
  <tr bgcolor="#EBEBEB" class="bodytext"> 
    <td  colspan="5" align="right" class="bodytext"> 
<?php 
if (!$msg_id) {

//�@����Y======================================
   echo '|<a href="'. $linkdata .'0"> �̽s��</a> |<a href="' . $linkdata .'1"> �̤��</a> ' ; 
   echo '|<a href="'. $linkdata .'2"> ���s������</a> |<a href="news_admin.php"> �i�K</a> |<a href="news_stats.php"> �έp</a> ' ;


}
else {
//�i�J�峹���Y=====================================
   echo '|<a href="'. $linkdata .'0"> �̽s��</a> |<a href="' . $linkdata .'1"> �̤��</a> ' ; 
   echo '|<a href="'. $linkdata .'2"> ���s������</a> |<a href="news_admin.php"> �i�K</a> |<a href="news_stats.php"> �έp</a> ' ;
   echo "|<a href=\"news_admin.php?do=edit&msg_id=$msg_id\"> �ק�</a> |<a href=\"news_admin.php?msg_id=$msg_id&do=delete\"> �R��</a> " ;
     
}
?>
     </td>
    <td  align="right" class="bodytext"> 
      <select name="selpage" onChange="changepage()" >
<?php 
    for ($i=1 ;$i<=$totalpage;$i++) {
    	if ($i==$showpage) echo "<option value=\"$i\" selected>�����" ;
        else echo "<option value=\"$i\">�����" ;
        echo  $i . "�� </option> \n" ;
    }
?>            
      </select>    

    </td>
  </tr>
</table>
  </center>
</div>
<br>
