<?php
                                                                                                                             
// $Id: checkid.php 6807 2012-06-22 08:08:30Z smallduh $

//���J�]�w��
if ($isload != 1)
	include "exam_config.php";
/***	
session_start();
session_register("session_log_id"); //�n�J�Юv�N��
session_register("session_tea_name"); //�n�J�Юv�m�W
session_register("session_stud_id");
session_register("session_stud_name");
session_register("session_curr_class_num");
***/

//�n�X
if ($_GET[logout] == 1) {
	session_destroy();
	$exam = "http://".$_SERVER[HTTP_HOST].$_GET[exename];
	header("Location: $exam");
}

//�n�J  
if ($_POST[B1] == "�n�J") {
	$sql_select = "select a.stud_id,a.stud_name ,a.curr_class_num,b.stud_pass from stud_base a ,exam_stud_data b \n";
	$sql_select .= "where a.stud_study_cond= 0 and a.stud_id = b.stud_id and a.stud_id = '".$_POST[stud_id]."' and b.stud_pass = '".$_POST[stud_pass]."' and a.stud_id <>'' ";
//	echo $sql_select;exit;
	$result = $CONN->Execute ($sql_select) or die($sql_select);
	if ($result->RecordCount()>0 || $_SESSION[session_log_id] !='') {
		$_SESSION[session_stud_id]=$result->fields["stud_id"];
		$_SESSION[session_stud_name]= $result->fields["stud_name"];		
		$_SESSION[session_curr_class_num] = $result->fields["curr_class_num"];
		$exam = "http://".$_SERVER[HTTP_HOST].$_POST[exename];
		header("Location: $exam");
	}
	
}

$exename = $_GET[exename] ;

include "header.php";
?> 

  <body  onload="setfocus()">
  <script language="JavaScript">
  <!--
  function setfocus() {
      document.checkid.stud_id.focus();
      return;
       }
      // --></script>
      <center><font color="#0080FF" size="3" face="�з���">�����A�Ȼݬd��b���K�X�A�Y�y���z�����K�A�q�Ш���</font></center>
      <form action="<? echo $PHP_SELF ?>" method="POST" name="checkid">
      
      <?
       if ($error_time != '')
        {
          if ($error_time < 3 )
            echo "<center><font color=red size=5>�N���αK�X���~!!�ЦA�T�{</font></center>";
        else
            echo "<center><B><blink><font color=red size=5>���ϻ�����K�X!!�ЦA�T�{</font></blink></b></center>";
        }       
        if (!isset($error_time)) $error_time = 1;
          else
        $error_time++;
       ?>
        
      <center><table border="0" cellspacing="1"
       bgcolor="#008000" bordercolor="#FFFFFF"
       bordercolordark="#C0C0C0" bordercolorlight="#FFFFFF">
           <tr>
               <td align="center"><table border="1" cellspacing="1"
               bgcolor="#FFFF00" bordercolor="#FFFFFF"
               bordercolordark="#C0C0C0" bordercolorlight="#FFFFFF">
                   <tr>
                       <td align="center" colspan="2"><font
                       color="#0000FF" size="5"><strong>�K�X�ˬd</strong></font></td>
                   </tr><tr>
                       <td align="center">��J�N��</td>
                       <td align="center"><input type="text"
                       size="20" name="stud_id"> </td>
                   </tr>
                   <tr>
                       <td>��J�K�X</td>
                       <td><input type="password" size="20"
                       name="stud_pass"> </td>
                   </tr>
                   <tr>
                       <td align="center" colspan="2">
                     <input type="hidden" name="error_time" value="<? echo $error_time ?>">
                     <input  type="submit" name="B1" value="�n�J"> 
                     &nbsp;&nbsp;<input type="button"  value= "�^�W��" onclick="history.back()">
                     </td>
                   </tr>
               </table>
               </td>
           </tr>
         <input type="hidden" name="exename" value="<?php echo $exename ?>">
        </form>
      </table>
     </center></div>
<? include "footer.php"; ?>
